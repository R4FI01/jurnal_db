<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Form Pembayaran Manual</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f4f4;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      background-color: white;
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
      width: 400px;
    }

    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 25px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
      color: #555;
    }

    input[type="number"],
    input[type="file"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      box-sizing: border-box;
    }

    button {
      background-color: #3498db;
      color: white;
      padding: 12px;
      width: 100%;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
    }

    button:hover {
      background-color: #2980b9;
    }

  </style>
</head>
<body>
  <div class="container">
    <h2>Form Pembayaran Manual</h2>
    <form action="unggah_bukti_proses.php" method="post" enctype="multipart/form-data">
      <label for="jumlah">Jumlah Pembayaran (Rp):</label>
      <input type="number" name="jumlah" id="jumlah" required>

      <label for="bukti">Unggah Bukti Transfer (.jpg, .png, .pdf):</label>
      <input type="file" name="bukti" id="bukti" accept=".jpg,.png,.pdf" required>

      <button type="submit">Kirim Bukti</button>
    </form>
  </div>
</body>
</html>
