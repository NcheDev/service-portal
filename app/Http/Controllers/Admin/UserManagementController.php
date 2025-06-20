<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;


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
        'invoices'
    ])->findOrFail($id);
    $roles = Role::all(); // get all available roles
    $permissions = Permission::all(); // get all available permissions

    return view('admin.users.show', compact('user', 'roles', 'permissions'));
}

 public function validateUser(Request $request, User $user)
{
    $request->validate([
        'validation_report' => 'required|mimes:pdf|max:2048',
        'action' => 'required|in:validated,invalid',
    ]);

    // Store the uploaded file
    $path = $request->file('validation_report')->store('validation_reports', 'public');

    // Set status based on action
    $user->status = $request->action;
    $user->response_report_path = $path;
    $user->save();

    return redirect()->back()->with('success', 'User has been marked as ' . $request->action . ' and report uploaded.');
}

public function validatedUsers()
{
    // Fetch all users with 'validated' status
    // Eager load roles and permissions for performance
$validatedUsers = User::where('status', 'validated')->paginate(10);

    return view('admin.users.show2', compact('validatedUsers'));
}
public function revertStatus(User $user)
{
    $user->status = 'pending';
    $user->save();

    return back()->with('success', 'User status reverted to pending.');
}



}
