-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.31 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for ragel
CREATE DATABASE IF NOT EXISTS `ragel` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `ragel`;

-- Dumping structure for table ragel.barang
CREATE TABLE IF NOT EXISTS `barang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori_id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `stok` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_kategori_barang` (`kategori_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table ragel.barang: 2 rows
/*!40000 ALTER TABLE `barang` DISABLE KEYS */;
INSERT INTO `barang` (`id`, `kategori_id`, `nama`, `keterangan`, `stok`) VALUES
	(2, 11, 'barang 1', 'tes 1', 10),
	(3, 11, 'barang 2', 'tes 2', 0);
/*!40000 ALTER TABLE `barang` ENABLE KEYS */;

-- Dumping structure for table ragel.kategori
CREATE TABLE IF NOT EXISTS `kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table ragel.kategori: 2 rows
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` (`id`, `nama`) VALUES
	(1, 'Kategori 1'),
	(11, 'kategori 2');
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;

-- Dumping structure for table ragel.setting
CREATE TABLE IF NOT EXISTS `setting` (
  `id` varchar(50) NOT NULL,
  `value` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- Dumping data for table ragel.setting: 2 rows
/*!40000 ALTER TABLE `setting` DISABLE KEYS */;
INSERT INTO `setting` (`id`, `value`) VALUES
	('app_name', 'Inventory Ragel'),
	('user_wa', '6281215992673');
/*!40000 ALTER TABLE `setting` ENABLE KEYS */;

-- Dumping structure for table ragel.transaksi
CREATE TABLE IF NOT EXISTS `transaksi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(100) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `mitra` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_barang_pengadaan` (`barang_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table ragel.transaksi: 1 rows
/*!40000 ALTER TABLE `transaksi` DISABLE KEYS */;
INSERT INTO `transaksi` (`id`, `kode`, `barang_id`, `tanggal`, `harga`, `jumlah`, `mitra`, `keterangan`) VALUES
	(1, 'IN01', 2, '2024-01-21 00:00:00', 210000, 10, 'pt badrul', 'oke sip');
/*!40000 ALTER TABLE `transaksi` ENABLE KEYS */;

-- Dumping structure for table ragel.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `no_wa` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table ragel.user: 1 rows
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `nama`, `password`, `no_wa`) VALUES
	(1, 'Badrulaa', '$2y$10$LGgRopvxe0u/CuJl4YWLROq8Ap0mtTai84WeSaj1dXvCxZKYnd9nC', '6281215992673');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
