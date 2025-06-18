<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

require_once 'db/config.php';

if (isset($_GET['aksi']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $aksi = $_GET['aksi'] === 'setujui' ? 'disetujui' : 'ditolak';

    $update = mysqli_query($conn, "UPDATE jurnal SET status='$aksi' WHERE id=$id");
    if ($update) {
        $_SESSION['success'] = "Status jurnal berhasil diperbarui.";
    } else {
        $_SESSION['error'] = "Gagal memperbarui status jurnal.";
    }
    header("Location: admin.php");
    exit();
}

$query = mysqli_query($conn, "SELECT * FROM jurnal ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #eef1f5;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logout-btn {
            padding: 8px 16px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
        .alert {
            padding: 10px;
            margin: 15px 0;
            border-radius: 5px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        table {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
        .btn {
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
            margin-right: 4px;
        }
        .btn-approve {
            background-color: #28a745;
            color: white;
        }
        .btn-reject {
            background-color: #dc3545;
            color: white;
        }
        .btn-delete {
            background-color: #6c757d;
            color: white;
        }
        .status-disetujui {
            color: green;
            font-weight: bold;
        }
        .status-pending {
            color: orange;
            font-weight: bold;
        }
        .status-ditolak {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <h2>Selamat Datang, Admin!</h2>
        <a class="logout-btn" href="logout.php">Logout</a>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <h3>Daftar Jurnal</h3>
    <table>
        <tr>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Kategori</th>
            <th>Tahun</th>
            <th>Status</th>
            <th>File</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($query)) { ?>
        <tr>
            <td><?= htmlspecialchars($row['judul']) ?></td>
            <td><?= htmlspecialchars($row['penulis']) ?></td>
            <td><?= htmlspecialchars($row['kategori']) ?></td>
            <td><?= htmlspecialchars($row['tahun']) ?></td>
            <td class="status-<?= strtolower($row['status']) ?>">
                <?= ucfirst($row['status']) ?>
            </td>
            <td><a href="uploads/<?= htmlspecialchars($row['file_pdf']) ?>" target="_blank">Lihat</a>
            <a href="pembayaran/verifikasi_pembayaran.php">Verifikasi Pembayaran</a>
        </td>
            <td>
                <?php if ($row['status'] === 'pending') { ?>
                    <a class="btn btn-approve" href="?aksi=setujui&id=<?= $row['id'] ?>" onclick="return confirm('Setujui jurnal ini?')">Setujui</a>
                    <a class="btn btn-reject" href="?aksi=tolak&id=<?= $row['id'] ?>" onclick="return confirm('Tolak jurnal ini?')">Tolak</a>
                <?php } ?>
                <a class="btn btn-delete" href="hapus.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus jurnal ini?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
