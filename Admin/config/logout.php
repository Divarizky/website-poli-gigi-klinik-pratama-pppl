<?php
session_start();
session_destroy(); // Hapus semua sesi
header('Location: ../pages/login.html'); // Redirect ke halaman login
exit();
?>
