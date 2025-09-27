<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Accès non autorisé.');
            }
            return $next($request);
        });
    }

    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        $stats = [
            'total_schools' => School::count(),
            'active_schools' => School::active()->count(),
            'total_applications' => Application::count(),
            'pending_applications' => Application::pending()->count(),
            'total_students' => User::where('role', 'student')->count(),
            'total_commission' => Application::where('status', 'accepted')->sum('commission_amount'),
        ];

        $recentApplications = Application::with(['user', 'school'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentApplications'));
    }

    /**
     * Show all schools.
     */
    public function schools(Request $request)
    {
        $query = School::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        $schools = $query->latest()->paginate(15)->withQueryString();

        return view('admin.schools.index', compact('schools'));
    }

    /**
     * Show the form for creating a new school.
     */
    public function createSchool()
    {
        return view('admin.schools.create');
    }

    /**
     * Store a newly created school.
     */
    public function storeSchool(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'city' => 'required|string|max:100',
            'address' => 'required|string',
            'postal_code' => 'required|string|max:10',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'fields_of_study' => 'required|array',
            'accreditations' => 'required|array',
            'diplomas' => 'required|array',
            'tuition_fee_min' => 'nullable|numeric|min:0',
            'tuition_fee_max' => 'nullable|numeric|min:0',
            'application_fee' => 'required|numeric|min:0',
            'admission_requirements' => 'nullable|string',
            'next_intake' => 'nullable|date',
        ]);

        School::create($validated);

        return redirect()->route('admin.schools.index')
            ->with('success', 'École créée avec succès !');
    }

    /**
     * Show the form for editing a school.
     */
    public function editSchool(School $school)
    {
        return view('admin.schools.edit', compact('school'));
    }

    /**
     * Update the specified school.
     */
    public function updateSchool(Request $request, School $school)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'city' => 'required|string|max:100',
            'address' => 'required|string',
            'postal_code' => 'required|string|max:10',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'fields_of_study' => 'required|array',
            'accreditations' => 'required|array',
            'diplomas' => 'required|array',
            'tuition_fee_min' => 'nullable|numeric|min:0',
            'tuition_fee_max' => 'nullable|numeric|min:0',
            'application_fee' => 'required|numeric|min:0',
            'admission_requirements' => 'nullable|string',
            'next_intake' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $school->update($validated);

        return redirect()->route('admin.schools.index')
            ->with('success', 'École mise à jour avec succès !');
    }

    /**
     * Remove the specified school.
     */
    public function destroySchool(School $school)
    {
        $school->delete();

        return redirect()->route('admin.schools.index')
            ->with('success', 'École supprimée avec succès !');
    }

    /**
     * Show all applications.
     */
    public function applications(Request $request)
    {
        $query = Application::with(['user', 'school']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('school')) {
            $query->where('school_id', $request->school);
        }

        $applications = $query->latest()->paginate(15)->withQueryString();
        $schools = School::active()->orderBy('name')->get();

        return view('admin.applications.index', compact('applications', 'schools'));
    }

    /**
     * Show a specific application.
     */
    public function showApplication(Application $application)
    {
        return view('admin.applications.show', compact('application'));
    }

    /**
     * Update application status.
     */
    public function updateApplicationStatus(Request $request, Application $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:submitted,in_progress,accepted,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        $application->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'],
            'processed_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Statut de la candidature mis à jour avec succès !');
    }
}
