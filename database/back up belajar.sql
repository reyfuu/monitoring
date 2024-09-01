-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 31, 2024 at 01:35 AM
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
  `id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
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
  `bimbingan_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `topik` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `npm` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `domen_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `isi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bimbingan`
--

INSERT INTO `bimbingan` (`bimbingan_id`, `topik`, `status`, `npm`, `domen_id`, `tanggal`, `isi`, `type`) VALUES
('BM001', 'UI/UX', 'perlu direvisi', '123er', '9', '2024-05-06', 'hell', 'Proposal'),
('BM002', 'Sistem Informasi', 'submit', '123er', '12345', '2024-07-27', 'hello', 'Proposal'),
('BM003', 'laravel', 'disetujui', '19340019', '12345', '2024-08-21', 'adanya perbaikan di laravel', 'Proposal'),
('BM004', 'Sistem Informasi', 'disetujui', '19340019', '12345', '2024-08-26', 'perbaiki view di modal', 'Tugas Akhir'),
('BM005', 'Sistem Monitoring', 'disetujui', '19340019', '12345', '2024-08-26', 'perbaikan konsep', 'Tugas Akhir'),
('BM006', 'laravel', 'disetujui', '19340019', '12345', '2024-08-29', 'isi', 'Proposal'),
('BM007', 'laravel', 'disetujui', '19340019', '12345', '2024-08-21', 'isi', 'Proposal'),
('BM008', 'laravel', 'disetujui', '19340019', '12345', '2024-08-21', 'isi', 'Proposal'),
('BM009', 'laravel', 'disetujui', '19340019', '12345', '2024-08-21', 'isi', 'Proposal'),
('BM010', 'laravel', 'disetujui', '19340019', '12345', '2024-08-29', 'isoi', 'Proposal'),
('BM011', 'laravel', 'disetujui', '19340019', '12345', '2024-08-29', 'hei', 'Proposal'),
('BM012', 'laravel', 'disetujui', '19340019', '12345', '2024-08-29', 'isi', 'Proposal'),
('BM013', 'laravel', 'disetujui', '19340019', '12345', '2024-08-21', 'isi', 'Proposal'),
('BM014', 'laravel', 'disetujui', '19340019', '12345', '2024-08-29', 'isi', 'Proposal'),
('BM015', 'laravel', 'disetujui', '19340019', '12345', '2024-08-21', 'isi', 'Proposal'),
('BM016', 'laravel', 'disetujui', '19340019', '12345', '2024-08-29', 'isi', 'Proposal'),
('BM017', 'laravel', 'disetujui', '19340019', '12345', '2024-08-29', 'isi', 'Proposal'),
('BM018', 'laravel', 'disetujui', '19340019', '12345', '2024-08-29', 'isi', 'Proposal');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `domen_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `npm` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `isi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `domen_id`, `npm`, `tanggal`, `isi`, `type`) VALUES
('CM001', '9', '123er', '2024-07-07', 'test', ''),
('CM002', '9', '19340019', '2024-08-21', 'masalah mengenai combo box dan saat melakukan edit data', 'Proposal'),
('CM003', '12345', '19340019', '2024-08-28', 'hello', 'Proposal'),
('CM004', '12345', '19340019', '2024-08-28', 'hello', 'Proposal'),
('CM005', '12345', '19340019', '2024-08-28', 'sudah lulus', 'Proposal'),
('CM006', '12345', '19340019', '2024-08-28', 'laporan akhir sudah benar', 'Tugas AKhir'),
('CM007', '12345', '19340019', '2024-08-28', 'fix yudisium', 'Tugas AKhir'),
('CM008', '12345', '19340019', '2024-08-29', 'proposal bab 1,2 dan 3 sudah selesai', 'Proposal');

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
  `judul` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_berakhir` date DEFAULT NULL,
  `deskripsi` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `domen_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `npm` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dokumen` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`laporan_id`, `judul`, `tanggal_mulai`, `tanggal_berakhir`, `deskripsi`, `domen_id`, `npm`, `dokumen`, `status`, `type`) VALUES
