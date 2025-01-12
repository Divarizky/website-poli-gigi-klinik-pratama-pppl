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

// Tentukan tipe data (dokter atau pasien) berdasarkan parameter URL
$type = isset($_GET['type']) ? $_GET['type'] : 'dokter';
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$isDoctor = $type === 'dokter';

// Ambil data dokter dari database
$sqlDokter = "SELECT id_dokter, nama_dokter FROM tb_dokter";
$resultDokter = $conn->query($sqlDokter);

// Ambil data berdasarkan ID
if ($isDoctor) {
  $sql = "SELECT * FROM tb_dokter WHERE id_dokter = ?";
} else {
  $sql = "SELECT * FROM tb_pasien WHERE id_pasien = ?";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

// Memisahkan tanggal reservasi menjadi hari, bulan, tahun, dan jam
if (!$isDoctor && !empty($data['tanggal_kunjungan'])) {
  $datetime = explode(' ', $data['tanggal_kunjungan']);
  $dateParts = explode('-', $datetime[0]); // Format: YYYY-MM-DD
  $time = $datetime[1] ?? ''; // Format: HH:MM:SS
  $hari = $dateParts[2] ?? '';
  $bulan = $dateParts[1] ?? '';
  $tahun = $dateParts[0] ?? '';
  $jam = $time;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ubah Data <?php echo ucfirst($type); ?></title>
  <link rel="stylesheet" href="../assets/css/styles.css">
  <link href="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-lite.min.css" rel="stylesheet">
</head>

<body>
  <div class="dashboard-container">
    <div class="sidebar" id="sidebar">
      <h2 id="logo">Logo</h2>
      <nav>
        <ul class="sidebar-nav" id="sidebar-nav">
          <li><a href="../index.php" id="dashboard-title">Manajemen Dashboard Admin</a></li>
          <li><a href="../pages/informasi_klinik.php" id="clinic-info-link">Informasi Klinik</a></li>
        </ul>
      </nav>
    </div>
    <div class="main-content" id="main-content">
      <main>
        <header>
          <h3 id="heading-main-content">
            <span class="sub-heading-main-content">
              <a href="../index.php">Manajemen Dashboard /</a>
            </span>
            <span>Ubah Data <?php echo ucfirst($type); ?></span>
          </h3>
        </header>

        <section>
          <div class="container-section">
            <h2 id="doctor-title" class="card-title mb-4">Ubah Data <?php echo ucfirst($type); ?></h2>
            <form action="../config/process_update_data.php" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="type" value="<?php echo $type; ?>">
              <input type="hidden" name="id" value="<?php echo $id; ?>">
              <!-- Nama -->
              <div class="mb-3">
                <label for="name" class="form-label"><?php echo $isDoctor ? 'NAMA DOKTER' : 'NAMA PASIEN'; ?> *</label>
                <input type="text" name="name" id="name" class="form-control"
                  value="<?php echo $data['nama_dokter'] ?? $data['nama_pasien']; ?>" required>
              </div>

              <!-- Input Pasien -->
              <?php if (!$isDoctor): ?>
                <div class="input-pasien">
                  <div class="mb-3">
                    <!-- Input Tanggal Reservasi -->
                    <div class="form-tanggal">
                      <label for="tanggal_reservasi" class="form-label">TANGGAL RESERVASI *</label>
                      <div class="input-group input-horizontal">
                        <input type="text" name="hari" placeholder="Hari" class="form-control input-small" value="<?php echo $hari; ?>" required>
                        <input type="text" name="bulan" placeholder="Bulan" class="form-control input-small" value="<?php echo $bulan; ?>" required>
                        <input type="text" name="tahun" placeholder="Tahun" class="form-control input-small" value="<?php echo $tahun; ?>" required>
                        <input type="text" name="jam" placeholder="Jam" class="form-control input-small" value="<?php echo $jam; ?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-input-pasien">
                    <div class="row-input-pasien">
                      <div class="mb-3">
                        <label for="usia">USIA *</label>
                        <input type="number" name="usia" id="usia" class="form-control"
                          value="<?php echo $data['usia']; ?>" required>
                      </div>
                      <div class="mb-3">
                        <label for="jenis_kelamin">JENIS KELAMIN *</label>
                        <input type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-control"
                          value="<?php echo $data['jenis_kelamin']; ?>" required>
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="kategori">KATEGORI *</label>
                      <input type="text" name="kategori" id="kategori" class="form-control"
                        value="<?php echo $data['kategori']; ?>" required>
                    </div>
                    <!-- Dropdown Dokter -->
                    <div class="mb-3">
                      <label for="dokter" class="form-label">DOKTER *</label>
                      <select name="id_dokter" id="dokter" class="form-control" required>
                        <option value="">Pilih Dokter</option>
                        <?php
                        if ($resultDokter && $resultDokter->num_rows > 0) {
                          while ($row = $resultDokter->fetch_assoc()) {
                            $selected = ($row['id_dokter'] == $data['id_dokter']) ? 'selected' : '';
                            echo "<option value='" . $row['id_dokter'] . "' $selected>" . htmlspecialchars($row['nama_dokter']) . "</option>";
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
              <?php endif; ?>

              <!-- Input Dokter -->
              <div class="row">
                <div class="col-lg-9">
                  <?php if ($isDoctor): ?>
                    <div class="mb-3">
                      <label for="hari_praktik" class="form-label">HARI PRAKTIK *</label>
                      <input type="text" name="hari_praktik" id="hari_praktik" class="form-control"
                        value="<?php echo $data['hari_praktik']; ?>" required>
                    </div>
                    <div class="mb-3">
                      <label for="jam_praktik" class="form-label">JAM PRAKTIK *</label>
                      <input type="text" name="jam_praktik" id="jam_praktik" class="form-control"
                        value="<?php echo $data['jam_praktik']; ?>" required>
                    </div>
                    <!-- Deskripsi -->
                    <div class="mb-3">
                      <label for="description" class="form-label">ISI DESKRIPSI *</label>
                      <textarea class="form-control summernote" name="description" id="description" rows="3" required><?php echo htmlspecialchars($data['deskripsi_dokter'] ?? $data['description']); ?></textarea>
                    </div>
                  <?php endif; ?>
                </div>

                <!-- Foto Dokter -->
                <?php if ($isDoctor): ?>
                  <div class="col-lg-3">
                    <div class="mb-3">
                      <label for="photo" class="form-label">UPLOAD FOTO *</label>
                      <input type="file" name="photo" class="form-control" id="photo">
                      <?php if (!empty($data['foto_dokter'])): ?>
                        <img src="../assets/images/<?php echo $data['foto_dokter']; ?>"
                          alt="Foto Dokter" style="width: 250px; height: 250px; object-fit: cover;">
                      <?php endif; ?>
                    </div>
                  </div>
                <?php endif; ?>
              </div>

              <div class="form-actions">
                <button type="button" onclick="window.history.back();" class="cancel-button">Batalkan</button>
                <button type="submit" class="submit-button">Update</button>
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
  </script>
</body>

</html>