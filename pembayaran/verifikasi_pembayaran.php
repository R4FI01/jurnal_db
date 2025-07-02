<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include '../db/config.php';

$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$keyword = isset($_GET['search']) ? $_GET['search'] : '';

$query = "SELECT * FROM pembayaran_manual WHERE 1=1";

if (!empty($status_filter)) {
    $query .= " AND status = '$status_filter'";
}

if (!empty($keyword)) {
    if (is_numeric($keyword)) {
        $query .= " AND (jurnal_id = '$keyword' OR nama_pengguna LIKE '%$keyword%')";
    } else {
        $query .= " AND nama_pengguna LIKE '%$keyword%'";
    }
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Verifikasi Pembayaran</title>
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
    img {
      width: 100px;
      border-radius: 8px;
    }
    .btn-verif {
      padding: 5px 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .btn-acc {
      background: #2ecc71;
      color: white;
    }
    .btn-tolak {
      background: #e74c3c;
      color: white;
    }
    @media screen and (max-width: 768px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }
      th {
        display: none;
      }
      td {
        position: relative;
        padding-left: 50%;
        text-align: left;
      }
      td:before {
        content: attr(data-label);
        position: absolute;
        left: 10px;
        font-weight: bold;
      }
    }
  </style>
</head>
<body>

<!-- Navbar Admin Gaya Konsisten -->
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="../admin.php">Admin Panel</a>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="../admin.php">Dashboard</a>
        </li> 
        <li class="nav-item"> 
          <a class="nav-link" href="../daftar_jurnal_admin.php">Daftar Jurnal</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../kelola_pengguna.php">Kelola Pengguna</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
  <h2 class="text-center mb-4">Verifikasi Pembayaran</h2>

  <div class="filter-box text-center mb-4">
    <form method="get" class="d-flex flex-wrap justify-content-center gap-2">
      <input type="text" name="search" class="form-control w-auto" placeholder="Cari nama / jurnal ID..." value="<?= htmlspecialchars($keyword) ?>">
      <select name="status" class="form-select w-auto">
        <option value="">Semua Status</option>
        <option value="Menunggu" <?= $status_filter == "Menunggu" ? "selected" : "" ?>>Menunggu</option>
        <option value="Diterima" <?= $status_filter == "Diterima" ? "selected" : "" ?>>Diterima</option>
        <option value="Ditolak" <?= $status_filter == "Ditolak" ? "selected" : "" ?>>Ditolak</option>
      </select>
      <button type="submit" class="btn btn-primary">Filter</button>
    </form>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Jurnal ID</th>
          <th>Nama Pengguna</th>
          <th>Jumlah (Rp)</th>
          <th>Bukti</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['jurnal_id'] ?></td>
            <td><?= $row['nama_pengguna'] ?></td>
            <td><?= number_format($row['jumlah'], 0, ',', '.') ?></td>
            <td>
              <a href="../uploads/<?= $row['bukti_transfer'] ?>" target="_blank">
                <img src="../uploads/<?= $row['bukti_transfer'] ?>" alt="Bukti Transfer">
              </a>
            </td>
            <td>
              <span class="badge bg-<?php
                if ($row['status'] == 'Diterima') echo 'success';
                elseif ($row['status'] == 'Ditolak') echo 'danger';
                else echo 'warning';
              ?>">
                <?= $row['status'] ?>
              </span>
            </td>
            <td>
              <?php if($row['status'] == "Menunggu"): ?>
                <a href="verifikasi_proses.php?id=<?= $row['id'] ?>&aksi=acc" class="btn-verif btn-acc">Terima</a>
                <a href="verifikasi_proses.php?id=<?= $row['id'] ?>&aksi=tolak" class="btn-verif btn-tolak">Tolak</a>
              <?php else: ?>
                -
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
