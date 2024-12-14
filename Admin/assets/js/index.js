document.addEventListener("DOMContentLoaded", function () {
  const doctorTable = document.getElementById("doctorTable");
  const patientTable = document.getElementById("patientTable");

  // Fungsi untuk mengambil data dari database
  async function fetchData() {
    try {
      const response = await fetch("../config/fetch_data.php");
      const data = await response.json();

      // Render tabel dokter
      doctorTable.innerHTML = data.doctors
        .map(
          (doctor, index) => `
          <tr>
              <td>${index + 1}</td>
              <td><img src="../assets/images/doctor.png" alt="Foto Dokter" style="width: 50px;"></td>
              <td>${doctor.nama_dokter}</td>
              <td>${new Date(doctor.tanggal_update).toLocaleDateString()}</td>
              <td>
                  <button onclick="updateDoctor(${doctor.id_dokter})">Update</button>
                  <button onclick="deleteDoctor(${doctor.id_dokter})">Delete</button>
              </td>
          </tr>
        `
        )
        .join("");

      // Render tabel pasien
      patientTable.innerHTML = data.patients
        .map(
          (patient, index) => `
          <tr>
              <td>${index + 1}</td>
              <td>${new Date(patient.tanggal_kunjungan).toLocaleString()}</td>
              <td>${patient.nama_pasien}</td>
              <td>${patient.usia}</td>
              <td>${patient.jenis_kelamin}</td>
              <td>${patient.kategori}</td>
              <td>${patient.nama_dokter}</td>
              <td>
                  <button onclick="editPatient(${patient.id_pasien})">Edit</button>
                  <button onclick="deletePatient(${patient.id_pasien})">Delete</button>
              </td>
          </tr>
        `
        )
        .join("");
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  }

  // Panggil fungsi fetchData untuk load data saat halaman dimuat
  fetchData();
});

// Fungsi placeholder untuk fitur update dan delete
// function updateDoctor(id) {
//   alert("Fitur Update Dokter akan ditambahkan untuk ID: " + id);
// }

// function deleteDoctor(id) {
//   alert("Fitur Delete Dokter akan ditambahkan untuk ID: " + id);
// }

// function editPatient(id) {
//   alert("Fitur Edit Pasien akan ditambahkan untuk ID: " + id);
// }

// function deletePatient(id) {
//   alert("Fitur Delete Pasien akan ditambahkan untuk ID: " + id);
// }
