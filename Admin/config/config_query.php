<?php
// Konfigurasi koneksi ke database
$servername = "localhost";
$username = "root"; // Sesuaikan dengan username MySQL Anda
$password = "";     // Sesuaikan dengan password MySQL Anda
$dbname = "db_poligigi_pratama"; // Nama database Anda

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// ------ FUNGSI UNTUK TABEL ADMIN ------

// Fungsi untuk menambahkan admin baru
function tambahAdmin($name, $username, $password)
{
    global $conn;
    $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Enkripsi password
    $sql = "INSERT INTO tb_admin (name, username, password) VALUES ('$name', '$username', '$hashed_password')";
    return $conn->query($sql);
}

// Fungsi untuk memverifikasi login admin
function verifikasiLogin($username, $password)
{
    global $conn;
    $sql = "SELECT * FROM tb_admin WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            return $admin; // Login berhasil
        }
    }
    return false; // Login gagal
}

// Fungsi untuk memperbarui password admin
function perbaruiPasswordAdmin($username, $password_baru)
{
    global $conn;
    $hashed_password = password_hash($password_baru, PASSWORD_BCRYPT); // Enkripsi password
    $sql = "UPDATE tb_admin SET password = '$hashed_password' WHERE username = '$username'";
    return $conn->query($sql);
}

// // ------ FUNGSI UNTUK TABEL DOKTER ------
// // Fungsi menambahkan dokter
// function tambahDokter($foto_dokter, $nama_dokter, $hari_praktik, $jam_praktik, $tanggal_update)
// {
//     global $conn;
//     $sql = "INSERT INTO tb_dokter (foto_dokter, nama_dokter, hari_praktik, jam_praktik, tanggal_update) VALUES ('$foto_dokter', '$nama_dokter', '$hari_praktik', '$jam_praktik', '$tanggal_update')";
//     return $conn->query($sql);
// }

// // Fungsi membaca data dokter
// function bacaSemuaDokter() {
//     global $conn;
//     $sql = "SELECT * FROM tb_dokter";
//     return $conn->query($sql);
// }

// // Fungsi memperbarui dokter
// function perbaruiDokter($id_dokter, $foto_dokter, $nama_dokter, $tanggal_update) {
//     global $conn;
//     $sql = "UPDATE tb_dokter SET foto_dokter='$foto_dokter', nama_dokter='$nama_dokter', tanggal_update='$tanggal_update' WHERE id_dokter=$id_dokter";
//     return $conn->query($sql);
// }

// // Fungsi menghapus dokter
// function hapusDokter($id_dokter) {
//     global $conn;
//     $sql = "DELETE FROM tb_dokter WHERE id_dokter=$id_dokter";
//     return $conn->query($sql);
// }

// // ------ FUNGSI UNTUK TABEL PASIEN ------
// // Fungsi menambahkan pasien
// function tambahPasien($tanggal_kunjungan, $nama_pasien, $usia, $jenis_kelamin, $kategori, $id_dokter) {
//     global $conn;
//     $sql = "INSERT INTO tb_pasien (tanggal_kunjungan, nama_pasien, usia, jenis_kelamin, kategori, id_dokter) VALUES ('$tanggal_kunjungan', '$nama_pasien', $usia, '$jenis_kelamin', '$kategori', $id_dokter)";
//     return $conn->query($sql);
// }

// // Fungsi membaca data pasien
// function bacaSemuaPasien() {
//     global $conn;
//     $sql = "SELECT p.id_pasien, p.tanggal_kunjungan, p.nama_pasien, p.usia, p.jenis_kelamin, p.kategori, d.nama_dokter 
//             FROM tb_pasien p 
//             JOIN tb_dokter d ON p.id_dokter = d.id_dokter";
//     return $conn->query($sql);
// }

