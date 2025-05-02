<?php
session_start();

// Cek apakah sudah login dan role-nya pelajar
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'pelajar') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pelajar</title>
</head>
<body>
    <h1>Selamat Datang, <?php echo htmlspecialchars($_SESSION['email']); ?>!</h1>
    <h2>Ini adalah Dashboard untuk Pelajar</h2>

    <ul>
        <li><a href="#">Lihat Materi</a></li>
        <li><a href="#">Kumpulkan Tugas</a></li>
        <li><a href="#">Lihat Nilai</a></li>
    </ul>

    <p><a href="logout.php">Logout</a></p>
</body>
</html>
