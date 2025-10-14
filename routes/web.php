<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
 use App\Http\Controllers\PersonalInformationController;
use App\Notifications\ResponseReportUploaded;
use App\Http\Controllers\ApplicationController;
 use App\Http\Controllers\InvoiceController;
 use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\Auth\ResetPasswordController;

use App\Http\Controllers\AdditionalInfoController;
use App\Http\Controllers\Admin\AuditTrailController;
use App\Http\Controllers\Admin\UserManagementController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
 use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\ApplicantViewController;



Route::middleware(['auth'])->group(function () {
    Route::get('/profile-details', [PersonalInformationController::class, 'showProfileDetails']);
});

// Index route
Route::get('/', [AuthController::class, 'showLogin']);

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registration
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
//personal information routes
Route::middleware(['auth'])->group(function () {
    // Show the form
    Route::get('/personal-info', [PersonalInformationController::class, 'showForm'])
        ->name('personal.showForm');

    // Store or update the form
   Route::match(['post', 'put'], '/personal-info', [PersonalInformationController::class, 'storeOrUpdate'])->name('personal.storeOrUpdate');
});
// Dashboards (only for verified users)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin.dashboard', function () {
    return redirect()->route('admin.dashboard');
});


    Route::get('/user-dashboard', function () {
        return view('user.dashboard');
    });
});

 
//documentation routes


Route::get('/documentation', function () {
    return view('user.documentation');
})->name('documentation.view');
//main-panel route
Route::get('/main-panel', function () {
    return view('user.main-panel');
})->name('main-panel.view');
// routes for downloading the PDF


Route::get('/documentation', [DocumentationController::class, 'show'])->name('documentation.view');
Route::get('/documentation/download', [DocumentationController::class, 'downloadPdf'])->name('documentation.download');

// Email verification routes
Route::middleware(['auth'])->group(function () {
    // Show the email verification notice
    Route::get('/email/verify', function () {
        return view('auth.verify');
    })->name('verification.notice');

    // Handle the email verification link
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill(); // Marks user as verified

        return redirect('/login'); // or /user-dashboard based on your flow
    })->middleware(['signed'])->name('verification.verify');

    // Resend the verification email
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware('throttle:6,1')->name('verification.send');
});
// routes/web.php

Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');


Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/users', [UserManagementController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{user}', [UserManagementController::class, 'show'])->name('admin.users.show'); // Added show route
    Route::post('/users/{user}/toggle', [UserManagementController::class, 'toggleActive'])->name('admin.users.toggle');
    Route::post('/users/{user}/assign-role', [UserManagementController::class, 'assignRole'])->name('admin.users.assignRole');
    Route::post('/users/{user}/remove-role', [UserManagementController::class, 'removeRole'])->name('admin.users.removeRole');
    Route::post('/users/{user}/give-permission', [UserManagementController::class, 'givePermission'])->name('admin.users.givePermission');
    Route::post('/users/{user}/revoke-permission', [UserManagementController::class, 'revokePermission'])->name('admin.users.revokePermission');

});
 
// Show the form
Route::get('/application', [ApplicationController::class, 'create'])->name('application.create');

// Handle form submission
Route::post('/application', [ApplicationController::class, 'store'])->name('application.store');
    //consent form upload
Route::post('/upload-consent-form', [ApplicationController::class, 'uploadConsentForm'])->name('documents.uploadConsent');
// Show the user's applications
Route::get('/my-applications', [ApplicationController::class, 'myApplications'])->name('applications.my');

// Invoice routes
Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
Route::get('/invoices/{invoice}/pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.pdf');
// routes/web.php

Route::get('/invoices/{invoice}/payment', [InvoiceController::class, 'paymentForm'])->name('invoices.payment');
Route::post('/invoices/{invoice}/payment', [InvoiceController::class, 'submitPayment'])->name('invoices.payment.submit');
 
