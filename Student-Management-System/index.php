<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_is_logged_in']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$query = "SELECT * FROM mahasiswa_kelas;"; // mengambil semua tabel mahasiswa_kelas di db
$sql = mysqli_query($conn, $query);
$no = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Bootstrap -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="/js/bootstrap.bundle.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="fontawesome/css/font-awesome.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="datatables/datatables.css">
    <script type="text/javascript" src="datatables/datatables.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- CDN DataTables CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Bundle JS (dengan Popper.js, agar alert bisa ditutup) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



    <title>Data Mahasiswa</title>
</head>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dt').DataTable();
    });
</script>

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
</style>

<body>
    <nav class="navbar navbar-maroon">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                CRUD PROJECT
            </a>
            <a class="btn btn-dark btn-sm" href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="container">
        <h1 class="mt-4">Data Mahasiswa D4 Teknik Informatika B</h1>
        <figure>

            <figcaption class="blockquote-footer">
                CRUD <cite title="Source Title">Create Read Update Delete</cite>
            </figcaption>
        </figure>
        <a href="kelola.php" type="button" class="btn btn-primary mb-3">
            <i class="fa fa-plus"></i> Tambah Data
        </a>

        <?php if (isset($_SESSION['eksekusi'])) : ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <?= $_SESSION['eksekusi']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php unset($_SESSION['eksekusi']);
        endif; ?>


        <div class="table-responsive">
            <table id="dt" class="table align-middle table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>
                            <center>No</center>
                        </th>
                        <th>NRP</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Jurusan</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>No Hp</th>
                        <th>Asal SMA</th>
                        <th>Mata Kuliah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($result = mysqli_fetch_assoc($sql)) { ?>
                        <tr>
                            <td>
                                <center><?php echo ++$no; ?>.</center>
                            </td>
                            <td><?php echo $result['nrp']; ?></td>
                            <td><?php echo $result['nama']; ?></td>
                            <td><?php echo $result['jenis_kelamin']; ?></td>
                            <td><?php echo $result['jurusan']; ?></td>
                            <td><?php echo $result['email']; ?></td>
                            <td><?php echo $result['alamat']; ?></td>
                            <td><?php echo $result['nohp']; ?></td>
                            <td><?php echo $result['asal_sma']; ?></td>
                            <td><?php echo $result['matkul_fav']; ?></td>

                            <td class="d-flex gap-2">
                                <a href="kelola.php?ubah=<?php echo $result['id_mahasiswa']; ?>" class="btn btn-success btn-sm">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a href="proses.php?hapus=<?php echo $result['id_mahasiswa']; ?>" class="btn btn-danger btn-sm" onClick="return confirm('Apakah anda yakin ingin menghapus data?')">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>


                            </td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>