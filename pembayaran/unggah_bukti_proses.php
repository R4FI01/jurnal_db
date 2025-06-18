<?php
include '../db/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $jumlah = $_POST['jumlah'];
    $nama_file = $_FILES['bukti']['name'];
    $tmp_file = $_FILES['bukti']['tmp_name'];
    $folder_upload = "../uploads/"; 

    $jurnal_id = isset($_GET['jurnal_id']) ? $_GET['jurnal_id'] : 0;

   
    $nama_baru = time() . "_" . basename($nama_file);
    $target_path = $folder_upload . $nama_baru;

    
    if (move_uploaded_file($tmp_file, $target_path)) {
        
        session_start(); 

$nama_pengguna = $_SESSION['pengguna_nama'];

$query = "INSERT INTO pembayaran_manual (jurnal_id, nama_pengguna, jumlah, bukti_transfer, status)
          VALUES ('$jurnal_id', '$nama_pengguna', '$jumlah', '$nama_baru', 'Menunggu')";

        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Bukti berhasil dikirim. Tunggu verifikasi admin.'); window.location.href='../index.php';</script>";
        } else {
            echo "Gagal menyimpan ke database: " . mysqli_error($conn);
        }
    } else {
        echo "Upload file gagal.";
    }
} else {
    echo "Akses tidak valid.";
}
?>