Route::get('/invoices/{invoice}/payment', [InvoiceController::class, 'paymentForm'])->name('invoices.payment');

Route::post('/invoices/{invoice}/payment', [InvoiceController::class, 'submitPayment'])->name('invoices.submitPayment');
 Route::get('/my-applications', [ApplicationController::class, 'myApplications'])
     ->name('applications.my')
     ->middleware('auth');
     Route::get('/applications/{id}', [ApplicationController::class, 'show'])->name('applications.show');

Route::get('/applications/{id}', [ApplicationController::class, 'show'])->name('applications.show');
Route::get('/applications/{id}', [ApplicationController::class, 'show'])->name('applications.show');
Route::get('/my-applications', [ApplicationController::class, 'myApplications'])->name('applications.my');
// in web.php
Route::post('/applications/{application}/request-info', [ApplicationController::class, 'requestInfo'])->name('applications.request-info');
Route::put('/applications/respond-info/{infoRequest}', [ApplicationController::class, 'respondInfo'])->name('applications.respond-info');
Route::post('/applications/{application}/request-info', [ApplicationController::class, 'requestInfo'])
    ->name('applications.request-info');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/users/validated', [UserManagementController::class, 'validatedUsers'])->name('admin.users.validated');
});
Route::get('/admin/users/validated', [UserManagementController::class, 'validatedUsers'])->name('admin.users.validated');

     Route::get('/applicants', [ApplicantViewController::class, 'all'])->name('admin.applicants.all');
    Route::get('/applicants/validated', [ApplicantViewController::class, 'validated'])->name('admin.applicants.validated');
    Route::get('/applicants/pending', [ApplicantViewController::class, 'pending'])->name('admin.applicants.pending');
    Route::get('/applicants/invalid', [ApplicantViewController::class, 'rejected'])->name('admin.applicants.invalid');
 Route::post('/users/{application}/validate', [UserManagementController::class, 'validateUser'])->name('admin.users.validate');
Route::patch('/users/{application}/revert', [UserManagementController::class, 'revertStatus'])->name('admin.users.revertStatus');

Route::get('/applications/{application}', [UserManagementController::class, 'show'])->name('applications.show');
Route::get('/admin/applications/{application}/generate-letter', [UserManagementController::class, 'generateValidationLetter'])
    ->name('applications.generateLetter');
// routes/web.php

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Other admin routes...

    Route::get('applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');
});
// routes/web.php

 Route::get('/db-check', function () {
    try {
        DB::connection()->getPdo();
        return "✅ Connected to database: " . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return "❌ Could not connect: " . $e->getMessage();
    }
});
Route::get('/db-check', function () {
    return 'Connected to DB: ' . DB::connection()->getDatabaseName();
});

Route::get('/admin/dashboard', [UserManagementController::class, 'dashboard'])->name('admin.dashboard');
Route::post('/users/{application}/validate', [UserManagementController::class, 'validateUser'])->name('admin.users.validate');
Route::patch('/users/{application}/revert', [UserManagementController::class, 'revertStatus'])->name('admin.users.revertStatus');

 
Route::get('/admin/applicants/{userId}/application/{applicationId}', [UserManagementController::class, 'viewApplication'])
    ->name('admin.applicants.viewApplication');
Route::prefix('admin/applicants')->name('admin.applicants.')->group(function () {
    Route::post('/{application}/validate', [UserManagementController::class, 'validateUser'])->name('validateUser');
    Route::post('/{application}/revert', [UserManagementController::class, 'revertStatus'])->name('revertStatus');
    Route::get('/{application}/generate-letter', [UserManagementController::class, 'generateValidationLetter'])->name('generateValidationLetter');
    Route::get('/{user}/{application}/view', [UserManagementController::class, 'viewApplication'])->name('viewApplication');
});

