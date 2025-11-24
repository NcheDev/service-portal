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

Route::get('/', [AuthController::class, 'showLogin']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/help', function () {
    return view('help');
});

// Routes requiring auth + prevent-back-history
Route::middleware(['auth', 'prevent-back-history'])->group(function () {

    // Dashboard / user-panel
    Route::get('/user-dashboard', [ApplicationController::class, 'userDashboard'])->name('user.dashboard');
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    Route::get('/main-panel', function () {
        return view('user.main-panel');
    })->name('main-panel.view');

    // Documentation
    Route::get('/documentation', [DocumentationController::class, 'show'])->name('documentation.view');
    Route::get('/documentation/download', [DocumentationController::class, 'downloadPdf'])->name('documentation.download');

    // Invoices
    Route::get('/invoices', function () {
        $invoices = \App\Models\Invoice::with('application')->where('user_id', auth()->id())->latest()->get();
        return view('invoices.index', compact('invoices'));
    })->name('invoices.index');

    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/invoices/{invoice}/pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.pdf');
    Route::get('/invoices/{invoice}/payment', [InvoiceController::class, 'paymentForm'])->name('invoices.payment');
    Route::post('/invoices/{invoice}/payment', [InvoiceController::class, 'submitPayment'])->name('invoices.payment.submit');

    // Profile / personal information (already partially grouped)
    Route::get('/profile', [PersonalInformationController::class, 'show'])->name('user.profile');

    // Notifications
    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.markAllRead');

    Route::get('/notifications/read/{id}', function ($id) {
        $notification = auth()->user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
            return redirect($notification->data['url'] ?? '/');
        }
        return redirect('/');
    })->name('notifications.read');

    // FAQ
    Route::get('/faq', function () {
        return view('faq');
    })->name('faq');

    // Pending applications count
    Route::get('/applications/{application}/pending-count', [ApplicationController::class, 'pendingCount'])
        ->name('applications.pendingCount');

    // Download application PDF
    Route::get('/application/{id}/download', [ApplicationController::class, 'downloadPDF'])->name('application.download');
});

// Email verification
Route::middleware(['auth'])->group(function () {

    Route::get('/email/verify', function () {
        return view('auth.verify');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/login'); // or redirect to dashboard
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->middleware('throttle:6,1')->name('verification.send');
});

Route::middleware(['auth', 'prevent-back-history'])->group(function () {

    // Dashboard
    Route::get('/user-dashboard', [ApplicationController::class, 'userDashboard'])
        ->name('user.dashboard');

    // Show application form
    Route::get('/application', [ApplicationController::class, 'create'])
        ->name('application.create');

    // Handle form submission
    Route::post('/application', [ApplicationController::class, 'store'])
        ->name('application.store');

    // Upload consent form
    Route::post('/upload-consent-form', [ApplicationController::class, 'uploadConsentForm'])
        ->name('documents.uploadConsent');

    // Show user's applications
    Route::get('/my-applications', [ApplicationController::class, 'myApplications'])
        ->name('applications.my');

    // Show specific application
    Route::get('/applications/{application}', [ApplicationController::class, 'show'])
        ->name('user.application.details');

    // Pending count for application
    Route::get('/applications/{application}/pending-count', [ApplicationController::class, 'pendingCount'])
        ->name('applications.pendingCount');

    // Edit & update application
    Route::get('/applications/{id}/edit', [ApplicationController::class, 'edit'])
        ->name('applications.edit');
    Route::put('/applications/{id}', [ApplicationController::class, 'update'])
        ->name('applications.update');

    // Download application PDF
    Route::get('/application/{id}/download', [ApplicationController::class, 'downloadPDF'])
        ->name('application.download');

    // Delete application document
    Route::delete('/applications/document/{id}/delete', [ApplicationController::class, 'destroyDocument'])
        ->name('applications.document.destroy');

    // Request additional info
    Route::post('/applications/{application}/request-info', [ApplicationController::class, 'requestInfo'])
        ->name('applications.request-info');

    // Respond to info request
    Route::put('/applications/respond-info/{infoRequest}', [ApplicationController::class, 'respondInfo'])
        ->name('applications.respond-info');

    // Admin-specific routes (if accessed under admin prefix)
    Route::prefix('admin')->group(function () {
        Route::get('applications/{application}', [ApplicationController::class, 'show'])
            ->name('applications.show');
    });
});

Route::middleware(['auth', 'prevent-back-history'])->group(function () {

    // Dashboard
    Route::get('/admin/dashboard', [UserManagementController::class, 'dashboard'])
        ->name('admin.dashboard');

    // Toggle user active/inactive
    Route::post('/users/{user}/toggle', [UserManagementController::class, 'toggleActive'])
        ->name('admin.users.toggle');

    // Toggle user status (duplicate)
    Route::patch('/admin/users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])
        ->name('admin.users.toggleStatus');

    // Assign / remove roles
    Route::post('/users/{user}/assign-role', [UserManagementController::class, 'assignRole'])
        ->name('admin.users.assignRole');
    Route::post('/users/{user}/remove-role', [UserManagementController::class, 'removeRole'])
        ->name('admin.users.removeRole');

    // Give / revoke permissions
    Route::post('/users/{user}/give-permission', [UserManagementController::class, 'givePermission'])
        ->name('admin.users.givePermission');
    Route::post('/users/{user}/revoke-permission', [UserManagementController::class, 'revokePermission'])
        ->name('admin.users.revokePermission');

    // Validate / revert user
    Route::post('/users/{application}/validate', [UserManagementController::class, 'validateUser'])
        ->name('admin.users.validate');
    Route::patch('/users/{application}/revert', [UserManagementController::class, 'revertStatus'])
        ->name('admin.users.revertStatus');

    // Validated users listing (duplicate)
    Route::get('/admin/users/validated', [UserManagementController::class, 'validatedUsers'])
        ->name('admin.users.validated');

    // View specific application
    Route::get('/applications/{application}', [UserManagementController::class, 'show'])
        ->name('applications.show');

    // Generate validation letter
    Route::get('/admin/applications/{application}/generate-letter', [UserManagementController::class, 'generateValidationLetter'])
        ->name('applications.generateLetter');

    // Admin view application for specific applicant
    Route::get('/admin/applicants/{userId}/application/{applicationId}', [UserManagementController::class, 'viewApplication'])
        ->name('admin.applicants.viewApplication');
});

Route::middleware(['auth', 'prevent-back-history'])->group(function () {

    // Show personal information form
    Route::get('/personal-info', [PersonalInformationController::class, 'showForm'])
        ->name('personal.showForm');

    // Save or update personal information
    Route::post('/personal-info', [PersonalInformationController::class, 'storeOrUpdate'])
        ->name('personal.storeOrUpdate');

    // Optional: alternative route naming for consistency
    Route::get('/personal-information', [PersonalInformationController::class, 'showForm'])
        ->name('user.personal-info');

    Route::post('/personal-information', [PersonalInformationController::class, 'storeOrUpdate'])
        ->name('personal-information.storeOrUpdate');

    // Show user profile
    Route::get('/profile', [PersonalInformationController::class, 'show'])
        ->name('user.profile');
});


// Notifications
Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.markAllRead');

    Route::get('/notifications/read/{id}', function ($id) {
        $notification = auth()->user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
            return redirect($notification->data['url'] ?? '/');
        }
        return redirect('/');
    })->name('notifications.read');
});

