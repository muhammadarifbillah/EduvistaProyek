<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran Eduvista</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: white;
            min-height: 140vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .daftarbox {
            background-color:rgb(125, 179, 245);
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
            text-align: center;
            min-height: 125vh; 
        }

        .logo {
            width: 150px;
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 25px;
            color: #333;
            font-weight: 600;
        }

        label {
            display: block;
            text-align: left;
            font-size: 14px;
            color: #444;
            margin-bottom: 5px;
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 12px;
            font-size: 15px;
            transition: border 0.3s ease;
        }

        input:focus, select:focus {
            border-color: #007BFF;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #007BFF;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 12px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        p {
            margin-top: 20px;
            font-size: 14px;
            color: #333;
        }

        a {
            color:rgb(17, 0, 255);
            text-decoration: none;
            font-weight: 500;
        }

        a:hover {
            text-decoration: underline;
        }

        .message {
            margin-top: 10px;
            font-size: 14px;
        }

    </style>
</head>
<body>
    <div class="daftarbox">
        <img src="img/LambangEduvista.jpg" alt="Eduvista Logo" class="logo">
        <h2>Daftar Akun Baru</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Masukkan Email Anda" required>

            <label for="password">Kata Sandi</label>
            <input type="password" id="password" name="password" placeholder="Masukkan Kata Sandi Anda" required>

            <label for="confirm-password">Konfirmasi Kata Sandi</label>
            <input type="password" id="confirm-password" name="confirm_password" placeholder="Ulangi Kata Sandi" required>

            <label for="role">Pilih Peran</label>
            <select id="role" name="role" required>
                <option value="">-- Pilih Peran --</option>
                <option value="pengajar">Pengajar</option>
                <option value="pelajar">Pelajar</option>
            </select>

            <button type="submit" name="submit">Daftar</button>
            <p>Sudah punya akun? <a href="login.php">Masuk di sini</a></p>
        </form>

        <div class="message">
        <?php
        include 'koneksi.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $role = $_POST['role'] ?? '';

            if (empty($role)) {
                echo "<p style='color:red;'>Silakan pilih peran Anda!</p>";
            } elseif ($password !== $confirm_password) {
                echo "<p style='color:red;'>Konfirmasi kata sandi tidak cocok!</p>";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
                $check->bind_param("s", $email);
                $check->execute();
                $check->store_result();

                if ($check->num_rows > 0) {
                    echo "<p style='color:red;'>Email sudah terdaftar!</p>";
                } else {
                    $stmt = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $email, $hashed_password, $role);

                    if ($stmt->execute()) {
                        echo "<p style='color:green;'>Pendaftaran berhasil! Silakan login.</p>";
                    } else {
                        echo "<p style='color:red;'>Terjadi kesalahan saat mendaftar.</p>";
                    }
                }
            }
        }
        ?>
        </div>
    </div>
</body>
</html>