('LP001', 'judul', '2024-04-05', '2024-05-23', 'test', '9', '123er', 'coba.pdf', 'Submit', 'Proposal'),
('LP004', 'hello', '2024-04-05', '2024-05-23', 'test', '9', '123er', 'coba.pdf', 'perlu direvisi', 'Laporan'),
('LP005', 'hai', '2024-03-07', '2024-05-21', 'test2', '9', '123rt', 'laporan.pdf', 'perlu direvisi', 'Laporan'),
('LP007', 'Aplikasi pemilihan template website menggunakan ', '2024-04-01', '2024-07-31', 'hello', '9', '19340012', NULL, 'submit', 'Proposal'),
('LP008', NULL, '2024-08-10', '2010-11-24', NULL, '9', '23124151', NULL, NULL, 'Proposal'),
('LP009', 'Pengembangan Aplikasi deteksi dan klasifikasi kanker kulit menggunakan metode inception V3 Berbasis ', '2024-08-19', '2019-11-24', NULL, '9', '23400005', NULL, NULL, 'Proposal'),
('LP011', NULL, '2024-08-19', '2019-11-24', NULL, '9', '203400010', NULL, NULL, 'Proposal'),
('LP012', NULL, '2024-08-19', '2019-11-24', NULL, '9', '203400012', NULL, NULL, 'Proposal'),
('LP013', NULL, '2024-08-19', '2019-11-24', NULL, '9', '203400013', NULL, NULL, 'Proposal'),
('LP014', NULL, '2024-08-19', '2019-11-24', NULL, '9', '20340014', NULL, NULL, 'Proposal'),
('LP015', NULL, '2024-08-19', '2019-11-24', NULL, '9', '20340017', NULL, NULL, 'Proposal'),
('LP016', NULL, '2024-08-19', '2019-11-24', NULL, '9', '20340018', NULL, NULL, 'Proposal'),
('LP017', NULL, '2024-08-19', '2019-11-24', NULL, '9', '20340019', NULL, NULL, 'Proposal'),
('LP018', NULL, '2024-08-19', '2019-11-24', NULL, '9', '203400023', NULL, NULL, 'Proposal'),
('LP019', 'SISTEM MONITORING MAGANG DAN TUGAS AKHIR YANG USER FRIENDLY DENGAN PENDEKATAN DESIGN THINKING DAN SUS TESTIN', '2024-02-07', '2019-11-24', 'Proses magang dan tugas akhir merupakan komponen penting dalam pendidikan tinggi. Untuk membantu mahasiswa dalam mengelola proses tersebut, sistem monitoring magang dan tugas akhir yang user-friendly sangatlah dibutuhkan. Penelitian ini bertujuan untuk membangun sistem monitoring magang dan tugas akhir yang user-friendly dengan menggunakan pendekatan Design Thinking dan SUS Testing.Penelitian ini menggunakan metode kualitatif dan kuantitatif. Metode kualitatif digunakan untuk mengumpulkan data tentang kebutuhan pengguna melalui observasi, wawancara, dan focus group discussion. Data yang diperoleh kemudian dianalisis menggunakan metode content analysis untuk mengidentifikasi tema dan pola yang muncul. Hasil analisis digunakan untuk merancang sistem monitoring magang dan tugas akhir yang sesuai dengan kebutuhan pengguna.\r\nMetode kuantitatif digunakan untuk mengevaluasi kegunaan sistem monitoring magang dan tugas akhir yang telah dirancang dengan menggunakan SUS Testing. Hasil SUS Testing menunjukkan bahwa sistem monitoring magang dan tugas akhir yang telah dirancang memiliki tingkat kegunaan yang tinggi. Penelitian ini menunjukkan bahwa pendekatan Design Thinking dan SUS Testing dapat digunakan untuk membangun sistem monitoring magang dan tugas akhir yang user-friendly. Sistem monitoring magang dan tugas akhir yang dihasilkan diharapkan dapat membantu mahasiswa dalam mengelola proses magang dan tugas akhir dengan lebih mudah dan efisien..', '12345', '19340019', '19340019-Buku TA- Audi Nathanael G.pdf', 'disetujui', 'Proposal'),
('LP022', 'SISTEM MONITORING MAGANG DAN TUGAS AKHIR YANG USER FRIENDLY DENGAN PENDEKATAN DESIGN THINKING DAN SUS TESTIN', '2024-02-07', '2019-11-24', 'abstrak2', '12345', '19340019', '203400024-Nicholas-Naskah-TA.pdf', 'disetujui', 'Tugas AKhir'),
('LP023', NULL, '2024-08-29', '2029-11-24', NULL, '12345', '123456', NULL, NULL, 'Proposal'),
('LP024', 'judul', '2024-08-29', '2029-11-24', 'abstrak', '12345', '123456', 'SWTM-2088_Atlassian-Git-Cheatsheet.pdf', NULL, 'Tugas Akhir'),
('LP025', 'Analisis Desain UI UX', '2024-08-30', '2030-11-24', 'Analisis desain ini dikerjakan mas Audi', '12345', 'dummy123', 'A.01 Pemberitahuan Jadwal Seminar Proposal.pdf', 'submit', 'Proposal');

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
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `angkatan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`npm`, `name`, `email`, `password`, `status`, `angkatan`) VALUES
('123456', 'dummy@gmail.com', 'dummy@gmail.com', '$2y$12$TpgZTt/iAzq9lILvKv/bxu1ZFgfBoGISrTJJB24XDj5IWyd6PXEL.', 'Tugas Akhir', '2019'),
('123er', 'wati', 'wati@gmail.com', '$2y$12$bMHgRgkWyXGezYeFwOC88O5jWFkD90BCGWxlIBfQ4/sE.hz2.UWG6', 'Tugas Akhir', ''),
('123rt', 'dida', 'didi@gmail.com', '$2y$12$.iINVaggW.LFRg8EoGeyHu0NsnzWyzxk0NrlM1qt6paM4ehzmVCAm', 'Magang', ''),
('19340012', 'Hanna Pratiwi', 'hanna@gmail.com', '$2y$12$yU.DFx.cmlNRQhlR6sJo2..RHh6g7GSKnl94ySazhV5xDL.NvkhLe', 'Tugas Akhir', ''),
('19340019', 'Audi Nathanael G', 'audi@gmail.com', '$2y$12$K8cfyh8.FV75PbhbkRVybeRDk6qTAb8NCHBZKDwuNjs2YPqgRAPju', 'Tugas Akhir', '2019'),
('203400010', 'Alvinus Yodi', 'yodi@gmail.com', '$2y$12$yYVzQqi2j7dSAWXUcXXrkOTWw9HF7uP1Dnw9VduwHYtJfHSJg1kbS', 'Tugas Akhir', '2020'),
('203400012', 'Yulius Dani Eko Saputro', 'dani@gmail.com', '$2y$12$pejeZruHcwOOdfnuJ6KkP.SD/4c6LBA5HAWYhYCxepduEE/pNHFMG', 'Tugas Akhir', '2020'),
('203400013', 'Hendra', 'hendra@gmail.com', '$2y$12$qiRYC.QSpZgy2cBGm9diE.CZua1a9R5rDjGfGwX1Jr6pDz18PFSGW', 'Tugas Akhir', '2020'),
('203400023', 'Fianindra Riezca Agusty', 'fian@gmail.com', '$2y$12$9HTKSEmgZs2vCUB3aiOoe.U.bjgyBuDIEfQGByqYJhz/.xbU7v9uO', 'Tugas Akhir', '2020'),
('20340014', 'Yohana Christela Oktavani', 'yohana@gmail.com', '$2y$12$1HxRpidqcalo9mTb0mi8O.LOdSYVf5.uo5osJrUt0yTEbmPKU32zq', 'Tugas Akhir', '2020'),
('20340017', 'wildwina', 'wildwina@gmail.com', '$2y$12$1fKCVyfo9gVN/SRLvrtrxOmwRrDdREkQ5x86Y.YlxwSgxE/pHQsKG', 'Tugas Akhir', '2020'),
('20340018', 'Angelicha Yuspitasari Suwingnyo', 'angel@gmail.com', '$2y$12$hU0jwJnl13tRq98WltttCuzFQ26nv2gYatwhRULzDQk37DEtHlRn.', 'Tugas Akhir', '2020'),
('20340019', 'Elisabeth Yolanda Christin', 'yolanda@gmail.com', '$2y$12$q98TdSTE7kBf15hHIOp5Iu/i/oGS5nAATV0bzMhOP1bMfd1l5mfMS', 'Tugas Akhir', '2020'),
('23124151', 'dewi', 'dewi@gmail.com', '$2y$12$pWgBOULqtNDKoplks4x.seWRMgYTTy5P7X.W9tLm/ghosstjiYUkK', 'Tugas Akhir', ''),
('23400005', 'Alvin Widyadhana Kosman', 'alvin@gmail.com', '$2y$12$eEubwT3gYqgKzMF3WZwKTOCmWH5eP9TcOas8WPbCqC1FB7wq2vS8y', 'Tugas Akhir', '2020'),
('dummy123', 'dummy1', 'dummy1@gmail.com', '$2y$12$VXqTtqs0njy.Y52rN0fXH.IPogOISDO563oIQwlYJ8/tEUSLMVMXu', 'Tugas Akhir', '2019');

-- --------------------------------------------------------

--
-- Table structure for table `mingguan`
--

CREATE TABLE `mingguan` (
  `id` varchar(50) NOT NULL,
  `npm` varchar(50) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `is_all_day` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `descrpttion` varchar(50) NOT NULL,
  `event_id` varchar(50) NOT NULL,
  `created_at` varchar(50) NOT NULL,
  `updated_at` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `syarat`
--

CREATE TABLE `syarat` (
  `id_syarat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `npm` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateupload` date NOT NULL,
  `dateac` date DEFAULT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `syarat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `syarat`
