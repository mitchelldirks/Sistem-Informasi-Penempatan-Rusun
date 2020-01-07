-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2020 at 08:19 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rusunawa`
--

-- --------------------------------------------------------

--
-- Table structure for table `penghuni`
--

CREATE TABLE `penghuni` (
  `id_penghuni` int(10) NOT NULL,
  `id_warga` varchar(20) NOT NULL,
  `id_unit` varchar(10) NOT NULL,
  `No_SP` varchar(20) NOT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penghuni`
--

INSERT INTO `penghuni` (`id_penghuni`, `id_warga`, `id_unit`, `No_SP`, `status`) VALUES
(1, '3275021603980017', 'A101', '16/-1/MtchllGntg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `Kode_unit` varchar(10) NOT NULL,
  `No_unit` varchar(10) NOT NULL,
  `Lantai` varchar(10) NOT NULL,
  `Blok` varchar(10) NOT NULL,
  `info` text NOT NULL,
  `harga` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`Kode_unit`, `No_unit`, `Lantai`, `Blok`, `info`, `harga`) VALUES
('A101', '1', '1', 'A', 'Pertama', 632000),
('A102', '2', '1', 'A', 'Sebelah yang pertama', 632000),
('A103', '3', '1', 'A', 'Sebelahnya sebelah yang pertama', 0),
('A201', '1', '2', 'A', 'Diatas yang pertama', 0),
('C303', '3', '3', 'C', 'Jauh dari yang pertama', 470000);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `level` varchar(10) NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `level`, `last_activity`) VALUES
('3275021603980017', '12345678', 'warga', '2020-01-07 01:35:52'),
('admin', 'admin', 'admin', '2020-01-07 01:39:56');

-- --------------------------------------------------------

--
-- Table structure for table `warga`
--

CREATE TABLE `warga` (
  `Nomor_KK` varchar(30) NOT NULL,
  `No_SP` varchar(30) NOT NULL,
  `Nama` varchar(50) NOT NULL,
  `TempatLahir` varchar(30) NOT NULL,
  `TTL` date NOT NULL,
  `JK` varchar(20) NOT NULL,
  `Agama` varchar(20) NOT NULL,
  `Telp` varchar(15) NOT NULL,
  `NIK` varchar(20) NOT NULL,
  `Nomor_REK` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `warga`
--

INSERT INTO `warga` (`Nomor_KK`, `No_SP`, `Nama`, `TempatLahir`, `TTL`, `JK`, `Agama`, `Telp`, `NIK`, `Nomor_REK`) VALUES
('3275021603980017', '16/-1/MtchllGntg', 'Mitchell Marcel', 'Bekasi', '1998-03-16', 'Pria', 'Islam', '0890780853', '3275021603980017', '0407091266');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `penghuni`
--
ALTER TABLE `penghuni`
  ADD PRIMARY KEY (`id_penghuni`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`Kode_unit`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `warga`
--
ALTER TABLE `warga`
  ADD PRIMARY KEY (`Nomor_KK`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `penghuni`
--
ALTER TABLE `penghuni`
  MODIFY `id_penghuni` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
