@include('partials.header')

<style>
    .forgot-container {
        max-width: 500px;
        margin: 50px auto;
        background-color: white;
        padding: 2rem;
        border-radius: 1rem;
        border: 2px solid #52074f;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .forgot-container h2 {
        text-align: center;
        color: #52074f;
        margin-bottom: 1.5rem;
    }

    .forgot-container label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
        color: #52074f;
    }

    .forgot-container input[type="email"] {
        width: 100%;
        padding: 0.6rem;
        margin-bottom: 1rem;
        border: 1px solid #ccc;
        border-radius: 0.5rem;
    }

    .forgot-container button {
        width: 100%;
        background-color: #dd8027;
        color: white;
        padding: 0.7rem;
        border: none;
        border-radius: 0.5rem;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .forgot-container button:hover {
        background-color: #c76e20;
    }
</style>

<br><br>
<div class="forgot-container">
    <h2>Forgot Password</h2>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div>
            <label>Email Address</label>
            <input type="email" name="email"  placeholder="enter email adress" required>
        </div>
        <button type="submit">Send Password Reset Link</button>
    </form>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-success">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Success</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        We have sent a password reset link to your email.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="modalCloseBtn">OK</button>
      </div>
    </div>
  </div>
</div>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if (session('status'))
            // Show modal
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();

            // Redirect to login when modal closed
            document.getElementById('modalCloseBtn').addEventListener('click', function() {
                window.location.href = "{{ route('login') }}";
            });

            // Also handle modal close via 'X'
            document.getElementById('successModal').addEventListener('hidden.bs.modal', function () {
                window.location.href = "{{ route('login') }}";
            });
        @endif
    });
</script>
