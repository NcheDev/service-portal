@extends('layouts.user-dashboard')

@section('content')

<div class="container py-5">
<div class="d-flex justify-content-between align-items-center mb-4">
     
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
</div>

    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card shadow-lg border-0">

                {{-- Header --}}
                <div class="card-header text-white text-center py-3" style="background-color:#52074f;">
                    <h4 class="fw-bold mb-0">📤 Bulk Application Upload</h4>
                </div>

                <div class="card-body p-4">

                    {{-- Instructions --}}
                    <div class="mb-4 p-3 border rounded-4" style="background:#faf5fc;">
                        <h5 class="fw-bold" style="color:#52074f;">📘 Instructions</h5>
                        <ul class="small mt-3">
                            <li>Download the official CSV template below and save it on your device.</li>
                            <li>Fill in applicant details exactly as required.</li>
                            <li><strong>Do not change the column names in the first row.</strong></li>
                            <li>Ensure required fields are not left blank.</li>
                            <li>Use the correct formats for dates, numbers, and . Names as indicated on certificate.</li>
                            <li>Upload only <strong>.csv</strong> files.</li>
                            <li>You can view a sample CSV structure below for reference before uploading.</li>
                        </ul>

                        <div class="d-flex flex-wrap gap-2 mt-2">
                            <a href="{{ route('application.csv.template') }}" 
                               class="btn btn-sm text-white"
                               style="background-color:#52074f; border-radius:25px;">
                               📥 Download CSV Template
                            </a>

                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#csvExampleModal" style="border-radius:25px;">
                                👁️ View CSV Example
                            </button>
                        </div>
                    </div>

                    {{-- Error display --}}
                    @if(session('error'))
                        <div class="alert alert-danger">
                            <h6 class="fw-bold">⚠️ Errors Found:</h6>
                            <ul class="mb-0">
                                @foreach(session('error') as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Success message --}}
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- CSV Upload Form --}}
                    <form action="{{ route('application.bulk.upload') }}" 
                          method="POST" enctype="multipart/form-data" 
                          class="mt-3">
                        @csrf

                        <label class="fw-bold mb-2">Upload Applicants CSV</label>

                        <input type="file" 
                               name="applicants_csv" 
                               accept=".csv"
                               class="form-control mb-3" 
                               required>

                        <button type="submit" 
                                class="btn w-100 text-white"
                                style="background-color:#28a745; border-radius:25px;">
                            📤 Upload CSV
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

{{-- CSV Example Modal --}}
<div class="modal fade" id="csvExampleModal" tabindex="-1" aria-labelledby="csvExampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#52074f; color:white;">
                <h5 class="modal-title fw-bold" id="csvExampleModalLabel">📄 Sample CSV Structure</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">

                <p class="small mb-3">This is an example of how your CSV should look. You can copy or refer to this structure when filling your template.</p>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped small">
                        <thead style="background-color:#52074f; color:white;">
                            <tr>
                                <th>first_name</th>
                                <th>surname</th>
                                <th>nationality</th>
                                <th>processing_type</th>
                                <th>qualification_1_name</th>
                                <th>qualification_1_program_name</th>
                                <th>qualification_1_year</th>
                                <th>qualification_1_institution</th>
                                <th>qualification_1_merit</th>
                                <th>qualification_1_country</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>John</td>
                                <td>Doe</td>
                                <td>Malawian</td>
                                <td>Express</td>
                                <td>Bachelor of Science</td>
                                <td>Computer Science</td>
                                <td>2020</td>
                                <td>University of Malawi</td>
                                <td>First Class</td>
                                <td>Malawi</td>
                            </tr>
                            <tr>
                                <td>Jane</td>
                                <td>Smith</td>
                                <td>Kenyan</td>
                                <td>Normal</td>
                                <td>Master of Arts</td>
                                <td>Education</td>
                                <td>2019</td>
                                <td>Kenya University</td>
                                <td>Distinction</td>
                                <td>Kenya</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
