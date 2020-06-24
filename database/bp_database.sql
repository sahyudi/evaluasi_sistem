-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2020 at 06:52 AM
-- Server version: 5.6.26
-- PHP Version: 5.5.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bp_database`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `get_total`(proyek_id int) RETURNS int(11)
BEGIN
	#Routine body goes here...

	RETURN 0;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `group_name`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'User', '0000-00-00 00:00:00', '2017-05-24 09:40:23');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `title` varchar(45) NOT NULL,
  `link` varchar(150) NOT NULL,
  `icon` varchar(45) NOT NULL,
  `order_by` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `parent_id`, `title`, `link`, `icon`, `order_by`) VALUES
(1, 0, 'Dashboard', '#', 'fa-tachometer-alt', NULL),
(22, 1, 'Home', 'home', 'fa-circle', NULL),
(24, 0, 'HRMS', '#', 'fa-clipboard-list', NULL),
(25, 24, 'Employee', 'employee', 'fa-user', NULL),
(30, 0, 'Setting', '#', 'fa-cog', NULL),
(31, 30, 'Menu', 'setting/menu', 'fa-circle', NULL),
(34, 30, 'Users', 'setting/users', 'fa-circle', NULL),
(44, 30, 'User Groups', 'setting/group', 'fa-circle', NULL),
(52, 42, 'Edit Material', 'project/get_material_project', 'fa-circle', NULL),
(53, 24, 'Agama', 'employee/agama', 'fa-circle', NULL),
(54, 24, 'Gol Darah', 'employee/gol_darah', 'fa-circle', NULL),
(55, 24, 'Pendidikan', 'employee/pendidikan', 'fa-circle', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_agama`
--

CREATE TABLE IF NOT EXISTS `tb_agama` (
  `id` int(11) NOT NULL,
  `nama` varchar(225) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_agama`
--

INSERT INTO `tb_agama` (`id`, `nama`) VALUES
(2, 'Islam'),
(3, 'Protestan'),
(4, 'Katolik');

-- --------------------------------------------------------

--
-- Table structure for table `tb_employee`
--

CREATE TABLE IF NOT EXISTS `tb_employee` (
  `id` int(11) NOT NULL,
  `nama` varchar(225) NOT NULL,
  `agama` int(11) NOT NULL,
  `jenis_kel` varchar(25) NOT NULL,
  `tgl_lahir` varchar(16) NOT NULL,
  `alamat` text NOT NULL,
  `pendidikan` int(11) NOT NULL,
  `no_telp` int(11) NOT NULL,
  `no_ktp` int(11) NOT NULL,
  `gol_darah` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_employee`
--

INSERT INTO `tb_employee` (`id`, `nama`, `agama`, `jenis_kel`, `tgl_lahir`, `alamat`, `pendidikan`, `no_telp`, `no_ktp`, `gol_darah`) VALUES
(3, 'Muhamad Sahyudi', 2, 'Laki - laki', '1998-09-01', 'Tiban masyeba Permai tahap 1', 3, 98765432, 1234567899, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tb_gol_darah`
--

CREATE TABLE IF NOT EXISTS `tb_gol_darah` (
  `id` int(11) NOT NULL,
  `nama` varchar(25) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_gol_darah`
--

INSERT INTO `tb_gol_darah` (`id`, `nama`) VALUES
(2, 'A'),
(3, 'B'),
(4, 'O');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pendidikan`
--

CREATE TABLE IF NOT EXISTS `tb_pendidikan` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `singkatan` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_pendidikan`
--

INSERT INTO `tb_pendidikan` (`id`, `nama`, `singkatan`) VALUES
(2, 'Master', 'S2'),
(3, 'Sarjana', 'S1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `outlet_id` int(11) DEFAULT NULL,
  `name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(128) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `group_id`, `outlet_id`, `name`, `email`, `password`, `image`, `created_at`, `updated_at`, `is_active`) VALUES
(2, 1, 0, 'Admin', 'admin', '$2y$10$ekSgfgIEPOjEIdFbmPys0Oy9BJ8noJqrKMQSvKf5KTBe4K4rHBlQK', 'default.jpg', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_role`
--

CREATE TABLE IF NOT EXISTS `user_access_role` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=435 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_access_role`
--

INSERT INTO `user_access_role` (`id`, `group_id`, `menu_id`) VALUES
(426, 1, 24),
(427, 1, 25),
(428, 1, 53),
(429, 1, 54),
(430, 1, 55),
(431, 1, 30),
(432, 1, 31),
(433, 1, 34),
(434, 1, 44);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_agama`
--
ALTER TABLE `tb_agama`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_employee`
--
ALTER TABLE `tb_employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_gol_darah`
--
ALTER TABLE `tb_gol_darah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_pendidikan`
--
ALTER TABLE `tb_pendidikan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `user_access_role`
--
ALTER TABLE `user_access_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT for table `tb_agama`
--
ALTER TABLE `tb_agama`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tb_employee`
--
ALTER TABLE `tb_employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tb_gol_darah`
--
ALTER TABLE `tb_gol_darah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tb_pendidikan`
--
ALTER TABLE `tb_pendidikan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user_access_role`
--
ALTER TABLE `user_access_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=435;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_access_role`
--
ALTER TABLE `user_access_role`
  ADD CONSTRAINT `user_access_role_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_access_role_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
