-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-08-2022 a las 21:00:11
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_ci-cobranza2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coins`
--

CREATE TABLE `coins` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `short_name` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `symbol` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `description` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `coins`
--

INSERT INTO `coins` (`id`, `name`, `short_name`, `symbol`, `description`) VALUES
(1, 'bolivianos', 'Bs', 'b', 'Moneda nacional'),
(2, 'dolar', 'usd', '$', 'dolar estadounidense'),
(3, 'euros', 'eu', 'e', 'moneda europea');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `dni` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'ci',
  `first_name` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `last_name` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `gender` enum('masculino','femenino','','') COLLATE utf8_spanish_ci DEFAULT NULL,
  `address` varchar(160) COLLATE utf8_spanish_ci DEFAULT NULL,
  `mobile` varchar(32) COLLATE utf8_spanish_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `business_name` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ruc` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'nit',
  `company` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `loan_status` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) DEFAULT NULL COMMENT 'adviser_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `customers`
--

INSERT INTO `customers` (`id`, `dni`, `first_name`, `last_name`, `gender`, `address`, `mobile`, `phone`, `business_name`, `ruc`, `company`, `loan_status`, `user_id`) VALUES
(8, '12345678', 'María', 'chavez', 'masculino', '', '', '', '', '', '', 0, 1),
(9, '344555', 'mario', 'flores', 'femenino', '', '', '', '', '', '', 0, 1),
(10, '12344', 'RUBEN', 'CHAVEZ', 'masculino', 'av el incas98', '', '', '', '', '', 1, 2),
(11, '123451', 'diego', 'arnica', 'masculino', 'mariano cron 45', '', '', '', '', '', 0, 1),
(12, '7654321', 'matilde', 'frisanc', 'femenino', 'choqwur n455', '', '', '', '', '', 0, 1),
(13, '1223', 'PABLO', 'MORALESSS', 'masculino', '', '', '', '', '', '', 0, 2),
(14, '6565565', 'Pedro', 'Fernandez', 'masculino', 'Calle las calles', '7935689', '4856985', '', '', 'Xempresas', 0, 1),
(15, '6547571', 'Sofía', 'Fuentes', 'femenino', 'Calle las palmas', '79356891', '4856958', '', '', ' Empresass', 0, 1),
(16, '12131415', 'Ramiro', 'Fuentes', 'masculino', 'Calle X', '7564854', '', '', '', '', 0, 1),
(17, '454125', 'CLARIZA', 'PRADO', 'femenino', 'Calle y dirección', '7935689', '4856958', '', '', '', 0, 1),
(18, '548967', 'DANIEL', 'FERNANDEZ', 'masculino', 'calle x', '7935689', '', '', '', '', 0, 2),
(19, '5569949', 'JHESICA', 'PRADO CáRDENAS', 'femenino', 'Calle X Y', '7935689', '', '', '', '', 0, 2),
(21, '1213212', 'JAIME', 'OMONTE', 'masculino', '', '', '', '', '', '', 0, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guarantors`
--

CREATE TABLE `guarantors` (
  `id` bigint(20) DEFAULT NULL,
  `loan_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `loans`
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
-- Volcado de datos para la tabla `loans`
--

INSERT INTO `loans` (`id`, `customer_id`, `credit_amount`, `interest_amount`, `num_fee`, `fee_amount`, `payment_m`, `coin_id`, `date`, `status`) VALUES
(10, 11, '3000.00', '3.00', 4, '772.50', 'mensual', 3, '2021-07-04', b'0'),
(11, 10, '3000.00', '4.00', 3, '1040.00', 'mensual', 1, '2021-07-18', b'1'),
(12, 9, '2000.00', '2.00', 3, '680.00', 'mensual', 1, '2021-07-18', b'0'),
(13, 12, '1000.00', '2.00', 4, '255.00', 'mensual', 2, '2021-07-18', b'1'),
(14, 13, '4000.00', '3.00', 4, '1030.00', 'mensual', 3, '2021-07-18', b'1'),
(15, 15, '5000.00', '3.00', 5, '1030.00', 'mensual', 1, '2022-08-10', b'0'),
(16, 10, '10000.00', '1.00', 25, '404.00', 'mensual', 1, '2022-08-13', b'1'),
(20, 14, '1500.00', '18.00', 3, '770.00', 'diario', 1, '2022-08-24', b'0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `loan_items`
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
-- Volcado de datos para la tabla `loan_items`
--

INSERT INTO `loan_items` (`id`, `loan_id`, `date`, `num_quota`, `fee_amount`, `pay_date`, `status`) VALUES
(41, 10, '2021-08-04', 1, '772.50', '2022-08-23 19:44:00', b'0'),
(42, 10, '2021-09-04', 2, '772.50', '2021-07-08 22:40:50', b'0'),
(43, 10, '2021-10-04', 3, '772.50', '2022-08-12 23:06:25', b'0'),
(44, 10, '2021-11-04', 4, '772.50', '2022-08-12 23:06:30', b'0'),
(45, 11, '2021-08-18', 1, '1040.00', '2022-08-22 13:50:24', b'0'),
(46, 11, '2021-09-18', 2, '1040.00', '2022-08-12 23:14:41', b'1'),
(47, 11, '2021-10-18', 3, '1040.00', '2022-08-12 23:14:44', b'1'),
(48, 12, '2021-08-18', 1, '680.00', '2022-08-22 21:56:36', b'0'),
(49, 12, '2021-09-18', 2, '680.00', '2022-08-23 00:08:48', b'0'),
(50, 12, '2021-10-18', 3, '680.00', '2022-08-23 19:54:47', b'0'),
(51, 13, '2021-08-18', 1, '255.00', '2021-07-19 02:10:53', b'1'),
(52, 13, '2021-09-18', 2, '255.00', '2021-07-19 02:10:53', b'1'),
(53, 13, '2021-10-18', 3, '255.00', '2021-07-19 02:10:53', b'1'),
(54, 13, '2021-11-18', 4, '255.00', '2021-07-19 02:10:53', b'1'),
(55, 14, '2021-08-18', 1, '1030.00', '2021-07-19 02:26:15', b'0'),
(56, 14, '2021-09-18', 2, '1030.00', '2021-07-19 02:26:16', b'0'),
(57, 14, '2021-10-18', 3, '1030.00', '2022-08-13 23:41:07', b'0'),
(58, 14, '2021-11-18', 4, '1030.00', '2021-07-19 02:23:32', b'1'),
(59, 15, '2022-09-10', 1, '1030.00', '2022-08-10 19:54:18', b'1'),
(60, 15, '2022-10-10', 2, '1030.00', '2022-08-10 19:54:18', b'1'),
(61, 15, '2022-11-10', 3, '1030.00', '2022-08-10 19:54:18', b'1'),
(62, 15, '2022-12-10', 4, '1030.00', '2022-08-10 19:54:18', b'1'),
(63, 15, '2023-01-10', 5, '1030.00', '2022-08-10 19:54:19', b'1'),
(64, 16, '2022-09-13', 1, '404.00', '2022-08-23 19:33:16', b'0'),
(65, 16, '2022-10-13', 2, '404.00', '2022-08-12 23:32:09', b'1'),
(66, 16, '2022-11-14', 3, '404.00', '2022-08-12 23:32:09', b'1'),
(67, 16, '2022-12-14', 4, '404.00', '2022-08-12 23:32:09', b'1'),
(68, 16, '2023-01-14', 5, '404.00', '2022-08-12 23:32:09', b'1'),
(69, 16, '2023-02-14', 6, '404.00', '2022-08-12 23:32:09', b'1'),
(70, 16, '2023-03-14', 7, '404.00', '2022-08-12 23:32:09', b'1'),
(71, 16, '2023-04-14', 8, '404.00', '2022-08-12 23:32:09', b'1'),
(72, 16, '2023-05-14', 9, '404.00', '2022-08-12 23:32:10', b'1'),
(73, 16, '2023-06-14', 10, '404.00', '2022-08-12 23:32:10', b'1'),
(74, 16, '2023-07-14', 11, '404.00', '2022-08-12 23:32:10', b'1'),
(75, 16, '2023-08-14', 12, '404.00', '2022-08-12 23:32:10', b'1'),
(76, 16, '2023-09-14', 13, '404.00', '2022-08-12 23:32:10', b'1'),
(77, 16, '2023-10-14', 14, '404.00', '2022-08-12 23:32:10', b'1'),
(78, 16, '2023-11-14', 15, '404.00', '2022-08-12 23:32:10', b'1'),
(79, 16, '2023-12-14', 16, '404.00', '2022-08-12 23:32:10', b'1'),
(80, 16, '2024-01-14', 17, '404.00', '2022-08-12 23:32:10', b'1'),
(81, 16, '2024-02-14', 18, '404.00', '2022-08-12 23:32:10', b'1'),
(82, 16, '2024-03-14', 19, '404.00', '2022-08-12 23:32:10', b'1'),
(83, 16, '2024-04-14', 20, '404.00', '2022-08-12 23:32:10', b'1'),
(84, 16, '2024-05-14', 21, '404.00', '2022-08-12 23:32:10', b'1'),
(85, 16, '2024-06-14', 22, '404.00', '2022-08-12 23:32:10', b'1'),
(86, 16, '2024-07-14', 23, '404.00', '2022-08-12 23:32:10', b'1'),
(87, 16, '2024-08-14', 24, '404.00', '2022-08-12 23:32:10', b'1'),
(88, 16, '2024-09-14', 25, '404.00', '2022-08-12 23:32:10', b'1'),
(102, 20, '2022-08-25', 1, '770.00', '2022-08-24 18:04:00', b'0'),
(103, 20, '2022-08-26', 2, '770.00', '2022-08-24 18:18:43', b'0'),
(104, 20, '2022-08-27', 3, '770.00', '2022-08-24 18:18:43', b'0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `micropayments`
--

CREATE TABLE `micropayments` (
  `id` bigint(20) NOT NULL,
  `loan_item_id` int(11) DEFAULT NULL,
  `mount` decimal(25,2) DEFAULT NULL,
  `pay_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `last_name` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(250) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`) VALUES
(1, 'Fulano', 'Fulanes Dábalos', 'admin@gmail.com', 'ad57cb3de9c53c1fc7de94665f6f1db2dfbcaaf73063769fed0b3011466eba602c2f423c4725c6dfacdc2973a518a18e0784e848ca3aabd7cadfd140df1df447'),
(2, 'GERARDO', 'GOMEZ', 'adminuser@gmail.com', 'ad57cb3de9c53c1fc7de94665f6f1db2dfbcaaf73063769fed0b3011466eba602c2f423c4725c6dfacdc2973a518a18e0784e848ca3aabd7cadfd140df1df447'),
(3, 'FERNANDO', 'QUEQUES', 'user@gmail.com', 'ad57cb3de9c53c1fc7de94665f6f1db2dfbcaaf73063769fed0b3011466eba602c2f423c4725c6dfacdc2973a518a18e0784e848ca3aabd7cadfd140df1df447');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `coins`
--
ALTER TABLE `coins`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD KEY `FK_customers_users` (`user_id`);

--
-- Indices de la tabla `guarantors`
--
ALTER TABLE `guarantors`
  ADD KEY `Índice 1` (`id`),
  ADD KEY `FK__loans` (`loan_id`),
  ADD KEY `FK__customers` (`customer_id`);

--
-- Indices de la tabla `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `coin_id` (`coin_id`);

--
-- Indices de la tabla `loan_items`
--
ALTER TABLE `loan_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_id` (`loan_id`);

--
-- Indices de la tabla `micropayments`
--
ALTER TABLE `micropayments`
  ADD KEY `id` (`id`),
  ADD KEY `FK__loan_items` (`loan_item_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `coins`
--
ALTER TABLE `coins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `loan_items`
--
ALTER TABLE `loan_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT de la tabla `micropayments`
--
ALTER TABLE `micropayments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `FK_customers_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `guarantors`
--
ALTER TABLE `guarantors`
  ADD CONSTRAINT `FK__customers` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK__loans` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `loans_ibfk_2` FOREIGN KEY (`coin_id`) REFERENCES `coins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `loan_items`
--
ALTER TABLE `loan_items`
  ADD CONSTRAINT `loan_items_ibfk_1` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `micropayments`
--
ALTER TABLE `micropayments`
  ADD CONSTRAINT `FK__loan_items` FOREIGN KEY (`loan_item_id`) REFERENCES `loan_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
