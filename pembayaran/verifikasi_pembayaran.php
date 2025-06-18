<?php
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
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #eef1f5;
      margin: 0;
      padding: 20px;
    }

    h2 {
      text-align: center;
      color: #333;
    }

    .filter-box {
      text-align: center;
      margin-bottom: 20px;
    }

    .filter-box input[type="text"],
    .filter-box select {
      padding: 8px;
      margin: 5px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    .filter-box button {
      padding: 8px 15px;
      background: #3498db;
      color: #fff;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #2c3e50;
      color: white;
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
  <h2>Verifikasi Pembayaran</h2>

  <div class="filter-box">
    <form method="get">
      <input type="text" name="search" placeholder="Cari nama / jurnal ID..." value="<?= htmlspecialchars($keyword) ?>">
      <select name="status">
        <option value="">Semua Status</option>
        <option value="Menunggu" <?= $status_filter == "Menunggu" ? "selected" : "" ?>>Menunggu</option>
        <option value="Diterima" <?= $status_filter == "Diterima" ? "selected" : "" ?>>Diterima</option>
        <option value="Ditolak" <?= $status_filter == "Ditolak" ? "selected" : "" ?>>Ditolak</option>
      </select>
      <button type="submit">Filter</button>
    </form>
  </div>

  <table>
    <thead>
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
              <img src="../uploads/<?= $row['bukti_transfer'] ?>" alt="Bukti">
            </a>
          </td>
          <td><?= $row['status'] ?></td>
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
</body>
</html>
