<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\School;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    /**
     * Create a new ApplicationController instance.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of applications
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $query = Application::with(['user', 'school', 'program']);

        // Students can only see their own applications
        if ($user->isStudent()) {
            $query->where('user_id', $user->id);
        }

        // Admin can filter by school
        if ($user->isAdmin() && $request->has('school_id')) {
            $query->where('school_id', $request->school_id);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by program
        if ($request->has('program_id') && $request->program_id) {
            $query->where('program_id', $request->program_id);
        }

        // Search by application number or user name
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('application_number', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('first_name', 'like', '%' . $search . '%')
                               ->orWhere('last_name', 'like', '%' . $search . '%')
                               ->orWhere('email', 'like', '%' . $search . '%');
                  });
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if (in_array($sortBy, ['created_at', 'submitted_at', 'status', 'application_number'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $perPage = min($request->get('per_page', 15), 50);
        $applications = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $applications
        ]);
    }

    /**
     * Store a newly created application
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user->isStudent()) {
            return response()->json([
                'success' => false,
                'message' => 'Only students can create applications'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'school_id' => 'required|exists:schools,id',
            'program_id' => 'required|exists:programs,id',
            'personal_statement' => 'required|string|min:100',
            'academic_background' => 'required|array',
            'academic_background.*.institution' => 'required|string',
            'academic_background.*.degree' => 'required|string',
            'academic_background.*.year' => 'required|integer|min:1950|max:' . date('Y'),
            'academic_background.*.grade' => 'nullable|string',
            'work_experience' => 'nullable|array',
            'work_experience.*.company' => 'required|string',
            'work_experience.*.position' => 'required|string',
            'work_experience.*.start_date' => 'required|date',
            'work_experience.*.end_date' => 'nullable|date|after:start_date',
            'work_experience.*.description' => 'nullable|string',
            'references' => 'nullable|array|max:3',
            'references.*.name' => 'required|string',
            'references.*.email' => 'required|email',
            'references.*.phone' => 'nullable|string',
            'references.*.relationship' => 'required|string',
            'documents' => 'nullable|array',
            'documents.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if program belongs to school
        $program = Program::where('id', $request->program_id)
                          ->where('school_id', $request->school_id)
                          ->first();

        if (!$program) {
            return response()->json([
                'success' => false,
                'message' => 'Program does not belong to the selected school'
            ], 422);
        }

        // Check if user already has an application for this program
        $existingApplication = Application::where('user_id', $user->id)
                                         ->where('program_id', $request->program_id)
                                         ->first();

        if ($existingApplication) {
            return response()->json([
                'success' => false,
                'message' => 'You already have an application for this program'
            ], 422);
        }

        $school = School::find($request->school_id);
        
        $applicationData = [
            'user_id' => $user->id,
            'school_id' => $request->school_id,
            'program_id' => $request->program_id,
            'personal_statement' => $request->personal_statement,
            'academic_background' => $request->academic_background,
            'work_experience' => $request->work_experience,
            'references' => $request->references,
            'application_fee' => $school->application_fee,
            'submitted_at' => now(),
        ];

        // Handle document uploads
        if ($request->hasFile('documents')) {
            $documents = [];
            foreach ($request->file('documents') as $index => $file) {
                $filename = time() . '_' . $index . '_' . $file->getClientOriginalName();
                $file->storeAs('public/applications/documents', $filename);
                $documents[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => 'applications/documents/' . $filename,
                    'type' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                ];
            }
            $applicationData['documents'] = $documents;
        }

        $application = Application::create($applicationData);

        return response()->json([
            'success' => true,
            'message' => 'Application submitted successfully',
            'data' => $application->load(['school', 'program'])
        ], 201);
    }

    /**
     * Display the specified application
     */
    public function show($id)
    {
        $user = auth()->user();
        
        $application = Application::with(['user', 'school', 'program'])->find($id);

        if (!$application) {
            return response()->json([
                'success' => false,
                'message' => 'Application not found'
            ], 404);
        }

        // Students can only view their own applications
        if ($user->isStudent() && $application->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $application
        ]);
    }

    /**
     * Update the specified application
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        
        $application = Application::find($id);

        if (!$application) {
            return response()->json([
                'success' => false,
                'message' => 'Application not found'
            ], 404);
        }

        // Students can only update their own applications and only if editable
        if ($user->isStudent()) {
            if ($application->user_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            if (!$application->is_editable) {
                return response()->json([
                    'success' => false,
                    'message' => 'Application cannot be edited in current status'
                ], 400);
            }
        }

        $validator = Validator::make($request->all(), [
            'personal_statement' => 'sometimes|required|string|min:100',
            'academic_background' => 'sometimes|required|array',
            'work_experience' => 'nullable|array',
            'references' => 'nullable|array|max:3',
            'status' => 'sometimes|in:submitted,in_progress,accepted,rejected',
            'admin_notes' => 'nullable|string',
            'rejection_reason' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $updateData = $request->only([
            'personal_statement', 'academic_background', 'work_experience', 'references'
        ]);

        // Only admins can update status and admin fields
        if ($user->isAdmin()) {
            if ($request->has('status')) {
                $application->updateStatus($request->status, $request->admin_notes);
            }
            
            if ($request->has('rejection_reason')) {
                $updateData['rejection_reason'] = $request->rejection_reason;
            }
        }

        $application->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Application updated successfully',
            'data' => $application->fresh()->load(['school', 'program'])
        ]);
    }

    /**
     * Remove the specified application
     */
    public function destroy($id)
    {
        $user = auth()->user();
        
        $application = Application::find($id);

        if (!$application) {
            return response()->json([
                'success' => false,
                'message' => 'Application not found'
            ], 404);
        }

        // Students can only delete their own applications and only if they can withdraw
        if ($user->isStudent()) {
            if ($application->user_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            if (!$application->can_withdraw) {
                return response()->json([
                    'success' => false,
                    'message' => 'Application cannot be withdrawn in current status'
                ], 400);
            }
        }

        // Delete associated documents
        if ($application->documents) {
            foreach ($application->documents as $document) {
                Storage::delete('public/' . $document['path']);
            }
        }

        $application->delete();

        return response()->json([
            'success' => true,
            'message' => 'Application deleted successfully'
        ]);
    }

    /**
     * Update application status (admin only)
     */
    public function updateStatus(Request $request, $id)
    {
        $user = auth()->user();

        if (!$user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Only admins can update application status'
            ], 403);
        }

        $application = Application::find($id);

        if (!$application) {
            return response()->json([
                'success' => false,
                'message' => 'Application not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:submitted,in_progress,accepted,rejected',
            'admin_notes' => 'nullable|string',
            'rejection_reason' => 'required_if:status,rejected|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $application->updateStatus($request->status, $request->admin_notes);

        if ($request->status === 'rejected' && $request->rejection_reason) {
            $application->rejection_reason = $request->rejection_reason;
            $application->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Application status updated successfully',
            'data' => $application->fresh()->load(['user', 'school', 'program'])
        ]);
    }

    /**
     * Get application statistics (admin only)
     */
    public function statistics(Request $request)
    {
        $user = auth()->user();

        if (!$user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Only admins can view statistics'
            ], 403);
        }

        $query = Application::query();

        // Filter by school if provided
        if ($request->has('school_id')) {
            $query->where('school_id', $request->school_id);
        }

        $stats = [
            'total_applications' => $query->count(),
            'submitted_applications' => $query->where('status', 'submitted')->count(),
            'in_progress_applications' => $query->where('status', 'in_progress')->count(),
            'accepted_applications' => $query->where('status', 'accepted')->count(),
            'rejected_applications' => $query->where('status', 'rejected')->count(),
            'total_revenue' => $query->whereIn('status', ['accepted', 'in_progress'])->sum('application_fee'),
            'applications_by_month' => $query->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->pluck('count', 'month'),
            'applications_by_school' => $query->with('school:id,name')
                ->get()
                ->groupBy('school.name')
                ->map(function($applications) {
                    return $applications->count();
                }),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Download application document
     */
    public function downloadDocument($id, $documentIndex)
    {
        $user = auth()->user();
        
        $application = Application::find($id);

        if (!$application) {
            return response()->json([
                'success' => false,
                'message' => 'Application not found'
            ], 404);
        }

        // Students can only download their own documents
        if ($user->isStudent() && $application->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        if (!$application->documents || !isset($application->documents[$documentIndex])) {
            return response()->json([
                'success' => false,
                'message' => 'Document not found'
            ], 404);
        }

        $document = $application->documents[$documentIndex];
        $filePath = storage_path('app/public/' . $document['path']);

        if (!file_exists($filePath)) {
            return response()->json([
                'success' => false,
                'message' => 'File not found on server'
            ], 404);
        }

        return response()->download($filePath, $document['name']);
    }
}
