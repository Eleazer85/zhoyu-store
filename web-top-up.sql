-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 11, 2025 at 07:51 AM
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
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `Username` varchar(5000) NOT NULL,
  `Password` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`Username`, `Password`) VALUES
('Eleazer', '$2y$10$XrGwLlcJnMcIZJWcJ3nWGOAZpm01.fobUKmISHf1.grYdFP0EzuK2');

-- --------------------------------------------------------

--
-- Table structure for table `Gambar-thumbnail`
--

CREATE TABLE `Gambar-thumbnail` (
  `Gambar` varchar(3000) NOT NULL,
  `Game_terkait` varchar(3000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Gambar-thumbnail`
--

INSERT INTO `Gambar-thumbnail` (`Gambar`, `Game_terkait`) VALUES
('Images/background-image/mobile-legend-thumbnail.png', 'mobile-legends'),
('Images/background-image/point-blank-thumbnail.jpeg', 'point-blank'),
('Images/background-image/pubg-thumbnail.jpg', 'pubg'),
('Images/background-image/valorant-thumbnail.png', 'valorant'),
('Images/background-image/codm-thumbnail.jpg', 'call-of-duty-mobile'),
('Images/background-image/free-fire-thumbnail.jpeg', 'free-fire'),
('Images/background-image/arena-breakout-thumbnail.webp', 'arena-breakout'),
('Images/background-image/genshin-impact-thumbnail.png', 'genshin-impact'),
('Images/background-image/roblox-thumbnail.jpg', 'roblox'),
('Images/background-image/steam-wallet-thumbnail.jpg', 'steam-wallet'),
('Images/background-image/honkai-star-rail-thumbnail.jpeg', 'honkai-star-rail'),
('Images/background-image/zenless-zone-zero-thumbnail.jpg', 'zenless-zone-zero');

-- --------------------------------------------------------

--
-- Table structure for table `Games`
--

CREATE TABLE `Games` (
  `ID` varchar(255) NOT NULL,
  `Nama-game` varchar(3000) NOT NULL,
  `Description` text DEFAULT NULL,
  `Gambar-game` varchar(3000) NOT NULL,
  `Likes` int(255) NOT NULL DEFAULT 0,
  `Game_terkait` varchar(255) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='List of all games available';

--
-- Dumping data for table `Games`
--

INSERT INTO `Games` (`ID`, `Nama-game`, `Description`, `Gambar-game`, `Likes`, `Game_terkait`, `date_added`) VALUES
('010-00001', 'Point Blank', 'testing', 'Images/PointBlank.jpg', 0, 'point-blank', '2025-03-04 07:31:58'),
('100-00001', 'Mobile Legends', 'Testing deskripsi', 'Images/Mobile-legend.jpeg', 0, 'mobile-legends', '2025-03-04 05:17:13'),
('100-00002', 'PUBG', NULL, 'Images/PUBG.jpg', 0, 'pubg', '2025-02-24 17:00:00'),
('100-00003', 'Valorant', NULL, 'Images/Valorant.jpg', 0, 'valorant', '2025-02-24 17:00:00'),
('100-00004', 'Call of Duty Mobile', NULL, 'Images/Cod-Mobile.png', 0, 'call-of-duty-mobile', '2025-02-24 17:00:00'),
('100-00005', 'Free Fire', NULL, 'Images/Free-Fire.png', 0, 'free-fire', '2025-02-24 17:00:00'),
('100-00006', 'Arena Breakout', NULL, 'Images/Arena-Breakout.png', 0, 'arena-breakout', '2025-02-24 17:00:00'),
('111-00001', 'Genshin Impact', NULL, 'Images/Genshin-Impact.jpg', 0, 'genshin-impact', '2025-02-24 17:00:00'),
('111-00002', 'Roblox', NULL, 'Images/roblox.png', 0, 'roblox', '2025-02-24 17:00:00'),
('111-00003', 'Steam Wallet', NULL, 'Images/Steamwallet.jpg', 0, 'steam-wallet', '2025-02-24 17:00:00'),
('111-00004', 'Honkai Star Rail', NULL, 'Images/HonkaiStarRail.jpg', 0, 'honkai-star-rail', '2025-02-24 17:00:00'),
('111-00005', 'Zenless Zone Zero (ZZZ)', NULL, 'Images/ZZZ.jpg', 0, 'zenless-zone-zero', '2025-02-24 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `Katalog`
--

CREATE TABLE `Katalog` (
  `Harga` int(255) NOT NULL,
  `Nominal` int(255) NOT NULL,
  `Curency` varchar(1000) NOT NULL,
  `Gambar` text NOT NULL,
  `Tipe` varchar(1000) NOT NULL,
  `Game_terkait` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Katalog`
--

INSERT INTO `Katalog` (`Harga`, `Nominal`, `Curency`, `Gambar`, `Tipe`, `Game_terkait`) VALUES
(1100, 3, 'Diamonds', 'Images/Game-money/2.png', 'Region-Indonesia', 'mobile-legends'),
(1600, 5, 'Diamonds', 'Images/Game-money/2.png', 'Region-Indonesia', 'mobile-legends');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD UNIQUE KEY `Username` (`Username`) USING HASH;

--
-- Indexes for table `Gambar-thumbnail`
--
ALTER TABLE `Gambar-thumbnail`
  ADD UNIQUE KEY `Game_terkait` (`Game_terkait`) USING HASH;

--
-- Indexes for table `Games`
--
ALTER TABLE `Games`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Game_terkait` (`Game_terkait`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
