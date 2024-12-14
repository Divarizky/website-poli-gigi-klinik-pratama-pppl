<?php
// Memulai session
session_start();
if (!isset($_SESSION['username']) || time() > $_SESSION['expire_time']) {
  session_destroy();
  header('Location: ../pages/login.html');
  exit();
}
$_SESSION['expire_time'] = time() + 1800; // Perpanjang sesi 30 menit

// Include file konfigurasi database
include '../config/config_query.php';

// Tentukan tipe data (dokter atau pasien) berdasarkan parameter URL
$type = isset($_GET['type']) ? $_GET['type'] : 'dokter';
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$isDoctor = $type === 'dokter';

// Ambil data dari database berdasarkan id
if ($isDoctor) {
  $sql = "SELECT * FROM tb_dokter WHERE id_dokter = $id";
} else {
  $sql = "SELECT * FROM tb_pasien WHERE id_pasien = $id";
}
$result = $conn->query($sql);
$data = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ubah Data <?php echo ucfirst($type); ?></title>
  <link rel="stylesheet" href="../assets/css/styles.css">
  <!-- Summernote CSS -->
  <link href="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-lite.min.css" rel="stylesheet">
</head>

<body>
  <div class="dashboard-container">
    <div class="sidebar" id="sidebar">
      <h2 id="logo">Logo</h2>
      <nav>
        <ul class="sidebar-nav" id="sidebar-nav">
          <li><a href="../index.php" id="dashboard-title">Manajemen Dashboard Admin</a></li>
        </ul>
      </nav>
    </div>
    <div class="main-content" id="main-content">
      <main>
        <header>
          <h3 id="heading-ubah-data-title">
            <span class="sub-heading-ubah-data">
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
              <div class="row">
                <div class="col-lg-9">
                  <div class="mb-3">
                    <label for="name" class="form-label"><?php echo $isDoctor ? 'NAMA DOKTER' : 'NAMA PASIEN'; ?> *</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?php echo $data['nama_dokter'] ?? $data['nama_pasien']; ?>" required>
                  </div>
                  <?php if ($isDoctor): ?>
                    <div class="mb-3">
                      <label for="hari_praktik" class="form-label">HARI PRAKTIK *</label>
                      <input type="text" name="hari_praktik" id="hari_praktik" class="form-control" value="<?php echo $data['hari_praktik']; ?>" required>
                    </div>
                    <div class="mb-3">
                      <label for="jam_praktik" class="form-label">JAM PRAKTIK *</label>
                      <input type="text" name="jam_praktik" id="jam_praktik" class="form-control" value="<?php echo $data['jam_praktik']; ?>" required>
                    </div>
                  <?php endif; ?>
                  <div class="mb-3">
                    <label for="description" class="form-label">ISI DESKRIPSI *</label>
                    <textarea class="form-control summernote" name="description" id="description" rows="3" required><?php echo $data['description'] ?? ''; ?></textarea>
                  </div>
                </div>

                <?php if ($isDoctor): ?>
                  <div class="col-lg-3">
                    <div class="mb-3">
                      <label for="photo" class="form-label">UPLOAD FOTO *</label>
                      <input type="file" name="photo" class="form-control" id="photo">
                      <small class="text-danger">Max Size 5Mb, ext. png, jpg, jpeg</small>
                      <?php if (!empty($data['foto_dokter'])): ?>
                        <img src="<?php echo $data['foto_dokter']; ?>" alt="Foto Dokter" style="width: 250px; height: 250px;">
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