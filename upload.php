<?php
session_start();
if (isset($_SESSION['success'])) {
    echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
}

require_once "db/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $kategori = $_POST['kategori'];
    $tahun = $_POST['tahun'];
    $abstrak = $_POST['abstrak'];

    $nama_file = $_FILES['file_pdf']['name'];
    $tmp = $_FILES['file_pdf']['tmp_name'];
    $folder = "uploads/" . $nama_file;
    $allowed_ext = 'pdf';
    $file_ext = strtolower(pathinfo($_FILES['jurnal']['name'], PATHINFO_EXTENSION));

    if ($file_ext !== $allowed_ext || $_FILES['jurnal']['type'] !== 'application/pdf') {
        $_SESSION['error'] = "File harus berformat PDF!";
        header("Location: upload.php");
        exit();
    }


    if (move_uploaded_file($tmp, $folder)) {
        $insert = mysqli_query($conn, "INSERT INTO jurnal (judul, penulis, kategori, tahun, abstrak, file_pdf, status, tanggal_upload) 
                    VALUES ('$judul', '$penulis', '$kategori', '$tahun', '$abstrak', '$nama_file', 'pending', NOW())");
        $pesan = $insert ? "Jurnal berhasil diunggah dan menunggu persetujuan." : "Gagal menyimpan ke database.";
    } else {
        $pesan = "Gagal mengunggah file.";
    }
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

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">📚 Sistem Publikasi Jurnal</a>
    </div>
</nav>

<div class="container">
    <div class="card shadow-sm mx-auto" style="max-width: 700px;">
        <div class="card-body">
            <h3 class="card-title mb-4">Form Upload Jurnal</h3>

            <?php if (!empty($pesan)): ?>
                <div class="alert alert-info"><?= $pesan ?></div>
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
                        <input type="number" name="tahun" class="form-control" required>
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
