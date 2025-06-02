<?php
session_start();

$admin_username = "admin";
$admin_password = "admin";

$username = $_POST['username'];
$password = $_POST['password'];

if ($username === $admin_username && $password === $admin_password) {
    $_SESSION['admin'] = true;
    header("Location: admin.php");
    exit();
} else {
    echo "<script>alert('Login gagal! Username atau password salah.'); window.location='login.php';</script>";
}
?>
