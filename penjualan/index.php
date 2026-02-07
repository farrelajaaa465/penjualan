<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #000;
      height: 100vh;
    }
    .login-card {
      background-color: #fff;
      border-radius: 10px;
      padding: 30px;
      width: 100%;
      max-width: 400px;
    }
    .form-control {
      border-radius: 8px;
    }
    .btn-black {
      background-color: #000;
      color: #fff;
      border: none;
    }
    .btn-black:hover {
      background-color: #333;
    }
    .login-title {
      font-weight: 700;
      text-align: center;
      margin-bottom: 20px;
    }
  </style>
</head>
<body class="d-flex align-items-center justify-content-center">

  <div class="login-card shadow">
    <?php
session_start();
if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger text-center'>".$_SESSION['error']."</div>";
    unset($_SESSION['error']);
}

if (isset($_SESSION['logout'])) {
    echo "<div class='alert alert-success text-center'>".$_SESSION['logout']."</div>";
    unset($_SESSION['logout']);
}

if (isset($_SESSION['login_required'])) {
    echo "<div class='alert alert-warning text-center'>".$_SESSION['login_required']."</div>";
    unset($_SESSION['login_required']);
}
?>

    <h3 class="login-title">LOGIN</h3>

     <form action="login.php" method="post" class="border rounded p-4 shadow-sm bg-light">

      <div class="mb-3">
        <label class="form-label">username</label>
        <input type="text" name="username" class="form-control" placeholder="masukkan username">
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password"class="form-control" placeholder="masukkan password">
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-black">Masuk</button>
      </div>

      <div class="text-center mt-3">
        <small class="text-muted">© 2026</small>
      </div>
    </form>
  </div>

</body>
</html>
