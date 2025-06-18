<?php
include '../db/config.php';

if (isset($_GET['id']) && isset($_GET['aksi'])) {
    $id = intval($_GET['id']);
    $aksi = $_GET['aksi'];

    if ($aksi == 'acc') {
        $status = 'Diterima';
    } elseif ($aksi == 'tolak') {
        $status = 'Ditolak';
    } else {
        die("Aksi tidak valid.");
    }

    // Update status di tabel pembayaran_manual
    $query = "UPDATE pembayaran_manual SET status = '$status' WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        header("Location: verifikasi_pembayaran.php");
        exit();
    } else {
        echo "Gagal mengubah status: " . mysqli_error($conn);
    }
} else {
    echo "Parameter tidak lengkap.";
}
?>
