<?php
include 'config_query.php'; // Pastikan koneksi database tersedia

// Memulai session
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['id_admin']) || time() > $_SESSION['expire_time']) {
    session_destroy();
    header('Location: ../pages/login.html');
    exit();
}
$_SESSION['expire_time'] = time() + 1800; // Perpanjang sesi 30 menit

$id_admin = $_SESSION['id_admin'];
$type = $_POST['type'];

// Fungsi untuk format tanggal dari input
function formatTanggalReservasi($hari, $bulan, $tahun, $jam)
{
    // Validasi tanggal
    $tanggal = "$tahun-$bulan-$hari $jam:00";
    $date = DateTime::createFromFormat('Y-m-d H:i:s', $tanggal);
    return $date ? $date->format('Y-m-d H:i:s') : null;
}

// Proses data untuk tipe pasien
if ($type === 'pasien') {
    // Ambil data dari form
    $nama_pasien = $_POST['name'];
    $usia = $_POST['usia'];
    $jenis_kelamin = strtoupper($_POST['jenis_kelamin']); // L/P
    $kategori = $_POST['kategori'];
    $id_dokter = $_POST['id_dokter'];

    // Ambil tanggal reservasi
    $hari = $_POST['hari'];
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];
    $jam = $_POST['jam'];

    $tanggal_kunjungan = formatTanggalReservasi($hari, $bulan, $tahun, $jam);

    if (!$tanggal_kunjungan) {
        echo "<script>alert('Tanggal reservasi tidak valid!'); window.history.back();</script>";
        exit();
    }

    // Simpan data pasien ke database
    $sql = "INSERT INTO tb_pasien (id_admin, tanggal_kunjungan, nama_pasien, usia, jenis_kelamin, kategori, id_dokter)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ississi", $id_admin, $tanggal_kunjungan, $nama_pasien, $usia, $jenis_kelamin, $kategori, $id_dokter);

    if ($stmt->execute()) {
        echo "<script>alert('Data Pasien berhasil ditambahkan!'); window.location.href = '../index.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menambahkan data pasien!'); window.history.back();</script>";
    }
}

// Proses data untuk tipe dokter
elseif ($type === 'dokter') {
    $nama_dokter = $_POST['name'];
    $hari_praktik = $_POST['hari_praktik'];
    $jam_praktik = $_POST['jam_praktik'];
    // Bersihkan deskripsi dari tag HTML
    $deskripsi_dokter = isset($_POST['description']) ? strip_tags($_POST['description']) : '';
    $tanggal_update = date('Y-m-d H:i:s');

    // Default nama file foto
    $foto_dokter = '';

    // Simpan data awal ke database tanpa foto
    $sqlInsert = "INSERT INTO tb_dokter (id_admin, nama_dokter, deskripsi_dokter, hari_praktik, jam_praktik, tanggal_update,     foto_dokter) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("issssss", $id_admin, $nama_dokter, $deskripsi_dokter, $hari_praktik, $jam_praktik, $tanggal_update, $foto_dokter);

    if ($stmtInsert->execute()) {
        // Ambil id_dokter yang baru ditambahkan
        $id_dokter = $conn->insert_id;

        // Proses upload foto jika ada
        if (!empty($_FILES['photo']['name'])) {
            $tmp = explode('.', $_FILES['photo']['name']);
            $ext = strtolower(end($tmp));
            $allowed_ext = ["png", "jpg", "jpeg"];
            $max_size = 5120000; // Maksimal 5MB

            if (in_array($ext, $allowed_ext) && $_FILES['photo']['size'] <= $max_size) {
                // Nama file baru
                $new_name = "dokter_{$id_dokter}_{$id_admin}_" . time() . ".{$ext}";
                $target_dir = "../assets/images/";
                $target_file = $target_dir . basename($new_name);

                // Pindahkan file ke direktori
                if (!move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
                    throw new Exception('Gagal mengupload file!');
                }

                // Update foto_dokter di database
                $sqlUpdatePhoto = "UPDATE tb_dokter SET foto_dokter = ? WHERE id_dokter = ?";
                $stmtUpdatePhoto = $conn->prepare($sqlUpdatePhoto);
                $stmtUpdatePhoto->bind_param("si", $new_name, $id_dokter);
                $stmtUpdatePhoto->execute();
            } else {
                echo "<script>alert('Gagal mengupload file!'); window.history.back();</script>";
                exit();
            }
        } else {
            echo "<script>alert('Format file tidak valid atau ukuran melebihi 5MB!'); window.history.back();</script>";
            exit();
        }
    }
    echo "<script>alert('Data Dokter berhasil ditambahkan!'); window.location.href = '../index.php';</script>";
} else {
    echo "<script>alert('Terjadi kesalahan saat menambahkan data dokter!'); window.history.back();</script>";
}

$conn->close();
