<?php
// Memulai session
session_start();
if (!isset($_SESSION['username']) || time() > $_SESSION['expire_time']) {
  session_destroy();
  header('Location: ../pages/login.html');
  exit();
}
$_SESSION['expire_time'] = time() + 1800; // Perpanjang sesi 30 menit

// Include file konfigurasi database
include '../config/config_query.php';

// Tentukan tipe data (dokter atau pasien) berdasarkan parameter URL
$type = isset($_GET['type']) ? $_GET['type'] : 'dokter';
$isDoctor = $type === 'dokter';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hapus Data <?php echo ucfirst($type); ?></title>
  <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>

</body>

</html>