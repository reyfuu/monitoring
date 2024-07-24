-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 08, 2024 at 09:49 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `belajar`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
('1', 'admin@admin', '$2y$12$P9hybvsmXXHr5TL/lR5xLuMRPH6STRS1P/2LqJpYDD30qFLuSKDba');

-- --------------------------------------------------------

--
-- Table structure for table `bimbingan`
--

CREATE TABLE `bimbingan` (
  `bimbingan_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `topik` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `npm` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `domen_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `isi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bimbingan`
--

INSERT INTO `bimbingan` (`bimbingan_id`, `topik`, `status`, `npm`, `domen_id`, `tanggal`, `isi`) VALUES
('BM001', 'UI/UX', 'submit', '123er', '9', '2024-05-06', 'hell'),
('BM004', 'Sistem Informasi', 'submit', '123er', '12345', '2024-06-10', 'sd');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `domen_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `npm` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` datetime NOT NULL,
  `isi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `domen_id`, `npm`, `tanggal`, `isi`) VALUES
('CM001', '9', '123er', '2024-07-07 00:00:00', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `domen`
--

CREATE TABLE `domen` (
  `domen_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `domen`
--

INSERT INTO `domen` (`domen_id`, `email`, `name`, `password`, `status`) VALUES
('1', 'admin@admin.com', 'admin', 'admin', 'admin'),
('12345', 'ryan@gmail.com', 'ryan', '$2y$12$B1YBOnfMVPMRaQ4o7ErXKOqfkh0FhgrwOmz/QBXGnT/kxwZe0L3BO', 'Dosen'),
('23dasd2', 'ahmad@ahmad', 'Ahmad Maulana', '$2y$12$DDN3biIq0j8mDA6/PsbqDO9GZ4QLg6vxPufXGO/864vO5dPMPp7.a', 'Mentor'),
('9', 'yulia@gmail.com', 'yulia', '$2y$12$cSSUrLlCyW1XxejSllepeu0S3EIfr84qgDqC3Ve4p9R9Q5/YtpyUS', 'Dosen');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
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
  `comment` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`laporan_id`, `judul`, `tanggal_mulai`, `tanggal_berakhir`, `deskripsi`, `domen_id`, `npm`, `dokumen`, `status`, `type`, `comment`) VALUES
