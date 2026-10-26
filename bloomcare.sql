-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 26, 2026 at 01:30 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bloomcare`
--

-- --------------------------------------------------------

--
-- Table structure for table `bunga`
--

CREATE TABLE `bunga` (
  `id` int NOT NULL,
  `nama_bunga` varchar(100) NOT NULL,
  `jenis_bunga` varchar(100) NOT NULL,
  `warna` varchar(50) NOT NULL,
  `tanggal_tanam` date DEFAULT NULL,
  `lokasi` varchar(150) DEFAULT NULL,
  `kondisi` varchar(50) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `catatan` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bunga`
--

INSERT INTO `bunga` (`id`, `nama_bunga`, `jenis_bunga`, `warna`, `tanggal_tanam`, `lokasi`, `kondisi`, `foto`, `catatan`, `created_at`, `latitude`, `longitude`) VALUES
(1, 'Mawar', 'Rosa', 'Merah', '2026-09-01', 'Taman Depan', 'Baik', NULL, 'Disiram setiap pagi', '2026-09-28 02:05:53', NULL, NULL),
(2, 'Melati', 'Jasminum', 'Putih', '2026-09-05', 'Taman Samping', 'Baik', NULL, 'Membutuhkan cahaya matahari', '2026-09-28 02:05:53', NULL, NULL),
(3, 'Bunga Matahari', 'Helianthus', 'Kuning', '2026-09-10', 'Taman Belakang', 'Perlu Perawatan', NULL, 'Daun mulai menguning', '2026-09-28 02:05:53', NULL, NULL),
(4, 'Bougenville ', 'Nyctaginaceae', 'Ungu', '2026-10-05', 'Taman samping', 'Baik ', NULL, 'Siram pagi ', '2026-10-05 03:35:32', NULL, NULL),
(6, 'Lily', 'Liliaceae', 'Pink', '2026-10-06', 'Taman Depan', 'Perlu Perawatan ', NULL, 'Ada serangga perusak', '2026-10-06 00:58:19', NULL, NULL),
(8, 'Gerbera ', 'Asteraceae ', 'Merah, Kuning, Oranye, Biru', '2026-10-06', 'Taman Depan ', 'Baik', NULL, 'Disiram tiap Pagi', '2026-10-06 02:09:50', NULL, NULL),
(10, 'Sepatu', 'Hibiscus ', 'Merah', '2026-10-06', 'Taman Belakang ', 'Perlu Perawatan ', NULL, 'Daunnya berguguran ', '2026-10-06 03:02:54', NULL, NULL),
(11, 'Tulip', 'Liliaceae ', 'Pink', '2026-10-06', 'Taman Depan ', 'Baik', NULL, 'Disiram tiap Pagi ', '2026-10-06 03:15:58', '-7.69334', '110.70283'),
(16, 'Anggrek ', 'Orchidaceae ', 'Ungu', '2026-10-07', 'Taman Samping ', 'Baik', NULL, 'Disiram tiap Pagi ', '2026-10-07 03:07:38', '-7.69334', '110.70283'),
(17, 'Kamboja ', 'Apocynaceae', 'Kuning', '2026-10-12', 'Taman Belakang ', 'Baik', NULL, 'Disiram tiap Pagi ', '2026-10-12 03:33:03', '-7.73044', '110.72531'),
(19, 'Lavender ', 'Lamiaceae', 'Ungu', '2026-10-19', 'Taman Samping', 'Baik', NULL, 'butuh pupuk', '2026-10-19 03:04:17', '-7.69336', '110.70268');

-- --------------------------------------------------------

--
-- Table structure for table `perawatan`
--

CREATE TABLE `perawatan` (
  `id` int NOT NULL,
  `bunga_id` int NOT NULL,
  `jenis_perawatan` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `kondisi` varchar(100) NOT NULL,
  `catatan` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `perawatan`
--

INSERT INTO `perawatan` (`id`, `bunga_id`, `jenis_perawatan`, `tanggal`, `kondisi`, `catatan`, `created_at`) VALUES
(1, 1, 'Penyiraman', '2026-09-28', '', 'Disiram pada pagi hari', '2026-09-28 02:06:46'),
(2, 2, 'Pemupukan', '2026-09-27', '', 'Menggunakan pupuk organik', '2026-09-28 02:06:46'),
(3, 3, 'Penyiraman', '2026-09-28', '', 'Tambahkan volume air', '2026-09-28 02:06:46'),
(4, 1, 'Penyiraman ', '2026-10-06', 'Baik', 'Disiram Pagi', '2026-10-06 07:01:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `created_at`) VALUES
(1, 'admin', 'admin123', 'Administrator BloomCare', '2026-09-28 02:04:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bunga`
--
ALTER TABLE `bunga`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `perawatan`
--
ALTER TABLE `perawatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bunga_id` (`bunga_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bunga`
--
ALTER TABLE `bunga`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `perawatan`
--
ALTER TABLE `perawatan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `perawatan`
--
ALTER TABLE `perawatan`
  ADD CONSTRAINT `perawatan_ibfk_1` FOREIGN KEY (`bunga_id`) REFERENCES `bunga` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
