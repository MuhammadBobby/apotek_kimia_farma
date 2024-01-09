-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2023 at 02:50 PM
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
-- Database: `apotek`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_pembelian`
--

CREATE TABLE `detail_pembelian` (
  `id_detail_pembelian` int(11) NOT NULL,
  `no_faktur` varchar(20) DEFAULT NULL,
  `id_obat` int(11) DEFAULT 0,
  `jumlah` int(11) DEFAULT 0,
  `harga` int(20) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_pembelian`
--

INSERT INTO `detail_pembelian` (`id_detail_pembelian`, `no_faktur`, `id_obat`, `jumlah`, `harga`) VALUES
(1, 'FAK001', 1, 100, 500000),
(2, 'FAK001', 8, 20, 600000);

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `id_detail_penjualan` int(11) NOT NULL,
  `id_penjualan` char(10) DEFAULT NULL,
  `id_obat` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`id_detail_penjualan`, `id_penjualan`, `id_obat`, `jumlah`, `harga`) VALUES
(1, '3011230001', 1, 2, 10000),
(2, '3011230001', 2, 55, 275000);

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` char(10) NOT NULL DEFAULT '',
  `nama_karyawan` varchar(255) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `status` enum('owner','karyawan','admin') DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `kode_unik` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `nama_karyawan`, `alamat`, `status`, `no_telepon`, `kode_unik`) VALUES
('ADM101', 'Muhammad Bobby', 'Medan', 'admin', '082277446352', '$2y$10$Hj6XrfDnWbhtqDpPAxA45eJKqVXe69H8Nwmw9Elf0DH2xsi/Xl7kW'),
('KRY001', 'Sintya Feronika', 'Tebing Tinggi', 'karyawan', '087656765433', '$2y$10$KZmSplYJfYfSHKi9VvcDcO1FeTMq/HCRUIVJNRFUCc.mdT6s9umtm'),
('KRY002', 'Rent Dasimon', 'Kisaran Timur, Asahan', 'karyawan', '085698783456', '$2y$10$ziXDUUE94jSiWQFjO.VL1.IYzebKfM.ZRiclrPwQlJwCQbaWB6xoK'),
('KRY003', 'Fina Dasim', 'Jl. Merak No. 12B', 'karyawan', '+628292383297', '$2y$10$Xok863AgF1B9ejGvRFyIIeAJb4RJOpPmArgK/Iw49aBYQDe3JxYSe'),
('OWN001', 'Farma', 'Medan', 'owner', '087656765433', '$2y$10$OFnuQ4gKd4KakSXaVzaY/ekHhQo4g7hbfNrHxwS/00ffcmkfmRxi6');

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id_obat` int(11) NOT NULL,
  `nama_obat` varchar(255) DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `id_supplier` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id_obat`, `nama_obat`, `jenis`, `harga`, `stok`, `id_supplier`) VALUES
(1, 'Paracetamol', 'tablet', 5000, 100, 'SUP0001'),
(2, 'Amoxilin', 'tablet', 5000, 48, 'SUP0001'),
(3, 'Tramadol', 'Kapsul', 6000, 75, 'SUP0002'),
(4, 'Oralit', 'lain', 3500, 40, 'SUP0005'),
(5, 'Morfina', 'cair', 15000, 100, 'SUP0004'),
(6, 'Ersylan', 'cair', 18000, 50, 'SUP0004'),
(7, 'OBH', 'cair', 12000, 50, 'SUP0002'),
(8, 'Cytrol Chindo', 'tetes', 30000, 40, 'SUP0001'),
(9, 'Suntik', 'alat', 20000, 100, 'SUP0003'),
(10, 'Minyak Kayu Putih (Sedang)', 'cair', 13000, 50, 'SUP0001');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` char(10) NOT NULL DEFAULT 'APT',
  `nama_pelanggan` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `jenis_kelamin` enum('lk','pr') DEFAULT NULL,
  `pekerjaan` varchar(50) DEFAULT NULL,
  `usia` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `alamat`, `jenis_kelamin`, `pekerjaan`, `usia`) VALUES
('APT0001', 'Jhon Doe', 'Jl. Pertahanan No. 23', 'lk', 'Wiraswasta', 35),
('APT0002', 'Jane Smith', 'Jl. Dinamika No. 01', 'pr', 'Ibu Rumah Tangga', 40),
('APT0003', 'Bob Jhonson', 'Jl. Beo No. 32', 'lk', 'Mahasiswa', 18),
('APT0004', 'David Rinda', 'Jl. Beo No. 90', 'lk', 'Pegawai', 27),
('APT0005', 'Auliya Ikhsana', 'Patumbak, Medan', 'pr', 'Mahasiswa', 19),
('APT0006', 'Muhammad Bobby', 'Rahuning 2, Asahan', 'lk', 'Mahasiswa', 20);

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `no_faktur` varchar(20) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `id_karyawan` char(10) DEFAULT NULL,
  `id_supplier` char(10) DEFAULT NULL,
  `total_bayar` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`no_faktur`, `tanggal`, `id_karyawan`, `id_supplier`, `total_bayar`) VALUES
('FAK001', '2023-11-30', 'ADM101', 'SUP0001', 1100000);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` char(10) NOT NULL DEFAULT '',
  `id_pelanggan` char(10) DEFAULT NULL,
  `id_karyawan` char(10) DEFAULT NULL,
  `total_bayar` int(11) DEFAULT NULL,
  `create_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `id_pelanggan`, `id_karyawan`, `total_bayar`, `create_at`) VALUES
('3011230001', 'APT0003', 'ADM101', 285000, '2023-11-30');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` char(10) NOT NULL DEFAULT '',
  `nama_supplier` varchar(100) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `no_telepon` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `alamat`, `no_telepon`) VALUES
('SUP0001', 'PT. Dunia Cakrawala Abadi', 'Jl. Gatot Subroto No. 23 Jakarta', '087656765433'),
('SUP0002', 'Kimia Medical', 'Jl. Kasuari , Medan', '083456762453'),
('SUP0003', 'PT. Isotekindo Interma', 'Jl. Kebayoran Lama no 309-C,  Jakarta Selatan', '+890124532'),
('SUP0004', 'PT. Bina Mitra Jaya Bersama', 'Ruko Gateway A36 Waru, Sidoarjo', '+7893214221'),
('SUP0005', 'PT. Multiverse Anugerah Chemindo', 'Jl. Hasyim Ashari No.118, Tangerang ', '+907627327');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD PRIMARY KEY (`id_detail_pembelian`) USING BTREE,
  ADD KEY `obatbeli` (`id_obat`);

--
-- Indexes for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`id_detail_penjualan`),
  ADD KEY `obat jual` (`id_obat`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id_obat`),
  ADD KEY `sup` (`id_supplier`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`) USING BTREE;

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`no_faktur`),
  ADD KEY `FK_pembelian_karyawan` (`id_karyawan`),
  ADD KEY `suplierbeli` (`id_supplier`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `karyawan1` (`id_karyawan`),
  ADD KEY `pelanggan` (`id_pelanggan`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  MODIFY `id_detail_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  MODIFY `id_detail_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id_obat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD CONSTRAINT `obatbeli` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id_obat`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD CONSTRAINT `obat jual` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id_obat`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `obat`
--
ALTER TABLE `obat`
  ADD CONSTRAINT `sup` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `FK_pembelian_karyawan` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `suplierbeli` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `karyawan1` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
