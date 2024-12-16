<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Poli Gigi Klinik Medikasih</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Base URL -->
  <base href="http://localhost/website-poli-gigi-klinik-pratama-pppl/">

  <!-- Favicons -->
  <link href="assets/img/logo.jpg" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="index-page">
  <header id="header" class="header sticky-top">
    <div class="branding d-flex align-items-center">
      <div class="container position-relative d-flex align-items-center justify-content-end">
        <a href="index.php" class="logo d-flex align-items-center me-auto">
          <img src="assets/img/logo.jpg" alt="Logo Klinik">
          <h3 class="sitename">Klinik Medikasih</h3>
        </a>
        <nav id="navmenu" class="navmenu">
          <ul class="nav">
            <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>">
              <a href="pages/about.php">Tentang Kami</a>
            </li>
            <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'service.php' ? 'active' : ''; ?>">
              <a href="pages/service.php">Layanan</a>
            </li>
            <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'doctor.php' ? 'active' : ''; ?>">
              <a href="pages/doctor.php">Dokter</a>
            </li>
            <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'contact_us.php' ? 'active' : ''; ?>">
              <a href="pages/contact_us.php">Kontak</a>
            </li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
        <a class="cta-btn" href="#" onclick="openWhatsApp()">Reservasi</a>
        <script>
          function openWhatsApp() {
            window.open('https://wa.me/6282152588142?text=' + encodeURIComponent('Hi, saya ingin Reservasi Layanan:\nNama:\nNo. HP:\nAlamat:\nLayanan:\nJumlah:'), '_blank');
          }
        </script>
      </div>
    </div>
  </header>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const navToggle = document.querySelector('.mobile-nav-toggle');
  const navMenu = document.querySelector('.navmenu ul');

  navToggle.addEventListener('click', function () {
    document.body.classList.toggle('mobile-nav-active');
  });

  // Close the dropdown when clicking outside
  document.addEventListener('click', function (event) {
    if (!navMenu.contains(event.target) && !navToggle.contains(event.target)) {
      document.body.classList.remove('mobile-nav-active');
    }
  });
});
</script>

</body>
</html>
