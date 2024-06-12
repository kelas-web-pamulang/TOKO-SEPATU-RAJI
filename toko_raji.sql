-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2024 at 10:54 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_raji`
--

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama_pelanggan`, `alamat`, `telepon`) VALUES
(1, 'Rafi', 'Bekasi', '081385788100'),
(2, 'Aji', 'Jaksel', '083867129912');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `harga` int(20) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama_produk`, `kategori`, `harga`, `stok`) VALUES
(3, 'Nike Dunk Low Panda', 'Sepatu', 1700000, 10),
(4, 'Nike Air Force 1 \'07', 'Sepatu', 1500000, 10),
(5, 'Nike Air Force 1 Triple White', 'Sepatu', 1250000, 10),
(6, 'Nike Dunk High Panda', 'Sepatu', 1900000, 10),
(7, 'Nike Dunk High Noble Green', 'Sepatu', 1800000, 10),
(8, 'Nike Blazer Mid Pro Club', 'Sepatu', 1700000, 10),
(9, 'New Balance 550 White/Black', 'Sepatu', 1700000, 10),
(10, 'New Balance 550 White', 'Sepatu', 1100000, 10),
(11, 'New Balance 550 White/Green', 'Sepatu', 1800000, 10),
(12, 'New Balance 550 White/Green', 'Sepatu', 1800000, 10),
(13, 'New Balance 2002R Light Grey', 'Sepatu', 2500000, 10),
(14, 'New Balance 2002R Grey', 'Sepatu', 2200000, 10),
(15, 'New Balance 2002R Beige', 'Sepatu', 2400000, 10),
(16, 'ADIDAS CAMPUS 00S BLACK', 'Sepatu', 1800000, 10),
(17, 'ADIDAS CAMPUS 00S GREEN', 'Sepatu', 1700000, 10),
(18, 'ADIDAS CAMPUS 00S ID2070', 'Sepatu', 1700000, 10);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `total_harga` int(20) DEFAULT NULL,
  `tanggal_transaksi` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `id_pelanggan`, `id_produk`, `jumlah`, `total_harga`, `tanggal_transaksi`) VALUES
(1, 1, 3, 2, 3400000, '2024-06-12'),
(2, 1, 4, 3, 4500000, '2024-06-12'),
(3, 1, 5, 5, 6250000, '2024-06-12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES
(1, 'rafiakl', '$2y$10$Lufr4yhtcRHIWE0JyCYKN.0aN3rLYetKrlQZpgNs3cWqlnp3J9BSW', 'rafiakmal587@gmail.com'),
(2, 'aji', '$2y$10$wRKR9zvkYN4b/jbG.D7OsOMkE65LS3qwB8bKfPr3XxI.iKNzIrVda', 'ajijaksel@gmail.com'),
(5, 'adminrafi', '$2y$10$Wkk6qEZBarwSeVf1xF4Pq.NwrXti3ZfnjVYErs3g.VieNae6uFNky', 'ujangkasbon97@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
