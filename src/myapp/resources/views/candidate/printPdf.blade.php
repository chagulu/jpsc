<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Application Preview</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; line-height: 1.5; }
        h2, h3, h4 { margin-bottom: 8px; }
        .section { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 6px; text-align: left; font-size: 12px; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Application #{{ $application->application_no }}</h2>

    <!-- Application Info -->
    <div class="section">
        <h3>Application Info</h3>
        <p><strong>Application No:</strong> {{ $application->application_no ?? 'N/A' }}</p>
        <p><strong>Submitted Date:</strong> {{ $application->submitted_at?->format('d-m-Y h:i A') ?? 'Not Submitted' }}</p>
    </div>

    <!-- Personal Info -->
    <div class="section">
        <h3>Personal Information</h3>
        <table>
            <tr><th>Full Name</th><td>{{ $application->full_name }}</td></tr>
            <tr><th>Father's Name</th><td>{{ $application->father_name }}</td></tr>
            <tr><th>Mother's Name</th><td>{{ $application->mother_name }}</td></tr>
            <tr><th>Mobile</th><td>{{ $application->mobile_no }}</td></tr>
            <tr><th>Email</th><td>{{ $application->email }}</td></tr>
            <tr><th>Date of Birth</th><td>{{ $application->date_of_birth?->format('d-m-Y') }}</td></tr>
            <tr><th>Gender</th><td>{{ ucfirst($application->gender) }}</td></tr>
            <tr><th>Category</th><td>{{ $application->category ?? 'N/A' }}</td></tr>
            <tr><th>Marital Status</th><td>{{ ucfirst($application->marital_status ?? 'N/A') }}</td></tr>
        </table>
    </div>

    <!-- Address -->
    <div class="section">
        <h3>Address</h3>
        <table>
            <tr>
                <th>Permanent</th>
                <td>
                    {{ $application->permanentAddress?->address_line1 ?? 'N/A' }}<br>
                    {{ $application->permanentAddress?->city ?? '' }},
                    {{ $application->permanentAddress?->state ?? '' }}
                    - {{ $application->permanentAddress?->pincode ?? '' }}
                </td>
            </tr>
            <tr>
                <th>Correspondence</th>
                <td>
                    {{ $application->correspondenceAddress?->address_line1 ?? 'N/A' }}<br>
                    {{ $application->correspondenceAddress?->city ?? '' }},
                    {{ $application->correspondenceAddress?->state ?? '' }}
                    - {{ $application->correspondenceAddress?->pincode ?? '' }}
                </td>
            </tr>
        </table>
    </div>

    <!-- Other Details -->
    <div class="section">
        <h3>Other Details</h3>
        <table>
            <tr><th>Nationality</th><td>{{ $application->nationality ?? 'N/A' }}</td></tr>
            <tr><th>Disability</th><td>{{ $application->disability ?? 'No' }}</td></tr>
            <tr><th>Identification Mark</th><td>{{ $application->identification_mark ?? 'N/A' }}</td></tr>
            <tr><th>Aadhaar No</th><td>{{ $application->aadhaar_no ?? 'N/A' }}</td></tr>
        </table>
    </div>

    <!-- Education -->
    <div class="section">
        <h3>Education</h3>
        <table>
            <thead>
                <tr>
                    <th>Exam</th>
                    <th>Degree</th>
                    <th>Subject</th>
                    <th>School/College</th>
                    <th>Board/Univ</th>
                    <th>Passing</th>
                    <th>Status</th>
                    <th>Marks</th>
                    <th>Division</th>
                    <th>Certificate No</th>
                </tr>
            </thead>
            <tbody>
            @forelse($application->education as $edu)
                <tr>
                    <td>{{ $edu->exam_name }}</td>
                    <td>{{ $edu->degree }}</td>
                    <td>{{ $edu->subject }}</td>
                    <td>{{ $edu->school_college }}</td>
                    <td>{{ $edu->board_university }}</td>
                    <td>{{ $edu->passing_month }} {{ $edu->passing_year }}</td>
                    <td>{{ $edu->status }}</td>
                    <td>{{ $edu->marks_obtained }}</td>
                    <td>{{ $edu->division }}</td>
                    <td>{{ $edu->certificate_number }}</td>
                </tr>
            @empty
                <tr><td colspan="10">No education details available.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- Uploaded Files -->
    <div class="section">
        <h3>Uploaded Files</h3>
        <p><strong>Photo:</strong></p>
        @if($application->documents?->photo)
            <img src="{{ public_path('storage/' . $application->documents->photo) }}" width="120">
        @endif

        <p><strong>Signature:</strong></p>
        @if($application->documents?->signature)
            <img src="{{ public_path('storage/' . $application->documents->signature) }}" width="150">
        @endif
    </div>
</body>
</html>
