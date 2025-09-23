<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Welcome Dashboard</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    
    <!-- Material Design Icons -->
    <link href="https://cdn.materialdesignicons.com/6.6.96/css/materialdesignicons.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        /* Hero Section */
        .hero-card {
            background: linear-gradient(135deg, #52074f, #dd8027);
            color: #fff;
            border-radius: 1rem;
            overflow: hidden;
        }
        .hero-card h3 {
            font-size: 2rem;
        }
        .hero-card p {
            font-size: 1rem;
        }

        /* Step Cards */
        .step-card {
            border-radius: 1rem;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .step-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .step-card i {
            font-size: 2rem;
        }

        /* Reminder Card */
        .reminder-card {
            background: #fff3cd;
            border-left: 5px solid #ffc107;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="container py-5">
<!-- Hero Section -->
<div class="card shadow-lg mb-5 text-center p-5" style="border-radius: 1rem; background: linear-gradient(135deg, #6f1d8b, #f28c38); color: #fff;">
    <h3 class="fw-bold mb-3" style="font-size: 2.2rem;">Welcome to the Certificate Portal!</h3>
    <p class="mb-0" style="font-size: 1.1rem;">Apply, submit information, and track your certificate verification status in a few easy steps.</p>
</div>


    <!-- How to Use Section -->
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
        </div>
    </div>

    <!-- Reminder Section -->
    <div class="card reminder-card shadow-sm p-3 text-center">
        <p class="mb-0">💡 <strong>Reminder:</strong> After processing, you will receive an email with your results. Always log in to the portal to view the latest updates.</p>
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
