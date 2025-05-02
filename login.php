<?php
include 'koneksi.php';
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Eduvista</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .loginbox {
            background-color: rgb(125, 179, 245);
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }

        .logo {
            width: 120px;
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
            color: #333;
            margin-bottom: 6px;
            margin-top: 15px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: #007BFF;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.4);
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #007BFF;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 25px;
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
            color:rgb(19, 7, 245);
            text-decoration: none;
            font-weight: 500;
        }

        a:hover {
            text-decoration: underline;
        }

        .message {
            margin-top: 15px;
            font-size: 14px;
        }

        @media (max-width: 480px) {
            .loginbox {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="loginbox">
        <img src="img/LambangEduvista.jpg" alt="Eduvista Logo" class="logo">
        <h2>Login</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Masukkan Email Anda" required>

            <label for="password">Kata Sandi</label>
            <input type="password" id="password" name="password" placeholder="Masukkan Kata Sandi Anda" required>

            <button type="submit" name="submit">Login</button>

            <p>Belum punya akun? <a href="Daftar2.php">Daftar</a></p>
        </form>

        <div class="message">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $hashed_password, $role);
                $stmt->fetch();

                if (password_verify($password, $hashed_password)) {
                    $_SESSION['user_id'] = $id;
                    $_SESSION['email'] = $email;
                    $_SESSION['role'] = $role;

                    echo "<p style='color:green;'>Login berhasil! Mengarahkan...</p>";

                    if ($role === 'pengajar') {
                        header("refresh:2;url=dashboard_pengajar.php");
                    } else {
                        header("refresh:2;url=dashboard_pelajar.php");
                    }
                    exit;
                } else {
                    echo "<p style='color:red;'>Kata sandi salah!</p>";
                }
            } else {
                echo "<p style='color:red;'>Email tidak ditemukan!</p>";
            }
        }
        ?>
        </div>
    </div>
</body>
</html>
