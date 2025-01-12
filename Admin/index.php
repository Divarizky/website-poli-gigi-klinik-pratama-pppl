<?php
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../Admin/assets/css/styles.css">
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <img id="logo" src="../assets/img/logo.jpg" alt="Logo Klinik Poli Gigi">
            <nav>
                <ul class="sidebar-nav" id="sidebar-nav">
                    <li>
                        <a href="#" id="dashboard-title">
                            <img class="sidebar-icon" src="../Admin/assets/icons/dashboard-icon.png" alt="Dashboard Icon">
                            Manajemen Dashboard Admin
                        </a>
                    </li>
                    <li>
                        <a href="../Admin/pages/informasi_klinik.php" id="clinic-info-link">
                            <img class="sidebar-icon" src="../Admin/assets/icons/info-icon.png" alt="Clinic Icon">
                            Informasi Klinik
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content" id="main-content">
            <div class="main-header" id="main-header">
                <h1 id="welcome-message">Selamat Datang, <?php echo $_SESSION['username']; ?>!</h1>
                <a href="../Admin/config/logout.php" class="btn-logout" id="logout-btn">Logout</a>
            </div>

            <!-- Tabel Dokter -->
            <section id="doctor-section" class="container-section">
                <h2 id="doctor-title">Daftar Dokter</h2>
                <button class="btn-add" id="add-doctor-btn" onclick="window.location.href='../Admin/pages/tambah_data.php?type=dokter'">
                    <img class="button-icon" src="../Admin/assets/icons/add-icon.png" alt="Tambah"> Tambah Data
                </button>
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

                                    // Menampilkan path foto dokter berdasarkan id_dokter
                                    $photoPath = "assets/images/placeholder.jpg"; // Default path jika gambar tidak ditemukan

                                    if (!empty($dokter['foto_dokter'])) {
                                        $filePath = "assets/images/" . $dokter['foto_dokter'];

                                        // Tambahkan validasi file_exists dan id_dokter
                                        if (file_exists($filePath)) {
                                            $photoPath = $filePath; // Path gambar yang valid
                                        } else {
                                            // Debugging jika gambar tidak ditemukan
                                            error_log("File foto tidak ditemukan: " . $filePath);
                                        }
                                    }

                                    // Tampilkan foto dalam tabel
                                    echo "<td><img src='" . htmlspecialchars($photoPath) . "' alt='Foto Dokter' class='preview-image' 
                                    style='width: 80px; height: 80px; object-fit: cover;'></td>";

                                    // Menampilkan nama, hari praktik, jam praktik, dan tanggal update
                                    echo "<td>" . htmlspecialchars($dokter['nama_dokter']) . "</td>";
                                    echo "<td>" . htmlspecialchars($dokter['hari_praktik']) . "</td>";
                                    echo "<td>" . htmlspecialchars($dokter['jam_praktik']) . "</td>";
                                    echo "<td>" . htmlspecialchars($dokter['tanggal_update']) . "</td>";

                                    // Aksi untuk mengedit atau menghapus
                                    echo "<td>
                                    <button class='btn-update' onclick=\"window.location.href='../Admin/pages/ubah_data.php?id=" . $dokter['id_dokter'] . "&type=dokter'\">Ubah</button>
                                    <button class='btn-delete' onclick=\"if(confirm('Yakin ingin menghapus?')) window.location.href='../Admin/config/process_delete_data.php?id=" . $dokter['id_dokter'] . "&type=dokter'\">Delete</button>
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

            <!-- Tabel Pasien -->
            <section id="patient-section" class="container-section">
                <h2 id="patient-title">Daftar Pasien</h2>
                <button class="btn-add" id="add-patient-btn" onclick="window.location.href='../Admin/pages/tambah_data.php?type=pasien'">
                    <img class="button-icon" src="../Admin/assets/icons/add-icon.png" alt="Tambah">Tambah Data
                </button>
                <div class="table-responsive" id="patient-table-container">
                    <table class="custom-table" id="patient-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal dan Jam</th>
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
                                    echo "<td>" . htmlspecialchars($pasien['nama_pasien']) . "</td>";
                                    echo "<td>" . htmlspecialchars($pasien['usia']) . "</td>";
                                    echo "<td>" . htmlspecialchars($pasien['jenis_kelamin']) . "</td>";
                                    echo "<td>" . htmlspecialchars($pasien['kategori']) . "</td>";
                                    echo "<td>" . htmlspecialchars($pasien['nama_dokter']) . "</td>";
                                    echo "<td>
                                    <button class='btn-update' onclick=\"window.location.href='../Admin/pages/ubah_data.php?id=" . $pasien['id_pasien'] . "&type=pasien'\">Ubah</button>
                                    <button class='btn-delete' onclick=\"if(confirm('Yakin ingin menghapus?')) window.location.href='../Admin/config/process_delete_data.php?id=" . $pasien['id_pasien'] . "&type=pasien'\">Delete</button>
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