@extends('layouts.user-dashboard')

@section('content')

    <div class="btn-group" role="group" aria-label="Application Actions">
        <a href="{{ route('application.select') }}" 
           class="btn btn-sm text-white" 
           style="background-color:#52074f; border-radius:25px;">
           ➕ New Application
        </a> 

        <a href="{{ route('applications.my') }}" 
           class="btn btn-sm btn-outline-warning" 
            style="background-color:#f99437; color:#52074f;  border-radius:25px;">
           📋View My Applications
        </a>
        <a href="{{ route('application.review') }}" 
   class="btn btn-sm text-white" 
   style="background-color:#52074f; border-radius:25px;">
   📋 View Uploaded CSV
</a>
      
    </div>
<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">

            <div class="card shadow-lg border-0">

                {{-- Header --}}
                <div class="card-header text-white text-center py-4"
                     style="background: linear-gradient(135deg, #52074f, #7a2e76);">
                    <h3 class="fw-bold mb-0">📄 Application Options</h3>
                    <p class="mb-0 small opacity-75">Choose how you want to submit applications</p>
                </div>

                <div class="card-body p-4">

                    <div class="row g-4">

                        {{-- Single Application --}}
                        <div class="col-md-6">
                            <div class="option-card p-4 rounded-4 text-center shadow-sm border h-100"
                                style="transition: .3s;">
                                
                                <div class="mb-3">
                                    <span style="font-size:40px; color:#52074f;">🧍‍♂️</span>
                                </div>

                                <h5 class="fw-bold mb-2" style="color:#52074f;">Single Application</h5>
                                <p class="small mb-4">
                                    Fill out the form to submit <strong>one applicant</strong>.
                                </p>

                                <a href="{{ route('application.create') }}"
                                    class="btn w-100 text-white fw-semibold"
                                    style="background-color:#52074f; border-radius:25px;">
                                    ➕ Create Single
                                </a>
                            </div>
                        </div>

                        {{-- Bulk CSV Upload --}}
                        <div class="col-md-6">
                            <div class="option-card p-4 rounded-4 text-center shadow-sm border h-100"
                                style="transition: .3s;">
                                
                                <div class="mb-3">
                                    <span style="font-size:40px; color:#bd8c0e;">📤</span>
                                </div>

                                <h5 class="fw-bold mb-2" style="color:#52074f;">Bulk Upload (CSV)</h5>
                                <p class="small mb-4">
                                    Upload a CSV file to submit <strong>multiple applicants</strong>.
                                </p>

                                <a href="{{ route('application.bulk.upload.page') }}"
                                   class="btn text-white fw-semibold w-100"
                                   style="background-color:#bd8c0e; border-radius:25px;">
                                    📥 Bulk Upload
                                </a>
                            </div>
                        </div>

                    </div> {{-- row end --}}
                </div>
            </div>

        </div>
    </div>

</div>

{{-- Hover effect --}}
<style>
    .option-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(82, 7, 79, 0.18);
        border-color: #52074f !important;
    }
</style>
@endsection
