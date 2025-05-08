<form id="qualificationForm" enctype="multipart/form-data">
    @csrf
    <h2>Qualification Verification Application</h2>

    <div>
        <label>Full Name:</label>
        <input type="text" name="full_name" required>
    </div>

    <div>
        <label>Email:</label>
        <input type="email" name="email" required>
    </div>

    <div>
        <label>Nationality:</label>
        <select name="nationality" required>
            <option value="">Select</option>
            <option value="local">Local (Malawian)</option>
            <option value="foreigner">Foreigner</option>
        </select>
    </div>

    <div>
        <label>Processing Type:</label>
        <select name="processing_type" id="processingType" required>
            <option value="">Select</option>
            <option value="normal">Normal</option>
            <option value="express">Express</option>
        </select>
    </div>
    <div id="processingTypeDetails" style="display: none; margin-top: 1em;">
        <p id="normalDetails" style="display: none;">Normal processed within 21 working days.<br>Locals (Malawian): MK 75,000</p>
        <p id="expressDetails" style="display: none;">Express processed within 10 working days.<br> Foreigner: US$ 150</p>
    </div>
    
    <div style="margin-top: 1em;">
        <label>Upload Proof of Payment:</label>
        <input type="file" name="payment_proof" required>
    </div>
    
    <div>
        <label>Qualification Level:</label>
        <select name="qualification_level" id="qualificationLevel" required>
            <option value="">Select</option>
            <option value="doctorate">Doctorate</option>
            <option value="masters">Master’s Degree</option>
            <option value="postgraduate_diploma">Postgraduate Diploma</option>
            <option value="bachelors">Bachelor’s Degree</option>
            <option value="diploma">Diploma</option>
        </select>
        <div id="requirementsSection" style="display: none; margin-top: 1em;">
            <p id="requirementsText" style="font-weight: bold;"></p>
        
            <label>Upload Required Documents:</label>
            <input type="file" name="qualification_documents[]" multiple required>
        </div>
        
    </div>

    <div id="requirementsSection" style="margin-top: 20px;"></div>

    <button type="submit">Submit Application</button>
</form>

<div id="responseMessage" style="margin-top: 20px;"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        const requirements = {
            doctorate: [
                "Doctorate certificates with transcripts",
                "Doctorate thesis",
                "All master’s degree verification documents"
            ],
            masters: [
                "Master’s Degree certificate with transcripts",
                "Master’s Degree thesis",
                "Bachelor’s Degree certificate or its equivalent"
            ],
            postgraduate_diploma: [
                "Postgraduate Diploma certificate with transcripts",
                "Diploma certificates or its equivalent",
                "Bachelor’s Degree certificates or its equivalent"
            ],
            bachelors: [
                "Bachelor’s Degree certificates or its equivalent",
                "Bachelor’s Degree transcripts"
            ],
            diploma: [
                "Diploma certificates and transcripts",
                "Secondary school level certificate or its equivalent"
            ]
        };

        $('#qualificationLevel').on('change', function () {
            const selected = $(this).val();
            const reqContainer = $('#requirementsSection');

            reqContainer.empty(); // Clear previous content

            if (requirements[selected]) {
                reqContainer.append(`<h4>Requirements for ${selected.replace('_', ' ').toUpperCase()}:</h4>`);

                requirements[selected].forEach((req, index) => {
                    const fieldName = selected + '_file_' + index;

                    reqContainer.append(`
                        <div style="margin-bottom: 10px;">
                            <label>${req}</label><br>
                            <input type="file" name="${fieldName}" required>
                        </div>
                    `);
                });

                // Show the section
                reqContainer.show();
            } else {
                reqContainer.hide();
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#processingType').on('change', function () {
            const selected = $(this).val();

            // Hide all first
            $('#processingTypeDetails').hide();
            $('#normalDetails').hide();
            $('#expressDetails').hide();

            if (selected === 'normal') {
                $('#processingTypeDetails').show();
                $('#normalDetails').show();
            } else if (selected === 'express') {
                $('#processingTypeDetails').show();
                $('#expressDetails').show();
            }
        });
    });
</script>
<style>
    body {
        background-color: #f8f4fb;
        font-family: 'Poppins', sans-serif;
        color: #333;
        padding: 2em;
    }

    #qualificationForm {
        background-color: #ffffff;
        border: 2px solid #52074f;
        border-radius: 16px;
        padding: 2em;
        max-width: 600px;
        margin: auto;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    #qualificationForm h2 {
        text-align: center;
        color: #52074f;
        font-size: 1.8em;
        margin-bottom: 1.5em;
    }

    #qualificationForm div {
        margin-bottom: 1.5em;
    }

    label {
        display: block;
        margin-bottom: 0.5em;
        color: #52074f;
        font-weight: 600;
    }

    input[type="text"],
    input[type="email"],
    select,
    input[type="file"] {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 1em;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    input:focus,
    select:focus {
        border-color: #dd8027;
        box-shadow: 0 0 0 3px rgba(221, 128, 39, 0.2);
        outline: none;
    }

    #processingTypeDetails p {
        background-color: #f9f1e6;
        border-left: 5px solid #dd8027;
        padding: 10px;
        border-radius: 6px;
        color: #333;
        font-size: 0.95em;
    }

    button, input[type="submit"] {
        background-color: #dd8027;
        color: #fff;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 1em;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button:hover,
    input[type="submit"]:hover {
        background-color: #c36d1f;
    }
</style>
