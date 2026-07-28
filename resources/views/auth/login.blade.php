<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lightgrace Admin - Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body style="background-color: #0a2f1f;">
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <h1>Lightgrace</h1>
                <p>Admin Dashboard</p>
            </div>
            
            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter your email"/>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password"/>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="form-group checkbox-group">
                    <label for="remember_me" class="checkbox-label">
                        <input id="remember_me" type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                </div>

                <div class="form-actions">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">
                            Forgot your password?
                        </a>
                    @endif

                    <button type="submit" class="btn btn-primary">
                        Log in
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
        }

        .login-box {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(13, 74, 53, 0.3);
            padding: 3rem;
            width: 100%;
            max-width: 450px;
            border-top: 4px solid #38ef7d;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #e8f5e9;
        }

        .login-header h1 {
            font-size: 2rem;
            color: #0d4a35;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .login-header p {
            color: #1a6b4f;
            font-size: 1rem;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-group label {
            font-weight: 600;
            color: #0d4a35;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group input {
            padding: 0.8rem;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 1rem;
            transition: all 0.3s;
            background-color: #f9fbf9;
        }

        .form-group input:focus {
            outline: none;
            border-color: #38ef7d;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(56, 239, 125, 0.1);
        }

        .checkbox-group {
            flex-direction: row;
            align-items: center;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .checkbox-label input[type="checkbox"] {
            width: auto;
            margin: 0;
        }

        .checkbox-label span {
            color: #555;
            font-size: 0.9rem;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
        }

        .forgot-password {
            color: #0d4a35;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
        }

        .forgot-password:hover {
            color: #38ef7d;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }

        .btn {
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0d4a35 0%, #1a6b4f 100%);
            color: white;
            border: 2px solid #38ef7d;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(13, 74, 53, 0.4);
            background: linear-gradient(135deg, #1a6b4f 0%, #0d4a35 100%);
        }
    </style>
</body>
</html>
