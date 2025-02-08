-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 08, 2025 at 08:54 AM
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
-- Database: `web-top-up`
--

-- --------------------------------------------------------

--
-- Table structure for table `Games`
--

CREATE TABLE `Games` (
  `ID` int(255) NOT NULL,
  `Nama-game` varchar(3000) NOT NULL,
  `Gambar-game` varchar(3000) NOT NULL,
  `Likes` int(255) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='List of all games available';

--
-- Dumping data for table `Games`
--

INSERT INTO `Games` (`ID`, `Nama-game`, `Gambar-game`, `Likes`) VALUES
(1, 'Mobile Legends', 'Images/Mobile-legend.jpeg', 0),
(2, 'Genshin Impact', 'Images/Genshin-Impact.jpg', 0),
(3, 'Roblox', 'Images/roblox.png', 0),
(4, 'Honkai STar Rail', 'Images/HonkaiStarRail.jpg', 0),
(5, 'Point Blank', 'Images/PointBlank.jpg', 0),
(6, 'PUBG', 'Images/PUBG.jpg', 0),
(7, 'Zenless Zone Zero (ZZZ)', 'Images/ZZZ.jpg', 0),
(8, 'Valorant', 'Images/Valorant.jpg', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Games`
--
ALTER TABLE `Games`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Games`
--
ALTER TABLE `Games`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
