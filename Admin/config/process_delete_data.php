<?php
// Memulai session
session_start();
if (!isset($_SESSION['username']) || time() > $_SESSION['expire_time']) {
  session_destroy();
  header('Location: ../Admin/pages/login.html');
  exit();
}
$_SESSION['expire_time'] = time() + 1800; // Perpanjang sesi 30 menit

// Include file konfigurasi database
include '../config/config_query.php';

// Fungsi untuk menghapus file foto jika ada
function hapusFoto($fotoName)
{
  $filePath = "../assets/images/" . $fotoName; // Path lengkap ke file foto
  if (!empty($fotoName) && file_exists($filePath)) {
    unlink($filePath);
  }
}

// Periksa tipe data dan ID
if (isset($_GET['type'], $_GET['id'])) {
  $type = $_GET['type'];
  $id = (int)$_GET['id']; // Cast ID menjadi integer untuk keamanan

  if ($type === 'dokter') {
    // Ambil path foto dari database sebelum data dihapus
    $sqlSelect = "SELECT foto_dokter FROM tb_dokter WHERE id_dokter = ?";
    $stmtSelect = $conn->prepare($sqlSelect);
    $stmtSelect->bind_param("i", $id);
    $stmtSelect->execute();
    $result = $stmtSelect->get_result();

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      hapusFoto($row['foto_dokter']); // Hapus file foto jika ada
    }

    // Hapus data dokter dari database
    $sqlDelete = "DELETE FROM tb_dokter WHERE id_dokter = ?";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bind_param("i", $id);
  } elseif ($type === 'pasien') {
    // Hapus data pasien dari database
    $sqlDelete = "DELETE FROM tb_pasien WHERE id_pasien = ?";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bind_param("i", $id);
  } else {
    echo "<script>alert('Tipe data tidak valid!'); window.history.back();</script>";
    exit();
  }

  // Eksekusi query penghapusan
  if ($stmtDelete->execute()) {
    echo "<script>alert('Data berhasil dihapus!'); window.location.href = '../index.php';</script>";
  } else {
    echo "<script>alert('Terjadi kesalahan saat menghapus data!'); window.history.back();</script>";
  }
} else {
  echo "<script>alert('ID atau tipe data tidak ditemukan!'); window.history.back();</script>";
}

$conn->close();
