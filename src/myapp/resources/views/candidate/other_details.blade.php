@extends('layouts.candidate.app')

@section('title', 'Other Details')

@section('content')
  <div class="container-fluid mb-4">
    <ul class="progressbar">
      <li class="active"><a href="{{ route('candidate.profile', $application->id) }}">Profile</a></li>
      <li class="active"><a href="{{ route('candidate.uploadDocuments', $application->id) }}">Sign & Photo</a></li>
      <li class="active"><a href="javascript:void(0)">Other Details</a></li>
      <li><a href="{{ route('candidate.education', $application->id) }}">Education</a></li>
      <li><a href="{{ route('candidate.preview', $application->id) }}">Preview</a></li>
      <li><a href="{{ route('candidate.completed', $application->id) }}">Completed</a></li>
    </ul>
  </div>

  <div class="container">
    <div class="card shadow-lg border-0">
      <div class="card-header bg-primary text-white text-center">
        <h5 class="mb-0"><i class="fas fa-info-circle mr-2"></i>Other Details</h5>
      </div>
      <div class="card-body p-4">
        <form id="candidateForm" action="{{ route('candidate.otherDetailsStore', $application->id) }}" method="POST" enctype="multipart/form-data">
          @csrf

          <!-- Date of Birth -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label font-weight-bold">
              <i class="fas fa-birthday-cake text-primary mr-2"></i>Date of Birth
            </label>
            <div class="col-md-6">
              <input type="date" name="dob" class="form-control" required
                value="{{ old('dob', optional($application->date_of_birth)?->format('Y-m-d')) }}">
            </div>
          </div>

          <!-- Gender -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label font-weight-bold">
              <i class="fas fa-venus-mars text-primary mr-2"></i>Gender
            </label>
            <div class="col-md-6">
              <select name="gender" class="form-control" required>
                <option value="">-- Select --</option>
                @foreach(['Male','Female','Transgender'] as $gender)
                  <option value="{{ $gender }}" {{ old('gender', $application->gender) === $gender ? 'selected' : '' }}>{{ $gender }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <!-- Category -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label font-weight-bold">
              <i class="fas fa-users text-primary mr-2"></i>Category
            </label>
            <div class="col-md-6">
              <select name="category" class="form-control" required>
                <option value="">-- Select Category --</option>
                @foreach(['UR','EWS','SC','ST','BC-I','BC-II','OBC','EBC','BC'] as $cat)
                  <option value="{{ $cat }}" {{ old('category', $application->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <!-- Primitive Tribe toggle (shown for ST/tribal categories if applicable) -->
          <fieldset class="form-group" id="primitiveTribeShow" style="{{ in_array(old('category', $application->category), ['ST']) ? '' : 'display:none' }}">
            <div class="row">
              <legend class="col-form-label col-md-3 pt-0">Primitive Tribe</legend>
              <div class="col-md-6 d-flex align-items-center">
                @php $ptOld = old('primitiveTribe', $application->primitive_tribe ?? null); @endphp
                <div class="form-check mr-3">
                  <input class="form-check-input" type="radio" id="yesPrimitiveTribe" name="primitiveTribe" value="true" {{ $ptOld === 'true' ? 'checked' : '' }}>
                  <label class="form-check-label" for="yesPrimitiveTribe">Yes</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" id="noPrimitiveTribe" name="primitiveTribe" value="false" {{ $ptOld === 'false' || is_null($ptOld) ? 'checked' : '' }}>
                  <label class="form-check-label" for="noPrimitiveTribe">No</label>
                </div>
              </div>
            </div>
          </fieldset>

          <!-- PTG dropdown -->
          <fieldset class="form-group" id="ptgBlock" style="{{ old('primitiveTribe', $application->primitive_tribe ?? 'false') === 'true' ? '' : 'display:none' }}">
            <div class="row">
              <legend class="col-form-label col-md-3 pt-0">Primitive Tribal Group (PTG)</legend>
              <div class="col-md-6">
                @php $ptgOld = old('primitiveTribalPTG', $application->primitive_tribal_ptg ?? ''); @endphp
                <select id="primitiveTribalPTG" name="primitiveTribalPTG" class="form-control">
                  <option value="">Select Primitive Group</option>
                  @foreach(['Asur','Birhor','Birajia','Korwa','Savar','Pahariya(Baiga)','Mal Pahariya','Souriya Pahariya'] as $ptg)
                    <option value="{{ $ptg }}" {{ $ptgOld === $ptg ? 'selected' : '' }}>{{ $ptg }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </fieldset>

          <!-- Benchmark Disability -->
          <fieldset class="form-group">
            <div class="row">
              <legend class="col-form-label col-md-3 pt-0">Benchmark Disability ≥ 40% <span class="text-danger">*</span></legend>
              <div class="col-md-6 d-flex align-items-center flex-wrap">
                @php $bdOld = old('benchmarkDisability', $application->benchmark_disability ?? null); @endphp
                <div class="form-check mr-3">
                  <input class="form-check-input" type="radio" id="bdYes" name="benchmarkDisability" value="true" {{ $bdOld === 'true' ? 'checked' : '' }}>
                  <label class="form-check-label" for="bdYes">Yes</label>
                </div>
                <div class="form-check mr-3">
                  <input class="form-check-input" type="radio" id="bdNo" name="benchmarkDisability" value="false" {{ $bdOld === 'false' || is_null($bdOld) ? 'checked' : '' }}>
                  <label class="form-check-label" for="bdNo">No</label>
                </div>
              </div>
            </div>
          </fieldset>

          <div id="disabilityDetails" style="{{ old('benchmarkDisability', $application->benchmark_disability ?? 'false') === 'true' ? '' : 'display:none' }}">
            <div class="form-group row">
              <label class="col-md-3 col-form-label">Type of Disability <span class="text-danger">*</span></label>
              <div class="col-md-6">
                @php $todOld = old('typeOfDisability', $application->type_of_disability ?? ''); @endphp
                <select id="typeOfDisability" name="typeOfDisability" class="form-control">
                  <option value="">Select</option>
                  @foreach([
                    'Visual Impairment',
                    'Hearing Impairment',
                    'Locomotive Disability including Leprosy Cured Person, Cerebral Palsy, Dwarfism, Muscular Dystrophy, Acid Attack Victims',
                    'Multiple Disabilities'
                  ] as $tod)
                    <option value="{{ $tod }}" {{ $todOld === $tod ? 'selected' : '' }}>{{ $tod }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row" id="subtypeWrap" style="{{ $todOld ? '' : 'display:none' }}">
              <label class="col-md-3 col-form-label">Sub-Type of Disability</label>
              <div class="col-md-6">
                @php $subOld = old('subtypeOfDisability', $application->subtype_of_disability ?? ''); @endphp
                <select id="subtypeOfDisability" name="subtypeOfDisability" class="form-control">
                  @if($subOld)
                    <option value="{{ $subOld }}" selected>{{ $subOld }}</option>
                  @else
                    <option value="">Select</option>
                  @endif
                </select>
              </div>
            </div>

            <fieldset class="form-group" id="scribeWrap" style="display:none">
              <div class="row">
                <legend class="col-form-label col-md-3 pt-0">Do you need a scribe?</legend>
                <div class="col-md-6 d-flex align-items-center">
                  @php $scribeOld = old('doYouNeedScribe', $application->need_scribe ?? 'false'); @endphp
                  <div class="form-check mr-3">
                    <input class="form-check-input" type="radio" name="doYouNeedScribe" id="scribeYes" value="true" {{ $scribeOld === 'true' ? 'checked' : '' }}>
                    <label class="form-check-label" for="scribeYes">Yes</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="doYouNeedScribe" id="scribeNo" value="false" {{ $scribeOld === 'false' ? 'checked' : '' }}>
                    <label class="form-check-label" for="scribeNo">No</label>
                  </div>
                </div>
              </div>
            </fieldset>
          </div>

          <!-- Ex-Serviceman -->
          <fieldset class="form-group">
            <div class="row">
              <legend class="col-form-label col-md-3 pt-0">Are you an ex-serviceman? <span class="text-danger">*</span></legend>
              <div class="col-md-6 d-flex align-items-center">
                @php $exOld = old('exServiceman', $application->ex_serviceman ?? 'false'); @endphp
                <div class="form-check mr-3">
                  <input class="form-check-input" type="radio" id="exYes" name="exServiceman" value="true" {{ $exOld === 'true' ? 'checked' : '' }}>
                  <label class="form-check-label" for="exYes">Yes</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" id="exNo" name="exServiceman" value="false" {{ $exOld === 'false' ? 'checked' : '' }}>
                  <label class="form-check-label" for="exNo">No</label>
                </div>
              </div>
            </div>
          </fieldset>

          <!-- Nationality/Citizenship -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label">Nationality/Citizenship <span class="text-danger">*</span></label>
            <div class="col-md-6">
              @php $natOld = old('nationality_Citizenship', $application->nationality ?? 'India'); @endphp
              <select id="nationality_Citizenship" name="nationality_Citizenship" class="form-control">
                <option value="">Select</option>
                <option value="India" {{ $natOld === 'India' ? 'selected' : '' }}>Indian</option>
              </select>
            </div>
          </div>

          <!-- Marital Status and Spouse Name -->
          <fieldset class="form-group">
            <div class="row">
              <legend class="col-form-label col-md-3 pt-0">Marital Status <span class="text-danger">*</span></legend>
              <div class="col-md-6 d-flex align-items-center flex-wrap">
                @php $marOld = old('maritalStatus', $application->marital_status ?? ''); @endphp
                @foreach(['Unmarried','Married','Widow','Divorced'] as $ms)
                <div class="form-check mr-3 mb-2">
                  <input class="form-check-input" type="radio" id="ms_{{ $ms }}" name="maritalStatus" value="{{ $ms }}" {{ $marOld === $ms ? 'checked' : '' }}>
                  <label class="form-check-label" for="ms_{{ $ms }}">{{ $ms }}</label>
                </div>
                @endforeach
              </div>
            </div>
          </fieldset>

          <div id="spouseWrap" style="{{ $marOld === 'Married' ? '' : 'display:none' }}">
            <div class="form-group row">
              <label class="col-md-3 col-form-label">Husband’s/Wife’s Name</label>
              <div class="col-md-6">
                <input id="spouseName" name="spouseName" type="text" class="form-control" placeholder="Spouse Name"
                  value="{{ old('spouseName', $application->spouse_name ?? '') }}">
              </div>
            </div>
          </div>

          <!-- Domicile State -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label">Domicile State <span class="text-danger">*</span></label>
            <div class="col-md-6">
              @php $domOld = old('domicile_state', $application->domicile_state ?? ''); @endphp
              <select id="domicile_state" name="domicile_state" class="form-control">
                @if($domOld)
                  <option value="{{ $domOld }}" selected>{{ $domOld }}</option>
                @else
                  <option value="">Select</option>
                @endif
              </select>
            </div>
          </div>

          <!-- Correspondence Address -->
          <hr>
          <h6>Correspondence Address</h6>
          @php $addr = optional($application->addresses->first()); @endphp
          <div class="form-group row">
            <label class="col-md-3 col-form-label">Address Line 1 <span class="text-danger">*</span></label>
            <div class="col-md-6">
              <input type="text" name="address_line1" class="form-control" required
                value="{{ old('address_line1', $addr->address_line1) }}">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">Address Line 2</label>
            <div class="col-md-6">
              <input type="text" name="address_line2" class="form-control"
                value="{{ old('address_line2', $addr->address_line2) }}">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-3">
              <label class="col-form-label">City <span class="text-danger">*</span></label>
              <input type="text" name="city" class="form-control" required value="{{ old('city', $addr->city) }}">
            </div>
            <div class="form-group col-md-3">
              <label class="col-form-label">District</label>
              <input type="text" name="district" class="form-control" value="{{ old('district', $addr->district) }}">
            </div>
            <div class="form-group col-md-3">
              <label class="col-form-label">State <span class="text-danger">*</span></label>
              <input type="text" name="state" class="form-control" required value="{{ old('state', $addr->state) }}">
            </div>
            <div class="form-group col-md-3">
              <label class="col-form-label">Pincode <span class="text-danger">*</span></label>
              <input type="text" name="pincode" class="form-control" required value="{{ old('pincode', $addr->pincode) }}">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">Country <span class="text-danger">*</span></label>
            <div class="col-md-6">
              <input type="text" name="country" class="form-control" required
                value="{{ old('country', $addr->country ?? 'India') }}">
            </div>
          </div>

          <!-- Permanent Address -->
          <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="sameAddress" {{ old('sameAddress') ? 'checked' : '' }}>
            <label class="form-check-label" for="sameAddress">Same as Correspondence Address</label>
          </div>
         <div id="permanentAddressSection">
          <h6>Permanent Address</h6>
          @php $paddr = optional($application->addresses->get(1)); @endphp
          <div class="form-group row">
            <label class="col-md-3 col-form-label">Address Line 1 <span class="text-danger">*</span></label>
            <div class="col-md-6">
              <input id="permanentAddress1" name="permanentAddress1" type="text" class="form-control"
                value="{{ old('permanentAddress1', $paddr->address_line1) }}">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">Address Line 2</label>
            <div class="col-md-6">
              <input id="permanentAddress2" name="permanentAddress2" type="text" class="form-control"
                value="{{ old('permanentAddress2', $paddr->address_line2) }}">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-3">
              <label class="col-form-label">City <span class="text-danger">*</span></label>
              <input id="permanentCity" name="permanentCity" type="text" class="form-control"
                value="{{ old('permanentCity', $paddr->city) }}">
            </div>
            <div class="form-group col-md-3">
              <label class="col-form-label">District</label>
              <input id="permanentDistrict" name="permanentDistrict" type="text" class="form-control"
                value="{{ old('permanentDistrict', $paddr->district) }}">
            </div>
            <div class="form-group col-md-3">
              <label class="col-form-label">State <span class="text-danger">*</span></label>
              <input id="permanentState" name="permanentState" type="text" class="form-control"
                value="{{ old('permanentState', $paddr->state) }}">
            </div>
            <div class="form-group col-md-3">
              <label class="col-form-label">Pincode <span class="text-danger">*</span></label>
              <input id="permanentPinCode" name="permanentPinCode" type="text" class="form-control" maxlength="6"
                value="{{ old('permanentPinCode', $paddr->pincode) }}">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label">Country <span class="text-danger">*</span></label>
            <div class="col-md-6">
              <input id="permanentCountry" name="permanentCountry" type="text" class="form-control"
                value="{{ old('permanentCountry', $paddr->country ?? 'India') }}">
            </div>
          </div>
          </div>

          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <!-- Actions -->
          <div class="form-group row mt-4">
            <div class="col-md-9 offset-md-3">
              <a href="{{ route('candidate.uploadDocuments',$application->id) }}" class="btn btn-success">
                <i class="fas fa-arrow-left mr-1"></i> Back
              </a>

              @if(($progress_status['step_name'] === 'other_details' && $progress_status['status'] !== 'Completed') || empty($progress_status['step_name']))
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-arrow-right mr-1"></i> Save & Next
                </button>
              @else
                <a href="{{ route('candidate.education', $application->id) }}" class="btn btn-primary mr-2">Next</a>
              @endif
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection


<script>
document.addEventListener("DOMContentLoaded", function () {
  // ===== Primitive Tribe & PTG =====
  function togglePrimitive() {
    var catEl = document.querySelector('[name="category"]');
    if (!catEl) return;
    var cat = catEl.value;
    var show = (cat === 'ST');
    var primitiveDiv = document.getElementById('primitiveTribeShow');
    var ptgDiv = document.getElementById('ptgBlock');
    if (primitiveDiv) primitiveDiv.style.display = show ? '' : 'none';
    if (!show && ptgDiv) ptgDiv.style.display = 'none';
  }
  var catEl = document.querySelector('[name="category"]');
  if (catEl) {
    catEl.addEventListener('change', togglePrimitive);
    togglePrimitive();
  }

  function onPrimitiveChange() {
    var val = document.querySelector('input[name="primitiveTribe"]:checked');
    var ptgDiv = document.getElementById('ptgBlock');
    if (ptgDiv) ptgDiv.style.display = (val && val.value === 'true') ? '' : 'none';
  }
  document.querySelectorAll('input[name="primitiveTribe"]').forEach(function (el) {
    el.addEventListener('change', onPrimitiveChange);
  });
  onPrimitiveChange();

  // ===== Benchmark Disability =====
  function toggleDisability() {
    var val = document.querySelector('input[name="benchmarkDisability"]:checked');
    var show = (val && val.value === 'true');
    var details = document.getElementById('disabilityDetails');
    var subtype = document.getElementById('subtypeWrap');
    var scribe = document.getElementById('scribeWrap');
    if (details) details.style.display = show ? '' : 'none';
    if (subtype) subtype.style.display = show ? subtype.style.display : 'none';
    if (scribe) scribe.style.display = show ? scribe.style.display : 'none';
  }
  document.querySelectorAll('input[name="benchmarkDisability"]').forEach(function (el) {
    el.addEventListener('change', toggleDisability);
  });
  toggleDisability();

  // Type of Disability -> sub-type + scribe
  var typeSel = document.getElementById('typeOfDisability');
  if (typeSel) {
    typeSel.addEventListener('change', function () {
      var has = !!this.value;
      var subtype = document.getElementById('subtypeWrap');
      var scribe = document.getElementById('scribeWrap');
      if (subtype) subtype.style.display = has ? '' : 'none';
      if (scribe) scribe.style.display = has ? '' : 'none';
    });
  }

  // ===== Marital Status -> spouse name =====
  function toggleSpouse() {
    var val = document.querySelector('input[name="maritalStatus"]:checked');
    var spouseDiv = document.getElementById('spouseWrap');
    if (spouseDiv) spouseDiv.style.display = (val && val.value === 'Married') ? '' : 'none';
  }
  document.querySelectorAll('input[name="maritalStatus"]').forEach(function (el) {
    el.addEventListener('change', toggleSpouse);
  });
  toggleSpouse();

  // ===== Permanent Address =====
  var chk = document.getElementById('sameAddress');
  var permSection = document.getElementById('permanentAddressSection');
  if (chk && permSection) {
    function togglePermanent() {
      if (chk.checked) {
        // hide section
        permSection.style.display = 'none';
        // copy values
        permSection.querySelector('#permanentAddress1').value = document.querySelector('[name="address_line1"]').value || '';
        permSection.querySelector('#permanentAddress2').value = document.querySelector('[name="address_line2"]').value || '';
        permSection.querySelector('#permanentCity').value = document.querySelector('[name="city"]').value || '';
        permSection.querySelector('#permanentDistrict').value = document.querySelector('[name="district"]').value || '';
        permSection.querySelector('#permanentState').value = document.querySelector('[name="state"]').value || '';
        permSection.querySelector('#permanentPinCode').value = document.querySelector('[name="pincode"]').value || '';
        permSection.querySelector('#permanentCountry').value = document.querySelector('[name="country"]').value || 'India';
      } else {
        permSection.style.display = '';
      }
    }
    chk.addEventListener('change', togglePermanent);
    togglePermanent(); // run on load
  }
});
</script>



