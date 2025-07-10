<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Help - NCHE Qualifications System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #f6f6fb;
            font-family: 'Segoe UI', sans-serif;
            color: #333;
        }
        .help-header {
            background: linear-gradient(135deg, #52074f, #dd8027);
            color: white;
            padding: 3rem 1rem;
            text-align: center;
            border-radius: 0 0 30px 30px;
        }
        .help-header h1 {
            font-weight: 700;
        }
        .section-title {
            color: #52074f;
            font-weight: 600;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
        }
        .card-header {
            background-color: #dd8027;
            color: white;
            font-weight: 600;
        }
        .icon {
            color: #dd8027;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="help-header">
        <h1><i class="bi bi-info-circle-fill"></i> Help & Support</h1>
        <p>Need guidance? You’re in the right place.</p>
    </div>

    <div class="container my-5" style="max-width: 950px;">
        {{-- Getting Started --}}
        <div class="card">
            <div class="card-header"><i class="bi bi-play-circle icon"></i> Getting Started</div>
            <div class="card-body">
                <p>This system allows you to apply for verification or recognition of qualifications issued locally or abroad. Simply register, complete your profile, upload your documents, pay, and submit your application.</p>
            </div>
        </div>

        {{-- Application Guide --}}
        <div class="card">
            <div class="card-header"><i class="bi bi-list-ol icon"></i> Step-by-Step Guide</div>
            <div class="card-body">
                <ol>
                    <li>Register or log in to your NCHE account.</li>
                    <li>Fill out your personal and contact information.</li>
                    <li>Add qualification details and upload all required documents.</li>
                    <li>Choose normal or express processing.</li>
                    <li>Make your payment and upload proof.</li>
                    <li>Submit the application and wait for email or portal update.</li>
                </ol>
            </div>
        </div>

        {{-- Required Documents --}}
        <div class="card">
            <div class="card-header"><i class="bi bi-journal-check icon"></i> Required Documents</div>
            <div class="card-body">
                <ul>
                    <li>Certificate or diploma (certified copy)</li>
                    <li>Official transcript or academic record</li>
                    <li>Thesis (for postgraduate)</li>
                    <li>English translations for non-English documents</li>
                    <li>ID or Passport</li>
                    <li>Proof of name change (if applicable)</li>
                </ul>
            </div>
        </div>

        {{-- Payments --}}
        <div class="card">
            <div class="card-header"><i class="bi bi-credit-card icon"></i> Payment Information</div>
            <div class="card-body">
                <p><strong>Normal:</strong> MWK 75,000 (locals) / USD 150 (foreigners)</p>
                <p><strong>Express:</strong> MWK 112,500 (locals) / USD 225 (foreigners)</p>
                <p>Pay via PayChangu, Airtel Money, Mpamba, or bank deposit. Then upload your proof of payment.</p>
            </div>
        </div>

        {{-- Status Tracking --}}
        <div class="card">
            <div class="card-header"><i class="bi bi-search icon"></i> Tracking Application Status</div>
            <div class="card-body">
                <p>Track your application through your dashboard. Statuses include:</p>
                <ul>
                    <li><strong>Pending</strong>: Awaiting review</li>
                    <li><strong>Validated</strong>: Recognized qualification</li>
                    <li><strong>Invalid</strong>: Not recognized or more info required</li>
                </ul>
            </div>
        </div>

        {{-- Contact --}}
        <div class="card">
            <div class="card-header"><i class="bi bi-envelope-open icon"></i> Need More Help?</div>
            <div class="card-body">
                <p>📧 Email: <a href="mailto:verification@nche.ac.mw">verification@nche.ac.mw</a></p>
                <p>📍 Visit: NCHE Offices, Lilongwe</p>
                <p>📞 Phone: +265 1 755 884</p>
                <p>📁 You can also visit our    <a href="{{ route('faq') }}" class="ajax-link text-decoration-underline" style="color: #52074f;">
  <i class="mdi mdi-help-circle-outline me-1"></i>
  FAQ Section
</a>
for more answers.</p>
            </div>
        </div>
    </div>

    <footer class="text-center mt-5 mb-4 text-muted small">
        &copy; {{ date('Y') }} National Council for Higher Education, Malawi
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
<script>
  $('.nav-link-help').on('click', function (e) {
    e.preventDefault();
    $.get('/help', function (response) {
        $('.main-panel').html(response);
    });
});

</script>
</body>
</html>
