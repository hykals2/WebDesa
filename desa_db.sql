-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2025 at 05:52 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `desa_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE `galeri` (
  `id` int(11) NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `tanggal_upload` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `info_desa`
--

CREATE TABLE `info_desa` (
  `id` int(11) NOT NULL DEFAULT 1,
  `jumlah_penduduk` varchar(50) NOT NULL,
  `jumlah_kk` varchar(50) NOT NULL,
  `luas_wilayah` varchar(50) NOT NULL,
  `hari_jadi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `info_desa`
--

INSERT INTO `info_desa` (`id`, `jumlah_penduduk`, `jumlah_kk`, `luas_wilayah`, `hari_jadi`) VALUES
(1, '-', '-', '-', '-');

-- --------------------------------------------------------

--
-- Table structure for table `profil_desa`
--

CREATE TABLE `profil_desa` (
  `id` int(11) NOT NULL DEFAULT 1,
  `deskripsi` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `telepon` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sejarah` text DEFAULT NULL,
  `visi` text DEFAULT NULL,
  `misi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profil_desa`
--

INSERT INTO `profil_desa` (`id`, `deskripsi`, `foto`, `lokasi`, `telepon`, `email`, `sejarah`, `visi`, `misi`) VALUES
(1, 'Desa Kliwonan adalah sebuah desa yang terletak di Kecamatan Kalibawang, Kabupaten Kulonprogo. Desa ini memiliki potensi besar di bidang pertanian dan pariwisata.', 'd.jpg', 'Jl. Raya Desa Kliwonan No. 1, Kec. Kalibawang', '(0274) 123456', 'desa@kliwonan.desa.id', 'tes', 'tes', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `struktur_desa`
--

CREATE TABLE `struktur_desa` (
  `id` int(11) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `struktur_desa`
--

INSERT INTO `struktur_desa` (`id`, `jabatan`, `nama`, `foto`) VALUES
(1, 'Kepala Desa', 'Supardal', 'd.jpg'),
(2, 'RT 09', 'damsdka', 'Final Menu Spesial Poster Makanan.jpg'),
(3, 'RT 10', 'Ahmad Zulkifli', 'default.png'),
(4, 'RT 11', 'Dewi Lestari', 'default.png'),
(10, 'RT 12', 'tes', 'default.png'),
(11, 'RW 05', 'TES', 'default.png'),
(12, 'RW 06', 'DS', 'default.png'),
(13, 'kETUA TANI', 'DS', 'default.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama_lengkap`) VALUES
(1, 'admin', '$2y$10$z86kBpzz/CzeI4PbcuzZ1eAdP3F2JeksJAEW3YdWXHdfgUaI0WtRW', 'Admin Utama'),
(4, 'adminKKN', '$2y$10$L9tqJVoIoYF28dd0X6Ug9.T5ioD0IX6gSFXJYcMO62AAdR9T5.ucK', 'Admin KKN UAD');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `info_desa`
--
ALTER TABLE `info_desa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profil_desa`
--
ALTER TABLE `profil_desa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `struktur_desa`
--
ALTER TABLE `struktur_desa`
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
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `struktur_desa`
--
ALTER TABLE `struktur_desa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
