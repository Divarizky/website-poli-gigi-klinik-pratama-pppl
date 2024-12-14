<?php
include 'config_query.php'; // Memastikan koneksi ke database sudah ada

// Ambil data dari form
$type = $_POST['type'];
$id = $_POST['id'];
$name = $_POST['name'];
$description = $_POST['description'];

// Proses data untuk tipe dokter
if ($type === 'dokter') {
  $hari_praktik = $_POST['hari_praktik'];
  $jam_praktik = $_POST['jam_praktik'];
  $photo = $_FILES['photo'];

  // Cek apakah ada foto yang diupload
  if ($photo['name']) {
    $photoPath = '../assets/images/' . basename($photo['name']);
    move_uploaded_file($photo['tmp_name'], $photoPath);
  } else {
    $photoPath = null;
  }

  // Update data dokter
  $sql = "UPDATE tb_dokter SET 
                nama_dokter = '$name', 
                hari_praktik = '$hari_praktik', 
                jam_praktik = '$jam_praktik', 
                description = '$description', 
                tanggal_update = NOW()";

  if ($photoPath) {
    $sql .= ", foto_dokter = '$photoPath'";
  }

  $sql .= " WHERE id_dokter = $id";

  if ($conn->query($sql)) {
    echo "<script>alert('Data Dokter berhasil diubah!'); window.location.href = '../pages/index.php';</script>";
  } else {
    echo "<script>alert('Terjadi kesalahan saat mengubah data dokter!'); window.history.back();</script>";
  }
} else {
  // Update data pasien
  $sql = "UPDATE tb_pasien SET 
                nama_pasien = '$name', 
                description = '$description', 
                tanggal_update = NOW() 
                WHERE id_pasien = $id";

  if ($conn->query($sql)) {
    echo "<script>alert('Data Pasien berhasil diubah!'); window.location.href = '../pages/index.php';</script>";
  } else {
    echo "<script>alert('Terjadi kesalahan saat mengubah data pasien!'); window.history.back();</script>";
  }
}
