<?php
include("template/header.php");

// konfigurasi database
include("Admin/config/config_query.php");
?>

<head>
  <!-- CSS -->
  <link href="assets/css/dashboard.css" rel="stylesheet">

</head>

<main class="main">

  <!-- Dashboard Section -->
  <div class="home mt-5">
    <div class="row">
      <!-- Left Section -->
      <div class="col-lg-6">
        <div class="info-card">
          <p class="mb-2">Home</p>
          <h1>Informasi Poli Gigi</h1>
          <p>Pengalaman Baru dalam Perawatan Gigi: Bebas Nyeri dengan Teknologi Terbaru! Jadikan Kesehatan Gigi Lebih
            Mudah dan Nyaman.</p>
        </div>
      </div>
      <!-- Right Section -->
      <div class="col-lg-6">
        <div class="row g-4">
          <!-- Card 1 -->
          <div class="col-6 icon-home">
            <img src="assets/img/dashboard/patient-1.png" alt="Icon 1">
            <h6>100.000+</h6>
            <p>Pasien Setiap Tahunnya</p>
          </div>
          <!-- Card 2 -->
          <div class="col-6 icon-home">
            <img src="assets/img/dashboard/patient-2.png" alt="Icon 2">
            <h6>> 16 Tahun</h6>
            <p>Memberikan Pelayanan Terbaik</p>
          </div>
          <!-- Card 3 -->
          <div class="col-6 icon-home">
            <img src="assets/img/dashboard/dentist.png" alt="Icon 3">
            <h6>Tim Dokter Gigi</h6>
            <p>Berpengalaman, Lebih dari 150 Spesialis</p>
          </div>
          <!-- Card 4 -->
          <div class="col-6 icon-home">
            <img src="assets/img/dashboard/dental-clinic.png" alt="Icon 4">
            <h6>Memberikan Kenyamanan</h6>
            <p>dan Keamanan dalam Perawatan Gigi</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--Jadwal Table Section-->
  <div class="jadwal-page mt-5">
    <h1>Jadwal Klinik</h1>
    <div class="jadwal-table">
      <table class="table">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Dokter</th>
            <th>Hari Praktik</th>
            <th>Jam Praktik</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Ambil data semua dokter
          $result_dokter = bacaSemuaDokter();

          // Cek jika ada data dokter
          if ($result_dokter->num_rows > 0) {
            $no = 1; // Nomor urut baris
            while ($dokter = $result_dokter->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $no++ . "</td>";
              echo "<td>" . htmlspecialchars($dokter['nama_dokter']) . "</td>";
              echo "<td>" . htmlspecialchars($dokter['hari_praktik']) . "</td>";
              echo "<td>" . htmlspecialchars($dokter['jam_praktik']) . "</td>";
              // Tombol untuk reservasi
              echo "<td><a class='custom-button' href='https://wa.me/6282152588142?text=Hi%2C%20saya%20ingin%20Reservasi%20Layanan%3A%0ANama%3A%0ANo.%20HP%3A%0AAlamat%3A%0ALayanan%3A%0AJumlah%3A'>Reservasi</a></td>";
              echo "</tr>";
            }
          } else {
            // Jika tidak ada dokter, tampilkan pesan ini
            echo "<tr><td colspan='5'>Tidak ada jadwal dokter yang tersedia.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <!--Konsultasi Section-->
  <div class="konsultasi mt-5">
    <div class="row justify-content-center">
      <div class="col-12 col-md-11">
        <div class="konsultasi-card d-flex justify-content-between align-items-center">
          <div>
            <h2>Konsultasi Sekarang!</h2>
            <p>Hubungi kami atau kunjungi Klinik Medikasih</p>
          </div>
          <td><a class="custom-button" href="https://wa.me/6282152588142?text=Hi%2C%20saya%20ingin%20Reservasi%20Layanan%3A%0ANama%3A%0ANo.%20HP%3A%0AAlamat%3A%0ALayanan%3A%0AJumlah%3A">Reservasi</a></td>
        </div>
      </div>
    </div>
  </div>

  <footer id="footer" class="footer light-background">
    <div class="container footer-top">
      <div class="row gy-4">

        <?php
        // Ambil data kontak dan lokasi
        $data_klinik = bacaInformasiKlinik();

        // Cek jika ada data klinik
        if ($data_klinik) {
          $kontak = htmlspecialchars($data_klinik['no_telp']);
          $lokasi = nl2br(htmlspecialchars($data_klinik['lokasi']));
        } else {
          $kontak = "Kontak tidak tersedia";
          $lokasi = "Lokasi tidak tersedia";
        }
        ?>

        <!-- Lokasi -->
        <div class="col-lg-4 col-md-5 footer-links">
          <h4>Lokasi</h4>
          <ul>
            <li><a><?php echo $lokasi; ?></a></li>
          </ul>
        </div>

        <!-- Sitemap -->
        <div class="col-lg-3 col-md-5 footer-links">
          <h4>Sitemap</h4>
          <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="pages/about.php">Tentang Kami</a></li>
            <li><a href="pages/service.php">Layanan</a></li>
            <li><a href="pages/contact_us.php">Kontak</a></li>
          </ul>
        </div>

        <!-- Kontak -->
        <div class="col-lg-3 col-md-3 footer-links">
          <h4>Kontak</h4>
          <ul>
            <li><a><?php echo $kontak; ?></a></li>
          </ul>
        </div>

        <!-- Media Sosial -->
        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Media Social</h4>
          <div class="social-links d-flex mt-1">
            <a href="https://www.instagram.com/"><i class="bi bi-instagram"></i></a>
            <a href="https://www.facebook.com/"><i class="bi bi-facebook"></i></a>
          </div>
        </div>

      </div>
    </div>
  </footer>
  <?php
  include("template/footer.php");
  ?>