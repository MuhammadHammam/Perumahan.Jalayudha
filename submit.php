<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


// ====== KONFIGURASI DATABASE ======
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "graha_jalayudha";

// ====== KONEKSI KE DATABASE ======
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// ====== AMBIL DATA DARI FORM ======
$nama = $_POST['nama'] ?? '';
$whatsapp = $_POST['whatsapp'] ?? '';

// Pastikan semua kolom diisi
if (empty($nama) || empty($whatsapp)) {
    die("Harap isi semua kolom sebelum mengirim data!");
}

// ====== SIAPKAN QUERY DENGAN PREPARED STATEMENT ======
$stmt = $conn->prepare("INSERT INTO penawaran (nama, whatsapp) VALUES ( ?, ?)");
$stmt->bind_param("ss", $nama, $whatsapp);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
} else {
    echo "Koneksi berhasil!<br>";
}

// ====== PENGEKSEKUSIAN ======
if ($stmt->execute()) {
    // Nomor WA tujuan
    $nomorWA = "6281528269852";

    // Pesan otomatis ke WA
    $pesan = "Halo, saya $nama. Saya tertarik dengan penawaran perumahan Graha Jalayudha.";
    
    // Arahkan ke WhatsApp setelah data tersimpan
    header("Location: https://wa.me/$6281528269852?text=" . urlencode($pesan));
    exit();
} else {
    echo "Terjadi kesalahan: " . $stmt->error;
}

// Tutup koneksi
$stmt->close();
$conn->close();
?>
