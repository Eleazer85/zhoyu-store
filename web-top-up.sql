-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 17, 2025 at 01:34 AM
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
  `Password` varchar(5000) NOT NULL,
  `session_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`Username`, `Password`, `session_token`) VALUES
('Eleazer', '$2y$10$XrGwLlcJnMcIZJWcJ3nWGOAZpm01.fobUKmISHf1.grYdFP0EzuK2', '$2y$10$cirPx9np3KjuLLBtTilBwu3nfnoDtepLPpwLBPuKHm6CBow5T2wTW');

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
('Images/background-image/pubg-thumbnail.jpg', 'pubg-mobile'),
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
  `id_type` varchar(50) NOT NULL,
  `server_type` enum('none','input','dropdown') NOT NULL DEFAULT 'none',
  `server_options` text DEFAULT NULL,
  `Likes` int(255) NOT NULL DEFAULT 0,
  `Game_terkait` varchar(255) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='List of all games available';

--
-- Dumping data for table `Games`
--

INSERT INTO `Games` (`ID`, `Nama-game`, `Description`, `Gambar-game`, `id_type`, `server_type`, `server_options`, `Likes`, `Game_terkait`, `date_added`) VALUES
('010-00001', 'Point Blank', 'Langkah-langkah Point Blank Cash :<br>\r\n1. Pilih jumlah Cash yang diinginkan<br>\r\n2. Pilih metode pembayaran yang diinginkan<br>\r\n3. Pemesanan akan dilempar ke wa admin<br>\r\n4.  By chat wa isikan Data Account<br>\r\n5. Tunggu admin membalas<br>\r\n6. Lalu pembayaran<br>\r\n7. Silahkan menunggu, UC akan diisikan oleh admin ke akun Anda<br>\r\n<br>\r\nNote :<br>\r\n', 'Images/PointBlank.jpg', 'Player ID', 'none', NULL, 0, 'point-blank', '2025-03-16 12:44:32'),
('100-00001', 'Mobile Legends', 'Langkah-Langkah pemesanan Diamond Mobile Legends :<br>\n	1. Pilih nominal diamond yang ingin dipesan<br>\n	2. Pilih metode pembayaran lalu klik pesan sekarang<br>\n	3. Pemesanan akan dilempar ke wa admin<br>\n	4. by chat wa isikan ID dan Server User<br>\n	5. Tunggu admin membalas<br>\n            6. Lalu pembayaran<br>\n            7.  Silahkan menunggu, Diamond akan diisikan oleh admin ke akun Anda<br>\n<br>\nNote:<br>\n ID dan Server dipisah<br>\n', 'Images/Mobile-legend.jpeg', 'User ID', 'input', NULL, 0, 'mobile-legends', '2025-03-16 12:50:12'),
('100-00002', 'PUBG Mobile', 'Langkah-langkah mengisi UC PUBG Mobile :<br>\n1. Pilih jumlah UC yang diinginkan<br>\n2. Pilih metode pembayaran yang diinginkan<br>\n3. Pemesanan akan dilempar ke wa admin<br>\n4.  By chat wa isikan ID dan Nickname<br>\n5. Tunggu admin membalas<br>\n6. Lalu pembayaran<br>\n7. Silahkan menunggu, UC akan diisikan oleh admin ke akun Anda<br>\n<br>\nNote:<br>\nPerhatikan region akun Anda sebelum membeli.<br>\n', 'Images/PUBG.jpg', 'Character ID', 'none', NULL, 0, 'pubg-mobile', '2025-03-16 13:24:41'),
('100-00003', 'Valorant', 'Langkah-langkah VP Valorant :<br>\n1. Pilih jumlah VP yang diinginkan<br>\n2. Pilih metode pembayaran yang diinginkan<br>\n3. Pemesanan akan dilempar ke wa admin<br>\n4.  By chat wa isikan Riot ID<br>\n5. Tunggu admin membalas<br>\n6. Lalu pembayaran<br>\n7. Silahkan menunggu, VP akan diisikan oleh admin ke akun Anda<br>\n<br>\nCatatan :<br> \nHanya bisa diproses untuk akun ber-Region Indonesia.<br>\n', 'Images/Valorant.jpg', 'Riot ID', 'none', NULL, 0, 'valorant', '2025-03-16 12:51:36'),
('100-00004', 'Call of Duty Mobile', 'Langkah-langkah CP Call Of Duty Mobile :<br>\n1. Pilih jumlah CP yang diinginkan<br>\n2. Pilih metode pembayaran yang diinginkan<br>\n3. Pemesanan akan dilempar ke wa admin<br>\n4.  By chat wa isikan ID dan Nickname<br>\n5. Tunggu admin membalas<br>\n6. Lalu pembayaran<br>\n7. Silahkan menunggu, CP akan diisikan oleh admin ke akun Anda<br>\n<br>\nNote :<br> \nHanya bisa diproses untuk akun ber-Region Indonesia.<br>\n\n', 'Images/Cod-Mobile.png', 'UID', 'none', NULL, 0, 'call-of-duty-mobile', '2025-03-16 12:52:50'),
('100-00005', 'Free Fire', 'Langkah-langkah pemesanan Diamond Free Fire :<br>\n1. Pilih jumlah Diamond yang diinginkan<br>\n2. Pilih metode pembayaran yang diinginkan<br>\n3. Pemesanan akan dilempar ke wa admin<br>\n4. By chat wa isikan UID<br>\n5. Tunggu admin membalas<br>\n6. Lalu pembayaran<br>\n7. Silahkan menunggu, Diamond akan diisikan oleh admin ke akun Anda<br>\n<br>\nNote:<br>\nHanya bisa diproses untuk akun ber-Region Indonesia.<br>\n', 'Images/Free-Fire.png', 'Player ID', 'none', NULL, 0, 'free-fire', '2025-03-16 12:55:39'),
('100-00006', 'Arena Breakout', 'Langkah-langkah Bonds Arena Break Out :<br>\n1. Pilih jumlah Bonds yang diinginkan<br>\n2. Pilih metode pembayaran yang diinginkan<br>\n3. Pemesanan akan dilempar ke wa admin<br>\n4.  By chat wa isikan ID<br>\n5. Tunggu admin membalas<br>\n6. Lalu pembayaran<br>\n7. Silahkan menunggu, Bonds akan diisikan oleh admin ke akun Anda<br>\n<br>\nNote :<br> \nHanya bisa diproses untuk akun ber-Region Indonesia.<br>\n', 'Images/Arena-Breakout.png', 'Account ID', 'none', NULL, 0, 'arena-breakout', '2025-03-16 12:57:09'),
('111-00001', 'Genshin Impact', 'Langkah-langkah Crystals Genshin Impact :<br>\n1. Pilih jumlah Bonds yang diinginkan<br>\n2. Pilih metode pembayaran yang diinginkan<br>\n3. Pemesanan akan dilempar ke wa admin<br>\n4.  By chat wa isikan UID dan Server<br>\n5. Tunggu admin membalas<br>\n6. Lalu pembayaran<br>\n7. Silahkan menunggu, Crystals diisikan oleh admin ke akun Anda<br>\n<br>\nNote :<br> \nHanya bisa diproses untuk akun ber-Region Indonesia.<br>\n\n', 'Images/Genshin-Impact.jpg', 'UID', 'dropdown', 'America , Europe , Asia , TW - HK - MO', 0, 'genshin-impact', '2025-03-16 13:02:31'),
('111-00002', 'Roblox', 'Langkah-langkah Robux Roblox:<br>\n1. Pilih jumlah Robux yang diinginkan<br>\n2. Pilih metode pembayaran yang diinginkan<br>\n3. Pemesanan akan dilempar ke wa admin<br>\n4.  By chat wa isikan UID dan Server<br>\n5. Tunggu admin membalas<br>\n6. Lalu pembayaran<br>\n7. Silahkan menunggu, Robux diisikan oleh admin ke akun Anda<br>\n<br>\nNote :<br> \nHanya bisa diproses untuk akun ber-Region Indonesia.<br>\n', 'Images/roblox.png', 'Username/User ID', 'none', NULL, 0, 'roblox', '2025-03-16 13:34:06'),
('111-00003', 'Steam Wallet', 'Langkah-langkah Steam Wallet:<br>\n1. Pilih jumlah Steam Wallet yang diinginkan<br>\n2. Pilih metode pembayaran yang diinginkan<br>\n3. Pemesanan akan dilempar ke wa admin<br>\n4.  By chat war<br>\n5. Tunggu admin membalas<br>\n6. Lalu pembayaran<br>\n7. Silahkan menunggu, Steam Wallet di isikan oleh admin ke akun Anda<br>\n<br>\nNote :<br> \nHanya bisa diproses untuk akun ber-Region Indonesia.<br>\n\n', 'Images/Steamwallet.jpg', 'Steam ID64 / Email', 'none', NULL, 0, 'steam-wallet', '2025-03-16 13:34:53'),
('111-00004', 'Honkai Star Rail', 'Langkah-langkah OS Honkai Starrail:<br>\n1. Pilih jumlah OS yang diinginkan<br>\n2. Pilih metode pembayaran yang diinginkan<br>\n3. Pemesanan akan dilempar ke wa admin<br>\n4.  By chat wa isikan ID dan Server<br>\n5. Tunggu admin membalas<br>\n6. Lalu pembayaran<br>\n7. Silahkan menunggu, OS diisikan oleh admin ke akun Anda<br>\n<br>\nNote :<br> \nHanya bisa diproses untuk akun ber-Region Indonesia.<br>\n', 'Images/HonkaiStarRail.jpg', 'UID', 'dropdown', 'America , Europe , Asia , TW - HK - MO', 0, 'honkai-star-rail', '2025-03-16 13:12:53'),
('111-00005', 'Zenless Zone Zero (ZZZ)', 'Langkah-langkah Monochrome ZZZ :<br>\n1. Pilih jumlah Monochrome yang diinginkan<br>\n2. Pilih metode pembayaran yang diinginkan<br>\n3. Pemesanan akan dilempar ke wa admin<br>\n4.  By chat wa isikan ID dan Server<br>\n5. Tunggu admin membalas<br>\n6. Lalu pembayaran<br>\n7. Silahkan menunggu, Monochrome diisikan oleh admin ke akun Anda<br>\n<br>\nNote :<br> \nHanya bisa diproses untuk akun ber-Region Indonesia.<br>\n', 'Images/ZZZ.jpg', 'UID', 'dropdown', 'America , Europe , Asia , TW - HK - MO', 0, 'zenless-zone-zero', '2025-03-16 13:16:12');

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
(1100, 3, 'Diamonds', 'Images/Game-Money/2.png', 'Region-Indonesia', 'mobile-legends'),
(1600, 5, 'Diamonds', 'Images/Game-Money/2.png', 'Region-Indonesia', 'mobile-legends'),
(3550, 12, 'Diamonds', 'Images/Game-Money/2.png', 'Region-Indonesia', 'mobile-legends'),
(5700, 19, 'Diamonds', 'Images/Game-Money/2.png', 'Region-Indonesia', 'mobile-legends'),
(11900, 44, 'Diamonds', 'Images/Game-Money/2.png', 'Region-Indonesia', 'mobile-legends'),
(19500, 74, 'Diamonds', 'Images/Game-Money/2.png', 'Region-indonesia', 'mobile-legends'),
(23500, 88, 'Diamonds', 'Images/Game-Money/2.png', 'Region-Indonesia', 'mobile-legends'),
(30200, 113, 'Diamonds', 'Images/Game-Money/2.png', 'Region-Indonesia', 'mobile-legends'),
(31500, 116, 'Diamonds', 'Images/Game-Money/2.png', 'Region-Indonesia', 'mobile-legends'),
(1600, 10, 'Diamonds', 'Images/Game-Money/2.png', 'Region-Indonesia', 'free-fire'),
(3200, 20, 'Diamonds', 'Images/Game-Money/2.png', 'Region-Indonesia', 'free-fire'),
(4700, 30, 'Diamonds', 'Images/Game-Money/2.png', 'Region-Indonesia', 'free-fire'),
(7700, 60, 'Diamonds', 'Images/Game-Money/2.png', 'Region-Indonesia', 'free-fire'),
(9900, 80, 'Diamonds', 'Images/Game-Money/2.png', 'Region-Indonesia', 'free-fire'),
(16000, 130, 'Diamonds', 'Images/Game-Money/2.png', 'Region-Indonesia', 'free-fire'),
(6500, 30, 'UC', 'Images/Game-Money/uc.png', 'Region-Indonesia', 'pubg-mobile'),
(25800, 120, 'UC', 'Images/Game-Money/uc.png', 'Region-Indonesia', 'pubg-mobile'),
(51600, 240, 'UC', 'Images/Game-Money/uc.png', 'Region-Indonesia', 'pubg-mobile'),
(54500, 475, 'VP', 'Images/Game-Money/vp.png', 'Region-Indonesia', 'valorant'),
(215500, 2050, 'VP', 'Images/Game-Money/vp.png', 'Region-Indonesia', 'valorant'),
(381500, 3650, 'VP', 'Images/Game-Money/vp.png', 'Region-Indonesia', 'valorant'),
(4600, 31, 'CP', 'Images/Game-Money/cod.png', 'Region-Indonesia', 'call-of-duty-mobile'),
(44600, 321, 'CP', 'Images/Game-Money/cod.png', 'Region-Indonesia', 'call-of-duty-mobile'),
(178000, 1323, 'CP', 'Images/Game-Money/cod.png', 'Region-Indonesia', 'call-of-duty-mobile'),
(11800, 60, 'crystals', 'Images/Game-Money/genshin.png', 'Regional-Indonesia', 'genshin-impact'),
(178700, 1090, 'crystals', 'Images/Game-Money/genshin.png', 'Region-Indonesia', 'genshin-impact'),
(387500, 2240, 'crystal', 'Images/Game-Money/genshin.png', 'Region-Indonesia', 'genshin-impact');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` varchar(50) NOT NULL,
  `game` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `prices` varchar(100) NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `user_id/username` varchar(50) NOT NULL,
  `server` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `expires_at` datetime DEFAULT (current_timestamp() + interval 24 hour)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `game`, `amount`, `prices`, `payment_method`, `user_id/username`, `server`, `created_at`, `expires_at`) VALUES
('2b2bfbd736fdfa4ba09545d891e9ce05', 'genshin impact', '2240 crystal', 'Rp. 387500', 'BCA', '78943758934', ' TW - HK - MO', '2025-03-16 22:45:26', '2025-03-17 22:45:26'),
('598a984559c984efc110ea3242f7a7c5', 'genshin impact', '1090 crystals', 'Rp. 178700', 'QRIS', '3284792347589', ' Asia ', '2025-03-16 22:06:40', '2025-03-17 22:06:40'),
('699eac562f42a408694869bee87bae7b', 'mobile legends', '5 Diamonds', 'Rp. 1600', 'BCA', '312321321', '12893729183721', '2025-03-17 07:31:35', '2025-03-18 07:31:35'),
('e3da9f89b18681bb07e88cd17a4c6a00', 'genshin impact', '2240 crystal', 'Rp. 387500', 'QRIS', '218937721', 'America ', '2025-03-17 07:28:19', '2025-03-18 07:28:19');

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

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
