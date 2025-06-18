<?php
session_start();
if (!isset($_SESSION['pengguna_id'])) {
    header("Location: login_pengguna.php");
    exit();
}

$nama = $_SESSION['pengguna_nama'];
$pengguna_id = $_SESSION['pengguna_id'];

require_once 'db/config.php';


$jurnal = mysqli_query($conn, "
    SELECT j.*, 
       (
           SELECT p.status 
           FROM pembayaran_manual p 
           WHERE p.jurnal_id = j.id 
           ORDER BY p.id DESC 
           LIMIT 1
       ) AS status_pembayaran
FROM jurnal j
WHERE j.pengguna_id = '$pengguna_id'
");


$total_jurnal = mysqli_num_rows($jurnal);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pengguna - Jurnal SINTAKS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
        }
        .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .welcome-banner {
            background: linear-gradient(to right, #5c4434, #8c6754);
            color: white;
            padding: 60px 20px;
            text-align: center;
        }
        .card-hover:hover {
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
            transition: 0.3s;
        }
        footer {
            background-color: #5c4434;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .table thead {
            background-color: #e3e3e3;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #5c4434;">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#">Jurnal SINTAKS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="index.php">Lihat Jurnal</a></li>
                <li class="nav-item"><a class="nav-link" href="upload.php">Unggah Jurnal</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="welcome-banner">
    <h1>Halo, <?= htmlspecialchars($nama) ?>!</h1>
    <p>Selamat datang di dashboard Anda. Kelola publikasi jurnal Anda di sini.</p>
</div>

<section class="container mt-5">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card card-hover text-center p-3">
                <i class="bi bi-journal-text fs-1 text-primary"></i>
                <h5 class="mt-3">Jumlah Jurnal</h5>
                <p class="text-muted"><?= $total_jurnal ?> jurnal telah diunggah</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-hover text-center p-3">
                <i class="bi bi-cloud-upload fs-1 text-success"></i>
                <h5 class="mt-3">Unggah Baru</h5>
                <p><a href="upload.php" class="btn btn-success btn-sm">Unggah Sekarang</a></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-hover text-center p-3">
                <i class="bi bi-person-lines-fill fs-1 text-warning"></i>
                <h5 class="mt-3">Profil Pengguna</h5>
                <p><a href="#" class="btn btn-warning btn-sm disabled">Segera Hadir</a></p>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h4>Daftar Jurnal Anda</h4>
        <?php if ($total_jurnal > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                          <th>Judul</th>
                          <th>Penulis</th>
                          <th>Tanggal Unggah</th>
                          <th>Status Pembayaran</th> <!-- Tambahan -->
                          <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($jurnal)): ?>
                            
<!-- Modal Metode Pembayaran -->
<div class="modal fade" id="modalMetode<?= $row['id'] ?>" tabindex="-1" aria-labelledby="modalLabel<?= $row['id'] ?>" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel<?= $row['id'] ?>">Pilih Metode Pembayaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Silakan pilih metode pembayaran untuk jurnal:</p>
        <div class="d-grid gap-2">
          <a href="pembayaran/metode_transfer.php?jurnal_id=<?= $row['id'] ?>" class="btn btn-outline-primary">Transfer Bank</a>
          <a href="pembayaran/metode_qris.php?jurnal_id=<?= $row['id'] ?>" class="btn btn-outline-success">QRIS / e-Wallet</a>
        </div>
      </div>
    </div>
  </div>
</div>

                            <tr>
                                <td><?= htmlspecialchars($row['judul']) ?></td>
                                <td><?= htmlspecialchars($row['penulis']) ?></td>
                                <td><?= htmlspecialchars($row['tanggal_upload']) ?></td>
                                <td>
    <?php
        $status = $row['status_pembayaran'] ?? 'Belum Bayar';
if ($status == 'Menunggu') {
    echo "<span class='badge bg-warning text-dark'>Menunggu</span>";
} elseif ($status == 'Diterima') {
    echo "<span class='badge bg-success'>Diterima</span>";
} elseif ($status == 'Ditolak') {
    echo "<span class='badge bg-danger'>Ditolak</span>";
} else {
    echo "<span class='badge bg-secondary'>Belum Bayar</span>";
}


    ?>
</td>
<td>
    <div class="d-flex gap-1">
        <?php if (!empty($row['file_pdf'])): ?>
            <a href="uploads/<?= htmlspecialchars($row['file_pdf']) ?>" target="_blank" class="btn btn-sm btn-primary">Lihat</a>
        <?php else: ?>
            <span class="text-muted">Belum ada file</span>
        <?php endif; ?>

        
            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalMetode<?= $row['id'] ?>">Bayar</button>

        
    </div>
</td>

                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted">Anda belum mengunggah jurnal.</p>
        <?php endif; ?>
    </div>
</section>

<footer class="mt-5">
    <p>&copy; <?= date('Y') ?> Jurnal SINTAKS</p>
    <small>Dikelola oleh Fakultas Sains & Teknologi</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
