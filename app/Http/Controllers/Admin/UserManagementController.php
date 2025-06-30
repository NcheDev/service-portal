<?php
namespace App\Http\Controllers\Admin;

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

        return back()->with('status', 'User status updated.');
    }

    // UserManagementController.php
public function assignRole(Request $request, User $user)
{
    $request->validate([
        'role' => 'required|string|exists:roles,name',
    ]);

    \Log::info('Assigning role', ['user_id' => $user->id, 'role' => $request->role]);

    $user->syncRoles($request->role); // Assigns and replaces existing role(s)
    return back()->with('success', 'Role assigned successfully.');
}





 public function removeRole(Request $request, User $user) 
{
    $request->validate([
        'role' => 'required|string|exists:roles,name',
    ]);

    $user->removeRole($request->role);

    return back()->with('success', 'Role removed successfully.');
}



    public function givePermission(Request $request, User $user)
    {
        $user->givePermissionTo($request->permission);
        return back()->with('status', 'Permission assigned.');
    }

    public function revokePermission(Request $request, User $user)
    {
        $user->revokePermissionTo($request->permission);
        return back()->with('status', 'Permission removed.');
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
        'validation_comment' => 'required|nullable|string|max:1000',
    ]);

    // Store the uploaded file
    $path = $request->file('validation_report')->store('validation_reports', 'public');

    // Update application details
    $application->status = $request->action;
    $application->response_report_path = $path;
    $application->validation_comment = $request->validation_comment; // New line
    $application->save();

    // Notify the user
    $user = $application->user;
    Mail::to($user->email)->send(new UserStatusNotificationMail($user, $application, $request->action));

    return redirect()->back()->with('success', 'User has been marked as ' . $request->action . ' and report uploaded.');
}


 
public function revertStatus(Application $application)
{
    $application->status = 'pending';
    $application->save();

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

    return $pdf->download("Validation_Letter_{$personalInfo->full_name}.pdf");
}
public function dashboard()
{
    $startOfWeek = Carbon::now()->startOfWeek();
    $startOfMonth = Carbon::now()->startOfMonth();

    $newApplications = Application::where('created_at', '>=', $startOfWeek)->count();

    // Consider completed to be any that are not pending
    $completedApplications = Application::where('status', '!=', 'pending')->count();

    $approvedApplications = Application::where('status', 'validated')
        ->where('created_at', '>=', $startOfMonth)
        ->count();

    $rejectedApplications = Application::where('status', 'invalid')
        ->where('created_at', '>=', $startOfMonth)
        ->count();

    return view('admin-dashboard', compact(
        'newApplications',
        'completedApplications',
        'approvedApplications',
        'rejectedApplications'
    ));
}


}
