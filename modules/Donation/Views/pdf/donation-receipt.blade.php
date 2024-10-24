<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Donation Receipt</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        .header,
        .footer {
            text-align: center;
            margin: 20px;
        }

        .content {
            margin: 20px 40px;
        }

        .details {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }

        .details th,
        .details td {
            border: 1px solid #dddddd;
            padding: 8px;
        }

        .details th {
            background-color: #f2f2f2;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
        }

        .signature img {
            width: 150px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Organization Name</h1>
        <p>Organization Address</p>
        <p>Contact Information</p>
    </div>

    <div class="content">
        <h2>Donation Receipt</h2>

        <h3>Donor Information</h3>
        <p>
            {{ $donation->receipt_address['name'] }}<br />
            {{ $donation->receipt_address['address'] }} <br />
            {{ $donation->receipt_address['postal_code'] }} {{ $donation->receipt_address['city'] }} <br />
            {{ $donation->receipt_address['country'] }}
        </p>

        <h3>Donation Details</h3>
        <p><strong>Amount:</strong> {{ $donation->amount }}</p>
        <p><strong>Amount in words:</strong> {{ $donation->amount->toWords() }}</p>

        <p>Thank you for your generous donation. Your support helps us continue our mission.</p>

        <div class="signature">
            <p>______________________________</p>
            <p>Authorized Signature</p>
        </div>
    </div>

    <div class="footer">
        <p>Footer Text / Legal Information</p>
    </div>

</body>

</html>
