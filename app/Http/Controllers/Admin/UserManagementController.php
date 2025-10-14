<?php

namespace App\Http\Controllers\Admin;
use App\Models\AuditTrail;

use App\Models\User;
use App\Models\Application;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Mail;
  use App\Mail\UserStatusNotificationMail;
  use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
 

class UserManagementController extends Controller
{
   public function index(Request $request)
    {
        // Eager‐load roles and permissions; paginate 10 users per page
        $users = User::with('roles', 'permissions', 'applications.documents')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show a single user’s details and management controls.
     */
   

    public function toggleActive(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();
            $this->logTrail("Toggled user ID {$user->id} active status to " . ($user->is_active ? 'active' : 'inactive'));

        return back()->with('status', 'User status updated.');
    }

    // UserManagementController.php 

public function assignRole(Request $request, User $user)
{
    $request->validate([
        'role' => 'required|string|exists:roles,name',
    ]);

    \Log::info('Assigning role', ['user_id' => $user->id, 'role' => $request->role]);
    $user->syncRoles($request->role);
    $this->logTrail("Assigned role '{$request->role}' to user ID {$user->id}");


    // If AJAX, return JSON with rendered HTML
    if ($request->ajax()) {
        $roles = Role::all();
        $permissions = Permission::all();
        $html = view('admin.users.show', compact('user', 'roles', 'permissions'))->render();
        return response()->json(['html' => $html]);
    }

    // Otherwise normal redirect
    return redirect()
        ->route('admin.users.show', $user)
        ->with('success', 'Role assigned successfully.');
}

public function removeRole(Request $request, User $user)
{
    $request->validate([
        'role' => 'required|string|exists:roles,name',
    ]);

    $user->removeRole($request->role);
    $this->logTrail("Removed role '{$request->role}' from user ID {$user->id}");


    if ($request->ajax()) {
        $roles = Role::all();
        $permissions = Permission::all();
        $html = view('admin.users.show', compact('user', 'roles', 'permissions'))->render();
        return response()->json(['html' => $html]);
    }

    return redirect()
        ->route('admin.users.show', $user)
        ->with('success', 'Role removed successfully.');
}

public function givePermission(Request $request, User $user)
{
    $request->validate([
        'permission' => 'required|string|exists:permissions,name',
    ]);

    $user->givePermissionTo($request->permission);
    $this->logTrail("Gave permission '{$request->permission}' to user ID {$user->id}");


    if ($request->ajax()) {
        $roles = Role::all();
        $permissions = Permission::all();
        $html = view('admin.users.show', compact('user', 'roles', 'permissions'))->render();
        return response()->json(['html' => $html]);
    }

    return redirect()
        ->route('admin.users.show', $user)
        ->with('success', 'Permission assigned successfully.');
}

public function revokePermission(Request $request, User $user)
{
    $request->validate([
        'permission' => 'required|string|exists:permissions,name',
    ]);

    $user->revokePermissionTo($request->permission);
    $this->logTrail("Revoked permission '{$request->permission}' from user ID {$user->id}");


    if ($request->ajax()) {
        $roles = Role::all();
        $permissions = Permission::all();
        $html = view('admin.users.show', compact('user', 'roles', 'permissions'))->render();
        return response()->json(['html' => $html]);
    }

    return redirect()
        ->route('admin.users.show', $user)
        ->with('success', 'Permission removed successfully.');
}


public function show($id)
{
    $user = User::with([
        'roles',
        'permissions',
        'personalInformation',
        'qualifications',
        'invoices',
        'applications' => function ($query) {
            $query->with('invoice'); // optional: eager load related invoice if needed
        }
    ])->findOrFail($id);

    $roles = Role::all();
    $permissions = Permission::all();

    return view('admin.users.show', compact('user', 'roles', 'permissions'));
}
 public function validateUser(Application $application, Request $request)
{
    $request->validate([
        'validation_report' => 'required|mimes:pdf|max:2048',
        'action' => 'required|in:validated,invalid',
        'validation_comment' => 'required|string|max:1000',
    ]);

    // Store the uploaded file
    $path = $request->file('validation_report')->store('validation_reports', 'public');

    // Update application details
    $application->status = $request->action;
    $application->response_report_path = $path;
    $application->validation_comment = $request->validation_comment; // New line
    $application->save();
$this->logTrail("Marked application ID {$application->id} as {$request->action}", "Validation report uploaded: {$path}");

    // Notify the user
    $user = $application->user;
    Mail::to($user->email)->send(new UserStatusNotificationMail($user, $application, $request->action));

    return redirect()->back()->with('success', 'User has been marked as ' . $request->action . ' and report uploaded.');
}


 
public function revertStatus(Application $application)
{
    $application->status = 'pending';
    $application->save();
    $this->logTrail("Reverted application ID {$application->id} status to pending");


    return back()->with('success', 'Application status reverted to pending.');
}


public function generateValidationLetter(Application $application)
{
    // Load user with related data
    $user = $application->user()->with(['personalInformation', 'qualifications'])->firstOrFail();
    $personalInfo = $user->personalInformation;
    
    // Get the qualification from the specific application
    $qualification = $application->qualifications->first();

    // Prepare data for PDF
    $data = [
        'user' => $user,
        'personalInfo' => $personalInfo,
        'qualification' => $qualification,
            'application' => $application,
        'title' => $personalInfo->title ?? '---',
        'full_name' => $personalInfo->full_name ?? '---',
        'physical_address' => $personalInfo->physical_address ?? '---',
        'country' => $personalInfo->country ?? '---',
        'program_name' => $qualification->program_name ?? '---',
        'qualification_name' => $qualification->name ?? '---',
        'institution' => $qualification->institution ?? '---',
        'certificate_country' => $qualification->country ?? '---',
        'award_date' => $qualification?->year
            ? \Carbon\Carbon::parse($qualification->year)->format('jS F, Y')
            : '---',

        'salutation' => $personalInfo?->gender === 'female' ? 'Madam' : 'Sir',
        'date' => now()->format('jS F, Y'),
    ];

    // Generate and download PDF
    $pdf = Pdf::loadView('pdfs.validation_letter', $data);
$this->logTrail("Generated validation letter for application ID {$application->id}");


    return $pdf->download("Validation_Letter_{$personalInfo->full_name}.pdf");
    
}
public function dashboard()
{
    $startOfWeek = Carbon::now()->startOfWeek();
    $startOfMonth = Carbon::now()->startOfMonth();

    $newApplications = Application::where('created_at', '>=', $startOfWeek)->count();

    // Completed = anything that is not pending
    $completedApplications = Application::where('status', '!=', 'pending')->count();

    // Validated this month
    $approvedApplications = Application::where('status', 'validated')
        ->where('updated_at', '>=', $startOfMonth) // <-- use updated_at
        ->count();

    // Invalid this month
    $rejectedApplications = Application::where('status', 'invalid')
        ->where('updated_at', '>=', $startOfMonth) // <-- use updated_at
        ->count();

    return view('admin.dashboard', compact(
        'newApplications',
        'completedApplications',
        'approvedApplications',
        'rejectedApplications'
    ));
}

public function viewApplication($userId, $applicationId)
{
    $user = User::with('personalInformation')->findOrFail($userId);

    $application = $user->applications()
        ->with(['qualifications', 'documents', 'invoice'])
        ->findOrFail($applicationId);

    $this->logTrail("Viewed application ID {$applicationId} for user ID {$userId}");

 
    return view('admin.applicants.show', compact('user', 'application'));
}


public function logTrail($action)
{
    try {
        \DB::table('audit_trails')->insert([
            'user_id' => auth()->id(),
            'action' => $action,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \Log::info('✅ Audit log inserted successfully');
    } catch (\Exception $e) {
        \Log::error('❌ Failed to insert audit trail: ' . $e->getMessage());
        dd($e->getMessage()); // temporary for debug
    }
}

public function toggleStatus(User $user)
{
    $user->is_active = !$user->is_active;
    $user->save();

    $status = $user->is_active ? 'activated' : 'deactivated';

    return redirect()->back()->with('success', "User has been {$status} successfully.");
}



}
