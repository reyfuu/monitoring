-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for belajar
CREATE DATABASE IF NOT EXISTS `belajar` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `belajar`;

-- Dumping structure for table belajar.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table belajar.admin: ~0 rows (approximately)
INSERT INTO `admin` (`id`, `email`, `password`) VALUES
	('1', 'admin@admin', '$2y$12$P9hybvsmXXHr5TL/lR5xLuMRPH6STRS1P/2LqJpYDD30qFLuSKDba');

-- Dumping structure for table belajar.bimbingan
CREATE TABLE IF NOT EXISTS `bimbingan` (
  `bimbingan_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `topik` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `npm` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `domen_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `isi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`bimbingan_id`),
  KEY `bimbingan_mahasiswa_FK` (`npm`),
  KEY `bimbingan_domen_FK` (`domen_id`),
  CONSTRAINT `bimbingan_domen_FK` FOREIGN KEY (`domen_id`) REFERENCES `domen` (`domen_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `bimbingan_mahasiswa_FK` FOREIGN KEY (`npm`) REFERENCES `mahasiswa` (`npm`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table belajar.bimbingan: ~3 rows (approximately)
INSERT INTO `bimbingan` (`bimbingan_id`, `topik`, `status`, `npm`, `domen_id`, `tanggal`, `isi`) VALUES
	('BM001', 'UI/UX', 'submit', '123er', '9', '2024-05-06', 'hell'),
	('BM004', 'Sistem Informasi', 'submit', '123er', '12345', '2024-06-10', 'sd');

-- Dumping structure for table belajar.comment
CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `domen_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `npm` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` datetime NOT NULL,
  `isi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dokumen` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `comment_domen_FK` (`domen_id`),
  KEY `comment_mahasiswa_FK` (`npm`),
  CONSTRAINT `comment_domen_FK` FOREIGN KEY (`domen_id`) REFERENCES `domen` (`domen_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comment_mahasiswa_FK` FOREIGN KEY (`npm`) REFERENCES `mahasiswa` (`npm`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table belajar.comment: ~0 rows (approximately)

-- Dumping structure for table belajar.domen
CREATE TABLE IF NOT EXISTS `domen` (
  `domen_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`domen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table belajar.domen: ~4 rows (approximately)
INSERT INTO `domen` (`domen_id`, `email`, `name`, `password`, `status`) VALUES
	('1', 'admin@admin.com', 'admin', 'admin', 'admin'),
	('12345', 'ryan@gmail.com', 'ryan', '$2y$12$B1YBOnfMVPMRaQ4o7ErXKOqfkh0FhgrwOmz/QBXGnT/kxwZe0L3BO', 'Dosen'),
	('23dasd2', 'ahmad@ahmad', 'Ahmad Maulana', '$2y$12$DDN3biIq0j8mDA6/PsbqDO9GZ4QLg6vxPufXGO/864vO5dPMPp7.a', 'Mentor'),
	('9', 'yulia@gmail.com', 'yulia', '$2y$12$cSSUrLlCyW1XxejSllepeu0S3EIfr84qgDqC3Ve4p9R9Q5/YtpyUS', 'Dosen');

-- Dumping structure for table belajar.laporan
CREATE TABLE IF NOT EXISTS `laporan` (
  `laporan_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_berakhir` date DEFAULT NULL,
  `deskripsi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `domen_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `npm` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dokumen` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`laporan_id`),
  KEY `laporan_domen_FK` (`domen_id`),
  KEY `laporan_mahasiswa_FK` (`npm`),
  CONSTRAINT `laporan_domen_FK` FOREIGN KEY (`domen_id`) REFERENCES `domen` (`domen_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `laporan_mahasiswa_FK` FOREIGN KEY (`npm`) REFERENCES `mahasiswa` (`npm`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table belajar.laporan: ~2 rows (approximately)
INSERT INTO `laporan` (`laporan_id`, `judul`, `tanggal_mulai`, `tanggal_berakhir`, `deskripsi`, `domen_id`, `npm`, `dokumen`, `status`, `type`, `comment`) VALUES
	('LP001', 'sistem informasi', '2024-03-06', '2024-05-20', 'isi', '9', '123er', 'laporan.pdf', 'submit', 'Proposal', ''),
	('LP002', NULL, '2024-06-10', '2010-09-24', NULL, '12345', '123rt', 'idk.pdf', NULL, 'Proposal', NULL);

-- Dumping structure for table belajar.laporan_harian
CREATE TABLE IF NOT EXISTS `laporan_harian` (
  `laporan_harian_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isi` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `dokumen` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `domen_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `npm` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`laporan_harian_id`),
  KEY `laporan_harian_domen_FK` (`domen_id`),
  KEY `laporan_harian_mahasiswa_FK` (`npm`),
  CONSTRAINT `laporan_harian_domen_FK` FOREIGN KEY (`domen_id`) REFERENCES `domen` (`domen_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `laporan_harian_mahasiswa_FK` FOREIGN KEY (`npm`) REFERENCES `mahasiswa` (`npm`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table belajar.laporan_harian: ~7 rows (approximately)
INSERT INTO `laporan_harian` (`laporan_harian_id`, `status`, `isi`, `tanggal`, `dokumen`, `domen_id`, `npm`, `comment`) VALUES
	('LH001', NULL, 'jello', '2024-10-10', NULL, '12345', '123er', NULL),
	('LH002', NULL, 'sdadsd', '2024-06-04', NULL, '12345', '123er', NULL),
	('LH003', NULL, 'dfds', '2024-06-03', NULL, '12345', '123er', NULL),
	('LH004', NULL, 'uygygj', '2024-03-04', NULL, '9', '123er', NULL),
	('LH005', NULL, NULL, '2024-03-04', NULL, '9', '123er', NULL),
	('LH006', NULL, 'fgfg', '2024-03-04', NULL, '9', '123er', NULL),
	('LH007', NULL, 'hello', '2024-05-06', NULL, '9', '123er', NULL);

-- Dumping structure for table belajar.mahasiswa
CREATE TABLE IF NOT EXISTS `mahasiswa` (
  `npm` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`npm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table belajar.mahasiswa: ~1 rows (approximately)
INSERT INTO `mahasiswa` (`npm`, `name`, `email`, `password`, `status`) VALUES
	('123er', 'wati', 'wati@gmail.com', '$2y$12$lXnCjfNVCbv/bKbkPFiGjOAcqVLSRUyKbCkMOhaivq0DbXdydZKYa', 'Magang'),
	('123rt', 'dida', 'didi@gmail.com', '$2y$12$.iINVaggW.LFRg8EoGeyHu0NsnzWyzxk0NrlM1qt6paM4ehzmVCAm', 'Magang');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
