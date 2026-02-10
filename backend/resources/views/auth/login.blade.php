<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { height: 100vh; width: 100vw; display: flex; font-family: Arial, sans-serif; }
.left { flex: 1; background: linear-gradient(135deg, #051937, #0a2a66, #0f3c8c); color: #fff; display: flex; justify-content: center; align-items: center; flex-direction: column; text-align: center; padding: 40px; }
.left h2 { font-size: 36px; margin-bottom: 15px; }
.left p { font-size: 16px; }
.right { flex: 1; background: linear-gradient(135deg, #051937, #0a2a66, #0f3c8c); display: flex; justify-content: center; align-items: center; }
.card { width: 100%; max-width: 350px; text-align: center; background: rgba(255, 255, 255, 0.95); padding: 30px; border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
.card h3 { margin-bottom: 20px; font-size: 22px; }
.card input { width: 100%; padding: 12px; margin-bottom: 15px; border-radius: 8px; border: 1px solid #ccc; font-size: 15px; }
.btn { width: 100%; padding: 12px; border: none; border-radius: 8px; background: linear-gradient(to right, #6a11cb, #2575fc); color: #fff; font-size: 16px; font-weight: bold; cursor: pointer; }
.btn:hover { opacity: 0.9; }
.card a { color: #6a11cb; text-decoration: none; font-weight: bold; }
.card a:hover { color: #2575fc; }
.error-message, .success-message { font-size: 14px; margin-bottom: 15px; }
.error-message { color: #dc3545; }
.success-message { color: #28a745; }
.forgot-password { display: block; margin-top: 10px; text-align: right; font-size: 14px; }
</style>
</head>
<body>
<div class="left">
    <h2>Welcome Back<br> to CodeZap!</h2>
    <p>Kickstart your coding journey with beginner-friendly courses for all major programming languages!</p>
</div>

<div class="right">
    <div class="card">
        @if (session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="error-message">{{ session('error') }}</div>
        @endif

        <!-- Login Form -->
        @if(!isset($forgotPassword))
            <h3>Login to Your Account</h3>
            <form method="POST" action="{{ route('login.submit') }}">
                @csrf
                <input type="email" name="email" placeholder="Email address" value="{{ old('email') }}" required>
                @error('email')<div class="error-message">{{ $message }}</div>@enderror
                <input type="password" name="password" placeholder="Password" required>
                @error('password')<div class="error-message">{{ $message }}</div>@enderror
                <button type="submit" class="btn">Login</button>
            </form>
            <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password?</a>
            <p style="margin-top: 15px;">Don’t have an account? <a href="{{ route('register') }}">Register</a></p>

        <!-- Forgot Password Form -->
        @elseif(isset($forgotPassword) && $forgotPassword)
            <h3>Forgot Password</h3>
            <form method="POST" action="{{ route('password.update.direct') }}">
                @csrf
                <input type="email" name="email" placeholder="Email address" value="{{ old('email') }}" required>
                <input type="password" name="current_password" placeholder="Current password" required>
                <input type="password" name="new_password" placeholder="New password" required>
                <input type="password" name="new_password_confirmation" placeholder="Confirm new password" required>
                <button type="submit" class="btn">Update Password</button>
            </form>
            <p><a href="{{ route('login') }}">Back to Login</a></p>
        @endif
    </div>
</div>
</body>
</html>
