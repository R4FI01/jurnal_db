<?php
require_once 'db/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $cek = mysqli_query($conn, "SELECT * FROM pengguna WHERE email='$email'");
    if (mysqli_num_rows($cek) > 0) {
        $error = "Email sudah terdaftar!";
    } else {
        $query = mysqli_query($conn, "INSERT INTO pengguna (nama, email, password) VALUES ('$nama', '$email', '$password')");
        if ($query) {
            header("Location: login_pengguna.php");
            exit();
        } else {
            $error = "Registrasi gagal. Coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun Pengguna</title>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right,rgb(194, 131, 14), #2563eb);
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-container {
            background: #ffffff;
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            width: 380px;
            animation: fadeInUp 0.8s ease-out;
        }

        h2 {
            text-align: center;
            color: #2563eb;
            margin-bottom: 25px;
            font-size: 24px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 18px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        input:focus {
            border-color:#2563eb;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #2563eb;
        }

        .error {
            background: #fee2e2;
            color: #b91c1c;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
        }

        .footer-link {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        .footer-link a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }

        .footer-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>📝 Daftar Akun Pengguna</h2>
        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="POST">
            <input type="text" name="nama" placeholder="Nama Lengkap" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Daftar</button>
        </form>
        <div class="footer-link">
            Sudah punya akun? <a href="login_pengguna.php">Login di sini</a>
        </div>
    </div>
</body>
</html>
