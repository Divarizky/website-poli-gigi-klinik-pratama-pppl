<?php
include("../template/header.php");

// Fungsi untuk mengambil data layanan berdasarkan type
function getLayananByType($type) {
    $layanan = [
        'poli-gigi' => [
            ['name' => 'Scalling', 'image' => 'assets/img/layanan/scalling.png', 'description' => 'Pembersihan karang gigi'],
            ['name' => 'Tambal Gigi', 'image' => 'assets/img/layanan/tambal.png', 'description' => 'Perawatan gigi berlubang'],
            ['name' => 'Perawatan Syaraf Gigi', 'image' => 'assets/img/layanan/perawatan_syaraf.png', 'description' => 'Perawatan syaraf gigi'],
            ['name' => 'Behel Gigi', 'image' => 'assets/img/layanan/behel.png', 'description' => 'Perawatan behel gigi'],
            ['name' => 'Veneer Gigi', 'image' => 'assets/img/layanan/veneer.png', 'description' => 'Perawatan veneer gigi'],
            ['name' => 'Bleaching Gigi', 'image' => 'assets/img/layanan/bleaching.png', 'description' => 'Pemutihan gigi'],
            ['name' => 'Pencabutan Gigi', 'image' => 'assets/img/layanan/pencabutan.png', 'description' => 'Pencabutan gigi'],
            ['name' => 'Perawatan Gigi Anak', 'image' => 'assets/img/layanan/perawatan_gigi.png', 'description' => 'Perawatan gigi anak'],
        ],
        // Tambahkan kategori lain yang dibutuhkan
    ];

    return $layanan[$type] ?? [];
}

// Mendapatkan type dari query string
$type = $_GET['type'] ?? 'poli-gigi'; // Default ke poli-gigi jika type tidak ditentukan

// Mengambil data layanan berdasarkan type
$layananData = getLayananByType($type);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Klinik Pratama</title>
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

  <div class="layanan my-5">
    <div class="row g-4">
      <!-- Kartu Layanan -->
      <div class="col-md-8">
        <div class="card-custom">
          <h6 class="fw-bold">Layanan</h6>
          <h2 class="fw-bold">Layanan <?php echo ucfirst(str_replace('-', ' ', $type)); ?></h2>
          <p>
            Poli Gigi Klinik Pratama hadir dengan misi untuk memberikan pelayanan kesehatan gigi terbaik yang mengutamakan kenyamanan dan keamanan pasien. Tim dokter profesional kami siap membantu Anda dalam menjaga kesehatan gigi dan mulut Anda.
          </p>
        </div>
      </div>
      <!-- Placeholder Gambar -->
      <div class="col-md-4">
        <div class="icon-placeholder">
          <img src="assets/img/layanan/service.jpg" alt="Placeholder Image">
        </div>
      </div>
    </div>

    <!-- Daftar Layanan -->
    <div class="row mt-5 g-4">
      <?php foreach ($layananData as $layanan): ?>
      <div class="col-md-3 col-6">
        <div class="service-card">
          <div class="service-icon">
            <img src="<?php echo $layanan['image']; ?>" alt="<?php echo $layanan['name']; ?>">
          </div>
          <h6><?php echo $layanan['name']; ?></h6>
          <p><?php echo $layanan['description']; ?></p>
          <a href="pages/detailservice.php?layanan=<?php echo urlencode($layanan['name']); ?>" class="btn btn-primary mt-3">Lihat Detail</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  </body>

  <?php
  include("../template/footer.php");
  ?>
