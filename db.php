<?php
$host = 'localhost'; // Server database
$user = 'root'; // Username database
$password = ''; // Password database
$dbname = 'catatan_db'; // Nama database

// Membuat koneksi
$conn = new mysqli($host, $user, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>