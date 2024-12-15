<?php
include 'config_query.php'; // Pastikan koneksi database tersedia

// Memulai session
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['id_admin']) || time() > $_SESSION['expire_time']) {
    session_destroy();
    header('Location: ../Admin/pages/login.html');
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
    $deskripsi_dokter = $_POST['description'];

    $sql = "INSERT INTO tb_dokter (id_admin, nama_dokter, deskripsi_dokter, hari_praktik, jam_praktik, tanggal_update) 
            VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $id_admin, $nama_dokter, $deskripsi_dokter, $hari_praktik, $jam_praktik);

    if ($stmt->execute()) {
        echo "<script>alert('Data Dokter berhasil ditambahkan!'); window.location.href = '../index.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menambahkan data dokter!'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Tipe data tidak valid!'); window.history.back();</script>";
}

$conn->close();
