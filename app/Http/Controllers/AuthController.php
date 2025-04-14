<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Http;


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
            'g-recaptcha-response' => 'required',
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
    // Step 1: Validate inputs including reCAPTCHA checkbox
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'g-recaptcha-response' => 'required',
    ], [
        'g-recaptcha-response.required' => 'Please verify you are not a robot.',
    ]);

    // Step 2: Verify reCAPTCHA with Google
    $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        'secret' => config('services.recaptcha.secret_key'),
        'response' => $request->input('g-recaptcha-response'),
        'remoteip' => $request->ip(),
    ]);

    $body = $response->json();

    if (!$body['success']) {
        return back()->withErrors(['captcha' => 'reCAPTCHA verification failed. Please try again.'])->withInput();
    }

    // Step 3: Attempt login ONLY if reCAPTCHA passed
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect('/admin-dashboard');
        } else {
            return redirect('/user-dashboard');
        }
    }

    return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
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
