-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2026 at 03:20 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iot_access_log`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_logs`
--

CREATE TABLE `access_logs` (
  `id` int(11) NOT NULL,
  `uid_kartu` varchar(100) NOT NULL,
  `status_akses` varchar(20) NOT NULL,
  `waktu_akses` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `access_logs`
--

INSERT INTO `access_logs` (`id`, `uid_kartu`, `status_akses`, `waktu_akses`) VALUES
(1, '1d2f958617d593d105567da1b72ff18f66765167c7b3c70452a0d47f48a0b396', 'DITERIMA', '2026-06-16 12:39:38'),
(2, '65fd98520b4b58bfada35dd2a625a4c05cf1d88c3623a139bb53c43d8d4b28d2', 'DITOLAK (DIBLOKIR)', '2026-06-16 12:39:42'),
(3, '1d2f958617d593d105567da1b72ff18f66765167c7b3c70452a0d47f48a0b396', 'DITERIMA', '2026-06-16 12:39:47'),
(4, '65fd98520b4b58bfada35dd2a625a4c05cf1d88c3623a139bb53c43d8d4b28d2', 'DITOLAK (DIBLOKIR)', '2026-06-16 12:47:37'),
(5, '1d2f958617d593d105567da1b72ff18f66765167c7b3c70452a0d47f48a0b396', 'DITERIMA', '2026-06-16 12:47:46'),
(6, '1d2f958617d593d105567da1b72ff18f66765167c7b3c70452a0d47f48a0b396', 'DITERIMA', '2026-06-16 12:49:42'),
(7, '65fd98520b4b58bfada35dd2a625a4c05cf1d88c3623a139bb53c43d8d4b28d2', 'DITOLAK (DIBLOKIR)', '2026-06-16 12:49:46'),
(8, '1d2f958617d593d105567da1b72ff18f66765167c7b3c70452a0d47f48a0b396', 'DITERIMA', '2026-06-16 13:07:17'),
(9, '65fd98520b4b58bfada35dd2a625a4c05cf1d88c3623a139bb53c43d8d4b28d2', 'DITOLAK (DIBLOKIR)', '2026-06-16 13:07:21');

-- --------------------------------------------------------

--
-- Table structure for table `registered_cards`
--

CREATE TABLE `registered_cards` (
  `id` int(11) NOT NULL,
  `uid_kartu` varchar(100) NOT NULL,
  `nama_pengguna` varchar(100) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registered_cards`
--

INSERT INTO `registered_cards` (`id`, `uid_kartu`, `nama_pengguna`, `is_active`) VALUES
(1, '1d2f958617d593d105567da1b72ff18f66765167c7b3c70452a0d47f48a0b396', 'Salman', 1),
(2, '65fd98520b4b58bfada35dd2a625a4c05cf1d88c3623a139bb53c43d8d4b28d2', 'Anomaly', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_logs`
--
ALTER TABLE `access_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registered_cards`
--
ALTER TABLE `registered_cards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uid_kartu` (`uid_kartu`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_logs`
--
ALTER TABLE `access_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `registered_cards`
--
ALTER TABLE `registered_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
