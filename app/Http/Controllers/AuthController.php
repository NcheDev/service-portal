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
use Illuminate\Support\Facades\Validator;



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
    // Step 1: Validate email & password with strong rules
    $validator = Validator::make($request->all(), [
        'email' => ['required', 'email'],
        'password' => [
            'required', 'string', 'min:8',
            'regex:/[A-Z]/',    // at least one uppercase letter
            'regex:/[a-z]/',    // at least one lowercase letter
            'regex:/[0-9]/',    // at least one number
            'regex:/[@$!%*?&]/' // at least one special character
        ],
    ], [
        'email.required' => 'Email is required.',
        'email.email' => 'Please enter a valid email (must contain "@" and a domain).',
        'password.required' => 'Password is required.',
        'password.min' => 'Password must be at least 8 characters long.',
        'password.regex' => 'Password must include uppercase, lowercase, a number, and a special character.',
    ]);

    // ✅ If validation fails
    if ($validator->fails()) {
        return back()
            ->withErrors($validator)
            ->with('error', 'There were errors in your login details. Please correct them and try again.')
            ->withInput($request->except('password'));
    }

    // Step 2: Rate limiting (3 attempts)
    if (RateLimiter::tooManyAttempts($this->throttleKey($request), 3)) {
        $seconds = RateLimiter::availableIn($this->throttleKey($request));
        return back()
            ->with('error', 'Too many login attempts. Please reset your password or try again in ' . $seconds . ' seconds.')
            ->withInput();
    }

    // Step 3: Check if user exists and is active
    $user = User::where('email', $request->email)->first();
    if (!$user) {
        RateLimiter::hit($this->throttleKey($request), 60);
        return back()
            ->with('error', 'No account found with this email address.')
            ->withInput();
    }

    if (!$user->is_active) {
        return back()
            ->with('error', 'Your account has been suspended. Please contact support.')
            ->withInput();
    }

    // Step 4: Attempt login
    $credentials = $request->only('email', 'password');
    if (!Auth::attempt($credentials, $request->filled('remember'))) {
        RateLimiter::hit($this->throttleKey($request), 60);
        return back()
            ->with('error', 'Invalid email or password.')
            ->withInput($request->except('password'));
    }

    // Step 5: Successful login
    RateLimiter::clear($this->throttleKey($request));
    $request->session()->regenerate();

    return redirect()->intended(
        Auth::user()->hasRole('admin') ? '/admin.dashboard' : '/user-dashboard'
    )->with('success', 'Welcome back!');
}

/**
 * Helper for rate limiting
 */ 
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
