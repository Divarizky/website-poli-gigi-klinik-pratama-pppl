<?php
session_start();
include 'config_query.php'; // Memanggil file konfigurasi database

$username = $_POST['username'];
$password = $_POST['password'];

// Verifikasi username dan password
$admin = verifikasiLogin($username, $password);

if ($admin) {
    // Login berhasil
    $_SESSION['username'] = $admin['username'];
    $_SESSION['expire_time'] = time() + 1800; // 30 menit
    header('Location: ../index.php'); // Mengarahkan ke index.php yang ada di folder terluar
    exit(); // Jangan lupa exit untuk menghentikan script lebih lanjut
} else {
    // Login gagal
    echo "<script>
            alert('Username atau password salah!');
            window.location.href = '../pages/login.html';
          </script>";
}
