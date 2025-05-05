<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qualification Verification Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #F9F9F9;
            padding: 30px;
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            max-width: 800px;
            margin: auto;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #5C3D7D;
            font-size: 1.8rem;
            margin-bottom: 25px;
        }

        label {
            font-weight: bold;
            color: #5C3D7D;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin-top: 8px;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: #5C3D7D;
            box-shadow: 0 0 5px rgba(92, 61, 125, 0.4);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-check-label {
            margin-left: 10px;
            font-size: 1rem;
        }

        .docs-section {
            margin-top: 30px;
        }

        .btn-primary {
            background-color: #5C3D7D;
            border-color: #5C3D7D;
            padding: 10px 20px;
            font-size: 1rem;
            width: 100%;
            border-radius: 6px;
        }

        .btn-primary:hover {
            background-color: #9274a6;
            border-color: #9274a6;
        }

        .success {
            color: green;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .error {
            color: red;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .hidden {
            display: none;
        }

        .form-check-input {
            margin-top: 8px;
        }

        .form-check {
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Qualification Verification Form</h2>

    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p class="error">{{ session('error') }}</p>
    @endif

    <form action="{{ route('register1.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Full Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email Address:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" class="form-control" required pattern="^\+?[0-9]{10,15}$" title="Phone number should be 10 to 15 digits long.">
        </div>

        <div class="form-group">
            <label for="address">Physical Address:</label>
            <input type="text" name="address" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="qualification_level">Qualification Level:</label>
            <select name="qualification_level" id="qualification_level" class="form-control" required onchange="showDocuments()">
                <option value="">-- Select Level --</option>
                <option value="doctorate">Doctorate</option>
                <option value="masters">Master's Degree</option>
                <option value="postgraduate_diploma">Postgraduate Diploma</option>
                <option value="bachelors">Bachelor's Degree</option>
                <option value="diploma">Diploma</option>
                <option value="other">Other</option>
            </select>
        </div>

        <div id="otherField" class="form-group hidden">
            <label>Specify Other Qualification:</label>
            <input type="text" name="other_qualification" class="form-control">
        </div>

        <div id="documents" class="docs-section"></div>

        <div class="form-group">
            <label for="national_id_or_passport">Upload National ID or Passport:</label>
            <input type="file" name="national_id_or_passport" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Choose Processing Option:</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_option" value="normal" id="normalProcessing" required>
                <label class="form-check-label" for="normalProcessing">
                    Normal Processing (Locals: MK 75,000, Foreigners: US$ 150)
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_option" value="express" id="expressProcessing">
                <label class="form-check-label" for="expressProcessing">
                    Express Processing (Locals: MK 112,500, Foreigners: US$ 225)
                </label>
            </div>
        </div>

        <div class="form-group">
            <label for="payment_proof">Upload Proof of Payment:</label>
            <input type="file" name="payment_proof" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
    function showDocuments() {
        const level = document.getElementById('qualification_level').value;
        const docsDiv = document.getElementById('documents');
        const otherField = document.getElementById('otherField');
        docsDiv.innerHTML = '';
        otherField.classList.toggle('hidden', level !== 'other');

        const fileInput = (label) =>
            `<div class="form-group">
                <label>${label}:</label>
                <input type="file" name="documents[]" class="form-control" required>
            </div>`;

        if (level === 'doctorate') {
            docsDiv.innerHTML =
                fileInput('Doctorate Certificate & Transcripts') +
                fileInput('Doctorate Thesis') +
                fileInput('Master’s Degree Certificate & Transcripts') +
                fileInput('Master’s Degree Thesis') +
                fileInput('Bachelor’s Degree Certificate');
        } else if (level === 'masters') {
            docsDiv.innerHTML =
                fileInput('Master’s Degree Certificate & Transcripts') +
                fileInput('Master’s Thesis') +
                fileInput('Bachelor’s Degree Certificate');
        } else if (level === 'postgraduate_diploma') {
            docsDiv.innerHTML =
                fileInput('Postgraduate Diploma Certificate & Transcripts') +
                fileInput('Diploma Certificate') +
                fileInput('Bachelor’s Degree Certificate');
        } else if (level === 'bachelors') {
            docsDiv.innerHTML =
                fileInput('Bachelor’s Degree Certificate') +
                fileInput('Bachelor’s Degree Transcripts');
        } else if (level === 'diploma') {
            docsDiv.innerHTML =
                fileInput('Diploma Certificate & Transcripts') +
                fileInput('Secondary School Certificate');
        }
    }
</script>

</body>
</html>
