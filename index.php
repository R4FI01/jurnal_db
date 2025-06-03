<?php
require_once "db/config.php";

// Inisialisasi pencarian dan filter
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$kategori = isset($_GET['kategori']) ? mysqli_real_escape_string($conn, $_GET['kategori']) : '';

// Pagination setup
$perPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $perPage;

// Query total data
$total = $conn->query("SELECT COUNT(*) as total FROM jurnal WHERE status='disetujui'")->fetch_assoc()['total'];
$pages = ceil($total / $perPage);

// Query data jurnal
$query = "SELECT * FROM jurnal WHERE status = 'disetujui'";
if ($search !== '') $query .= " AND judul LIKE '%$search%'";
if ($kategori !== '') $query .= " AND kategori = '$kategori'";
$query .= " ORDER BY id DESC LIMIT $start, $perPage";
$result = mysqli_query($conn, $query);

// Ambil kategori unik
$kategori_result = mysqli_query($conn, "SELECT DISTINCT kategori FROM jurnal WHERE status = 'disetujui'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jurnal Disetujui</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f4f8;
            margin: 0;
            padding: 40px;
            color: #1f2937;
        }
        .container {
            max-width: 960px;
            margin: auto;
        }
        h2 {
            font-size: 30px;
            margin-bottom: 25px;
            font-weight: bold;
            text-align: center;
        }
        .search-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 25px;
        }
        .search-bar input,
        .search-bar select {
            flex: 1;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        .btn-search {
            padding: 10px 16px;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .btn-search:hover {
            background-color: #1d4ed8;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            margin-bottom: 18px;
        }
        .card h3 {
            margin: 0 0 10px;
            color: #111827;
        }
        .card p {
            margin: 4px 0;
            font-size: 14px;
        }
        .card a {
            color: #1d4ed8;
            text-decoration: none;
            font-weight: 500;
        }
        .card a:hover {
            text-decoration: underline;
        }
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 30px;
        }
        .pagination a {
            padding: 8px 12px;
            background: #e5e7eb;
            border-radius: 6px;
            color: #111827;
            text-decoration: none;
        }
        .pagination a.active {
            background: #1d4ed8;
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>📄 Daftar Jurnal Disetujui</h2>

    <form class="search-bar" method="GET" action="">
        <input type="text" name="search" placeholder="Cari judul..." value="<?= htmlspecialchars($search) ?>">
        <select name="kategori">
            <option value="">Semua Kategori</option>
            <?php while ($kat = mysqli_fetch_assoc($kategori_result)): ?>
                <option value="<?= $kat['kategori'] ?>" <?= ($kategori === $kat['kategori']) ? 'selected' : '' ?>>
                    <?= $kat['kategori'] ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button type="submit" class="btn-search">Cari</button>
    </form>

    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="card">
            <h3><?= strtoupper($row['judul']) ?></h3>
            <p><strong>Penulis:</strong> <?= $row['penulis'] ?></p>
            <p><strong>Kategori:</strong> <?= $row['kategori'] ?></p>
            <p><strong>Tahun:</strong> <?= $row['tahun'] ?></p>
            <p><strong>File:</strong> <a href="uploads/<?= $row['file_pdf'] ?>" target="_blank">Lihat</a></p>
        </div>
    <?php endwhile; ?>

    <div class="pagination">
        <?php for ($i = 1; $i <= $pages; $i++): ?>
            <a href="?search=<?= urlencode($search) ?>&kategori=<?= urlencode($kategori) ?>&page=<?= $i ?>"
               class="<?= ($i === $page) ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</div>
</body>
</html>
