<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProgramController extends Controller
{
    /**
     * Create a new ProgramController instance.
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show', 'getBySchool']);
        $this->middleware('admin')->except(['index', 'show', 'getBySchool']);
    }

    /**
     * Display a listing of programs
     */
    public function index(Request $request)
    {
        $query = Program::with(['school'])->active();

        // Filter by school
        if ($request->has('school_id') && $request->school_id) {
            $query->where('school_id', $request->school_id);
        }

        // Filter by level
        if ($request->has('level') && $request->level) {
            $query->where('level', $request->level);
        }

        // Filter by tuition fee range
        if ($request->has('min_fee') || $request->has('max_fee')) {
            $query->withinTuitionRange($request->min_fee, $request->max_fee);
        }

        // Filter by duration
        if ($request->has('min_duration') || $request->has('max_duration')) {
            $query->byDuration($request->min_duration, $request->max_duration);
        }

        // Filter by mode of study
        if ($request->has('mode') && $request->mode) {
            $query->byMode($request->mode);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        
        if (in_array($sortBy, ['name', 'level', 'tuition_fee', 'duration_months', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $perPage = min($request->get('per_page', 15), 50);
        $programs = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $programs,
            'filters' => [
                'levels' => Program::getAvailableLevels(),
                'modes' => ['full-time' => 'Full-time', 'part-time' => 'Part-time', 'online' => 'Online'],
            ]
        ]);
    }

    /**
     * Store a newly created program
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'school_id' => 'required|exists:schools,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'required|in:certificate,diploma,bachelor,master,phd',
            'duration_months' => 'required|integer|min:1|max:120',
            'tuition_fee' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'requirements' => 'nullable|array',
            'career_prospects' => 'nullable|array',
            'application_deadline' => 'nullable|date|after:today',
            'start_date' => 'nullable|date',
            'language_of_instruction' => 'required|string|max:100',
            'mode_of_study' => 'required|in:full-time,part-time,online',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        // Verify school exists and is active
        $school = School::active()->find($request->school_id);
        if (!$school) {
            return response()->json([
                'success' => false,
                'message' => 'School not found or inactive'
            ], 404);
        }

        $program = Program::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Program created successfully',
            'data' => $program->load('school')
        ], 201);
    }

    /**
     * Display the specified program
     */
    public function show($id)
    {
        $program = Program::with(['school', 'applications' => function($q) {
            if (auth()->check() && auth()->user()->isStudent()) {
                $q->where('user_id', auth()->id());
            }
        }])->find($id);

        if (!$program) {
            return response()->json([
                'success' => false,
                'message' => 'Program not found'
            ], 404);
        }

        // Add statistics for admin users
        if (auth()->check() && auth()->user()->isAdmin()) {
            $program->loadCount([
                'applications',
                'applications as pending_applications_count' => function ($query) {
                    $query->where('status', 'submitted');
                },
                'applications as accepted_applications_count' => function ($query) {
                    $query->where('status', 'accepted');
                }
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $program
        ]);
    }

    /**
     * Update the specified program
     */
    public function update(Request $request, $id)
    {
        $program = Program::find($id);

        if (!$program) {
            return response()->json([
                'success' => false,
                'message' => 'Program not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'level' => 'sometimes|required|in:certificate,diploma,bachelor,master,phd',
            'duration_months' => 'sometimes|required|integer|min:1|max:120',
            'tuition_fee' => 'sometimes|required|numeric|min:0',
            'currency' => 'sometimes|required|string|size:3',
            'requirements' => 'nullable|array',
            'career_prospects' => 'nullable|array',
            'is_active' => 'sometimes|boolean',
            'application_deadline' => 'nullable|date',
            'start_date' => 'nullable|date',
            'language_of_instruction' => 'sometimes|required|string|max:100',
            'mode_of_study' => 'sometimes|required|in:full-time,part-time,online',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $program->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Program updated successfully',
            'data' => $program->fresh()->load('school')
        ]);
    }

    /**
     * Remove the specified program
     */
    public function destroy($id)
    {
        $program = Program::find($id);

        if (!$program) {
            return response()->json([
                'success' => false,
                'message' => 'Program not found'
            ], 404);
        }

        // Check if program has applications
        if ($program->applications()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete program with existing applications'
            ], 400);
        }

        $program->delete();

        return response()->json([
            'success' => true,
            'message' => 'Program deleted successfully'
        ]);
    }

    /**
     * Get programs by school
     */
    public function getBySchool($schoolId)
    {
        $school = School::active()->find($schoolId);

        if (!$school) {
            return response()->json([
                'success' => false,
                'message' => 'School not found'
            ], 404);
        }

        $programs = Program::where('school_id', $schoolId)
                          ->active()
                          ->orderBy('name')
                          ->get();

        return response()->json([
            'success' => true,
            'data' => $programs
        ]);
    }

    /**
     * Get program statistics (admin only)
     */
    public function statistics($id)
    {
        $program = Program::with(['applications', 'school'])->find($id);

        if (!$program) {
            return response()->json([
                'success' => false,
                'message' => 'Program not found'
            ], 404);
        }

        $stats = [
            'total_applications' => $program->applications->count(),
            'pending_applications' => $program->applications->where('status', 'submitted')->count(),
            'in_progress_applications' => $program->applications->where('status', 'in_progress')->count(),
            'accepted_applications' => $program->applications->where('status', 'accepted')->count(),
            'rejected_applications' => $program->applications->where('status', 'rejected')->count(),
            'acceptance_rate' => $program->applications->count() > 0 ? 
                round(($program->applications->where('status', 'accepted')->count() / $program->applications->count()) * 100, 2) : 0,
            'total_revenue' => $program->applications->whereIn('status', ['accepted', 'in_progress'])->sum('application_fee'),
            'applications_by_month' => $program->applications()
                ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->pluck('count', 'month'),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
