<?php
session_start();
include '../koneksi.php';

// Cek role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'pengajar') {
    header("Location: ../login.php");
    exit;
}

$id_pengajar = $_SESSION['user_id'];

// Tambah kelas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $nama_kelas = $_POST['nama_kelas'];
    $deskripsi = $_POST['deskripsi'];

    $stmt = $conn->prepare("INSERT INTO kelas (nama_kelas, deskripsi, id_pengajar) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $nama_kelas, $deskripsi, $id_pengajar);
    $stmt->execute();

    header("Location: kelola_kelas.php");
    exit;
}

// Hapus kelas
if (isset($_GET['hapus'])) {
    $id_kelas = $_GET['hapus'];

    $stmt = $conn->prepare("DELETE FROM kelas WHERE id = ? AND id_pengajar = ?");
    $stmt->bind_param("ii", $id_kelas, $id_pengajar);
    $stmt->execute();

    header("Location: kelola_kelas.php");
    exit;
}

// Edit kelas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $id_kelas = $_POST['id_kelas'];
    $nama_kelas = $_POST['nama_kelas'];
    $deskripsi = $_POST['deskripsi'];

    $stmt = $conn->prepare("UPDATE kelas SET nama_kelas = ?, deskripsi = ? WHERE id = ? AND id_pengajar = ?");
    $stmt->bind_param("ssii", $nama_kelas, $deskripsi, $id_kelas, $id_pengajar);
    $stmt->execute();

    header("Location: kelola_kelas.php");
    exit;
}

// Ambil semua kelas untuk tampilan
$stmt = $conn->prepare("SELECT id, nama_kelas, deskripsi, created_at FROM kelas WHERE id_pengajar = ?");
$stmt->bind_param("i", $id_pengajar);
$stmt->execute();
$result = $stmt->get_result();

// Untuk load data saat mau edit
$edit_data = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $stmt_edit = $conn->prepare("SELECT id, nama_kelas, deskripsi FROM kelas WHERE id = ? AND id_pengajar = ?");
    $stmt_edit->bind_param("ii", $edit_id, $id_pengajar);
    $stmt_edit->execute();
    $result_edit = $stmt_edit->get_result();
    $edit_data = $result_edit->fetch_assoc();
}
?>
