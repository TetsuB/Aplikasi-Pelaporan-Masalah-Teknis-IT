<?php
include 'config.php';
if (isset($_SESSION['user'])) {
    if ($_SESSION['role'] == 'teknisi') {
        header('Location: teknisi/dashboard.php');
    } elseif ($_SESSION['role'] == 'karyawan') {
        header('Location: user/buat-laporan.php');
    }
    exit();
}

if ($_POST) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']);
    $q = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    if (mysqli_num_rows($q)==1) {
        $r = mysqli_fetch_assoc($q);
        $_SESSION['user'] = $r['id'];
        $_SESSION['nama'] = $r['nama'];
        $_SESSION['role'] = $r['role'];
        if ($r['role'] == 'teknisi') {
          header('Location: teknisi/dashboard.php');
          exit();
        } elseif ($r['role'] == 'karyawan') {
            header('Location: user/buat-laporan.php');
            exit();
        }
    } else $error = "Username/password salah!";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login – IT Support Mantos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body,html{height:100%;margin:0;background:#C0C0C0}
    .login-container{height:100vh;display:flex;align-items:center}
    .left-side{
      background: 
        linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)),
        url('assets/img/login-bg.jpg') center/cover no-repeat;
      border-radius:20px 0 0 20px;
      display:flex;
      flex-direction:column;
      justify-content:center;
      align-items:center;
      color:#fff;
      text-align:center;
    }
    .left-side h2{
      font-size:2.5rem;
      letter-spacing:1px;
    }

    .left-side p{
      font-size:1.1rem;
      opacity:0.9;
    }
    .right-side{background:#fff;border-radius:0 20px 20px 0;box-shadow:0 10px 30px rgba(0,0,0,0.1);padding:40px}
    @media(max-width:768px){
      .left-side{display:none}
      .right-side{border-radius:20px}
    }
  </style>
</head>
<body>
<div class="container-fluid login-container">
  <div class="row w-100 shadow-lg" style="max-width:900px;margin:auto">
    <div class="col-md-6 left-side">
      <h2 class="fw-bold">IT Support</h2>
      <p class="mt-2">Manado Town Square</p>
    </div>
    <div class="col-md-6 right-side">
      <h4 class="text-center mb-4">Login</h4>
      <?php if(isset($error)) echo "<div class='alert alert-danger small'>$error</div>"; ?>
      <form method="post">
        <div class="mb-3">
          <input type="text" name="username" class="form-control form-control-lg" placeholder="Username" required>
        </div>
        <div class="mb-4">
          <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-dark w-100 fw-bold">LOGIN</button>
      </form>
      <small class="text-muted d-block text-center mt-4">
        Test: karyawan1 / 123<br>teknisi / 123
      </small>
    </div>
  </div>
</div>
</body>
</html>