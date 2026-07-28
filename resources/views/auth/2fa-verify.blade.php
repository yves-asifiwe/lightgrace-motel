@extends('layouts.app')

@section('title', 'Two-Factor Authentication')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-lg">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Two-Factor Authentication
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Enter the 6-digit code sent to your email
            </p>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                {{ session('error') }}
            </div>
        @endif

        <form class="mt-8 space-y-6" action="{{ route('2fa.verify') }}" method="POST">
            @csrf
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="code" class="sr-only">Authentication Code</label>
                    <input
                        id="code"
                        name="code"
                        type="text"
                        required
                        class="appearance-none rounded relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 text-center text-2xl tracking-widest focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="000000"
                        maxlength="6"
                        pattern="\d{6}"
                        autofocus
                    >
                </div>
            </div>

            <div>
                <button
                    type="submit"
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Verify
                </button>
            </div>

            <div class="text-center">
                <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:text-indigo-500">
                    Back to login
                </a>
            </div>
        </form>

        <div class="mt-4 border-t pt-4">
            <p class="text-xs text-gray-500 text-center">
                Lost access to your email? Use one of your <a href="#" class="text-indigo-600 hover:text-indigo-500">recovery codes</a>.
            </p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const codeInput = document.getElementById('code');

        codeInput.addEventListener('input', function(e) {
            // Only allow numbers
            this.value = this.value.replace(/\D/g, '');

            // Auto-focus next input or submit
            if (this.value.length === 6) {
                this.form.submit();
            }
        });

        codeInput.focus();
    });
</script>
@endsection
