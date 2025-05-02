<?php
session_start();

// Cek apakah sudah login dan role-nya pengajar
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'pengajar') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pengajar</title>
</head>
<body>
    <h1>Selamat Datang, <?php echo htmlspecialchars($_SESSION['email']); ?>!</h1>
    <h2>Dashboard Pengajar</h2>

    <ul>
        <li><a href="kelolaKelas/kelola_kelas.php">Kelola Kelas</a></li>
        <li><a href="tambah_materi.php">Tambah Materi</a></li>
        <li><a href="nilai_tugas.php">Nilai Tugas</a></li>
    </ul>

    <p><a href="logout.php">Logout</a></p>
</body>
</html>
