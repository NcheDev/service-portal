@extends('layouts.user-dashboard')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>NCHE - FAQ</title>
  <style>
    body {
      background-color: #f9fafc;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #333;
    }

    /* Hero Section */
    .header {
      background: linear-gradient(90deg, #52074f 0%, #6a1570 40%, #dd8027 100%);
      color: #fff;
      text-align: center;
      padding: 4rem 1rem 3rem;
      border-radius: 0 0 25px 25px;
      margin-bottom: 3rem;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .header h1 {
      font-size: 2.2rem;
      font-weight: 700;
      margin-bottom: 0.8rem;
      letter-spacing: 0.8px;
    }

    .header p {
      font-size: 1.05rem;
      opacity: 0.9;
      margin: 0;
    }

    /* Accordion */
    .accordion-button {
      background-color: #fff;
      color: #52074f;
      font-weight: 600;
      border: 1px solid #eee;
      transition: all 0.2s ease-in-out;
    }

    .accordion-button:not(.collapsed) {
      background-color: #dd8027;
      color: #fff;
      box-shadow: none;
    }

    .accordion-button:focus {
      box-shadow: 0 0 0 0.2rem rgba(221, 128, 39, 0.3);
    }

    .accordion-body {
      background-color: #fff;
      color: #444;
      line-height: 1.6;
      border-left: 3px solid #dd8027;
      border-radius: 0 0 10px 10px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .faq-icon {
      color: #ffc107;
      margin-right: 8px;
    }

    /* Search Bar */
    #faq-search {
      border-radius: 30px;
      padding: 0.6rem 1rem;
    }

    .input-group-text {
      border-radius: 30px 0 0 30px;
    }

    footer {
      text-align: center;
      margin-top: 4rem;
      color: #777;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
  <section class="header">
    <h1><i class="bi bi-question-circle-fill faq-icon"></i> NCHE Frequently Asked Questions</h1>
    <p>Your guide to understanding the Qualification Verification process</p>
  </section>

  <div class="container my-5" style="max-width: 950px;">
    <h2 class="mb-4" style="color:#52074f; font-weight:700;">
      <i class="mdi mdi-help-circle-outline text-warning me-1" style="font-size:1.8rem; vertical-align:middle;"></i>
      Frequently Asked Questions
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
          ['q' => 'What is the NCHE Qualifications Recognition & Verification system?', 'a' => 'It is an online platform ...'],
          ['q' => 'Who can lodge an application?', 'a' => 'Any person who wishes to have their ...'],
          ['q' => 'What documents are required?', 'a' => 'Applicants must submit certified copies ...'],
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
        <div class="accordion-item mb-3 faq-item">
          <h2 class="accordion-header" id="heading{{ $index }}">
            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse"
              data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}">
              <i class="mdi mdi-chevron-down-circle-outline me-2 text-warning"></i>
              {{ $faq['q'] }}
            </button>
          </h2>
          <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}"
            data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              {!! nl2br(e($faq['a'])) !!}
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  <footer>&copy; {{ date('Y') }} National Council for Higher Education - Malawi</footer>

  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.getElementById('faq-search').addEventListener('input', function () {
      const query = this.value.toLowerCase();
      document.querySelectorAll('.faq-item').forEach(function (item) {
        const question = item.querySelector('.accordion-button').textContent.toLowerCase();
        const answer = item.querySelector('.accordion-body').textContent.toLowerCase();
        item.style.display = (question.includes(query) || answer.includes(query)) ? '' : 'none';
      });
    });
  </script>
</body>
</html>
@endsection
