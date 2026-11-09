<?php
include 'koneksi.php';

// Inisialisasi Variabel untuk menyimpan pesan error & sukses
$error = '';
$success = '';

// Memastikan proses di dalamnya hanya dijalankan ketika user menekan tombol Daftar
if (isset($_POST['register'])) {
    // Mengambil dan menyimpan inut dari user 
    $username    = $_POST['username'];
    $password    = md5($_POST['password']);
    $role        = $_POST['role'];
    // Hanya diisi ketika role dosen / mahasiswa
    $matkul_fav = ($role == 'dosen') ? $_POST['matkul_fav'] : null;
    $nrp         = ($role == 'mahasiswa') ? $_POST['nrp'] : '';

    // Validasi input
    // Mengecek apakah sudah terisi semua, jika masih ada 1 yang kosong maka tampil pesan error
    if (empty($username) || empty($password) || empty($role)) {
        $error = "Semua field wajib diisi!";
    } elseif ($role == 'mahasiswa' && empty($nrp)) { // kondisi ketika jika role yang dipilih mahasiswa dan nrp belum diisi
        $error = "NRP wajib diisi untuk mahasiswa!";
    } elseif ($role == 'dosen' && empty($matkul_fav)) {
        $error = "Mata kuliah favorit wajib diisi untuk dosen!";
    } else {
        $cek = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");

        if (mysqli_num_rows($cek) > 0) {
            $error = "Username sudah terdaftar!";
        } else {
            // Query berdasarkan role
            if ($role == 'dosen') {
                $query = "INSERT INTO admin (username, password, role, matkul_fav) 
                    VALUES ('$username', '$password', '$role', '$matkul_fav')";
            } else {
                $query = "INSERT INTO admin (username, password, role, nrp) 
                    VALUES ('$username', '$password', '$role', '$nrp')";
            }

            if (mysqli_query($conn, $query)) {
                $success = "Registrasi berhasil. Silakan login.";
            } else {
                $error = "Registrasi gagal. Silakan coba lagi.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Registrasi</title>
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

        .register-container {
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

        .logo {
            width: 160px;
            height: 160px;
            display: block;
            margin: 0 auto 15px auto;
        }

        h2 {
            text-align: center;
            color: #fff;
            margin-bottom: 20px;
        }

        .error,
        .success {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            color: #fff;
            font-weight: bold;
            margin-bottom: 5px;
            text-align: left;
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

        .link-login {
            text-align: center;
            margin-top: 10px;
        }

        .link-login a {
            color: #fff;
            text-decoration: underline;
        }
    </style>

    <script>
        function toggleFields() { // tampilan kolom input
            const role = document.querySelector('select[name="role"]').value; // mengambil nilai role yang dipilih
            const nrpField = document.getElementById('nrp-field'); // Elemen nrp ditampilkan
            const matkulField = document.getElementById('matkul-fav-field'); //Elemen mata kuliah ditampilkan

            if (role === 'mahasiswa') {
                nrpField.style.display = 'block';
                document.getElementById('nrp').required = true;
                matkulField.style.display = 'none';
            } else if (role === 'dosen') {
                nrpField.style.display = 'none';
                document.getElementById('nrp').required = false;
                matkulField.style.display = 'block';
            } else {
                nrpField.style.display = 'none';
                document.getElementById('nrp').required = false;
                matkulField.style.display = 'none';
            }
        }

        window.onload = function() {
            toggleFields();
            document.querySelector('select[name="role"]').addEventListener('change', toggleFields);
        };
    </script>
</head>

<body>
    <div class="register-container">
        <img src="logo2.png" alt="Logo" class="logo">
        <h2>Registrasi Akun</h2>

        <?php if ($error): ?>
            <p class="error"><?= $error; ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p class="success"><?= $success; ?></p>
        <?php endif; ?>

        <form method="post" action="">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <div id="nrp-field">
                <label>NRP:</label>
                <input type="text" name="nrp" id="nrp">
            </div>

            <label>Daftar sebagai:</label>
            <select name="role" required>
                <option value="">-- Pilih Role --</option>
                <option value="mahasiswa">Mahasiswa</option>
                <option value="dosen">Dosen</option>
            </select>

            <div id="matkul-fav-field" style="display: none;">
                <label>Mata Kuliah:</label>
                <input type="text" name="matkul_fav">
            </div>

            <input type="submit" name="register" value="Daftar">
        </form>

        <div class="link-login">
            <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </div>
    </div>
</body>

</html>