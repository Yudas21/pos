-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               10.1.36-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table pos_db.akses
CREATE TABLE IF NOT EXISTS `akses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_level` tinyint(3) unsigned NOT NULL,
  `id_menu` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pos_db.akses: ~32 rows (approximately)
/*!40000 ALTER TABLE `akses` DISABLE KEYS */;
INSERT INTO `akses` (`id`, `id_level`, `id_menu`) VALUES
	(2, 1, 2),
	(3, 1, 5),
	(4, 1, 7),
	(5, 1, 9),
	(7, 1, 11),
	(8, 1, 12),
	(9, 1, 8),
	(10, 1, 17),
	(11, 1, 18),
	(12, 1, 19),
	(13, 1, 20),
	(15, 1, 1),
	(16, 1, 10),
	(17, 2, 1),
	(18, 2, 3),
	(20, 2, 13),
	(21, 2, 14),
	(22, 3, 1),
	(23, 3, 4),
	(25, 3, 16),
	(26, 3, 5),
	(27, 3, 7),
	(28, 3, 10),
	(29, 3, 11),
	(30, 4, 1),
	(32, 4, 13),
	(33, 4, 14),
	(34, 4, 15),
	(35, 4, 16),
	(36, 3, 23),
	(37, 3, 24),
	(38, 2, 17),
	(39, 4, 22),
	(40, 2, 21),
	(41, 3, 21),
	(42, 4, 21),
	(43, 3, 25),
	(44, 4, 25),
	(45, 4, 26),
	(46, 3, 22);
/*!40000 ALTER TABLE `akses` ENABLE KEYS */;

-- Dumping structure for table pos_db.barang
CREATE TABLE IF NOT EXISTS `barang` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kategori` tinyint(3) unsigned NOT NULL,
  `id_suplier` int(10) unsigned NOT NULL,
  `jumlah` double NOT NULL,
  `satuan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` double NOT NULL,
  `promo` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `diskon` double DEFAULT NULL,
  `tgl_mulai_promo` date DEFAULT NULL,
  `tgl_sampai_promo` date DEFAULT NULL,
  `tgl_kadaluarsa` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pos_db.barang: ~0 rows (approximately)
/*!40000 ALTER TABLE `barang` DISABLE KEYS */;
/*!40000 ALTER TABLE `barang` ENABLE KEYS */;

-- Dumping structure for table pos_db.customer
CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomor_kartu` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_customer` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_lahir_customer` date NOT NULL,
  `kontak_customer` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pos_db.customer: ~0 rows (approximately)
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;

