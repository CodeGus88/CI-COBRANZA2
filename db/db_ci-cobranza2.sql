-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 11, 2022 at 04:10 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ci-cobranza2`
--

-- --------------------------------------------------------

--
-- Table structure for table `coins`
--

CREATE TABLE `coins` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `short_name` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `symbol` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `description` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `coins`
--

INSERT INTO `coins` (`id`, `name`, `short_name`, `symbol`, `description`) VALUES
(1, 'bolivianos', 'Bs', 'b', 'Moneda nacional'),
(2, 'dolar', 'usd', '$', 'dolar estadounidense'),
(3, 'euros', 'eu', 'e', 'moneda europea');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `dni` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `first_name` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `last_name` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `gender` enum('masculino','femenino','','') COLLATE utf8_spanish_ci DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `province_id` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `district_id` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `address` varchar(160) COLLATE utf8_spanish_ci DEFAULT NULL,
  `mobile` varchar(32) COLLATE utf8_spanish_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `business_name` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ruc` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `company` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `loan_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `dni`, `first_name`, `last_name`, `gender`, `department_id`, `province_id`, `district_id`, `address`, `mobile`, `phone`, `business_name`, `ruc`, `company`, `loan_status`) VALUES
(8, '12345678', 'maria', 'chavez', 'masculino', NULL, NULL, NULL, '', '', '', '', '', '', 0),
(9, '344555', 'mario', 'flores', 'femenino', 10, '1003', '100311', '', '', '', '', '', '', 1),
(10, '12344', 'ruben', 'chavez', 'masculino', 10, '1002', '100202', 'av el incas98', '', '', '', '', '', 1),
(11, '123451', 'diego', 'arnica', 'masculino', 12, '1203', '120303', 'mariano cron 45', '', '', '', '', '', 1),
(12, '7654321', 'matilde', 'frisanc', 'femenino', 11, '1103', '110304', 'choqwur n455', '', '', '', '', '', 1),
(13, '1223', 'pablo', 'moralesss', 'masculino', 10, '1002', '100202', '', '', '', '', '', '', 1),
(14, '6565565', 'Pedro', 'Fernandez', 'masculino', NULL, NULL, NULL, 'Calle las calles', '7935689', '4856985', '', '', 'Xempresas', 0),
(15, '6547571', 'Sofía', 'Fuentes', 'femenino', NULL, NULL, NULL, 'Calle las palmas', '79356891', '4856958', '', '', ' Empresass', 1);

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `credit_amount` decimal(15,2) NOT NULL,
  `interest_amount` decimal(15,2) NOT NULL,
  `num_fee` int(3) NOT NULL,
  `fee_amount` decimal(10,2) NOT NULL,
  `payment_m` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `coin_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `customer_id`, `credit_amount`, `interest_amount`, `num_fee`, `fee_amount`, `payment_m`, `coin_id`, `date`, `status`) VALUES
(10, 11, '3000.00', '3.00', 4, '772.50', 'mensual', 1, '2021-07-04', b'1'),
(11, 10, '3000.00', '4.00', 3, '1040.00', 'mensual', 1, '2021-07-18', b'1'),
(12, 9, '2000.00', '2.00', 3, '680.00', 'mensual', 1, '2021-07-18', b'1'),
(13, 12, '1000.00', '2.00', 4, '255.00', 'mensual', 2, '2021-07-18', b'1'),
(14, 13, '4000.00', '3.00', 4, '1030.00', 'mensual', 1, '2021-07-18', b'1'),
(15, 15, '5000.00', '3.00', 5, '1030.00', 'mensual', 1, '2022-08-10', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `loan_items`
--

CREATE TABLE `loan_items` (
  `id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `num_quota` int(11) NOT NULL,
  `fee_amount` decimal(25,2) NOT NULL,
  `pay_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `loan_items`
--

INSERT INTO `loan_items` (`id`, `loan_id`, `date`, `num_quota`, `fee_amount`, `pay_date`, `status`) VALUES
(41, 10, '2021-08-04', 1, '772.50', '2021-07-08 22:40:50', b'0'),
(42, 10, '2021-09-04', 2, '772.50', '2021-07-08 22:40:50', b'0'),
(43, 10, '2021-10-04', 3, '772.50', '2021-07-05 01:12:13', b'1'),
(44, 10, '2021-11-04', 4, '772.50', '2021-07-05 01:12:13', b'1'),
(45, 11, '2021-08-18', 1, '1040.00', '2021-07-19 00:56:48', b'0'),
(46, 11, '2021-09-18', 2, '1040.00', '2021-07-19 00:55:17', b'1'),
(47, 11, '2021-10-18', 3, '1040.00', '2021-07-19 00:55:17', b'1'),
(48, 12, '2021-08-18', 1, '680.00', '2021-07-19 02:09:52', b'1'),
(49, 12, '2021-09-18', 2, '680.00', '2021-07-19 02:09:53', b'1'),
(50, 12, '2021-10-18', 3, '680.00', '2021-07-19 02:09:53', b'1'),
(51, 13, '2021-08-18', 1, '255.00', '2021-07-19 02:10:53', b'1'),
(52, 13, '2021-09-18', 2, '255.00', '2021-07-19 02:10:53', b'1'),
(53, 13, '2021-10-18', 3, '255.00', '2021-07-19 02:10:53', b'1'),
(54, 13, '2021-11-18', 4, '255.00', '2021-07-19 02:10:53', b'1'),
(55, 14, '2021-08-18', 1, '1030.00', '2021-07-19 02:26:15', b'0'),
(56, 14, '2021-09-18', 2, '1030.00', '2021-07-19 02:26:16', b'0'),
(57, 14, '2021-10-18', 3, '1030.00', '2021-07-19 02:23:32', b'1'),
(58, 14, '2021-11-18', 4, '1030.00', '2021-07-19 02:23:32', b'1'),
(59, 15, '2022-09-10', 1, '1030.00', '2022-08-10 19:54:18', b'1'),
(60, 15, '2022-10-10', 2, '1030.00', '2022-08-10 19:54:18', b'1'),
(61, 15, '2022-11-10', 3, '1030.00', '2022-08-10 19:54:18', b'1'),
(62, 15, '2022-12-10', 4, '1030.00', '2022-08-10 19:54:18', b'1'),
(63, 15, '2023-01-10', 5, '1030.00', '2022-08-10 19:54:19', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `last_name` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(250) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`) VALUES
(1, 'Fulano', 'Fulanes', 'admin@gmail.com', 'ad57cb3de9c53c1fc7de94665f6f1db2dfbcaaf73063769fed0b3011466eba602c2f423c4725c6dfacdc2973a518a18e0784e848ca3aabd7cadfd140df1df447');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coins`
--
ALTER TABLE `coins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `coin_id` (`coin_id`);

--
-- Indexes for table `loan_items`
--
ALTER TABLE `loan_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_id` (`loan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `coins`
--
ALTER TABLE `coins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `loan_items`
--
ALTER TABLE `loan_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `loans_ibfk_2` FOREIGN KEY (`coin_id`) REFERENCES `coins` (`id`);

--
-- Constraints for table `loan_items`
--
ALTER TABLE `loan_items`
  ADD CONSTRAINT `loan_items_ibfk_1` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
