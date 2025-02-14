<?php
// Memulai session
session_start();

if (!isset($_SESSION['username']) || time() > $_SESSION['expire_time']) {
    session_destroy();
    header('Location: ../Admin/pages/login.html');
    exit();
}
$_SESSION['expire_time'] = time() + 1800; // Perpanjang sesi 30 menit

// Include file konfigurasi database
include '../config/config_query.php';

$sql = "SELECT id_dokter, nama_dokter FROM tb_dokter";
$result = $conn->query($sql);

// Tentukan tipe data (dokter atau pasien) berdasarkan parameter URL
$type = isset($_GET['type']) ? $_GET['type'] : 'dokter';
$isDoctor = $type === 'dokter';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data <?php echo ucfirst($type); ?></title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-lite.min.css" rel="stylesheet">
</head>

<body>
    <div class="dashboard-container">
        <div class="sidebar" id="sidebar">
            <img id="logo" src="../assets/icons/logo.jpg" alt="Logo Klinik Poli Gigi">
            <nav>
                <ul class="sidebar-nav" id="sidebar-nav">
                    <li>
                        <a href="../index.php" id="dashboard-title">
                            <img class="sidebar-icon" src="../assets/icons/dashboard-icon.png" alt="Dashboard Icon">
                            Manajemen Dashboard Admin
                        </a>
                    </li>
                    <li>
                        <a href="../pages/informasi_klinik.php" id="clinic-info-link">
                            <img class="sidebar-icon" src="../assets/icons/info-icon.png" alt="Clinic Icon">
                            Informasi Klinik
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="main-content" id="main-content">
            <main>
                <header>
                    <h3 id="heading-main-content">
                        <span class="sub-heading-main-content">
                            <a href="../index.php">Manajemen Dashboard Admin /</a>
                        </span>
                        <span>Tambah Data <?php echo ucfirst($type); ?> </span>
                    </h3>
                </header>

                <section>
                    <div class="container-section">
                        <h2 id="doctor-title" class="card-title mb-4">Tambah Data <?php echo ucfirst($type); ?> Baru</h2>
                        <form action="../config/process_add_data.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="type" value="<?php echo $type; ?>">
                            <div class="mb-3">
                                <label for="name" class="form-label"><?php echo $isDoctor ? 'NAMA DOKTER' : 'NAMA PASIEN'; ?> *</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan Nama" required>
                            </div>

                            <!-- Input untuk Pasien -->
                            <?php if (!$isDoctor): ?>
                                <div class="input-pasien">
                                    <div class="mb-3">
                                        <div class="form-tanggal">
                                            <label for="tanggal_reservasi" class="form-label">TANGGAL RESERVASI *</label>
                                            <div class="input-group input-horizontal">
                                                <input type="text" name="hari" placeholder="Hari" class="form-control input-small" required>
                                                <input type="text" name="bulan" placeholder="Bulan" class="form-control input-small" required>
                                                <input type="text" name="tahun" placeholder="Tahun" class="form-control input-small" required>
                                                <input type="text" name="jam" placeholder="Jam" class="form-control input-small" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-input-pasien">
                                        <div class="row-input-pasien">
                                            <div class="mb-3">
                                                <label for="usia">USIA *</label>
                                                <input type="number" name="usia" id="usia" class="form-control" placeholder="Masukkan Usia" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="jenis_kelamin">JENIS KELAMIN *</label>
                                                <input type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-control" placeholder="L/P" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="kategori">KATEGORI *</label>
                                            <input type="text" name="kategori" id="kategori" class="form-control" placeholder="Kategori" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="dokter" class="form-label">DOKTER *</label>
                                            <select name="id_dokter" id="dokter" class="form-control" required>
                                                <option value="">Pilih Dokter</option>
                                                <?php
                                                // Perulangan untuk menampilkan data dokter di dropdown
                                                if ($result && $result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<option value='" . $row['id_dokter'] . "'>" . htmlspecialchars($row['nama_dokter']) . "</option>";
                                                    }
                                                } else {
                                                    echo "<option value=''>Tidak Ada Dokter Tersedia</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="row">
                                <div class="col-lg-9">
                                    <!-- Input untuk Dokter -->
                                    <?php if ($isDoctor): ?>
                                        <div class="mb-3">
                                            <label for="hari_praktik" class="form-label">HARI PRAKTIK *</label>
                                            <input type="text" name="hari_praktik" id="hari_praktik" class="form-control" placeholder="Masukkan Hari Praktik" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="jam_praktik" class="form-label">JAM PRAKTIK *</label>
                                            <input type="text" name="jam_praktik" id="jam_praktik" class="form-control" placeholder="Masukkan Jam Praktik" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">ISI DESKRIPSI *</label>
                                            <textarea class="form-control summernote" name="description" id="description" rows="3" required></textarea>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <?php if ($isDoctor): ?>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label for="photo" class="form-label">UPLOAD FOTO *</label>
                                            <input type="file" name="photo" class="form-control" id="photo" required onchange="previewPhoto(event)">
                                            <small class="text-danger">Max Size 5Mb, ext. png, jpg, jpeg</small>
                                            <img id="photo-preview" src="#" alt="Pratinjau Foto" style="display:none; width: 250px; height: 250px; margin-top: 10px;">
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="form-actions">
                                <button type="button" onclick="window.history.back();" class="cancel-button">Batalkan</button>
                                <button type="submit" class="submit-button">Submit</button>
                            </div>
                        </form>
                </section>
            </main>
        </div>
    </div>
    <!-- Summernote JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                placeholder: 'Masukkan Deskripsi...',
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'help']]
                ]
            });
        });

        function previewPhoto(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('photo-preview');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

</html>