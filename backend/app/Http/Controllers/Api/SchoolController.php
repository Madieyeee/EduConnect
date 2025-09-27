<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SchoolController extends Controller
{
    /**
     * Create a new SchoolController instance.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('admin')->except(['index', 'show', 'search']);
    }

    /**
     * Display a listing of schools
     */
    public function index(Request $request)
    {
        $query = School::with(['programs' => function($q) {
            $q->active();
        }])->active();

        // Apply filters
        if ($request->has('city') && $request->city) {
            $query->byCity($request->city);
        }

        if ($request->has('country') && $request->country) {
            $query->byCountry($request->country);
        }

        if ($request->has('accreditation') && $request->accreditation) {
            $query->withAccreditation($request->accreditation);
        }

        if ($request->has('min_price') || $request->has('max_price')) {
            $query->withinPriceRange($request->min_price, $request->max_price);
        }

        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        
        if (in_array($sortBy, ['name', 'city', 'application_fee', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $perPage = min($request->get('per_page', 15), 50);
        $schools = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $schools,
            'filters' => [
                'cities' => School::active()->distinct()->pluck('city')->filter()->sort()->values(),
                'countries' => School::active()->distinct()->pluck('country')->filter()->sort()->values(),
            ]
        ]);
    }

    /**
     * Store a newly created school
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'established_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'accreditations' => 'nullable|array',
            'facilities' => 'nullable|array',
            'admission_requirements' => 'nullable|array',
            'application_fee' => 'required|numeric|min:0',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $schoolData = $request->except(['logo', 'banner_image']);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '_logo_' . $logo->getClientOriginalName();
            $logo->storeAs('public/schools/logos', $logoName);
            $schoolData['logo'] = 'schools/logos/' . $logoName;
        }

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            $banner = $request->file('banner_image');
            $bannerName = time() . '_banner_' . $banner->getClientOriginalName();
            $banner->storeAs('public/schools/banners', $bannerName);
            $schoolData['banner_image'] = 'schools/banners/' . $bannerName;
        }

        $school = School::create($schoolData);

        return response()->json([
            'success' => true,
            'message' => 'School created successfully',
            'data' => $school->load('programs')
        ], 201);
    }

    /**
     * Display the specified school
     */
    public function show($id)
    {
        $school = School::with(['programs' => function($q) {
            $q->active()->orderBy('name');
        }])->find($id);

        if (!$school) {
            return response()->json([
                'success' => false,
                'message' => 'School not found'
            ], 404);
        }

        // Add statistics for admin users
        if (auth()->check() && auth()->user()->isAdmin()) {
            $school->loadCount([
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
            'data' => $school
        ]);
    }

    /**
     * Update the specified school
     */
    public function update(Request $request, $id)
    {
        $school = School::find($id);

        if (!$school) {
            return response()->json([
                'success' => false,
                'message' => 'School not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'address' => 'sometimes|required|string',
            'city' => 'sometimes|required|string|max:100',
            'country' => 'sometimes|required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'established_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'accreditations' => 'nullable|array',
            'facilities' => 'nullable|array',
            'admission_requirements' => 'nullable|array',
            'application_fee' => 'sometimes|required|numeric|min:0',
            'is_active' => 'sometimes|boolean',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $schoolData = $request->except(['logo', 'banner_image']);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($school->logo) {
                Storage::delete('public/' . $school->logo);
            }
            
            $logo = $request->file('logo');
            $logoName = time() . '_logo_' . $logo->getClientOriginalName();
            $logo->storeAs('public/schools/logos', $logoName);
            $schoolData['logo'] = 'schools/logos/' . $logoName;
        }

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            // Delete old banner
            if ($school->banner_image) {
                Storage::delete('public/' . $school->banner_image);
            }
            
            $banner = $request->file('banner_image');
            $bannerName = time() . '_banner_' . $banner->getClientOriginalName();
            $banner->storeAs('public/schools/banners', $bannerName);
            $schoolData['banner_image'] = 'schools/banners/' . $bannerName;
        }

        $school->update($schoolData);

        return response()->json([
            'success' => true,
            'message' => 'School updated successfully',
            'data' => $school->fresh()->load('programs')
        ]);
    }

    /**
     * Remove the specified school
     */
    public function destroy($id)
    {
        $school = School::find($id);

        if (!$school) {
            return response()->json([
                'success' => false,
                'message' => 'School not found'
            ], 404);
        }

        // Check if school has applications
        if ($school->applications()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete school with existing applications'
            ], 400);
        }

        // Delete associated files
        if ($school->logo) {
            Storage::delete('public/' . $school->logo);
        }
        if ($school->banner_image) {
            Storage::delete('public/' . $school->banner_image);
        }

        $school->delete();

        return response()->json([
            'success' => true,
            'message' => 'School deleted successfully'
        ]);
    }

    /**
     * Search schools with advanced filters
     */
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'query' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'min_fee' => 'nullable|numeric|min:0',
            'max_fee' => 'nullable|numeric|min:0',
            'accreditations' => 'nullable|array',
            'program_level' => 'nullable|string|in:certificate,diploma,bachelor,master,phd',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $query = School::with(['programs' => function($q) use ($request) {
            $q->active();
            if ($request->program_level) {
                $q->where('level', $request->program_level);
            }
        }])->active();

        // Apply search filters
        if ($request->query) {
            $query->search($request->query);
        }

        if ($request->city) {
            $query->byCity($request->city);
        }

        if ($request->country) {
            $query->byCountry($request->country);
        }

        if ($request->min_fee || $request->max_fee) {
            $query->withinPriceRange($request->min_fee, $request->max_fee);
        }

        if ($request->accreditations && is_array($request->accreditations)) {
            foreach ($request->accreditations as $accreditation) {
                $query->withAccreditation($accreditation);
            }
        }

        $schools = $query->orderBy('name')->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $schools
        ]);
    }

    /**
     * Get school statistics (admin only)
     */
    public function statistics($id)
    {
        $school = School::with(['applications', 'programs'])->find($id);

        if (!$school) {
            return response()->json([
                'success' => false,
                'message' => 'School not found'
            ], 404);
        }

        $stats = [
            'total_applications' => $school->applications->count(),
            'pending_applications' => $school->applications->where('status', 'submitted')->count(),
            'in_progress_applications' => $school->applications->where('status', 'in_progress')->count(),
            'accepted_applications' => $school->applications->where('status', 'accepted')->count(),
            'rejected_applications' => $school->applications->where('status', 'rejected')->count(),
            'total_programs' => $school->programs->count(),
            'active_programs' => $school->programs->where('is_active', true)->count(),
            'total_revenue' => $school->applications->whereIn('status', ['accepted', 'in_progress'])->sum('application_fee'),
            'applications_by_month' => $school->applications()
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
