<?php
include 'config_query.php'; // Memastikan koneksi ke database sudah ada

// Fungsi untuk mendapatkan data lama berdasarkan ID
function getDataLama($type, $id)
{
  global $conn;
  $table = ($type === 'dokter') ? 'tb_dokter' : 'tb_pasien';
  $id_field = ($type === 'dokter') ? 'id_dokter' : 'id_pasien';

  $sql = "SELECT * FROM $table WHERE $id_field = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  return $stmt->get_result()->fetch_assoc();
}

// Fungsi untuk mengupload gambar dengan format baru
function uploadGambar($file, $id_dokter, $id_admin)
{
  $tmp = explode('.', $file['name']);
  $ext = strtolower(end($tmp));
  $allowed_ext = ["png", "jpg", "jpeg"];

  if (!in_array($ext, $allowed_ext) || $file['size'] > 5120000) { // Validasi format & ukuran
    echo "<script>alert('Format file tidak valid atau ukuran melebihi 5MB!'); window.history.back();</script>";
    return false;
  }

  // Nama file baru: dokter_[id_dokter]_[id_admin]_timestamp.ext
  $new_name = "dokter_{$id_dokter}_{$id_admin}_" . time() . ".{$ext}";
  $path = "../assets/images/" . $new_name;

  if (move_uploaded_file($file['tmp_name'], $path)) {
    return $new_name; // Mengembalikan nama file baru
  } else {
    echo "<script>alert('Gagal mengupload file!'); window.history.back();</script>";
    return false;
  }
}

// Fungsi untuk mengupdate data dokter
function updateDokter($id_dokter, $id_admin, $name, $description, $hari_praktik, $jam_praktik, $photoName = null)
{
  global $conn;
  $setPhoto = $photoName ? ", foto_dokter = ?" : "";
  $sql = "UPDATE tb_dokter 
            SET nama_dokter = ?, deskripsi_dokter = ?, hari_praktik = ?, jam_praktik = ?, tanggal_update = NOW() 
            $setPhoto
            WHERE id_dokter = ?";
  $stmt = $conn->prepare($sql);

  if ($photoName) {
    $stmt->bind_param("sssssi", $name, $description, $hari_praktik, $jam_praktik, $photoName, $id_dokter);
  } else {
    $stmt->bind_param("ssssi", $name, $description, $hari_praktik, $jam_praktik, $id_dokter);
  }
  return $stmt->execute();
}

// Fungsi untuk mengupdate data pasien
function updatePasien($id, $name, $description)
{
  global $conn;
  $sql = "UPDATE tb_pasien 
            SET nama_pasien = ?, description = ?, tanggal_update = NOW()
            WHERE id_pasien = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssi", $name, $description, $id);
  return $stmt->execute();
}

// Ambil data dari form
session_start();
$id_admin = $_SESSION['id_admin']; // Menangkap id_admin dari sesi
$type = $_POST['type'];
$id = $_POST['id'];
$name = $_POST['name'];
$description = $_POST['description'];

if ($type === 'dokter') {
  $hari_praktik = $_POST['hari_praktik'];
  $jam_praktik = $_POST['jam_praktik'];
  $photo = $_FILES['photo'];

  // Ambil data lama
  $dataLama = getDataLama('dokter', $id);
  if (!$dataLama) {
    echo "<script>alert('Data dokter tidak ditemukan!'); window.history.back();</script>";
    exit();
  }

  // Gunakan data lama jika deskripsi kosong
  $description = empty($description) ? $dataLama['deskripsi_dokter'] : $description;

  // Upload foto jika ada, gunakan id_dokter dan id_admin
  $photoName = null;
  if (!empty($photo['name'])) {
    $photoName = uploadGambar($photo, $id, $id_admin); // Nama file baru
    if (!$photoName) {
      exit(); // Hentikan proses jika upload gagal
    }
  } else {
    $photoName = $dataLama['foto_dokter']; // Jika tidak ada upload foto, gunakan foto lama
  }

  // Update data dokter
  if (updateDokter($id, $id_admin, $name, $description, $hari_praktik, $jam_praktik, $photoName)) {
    echo "<script>alert('Data Dokter berhasil diubah!'); window.location.href = '../index.php';</script>";
  } else {
    echo "<script>alert('Terjadi kesalahan saat mengubah data dokter!'); window.history.back();</script>";
  }
} elseif ($type === 'pasien') {
  $dataLama = getDataLama('pasien', $id);
  if (!$dataLama) {
    echo "<script>alert('Data pasien tidak ditemukan!'); window.history.back();</script>";
    exit();
  }

  // Gunakan data lama jika deskripsi kosong
  $description = empty($description) ? $dataLama['description'] : $description;

  // Update data pasien
  if (updatePasien($id, $name, $description)) {
    echo "<script>alert('Data Pasien berhasil diubah!'); window.location.href = '../index.php';</script>";
  } else {
    echo "<script>alert('Terjadi kesalahan saat mengubah data pasien!'); window.history.back();</script>";
  }
} else {
  echo "<script>alert('Tipe data tidak valid!'); window.history.back();</script>";
}

$conn->close();
