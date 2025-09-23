<div class="chat-container d-flex flex-column" style="width:100%; height:calc(100vh - 150px); padding:15px;">

    <!-- Chat Messages Box -->
    <div id="chatBox" class="chat-box border rounded p-3 mb-3 flex-grow-1" 
         style="height:100%; overflow-y:auto; background:#f8f9fa;">
        @forelse($application->additionalInfoRequests as $req)
            <div class="mb-3">
                <!-- Admin Message -->
                <div class="d-flex mb-1">
                    <div class="badge bg-primary text-white me-2" 
                         style="width:40px; height:40px; display:flex; align-items:center; justify-content:center; border-radius:50%;">
                        A
                    </div>
                    <div>
                        <p class="mb-1 fw-bold">{{ $req->admin->name }} 
                            <span class="text-muted" style="font-size:0.8rem;">Admin</span>
                        </p>
                        <div class="p-2 rounded bg-primary text-white" style="max-width:80%;">
                            {{ $req->message }}
                        </div>
                    </div>
                </div>

                <!-- Applicant Response -->
                @if($req->response || $req->response_file_path)
                    <div class="d-flex justify-content-end mt-1">
                        <div class="text-end">
                            <p class="mb-1 fw-bold text-muted" style="font-size:0.8rem;">Applicant</p>
                            <div class="p-2 rounded bg-light border" style="max-width:80%;">
                                {{ $req->response ?? 'No text response' }}
                                @if($req->response_file_path)
                                    <div class="mt-1">
                                        <a href="{{ Storage::url($req->response_file_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">View File</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-muted small mt-1">Awaiting applicant response...</p>
                @endif
            </div>
        @empty
            <p class="text-muted text-center">No additional info requests yet.</p>
        @endforelse
    </div>

    <!-- Message Input -->
    <form id="additionalInfoForm" class="ajax-form d-flex mt-auto" 
          method="POST" action="{{ route('admin.applicants.requestInfo', $application->id) }}">
        @csrf
        <input type="text" name="message" id="messageInput" class="form-control me-2" placeholder="Type your message..." required>
        <button type="submit" class="btn btn-primary">Send</button>
    </form>
</div>

<script>
$(document).ready(function() {
    const chatBox = $('.chat-box');

    function scrollChat() {
        chatBox.scrollTop(chatBox[0].scrollHeight);
    }

    scrollChat(); // scroll on load

    $('#additionalInfoForm').on('submit', function(e){
        e.preventDefault();
        let form = $(this);
        let url = form.attr('action');
        let data = form.serialize();

        $.post(url, data, function(response) {
            // Assuming your controller returns JSON { success: true, message_html: '...' }
            if(response.success) {
                chatBox.append(response.message_html);
                form.trigger('reset');
                scrollChat();
            } else {
                alert('Failed to send message.');
            }
        }).fail(function(xhr){
            alert('Error sending message.');
            console.error(xhr.responseText);
        });
    });
});
</script>
