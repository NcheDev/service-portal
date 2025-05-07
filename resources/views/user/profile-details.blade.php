<div>
    <h2>Profile Details</h2>

    @if($personalInfo)
        <p><strong>Full Name:</strong> {{ $personalInfo->full_name }}</p>
        <p><strong>Contact Address:</strong> {{ $personalInfo->contact_address }}</p>
        <p><strong>Physical Address:</strong> {{ $personalInfo->physical_address }}</p>
        <p><strong>Email:</strong> {{ $personalInfo->email }}</p>
        <p><strong>Personal Statement:</strong> {{ $personalInfo->personal_statement }}</p>
        @if($personalInfo->national_id_path)
            <p><strong>National ID:</strong> 
                <a href="{{ Storage::url($personalInfo->national_id_path) }}" target="_blank">View ID</a>
            </p>
        @endif
    @else
        <p>No information found.</p>
    @endif
</div>
