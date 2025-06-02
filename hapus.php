<?php
include 'db/config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $result = mysqli_query($conn, "SELECT file_pdf FROM jurnal WHERE id = $id");
    $data = mysqli_fetch_assoc($result);
    $file_pdf = $data['file_pdf'];

    $query = mysqli_query($conn, "DELETE FROM jurnal WHERE id = $id");

    if ($query) {
        if (file_exists("uploads/" . $file_pdf)) {
            unlink("uploads/" . $file_pdf);
        }

        header("Location: admin.php?pesan=sukses");
    } else {
        echo "Gagal menghapus data";
    }
}
?>