// // Fungsi memperbarui pasien
// function perbaruiPasien($id_pasien, $tanggal_kunjungan, $nama_pasien, $usia, $jenis_kelamin, $kategori, $id_dokter) {
//     global $conn;
//     $sql = "UPDATE tb_pasien SET tanggal_kunjungan='$tanggal_kunjungan', nama_pasien='$nama_pasien', usia=$usia, jenis_kelamin='$jenis_kelamin', kategori='$kategori', id_dokter=$id_dokter WHERE id_pasien=$id_pasien";
//     return $conn->query($sql);
// }

// // Fungsi menghapus pasien
// function hapusPasien($id_pasien) {
//     global $conn;
//     $sql = "DELETE FROM tb_pasien WHERE id_pasien=$id_pasien";
//     return $conn->query($sql);
// }

// ------ FUNGSI UNTUK TABEL DOKTER ------
// Fungsi menambahkan dokter
function tambahDokter($id_admin, $foto_dokter, $nama_dokter, $hari_praktik, $jam_praktik, $tanggal_update)
{
    global $conn;
    $sql = "INSERT INTO tb_dokter (id_admin, foto_dokter, nama_dokter, hari_praktik, jam_praktik, tanggal_update) VALUES ($id_admin, '$foto_dokter', '$nama_dokter', '$hari_praktik', '$jam_praktik', '$tanggal_update')";
    return $conn->query($sql);
}

// Fungsi membaca data dokter
function bacaSemuaDokter()
{
    global $conn;
    $sql = "SELECT d.*, a.name
            FROM tb_dokter d
            JOIN tb_admin a ON d.id_admin = a.id_admin";
    return $conn->query($sql);
}

// Fungsi memperbarui dokter
function perbaruiDokter($id_dokter, $foto_dokter, $nama_dokter, $tanggal_update)
{
    global $conn;
    $sql = "UPDATE tb_dokter SET foto_dokter='$foto_dokter', nama_dokter='$nama_dokter', tanggal_update='$tanggal_update' WHERE id_dokter=$id_dokter";
    return $conn->query($sql);
}

// Fungsi menghapus dokter
function hapusDokter($id_dokter)
{
    global $conn;
    $sql = "DELETE FROM tb_dokter WHERE id_dokter=$id_dokter";
    return $conn->query($sql);
}

// ------ FUNGSI UNTUK TABEL PASIEN ------
// Fungsi menambahkan pasien
function tambahPasien($id_admin, $tanggal_kunjungan, $nama_pasien, $usia, $jenis_kelamin, $kategori, $id_dokter)
{
    global $conn;
    $sql = "INSERT INTO tb_pasien (id_admin, tanggal_kunjungan, nama_pasien, usia, jenis_kelamin, kategori, id_dokter) VALUES ($id_admin, '$tanggal_kunjungan', '$nama_pasien', $usia, '$jenis_kelamin', '$kategori', $id_dokter)";
    return $conn->query($sql);
}

// Fungsi membaca data pasien
function bacaSemuaPasien()
{
    global $conn;
    $sql = "SELECT p.id_pasien, p.tanggal_kunjungan, p.nama_pasien, p.usia, p.jenis_kelamin, p.kategori, d.nama_dokter, a.name 
            FROM tb_pasien p 
            JOIN tb_dokter d ON p.id_dokter = d.id_dokter
            JOIN tb_admin a ON p.id_admin = a.id_admin";
    return $conn->query($sql);
}

// Fungsi memperbarui pasien
function perbaruiPasien($id_pasien, $tanggal_kunjungan, $nama_pasien, $usia, $jenis_kelamin, $kategori, $id_dokter)
{
    global $conn;
    $sql = "UPDATE tb_pasien SET tanggal_kunjungan='$tanggal_kunjungan', nama_pasien='$nama_pasien', usia=$usia, jenis_kelamin='$jenis_kelamin', kategori='$kategori', id_dokter=$id_dokter WHERE id_pasien=$id_pasien";
    return $conn->query($sql);
}

// Fungsi menghapus pasien
function hapusPasien($id_pasien)
{
    global $conn;
    $sql = "DELETE FROM tb_pasien WHERE id_pasien=$id_pasien";
    return $conn->query($sql);
}

// Fungsi menutup koneksi
function tutupKoneksi()
{
    global $conn;
    $conn->close();
}
