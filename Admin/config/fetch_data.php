<?php
include 'config_query.php';

// Query untuk mendapatkan data dokter
$doctors = [];
$sql_doctor = "SELECT * FROM tb_dokter";
$result_doctor = $conn->query($sql_doctor);

if ($result_doctor->num_rows > 0) {
    while ($row = $result_doctor->fetch_assoc()) {
        $doctors[] = $row;
    }
}

// Query untuk mendapatkan data pasien
$patients = [];
$sql_patient = "SELECT p.id_pasien, p.tanggal_kunjungan, p.nama_pasien, p.usia, p.jenis_kelamin, p.kategori, d.nama_dokter 
                FROM tb_pasien p 
                JOIN tb_dokter d ON p.id_dokter = d.id_dokter";
$result_patient = $conn->query($sql_patient);

if ($result_patient->num_rows > 0) {
    while ($row = $result_patient->fetch_assoc()) {
        $patients[] = $row;
    }
}

// Mengembalikan data dalam format JSON
echo json_encode([
    "doctors" => $doctors,
    "patients" => $patients,
]);
?>
