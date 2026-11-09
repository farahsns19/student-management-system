<?php
session_start();
include 'koneksi.php';

$error = '';

// Pengecekan ketika tombol login ditekan 
if (isset($_POST['login'])) {
    $username = $_POST['username']; // Mengambil data dari form
    $password = md5($_POST['password']); // diubah ke bentuk MD5 (krn database pakai MD5)
    $role = $_POST['role'];
    // Cek database apakah data cocok dari apa yang di inputkan user dan yg ada di dtbs
    $query = "SELECT * FROM admin WHERE username='$username' AND password='$password' AND role='$role'";
    $result = mysqli_query($conn, $query);
    // Kondisi pengecekan jika ditemukan 1 data yg cocok maka login berhasil
    if (mysqli_num_rows($result) == 1) {
        // Mengambil data user dr hasil query dan mengubah jd array asosiatif
        $data = mysqli_fetch_assoc($result);
        // Untuk menandai bahwa user sudah login
        $_SESSION['user_is_logged_in'] = true;
        // Menyimpan username ke dalam session untuk menampilkan data user di halaman
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $data['role'];
        // Menyimpan NRP ke session untuk membedakan NRP berdasarkan user yg login nantinya akan menampilkan datanya sendiri
        $_SESSION['nrp'] = $data['nrp']; // Simpan NRP

        // Mengarahkan input an user sesuai halaman role
        if ($data['role'] == 'admin') {
            header("Location: index.php");
        } elseif ($data['role'] == 'dosen') {
            header("Location: dosen.php");
        } elseif ($data['role'] == 'mahasiswa') {
            header("Location: mahasiswa.php");
        } else {
            $error = "Role tidak dikenali.";
        }
        exit;
    } else {
        // Jika gagal login maka pesan error
        $error = "Username, Password, atau Role salah!";
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <style>
        body {
            background-image: url('uni2.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(10px);
            width: 350px;
            padding: 30px;
            margin: 100px auto;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        h2 {
            text-align: center;
            color: #fff;
            margin-bottom: 20px;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            color: #fff;
            font-weight: bold;
            text-align: left;
        }

        .logo {
            width: 160px;
            height: 160px;
            display: block;
            margin: 0 auto 15px auto;
        }

        input[type="text"],
        input[type="password"],
        select {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: rgb(77, 73, 56);
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        input[type="submit"]:hover {
            background-color: rgb(37, 29, 7);
        }

        p a {
            color: #fff;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <!-- Logo -->
        <img src="logo2.png" alt="Logo" class="logo">

        <!-- Judul -->
        <h2 align="center">Login</h2>

        <!-- Notifikasi Error -->
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <!-- Form Login -->
        <form method="post" action=""> <!-- Data dikirim secara tersembunyi -->
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <!-- Daftar pilihan untuk user memilih -->
            <label for="role">Login sebagai:</label>
            <select name="role" id="role" required>
                <option value="">-- Pilih Role --</option>
                <option value="admin">Admin</option>
                <option value="dosen">Dosen</option>
                <option value="mahasiswa">Mahasiswa</option>
            </select>

            <input type="submit" name="login" value="Login">
        </form>

        <!-- Link ke Halaman Register -->
        <p align="center">
            Belum punya akun? <a href="register.php">Daftar di sini</a>
        </p>

        <!-- Notifikasi Logout -->
        <?php if (isset($_GET['logout']) && $_GET['logout'] == 'true'): ?>
            <script>
                alert("Anda telah logout.");
            </script>
        <?php endif; ?>
    </div>
</body>

</html>