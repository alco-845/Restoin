-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 24, 2022 at 01:04 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_resto`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `id_resto` int(11) NOT NULL DEFAULT 0,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` enum('Admin','Master','') NOT NULL,
  `aktif` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `id_resto`, `username`, `email`, `password`, `level`, `aktif`) VALUES
(1, 0, 'master', 'master@gmail.com', 'master', 'Master', 1),
(3, 2, 'Restoku', 'restoku@gmail.com', 'restoku', 'Admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `id_detail` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `subtotal` decimal(11,0) NOT NULL,
  `status` enum('Proses','Selesai','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`id_detail`, `id_penjualan`, `id_menu`, `jumlah`, `subtotal`, `status`) VALUES
(1, 1, 3, 2, '4000', 'Selesai'),
(2, 1, 1, 1, '10000', 'Selesai');

-- --------------------------------------------------------

--
-- Stand-in structure for view `item_penjualan`
-- (See below for the actual view)
--
CREATE TABLE `item_penjualan` (
`id_detail` int(11)
,`id_penjualan` int(11)
,`id_menu` int(11)
,`jumlah` int(11)
,`subtotal` decimal(11,0)
,`status` enum('Proses','Selesai','')
,`id_resto` int(5)
,`kategori` varchar(100)
,`menu` varchar(100)
,`harga` decimal(10,0)
,`foto` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `laporan_penjualan`
-- (See below for the actual view)
--
CREATE TABLE `laporan_penjualan` (
`id_penjualan` int(11)
,`id_resto` int(5)
,`id_meja` int(11)
,`no_faktur` varchar(10)
,`pelanggan` varchar(100)
,`tanggal` date
,`total` decimal(11,0)
,`bayar` decimal(11,0)
,`kembali` decimal(11,0)
,`metode_pembayaran` varchar(100)
,`status` enum('Baru order','Sudah dibayar','Selesai','')
,`nama_pemilik` varchar(100)
,`nama` varchar(100)
,`logo` varchar(100)
,`alamat` text
,`qrcode` varchar(100)
,`nomer_meja` varchar(10)
,`status_meja` enum('Tersedia','Dipakai','')
);

-- --------------------------------------------------------

--
-- Table structure for table `meja`
--

CREATE TABLE `meja` (
  `id_meja` int(11) NOT NULL,
  `id_resto` int(5) NOT NULL,
  `nomer` varchar(10) NOT NULL,
  `status` enum('Tersedia','Dipakai','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `meja`
--

INSERT INTO `meja` (`id_meja`, `id_resto`, `nomer`, `status`) VALUES
(1, 2, 'Meja 1 ', 'Tersedia'),
(2, 2, 'Meja 2', 'Tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `id_resto` int(5) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `menu` varchar(100) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `id_resto`, `kategori`, `menu`, `harga`, `foto`) VALUES
(1, 2, 'Makanan', 'Kue mini', '10000', 'default.jpg'),
(3, 2, 'Minuman', 'Es teh', '2000', '2_2022-05-24_Screenshot_2021-03-04_07-55-47.png');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id_pegawai` int(11) NOT NULL,
  `id_resto` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `notelp` varchar(100) NOT NULL,
  `aktif` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id_pegawai`, `id_resto`, `username`, `password`, `nama`, `alamat`, `notelp`, `aktif`) VALUES
(1, 2, 'alex', 'alex', 'Alex', 'Alex rumah', '0852', 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `pemilik`
-- (See below for the actual view)
--
CREATE TABLE `pemilik` (
`id_admin` int(11)
,`id_resto` int(11)
,`username` varchar(100)
,`email` varchar(100)
,`password` varchar(100)
,`level` enum('Admin','Master','')
,`aktif` tinyint(1)
,`nama_pemilik` varchar(100)
,`nama` varchar(100)
,`logo` varchar(100)
,`alamat` text
,`qrcode` varchar(100)
);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `id_resto` int(5) NOT NULL,
  `id_meja` int(11) NOT NULL,
  `no_faktur` varchar(10) NOT NULL,
  `pelanggan` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `total` decimal(11,0) NOT NULL DEFAULT 0,
  `bayar` decimal(11,0) NOT NULL DEFAULT 0,
  `kembali` decimal(11,0) NOT NULL DEFAULT 0,
  `metode_pembayaran` varchar(100) NOT NULL,
  `status` enum('Baru order','Sudah dibayar','Selesai','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `id_resto`, `id_meja`, `no_faktur`, `pelanggan`, `tanggal`, `total`, `bayar`, `kembali`, `metode_pembayaran`, `status`) VALUES
(1, 2, 2, '00000001', 'Simon', '2022-05-24', '14000', '14000', '0', 'Bank Transfer', 'Selesai');

-- --------------------------------------------------------

--
-- Table structure for table `resto`
--

CREATE TABLE `resto` (
  `id_resto` int(5) NOT NULL,
  `nama_pemilik` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `qrcode` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resto`
--

INSERT INTO `resto` (`id_resto`, `nama_pemilik`, `nama`, `logo`, `alamat`, `qrcode`) VALUES
(0, 'master', 'master', 'master', 'master', 'master'),
(2, 'Restoku official', 'Restoku dirumah', 'default.jpg', 'Jalanin aja', 'resto_2.png');

-- --------------------------------------------------------

--
-- Structure for view `item_penjualan`
--
DROP TABLE IF EXISTS `item_penjualan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `item_penjualan`  AS SELECT `detail_penjualan`.`id_detail` AS `id_detail`, `detail_penjualan`.`id_penjualan` AS `id_penjualan`, `detail_penjualan`.`id_menu` AS `id_menu`, `detail_penjualan`.`jumlah` AS `jumlah`, `detail_penjualan`.`subtotal` AS `subtotal`, `detail_penjualan`.`status` AS `status`, `menu`.`id_resto` AS `id_resto`, `menu`.`kategori` AS `kategori`, `menu`.`menu` AS `menu`, `menu`.`harga` AS `harga`, `menu`.`foto` AS `foto` FROM (`detail_penjualan` join `menu` on(`detail_penjualan`.`id_menu` = `menu`.`id_menu`)) ;

-- --------------------------------------------------------

--
-- Structure for view `laporan_penjualan`
--
DROP TABLE IF EXISTS `laporan_penjualan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `laporan_penjualan`  AS SELECT `penjualan`.`id_penjualan` AS `id_penjualan`, `penjualan`.`id_resto` AS `id_resto`, `penjualan`.`id_meja` AS `id_meja`, `penjualan`.`no_faktur` AS `no_faktur`, `penjualan`.`pelanggan` AS `pelanggan`, `penjualan`.`tanggal` AS `tanggal`, `penjualan`.`total` AS `total`, `penjualan`.`bayar` AS `bayar`, `penjualan`.`kembali` AS `kembali`, `penjualan`.`metode_pembayaran` AS `metode_pembayaran`, `penjualan`.`status` AS `status`, `resto`.`nama_pemilik` AS `nama_pemilik`, `resto`.`nama` AS `nama`, `resto`.`logo` AS `logo`, `resto`.`alamat` AS `alamat`, `resto`.`qrcode` AS `qrcode`, `meja`.`nomer` AS `nomer_meja`, `meja`.`status` AS `status_meja` FROM ((`penjualan` join `resto` on(`penjualan`.`id_resto` = `resto`.`id_resto`)) join `meja` on(`penjualan`.`id_meja` = `meja`.`id_meja`)) ;

-- --------------------------------------------------------

--
-- Structure for view `pemilik`
--
DROP TABLE IF EXISTS `pemilik`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pemilik`  AS SELECT `admin`.`id_admin` AS `id_admin`, `admin`.`id_resto` AS `id_resto`, `admin`.`username` AS `username`, `admin`.`email` AS `email`, `admin`.`password` AS `password`, `admin`.`level` AS `level`, `admin`.`aktif` AS `aktif`, `resto`.`nama_pemilik` AS `nama_pemilik`, `resto`.`nama` AS `nama`, `resto`.`logo` AS `logo`, `resto`.`alamat` AS `alamat`, `resto`.`qrcode` AS `qrcode` FROM (`admin` join `resto` on(`admin`.`id_resto` = `resto`.`id_resto`)) WHERE `admin`.`level` = 'Admin' ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `id_resto` (`id_resto`);

--
-- Indexes for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_penjualan` (`id_penjualan`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indexes for table `meja`
--
ALTER TABLE `meja`
  ADD PRIMARY KEY (`id_meja`),
  ADD KEY `id_resto` (`id_resto`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `id_resto` (`id_resto`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`),
  ADD KEY `id_resto` (`id_resto`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `id_resto` (`id_resto`),
  ADD KEY `id_meja` (`id_meja`);

--
-- Indexes for table `resto`
--
ALTER TABLE `resto`
  ADD PRIMARY KEY (`id_resto`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `meja`
--
ALTER TABLE `meja`
  MODIFY `id_meja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id_pegawai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `resto`
--
ALTER TABLE `resto`
  MODIFY `id_resto` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`id_resto`) REFERENCES `resto` (`id_resto`);

--
-- Constraints for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD CONSTRAINT `detail_penjualan_ibfk_1` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id_penjualan`),
  ADD CONSTRAINT `detail_penjualan_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`);

--
-- Constraints for table `meja`
--
ALTER TABLE `meja`
  ADD CONSTRAINT `meja_ibfk_1` FOREIGN KEY (`id_resto`) REFERENCES `resto` (`id_resto`);

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_3` FOREIGN KEY (`id_resto`) REFERENCES `resto` (`id_resto`);

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`id_meja`) REFERENCES `meja` (`id_meja`),
  ADD CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`id_resto`) REFERENCES `resto` (`id_resto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