-- Dumping structure for table pos_db.kategori_barang
CREATE TABLE IF NOT EXISTS `kategori_barang` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ket_kategori` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pos_db.kategori_barang: ~0 rows (approximately)
/*!40000 ALTER TABLE `kategori_barang` DISABLE KEYS */;
/*!40000 ALTER TABLE `kategori_barang` ENABLE KEYS */;

-- Dumping structure for table pos_db.level
CREATE TABLE IF NOT EXISTS `level` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `nama_level` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pos_db.level: ~3 rows (approximately)
/*!40000 ALTER TABLE `level` DISABLE KEYS */;
INSERT INTO `level` (`id`, `nama_level`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Admin', NULL, NULL, NULL),
	(2, 'Kasir', NULL, NULL, NULL),
	(3, 'Gudang', NULL, NULL, NULL),
	(4, 'Owner', NULL, NULL, NULL);
/*!40000 ALTER TABLE `level` ENABLE KEYS */;

-- Dumping structure for table pos_db.menu
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama_menu` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ikon_menu` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_menu` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_menu` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pos_db.menu: ~19 rows (approximately)
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` (`id`, `nama_menu`, `ikon_menu`, `url_menu`, `parent_menu`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Dasboard', 'fa fa-home', 'dashboard', 0, NULL, '2018-11-28 11:21:28', NULL),
	(2, 'User Management', 'fa fa-cogs', NULL, 0, NULL, NULL, NULL),
	(3, 'Sale', 'fa fa-dollar', 'sale', 0, NULL, NULL, NULL),
	(4, 'Pembelian', 'fa fa-shopping-cart', '', 0, NULL, NULL, NULL),
	(5, 'Supplier', 'fa fa-truck', 'supplier', 0, NULL, NULL, NULL),
	(7, 'Barang', 'fa fa-cubes', '', 0, NULL, NULL, NULL),
	(8, 'Menu', NULL, 'admin/menu', 2, NULL, NULL, NULL),
	(9, 'Level', NULL, 'admin/level', 2, NULL, NULL, NULL),
	(10, 'Kategori Barang', NULL, 'kategori', 7, NULL, '2018-11-28 15:09:14', NULL),
	(11, 'Daftar Barang', NULL, 'daftar_barang', 7, NULL, NULL, NULL),
	(12, 'User', NULL, 'admin/users', 2, NULL, NULL, NULL),
	(13, 'Penjualan Harian', NULL, 'lap_harian', 21, NULL, NULL, NULL),
	(14, 'Penjualan Per Periode', NULL, 'lap_periode', 21, NULL, NULL, NULL),
	(15, 'Penjualan Per Kasir', NULL, 'lap_stok', 21, NULL, NULL, NULL),
	(16, 'Stok of Name', NULL, 'lap_kadaluarsa', 21, NULL, NULL, NULL),
	(17, 'Customer', 'fa fa-id-card', 'customer', 0, NULL, NULL, NULL),
	(18, 'Database', 'fa fa-database', 'admin/database', 0, NULL, NULL, NULL),
	(19, 'Setting', NULL, 'admin/setting', 18, NULL, NULL, NULL),
	(20, 'Backup', NULL, 'admin/backup', 18, NULL, NULL, NULL),
	(21, 'Laporan', 'fa fa-file', NULL, 0, NULL, NULL, NULL),
	(22, 'Kadaluarsa', NULL, NULL, 21, NULL, NULL, NULL),
	(23, 'Usulan', NULL, NULL, 4, NULL, NULL, NULL),
	(24, 'Realisasi', NULL, NULL, 4, NULL, NULL, NULL),
	(25, 'Pembelian', NULL, NULL, 21, NULL, NULL, NULL),
	(26, 'Laba - Rgi', NULL, NULL, 21, NULL, NULL, NULL);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;

-- Dumping structure for table pos_db.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pos_db.migrations: ~11 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2018_11_27_185051_create_levels_table', 2),
	(4, '2018_11_27_185549_create_menus_table', 3),
	(5, '2018_11_27_190008_create_akses_table', 4),
	(6, '2018_11_27_190234_create_kategori_barangs_table', 5),
	(7, '2018_11_27_190532_create_supliers_table', 6),
	(8, '2018_11_27_192040_create_customers_table', 7),
	(9, '2018_11_27_192518_create_barangs_table', 8),
	(10, '2018_11_27_193928_create_settings_table', 9),
	(11, '2018_11_27_194332_create_sales_table', 10),
	(12, '2018_11_27_211951_create_sales_details_table', 11),
	(13, '2018_11_27_212515_create_pembelians_table', 12);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table pos_db.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pos_db.password_resets: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table pos_db.pembelian
CREATE TABLE IF NOT EXISTS `pembelian` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nomor_invoice` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_pembelian` date NOT NULL,
  `id_barang` int(10) unsigned NOT NULL,
  `id_suplier` int(10) unsigned NOT NULL,
  `jumlah` double NOT NULL,
  `harga` double NOT NULL,
  `satuan` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` double NOT NULL,
  `ket` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pos_db.pembelian: ~0 rows (approximately)
/*!40000 ALTER TABLE `pembelian` DISABLE KEYS */;
/*!40000 ALTER TABLE `pembelian` ENABLE KEYS */;

-- Dumping structure for table pos_db.sales
CREATE TABLE IF NOT EXISTS `sales` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_kasir` int(10) unsigned NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pos_db.sales: ~0 rows (approximately)
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;

-- Dumping structure for table pos_db.sales_detail
CREATE TABLE IF NOT EXISTS `sales_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_sales` int(10) unsigned NOT NULL,
  `id_barang` int(10) unsigned NOT NULL,
  `jumlah` double NOT NULL,
  `harga` double NOT NULL,
  `persen_diskon` double NOT NULL,
  `besar_diskon` double NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pos_db.sales_detail: ~0 rows (approximately)
/*!40000 ALTER TABLE `sales_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `sales_detail` ENABLE KEYS */;

-- Dumping structure for table pos_db.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `nama_setting` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai_setting` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pos_db.settings: ~0 rows (approximately)
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;

-- Dumping structure for table pos_db.suplier
CREATE TABLE IF NOT EXISTS `suplier` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama_suplier` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_suplier` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kontak_suplier` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pos_db.suplier: ~0 rows (approximately)
/*!40000 ALTER TABLE `suplier` DISABLE KEYS */;
/*!40000 ALTER TABLE `suplier` ENABLE KEYS */;

-- Dumping structure for table pos_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_handphone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_level` tinyint(3) unsigned DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table pos_db.users: ~3 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `nama`, `tempat_lahir`, `tgl_lahir`, `jenis_kelamin`, `alamat`, `no_handphone`, `username`, `email`, `id_level`, `email_verified_at`, `password`, `remember_token`, `foto`, `active`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Admin', NULL, NULL, 'Laki-laki', NULL, NULL, 'admin', 'baim.moh@gmail.com', 1, NULL, '$2y$10$GlDR9uEYJG3u2z0AO1ngX.2Oi78EJJQClkE8SSNP80OlL7SsDSJme', 'cw3VvppY5TtVf0ZTYnpqABeSxk2D0ehzTOsN3BQTqFWnIkTpheIqIz5ybG0w', NULL, '1', '2018-11-27 18:48:34', '2018-11-28 19:39:46', NULL),
	(2, 'Kasir', NULL, NULL, NULL, NULL, NULL, 'kasir', '', 2, NULL, '$2y$10$QRZ.Rf0/DQ75wxAx4q9LfezEouh0XOwIZZjL8X1MMpo1t7fiBemYS', 'O8ERYLR8DvyHXAkDlBv35AvkIEJBYPSF6cAMfz1oupsoUL8UBdZSoDOiI9RI', NULL, '1', '2018-11-28 19:33:44', '2018-11-28 19:49:33', NULL),
	(4, 'Gudang', NULL, NULL, NULL, NULL, NULL, 'gudang', NULL, 3, NULL, '$2y$10$c4mBT0x0m/b2vpnuB5mY8udETrPGfttDAkHNtG2HYOrAlzcKqFhPC', '0B3aWCPumilfaKCkSUBiHKaVTsNHoGe9RbkcnlNdv5NxB1AUo0tMhDGWe8OJ', NULL, '1', '2018-11-28 19:39:19', '2018-11-28 19:50:03', NULL),
	(5, 'Owner', NULL, NULL, NULL, NULL, NULL, 'owner', NULL, 4, NULL, '$2y$10$J1GdpoAgtEFUUN/jI6o6sO9E2m.B8FXEw1Lh0rpERBE3TxsHTfuLe', 'EfZZ7ItKpKKnjMQNEgdAnBDS3FGcXHlHhn9ZzuAKGZY31VAq72xuyjd4e9rq', NULL, '1', '2018-11-28 20:29:43', '2018-11-28 20:29:43', NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
