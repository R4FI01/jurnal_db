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
    <title>Pembayaran via QRIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

    <h2>Pembayaran via QRIS / E-Wallet</h2>
    <p>Silakan scan QR Code di bawah ini untuk melakukan pembayaran:</p>

    <img src="qris.jpg" alt="QRIS Code" width="300" class="my-3 border rounded">

    <ul class="list-group mb-4">
        <li class="list-group-item">Nama Merchant: <strong>Jurnal SINTAKS</strong></li>
        <li class="list-group-item">Jumlah: <strong>Rp 50.000</strong></li>
    </ul>

    <p>Setelah membayar, silakan unggah bukti pembayaran Anda.</p>

    <a href="unggah_bukti.php?jurnal_id=<?= $jurnal_id ?>" class="btn btn-success">Unggah Bukti Pembayaran</a>
    <a href="../dashboard_pengguna.php" class="btn btn-success ">Kembali ke Dashboard</a>

</body>
</html>
