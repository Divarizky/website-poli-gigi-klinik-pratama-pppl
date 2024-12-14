<?php
include 'config_query.php'; // Memastikan koneksi ke database sudah ada

// Ambil data dari form
$type = $_POST['type'];
$name = $_POST['name'];
$description = $_POST['description'];

// Proses data untuk tipe dokter
if ($type === 'dokter') {
    // Ambil data foto dokter
    $photo = $_FILES['photo'];
    $hari_praktik = $_POST['hari_praktik'];
    $jam_praktik = $_POST['jam_praktik'];

    // Tentukan path untuk menyimpan foto dokter di folder 'images'
    $photoPath = '../assets/images/' . basename($photo['name']);

    // Cek apakah foto berhasil diupload
    if (move_uploaded_file($photo['tmp_name'], $photoPath)) {
        // Menyimpan data dokter ke database
        $sql = "INSERT INTO tb_dokter (nama_dokter, foto_dokter, hari_praktik, jam_praktik, tanggal_update) 
                VALUES ('$name', '$photoPath', '$hari_praktik', '$jam_praktik', NOW())";

        if ($conn->query($sql)) {
            echo "<script>alert('Data Dokter berhasil ditambahkan!'); window.location.href = '../pages/index.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat menambahkan data dokter!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Gagal mengupload foto!'); window.history.back();</script>";
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
    $sql = "INSERT INTO tb_pasien (tanggal_kunjungan, nama_pasien, usia, jenis_kelamin, kategori, id_dokter)
VALUES ('$tanggal_kunjungan', '$nama_pasien', $usia, '$jenis_kelamin', '$kategori', $id_dokter)";

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
