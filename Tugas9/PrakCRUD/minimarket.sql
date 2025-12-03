-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2025 at 01:19 PM
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
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment_text` text NOT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `comment_text`, `status`, `created_at`, `approved_by`, `approved_at`) VALUES
(1, 3, 'Minimarket', 'approved', '2025-11-12 20:08:37', 1, '2025-11-12 20:08:55');

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
(6, 20.00, 'Tengah Hutan'),
(7, 6.00, 'Dalam Gang');

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
(8, 'Jl. Martadinata', 'Balikpapan', 'Kalimantan Timur');

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
(15, 'Alfamart', 2, 2, 2, 2, NULL),
(16, 'Indomaret', 3, 3, 3, 3, NULL),
(17, 'DIY', 4, 4, 4, 4, NULL),
(18, 'Alfamidi', 5, 5, 5, 5, NULL),
(19, 'Hypermart', 6, 6, 6, 6, NULL),
(20, 'OhSome', 3, 1, 1, 4, NULL),
(24, 'Greenmart', 3, 2, 3, 7, '2025-11-02 10:10:07'),
(25, 'Yovamart', 3, 1, 1, 4, '2025-11-11 19:41:53'),
(26, 'Giantmart', 1, 1, 1, 1, NULL);

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

-- --------------------------------------------------------

--
-- Table structure for table `pending_minimarkets`
--

CREATE TABLE `pending_minimarkets` (
  `id` int(11) NOT NULL,
  `minimarket_id` int(11) DEFAULT NULL,
  `action` varchar(20) NOT NULL,
  `payload` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `reviewed_by` int(11) DEFAULT NULL,
  `reviewed_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pending_minimarkets`
--

INSERT INTO `pending_minimarkets` (`id`, `minimarket_id`, `action`, `payload`, `created_by`, `status`, `reviewed_by`, `reviewed_at`, `created_at`) VALUES
(1, NULL, 'create', '{\"csrf_token\":\"75b22230ecc20b1a328cd81d9d2b26113315bb7f2d03eb8ef950c57e8f8f7721\",\"nama_minimarket\":\"Giantmart\",\"id_lokasi\":\"1\",\"id_kontak\":\"1\",\"id_owner\":\"1\",\"id_jarak\":\"1\"}', 2, 'approved', 1, '2025-11-12 20:07:53', '2025-11-12 20:07:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(200) DEFAULT '',
  `role` varchar(50) DEFAULT 'visitor',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$KjUxXbarx0Avqy2Isn.k9./D8bUfslDQoataW6VbzMEhMRTE/4hYW', 'Administrator', 'admin', '2025-11-11 19:32:03'),
(2, 'surveyor', '$2y$10$1ITIOw.vux3WfkgG3n5RbekQuDpFmHsWlsd3rXXBED21SXXPpMbbO', 'Surveyor', 'surveyor', '2025-11-11 19:32:03'),
(3, 'visitor', '$2y$10$6dvkSarnf7ldJFqcIxw8ke5uIbrBURr.EdLUNzvmp9rGWdDGvfFxK', 'Visitor', 'visitor', '2025-11-11 19:32:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `pending_minimarkets`
--
ALTER TABLE `pending_minimarkets`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jarak`
--
ALTER TABLE `jarak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `minimarket`
--
ALTER TABLE `minimarket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `owner`
--
ALTER TABLE `owner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pending_minimarkets`
--
ALTER TABLE `pending_minimarkets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
