<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Payment Confirmation - BSSC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: #f0f4ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .thankyou-card {
            background: #ffffff;
            padding: 3rem 2.5rem;
            max-width: 480px;
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 6px 24px rgba(22, 66, 126, 0.12);
            text-align: center;
        }
        .thankyou-card h1 {
            font-size: 2.8rem;
            color: #16467f;
            margin-bottom: 0.6rem;
        }
        .thankyou-card p {
            font-size: 1.1rem;
            color: #3a3f58;
            margin-bottom: 1.8rem;
        }
        .thankyou-icon {
            font-size: 4.5rem;
            color: #28a745;
            margin-bottom: 1rem;
        }
        .btn-primary {
            background-color: #16467f;
            border-color: #16467f;
            font-size: 1.1rem;
            padding: 0.65rem 1.6rem;
            border-radius: 8px;
        }
        .btn-primary:hover {
            background-color: #0f2a54;
            border-color: #0f2a54;
        }
        .info-text {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="thankyou-card">
        <div class="thankyou-icon">&#10004;</div>
        <h1>Payment Successful!</h1>
        <p>Thank you for completing your payment for the BSSC application.</p>
        <p>Your application is now confirmed and being processed.</p>

        <a href="/" class="btn btn-primary">Go to Homepage</a>

        <div class="info-text mt-3">
            <p>If you have any questions or need support, please contact <a href="mailto:support@bssc.gov.in">support@bssc.gov.in</a>.</p>
        </div>
    </div>
</body>
</html>
