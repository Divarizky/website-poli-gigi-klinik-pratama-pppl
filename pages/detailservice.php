<?php
include("../template/header.php");
include("information_service.php"); // Memanggil file yang berisi informasi layanan

// Mendapatkan nama layanan dari query string
$layanan = $_GET['layanan'] ?? 'Scalling';

// Mengambil detail layanan berdasarkan nama
$detail = $services[$layanan] ?? null;

if ($detail === null) {
    echo "Layanan tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Detail Layanan - Klinik Medikasih</title>
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
  <link href="assets/css/layanan.css" rel="stylesheet">
</head>

<main class="main">

  <div class="detail-layanan my-5">
    <div class="row g-4">
      <div class="col-md-12">
        <div class="card-custom">
          <h6 class="fw-bold">Detail Layanan</h6>
          <h2 class="fw-bold"><?php echo $detail['title']; ?></h2>
          <p><?php echo $detail['description']; ?></p>
          <h3>Mengapa <?php echo $layanan; ?>?</h3>
          <p><?php echo $detail['description']; ?></p>
          <ul>
            <?php foreach ($detail['benefits'] as $benefit): ?>
            <li><?php echo $benefit; ?></li>
            <?php endforeach; ?>
          </ul>
          <a class="btn btn-primary mt-3" href="https://wa.me/6282152588142?text=Hi%2C%20saya%20ingin%20Reservasi%20Layanan%3A%0ANama%3A%0ANo.%20HP%3A%0AAlamat%3A%0ALayanan%3A%0AJumlah%3A">Konsultasi Sekarang!</a>
          <!--<button class="btn btn-primary mt-3" href="https://wa.me/6282152588142?text=Hi%2C%20saya%20ingin%20Reservasi%20Layanan%3A%0ANama%3A%0ANo.%20HP%3A%0AAlamat%3A%0ALayanan%3A%0AJumlah%3A">Konsultasi Sekarang!</button>
        </div>
      </div>
    </div>
  </div>

  </body>

  <?php
  include("../template/footer.php");
  ?>
