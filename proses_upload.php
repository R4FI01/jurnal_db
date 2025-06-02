<?php
include "db/config.php";

$judul = $_POST['judul'];
$penulis = $_POST['penulis'];
$tahun = $_POST['tahun'];
$kategori = $_POST['kategori'];
$abstrak = $_POST['abstrak'];

$target_dir = "uploads/";
$file_name = basename($_FILES["file_pdf"]["name"]);
$target_file = $target_dir . $file_name;

if (move_uploaded_file($_FILES["file_pdf"]["tmp_name"], $target_file)) {
    $sql = "INSERT INTO jurnal (judul, penulis, tahun, kategori, abstrak, file_pdf, tanggal_upload, status)
        VALUES ('$judul', '$penulis', $tahun, '$kategori', '$abstrak', '$file_name', NOW(), 'pending')";
    mysqli_query($conn, $query);
    header("Location: index.php");
} else {
    echo "Upload gagal.";
}
?>
