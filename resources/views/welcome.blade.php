<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Validation</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: #333;
        }

        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 60px 0;
        }

        .hero img {
            max-width: 100%;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .slider {
            position: relative;
        }

        .slide {
            display: none;
        }

        .slide.active {
            display: block;
            animation: fadeIn 1s ease-in-out;
        }

        .slide p {
            font-size: 1.6rem;
            font-weight: 500;
            color: #333;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .cta-buttons a {
            background-color: #dd8027;
            color: #fff;
            padding: 12px 24px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .cta-buttons a:hover {
            background-color: #b86d1e;
        }

        footer {
            text-align: center;
            padding: 15px 10px;
            font-size: 0.9rem;
            background: #f8f9fa;
            border-top: 1px solid #e5e5e5;
        }

        footer a {
            color: #52074f;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    @include("partials.header")

    <!-- Hero Section -->
    <section class="hero container">
        <div class="row align-items-center">
            <!-- Left Image -->
            <div class="col-lg-6 mb-4 mb-lg-0 text-center">
                <img src="/assets/images/slider/image1.jpg" alt="Certificate Validation">
            </div>

            <!-- Right Slider Content -->
            <div class="col-lg-6 text-center text-lg-start">
                <div class="slider mb-4">
                    <div class="slide active">
                        <p><strong>Welcome to the Certificate Validation Platform</strong></p>
                    </div>
                    <div class="slide">
                        <p>Upload your certificates for validation and track the status.</p>
                    </div>
                    <div class="slide">
                        <p>Secure and Transparent Verification Process</p>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <div class="d-flex justify-content-center justify-content-lg-start gap-3 cta-buttons">
                    <a href="/login">Upload Certificate</a>
                    <a href="/">Track Status</a>
                </div>
            </div>
        </div>
    </section>

    @include("partials.footer")

    <!-- Bootstrap + Slider Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Slider functionality
        const slides = document.querySelectorAll('.slide');
        let currentSlide = 0;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
            });
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        setInterval(nextSlide, 4000); // Auto slide every 4 seconds
    </script>
</body>
</html>
