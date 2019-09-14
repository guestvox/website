-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-09-2019 a las 18:03:58
-- Versión del servidor: 10.1.30-MariaDB
-- Versión de PHP: 7.0.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `guestvox_development`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) NOT NULL,
  `name` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `signup_date` date NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `signup_date`, `status`) VALUES
(1, 'GuestVox', '2019-07-16', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `com_payment_invalid`
--

CREATE TABLE `com_payment_invalid` (
  `id_payment_invalid` bigint(20) NOT NULL,
  `txn_id` text CHARACTER SET latin1 NOT NULL,
  `payer_email` text CHARACTER SET latin1 NOT NULL,
  `data` longtext CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `com_payment_settings`
--

CREATE TABLE `com_payment_settings` (
  `id_setting` bigint(20) NOT NULL,
  `email_notifications` text,
  `email_paypal_account` text,
  `conekta_private_key` text,
  `conekta_public_key` text,
  `conekta_oxxopay_expires` int(11) NOT NULL DEFAULT '5',
  `currency` text NOT NULL,
  `extra_charge` int(11) DEFAULT NULL,
  `sandbox` set('1','0') NOT NULL DEFAULT '0',
  `debug` set('1','0') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `com_payment_settings`
--

INSERT INTO `com_payment_settings` (`id_setting`, `email_notifications`, `email_paypal_account`, `conekta_private_key`, `conekta_public_key`, `conekta_oxxopay_expires`, `currency`, `extra_charge`, `sandbox`, `debug`) VALUES
(1, 'paypal@guestvox.com', 'paypal@guestvox.com', NULL, NULL, 0, 'MXN', NULL, '0', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `com_payment_tmp`
--

CREATE TABLE `com_payment_tmp` (
  `id_tmp` bigint(20) NOT NULL,
  `data` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `com_payment_verified`
--

CREATE TABLE `com_payment_verified` (
  `id_payment_verified` int(11) NOT NULL,
  `payment_method` text COLLATE utf8_unicode_ci NOT NULL,
  `txn_id` text CHARACTER SET latin1 NOT NULL,
  `payer_email` text CHARACTER SET latin1 NOT NULL,
  `data` longtext CHARACTER SET latin1 NOT NULL,
  `status_payment` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) NOT NULL,
  `name` text COLLATE utf8_spanish_ci NOT NULL,
  `code` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `lada` varchar(4) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`, `lada`) VALUES
(1, '{\"es\":\"Afganistán\",\"en\":\"Afganistán\"}', 'AFG', '93'),
(2, '{\"es\":\"Albania\",\"en\":\"Albania\"}', 'ALB', '355'),
(3, '{\"es\":\"Alemania\",\"en\":\"Alemania\"}', 'DEU', '49'),
(4, '{\"es\":\"Argelia\",\"en\":\"Argelia\"}', 'DZA', '213'),
(5, '{\"es\":\"Andorra\",\"en\":\"Andorra\"}', 'AND', '376'),
(6, '{\"es\":\"Angola\",\"en\":\"Angola\"}', 'AGO', '244'),
(7, '{\"es\":\"Anguila\",\"en\":\"Anguila\"}', 'AIA', '264'),
(8, '{\"es\":\"Antártida\",\"en\":\"Antártida\"}', 'ATA', '672'),
(9, '{\"es\":\"Antigua y Barbuda\",\"en\":\"Antigua y Barbuda\"}', 'ATG', '268'),
(10, '{\"es\":\"Antillas Neerlandesas\",\"en\":\"Antillas Neerlandesas\"}', 'ANT', '599'),
(11, '{\"es\":\"Arabia Saudita\",\"en\":\"Arabia Saudita\"}', 'SAU', '966'),
(12, '{\"es\":\"Argentina\",\"en\":\"Argentina\"}', 'ARG', '54'),
(13, '{\"es\":\"Armenia\",\"en\":\"Armenia\"}', 'ARM', '374'),
(14, '{\"es\":\"Aruba\",\"en\":\"Aruba\"}', 'ABW', '297'),
(15, '{\"es\":\"Australia\",\"en\":\"Australia\"}', 'AUS', '61'),
(16, '{\"es\":\"Austria\",\"en\":\"Austria\"}', 'AUT', '43'),
(17, '{\"es\":\"Azerbayán\",\"en\":\"Azerbayán\"}', 'AZE', '994'),
(18, '{\"es\":\"Bahamas\",\"en\":\"Bahamas\"}', 'BHS', '242'),
(19, '{\"es\":\"Bahrein\",\"en\":\"Bahrein\"}', 'BHR', '973'),
(20, '{\"es\":\"Bangladesh\",\"en\":\"Bangladesh\"}', 'BGD', '880'),
(21, '{\"es\":\"Barbados\",\"en\":\"Barbados\"}', 'BRB', '246'),
(22, '{\"es\":\"Bélgica\",\"en\":\"Bélgica\"}', 'BEL', '32'),
(23, '{\"es\":\"Belice\",\"en\":\"Belice\"}', 'BLZ', '501'),
(24, '{\"es\":\"Ben\\u00edn\",\"en\":\"Ben\\u00edn\"}', 'BEN', '229'),
(25, '{\"es\":\"Bhut\\u00e1n\",\"en\":\"Bhut\\u00e1n\"}', 'BTN', '975'),
(26, '{\"es\":\"Bielorrusia\",\"en\":\"Bielorrusia\"}', 'BLR', '375'),
(27, '{\"es\":\"Birmania\",\"en\":\"Birmania\"}', 'MMR', '95'),
(28, '{\"es\":\"Bolivia\",\"en\":\"Bolivia\"}', 'BOL', '591'),
(29, '{\"es\":\"Bosnia y Herzegovina\",\"en\":\"Bosnia y Herzegovina\"}', 'BIH', '387'),
(30, '{\"es\":\"Botsuana\",\"en\":\"Botsuana\"}', 'BWA', '267'),
(31, '{\"es\":\"Brasil\",\"en\":\"Brasil\"}', 'BRA', '55'),
(32, '{\"es\":\"Brun\\u00e9i\",\"en\":\"Brun\\u00e9i\"}', 'BRN', '673'),
(33, '{\"es\":\"Bulgaria\",\"en\":\"Bulgaria\"}', 'BGR', '359'),
(34, '{\"es\":\"Burkina Faso\",\"en\":\"Burkina Faso\"}', 'BFA', '226'),
(35, '{\"es\":\"Burundi\",\"en\":\"Burundi\"}', 'BDI', '257'),
(36, '{\"es\":\"Cabo Verde\",\"en\":\"Cabo Verde\"}', 'CPV', '238'),
(37, '{\"es\":\"Camboya\",\"en\":\"Camboya\"}', 'KHM', '855'),
(38, '{\"es\":\"Camer\\u00fan\",\"en\":\"Camer\\u00fan\"}', 'CMR', '237'),
(39, '{\"es\":\"Canad\\u00e1\",\"en\":\"Canad\\u00e1\"}', 'CAN', '1'),
(40, '{\"es\":\"Chad\",\"en\":\"Chad\"}', 'TCD', '235'),
(41, '{\"es\":\"Chile\",\"en\":\"Chile\"}', 'CHL', '56'),
(42, '{\"es\":\"China\",\"en\":\"China\"}', 'CHN', '86'),
(43, '{\"es\":\"Chipre\",\"en\":\"Chipre\"}', 'CYP', '357'),
(44, '{\"es\":\"Ciudad del Vaticano\",\"en\":\"Ciudad del Vaticano\"}', 'VAT', '39'),
(45, '{\"es\":\"Colombia\",\"en\":\"Colombia\"}', 'COL', '57'),
(46, '{\"es\":\"Comoras\",\"en\":\"Comoras\"}', 'COM', '269'),
(47, '{\"es\":\"Congo\",\"en\":\"Congo\"}', 'COG', '242'),
(48, '{\"es\":\"Corea del Norte\",\"en\":\"Corea del Norte\"}', 'PRK', '850'),
(49, '{\"es\":\"Corea del Sur\",\"en\":\"Corea del Sur\"}', 'KOR', '82'),
(50, '{\"es\":\"Costa de Marfil\",\"en\":\"Costa de Marfil\"}', 'CIV', '225'),
(51, '{\"es\":\"Costa Rica\",\"en\":\"Costa Rica\"}', 'CRI', '506'),
(52, '{\"es\":\"Croacia\",\"en\":\"Croacia\"}', 'HRV', '385'),
(53, '{\"es\":\"Cuba\",\"en\":\"Cuba\"}', 'CUB', '53'),
(54, '{\"es\":\"Dinamarca\",\"en\":\"Dinamarca\"}', 'DNK', '45'),
(55, '{\"es\":\"Dominica\",\"en\":\"Dominica\"}', 'DMA', '767'),
(56, '{\"es\":\"Ecuador\",\"en\":\"Ecuador\"}', 'ECU', '593'),
(57, '{\"es\":\"Egipto\",\"en\":\"Egipto\"}', 'EGY', '20'),
(58, '{\"es\":\"El Salvador\",\"en\":\"El Salvador\"}', 'SLV', '503'),
(59, '{\"es\":\"Emiratos \\u00c1rabes Unidos\",\"en\":\"Emiratos \\u00c1rabes Unidos\"}', 'ARE', '971'),
(60, '{\"es\":\"Eritrea\",\"en\":\"Eritrea\"}', 'ERI', '291'),
(61, '{\"es\":\"Eslovaquia\",\"en\":\"Eslovaquia\"}', 'SVK', '421'),
(62, '{\"es\":\"Eslovenia\",\"en\":\"Eslovenia\"}', 'SVN', '386'),
(63, '{\"es\":\"Espa\\u00f1a\",\"en\":\"Espa\\u00f1a\"}', 'ESP', '34'),
(64, '{\"es\":\"Estados Unidos de Am\\u00e9rica\",\"en\":\"Estados Unidos de Am\\u00e9rica\"}', 'USA', '1'),
(65, '{\"es\":\"Estonia\",\"en\":\"Estonia\"}', 'EST', '372'),
(66, '{\"es\":\"Etiop\\u00eda\",\"en\":\"Etiop\\u00eda\"}', 'ETH', '251'),
(67, '{\"es\":\"Filipinas\",\"en\":\"Filipinas\"}', 'PHL', '63'),
(68, '{\"es\":\"Finlandia\",\"en\":\"Finlandia\"}', 'FIN', '358'),
(69, '{\"es\":\"Fiyi\",\"en\":\"Fiyi\"}', 'FJI', '679'),
(70, '{\"es\":\"Francia\",\"en\":\"Francia\"}', 'FRA', '33'),
(71, '{\"es\":\"Gab\\u00f3n\",\"en\":\"Gab\\u00f3n\"}', 'GAB', '241'),
(72, '{\"es\":\"Gambia\",\"en\":\"Gambia\"}', 'GMB', '220'),
(73, '{\"es\":\"Georgia\",\"en\":\"Georgia\"}', 'GEO', '995'),
(74, '{\"es\":\"Ghana\",\"en\":\"Ghana\"}', 'GHA', '233'),
(75, '{\"es\":\"Gibraltar\",\"en\":\"Gibraltar\"}', 'GIB', '350'),
(76, '{\"es\":\"Granada\",\"en\":\"Granada\"}', 'GRD', '473'),
(77, '{\"es\":\"Grecia\",\"en\":\"Grecia\"}', 'GRC', '30'),
(78, '{\"es\":\"Groenlandia\",\"en\":\"Groenlandia\"}', 'GRL', '299'),
(79, '{\"es\":\"Guadalupe\",\"en\":\"Guadalupe\"}', 'GLP', '0'),
(80, '{\"es\":\"Guam\",\"en\":\"Guam\"}', 'GUM', '671'),
(81, '{\"es\":\"Guatemala\",\"en\":\"Guatemala\"}', 'GTM', '502'),
(82, '{\"es\":\"Guayana Francesa\",\"en\":\"Guayana Francesa\"}', 'GUF', '0'),
(83, '{\"es\":\"Guernsey\",\"en\":\"Guernsey\"}', 'GGY', '0'),
(84, '{\"es\":\"Guinea\",\"en\":\"Guinea\"}', 'GIN', '224'),
(85, '{\"es\":\"Guinea Ecuatorial\",\"en\":\"Guinea Ecuatorial\"}', 'GNQ', '240'),
(86, '{\"es\":\"Guinea-Bissau\",\"en\":\"Guinea-Bissau\"}', 'GNB', '245'),
(87, '{\"es\":\"Guyana\",\"en\":\"Guyana\"}', 'GUY', '592'),
(88, '{\"es\":\"Hait\\u00ed\",\"en\":\"Hait\\u00ed\"}', 'HTI', '509'),
(89, '{\"es\":\"Honduras\",\"en\":\"Honduras\"}', 'HND', '504'),
(90, '{\"es\":\"Hong kong\",\"en\":\"Hong kong\"}', 'HKG', '852'),
(91, '{\"es\":\"Hungr\\u00eda\",\"en\":\"Hungr\\u00eda\"}', 'HUN', '36'),
(92, '{\"es\":\"India\",\"en\":\"India\"}', 'IND', '91'),
(93, '{\"es\":\"Indonesia\",\"en\":\"Indonesia\"}', 'IDN', '62'),
(94, '{\"es\":\"Irak\",\"en\":\"Irak\"}', 'IRQ', '964'),
(95, '{\"es\":\"Ir\\u00e1n\",\"en\":\"Ir\\u00e1n\"}', 'IRN', '98'),
(96, '{\"es\":\"Irlanda\",\"en\":\"Irlanda\"}', 'IRL', '353'),
(97, '{\"es\":\"Isla Bouvet\",\"en\":\"Isla Bouvet\"}', 'BVT', '0'),
(98, '{\"es\":\"Isla de Man\",\"en\":\"Isla de Man\"}', 'IMN', '44'),
(99, '{\"es\":\"Isla de Navidad\",\"en\":\"Isla de Navidad\"}', 'CXR', '61'),
(100, '{\"es\":\"Isla Norfolk\",\"en\":\"Isla Norfolk\"}', 'NFK', '0'),
(101, '{\"es\":\"Islandia\",\"en\":\"Islandia\"}', 'ISL', '354'),
(102, '{\"es\":\"Islas Bermudas\",\"en\":\"Islas Bermudas\"}', 'BMU', '441'),
(103, '{\"es\":\"Islas Caim\\u00e1n\",\"en\":\"Islas Caim\\u00e1n\"}', 'CYM', '345'),
(104, '{\"es\":\"Islas Cocos (Keeling)\",\"en\":\"Islas Cocos (Keeling)\"}', 'CCK', '61'),
(105, '{\"es\":\"Islas Cook\",\"en\":\"Islas Cook\"}', 'COK', '682'),
(106, '{\"es\":\"Islas de \\u00c5land\",\"en\":\"Islas de \\u00c5land\"}', 'ALA', '0'),
(107, '{\"es\":\"Islas Feroe\",\"en\":\"Islas Feroe\"}', 'FRO', '298'),
(108, '{\"es\":\"Islas Georgias del Sur y Sandwich del Sur\",\"en\":\"Islas Georgias del Sur y Sandwich del Sur\"}', 'SGS', '0'),
(109, '{\"es\":\"Islas Heard y McDonald\",\"en\":\"Islas Heard y McDonald\"}', 'HMD', '0'),
(110, '{\"es\":\"Islas Maldivas\",\"en\":\"Islas Maldivas\"}', 'MDV', '960'),
(111, '{\"es\":\"Islas Malvinas\",\"en\":\"Islas Malvinas\"}', 'FLK', '500'),
(112, '{\"es\":\"Islas Marianas del Norte\",\"en\":\"Islas Marianas del Norte\"}', 'MNP', '670'),
(113, '{\"es\":\"Islas Marshall\",\"en\":\"Islas Marshall\"}', 'MHL', '692'),
(114, '{\"es\":\"Islas Pitcairn\",\"en\":\"Islas Pitcairn\"}', 'PCN', '870'),
(115, '{\"es\":\"Islas Salom\\u00f3n\",\"en\":\"Islas Salom\\u00f3n\"}', 'SLB', '677'),
(116, '{\"es\":\"Islas Turcas y Caicos\",\"en\":\"Islas Turcas y Caicos\"}', 'TCA', '649'),
(117, '{\"es\":\"Islas Ultramarinas Menores de Estados Unidos\",\"en\":\"Islas Ultramarinas Menores de Estados Unidos\"}', 'UMI', '0'),
(118, '{\"es\":\"Islas V\\u00edrgenes Brit\\u00e1nicas\",\"en\":\"Islas V\\u00edrgenes Brit\\u00e1nicas\"}', 'VG', '284'),
(119, '{\"es\":\"Islas V\\u00edrgenes de los Estados Unidos\",\"en\":\"Islas V\\u00edrgenes de los Estados Unidos\"}', 'VIR', '340'),
(120, '{\"es\":\"Israel\",\"en\":\"Israel\"}', 'ISR', '972'),
(121, '{\"es\":\"Italia\",\"en\":\"Italia\"}', 'ITA', '39'),
(122, '{\"es\":\"Jamaica\",\"en\":\"Jamaica\"}', 'JAM', '876'),
(123, '{\"es\":\"Jap\\u00f3n\",\"en\":\"Jap\\u00f3n\"}', 'JPN', '81'),
(124, '{\"es\":\"Jersey\",\"en\":\"Jersey\"}', 'JEY', '0'),
(125, '{\"es\":\"Jordania\",\"en\":\"Jordania\"}', 'JOR', '962'),
(126, '{\"es\":\"Kazajist\\u00e1n\",\"en\":\"Kazajist\\u00e1n\"}', 'KAZ', '7'),
(127, '{\"es\":\"Kenia\",\"en\":\"Kenia\"}', 'KEN', '254'),
(128, '{\"es\":\"Kirgizst\\u00e1n\",\"en\":\"Kirgizst\\u00e1n\"}', 'KGZ', '996'),
(129, '{\"es\":\"Kiribati\",\"en\":\"Kiribati\"}', 'KIR', '686'),
(130, '{\"es\":\"Kuwait\",\"en\":\"Kuwait\"}', 'KWT', '965'),
(131, '{\"es\":\"Laos\",\"en\":\"Laos\"}', 'LAO', '856'),
(132, '{\"es\":\"Lesoto\",\"en\":\"Lesoto\"}', 'LSO', '266'),
(133, '{\"es\":\"Letonia\",\"en\":\"Letonia\"}', 'LVA', '371'),
(134, '{\"es\":\"L\\u00edbano\",\"en\":\"L\\u00edbano\"}', 'LBN', '961'),
(135, '{\"es\":\"Liberia\",\"en\":\"Liberia\"}', 'LBR', '231'),
(136, '{\"es\":\"Libia\",\"en\":\"Libia\"}', 'LBY', '218'),
(137, '{\"es\":\"Liechtenstein\",\"en\":\"Liechtenstein\"}', 'LIE', '423'),
(138, '{\"es\":\"Lituania\",\"en\":\"Lituania\"}', 'LTU', '370'),
(139, '{\"es\":\"Luxemburgo\",\"en\":\"Luxemburgo\"}', 'LUX', '352'),
(140, '{\"es\":\"Macao\",\"en\":\"Macao\"}', 'MAC', '853'),
(141, '{\"es\":\"Maced\\u00f4nia\",\"en\":\"Maced\\u00f4nia\"}', 'MKD', '389'),
(142, '{\"es\":\"Madagascar\",\"en\":\"Madagascar\"}', 'MDG', '261'),
(143, '{\"es\":\"Malasia\",\"en\":\"Malasia\"}', 'MYS', '60'),
(144, '{\"es\":\"Malawi\",\"en\":\"Malawi\"}', 'MWI', '265'),
(145, '{\"es\":\"Mali\",\"en\":\"Mali\"}', 'MLI', '223'),
(146, '{\"es\":\"Malta\",\"en\":\"Malta\"}', 'MLT', '356'),
(147, '{\"es\":\"Marruecos\",\"en\":\"Marruecos\"}', 'MAR', '212'),
(148, '{\"es\":\"Martinica\",\"en\":\"Martinica\"}', 'MTQ', '0'),
(149, '{\"es\":\"Mauricio\",\"en\":\"Mauricio\"}', 'MUS', '230'),
(150, '{\"es\":\"Mauritania\",\"en\":\"Mauritania\"}', 'MRT', '222'),
(151, '{\"es\":\"Mayotte\",\"en\":\"Mayotte\"}', 'MYT', '262'),
(152, '{\"es\":\"M\\u00e9xico\",\"en\":\"M\\u00e9xico\"}', 'MEX', '52'),
(153, '{\"es\":\"Micronesia\",\"en\":\"Micronesia\"}', 'FSM', '691'),
(154, '{\"es\":\"Moldavia\",\"en\":\"Moldavia\"}', 'MDA', '373'),
(155, '{\"es\":\"M\\u00f3naco\",\"en\":\"M\\u00f3naco\"}', 'MCO', '377'),
(156, '{\"es\":\"Mongolia\",\"en\":\"Mongolia\"}', 'MNG', '976'),
(157, '{\"es\":\"Montenegro\",\"en\":\"Montenegro\"}', 'MNE', '382'),
(158, '{\"es\":\"Montserrat\",\"en\":\"Montserrat\"}', 'MSR', '664'),
(159, '{\"es\":\"Mozambique\",\"en\":\"Mozambique\"}', 'MOZ', '258'),
(160, '{\"es\":\"Namibia\",\"en\":\"Namibia\"}', 'NAM', '264'),
(161, '{\"es\":\"Nauru\",\"en\":\"Nauru\"}', 'NRU', '674'),
(162, '{\"es\":\"Nepal\",\"en\":\"Nepal\"}', 'NPL', '977'),
(163, '{\"es\":\"Nicaragua\",\"en\":\"Nicaragua\"}', 'NIC', '505'),
(164, '{\"es\":\"Niger\",\"en\":\"Niger\"}', 'NER', '227'),
(165, '{\"es\":\"Nigeria\",\"en\":\"Nigeria\"}', 'NGA', '234'),
(166, '{\"es\":\"Niue\",\"en\":\"Niue\"}', 'NIU', '683'),
(168, '{\"es\":\"Noruega\",\"en\":\"Noruega\"}', 'NOR', '47'),
(169, '{\"es\":\"Nueva Caledonia\",\"en\":\"Nueva Caledonia\"}', 'NCL', '687'),
(170, '{\"es\":\"Nueva Zelanda\",\"en\":\"Nueva Zelanda\"}', 'NZL', '64'),
(171, '{\"es\":\"Om\\u00e1n\",\"en\":\"Om\\u00e1n\"}', 'OMN', '968'),
(172, '{\"es\":\"Pa\\u00edses Bajos\",\"en\":\"Pa\\u00edses Bajos\"}', 'NLD', '31'),
(173, '{\"es\":\"Pakist\\u00e1n\",\"en\":\"Pakist\\u00e1n\"}', 'PAK', '92'),
(174, '{\"es\":\"Palau\",\"en\":\"Palau\"}', 'PLW', '680'),
(175, '{\"es\":\"Palestina\",\"en\":\"Palestina\"}', 'PSE', '0'),
(176, '{\"es\":\"Panam\\u00e1\",\"en\":\"Panam\\u00e1\"}', 'PAN', '507'),
(177, '{\"es\":\"Pap\\u00faa Nueva Guinea\",\"en\":\"Pap\\u00faa Nueva Guinea\"}', 'PNG', '675'),
(178, '{\"es\":\"Paraguay\",\"en\":\"Paraguay\"}', 'PRY', '595'),
(179, '{\"es\":\"Per\\u00fa\",\"en\":\"Per\\u00fa\"}', 'PER', '51'),
(180, '{\"es\":\"Polinesia Francesa\",\"en\":\"Polinesia Francesa\"}', 'PYF', '689'),
(181, '{\"es\":\"Polonia\",\"en\":\"Polonia\"}', 'POL', '48'),
(182, '{\"es\":\"Portugal\",\"en\":\"Portugal\"}', 'PRT', '351'),
(183, '{\"es\":\"Puerto Rico\",\"en\":\"Puerto Rico\"}', 'PRI', '787'),
(184, '{\"es\":\"Qatar\",\"en\":\"Qatar\"}', 'QAT', '974'),
(185, '{\"es\":\"Reino Unido\",\"en\":\"Reino Unido\"}', 'GBR', '44'),
(186, '{\"es\":\"Rep\\u00fablica Centroafricana\",\"en\":\"Rep\\u00fablica Centroafricana\"}', 'CAF', '236'),
(187, '{\"es\":\"Rep\\u00fablica Checa\",\"en\":\"Rep\\u00fablica Checa\"}', 'CZE', '420'),
(188, '{\"es\":\"Rep\\u00fablica Dominicana\",\"en\":\"Rep\\u00fablica Dominicana\"}', 'DOM', '809'),
(189, '{\"es\":\"Reuni\\u00f3n\",\"en\":\"Reuni\\u00f3n\"}', 'REU', '0'),
(190, '{\"es\":\"Ruanda\",\"en\":\"Ruanda\"}', 'RWA', '250'),
(191, '{\"es\":\"Ruman\\u00eda\",\"en\":\"Ruman\\u00eda\"}', 'ROU', '40'),
(192, '{\"es\":\"Rusia\",\"en\":\"Rusia\"}', 'RUS', '7'),
(193, '{\"es\":\"Sahara Occidental\",\"en\":\"Sahara Occidental\"}', 'ESH', '0'),
(194, '{\"es\":\"Samoa\",\"en\":\"Samoa\"}', 'WSM', '685'),
(195, '{\"es\":\"Samoa Americana\",\"en\":\"Samoa Americana\"}', 'ASM', '684'),
(196, '{\"es\":\"San Bartolom\\u00e9\",\"en\":\"San Bartolom\\u00e9\"}', 'BLM', '590'),
(197, '{\"es\":\"San Crist\\u00f3bal y Nieves\",\"en\":\"San Crist\\u00f3bal y Nieves\"}', 'KNA', '869'),
(198, '{\"es\":\"San Marino\",\"en\":\"San Marino\"}', 'SMR', '378'),
(199, '{\"es\":\"San Mart\\u00edn (Francia)\",\"en\":\"San Mart\\u00edn (Francia)\"}', 'MAF', '599'),
(200, '{\"es\":\"San Pedro y Miquel\\u00f3n\",\"en\":\"San Pedro y Miquel\\u00f3n\"}', 'SPM', '508'),
(201, '{\"es\":\"San Vicente y las Granadinas\",\"en\":\"San Vicente y las Granadinas\"}', 'VCT', '784'),
(202, '{\"es\":\"Santa Elena\",\"en\":\"Santa Elena\"}', 'SHN', '290'),
(203, '{\"es\":\"Santa Luc\\u00eda\",\"en\":\"Santa Luc\\u00eda\"}', 'LCA', '758'),
(204, '{\"es\":\"Santo Tom\\u00e9 y Pr\\u00edncipe\",\"en\":\"Santo Tom\\u00e9 y Pr\\u00edncipe\"}', 'STP', '239'),
(205, '{\"es\":\"Senegal\",\"en\":\"Senegal\"}', 'SEN', '221'),
(206, '{\"es\":\"Serbia\",\"en\":\"Serbia\"}', 'SRB', '381'),
(207, '{\"es\":\"Seychelles\",\"en\":\"Seychelles\"}', 'SYC', '248'),
(208, '{\"es\":\"Sierra Leona\",\"en\":\"Sierra Leona\"}', 'SLE', '232'),
(209, '{\"es\":\"Singapur\",\"en\":\"Singapur\"}', 'SGP', '65'),
(210, '{\"es\":\"Siria\",\"en\":\"Siria\"}', 'SYR', '963'),
(211, '{\"es\":\"Somalia\",\"en\":\"Somalia\"}', 'SOM', '252'),
(212, '{\"es\":\"Sri lanka\",\"en\":\"Sri lanka\"}', 'LKA', '94'),
(213, '{\"es\":\"Sud\\u00e1frica\",\"en\":\"Sud\\u00e1frica\"}', 'ZAF', '27'),
(214, '{\"es\":\"Sud\\u00e1n\",\"en\":\"Sud\\u00e1n\"}', 'SDN', '249'),
(215, '{\"es\":\"Suecia\",\"en\":\"Suecia\"}', 'SWE', '46'),
(216, '{\"es\":\"Suiza\",\"en\":\"Suiza\"}', 'CHE', '41'),
(217, '{\"es\":\"Surin\\u00e1m\",\"en\":\"Surin\\u00e1m\"}', 'SUR', '597'),
(218, '{\"es\":\"Svalbard y Jan Mayen\",\"en\":\"Svalbard y Jan Mayen\"}', 'SJM', '0'),
(219, '{\"es\":\"Swazilandia\",\"en\":\"Swazilandia\"}', 'SWZ', '268'),
(220, '{\"es\":\"Tadjikist\\u00e1n\",\"en\":\"Tadjikist\\u00e1n\"}', 'TJK', '992'),
(221, '{\"es\":\"Tailandia\",\"en\":\"Tailandia\"}', 'THA', '66'),
(222, '{\"es\":\"Taiw\\u00e1n\",\"en\":\"Taiw\\u00e1n\"}', 'TWN', '886'),
(223, '{\"es\":\"Tanzania\",\"en\":\"Tanzania\"}', 'TZA', '255'),
(224, '{\"es\":\"Territorio Brit\\u00e1nico del Oc\\u00e9ano \\u00cdndico\",\"en\":\"Territorio Brit\\u00e1nico del Oc\\u00e9ano \\u00cdndico\"}', 'IOT', '0'),
(225, '{\"es\":\"Territorios Australes y Ant\\u00e1rticas Franceses\",\"en\":\"Territorios Australes y Ant\\u00e1rticas Franceses\"}', 'ATF', '0'),
(226, '{\"es\":\"Timor Oriental\",\"en\":\"Timor Oriental\"}', 'TLS', '670'),
(227, '{\"es\":\"Togo\",\"en\":\"Togo\"}', 'TGO', '228'),
(228, '{\"es\":\"Tokelau\",\"en\":\"Tokelau\"}', 'TKL', '690'),
(229, '{\"es\":\"Tonga\",\"en\":\"Tonga\"}', 'TON', '676'),
(230, '{\"es\":\"Trinidad y Tobago\",\"en\":\"Trinidad y Tobago\"}', 'TTO', '868'),
(231, '{\"es\":\"Tunez\",\"en\":\"Tunez\"}', 'TUN', '216'),
(232, '{\"es\":\"Turkmenist\\u00e1n\",\"en\":\"Turkmenist\\u00e1n\"}', 'TKM', '993'),
(233, '{\"es\":\"Turqu\\u00eda\",\"en\":\"Turqu\\u00eda\"}', 'TUR', '90'),
(234, '{\"es\":\"Tuvalu\",\"en\":\"Tuvalu\"}', 'TUV', '688'),
(235, '{\"es\":\"Ucrania\",\"en\":\"Ucrania\"}', 'UKR', '380'),
(236, '{\"es\":\"Uganda\",\"en\":\"Uganda\"}', 'UGA', '256'),
(237, '{\"es\":\"Uruguay\",\"en\":\"Uruguay\"}', 'URY', '598'),
(238, '{\"es\":\"Uzbekist\\u00e1n\",\"en\":\"Uzbekist\\u00e1n\"}', 'UZB', '998'),
(239, '{\"es\":\"Vanuatu\",\"en\":\"Vanuatu\"}', 'VUT', '678'),
(240, '{\"es\":\"Venezuela\",\"en\":\"Venezuela\"}', 'VEN', '58'),
(241, '{\"es\":\"Vietnam\",\"en\":\"Vietnam\"}', 'VNM', '84'),
(242, '{\"es\":\"Wallis y Futuna\",\"en\":\"Wallis y Futuna\"}', 'WLF', '681'),
(243, '{\"es\":\"Yemen\",\"en\":\"Yemen\"}', 'YEM', '967'),
(244, '{\"es\":\"Yibuti\",\"en\":\"Yibuti\"}', 'DJI', '253'),
(245, '{\"es\":\"Zambia\",\"en\":\"Zambia\"}', 'ZMB', '260'),
(246, '{\"es\":\"Zimbabue\",\"en\":\"Zimbabue\"}', 'ZWE', '263');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) NOT NULL,
  `name` text COLLATE utf8_spanish_ci NOT NULL,
  `code` varchar(4) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `code`) VALUES
(1, '{\"es\":\"Afgani afgano\",\"en\":\"Afgani afgano\"}', 'AFN'),
(2, '{\"es\":\"Lek alban\\u00e9s\",\"en\":\"Lek alban\\u00e9s\"}', 'ALL'),
(3, '{\"es\":\"Euro\",\"en\":\"Euro\"}', 'EUR'),
(4, '{\"es\":\"Euro\",\"en\":\"Euro\"}', 'EUR'),
(5, '{\"es\":\"Kwanza angole\\u00f1o\",\"en\":\"Kwanza angole\\u00f1o\"}', 'AOA'),
(6, '{\"es\":\"D\\u00f3lar del Caribe Oriental\",\"en\":\"D\\u00f3lar del Caribe Oriental\"}', 'XCD'),
(7, '{\"es\":\"Riyal saud\\u00ed\",\"en\":\"Riyal saud\\u00ed\"}', 'SAR'),
(8, '{\"es\":\"Dinar argelino\",\"en\":\"Dinar argelino\"}', 'DZD'),
(9, '{\"es\":\"Peso\",\"en\":\"Peso\"}', 'ARS'),
(10, '{\"es\":\"Dram armenio\",\"en\":\"Dram armenio\"}', 'AMD'),
(11, '{\"es\":\"D\\u00f3lar australiano\",\"en\":\"D\\u00f3lar australiano\"}', 'AUD'),
(12, '{\"es\":\"Euro\",\"en\":\"Euro\"}', 'EUR'),
(13, '{\"es\":\"Manat azer\\u00ed\",\"en\":\"Manat azer\\u00ed\"}', 'AZN'),
(14, '{\"es\":\"D\\u00f3lar bahame\\u00f1o\",\"en\":\"D\\u00f3lar bahame\\u00f1o\"}', 'BSD'),
(15, '{\"es\":\"Taka bangladesh\\u00ed\",\"en\":\"Taka bangladesh\\u00ed\"}', 'BDT'),
(16, '{\"es\":\"D\\u00f3lar de Barbados\",\"en\":\"D\\u00f3lar de Barbados\"}', 'BBD'),
(17, '{\"es\":\"Dinar bahrein\\u00ed\",\"en\":\"Dinar bahrein\\u00ed\"}', 'BHD'),
(18, '{\"es\":\"Euro\",\"en\":\"Euro\"}', 'EUR'),
(19, '{\"es\":\"D\\u00f3lar belice\\u00f1o\",\"en\":\"D\\u00f3lar belice\\u00f1o\"}', 'BZD'),
(20, '{\"es\":\"Franco CFA de \\u00c1frica Occidental\",\"en\":\"Franco CFA de \\u00c1frica Occidental\"}', 'XOF'),
(21, '{\"es\":\"Rublo bielorruso\",\"en\":\"Rublo bielorruso\"}', 'BYN'),
(22, '{\"es\":\"Kyat birmano\",\"en\":\"Kyat birmano\"}', 'MMK'),
(23, '{\"es\":\"Boliviano\",\"en\":\"Boliviano\"}', 'BOB'),
(24, '{\"es\":\"Marco convertible\",\"en\":\"Marco convertible\"}', 'BAM'),
(25, '{\"es\":\"Pula\",\"en\":\"Pula\"}', 'BWP'),
(26, '{\"es\":\"Real brasile\\u00f1o\",\"en\":\"Real brasile\\u00f1o\"}', 'BRL'),
(27, '{\"es\":\"D\\u00f3lar de Brun\\u00e9i\",\"en\":\"D\\u00f3lar de Brun\\u00e9i\"}', 'BND'),
(28, '{\"es\":\"Lev b\\u00falgaro\",\"en\":\"Lev b\\u00falgaro\"}', 'BGN'),
(29, '{\"es\":\"Franco CFA de \\u00c1frica Occidental\",\"en\":\"Franco CFA de \\u00c1frica Occidental\"}', 'XOF'),
(30, '{\"es\":\"Franco de Burundi\",\"en\":\"Franco de Burundi\"}', 'BIF'),
(31, '{\"es\":\"Ngultrum butan\\u00e9s\",\"en\":\"Ngultrum butan\\u00e9s\"}', 'BTN'),
(32, '{\"es\":\"Escudo caboverdiano\",\"en\":\"Escudo caboverdiano\"}', 'CVE'),
(33, '{\"es\":\"Riel camboyano\",\"en\":\"Riel camboyano\"}', 'KHR'),
(34, '{\"es\":\"Franco CFA de \\u00c1frica Central\",\"en\":\"Franco CFA de \\u00c1frica Central\"}', 'XAF'),
(35, '{\"es\":\"D\\u00f3lar canadiense\",\"en\":\"D\\u00f3lar canadiense\"}', 'CAD'),
(36, '{\"es\":\"Riyal qatar\\u00ed\",\"en\":\"Riyal qatar\\u00ed\"}', 'QAR'),
(37, '{\"es\":\"Franco CFA de \\u00c1frica Central\",\"en\":\"Franco CFA de \\u00c1frica Central\"}', 'XAF'),
(38, '{\"es\":\"Peso chileno\",\"en\":\"Peso chileno\"}', 'CLP'),
(39, '{\"es\":\"Yuan chino\",\"en\":\"Yuan chino\"}', 'CNY'),
(40, '{\"es\":\"Euro\",\"en\":\"Euro\"}', 'EUR'),
(41, '{\"es\":\"Peso colombiano\",\"en\":\"Peso colombiano\"}', 'COP'),
(42, '{\"es\":\"Franco comorano\",\"en\":\"Franco comorano\"}', 'KMF'),
(43, '{\"es\":\"Franco CFA de \\u00c1frica Central\",\"en\":\"Franco CFA de \\u00c1frica Central\"}', 'XAF'),
(44, '{\"es\":\"Won norcoreano\",\"en\":\"Won norcoreano\"}', 'KPW'),
(45, '{\"es\":\"Won surcoreano\",\"en\":\"Won surcoreano\"}', 'KRW'),
(46, '{\"es\":\"Franco CFA de \\u00c1frica Occidental\",\"en\":\"Franco CFA de \\u00c1frica Occidental\"}', 'XOF'),
(47, '{\"es\":\"Col\\u00f3n costarricense\",\"en\":\"Col\\u00f3n costarricense\"}', 'CRC'),
(48, '{\"es\":\"Kuna croata\",\"en\":\"Kuna croata\"}', 'HRK'),
(49, '{\"es\":\"Peso cubano\",\"en\":\"Peso cubano\"}', 'CUP'),
(50, '{\"es\":\"Corona danesa\",\"en\":\"Corona danesa\"}', 'DKK'),
(51, '{\"es\":\"D\\u00f3lar del Caribe Oriental\",\"en\":\"D\\u00f3lar del Caribe Oriental\"}', 'XCD'),
(52, '{\"es\":\"D\\u00f3lar estadounidense\",\"en\":\"D\\u00f3lar estadounidense\"}', 'USD'),
(53, '{\"es\":\"Libra egipcia\",\"en\":\"Libra egipcia\"}', 'EGP'),
(54, '{\"es\":\"D\\u00f3lar estadounidense\",\"en\":\"D\\u00f3lar estadounidense\"}', 'USD'),
(55, '{\"es\":\"Dirham de los Emiratos \\u00c1rabes Unidos\",\"en\":\"Dirham de los Emiratos \\u00c1rabes Unidos\"}', 'AED'),
(56, '{\"es\":\"Nakfa\",\"en\":\"Nakfa\"}', 'ERN'),
(57, '{\"es\":\"Euro\",\"en\":\"Euro\"}', 'EUR'),
(58, '{\"es\":\"Euro\",\"en\":\"Euro\"}', 'EUR'),
(59, '{\"es\":\"Euro\",\"en\":\"Euro\"}', 'EUR'),
(60, '{\"es\":\"D\\u00f3lar estadounidense\",\"en\":\"D\\u00f3lar estadounidense\"}', 'USD'),
(61, '{\"es\":\"Euro\",\"en\":\"Euro\"}', 'EUR'),
(62, '{\"es\":\"Birr et\\u00edope\",\"en\":\"Birr et\\u00edope\"}', 'ETB'),
(63, '{\"es\":\"Peso filipino\",\"en\":\"Peso filipino\"}', 'PHP'),
(64, '{\"es\":\"Euro\",\"en\":\"Euro\"}', 'EUR'),
(65, '{\"es\":\"D\\u00f3lar fiyiano\",\"en\":\"D\\u00f3lar fiyiano\"}', 'FJD'),
(66, '{\"es\":\"Euro\",\"en\":\"Euro\"}', 'EUR'),
(67, '{\"es\":\"Franco CFA de \\u00c1frica Central\",\"en\":\"Franco CFA de \\u00c1frica Central\"}', 'XAF'),
(68, '{\"es\":\"Dalasi\",\"en\":\"Dalasi\"}', 'GMD'),
(69, '{\"es\":\"Lari georgiano\",\"en\":\"Lari georgiano\"}', 'GEL'),
(70, '{\"es\":\"Cedi\",\"en\":\"Cedi\"}', 'GHS'),
(71, '{\"es\":\"D\\u00f3lar del Caribe Oriental\",\"en\":\"D\\u00f3lar del Caribe Oriental\"}', 'XCD'),
(72, '{\"es\":\"Euro\",\"en\":\"Euro\"}', 'EUR'),
(73, '{\"es\":\"Quetzal guatemalteco\",\"en\":\"Quetzal guatemalteco\"}', 'GTQ'),
(74, '{\"es\":\"Franco guineano\",\"en\":\"Franco guineano\"}', 'GNF'),
(75, '{\"es\":\"Franco CFA de \\u00c1frica Central\",\"en\":\"Franco CFA de \\u00c1frica Central\"}', 'XAF'),
(76, '{\"es\":\"Franco CFA de \\u00c1frica Occidental\",\"en\":\"Franco CFA de \\u00c1frica Occidental\"}', 'XOF'),
(77, '{\"es\":\"D\\u00f3lar guyan\\u00e9s\",\"en\":\"D\\u00f3lar guyan\\u00e9s\"}', 'GYD'),
(78, '{\"es\":\"Gourde haitiano\",\"en\":\"Gourde haitiano\"}', 'HTG'),
(79, '{\"es\":\"Lempira hondure\\u00f1o\",\"en\":\"Lempira hondure\\u00f1o\"}', 'HNL'),
(80, '{\"es\":\"Forinto h\\u00fangaro\",\"en\":\"Forinto h\\u00fangaro\"}', 'HUF'),
(81, '{\"es\":\"Rupia india\",\"en\":\"Rupia india\"}', 'INR'),
(82, '{\"es\":\"Rupia indonesia\",\"en\":\"Rupia indonesia\"}', 'IDR'),
(83, '{\"es\":\"Dinar iraqu\\u00ed\",\"en\":\"Dinar iraqu\\u00ed\"}', 'IQD'),
(84, '{\"es\":\"Rial iran\\u00ed\",\"en\":\"Rial iran\\u00ed\"}', 'IRR'),
(85, '{\"es\":\"Euro\",\"en\":\"Euro\"}', 'EUR'),
(86, '{\"es\":\"Corona islandes\",\"en\":\"Corona islandes\"}', 'ISK'),
(87, '{\"es\":\"D\\u00f3lar estadounidense\",\"en\":\"D\\u00f3lar estadounidense\"}', 'USD'),
(88, '{\"es\":\"D\\u00f3lar de las Islas Salom\\u00f3n\",\"en\":\"D\\u00f3lar de las Islas Salom\\u00f3n\"}', 'SBD'),
(89, '{\"es\":\"Nuevo sh\\u00e9quel\",\"en\":\"Nuevo sh\\u00e9quel\"}', 'ILS'),
(90, '{\"es\":\"Euro\",\"en\":\"Euro\"}', 'EUR'),
(91, '{\"es\":\"D\\u00f3lar jamaiquino\",\"en\":\"D\\u00f3lar jamaiquino\"}', 'JMD'),
(92, '{\"es\":\"Yen\",\"en\":\"Yen\"}', 'JPY'),
(93, '{\"es\":\"Dinar jordano\",\"en\":\"Dinar jordano\"}', 'JOD'),
(94, '{\"es\":\"Tenge kazajo\",\"en\":\"Tenge kazajo\"}', 'KZT'),
(95, '{\"es\":\"Chel\\u00edn keniano\",\"en\":\"Chel\\u00edn keniano\"}', 'KES'),
(96, '{\"es\":\"Som kirgu\\u00eds\",\"en\":\"Som kirgu\\u00eds\"}', 'KGS'),
(97, '{\"es\":\"D\\u00f3lar australiano\",\"en\":\"D\\u00f3lar australiano\"}', 'AUD'),
(98, '{\"es\":\"Euro\",\"en\":\"Euro\"}', 'EUR'),
(99, '{\"es\":\"Dinar kuwait\\u00ed\",\"en\":\"Dinar kuwait\\u00ed\"}', 'KWD'),
(100, '{\"es\":\"Kip laosiano\",\"en\":\"Kip laosiano\"}', 'LAK'),
(101, '{\"es\":\"Loti\",\"en\":\"Loti\"}', 'LSL'),
(102, '{\"es\":\"Euro\",\"en\":\"Euro\"}', 'EUR'),
(103, '{\"es\":\"Libra libanesa\",\"en\":\"Libra libanesa\"}', 'LBP'),
(104, '{\"es\":\"D\\u00f3lar liberiano\",\"en\":\"D\\u00f3lar liberiano\"}', 'LRD'),
(105, '{\"es\":\"Dinar libio\",\"en\":\"Dinar libio\"}', 'LYD'),
(106, '{\"es\":\"Franco suizo\",\"en\":\"Franco suizo\"}', 'CHF'),
(107, '{\"es\":\"Euro\",\"en\":\"Euro\"}', 'EUR'),
(108, '{\"es\":\"Euro\",\"en\":\"Euro\"}', 'EUR'),
(109, '{\"es\":\"Denar macedonio\",\"en\":\"Denar macedonio\"}', 'MKD'),
(110, '{\"es\":\"Ariary malgache\",\"en\":\"Ariary malgache\"}', 'MGA'),
(111, '{\"es\":\"Ringgit malayo\",\"en\":\"Ringgit malayo\"}', 'MYR'),
(112, '{\"es\":\"Kwacha malau\\u00ed\",\"en\":\"Kwacha malau\\u00ed\"}', 'MWK'),
(113, '{\"es\":\"Rupia de Maldivas\",\"en\":\"Rupia de Maldivas\"}', 'MVR'),
(114, '{\"es\":\"Franco CFA de \\u00c1frica Occidental\",\"en\":\"Franco CFA de \\u00c1frica Occidental\"}', 'XOF'),
(115, '{\"es\":\"Euro\",\"en\":\"Euro\"}', 'EUR'),
(116, '{\"es\":\"Dirham marroqu\\u00ed\",\"en\":\"Dirham marroqu\\u00ed\"}', 'MAD'),
(117, '{\"es\":\"Rupia de Mauricio\",\"en\":\"Rupia de Mauricio\"}', 'MUR'),
(118, '{\"es\":\"Uguiya\",\"en\":\"Uguiya\"}', 'MRO'),
(119, '{\"es\":\"Peso mexicano\",\"en\":\"Peso mexicano\"}', 'MXN'),
(120, '{\"es\":\"D\\u00f3lar estadounidense\",\"en\":\"D\\u00f3lar estadounidense\"}', 'USD'),
(121, '{\"es\":\"Leu moldavo\",\"en\":\"Leu moldavo\"}', 'MDL'),
(122, '{\"es\":\"Euro\",\"en\":\"Euro\"}', 'EUR'),
(123, '{\"es\":\"Tugrik mongol\",\"en\":\"Tugrik mongol\"}', 'MNT'),
(124, '{\"es\":\"Euro\",\"en\":\"Euro\"}', 'EUR'),
(125, '{\"es\":\"Metical mozambique\\u00f1o\",\"en\":\"Metical mozambique\\u00f1o\"}', 'MZN'),
(126, '{\"es\":\"D\\u00f3lar namibio\",\"en\":\"D\\u00f3lar namibio\"}', 'NAD'),
(127, '{\"es\":\"D\\u00f3lar australiano\",\"en\":\"D\\u00f3lar australiano\"}', 'AUD'),
(128, '{\"es\":\"Rupia nepal\\u00ed\",\"en\":\"Rupia nepal\\u00ed\"}', 'NPR'),
(129, '{\"es\":\"C\\u00f3rdoba nicarag\\u00fcense\",\"en\":\"C\\u00f3rdoba nicarag\\u00fcense\"}', 'NIO'),
(130, '{\"es\":\"Franco CFA de \\u00c1frica Occidental\",\"en\":\"Franco CFA de \\u00c1frica Occidental\"}', 'XOF'),
(131, '{\"es\":\"Naira\",\"en\":\"Naira\"}', 'NGN'),
(132, '{\"es\":\"Corona noruega\",\"en\":\"Corona noruega\"}', 'NOK'),
(133, '{\"es\":\"D\\u00f3lar neozeland\\u00e9s\",\"en\":\"D\\u00f3lar neozeland\\u00e9s\"}', 'NZD'),
(134, '{\"es\":\"Rial oman\\u00ed\",\"en\":\"Rial oman\\u00ed\"}', 'OMR'),
(135, '{\"es\":\"Euro\",\"en\":\"Euro\"}', 'EUR'),
(136, '{\"es\":\"Rupia pakistan\\u00ed\",\"en\":\"Rupia pakistan\\u00ed\"}', 'PKR'),
(137, '{\"es\":\"D\\u00f3lar estadounidense\",\"en\":\"D\\u00f3lar estadounidense\"}', 'USD'),
(138, '{\"es\":\"Nuevo sh\\u00e9quel\",\"en\":\"Nuevo sh\\u00e9quel\"}', 'ILS'),
(139, '{\"es\":\"Balboa paname\\u00f1o\",\"en\":\"Balboa paname\\u00f1o\"}', 'PAB'),
(140, '{\"es\":\"Kina\",\"en\":\"Kina\"}', 'PGK'),
(141, '{\"es\":\"Guaran\\u00ed\",\"en\":\"Guaran\\u00ed\"}', 'PYG'),
(142, '{\"es\":\"Nuevo sol\",\"en\":\"Nuevo sol\"}', 'PEN'),
(143, '{\"es\":\"Zloty\",\"en\":\"Zloty\"}', 'PLN'),
(144, '{\"es\":\"Euro\",\"en\":\"Euro\"}', 'EUR'),
(145, '{\"es\":\"Libra brit\\u00e1nica\",\"en\":\"Libra brit\\u00e1nica\"}', 'GBP'),
(146, '{\"es\":\"Franco CFA de \\u00c1frica Central\",\"en\":\"Franco CFA de \\u00c1frica Central\"}', 'XAF'),
(147, '{\"es\":\"Corona checa\",\"en\":\"Corona checa\"}', 'CZK'),
(148, '{\"es\":\"Franco congole\\u00f1o\",\"en\":\"Franco congole\\u00f1o\"}', 'CDF'),
(149, '{\"es\":\"Peso dominicano\",\"en\":\"Peso dominicano\"}', 'DOP'),
(150, '{\"es\":\"Franco ruand\\u00e9s\",\"en\":\"Franco ruand\\u00e9s\"}', 'RWF'),
(151, '{\"es\":\"Leu rumano\",\"en\":\"Leu rumano\"}', 'RON'),
(152, '{\"es\":\"Rublo ruso\",\"en\":\"Rublo ruso\"}', 'RUB'),
(153, '{\"es\":\"Tala\",\"en\":\"Tala\"}', 'WST'),
(154, '{\"es\":\"D\\u00f3lar del Caribe Oriental\",\"en\":\"D\\u00f3lar del Caribe Oriental\"}', 'XCD'),
(155, '{\"es\":\"Euro\",\"en\":\"Euro\"}', 'EUR'),
(156, '{\"es\":\"D\\u00f3lar del Caribe Oriental\",\"en\":\"D\\u00f3lar del Caribe Oriental\"}', 'XCD'),
(157, '{\"es\":\"D\\u00f3lar del Caribe Oriental\",\"en\":\"D\\u00f3lar del Caribe Oriental\"}', 'XCD'),
(158, '{\"es\":\"Dobra\",\"en\":\"Dobra\"}', 'STD'),
(159, '{\"es\":\"Franco CFA de \\u00c1frica Occidental\",\"en\":\"Franco CFA de \\u00c1frica Occidental\"}', 'XOF'),
(160, '{\"es\":\"Dinar serbio\",\"en\":\"Dinar serbio\"}', 'RSD'),
(161, '{\"es\":\"Rupia de Seychelles\",\"en\":\"Rupia de Seychelles\"}', 'SCR'),
(162, '{\"es\":\"Leone\",\"en\":\"Leone\"}', 'SLL'),
(163, '{\"es\":\"D\\u00f3lar de Singapur\",\"en\":\"D\\u00f3lar de Singapur\"}', 'SGD'),
(164, '{\"es\":\"Libra siria\",\"en\":\"Libra siria\"}', 'SYP'),
(165, '{\"es\":\"Chel\\u00edn somal\\u00ed\",\"en\":\"Chel\\u00edn somal\\u00ed\"}', 'SOS'),
(166, '{\"es\":\"Rupia de Sri Lanka\",\"en\":\"Rupia de Sri Lanka\"}', 'LKR'),
(167, '{\"es\":\"Lilangeni\",\"en\":\"Lilangeni\"}', 'SZL'),
(168, '{\"es\":\"Rand sudafricano\",\"en\":\"Rand sudafricano\"}', 'ZAR'),
(169, '{\"es\":\"Libra sudanesa\",\"en\":\"Libra sudanesa\"}', 'SDG'),
(170, '{\"es\":\"Libra sursudanesa\",\"en\":\"Libra sursudanesa\"}', 'SSP'),
(171, '{\"es\":\"Corona sueca\",\"en\":\"Corona sueca\"}', 'SEK'),
(172, '{\"es\":\"Franco suizo\",\"en\":\"Franco suizo\"}', 'CHF'),
(173, '{\"es\":\"D\\u00f3lar surinam\\u00e9s\",\"en\":\"D\\u00f3lar surinam\\u00e9s\"}', 'SRD'),
(174, '{\"es\":\"Baht tailand\\u00e9s\",\"en\":\"Baht tailand\\u00e9s\"}', 'THB'),
(175, '{\"es\":\"Nuevo d\\u00f3lar taiwan\\u00e9s\",\"en\":\"Nuevo d\\u00f3lar taiwan\\u00e9s\"}', 'TWD'),
(176, '{\"es\":\"Chel\\u00edn tanzano\",\"en\":\"Chel\\u00edn tanzano\"}', 'TZS'),
(177, '{\"es\":\"Somoni tayiko\",\"en\":\"Somoni tayiko\"}', 'TJS'),
(178, '{\"es\":\"D\\u00f3lar estadounidense\",\"en\":\"D\\u00f3lar estadounidense\"}', 'USD'),
(179, '{\"es\":\"Franco CFA de \\u00c1frica Occidental\",\"en\":\"Franco CFA de \\u00c1frica Occidental\"}', 'XOF'),
(180, '{\"es\":\"Paanga\",\"en\":\"Paanga\"}', 'TOP'),
(181, '{\"es\":\"D\\u00f3lar trinitense\",\"en\":\"D\\u00f3lar trinitense\"}', 'TTD'),
(182, '{\"es\":\"Dinar tunecino\",\"en\":\"Dinar tunecino\"}', 'TND'),
(183, '{\"es\":\"Manat turcomano\",\"en\":\"Manat turcomano\"}', 'TMT'),
(184, '{\"es\":\"Lira turca\",\"en\":\"Lira turca\"}', 'TRY'),
(185, '{\"es\":\"D\\u00f3lar australiano\",\"en\":\"D\\u00f3lar australiano\"}', 'AUD'),
(186, '{\"es\":\"Grivna\",\"en\":\"Grivna\"}', 'UAH'),
(187, '{\"es\":\"Chel\\u00edn ugand\\u00e9s\",\"en\":\"Chel\\u00edn ugand\\u00e9s\"}', 'UGX'),
(188, '{\"es\":\"Peso uruguayo\",\"en\":\"Peso uruguayo\"}', 'UYU'),
(189, '{\"es\":\"Som uzbeko\",\"en\":\"Som uzbeko\"}', 'UZS'),
(190, '{\"es\":\"Vatu\",\"en\":\"Vatu\"}', 'VUV'),
(191, '{\"es\":\"Euro\",\"en\":\"Euro\"}', 'EUR'),
(192, '{\"es\":\"Bol\\u00edvar fuerte\",\"en\":\"Bol\\u00edvar fuerte\"}', 'VEF'),
(193, '{\"es\":\"Dong vietnamita\",\"en\":\"Dong vietnamita\"}', 'VND'),
(194, '{\"es\":\"Rial yemen\\u00ed\",\"en\":\"Rial yemen\\u00ed\"}', 'YER'),
(195, '{\"es\":\"Franco yibutiano\",\"en\":\"Franco yibutiano\"}', 'DJF'),
(196, '{\"es\":\"Kwacha zambiano\",\"en\":\"Kwacha zambiano\"}', 'ZMW'),
(197, '{\"es\":\"D\\u00f3lar estadounidense\",\"en\":\"D\\u00f3lar estadounidense\"}', 'USD');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guest_treatments`
--

CREATE TABLE `guest_treatments` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `name` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `guest_treatments`
--

INSERT INTO `guest_treatments` (`id`, `account`, `name`) VALUES
(1, 1, 'Sr.'),
(2, 1, 'Sra.'),
(3, 1, 'Srita.'),
(4, 1, 'Mr.'),
(5, 1, 'Miss.'),
(6, 1, 'Mrs.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guest_types`
--

CREATE TABLE `guest_types` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `name` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `guest_types`
--

INSERT INTO `guest_types` (`id`, `account`, `name`) VALUES
(1, 1, 'Club vacacional'),
(2, 1, 'Day pass'),
(3, 1, 'Externo'),
(4, 1, 'Gold'),
(5, 1, 'Platinium'),
(6, 1, 'Regular'),
(7, 1, 'V.I.P.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) NOT NULL,
  `name` text COLLATE utf8_spanish_ci NOT NULL,
  `code` varchar(2) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`) VALUES
(1, 'Español', 'es'),
(2, 'English', 'en');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `name` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `request` tinyint(1) NOT NULL,
  `incident` tinyint(1) NOT NULL,
  `public` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opportunity_areas`
--

CREATE TABLE `opportunity_areas` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `name` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `request` tinyint(1) NOT NULL,
  `incident` tinyint(1) NOT NULL,
  `public` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opportunity_types`
--

CREATE TABLE `opportunity_types` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `opportunity_area` bigint(20) NOT NULL,
  `name` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `request` tinyint(1) NOT NULL,
  `incident` tinyint(1) NOT NULL,
  `public` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promotional_codes`
--

CREATE TABLE `promotional_codes` (
  `id` bigint(20) NOT NULL,
  `code` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `account` bigint(20) NOT NULL,
  `name` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `type` enum('all','request','incident') CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `opportunity_area` bigint(20) DEFAULT NULL,
  `opportunity_type` bigint(20) DEFAULT NULL,
  `room` bigint(20) DEFAULT NULL,
  `location` bigint(20) DEFAULT NULL,
  `order` enum('room','guest') CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `time_period` int(11) NOT NULL,
  `addressed_to` enum('all','opportunity_areas','me') CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `addressed_to_opportunity_areas` longtext CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `addressed_to_user` bigint(20) DEFAULT NULL,
  `fields` longtext CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservation_status`
--

CREATE TABLE `reservation_status` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `name` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `reservation_status`
--

INSERT INTO `reservation_status` (`id`, `account`, `name`) VALUES
(1, 1, 'En casa'),
(2, 1, 'Fuera de casa'),
(3, 1, 'Pre llegada'),
(4, 1, 'Llegada'),
(5, 1, 'Pre salida'),
(6, 1, 'Salida');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `code` text NOT NULL,
  `name` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `qr` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rooms`
--

INSERT INTO `rooms` (`id`, `account`, `code`, `name`, `qr`) VALUES
(1, 1, 'EWFA2L6J', 'H 1 VIP', '{\"name\":\"qr_EwfA2l6J.png\",\"code\":\"EwfA2l6J\"}'),
(2, 1, 'FRVDUOX0', 'H 2 VIP', '{\"name\":\"qr_FrVDuOX0.png\",\"code\":\"FrVDuOX0\"}'),
(3, 1, '6UAHSCL2', 'H 3 VIP', '{\"name\":\"qr_6uaHScl2.png\",\"code\":\"6uaHScl2\"}'),
(4, 1, 'X2IZWFHN', 'H 4 VIP', '{\"name\":\"qr_X2iZWfhN.png\",\"code\":\"X2iZWfhN\"}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `room_packages`
--

CREATE TABLE `room_packages` (
  `id` bigint(20) NOT NULL,
  `quantity_start` int(11) NOT NULL,
  `quantity_end` int(11) NOT NULL,
  `price` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `room_packages`
--

INSERT INTO `room_packages` (`id`, `quantity_start`, `quantity_end`, `price`) VALUES
(1, 1, 20, '1200'),
(2, 21, 40, '1600'),
(3, 41, 60, '1800'),
(4, 61, 80, '2000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `private_key` longtext CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `room_package` bigint(20) DEFAULT NULL,
  `user_package` bigint(20) DEFAULT NULL,
  `country` text NOT NULL,
  `cp` text NOT NULL,
  `city` text NOT NULL,
  `address` text NOT NULL,
  `time_zone` text NOT NULL,
  `language` enum('es','en') CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `currency` text NOT NULL,
  `logotype` text,
  `fiscal_id` text NOT NULL,
  `fiscal_name` text NOT NULL,
  `fiscal_address` text NOT NULL,
  `contact` text NOT NULL,
  `payment` enum('card','mercado_pago','paypal') NOT NULL,
  `promotional_code` varchar(8) DEFAULT NULL,
  `sms` int(11) NOT NULL,
  `survey_title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `settings`
--

INSERT INTO `settings` (`id`, `account`, `private_key`, `room_package`, `user_package`, `country`, `cp`, `city`, `address`, `time_zone`, `language`, `currency`, `logotype`, `fiscal_id`, `fiscal_name`, `fiscal_address`, `contact`, `payment`, `promotional_code`, `sms`, `survey_title`) VALUES
(1, 1, 'OvX7WsT*^Ji35si,rEnFi8jrn(x9tHN3?.e3}]q0u)!D<GG9d~B(@7N5LE<psQgs:Mz-WJbRgm4!)pYiHPBGjZ#tnEFiZ0Cd)rc:uJNj(]_rZtHY0<:XkacT/!p|oV[7', 4, 4, 'MEX', '77500', 'Cancún', 'Mi dirección', 'America/Cancun', 'es', 'MXN', 'ITPWEmzXlSRO963e.png', 'AAAA123456789', 'GuestVox S.A.P.I. de C.V.', 'Mi dirección', '{\"name\":\"Gers\\u00f3n G\\u00f3mez\",\"department\":\"Inform\\u00e1tica\",\"lada\":\"52\",\"phone\":\"1234567890\",\"email\":\"gerson@guestvox.com\"}', 'card', NULL, 0, '{\"es\":\"Responde nuestra encuesta y obt\\u00e9n una botella de vino\",\"en\":\"Answer our survey and get a bottle of wine\"}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sms_packages`
--

CREATE TABLE `sms_packages` (
  `id` bigint(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `sms_packages`
--

INSERT INTO `sms_packages` (`id`, `quantity`, `price`) VALUES
(1, 1000, '600'),
(2, 1500, '400');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `survey_answers`
--

CREATE TABLE `survey_answers` (
  `id` int(11) NOT NULL,
  `account` bigint(20) NOT NULL,
  `room` bigint(20) NOT NULL,
  `survey_question` bigint(20) NOT NULL,
  `rate` int(11) NOT NULL,
  `date` date NOT NULL,
  `token` char(6) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `survey_comments`
--

CREATE TABLE `survey_comments` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `room` bigint(20) NOT NULL,
  `comment` text COLLATE utf8_spanish_ci NOT NULL,
  `date` date NOT NULL,
  `token` char(6) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `survey_questions`
--

CREATE TABLE `survey_questions` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `question` longtext COLLATE utf8_spanish_ci NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `description` text COLLATE utf8_spanish_ci NOT NULL,
  `assigned_users` longtext COLLATE utf8_spanish_ci NOT NULL,
  `assigned_areas` longtext COLLATE utf8_spanish_ci NOT NULL,
  `assigned_user_levels` longtext COLLATE utf8_spanish_ci NOT NULL,
  `expiration_date` date NOT NULL,
  `expiration_hour` time NOT NULL,
  `repetition` enum('unique','dayli','weekly','monthly','annual') COLLATE utf8_spanish_ci NOT NULL,
  `creation_date` date NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `time_zones`
--

CREATE TABLE `time_zones` (
  `id` bigint(20) NOT NULL,
  `code` text COLLATE utf8_spanish_ci NOT NULL,
  `zone` enum('america','africa','antarctica','artic','asia','atlantic','australia','europe','indian','pacific') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `time_zones`
--

INSERT INTO `time_zones` (`id`, `code`, `zone`) VALUES
(1, 'America/Adak', 'america'),
(2, 'America/Anchorage', 'america'),
(3, 'America/Anguilla', 'america'),
(4, 'America/Antigua', 'america'),
(5, 'America/Araguaina', 'america'),
(6, 'America/Argentina/Buenos_Aires', 'america'),
(7, 'America/Argentina/Catamarca', 'america'),
(8, 'America/Argentina/Cordoba', 'america'),
(9, 'America/Argentina/Jujuy', 'america'),
(10, 'America/Argentina/La_Rioja', 'america'),
(11, 'America/Argentina/Mendoza', 'america'),
(12, 'America/Argentina/Rio_Gallegos', 'america'),
(13, 'America/Argentina/Salta', 'america'),
(14, 'America/Argentina/San_Juan', 'america'),
(15, 'America/Argentina/San_Luis', 'america'),
(16, 'America/Argentina/Tucuman', 'america'),
(17, 'America/Argentina/Ushuaia', 'america'),
(18, 'America/Aruba', 'america'),
(19, 'America/Asuncion', 'america'),
(20, 'America/Atikokan', 'america'),
(21, 'America/Bahia', 'america'),
(22, 'America/Bahia_Banderas', 'america'),
(23, 'America/Barbados', 'america'),
(24, 'America/Belem', 'america'),
(25, 'America/Belize', 'america'),
(26, 'America/Blanc-Sablon', 'america'),
(27, 'America/Boa_Vista', 'america'),
(28, 'America/Bogota', 'america'),
(29, 'America/Boise', 'america'),
(30, 'America/Cambridge_Bay', 'america'),
(31, 'America/Campo_Grande', 'america'),
(32, 'America/Cancun', 'america'),
(33, 'America/Caracas', 'america'),
(34, 'America/Cayenne', 'america'),
(35, 'America/Cayman', 'america'),
(36, 'America/Chicago', 'america'),
(37, 'America/Chihuahua', 'america'),
(38, 'America/Costa_Rica', 'america'),
(39, 'America/Creston', 'america'),
(40, 'America/Cuiaba', 'america'),
(41, 'America/Curacao', 'america'),
(42, 'America/Danmarkshavn', 'america'),
(43, 'America/Dawson', 'america'),
(44, 'America/Dawson_Creek', 'america'),
(45, 'America/Denver', 'america'),
(46, 'America/Detroit', 'america'),
(47, 'America/Dominica', 'america'),
(48, 'America/Edmonton', 'america'),
(49, 'America/Eirunepe', 'america'),
(50, 'America/El_Salvador', 'america'),
(51, 'America/Fort_Nelson', 'america'),
(52, 'America/Fortaleza', 'america'),
(53, 'America/Glace_Bay', 'america'),
(54, 'America/Godthab', 'america'),
(55, 'America/Goose_Bay', 'america'),
(56, 'America/Grand_Turk', 'america'),
(57, 'America/Grenada', 'america'),
(58, 'America/Guadeloupe', 'america'),
(59, 'America/Guatemala', 'america'),
(60, 'America/Guayaquil', 'america'),
(61, 'America/Guyana', 'america'),
(62, 'America/Halifax', 'america'),
(63, 'America/Havana', 'america'),
(64, 'America/Hermosillo', 'america'),
(65, 'America/Indiana/Indianapolis', 'america'),
(66, 'America/Indiana/Knox', 'america'),
(67, 'America/Indiana/Marengo', 'america'),
(68, 'America/Indiana/Petersburg', 'america'),
(69, 'America/Indiana/Tell_City', 'america'),
(70, 'America/Indiana/Vevay', 'america'),
(71, 'America/Indiana/Vincennes', 'america'),
(72, 'America/Indiana/Winamac', 'america'),
(73, 'America/Inuvik', 'america'),
(74, 'America/Iqaluit', 'america'),
(75, 'America/Jamaica', 'america'),
(76, 'America/Juneau', 'america'),
(77, 'America/Kentucky/Louisville', 'america'),
(78, 'America/Kentucky/Monticello', 'america'),
(79, 'America/Kralendijk', 'america'),
(80, 'America/La_Paz', 'america'),
(81, 'America/Lima', 'america'),
(82, 'America/Los_Angeles', 'america'),
(83, 'America/Lower_Princes', 'america'),
(84, 'America/Maceio', 'america'),
(85, 'America/Managua', 'america'),
(86, 'America/Manaus', 'america'),
(87, 'America/Marigot', 'america'),
(88, 'America/Martinique', 'america'),
(89, 'America/Matamoros', 'america'),
(90, 'America/Mazatlan', 'america'),
(91, 'America/Menominee', 'america'),
(92, 'America/Merida', 'america'),
(93, 'America/Metlakatla', 'america'),
(94, 'America/Mexico_City', 'america'),
(95, 'America/Miquelon', 'america'),
(96, 'America/Moncton', 'america'),
(97, 'America/Monterrey', 'america'),
(98, 'America/Montevideo', 'america'),
(99, 'America/Montserrat', 'america'),
(100, 'America/Nassau', 'america'),
(101, 'America/New_York', 'america'),
(102, 'America/Nipigon', 'america'),
(103, 'America/Nome', 'america'),
(104, 'America/Noronha', 'america'),
(105, 'America/North_Dakota/Beulah', 'america'),
(106, 'America/North_Dakota/Center', 'america'),
(107, 'America/North_Dakota/New_Salem', 'america'),
(108, 'America/Ojinaga', 'america'),
(109, 'America/Panama', 'america'),
(110, 'America/Pangnirtung', 'america'),
(111, 'America/Paramaribo', 'america'),
(112, 'America/Phoenix', 'america'),
(113, 'America/Port-au-Prince', 'america'),
(114, 'America/Port_of_Spain', 'america'),
(115, 'America/Porto_Velho', 'america'),
(116, 'America/Puerto_Rico', 'america'),
(117, 'America/Punta_Arenas', 'america'),
(118, 'America/Rainy_River', 'america'),
(119, 'America/Rankin_Inlet', 'america'),
(120, 'America/Recife', 'america'),
(121, 'America/Regina', 'america'),
(122, 'America/Resolute', 'america'),
(123, 'America/Rio_Branco', 'america'),
(124, 'America/Santarem', 'america'),
(125, 'America/Santiago', 'america'),
(126, 'America/Santo_Domingo', 'america'),
(127, 'America/Sao_Paulo', 'america'),
(128, 'America/Scoresbysund', 'america'),
(129, 'America/Sitka', 'america'),
(130, 'America/St_Barthelemy', 'america'),
(131, 'America/St_Johns', 'america'),
(132, 'America/St_Kitts', 'america'),
(133, 'America/St_Lucia', 'america'),
(134, 'America/St_Thomas', 'america'),
(135, 'America/St_Vincent', 'america'),
(136, 'America/Swift_Current', 'america'),
(137, 'America/Tegucigalpa', 'america'),
(138, 'America/Thule', 'america'),
(139, 'America/Thunder_Bay', 'america'),
(140, 'America/Tijuana', 'america'),
(141, 'America/Toronto', 'america'),
(142, 'America/Tortola', 'america'),
(143, 'America/Vancouver', 'america'),
(144, 'America/Whitehorse', 'america'),
(145, 'America/Winnipeg', 'america'),
(146, 'America/Yakutat', 'america'),
(147, 'America/Yellowknife', 'america'),
(148, 'Africa/Abidjan', 'africa'),
(149, 'Africa/Accra', 'africa'),
(150, 'Africa/Addis_Ababa', 'africa'),
(151, 'Africa/Algiers', 'africa'),
(152, 'Africa/Asmara', 'africa'),
(153, 'Africa/Bamako', 'africa'),
(154, 'Africa/Bangui', 'africa'),
(155, 'Africa/Banjul', 'africa'),
(156, 'Africa/Bissau', 'africa'),
(157, 'Africa/Blantyre', 'africa'),
(158, 'Africa/Brazzaville', 'africa'),
(159, 'Africa/Bujumbura', 'africa'),
(160, 'Africa/Cairo', 'africa'),
(161, 'Africa/Casablanca', 'africa'),
(162, 'Africa/Ceuta', 'africa'),
(163, 'Africa/Conakry', 'africa'),
(164, 'Africa/Dakar', 'africa'),
(165, 'Africa/Dar_es_Salaam', 'africa'),
(166, 'Africa/Djibouti', 'africa'),
(167, 'Africa/Douala', 'africa'),
(168, 'Africa/El_Aaiun', 'africa'),
(169, 'Africa/Freetown', 'africa'),
(170, 'Africa/Gaborone', 'africa'),
(171, 'Africa/Harare', 'africa'),
(172, 'Africa/Johannesburg', 'africa'),
(173, 'Africa/Juba', 'africa'),
(174, 'Africa/Kampala', 'africa'),
(175, 'Africa/Khartoum', 'africa'),
(176, 'Africa/Kigali', 'africa'),
(177, 'Africa/Kinshasa', 'africa'),
(178, 'Africa/Lagos', 'africa'),
(179, 'Africa/Libreville', 'africa'),
(180, 'Africa/Lome', 'africa'),
(181, 'Africa/Luanda', 'africa'),
(182, 'Africa/Lubumbashi', 'africa'),
(183, 'Africa/Lusaka', 'africa'),
(184, 'Africa/Malabo', 'africa'),
(185, 'Africa/Maputo', 'africa'),
(186, 'Africa/Maseru', 'africa'),
(187, 'Africa/Mbabane', 'africa'),
(188, 'Africa/Mogadishu', 'africa'),
(189, 'Africa/Monrovia', 'africa'),
(190, 'Africa/Nairobi', 'africa'),
(191, 'Africa/Ndjamena', 'africa'),
(192, 'Africa/Niamey', 'africa'),
(193, 'Africa/Nouakchott', 'africa'),
(194, 'Africa/Ouagadougou', 'africa'),
(195, 'Africa/Porto-Novo', 'africa'),
(196, 'Africa/Sao_Tome', 'africa'),
(197, 'Africa/Tripoli', 'africa'),
(198, 'Africa/Tunis', 'africa'),
(199, 'Africa/Windhoek', 'africa'),
(200, 'Antarctica/Casey', 'antarctica'),
(201, 'Antarctica/Davis', 'antarctica'),
(202, 'Antarctica/DumontDUrville', 'antarctica'),
(203, 'Antarctica/Macquarie', 'antarctica'),
(204, 'Antarctica/Mawson', 'antarctica'),
(205, 'Antarctica/McMurdo', 'antarctica'),
(206, 'Antarctica/Palmer', 'antarctica'),
(207, 'Antarctica/Rothera', 'antarctica'),
(208, 'Antarctica/Syowa', 'antarctica'),
(209, 'Antarctica/Troll', 'antarctica'),
(210, 'Antarctica/Vostok', 'antarctica'),
(211, 'Arctic/Longyearbyen', 'artic'),
(212, 'Asia/Aden', 'asia'),
(213, 'Asia/Almaty', 'asia'),
(214, 'Asia/Amman', 'asia'),
(215, 'Asia/Anadyr', 'asia'),
(216, 'Asia/Aqtau', 'asia'),
(217, 'Asia/Aqtobe', 'asia'),
(218, 'Asia/Ashgabat', 'asia'),
(219, 'Asia/Atyrau', 'asia'),
(220, 'Asia/Baghdad', 'asia'),
(221, 'Asia/Bahrain', 'asia'),
(222, 'Asia/Baku', 'asia'),
(223, 'Asia/Bangkok', 'asia'),
(224, 'Asia/Barnaul', 'asia'),
(225, 'Asia/Beirut', 'asia'),
(226, 'Asia/Bishkek', 'asia'),
(227, 'Asia/Brunei', 'asia'),
(228, 'Asia/Chita', 'asia'),
(229, 'Asia/Choibalsan', 'asia'),
(230, 'Asia/Colombo', 'asia'),
(231, 'Asia/Damascus', 'asia'),
(232, 'Asia/Dhaka', 'asia'),
(233, 'Asia/Dili', 'asia'),
(234, 'Asia/Dubai', 'asia'),
(235, 'Asia/Dushanbe', 'asia'),
(236, 'Asia/Famagusta', 'asia'),
(237, 'Asia/Gaza', 'asia'),
(238, 'Asia/Hebron', 'asia'),
(239, 'Asia/Ho_Chi_Minh', 'asia'),
(240, 'Asia/Hong_Kong', 'asia'),
(241, 'Asia/Hovd', 'asia'),
(242, 'Asia/Irkutsk', 'asia'),
(243, 'Asia/Jakarta', 'asia'),
(244, 'Asia/Jayapura', 'asia'),
(245, 'Asia/Jerusalem', 'asia'),
(246, 'Asia/Kabul', 'asia'),
(247, 'Asia/Kamchatka', 'asia'),
(248, 'Asia/Karachi', 'asia'),
(249, 'Asia/Kathmandu', 'asia'),
(250, 'Asia/Khandyga', 'asia'),
(251, 'Asia/Kolkata', 'asia'),
(252, 'Asia/Krasnoyarsk', 'asia'),
(253, 'Asia/Kuala_Lumpur', 'asia'),
(254, 'Asia/Kuching', 'asia'),
(255, 'Asia/Kuwait', 'asia'),
(256, 'Asia/Macau', 'asia'),
(257, 'Asia/Magadan', 'asia'),
(258, 'Asia/Makassar', 'asia'),
(259, 'Asia/Manila', 'asia'),
(260, 'Asia/Muscat', 'asia'),
(261, 'Asia/Nicosia', 'asia'),
(262, 'Asia/Novokuznetsk', 'asia'),
(263, 'Asia/Novosibirsk', 'asia'),
(264, 'Asia/Omsk', 'asia'),
(265, 'Asia/Oral', 'asia'),
(266, 'Asia/Phnom_Penh', 'asia'),
(267, 'Asia/Pontianak', 'asia'),
(268, 'Asia/Pyongyang', 'asia'),
(269, 'Asia/Qatar', 'asia'),
(270, 'Asia/Qyzylorda', 'asia'),
(271, 'Asia/Riyadh', 'asia'),
(272, 'Asia/Sakhalin', 'asia'),
(273, 'Asia/Samarkand', 'asia'),
(274, 'Asia/Seoul', 'asia'),
(275, 'Asia/Shanghai', 'asia'),
(276, 'Asia/Singapore', 'asia'),
(277, 'Asia/Srednekolymsk', 'asia'),
(278, 'Asia/Taipei', 'asia'),
(279, 'Asia/Tashkent', 'asia'),
(280, 'Asia/Tbilisi', 'asia'),
(281, 'Asia/Tehran', 'asia'),
(282, 'Asia/Thimphu', 'asia'),
(283, 'Asia/Tokyo', 'asia'),
(284, 'Asia/Tomsk', 'asia'),
(285, 'Asia/Ulaanbaatar', 'asia'),
(286, 'Asia/Urumqi', 'asia'),
(287, 'Asia/Ust-Nera', 'asia'),
(288, 'Asia/Vientiane', 'asia'),
(289, 'Asia/Vladivostok', 'asia'),
(290, 'Asia/Yakutsk', 'asia'),
(291, 'Asia/Yangon', 'asia'),
(292, 'Asia/Yekaterinburg', 'asia'),
(293, 'Asia/Yerevan', 'asia'),
(294, 'Atlantic/Azores', 'atlantic'),
(295, 'Atlantic/Bermuda', 'atlantic'),
(296, 'Atlantic/Canary', 'atlantic'),
(297, 'Atlantic/Cape_Verde', 'atlantic'),
(298, 'Atlantic/Faroe', 'atlantic'),
(299, 'Atlantic/Madeira', 'atlantic'),
(300, 'Atlantic/Reykjavik', 'atlantic'),
(301, 'Atlantic/South_Georgia', 'atlantic'),
(302, 'Atlantic/St_Helena', 'atlantic'),
(303, 'Atlantic/Stanley', 'atlantic'),
(304, 'Australia/Adelaide', 'australia'),
(305, 'Australia/Brisbane', 'australia'),
(306, 'Australia/Broken_Hill', 'australia'),
(307, 'Australia/Currie', 'australia'),
(308, 'Australia/Darwin', 'australia'),
(309, 'Australia/Eucla', 'australia'),
(310, 'Australia/Hobart', 'australia'),
(311, 'Australia/Lindeman', 'australia'),
(312, 'Australia/Lord_Howe', 'australia'),
(313, 'Australia/Melbourne', 'australia'),
(314, 'Australia/Perth', 'australia'),
(315, 'Australia/Sydney', 'australia'),
(316, 'Europe/Amsterdam', 'europe'),
(317, 'Europe/Andorra', 'europe'),
(318, 'Europe/Astrakhan', 'europe'),
(319, 'Europe/Athens', 'europe'),
(320, 'Europe/Belgrade', 'europe'),
(321, 'Europe/Berlin', 'europe'),
(322, 'Europe/Bratislava', 'europe'),
(323, 'Europe/Brussels', 'europe'),
(324, 'Europe/Bucharest', 'europe'),
(325, 'Europe/Budapest', 'europe'),
(326, 'Europe/Busingen', 'europe'),
(327, 'Europe/Chisinau', 'europe'),
(328, 'Europe/Copenhagen', 'europe'),
(329, 'Europe/Dublin', 'europe'),
(330, 'Europe/Gibraltar', 'europe'),
(331, 'Europe/Guernsey', 'europe'),
(332, 'Europe/Helsinki', 'europe'),
(333, 'Europe/Isle_of_Man', 'europe'),
(334, 'Europe/Istanbul', 'europe'),
(335, 'Europe/Jersey', 'europe'),
(336, 'Europe/Kaliningrad', 'europe'),
(337, 'Europe/Kiev', 'europe'),
(338, 'Europe/Kirov', 'europe'),
(339, 'Europe/Lisbon', 'europe'),
(340, 'Europe/Ljubljana', 'europe'),
(341, 'Europe/London', 'europe'),
(342, 'Europe/Luxembourg', 'europe'),
(343, 'Europe/Madrid', 'europe'),
(344, 'Europe/Malta', 'europe'),
(345, 'Europe/Mariehamn', 'europe'),
(346, 'Europe/Minsk', 'europe'),
(347, 'Europe/Monaco', 'europe'),
(348, 'Europe/Moscow', 'europe'),
(349, 'Europe/Oslo', 'europe'),
(350, 'Europe/Paris', 'europe'),
(351, 'Europe/Podgorica', 'europe'),
(352, 'Europe/Prague', 'europe'),
(353, 'Europe/Riga', 'europe'),
(354, 'Europe/Rome', 'europe'),
(355, 'Europe/Samara', 'europe'),
(356, 'Europe/San_Marino', 'europe'),
(357, 'Europe/Sarajevo', 'europe'),
(358, 'Europe/Saratov', 'europe'),
(359, 'Europe/Simferopol', 'europe'),
(360, 'Europe/Skopje', 'europe'),
(361, 'Europe/Sofia', 'europe'),
(362, 'Europe/Stockholm', 'europe'),
(363, 'Europe/Tallinn', 'europe'),
(364, 'Europe/Tirane', 'europe'),
(365, 'Europe/Ulyanovsk', 'europe'),
(366, 'Europe/Uzhgorod', 'europe'),
(367, 'Europe/Vaduz', 'europe'),
(368, 'Europe/Vatican', 'europe'),
(369, 'Europe/Vienna', 'europe'),
(370, 'Europe/Vilnius', 'europe'),
(371, 'Europe/Volgograd', 'europe'),
(372, 'Europe/Warsaw', 'europe'),
(373, 'Europe/Zagreb', 'europe'),
(374, 'Europe/Zaporozhye', 'europe'),
(375, 'Europe/Zurich', 'europe'),
(376, 'Indian/Antananarivo', 'indian'),
(377, 'Indian/Chagos', 'indian'),
(378, 'Indian/Christmas', 'indian'),
(379, 'Indian/Cocos', 'indian'),
(380, 'Indian/Comoro', 'indian'),
(381, 'Indian/Kerguelen', 'indian'),
(382, 'Indian/Mahe', 'indian'),
(383, 'Indian/Maldives', 'indian'),
(384, 'Indian/Mauritius', 'indian'),
(385, 'Indian/Mayotte', 'indian'),
(386, 'Indian/Reunion', 'indian'),
(387, 'Pacific/Apia', 'pacific'),
(388, 'Pacific/Auckland', 'pacific'),
(389, 'Pacific/Bougainville', 'pacific'),
(390, 'Pacific/Chatham', 'pacific'),
(391, 'Pacific/Chuuk', 'pacific'),
(392, 'Pacific/Easter', 'pacific'),
(393, 'Pacific/Efate', 'pacific'),
(394, 'Pacific/Enderbury', 'pacific'),
(395, 'Pacific/Fakaofo', 'pacific'),
(396, 'Pacific/Fiji', 'pacific'),
(397, 'Pacific/Funafuti', 'pacific'),
(398, 'Pacific/Galapagos', 'pacific'),
(399, 'Pacific/Gambier', 'pacific'),
(400, 'Pacific/Guadalcanal', 'pacific'),
(401, 'Pacific/Guam', 'pacific'),
(402, 'Pacific/Honolulu', 'pacific'),
(403, 'Pacific/Kiritimati', 'pacific'),
(404, 'Pacific/Kosrae', 'pacific'),
(405, 'Pacific/Kwajalein', 'pacific'),
(406, 'Pacific/Majuro', 'pacific'),
(407, 'Pacific/Marquesas', 'pacific'),
(408, 'Pacific/Midway', 'pacific'),
(409, 'Pacific/Nauru', 'pacific'),
(410, 'Pacific/Niue', 'pacific'),
(411, 'Pacific/Norfolk', 'pacific'),
(412, 'Pacific/Noumea', 'pacific'),
(413, 'Pacific/Pago_Pago', 'pacific'),
(414, 'Pacific/Palau', 'pacific'),
(415, 'Pacific/Pitcairn', 'pacific'),
(416, 'Pacific/Pohnpei', 'pacific'),
(417, 'Pacific/Port_Moresby', 'pacific'),
(418, 'Pacific/Rarotonga', 'pacific'),
(419, 'Pacific/Saipan', 'pacific'),
(420, 'Pacific/Tahiti', 'pacific'),
(421, 'Pacific/Tarawa', 'pacific'),
(422, 'Pacific/Tongatapu', 'pacific'),
(423, 'Pacific/Wake', 'pacific'),
(424, 'Pacific/Wallis', 'pacific');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `name` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `lastname` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `cellphone` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `avatar` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `username` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(110) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `temporal_password` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `user_level` bigint(20) NOT NULL,
  `user_permissions` longtext CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `opportunity_areas` longtext CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `account`, `name`, `lastname`, `email`, `cellphone`, `avatar`, `username`, `password`, `temporal_password`, `user_level`, `user_permissions`, `opportunity_areas`, `status`) VALUES
(1, 1, 'Demo', 'Demo', 'demo@guestvox.com', '1234567890', NULL, 'demo', 'b46f6d9fa6d845f27280e4de5768bb1703556af9:8aVrVRC7LOeIrhcOjX3OoV6jmYU6gKpAnWvadP7O3AjojUiUBSfvR3BSuGl9OHnx', NULL, 1, '[\"1\",\"2\",\"3\",\"38\",\"39\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"16\",\"17\",\"19\",\"20\",\"21\",\"18\",\"22\",\"23\",\"24\",\"25\",\"26\"]', '[\"1\",\"2\",\"3\",\"4\"]', 1),
(2, 1, 'Daniel', 'Basurto', 'daniel@guestvox.com', '9988452843', 'jK55YiHY5qv5Bo2x.png', 'daniel@guestvox.com', '5d50e2fd215a0494c57dc5a9ab67ffea5b7579ce:8ucTICQVmT1dcvldG4O79WiakfWWOCIinvGdorqdHqEwiF3VD0cpek0rwj4L0hfh', NULL, 1, '[\"1\",\"2\",\"3\",\"38\",\"39\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"16\",\"17\",\"19\",\"20\",\"21\",\"18\",\"22\",\"23\",\"24\",\"25\",\"26\"]', '[\"1\",\"2\",\"3\",\"4\"]', 1),
(3, 1, 'Gersón', 'Gómez', 'gerson@guestvox.com', '9988701057', 'jK55YiHY8qv5Bo2x.jpeg', 'gerson@guestvox.com', 'f53d6dd0204f8b2faaf10f1ccad212025ebc73f6:1X5m1Nx9jm4ugQTWmKOAat7eX8yreg6VfNVPiphTMSxiEZZyY1TOgs63vu4NupDT', NULL, 1, '[\"1\",\"2\",\"3\",\"38\",\"39\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"16\",\"17\",\"19\",\"20\",\"21\",\"18\",\"22\",\"23\",\"24\",\"25\",\"26\"]', '[\"1\",\"2\",\"3\",\"4\"]', 1),
(4, 1, 'Saúl', 'Poot', 'saul@guestvox.com', '9983856109', 'jK55hiHY5qv5Bo2x.png', 'saul@guestvox.com', '79b6139a4bc1492c5bed1087d1461e0209b744f3:uhvK6xtCu3RNs22oSWykkvSYnOVYvtrZ9nLZ9Xzar38E7FIkNkXb3EoVamaVfY5v', NULL, 1, '[\"1\",\"2\",\"3\",\"38\",\"39\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"16\",\"17\",\"19\",\"20\",\"21\",\"18\",\"22\",\"23\",\"24\",\"25\",\"26\"]', '[\"1\",\"2\",\"3\",\"4\"]', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_levels`
--

CREATE TABLE `user_levels` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `code` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `name` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `user_permissions` longtext CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user_levels`
--

INSERT INTO `user_levels` (`id`, `account`, `code`, `name`, `user_permissions`) VALUES
(1, 1, '{administrator}', 'Administrador', '[\"1\",\"2\",\"3\",\"38\",\"39\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"16\",\"17\",\"19\",\"20\",\"21\",\"18\",\"22\",\"23\",\"24\",\"26\"]'),
(2, 1, '{director}', 'Director', '[\"1\",\"2\",\"3\",\"38\",\"39\",\"25\",\"26\"]'),
(3, 1, '{manager}', 'Gerente', '[\"1\",\"2\",\"3\",\"38\",\"39\",\"25\",\"27\"]'),
(4, 1, '{supervisor}', 'Supervisor', '[\"1\",\"2\",\"3\",\"38\",\"39\",\"27\"]'),
(5, 1, '{operator}', 'Operador', '[\"1\",\"2\",\"28\"]');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_packages`
--

CREATE TABLE `user_packages` (
  `id` bigint(20) NOT NULL,
  `quantity_start` int(11) NOT NULL,
  `quantity_end` int(11) NOT NULL,
  `price` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `user_packages`
--

INSERT INTO `user_packages` (`id`, `quantity_start`, `quantity_end`, `price`) VALUES
(1, 1, 20, '1200'),
(2, 21, 40, '1400'),
(3, 41, 60, '1800'),
(4, 61, 80, '2000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_permissions`
--

CREATE TABLE `user_permissions` (
  `id` bigint(20) NOT NULL,
  `code` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `priority` int(11) NOT NULL,
  `unique` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user_permissions`
--

INSERT INTO `user_permissions` (`id`, `code`, `description`, `priority`, `unique`) VALUES
(1, '{voxes_update}', '{\"es\":\"Editar\",\"en\":\"Update\"}', 1, 0),
(2, '{voxes_complete}', '{\"es\":\"Completar\",\"en\":\"Complete\"}', 2, 0),
(3, '{voxes_reopen}', '{\"es\":\"Reabrir\",\"en\":\"Reopen\"}', 3, 0),
(4, '{opportunityareas_create}', '{\"es\":\"Crear\",\"en\":\"Create\"}', 1, 0),
(5, '{opportunityareas_update}', '{\"es\":\"Editar\",\"en\":\"Update\"}', 2, 0),
(6, '{opportunityareas_delete}', '{\"es\":\"Eliminar\",\"en\":\"Delete\"}', 3, 0),
(7, '{opportunitytypes_create}', '{\"es\":\"Crear\",\"en\":\"Create\"}', 1, 0),
(8, '{opportunitytypes_update}', '{\"es\":\"Editar\",\"en\":\"Update\"}', 2, 0),
(9, '{opportunitytypes_delete}', '{\"es\":\"Eliminar\",\"en\":\"Delete\"}', 3, 0),
(10, '{locations_create}', '{\"es\":\"Crear\",\"en\":\"Create\"}', 1, 0),
(11, '{locations_update}', '{\"es\":\"Editar\",\"en\":\"Update\"}', 2, 0),
(12, '{locations_delete}', '{\"es\":\"Eliminar\",\"en\":\"Delete\"}', 3, 0),
(13, '{rooms_create}', '{\"es\":\"Crear\",\"en\":\"Create\"}', 1, 0),
(14, '{rooms_update}', '{\"es\":\"Editar\",\"en\":\"Update\"}', 2, 0),
(15, '{rooms_delete}', '{\"es\":\"Eliminar\",\"en\":\"Delete\"}', 3, 0),
(16, '{users_create}', '{\"es\":\"Crear\",\"en\":\"Create\"}', 1, 0),
(17, '{users_update}', '{\"es\":\"Editar\",\"en\":\"Update\"}', 2, 0),
(18, '{users_delete}', '{\"es\":\"Eliminar\",\"en\":\"Delete\"}', 6, 0),
(19, '{users_restorepassword}', '{\"es\":\"Restablecer contraseña\",\"en\":\"Restore password\"}', 3, 0),
(20, '{users_deactivate}', '{\"es\":\"Desactivar\",\"en\":\"Deactivate\"}', 4, 0),
(21, '{users_activate}', '{\"es\":\"Activar\",\"en\":\"Activate\"}', 5, 0),
(22, '{userlevels_create}', '{\"es\":\"Crear\",\"en\":\"Create\"}', 1, 0),
(23, '{userlevels_update}', '{\"es\":\"Editar\",\"en\":\"Update\"}', 2, 0),
(24, '{userlevels_delete}', '{\"es\":\"Eliminar\",\"en\":\"Delete\"}', 3, 0),
(25, '{views_confidentiality}', '{\"es\":\"Confidencialidad\",\"en\":\"Confidentiality\"}', 1, 0),
(26, '{views_all}', '{\"es\":\"Todo\",\"en\":\"All\"}', 2, 1),
(27, '{views_opportunity_areas}', '{\"es\":\"Áreas de oportunidad asignadas\",\"en\":\"Opportunity areas assigned\"}', 3, 1),
(28, '{views_own}', '{\"es\":\"Propio\",\"en\":\"Own\"}', 4, 1),
(29, '{guesttreatments_create}', '{\"es\":\"Crear\",\"en\":\"Create\"}', 1, 0),
(30, '{guesttreatments_update}', '{\"es\":\"Editar\",\"en\":\"Update\"}', 2, 0),
(31, '{guesttreatments_delete}', '{\"es\":\"Eliminar\",\"en\":\"Delete\"}', 3, 0),
(32, '{guesttypes_create}', '{\"es\":\"Crear\",\"en\":\"Create\"}', 1, 0),
(33, '{guesttypes_update}', '{\"es\":\"Editar\",\"en\":\"Update\"}', 2, 0),
(34, '{guesttypes_delete}', '{\"es\":\"Eliminar\",\"en\":\"Delete\"}', 3, 0),
(35, '{reservationstatus_create}', '{\"es\":\"Crear\",\"en\":\"Create\"}', 1, 0),
(36, '{reservationstatus_update}', '{\"es\":\"Editar\",\"en\":\"Update\"}', 2, 0),
(37, '{reservationstatus_delete}', '{\"es\":\"Eliminar\",\"en\":\"Delete\"}', 3, 0),
(38, '{stats_view}', '{\"es\":\"Ver\",\"en\":\"View\"}', 5, 0),
(39, '{reports_generate}', '{\"es\":\"Generar\",\"en\":\"Generate\"}', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `voxes`
--

CREATE TABLE `voxes` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `type` enum('request','incident') CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL DEFAULT 'request',
  `data` longtext CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `com_payment_invalid`
--
ALTER TABLE `com_payment_invalid`
  ADD PRIMARY KEY (`id_payment_invalid`);

--
-- Indices de la tabla `com_payment_settings`
--
ALTER TABLE `com_payment_settings`
  ADD PRIMARY KEY (`id_setting`);

--
-- Indices de la tabla `com_payment_tmp`
--
ALTER TABLE `com_payment_tmp`
  ADD PRIMARY KEY (`id_tmp`);

--
-- Indices de la tabla `com_payment_verified`
--
ALTER TABLE `com_payment_verified`
  ADD PRIMARY KEY (`id_payment_verified`);

--
-- Indices de la tabla `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `guest_treatments`
--
ALTER TABLE `guest_treatments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`) USING BTREE;

--
-- Indices de la tabla `guest_types`
--
ALTER TABLE `guest_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`) USING BTREE;

--
-- Indices de la tabla `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`) USING BTREE;

--
-- Indices de la tabla `opportunity_areas`
--
ALTER TABLE `opportunity_areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`) USING BTREE;

--
-- Indices de la tabla `opportunity_types`
--
ALTER TABLE `opportunity_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`) USING BTREE,
  ADD KEY `opportunity_area` (`opportunity_area`) USING BTREE;

--
-- Indices de la tabla `promotional_codes`
--
ALTER TABLE `promotional_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`) USING BTREE,
  ADD KEY `reports_ibfk_1` (`opportunity_area`),
  ADD KEY `opportunity_type` (`opportunity_type`),
  ADD KEY `location` (`location`),
  ADD KEY `addressed_to_user` (`addressed_to_user`),
  ADD KEY `room` (`room`);

--
-- Indices de la tabla `reservation_status`
--
ALTER TABLE `reservation_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`) USING BTREE;

--
-- Indices de la tabla `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`) USING BTREE;

--
-- Indices de la tabla `room_packages`
--
ALTER TABLE `room_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`) USING BTREE,
  ADD KEY `room_package` (`room_package`),
  ADD KEY `user_package` (`user_package`);

--
-- Indices de la tabla `sms_packages`
--
ALTER TABLE `sms_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `survey_answers`
--
ALTER TABLE `survey_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`),
  ADD KEY `survey_question` (`survey_question`),
  ADD KEY `room` (`room`);

--
-- Indices de la tabla `survey_comments`
--
ALTER TABLE `survey_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`),
  ADD KEY `room` (`room`);

--
-- Indices de la tabla `survey_questions`
--
ALTER TABLE `survey_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`);

--
-- Indices de la tabla `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`);

--
-- Indices de la tabla `time_zones`
--
ALTER TABLE `time_zones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`) USING BTREE,
  ADD KEY `user_level` (`user_level`);

--
-- Indices de la tabla `user_levels`
--
ALTER TABLE `user_levels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`) USING BTREE;

--
-- Indices de la tabla `user_packages`
--
ALTER TABLE `user_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `voxes`
--
ALTER TABLE `voxes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `com_payment_invalid`
--
ALTER TABLE `com_payment_invalid`
  MODIFY `id_payment_invalid` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `com_payment_settings`
--
ALTER TABLE `com_payment_settings`
  MODIFY `id_setting` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `com_payment_tmp`
--
ALTER TABLE `com_payment_tmp`
  MODIFY `id_tmp` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `com_payment_verified`
--
ALTER TABLE `com_payment_verified`
  MODIFY `id_payment_verified` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT de la tabla `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- AUTO_INCREMENT de la tabla `guest_treatments`
--
ALTER TABLE `guest_treatments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `guest_types`
--
ALTER TABLE `guest_types`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `opportunity_areas`
--
ALTER TABLE `opportunity_areas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `opportunity_types`
--
ALTER TABLE `opportunity_types`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `promotional_codes`
--
ALTER TABLE `promotional_codes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reservation_status`
--
ALTER TABLE `reservation_status`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `room_packages`
--
ALTER TABLE `room_packages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `sms_packages`
--
ALTER TABLE `sms_packages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `survey_answers`
--
ALTER TABLE `survey_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `survey_comments`
--
ALTER TABLE `survey_comments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `survey_questions`
--
ALTER TABLE `survey_questions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `time_zones`
--
ALTER TABLE `time_zones`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=425;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `user_levels`
--
ALTER TABLE `user_levels`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `user_packages`
--
ALTER TABLE `user_packages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `user_permissions`
--
ALTER TABLE `user_permissions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `voxes`
--
ALTER TABLE `voxes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `guest_treatments`
--
ALTER TABLE `guest_treatments`
  ADD CONSTRAINT `guest_treatments_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`);

--
-- Filtros para la tabla `guest_types`
--
ALTER TABLE `guest_types`
  ADD CONSTRAINT `guest_types_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`);

--
-- Filtros para la tabla `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `locations_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`);

--
-- Filtros para la tabla `opportunity_areas`
--
ALTER TABLE `opportunity_areas`
  ADD CONSTRAINT `opportunity_areas_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`);

--
-- Filtros para la tabla `opportunity_types`
--
ALTER TABLE `opportunity_types`
  ADD CONSTRAINT `opportunity_types_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `opportunity_types_ibfk_2` FOREIGN KEY (`opportunity_area`) REFERENCES `opportunity_areas` (`id`);

--
-- Filtros para la tabla `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`opportunity_area`) REFERENCES `opportunity_areas` (`id`),
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`opportunity_type`) REFERENCES `opportunity_types` (`id`),
  ADD CONSTRAINT `reports_ibfk_3` FOREIGN KEY (`location`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `reports_ibfk_4` FOREIGN KEY (`addressed_to_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reports_ibfk_5` FOREIGN KEY (`room`) REFERENCES `rooms` (`id`);

--
-- Filtros para la tabla `reservation_status`
--
ALTER TABLE `reservation_status`
  ADD CONSTRAINT `reservation_status_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`);

--
-- Filtros para la tabla `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`);

--
-- Filtros para la tabla `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `settings_ibfk_2` FOREIGN KEY (`room_package`) REFERENCES `room_packages` (`id`),
  ADD CONSTRAINT `settings_ibfk_3` FOREIGN KEY (`user_package`) REFERENCES `user_packages` (`id`);

--
-- Filtros para la tabla `survey_answers`
--
ALTER TABLE `survey_answers`
  ADD CONSTRAINT `survey_answers_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `survey_answers_ibfk_2` FOREIGN KEY (`survey_question`) REFERENCES `survey_questions` (`id`),
  ADD CONSTRAINT `survey_answers_ibfk_3` FOREIGN KEY (`room`) REFERENCES `rooms` (`id`);

--
-- Filtros para la tabla `survey_comments`
--
ALTER TABLE `survey_comments`
  ADD CONSTRAINT `survey_comments_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `survey_comments_ibfk_2` FOREIGN KEY (`room`) REFERENCES `rooms` (`id`);

--
-- Filtros para la tabla `survey_questions`
--
ALTER TABLE `survey_questions`
  ADD CONSTRAINT `survey_questions_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`);

--
-- Filtros para la tabla `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`user_level`) REFERENCES `user_levels` (`id`);

--
-- Filtros para la tabla `user_levels`
--
ALTER TABLE `user_levels`
  ADD CONSTRAINT `user_levels_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`);

--
-- Filtros para la tabla `voxes`
--
ALTER TABLE `voxes`
  ADD CONSTRAINT `voxes_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
