<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

require_once 'db/config.php';

$query = mysqli_query($conn, "SELECT * FROM jurnal ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Jurnal - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }
        .navbar {
            background-color: #2c3e50;
        }
        .navbar-brand, .nav-link {
            color: white !important;
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
          <a class="nav-link" href="admin.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="pembayaran/verifikasi_pembayaran.php">Verifikasi Pembayaran</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="kelola_pengguna.php">Kelola Pengguna</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout_pengguna.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


<div class="container mt-4">
    <h3 class="mb-4">Daftar Semua Jurnal</h3>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Kategori</th>
                <th>Tahun</th>
                <th>Status</th>
                <th>File</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($query)) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['judul']) ?></td>
                <td><?= htmlspecialchars($row['penulis']) ?></td>
                <td><?= htmlspecialchars($row['kategori']) ?></td>
                <td><?= htmlspecialchars($row['tahun']) ?></td>
                <td>
                      <span class="fw-bold 
                      <?php
                            if ($row['status'] == 'disetujui') echo 'text-success';
                            elseif ($row['status'] == 'ditolak') echo 'text-danger';
                            else echo 'text-warning';
                      ?>">
                            <?= ucfirst($row['status']) ?>
                      </span>
                </td>
                <td>
                    <a class="btn btn-sm btn-primary" href="uploads/<?= htmlspecialchars($row['file_pdf']) ?>" target="_blank">Lihat</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
