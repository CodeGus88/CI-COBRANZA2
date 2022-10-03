-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-10-2022 a las 17:06:17
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
-- Base de datos: `admincre_db_ci_cobranza2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coins`
--

CREATE TABLE `coins` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `short_name` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `symbol` varchar(11) COLLATE utf8_spanish2_ci NOT NULL,
  `description` varchar(70) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `coins`
--

INSERT INTO `coins` (`id`, `name`, `short_name`, `symbol`, `description`) VALUES
(1, 'Bolivianos', 'Bs', 'BO', 'Moneda nacional');

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

--
-- Volcado de datos para la tabla `customers`
--

INSERT INTO `customers` (`id`, `dni`, `first_name`, `last_name`, `gender`, `address`, `mobile`, `phone`, `business_name`, `ruc`, `company`, `loan_status`, `user_id`) VALUES
(3, '10709331', 'MARIA JULIA', 'JURADO RODRIGUEZ', 'femenino', 'BARRIO 27 DE MAYO ', '68688249', '', '', '', '', 1, 3),
(4, '5044555', 'EDULIO', 'CARI APARICIO', 'masculino', 'b/luis de fuentes', '77873321', '', 'propio', '5044555', 'taxi', 1, 4),
(5, '5039377', 'BARBARITA CRISTINA', 'ZENTENO MARISCAL', 'femenino', 'B/ SAN MARCOS C/ COLON N-173O', '72962288', '', '', '', '', 1, 2),
(6, '1052847', 'MARIA LOURDES', 'VACA RAMOS DE VELASCO', 'femenino', 'AV. SAMA', '72980734', '', '', '', '', 0, 3),
(7, '5506680', 'CARLA CAROLA', 'RODRIGUEZ SOTOMAYOR', '', 'B/ ALTO SENAC ', '71820406', '', '', '', '', 1, 2),
(9, '5815577', 'HILDA GABRIELA', 'ORTEGA MARTINEZ', 'femenino', 'B/6 DE AGOSTO', '75129912', '', '', '', 'GARANTE', 1, 5),
(10, '5008664', 'MARIA', 'LLAMPA VIDAURRE', 'femenino', 'ZONA LA TERMINAL', '60257038', '', '', '', '', 1, 3),
(12, '7109398', 'CRISTHIAN HAROLD', 'ROCHA MENDEZ', 'masculino', 'B/ MORROS BLANCOS ', '74533209', '', '', '', '', 1, 2),
(13, '7217197', 'MARIA MAYDA', 'TITIZANO JEREZ', 'femenino', 'AV. LOS CEIBOS BA/ SENAC ', '73483618', '0', '', '', '', 1, 1),
(15, '5796238', 'MARLENE', 'ROMAN BOLIVAR', 'femenino', 'BA/26 DE AGOSTO ', '', '', '', '', '', 1, 1),
(16, '7190526', 'MARCO ANTONIO', 'COLODRO', 'masculino', 'BA/NACIONAL CARAPARI ', '', '', '', '', '', 1, 1),
(17, '10625967', 'HUGO ALBARO', 'CONDORI COLQUE', 'masculino', 'B/ ALTO SENAC C/ EL CHAÑAR', '76183152', '', '', '', 'GARANTE', 0, 5),
(18, '7197800', 'CESAR ALEX', 'QUISPE LLANQUE', 'masculino', 'B/ 12 DE OCTUBRE C/ ANDALUCIA ', '65811181', '', '', '', '', 1, 2),
(19, '7211060', 'CELESTE NARELLA', 'ROCHA ALARCON', 'femenino', 'BA/ PARADA EL NORTE ', '7211060', '', '', '', 'GARANTE', 1, 5),
(20, '1886834', 'MARIO', 'SOSSA VASQUEZ', 'masculino', 'BARRIO TABLADITA C/LOS TAJIBOS', '60274489', '60274489', '', '', '', 1, 3),
(21, '7179193', 'EDUARDO LUIZ', 'ANTEZANA RAMOS', 'femenino', 'BA/ PARADA EL NORTE ', '78703409', '', '', '', '', 0, 5),
(22, '7105231', 'EDGAR', 'TOLAY MOLINA', 'masculino', 'SAN GERONIMO ALTO DE LA ALIANZA ', '69307019', '', '', '', '', 1, 5),
(23, '1847138', 'MARIA ZULMA', 'UGARTE VASQUEZ', 'femenino', 'BA/ SENAC ', '70229813', '6655535', '', '', '', 1, 1),
(24, '1884314', 'MIRKA', 'LARA VILCA', 'femenino', 'BARRIO LA PAMPA AV. POTOSI ', '79260489', '', '', '', '', 1, 3),
(25, '1663104', 'LUCIO', 'TOLAY', 'masculino', 'SAN GERONIMO ALTO DE LA ALIANZA ', '', '', '', '', 'GARANTE', 0, 5),
(26, '5811198', 'IVANNA SHAFID', 'VARGAS UGARTE', 'femenino', 'AV. DOMINGO PAZ ', '75138159', '', '', '', '', 1, 1),
(27, '1892800-1F', 'PABLO FLAVIO', 'ESPINDOLA SANCHEZ', 'masculino', 'BARRIO TABLADITA PJE. EL CHURQUI', '78221907', '', '', '', '', 0, 3),
(28, '1860839', 'PAOLA PATRICIA', 'CAMPERO', 'femenino', 'BARRIO MOLINO C. VIRGINIO LEMA', '', '', '', '', '', 1, 3),
(31, '7206055', 'ROBERT PABLO', 'SANCHEZ TAPIA', 'masculino', 'C. MIRAFLORES Y MEJILLONES ', '74507778', '', '', '', '', 1, 3),
(32, '5809785', 'RENE', 'COLQUECHAMBI FLORES', 'masculino', 'B. MORROS BLANCOS C. FRAY QUEBRACHO', '79255860', '', '', '', '', 1, 3),
(33, '7254095', 'ROLY ALEJANDRO', 'VELASCO VACA', 'masculino', 'B. TABLADITA AV. SAMA C. CHAPAQUITA', '73498936', '', '', '', '', 1, 3),
(34, '5055299', 'RICHARD', 'ROMERO CASTILLO', 'masculino', 'B.57 VIVIENDAS PJE N-3', '6788226', '', '', '', '', 1, 3),
(35, '4120354', 'SABINO', 'CHOQUE', 'masculino', 'B.27 DE MAYO AV. SALINAS', '63789847', '', '', '', '', 1, 3),
(36, '7148877', 'SANTOS RODOLFO', 'FERNANDEZ CHAUQUE', 'masculino', 'B. LOS CHAPACOS C. BELLAVISTA', '75147408', '', '', '', '', 1, 3),
(37, '5049517', 'SERGIO DANIEL', 'GUERRERO ARENAS', '', 'B. SAN JOSE  C. SUIPACHA ESQ. SALTA', '78239141', '', '', '', '', 1, 3),
(38, '2785290', 'EDUARDO', 'LLAMPA VIDAURRE', 'masculino', 'BA/ 12 DE OCTUBRE', '65810211', '', '', '', '', 1, 5),
(39, '1884457', 'ALBERTO', 'LLAMPA VIDAURRE', 'masculino', 'B/LOURDES ', '', '', '', '', 'GARANTE', 0, 5),
(40, '7217361', 'SILVIA LEONOR', 'AYARDE VARGAS', 'femenino', 'B. SANTA ROSA AV. GRAN CHACO', '67380388', '', '', '', '', 1, 3),
(41, '7142667', 'CRISTIAN OLIVER', 'RAMOS VELIZ', 'masculino', 'B/ AVAROA C/ CALAMA ', '76802609', '', '', '', '', 1, 2),
(42, '7106747', 'CYNTIA YOVANA', 'VELASCO VACA', 'femenino', 'B/ EL MANANTIAL AV/ SAN ANTONIO', '65833585', '', '', '', '', 1, 2),
(44, '4157689', 'DALMA DAYANA', 'ORTEGA GARNICA', 'femenino', 'B/ 4 DE JULIO C/ ECUADOR ', '4157689', '', '', '', '', 1, 2),
(45, '7109217', 'WALTER LUCAS', 'PIMENTEL LAURA', 'masculino', 'B. MENDEZ ARCOS AV. LOS MOLLES', '78701876', '', '', '', '', 1, 3),
(48, '7212958', 'EMELDA', 'ARMELLA SOLIZ', 'femenino', 'B/ LUIS PIZARRO C/ PASTOR BORDA ', '68680402', '', '', '', '', 1, 2),
(49, '7259089', 'MARISOL DANIELA', 'RAMOS', 'femenino', 'ZONA SAN JACINTO ', '75128680', '', '', '', '', 1, 1),
(50, '4143978', 'MARIA DEL ROSARIO', 'RIOS VALDEZ', 'femenino', 'BA/ AVAROA CALLE CALAMA ', '73495002', '', '', '', '', 1, 1),
(51, '7238521', 'MILDRED ROCIO', 'ALBORNOZ', 'femenino', 'C/ COCHABAMBA N*179', '76199969', '', '', '', '', 1, 1),
(53, '7143371', 'NOEMI LILA', 'LOPEZ CANEDO', 'femenino', 'BA/ LA PAMPA AV/ POTOSI ', '67991999', '', '', '', '', 1, 1),
(54, '4134360', 'ZAIDA ANAHI', 'MIRANDA RUIZ', 'femenino', 'ZONA PALMARCITO C. JOSE ELECTO', '72992767', '', '', '', '', 1, 3),
(55, '7127438', 'PAUL MIKI', 'GARNICA MEZZA', 'masculino', 'BA/ SAN ROQUE C/ GENERAL TRIGO ', '72955787', '', '', '', '', 1, 1),
(56, '5797560', 'LIMBER RAYNARD', 'GARNICA MEZZA', 'masculino', 'BA/ ANDALUSIA C/ FINAL RUILOBA ', '', '', '', '', '', 1, 1),
(57, '10651336', 'PAOLA RAQUEL', 'PIMENTEL ROMERO', '', 'BA/ JUAN XXIII C/ GODOFREDO ARNOLD ', '77879502', '', '', '', '', 1, 1),
(58, '7229068', 'JOSE MANUEL', 'OJEDA MARTINEZ', 'masculino', 'BA/ FATIMA ', '60274386', '', '', '', '', 1, 1),
(59, '5784463', 'EVA TERESA', 'SANDOVAL', 'femenino', 'B/ ALTO SENAC ', '78225155', '', '', '', '', 1, 2),
(60, '4071301', 'WILBER ALVARO', 'GARCIA PADILLA', 'masculino', 'B/ SENAC C/ BELLA VISTA ', '78225155', '', '', '', '', 0, 2),
(61, '1893814', 'RITA MARIA', 'SANDOVAL', 'femenino', 'B/ TABLADITA', '75140184', '', '', '', '', 0, 2),
(62, '5784586', 'PAMELA JUANA', 'RIVERA FLORES', 'femenino', 'COLON NORTE ', '69325911', '', '', '', '', 1, 1),
(65, '1878631', 'WISTON WILBER', 'YUCRA PALACIOS', 'femenino', 'BA/ SAN JORGE ', '72992642', '', '', '', '', 1, 1),
(66, '5787275', 'POLONIA', 'JEREZ RUEDA', 'femenino', 'BA/ AEROPUERTO ', '71332395', '', '', '', '', 1, 1),
(67, '5675379', 'ELIANA GRACIELA', 'SARAVIA CARDOZO', 'femenino', 'B/ OSCAR ALFARO ', '68703121', '', '', '', '', 1, 2),
(68, '1787751', 'ELENA', 'CARDOZO YEBARA', 'femenino', 'B/ IV CENTENARIO', '', '', '', '', '', 0, 2),
(69, '7167619', 'ROLY ADAN', 'CARY MANPAZO', 'femenino', 'BA/SIMON BOLIVAR ', '73482828', '', '', '', '', 1, 1),
(70, '7247912', 'LISELDA MILENIA', 'ROMERO ALARCON', 'femenino', 'COM SAN DIEGO NORTE ', '72943345', '', '', '', '', 1, 1),
(71, '5684823', 'SOLEDAD DOMINGA', 'VASQUEZ FERNANDEZ', 'femenino', 'AV/ LOS CEIBOS BA SENAC ', '73484466', '', '', '', '', 1, 1),
(72, '5032867', 'JUANA ANGELICA', 'MENDIETA CARDONA', 'femenino', 'Z/ VILLA FATIMA C/ ESPAÑA ', '78244484', '', '', '', '', 1, 1),
(73, '7162716', 'SERGIO', 'ROCHA ALARCON', 'masculino', 'BA/ AVAROA C/ BALLIVIAN ', '63405477', '', '', '', '', 1, 1),
(74, '1899092', 'TATIANA', 'TRUJILLO VASQUEZ', 'femenino', 'BA/ SENAC AV/ HEROES DE LA INDEPENDENCIA ', '70211763', '', '', '', '', 1, 1),
(75, '5006333', 'GABRIELA PATRICIA', 'CASTILLO TOLABA', 'femenino', 'B/ SAN MARCOS', '78704333', '', '', '', '', 1, 2),
(76, '5021478', 'VICTOR EMERSON', 'CARTAGENA CASTRO', 'masculino', 'BA LA LOMA ', '76180448', '', '', '', '', 1, 1),
(77, '5002529', 'EVA NIEVES', 'CRUZ GUTIERREZ', 'femenino', 'C/ COCHABAMBA N|1480', '71877280', '', '', '', '', 1, 1),
(78, '5001200', 'YOLANDA', 'FLORES AYARDE', 'femenino', 'ERQUIS NORTE ', '72940770', '', '', '', '', 1, 1),
(79, '1889902', 'EULOGIO RAMIRO', 'HUMACATA', 'masculino', 'ZONA CAMPESINO ', '', '', '', '', '', 1, 1),
(80, '5801048', 'IVAN NERY', 'ICHAZU SUSTACH', 'masculino', 'B/ LA PAMPA', '75121235', '', '', '', '', 1, 2),
(81, '7141330', 'IVER MAURICIO', 'VELASCO VACA', 'masculino', 'B/ MAGISTERIO Z/ TABLADITA', '75133624', '', '', '', '', 1, 2),
(82, '10640681', 'JESUS GONZALO', 'CHOQUE JURADO', '', 'AV/ SALINAS C/ DOMETILA', '69315139', '', '', '', '', 1, 2),
(84, '14177626', 'JHONNY GABRIEL', 'ONTIVEROS RASGUIDO', 'masculino', 'B/ SAN ANTONIO C/ ISABEL LA CATOLICA', '76802609', '', '', '', '', 1, 2),
(85, '5808056', 'GIOVANNI BRAYAN', 'PEREZ IRAHOLA', 'masculino', 'B/ SAN JOSE ', '70211244', '', '', '', '', 0, 2),
(86, '10660835', 'LUIS FERNANDO', 'CISNEROS', 'masculino', 'ave. Panamericana y  Luis campero', '68767242', '', '', '', 'trabaja en la cascada', 1, 4),
(88, '7197273', 'JHON WALTER', 'SALVATIERRA VACA', 'masculino', 'B/ SAN JORGE II', '77170324', '', '', '', '', 1, 2),
(92, '12849458', 'AMISTAD ALEJANDRA', 'ZELADA MARTINEZ', 'femenino', 'B/FLORIDA CALLE COLON Y 6 DE ENERO', '67632811', '', '', '', 'AMISTAD', 0, 4),
(93, '10719735', 'JORGE LUIS', 'CRUZ MENDOZA', 'masculino', 'B/ 26 DE AGOSTO', '75146451', '', '', '', '', 1, 2),
(95, '10741444', 'JUAN CARLOS', 'MAMANI CHOQUE', 'masculino', 'B/ LOMA DE TOMATITAS', '76194960', '', '', '', '', 1, 2),
(96, '4147520', 'LUCIA', 'VALLEJOS FLORES', 'femenino', 'MZ. 11 CASA Nº 5 URB. BELLA VISTA II- YACUIBA', '63776345', 'NO REGISTRA', '', '', '', 1, 6),
(97, '7120125', 'KAREN ESTHER', 'CORDERO MORALES', 'femenino', 'B/ SENAC ', '68702457', '', '', '', '', 1, 2),
(98, '2637944', 'ANA MARIA', 'SARMIENTO', 'femenino', 'BA/ MIRAFLORES ', '72995775', '', '', '', '', 1, 5),
(99, '5008907', 'LEONOR', 'ARENAS TOLABA', 'masculino', 'B/ MENDEZ ARCOS', '70212600', '', '', '', '', 1, 2),
(101, '7105285', 'LUIS FERNANDO', 'NIEVES MARQUEZ', 'masculino', 'B/ NARCISO CAMPERO', '76836500', '', '', '', '', 1, 2),
(102, '10703486', 'MONICA ALEJANDRA', 'GUZMAN RAMIREZ', 'femenino', 'SAN LORENZO MATADERO MUNICIAPAL', '67632811', '', '', '', 'AMISTAD', 1, 4),
(103, '6786439', 'CAROLINA PAOLA', 'GALEAN', 'femenino', 'B/ ALTO SENAC C/ EL CHAÑAR', '76183152', '', '', '', '', 1, 5),
(104, '5056800', 'FABIOLA', 'MERCADO CAYALO', 'femenino', 'CREVAUX E/M. BARROSO Y SAN MARTIN Nº 196 B/C. NORTE YACUIBA', '71068363', 'NO REGISTRA', '', '', '', 1, 6),
(105, '7155107', 'LUIS ALFREDO', 'CHOQUE REYNOSO', 'masculino', 'C/PALOS BLANCOS E/MARTIN BARROSO Y COMERCIO YACUIBA', '75174191', 'NO REGISTRA', '', '', '', 1, 6),
(107, '12411923', 'KATHIA BELEN', 'RAMIREZ QUISPE', 'femenino', 'B/FLORIDA CALLE COLON Y 6 DE ENERO', '69328559', '', '', '', '', 0, 4),
(108, '1898679', 'ROLANDO MANUEL', 'CRUZ PORTAL', 'masculino', 'C/BALLIVIAN E/JUAN XXIII Y SAN PEDRO YACUIBA', '75160837', 'NO REGISTRA', '', '', '', 0, 6),
(109, '7221217', 'ESTHER ABIGAIL', 'BUSTOS DAVILA', 'femenino', 'BA/ MOTO MENDEZ', '65811022', '', '', '', '', 1, 5),
(110, '7180798', 'JUAN JOSE', 'CHURA ALBINO', 'masculino', 'B/ SAN BERNARDO', '', '', '', '', 'GARANTE', 1, 5),
(111, '6125302', 'FARE ISAEL', 'SANCHEZ DAVALOS', 'masculino', 'BA/ SAN ANTONIO ', '78246113', '', '', '', '', 1, 5),
(112, '14837656', 'CARLA LORENA', 'ORTEGA HUARACHI', 'femenino', 'B/ SAN ANTONIO', '', '', '', '', 'GARANTE', 0, 5),
(123, '7259747', 'GONZALO', 'ANTEZANO RAMOS', 'masculino', 'BA/ MENDEZ ARCOS', '72958255', '', '', '', '', 1, 5),
(124, '5030757', 'ANA ROSA', 'RAMOS VARGAS', 'femenino', 'BA/ MENDEZ ARCOS', '75113295', '', '', '', '', 0, 5),
(125, '7152316', 'HILDA FERNANDEZ', 'TOLABA', 'femenino', 'B/ IV CENTENARIO', '75120469', '', '', '', '', 0, 5),
(127, '7167479', 'INGRID', 'VELASQUEZ ROMERO', 'femenino', 'B/ SAN GERONIMO', '77871357', '', '', '', '', 1, 5),
(128, '5041294', 'YIMMY WILSON', 'SAAVEDRA CHIPANA', 'masculino', 'AV/ MARCELO QUIROGA SANTA CRUZ B/ LUIS ESPINAL ', '68694846', '', '', '', '', 1, 5),
(130, '5787673', 'JUAN DARIO', 'VILLAROEL REYNOSO', 'masculino', 'C/ BALLIVIAN ESQ. JUAN XXIII', '71873195', '', '', '', '', 1, 5),
(133, '4141852', 'KARINA', 'CASTILLO CARDOZO', 'femenino', 'C/ LA VICTORIA BA/ TABLADITA ', '76196369', '', '', '', '', 1, 5),
(134, '6638630', 'VICTOR', 'CASTRO', 'masculino', 'B/ TABLADITA', '72980234', '', '', '', '', 0, 5),
(135, '7136623', 'LUIS EMILIO', 'SARAVIA CARDOZA', 'masculino', 'TABLADA GRANDE', '60255451', '', '', '', '', 1, 5),
(136, '1873728', 'EVA', 'LOPEZ MAMANI', 'femenino', 'C/M. BARROSO E/BOQUERON Y V. MONTES B/ LA CRUZ YACUIBA', '77197408', 'NO REGISTRA', '', '', '', 1, 6),
(137, '7668170', 'FIDEL', 'FALON GALEAN', 'masculino', 'COM BELLA VISTA - GRAN CHACO - TARIJA', '71433026', '', '', '', '', 1, 7),
(139, '5009688', 'JESUS', 'CASTILLO CASTRO', 'masculino', 'C/ROBLES E/SANTA CRUZ Y COMERCIO B. ATLETICO NORTE YACUIBA', '77196581', 'NO REGISTRA', '', '', '', 1, 6),
(142, '7166644', 'NELSON', 'VELIZ HINOJOSA', 'masculino', 'URB. BELLA VISTA II MZ. 5 CASA Nº 10 YACUIBA', '67695215', 'NO REGISTRA', '', '', '', 1, 6),
(144, '7154411', 'ROSMERY', 'ARANCIBIA SERRUDO', 'femenino', 'MZ. 5 CASA Nº 8 URB. BELLA VISTA II- YACUIBA', '71879853', 'NO REGISTRA', '', '', '', 0, 6),
(145, '8064094', 'BERTHA', 'CUEVAS FLORES', 'femenino', 'C/COCHABAMBAFINALS/N B/ ASERRADERO - YACUIBA', '76813559', '', '', '', '', 1, 7),
(146, '5046558', 'SELENE', 'URZAGASTE ARECO', 'femenino', 'COM. COLONIA PRODUCTIVA FISCAL EL PALMAR - GRAN CHACO - TARIJA', '75176886', '', '', '', '', 0, 7),
(147, '8166058', 'EMILSE', 'SALVATIERRA TEJERINA', 'femenino', 'AV. LIBERTADORES ESQ. URUNDELES B. EL PORVENIR - YACUIBA', '60298806', '', '', '', '', 0, 7),
(148, '7104384', 'MARYBEL', 'GARECA VARGAS', 'femenino', 'PROLONGACION LAS DELICIAS - B/ASERRADERO - YACUIBA', '67389464', '', '', '', '', 0, 7),
(149, '7228075', 'VICTOR HUGO', 'CAMARGO', 'masculino', 'COM. TARAIRI VILLAMONTES GRAN CHACO TARIJA', '61669428', 'NO REGISTRA', '', '', '', 1, 6),
(151, '10722293', 'MARIA VICTORIA', 'PARADA', 'femenino', 'AV. LIBERTADORES E/JACINTO DELFINYCOLON - YACUIBA', '75168164', '', '', '', '', 0, 7),
(152, '5810149', 'SANDRA VALERIA', 'CONDORI OSINAGA', 'femenino', 'C/BENEMERITOS E/M BARROSO Y AV. S. MARTIN - YACUIBA ', '68016484', '', '', '', '', 0, 7),
(153, '5816465', 'AGAPITO', 'SORUCO ORTIZ', 'masculino', 'C/URUGUAY E/LIBERTAD Y ECUADOR B/EL PRADO YACUIBA', '68901933', 'NO REGISTRA', '', '', '', 1, 6),
(154, '4155405', 'WILBER', 'GONZALES', 'masculino', 'C/F. CAMPO VIA E/T. MANCHEGO Y E. RUIZ B.S. GERONIMO YACUIBA', '', 'NO REGISTRA', '', '', '', 0, 6),
(155, '2854534', 'IRMA FABIOLA', 'GUTIERREZ SUAREZ', 'femenino', 'C/DANIEL CAMPOS ESQ.  AV.  LIBERTADORES B/OBRERO - YACUIBA', '', '', '', '', '', 0, 7),
(156, '9707908', 'JORGE CORNELIO', 'CUEVAS FLORES', 'masculino', 'RES. EN YACUIBA', '76821126', '', '', '', '', 0, 7),
(157, '2926863', 'GRACIELA', 'GONZALES VALLE VDA. DE ELIAS', 'femenino', 'C/JUAN XXIII ESQ. CORNELIO RIOS YACUIBA', '71378316', 'NO REGISTRA', '', '', '', 1, 6),
(158, '1836015', 'LOURDES', 'PADILLA', 'femenino', 'C/CORNELIO RIOS E/JUAN XXIII Y JACINTO DELFIN YACUIBA', '73458576', 'NO REGISTRA', '', '', '', 0, 6),
(159, '7245064', 'MARCO ANTONIO', 'LOPEZ ZARATE', 'masculino', 'C/TUPIZA E/AV. TARIJA Y CHUQUISACA S/N S.J. DE POCITOS', '76824296', 'NO REGISTRA', '', '', '', 1, 6),
(160, '1817258', 'ADOLFO', 'ARROYO SAINS', 'femenino', 'COM. OJO DEL AGUA GRAN CHACO ', '76824296', 'NO REGISTRA', '', '', '', 0, 6),
(161, '5802105', 'RONY', 'ORTIZ CAMACHO', 'masculino', 'C/BOLIVAR E/21 DE ENERO Y E. MENDEZ B/SAN FRANCISCO YACUIBA', '63793218', 'NO REGISTRA', '', '', '', 1, 6),
(162, '5790037', 'JORGE ALEJANDRO', 'CUELLAR MENDOZA', 'masculino', 'C/PARAGUAY E/C MORENO Y 15 DE ABRIL B/MUNICIPAL YACUIBA', '71336226', 'NO REGISTRA', '', '', '', 1, 6),
(163, '10632600', 'ROLANDO', 'HERRERA', 'masculino', 'COM. CAMPO LARGO GRAN CHACO TARIJA', '', 'NO REGISTRA', '', '', '', 0, 6),
(164, '10635688', 'MARIANA NOEMI', 'RIOS MENDOZA', 'femenino', 'H. SALAZAR ESQ. DELICIAS S/N B/LAS DELICIAS YACUIBA', '76805789', 'NO REGISTRA', '', '', '', 1, 6),
(165, '5014304', 'MARIA', 'MENDOZA ALVAREZ', 'femenino', 'C/HUGO SALAZAR ESQ. LAS DELICIAS B/FRANZ QUEBRACHO YACUIBA', '75165883', 'NO REGISTRA', '', '', '', 0, 6),
(166, '12381291', 'KEYCLIN KATHERIN', 'CASTILLO CABRERA', 'femenino', 'C/CORNELIO RIOS E/CEBILES Y CHAÑARES', '75160051', 'NO REGISTRA', '', '', '', 1, 6),
(167, '7210596', 'MARISOL', 'CABRERA', 'femenino', 'C/C. RIOS E/CHAÑARES Y CEVILES B/FERROVIARIO YACUIBA', '77192387', 'NO REGISTRA', '', '', '', 0, 6),
(168, '1884070', 'HILDA ELVA', 'CASTRILLO PIZARRO VDA. DE GAMBARTE', 'femenino', 'AV. LAS DELICIAS E/CAMPERO S/N B. LA PLAYA YACUIBA', '67695857', 'NO REGISTRA', '', '', '', 1, 6),
(169, '7145480', 'LARITZA', 'GAMBARTE CASTRILLO', 'femenino', 'C/SAN PEDRO E/AV. DELICIAS Y 15 DE ABRIL B/LA PLAYA YACUIBA', '', 'NO REGISTRA', '', '', '', 0, 6),
(171, '5780197', 'PRIMITIVA', 'GALARZA VALLE', 'femenino', 'C/M BARROSO E/CREVAUX Y SUCRE B. CENTRONORTE - YACUIBA', '77893215', '', '', '', '', 0, 7),
(172, '1885720', 'MARGARITA', 'AMPUERO BARJA DE GONZALES', 'femenino', 'C/CORNELIO RIOSESQ.QUEBRACHOS-B/FERRROVIARIO-YACUIBA', '75162401', '', '', '', '', 0, 7),
(173, '7125466', 'SONIA', 'ARTEAGA MOYE', 'femenino', 'B/15 DE AGOSTO - COM. LAPACHAL ALTO - YBA G. CHACO-TJA', '68718144', '', '', '', '', 0, 7),
(174, '1878048', 'SANDRA TRICIA', 'ACOSTA TAPIA', 'femenino', 'BA/ MONTO MENDEZ ', '74511513', '', '', '', '', 1, 1),
(175, '5050637', 'BRIGIDAMARGOTH', 'BATALLANOS DE ROCA', 'femenino', 'C/DELFIN E/BENI YBOLIVAR - B/S J. OBRERO - YACUIBA', '74509635', '', '', '', '', 1, 7),
(176, '5009809', 'JUAN CARLOS', 'NUÑEZ ARANCIBIA', 'masculino', 'C/ROBLES ESQ. AVAROA II S/N B/SANTACANDELARIA', '76815064', '', '', '', '', 0, 7),
(177, '5050743', 'AIDA LUZ', 'VALLEJOS QUISPE', 'femenino', 'B. LAS DELICIAS C/ JUAN XXIII - YACUIBA', '69349473', '', '', '', '', 0, 7),
(178, '10711135', 'MARIELA', 'SAAVEDRA FORES', 'femenino', 'FINAL C/INDEPENDENCIA S/N B. SAN FRANCISCO YACUIBA', '75185989', '', '', '', '', 0, 7),
(179, '1848994', 'FEDERICO ANTONIO', 'FLORES', 'masculino', 'Zona Central C/Colon N°882', '75125557', '', '', '', '', 1, 1),
(180, '7238010', 'FIDEL FABIAN', 'GARECA ACOSTA', 'masculino', 'B. MOTO MENDEZ BLOQ.M-22', '', '', '', '', '', 1, 1),
(185, '7175626', 'JUAN GABRIEL', 'MARTINEZ ANACHURI', 'masculino', '', '', '', '', '', '', 0, 1),
(188, '5784526', 'PAMELA JUANA', 'RIVERA FLORES', 'femenino', 'B. AEROPUERTO AV. H DEL CHACO', '69325911', '', '', '', '', 1, 1),
(189, '1899950', 'MARY DOLORES', 'MEJIA BARCA DE CASTILLO', 'femenino', 'C/ROBLES E/SANTA CRUZ Y COMERCIO B. ATLETICO NORTE YACUIBA', '60297883', 'NO REGISTRA', '', '', '', 1, 6),
(190, '4137855', 'ANA LIA', 'GARCIA MEDRANO', 'femenino', 'C/D CAMPOS E/BALLIVIAN Y F. TAMAYO-B.S. JOSE OBRERO-YBA', '75376011', '', '', '', '', 1, 7),
(191, '5998229', 'RODO CELSO', 'VALDEZ MORALES', 'masculino', 'C, UNION No.170Z.VILLA COPACABANA', '74526638', '', '', '', '', 0, 7),
(192, '7236324-1Q', 'MARIA  ALEJANDRA', 'REYES GARCIA', 'femenino', 'C/H.SALAZAR E/COMERCIOY MARTIN BARROSO B. JUAN XXIII-YBA', '', '', '', '', '', 0, 7),
(211, '6547523', 'DAMIAN', 'FUENTES CLAROS', 'masculino', 'calle xyz', '78569458', '', '', '', '', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guarantors`
--

CREATE TABLE `guarantors` (
  `id` bigint(20) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `guarantors`
--

INSERT INTO `guarantors` (`id`, `loan_id`, `customer_id`) VALUES
(3, 10, 15),
(4, 10, 16),
(8, 40, 56),
(9, 41, 58),
(10, 42, 60),
(11, 42, 61),
(14, 45, 13),
(15, 45, 65),
(16, 46, 21),
(17, 47, 70),
(18, 48, 72),
(19, 50, 68),
(20, 51, 23),
(21, 53, 77),
(22, 54, 79),
(23, 58, 85),
(24, 59, 25),
(25, 61, 39),
(26, 66, 9),
(27, 69, 96),
(29, 71, 17),
(31, 73, 110),
(32, 74, 112),
(33, 75, 124),
(34, 76, 98),
(35, 79, 134),
(36, 81, 108),
(39, 85, 144),
(41, 87, 154),
(42, 88, 158),
(43, 89, 160),
(44, 90, 162),
(45, 91, 163),
(46, 92, 165),
(47, 93, 167),
(48, 94, 169),
(49, 95, 146),
(50, 95, 147),
(51, 95, 148),
(52, 95, 151),
(53, 95, 152),
(54, 95, 155),
(55, 95, 156),
(59, 98, 176),
(60, 98, 177),
(61, 98, 178),
(62, 106, 139),
(63, 107, 191),
(64, 107, 192),
(73, 112, 16),
(74, 113, 13),
(75, 114, 4),
(76, 114, 92),
(77, 114, 102),
(78, 115, 92),
(79, 116, 15),
(80, 116, 16),
(81, 117, 50),
(82, 128, 92);

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

--
-- Volcado de datos para la tabla `loans`
--

INSERT INTO `loans` (`id`, `customer_id`, `credit_amount`, `interest_amount`, `num_fee`, `fee_amount`, `payment_m`, `coin_id`, `date`, `status`) VALUES
(3, 3, '2000.00', '18.00', 12, '256.70', 'semanal', 1, '2022-07-23', b'1'),
(4, 5, '1800.00', '18.00', 6, '462.00', 'quincenal', 1, '2022-07-16', b'1'),
(5, 6, '1500.00', '18.00', 4, '510.00', 'quincenal', 1, '2022-05-16', b'0'),
(6, 7, '1000.00', '18.00', 6, '256.70', 'quincenal', 1, '2022-08-16', b'1'),
(7, 10, '616.00', '18.00', 8, '104.70', 'semanal', 1, '2022-06-24', b'1'),
(9, 12, '2500.00', '18.00', 4, '850.00', 'quincenal', 1, '2022-07-14', b'1'),
(10, 13, '5000.00', '18.00', 10, '950.00', 'quincenal', 1, '2022-02-16', b'1'),
(11, 18, '2000.00', '18.00', 4, '680.00', 'quincenal', 1, '2022-08-24', b'1'),
(12, 20, '1500.00', '16.00', 6, '370.00', 'quincenal', 1, '2022-08-16', b'1'),
(13, 24, '1500.00', '18.00', 4, '510.00', 'quincenal', 1, '2022-08-25', b'1'),
(14, 27, '1500.00', '18.00', 8, '255.00', 'semanal', 1, '2022-08-16', b'0'),
(15, 28, '2096.00', '18.00', 12, '269.00', 'semanal', 1, '2022-05-21', b'1'),
(18, 31, '2500.00', '18.00', 4, '850.00', 'quincenal', 1, '2022-04-16', b'1'),
(19, 32, '1000.00', '16.00', 2, '580.00', 'quincenal', 1, '2022-07-22', b'1'),
(20, 33, '1500.00', '18.00', 8, '322.50', 'quincenal', 1, '2022-05-11', b'1'),
(21, 34, '4000.00', '18.00', 3, '2053.30', 'mensual', 1, '2022-07-14', b'1'),
(22, 35, '2000.00', '17.00', 4, '670.00', 'quincenal', 1, '2022-07-21', b'1'),
(23, 36, '2000.00', '18.00', 6, '513.30', 'quincenal', 1, '2022-07-08', b'1'),
(24, 37, '2000.00', '18.00', 4, '680.00', 'quincenal', 1, '2022-08-22', b'1'),
(25, 40, '1302.00', '18.00', 4, '442.70', 'quincenal', 1, '2022-04-28', b'1'),
(26, 41, '500.00', '15.00', 6, '120.80', 'quincenal', 1, '2022-06-18', b'1'),
(27, 42, '1500.00', '18.00', 6, '385.00', 'quincenal', 1, '2022-05-17', b'1'),
(29, 45, '1500.00', '18.00', 6, '385.00', 'quincenal', 1, '2022-07-25', b'1'),
(31, 44, '3500.00', '18.00', 10, '665.00', 'quincenal', 1, '2022-02-08', b'1'),
(32, 49, '3710.00', '18.00', 6, '952.20', 'quincenal', 1, '2022-06-13', b'1'),
(33, 50, '4000.00', '15.00', 10, '700.00', 'quincenal', 1, '2022-05-05', b'1'),
(34, 51, '5000.00', '18.00', 6, '1283.30', 'quincenal', 1, '2022-08-03', b'1'),
(35, 53, '3000.00', '18.00', 6, '770.00', 'quincenal', 1, '2022-04-21', b'1'),
(36, 54, '2000.00', '18.00', 8, '340.00', 'semanal', 1, '2022-07-21', b'1'),
(38, 48, '1900.00', '18.00', 6, '487.70', 'quincenal', 1, '2022-06-28', b'1'),
(40, 55, '3500.00', '18.00', 6, '898.30', 'quincenal', 1, '2022-05-10', b'1'),
(41, 57, '3500.00', '18.00', 10, '665.00', 'quincenal', 1, '2022-03-17', b'1'),
(42, 59, '2000.00', '17.00', 4, '670.00', 'quincenal', 1, '2022-06-22', b'1'),
(43, 62, '3500.00', '18.00', 12, '449.20', 'semanal', 1, '2021-12-02', b'1'),
(45, 66, '10638.00', '18.00', 20, '1010.60', 'semanal', 1, '2022-07-16', b'1'),
(46, 19, '9395.00', '18.00', 20, '892.50', 'semanal', 1, '2022-07-14', b'1'),
(47, 69, '3000.00', '18.00', 8, '510.00', 'semanal', 1, '2021-09-29', b'1'),
(48, 71, '3500.00', '18.00', 10, '665.00', 'quincenal', 1, '2022-07-16', b'1'),
(49, 73, '6500.00', '18.00', 10, '1235.00', 'quincenal', 1, '2022-04-18', b'1'),
(50, 67, '4170.00', '18.00', 5, '1584.60', 'mensual', 1, '2022-01-05', b'1'),
(51, 74, '3000.00', '18.00', 6, '770.00', 'quincenal', 1, '2022-08-17', b'1'),
(52, 75, '1500.00', '18.00', 4, '510.00', 'quincenal', 1, '2022-05-16', b'1'),
(53, 76, '3500.00', '18.00', 2, '2065.00', 'quincenal', 1, '2022-08-16', b'1'),
(54, 78, '2500.00', '18.00', 6, '641.70', 'quincenal', 1, '2022-08-25', b'1'),
(55, 80, '1000.00', '16.00', 2, '580.00', 'quincenal', 1, '2022-08-08', b'1'),
(56, 81, '1500.00', '18.00', 6, '385.00', 'quincenal', 1, '2022-08-04', b'1'),
(57, 82, '1500.00', '18.00', 8, '322.50', 'quincenal', 1, '2022-06-07', b'1'),
(58, 84, '1500.00', '18.00', 6, '385.00', 'quincenal', 1, '2022-05-17', b'1'),
(59, 22, '4000.00', '18.00', 12, '513.30', 'semanal', 1, '2022-03-14', b'1'),
(60, 88, '1000.00', '18.00', 2, '590.00', 'quincenal', 1, '2022-07-28', b'1'),
(61, 38, '2280.00', '18.00', 12, '292.60', 'semanal', 1, '2022-04-25', b'1'),
(62, 93, '2000.00', '18.00', 4, '680.00', 'quincenal', 1, '2022-07-22', b'1'),
(63, 95, '1000.00', '18.00', 4, '340.00', 'quincenal', 1, '2022-08-16', b'1'),
(64, 97, '800.00', '16.00', 4, '264.00', 'quincenal', 1, '2022-08-22', b'1'),
(65, 99, '2000.00', '18.00', 4, '680.00', 'quincenal', 1, '2022-08-09', b'1'),
(66, 98, '1397.00', '18.00', 4, '475.00', 'quincenal', 1, '2022-07-11', b'1'),
(67, 96, '1542.00', '15.00', 8, '250.60', 'semanal', 1, '2022-07-19', b'1'),
(68, 101, '3749.00', '17.00', 4, '1255.90', 'quincenal', 1, '2022-08-09', b'1'),
(69, 104, '3500.00', '18.00', 12, '449.20', 'semanal', 1, '2022-02-04', b'1'),
(70, 105, '2000.00', '18.00', 12, '256.70', 'semanal', 1, '2022-05-10', b'1'),
(71, 103, '4593.00', '18.00', 8, '987.50', 'quincenal', 1, '2022-07-05', b'1'),
(73, 109, '2000.00', '18.00', 6, '513.30', 'quincenal', 1, '2022-03-17', b'1'),
(74, 111, '3500.00', '18.00', 20, '332.50', 'semanal', 1, '2021-12-27', b'1'),
(75, 123, '4000.00', '18.00', 12, '513.30', 'semanal', 1, '2022-05-10', b'1'),
(76, 9, '2500.00', '18.00', 10, '475.00', 'quincenal', 1, '2022-01-29', b'1'),
(77, 127, '2112.00', '18.00', 8, '359.00', 'semanal', 1, '2022-05-11', b'1'),
(78, 128, '2500.00', '18.00', 8, '537.50', 'quincenal', 1, '2022-06-10', b'1'),
(79, 133, '3000.00', '18.00', 10, '570.00', 'quincenal', 1, '2022-07-26', b'1'),
(80, 135, '3000.00', '18.00', 6, '770.00', 'quincenal', 1, '2022-08-17', b'1'),
(81, 136, '2696.00', '18.00', 6, '692.00', 'quincenal', 1, '2022-08-16', b'1'),
(82, 137, '2000.00', '16.00', 6, '493.30', 'quincenal', 1, '2022-08-05', b'1'),
(84, 139, '10000.00', '15.00', 20, '875.00', 'semanal', 1, '2022-06-08', b'1'),
(85, 142, '3500.00', '18.00', 12, '449.20', 'semanal', 1, '2022-07-13', b'1'),
(86, 149, '2000.00', '18.00', 12, '256.70', 'semanal', 1, '2022-07-13', b'1'),
(87, 153, '2500.00', '18.00', 12, '320.80', 'semanal', 1, '2022-07-20', b'1'),
(88, 157, '3500.00', '18.00', 6, '898.30', 'quincenal', 1, '2022-07-25', b'1'),
(89, 159, '2000.00', '18.00', 6, '513.30', 'quincenal', 1, '2022-07-28', b'1'),
(90, 161, '6000.00', '15.00', 6, '1450.00', 'quincenal', 1, '2022-08-03', b'1'),
(91, 162, '3500.00', '18.00', 6, '898.30', 'quincenal', 1, '2022-08-03', b'1'),
(92, 164, '3500.00', '18.00', 6, '898.30', 'quincenal', 1, '2022-08-13', b'1'),
(93, 166, '3500.00', '18.00', 6, '898.30', 'quincenal', 1, '2022-08-15', b'1'),
(94, 168, '2500.00', '18.00', 6, '641.70', 'quincenal', 1, '2022-08-18', b'1'),
(95, 145, '13000.00', '16.00', 6, '3206.70', 'quincenal', 1, '2022-07-19', b'1'),
(97, 174, '500.00', '20.00', 4, '150.00', 'semanal', 1, '2022-09-02', b'1'),
(98, 175, '7000.00', '16.00', 6, '1726.70', 'quincenal', 1, '2022-08-02', b'1'),
(99, 179, '1000.00', '16.00', 1, '1160.00', 'mensual', 1, '2022-09-10', b'0'),
(100, 180, '500.00', '20.00', 4, '150.00', 'semanal', 1, '2022-09-13', b'1'),
(102, 130, '3500.00', '18.00', 4, '1190.00', 'quincenal', 1, '2022-03-26', b'1'),
(103, 110, '3500.00', '18.00', 4, '1190.00', 'quincenal', 1, '2022-02-09', b'1'),
(104, 188, '3881.00', '18.00', 12, '498.10', 'semanal', 1, '2022-03-16', b'1'),
(105, 179, '2000.00', '18.00', 2, '1180.00', 'quincenal', 1, '2022-09-15', b'1'),
(106, 189, '1700.00', '18.00', 8, '289.00', 'semanal', 1, '2022-09-02', b'1'),
(107, 190, '8000.00', '16.00', 6, '1973.30', 'quincenal', 1, '2022-08-05', b'1'),
(112, 15, '15800.00', '14.00', 12, '2422.70', 'quincenal', 1, '2022-09-16', b'1'),
(113, 16, '1300.00', '14.00', 4, '416.00', 'quincenal', 1, '2022-09-21', b'1'),
(114, 86, '1500.00', '10.00', 4, '450.00', 'quincenal', 1, '2022-09-22', b'1'),
(115, 4, '850.00', '14.00', 20, '102.00', 'quincenal', 1, '2022-09-26', b'1'),
(116, 23, '1500.00', '14.00', 12, '230.00', 'quincenal', 1, '2022-09-26', b'1'),
(117, 211, '2500.00', '10.00', 4, '750.00', 'quincenal', 1, '2022-09-26', b'1'),
(118, 79, '4500.00', '14.00', 4, '1440.00', 'quincenal', 1, '2022-09-27', b'1'),
(119, 26, '1500.00', '14.00', 300, '110.00', 'quincenal', 1, '2022-09-28', b'1'),
(120, 56, '1527.00', '14.00', 60, '32.58', 'diario', 1, '2022-10-01', b'1'),
(121, 58, '1527.00', '14.00', 60, '32.58', 'diario', 1, '2022-10-01', b'1'),
(122, 65, '18571.00', '14.00', 30, '705.70', 'diario', 1, '2022-10-01', b'1'),
(123, 70, '18571.00', '14.00', 30, '705.70', 'diario', 1, '2022-10-01', b'1'),
(124, 72, '1500.00', '14.00', 2, '855.00', 'quincenal', 1, '2022-10-01', b'1'),
(125, 72, '1500.00', '14.00', 2, '855.00', 'quincenal', 1, '2022-10-01', b'1'),
(126, 72, '1500.00', '14.00', 2, '855.00', 'quincenal', 1, '2022-10-01', b'1'),
(127, 77, '1521.00', '11.00', 6, '337.16', 'quincenal', 1, '2022-10-01', b'1'),
(128, 102, '77777.00', '11.00', 22, '7813.05', 'quincenal', 1, '2022-10-01', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `loan_items`
--

CREATE TABLE `loan_items` (
  `id` bigint(20) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `num_quota` int(11) NOT NULL,
  `fee_amount` decimal(25,2) NOT NULL,
  `pay_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `loan_items`
--

INSERT INTO `loan_items` (`id`, `loan_id`, `date`, `num_quota`, `fee_amount`, `pay_date`, `status`) VALUES
(9, 3, '2022-07-30', 1, '256.70', '2022-09-02 15:40:35', b'0'),
(10, 3, '2022-08-06', 2, '256.70', '2022-09-02 15:40:35', b'0'),
(11, 3, '2022-08-13', 3, '256.70', '2022-09-24 00:51:31', b'0'),
(12, 3, '2022-08-20', 4, '256.70', '2022-09-24 00:51:36', b'0'),
(13, 3, '2022-08-27', 5, '256.70', '2022-09-24 00:51:39', b'0'),
(14, 3, '2022-09-03', 6, '256.70', '2022-10-01 01:27:44', b'0'),
(15, 3, '2022-09-10', 7, '256.70', '2022-10-01 13:53:19', b'0'),
(16, 3, '2022-09-17', 8, '256.70', '2022-10-03 13:29:29', b'0'),
(17, 3, '2022-09-24', 9, '256.70', '2022-08-31 20:01:35', b'1'),
(18, 3, '2022-10-01', 10, '256.70', '2022-08-31 20:01:35', b'1'),
(19, 3, '2022-10-08', 11, '256.70', '2022-08-31 20:01:35', b'1'),
(20, 3, '2022-10-15', 12, '256.70', '2022-08-31 20:01:35', b'1'),
(21, 4, '2022-08-02', 1, '462.00', '2022-09-14 14:35:21', b'0'),
(22, 4, '2022-08-15', 2, '462.00', '2022-09-14 14:35:21', b'0'),
(23, 4, '2022-08-30', 3, '462.00', '2022-09-24 00:51:44', b'0'),
(24, 4, '2022-09-14', 4, '462.00', '2022-09-24 00:51:47', b'0'),
(25, 4, '2022-09-29', 5, '462.00', '2022-09-24 04:16:55', b'0'),
(26, 4, '2022-10-14', 6, '462.00', '2022-08-31 20:12:47', b'1'),
(27, 5, '2022-05-31', 1, '510.00', '2022-09-02 15:41:41', b'0'),
(28, 5, '2022-06-15', 2, '510.00', '2022-09-02 15:41:41', b'0'),
(29, 5, '2022-06-30', 3, '510.00', '2022-09-30 23:40:34', b'0'),
(30, 5, '2022-07-15', 4, '510.00', '2022-09-30 23:41:12', b'0'),
(31, 6, '2022-08-31', 1, '256.70', '2022-09-14 14:32:57', b'0'),
(32, 6, '2022-09-15', 2, '256.70', '2022-08-31 20:16:55', b'1'),
(33, 6, '2022-09-30', 3, '256.70', '2022-08-31 20:16:55', b'1'),
(34, 6, '2022-10-15', 4, '256.70', '2022-08-31 20:16:55', b'1'),
(35, 6, '2022-11-01', 5, '256.70', '2022-08-31 20:16:55', b'1'),
(36, 6, '2022-11-14', 6, '256.70', '2022-08-31 20:16:55', b'1'),
(37, 7, '2022-07-01', 1, '104.70', '2022-09-02 15:43:19', b'0'),
(38, 7, '2022-07-08', 2, '104.70', '2022-09-02 15:43:19', b'0'),
(39, 7, '2022-07-15', 3, '104.70', '2022-09-02 15:43:19', b'0'),
(40, 7, '2022-07-22', 4, '104.70', '2022-09-02 15:43:19', b'0'),
(41, 7, '2022-07-29', 5, '104.70', '2022-09-02 15:43:19', b'0'),
(42, 7, '2022-08-05', 6, '104.70', '2022-09-02 15:43:19', b'0'),
(43, 7, '2022-08-12', 7, '104.70', '2022-09-30 21:35:47', b'0'),
(44, 7, '2022-08-19', 8, '104.70', '2022-09-30 21:35:51', b'0'),
(49, 9, '2022-07-29', 1, '850.00', '2022-09-14 14:36:35', b'0'),
(50, 9, '2022-08-13', 2, '850.00', '2022-08-31 20:29:49', b'1'),
(51, 9, '2022-08-30', 3, '850.00', '2022-08-31 20:29:49', b'1'),
(52, 9, '2022-09-12', 4, '850.00', '2022-08-31 20:29:49', b'1'),
(53, 10, '2022-03-03', 1, '950.00', '2022-09-15 13:48:20', b'0'),
(54, 10, '2022-03-18', 2, '950.00', '2022-09-15 13:48:20', b'0'),
(55, 10, '2022-04-02', 3, '950.00', '2022-09-15 13:48:20', b'0'),
(56, 10, '2022-04-19', 4, '950.00', '2022-09-15 13:48:20', b'0'),
(57, 10, '2022-05-02', 5, '950.00', '2022-08-31 20:34:21', b'1'),
(58, 10, '2022-05-17', 6, '950.00', '2022-08-31 20:34:21', b'1'),
(59, 10, '2022-06-01', 7, '950.00', '2022-08-31 20:34:21', b'1'),
(60, 10, '2022-06-16', 8, '950.00', '2022-08-31 20:34:21', b'1'),
(61, 10, '2022-07-01', 9, '950.00', '2022-08-31 20:34:21', b'1'),
(62, 10, '2022-07-16', 10, '950.00', '2022-08-31 20:34:21', b'1'),
(63, 11, '2022-09-08', 1, '680.00', '2022-08-31 20:35:46', b'1'),
(64, 11, '2022-09-23', 2, '680.00', '2022-08-31 20:35:46', b'1'),
(65, 11, '2022-10-08', 3, '680.00', '2022-08-31 20:35:46', b'1'),
(66, 11, '2022-10-25', 4, '680.00', '2022-08-31 20:35:46', b'1'),
(67, 12, '2022-08-31', 1, '370.00', '2022-09-02 15:44:11', b'0'),
(68, 12, '2022-09-15', 2, '370.00', '2022-08-31 20:38:59', b'1'),
(69, 12, '2022-09-30', 3, '370.00', '2022-08-31 20:38:59', b'1'),
(70, 12, '2022-10-15', 4, '370.00', '2022-08-31 20:38:59', b'1'),
(71, 12, '2022-11-01', 5, '370.00', '2022-08-31 20:38:59', b'1'),
(72, 12, '2022-11-14', 6, '370.00', '2022-08-31 20:38:59', b'1'),
(73, 13, '2022-09-09', 1, '510.00', '2022-09-14 15:37:33', b'0'),
(74, 13, '2022-09-24', 2, '510.00', '2022-08-31 20:43:04', b'1'),
(75, 13, '2022-10-11', 3, '510.00', '2022-08-31 20:43:04', b'1'),
(76, 13, '2022-10-24', 4, '510.00', '2022-08-31 20:43:04', b'1'),
(77, 14, '2022-08-23', 1, '255.00', '2022-09-02 15:44:41', b'0'),
(78, 14, '2022-08-30', 2, '255.00', '2022-09-14 15:38:02', b'0'),
(79, 14, '2022-09-06', 3, '255.00', '2022-10-03 14:02:52', b'0'),
(80, 14, '2022-09-13', 4, '255.00', '2022-10-03 14:02:52', b'0'),
(81, 14, '2022-09-20', 5, '255.00', '2022-10-03 14:02:52', b'0'),
(82, 14, '2022-09-27', 6, '255.00', '2022-10-03 14:02:52', b'0'),
(83, 14, '2022-10-04', 7, '255.00', '2022-10-03 14:02:52', b'0'),
(84, 14, '2022-10-11', 8, '255.00', '2022-10-03 14:02:52', b'0'),
(85, 15, '2022-05-28', 1, '269.00', '2022-09-02 15:48:22', b'0'),
(86, 15, '2022-06-04', 2, '269.00', '2022-09-02 15:48:22', b'0'),
(87, 15, '2022-06-11', 3, '269.00', '2022-09-02 15:48:22', b'0'),
(88, 15, '2022-06-18', 4, '269.00', '2022-09-02 15:48:22', b'0'),
(89, 15, '2022-06-25', 5, '269.00', '2022-09-14 15:41:07', b'0'),
(90, 15, '2022-07-02', 6, '269.00', '2022-08-31 20:59:23', b'1'),
(91, 15, '2022-07-09', 7, '269.00', '2022-08-31 20:59:23', b'1'),
(92, 15, '2022-07-16', 8, '269.00', '2022-08-31 20:59:23', b'1'),
(93, 15, '2022-07-23', 9, '269.00', '2022-08-31 20:59:23', b'1'),
(94, 15, '2022-07-30', 10, '269.00', '2022-08-31 20:59:23', b'1'),
(95, 15, '2022-08-06', 11, '269.00', '2022-08-31 20:59:23', b'1'),
(96, 15, '2022-08-13', 12, '269.00', '2022-08-31 20:59:23', b'1'),
(103, 18, '2022-05-03', 1, '850.00', '2022-09-02 15:50:36', b'0'),
(104, 18, '2022-05-16', 2, '850.00', '2022-08-31 21:39:29', b'1'),
(105, 18, '2022-05-31', 3, '850.00', '2022-08-31 21:39:29', b'1'),
(106, 18, '2022-06-15', 4, '850.00', '2022-08-31 21:39:29', b'1'),
(107, 19, '2022-08-06', 1, '580.00', '2022-08-31 21:42:55', b'1'),
(108, 19, '2022-08-23', 2, '580.00', '2022-08-31 21:42:55', b'1'),
(109, 20, '2022-05-26', 1, '322.50', '2022-09-02 15:51:19', b'0'),
(110, 20, '2022-06-10', 2, '322.50', '2022-08-31 22:11:41', b'1'),
(111, 20, '2022-06-25', 3, '322.50', '2022-08-31 22:11:41', b'1'),
(112, 20, '2022-07-12', 4, '322.50', '2022-08-31 22:11:41', b'1'),
(113, 20, '2022-07-25', 5, '322.50', '2022-08-31 22:11:41', b'1'),
(114, 20, '2022-08-09', 6, '322.50', '2022-08-31 22:11:41', b'1'),
(115, 20, '2022-08-24', 7, '322.50', '2022-08-31 22:11:41', b'1'),
(116, 20, '2022-09-08', 8, '322.50', '2022-08-31 22:11:41', b'1'),
(117, 21, '2022-08-16', 1, '2053.30', '2022-08-31 22:15:03', b'1'),
(118, 21, '2022-09-14', 2, '2053.30', '2022-08-31 22:15:03', b'1'),
(119, 21, '2022-10-14', 3, '2053.30', '2022-08-31 22:15:03', b'1'),
(120, 22, '2022-08-05', 1, '670.00', '2022-08-31 22:18:17', b'1'),
(121, 22, '2022-08-20', 2, '670.00', '2022-08-31 22:18:17', b'1'),
(122, 22, '2022-09-06', 3, '670.00', '2022-08-31 22:18:17', b'1'),
(123, 22, '2022-09-19', 4, '670.00', '2022-08-31 22:18:17', b'1'),
(124, 23, '2022-07-23', 1, '513.30', '2022-09-02 15:52:25', b'0'),
(125, 23, '2022-08-09', 2, '513.30', '2022-09-02 15:52:25', b'0'),
(126, 23, '2022-08-22', 3, '513.30', '2022-08-31 22:22:22', b'1'),
(127, 23, '2022-09-06', 4, '513.30', '2022-08-31 22:22:22', b'1'),
(128, 23, '2022-09-21', 5, '513.30', '2022-08-31 22:22:22', b'1'),
(129, 23, '2022-10-06', 6, '513.30', '2022-08-31 22:22:22', b'1'),
(130, 24, '2022-09-06', 1, '680.00', '2022-08-31 22:32:23', b'1'),
(131, 24, '2022-09-21', 2, '680.00', '2022-08-31 22:32:23', b'1'),
(132, 24, '2022-10-06', 3, '680.00', '2022-08-31 22:32:23', b'1'),
(133, 24, '2022-10-21', 4, '680.00', '2022-08-31 22:32:23', b'1'),
(134, 25, '2022-05-13', 1, '442.70', '2022-08-31 22:40:45', b'1'),
(135, 25, '2022-05-28', 2, '442.70', '2022-08-31 22:40:45', b'1'),
(136, 25, '2022-06-14', 3, '442.70', '2022-08-31 22:40:45', b'1'),
(137, 25, '2022-06-27', 4, '442.70', '2022-08-31 22:40:45', b'1'),
(138, 26, '2022-07-05', 1, '120.80', '2022-09-14 14:38:26', b'0'),
(139, 26, '2022-07-18', 2, '120.80', '2022-09-01 13:15:31', b'1'),
(140, 26, '2022-08-02', 3, '120.80', '2022-09-01 13:15:31', b'1'),
(141, 26, '2022-08-17', 4, '120.80', '2022-09-01 13:15:31', b'1'),
(142, 26, '2022-09-01', 5, '120.80', '2022-09-01 13:15:31', b'1'),
(143, 26, '2022-09-16', 6, '120.80', '2022-09-01 13:15:31', b'1'),
(144, 27, '2022-06-01', 1, '385.00', '2022-09-14 14:39:22', b'0'),
(145, 27, '2022-06-16', 2, '385.00', '2022-09-14 14:39:22', b'0'),
(146, 27, '2022-07-01', 3, '385.00', '2022-09-14 14:39:22', b'0'),
(147, 27, '2022-07-16', 4, '385.00', '2022-09-01 13:22:32', b'1'),
(148, 27, '2022-08-02', 5, '385.00', '2022-09-01 13:22:32', b'1'),
(149, 27, '2022-08-15', 6, '385.00', '2022-09-01 13:22:32', b'1'),
(152, 29, '2022-08-09', 1, '385.00', '2022-09-14 15:45:41', b'0'),
(153, 29, '2022-08-24', 2, '385.00', '2022-09-01 13:28:58', b'1'),
(154, 29, '2022-09-08', 3, '385.00', '2022-09-01 13:28:58', b'1'),
(155, 29, '2022-09-23', 4, '385.00', '2022-09-01 13:28:58', b'1'),
(156, 29, '2022-10-08', 5, '385.00', '2022-09-01 13:28:58', b'1'),
(157, 29, '2022-10-25', 6, '385.00', '2022-09-01 13:28:58', b'1'),
(166, 31, '2022-02-23', 1, '665.00', '2022-09-14 14:41:46', b'0'),
(167, 31, '2022-03-10', 2, '665.00', '2022-09-14 14:41:46', b'0'),
(168, 31, '2022-03-25', 3, '665.00', '2022-09-14 14:41:46', b'0'),
(169, 31, '2022-04-09', 4, '665.00', '2022-09-14 14:41:46', b'0'),
(170, 31, '2022-04-26', 5, '665.00', '2022-09-14 14:41:46', b'0'),
(171, 31, '2022-05-09', 6, '665.00', '2022-09-01 13:38:58', b'1'),
(172, 31, '2022-05-24', 7, '665.00', '2022-09-01 13:38:58', b'1'),
(173, 31, '2022-06-08', 8, '665.00', '2022-09-01 13:38:58', b'1'),
(174, 31, '2022-06-23', 9, '665.00', '2022-09-01 13:38:58', b'1'),
(175, 31, '2022-07-08', 10, '665.00', '2022-09-01 13:38:58', b'1'),
(176, 32, '2022-06-28', 1, '952.20', '2022-09-01 14:01:52', b'1'),
(177, 32, '2022-07-13', 2, '952.20', '2022-09-01 14:01:52', b'1'),
(178, 32, '2022-07-28', 3, '952.20', '2022-09-01 14:01:52', b'1'),
(179, 32, '2022-08-12', 4, '952.20', '2022-09-01 14:01:52', b'1'),
(180, 32, '2022-08-27', 5, '952.20', '2022-09-01 14:01:52', b'1'),
(181, 32, '2022-09-13', 6, '952.20', '2022-09-01 14:01:52', b'1'),
(182, 33, '2022-05-20', 1, '700.00', '2022-09-15 14:04:24', b'0'),
(183, 33, '2022-06-04', 2, '700.00', '2022-09-15 14:04:24', b'0'),
(184, 33, '2022-06-21', 3, '700.00', '2022-09-15 14:04:24', b'0'),
(185, 33, '2022-07-04', 4, '700.00', '2022-09-01 14:04:48', b'1'),
(186, 33, '2022-07-19', 5, '700.00', '2022-09-01 14:04:48', b'1'),
(187, 33, '2022-08-03', 6, '700.00', '2022-09-01 14:04:48', b'1'),
(188, 33, '2022-08-18', 7, '700.00', '2022-09-01 14:04:48', b'1'),
(189, 33, '2022-09-02', 8, '700.00', '2022-09-01 14:04:48', b'1'),
(190, 33, '2022-09-17', 9, '700.00', '2022-09-01 14:04:48', b'1'),
(191, 33, '2022-10-04', 10, '700.00', '2022-09-01 14:04:48', b'1'),
(192, 34, '2022-08-18', 1, '1283.30', '2022-09-15 14:05:44', b'0'),
(193, 34, '2022-09-02', 2, '1283.30', '2022-09-15 14:05:44', b'0'),
(194, 34, '2022-09-17', 3, '1283.30', '2022-09-01 14:11:59', b'1'),
(195, 34, '2022-10-04', 4, '1283.30', '2022-09-01 14:11:59', b'1'),
(196, 34, '2022-10-17', 5, '1283.30', '2022-09-01 14:11:59', b'1'),
(197, 34, '2022-11-01', 6, '1283.30', '2022-09-01 14:11:59', b'1'),
(198, 35, '2022-05-06', 1, '770.00', '2022-09-15 14:07:49', b'0'),
(199, 35, '2022-05-21', 2, '770.00', '2022-09-15 14:07:49', b'0'),
(200, 35, '2022-06-07', 3, '770.00', '2022-09-15 14:07:49', b'0'),
(201, 35, '2022-06-20', 4, '770.00', '2022-09-01 14:15:42', b'1'),
(202, 35, '2022-07-05', 5, '770.00', '2022-09-01 14:15:42', b'1'),
(203, 35, '2022-07-20', 6, '770.00', '2022-09-01 14:15:42', b'1'),
(204, 36, '2022-07-28', 1, '340.00', '2022-09-14 15:46:32', b'0'),
(205, 36, '2022-08-04', 2, '340.00', '2022-09-14 15:46:32', b'0'),
(206, 36, '2022-08-11', 3, '340.00', '2022-09-14 15:46:32', b'0'),
(207, 36, '2022-08-18', 4, '340.00', '2022-09-01 14:18:16', b'1'),
(208, 36, '2022-08-25', 5, '340.00', '2022-09-01 14:18:16', b'1'),
(209, 36, '2022-09-01', 6, '340.00', '2022-09-01 14:18:16', b'1'),
(210, 36, '2022-09-08', 7, '340.00', '2022-09-01 14:18:16', b'1'),
(211, 36, '2022-09-15', 8, '340.00', '2022-09-01 14:18:16', b'1'),
(218, 38, '2022-07-13', 1, '487.70', '2022-09-14 14:42:31', b'0'),
(219, 38, '2022-07-28', 2, '487.70', '2022-09-01 14:42:40', b'1'),
(220, 38, '2022-08-12', 3, '487.70', '2022-09-01 14:42:40', b'1'),
(221, 38, '2022-08-27', 4, '487.70', '2022-09-01 14:42:40', b'1'),
(222, 38, '2022-09-13', 5, '487.70', '2022-09-01 14:42:40', b'1'),
(223, 38, '2022-09-26', 6, '487.70', '2022-09-01 14:42:40', b'1'),
(226, 40, '2022-05-25', 1, '898.30', '2022-09-15 15:56:48', b'0'),
(227, 40, '2022-06-09', 2, '898.30', '2022-09-01 14:46:50', b'1'),
(228, 40, '2022-06-24', 3, '898.30', '2022-09-01 14:46:50', b'1'),
(229, 40, '2022-07-09', 4, '898.30', '2022-09-01 14:46:50', b'1'),
(230, 40, '2022-07-26', 5, '898.30', '2022-09-01 14:46:50', b'1'),
(231, 40, '2022-08-08', 6, '898.30', '2022-09-01 14:46:50', b'1'),
(232, 41, '2022-04-01', 1, '665.00', '2022-09-15 15:57:55', b'0'),
(233, 41, '2022-04-16', 2, '665.00', '2022-09-15 15:57:55', b'0'),
(234, 41, '2022-05-03', 3, '665.00', '2022-09-01 14:57:14', b'1'),
(235, 41, '2022-05-16', 4, '665.00', '2022-09-01 14:57:14', b'1'),
(236, 41, '2022-05-31', 5, '665.00', '2022-09-01 14:57:14', b'1'),
(237, 41, '2022-06-15', 6, '665.00', '2022-09-01 14:57:14', b'1'),
(238, 41, '2022-06-30', 7, '665.00', '2022-09-01 14:57:14', b'1'),
(239, 41, '2022-07-15', 8, '665.00', '2022-09-01 14:57:14', b'1'),
(240, 41, '2022-07-30', 9, '665.00', '2022-09-01 14:57:14', b'1'),
(241, 41, '2022-08-16', 10, '665.00', '2022-09-01 14:57:14', b'1'),
(242, 42, '2022-07-07', 1, '670.00', '2022-09-01 15:00:03', b'1'),
(243, 42, '2022-07-22', 2, '670.00', '2022-09-01 15:00:03', b'1'),
(244, 42, '2022-08-06', 3, '670.00', '2022-09-01 15:00:03', b'1'),
(245, 42, '2022-08-23', 4, '670.00', '2022-09-01 15:00:03', b'1'),
(246, 43, '2021-12-09', 1, '449.20', '2022-09-01 15:04:36', b'1'),
(247, 43, '2021-12-16', 2, '449.20', '2022-09-01 15:04:36', b'1'),
(248, 43, '2021-12-23', 3, '449.20', '2022-09-01 15:04:36', b'1'),
(249, 43, '2021-12-30', 4, '449.20', '2022-09-01 15:04:36', b'1'),
(250, 43, '2022-01-06', 5, '449.20', '2022-09-01 15:04:36', b'1'),
(251, 43, '2022-01-13', 6, '449.20', '2022-09-01 15:04:36', b'1'),
(252, 43, '2022-01-20', 7, '449.20', '2022-09-01 15:04:36', b'1'),
(253, 43, '2022-01-27', 8, '449.20', '2022-09-01 15:04:36', b'1'),
(254, 43, '2022-02-03', 9, '449.20', '2022-09-01 15:04:36', b'1'),
(255, 43, '2022-02-10', 10, '449.20', '2022-09-01 15:04:36', b'1'),
(256, 43, '2022-02-17', 11, '449.20', '2022-09-01 15:04:36', b'1'),
(257, 43, '2022-02-24', 12, '449.20', '2022-09-01 15:04:36', b'1'),
(262, 45, '2022-07-23', 1, '1010.60', '2022-09-15 16:10:53', b'0'),
(263, 45, '2022-07-30', 2, '1010.60', '2022-09-01 15:20:04', b'1'),
(264, 45, '2022-08-06', 3, '1010.60', '2022-09-01 15:20:04', b'1'),
(265, 45, '2022-08-13', 4, '1010.60', '2022-09-01 15:20:04', b'1'),
(266, 45, '2022-08-20', 5, '1010.60', '2022-09-01 15:20:04', b'1'),
(267, 45, '2022-08-27', 6, '1010.60', '2022-09-01 15:20:04', b'1'),
(268, 45, '2022-09-03', 7, '1010.60', '2022-09-01 15:20:04', b'1'),
(269, 45, '2022-09-10', 8, '1010.60', '2022-09-01 15:20:04', b'1'),
(270, 45, '2022-09-17', 9, '1010.60', '2022-09-01 15:20:04', b'1'),
(271, 45, '2022-09-24', 10, '1010.60', '2022-09-01 15:20:04', b'1'),
(272, 45, '2022-10-01', 11, '1010.60', '2022-09-01 15:20:04', b'1'),
(273, 45, '2022-10-08', 12, '1010.60', '2022-09-01 15:20:04', b'1'),
(274, 45, '2022-10-15', 13, '1010.60', '2022-09-01 15:20:04', b'1'),
(275, 45, '2022-10-22', 14, '1010.60', '2022-09-01 15:20:04', b'1'),
(276, 45, '2022-10-29', 15, '1010.60', '2022-09-01 15:20:04', b'1'),
(277, 45, '2022-11-05', 16, '1010.60', '2022-09-01 15:20:04', b'1'),
(278, 45, '2022-11-12', 17, '1010.60', '2022-09-01 15:20:04', b'1'),
(279, 45, '2022-11-19', 18, '1010.60', '2022-09-01 15:20:04', b'1'),
(280, 45, '2022-11-26', 19, '1010.60', '2022-09-01 15:20:04', b'1'),
(281, 45, '2022-12-03', 20, '1010.60', '2022-09-01 15:20:04', b'1'),
(282, 46, '2022-07-21', 1, '892.50', '2022-09-01 15:23:26', b'1'),
(283, 46, '2022-07-28', 2, '892.50', '2022-09-01 15:23:26', b'1'),
(284, 46, '2022-08-04', 3, '892.50', '2022-09-01 15:23:26', b'1'),
(285, 46, '2022-08-11', 4, '892.50', '2022-09-01 15:23:26', b'1'),
(286, 46, '2022-08-18', 5, '892.50', '2022-09-01 15:23:26', b'1'),
(287, 46, '2022-08-25', 6, '892.50', '2022-09-01 15:23:26', b'1'),
(288, 46, '2022-09-01', 7, '892.50', '2022-09-01 15:23:26', b'1'),
(289, 46, '2022-09-08', 8, '892.50', '2022-09-01 15:23:26', b'1'),
(290, 46, '2022-09-15', 9, '892.50', '2022-09-01 15:23:26', b'1'),
(291, 46, '2022-09-22', 10, '892.50', '2022-09-01 15:23:26', b'1'),
(292, 46, '2022-09-29', 11, '892.50', '2022-09-01 15:23:26', b'1'),
(293, 46, '2022-10-06', 12, '892.50', '2022-09-01 15:23:26', b'1'),
(294, 46, '2022-10-13', 13, '892.50', '2022-09-01 15:23:26', b'1'),
(295, 46, '2022-10-20', 14, '892.50', '2022-09-01 15:23:26', b'1'),
(296, 46, '2022-10-27', 15, '892.50', '2022-09-01 15:23:26', b'1'),
(297, 46, '2022-11-03', 16, '892.50', '2022-09-01 15:23:26', b'1'),
(298, 46, '2022-11-10', 17, '892.50', '2022-09-01 15:23:26', b'1'),
(299, 46, '2022-11-17', 18, '892.50', '2022-09-01 15:23:26', b'1'),
(300, 46, '2022-11-24', 19, '892.50', '2022-09-01 15:23:26', b'1'),
(301, 46, '2022-12-01', 20, '892.50', '2022-09-01 15:23:26', b'1'),
(302, 47, '2021-10-06', 1, '510.00', '2022-09-21 14:55:44', b'0'),
(303, 47, '2021-10-13', 2, '510.00', '2022-09-21 14:55:44', b'0'),
(304, 47, '2021-10-20', 3, '510.00', '2022-09-21 14:55:44', b'0'),
(305, 47, '2021-10-27', 4, '510.00', '2022-09-21 14:55:44', b'0'),
(306, 47, '2021-11-03', 5, '510.00', '2022-09-21 14:55:44', b'0'),
(307, 47, '2021-11-10', 6, '510.00', '2022-09-21 14:55:44', b'0'),
(308, 47, '2021-11-17', 7, '510.00', '2022-09-21 14:55:44', b'0'),
(309, 47, '2021-11-24', 8, '510.00', '2022-09-01 15:36:40', b'1'),
(310, 48, '2022-08-02', 1, '665.00', '2022-09-15 20:26:56', b'0'),
(311, 48, '2022-08-15', 2, '665.00', '2022-09-15 20:26:56', b'0'),
(312, 48, '2022-08-30', 3, '665.00', '2022-09-01 15:41:35', b'1'),
(313, 48, '2022-09-14', 4, '665.00', '2022-09-01 15:41:35', b'1'),
(314, 48, '2022-09-29', 5, '665.00', '2022-09-01 15:41:35', b'1'),
(315, 48, '2022-10-14', 6, '665.00', '2022-09-01 15:41:35', b'1'),
(316, 48, '2022-10-29', 7, '665.00', '2022-09-01 15:41:35', b'1'),
(317, 48, '2022-11-15', 8, '665.00', '2022-09-01 15:41:35', b'1'),
(318, 48, '2022-11-28', 9, '665.00', '2022-09-01 15:41:35', b'1'),
(319, 48, '2022-12-13', 10, '665.00', '2022-09-01 15:41:35', b'1'),
(320, 49, '2022-05-03', 1, '1235.00', '2022-09-01 15:47:28', b'1'),
(321, 49, '2022-05-18', 2, '1235.00', '2022-09-01 15:47:28', b'1'),
(322, 49, '2022-06-02', 3, '1235.00', '2022-09-01 15:47:28', b'1'),
(323, 49, '2022-06-17', 4, '1235.00', '2022-09-01 15:47:28', b'1'),
(324, 49, '2022-07-02', 5, '1235.00', '2022-09-01 15:47:28', b'1'),
(325, 49, '2022-07-19', 6, '1235.00', '2022-09-01 15:47:28', b'1'),
(326, 49, '2022-08-01', 7, '1235.00', '2022-09-01 15:47:28', b'1'),
(327, 49, '2022-08-16', 8, '1235.00', '2022-09-01 15:47:28', b'1'),
(328, 49, '2022-08-31', 9, '1235.00', '2022-09-01 15:47:28', b'1'),
(329, 49, '2022-09-15', 10, '1235.00', '2022-09-01 15:47:28', b'1'),
(330, 50, '2022-02-05', 1, '1584.60', '2022-09-14 14:45:48', b'0'),
(331, 50, '2022-03-05', 2, '1584.60', '2022-09-01 15:47:37', b'1'),
(332, 50, '2022-04-05', 3, '1584.60', '2022-09-01 15:47:37', b'1'),
(333, 50, '2022-05-05', 4, '1584.60', '2022-09-01 15:47:37', b'1'),
(334, 50, '2022-06-07', 5, '1584.60', '2022-09-01 15:47:37', b'1'),
(335, 51, '2022-09-01', 1, '770.00', '2022-09-15 20:27:31', b'0'),
(336, 51, '2022-09-16', 2, '770.00', '2022-09-01 15:51:40', b'1'),
(337, 51, '2022-10-01', 3, '770.00', '2022-09-01 15:51:40', b'1'),
(338, 51, '2022-10-18', 4, '770.00', '2022-09-01 15:51:40', b'1'),
(339, 51, '2022-10-31', 5, '770.00', '2022-09-01 15:51:40', b'1'),
(340, 51, '2022-11-15', 6, '770.00', '2022-09-01 15:51:40', b'1'),
(341, 52, '2022-05-31', 1, '510.00', '2022-09-14 15:01:46', b'0'),
(342, 52, '2022-06-15', 2, '510.00', '2022-09-01 15:56:24', b'1'),
(343, 52, '2022-06-30', 3, '510.00', '2022-09-01 15:56:25', b'1'),
(344, 52, '2022-07-15', 4, '510.00', '2022-09-01 15:56:25', b'1'),
(345, 53, '2022-08-31', 1, '2065.00', '2022-09-01 15:59:10', b'1'),
(346, 53, '2022-09-15', 2, '2065.00', '2022-09-01 15:59:10', b'1'),
(347, 54, '2022-09-09', 1, '641.70', '2022-09-15 20:28:15', b'0'),
(348, 54, '2022-09-24', 2, '641.70', '2022-09-01 16:03:35', b'1'),
(349, 54, '2022-10-11', 3, '641.70', '2022-09-01 16:03:35', b'1'),
(350, 54, '2022-10-24', 4, '641.70', '2022-09-01 16:03:35', b'1'),
(351, 54, '2022-11-08', 5, '641.70', '2022-09-01 16:03:35', b'1'),
(352, 54, '2022-11-23', 6, '641.70', '2022-09-01 16:03:35', b'1'),
(353, 55, '2022-08-23', 1, '580.00', '2022-09-01 19:18:50', b'1'),
(354, 55, '2022-09-07', 2, '580.00', '2022-09-01 19:18:50', b'1'),
(355, 56, '2022-08-19', 1, '385.00', '2022-09-01 19:23:40', b'1'),
(356, 56, '2022-09-03', 2, '385.00', '2022-09-01 19:23:40', b'1'),
(357, 56, '2022-09-20', 3, '385.00', '2022-09-01 19:23:40', b'1'),
(358, 56, '2022-10-03', 4, '385.00', '2022-09-01 19:23:40', b'1'),
(359, 56, '2022-10-18', 5, '385.00', '2022-09-01 19:23:40', b'1'),
(360, 56, '2022-11-02', 6, '385.00', '2022-09-01 19:23:40', b'1'),
(361, 57, '2022-06-22', 1, '322.50', '2022-09-14 15:21:25', b'0'),
(362, 57, '2022-07-07', 2, '322.50', '2022-09-14 15:21:25', b'0'),
(363, 57, '2022-07-22', 3, '322.50', '2022-09-14 15:21:25', b'0'),
(364, 57, '2022-08-06', 4, '322.50', '2022-09-14 15:21:25', b'0'),
(365, 57, '2022-08-23', 5, '322.50', '2022-09-14 15:21:25', b'0'),
(366, 57, '2022-09-05', 6, '322.50', '2022-09-14 15:21:25', b'0'),
(367, 57, '2022-09-20', 7, '322.50', '2022-09-01 19:32:52', b'1'),
(368, 57, '2022-10-05', 8, '322.50', '2022-09-01 19:32:52', b'1'),
(369, 58, '2022-06-01', 1, '385.00', '2022-09-14 15:22:51', b'0'),
(370, 58, '2022-06-16', 2, '385.00', '2022-09-01 19:42:18', b'1'),
(371, 58, '2022-07-01', 3, '385.00', '2022-09-01 19:42:18', b'1'),
(372, 58, '2022-07-16', 4, '385.00', '2022-09-01 19:42:18', b'1'),
(373, 58, '2022-08-02', 5, '385.00', '2022-09-01 19:42:18', b'1'),
(374, 58, '2022-08-15', 6, '385.00', '2022-09-01 19:42:18', b'1'),
(375, 59, '2022-03-21', 1, '513.30', '2022-09-01 19:42:23', b'1'),
(376, 59, '2022-03-28', 2, '513.30', '2022-09-01 19:42:23', b'1'),
(377, 59, '2022-04-04', 3, '513.30', '2022-09-01 19:42:23', b'1'),
(378, 59, '2022-04-11', 4, '513.30', '2022-09-01 19:42:23', b'1'),
(379, 59, '2022-04-18', 5, '513.30', '2022-09-01 19:42:23', b'1'),
(380, 59, '2022-04-25', 6, '513.30', '2022-09-01 19:42:23', b'1'),
(381, 59, '2022-05-02', 7, '513.30', '2022-09-01 19:42:23', b'1'),
(382, 59, '2022-05-09', 8, '513.30', '2022-09-01 19:42:23', b'1'),
(383, 59, '2022-05-16', 9, '513.30', '2022-09-01 19:42:23', b'1'),
(384, 59, '2022-05-23', 10, '513.30', '2022-09-01 19:42:23', b'1'),
(385, 59, '2022-05-30', 11, '513.30', '2022-09-01 19:42:23', b'1'),
(386, 59, '2022-06-06', 12, '513.30', '2022-09-01 19:42:23', b'1'),
(387, 60, '2022-08-12', 1, '590.00', '2022-09-14 15:23:13', b'0'),
(388, 60, '2022-08-27', 2, '590.00', '2022-09-01 19:47:33', b'1'),
(389, 61, '2022-05-02', 1, '292.60', '2022-09-14 16:06:21', b'0'),
(390, 61, '2022-05-09', 2, '292.60', '2022-09-14 16:06:21', b'0'),
(391, 61, '2022-05-16', 3, '292.60', '2022-09-14 16:06:21', b'0'),
(392, 61, '2022-05-23', 4, '292.60', '2022-09-01 19:54:00', b'1'),
(393, 61, '2022-05-30', 5, '292.60', '2022-09-01 19:54:00', b'1'),
(394, 61, '2022-06-06', 6, '292.60', '2022-09-01 19:54:00', b'1'),
(395, 61, '2022-06-13', 7, '292.60', '2022-09-01 19:54:00', b'1'),
(396, 61, '2022-06-20', 8, '292.60', '2022-09-01 19:54:00', b'1'),
(397, 61, '2022-06-27', 9, '292.60', '2022-09-01 19:54:00', b'1'),
(398, 61, '2022-07-04', 10, '292.60', '2022-09-01 19:54:00', b'1'),
(399, 61, '2022-07-11', 11, '292.60', '2022-09-01 19:54:00', b'1'),
(400, 61, '2022-07-18', 12, '292.60', '2022-09-01 19:54:00', b'1'),
(401, 62, '2022-08-06', 1, '680.00', '2022-09-15 19:32:30', b'0'),
(402, 62, '2022-08-23', 2, '680.00', '2022-09-01 20:01:59', b'1'),
(403, 62, '2022-09-05', 3, '680.00', '2022-09-01 20:01:59', b'1'),
(404, 62, '2022-09-20', 4, '680.00', '2022-09-01 20:01:59', b'1'),
(405, 63, '2022-08-31', 1, '340.00', '2022-09-01 20:09:26', b'1'),
(406, 63, '2022-09-15', 2, '340.00', '2022-09-01 20:09:26', b'1'),
(407, 63, '2022-09-30', 3, '340.00', '2022-09-01 20:09:26', b'1'),
(408, 63, '2022-10-15', 4, '340.00', '2022-09-01 20:09:26', b'1'),
(409, 64, '2022-09-06', 1, '264.00', '2022-09-14 15:24:08', b'0'),
(410, 64, '2022-09-21', 2, '264.00', '2022-09-01 20:12:15', b'1'),
(411, 64, '2022-10-06', 3, '264.00', '2022-09-01 20:12:15', b'1'),
(412, 64, '2022-10-21', 4, '264.00', '2022-09-01 20:12:15', b'1'),
(413, 65, '2022-08-24', 1, '680.00', '2022-09-01 20:14:41', b'1'),
(414, 65, '2022-09-08', 2, '680.00', '2022-09-01 20:14:41', b'1'),
(415, 65, '2022-09-23', 3, '680.00', '2022-09-01 20:14:41', b'1'),
(416, 65, '2022-10-08', 4, '680.00', '2022-09-01 20:14:41', b'1'),
(417, 66, '2022-07-26', 1, '475.00', '2022-09-01 20:22:49', b'1'),
(418, 66, '2022-08-10', 2, '475.00', '2022-09-01 20:22:49', b'1'),
(419, 66, '2022-08-25', 3, '475.00', '2022-09-01 20:22:49', b'1'),
(420, 66, '2022-09-09', 4, '475.00', '2022-09-01 20:22:49', b'1'),
(421, 67, '2022-07-26', 1, '250.60', '2022-09-01 20:24:41', b'0'),
(422, 67, '2022-08-02', 2, '250.60', '2022-09-01 20:25:08', b'0'),
(423, 67, '2022-08-09', 3, '250.60', '2022-09-01 20:25:30', b'0'),
(424, 67, '2022-08-16', 4, '250.60', '2022-09-01 20:22:54', b'1'),
(425, 67, '2022-08-23', 5, '250.60', '2022-09-01 20:22:54', b'1'),
(426, 67, '2022-08-30', 6, '250.60', '2022-09-01 20:22:54', b'1'),
(427, 67, '2022-09-06', 7, '250.60', '2022-09-01 20:22:54', b'1'),
(428, 67, '2022-09-13', 8, '250.60', '2022-09-01 20:22:54', b'1'),
(429, 68, '2022-08-24', 1, '1255.90', '2022-09-01 20:24:08', b'1'),
(430, 68, '2022-09-08', 2, '1255.90', '2022-09-01 20:24:08', b'1'),
(431, 68, '2022-09-23', 3, '1255.90', '2022-09-01 20:24:08', b'1'),
(432, 68, '2022-10-08', 4, '1255.90', '2022-09-01 20:24:08', b'1'),
(433, 69, '2022-02-11', 1, '449.20', '2022-09-01 20:30:37', b'0'),
(434, 69, '2022-02-18', 2, '449.20', '2022-09-01 20:30:51', b'0'),
(435, 69, '2022-02-25', 3, '449.20', '2022-09-01 20:31:10', b'0'),
(436, 69, '2022-03-04', 4, '449.20', '2022-09-01 20:31:22', b'0'),
(437, 69, '2022-03-11', 5, '449.20', '2022-09-01 20:31:35', b'0'),
(438, 69, '2022-03-18', 6, '449.20', '2022-09-01 20:32:01', b'0'),
(439, 69, '2022-03-25', 7, '449.20', '2022-09-01 20:32:19', b'0'),
(440, 69, '2022-04-01', 8, '449.20', '2022-09-01 20:30:03', b'1'),
(441, 69, '2022-04-08', 9, '449.20', '2022-09-01 20:30:03', b'1'),
(442, 69, '2022-04-15', 10, '449.20', '2022-09-01 20:30:03', b'1'),
(443, 69, '2022-04-22', 11, '449.20', '2022-09-01 20:30:03', b'1'),
(444, 69, '2022-04-29', 12, '449.20', '2022-09-01 20:30:03', b'1'),
(445, 70, '2022-05-17', 1, '256.70', '2022-09-01 20:39:05', b'0'),
(446, 70, '2022-05-24', 2, '256.70', '2022-09-01 20:39:17', b'0'),
(447, 70, '2022-05-31', 3, '256.70', '2022-09-01 20:39:27', b'0'),
(448, 70, '2022-06-07', 4, '256.70', '2022-09-01 20:39:40', b'0'),
(449, 70, '2022-06-14', 5, '256.70', '2022-09-01 20:40:22', b'0'),
(450, 70, '2022-06-21', 6, '256.70', '2022-09-01 20:40:34', b'0'),
(451, 70, '2022-06-28', 7, '256.70', '2022-09-01 20:38:28', b'1'),
(452, 70, '2022-07-05', 8, '256.70', '2022-09-01 20:38:28', b'1'),
(453, 70, '2022-07-12', 9, '256.70', '2022-09-01 20:38:28', b'1'),
(454, 70, '2022-07-19', 10, '256.70', '2022-09-01 20:38:28', b'1'),
(455, 70, '2022-07-26', 11, '256.70', '2022-09-01 20:38:28', b'1'),
(456, 70, '2022-08-02', 12, '256.70', '2022-09-01 20:38:28', b'1'),
(457, 71, '2022-07-20', 1, '987.50', '2022-09-01 20:39:15', b'1'),
(458, 71, '2022-08-04', 2, '987.50', '2022-09-01 20:39:15', b'1'),
(459, 71, '2022-08-19', 3, '987.50', '2022-09-01 20:39:15', b'1'),
(460, 71, '2022-09-03', 4, '987.50', '2022-09-01 20:39:15', b'1'),
(461, 71, '2022-09-20', 5, '987.50', '2022-09-01 20:39:15', b'1'),
(462, 71, '2022-10-03', 6, '987.50', '2022-09-01 20:39:15', b'1'),
(463, 71, '2022-10-18', 7, '987.50', '2022-09-01 20:39:15', b'1'),
(464, 71, '2022-11-02', 8, '987.50', '2022-09-01 20:39:15', b'1'),
(471, 73, '2022-04-01', 1, '513.30', '2022-09-14 16:07:45', b'0'),
(472, 73, '2022-04-16', 2, '513.30', '2022-09-14 16:07:45', b'0'),
(473, 73, '2022-05-03', 3, '513.30', '2022-09-14 16:07:45', b'0'),
(474, 73, '2022-05-16', 4, '513.30', '2022-09-01 21:07:19', b'1'),
(475, 73, '2022-05-31', 5, '513.30', '2022-09-01 21:07:19', b'1'),
(476, 73, '2022-06-15', 6, '513.30', '2022-09-01 21:07:19', b'1'),
(477, 74, '2022-01-03', 1, '332.50', '2022-09-14 16:11:29', b'0'),
(478, 74, '2022-01-10', 2, '332.50', '2022-09-14 16:11:29', b'0'),
(479, 74, '2022-01-17', 3, '332.50', '2022-09-14 16:11:29', b'0'),
(480, 74, '2022-01-24', 4, '332.50', '2022-09-01 21:15:55', b'1'),
(481, 74, '2022-01-31', 5, '332.50', '2022-09-01 21:15:55', b'1'),
(482, 74, '2022-02-07', 6, '332.50', '2022-09-01 21:15:55', b'1'),
(483, 74, '2022-02-14', 7, '332.50', '2022-09-01 21:15:55', b'1'),
(484, 74, '2022-02-21', 8, '332.50', '2022-09-01 21:15:55', b'1'),
(485, 74, '2022-02-28', 9, '332.50', '2022-09-01 21:15:55', b'1'),
(486, 74, '2022-03-07', 10, '332.50', '2022-09-01 21:15:55', b'1'),
(487, 74, '2022-03-14', 11, '332.50', '2022-09-01 21:15:55', b'1'),
(488, 74, '2022-03-21', 12, '332.50', '2022-09-01 21:15:55', b'1'),
(489, 74, '2022-03-28', 13, '332.50', '2022-09-01 21:15:55', b'1'),
(490, 74, '2022-04-04', 14, '332.50', '2022-09-01 21:15:55', b'1'),
(491, 74, '2022-04-11', 15, '332.50', '2022-09-01 21:15:55', b'1'),
(492, 74, '2022-04-18', 16, '332.50', '2022-09-01 21:15:55', b'1'),
(493, 74, '2022-04-25', 17, '332.50', '2022-09-01 21:15:55', b'1'),
(494, 74, '2022-05-02', 18, '332.50', '2022-09-01 21:15:55', b'1'),
(495, 74, '2022-05-09', 19, '332.50', '2022-09-01 21:15:55', b'1'),
(496, 74, '2022-05-16', 20, '332.50', '2022-09-01 21:15:55', b'1'),
(497, 75, '2022-05-17', 1, '513.30', '2022-09-02 13:00:56', b'1'),
(498, 75, '2022-05-24', 2, '513.30', '2022-09-02 13:00:56', b'1'),
(499, 75, '2022-05-31', 3, '513.30', '2022-09-02 13:00:56', b'1'),
(500, 75, '2022-06-07', 4, '513.30', '2022-09-02 13:00:56', b'1'),
(501, 75, '2022-06-14', 5, '513.30', '2022-09-02 13:00:56', b'1'),
(502, 75, '2022-06-21', 6, '513.30', '2022-09-02 13:00:56', b'1'),
(503, 75, '2022-06-28', 7, '513.30', '2022-09-02 13:00:56', b'1'),
(504, 75, '2022-07-05', 8, '513.30', '2022-09-02 13:00:56', b'1'),
(505, 75, '2022-07-12', 9, '513.30', '2022-09-02 13:00:56', b'1'),
(506, 75, '2022-07-19', 10, '513.30', '2022-09-02 13:00:56', b'1'),
(507, 75, '2022-07-26', 11, '513.30', '2022-09-02 13:00:56', b'1'),
(508, 75, '2022-08-02', 12, '513.30', '2022-09-02 13:00:56', b'1'),
(509, 76, '2022-02-15', 1, '475.00', '2022-09-14 20:00:49', b'0'),
(510, 76, '2022-02-28', 2, '475.00', '2022-09-14 20:00:49', b'0'),
(511, 76, '2022-03-15', 3, '475.00', '2022-09-14 20:00:49', b'0'),
(512, 76, '2022-03-30', 4, '475.00', '2022-09-02 13:25:22', b'1'),
(513, 76, '2022-04-14', 5, '475.00', '2022-09-02 13:25:22', b'1'),
(514, 76, '2022-04-29', 6, '475.00', '2022-09-02 13:25:22', b'1'),
(515, 76, '2022-05-14', 7, '475.00', '2022-09-02 13:25:22', b'1'),
(516, 76, '2022-05-31', 8, '475.00', '2022-09-02 13:25:22', b'1'),
(517, 76, '2022-06-13', 9, '475.00', '2022-09-02 13:25:22', b'1'),
(518, 76, '2022-06-28', 10, '475.00', '2022-09-02 13:25:22', b'1'),
(519, 77, '2022-05-18', 1, '359.00', '2022-09-14 20:02:14', b'0'),
(520, 77, '2022-05-25', 2, '359.00', '2022-09-02 13:32:34', b'1'),
(521, 77, '2022-06-01', 3, '359.00', '2022-09-02 13:32:34', b'1'),
(522, 77, '2022-06-08', 4, '359.00', '2022-09-02 13:32:34', b'1'),
(523, 77, '2022-06-15', 5, '359.00', '2022-09-02 13:32:34', b'1'),
(524, 77, '2022-06-22', 6, '359.00', '2022-09-02 13:32:34', b'1'),
(525, 77, '2022-06-29', 7, '359.00', '2022-09-02 13:32:34', b'1'),
(526, 77, '2022-07-06', 8, '359.00', '2022-09-02 13:32:34', b'1'),
(527, 78, '2022-06-25', 1, '537.50', '2022-09-14 20:07:05', b'0'),
(528, 78, '2022-07-12', 2, '537.50', '2022-09-14 20:07:05', b'0'),
(529, 78, '2022-07-25', 3, '537.50', '2022-09-14 20:07:05', b'0'),
(530, 78, '2022-08-09', 4, '537.50', '2022-09-14 20:07:05', b'0'),
(531, 78, '2022-08-24', 5, '537.50', '2022-09-14 20:07:05', b'0'),
(532, 78, '2022-09-08', 6, '537.50', '2022-09-02 13:43:19', b'1'),
(533, 78, '2022-09-23', 7, '537.50', '2022-09-02 13:43:19', b'1'),
(534, 78, '2022-10-08', 8, '537.50', '2022-09-02 13:43:19', b'1'),
(535, 79, '2022-08-10', 1, '570.00', '2022-09-14 21:40:48', b'0'),
(536, 79, '2022-08-25', 2, '570.00', '2022-09-14 21:40:48', b'0'),
(537, 79, '2022-09-09', 3, '570.00', '2022-09-02 14:17:56', b'1'),
(538, 79, '2022-09-24', 4, '570.00', '2022-09-02 14:17:56', b'1'),
(539, 79, '2022-10-11', 5, '570.00', '2022-09-02 14:17:56', b'1'),
(540, 79, '2022-10-24', 6, '570.00', '2022-09-02 14:17:56', b'1'),
(541, 79, '2022-11-08', 7, '570.00', '2022-09-02 14:17:56', b'1'),
(542, 79, '2022-11-23', 8, '570.00', '2022-09-02 14:17:56', b'1'),
(543, 79, '2022-12-08', 9, '570.00', '2022-09-02 14:17:56', b'1'),
(544, 79, '2022-12-23', 10, '570.00', '2022-09-02 14:17:56', b'1'),
(545, 80, '2022-09-01', 1, '770.00', '2022-09-02 14:29:24', b'1'),
(546, 80, '2022-09-16', 2, '770.00', '2022-09-02 14:29:24', b'1'),
(547, 80, '2022-10-01', 3, '770.00', '2022-09-02 14:29:24', b'1'),
(548, 80, '2022-10-18', 4, '770.00', '2022-09-02 14:29:24', b'1'),
(549, 80, '2022-10-31', 5, '770.00', '2022-09-02 14:29:24', b'1'),
(550, 80, '2022-11-15', 6, '770.00', '2022-09-02 14:29:24', b'1'),
(551, 81, '2022-08-31', 1, '692.00', '2022-09-02 14:54:37', b'1'),
(552, 81, '2022-09-15', 2, '692.00', '2022-09-02 14:54:37', b'1'),
(553, 81, '2022-09-30', 3, '692.00', '2022-09-02 14:54:37', b'1'),
(554, 81, '2022-10-15', 4, '692.00', '2022-09-02 14:54:37', b'1'),
(555, 81, '2022-11-01', 5, '692.00', '2022-09-02 14:54:37', b'1'),
(556, 81, '2022-11-14', 6, '692.00', '2022-09-02 14:54:37', b'1'),
(557, 82, '2022-08-20', 1, '493.30', '2022-09-02 14:54:50', b'1'),
(558, 82, '2022-09-06', 2, '493.30', '2022-09-02 14:54:50', b'1'),
(559, 82, '2022-09-19', 3, '493.30', '2022-09-02 14:54:50', b'1'),
(560, 82, '2022-10-04', 4, '493.30', '2022-09-02 14:54:50', b'1'),
(561, 82, '2022-10-19', 5, '493.30', '2022-09-02 14:54:50', b'1'),
(562, 82, '2022-11-03', 6, '493.30', '2022-09-02 14:54:50', b'1'),
(575, 84, '2022-06-15', 1, '875.00', '2022-09-02 15:09:17', b'0'),
(576, 84, '2022-06-22', 2, '875.00', '2022-09-02 15:09:29', b'0'),
(577, 84, '2022-06-29', 3, '875.00', '2022-09-02 15:08:36', b'1'),
(578, 84, '2022-07-06', 4, '875.00', '2022-09-02 15:08:36', b'1'),
(579, 84, '2022-07-13', 5, '875.00', '2022-09-02 15:08:36', b'1'),
(580, 84, '2022-07-20', 6, '875.00', '2022-09-02 15:08:36', b'1'),
(581, 84, '2022-07-27', 7, '875.00', '2022-09-02 15:08:36', b'1'),
(582, 84, '2022-08-03', 8, '875.00', '2022-09-02 15:08:36', b'1'),
(583, 84, '2022-08-10', 9, '875.00', '2022-09-02 15:08:36', b'1'),
(584, 84, '2022-08-17', 10, '875.00', '2022-09-02 15:08:36', b'1'),
(585, 84, '2022-08-24', 11, '875.00', '2022-09-02 15:08:36', b'1'),
(586, 84, '2022-08-31', 12, '875.00', '2022-09-02 15:08:36', b'1'),
(587, 84, '2022-09-07', 13, '875.00', '2022-09-02 15:08:36', b'1'),
(588, 84, '2022-09-14', 14, '875.00', '2022-09-02 15:08:36', b'1'),
(589, 84, '2022-09-21', 15, '875.00', '2022-09-02 15:08:36', b'1'),
(590, 84, '2022-09-28', 16, '875.00', '2022-09-02 15:08:36', b'1'),
(591, 84, '2022-10-05', 17, '875.00', '2022-09-02 15:08:36', b'1'),
(592, 84, '2022-10-12', 18, '875.00', '2022-09-02 15:08:36', b'1'),
(593, 84, '2022-10-19', 19, '875.00', '2022-09-02 15:08:36', b'1'),
(594, 84, '2022-10-26', 20, '875.00', '2022-09-02 15:08:36', b'1'),
(595, 85, '2022-07-20', 1, '449.20', '2022-09-02 15:19:16', b'0'),
(596, 85, '2022-07-27', 2, '449.20', '2022-09-02 15:20:19', b'0'),
(597, 85, '2022-08-03', 3, '449.20', '2022-09-02 15:20:31', b'0'),
(598, 85, '2022-08-10', 4, '449.20', '2022-09-02 15:20:46', b'0'),
(599, 85, '2022-08-17', 5, '449.20', '2022-09-02 15:25:00', b'0'),
(600, 85, '2022-08-24', 6, '449.20', '2022-09-02 15:18:55', b'1'),
(601, 85, '2022-08-31', 7, '449.20', '2022-09-02 15:18:55', b'1'),
(602, 85, '2022-09-07', 8, '449.20', '2022-09-02 15:18:55', b'1'),
(603, 85, '2022-09-14', 9, '449.20', '2022-09-02 15:18:55', b'1'),
(604, 85, '2022-09-21', 10, '449.20', '2022-09-02 15:18:55', b'1'),
(605, 85, '2022-09-28', 11, '449.20', '2022-09-02 15:18:55', b'1'),
(606, 85, '2022-10-05', 12, '449.20', '2022-09-02 15:18:55', b'1'),
(607, 86, '2022-07-20', 1, '256.70', '2022-09-02 15:50:51', b'0'),
(608, 86, '2022-07-27', 2, '256.70', '2022-09-02 15:51:02', b'0'),
(609, 86, '2022-08-03', 3, '256.70', '2022-09-02 15:51:16', b'0'),
(610, 86, '2022-08-10', 4, '256.70', '2022-09-02 15:51:30', b'0'),
(611, 86, '2022-08-17', 5, '256.70', '2022-09-02 15:52:12', b'0'),
(612, 86, '2022-08-24', 6, '256.70', '2022-09-02 15:52:35', b'0'),
(613, 86, '2022-08-31', 7, '256.70', '2022-09-15 20:07:00', b'0'),
(614, 86, '2022-09-07', 8, '256.70', '2022-09-15 20:07:35', b'0'),
(615, 86, '2022-09-14', 9, '256.70', '2022-09-15 21:27:50', b'0'),
(616, 86, '2022-09-21', 10, '256.70', '2022-09-02 15:50:02', b'1'),
(617, 86, '2022-09-28', 11, '256.70', '2022-09-02 15:50:02', b'1'),
(618, 86, '2022-10-05', 12, '256.70', '2022-09-02 15:50:02', b'1'),
(619, 87, '2022-07-27', 1, '320.80', '2022-09-02 16:00:43', b'0'),
(620, 87, '2022-08-03', 2, '320.80', '2022-09-02 16:00:56', b'0'),
(621, 87, '2022-08-10', 3, '320.80', '2022-09-02 16:01:08', b'0'),
(622, 87, '2022-08-17', 4, '320.80', '2022-09-02 16:01:19', b'0'),
(623, 87, '2022-08-24', 5, '320.80', '2022-09-02 16:01:32', b'0'),
(624, 87, '2022-08-31', 6, '320.80', '2022-09-15 20:09:51', b'0'),
(625, 87, '2022-09-07', 7, '320.80', '2022-09-15 20:10:12', b'0'),
(626, 87, '2022-09-14', 8, '320.80', '2022-09-02 15:59:51', b'1'),
(627, 87, '2022-09-21', 9, '320.80', '2022-09-02 15:59:51', b'1'),
(628, 87, '2022-09-28', 10, '320.80', '2022-09-02 15:59:51', b'1'),
(629, 87, '2022-10-05', 11, '320.80', '2022-09-02 15:59:51', b'1'),
(630, 87, '2022-10-12', 12, '320.80', '2022-09-02 15:59:51', b'1'),
(631, 88, '2022-08-09', 1, '898.30', '2022-09-02 18:48:40', b'0'),
(632, 88, '2022-08-24', 2, '898.30', '2022-09-02 18:49:20', b'0'),
(633, 88, '2022-09-08', 3, '898.30', '2022-09-15 20:11:38', b'0'),
(634, 88, '2022-09-23', 4, '898.30', '2022-09-02 18:48:07', b'1'),
(635, 88, '2022-10-08', 5, '898.30', '2022-09-02 18:48:07', b'1'),
(636, 88, '2022-10-25', 6, '898.30', '2022-09-02 18:48:07', b'1'),
(637, 89, '2022-08-12', 1, '513.30', '2022-09-02 18:55:23', b'0'),
(638, 89, '2022-08-27', 2, '513.30', '2022-09-02 18:55:36', b'0'),
(639, 89, '2022-09-13', 3, '513.30', '2022-09-15 20:13:01', b'0'),
(640, 89, '2022-09-26', 4, '513.30', '2022-09-02 18:54:18', b'1'),
(641, 89, '2022-10-11', 5, '513.30', '2022-09-02 18:54:18', b'1'),
(642, 89, '2022-10-26', 6, '513.30', '2022-09-02 18:54:18', b'1'),
(643, 90, '2022-08-18', 1, '1450.00', '2022-09-02 19:01:42', b'0'),
(644, 90, '2022-09-02', 2, '1450.00', '2022-09-15 20:14:54', b'0'),
(645, 90, '2022-09-17', 3, '1450.00', '2022-09-02 19:01:26', b'1'),
(646, 90, '2022-10-04', 4, '1450.00', '2022-09-02 19:01:26', b'1'),
(647, 90, '2022-10-17', 5, '1450.00', '2022-09-02 19:01:26', b'1'),
(648, 90, '2022-11-01', 6, '1450.00', '2022-09-02 19:01:26', b'1'),
(649, 91, '2022-08-18', 1, '898.30', '2022-09-02 19:05:10', b'0'),
(650, 91, '2022-09-02', 2, '898.30', '2022-09-15 20:16:06', b'0'),
(651, 91, '2022-09-17', 3, '898.30', '2022-09-02 19:04:52', b'1'),
(652, 91, '2022-10-04', 4, '898.30', '2022-09-02 19:04:52', b'1'),
(653, 91, '2022-10-17', 5, '898.30', '2022-09-02 19:04:53', b'1'),
(654, 91, '2022-11-01', 6, '898.30', '2022-09-02 19:04:53', b'1'),
(655, 92, '2022-08-30', 1, '898.30', '2022-09-02 19:13:22', b'0'),
(656, 92, '2022-09-12', 2, '898.30', '2022-09-15 21:31:09', b'0'),
(657, 92, '2022-09-27', 3, '898.30', '2022-09-02 19:12:46', b'1'),
(658, 92, '2022-10-12', 4, '898.30', '2022-09-02 19:12:46', b'1'),
(659, 92, '2022-10-27', 5, '898.30', '2022-09-02 19:12:46', b'1'),
(660, 92, '2022-11-11', 6, '898.30', '2022-09-02 19:12:46', b'1'),
(661, 93, '2022-08-30', 1, '898.30', '2022-09-02 19:20:49', b'1'),
(662, 93, '2022-09-14', 2, '898.30', '2022-09-02 19:20:49', b'1'),
(663, 93, '2022-09-29', 3, '898.30', '2022-09-02 19:20:49', b'1'),
(664, 93, '2022-10-14', 4, '898.30', '2022-09-02 19:20:49', b'1'),
(665, 93, '2022-10-29', 5, '898.30', '2022-09-02 19:20:49', b'1'),
(666, 93, '2022-11-15', 6, '898.30', '2022-09-02 19:20:49', b'1'),
(667, 94, '2022-09-02', 1, '641.70', '2022-09-15 22:13:23', b'0'),
(668, 94, '2022-09-17', 2, '641.70', '2022-09-02 19:25:18', b'1'),
(669, 94, '2022-10-04', 3, '641.70', '2022-09-02 19:25:18', b'1'),
(670, 94, '2022-10-17', 4, '641.70', '2022-09-02 19:25:18', b'1'),
(671, 94, '2022-11-01', 5, '641.70', '2022-09-02 19:25:18', b'1'),
(672, 94, '2022-11-16', 6, '641.70', '2022-09-02 19:25:18', b'1'),
(673, 95, '2022-08-03', 1, '3206.70', '2022-09-02 19:37:15', b'0'),
(674, 95, '2022-08-18', 2, '3206.70', '2022-09-02 19:37:15', b'0'),
(675, 95, '2022-09-02', 3, '3206.70', '2022-09-02 19:25:39', b'1'),
(676, 95, '2022-09-17', 4, '3206.70', '2022-09-02 19:25:39', b'1'),
(677, 95, '2022-10-04', 5, '3206.70', '2022-09-02 19:25:39', b'1'),
(678, 95, '2022-10-17', 6, '3206.70', '2022-09-02 19:25:39', b'1'),
(685, 97, '2022-09-09', 1, '150.00', '2022-09-15 20:45:48', b'0'),
(686, 97, '2022-09-16', 2, '150.00', '2022-09-02 22:03:01', b'1'),
(687, 97, '2022-09-23', 3, '150.00', '2022-09-02 22:03:01', b'1'),
(688, 97, '2022-09-30', 4, '150.00', '2022-09-02 22:03:01', b'1'),
(689, 98, '2022-08-17', 1, '1726.70', '2022-09-02 22:33:03', b'0'),
(690, 98, '2022-09-01', 2, '1726.70', '2022-09-02 22:27:22', b'1'),
(691, 98, '2022-09-16', 3, '1726.70', '2022-09-02 22:27:22', b'1'),
(692, 98, '2022-10-01', 4, '1726.70', '2022-09-02 22:27:22', b'1'),
(693, 98, '2022-10-18', 5, '1726.70', '2022-09-02 22:27:22', b'1'),
(694, 98, '2022-10-31', 6, '1726.70', '2022-09-02 22:27:22', b'1'),
(695, 99, '2022-10-10', 1, '1160.00', '2022-09-15 16:18:55', b'0'),
(696, 100, '2022-09-20', 1, '150.00', '2022-09-14 14:59:26', b'1'),
(697, 100, '2022-09-27', 2, '150.00', '2022-09-14 14:59:26', b'1'),
(698, 100, '2022-10-04', 3, '150.00', '2022-09-14 14:59:26', b'1'),
(699, 100, '2022-10-11', 4, '150.00', '2022-09-14 14:59:26', b'1'),
(706, 102, '2022-04-12', 1, '1190.00', '2022-09-14 21:25:53', b'0'),
(707, 102, '2022-04-25', 2, '1190.00', '2022-09-14 21:25:35', b'1'),
(708, 102, '2022-05-10', 3, '1190.00', '2022-09-14 21:25:35', b'1'),
(709, 102, '2022-05-25', 4, '1190.00', '2022-09-14 21:25:35', b'1'),
(710, 103, '2022-02-24', 1, '1190.00', '2022-09-14 21:39:26', b'0'),
(711, 103, '2022-03-11', 2, '1190.00', '2022-09-14 21:39:26', b'0'),
(712, 103, '2022-03-26', 3, '1190.00', '2022-09-14 21:39:26', b'0'),
(713, 103, '2022-04-12', 4, '1190.00', '2022-09-14 21:29:37', b'1'),
(714, 104, '2022-03-23', 1, '498.10', '2022-09-15 16:07:15', b'0'),
(715, 104, '2022-03-30', 2, '498.10', '2022-09-15 16:06:35', b'1'),
(716, 104, '2022-04-06', 3, '498.10', '2022-09-15 16:06:35', b'1'),
(717, 104, '2022-04-13', 4, '498.10', '2022-09-15 16:06:35', b'1'),
(718, 104, '2022-04-20', 5, '498.10', '2022-09-15 16:06:35', b'1'),
(719, 104, '2022-04-27', 6, '498.10', '2022-09-15 16:06:35', b'1'),
(720, 104, '2022-05-04', 7, '498.10', '2022-09-15 16:06:35', b'1'),
(721, 104, '2022-05-11', 8, '498.10', '2022-09-15 16:06:35', b'1'),
(722, 104, '2022-05-18', 9, '498.10', '2022-09-15 16:06:35', b'1'),
(723, 104, '2022-05-25', 10, '498.10', '2022-09-15 16:06:35', b'1'),
(724, 104, '2022-06-01', 11, '498.10', '2022-09-15 16:06:35', b'1'),
(725, 104, '2022-06-08', 12, '498.10', '2022-09-15 16:06:35', b'1'),
(726, 105, '2022-09-30', 1, '1180.00', '2022-09-15 16:20:43', b'1'),
(727, 105, '2022-10-15', 2, '1180.00', '2022-09-15 16:20:43', b'1'),
(728, 106, '2022-09-09', 1, '289.00', '2022-09-15 19:36:21', b'1'),
(729, 106, '2022-09-16', 2, '289.00', '2022-09-15 19:36:21', b'1'),
(730, 106, '2022-09-23', 3, '289.00', '2022-09-15 19:36:21', b'1'),
(731, 106, '2022-09-30', 4, '289.00', '2022-09-15 19:36:21', b'1'),
(732, 106, '2022-10-07', 5, '289.00', '2022-09-15 19:36:21', b'1'),
(733, 106, '2022-10-14', 6, '289.00', '2022-09-15 19:36:21', b'1'),
(734, 106, '2022-10-21', 7, '289.00', '2022-09-15 19:36:21', b'1'),
(735, 106, '2022-10-28', 8, '289.00', '2022-09-15 19:36:21', b'1'),
(736, 107, '2022-08-20', 1, '1973.30', '2022-09-15 20:10:38', b'1'),
(737, 107, '2022-09-06', 2, '1973.30', '2022-09-15 20:10:38', b'1'),
(738, 107, '2022-09-19', 3, '1973.30', '2022-09-15 20:10:38', b'1'),
(739, 107, '2022-10-04', 4, '1973.30', '2022-09-15 20:10:38', b'1'),
(740, 107, '2022-10-19', 5, '1973.30', '2022-09-15 20:10:38', b'1'),
(741, 107, '2022-11-03', 6, '1973.30', '2022-09-15 20:10:38', b'1'),
(762, 112, '2022-10-01', 1, '2422.70', '2022-09-16 22:37:47', b'1'),
(763, 112, '2022-10-18', 2, '2422.70', '2022-09-16 22:37:47', b'1'),
(764, 112, '2022-10-31', 3, '2422.70', '2022-09-16 22:37:47', b'1'),
(765, 112, '2022-11-15', 4, '2422.70', '2022-09-16 22:37:47', b'1'),
(766, 112, '2022-11-30', 5, '2422.70', '2022-09-16 22:37:47', b'1'),
(767, 112, '2022-12-15', 6, '2422.70', '2022-09-16 22:37:47', b'1'),
(768, 112, '2022-12-30', 7, '2422.70', '2022-09-16 22:37:47', b'1'),
(769, 112, '2023-01-14', 8, '2422.70', '2022-09-16 22:37:47', b'1'),
(770, 112, '2023-01-31', 9, '2422.70', '2022-09-16 22:37:47', b'1'),
(771, 112, '2023-02-13', 10, '2422.70', '2022-09-16 22:37:48', b'1'),
(772, 112, '2023-02-28', 11, '2422.70', '2022-09-16 22:37:48', b'1'),
(773, 112, '2023-03-15', 12, '2422.70', '2022-09-16 22:37:48', b'1'),
(774, 113, '2022-10-06', 1, '416.00', '2022-09-21 19:07:28', b'1'),
(775, 113, '2022-10-21', 2, '416.00', '2022-09-21 19:07:28', b'1'),
(776, 113, '2022-11-05', 3, '416.00', '2022-09-21 19:07:28', b'1'),
(777, 113, '2022-11-22', 4, '416.00', '2022-09-21 19:07:29', b'1'),
(778, 114, '2022-10-07', 1, '450.00', '2022-09-23 01:36:43', b'1'),
(779, 114, '2022-10-22', 2, '450.00', '2022-09-23 01:36:43', b'1'),
(780, 114, '2022-11-08', 3, '450.00', '2022-09-23 01:36:43', b'1'),
(781, 114, '2022-11-21', 4, '450.00', '2022-09-23 01:36:44', b'1'),
(782, 115, '2022-10-11', 1, '102.00', '2022-09-30 23:32:06', b'0'),
(783, 115, '2022-10-26', 2, '102.00', '2022-09-30 23:34:00', b'0'),
(784, 115, '2022-11-10', 3, '102.00', '2022-09-30 23:34:00', b'0'),
(785, 115, '2022-11-25', 4, '102.00', '2022-09-26 13:34:06', b'1'),
(786, 115, '2022-12-10', 5, '102.00', '2022-09-26 13:34:06', b'1'),
(787, 115, '2022-12-27', 6, '102.00', '2022-09-26 13:34:06', b'1'),
(788, 115, '2023-01-09', 7, '102.00', '2022-09-26 13:34:06', b'1'),
(789, 115, '2023-01-24', 8, '102.00', '2022-09-26 13:34:06', b'1'),
(790, 115, '2023-02-08', 9, '102.00', '2022-09-26 13:34:07', b'1'),
(791, 115, '2023-02-23', 10, '102.00', '2022-09-26 13:34:07', b'1'),
(792, 115, '2023-03-10', 11, '102.00', '2022-09-26 13:34:07', b'1'),
(793, 115, '2023-03-25', 12, '102.00', '2022-09-26 13:34:07', b'1'),
(794, 115, '2023-04-11', 13, '102.00', '2022-09-26 13:34:07', b'1'),
(795, 115, '2023-04-24', 14, '102.00', '2022-09-26 13:34:08', b'1'),
(796, 115, '2023-05-09', 15, '102.00', '2022-09-26 13:34:08', b'1'),
(797, 115, '2023-05-24', 16, '102.00', '2022-09-26 13:34:08', b'1'),
(798, 115, '2023-06-08', 17, '102.00', '2022-09-26 13:34:08', b'1'),
(799, 115, '2023-06-23', 18, '102.00', '2022-09-26 13:34:09', b'1'),
(800, 115, '2023-07-08', 19, '102.00', '2022-09-26 13:34:09', b'1'),
(801, 115, '2023-07-25', 20, '102.00', '2022-09-26 13:34:09', b'1'),
(802, 116, '2022-10-11', 1, '230.00', '2022-09-26 14:10:16', b'1'),
(803, 116, '2022-10-26', 2, '230.00', '2022-09-26 14:10:16', b'1'),
(804, 116, '2022-11-10', 3, '230.00', '2022-09-26 14:10:16', b'1'),
(805, 116, '2022-11-25', 4, '230.00', '2022-09-26 14:10:16', b'1'),
(806, 116, '2022-12-10', 5, '230.00', '2022-09-26 14:10:16', b'1'),
(807, 116, '2022-12-27', 6, '230.00', '2022-09-26 14:10:16', b'1'),
(808, 116, '2023-01-09', 7, '230.00', '2022-09-26 14:10:16', b'1'),
(809, 116, '2023-01-24', 8, '230.00', '2022-09-26 14:10:16', b'1'),
(810, 116, '2023-02-08', 9, '230.00', '2022-09-26 14:10:16', b'1'),
(811, 116, '2023-02-23', 10, '230.00', '2022-09-26 14:10:16', b'1'),
(812, 116, '2023-03-10', 11, '230.00', '2022-09-26 14:10:17', b'1'),
(813, 116, '2023-03-25', 12, '230.00', '2022-09-26 14:10:17', b'1'),
(814, 117, '2022-10-11', 1, '750.00', '2022-09-26 14:12:49', b'1'),
(815, 117, '2022-10-26', 2, '750.00', '2022-09-26 14:12:49', b'1'),
(816, 117, '2022-11-10', 3, '750.00', '2022-09-26 14:12:49', b'1'),
(817, 117, '2022-11-25', 4, '750.00', '2022-09-26 14:12:50', b'1'),
(818, 118, '2022-10-12', 1, '1440.00', '2022-09-27 18:56:04', b'1'),
(819, 118, '2022-10-27', 2, '1440.00', '2022-09-27 18:56:04', b'1'),
(820, 118, '2022-11-11', 3, '1440.00', '2022-09-27 18:56:04', b'1'),
(821, 118, '2022-11-26', 4, '1440.00', '2022-09-27 18:56:04', b'1'),
(822, 119, '2022-10-13', 1, '110.00', '2022-09-28 21:50:04', b'1'),
(823, 119, '2022-10-28', 2, '110.00', '2022-09-28 21:50:04', b'1'),
(824, 119, '2022-11-12', 3, '110.00', '2022-09-28 21:50:04', b'1'),
(825, 119, '2022-11-29', 4, '110.00', '2022-09-28 21:50:04', b'1'),
(826, 119, '2022-12-12', 5, '110.00', '2022-09-28 21:50:04', b'1'),
(827, 119, '2022-12-27', 6, '110.00', '2022-09-28 21:50:04', b'1'),
(828, 119, '2023-01-11', 7, '110.00', '2022-09-28 21:50:04', b'1'),
(829, 119, '2023-01-26', 8, '110.00', '2022-09-28 21:50:04', b'1'),
(830, 119, '2023-02-10', 9, '110.00', '2022-09-28 21:50:04', b'1'),
(831, 119, '2023-02-25', 10, '110.00', '2022-09-28 21:50:04', b'1'),
(832, 119, '2023-03-14', 11, '110.00', '2022-09-28 21:50:04', b'1'),
(833, 119, '2023-03-27', 12, '110.00', '2022-09-28 21:50:05', b'1'),
(834, 119, '2023-04-11', 13, '110.00', '2022-09-28 21:50:05', b'1'),
(835, 119, '2023-04-26', 14, '110.00', '2022-09-28 21:50:05', b'1'),
(836, 119, '2023-05-11', 15, '110.00', '2022-09-28 21:50:05', b'1'),
(837, 119, '2023-05-26', 16, '110.00', '2022-09-28 21:50:05', b'1'),
(838, 119, '2023-06-10', 17, '110.00', '2022-09-28 21:50:05', b'1'),
(839, 119, '2023-06-27', 18, '110.00', '2022-09-28 21:50:05', b'1'),
(840, 119, '2023-07-10', 19, '110.00', '2022-09-28 21:50:05', b'1'),
(841, 119, '2023-07-25', 20, '110.00', '2022-09-28 21:50:05', b'1'),
(842, 119, '2023-08-09', 21, '110.00', '2022-09-28 21:50:05', b'1'),
(843, 119, '2023-08-24', 22, '110.00', '2022-09-28 21:50:05', b'1'),
(844, 119, '2023-09-08', 23, '110.00', '2022-09-28 21:50:05', b'1'),
(845, 119, '2023-09-23', 24, '110.00', '2022-09-28 21:50:05', b'1'),
(846, 119, '2023-10-10', 25, '110.00', '2022-09-28 21:50:05', b'1'),
(847, 119, '2023-10-23', 26, '110.00', '2022-09-28 21:50:05', b'1'),
(848, 119, '2023-11-07', 27, '110.00', '2022-09-28 21:50:05', b'1'),
(849, 119, '2023-11-22', 28, '110.00', '2022-09-28 21:50:05', b'1'),
(850, 119, '2023-12-07', 29, '110.00', '2022-09-28 21:50:05', b'1'),
(851, 119, '2023-12-22', 30, '110.00', '2022-09-28 21:50:05', b'1'),
(852, 119, '2024-01-06', 31, '110.00', '2022-09-28 21:50:06', b'1'),
(853, 119, '2024-01-23', 32, '110.00', '2022-09-28 21:50:06', b'1');
INSERT INTO `loan_items` (`id`, `loan_id`, `date`, `num_quota`, `fee_amount`, `pay_date`, `status`) VALUES
(854, 119, '2024-02-05', 33, '110.00', '2022-09-28 21:50:06', b'1'),
(855, 119, '2024-02-20', 34, '110.00', '2022-09-28 21:50:06', b'1'),
(856, 119, '2024-03-06', 35, '110.00', '2022-09-28 21:50:06', b'1'),
(857, 119, '2024-03-21', 36, '110.00', '2022-09-28 21:50:06', b'1'),
(858, 119, '2024-04-05', 37, '110.00', '2022-09-28 21:50:06', b'1'),
(859, 119, '2024-04-20', 38, '110.00', '2022-09-28 21:50:06', b'1'),
(860, 119, '2024-05-07', 39, '110.00', '2022-09-28 21:50:06', b'1'),
(861, 119, '2024-05-20', 40, '110.00', '2022-09-28 21:50:06', b'1'),
(862, 119, '2024-06-04', 41, '110.00', '2022-09-28 21:50:06', b'1'),
(863, 119, '2024-06-19', 42, '110.00', '2022-09-28 21:50:06', b'1'),
(864, 119, '2024-07-04', 43, '110.00', '2022-09-28 21:50:06', b'1'),
(865, 119, '2024-07-19', 44, '110.00', '2022-09-28 21:50:06', b'1'),
(866, 119, '2024-08-03', 45, '110.00', '2022-09-28 21:50:06', b'1'),
(867, 119, '2024-08-20', 46, '110.00', '2022-09-28 21:50:06', b'1'),
(868, 119, '2024-09-02', 47, '110.00', '2022-09-28 21:50:06', b'1'),
(869, 119, '2024-09-17', 48, '110.00', '2022-09-28 21:50:06', b'1'),
(870, 119, '2024-10-02', 49, '110.00', '2022-09-28 21:50:06', b'1'),
(871, 119, '2024-10-17', 50, '110.00', '2022-09-28 21:50:07', b'1'),
(872, 119, '2024-11-01', 51, '110.00', '2022-09-28 21:50:07', b'1'),
(873, 119, '2024-11-16', 52, '110.00', '2022-09-28 21:50:07', b'1'),
(874, 119, '2024-12-03', 53, '110.00', '2022-09-28 21:50:07', b'1'),
(875, 119, '2024-12-16', 54, '110.00', '2022-09-28 21:50:07', b'1'),
(876, 119, '2024-12-31', 55, '110.00', '2022-09-28 21:50:07', b'1'),
(877, 119, '2025-01-15', 56, '110.00', '2022-09-28 21:50:07', b'1'),
(878, 119, '2025-01-30', 57, '110.00', '2022-09-28 21:50:07', b'1'),
(879, 119, '2025-02-14', 58, '110.00', '2022-09-28 21:50:07', b'1'),
(880, 119, '2025-03-01', 59, '110.00', '2022-09-28 21:50:07', b'1'),
(881, 119, '2025-03-18', 60, '110.00', '2022-09-28 21:50:07', b'1'),
(882, 119, '2025-03-31', 61, '110.00', '2022-09-28 21:50:07', b'1'),
(883, 119, '2025-04-15', 62, '110.00', '2022-09-28 21:50:07', b'1'),
(884, 119, '2025-04-30', 63, '110.00', '2022-09-28 21:50:07', b'1'),
(885, 119, '2025-05-15', 64, '110.00', '2022-09-28 21:50:07', b'1'),
(886, 119, '2025-05-30', 65, '110.00', '2022-09-28 21:50:07', b'1'),
(887, 119, '2025-06-14', 66, '110.00', '2022-09-28 21:50:07', b'1'),
(888, 119, '2025-07-01', 67, '110.00', '2022-09-28 21:50:07', b'1'),
(889, 119, '2025-07-14', 68, '110.00', '2022-09-28 21:50:07', b'1'),
(890, 119, '2025-07-29', 69, '110.00', '2022-09-28 21:50:07', b'1'),
(891, 119, '2025-08-13', 70, '110.00', '2022-09-28 21:50:07', b'1'),
(892, 119, '2025-08-28', 71, '110.00', '2022-09-28 21:50:07', b'1'),
(893, 119, '2025-09-12', 72, '110.00', '2022-09-28 21:50:07', b'1'),
(894, 119, '2025-09-27', 73, '110.00', '2022-09-28 21:50:07', b'1'),
(895, 119, '2025-10-14', 74, '110.00', '2022-09-28 21:50:07', b'1'),
(896, 119, '2025-10-27', 75, '110.00', '2022-09-28 21:50:08', b'1'),
(897, 119, '2025-11-11', 76, '110.00', '2022-09-28 21:50:08', b'1'),
(898, 119, '2025-11-26', 77, '110.00', '2022-09-28 21:50:08', b'1'),
(899, 119, '2025-12-11', 78, '110.00', '2022-09-28 21:50:08', b'1'),
(900, 119, '2025-12-26', 79, '110.00', '2022-09-28 21:50:08', b'1'),
(901, 119, '2026-01-10', 80, '110.00', '2022-09-28 21:50:08', b'1'),
(902, 119, '2026-01-27', 81, '110.00', '2022-09-28 21:50:08', b'1'),
(903, 119, '2026-02-09', 82, '110.00', '2022-09-28 21:50:08', b'1'),
(904, 119, '2026-02-24', 83, '110.00', '2022-09-28 21:50:08', b'1'),
(905, 119, '2026-03-11', 84, '110.00', '2022-09-28 21:50:08', b'1'),
(906, 119, '2026-03-26', 85, '110.00', '2022-09-28 21:50:08', b'1'),
(907, 119, '2026-04-10', 86, '110.00', '2022-09-28 21:50:08', b'1'),
(908, 119, '2026-04-25', 87, '110.00', '2022-09-28 21:50:08', b'1'),
(909, 119, '2026-05-12', 88, '110.00', '2022-09-28 21:50:08', b'1'),
(910, 119, '2026-05-25', 89, '110.00', '2022-09-28 21:50:08', b'1'),
(911, 119, '2026-06-09', 90, '110.00', '2022-09-28 21:50:08', b'1'),
(912, 119, '2026-06-24', 91, '110.00', '2022-09-28 21:50:08', b'1'),
(913, 119, '2026-07-09', 92, '110.00', '2022-09-28 21:50:08', b'1'),
(914, 119, '2026-07-24', 93, '110.00', '2022-09-28 21:50:08', b'1'),
(915, 119, '2026-08-08', 94, '110.00', '2022-09-28 21:50:08', b'1'),
(916, 119, '2026-08-25', 95, '110.00', '2022-09-28 21:50:08', b'1'),
(917, 119, '2026-09-07', 96, '110.00', '2022-09-28 21:50:08', b'1'),
(918, 119, '2026-09-22', 97, '110.00', '2022-09-28 21:50:08', b'1'),
(919, 119, '2026-10-07', 98, '110.00', '2022-09-28 21:50:09', b'1'),
(920, 119, '2026-10-22', 99, '110.00', '2022-09-28 21:50:09', b'1'),
(921, 119, '2026-11-06', 100, '110.00', '2022-09-28 21:50:09', b'1'),
(922, 119, '2026-11-21', 101, '110.00', '2022-09-28 21:50:09', b'1'),
(923, 119, '2026-12-08', 102, '110.00', '2022-09-28 21:50:09', b'1'),
(924, 119, '2026-12-21', 103, '110.00', '2022-09-28 21:50:09', b'1'),
(925, 119, '2027-01-05', 104, '110.00', '2022-09-28 21:50:09', b'1'),
(926, 119, '2027-01-20', 105, '110.00', '2022-09-28 21:50:09', b'1'),
(927, 119, '2027-02-04', 106, '110.00', '2022-09-28 21:50:09', b'1'),
(928, 119, '2027-02-19', 107, '110.00', '2022-09-28 21:50:09', b'1'),
(929, 119, '2027-03-06', 108, '110.00', '2022-09-28 21:50:09', b'1'),
(930, 119, '2027-03-23', 109, '110.00', '2022-09-28 21:50:09', b'1'),
(931, 119, '2027-04-05', 110, '110.00', '2022-09-28 21:50:09', b'1'),
(932, 119, '2027-04-20', 111, '110.00', '2022-09-28 21:50:09', b'1'),
(933, 119, '2027-05-05', 112, '110.00', '2022-09-28 21:50:09', b'1'),
(934, 119, '2027-05-20', 113, '110.00', '2022-09-28 21:50:09', b'1'),
(935, 119, '2027-06-04', 114, '110.00', '2022-09-28 21:50:09', b'1'),
(936, 119, '2027-06-19', 115, '110.00', '2022-09-28 21:50:09', b'1'),
(937, 119, '2027-07-06', 116, '110.00', '2022-09-28 21:50:09', b'1'),
(938, 119, '2027-07-19', 117, '110.00', '2022-09-28 21:50:09', b'1'),
(939, 119, '2027-08-03', 118, '110.00', '2022-09-28 21:50:09', b'1'),
(940, 119, '2027-08-18', 119, '110.00', '2022-09-28 21:50:09', b'1'),
(941, 119, '2027-09-02', 120, '110.00', '2022-09-28 21:50:10', b'1'),
(942, 119, '2027-09-17', 121, '110.00', '2022-09-28 21:50:10', b'1'),
(943, 119, '2027-10-02', 122, '110.00', '2022-09-28 21:50:10', b'1'),
(944, 119, '2027-10-19', 123, '110.00', '2022-09-28 21:50:10', b'1'),
(945, 119, '2027-11-01', 124, '110.00', '2022-09-28 21:50:10', b'1'),
(946, 119, '2027-11-16', 125, '110.00', '2022-09-28 21:50:10', b'1'),
(947, 119, '2027-12-01', 126, '110.00', '2022-09-28 21:50:10', b'1'),
(948, 119, '2027-12-16', 127, '110.00', '2022-09-28 21:50:10', b'1'),
(949, 119, '2027-12-31', 128, '110.00', '2022-09-28 21:50:10', b'1'),
(950, 119, '2028-01-15', 129, '110.00', '2022-09-28 21:50:10', b'1'),
(951, 119, '2028-02-01', 130, '110.00', '2022-09-28 21:50:10', b'1'),
(952, 119, '2028-02-14', 131, '110.00', '2022-09-28 21:50:10', b'1'),
(953, 119, '2028-02-29', 132, '110.00', '2022-09-28 21:50:10', b'1'),
(954, 119, '2028-03-15', 133, '110.00', '2022-09-28 21:50:10', b'1'),
(955, 119, '2028-03-30', 134, '110.00', '2022-09-28 21:50:10', b'1'),
(956, 119, '2028-04-14', 135, '110.00', '2022-09-28 21:50:10', b'1'),
(957, 119, '2028-04-29', 136, '110.00', '2022-09-28 21:50:11', b'1'),
(958, 119, '2028-05-16', 137, '110.00', '2022-09-28 21:50:11', b'1'),
(959, 119, '2028-05-29', 138, '110.00', '2022-09-28 21:50:11', b'1'),
(960, 119, '2028-06-13', 139, '110.00', '2022-09-28 21:50:11', b'1'),
(961, 119, '2028-06-28', 140, '110.00', '2022-09-28 21:50:11', b'1'),
(962, 119, '2028-07-13', 141, '110.00', '2022-09-28 21:50:11', b'1'),
(963, 119, '2028-07-28', 142, '110.00', '2022-09-28 21:50:11', b'1'),
(964, 119, '2028-08-12', 143, '110.00', '2022-09-28 21:50:11', b'1'),
(965, 119, '2028-08-29', 144, '110.00', '2022-09-28 21:50:11', b'1'),
(966, 119, '2028-09-11', 145, '110.00', '2022-09-28 21:50:12', b'1'),
(967, 119, '2028-09-26', 146, '110.00', '2022-09-28 21:50:12', b'1'),
(968, 119, '2028-10-11', 147, '110.00', '2022-09-28 21:50:12', b'1'),
(969, 119, '2028-10-26', 148, '110.00', '2022-09-28 21:50:12', b'1'),
(970, 119, '2028-11-10', 149, '110.00', '2022-09-28 21:50:12', b'1'),
(971, 119, '2028-11-25', 150, '110.00', '2022-09-28 21:50:12', b'1'),
(972, 119, '2028-12-12', 151, '110.00', '2022-09-28 21:50:12', b'1'),
(973, 119, '2028-12-25', 152, '110.00', '2022-09-28 21:50:12', b'1'),
(974, 119, '2029-01-09', 153, '110.00', '2022-09-28 21:50:12', b'1'),
(975, 119, '2029-01-24', 154, '110.00', '2022-09-28 21:50:12', b'1'),
(976, 119, '2029-02-08', 155, '110.00', '2022-09-28 21:50:12', b'1'),
(977, 119, '2029-02-23', 156, '110.00', '2022-09-28 21:50:12', b'1'),
(978, 119, '2029-03-10', 157, '110.00', '2022-09-28 21:50:12', b'1'),
(979, 119, '2029-03-27', 158, '110.00', '2022-09-28 21:50:12', b'1'),
(980, 119, '2029-04-09', 159, '110.00', '2022-09-28 21:50:12', b'1'),
(981, 119, '2029-04-24', 160, '110.00', '2022-09-28 21:50:12', b'1'),
(982, 119, '2029-05-09', 161, '110.00', '2022-09-28 21:50:12', b'1'),
(983, 119, '2029-05-24', 162, '110.00', '2022-09-28 21:50:12', b'1'),
(984, 119, '2029-06-08', 163, '110.00', '2022-09-28 21:50:13', b'1'),
(985, 119, '2029-06-23', 164, '110.00', '2022-09-28 21:50:13', b'1'),
(986, 119, '2029-07-10', 165, '110.00', '2022-09-28 21:50:13', b'1'),
(987, 119, '2029-07-23', 166, '110.00', '2022-09-28 21:50:13', b'1'),
(988, 119, '2029-08-07', 167, '110.00', '2022-09-28 21:50:13', b'1'),
(989, 119, '2029-08-22', 168, '110.00', '2022-09-28 21:50:13', b'1'),
(990, 119, '2029-09-06', 169, '110.00', '2022-09-28 21:50:13', b'1'),
(991, 119, '2029-09-21', 170, '110.00', '2022-09-28 21:50:13', b'1'),
(992, 119, '2029-10-06', 171, '110.00', '2022-09-28 21:50:13', b'1'),
(993, 119, '2029-10-23', 172, '110.00', '2022-09-28 21:50:13', b'1'),
(994, 119, '2029-11-05', 173, '110.00', '2022-09-28 21:50:13', b'1'),
(995, 119, '2029-11-20', 174, '110.00', '2022-09-28 21:50:13', b'1'),
(996, 119, '2029-12-05', 175, '110.00', '2022-09-28 21:50:13', b'1'),
(997, 119, '2029-12-20', 176, '110.00', '2022-09-28 21:50:13', b'1'),
(998, 119, '2030-01-04', 177, '110.00', '2022-09-28 21:50:13', b'1'),
(999, 119, '2030-01-19', 178, '110.00', '2022-09-28 21:50:13', b'1'),
(1000, 119, '2030-02-05', 179, '110.00', '2022-09-28 21:50:14', b'1'),
(1001, 119, '2030-02-18', 180, '110.00', '2022-09-28 21:50:14', b'1'),
(1002, 119, '2030-03-05', 181, '110.00', '2022-09-28 21:50:14', b'1'),
(1003, 119, '2030-03-20', 182, '110.00', '2022-09-28 21:50:14', b'1'),
(1004, 119, '2030-04-04', 183, '110.00', '2022-09-28 21:50:14', b'1'),
(1005, 119, '2030-04-19', 184, '110.00', '2022-09-28 21:50:14', b'1'),
(1006, 119, '2030-05-04', 185, '110.00', '2022-09-28 21:50:14', b'1'),
(1007, 119, '2030-05-21', 186, '110.00', '2022-09-28 21:50:14', b'1'),
(1008, 119, '2030-06-03', 187, '110.00', '2022-09-28 21:50:14', b'1'),
(1009, 119, '2030-06-18', 188, '110.00', '2022-09-28 21:50:14', b'1'),
(1010, 119, '2030-07-03', 189, '110.00', '2022-09-28 21:50:14', b'1'),
(1011, 119, '2030-07-18', 190, '110.00', '2022-09-28 21:50:14', b'1'),
(1012, 119, '2030-08-02', 191, '110.00', '2022-09-28 21:50:14', b'1'),
(1013, 119, '2030-08-17', 192, '110.00', '2022-09-28 21:50:14', b'1'),
(1014, 119, '2030-09-03', 193, '110.00', '2022-09-28 21:50:14', b'1'),
(1015, 119, '2030-09-16', 194, '110.00', '2022-09-28 21:50:14', b'1'),
(1016, 119, '2030-10-01', 195, '110.00', '2022-09-28 21:50:14', b'1'),
(1017, 119, '2030-10-16', 196, '110.00', '2022-09-28 21:50:14', b'1'),
(1018, 119, '2030-10-31', 197, '110.00', '2022-09-28 21:50:14', b'1'),
(1019, 119, '2030-11-15', 198, '110.00', '2022-09-28 21:50:14', b'1'),
(1020, 119, '2030-11-30', 199, '110.00', '2022-09-28 21:50:14', b'1'),
(1021, 119, '2030-12-17', 200, '110.00', '2022-09-28 21:50:14', b'1'),
(1022, 119, '2030-12-30', 201, '110.00', '2022-09-28 21:50:14', b'1'),
(1023, 119, '2031-01-14', 202, '110.00', '2022-09-28 21:50:14', b'1'),
(1024, 119, '2031-01-29', 203, '110.00', '2022-09-28 21:50:14', b'1'),
(1025, 119, '2031-02-13', 204, '110.00', '2022-09-28 21:50:14', b'1'),
(1026, 119, '2031-02-28', 205, '110.00', '2022-09-28 21:50:15', b'1'),
(1027, 119, '2031-03-15', 206, '110.00', '2022-09-28 21:50:15', b'1'),
(1028, 119, '2031-04-01', 207, '110.00', '2022-09-28 21:50:15', b'1'),
(1029, 119, '2031-04-14', 208, '110.00', '2022-09-28 21:50:15', b'1'),
(1030, 119, '2031-04-29', 209, '110.00', '2022-09-28 21:50:15', b'1'),
(1031, 119, '2031-05-14', 210, '110.00', '2022-09-28 21:50:15', b'1'),
(1032, 119, '2031-05-29', 211, '110.00', '2022-09-28 21:50:15', b'1'),
(1033, 119, '2031-06-13', 212, '110.00', '2022-09-28 21:50:15', b'1'),
(1034, 119, '2031-06-28', 213, '110.00', '2022-09-28 21:50:15', b'1'),
(1035, 119, '2031-07-15', 214, '110.00', '2022-09-28 21:50:15', b'1'),
(1036, 119, '2031-07-28', 215, '110.00', '2022-09-28 21:50:15', b'1'),
(1037, 119, '2031-08-12', 216, '110.00', '2022-09-28 21:50:15', b'1'),
(1038, 119, '2031-08-27', 217, '110.00', '2022-09-28 21:50:15', b'1'),
(1039, 119, '2031-09-11', 218, '110.00', '2022-09-28 21:50:15', b'1'),
(1040, 119, '2031-09-26', 219, '110.00', '2022-09-28 21:50:15', b'1'),
(1041, 119, '2031-10-11', 220, '110.00', '2022-09-28 21:50:15', b'1'),
(1042, 119, '2031-10-28', 221, '110.00', '2022-09-28 21:50:15', b'1'),
(1043, 119, '2031-11-10', 222, '110.00', '2022-09-28 21:50:15', b'1'),
(1044, 119, '2031-11-25', 223, '110.00', '2022-09-28 21:50:15', b'1'),
(1045, 119, '2031-12-10', 224, '110.00', '2022-09-28 21:50:15', b'1'),
(1046, 119, '2031-12-25', 225, '110.00', '2022-09-28 21:50:15', b'1'),
(1047, 119, '2032-01-09', 226, '110.00', '2022-09-28 21:50:15', b'1'),
(1048, 119, '2032-01-24', 227, '110.00', '2022-09-28 21:50:15', b'1'),
(1049, 119, '2032-02-10', 228, '110.00', '2022-09-28 21:50:15', b'1'),
(1050, 119, '2032-02-23', 229, '110.00', '2022-09-28 21:50:15', b'1'),
(1051, 119, '2032-03-09', 230, '110.00', '2022-09-28 21:50:15', b'1'),
(1052, 119, '2032-03-24', 231, '110.00', '2022-09-28 21:50:16', b'1'),
(1053, 119, '2032-04-08', 232, '110.00', '2022-09-28 21:50:16', b'1'),
(1054, 119, '2032-04-23', 233, '110.00', '2022-09-28 21:50:16', b'1'),
(1055, 119, '2032-05-08', 234, '110.00', '2022-09-28 21:50:16', b'1'),
(1056, 119, '2032-05-25', 235, '110.00', '2022-09-28 21:50:16', b'1'),
(1057, 119, '2032-06-07', 236, '110.00', '2022-09-28 21:50:16', b'1'),
(1058, 119, '2032-06-22', 237, '110.00', '2022-09-28 21:50:16', b'1'),
(1059, 119, '2032-07-07', 238, '110.00', '2022-09-28 21:50:16', b'1'),
(1060, 119, '2032-07-22', 239, '110.00', '2022-09-28 21:50:16', b'1'),
(1061, 119, '2032-08-06', 240, '110.00', '2022-09-28 21:50:16', b'1'),
(1062, 119, '2032-08-21', 241, '110.00', '2022-09-28 21:50:16', b'1'),
(1063, 119, '2032-09-07', 242, '110.00', '2022-09-28 21:50:16', b'1'),
(1064, 119, '2032-09-20', 243, '110.00', '2022-09-28 21:50:16', b'1'),
(1065, 119, '2032-10-05', 244, '110.00', '2022-09-28 21:50:16', b'1'),
(1066, 119, '2032-10-20', 245, '110.00', '2022-09-28 21:50:16', b'1'),
(1067, 119, '2032-11-04', 246, '110.00', '2022-09-28 21:50:16', b'1'),
(1068, 119, '2032-11-19', 247, '110.00', '2022-09-28 21:50:16', b'1'),
(1069, 119, '2032-12-04', 248, '110.00', '2022-09-28 21:50:16', b'1'),
(1070, 119, '2032-12-21', 249, '110.00', '2022-09-28 21:50:17', b'1'),
(1071, 119, '2033-01-03', 250, '110.00', '2022-09-28 21:50:17', b'1'),
(1072, 119, '2033-01-18', 251, '110.00', '2022-09-28 21:50:17', b'1'),
(1073, 119, '2033-02-02', 252, '110.00', '2022-09-28 21:50:17', b'1'),
(1074, 119, '2033-02-17', 253, '110.00', '2022-09-28 21:50:17', b'1'),
(1075, 119, '2033-03-04', 254, '110.00', '2022-09-28 21:50:17', b'1'),
(1076, 119, '2033-03-19', 255, '110.00', '2022-09-28 21:50:17', b'1'),
(1077, 119, '2033-04-05', 256, '110.00', '2022-09-28 21:50:17', b'1'),
(1078, 119, '2033-04-18', 257, '110.00', '2022-09-28 21:50:17', b'1'),
(1079, 119, '2033-05-03', 258, '110.00', '2022-09-28 21:50:17', b'1'),
(1080, 119, '2033-05-18', 259, '110.00', '2022-09-28 21:50:17', b'1'),
(1081, 119, '2033-06-02', 260, '110.00', '2022-09-28 21:50:17', b'1'),
(1082, 119, '2033-06-17', 261, '110.00', '2022-09-28 21:50:17', b'1'),
(1083, 119, '2033-07-02', 262, '110.00', '2022-09-28 21:50:17', b'1'),
(1084, 119, '2033-07-19', 263, '110.00', '2022-09-28 21:50:17', b'1'),
(1085, 119, '2033-08-01', 264, '110.00', '2022-09-28 21:50:17', b'1'),
(1086, 119, '2033-08-16', 265, '110.00', '2022-09-28 21:50:17', b'1'),
(1087, 119, '2033-08-31', 266, '110.00', '2022-09-28 21:50:17', b'1'),
(1088, 119, '2033-09-15', 267, '110.00', '2022-09-28 21:50:17', b'1'),
(1089, 119, '2033-09-30', 268, '110.00', '2022-09-28 21:50:18', b'1'),
(1090, 119, '2033-10-15', 269, '110.00', '2022-09-28 21:50:18', b'1'),
(1091, 119, '2033-11-01', 270, '110.00', '2022-09-28 21:50:18', b'1'),
(1092, 119, '2033-11-14', 271, '110.00', '2022-09-28 21:50:18', b'1'),
(1093, 119, '2033-11-29', 272, '110.00', '2022-09-28 21:50:18', b'1'),
(1094, 119, '2033-12-14', 273, '110.00', '2022-09-28 21:50:18', b'1'),
(1095, 119, '2033-12-29', 274, '110.00', '2022-09-28 21:50:18', b'1'),
(1096, 119, '2034-01-13', 275, '110.00', '2022-09-28 21:50:18', b'1'),
(1097, 119, '2034-01-28', 276, '110.00', '2022-09-28 21:50:18', b'1'),
(1098, 119, '2034-02-14', 277, '110.00', '2022-09-28 21:50:18', b'1'),
(1099, 119, '2034-02-27', 278, '110.00', '2022-09-28 21:50:18', b'1'),
(1100, 119, '2034-03-14', 279, '110.00', '2022-09-28 21:50:18', b'1'),
(1101, 119, '2034-03-29', 280, '110.00', '2022-09-28 21:50:18', b'1'),
(1102, 119, '2034-04-13', 281, '110.00', '2022-09-28 21:50:18', b'1'),
(1103, 119, '2034-04-28', 282, '110.00', '2022-09-28 21:50:18', b'1'),
(1104, 119, '2034-05-13', 283, '110.00', '2022-09-28 21:50:18', b'1'),
(1105, 119, '2034-05-30', 284, '110.00', '2022-09-28 21:50:18', b'1'),
(1106, 119, '2034-06-12', 285, '110.00', '2022-09-28 21:50:19', b'1'),
(1107, 119, '2034-06-27', 286, '110.00', '2022-09-28 21:50:19', b'1'),
(1108, 119, '2034-07-12', 287, '110.00', '2022-09-28 21:50:19', b'1'),
(1109, 119, '2034-07-27', 288, '110.00', '2022-09-28 21:50:19', b'1'),
(1110, 119, '2034-08-11', 289, '110.00', '2022-09-28 21:50:19', b'1'),
(1111, 119, '2034-08-26', 290, '110.00', '2022-09-28 21:50:19', b'1'),
(1112, 119, '2034-09-12', 291, '110.00', '2022-09-28 21:50:19', b'1'),
(1113, 119, '2034-09-25', 292, '110.00', '2022-09-28 21:50:19', b'1'),
(1114, 119, '2034-10-10', 293, '110.00', '2022-09-28 21:50:19', b'1'),
(1115, 119, '2034-10-25', 294, '110.00', '2022-09-28 21:50:19', b'1'),
(1116, 119, '2034-11-09', 295, '110.00', '2022-09-28 21:50:19', b'1'),
(1117, 119, '2034-11-24', 296, '110.00', '2022-09-28 21:50:19', b'1'),
(1118, 119, '2034-12-09', 297, '110.00', '2022-09-28 21:50:19', b'1'),
(1119, 119, '2034-12-26', 298, '110.00', '2022-09-28 21:50:19', b'1'),
(1120, 119, '2035-01-08', 299, '110.00', '2022-09-28 21:50:19', b'1'),
(1121, 119, '2035-01-23', 300, '110.00', '2022-09-28 21:50:19', b'1'),
(1122, 126, '2022-10-18', 1, '855.00', '2022-10-01 15:57:52', b'1'),
(1123, 126, '2022-10-31', 2, '855.00', '2022-10-01 15:57:52', b'1'),
(1124, 127, '2022-10-18', 1, '337.16', '2022-10-01 16:09:16', b'1'),
(1125, 127, '2022-10-31', 2, '337.16', '2022-10-01 16:09:16', b'1'),
(1126, 127, '2022-11-15', 3, '337.16', '2022-10-01 16:09:16', b'1'),
(1127, 127, '2022-11-30', 4, '337.16', '2022-10-01 16:09:17', b'1'),
(1128, 127, '2022-12-15', 5, '337.16', '2022-10-01 16:09:17', b'1'),
(1129, 127, '2022-12-30', 6, '337.16', '2022-10-01 16:09:17', b'1'),
(1130, 128, '2022-10-18', 1, '7813.05', '2022-10-01 16:28:13', b'1'),
(1131, 128, '2022-10-31', 2, '7813.05', '2022-10-01 16:28:13', b'1'),
(1132, 128, '2022-11-15', 3, '7813.05', '2022-10-01 16:28:14', b'1'),
(1133, 128, '2022-11-30', 4, '7813.05', '2022-10-01 16:28:14', b'1'),
(1134, 128, '2022-12-15', 5, '7813.05', '2022-10-01 16:28:14', b'1'),
(1135, 128, '2022-12-30', 6, '7813.05', '2022-10-01 16:28:14', b'1'),
(1136, 128, '2023-01-14', 7, '7813.05', '2022-10-01 16:28:14', b'1'),
(1137, 128, '2023-01-31', 8, '7813.05', '2022-10-01 16:28:14', b'1'),
(1138, 128, '2023-02-13', 9, '7813.05', '2022-10-01 16:28:14', b'1'),
(1139, 128, '2023-02-28', 10, '7813.05', '2022-10-01 16:28:14', b'1'),
(1140, 128, '2023-03-15', 11, '7813.05', '2022-10-01 16:28:14', b'1'),
(1141, 128, '2023-03-30', 12, '7813.05', '2022-10-01 16:28:14', b'1'),
(1142, 128, '2023-04-14', 13, '7813.05', '2022-10-01 16:28:14', b'1'),
(1143, 128, '2023-04-29', 14, '7813.05', '2022-10-01 16:28:14', b'1'),
(1144, 128, '2023-05-16', 15, '7813.05', '2022-10-01 16:28:14', b'1'),
(1145, 128, '2023-05-29', 16, '7813.05', '2022-10-01 16:28:15', b'1'),
(1146, 128, '2023-06-13', 17, '7813.05', '2022-10-01 16:28:15', b'1'),
(1147, 128, '2023-06-28', 18, '7813.05', '2022-10-01 16:28:15', b'1'),
(1148, 128, '2023-07-13', 19, '7813.05', '2022-10-01 16:28:15', b'1'),
(1149, 128, '2023-07-28', 20, '7813.05', '2022-10-01 16:28:15', b'1'),
(1150, 128, '2023-08-12', 21, '7813.05', '2022-10-01 16:28:15', b'1'),
(1151, 128, '2023-08-29', 22, '7813.05', '2022-10-01 16:28:15', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) NOT NULL,
  `loan_item_id` bigint(20) NOT NULL,
  `mount` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_spanish_ci;

--
-- Volcado de datos para la tabla `payments`
--

INSERT INTO `payments` (`id`, `loan_item_id`, `mount`) VALUES
(54, 16, '256.70'),
(55, 79, '255.00'),
(56, 80, '255.00'),
(57, 81, '255.00'),
(58, 82, '255.00'),
(59, 83, '255.00'),
(60, 84, '255.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`) VALUES
(1, 'PERMISSION_CREATE'),
(2, 'PERMISSION_READ'),
(3, 'PERMISSION_UPDATE'),
(4, 'PERMISSION_DELETE'),
(5, 'ROLE_PERMISION_CREATE'),
(6, 'ROLE_PERMISION_READ'),
(7, 'ROLE_PERMISION_UPDATE'),
(8, 'ROLE_PERMISION_DELETE'),
(9, 'ROLE_CREATE'),
(10, 'ROLE_READ'),
(11, 'ROLE_UPDATE'),
(12, 'ROLE_DELETE'),
(13, 'USER_ROLE_CREATE'),
(14, 'USER_ROLE_READ'),
(15, 'USER_ROLE_UPDATE'),
(16, 'USER_ROLE_DELETE'),
(17, 'USER_CREATE'),
(18, 'USER_READ'),
(19, 'USER_UPDATE'),
(20, 'USER_DELETE'),
(21, 'CUSTOMER_CREATE'),
(22, 'CUSTOMER_READ'),
(23, 'CUSTOMER_UPDATE'),
(24, 'CUSTOMER_DELETE'),
(25, 'LOAN_CREATE'),
(26, 'LOAN_READ'),
(27, 'LOAN_UPDATE'),
(28, 'LOAN_DELETE'),
(29, 'LOAN_ITEM_CREATE'),
(30, 'LOAN_ITEM_READ'),
(31, 'LOAN_ITEM_UPDATE'),
(32, 'LOAN_ITEM_DELETE'),
(33, 'GUARANTOR_CREATE'),
(34, 'GUARANTOR_READ'),
(35, 'GUARANTOR_UPDATE'),
(36, 'GUARANTOR_DELETE'),
(37, 'MICROPAIMENT_CREATE'),
(38, 'MICROPAIMENT_READ'),
(39, 'MICROPAIMENT_UPDATE'),
(40, 'MICROPAIMENT_DELETE'),
(41, 'COIN_CREATE'),
(42, 'COIN_READ'),
(43, 'COIN_UPDATE'),
(44, 'COIN_DELETE'),
(45, 'AUTHOR_CUSTOMER_CREATE'),
(46, 'AUTHOR_CUSTOMER_READ'),
(47, 'AUTHOR_CUSTOMER_UPDATE'),
(48, 'AUTHOR_CUSTOMER_DELETE'),
(49, 'AUTHOR_LOAN_CREATE'),
(50, 'AUTHOR_LOAN_READ'),
(51, 'AUTHOR_LOAN_UPDATE'),
(52, 'AUTHOR_LOAN_DELETE'),
(53, 'AUTHOR_LOAN_ITEM_CREATE'),
(54, 'AUTHOR_LOAN_ITEM_READ'),
(55, 'AUTHOR_LOAN_ITEM_UPDATE'),
(56, 'AUTHOR_LOAN_ITEM_DELETE'),
(57, 'AUTHOR_GUARANTOR_CREATE'),
(58, 'AUTHOR_GUARANTOR_READ'),
(59, 'AUTHOR_GUARANTOR_UPDATE'),
(60, 'AUTHOR_GUARANTOR_DELETE'),
(61, 'AUTHOR_MICROPAIMENT_CREATE'),
(62, 'AUTHOR_MICROPAIMENT_READ'),
(63, 'AUTHOR_MICROPAIMENT_UPDATE'),
(64, 'AUTHOR_MICROPAIMENT_DELETE'),
(65, 'AUTHOR_COIN_CREATE'),
(66, 'AUTHOR_COIN_READ'),
(67, 'AUTHOR_COIN_UPDATE'),
(68, 'AUTHOR_COIN_DELETE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'ADMIN'),
(2, 'ADMIN_ADVISER'),
(3, 'AUX');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_permissions`
--

CREATE TABLE `roles_permissions` (
  `id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `permission_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `roles_permissions`
--

INSERT INTO `roles_permissions` (`id`, `role_id`, `permission_id`) VALUES
(1, 1, 21),
(2, 1, 22),
(3, 1, 23),
(4, 1, 24),
(5, 1, 25),
(6, 1, 26),
(7, 1, 27),
(8, 1, 28),
(9, 1, 29),
(10, 1, 30),
(11, 1, 31),
(12, 1, 32),
(13, 1, 33),
(14, 1, 34),
(15, 1, 35),
(16, 1, 36),
(17, 1, 37),
(18, 1, 38),
(19, 1, 39),
(20, 1, 40),
(21, 1, 41),
(22, 1, 42),
(23, 1, 43),
(24, 1, 44),
(25, 3, 21),
(26, 3, 22),
(27, 3, 23),
(29, 3, 25),
(30, 3, 26),
(31, 3, 51),
(32, 3, 28),
(33, 3, 29),
(34, 3, 30),
(35, 3, 55),
(36, 3, 32),
(37, 3, 33),
(38, 3, 34),
(39, 3, 35),
(40, 3, 36),
(41, 3, 37),
(42, 3, 38),
(43, 3, 39),
(44, 3, 40),
(45, 3, 41),
(46, 3, 42),
(47, 3, 43),
(48, 3, 44),
(49, 2, 21),
(50, 2, 22),
(51, 2, 23),
(52, 2, 25),
(53, 2, 26),
(54, 2, 27),
(55, 2, 28),
(56, 2, 29),
(57, 2, 30),
(58, 2, 31),
(59, 2, 32),
(60, 2, 33),
(61, 2, 34),
(62, 2, 35),
(63, 2, 36),
(64, 2, 37),
(65, 2, 38),
(66, 2, 39),
(67, 2, 40),
(68, 2, 41),
(69, 2, 42),
(70, 2, 43),
(71, 2, 44),
(72, 1, 54);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `academic_degree` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `first_name` varchar(150) COLLATE utf8_spanish2_ci NOT NULL,
  `last_name` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_spanish2_ci NOT NULL,
  `password` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `avatar` varchar(2000) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `academic_degree`, `first_name`, `last_name`, `email`, `password`, `avatar`) VALUES
(1, 'DR.', 'ORLANDO', 'BEJARANO FERNANDEZ', 'gerenciacredichuracasa@gmail.com', 'ad57cb3de9c53c1fc7de94665f6f1db2dfbcaaf73063769fed0b3011466eba602c2f423c4725c6dfacdc2973a518a18e0784e848ca3aabd7cadfd140df1df447', 'employee_man.png'),
(2, 'DR.', 'JERZON PABLO', 'SIHUAIROS', 'legalcredichuracasa@gmail.com', 'ad57cb3de9c53c1fc7de94665f6f1db2dfbcaaf73063769fed0b3011466eba602c2f423c4725c6dfacdc2973a518a18e0784e848ca3aabd7cadfd140df1df447', 'employee_man.png'),
(3, 'LIC.', 'GISELA', 'CARVAJAL NINAJA', 'credichuracasaadm@gmail.com', 'ad57cb3de9c53c1fc7de94665f6f1db2dfbcaaf73063769fed0b3011466eba602c2f423c4725c6dfacdc2973a518a18e0784e848ca3aabd7cadfd140df1df447', 'employee_woman.png'),
(4, 'ING.', 'RUSSETT', 'RODRIGUEZ VELIZ', 'cobrostarijacredichura@gmail.com', 'ad57cb3de9c53c1fc7de94665f6f1db2dfbcaaf73063769fed0b3011466eba602c2f423c4725c6dfacdc2973a518a18e0784e848ca3aabd7cadfd140df1df447', 'employee_man.png'),
(5, 'LIC.', 'CRISTIAN OLIVER', 'RAMOS VELIZ', 'auxiliartjacredichuracasa@gmail.com', 'ad57cb3de9c53c1fc7de94665f6f1db2dfbcaaf73063769fed0b3011466eba602c2f423c4725c6dfacdc2973a518a18e0784e848ca3aabd7cadfd140df1df447', 'employee_man.png'),
(6, 'DRA.', 'FABIOLA', 'ARDAYA ALCAZAR', 'agenciayacuibacredichuracasa@gmail.com', 'ad57cb3de9c53c1fc7de94665f6f1db2dfbcaaf73063769fed0b3011466eba602c2f423c4725c6dfacdc2973a518a18e0784e848ca3aabd7cadfd140df1df447', 'employee_woman.png'),
(7, 'DRA.', 'M ALEJANDRA', 'ZENTENO VELASCO', 'cobranzascredichuracasa@gmail.com', 'ad57cb3de9c53c1fc7de94665f6f1db2dfbcaaf73063769fed0b3011466eba602c2f423c4725c6dfacdc2973a518a18e0784e848ca3aabd7cadfd140df1df447', 'employee_woman.png'),
(8, '', 'PRUEBA', 'PRUEBA', 'prueba@gmail.com', 'ad57cb3de9c53c1fc7de94665f6f1db2dfbcaaf73063769fed0b3011466eba602c2f423c4725c6dfacdc2973a518a18e0784e848ca3aabd7cadfd140df1df447', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_roles`
--

CREATE TABLE `users_roles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users_roles`
--

INSERT INTO `users_roles` (`id`, `user_id`, `role_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 2),
(4, 4, 2),
(5, 5, 3),
(6, 6, 2),
(7, 7, 2),
(8, 8, 1);

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
-- Indices de la tabla `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `Índice 2` (`loan_item_id`) USING BTREE;

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `FK__roles` (`role_id`) USING BTREE,
  ADD KEY `FK__permissions` (`permission_id`) USING BTREE;

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `FK__users` (`user_id`) USING BTREE,
  ADD KEY `FK__roles` (`role_id`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `coins`
--
ALTER TABLE `coins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT de la tabla `guarantors`
--
ALTER TABLE `guarantors`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT de la tabla `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT de la tabla `loan_items`
--
ALTER TABLE `loan_items`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1152;

--
-- AUTO_INCREMENT de la tabla `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `roles_permissions`
--
ALTER TABLE `roles_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `users_roles`
--
ALTER TABLE `users_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
-- Filtros para la tabla `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `FK_payments_loan_items` FOREIGN KEY (`loan_item_id`) REFERENCES `loan_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD CONSTRAINT `FK__permissions` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK__roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `users_roles`
--
ALTER TABLE `users_roles`
  ADD CONSTRAINT `FK___roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK___users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
