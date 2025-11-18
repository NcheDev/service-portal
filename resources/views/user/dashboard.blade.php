@extends('layouts.user-dashboard')
@section('content')
<div class="container py-5">

    <!-- Hero Section -->
    <div class="card shadow-lg mb-5 text-center p-5 hero-card">
        <h3 class="fw-bold mb-3">Welcome           <span>{{ Auth::user()->name }}</span>
 to the Certificate Verification Portal!</h3>
        <p class="mb-0">Apply, submit information, and track your certificate verification status in a few easy steps.</p>
    </div>

    <!-- Applications Overview Cards -->
    <div class="mb-5">
        <h4 class="mb-4 text-center fw-bold">My Applications Overview</h4>
        <div class="row g-4 text-center">

            <!-- All Applications -->
            <div class="col-md-3 mx-auto">
                <div class="card stats-card shadow-sm p-4 h-100">
                    <i class="mdi mdi-file-document-outline text-primary mb-3"></i>
                    <h5 class="fw-bold">All Applications</h5>
                    <p class="fs-4 mb-0">{{ $allApplications ?? 0 }}</p>
                </div>
            </div>

            <!-- Approved Applications -->
            <div class="col-md-3 mx-auto">
                <div class="card stats-card shadow-sm p-4 h-100">
                    <i class="mdi mdi-checkbox-marked-circle-outline text-success mb-3"></i>
                    <h5 class="fw-bold">Approved</h5>
                    <p class="fs-4 mb-0">{{ $approvedApplications ?? 0 }}</p>
                </div>
            </div>

            <!-- Pending Applications -->
            <div class="col-md-3 mx-auto">
                <div class="card stats-card shadow-sm p-4 h-100">
                    <i class="mdi mdi-timer-sand text-warning mb-3"></i>
                    <h5 class="fw-bold">Pending</h5>
                    <p class="fs-4 mb-0">{{ $pendingApplications ?? 0 }}</p>
                </div>
            </div>

            <!-- Rejected / Unrecognized Applications -->
            <div class="col-md-3 mx-auto">
                <div class="card stats-card shadow-sm p-4 h-100">
                    <i class="mdi mdi-close-circle-outline text-danger mb-3"></i>
                    <h5 class="fw-bold">Rejected / Unrecognized</h5>
                    <p class="fs-4 mb-0">{{ $rejectedApplications ?? 0 }}</p>
                </div>
            </div>

        </div>
    </div>

    <!-- How to Use Section (unchanged) -->
    <div class="mb-5">
        <h4 class="mb-4 text-center fw-bold">How to Use the System</h4>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card step-card shadow-sm p-4 text-center h-100">
                    <i class="mdi mdi-file-document-outline text-primary mb-3"></i>
                    <h6 class="fw-bold">Step 1: Submit Application</h6>
                    <p class="text-muted small">Fill in your personal and academic information to create a new application easily.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card step-card shadow-sm p-4 text-center h-100">
                    <i class="mdi mdi-email-outline text-success mb-3"></i>
                    <h6 class="fw-bold">Step 2: Receive Confirmation</h6>
                    <p class="text-muted small">You will get an email confirming your submission and providing next steps.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card step-card shadow-sm p-4 text-center h-100">
                    <i class="mdi mdi-monitor-eye text-warning mb-3"></i>
                    <h6 class="fw-bold">Step 3: Check Status</h6>
                    <p class="text-muted small">Log into the portal to track your application progress and certificate verification results.</p>
                </div>
            </div>
        </div><br>
        
        <!-- Reminder Section -->
        <div class="card reminder-card shadow-sm p-3 text-center">
            <p class="mb-0">💡 <strong>Reminder:</strong> After processing, you will receive an email with your results. Always log in to the portal to view the latest updates.</p>
        </div>
    </div>

</div>

{{-- Styles --}}
<style>
.hero-card {
    background: linear-gradient(135deg, #52074f, #dd8027);
    color: #fff;
    border-radius: 1rem;
    overflow: hidden;
}
.hero-card h3 { font-size: 2.2rem; }
.hero-card p { font-size: 1.1rem; }

/* Application Stats Cards */
.stats-card {
    background-color: #fff;
    border-radius: 1rem;
    transition: transform 0.3s, box-shadow 0.3s;
    padding: 2rem 1rem;
}
.stats-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
}
.stats-card i { font-size: 2rem; }

/* Step Cards */
.step-card { border-radius: 1rem; transition: transform 0.3s, box-shadow 0.3s; }
.step-card:hover { transform: translateY(-8px); box-shadow: 0 10px 25px rgba(0,0,0,0.2); }
.step-card i { font-size: 2rem; }

/* Reminder Card */
.reminder-card {
    background: #fff3cd;
    border-left: 5px solid #ffc107;
    font-weight: 500;
}
</style>
<script>
    (function() {
        // Force the page to reload from server if user navigates back
        if (window.history && window.history.pushState) {
            window.history.pushState(null, null, window.location.href);
            window.onpopstate = function () {
                window.location.reload();
            };
        }
    })();
</script>

@endsection
