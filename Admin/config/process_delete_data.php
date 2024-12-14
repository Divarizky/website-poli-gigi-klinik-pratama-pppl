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

// Tentukan tipe data (dokter atau pasien) berdasarkan ID
if (isset($_GET['type']) && isset($_GET['id'])) {
  $type = $_GET['type'];
  $id = $_GET['id'];
  if ($type === 'dokter') {
    $sql = "DELETE FROM tb_dokter WHERE id_dokter = $id";
  } else if ($type === 'pasien') {
    $sql = "DELETE FROM tb_pasien WHERE id_pasien = $id";
  } else {
    echo "<script>alert('Tipe data tidak valid!'); window.history.back();</script>";
    exit();
  }
  if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Data berhasil dihapus!'); window.location.href = '../index.php';</script>";
  } else {
    echo "<script>alert('Terjadi kesalahan saat menghapus data!'); window.history.back();</script>";
  }
} else {
  echo "<script>alert('ID atau tipe data tidak ditemukan!'); window.history.back();</script>";
}
