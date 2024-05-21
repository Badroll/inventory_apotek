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


-- Dumping database structure for inventory
CREATE DATABASE IF NOT EXISTS `inventory` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `inventory`;

-- Dumping structure for table inventory.barang
CREATE TABLE IF NOT EXISTS `barang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori_id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `stok_minimum` int(11) NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `expired` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_kategori_barang` (`kategori_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table inventory.barang: 2 rows
/*!40000 ALTER TABLE `barang` DISABLE KEYS */;
INSERT INTO `barang` (`id`, `kategori_id`, `nama`, `keterangan`, `stok_minimum`, `satuan`, `expired`) VALUES
	(1, 1, 'obat 1', 'tes', 5, 'grams', '2024-06-29'),
	(2, 1, 'Obat kedua', 'w', 1, 'kg', '2024-06-30');
/*!40000 ALTER TABLE `barang` ENABLE KEYS */;

-- Dumping structure for table inventory.kategori
CREATE TABLE IF NOT EXISTS `kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table inventory.kategori: 1 rows
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` (`id`, `nama`) VALUES
	(1, 'obat pusing');
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;

-- Dumping structure for table inventory.kontak
CREATE TABLE IF NOT EXISTS `kontak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis` enum('Supplier','Customer') NOT NULL,
  `nama` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table inventory.kontak: 2 rows
/*!40000 ALTER TABLE `kontak` DISABLE KEYS */;
INSERT INTO `kontak` (`id`, `jenis`, `nama`, `keterangan`) VALUES
	(2, 'Supplier', 'SP-01', 'suplier pertama'),
	(3, 'Customer', 'CT-01', 'customer pertama');
/*!40000 ALTER TABLE `kontak` ENABLE KEYS */;

-- Dumping structure for table inventory.setting
CREATE TABLE IF NOT EXISTS `setting` (
  `id` varchar(50) NOT NULL,
  `value` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- Dumping data for table inventory.setting: 2 rows
/*!40000 ALTER TABLE `setting` DISABLE KEYS */;
INSERT INTO `setting` (`id`, `value`) VALUES
	('app_name', 'Inventory Apotek'),
	('user_wa', '6281215992673');
/*!40000 ALTER TABLE `setting` ENABLE KEYS */;

-- Dumping structure for table inventory.transaksi
CREATE TABLE IF NOT EXISTS `transaksi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(100) NOT NULL,
  `jenis` enum('Pengadaan','Penjualan') NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `mitra_id` int(11) DEFAULT NULL,
  `keterangan` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table inventory.transaksi: 2 rows
/*!40000 ALTER TABLE `transaksi` DISABLE KEYS */;
INSERT INTO `transaksi` (`id`, `kode`, `jenis`, `tanggal`, `mitra_id`, `keterangan`) VALUES
	(3, '664C6EE913AF0', 'Penjualan', '2024-05-20 13:00:00', 3, 'so pertama'),
	(2, '664C6E8557A1C', 'Pengadaan', '2024-05-20 13:00:00', 2, 'po pertama');
/*!40000 ALTER TABLE `transaksi` ENABLE KEYS */;

-- Dumping structure for table inventory.transaksi_item
CREATE TABLE IF NOT EXISTS `transaksi_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaksi_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table inventory.transaksi_item: 2 rows
/*!40000 ALTER TABLE `transaksi_item` DISABLE KEYS */;
INSERT INTO `transaksi_item` (`id`, `transaksi_id`, `barang_id`, `harga`, `jumlah`) VALUES
	(12, 2, 1, 10000, 5),
	(13, 3, 1, 12000, 3);
/*!40000 ALTER TABLE `transaksi_item` ENABLE KEYS */;

-- Dumping structure for table inventory.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `no_wa` varchar(50) NOT NULL,
  `role` int(11) NOT NULL DEFAULT '2' COMMENT '1 = admin, 2 = petugas',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table inventory.user: 2 rows
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `nama`, `password`, `no_wa`, `role`) VALUES
	(1, 'Badrulll', '$2y$10$IJuViyHllCyKcYU7ry.3i.BYlFYfp3MaSoMIR0CNTZfQ7ARDIW5oa', '6281215992673', 1),
	(2, 'Akbar', '$2y$10$zo2OI/e8pOzCnTYb9PdreO1HQI8anp8M7RlG.X0X9w3h8tESV/4pS', '62812345', 2);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
