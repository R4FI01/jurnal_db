<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Beranda - Jurnal SINTAKS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .navbar {
            background-color: #5c4434;
        }

        .sticky-top {
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .nav-link {
            color: white !important;
        }

        .nav-link:hover {
            text-decoration: underline;
        }

        .hero {
            background: url('background.jpeg') center/cover no-repeat;
            height: 100vh;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.6);
        }

        footer {
            background-color: rgb(64, 56, 52);
            color: white;
        }
    </style>
</head>
<body>

<!-- Sticky Navbar -->
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand text-white fw-bold" href="#">Jurnal SINTAKS</a>
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="index.php">Daftar Jurnal</a></li>
                <li class="nav-item"><a class="nav-link" href="upload.php">Unggah Jurnal</a></li>

                <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item"><a class="nav-link" href="#">Halo, <?= htmlspecialchars($_SESSION['username']) ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login_pengguna.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Daftar Akun</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="hero text-center">
    <h1 class="display-5 fw-bold mt-3">Selamat Datang di Website Jurnal SINTAKS</h1>
    <p class="lead">
        <?php if (isset($_SESSION['username'])): ?>
            Selamat datang kembali, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>! Temukan jurnal terbaru untuk Anda.
        <?php else: ?>
            Temukan, unggah, dan akses berbagai jurnal ilmiah dari berbagai bidang studi.
        <?php endif; ?>
    </p>
</div>

<!-- Tentang -->
<section class="container my-5">
    <h2 class="text-center mb-4">Tentang Jurnal SINTAKS</h2>
    <div class="row text-center">
        <div class="col-md-4">
            <i class="bi bi-upload fs-1 text-primary"></i>
            <h5 class="mt-3">Unggah Jurnal</h5>
            <p>Mahasiswa dan dosen dapat mengunggah karya ilmiah dengan mudah.</p>
        </div>
        <div class="col-md-4">
            <i class="bi bi-book fs-1 text-success"></i>
            <h5 class="mt-3">Akses Mudah</h5>
            <p>Semua jurnal dapat diakses secara terbuka oleh siapa saja.</p>
        </div>
        <div class="col-md-4">
            <i class="bi bi-search fs-1 text-warning"></i>
            <h5 class="mt-3">Pencarian Cepat</h5>
            <p>Fitur pencarian membantu menemukan jurnal berdasarkan topik atau penulis.</p>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="py-4 text-center">
    <p class="mb-1">&copy; <?= date('Y') ?> Jurnal SINTAKS</p>
    <small class="text-muted">Dikelola oleh Fakultas Sains & Teknologi</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
