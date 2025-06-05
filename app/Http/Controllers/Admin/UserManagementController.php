<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserManagementController extends Controller
{
   public function index(Request $request)
    {
        // Eager‐load roles and permissions; paginate 10 users per page
        $users = User::with('roles', 'permissions')->paginate(10);

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
        'payments'
    ])->findOrFail($id);
    $roles = Role::all(); // get all available roles
    $permissions = Permission::all(); // get all available permissions

    return view('admin.users.show', compact('user', 'roles', 'permissions'));
}

 

}
