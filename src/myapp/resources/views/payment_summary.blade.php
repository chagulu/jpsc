<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>BSSC Payment Summary</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #f8fafc 0%, #e3effd 100%);
      font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
    }
    .bssc-header {
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(44,104,162,0.11);
      padding: 14px 20px;
      margin-bottom: 1.5rem;
    }
    .bssc-header img {
      height: 100px;
      width: 100px;
      object-fit: contain;
      margin-right: 20px;
    }
    .notice-board {
      background: #16467f;
      color: #fff;
      font-weight: bold;
      padding: 12px 0;
      letter-spacing: 1px;
      font-size: 1.05rem;
      border-bottom: 2px solid #0d2d53;
      margin-bottom: 0.7rem;
    }
    .marquee {
      white-space: nowrap;
      overflow: hidden;
      box-sizing: border-box;
    }
    .marquee span {
      display: inline-block;
      padding-left: 100%;
      animation: marquee 16s linear infinite;
    }
    @keyframes marquee {
      0%   { transform: translate(0, 0); }
      100% { transform: translate(-100%, 0); }
    }
    .summary-card {
      background: #fff;
      box-shadow: 0 2px 32px rgba(44,104,162,0.10), 0 1.5px 8px rgba(44,73,104,0.10);
      border-radius: 15px;
      padding: 2rem 2.5rem;
      max-width: 720px;
      margin: 2rem auto;
    }
    .summary-title {
      color: #16467f;
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
      text-align: center;
    }
    .btn-primary {
      background-color: #16467f;
      border-color: #16467f;
    }
    .btn-primary:hover {
      background-color: #11365f;
    }
    .row-label {
      font-weight: 600;
      color: #2a2a2a;
    }
    .amount {
      font-weight: 600;
      color: #16467f;
    }
  </style>
</head>
<body>
  <div class="container">

    <!-- Header -->
    <div class="bssc-header d-flex align-items-center shadow-sm">
      <img src="https://saraltyping.com/wp-content/uploads/2021/08/bihar-ssc-logo-1-1.webp" alt="BSSC Logo">
      <div class="flex-grow-1 text-center">
        <div style="font-size: 1.15rem; font-weight: 700; color: #1b3869;">Bihar Staff Selection Commission</div>
        <div style="font-size: 0.98rem; color: #313131;">P.O.-VETERINARY COLLEGE, PATNA - 800014</div>
        <div style="font-size: 0.93rem; color: #38406f;">Adv No.-05/25, 4th Graduate Level Combined Competitive Exam</div>
        <div style="font-size: 0.93rem; color: #3b525e;">चतुर्थ स्नातक स्तरीय संयुक्त प्रतियोगिता परीक्षा</div>
      </div>
    </div>

    <!-- Notice -->
    <div class="notice-board">
      <div class="marquee">
        <span>सभी आवेदकों को सूचित किया जाता है कि ऑनलाइन आवेदन प्रक्रिया 5 अक्टूबर 2025 तक खुली रहेगी | कृपया आगे की सूचना एवं अपडेट्स के लिए इस नोटिस बोर्ड पर ध्यान दें | For assistance, contact support@bssc.gov.in.</span>
      </div>
    </div>

    <!-- Payment Summary Card -->
    <div class="summary-card">
      <h2 class="summary-title">Payment Summary</h2>

      <div class="row mb-3">
        <div class="col-6 row-label">Application ID:</div>
        <div class="col-6 text-end">APP2025-001</div>
      </div>
      <div class="row mb-3">
        <div class="col-6 row-label">Applicant Name:</div>
        <div class="col-6 text-end">Rahul Kumar</div>
      </div>
      <div class="row mb-3">
        <div class="col-6 row-label">Mobile:</div>
        <div class="col-6 text-end">9876543210</div>
      </div>
      <div class="row mb-3">
        <div class="col-6 row-label">Email:</div>
        <div class="col-6 text-end">rahul@example.com</div>
      </div>
      <hr>
      <div class="row mb-3">
        <div class="col-6 row-label">Base Fee:</div>
        <div class="col-6 text-end amount">₹1,000.00</div>
      </div>
      <div class="row mb-3">
        <div class="col-6 row-label">GST (18%):</div>
        <div class="col-6 text-end amount">₹180.00</div>
      </div>
      <div class="row mb-3">
        <div class="col-6 row-label">Total Payable:</div>
        <div class="col-6 text-end amount fs-5">₹1,180.00</div>
      </div>

      <div class="alert alert-info mt-4">
        Verify your details before proceeding. Once you proceed, you will be redirected to the secure Paytm payment page.
      </div>

      <div class="d-grid">
        <button class="btn btn-primary btn-lg">Proceed to Pay</button>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
