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

// Ambil data informasi klinik dari database
$informasi = bacaInformasiKlinik();

// Proses pembaruan data jika form dikirimkan
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nomor_telepon = $_POST['nomor_telepon'];
  $email = $_POST['email'];
  $lokasi = $_POST['lokasi'];

  if (perbaruiInformasiKlinik($nomor_telepon, $email, $lokasi)) {
    $message = "Informasi klinik berhasil diperbarui.";
    $informasi = bacaInformasiKlinik(); // Ambil data terbaru
  } else {
    $message = "Gagal memperbarui informasi klinik.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Informasi Klinik</title>
  <link rel="stylesheet" href="../assets/css/styles.css">
  <script>
    // Fungsi untuk menampilkan pesan pop-up
    function showMessage(message) {
      if (message) {
        alert(message);
      }
    }
  </script>
</head>

<body onload="showMessage('<?php echo $message; ?>')">
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
            <a href="#" id="clinic-info-link">
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
            <span>Informasi Klinik</span>
          </h3>
        </header>

        <section>
          <div class="container-section">
            <h2 id="doctor-title" class="card-title mb-4">Kelola Informasi Klinik</h2>

            <form action="informasi_klinik.php" method="POST">
              <div class="mb-3">
                <label for="nomor_telepon" class="form-label">NOMOR TELEPON *</label>
                <input type="text" name="nomor_telepon" id="nomor_telepon" class="form-control" placeholder="Masukkan Nomor Telepon" value="<?php echo htmlspecialchars($informasi['no_telp']); ?>" required>
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">EMAIL *</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan Email" value="<?php echo htmlspecialchars($informasi['email']); ?>" required>
              </div>

              <div class="mb-3">
                <label for="lokasi" class="form-label">LOKASI *</label>
                <textarea class="form-control" name="lokasi" id="lokasi" rows="3" placeholder="Masukkan Lokasi Klinik" required><?php echo htmlspecialchars($informasi['lokasi']); ?></textarea>
              </div>

              <div class="form-actions">
                <button type="button" onclick="window.history.back();" class="cancel-button">Batalkan</button>
                <button type="submit" class="submit-button">Simpan</button>
              </div>
            </form>
          </div>
        </section>
      </main>
    </div>
  </div>
</body>

</html>