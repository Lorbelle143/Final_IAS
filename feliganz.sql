-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2025 at 03:01 PM
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
-- Database: `feliganz`
--

-- --------------------------------------------------------

--
-- Table structure for table `incidents`
--

CREATE TABLE `incidents` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `username` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `incidents`
--

INSERT INTO `incidents` (`id`, `user_id`, `fullname`, `email`, `phone`, `username`, `title`, `description`, `location`, `created_at`) VALUES
(4, 46, 'gg', 'lorbelleganzan@gmail.com', '09368012296', '', 'medium', 'car accident', NULL, '2025-05-28 12:40:01');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `otp` varchar(6) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `created_at`, `otp`, `otp_expiry`) VALUES
(35, 'gwapo', 'jamesivanfelicitas@gmail.com', '$2y$10$z1kEp88QluMpJ3VtJ98VkOroWFrb5ynz0wa7/ZOoHiU5uW7TH6s8y', '2025-05-28 11:03:10', '538951', '2025-05-28 19:13:10'),
(36, 'gwapo', 'lorbelleganzan@gmail.com', '$2y$10$EhHD8b65DVJbj.btJWaQoOjhwcZ5auOmYSJWCtYKTkdUljDH4/BWK', '2025-05-28 11:05:12', NULL, NULL),
(37, 'gwapo', 'jamesivanfelicitas@gmail.com', '$2y$10$5JWmJu/n3gv9E.qNdewoeeZPyDtY/HggIgUVoZipyG0H1O/2OuQ/i', '2025-05-28 11:17:33', '351724', '2025-05-28 19:27:33'),
(38, 'gwapo', 'jamesivanfelicitas@gmail.com', '$2y$10$ncjzuTRlvFkMm6Etdrn1wuKn1.DhGdmOeBgFbhw2bkx2yWDWYSfJm', '2025-05-28 11:18:00', '733631', '2025-05-28 19:28:00'),
(39, 'gwapo', 'jamesivanfelicitas@gmail.com', '$2y$10$PLn3h.FRX4ko1Q1wMdI4.u5OQpbHzkd6N4t4lI/znrfy9c9aSdcke', '2025-05-28 11:31:41', '688069', '2025-05-28 19:41:41'),
(40, 'gwapo', 'jamesivanfelicitas@gmail.com', '$2y$10$qOrSQ3tUNJ1BWHDHCGf.GO5GKDlivgbBy8NaWWm/G6tZn0tlrKwYS', '2025-05-28 11:34:27', '886387', '2025-05-28 19:44:27'),
(41, 'gwapo', 'jamesivanfelicitas@gmail.com', '$2y$10$6JCO1m55ajBoBec7trWTa.JxiplJ0bUTqFOLS1NGFWjcSAYTXPq8q', '2025-05-28 11:37:56', '959034', '2025-05-28 19:47:56'),
(42, 'gwapo', 'jamesivanfelicitas@gmail.com', '$2y$10$K7b3SZZDO8VVLFsAbUvRKurqiP7zbA3yqss2DdbDEQX0SE3ra9KFS', '2025-05-28 11:40:27', '367127', '2025-05-28 19:50:27'),
(43, 'gwapo', 'lorbelleganzan@gmail.com', '$2y$10$Fdtz0E4TJmGJwTiMMAXMeems6HilRlD0geXDpcNTiNshwNobbQ8Em', '2025-05-28 11:42:03', NULL, NULL),
(44, 'gwapo', 'lorbelleganzan@gmail.com', '$2y$10$IWk5xvfPfMW3iIFyk9KApuOiB1YIkGt9eNV.gp1WGaB8NeRi1MkMq', '2025-05-28 11:47:30', NULL, NULL),
(45, 'ganzan', 'lorbelleganzan@gmail.com', '$2y$10$ZIFIL.V5oT1esXk0uJP/Z.iOaSatR4VIVZTGn49jnE46v4l9Bo.OO', '2025-05-28 11:50:59', NULL, NULL),
(46, 'raito', 'lorbelleganzan@gmail.com', '$2y$10$ll.fkWury4ny2oSg/DgRVO1J7vOHo11uhL2odbtpf0fJH.NEtMOVK', '2025-05-28 11:57:35', NULL, NULL),
(47, 'admin', 'lorbelleganzan@gmail.com', '$2y$10$uQhk919DzGsUys3AnSbbvOTRHyeCLDfFyDi03wwa3k9EPD2QpzvUq', '2025-05-28 12:00:17', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `incidents`
--
ALTER TABLE `incidents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_incident` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `incidents`
--
ALTER TABLE `incidents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `incidents`
--
ALTER TABLE `incidents`
  ADD CONSTRAINT `fk_user_incident` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
