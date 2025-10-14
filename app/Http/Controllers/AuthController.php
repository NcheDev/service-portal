<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    
    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
           'surname' => 'required|string|max:255',

            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).+$/',
            ],
        ], [
            'email.unique' => 'This email is already registered. Please use a different one or log in instead.',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ]);
        
        
    
        // Create the user
      $user = User::create([
    'name' => $request->first_name . ' ' . $request->surname,
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
    // ✅ Step 1: Validate inputs (simple and browser-compatible)
    $request->validate([
       $request->validate([
    'email' => [
        'required',
        'email', // ensures it has "@" and a valid domain format
    ],
    'password' => [
        'required',
        'string',
        'min:8',                      // at least 8 characters
        'regex:/[A-Z]/',              // at least one uppercase letter
        'regex:/[a-z]/',              // at least one lowercase letter
        'regex:/[0-9]/',              // at least one digit
        'regex:/[@$!%*?&]/',          // at least one special character
    ],
], [
    'email.required' => 'Please enter your email address.',
    'email.email' => 'Enter a valid email address with "@" and a domain.',

    'password.required' => 'Please enter your password.',
    'password.min' => 'Password must be at least 8 characters long.',
    'password.regex' => 'Password must include uppercase, lowercase, number, and a special character (e.g. @, $, %, !).',
]),

    ], [
        'email.required' => 'Please enter your email address.',
        'email.email' => 'Invalid email format. Please include "@" and domain.',
        'password.required' => 'Please enter your password.',
    ]);

    // ✅ Step 2: Check rate limit (3 attempts per minute)
    if (RateLimiter::tooManyAttempts($this->throttleKey($request), 3)) {
        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        return back()->with('error',
            'You have entered the wrong password more than 3 times. ' .
            'Please reset your password or try again in ' . $seconds . ' seconds.'
        )->withInput();
    }

    // ✅ Step 3: Verify if user exists
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->with('error', 'No account found with this email.')->withInput();
    }

    // ✅ Step 4: Check if user is active
    if (!$user->is_active) {
        return back()->with('error', 'Your account was suspended. Please contact support.')->withInput();
    }

    // ✅ Step 5: Attempt login
    $credentials = $request->only('email', 'password');

    if (!Auth::attempt($credentials, $request->filled('remember'))) {
        // count failed attempts
        RateLimiter::hit($this->throttleKey($request), 60); // lockout for 60 seconds
        return back()->with('error', 'Invalid email or password.')->withInput();
    }

    // ✅ Step 6: Successful login
    RateLimiter::clear($this->throttleKey($request)); // reset failed attempts
    $request->session()->regenerate();

    $user = Auth::user();

    return redirect()
        ->intended($user->hasRole('admin') ? '/admin.dashboard' : '/user-dashboard')
        ->with('success', 'Login successful! Welcome back.');
}

/**
 * Generate a unique throttle key for rate limiting.
 */
protected function throttleKey(Request $request)
{
    return strtolower($request->input('email')) . '|' . $request->ip();
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

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard'); // 👈 this is the key change
    } else {
        return view('user-dashboard', compact('user'));
    }
}
protected function ensureIsNotRateLimited(Request $request)
{
    if (!RateLimiter::tooManyAttempts($this->throttleKey($request), 3)) {
        return;
    }

    $seconds = RateLimiter::availableIn($this->throttleKey($request));

    throw ValidationException::withMessages([
        'email' => "Too many login attempts. Please try again in {$seconds} seconds.",
    ]);
}
 



}