// Dashboard, FAQ, and Help pages
Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    Route::get('/user-dashboard', [ApplicationController::class, 'userDashboard'])
        ->name('user.dashboard');

    Route::get('/faq', function () {
        return view('faq');
    })->name('faq');

    Route::get('/help', function () {
        return view('help');
    });
});
Route::middleware(['auth', 'prevent-back-history'])->prefix('admin')->group(function () {
    // View applicant profile
    Route::get('/applicants/{userId}', [ApplicantViewController::class, 'show'])
        ->name('admin.applicants.show');

    // View all applications for a specific applicant
    Route::get('/applicants/{userId}/applications', [ApplicantViewController::class, 'applications'])
        ->name('admin.applicants.applications');
});

Route::middleware(['auth', 'prevent-back-history'])->prefix('admin')->group(function () {
    // List audit trails
    Route::get('/audit-trails', [AuditTrailController::class, 'index'])
        ->name('admin.audit-trails.index');

    // View specific audit trail entry
    Route::get('/audit-trails/{id}', [AuditTrailController::class, 'show'])
        ->name('admin.audit-trails.show');
});
Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    // Admin requests additional info from applicant
    Route::post('/applications/{application}/additional-info/request', [AdditionalInfoController::class, 'requestInfo'])
        ->name('applications.additional-info.request');

    // Applicant responds to additional info request
    Route::post('/applications/{application}/additional-info/respond', [AdditionalInfoController::class, 'respondInfo'])
        ->name('applications.additional-info.respond');

    // List additional info requests for user
    Route::get('/applications/{application}/additional-info', [AdditionalInfoController::class, 'index'])
        ->name('applications.additional-info.index');
});

Route::get('/error/database', function () {
    return view('errors.database');
})->name('error.database');

Route::middleware(['auth'])->group(function () {
 
    // INSTITUTION Application
    Route::post('/applications/institution/store', 
        [ApplicationController::class, 'storeInstitution']
    )->name('application.institution.store');

  Route::get('institution-applicants/{id}/download', [PersonalInformationController::class, 'downloadPDF'])
     ->name('institution-applicants.download');

});

