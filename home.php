<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Beranda - Website Jurnal SINTAKS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: Arial, sans-serif;
    }

    .navbar {
        background-color: #5a4a3f !important; 
    }

    .hero-section {
        background-image: url('background.jpg');
        background-size: cover;
        background-position: center;
        height: 100vh;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 0 20px;
    }

    .hero-section h1 {
        font-size: 48px;
        font-weight: bold;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
    }

    .hero-section p {
        font-size: 20px;
        margin-top: 10px;
        margin-bottom: 20px;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
    }

    .hero-section .btn {
        padding: 10px 25px;
        font-size: 18px;
    }

    .footer {
        position: absolute;
        bottom: 10px;
        width: 100%;
        text-align: center;
        color: white;
        text-shadow: 1px 1px 2px black;
    }
</style>

</head>
<body>

<div class="overlay"></div>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="#">Jurnal SINTAKS</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Daftar Jurnal</a></li>
        <li class="nav-item"><a class="nav-link" href="upload.php">Unggah Jurnal</a></li>
        <li class="nav-item"><a class="nav-link" href="login_pengguna.php">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="register.php">Daftar Akun</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="hero-section">
  <h1>Selamat Datang di Website Jurnal SINTAKS</h1>
  <p>Temukan, unggah, dan akses berbagai jurnal ilmiah dari.</p>
  <a href="index.php" class="btn btn-primary">Lihat Jurnal</a>
</div>

<div class="footer">
  &copy; 2025 All rights reserved.
</div>

<footer>
    &copy; <?= date("Y") ?>  All rights reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
