<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Beranda - Jurnal SINTAKS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
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

        .nav-link {
            color: white !important;
        }

        .nav-link:hover {
            text-decoration: underline;
        }

        footer {
            background-color:rgb(64, 56, 52);
            color: white;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg" style="background-color: #5c4434;">
        <div class="container-fluid">
            <a class="navbar-brand text-white fw-bold" href="#">Jurnal SINTAKS</a>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Daftar Jurnal</a></li>
                    <li class="nav-item"><a class="nav-link" href="upload.php">Unggah Jurnal</a></li>
                    <li class="nav-item"><a class="nav-link" href="login_pengguna.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Daftar Akun</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero text-center">
        <h1 class="display-5 fw-bold mt-3">Selamat Datang di Website Jurnal SINTAKS</h1>
        <p class="lead">Temukan, unggah, dan akses berbagai jurnal ilmiah dari berbagai bidang studi.</p>
        <a href="#" class="btn btn-primary btn-lg mt-3">Lihat Jurnal</a>
    </div>

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

    <footer class="py-4 text-center">
        <p class="mb-1">&copy; <?= date('Y') ?> Jurnal SINTAKS </p>
        <small class="text-muted">Dikelola oleh Fakultas Sains & Teknologi</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
