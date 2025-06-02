<?php
require_once "db/config.php";

$search = '';
$kategori = '';

$query = "SELECT * FROM jurnal WHERE status = 'disetujui'";

if (isset($_GET['search']) && $_GET['search'] !== '') {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $query .= " AND judul LIKE '%$search%'";
}

if (isset($_GET['kategori']) && $_GET['kategori'] !== '') {
    $kategori = mysqli_real_escape_string($conn, $_GET['kategori']);
    $query .= " AND kategori = '$kategori'";
}

if (!isset($_SESSION['pengguna'])) {
    header("Location: login_pengguna.php");
    exit();
}

$query .= " ORDER BY id DESC";
$result = mysqli_query($conn, $query);

$perPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

$total = $conn->query("SELECT COUNT(*) as total FROM jurnal WHERE status='disetujui'")->fetch_assoc()['total'];
$pages = ceil($total / $perPage);

$query = $conn->query("SELECT * FROM jurnal WHERE status='disetujui' ORDER BY id DESC LIMIT $start, $perPage");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Jurnal yang Disetujui</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f8fafc;
            margin: 0;
            padding: 40px;
            color: #1e293b;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        h2 {
            font-size: 28px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .search-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
        }

        .search-bar input,
        .search-bar select {
            padding: 10px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
            flex: 1;
        }

        .btn-search {
            background: #1d4ed8;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 16px;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-search:hover {
            background: #1e40af;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .card h3 {
            margin: 0 0 10px;
            font-size: 18px;
            color: #0f172a;
            font-weight: 600;
        }

        .card p {
            margin: 4px 0;
            font-size: 14px;
            color: #334155;
        }

        .card a {
            color: #2563eb;
            font-weight: 500;
            text-decoration: none;
        }

        .card a:hover {
            text-decoration: underline;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 30px;
        }

        .pagination a {
            padding: 8px 12px;
            background: #e2e8f0;
            border-radius: 6px;
            text-decoration: none;
            color: #1e293b;
            font-weight: 500;
            transition: 0.2s;
        }

        .pagination a:hover {
            background: #cbd5e1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📚 Daftar Jurnal yang Disetujui</h2>

        <div class="search-bar">
            <input type="text" placeholder="Cari judul..." />
            <select>
                <option>Semua Kategori</option>
                <!-- Bisa diisi kategori dari database -->
            </select>
            <button class="btn-search">Cari</button>
        </div>

        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <div class="card">
                <h3><?php echo strtoupper($row['judul']); ?></h3>
                <p><strong>Penulis:</strong> <?php echo $row['penulis']; ?></p>
                <p><strong>Kategori:</strong> <?php echo $row['kategori']; ?></p>
                <p><strong>Tahun:</strong> <?php echo $row['tahun']; ?></p>
                <p><strong>File:</strong>  <a class="link-lihat" href="uploads/<?= $row['file_pdf'] ?>" target="_blank">Lihat</a></p>
            </div>
        <?php endwhile; ?>

        <div class="pagination">
            <a href="#">1</a>
            <a href="#">2</a>
        </div>
    </div>
</body>
</html>