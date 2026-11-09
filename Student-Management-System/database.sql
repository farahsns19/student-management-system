-- Database: `crud`
CREATE DATABASE IF NOT EXISTS `crud`;
USE `crud`;

-- --------------------------------------------------------

-- Table structure for table `admin`
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','dosen','mahasiswa') NOT NULL,
  `matkul_fav` varchar(100) DEFAULT NULL,
  `nrp` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table `admin`
-- Credentials:
-- 1. admin     / password: admin123
-- 2. dosen1    / password: dosen123
-- 3. farah     / password: mhs123
INSERT INTO `admin` (`id`, `username`, `password`, `role`, `matkul_fav`, `nrp`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'admin', NULL, NULL),
(2, 'dosen1', 'd5bbfb47ac3160c31fa8c247827115aa', 'dosen', 'Pemrograman Web', NULL),
(3, 'farah', '39f55dd65ead9c938fa93a765983bff0', 'mahasiswa', NULL, '3124600053')
ON DUPLICATE KEY UPDATE `username`=`username`;

-- --------------------------------------------------------

-- Table structure for table `mahasiswa_kelas`
CREATE TABLE IF NOT EXISTS `mahasiswa_kelas` (
  `id_mahasiswa` int(11) NOT NULL AUTO_INCREMENT,
  `nrp` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(20) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `nohp` varchar(20) NOT NULL,
  `asal_sma` varchar(100) NOT NULL,
  `matkul_fav` varchar(100) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `nilai` varchar(50) DEFAULT '0',
  `catatan` text DEFAULT NULL,
  PRIMARY KEY (`id_mahasiswa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table `mahasiswa_kelas`
INSERT INTO `mahasiswa_kelas` (`id_mahasiswa`, `nrp`, `nama`, `jenis_kelamin`, `jurusan`, `email`, `alamat`, `nohp`, `asal_sma`, `matkul_fav`, `file`, `nilai`, `catatan`) VALUES
(1, '3124600053', 'Farah Hasna Salsabila', 'Perempuan', 'Teknik Informatika', 'farah@example.com', 'Surabaya', '081234567890', 'SMAN 1 Surabaya', 'Pemrograman Web', NULL, '95', 'Sangat Baik')
ON DUPLICATE KEY UPDATE `id_mahasiswa`=`id_mahasiswa`;
