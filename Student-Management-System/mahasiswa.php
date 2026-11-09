<?php
session_start();
include 'koneksi.php';

date_default_timezone_set("Asia/Jakarta");

if (!isset($_SESSION['user_is_logged_in']) || $_SESSION['role'] != 'mahasiswa') {
    header("Location: login.php");
    exit;
}

$nrp = $_SESSION['nrp'];

// Ambil nama mahasiswa dulu
$query_nama = "SELECT nama FROM mahasiswa_kelas WHERE nrp = '$nrp' LIMIT 1";
$result_nama = mysqli_query($conn, $query_nama);
$row_nama = mysqli_fetch_assoc($result_nama);
$nama_mahasiswa = $row_nama['nama'] ?? 'Mahasiswa';

// Query utama untuk menampilkan data mahasiswa (bisa banyak data)
$query = "SELECT * FROM mahasiswa_kelas WHERE nrp = '$nrp';";
$sql = mysqli_query($conn, $query);
$no = 0;


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Data Mahasiswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-image: url('uni2.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
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
            font-size: 14px;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(139, 69, 19, 0.1);
        }

        /* Style tambahan untuk catatan dosen */
        .nilai-section {
            min-width: 120px;
        }

        .nilai-display {
            font-weight: bold;
            color: #28a745;
            font-size: 1.1rem;
        }

        .catatan-dosen {
            background-color: #f8f9fa;
            border-left: 3px solid #6c757d;
            padding: 8px;
            margin-top: 8px;
            border-radius: 4px;
            font-size: 13px;
        }

        .catatan-header {
            font-weight: bold;
            color: #495057;
            margin-bottom: 5px;
        }

        .dosen-name {
            font-size: 12px;
            color: #6c757d;
            text-align: right;
            margin-top: 5px;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#dt').DataTable();
        });
    </script>
</head>

<body>
    <nav class="navbar navbar-maroon">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Mahasiswa Dashboard</a>
            <a class="btn btn-dark btn-sm" href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="container">
        <h1 class="mt-4">Selamat datang, <?= htmlspecialchars($nama_mahasiswa); ?>!</h1>

        <figure>
            <figcaption class="blockquote-footer">
                CRUD <cite title="Source Title">Website Pengumpulan Tugas</cite>
            </figcaption>
        </figure>

        <?php if (isset($_SESSION['eksekusi'])) : ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <?= $_SESSION['eksekusi']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['eksekusi']); ?>
        <?php endif; ?>

        <div class="table-responsive">
            <table id="dt" class="table table-bordered table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th>
                            <center>No</center>
                        </th>
                        <th>NRP</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Mata Kuliah</th>
                        <th>File Tugas</th>
                        <th><small>Tanggal Upload</small></th>
                        <th>Nilai & Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($result = mysqli_fetch_assoc($sql)) { ?>
                        <tr>
                            <td>
                                <center><?= ++$no; ?>.</center>
                            </td>
                            <td><?= htmlspecialchars($result['nrp']); ?></td>
                            <td><?= htmlspecialchars($result['nama']); ?></td>
                            <td><?= htmlspecialchars($result['email']); ?></td>
                            <td><?= htmlspecialchars($result['matkul_fav']); ?></td>
                            <td>
                                <?php if (!empty($result['file'])) : ?>
                                    <div class="d-flex flex-column">
                                        <a href="download.php?file=<?= urlencode($result['file']); ?>" class="btn btn-info btn-sm mb-1">
                                            <i class="fa fa-download"></i> Download
                                        </a>
                                        <form action="edit_file.php" method="POST" enctype="multipart/form-data" class="d-flex flex-column">
                                            <input type="hidden" name="id_mahasiswa" value="<?= $result['id_mahasiswa']; ?>">
                                            <input type="hidden" name="old_file" value="<?= $result['file']; ?>">
                                            <input type="file" name="file" class="form-control form-control-sm mb-1" required>
                                            <button type="submit" name="edit_file" class="btn btn-sm btn-warning">
                                                <i class="fa fa-edit"></i> Edit File
                                            </button>
                                        </form>
                                    </div>
                                <?php else : ?>
                                    <form action="upload.php" method="POST" enctype="multipart/form-data" class="d-flex flex-column">
                                        <input type="hidden" name="id_mahasiswa" value="<?= $result['id_mahasiswa']; ?>">
                                        <textarea name="deskripsi_tugas" class="form-control form-control-sm mb-1" placeholder="Judul atau deskripsi tugas..." required></textarea>
                                        <input type="file" name="file" class="form-control form-control-sm mb-1" required>
                                        <button type="submit" name="upload" class="btn btn-sm btn-secondary">Upload</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                            <td><?= !empty($result['tanggal_upload']) ? date('d-m-Y H:i', strtotime($result['tanggal_upload'])) : '-'; ?></td>
                            <td class="nilai-section">
                                <?php if (!empty($result['nilai'])) : ?>
                                    <?php
                                    $nilai = (int) $result['nilai'];
                                    $warna_nilai = $nilai < 70 ? 'text-danger' : 'text-success';
                                    ?>
                                    <div class="nilai-display <?= $warna_nilai ?>">
                                        <?= htmlspecialchars($nilai) ?>
                                    </div>
                                <?php else : ?>
                                    <div class="text-muted">Belum dinilai</div>
                                <?php endif; ?>

                                <?php if (!empty($result['catatan'])) : ?>
                                    <div class="catatan-dosen">
                                        <div class="catatan-header">Catatan Dosen:</div>
                                        <div><?= nl2br(htmlspecialchars($result['catatan'])) ?></div>
                                        <?php if (!empty($result['nama_dosen'])) : ?>
                                            <div class="dosen-name">
                                                - <?= htmlspecialchars($result['nama_dosen']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>