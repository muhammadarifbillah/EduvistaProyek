<?php
include 'kelas_controller.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Kelas</title>
</head>
<body>
    <h1>Kelola Kelas Anda</h1>
    <p><a href="../dashboard_pengajar.php">Kembali ke Dashboard</a> | <a href="../logout.php">Logout</a></p>

    <h2><?php echo isset($edit_data) ? "Edit Kelas" : "Tambah Kelas Baru"; ?></h2>

    <form action="kelas_controller.php" method="post">
        <?php if (isset($edit_data)): ?>
            <input type="hidden" name="id_kelas" value="<?php echo $edit_data['id']; ?>">
        <?php endif; ?>

        <label for="nama_kelas">Nama Kelas:</label><br>
        <input type="text" id="nama_kelas" name="nama_kelas" value="<?php echo isset($edit_data) ? htmlspecialchars($edit_data['nama_kelas']) : ''; ?>" required><br><br>

        <label for="deskripsi">Deskripsi:</label><br>
        <textarea id="deskripsi" name="deskripsi" rows="4" cols="50" required><?php echo isset($edit_data) ? htmlspecialchars($edit_data['deskripsi']) : ''; ?></textarea><br><br>

        <button type="submit" name="<?php echo isset($edit_data) ? 'edit' : 'tambah'; ?>">
            <?php echo isset($edit_data) ? 'Update Kelas' : 'Tambah Kelas'; ?>
        </button>
    </form>

    <h2>Daftar Kelas</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>Nama Kelas</th>
            <th>Deskripsi</th>
            <th>Dibuat Pada</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['nama_kelas']); ?></td>
            <td><?php echo htmlspecialchars($row['deskripsi']); ?></td>
            <td><?php echo $row['created_at']; ?></td>
            <td>
                <a href="kelola_kelas.php?edit_id=<?php echo $row['id']; ?>">Edit</a> |
                <a href="kelas_controller.php?hapus=<?php echo $row['id']; ?>" onclick="return confirm('Yakin hapus kelas ini?');">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
