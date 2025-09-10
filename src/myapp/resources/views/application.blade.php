<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Candidate Application Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Times New Roman', serif;
      background: #fff;
      margin: 30px;
    }
    .header {
      text-align: center;
      margin-bottom: 20px;
    }
    .header img {
      max-height: 80px;
    }
    .form-title {
      font-size: 20px;
      font-weight: bold;
      margin-top: 10px;
      margin-bottom: 20px;
    }
    .table th {
      background: #f1f1f1;
    }
    .section-title {
      font-weight: bold;
      margin-top: 20px;
      margin-bottom: 10px;
      border-bottom: 1px solid #000;
      padding-bottom: 5px;
    }
    .signature-box {
      height: 60px;
      border: 1px dashed #000;
      margin-top: 20px;
      text-align: center;
      padding-top: 15px;
      font-style: italic;
    }
    .photo-box, .sign-box {
      border: 1px solid #000;
      width: 120px;
      height: 150px;
      text-align: center;
      font-size: 12px;
      line-height: 140px;
      margin-bottom: 10px;
    }
    .sign-box {
      height: 60px;
      line-height: 55px;
    }
    .barcode {
      text-align: center;
      margin-top: 10px;
    }
    .barcode img {
      max-width: 200px;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <div class="header">
    <img src="https://saraltyping.com/wp-content/uploads/2021/08/bihar-ssc-logo-1-1.webp" alt="BSSC Logo">
    <h4>Bihar Staff Selection Commission</h4>
    <p>P.O.- Veterinary College, Patna - 800014</p>
    <div class="form-title">Candidate Application Form</div>
  </div>

  <!-- Top Row with Photos & Barcode -->
  <div class="row mb-4">
    <div class="col-md-3 text-center">
      <div class="photo-box">Candidate Photo</div>
      <div class="sign-box">Signature</div>
    </div>
    <div class="col-md-6 text-center">
      <h5><b>Application No:</b> APP-2025-1234</h5>
      <div class="barcode">
        <img src="https://barcode.tec-it.com/barcode.ashx?data=APP-2025-1234&code=Code128&dpi=96" alt="Barcode">
      </div>
    </div>
    <div class="col-md-3"></div>
  </div>

  <!-- Candidate Details -->
  <div class="section-title">Candidate Details</div>
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th style="width: 30%;">Full Name</th>
        <td>BASANTA KUMAR SWAIN</td>
      </tr>
      <tr>
        <th>Date of Birth</th>
        <td>1994-01-01</td>
      </tr>
      <tr>
        <th>Gender</th>
        <td>Male</td>
      </tr>
      <tr>
        <th>Father's Name</th>
        <td>DEBENDRA</td>
      </tr>
      <tr>
        <th>Mother's Name</th>
        <td>SUKANTI</td>
      </tr>
      <tr>
        <th>Mobile Number</th>
        <td>9439971201</td>
      </tr>
      <tr>
        <th>Email ID</th>
        <td>arshad10@gmail.com</td>
      </tr>
      <tr>
        <th>Aadhaar Number</th>
        <td>899640301519</td>
      </tr>
      <tr>
        <th>Roll Number</th>
        <td>hjghjg5676</td>
      </tr>
    </tbody>
  </table>

  <!-- Address -->
  <div class="section-title">Address</div>
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th style="width: 30%;">Permanent Address</th>
        <td>Village XYZ, Block ABC, Patna, Bihar</td>
      </tr>
      <tr>
        <th>Correspondence Address</th>
        <td>Same as above</td>
      </tr>
    </tbody>
  </table>

  <!-- Declaration -->
  <div class="section-title">Declaration</div>
  <p>
    I hereby declare that the information furnished above is true and correct to the best of my knowledge. 
    I understand that if any information is found false at any stage, my candidature will be cancelled.
  </p>

  <!-- Signature Section -->
  <div class="row">
    <div class="col-md-6">
      <p>Date: ____________</p>
      <p>Place: ____________</p>
    </div>
    <div class="col-md-6 text-right">
      <div class="signature-box">Candidate Signature</div>
    </div>
  </div>

</body>
</html>
