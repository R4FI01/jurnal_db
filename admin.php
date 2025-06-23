<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

require_once 'db/config.php';

$total_jurnal = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM jurnal"));
$total_diterima = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM jurnal WHERE status = 'disetujui'"));
$total_ditolak = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM jurnal WHERE status = 'ditolak'"));
$total_pengguna = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pengguna"));

$latest_jurnal = mysqli_query($conn, "SELECT * FROM jurnal ORDER BY id DESC LIMIT 5");
$latest_pengguna = mysqli_query($conn, "SELECT * FROM pengguna ORDER BY id DESC LIMIT 5");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }
        .navbar {
            background-color: #2c3e50;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        .container {
            margin-top: 120px;
        }
        .section-title {
            border-left: 5px solid #3498db;
            padding-left: 10px;
            margin-top: 40px;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="admin.php">Admin Panel</a>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="daftar_jurnal.php">Daftar Jurnal</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="pembayaran/verifikasi_pembayaran.php">Verifikasi Pembayaran</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="kelola_pengguna.php">Kelola Pengguna</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
    <div class="alert alert-info text-center">
        <strong>Informasi Terbaru:</strong> Pastikan untuk memverifikasi jurnal dan pembayaran setiap hari.
    </div>

    <div class="row text-center mb-4">
        <div class="col-md-3">
            <div class="card border-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Jurnal</h5>
                    <p class="card-text fs-4 fw-bold text-primary"><?= $total_jurnal ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body">
                    <h5 class="card-title">Diterima</h5>
                    <p class="card-text fs-4 fw-bold text-success"><?= $total_diterima ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-danger">
                <div class="card-body">
                    <h5 class="card-title">Ditolak</h5>
                    <p class="card-text fs-4 fw-bold text-danger"><?= $total_ditolak ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-dark">
                <div class="card-body">
                    <h5 class="card-title">Total Pengguna</h5>
                    <p class="card-text fs-4 fw-bold text-dark"><?= $total_pengguna ?></p>
                </div>
            </div>
        </div>
    </div>

    <h4 class="section-title">Jurnal Terbaru</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Kategori</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while($j = mysqli_fetch_assoc($latest_jurnal)): ?>
            <tr>
                <td><?= htmlspecialchars($j['judul']) ?></td>
                <td><?= htmlspecialchars($j['penulis']) ?></td>
                <td><?= htmlspecialchars($j['kategori']) ?></td>
                <td>
                    <span class="badge bg-<?php
                        if ($j['status'] == 'disetujui') echo 'success';
                        elseif ($j['status'] == 'ditolak') echo 'danger';
                        else echo 'warning';
                    ?>">
                        <?= ucfirst($j['status']) ?>
                    </span>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h4 class="section-title">Pengguna Terbaru</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php while($p = mysqli_fetch_assoc($latest_pengguna)): ?>
            <tr>
                <td><?= htmlspecialchars($p['nama']) ?></td>
                <td><?= htmlspecialchars($p['email']) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