--

INSERT INTO `syarat` (`id_syarat`, `npm`, `file`, `dateupload`, `dateac`, `status`, `syarat`) VALUES
('SY001', '19340019', 'kpk.pdf', '2024-08-21', '2024-08-20', 'disetujui', 'kpk'),
('SY002', '19340019', 'SKS.pdf', '2024-08-21', '2024-08-26', 'disetujui', 'sks'),
('SY003', '19340019', 'inhouse.pdf', '2024-08-21', NULL, 'disetujui', 'inhouse'),
('SY004', '19340019', 'WM.pdf', '2024-08-21', NULL, 'disetujui', 'wm'),
('SY006', '19340019', 'LKMMTM.pdf', '2024-08-24', NULL, 'submit', 'lkmmtm'),
('SY007', '19340019', 'lkmmtd.pdf', '2024-08-24', NULL, 'disetujui', 'lkmmtd'),
('SY008', '19340019', 'outbond.pdf', '2024-08-24', NULL, 'submit', 'outbond'),
('SY009', '19340019', 'NILAI.pdf', '2024-08-24', NULL, 'submit', 'nilai'),
('SY010', '19340019', 'SPP.pdf', '2024-08-24', NULL, 'submit', 'spp'),
('SY011', '19340019', 'toefl.pdf', '2024-08-24', NULL, 'submit', 'toefl'),
('SY012', '19340019', 'sumsks.pdf', '2024-08-26', NULL, 'submit', 'sumsks');

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
-- Indexes for table `syarat`
--
ALTER TABLE `syarat`
  ADD PRIMARY KEY (`id_syarat`),
  ADD KEY `npm` (`npm`);

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

--
-- Constraints for table `syarat`
--
ALTER TABLE `syarat`
  ADD CONSTRAINT `syarat_ibfk_1` FOREIGN KEY (`npm`) REFERENCES `mahasiswa` (`npm`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
