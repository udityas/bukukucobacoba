-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2019 at 11:30 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `buku_agus_nurwanto`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `TambahBuku` (IN `val_id_kategori` INT, IN `val_judul` TEXT, IN `val_isbn` VARCHAR(30), IN `val_penerbit` VARCHAR(50), IN `val_penulis` VARCHAR(50))  BEGIN
	START TRANSACTION;
	insert into buku (id_kategori, judul, isbn, penerbit, penulis) values (val_id_kategori, val_judul, val_isbn, val_penerbit, val_penulis);
	COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `TambahKategori` (IN `val_kategori` VARCHAR(30))  BEGIN
	START TRANSACTION;
	insert into kategori (kategori) values (val_kategori);
	COMMIT;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `TotalBuku` (`id` INT) RETURNS INT(11) BEGIN
    DECLARE TOTAL int;
 
    SELECT count(*) INTO TOTAL FROM buku WHERE id_kategori = id;
 
RETURN (TOTAL);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `judul` text NOT NULL,
  `isbn` varchar(30) NOT NULL,
  `penerbit` varchar(50) NOT NULL,
  `penulis` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `id_kategori`, `judul`, `isbn`, `penerbit`, `penulis`) VALUES
(1, 1, 'Tuntunan Sholat 5 waktu sesuai sunnah nabi', '198276172312-df2', 'Airlangga', 'Agus Nurwanto HH. MSI'),
(2, 1, 'Tuntunan Wudhu Bersuci sesuai sunnah nabi', '19827617232-df2', 'Airlangga', 'Agus Nurwanto HH. MSI'),
(3, 2, 'Belajar PHP', '198276172312-df2', 'Airlangga', 'Agus Nurwanto HH. MSI'),
(4, 3, 'Terbentuknya kabupaten Magetan', '19827617232-df2', 'Airlangga', 'Agus Nurwanto HH. MSI'),
(6, 2, 'tes 123', '23942938 123', 'ali sadikin 123', 'agus n 123'),
(9, 3, 'tes', '23942938', 'airlangga', 'agus nur'),
(10, 1, 'tes', '23942938', 'airlangga', 'agus nur'),
(11, 2, 'tes 123', '23942938 123', 'airlangga 123', 'agus n 123'),
(12, 2, 'tes 123', '23942938 123', 'airlangga 123', 'agus n 123'),
(13, 2, 'tes 123', '23942938 123', 'airlangga 123', 'agus n 123');

--
-- Triggers `buku`
--
DELIMITER $$
CREATE TRIGGER `LogBukuDelete` BEFORE DELETE ON `buku` FOR EACH ROW BEGIN
	insert into log_buku (id_buku, aksi, tgl) values (OLD.id_buku, 'DELETE', now());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `LogBukuInsert` AFTER INSERT ON `buku` FOR EACH ROW BEGIN
	insert into log_buku (id_buku, aksi, tgl) values (NEW.id_buku, 'INSERT', now());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `LogBukuUpdate` BEFORE UPDATE ON `buku` FOR EACH ROW BEGIN
	insert into log_buku (id_buku, aksi, tgl) values (NEW.id_buku, 'UPDATE', now());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `daftar_buku_dan_kategori`
--
CREATE TABLE `daftar_buku_dan_kategori` (
`ID_BUKU` int(11)
,`JUDUL` text
,`KATEGORI` varchar(30)
,`ISBN` varchar(30)
,`PENERBIT` varchar(50)
,`PENULIS` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `daftar_buku_dan_kategori_all`
--
CREATE TABLE `daftar_buku_dan_kategori_all` (
`ID_KATEGORI` int(11)
,`ID_BUKU` int(11)
,`JUDUL` text
,`KATEGORI` varchar(30)
,`ISBN` varchar(30)
,`PENERBIT` varchar(50)
,`PENULIS` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `jumlah_buku_per_kategori`
--
CREATE TABLE `jumlah_buku_per_kategori` (
`ID_KATEGORI` int(11)
,`KATEGORI` varchar(30)
,`TOTAL_BUKU` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `kategori` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `kategori`) VALUES
(1, 'Agama'),
(2, 'Teknologi Informasi Komunikasi'),
(3, 'Sejarah');

-- --------------------------------------------------------

--
-- Table structure for table `log_buku`
--

CREATE TABLE `log_buku` (
  `id` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `aksi` varchar(30) NOT NULL,
  `tgl` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log_buku`
--

INSERT INTO `log_buku` (`id`, `id_buku`, `aksi`, `tgl`) VALUES
(2, 5, 'INSERT', '2019-08-29 10:28:39'),
(3, 5, 'UPDATE', '2019-08-29 10:33:12'),
(4, 5, 'DELETE', '2019-08-29 10:33:32'),
(5, 0, 'INSERT', '2019-08-29 11:14:36'),
(6, 0, 'INSERT', '2019-08-29 11:14:47'),
(7, 0, 'INSERT', '2019-08-29 11:17:30'),
(8, 8, 'DELETE', '2019-08-29 11:36:32'),
(9, 7, 'DELETE', '2019-08-29 11:37:03'),
(10, 6, 'UPDATE', '2019-08-29 15:55:12'),
(11, 0, 'INSERT', '2019-08-29 16:13:03'),
(12, 0, 'INSERT', '2019-08-29 16:13:31'),
(13, 0, 'INSERT', '2019-08-29 16:17:30'),
(14, 0, 'INSERT', '2019-08-29 16:20:20'),
(15, 13, 'INSERT', '2019-08-29 16:22:09');

-- --------------------------------------------------------

--
-- Structure for view `daftar_buku_dan_kategori`
--
DROP TABLE IF EXISTS `daftar_buku_dan_kategori`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `daftar_buku_dan_kategori`  AS  select `b`.`id_buku` AS `ID_BUKU`,`b`.`judul` AS `JUDUL`,`k`.`kategori` AS `KATEGORI`,`b`.`isbn` AS `ISBN`,`b`.`penerbit` AS `PENERBIT`,`b`.`penulis` AS `PENULIS` from (`buku` `b` left join `kategori` `k` on((`b`.`id_kategori` = `k`.`id_kategori`))) ;

-- --------------------------------------------------------

--
-- Structure for view `daftar_buku_dan_kategori_all`
--
DROP TABLE IF EXISTS `daftar_buku_dan_kategori_all`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `daftar_buku_dan_kategori_all`  AS  select `k`.`id_kategori` AS `ID_KATEGORI`,`b`.`id_buku` AS `ID_BUKU`,`b`.`judul` AS `JUDUL`,`k`.`kategori` AS `KATEGORI`,`b`.`isbn` AS `ISBN`,`b`.`penerbit` AS `PENERBIT`,`b`.`penulis` AS `PENULIS` from (`buku` `b` left join `kategori` `k` on((`b`.`id_kategori` = `k`.`id_kategori`))) ;

-- --------------------------------------------------------

--
-- Structure for view `jumlah_buku_per_kategori`
--
DROP TABLE IF EXISTS `jumlah_buku_per_kategori`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `jumlah_buku_per_kategori`  AS  select `k`.`id_kategori` AS `ID_KATEGORI`,`k`.`kategori` AS `KATEGORI`,`TotalBuku`(`k`.`id_kategori`) AS `TOTAL_BUKU` from (`kategori` `k` left join `buku` `b` on((`b`.`id_kategori` = `k`.`id_kategori`))) group by `k`.`id_kategori` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `log_buku`
--
ALTER TABLE `log_buku`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_buku` (`id_buku`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `log_buku`
--
ALTER TABLE `log_buku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
