@extends('admin-dashboard')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="text-center mb-5">
        <h2 class="fw-bold text-uppercase" style="color:#52074f;">NCHE Admin Dashboard</h2>
        <p class="text-muted">Summary of application activity and validation status</p>
        <hr class="mx-auto" style="width:120px; border:2px solid #dd8027;">
    </div>

    <!-- Stat Cards -->
    <div class="row g-4 justify-content-center">
        <!-- New Applications -->
        <div class="col-lg-3 col-md-6">
            <div class="card stat-card shadow-lg border-0 text-center">
                <div class="card-body">
                    <i class="bi bi-file-earmark-plus fs-1 text-nche-purple"></i>
                    <h5 class="mt-3 text-muted">New This Week</h5>
                    <h1 class="fw-bold text-dark">{{ $newApplications }}</h1>
                </div>
            </div>
        </div>

        <!-- Completed -->
        <div class="col-lg-3 col-md-6">
            <div class="card stat-card shadow-lg border-0 text-center">
                <div class="card-body">
                    <i class="bi bi-check2-square fs-1 text-nche-orange"></i>
                    <h5 class="mt-3 text-muted">Completed</h5>
                    <h1 class="fw-bold text-dark">{{ $completedApplications }}</h1>
                </div>
            </div>
        </div>

        <!-- Validated -->
        <div class="col-lg-3 col-md-6">
            <div class="card stat-card shadow-lg border-0 text-center">
                <div class="card-body">
                    <i class="bi bi-patch-check fs-1 text-success"></i>
                    <h5 class="mt-3 text-muted">Validated This Month</h5>
                    <h1 class="fw-bold text-dark">{{ $approvedApplications }}</h1>
                </div>
            </div>
        </div>
<div class="col-lg-3 col-md-6">
    <div class="card stat-card shadow-lg border-0 text-center">
        <div class="card-body">
            <i class="bi bi-x-octagon fs-1 text-danger"></i>
            <h5 class="mt-3 text-muted">Unrecognised This Month</h5>
            <h1 class="fw-bold text-dark">{{ $rejectedApplications }}</h1>
        </div>
    </div>
</div>

            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="card mt-5 border-0 shadow-sm">
        <div class="card-body">
            <h5 class="mb-3 fw-semibold" style="color:#52074f;">Application Summary Chart</h5>
            <canvas id="applicationsChart" height="100"></canvas>
        </div>
    </div>

</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('applicationsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['New This Week', 'Completed', 'Validated', 'Unrecognised'],
            datasets: [{
                label: 'Applications Count',
                data: [
                    {{ $newApplications }},
                    {{ $completedApplications }},
                    {{ $approvedApplications }},
                    {{ $rejectedApplications }}
                ],
                backgroundColor: [
                    '#52074f',
                    '#dd8027',
                    '#28a745',
                    '#dc3545'
                ],
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { backgroundColor: '#52074f' }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { color: '#333' },
                    grid: { color: '#eee' }
                },
                x: {
                    ticks: { color: '#52074f' },
                    grid: { display: false }
                }
            }
        }
    });
});
</script>

<style>
/* === NCHE Dashboard Theme === */
.text-nche-purple { color: #52074f !important; }
.text-nche-orange { color: #dd8027 !important; }

.stat-card {
    border-radius: 18px;
    transition: all 0.3s ease;
    padding: 1rem 0.5rem;
}
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.1);
}
.stat-card h1 {
    font-size: 2.8rem;
}
</style>
@endsection
