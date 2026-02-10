<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
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
      flex: 1; /* 50% */
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
      flex: 1; /* 50% */
      background: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .card {
      width: 100%;
      max-width: 350px;
      text-align: center;
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
    <h2>Welcome Back!</h2>
    <p>To keep connected with us please login with your personal info</p>
  </div>

  <!-- Right Side -->
  <div class="right">
    <div class="card">
      <h3>Login to Your Account</h3>
      <form>
        <input type="email" placeholder="Email address" required>
        <input type="password" placeholder="Password" required>
        <button class="btn">Login</button>
      </form>
      <p style="margin-top: 15px;">Don’t have an account? <a href="#">Sign Up</a></p>
    </div>
  </div>
</body>
</html>
