<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>NCHE - FAQ</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f6f6fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .header {
            background: linear-gradient(135deg, #52074f, #dd8027);
            color: white;
            padding: 6rem 1rem;
            text-align: center;
            border-radius: 0 0 30px 30px;
            margin-bottom: 2rem;
        }
        .header h1 {
            font-weight: 700;
            letter-spacing: 1.2px;
        }
        .accordion-button {
            background-color: #52074f;
            color: white;
            font-weight: 600;
        }
        .accordion-button:not(.collapsed) {
            background-color: #dd8027;
            color: white;
            box-shadow: none;
        }
        h2{
            color: white;
        }
        .accordion-body {
            background-color: #fff3e6;
            color: #333;
        }
        .faq-icon {
            color: #dd8027;
            margin-right: 10px;
        }
        footer {
            text-align: center;
            margin-top: 4rem;
            color: #666;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <section class="header" >
        <h1><i class="bi bi-question-circle-fill faq-icon"></i> NCHE FAQ</h1>
        <p>Your Questions About Qualification Verification — Answered</p>
    </section>

   <div class="container my-5" style="max-width: 950px; font-family: 'Segoe UI', sans-serif;">
    <h2 class="mb-4" style="color:#52074f;">
        <i class="mdi mdi-help-circle-outline text-warning" style="font-size:1.8rem; vertical-align:middle;"></i>
        Frequently Asked Questions (FAQ)
    </h2>

    {{-- Search Bar --}}
    <div class="input-group mb-4 shadow-sm">
        <span class="input-group-text bg-white border-end-0">
            <i class="mdi mdi-magnify text-secondary"></i>
        </span>
        <input type="text" id="faq-search" class="form-control border-start-0" placeholder="Search questions...">
    </div>

    {{-- Accordion --}}
    <div class="accordion" id="faqAccordion">
        @php
            $faqs = [
                ['q' => 'What is the NCHE Qualifications Recognition & Verification system?', 'a' => 'It is an online platform that allows individuals to apply for the evaluation and verification of their academic qualifications to ensure their recognition within Malawi’s education system.'],
                ['q' => 'Who can lodge an application?', 'a' => 'Any person who wishes to have their foreign or local qualifications evaluated and recognized by NCHE can lodge an application using the approved form.'],
                ['q' => 'What documents are required for an application?', 'a' => 'Applicants must submit certified copies of their certificates or diplomas, official transcripts, and any previous evaluation reports if available. Doctorate and Master’s degree applicants have additional document requirements.'],
                ['q' => 'How long does the evaluation process take?', 'a' => 'Standard processing usually takes up to 21 working days, while express applications can be processed within 10 working days, depending on the completeness of the application.'],
                ['q' => 'What happens if I submit forged or altered documents?', 'a' => 'NCHE will not process applications with forged or falsified documents and reserves the right to report such cases to relevant authorities.'],
                ['q' => 'Can I get a copy of my evaluation report?', 'a' => 'Yes, the evaluation report is issued to the applicant. Certified copies can be provided to third parties upon request and payment.'],
                ['q' => 'What are the fees for the evaluation service?', 'a' => 'Fees depend on the applicant’s nationality and processing type: Normal processing is MK 75,000 for locals and US$150 for foreigners. Express processing is MK 112,500 for locals and US$225 for foreigners.'],
                ['q' => 'How do I pay the evaluation fees?', 'a' => 'Payments can be made through various methods including PayChangu, Mpamba, Airtel Money, or bank deposit. Upload proof of payment where required.'],
                ['q' => 'How can I track the status of my application?', 'a' => 'Applicants are responsible for following up on their application status via the online portal or by contacting the Evaluation Division.'],
                ['q' => 'Who can I contact for support or inquiries?', 'a' => 'For any questions, contact the Evaluation Division at verification@nche.ac.mw or visit NCHE offices during working hours.'],
                ['q' => 'What is the timeline for application processing?', 'a' => 'Applications are ordinarily processed within 21 working days. Urgent applications may be processed within 10 working days. However, some delays may occur due to unforeseen circumstances.'],
                ['q' => 'What happens if my application is incomplete?', 'a' => 'Incomplete or incorrect applications will not be processed. Additional information will be requested before evaluation begins.'],
                ['q' => 'Can I submit documents in languages other than English?', 'a' => 'All foreign language documents must be accompanied by certified English translations prepared by a sworn translator.'],
                ['q' => 'Are there additional document requirements for higher qualifications?', 'a' => 'Yes, Doctorate, Master’s degree, and Postgraduate diploma applicants must submit additional documents such as theses and transcripts.'],
                ['q' => 'Can the evaluation report be shared with other parties?', 'a' => 'A certified copy of the evaluation report may be issued to another party if specifically requested and paid for by the applicant.'],
                ['q' => 'What if I want my evaluation result emailed or collected personally?', 'a' => 'Evaluation results can be delivered according to your instruction by email or personal collection.'],
                ['q' => 'Are the evaluation results binding on institutions?', 'a' => 'No, the evaluation outcome is based on the best available information and is not binding on any institution or registration body.'],
                ['q' => 'What should I do if my name has changed?', 'a' => 'You must provide proof of any name change along with your application documents.'],
                ['q' => 'Do I need to follow up on the status of my application?', 'a' => 'Yes, applicants are responsible for following up on their application status.'],
                ['q' => 'What should I do if I have questions during the application process?', 'a' => 'You can contact the Evaluation Division by email at verification@nche.ac.mw or visit the NCHE office during working hours.'],
                ['q' => 'What are the NCHE bank account details for payments?', 'a' => 'Bank Name: NBS Bank<br>Branch: Lilongwe<br>Account Name: NCHE Service Fees<br>Account Number: 14416177<br>SWIFT CODE: NBSMWMW.'],
            ];
        @endphp

        @foreach($faqs as $index => $faq)
            <div class="accordion-item mb-2 faq-item">
                <h2 class="accordion-header" id="heading{{ $index }}">
                    <button class="accordion-button collapsed fw-bold text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}">
                        <i class="mdi mdi-chevron-down-circle-outline me-2 text-warning"></i> {{ $faq['q'] }}
                    </button>
                </h2>
                <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#faqAccordion">
                    <div class="accordion-body" style="line-height: 1.6;">
                        {!! nl2br(e($faq['a'])) !!}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- Include required scripts --}}
<link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('faq-search').addEventListener('input', function () {
        const query = this.value.toLowerCase();
        document.querySelectorAll('.faq-item').forEach(function (item) {
            const question = item.querySelector('.accordion-button').textContent.toLowerCase();
            const answer = item.querySelector('.accordion-body').textContent.toLowerCase();
            if (question.includes(query) || answer.includes(query)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });
</script>


    <footer class="mt-5 mb-3">
        &copy; {{ date('Y') }} National Council for Higher Education - Malawi
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</body>
</html>
