<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BSSC Application Form</title>
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
        .marquee { white-space: nowrap; overflow: hidden; box-sizing: border-box; }
        .marquee span { display: inline-block; padding-left: 100%; animation: marquee 16s linear infinite; }
        @keyframes marquee { 0% { transform: translate(0,0);} 100% { transform: translate(-100%,0);} }
        .form-card {
            background: #fff;
            box-shadow: 0 2px 32px rgba(44,104,162,0.10), 0 1.5px 8px rgba(44,73,104,0.10);
            border-radius: 15px;
            padding: 2rem 2.5rem;
            max-width: 660px;
            margin: 2rem auto;
        }
        .form-title { color: #16467f; font-size: 2.1rem; font-weight: 700; }
        .btn-primary { background-color: #16467f; border-color: #16467f; }
        .btn-primary:hover { background-color: #11365f; }
        label.form-label { font-weight: 610; color: #222e3e; margin-bottom: 0.2em; }
        .section-divider { border-top: 1.5px solid #bfcbe2; margin: 2.5rem 0 1.5rem 0; }
        .form-select, .form-control { border-radius: 6px !important; }
        .is-invalid { border-color: #dc3545 !important; }
        .invalid-feedback { display:block; }
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

    <!-- Form -->
    <div class="form-card shadow">
        <h2 class="mb-4 text-center form-title">BSSC Application Form</h2>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('jet.application.submit') }}" method="POST" novalidate>
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <label for="full_name" class="form-label">Name of Applicant *</label>
                <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                       id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Gender -->
            <div class="mb-3">
                <label class="form-label">Gender *</label><br>
                @php $genderOld = old('gender'); @endphp
                <div class="form-check form-check-inline">
                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="male" value="Male" {{ $genderOld=='Male'?'checked':'' }} required>
                    <label class="form-check-label" for="male">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="female" value="Female" {{ $genderOld=='Female'?'checked':'' }} required>
                    <label class="form-check-label" for="female">Female</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="transgender" value="Transgender" {{ $genderOld=='Transgender'?'checked':'' }} required>
                    <label class="form-check-label" for="transgender">Transgender</label>
                </div>
                @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="section-divider"></div>

            <!-- Domicile -->
            <div class="mb-3">
                <label class="form-label">Domicile of Bihar State? *</label>
                <select class="form-select @error('bihar_domicile') is-invalid @enderror" name="bihar_domicile" required>
                    <option value="">--Select--</option>
                    <option value="Yes" {{ old('bihar_domicile')=='Yes'?'selected':'' }}>Yes</option>
                    <option value="No" {{ old('bihar_domicile')=='No'?'selected':'' }}>No</option>
                </select>
                @error('bihar_domicile')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Category -->
            <div class="mb-3">
                <label class="form-label">Category *</label>
                <select class="form-select @error('category') is-invalid @enderror" name="category" required>
                    <option value="">--Select--</option>
                    @foreach (['UR','SC','ST','EBC','BC','EWS'] as $cat)
                        <option value="{{ $cat }}" {{ old('category')==$cat?'selected':'' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Caste -->
            <div class="mb-3">
                <label class="form-label">Caste *</label>
                <input type="text" class="form-control @error('caste') is-invalid @enderror" name="caste" value="{{ old('caste') }}" required>
                @error('caste')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Non-Creamy Layer -->
            <div class="mb-3">
                <label class="form-label">Non-Creamy Layer? *</label>
                <select class="form-select @error('non_creamy_layer') is-invalid @enderror" name="non_creamy_layer" required>
                    <option value="">--Select--</option>
                    <option value="Yes" {{ old('non_creamy_layer')=='Yes'?'selected':'' }}>Yes</option>
                    <option value="No" {{ old('non_creamy_layer')=='No'?'selected':'' }}>No</option>
                </select>
                @error('non_creamy_layer')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- PWD -->
            <div class="mb-3">
                <label class="form-label">Person with Disability (PWD)? *</label>
                <select class="form-select @error('pwd') is-invalid @enderror" name="pwd" id="pwd" required>
                    <option value="">--Select--</option>
                    <option value="Yes" {{ old('pwd')=='Yes'?'selected':'' }}>Yes</option>
                    <option value="No"  {{ old('pwd')=='No'?'selected':'' }}>No</option>
                </select>
                @error('pwd')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Nature of Disability -->
            <div class="mb-3" id="disability_type_div" style="display:none;">
                <label class="form-label">Nature of Disability *</label>
                <select class="form-select @error('disability_type') is-invalid @enderror" name="disability_type">
                    <option value="">--Select--</option>
                    <option value="Permanent" {{ old('disability_type')=='Permanent'?'selected':'' }}>Permanent</option>
                    <option value="Temporary" {{ old('disability_type')=='Temporary'?'selected':'' }}>Temporary</option>
                </select>
                @error('disability_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Minimum 40% Disability -->
            <div class="mb-3" id="min_disability_div" style="display:none;">
                <label class="form-label">Minimum 40% Disability? *</label>
                <select class="form-select @error('min_40_percent_disability') is-invalid @enderror" name="min_40_percent_disability">
                    <option value="">--Select--</option>
                    <option value="Yes" {{ old('min_40_percent_disability')=='Yes'?'selected':'' }}>Yes</option>
                    <option value="No"  {{ old('min_40_percent_disability')=='No'?'selected':'' }}>No</option>
                </select>
                @error('min_40_percent_disability')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="section-divider"></div>

            <!-- Ex-Serviceman -->
            <div class="mb-3">
                <label class="form-label">Ex-Serviceman? *</label>
                <select class="form-select @error('ex_serviceman') is-invalid @enderror" name="ex_serviceman" required>
                    <option value="">--Select--</option>
                    <option value="Yes" {{ old('ex_serviceman')=='Yes'?'selected':'' }}>Yes</option>
                    <option value="No"  {{ old('ex_serviceman')=='No'?'selected':'' }}>No</option>
                </select>
                @error('ex_serviceman')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Service in Defence -->
            <div class="mb-3">
                <label class="form-label">Service in Defence (Year/Month/Day)</label>
                <div class="row g-2">
                    <div class="col">
                        <input type="number" class="form-control @error('service_in_defence_year') is-invalid @enderror" name="service_in_defence_year" placeholder="Year" value="{{ old('service_in_defence_year') }}">
                        @error('service_in_defence_year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col">
                        <input type="number" class="form-control @error('service_in_defence_month') is-invalid @enderror" name="service_in_defence_month" placeholder="Month" value="{{ old('service_in_defence_month') }}">
                        @error('service_in_defence_month')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col">
                        <input type="number" class="form-control @error('service_in_defence_day') is-invalid @enderror" name="service_in_defence_day" placeholder="Day" value="{{ old('service_in_defence_day') }}">
                        @error('service_in_defence_day')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <!-- NCC/Bihar Govt Service -->
            <div class="mb-3">
                <label class="form-label">Worked under Bihar Govt after NCC release? *</label>
                <select class="form-select @error('ncc_bihar_govt_service') is-invalid @enderror" name="ncc_bihar_govt_service" required>
                    <option value="">--Select--</option>
                    <option value="Yes" {{ old('ncc_bihar_govt_service')=='Yes'?'selected':'' }}>Yes</option>
                    <option value="No"  {{ old('ncc_bihar_govt_service')=='No'?'selected':'' }}>No</option>
                </select>
                @error('ncc_bihar_govt_service')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Bihar Govt Employee -->
            <div class="mb-3">
                <label class="form-label">Bihar Govt Employee with ≥3 years service? *</label>
                <select class="form-select @error('bihar_govt_employee') is-invalid @enderror" name="bihar_govt_employee" required>
                    <option value="">--Select--</option>
                    <option value="Yes" {{ old('bihar_govt_employee')=='Yes'?'selected':'' }}>Yes</option>
                    <option value="No"  {{ old('bihar_govt_employee')=='No'?'selected':'' }}>No</option>
                </select>
                @error('bihar_govt_employee')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Number of Attempts -->
            <div class="mb-3">
                <label class="form-label">Attempts after Bihar Govt Employee</label>
                <select class="form-select @error('attempts_after_bihar_employee') is-invalid @enderror" name="attempts_after_bihar_employee">
                    <option value="">--Select--</option>
                    @for($i=0; $i<=10; $i++)
                        <option value="{{ $i }}" {{ old('attempts_after_bihar_employee')==$i?'selected':'' }}>{{ $i }}</option>
                    @endfor
                </select>
                @error('attempts_after_bihar_employee')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="section-divider"></div>

            <!-- Mobile -->
            <div class="mb-3">
                <label class="form-label">Mobile No *</label>
                <input type="text" class="form-control @error('mobile_no') is-invalid @enderror" name="mobile_no" value="{{ old('mobile_no') }}" required>
                @error('mobile_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Confirm Mobile -->
            <div class="mb-3">
                <label class="form-label">Confirm Mobile No *</label>
                <input type="text" class="form-control @error('mobile_no_confirm') is-invalid @enderror" name="mobile_no_confirm" value="{{ old('mobile_no_confirm') }}" required>
                @error('mobile_no_confirm')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label">Email ID</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Confirm Email -->
            <div class="mb-3">
                <label class="form-label">Confirm Email ID</label>
                <input type="email" class="form-control @error('email_confirm') is-invalid @enderror" name="email_confirm" value="{{ old('email_confirm') }}">
                @error('email_confirm')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Date of Birth -->
            <div class="mb-3">
                <label class="form-label">Date of Birth *</label>
                <input type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" id="dob" value="{{ old('dob') }}" required>
                @error('dob')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Age (auto-calc, read-only) -->
            <div class="mb-3">
                <label class="form-label">Age (as on 01-08-2025)</label>
                <input type="number" class="form-control @error('age_on_date') is-invalid @enderror" name="age_on_date" id="age_on_date" value="{{ old('age_on_date') }}" >
                @error('age_on_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Captcha -->
            {{-- <div class="mb-3">
                <label class="form-label">Captcha Code *</label>
                <div class="d-flex align-items-center mb-2">
                    <span id="captcha-image">{!! captcha_img() !!}</span>
                    <button type="button" class="btn btn-secondary btn-sm ms-2" id="captcha-refresh">Refresh</button>
                </div>
                <input type="text" class="form-control @error('captcha_code') is-invalid @enderror" name="captcha_code" required placeholder="Enter captcha text">
                @error('captcha_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div> --}}

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary btn-lg">Submit Application</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Show/hide disability fields based on PWD selection (persist state on reload)
    function toggleDisabilityFields() {
        const pwd = document.getElementById('pwd').value;
        document.getElementById('disability_type_div').style.display = (pwd === 'Yes') ? 'block' : 'none';
        document.getElementById('min_disability_div').style.display = (pwd === 'Yes') ? 'block' : 'none';
    }
    document.getElementById('pwd').addEventListener('change', toggleDisabilityFields);
    // Initialize on load based on old('pwd')
    toggleDisabilityFields();

    // Captcha refresh (expects a route returning JSON {captcha: '<img ...>'})
    

    // Auto-calc Age as on 01-08-2025 when DOB changes
    const DOB_CUTOFF = new Date('2025-08-01T00:00:00'); // 01-08-2025
    function computeAgeOnCutoff(d) {
        if (!d) return '';
        const dob = new Date(d + 'T00:00:00');
        if (Number.isNaN(dob.getTime())) return '';
        let age = DOB_CUTOFF.getFullYear() - dob.getFullYear();
        const m = DOB_CUTOFF.getMonth() - dob.getMonth();
        if (m < 0 || (m === 0 && DOB_CUTOFF.getDate() < dob.getDate())) {
            age--;
        }
        return age < 0 ? '' : age;
    }
    const dobInput = document.getElementById('dob');
    const ageInput = document.getElementById('age_on_date');
    function updateAge() { ageInput.value = computeAgeOnCutoff(dobInput.value); }
    dobInput.addEventListener('change', updateAge);
    // Initialize age on load if DOB has old value
    updateAge();
</script>
</body>
</html>
