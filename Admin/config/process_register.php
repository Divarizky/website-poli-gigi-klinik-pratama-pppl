<?php
include 'config_query.php'; // Memanggil file konfigurasi database

$name = $_POST['name'];
$username = $_POST['username'];
$password = $_POST['password'];

// Cek apakah username sudah ada
$sql_check = "SELECT * FROM tb_admin WHERE username = '$username'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    echo "<script>
            alert('Username sudah terdaftar!');
            window.location.href = '../pages/register.html';
          </script>";
} else {
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $sql_insert = "INSERT INTO tb_admin (name, username, password) VALUES ('$name', '$username', '$hashed_password')";

    if ($conn->query($sql_insert)) {
        echo "<script>
                alert('Akun berhasil dibuat!');
                window.location.href = '../pages/login.html';
              </script>";
    } else {
        echo "<script>
                alert('Terjadi kesalahan!');
                window.location.href = '../pages/register.html';
              </script>";
    }
}
$conn->close();
?>
