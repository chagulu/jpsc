<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Payment - BSSC Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e3effd 100%);
            font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
        }
        .form-card {
            background: #fff;
            box-shadow: 0 2px 32px rgba(44,104,162,0.10), 0 1.5px 8px rgba(44,73,104,0.10);
            border-radius: 15px;
            padding: 2.2rem 2.8rem;
            max-width: 440px;
            margin: 3.5rem auto 1rem auto;
        }
        .form-title {
            color: #174384;
            font-size: 1.65rem;
            font-weight: 700;
        }
        .or-divider {
            text-align: center;
            color: #b0b0b0;
            font-weight: 600;
            margin: 2.2em 0 1.6em 0;
            position: relative;
        }
        .or-divider:before, .or-divider:after {
            content: "";
            display: inline-block;
            width: 40%;
            height: 1px;
            background: #d0ddf5;
            vertical-align: middle;
            margin: 0 0.6em;
        }
        .btn-primary {
            background-color: #174384;
            border-color: #174384;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .btn-primary:hover {
            background-color: #11365f;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-card shadow">
            <div class="text-center">
                <img src="YOUR_LOGO_URL.png" alt="BSSC Logo" style="height: 43px;">
            </div>
            <h2 class="form-title text-center mt-2 mb-4">
                Pending Payment for Applicants
            </h2>
            <form action="/resume-payment" method="POST" autocomplete="off">
                <!-- Section 1: By Application ID -->
                <div class="mb-3">
                    <label class="form-label" for="application_id">Application ID</label>
                    <input type="text" class="form-control" id="application_id" name="application_id" maxlength="20" placeholder="Enter your Application ID">
                </div>

                <div class="or-divider">OR</div>

                <!-- Section 2: By Mobile & DOB -->
                <div class="mb-3">
                    <label class="form-label" for="mobile_no">Mobile Number</label>
                    <input type="text" class="form-control" id="mobile_no" name="mobile_no" maxlength="15" placeholder="Enter your registered mobile">
                </div>
                <div class="mb-4">
                    <label class="form-label" for="dob">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" name="dob" placeholder="YYYY-MM-DD">
                </div>

                <button type="submit" class="btn btn-primary w-100">Proceed to Payment</button>
            </form>
            <p class="text-center text-muted mt-4 mb-1" style="font-size:0.97rem">
                Only applicants who have applied but have not completed payment can use this portal.
            </p>
        </div>
    </div>
</body>
</html>
