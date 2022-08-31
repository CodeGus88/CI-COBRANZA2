-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-08-2022 a las 17:52:15
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
  `name` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `short_name` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `symbol` varchar(11) COLLATE utf8_spanish2_ci NOT NULL,
  `description` varchar(70) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `dni` varchar(20) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'ci',
  `first_name` varchar(150) COLLATE utf8_spanish2_ci NOT NULL,
  `last_name` varchar(150) COLLATE utf8_spanish2_ci NOT NULL,
  `gender` enum('masculino','femenino','','') COLLATE utf8_spanish2_ci DEFAULT NULL,
  `address` varchar(160) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `mobile` varchar(32) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `business_name` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `ruc` varchar(20) COLLATE utf8_spanish2_ci DEFAULT NULL COMMENT 'nit',
  `company` varchar(150) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `loan_status` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) DEFAULT NULL COMMENT 'adviser_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guarantors`
--

CREATE TABLE `guarantors` (
  `id` bigint(20) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `loans`
--

CREATE TABLE `loans` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `credit_amount` decimal(15,2) NOT NULL,
  `interest_amount` decimal(15,2) NOT NULL COMMENT 'interest_rate',
  `num_fee` int(3) NOT NULL,
  `fee_amount` decimal(10,2) NOT NULL,
  `payment_m` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `coin_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `micropayments`
--

CREATE TABLE `micropayments` (
  `id` bigint(20) NOT NULL,
  `loan_item_id` int(11) DEFAULT NULL,
  `mount` decimal(25,2) DEFAULT NULL,
  `pay_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(150) COLLATE utf8_spanish2_ci NOT NULL,
  `last_name` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_spanish2_ci NOT NULL,
  `password` varchar(250) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`) VALUES
(1, 'DR. ORLANDO', 'BEJARANO FERNANDEZ', 'gerenciacredichuracasa@gmail.com', 'ad57cb3de9c53c1fc7de94665f6f1db2dfbcaaf73063769fed0b3011466eba602c2f423c4725c6dfacdc2973a518a18e0784e848ca3aabd7cadfd140df1df447'),
(2, 'DR. JERZON PABLO', 'SIHUAIROS', 'legalcredichuracasa@gmail.com', 'ad57cb3de9c53c1fc7de94665f6f1db2dfbcaaf73063769fed0b3011466eba602c2f423c4725c6dfacdc2973a518a18e0784e848ca3aabd7cadfd140df1df447'),
(3, 'LIC. GISELA', 'CARVAJAL NINAJA', 'credichuracasaadm@gmail.com', 'ad57cb3de9c53c1fc7de94665f6f1db2dfbcaaf73063769fed0b3011466eba602c2f423c4725c6dfacdc2973a518a18e0784e848ca3aabd7cadfd140df1df447'),
(4, 'ING. RUSSETT', 'RODRIGUEZ VELIZ', 'cobrostarijacredichura@gmail.com', 'ad57cb3de9c53c1fc7de94665f6f1db2dfbcaaf73063769fed0b3011466eba602c2f423c4725c6dfacdc2973a518a18e0784e848ca3aabd7cadfd140df1df447'),
(5, 'LIC. CRISTIAN OLIVER', 'RAMOS VELIZ', 'auxiliartjacredichuracasa@gmail.com', 'ad57cb3de9c53c1fc7de94665f6f1db2dfbcaaf73063769fed0b3011466eba602c2f423c4725c6dfacdc2973a518a18e0784e848ca3aabd7cadfd140df1df447'),
(6, 'DRA. FABIOLA', 'ARDAYA ALCAZAR', 'agenciayacuibacredichuracasa@gmail.com', 'ad57cb3de9c53c1fc7de94665f6f1db2dfbcaaf73063769fed0b3011466eba602c2f423c4725c6dfacdc2973a518a18e0784e848ca3aabd7cadfd140df1df447'),
(7, 'DRA. M ALEJANDRA', 'ZENTENO VELASCO', 'cobranzascredichuracasa@gmail.com', 'ad57cb3de9c53c1fc7de94665f6f1db2dfbcaaf73063769fed0b3011466eba602c2f423c4725c6dfacdc2973a518a18e0784e848ca3aabd7cadfd140df1df447');

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
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `FK_guarantors_customers` (`customer_id`),
  ADD KEY `FK_guarantors_loans` (`loan_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `guarantors`
--
ALTER TABLE `guarantors`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `loan_items`
--
ALTER TABLE `loan_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `micropayments`
--
ALTER TABLE `micropayments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  ADD CONSTRAINT `FK_guarantors_customers` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_guarantors_loans` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
