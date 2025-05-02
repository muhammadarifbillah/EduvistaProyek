<?php
$servername = "localhost"; // Biasanya localhost
$username = "root";         // Username database kamu
$password = "";             // Password database kamu
$dbname = "eduvista_db";    // Nama database

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>