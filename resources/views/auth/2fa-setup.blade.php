@extends('layouts.app')

@section('title', 'Setup Two-Factor Authentication')

@section('content')
<div class="two-fa-container">
    <div class="two-fa-card">
        <div class="two-fa-header">
            <h2 class="two-fa-title">Two-Factor Authentication</h2>
        </div>

        <div class="two-fa-body">
            @if(session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <div class="form-section">
                <p class="info-text">Code sent to your email. Valid for 10 minutes.</p>

                <form action="{{ route('2fa.setup') }}" method="POST" class="two-fa-form">
                    @csrf
                    <div class="form-group">
                        <label for="code" class="form-label">Enter 6-digit code</label>
                        <input
                            id="code"
                            name="code"
                            type="text"
                            required
                            class="form-input"
                            placeholder="000000"
                            maxlength="6"
                            pattern="\d{6}"
                            autofocus
                        >
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Verify OTP
                    </button>

                    <div class="back-link">
                        <a href="{{ route('login') }}">Back to login</a>
                    </div>
                </form>
            </div>

            <div class="help-text">
                Need help? Contact support if you don't receive the code.
            </div>
        </div>
    </div>
</div>

<style>
.two-fa-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
}

.two-fa-card {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    overflow: hidden;
    max-width: 400px;
    width: 100%;
}

.two-fa-header {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    padding: 2rem;
    text-align: center;
}

.two-fa-title {
    color: white;
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
}

.two-fa-body {
    padding: 2rem;
}

.alert {
    padding: 1rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
    font-size: 0.875rem;
}

.alert-warning {
    background: #fff3cd;
    border: 1px solid #ffc107;
    color: #856404;
}

.alert-error {
    background: #f8d7da;
    border: 1px solid #dc3545;
    color: #721c24;
}

.form-section {
    margin-bottom: 1.5rem;
}

.info-text {
    color: #6b7280;
    margin-bottom: 1.5rem;
    text-align: center;
}

.two-fa-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
}

.form-input {
    padding: 0.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 0.5rem;
    font-size: 1.25rem;
    text-align: center;
    font-weight: 700;
    letter-spacing: 0.25em;
    transition: all 0.3s;
}

.form-input:focus {
    outline: none;
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

.btn {
    padding: 0.875rem 1.5rem;
    border: none;
    border-radius: 0.5rem;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-primary {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
}

.back-link {
    text-align: center;
    margin-top: 1rem;
}

.back-link a {
    color: #10b981;
    text-decoration: none;
    font-size: 0.875rem;
}

.back-link a:hover {
    text-decoration: underline;
}

.help-text {
    border-top: 1px solid #e5e7eb;
    padding-top: 1rem;
    text-align: center;
    font-size: 0.75rem;
    color: #9ca3af;
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const codeInput = document.getElementById('code');

        codeInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '');
        });

        codeInput.focus();
    });
</script>
@endsection
