<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\School;
use App\Models\Application;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'admin']);
    }

    /**
     * Export students data.
     */
    public function exportStudents(Request $request): JsonResponse
    {
        $query = User::where('role', 'student')
                    ->with(['applications.school', 'applications.program']);

        // Apply date filters
        if ($request->has('start_date')) {
            $query->where('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->where('created_at', '<=', $request->end_date);
        }

        // Apply status filter for applications
        if ($request->has('application_status')) {
            $query->whereHas('applications', function ($q) use ($request) {
                $q->where('status', $request->application_status);
            });
        }

        // Apply school filter
        if ($request->has('school_id')) {
            $query->whereHas('applications', function ($q) use ($request) {
                $q->where('school_id', $request->school_id);
            });
        }

        $students = $query->get();

        $exportData = $students->map(function ($student) {
            return [
                'id' => $student->id,
                'name' => $student->name,
                'email' => $student->email,
                'phone' => $student->phone,
                'date_of_birth' => $student->date_of_birth,
                'gender' => $student->gender,
                'address' => $student->address,
                'city' => $student->city,
                'country' => $student->country,
                'registration_date' => $student->created_at->format('Y-m-d H:i:s'),
                'total_applications' => $student->applications->count(),
                'applications' => $student->applications->map(function ($app) {
                    return [
                        'application_number' => $app->application_number,
                        'school' => $app->school->name,
                        'program' => $app->program->name,
                        'status' => $app->status,
                        'application_date' => $app->created_at->format('Y-m-d H:i:s'),
                        'application_fee' => $app->application_fee,
                    ];
                }),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $exportData,
            'total_records' => $exportData->count(),
            'export_date' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Export applications data.
     */
    public function exportApplications(Request $request): JsonResponse
    {
        $query = Application::with(['user', 'school', 'program']);

        // Apply filters
        if ($request->has('start_date')) {
            $query->where('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->where('created_at', '<=', $request->end_date);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('school_id')) {
            $query->where('school_id', $request->school_id);
        }

        if ($request->has('program_id')) {
            $query->where('program_id', $request->program_id);
        }

        $applications = $query->get();

        $exportData = $applications->map(function ($app) {
            return [
                'application_number' => $app->application_number,
                'student_name' => $app->user->name,
                'student_email' => $app->user->email,
                'student_phone' => $app->user->phone,
                'school_name' => $app->school->name,
                'program_name' => $app->program->name,
                'program_level' => $app->program->level,
                'status' => $app->status,
                'application_date' => $app->created_at->format('Y-m-d H:i:s'),
                'last_updated' => $app->updated_at->format('Y-m-d H:i:s'),
                'application_fee' => $app->application_fee,
                'payment_status' => $app->payment_status,
                'personal_statement' => $app->personal_statement,
                'academic_background' => $app->academic_background,
                'work_experience' => $app->work_experience,
                'references' => $app->references,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $exportData,
            'total_records' => $exportData->count(),
            'export_date' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Export schools data.
     */
    public function exportSchools(Request $request): JsonResponse
    {
        $query = School::withCount(['programs', 'applications']);

        if ($request->has('city')) {
            $query->where('city', $request->city);
        }

        if ($request->has('country')) {
            $query->where('country', $request->country);
        }

        $schools = $query->get();

        $exportData = $schools->map(function ($school) {
            return [
                'id' => $school->id,
                'name' => $school->name,
                'description' => $school->description,
                'address' => $school->address,
                'city' => $school->city,
                'country' => $school->country,
                'phone' => $school->phone,
                'email' => $school->email,
                'website' => $school->website,
                'established_year' => $school->established_year,
                'accreditations' => $school->accreditations,
                'facilities' => $school->facilities,
                'application_fee' => $school->application_fee,
                'is_active' => $school->is_active,
                'total_programs' => $school->programs_count,
                'total_applications' => $school->applications_count,
                'created_at' => $school->created_at->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $exportData,
            'total_records' => $exportData->count(),
            'export_date' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Export financial report (commissions).
     */
    public function exportFinancialReport(Request $request): JsonResponse
    {
        $startDate = $request->get('start_date', now()->startOfMonth());
        $endDate = $request->get('end_date', now()->endOfMonth());

        // Get applications with fees within date range
        $applications = Application::with(['user', 'school', 'program'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('application_fee')
            ->where('application_fee', '>', 0)
            ->get();

        // Group by school
        $schoolCommissions = $applications->groupBy('school_id')->map(function ($schoolApps) {
            $school = $schoolApps->first()->school;
            $totalApplications = $schoolApps->count();
            $totalCommissions = $schoolApps->sum('application_fee');
            
            return [
                'school_id' => $school->id,
                'school_name' => $school->name,
                'total_applications' => $totalApplications,
                'total_commissions' => $totalCommissions,
                'average_fee' => $totalApplications > 0 ? $totalCommissions / $totalApplications : 0,
                'applications' => $schoolApps->map(function ($app) {
                    return [
                        'application_number' => $app->application_number,
                        'student_name' => $app->user->name,
                        'program_name' => $app->program->name,
                        'application_fee' => $app->application_fee,
                        'date' => $app->created_at->format('Y-m-d'),
                        'status' => $app->status,
                    ];
                }),
            ];
        });

        // Overall statistics
        $totalCommissions = $applications->sum('application_fee');
        $totalApplications = $applications->count();
        $averageFee = $totalApplications > 0 ? $totalCommissions / $totalApplications : 0;

        // Monthly breakdown
        $monthlyBreakdown = $applications->groupBy(function ($app) {
            return $app->created_at->format('Y-m');
        })->map(function ($monthApps, $month) {
            return [
                'month' => $month,
                'total_applications' => $monthApps->count(),
                'total_commissions' => $monthApps->sum('application_fee'),
                'average_fee' => $monthApps->count() > 0 ? $monthApps->sum('application_fee') / $monthApps->count() : 0,
            ];
        })->values();

        return response()->json([
            'success' => true,
            'data' => [
                'period' => [
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ],
                'summary' => [
                    'total_applications' => $totalApplications,
                    'total_commissions' => $totalCommissions,
                    'average_fee' => $averageFee,
                    'total_schools' => $schoolCommissions->count(),
                ],
                'monthly_breakdown' => $monthlyBreakdown,
                'school_commissions' => $schoolCommissions->values(),
            ],
            'export_date' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Export contacts data.
     */
    public function exportContacts(Request $request): JsonResponse
    {
        $query = Contact::with(['user', 'assignedAdmin']);

        // Apply filters
        if ($request->has('start_date')) {
            $query->where('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->where('created_at', '<=', $request->end_date);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $contacts = $query->get();

        $exportData = $contacts->map(function ($contact) {
            return [
                'id' => $contact->id,
                'name' => $contact->name,
                'email' => $contact->email,
                'phone' => $contact->phone,
                'subject' => $contact->subject,
                'message' => $contact->message,
                'type' => $contact->type,
                'priority' => $contact->priority,
                'status' => $contact->status,
                'user_name' => $contact->user ? $contact->user->name : null,
                'assigned_admin' => $contact->assignedAdmin ? $contact->assignedAdmin->name : null,
                'admin_response' => $contact->admin_response,
                'created_at' => $contact->created_at->format('Y-m-d H:i:s'),
                'responded_at' => $contact->responded_at ? $contact->responded_at->format('Y-m-d H:i:s') : null,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $exportData,
            'total_records' => $exportData->count(),
            'export_date' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Get export statistics.
     */
    public function getExportStatistics(): JsonResponse
    {
        $stats = [
            'students' => [
                'total' => User::where('role', 'student')->count(),
                'this_month' => User::where('role', 'student')
                    ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                    ->count(),
            ],
            'applications' => [
                'total' => Application::count(),
                'this_month' => Application::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count(),
                'by_status' => [
                    'submitted' => Application::where('status', 'submitted')->count(),
                    'in_progress' => Application::where('status', 'in_progress')->count(),
                    'accepted' => Application::where('status', 'accepted')->count(),
                    'rejected' => Application::where('status', 'rejected')->count(),
                ],
            ],
            'schools' => [
                'total' => School::count(),
                'active' => School::where('is_active', true)->count(),
            ],
            'contacts' => [
                'total' => Contact::count(),
                'open' => Contact::where('status', 'open')->count(),
                'resolved' => Contact::where('status', 'resolved')->count(),
            ],
            'commissions' => [
                'total' => Application::sum('application_fee'),
                'this_month' => Application::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                    ->sum('application_fee'),
            ],
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }
}
