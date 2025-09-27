<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the student dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $applications = $user->applications()
            ->with('school')
            ->latest()
            ->get();

        $stats = [
            'total' => $applications->count(),
            'pending' => $applications->whereIn('status', ['submitted', 'in_progress'])->count(),
            'accepted' => $applications->where('status', 'accepted')->count(),
            'rejected' => $applications->where('status', 'rejected')->count(),
        ];

        return view('student.dashboard', compact('applications', 'stats'));
    }

    /**
     * Show the application form for a school.
     */
    public function showApplicationForm(School $school)
    {
        $user = Auth::user();

        // Check if user already has an application for this school
        $existingApplication = $user->applications()
            ->where('school_id', $school->id)
            ->first();

        if ($existingApplication) {
            return redirect()->route('student.applications.show', $existingApplication)
                ->with('info', 'Vous avez déjà une candidature pour cette école.');
        }

        return view('student.apply', compact('school'));
    }

    /**
     * Store a new application.
     */
    public function storeApplication(Request $request, School $school)
    {
        $user = Auth::user();

        // Check if user already has an application for this school
        $existingApplication = $user->applications()
            ->where('school_id', $school->id)
            ->first();

        if ($existingApplication) {
            return redirect()->route('student.applications.show', $existingApplication)
                ->with('error', 'Vous avez déjà une candidature pour cette école.');
        }

        $validated = $request->validate([
            'field_of_study' => 'required|string|max:255',
            'diploma_level' => 'required|string|max:255',
            'motivation_letter' => 'required|string|min:100',
        ]);

        $application = Application::create([
            'user_id' => $user->id,
            'school_id' => $school->id,
            'field_of_study' => $validated['field_of_study'],
            'diploma_level' => $validated['diploma_level'],
            'motivation_letter' => $validated['motivation_letter'],
            'status' => 'submitted',
            'commission_amount' => $school->application_fee,
            'submitted_at' => now(),
        ]);

        return redirect()->route('student.applications.show', $application)
            ->with('success', 'Votre candidature a été soumise avec succès !');
    }

    /**
     * Show a specific application.
     */
    public function showApplication(Application $application)
    {
        $user = Auth::user();

        if ($application->user_id !== $user->id) {
            abort(403);
        }

        return view('student.application-details', compact('application'));
    }

    /**
     * Show all applications for the student.
     */
    public function applications()
    {
        $user = Auth::user();
        
        $applications = $user->applications()
            ->with('school')
            ->latest()
            ->paginate(10);

        return view('student.applications', compact('applications'));
    }
}
