<!DOCTYPE html>
<html lang="en">

<?php
include 'koneksi.php';
session_start();

$nrp = '';
$nama = '';
$jenis_kelamin = '';
$jurusan = '';
$email = '';
$alamat = '';
$nohp = '';
$asal_sma = '';
$matkul_fav = '';
$file = '';

if (isset($_GET['ubah'])) {
    $id_mahasiswa = $_GET['ubah']; //Parameter ubah untuk mengedit

    $query = "SELECT * FROM mahasiswa_kelas WHERE id_mahasiswa = '$id_mahasiswa';";

    $sql = mysqli_query($conn, $query);

    $result = mysqli_fetch_assoc($sql);

    $nrp = $result['nrp'];
    $nama = $result['nama'];
    $jenis_kelamin = $result['jenis_kelamin'];
    $jurusan = $result['jurusan'];
    $email = $result['email'];
    $alamat = $result['alamat'];
    $nohp = $result['nohp'];
    $asal_sma = $result['asal_sma'];
    $matkul_fav = $result['matkul_fav'];
    $file = $result['file'] ?? '';
}
?>

<head>
    <meta charset="UTF-8">
    <!-- Bootstrap -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="/js/bootstrap.bundle.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="fontawesome/css/font-awesome.min.css">

    <title>Document</title>
</head>

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
        justify-content: center;
        align-items: center;
    }

    .navbar-maroon {
        background-color: rgb(77, 73, 56);
    }

    .navbar-maroon .navbar-brand {
        color: white;
    }

    .container {
        background-color: rgba(255, 255, 255, 0.5);
        /* lebih transparan */
        padding: 30px 40px;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        max-width: 1100px;
        width: 100%;
        margin: 40px auto;
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
</style>


<body>
    <nav class="navbar navbar-maroon mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                CRUD
            </a>
        </div>
    </nav>
    <div class="container">
        <form method="POST" action="proses.php" enctype="multipart/form-data">
            <input type="hidden" value="<?php echo $id_mahasiswa ?? ''; ?>" name="id_mahasiswa">
            <div class="mb-3 row">
                <label for="nrp" class="col-sm-2 col-form-label">NRP</label>
                <div class="col-sm-10">
                    <input required type="text" name="nrp" class="form-control" id="nrp" placeholder="Ex: 3124600053" value="<?php echo $nrp; ?>">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input required type="text" name="nama" class="form-control" id="nama" placeholder="Ex: Maudy Ayunda" value="<?php echo $nama; ?>">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-10">
                    <select required id="jenis_kelamin" name="jenis_kelamin" class="form-select">
                        <option <?php if ($jenis_kelamin == 'L') echo "selected"; ?> value="L">Laki-laki</option>
                        <option <?php if ($jenis_kelamin == 'P') echo "selected"; ?> value="P">Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="jurusan" class="col-sm-2 col-form-label">Jurusan</label>
                <div class="col-sm-10">
                    <input required type="text" name="jurusan" class="form-control" id="jurusan" placeholder="Ex: Teknik Informatika A" value="<?php echo $jurusan; ?>">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input required type="text" name="email" class="form-control" id="email" placeholder="Ex: maudyayunda@gmail.com" value="<?php echo $email; ?>">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                    <textarea required class="form-control" name="alamat" id="alamat" rows="3"><?php echo $alamat; ?></textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="nohp" class="col-sm-2 col-form-label">No. HP</label>
                <div class="col-sm-10">
                    <input required type="text" name="nohp" class="form-control" id="nohp" placeholder="Ex: +62 831-3789-95673" value="<?php echo $nohp; ?>">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="asal_sma" class="col-sm-2 col-form-label">Asal SMA</label>
                <div class="col-sm-10">
                    <input required type="text" name="asal_sma" class="form-control" id="asal_sma" placeholder="Ex: SMA Negeri 16 Surabaya" value="<?php echo $asal_sma; ?>">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="matkul_fav" class="col-sm-2 col-form-label">Mata Kuliah Fav</label>
                <div class="col-sm-10">
                    <input required type="text" name="matkul_fav" class="form-control" id="matkul_fav" placeholder="Ex: Basis Data" value="<?php echo $matkul_fav; ?>">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="file" class="col-sm-2 col-form-label">Upload File</label>
                <div class="col-sm-10">
                    <input type="file" name="file" class="form-control" id="file">
                    <?php if (isset($_GET['ubah']) && !empty($file)): ?>
                        <p class="mt-2">File saat ini:
                            <a href="uploads/<?php echo $file; ?>" target="_blank"><?php echo $file; ?></a>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col">
                    <?php if (isset($_GET['ubah'])) { ?>
                        <button type="submit" name="aksi" value="edit" class="btn btn-primary">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i>
                            Simpan Perubahan
                        </button>
                    <?php } else { ?>
                        <button type="submit" name="aksi" value="add" class="btn btn-primary">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i>
                            Tambahkan
                        </button>
                    <?php } ?>
                    <a href="index.php" type="button" class="btn btn-danger">
                        <i class="fa fa-reply" aria-hidden="true"></i>
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>