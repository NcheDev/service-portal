<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Validation</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: white;
        }

        .hero {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            padding: 20px;
            gap: 40px;
        }

        .hero-image {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .slider {
            flex: 1;
            font-size: 1.5em;
            max-width: 600px;
            position: relative;
        }

        .slide {
            display: none;
        }

        .slide.active {
            display: block;
        }

        .slide p {
            font-size: 2em;
            color: #333;
        }

        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .cta-button {
            background-color: #dd8027;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            font-size: 1.2em;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .cta-button:hover {
            background-color: #b86d1e;
        }

        footer {
            text-align: center;
            padding: 10px;
            font-size: 0.8em;
        }

        footer a {
            color: #333;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    @include("partials.header")

    <section class="hero">
        <div class="hero-image">
            <img src="/assets/images/slider/image1.jpg" alt="Hero Image">
        </div>

        <div class="slider">
            <div class="slide active">
                <p><strong>Welcome to the Certificate Validation Platform</strong></p>
            </div>
            <div class="slide">
                <p>Upload your certificates for validation and track the status.</p>
            </div>
            <div class="slide">
                <p>Secure and Transparent Verification Process</p>
            </div>

            <div class="cta-buttons">
                <a href="/login" class="cta-button">Upload Certificate</a>
                <a href="/" class="cta-button">Track Status</a>
            </div>
        </div>
    </section>

    @include("partials.footer")

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

        setInterval(nextSlide, 4000); // Change slide every 4 seconds
    </script>
</body>
</html>
