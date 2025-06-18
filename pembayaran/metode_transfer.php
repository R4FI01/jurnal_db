<?php
if (!isset($_GET['jurnal_id'])) {
    echo "ID Jurnal tidak ditemukan.";
    exit;
}
$jurnal_id = $_GET['jurnal_id'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran via Transfer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

    <h2>Pembayaran via Transfer Bank</h2>
    <p>Silakan transfer biaya publikasi ke rekening berikut:</p>

    <ul class="list-group mb-4">
        <li class="list-group-item">Bank: <strong>BCA</strong></li>
        <li class="list-group-item">No Rekening: <strong>1234567890</strong></li>
        <li class="list-group-item">Atas Nama: <strong>Admin Jurnal SINTAKS</strong></li>
        <li class="list-group-item">Jumlah: <strong>Rp 50.000</strong></li>
    </ul>

    <p>Setelah melakukan transfer, silakan unggah bukti pembayaran Anda.</p>

    <a href="unggah_bukti.php?jurnal_id=<?= $jurnal_id ?>" class="btn btn-primary">Unggah Bukti Pembayaran</a>
    <a href="../dashboard_pengguna.php" class="btn btn-primary ">Kembali ke Dashboard</a>

</body>
</html>
