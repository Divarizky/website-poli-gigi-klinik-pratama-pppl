<?php
include("../template/header.php");

// konfigurasi database
include('../Admin/config/config_query.php');

// Ambil data dokter dari database
$result_dokter = bacaSemuaDokter();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Klinik Medikasih</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  <link href="assets/css/dokter.css" rel="stylesheet">
</head>

<body>

  <main class="main">

    <div class="dokter my-5">
      <div class="container">
        <div class="row g-4">
          <!-- Kartu Tim Dokter -->
          <div class="col-md-8">
            <div class="card-custom">
              <h6 class="mb-2">Dokter</h6>
              <h2 class="fw-bold">Tim Dokter Poli Gigi Klinik Medikasih</h2>
              <p>
                Tim Dokter Poli Gigi Klinik Medikasih menyediakan layanan kesehatan gigi yang nyaman dan aman, dipandu oleh dokter-dokter profesional untuk menjaga kesehatan gigi Anda.
              </p>
            </div>
          </div>
          <!-- Placeholder Gambar -->
          <div class="col-md-4">
            <div class="icon-placeholder">
              <img src="assets/img/doctors/ilustration_doctor.jpg" alt="Placeholder Image">
            </div>
          </div>
        </div>

        <!-- Daftar Dokter -->
        <div class="row mt-5 text-center g-4">
          <?php
          // Cek apakah data dokter tersedia
          if ($result_dokter->num_rows > 0) {
            while ($dokter = $result_dokter->fetch_assoc()) {
              // Tentukan path foto dokter
              $foto_dokter = !empty($dokter['foto_dokter']) ? "Admin/assets/images/" . htmlspecialchars($dokter['foto_dokter']) : "Admin/assets/images/default.jpg";

              // Tampilkan data dokter dalam format card
              echo '<div class="col-md-3 col-6">';
              echo '  <div class="doctor-card">';
              echo '    <div class="doctor-icon">';
              echo '      <img src="' . $foto_dokter . '" alt="Dokter Icon">';
              echo '    </div>';
              echo '    <h6 class="mt-3 fw-bold">' . htmlspecialchars($dokter['nama_dokter']) . '</h6>';
              echo '    <span>' . htmlspecialchars($dokter['deskripsi_dokter']) . '</span>';
              echo '  </div>';
              echo '</div>';
            }
          } else {
            // Pesan jika tidak ada data dokter
            echo '<div class="col-12"><p>Tidak ada data dokter yang tersedia.</p></div>';
          }
          ?>
        </div>
      </div>
    </div>

  </main>

  <?php include("../template/footer.php"); ?>

</body>

</html>