<?php
session_start();
include 'koneksi.php';

// Cek apakah yang login adalah dosen
if (!isset($_SESSION['user_is_logged_in']) || $_SESSION['role'] !== 'dosen') {
    header("Location: login.php");
    exit;
}

// Ambil mata kuliah favorit dosen dari tabel admin berdasarkan username session
$username = $_SESSION['username'];

// Pastikan username aman untuk query (bisa pakai prepared statement lebih aman)
$username_safe = mysqli_real_escape_string($conn, $username);

$query_matkul = "SELECT matkul_fav FROM admin WHERE username = '$username_safe' LIMIT 1";
$result_matkul = mysqli_query($conn, $query_matkul);

if (!$result_matkul || mysqli_num_rows($result_matkul) === 0) {
    die("Mata kuliah dosen tidak ditemukan.");
}

$dosen_matkul = mysqli_fetch_assoc($result_matkul)['matkul_fav'];

// Query ambil data mahasiswa yang matkul_fav-nya sama dengan dosen_matkul
$query = "SELECT * FROM mahasiswa_kelas WHERE matkul_fav = '$dosen_matkul'";
$sql = mysqli_query($conn, $query);

if (!$sql) {
    die("Query error: " . mysqli_error($conn));
}

$no = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Data Mahasiswa</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="fontawesome/css/font-awesome.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="datatables/datatables.css">
    <script type="text/javascript" src="datatables/datatables.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            background-image: url('uni2.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .navbar-maroon {
            background-color: rgb(77, 73, 56);
        }

        .navbar-maroon .navbar-brand,
        .navbar-maroon .btn {
            color: white;
        }

        .navbar-maroon .btn:hover {
            background-color: #5C3317;
            color: white;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.85);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            margin-top: 30px;
        }

        table.dataTable {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            overflow: hidden;
            font-size: 14px;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(139, 69, 19, 0.1);
        }

        .nilai-form {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .nilai-input {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .catatan-input {
            width: 100%;
        }

        .catatan-input textarea {
            width: 100%;
            padding: 5px;
            font-size: 12px;
            border-radius: 4px;
            border: 1px solid #ddd;
            resize: vertical;
            min-height: 60px;
        }

        .nilai-display {
            font-weight: bold;
        }

        .catatan-display {
            font-size: 12px;
            color: #555;
            background-color: #f8f9fa;
            padding: 5px;
            border-radius: 4px;
            margin-top: 5px;
        }
    </style>
</head>

<script>
    $(document).ready(function() {
        $('#dt').DataTable();
    });
</script>

<body>
    <nav class="navbar navbar-maroon">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Dosen Dashboard</a>
            <a class="btn btn-dark btn-sm" href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="container">
        <h1 class="mt-4">Selamat datang, Mu'arifin S.ST., M.T </h1>
        <figure>
            <blockquote class="blockquote">
                <p>Halaman ini menampilkan tugas mahasiswa dan memberi nilai.</p>
            </blockquote>
            <figcaption class="blockquote-footer">
                Dosen Role <cite title="Source Title">Read & Give Grade</cite>
            </figcaption>
        </figure>

        <?php if (isset($_SESSION['eksekusi'])) : ?>
            <div class="alert" style="background-color: #e7f3fe; border-left: 4px solid #2196F3; padding: 10px; margin-top: 15px;">
                <?= htmlspecialchars($_SESSION['eksekusi']); ?>
                <?php unset($_SESSION['eksekusi']); ?>
            </div>
        <?php endif; ?>


        <div class="table-responsive">
            <table id="dt" class="table align-middle table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NRP</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Mata Kuliah</th>
                        <th>File Tugas</th>
                        <th>Tanggal Upload</th>
                        <th>Nilai & Catatan</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($result = mysqli_fetch_assoc($sql)) : ?>
                        <tr>
                            <td><?= ++$no ?></td>
                            <td><?= htmlspecialchars($result['nrp']) ?></td>
                            <td><?= htmlspecialchars($result['nama']) ?></td>
                            <td><?= htmlspecialchars($result['email']) ?></td>
                            <td><?= htmlspecialchars($result['matkul_fav'] ?? '-') ?></td>

                            <!-- File -->
                            <td>
                                <?php if (!empty($result['file'])) : ?>
                                    <a href="download.php?file=<?= urlencode($result['file']); ?>" class="btn btn-info btn-sm">
                                        <i class="fa fa-download"></i> Download
                                    </a>
                                <?php else : ?>
                                    <span class="text-muted">Belum Upload</span>
                                <?php endif; ?>
                            </td>

                            <!-- Tanggal Upload -->
                            <td>
                                <?= !empty($result['tanggal_upload']) ? date("d-m-Y H:i", strtotime($result['tanggal_upload'])) : '<span class="text-muted">-</span>'; ?>
                            </td>

                            <!-- Nilai dan Catatan -->
                            <td>
                                <?php if (!empty($result['nilai'])) : ?>
                                    <div class="nilai-display">
                                        Nilai: <?= htmlspecialchars($result['nilai']) ?>
                                    </div>
                                    <?php if (!empty($result['catatan'])) : ?>
                                        <div class="catatan-display">
                                            <strong>Catatan:</strong> <?= htmlspecialchars($result['catatan']) ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <form method="post" action="beri_nilai.php" class="nilai-form">
                                    <input type="hidden" name="id_mahasiswa" value="<?= htmlspecialchars($result['id_mahasiswa']); ?>">

                                    <div class="nilai-input">
                                        <input type="number" name="nilai"
                                            value="<?= htmlspecialchars($result['nilai'] ?? ''); ?>"
                                            min="0" max="100"
                                            class="form-control form-control-sm"
                                            style="width: 70px;">
                                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                    </div>

                                    <div class="catatan-input">
                                        <textarea name="catatan" placeholder="Berikan catatan untuk mahasiswa..."><?=
                                                                                                                    htmlspecialchars($result['catatan'] ?? '')
                                                                                                                    ?></textarea>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile ?>
                </tbody>
            </table>
        </div>
</body>

</html>