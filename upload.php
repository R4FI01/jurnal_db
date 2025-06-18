<?php
session_start();
require_once "db/config.php";

// Hanya bisa diakses setelah login
if (!isset($_SESSION['pengguna_id'])) {
    $_SESSION['error'] = "Silakan login terlebih dahulu.";
    header("Location: login_pengguna.php");
    exit;
}

$pesan = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul     = mysqli_real_escape_string($conn, $_POST['judul']);
    $penulis   = mysqli_real_escape_string($conn, $_POST['penulis']);
    $kategori  = mysqli_real_escape_string($conn, $_POST['kategori']);
    $tahun     = (int)$_POST['tahun'];
    $abstrak   = mysqli_real_escape_string($conn, $_POST['abstrak']);
    $pengguna_id = $_SESSION['pengguna_id'];

    // Validasi file PDF
    $nama_file = $_FILES['file_pdf']['name'];
    $tmp       = $_FILES['file_pdf']['tmp_name'];
    $folder    = "uploads/" . $nama_file;
    $file_ext  = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

    if ($file_ext !== 'pdf' || $_FILES['file_pdf']['type'] !== 'application/pdf') {
        $_SESSION['error'] = "File harus berformat PDF!";
        header("Location: upload.php");
        exit();
    }

    if (move_uploaded_file($tmp, $folder)) {
        $insert = mysqli_query($conn, "INSERT INTO jurnal 
            (judul, penulis, kategori, tahun, abstrak, file_pdf, status, tanggal_upload, pengguna_id) 
            VALUES 
            ('$judul', '$penulis', '$kategori', '$tahun', '$abstrak', '$nama_file', 'pending', NOW(), $pengguna_id)");

        if ($insert) {
            $_SESSION['success'] = "✅ Jurnal berhasil diunggah dan menunggu persetujuan.";
        } else {
            $_SESSION['error'] = "❌ Gagal menyimpan ke database.";
        }
    } else {
        $_SESSION['error'] = "❌ Gagal mengunggah file.";
    }
  
    header("Location: upload.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upload Jurnal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 sticky-top">
    <div class="container">
        <a class="navbar-brand" href="dashboard_pengguna.php">📚 Dashboard Pengguna</a>
        <div class="d-flex">
            <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="card shadow-sm mx-auto" style="max-width: 700px;">
        <div class="card-body">
            <h3 class="card-title mb-4">Form Upload Jurnal</h3>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Judul Jurnal</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Penulis</label>
                    <input type="text" name="penulis" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tahun</label>
                        <input type="number" name="tahun" class="form-control" required min="1900" max="<?= date('Y') ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Abstrak</label>
                    <textarea name="abstrak" class="form-control" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">File PDF</label>
                    <input type="file" name="file_pdf" class="form-control" accept=".pdf" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Upload Jurnal</button>
            </form>
        </div>
    </div>
</div>

<footer class="text-center mt-5 mb-3 text-muted">
    &copy; <?= date("Y") ?> - Sistem Publikasi Jurnal
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
