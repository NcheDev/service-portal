<div class="chat-box" style="height:400px; overflow-y:auto;">
    @foreach($messages as $msg)
        @php $isAdmin = $msg->requested_by === auth()->id(); @endphp
        <div class="d-flex mb-2 {{ $isAdmin ? 'justify-content-start' : 'justify-content-end' }}">
            <div class="p-2 rounded {{ $isAdmin ? 'bg-primary text-white' : 'bg-light' }}" style="max-width:70%;">
                <p class="mb-1">{{ $msg->message }}</p>
                @if($msg->response_file_path)
                    <a href="{{ Storage::url($msg->response_file_path) }}" target="_blank" class="{{ $isAdmin ? 'text-white' : '' }}">View File</a>
                @endif
                <small class="d-block text-muted text-end">{{ $msg->created_at->diffForHumans() }}</small>
            </div>
        </div>
    @endforeach
</div>
