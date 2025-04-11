<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    
    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'country' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);
        User::create([
            'name' => $request->username,
            'email' => $request->email,
            'country' => $request->country,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Registration successful!');
    }
    public function showLogin()
    {
        return view('login'); // or 'auth.login' if it's in a folder
    }

    public function showLoginForm()
{
    return view('login'); 
}

public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect('/admin-dashboard');
        } else {
            return redirect('/user-dashboard');
        }
    }

    return back()->withErrors(['email' => 'Invalid email or password.']);
}

public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
}
public function dashboard()
{
    $user = Auth::user();

    if ($user->role === 'admin') {
        return view('admin-dashboard', compact('user'));
    } else {
        return view('user-dashboard', compact('user'));
    }
}


}
