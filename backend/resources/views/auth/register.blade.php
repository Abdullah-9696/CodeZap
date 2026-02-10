<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      height: 100vh;
      width: 100vw;
      display: flex;
      font-family: Arial, sans-serif;
    }

    /* Left side */
    .left {
      flex: 1;
      background: linear-gradient(135deg, #051937, #0a2a66, #0f3c8c);
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      text-align: center;
      padding: 40px;
    }
    .left h2 {
      font-size: 36px;
      margin-bottom: 15px;
    }
    .left p {
      font-size: 16px;
    }

    /* Right side */
    .right {
      flex: 1;
      background: linear-gradient(135deg, #ffffff, #f3f6fa);
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .card {
      width: 100%;
      max-width: 350px;
      text-align: center;
      background: rgba(255, 255, 255, 0.9);
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    .card h3 {
      margin-bottom: 20px;
      font-size: 22px;
    }
    .card input {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 15px;
    }
    .btn {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      background: linear-gradient(to right, #6a11cb, #2575fc);
      color: #fff;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
    }
    .btn:hover {
      opacity: 0.9;
    }
    .card a {
      color: #6a11cb;
      text-decoration: none;
      font-weight: bold;
    }
    .card a:hover {
      color: #2575fc;
    }
  </style>
</head>
<body>
  <!-- Left Side -->
  <div class="left">
    <h2>Create Account</h2>
    <p>Join us and start your journey today!</p>
  </div>

  <!-- Right Side -->
  <div class="right">
    <div class="card">
      <h3>Register</h3>
      <form method="POST" action="{{ route('register.submit') }}">
        @csrf
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email address" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
        <button type="submit" class="btn">Register</button>
      </form>
      <p style="margin-top: 15px;">Already have an account? <a href="{{ route('login') }}">Login</a></p>
    </div>
  </div>
</body>
</html>
