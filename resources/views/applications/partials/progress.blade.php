@php
$steps = [
    'profile'   => 'Profile',
    'details'   => 'Application Details',
    'documents' => 'Documents',
    'preview'   => 'Preview',
];

$currentIndex = array_search($application->current_step, array_keys($steps));
@endphp

<div class="mb-4">
    <div class="d-flex justify-content-between mb-2 small text-muted">
        @foreach($steps as $key => $label)
            <span class="{{ $application->current_step === $key ? 'fw-bold text-primary' : '' }}">
                {{ $label }}
            </span>
        @endforeach
    </div>

    <div class="progress" style="height: 8px;">
        <div class="progress-bar"
             role="progressbar"
             style="width: {{ (($currentIndex + 1) / count($steps)) * 100 }}%;">
        </div>
    </div>
</div>
