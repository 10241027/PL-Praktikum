-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2025 at 08:59 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `minimarket`
--

-- --------------------------------------------------------

--
-- Table structure for table `jarak`
--

CREATE TABLE `jarak` (
  `id` int(11) NOT NULL,
  `jarak_km` decimal(5,2) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jarak`
--

INSERT INTO `jarak` (`id`, `jarak_km`, `deskripsi`) VALUES
(1, 1.50, 'Dekat pusat kota'),
(2, 3.20, 'Pinggir kota'),
(3, 4.00, 'Dekat bandara'),
(4, 5.00, 'Pinggiran Laut'),
(5, 8.00, 'Pegunungan'),
(6, 20.00, 'Tengah Hutan');

-- --------------------------------------------------------

--
-- Table structure for table `kontak`
--

CREATE TABLE `kontak` (
  `id` int(11) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kontak`
--

INSERT INTO `kontak` (`id`, `no_hp`, `email`) VALUES
(1, '081234567890', 'alfamart@gmail.com'),
(2, '081298765432', 'indomaret@gmail.com'),
(3, '087812992245', 'hypermart@gmail.com'),
(4, '081283990958', 'alfamidi@gmail.com'),
(5, '081082821919', 'diy@gmail.com'),
(6, '081502029999', 'ohsome@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id` int(11) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `kota` varchar(100) NOT NULL,
  `provinsi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id`, `alamat`, `kota`, `provinsi`) VALUES
(1, 'Jl. Merdeka No. 10', 'Bandung', 'Jawa Barat'),
(2, 'Jl. Sudirman No. 15', 'Jakarta', 'DKI Jakarta'),
(3, 'Jl. Karang Joang 1', 'Balikpapan', 'Kalimantan Timur'),
(4, 'Jl. Sudirman', 'Surabaya', 'Jawa Timur'),
(5, 'Jl. Pattimura', 'Ternate', 'Maluku Utara'),
(6, 'Jl. Sam Rat Tulangi', 'Manado', 'Sulawesi Utara'),
(7, 'Jl. Soekarno', 'Jakarta', 'DKI Jakarta');

-- --------------------------------------------------------

--
-- Table structure for table `minimarket`
--

CREATE TABLE `minimarket` (
  `id` int(11) NOT NULL,
  `nama_minimarket` varchar(100) NOT NULL,
  `id_lokasi` int(11) NOT NULL,
  `id_kontak` int(11) NOT NULL,
  `id_owner` int(11) NOT NULL,
  `id_jarak` int(11) NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `minimarket`
--

INSERT INTO `minimarket` (`id`, `nama_minimarket`, `id_lokasi`, `id_kontak`, `id_owner`, `id_jarak`, `deleted_at`) VALUES
(1, 'Alfamart', 1, 1, 1, 1, NULL),
(2, 'Indomaret', 2, 2, 2, 2, NULL),
(3, 'Alfamart', 3, 1, 3, 3, NULL),
(4, 'Indomaret', 3, 1, 1, 3, NULL),
(5, 'Alfamart', 3, 2, 2, 3, NULL),
(6, 'Indomaret', 3, 1, 3, 2, NULL),
(7, 'Alfamidi', 4, 5, 4, 4, NULL),
(8, 'Hypermart', 5, 6, 5, 5, NULL),
(9, 'DIY', 6, 4, 6, 6, NULL),
(10, 'OhSome', 6, 6, 1, 6, NULL),
(12, 'OhSome', 3, 1, 1, 4, '2025-10-26 02:16:51');

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `id` int(11) NOT NULL,
  `nama_owner` varchar(100) NOT NULL,
  `nik` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `owner`
--

INSERT INTO `owner` (`id`, `nama_owner`, `nik`) VALUES
(1, 'Fabyo', '10241027'),
(2, 'Devin', '10241021'),
(3, 'Hamzah', '10241035'),
(4, 'Farras', '10241045'),
(5, 'Toro', '10241071'),
(6, 'Linggar', '10241039');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jarak`
--
ALTER TABLE `jarak`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `minimarket`
--
ALTER TABLE `minimarket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_lokasi` (`id_lokasi`),
  ADD KEY `id_kontak` (`id_kontak`),
  ADD KEY `id_owner` (`id_owner`),
  ADD KEY `id_jarak` (`id_jarak`);

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jarak`
--
ALTER TABLE `jarak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `minimarket`
--
ALTER TABLE `minimarket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `owner`
--
ALTER TABLE `owner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `minimarket`
--
ALTER TABLE `minimarket`
  ADD CONSTRAINT `minimarket_ibfk_1` FOREIGN KEY (`id_lokasi`) REFERENCES `lokasi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `minimarket_ibfk_2` FOREIGN KEY (`id_kontak`) REFERENCES `kontak` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `minimarket_ibfk_3` FOREIGN KEY (`id_owner`) REFERENCES `owner` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `minimarket_ibfk_4` FOREIGN KEY (`id_jarak`) REFERENCES `jarak` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
