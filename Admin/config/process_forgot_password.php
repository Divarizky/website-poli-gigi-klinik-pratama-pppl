<?php
include 'config_query.php'; // Memanggil file konfigurasi database

$username = $_POST['username'];
$new_password = $_POST['new_password'];

// Validasi username
$sql_check = "SELECT * FROM tb_admin WHERE username = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $username); // "s" untuk string
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
  // Hash password baru
  $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

  // Mendapatkan waktu sekarang untuk memperbarui kolom updated_at
  $updated_at = date('Y-m-d H:i:s'); // Format timestamp: YYYY-MM-DD HH:MM:SS

  // Query update dengan prepared statement
  $sql_update = "UPDATE tb_admin SET password = ?, updated_at = ? WHERE username = ?";
  $stmt_update = $conn->prepare($sql_update);
  $stmt_update->bind_param("sss", $hashed_password, $updated_at, $username); // "sss" untuk tiga string
  if ($stmt_update->execute()) {
    echo "<script>
                alert('Password berhasil diperbarui!');
                window.location.href = '../pages/login.html';
              </script>";
  } else {
    echo "<script>
                alert('Terjadi kesalahan! Gagal memperbarui password.');
                window.location.href = '../pages/forgot_password.html';
              </script>";
  }
} else {
  echo "<script>
            alert('Username tidak ditemukan!');
            window.location.href = '../pages/forgot_password.html';
          </script>";
}
$conn->close();
