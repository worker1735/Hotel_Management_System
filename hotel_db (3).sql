-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2026 at 08:00 PM
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
-- Database: `hotel_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin@gmail.com', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `method` varchar(50) DEFAULT NULL,
  `amount` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `method`, `amount`, `status`) VALUES
(1, 1, 'EasyPaisa', '', 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `roombook`
--

CREATE TABLE `roombook` (
  `id` int(11) NOT NULL,
  `Title` varchar(20) DEFAULT NULL,
  `FName` varchar(100) NOT NULL,
  `LName` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `National` varchar(50) DEFAULT NULL,
  `Country` varchar(100) NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `TRoom` varchar(50) NOT NULL,
  `room_price` decimal(10,2) DEFAULT 0.00,
  `Bed` varchar(50) NOT NULL,
  `NRoom` int(11) NOT NULL,
  `Meal` varchar(50) NOT NULL,
  `meal_price` decimal(10,2) DEFAULT 0.00,
  `cin` date NOT NULL,
  `cout` date NOT NULL,
  `stat` varchar(50) NOT NULL,
  `nodays` int(11) NOT NULL,
  `total_price` decimal(10,2) DEFAULT 0.00,
  `status` varchar(20) DEFAULT 'Pending',
  `room_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roombook`
--

INSERT INTO `roombook` (`id`, `Title`, `FName`, `LName`, `Email`, `National`, `Country`, `Phone`, `TRoom`, `room_price`, `Bed`, `NRoom`, `Meal`, `meal_price`, `cin`, `cout`, `stat`, `nodays`, `total_price`, `status`, `room_id`) VALUES
(9, '', 'ifra', 'ikl,k', 'shanzay@gmail.com', 'Foreigner', 'Pakistan', 'iokiuku', 'Standard', 0.00, 'Single Bed', 1, 'Room only', 0.00, '2222-02-22', '2222-02-22', 'Accepted', 0, 0.00, 'Pending', NULL),
(19, NULL, 'User', '', '', NULL, '', '', 'Double', 0.00, '', 1, '', 0.00, '0000-00-00', '0000-00-00', 'Accepted', 0, 0.00, 'Pending', NULL),
(20, NULL, 'User', '', '', NULL, '', '', 'Executive', 0.00, 'Single Bed', 1, '', 0.00, '0000-00-00', '0000-00-00', 'Accepted', 0, 0.00, 'Pending', NULL),
(21, NULL, 'User', '', '', NULL, '', '', 'Executive', 0.00, 'Single Bed', 1, '', 0.00, '0000-00-00', '0000-00-00', 'Accepted', 0, 0.00, 'Pending', NULL),
(22, NULL, 'User', '', '4', NULL, '', '', 'Executive', 0.00, 'Single Bed', 1, '', 0.00, '2026-05-10', '2026-05-11', 'Accepted', 0, 0.00, 'Pending', NULL),
(35, '', 'aaa', 'thujfgtj', 'ifra1@gmail.com', 'Foreigner', 'Pakistan', 'ykmmk', 'Standard', 4.00, 'Single Bed', 1, 'Room only', 0.00, '2026-05-11', '2026-05-22', 'Paid', 11, 44.00, 'Pending', NULL),
(36, '', 'aaa', 'fhdh', 'ifra1@gmail.com', 'Foreigner', 'Pakistan', 'gnhgfhb', 'Standard', 45456.00, 'Single Bed', 1, 'Room only', 0.00, '2026-05-19', '2026-05-30', 'Paid', 11, 500016.00, 'Pending', NULL),
(37, '', 'aaa', 'tyhjn', 'ifra1@gmail.com', 'Foreigner', 'Pakistan', '768457', 'Standard', 465.00, 'Single Bed', 1, 'Room only', 0.00, '2026-05-11', '2026-05-19', 'Paid', 8, 3720.00, 'Pending', NULL),
(38, '', 'aaa', 'u', 'ifra1@gmail.com', 'Foreigner', 'Pakistan', '546', 'Standard', 67.00, 'Double Bed', 1, 'Room only', 0.00, '2026-05-19', '2026-05-28', 'Paid', 9, 603.00, 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room_number` varchar(50) NOT NULL,
  `room_type` varchar(50) NOT NULL,
  `bed_size` varchar(50) DEFAULT NULL,
  `price_per_night` decimal(10,2) NOT NULL,
  `status` enum('Available','Booked','Maintenance') DEFAULT 'Available',
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_number`, `room_type`, `bed_size`, `price_per_night`, `status`, `description`) VALUES
(1, '56', 'Double', NULL, 56.00, 'Booked', 'xv c'),
(2, '67', 'Standard', 'Double Bed', 67.00, 'Booked', 'b g ncmcm c '),
(3, '56', 'Executive', 'Single Bed', 45555.00, 'Booked', '2345678nbvcz'),
(4, '56', 'Standard', 'Single Bed', 45456.00, 'Booked', 'hfbvghjdgshjfbcjaewdkeajfdcrfffkjhbchdhjsfbncdjshfjahnfkjhnaskdjnkasdjqkawsjdiqejfoiewhgfoiehjfoikjd;lsakdmxjasfckldhnfkjusbdhvgkjhkfjcdosdjksfjoiewhfouewryhdjqiwjduiewhfjednekasdmjkasjcndsbvncvc,cmxdkcfjdjsghrufgeiwjdpoqwked;lqwmdq;kwjeoiewghuwhfkejrjo3iryhouqndklsmf;laskdoqewuidj'),
(5, '5y', 'Standard', 'Single Bed', 546546.00, 'Booked', 'asdfghj,k.l;qwertyuiop\\zxcvbnm,.asdfghjkl;wertyuiopxzcvbnm,sdfghjklwertyukiolp;xsdcfvgbhnj,;l.drectvfbygomki,l;.hfkjghjkgklirejmgklkresjhujklvgmdfklgjoidfejgrkwsgjkdfsgjhjkh;re,fkmklrejgbvkrjegurt90igkprw;,fldem clda,lc;lewp[tgiyihjuotkl[woejitik\'q;edl\'q;edl\'AX.\';ASFLPREOY0YI90YIGP[EDLQS'),
(6, '5', 'Standard', 'Single Bed', 465.00, 'Booked', 'b vgfmhnj'),
(7, 'u', 'Standard', 'Single Bed', 756.00, 'Available', ''),
(8, '4', 'Standard', 'Single Bed', 4.00, 'Booked', ''),
(9, '789', 'Standard', 'Single Bed', 7.00, 'Available', ' cn njc nj dj vjds njb n'),
(10, '5', 'Standard', 'Single Bed', 5.00, 'Available', ''),
(11, '5', 'Standard', 'Single Bed', 6.00, 'Available', ''),
(12, '6', 'Standard', 'Single Bed', 67.00, 'Available', ''),
(13, '5', 'Standard', 'Single Bed', 786.00, 'Booked', 'hdfhfvi hncdfkjsjv'),
(14, '4', 'Standard', 'Single Bed', 667.00, 'Booked', 'ghvhjjkm'),
(15, '6', 'Standard', 'Single Bed', 33.00, 'Available', ''),
(16, '6', 'Standard', 'Single Bed', 77.00, 'Available', ''),
(17, '6', 'Standard', 'Single Bed', 674.00, 'Booked', ''),
(18, '5', 'Standard', 'Single Bed', 56.00, 'Booked', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT 'guest',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `role`, `created_at`) VALUES
(4, 'aaa', 'ifra1@gmail.com', '$2y$10$uEuKelD/KWrPKjqSUdnbjuxYDU/Z2Cg64vV0G1VFGavcKPvfJe0qO', 'guest', '2026-05-08 10:32:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roombook`
--
ALTER TABLE `roombook`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roombook`
--
ALTER TABLE `roombook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