Route::get('/invoices', function () {
    $invoices = \App\Models\Invoice::with('application')->where('user_id', auth()->id())->latest()->get();
    return view('invoices.index', compact('invoices'));
})->middleware(['auth'])->name('invoices.index');
Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/help', function () {
    return view('help');
});
// Audit Trail route
Route::get('/audit-trail', [\App\Http\Controllers\Admin\AuditTrailController::class, 'index'])->name('audit.index');


 Route::middleware(['auth'])->group(function () {
    Route::get('/applications/{application}', [ApplicationController::class, 'show'])
        ->name('user.application.details');
});
Route::post('/notifications/mark-all-read', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return back();
})->name('notifications.markAllRead');
// web.php
Route::get('/notifications/read/{id}', function($id) {
    $notification = auth()->user()->notifications()->find($id);
    if ($notification) {
        $notification->markAsRead();
        return redirect($notification->data['url'] ?? '/');
    }
    return redirect('/');
})->name('notifications.read');

Route::get('/user/applications/{application}', [ApplicationController::class, 'show'])
    ->name('user.application.details');Route::get('admin/applicants/{user}/{application}/view', 
    [App\Http\Controllers\Admin\UserManagementController::class, 'viewApplication']
)->name('admin.applicants.viewApplication');

Route::prefix('admin')->middleware(['auth'])->group(function() {

    // Load chat page for a specific application
    Route::get('additional-info/{application}/chat', [AdditionalInfoController::class, 'chat'])
        ->name('admin.additional-info.chat');

    // Admin sends a new request to the user
    Route::post('additional-info/{application}/send', [AdditionalInfoController::class, 'requestInfo'])
        ->name('admin.additional-info.send');

    // User responds to request (optional, if handled by admin panel)
    Route::post('additional-info/respond/{infoRequest}', [AdditionalInfoController::class, 'respondInfo'])
        ->name('user.additional-info.respond');

    // Optional: Mark all notifications as read (if using your notification blade)
    Route::post('notifications/mark-all-read', function() {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.markAllRead');

});

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function() {

    Route::post('applicants/{application}/request-info', [ApplicationController::class, 'requestInfo'])
        ->name('applicants.requestInfo');

});
Route::get('/admin/additional-info-chat/{application}', [ApplicationController::class, 'showAdditionalInfoChat'])
    ->name('admin.additional-info.chat');
    
    
    
Route::middleware(['auth'])->group(function () {
    Route::get('/personal-info', [PersonalInformationController::class, 'showForm'])
        ->name('user.personal-info');

    Route::post('/personal-info', [PersonalInformationController::class, 'storeOrUpdate']);
});

 
Route::get('/dashboard', function () {
    return view('user.dashboard');
})->name('user.dashboard'); 


Route::middleware(['auth'])->group(function () {
    // Show form
    Route::get('/personal-information', [PersonalInformationController::class, 'showForm'])
        ->name('personal.showForm');

    // Save or update form
    Route::post('/personal-information', [PersonalInformationController::class, 'storeOrUpdate'])
        ->name('personal.storeOrUpdate');
});
Route::get('/profile', [PersonalInformationController::class, 'show'])->name('user.profile');

Route::get('/applications/{application}/pending-count', [ApplicationController::class, 'pendingCount'])
    ->name('applications.pendingCount');

    // routes/web.php
Route::get('/notifications/read/{id}', function ($id) {
    $notification = auth()->user()->unreadNotifications()->find($id);
    if ($notification) {
        $notification->markAsRead();
    }
    return response()->json(['status' => 'success']);
});

 
Route::post('/personal-information', [PersonalInformationController::class, 'storeOrUpdate'])
    ->name('personal-information.storeOrUpdate');

Route::get('/admin/dashboard', [UserManagementController::class, 'dashboard'])
    ->name('admin.dashboard');

    Route::get('/user-dashboard', [ApplicationController::class, 'userDashboard'])
    ->name('user.dashboard')
    ->middleware(['auth']);

    Route::patch('/admin/users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])
    ->name('admin.users.toggleStatus');
