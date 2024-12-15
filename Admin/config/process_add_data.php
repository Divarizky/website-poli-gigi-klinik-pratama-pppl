<?php
include 'config_query.php'; // Memastikan koneksi ke database sudah ada

// Memulai session
session_start();

// Mengecek apakah user sudah login atau session timeout
if (!isset($_SESSION['username']) || !isset($_SESSION['id_admin']) || time() > $_SESSION['expire_time']) {
    session_destroy();
    header('Location: ../Admin/pages/login.html'); // Redirect ke halaman login jika belum login atau session habis
    exit();
}

// Perbarui waktu sesi (reset timeout)
$_SESSION['expire_time'] = time() + 1800; // 30 menit

// Menangkap id_admin dari sesi
$id_admin = $_SESSION['id_admin'];

// Ambil data dari form
$type = $_POST['type'];
$name = $_POST['name'];
$description = $_POST['description'];

// Fungsi untuk mengupload gambar
function uploadGambar($file)
{
    // Memecah nama file dan extension
    $tmp = explode('.', $file['name']);
    $ext = end($tmp); // Mengambil extension
    $filename = $tmp[0]; // Mengambil nilai nama file tanpa extension
    $allowed_ext = array("png", "jpg", "jpeg"); // Extension file yang diizinkan

    // Cek validasi extension
    if (!in_array($ext, $allowed_ext)) {
        echo "<script>alert('Ekstensi file tidak diizinkan! Harus berupa .png, .jpg, atau .jpeg.'); window.history.back();</script>";
        return false; // Extension tidak diizinkan
    }

    // Cek ukuran gambar dengan maks. ukuran 5mb (dalam byte)
    if ($file["size"] > 5120000) {
        echo "<script>alert('Ukuran gambar terlalu besar! Maksimal ukuran 5MB.'); window.history.back();</script>";
        return false; // Ukuran gambar terlalu besar
    }

    $name = $filename . '_' . rand() . '.' . $ext; // Rename nama file gambar
    $path = "../assets/images/" . $name; // Lokasi upload file gambar
    if (move_uploaded_file($file["tmp_name"], $path)) { // Memindahkan file
        return $path;
    } else {
        echo "<script>alert('Gagal memindahkan file!'); window.history.back();</script>";
        return false; // Gagal memindahkan file
    }
}

// Proses data untuk tipe dokter
if ($type === 'dokter') {
    // Ambil data foto dokter
    $photo = $_FILES['photo'];
    $hari_praktik = $_POST['hari_praktik'];
    $jam_praktik = $_POST['jam_praktik'];

    // Upload gambar
    $photoPath = uploadGambar($photo);

    if ($photoPath) {
        // Menyimpan data dokter ke database
        $sql = "INSERT INTO tb_dokter (id_admin, nama_dokter, foto_dokter, hari_praktik, jam_praktik, tanggal_update) 
                VALUES ($id_admin, '$name', '$photoPath', '$hari_praktik', '$jam_praktik', NOW())";

        if ($conn->query($sql)) {
            echo "<script>alert('Data Dokter berhasil ditambahkan!'); window.location.href = '../index.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat menambahkan data dokter!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Gagal mengupload foto! Pastikan file dalam format JPG/PNG dan ukuran kurang dari 5MB.'); window.history.back();</script>";
    }
}

// Proses data untuk tipe pasien
elseif ($type === 'pasien') {
    // Ambil data untuk pasien (tanggal, usia, jenis kelamin, dll.)
    $tanggal_kunjungan = $_POST['tanggal_kunjungan'];
    $nama_pasien = $_POST['nama_pasien'];
    $usia = $_POST['usia'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $kategori = $_POST['kategori'];
    $id_dokter = $_POST['id_dokter']; // ID dokter yang dipilih

    // Menyimpan data pasien ke database
    $sql = "INSERT INTO tb_pasien (id_admin, tanggal_kunjungan, nama_pasien, usia, jenis_kelamin, kategori, id_dokter)
    VALUES ($id_admin, '$tanggal_kunjungan', '$nama_pasien', $usia, '$jenis_kelamin', '$kategori', $id_dokter)";

    if ($conn->query($sql)) {
        echo "<script>
    alert('Data Pasien berhasil ditambahkan!');
    window.location.href = '../index.php';
</script>";
    } else {
        echo "<script>
    alert('Terjadi kesalahan saat menambahkan data pasien!');
    window.history.back();
</script>";
    }
} else {
    echo "<script>
    alert('Tipe data tidak valid!');
    window.history.back();
</script>";
}

$conn->close();
