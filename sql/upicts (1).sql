-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 12, 2021 at 08:58 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `upicts`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id_category` int(50) NOT NULL,
  `name_category` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id_category`, `name_category`) VALUES
(1, 'pemandangan'),
(2, 'pantai'),
(3, 'gunung'),
(4, 'makanan');

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `id_image` int(50) NOT NULL,
  `id_user` int(25) DEFAULT NULL,
  `title` varchar(24) DEFAULT NULL,
  `download` int(50) DEFAULT NULL,
  `upload_data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id_image`, `id_user`, `title`, `download`, `upload_data`) VALUES
(34915788, 312114908, 'letmein', 1, '2021-08-11'),
(69968721, 312114908, 'JANCOK', 1, '2021-08-11');

-- --------------------------------------------------------

--
-- Table structure for table `image_category`
--

CREATE TABLE `image_category` (
  `id_image` int(50) DEFAULT NULL,
  `id_category` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `image_category`
--

INSERT INTO `image_category` (`id_image`, `id_category`) VALUES
(34915788, 4),
(69968721, 4);

-- --------------------------------------------------------

--
-- Table structure for table `like_image`
--

CREATE TABLE `like_image` (
  `id_user` int(25) DEFAULT NULL,
  `id_image` int(50) DEFAULT NULL,
  `like` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `like_image`
--

INSERT INTO `like_image` (`id_user`, `id_image`, `like`) VALUES
(312114908, 69968721, 1);

-- --------------------------------------------------------

--
-- Table structure for table `link_image`
--

CREATE TABLE `link_image` (
  `id_image` int(50) DEFAULT NULL,
  `temp_img` varbinary(50) NOT NULL,
  `raw_img` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `link_image`
--

INSERT INTO `link_image` (`id_image`, `temp_img`, `raw_img`) VALUES
(34915788, 0x696d672f74656d702f333439313537383874656d702e6a7067, 'img/raw/34915788raw.jpg'),
(69968721, 0x696d672f74656d702f363939363837323174656d702e706e67, 'img/raw/69968721raw.png');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id_profile` int(50) NOT NULL,
  `id_user` int(25) DEFAULT NULL,
  `fullname` varchar(24) DEFAULT NULL,
  `gender` char(2) DEFAULT NULL,
  `phone` varchar(14) DEFAULT NULL,
  `country` varchar(24) DEFAULT NULL,
  `imgprofile` varchar(30) DEFAULT NULL,
  `create_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id_profile`, `id_user`, `fullname`, `gender`, `phone`, `country`, `imgprofile`, `create_at`) VALUES
(11, 312114908, 'sidiq', NULL, NULL, NULL, 'img/profile/312114908.jpeg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(50) NOT NULL,
  `id_user` int(25) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('master','client') DEFAULT 'client'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `id_user`, `username`, `password`, `level`) VALUES
(17, 312114908, 'admin@gmail.com', '$2y$10$equawzjsRd02fSJGAS9xau.N3Y4fxzF.81pisdia095AAm39Tnj7C', 'master');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id_image`),
  ADD KEY `image_ibfk_1` (`id_user`);

--
-- Indexes for table `image_category`
--
ALTER TABLE `image_category`
  ADD KEY `image_category_ibfk_2` (`id_image`),
  ADD KEY `image_category_ibfk_3` (`id_category`);

--
-- Indexes for table `like_image`
--
ALTER TABLE `like_image`
  ADD KEY `like_image_ibfk_1` (`id_user`),
  ADD KEY `like_image_ibfk_2` (`id_image`);

--
-- Indexes for table `link_image`
--
ALTER TABLE `link_image`
  ADD KEY `link_image_ibfk_1` (`id_image`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id_profile`),
  ADD KEY `profile_ibfk_1` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`,`username`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id_profile` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `image_category`
--
ALTER TABLE `image_category`
  ADD CONSTRAINT `image_category_ibfk_2` FOREIGN KEY (`id_image`) REFERENCES `image` (`id_image`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `image_category_ibfk_3` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `like_image`
--
ALTER TABLE `like_image`
  ADD CONSTRAINT `like_image_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `like_image_ibfk_2` FOREIGN KEY (`id_image`) REFERENCES `image` (`id_image`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `link_image`
--
ALTER TABLE `link_image`
  ADD CONSTRAINT `link_image_ibfk_1` FOREIGN KEY (`id_image`) REFERENCES `image` (`id_image`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
