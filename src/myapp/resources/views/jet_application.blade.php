{{-- resources/views/jet_application.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>BSSC Application Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
      body{background:linear-gradient(135deg,#f8fafc 0%,#e3effd 100%);font-family:'Segoe UI','Roboto',Arial,sans-serif;}
      .bssc-header{background:#fff;border-radius:8px;box-shadow:0 2px 10px rgba(44,104,162,.11);padding:14px 20px;margin-bottom:1.5rem;}
      .bssc-header img{height:100px;width:100px;object-fit:contain;margin-right:20px;}
      .notice-board{background:#16467f;color:#fff;font-weight:700;padding:12px 0;font-size:1.05rem;margin-bottom:.7rem;}
      .marquee{white-space:nowrap;overflow:hidden;box-sizing:border-box;}
      .marquee span{display:inline-block;padding-left:100%;animation:marquee 16s linear infinite;}
      @keyframes marquee{0%{transform:translate(0,0);}100%{transform:translate(-100%,0);}}
      .form-card{background:#fff;box-shadow:0 2px 32px rgba(44,104,162,.10),0 1.5px 8px rgba(44,73,104,.10);border-radius:15px;padding:2rem 2.5rem;max-width:660px;margin:2rem auto;}
      .form-title{color:#16467f;font-size:2.1rem;font-weight:700;}
      .btn-primary{background:#16467f;border-color:#16467f;}
      .btn-primary:hover{background:#11365f;}
      label.form-label{font-weight:600;color:#222e3e;margin-bottom:.2em;}
      .section-divider{border-top:1.5px solid #bfcbe2;margin:2.5rem 0 1.5rem 0;}
      .form-select,.form-control{border-radius:6px!important;}
      .is-invalid{border-color:#dc3545!important;}
      .invalid-feedback{display:block;}
  </style>
</head>
<body>
<div class="container">
  {{-- Header --}}
  <div class="bssc-header d-flex align-items-center">
    <img src="https://saraltyping.com/wp-content/uploads/2021/08/bihar-ssc-logo-1-1.webp" alt="BSSC Logo">
    <div class="flex-grow-1 text-center">
      <div style="font-size:1.15rem;font-weight:700;color:#1b3869;">Bihar Staff Selection Commission</div>
      <div style="font-size:.98rem;color:#313131;">P.O.-VETERINARY COLLEGE, PATNA - 800014</div>
      <div style="font-size:.93rem;color:#38406f;">Adv No.-05/25, 4th Graduate Level Combined Competitive Exam</div>
      <div style="font-size:.93rem;color:#3b525e;">चतुर्थ स्नातक स्तरीय संयुक्त प्रतियोगिता परीक्षा</div>
    </div>
  </div>

  {{-- Notice --}}
  <div class="notice-board">
    <div class="marquee">
      <span>ऑनलाइन आवेदन प्रक्रिया 5 अक्टूबर 2025 तक खुली रहेगी | For assistance contact support@bssc.gov.in</span>
    </div>
  </div>

  {{-- Form --}}
  <div class="form-card shadow">
    <h2 class="mb-4 text-center form-title">BSSC Application Form</h2>

    {{-- success --}}
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- validation + DB errors --}}
    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('jet.application.submit') }}" method="POST" novalidate>
      @csrf

      {{-- full name --}}
      <div class="mb-3">
        <label class="form-label" for="full_name">Name of Applicant *</label>
        <input type="text" id="full_name" name="full_name"
               class="form-control @error('full_name') is-invalid @enderror"
               value="{{ old('full_name') }}" required>
        @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      {{-- gender --}}
      <div class="mb-3">
        <label class="form-label">Gender *</label><br>
        @php $genderOld = old('gender'); @endphp
        @foreach(['Male','Female','Transgender'] as $g)
          <div class="form-check form-check-inline">
            <input class="form-check-input @error('gender') is-invalid @enderror"
                   type="radio" name="gender" id="g_{{ $g }}" value="{{ $g }}"
                   {{ $genderOld===$g?'checked':'' }} required>
            <label class="form-check-label" for="g_{{ $g }}">{{ $g }}</label>
          </div>
        @endforeach
        @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="section-divider"></div>

      {{-- Bihar domicile --}}
      <div class="mb-3">
        <label class="form-label">Domicile of Bihar *</label>
        <select name="bihar_domicile" class="form-select @error('bihar_domicile') is-invalid @enderror" required>
          <option value="">--Select--</option>
          <option value="Yes" {{ old('bihar_domicile')=='Yes'?'selected':'' }}>Yes</option>
          <option value="No"  {{ old('bihar_domicile')=='No'?'selected':'' }}>No</option>
        </select>
        @error('bihar_domicile')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      {{-- Category --}}
      <div class="mb-3">
        <label class="form-label">Category *</label>
        <select name="category" class="form-select @error('category') is-invalid @enderror" required>
          <option value="">--Select--</option>
          @foreach(['UR','SC','ST','EBC','BC','EWS'] as $c)
            <option value="{{ $c }}" {{ old('category')==$c?'selected':'' }}>{{ $c }}</option>
          @endforeach
        </select>
        @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      {{-- Caste --}}
      <div class="mb-3">
        <label class="form-label">Caste *</label>
        <input name="caste" type="text" class="form-control @error('caste') is-invalid @enderror"
               value="{{ old('caste') }}" required>
        @error('caste')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      {{-- Non creamy layer --}}
      <div class="mb-3">
        <label class="form-label">Non-Creamy Layer? *</label>
        <select name="non_creamy_layer" class="form-select @error('non_creamy_layer') is-invalid @enderror" required>
          <option value="">--Select--</option>
          <option value="Yes" {{ old('non_creamy_layer')=='Yes'?'selected':'' }}>Yes</option>
          <option value="No"  {{ old('non_creamy_layer')=='No'?'selected':'' }}>No</option>
        </select>
        @error('non_creamy_layer')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      {{-- PWD --}}
      <div class="mb-3">
        <label class="form-label">Person with Disability (PWD)? *</label>
        <select id="pwd" name="pwd" class="form-select @error('pwd') is-invalid @enderror" required>
          <option value="">--Select--</option>
          <option value="Yes" {{ old('pwd')=='Yes'?'selected':'' }}>Yes</option>
          <option value="No"  {{ old('pwd')=='No'?'selected':'' }}>No</option>
        </select>
        @error('pwd')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      {{-- disability extra --}}
      <div id="disability_type_div" class="mb-3" style="display:none;">
        <label class="form-label">Nature of Disability *</label>
        <select name="disability_type" class="form-select @error('disability_type') is-invalid @enderror">
          <option value="">--Select--</option>
          <option value="Permanent" {{ old('disability_type')=='Permanent'?'selected':'' }}>Permanent</option>
          <option value="Temporary" {{ old('disability_type')=='Temporary'?'selected':'' }}>Temporary</option>
        </select>
        @error('disability_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div id="min_disability_div" class="mb-3" style="display:none;">
        <label class="form-label">Minimum 40% Disability *</label>
        <select name="min_40_percent_disability" class="form-select @error('min_40_percent_disability') is-invalid @enderror">
          <option value="">--Select--</option>
          <option value="Yes" {{ old('min_40_percent_disability')=='Yes'?'selected':'' }}>Yes</option>
          <option value="No"  {{ old('min_40_percent_disability')=='No'?'selected':'' }}>No</option>
        </select>
        @error('min_40_percent_disability')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="section-divider"></div>

      {{-- ex serviceman --}}
      <div class="mb-3">
        <label class="form-label">Ex-Serviceman? *</label>
        <select name="ex_serviceman" class="form-select @error('ex_serviceman') is-invalid @enderror" required>
          <option value="">--Select--</option>
          <option value="Yes" {{ old('ex_serviceman')=='Yes'?'selected':'' }}>Yes</option>
          <option value="No"  {{ old('ex_serviceman')=='No'?'selected':'' }}>No</option>
        </select>
        @error('ex_serviceman')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      {{-- service in defence --}}
      <div class="mb-3">
        <label class="form-label">Service in Defence (Year/Month/Day)</label>
        <div class="row g-2">
          <div class="col"><input type="number" name="service_in_defence_year" placeholder="Year" class="form-control" value="{{ old('service_in_defence_year') }}"></div>
          <div class="col"><input type="number" name="service_in_defence_month" placeholder="Month" class="form-control" value="{{ old('service_in_defence_month') }}"></div>
          <div class="col"><input type="number" name="service_in_defence_day" placeholder="Day" class="form-control" value="{{ old('service_in_defence_day') }}"></div>
        </div>
      </div>

      {{-- NCC Bihar Govt --}}
      <div class="mb-3">
        <label class="form-label">Worked under Bihar Govt after NCC? *</label>
        <select name="ncc_bihar_govt_service" class="form-select @error('ncc_bihar_govt_service') is-invalid @enderror" required>
          <option value="">--Select--</option>
          <option value="Yes" {{ old('ncc_bihar_govt_service')=='Yes'?'selected':'' }}>Yes</option>
          <option value="No"  {{ old('ncc_bihar_govt_service')=='No'?'selected':'' }}>No</option>
        </select>
        @error('ncc_bihar_govt_service')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      {{-- Bihar govt employee --}}
      <div class="mb-3">
        <label class="form-label">Bihar Govt Employee? *</label>
        <select name="bihar_govt_employee" class="form-select @error('bihar_govt_employee') is-invalid @enderror" required>
          <option value="">--Select--</option>
          <option value="Yes" {{ old('bihar_govt_employee')=='Yes'?'selected':'' }}>Yes</option>
          <option value="No"  {{ old('bihar_govt_employee')=='No'?'selected':'' }}>No</option>
        </select>
        @error('bihar_govt_employee')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      {{-- attempts --}}
      <div class="mb-3">
        <label class="form-label">Attempts after Bihar Govt Employee</label>
        <select name="attempts_after_bihar_employee" class="form-select">
          <option value="">--Select--</option>
          @for($i=0;$i<=10;$i++)
            <option value="{{ $i }}" {{ old('attempts_after_bihar_employee')==$i?'selected':'' }}>{{ $i }}</option>
          @endfor
        </select>
      </div>

      <div class="section-divider"></div>

      {{-- mobile --}}
      <div class="mb-3">
        <label class="form-label">Mobile No *</label>
        <input name="mobile_no" type="text" class="form-control @error('mobile_no') is-invalid @enderror"
               value="{{ old('mobile_no') }}" required>
        @error('mobile_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      {{-- confirm mobile --}}
      <div class="mb-3">
        <label class="form-label">Confirm Mobile No *</label>
        <input name="mobile_no_confirm" type="text" class="form-control" value="{{ old('mobile_no_confirm') }}" required>
      </div>

      {{-- email --}}
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input name="email" type="email" class="form-control" value="{{ old('email') }}">
      </div>

      {{-- confirm email --}}
      <div class="mb-3">
        <label class="form-label">Confirm Email</label>
        <input name="email_confirm" type="email" class="form-control" value="{{ old('email_confirm') }}">
      </div>

      {{-- DOB --}}
      <div class="mb-3">
        <label class="form-label">Date of Birth *</label>
        <input type="date" id="dob" name="dob" class="form-control @error('dob') is-invalid @enderror" value="{{ old('dob') }}" required>
        @error('dob')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      {{-- age --}}
      <div class="mb-3">
        <label class="form-label">Age (as on 01-08-2025)</label>
        <input id="age_on_date" name="age_on_date" type="number" class="form-control" value="{{ old('age_on_date') }}">
      </div>

      <div class="d-grid mt-4">
        <button type="submit" class="btn btn-primary btn-lg">Submit Application</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function toggleDisabilityFields(){
    const pwd=document.getElementById('pwd').value;
    document.getElementById('disability_type_div').style.display=(pwd==='Yes')?'block':'none';
    document.getElementById('min_disability_div').style.display=(pwd==='Yes')?'block':'none';
  }
  document.getElementById('pwd').addEventListener('change',toggleDisabilityFields);
  toggleDisabilityFields();

  const DOB_CUTOFF=new Date('2025-08-01T00:00:00');
  const dobInput=document.getElementById('dob');
  const ageInput=document.getElementById('age_on_date');
  function computeAge(d){if(!d)return'';const dob=new Date(d+'T00:00:00');if(Number.isNaN(dob.getTime()))return'';let age=DOB_CUTOFF.getFullYear()-dob.getFullYear();const m=DOB_CUTOFF.getMonth()-dob.getMonth();if(m<0||(m===0&&DOB_CUTOFF.getDate()<dob.getDate()))age--;return age<0?'':age;}
  function updateAge(){ageInput.value=computeAge(dobInput.value);}
  dobInput.addEventListener('change',updateAge);updateAge();
</script>
</body>
</html>
