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
    // Step 1: Validate inputs
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'g-recaptcha-response' => 'required',
    ], [
        'g-recaptcha-response.required' => 'Please verify you are not a robot.',
    ]);

    // Step 2: Verify reCAPTCHA
    $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
        'secret' => config('services.recaptcha.secret_key'),
        'response' => $request->input('g-recaptcha-response'),
        'remoteip' => $request->ip(),
    ]);

    $body = $response->json();
    if (!$body['success']) {
        return back()->withErrors(['captcha' => 'reCAPTCHA verification failed. Please try again.'])->withInput();
    }

    // Step 3: Check rate limit (max 3 attempts)
    if (RateLimiter::tooManyAttempts($this->throttleKey($request), 3)) {
        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        return back()->withErrors([
            'email' => 'You have entered the wrong password more than 3 times. ' .
                       'Please reset your password ' .
                       'or try again in ' . $seconds . ' seconds.',
        ])->withInput();
    }
    // Step 3.5: Check if user exists and active
$user = User::where('email', $request->email)->first();
if ($user && !$user->is_active) {
    return back()->withErrors([
        'email' => 'Your account was suspended. Please contact support.'
    ])->withInput();
}


    // Step 4: Attempt login
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials, $request->filled('remember'))) {
        RateLimiter::clear($this->throttleKey($request)); // reset failed attempts
        $request->session()->regenerate();

        $user = Auth::user();
        return $user->hasRole('admin')
            ? redirect('/admin.dashboard')
            : redirect('/user-dashboard');
    }

    // Step 5: Failed login — count as an attempt
    RateLimiter::hit($this->throttleKey($request), 60); // lockout for 60 seconds

    return back()->withErrors([
        'email' => 'Invalid email or password.',
    ])->withInput();
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

protected function throttleKey(Request $request)
{
    // Unique per user email + IP
    return Str::lower($request->input('email')).'|'.$request->ip();
}



}
