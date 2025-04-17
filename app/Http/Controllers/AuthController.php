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
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).+$/',
            ],
            'g-recaptcha-response' => 'required',
        ], [
            'email.unique' => 'This email is already registered. Please use a different one or log in instead.',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'g-recaptcha-response.required' => 'Please verify you are not a robot.',
        ]);
        
        
    
        // Create the user
        $user = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        // Automatically log them in
        Auth::login($user);
    
        // Send the verification email
        $user->sendEmailVerificationNotification();
    
        // Redirect to email verification notice
        return redirect()->route('verification.notice')->with('success', 'Registration successful! Please check your email to verify your account.');
    }
    public function showLogin()
    {
        return view('welcome'); // or 'auth.login' if it's in a folder
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
