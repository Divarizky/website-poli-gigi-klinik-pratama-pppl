<?php
include("../template/header.php");

// konfigurasi database
include("../Admin/config/config_query.php");

// Ambil data kontak dan alamat
$data_klinik = bacaInformasiKlinik();

if ($data_klinik) {
  $kontak = htmlspecialchars($data_klinik['no_telp']);
  $email = htmlspecialchars($data_klinik['email']);
  $lokasi = nl2br(htmlspecialchars($data_klinik['lokasi']));
} else {
  $kontak = "Kontak tidak tersedia";
  $email = "Email tidak tersedia";
  $lokasi = "Alamat tidak tersedia";
}
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
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
  <link href="assets/css/kontak.css" rel="stylesheet">
</head>

<body>
  <main class="main">
    <div class="kontak my-5">
      <div class="container">
        <div class="row g-4">
          <!-- Kartu Tim Dokter -->
          <div class="col-md-8">
            <div class="card-custom">
              <h6 class="mb-2">Kontak</h6>
              <h2 class="fw-bold">Hubungi Kami</h2>
              <p>
                Jika Anda memiliki pertanyaan spesifik tentang kami maupun layanan kami, jangan ragu untuk menghubungi tim Poli Gigi Klinik Medikasih. Kami akan dengan senang hati menjawab pertanyaan Anda.
              </p>
            </div>
          </div>
          <!-- Placeholder Gambar -->
          <div class="col-md-4">
            <div class="icon-placeholder">
              <img src="assets/img/contact/ilustration_contact.jpg" alt="Placeholder Image">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="kontak-body">
      <div class="container">

        <!-- Kontak -->
        <h2>Kontak Kami</h2>
        <p>
          <i class="fas fa-phone"></i> <?php echo $kontak; ?><br>
          <i class="fas fa-envelope"></i> <?php echo $email; ?>
        </p><br>

        <!-- Alamat -->
        <p>
        <h2>Alamat Kami</h2>
        <?php echo $lokasi; ?>
        </p><br>
      </div>
    </div>
  </main>

  <?php
  include("../template/footer.php");
  ?>
</body>

</html>