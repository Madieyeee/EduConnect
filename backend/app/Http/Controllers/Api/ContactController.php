<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['store']);
    }

    /**
     * Display a listing of contacts (Admin only).
     */
    public function index(Request $request): JsonResponse
    {
        $this->middleware('admin');
        
        $query = Contact::with(['user', 'assignedAdmin']);

        // Apply filters
        if ($request->has('status')) {
            $query->byStatus($request->status);
        }

        if ($request->has('type')) {
            $query->byType($request->type);
        }

        if ($request->has('priority')) {
            $query->byPriority($request->priority);
        }

        if ($request->has('assigned_to')) {
            if ($request->assigned_to === 'unassigned') {
                $query->unassigned();
            } else {
                $query->where('assigned_to', $request->assigned_to);
            }
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $contacts = $query->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $contacts,
        ]);
    }

    /**
     * Store a newly created contact message.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
            'type' => 'nullable|in:general,application_help,technical_support,complaint',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $contactData = $validator->validated();
        
        // Add user_id if authenticated
        if (Auth::guard('api')->check()) {
            $contactData['user_id'] = Auth::guard('api')->id();
        }

        $contact = Contact::create($contactData);

        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent successfully. We will get back to you soon.',
            'data' => $contact->load(['user']),
        ], 201);
    }

    /**
     * Display the specified contact.
     */
    public function show(Contact $contact): JsonResponse
    {
        $this->middleware('admin');
        
        return response()->json([
            'success' => true,
            'data' => $contact->load(['user', 'assignedAdmin']),
        ]);
    }

    /**
     * Update the specified contact (Admin only).
     */
    public function update(Request $request, Contact $contact): JsonResponse
    {
        $this->middleware('admin');
        
        $validator = Validator::make($request->all(), [
            'status' => 'nullable|in:open,in_progress,resolved,closed',
            'priority' => 'nullable|in:low,medium,high,urgent',
            'assigned_to' => 'nullable|exists:users,id',
            'admin_response' => 'nullable|string|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $updateData = $validator->validated();
        
        // If admin_response is provided, mark as responded
        if (isset($updateData['admin_response'])) {
            $updateData['responded_at'] = now();
            if (!isset($updateData['status'])) {
                $updateData['status'] = Contact::STATUS_RESOLVED;
            }
        }

        $contact->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Contact updated successfully',
            'data' => $contact->load(['user', 'assignedAdmin']),
        ]);
    }

    /**
     * Assign contact to admin.
     */
    public function assign(Request $request, Contact $contact): JsonResponse
    {
        $this->middleware('admin');
        
        $validator = Validator::make($request->all(), [
            'admin_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $admin = User::findOrFail($request->admin_id);
        
        if (!$admin->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Selected user is not an admin',
            ], 422);
        }

        $contact->assignTo($admin);

        return response()->json([
            'success' => true,
            'message' => 'Contact assigned successfully',
            'data' => $contact->load(['user', 'assignedAdmin']),
        ]);
    }

    /**
     * Get user's own contacts.
     */
    public function myContacts(Request $request): JsonResponse
    {
        $user = Auth::guard('api')->user();
        
        $query = Contact::where('user_id', $user->id);

        // Apply filters
        if ($request->has('status')) {
            $query->byStatus($request->status);
        }

        if ($request->has('type')) {
            $query->byType($request->type);
        }

        $contacts = $query->orderBy('created_at', 'desc')
                         ->paginate($request->get('per_page', 10));

        return response()->json([
            'success' => true,
            'data' => $contacts,
        ]);
    }

    /**
     * Get contact statistics (Admin only).
     */
    public function statistics(): JsonResponse
    {
        $this->middleware('admin');
        
        $stats = [
            'total' => Contact::count(),
            'open' => Contact::byStatus(Contact::STATUS_OPEN)->count(),
            'in_progress' => Contact::byStatus(Contact::STATUS_IN_PROGRESS)->count(),
            'resolved' => Contact::byStatus(Contact::STATUS_RESOLVED)->count(),
            'closed' => Contact::byStatus(Contact::STATUS_CLOSED)->count(),
            'unassigned' => Contact::unassigned()->count(),
            'by_type' => [
                'general' => Contact::byType(Contact::TYPE_GENERAL)->count(),
                'application_help' => Contact::byType(Contact::TYPE_APPLICATION_HELP)->count(),
                'technical_support' => Contact::byType(Contact::TYPE_TECHNICAL_SUPPORT)->count(),
                'complaint' => Contact::byType(Contact::TYPE_COMPLAINT)->count(),
            ],
            'by_priority' => [
                'low' => Contact::byPriority(Contact::PRIORITY_LOW)->count(),
                'medium' => Contact::byPriority(Contact::PRIORITY_MEDIUM)->count(),
                'high' => Contact::byPriority(Contact::PRIORITY_HIGH)->count(),
                'urgent' => Contact::byPriority(Contact::PRIORITY_URGENT)->count(),
            ],
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }
}
