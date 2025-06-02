<?php
include "db/config.php";
$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM jurnal WHERE status = 'disetujui' ORDER BY tanggal_upload DESC");
$data = mysqli_fetch_assoc($result);
?>

<h2><?php echo $data['judul']; ?></h2>
<p><strong>Penulis:</strong> <?php echo $data['penulis']; ?></p>
<p><strong>Tahun:</strong> <?php echo $data['tahun']; ?></p>
<p><strong>Kategori:</strong> <?php echo $data['kategori']; ?></p>
<p><strong>Abstrak:</strong><br><?php echo $data['abstrak']; ?></p>
<a href="uploads/<?php echo $data['file_pdf']; ?>" target="_blank">Download PDF</a>
