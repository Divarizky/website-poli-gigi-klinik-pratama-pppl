<?php
// Memulai session
session_start();

// Mengecek apakah user sudah login atau session timeout
if (!isset($_SESSION['username']) || time() > $_SESSION['expire_time']) {
    session_destroy();
    header('Location: ../pages/login.html'); // Redirect ke halaman login jika belum login atau session habis
    exit();
}

// Perbarui waktu sesi (reset timeout)
$_SESSION['expire_time'] = time() + 1800; // 30 menit
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../admin-poli-gigi/assets/css/styles.css">
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <h2 id="logo">Logo</h2>
            <nav>
                <ul class="sidebar-nav" id="sidebar-nav">
                    <li><a href="#" id="dashboard-title">Manajemen Dashboard Admin</a></li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content" id="main-content">
            <div class="main-header" id="main-header">
                <h1 id="welcome-message">Selamat Datang, <?php echo $_SESSION['username']; ?>!</h1>
                <a href="../admin-poli-gigi/config/logout.php" class="btn-logout" id="logout-btn">Logout</a>
            </div>

            <!-- Daftar Dokter -->
            <section id="doctor-section" class="container-section">
                <h2 id="doctor-title">Daftar Dokter</h2>
                <button class="btn-add" id="add-doctor-btn" onclick="window.location.href='../admin-poli-gigi/pages/tambah_data.php?type=dokter'">Tambah Data</button>
                <div class="table-responsive" id="doctor-table-container">
                    <table class="custom-table" id="doctor-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto Dokter</th>
                                <th>Nama</th>
                                <th>Hari Praktik</th>
                                <th>Jam Praktik</th>
                                <th>Tanggal Update</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="doctorTable">
                            <!-- Data dokter akan di-load dari database -->
                            <?php
                            // Menarik data dokter
                            include('config/config_query.php'); // Pastikan koneksi database sudah ada di sini
                            $result_dokter = bacaSemuaDokter();

                            // Memastikan ada data yang ditemukan
                            if ($result_dokter->num_rows > 0) {
                                $no = 1; // Menyusun nomor urut
                                while ($dokter = $result_dokter->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $no++ . "</td>";

                                    // Menampilkan foto dokter jika ada, atau tampilkan placeholder
                                    $foto = $dokter['foto_dokter'] ? "../assets/images/" . basename($dokter['foto_dokter']) : "../assets/images/placeholder.jpg";
                                    echo "<td><img src='$foto' alt='Foto Dokter' style='width: 100px; height: auto;'></td>";

                                    // Menampilkan nama, hari praktik, jam praktik, dan tanggal update
                                    echo "<td>" . $dokter['nama_dokter'] . "</td>";
                                    echo "<td>" . $dokter['hari_praktik'] . "</td>";
                                    echo "<td>" . $dokter['jam_praktik'] . "</td>";
                                    echo "<td>" . $dokter['tanggal_update'] . "</td>";

                                    // Aksi untuk mengedit atau menghapus
                                    echo "<td>
                                    <button class='btn-update' onclick=\"window.location.href='ubah_data.php?id=" . $dokter['id_dokter'] . "'\">Update</button>
                                    <button class='btn-delete' onclick=\"if(confirm('Yakin ingin menghapus?')) window.location.href='hapus_data.php?id=" . $dokter['id_dokter'] . "'\">Delete</button>
                                    </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>Tidak ada data dokter.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Daftar Pasien -->
            <section id="patient-section" class="container-section">
                <h2 id="patient-title">Daftar Pasien</h2>
                <button class="btn-add" id="add-patient-btn" onclick="window.location.href='../admin-poli-gigi/pages/tambah_data.php?type=pasien'">Tambah Data</button>
                <div class="table-responsive" id="patient-table-container">
                    <table class="custom-table" id="patient-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Umur</th>
                                <th>JK</th>
                                <th>Kategori</th>
                                <th>Dokter</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="patientTable">
                            <!-- Data pasien akan di-load dari database -->
                            <?php
                            // Menarik data pasien
                            $result_pasien = bacaSemuaPasien();

                            // Memastikan ada data yang ditemukan
                            if ($result_pasien->num_rows > 0) {
                                $no = 1; // Menyusun nomor urut
                                while ($pasien = $result_pasien->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $no++ . "</td>";
                                    echo "<td>" . $pasien['tanggal_kunjungan'] . "</td>";
                                    echo "<td>" . $pasien['nama_pasien'] . "</td>";
                                    echo "<td>" . $pasien['usia'] . "</td>";
                                    echo "<td>" . $pasien['jenis_kelamin'] . "</td>";
                                    echo "<td>" . $pasien['kategori'] . "</td>";
                                    echo "<td>" . $pasien['nama_dokter'] . "</td>";
                                    echo "<td>
                                    <a href='edit_pasien.php?id=" . $pasien['id_pasien'] . "'>Edit</a> | 
                                    <a href='hapus_pasien.php?id=" . $pasien['id_pasien'] . "' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
                                    </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8'>Tidak ada data pasien.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</body>

</html>