('LP002', NULL, '2024-06-10', '2024-09-24', NULL, '12345', '123er', 'coba.pdf', NULL, 'Proposal', NULL),
('LP003', 'ai', '2024-03-06', '2024-05-20', 'test', '9', '123er', 'coba.pdf', 'perlu direvisi', 'Proposal', NULL),
('LP004', 'hello', '2024-04-05', '2024-05-23', 'test', '9', '123er', 'coba.pdf', 'perlu direvisi', 'Laporan', NULL),
('LP005', 'hai', '2024-03-07', '2024-05-21', 'test2', '9', '123rt', 'laporan.pdf', 'perlu direvisi', 'Laporan', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `laporan_harian`
--

CREATE TABLE `laporan_harian` (
  `laporan_harian_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `domen_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `npm` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minggu` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laporan_harian`
--

INSERT INTO `laporan_harian` (`laporan_harian_id`, `isi`, `tanggal`, `domen_id`, `npm`, `comment`, `minggu`) VALUES
('LH001', 'jello', '2024-10-10', '12345', '123er', NULL, NULL),
('LH002', 'sdadsd', '2024-06-04', '12345', '123er', NULL, NULL),
('LH003', 'dfds', '2024-06-03', '12345', '123er', NULL, NULL),
('LH006', 'test100', '2024-06-10', '12345', '123er', NULL, '1'),
('LH007', 'test2', '2024-06-11', '12345', '123er', NULL, '1'),
('LH008', 'test30', '2024-06-12', '12345', '123er', NULL, '1'),
('LH009', 'test 4', '2024-06-13', '12345', '123er', NULL, '1'),
('LH010', 'test 5', '2024-06-14', '12345', '123er', NULL, '1'),
('LH011', 'test 6', '2024-06-15', '12345', '123er', NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_mingguan`
--

CREATE TABLE `laporan_mingguan` (
  `laporan_mingguan_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `domen_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `npm` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `week` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laporan_mingguan`
--

INSERT INTO `laporan_mingguan` (`laporan_mingguan_id`, `isi`, `domen_id`, `npm`, `week`, `status`) VALUES
('LM001', 'rangkuman12', '9', '123er', '1', 'perlu direvisi'),
('LM002', 'rangkuman2', '9', '123er', '2', 'menunggu persetujuan mentor');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `npm` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`npm`, `name`, `email`, `password`, `status`) VALUES
('123er', 'wati', 'wati@gmail.com', '$2y$12$lXnCjfNVCbv/bKbkPFiGjOAcqVLSRUyKbCkMOhaivq0DbXdydZKYa', 'Magang'),
('123rt', 'dida', 'didi@gmail.com', '$2y$12$.iINVaggW.LFRg8EoGeyHu0NsnzWyzxk0NrlM1qt6paM4ehzmVCAm', 'Magang');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bimbingan`
--
ALTER TABLE `bimbingan`
  ADD PRIMARY KEY (`bimbingan_id`),
  ADD KEY `bimbingan_mahasiswa_FK` (`npm`),
  ADD KEY `bimbingan_domen_FK` (`domen_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment_domen_FK` (`domen_id`),
  ADD KEY `comment_mahasiswa_FK` (`npm`);

--
-- Indexes for table `domen`
--
ALTER TABLE `domen`
  ADD PRIMARY KEY (`domen_id`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`laporan_id`),
  ADD KEY `laporan_domen_FK` (`domen_id`),
  ADD KEY `laporan_mahasiswa_FK` (`npm`);

--
-- Indexes for table `laporan_harian`
--
ALTER TABLE `laporan_harian`
  ADD PRIMARY KEY (`laporan_harian_id`),
  ADD KEY `laporan_harian_domen_FK` (`domen_id`),
  ADD KEY `laporan_harian_mahasiswa_FK` (`npm`);

--
-- Indexes for table `laporan_mingguan`
--
ALTER TABLE `laporan_mingguan`
  ADD PRIMARY KEY (`laporan_mingguan_id`),
  ADD KEY `newtable_domen_FK` (`domen_id`),
  ADD KEY `newtable_mahasiswa_FK` (`npm`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`npm`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bimbingan`
--
ALTER TABLE `bimbingan`
  ADD CONSTRAINT `bimbingan_domen_FK` FOREIGN KEY (`domen_id`) REFERENCES `domen` (`domen_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bimbingan_mahasiswa_FK` FOREIGN KEY (`npm`) REFERENCES `mahasiswa` (`npm`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_domen_FK` FOREIGN KEY (`domen_id`) REFERENCES `domen` (`domen_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_mahasiswa_FK` FOREIGN KEY (`npm`) REFERENCES `mahasiswa` (`npm`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_domen_FK` FOREIGN KEY (`domen_id`) REFERENCES `domen` (`domen_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_mahasiswa_FK` FOREIGN KEY (`npm`) REFERENCES `mahasiswa` (`npm`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `laporan_harian`
--
ALTER TABLE `laporan_harian`
  ADD CONSTRAINT `laporan_harian_domen_FK` FOREIGN KEY (`domen_id`) REFERENCES `domen` (`domen_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laporan_harian_mahasiswa_FK` FOREIGN KEY (`npm`) REFERENCES `mahasiswa` (`npm`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `laporan_mingguan`
--
ALTER TABLE `laporan_mingguan`
  ADD CONSTRAINT `newtable_domen_FK` FOREIGN KEY (`domen_id`) REFERENCES `domen` (`domen_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `newtable_mahasiswa_FK` FOREIGN KEY (`npm`) REFERENCES `mahasiswa` (`npm`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
