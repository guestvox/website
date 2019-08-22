-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-08-2019 a las 02:13:53
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
  `type` set('administrator','hotel','association') CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `signup_date`, `type`, `status`) VALUES
(1, 'GuestVox', '2019-07-16', 'administrator,hotel,association', 1);

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

--
-- Volcado de datos para la tabla `locations`
--

INSERT INTO `locations` (`id`, `account`, `name`, `request`, `incident`, `public`) VALUES
(1, 1, '{\"es\":\"Alberca\",\"en\":\"Pool\"}', 1, 1, 1),
(2, 1, '{\"es\":\"Lobby\",\"en\":\"Lobby\"}', 1, 1, 1),
(3, 1, '{\"es\":\"Habitaci\\u00f3n\",\"en\":\"Room\"}', 1, 1, 1),
(4, 1, '{\"es\":\"Restaurante\",\"en\":\"Restaurant\"}', 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notes`
--

CREATE TABLE `notes` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `description` text COLLATE utf8_spanish_ci NOT NULL,
  `date` date NOT NULL,
  `user` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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

--
-- Volcado de datos para la tabla `opportunity_areas`
--

INSERT INTO `opportunity_areas` (`id`, `account`, `name`, `request`, `incident`, `public`) VALUES
(1, 1, '{\"es\":\"A y B\",\"en\":\"A & B\"}', 1, 1, 1),
(2, 1, '{\"es\":\"Ama de llaves\",\"en\":\"Housekeep\"}', 1, 1, 1),
(3, 1, '{\"es\":\"IT\",\"en\":\"IT\"}', 1, 1, 1),
(4, 1, '{\"es\":\"Mantenimiento\",\"en\":\"Maintenance\"}', 1, 1, 1);

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

--
-- Volcado de datos para la tabla `opportunity_types`
--

INSERT INTO `opportunity_types` (`id`, `account`, `opportunity_area`, `name`, `request`, `incident`, `public`) VALUES
(1, 1, 1, '{\"es\":\"Calidad en los alimentos\",\"en\":\"Foot quality\"}', 1, 1, 1),
(2, 1, 2, '{\"es\":\"Toallas\",\"en\":\"Towels\"}', 1, 1, 1),
(3, 1, 3, '{\"es\":\"Wifi\",\"en\":\"Wifi\"}', 1, 1, 1),
(4, 1, 4, '{\"es\":\"Aire acondicionado\",\"en\":\"Air conditioned\"}', 1, 1, 1);

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

--
-- Volcado de datos para la tabla `reports`
--

INSERT INTO `reports` (`id`, `account`, `name`, `type`, `opportunity_area`, `opportunity_type`, `room`, `location`, `order`, `time_period`, `addressed_to`, `addressed_to_opportunity_areas`, `addressed_to_user`, `fields`) VALUES
(1, 1, 'Reporte 1', 'all', NULL, NULL, NULL, NULL, 'room', 1, 'all', NULL, NULL, '[\"type\",\"room\",\"opportunity_area\",\"opportunity_type\",\"started_date_hour\",\"location\",\"cost\",\"urgency\",\"confidentiality\",\"observations\",\"subject\",\"assigned_users\",\"description\",\"action_taken\",\"guest_treatment_name_lastname\",\"guest_id\",\"guest_type\",\"reservation_number\",\"reservation_status\",\"check_in_check_out\",\"attachments\",\"status\",\"origin\",\"created_user_date_hour\",\"edited_user_date_hour\",\"completed_user_date_hour\",\"reopened_user_date_hour\",\"comments\",\"viewed_by\",\"average_resolution\"]'),
(2, 1, 'Reporte 2', 'all', NULL, NULL, NULL, NULL, 'room', 1, 'opportunity_areas', '[\"1\",\"2\",\"3\",\"4\"]', NULL, '[\"type\",\"room\",\"opportunity_area\",\"opportunity_type\",\"started_date_hour\",\"location\",\"cost\",\"urgency\",\"confidentiality\",\"observations\",\"subject\",\"assigned_users\",\"description\",\"action_taken\",\"guest_treatment_name_lastname\",\"guest_id\",\"guest_type\",\"reservation_number\",\"reservation_status\",\"check_in_check_out\",\"attachments\",\"status\",\"origin\",\"created_user_date_hour\",\"edited_user_date_hour\",\"completed_user_date_hour\",\"reopened_user_date_hour\",\"comments\",\"viewed_by\",\"average_resolution\"]'),
(3, 1, 'Reporte 3', 'request', 1, 1, 1, 1, 'room', 1, 'all', NULL, NULL, '[\"room\",\"opportunity_area\",\"opportunity_type\",\"started_date_hour\",\"location\",\"urgency\",\"observations\",\"assigned_users\",\"guest_treatment_name_lastname\",\"attachments\",\"status\",\"origin\",\"created_user_date_hour\",\"edited_user_date_hour\",\"completed_user_date_hour\",\"reopened_user_date_hour\",\"comments\",\"viewed_by\",\"average_resolution\"]'),
(4, 1, 'Reporte 4', 'all', NULL, NULL, NULL, NULL, 'room', 1, 'me', NULL, 1, '[\"type\",\"room\",\"opportunity_area\",\"opportunity_type\",\"started_date_hour\",\"location\",\"cost\",\"urgency\",\"confidentiality\",\"observations\",\"subject\",\"assigned_users\",\"description\",\"action_taken\",\"guest_treatment_name_lastname\",\"guest_id\",\"guest_type\",\"reservation_number\",\"reservation_status\",\"check_in_check_out\",\"attachments\",\"status\",\"origin\",\"created_user_date_hour\",\"edited_user_date_hour\",\"completed_user_date_hour\",\"reopened_user_date_hour\",\"comments\",\"viewed_by\",\"average_resolution\"]');

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
(1, 1, 'IWLMJBUA', '1', '{\"name\":\"qr_IwlMjbuA.png\",\"code\":\"IwlMjbuA\"}'),
(2, 1, 'RIJ9VLHQ', '2', '{\"name\":\"qr_rij9Vlhq.png\",\"code\":\"rij9Vlhq\"}'),
(3, 1, 'Y6PCQJWG', '3', '{\"name\":\"qr_y6pCqJWg.png\",\"code\":\"y6pCqJWg\"}'),
(4, 1, 'TJBQFBRP', '4', '{\"name\":\"qr_TJbQFbrP.png\",\"code\":\"TJbQFbrP\"}');

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
(1, 1, 20, '99'),
(2, 21, 40, '199'),
(3, 41, 60, '299');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `private_key` longtext CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `currency` varchar(4) NOT NULL,
  `language` enum('es','en') CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `country` varchar(4) NOT NULL,
  `time_zone` text NOT NULL,
  `sms` int(11) NOT NULL,
  `room_package` bigint(20) DEFAULT NULL,
  `user_package` bigint(20) DEFAULT NULL,
  `promotional_code` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `settings`
--

INSERT INTO `settings` (`id`, `account`, `private_key`, `currency`, `language`, `country`, `time_zone`, `sms`, `room_package`, `user_package`, `promotional_code`) VALUES
(1, 1, 'OvX7WsT*^Ji35si,rEnFi8jrn(x9tHN3?.e3}]q0u)!D<GG9d~B(@7N5LE<psQgs:Mz-WJbRgm4!)pYiHPBGjZ#tnEFiZ0Cd)rc:uJNj(]_rZtHY0<:XkacT/!p|oV[7', '', 'es', '', '32', 0, NULL, NULL, NULL);

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
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `survey_answers`
--

INSERT INTO `survey_answers` (`id`, `account`, `room`, `survey_question`, `rate`, `date`) VALUES
(1, 1, 1, 1, 3, '2019-08-21'),
(2, 1, 1, 2, 3, '2019-08-21'),
(3, 1, 1, 3, 3, '2019-08-21'),
(4, 1, 1, 4, 3, '2019-08-21'),
(5, 1, 1, 5, 3, '2019-08-21'),
(6, 1, 1, 1, 5, '2019-08-21'),
(7, 1, 1, 2, 5, '2019-08-21'),
(8, 1, 1, 3, 5, '2019-08-21'),
(9, 1, 1, 4, 5, '2019-08-21'),
(10, 1, 1, 5, 5, '2019-08-21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `survey_questions`
--

CREATE TABLE `survey_questions` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `question` longtext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `survey_questions`
--

INSERT INTO `survey_questions` (`id`, `account`, `question`) VALUES
(1, 1, '{\"es\":\"Pregunta 1\",\"en\":\"Question 1\"}'),
(2, 1, '{\"es\":\"Pregunta 2\",\"en\":\"Question 2\"}'),
(3, 1, '{\"es\":\"Pregunta 3\",\"en\":\"Question 3\"}'),
(4, 1, '{\"es\":\"Pregunta 4\",\"en\":\"Question 4\"}'),
(5, 1, '{\"es\":\"Pregunta 5\",\"en\":\"Question 5\"}');

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

INSERT INTO `users` (`id`, `account`, `name`, `lastname`, `email`, `cellphone`, `username`, `password`, `temporal_password`, `user_level`, `user_permissions`, `opportunity_areas`, `status`) VALUES
(1, 1, 'Gersón', 'Gómez', 'gerson@guestvox.com', '9988701057', 'gerson@guestvox.com', 'f53d6dd0204f8b2faaf10f1ccad212025ebc73f6:1X5m1Nx9jm4ugQTWmKOAat7eX8yreg6VfNVPiphTMSxiEZZyY1TOgs63vu4NupDT', NULL, 1, '[\"1\",\"2\",\"3\",\"38\",\"39\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"16\",\"17\",\"19\",\"20\",\"21\",\"18\",\"22\",\"23\",\"24\",\"25\",\"26\"]', '[\"1\",\"2\",\"3\",\"4\"]', 1),
(2, 1, 'Saúl', 'Poot', 'saul@guestvox.com', '9983856109', 'saul@guestvox.com', 'f53d6dd0204f8b2faaf10f1ccad212025ebc73f6:1X5m1Nx9jm4ugQTWmKOAat7eX8yreg6VfNVPiphTMSxiEZZyY1TOgs63vu4NupDT', 'r4yAjXyZ', 1, '[\"1\",\"2\",\"3\",\"38\",\"39\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"16\",\"17\",\"19\",\"20\",\"21\",\"18\",\"22\",\"23\",\"24\",\"25\",\"26\"]', '[\"1\",\"2\",\"3\",\"4\"]', 1),
(3, 1, 'Daniel', 'Basurto', 'daniel@guestvox.com', '9988452843', 'daniel@guestvox.com', 'bff990e1bb63d579bc65aa9c9b2160bf4fc792d0:OQ4m2Q8UtKDW02kCfF7JT8077jQffhBFLNWgOBQZ5oxAY0trtGAb8k0H99uxAxuR', 'v42CkX6e', 1, '[\"1\",\"2\",\"3\",\"38\",\"39\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"16\",\"17\",\"19\",\"20\",\"21\",\"18\",\"22\",\"23\",\"24\",\"25\",\"26\"]', '[\"1\",\"2\",\"3\",\"4\"]', 1);

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
(3, 1, '{manager}', 'Gerente', '[\"1\",\"2\",\"3\",\"38\",\"39\",\"27\"]'),
(4, 1, '{supervisor}', 'Supervisor', '[\"1\",\"2\",\"3\",\"39\",\"27\"]'),
(5, 1, '{operator}', 'Operador', '[\"1\",\"2\",\"39\",\"28\"]');

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
(1, 1, 20, '99'),
(2, 21, 40, '199'),
(3, 41, 60, '299');

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
-- Volcado de datos para la tabla `voxes`
--

INSERT INTO `voxes` (`id`, `account`, `type`, `data`) VALUES
(1, 1, 'request', '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'),
(2, 1, 'incident', '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'),
(3, 1, 'request', 'Poc5btD/5H6RLRcPPPGP/zYeadrFyk+1o3fpLnsTsw0RhgShRjWxIkAx3jbVIIcW7iPqejn+2EqcP19/DmsVSCoRzmL1m52AzOIHsc24C08C7d5Nex9a6oI0NAEXbZbUr0Cr2q0/nz4BrS75dQ9OuanQap5c7AfSnKIIQLhM+mtbGEAdgf5L9N/T6J2UQ1/mN9eL1kncqyfhQyH1bpFBRJ2utquUMIyounyogJZFq9X1ocdub9MxABR8ILGPH7sYkgstZkPOCQbJlvRA+UxR6JZSnqh07yuKK2QHW+N3WZLf0V5Vxtz+UOPLIg/xq3LeRQhUDg8S5/p+Msp0WVb5gYuOaZtnOf8bIUp9PXHwcDqhSTxf7A/fc6KuGdsg/WoToXi7ez7OF226m0bu+e2wRMHGuJ8gDmbwzDx7XojSOr9wTLYjTTtoHcVldXdxwZUVikBk86HMqPQqSvf9ECrTlogDcVHfN7nkiWfl06295SzIckOOMGp4q1uDDKPhzVBhOhg7ybBl+qfQGXfFQ8egtSmCT6S9uWg1TbGUF71uEGUj5jmK13aK7Iw/1okB7LuD1QM6my9zoTkyB7VmL9EoKkxCD3fElLE0Fd09KRcMLg11URyT1fifHXi4U2pMNLH6o/u3QFWYmxKro0k0MNQzAJwAuy8Dke6Efyj5MO7EvKMHr2DzdwlUjwAqhQykMdkdTr+t2SVLsPfwUxpJ2Agpz5h7raL6aR5eQkwbmfOdQ8+5+pc2hKcFsJ8yLDfPvbAEec+t16CZGZmDYTnIw8yGlUqWvlxqqtaADw4nGrIwKNWpLn7MqcX/sfdxR/7TNPH/0KKCw06Yzpdf5qZLnRpFsn5NMynOd/5PSrH0uwwpepDv0sHiavBRQ41cebJeJcMg2pe5/6D/USX0aP9bLADIvxEkaHlWSgx/sa46zSf59Kp/NYEtbxyINeTGuwyUISCO5ijyP+ppqUT15xwr6E0SfJ8RL9awXNeAajY/5GLXqK/VyvWdRZz/MgviQPw8/QSuOmsRLKWhY6E6tl14Fjl/RvLA65xuvtTYBfb4SqBoyTL5RKPBhGIFMyMOyW7Zgds71yPtbzuTgd1Pu32O1MbloTjGuicjBP1nXW0sFI3SB9/qQwVSSLXNlpQ0jGhsiyCSquEejIp1sp/sRk7p9mu44MelYvCMCTxyT9yxcvaMMyWVNfCfGR1snk7+r6vXzSiEcOvAgaxHDICX9Fa0wF+uztLlR09Epjw8kJEWlNmFrLRDHHF3tPTz3+yWwPR+aSOjA5AkuXoVBP/oFRsiL8Lj/wnX6HZiDeQhB65dOSesu0LRoDvSE06udA+aa+9ktF3jcolRVo1YoObvqxFI1F7F5w=='),
(4, 1, 'incident', '5qlcCOik5vVZkHyjXYk5TMZqCMk5mQdR0nZl1IMpObdj0rSMFcWdV51rZ2gaNtA/FMCbs0qBQUfsbUGthjZf5ZfXiHqV4Fck73RtLkLn3P2+k5637oU3Aq1INNfEJZ2Y/AuDInpD9VRqI1gW5vIy4rfXRXSrhzt4UmcMD2JHfU0eiMOvtyyHoVDQyMcPBWtX6sGGmuZf+tLrMIDZeQazuaESjqi01r5/ftOaVtd3it3zRJCEu3qXc1unqnATrHD3Y8kmxurv624nQsiTISRW0/vpoYKDYkF44gXgy8YvEb5TmoO6Jbh1xp8f5xjh/HYpVtV9e4c6QOHKrhvV/A/ATpMzIupMPQSgmourgtFLa2mbgI5PUgT9687MWoScunmlCN37F/odOtH7M8qEmJSZ9aNZrde/7GeybP7HyJctKNHAuZeQyVsY6OqcE0mdxUq8Gg3hPRYESALgnKnFD7hesgHqSyU9g2/j5iUh+OCsyVcfaXf8IgPZNX3Ta17QMqxvd3tErBjLrwgifd12B54ELJf3/pdVb8/NgQ9HYXfMoZ9pBvZQod6d+RZdeOOhLJXY0wnfk1O1JYALZwYfCEcEmO02y0CZt3c4IXQwqhm1c4Lz8VsyTRQcwrX9/SE66rpb4DCX5PhUzguYincJBm1Qu9T0Ih5lvtvBPt751ZvRHtbP4pEC83wc0LOHOoN0gTKrpOzRBe6iCkIWT0NIMXf6lMox0IzgKnZTgQV0hnfuQ5z+Ug5y+0Kll8hQYrnxxpCqt23nu8f81hnZbrOGxn104j/l0Rva+Y2bVomDjhpzBthTFQXbfCZ9TaFAomriXhpl4M0OhRn7PpiuP+DdRbhDii/3aXFoySYf63VdvN8jAdUAcrDKdhoHXrJNSeazH6C+5zxN8+JWw4uZxbqN46bYdgCp6LBQ5bdnDhLvbZJGbDLdQIScebY9pHx4H6sMYOgXnz0JX5p7tQ0JEPO2eMFC1tuLh287+kaTkC54fku/pqnBvnwMTZbHWexj+/61gzBgEvdToZas8RvOPpmFtivG/80KKfdCGHMNXFqrIH8Uv/UQapzZrbuUqdMhDMEST/bzKGERxWSVkjVjs8WNHhly5/hArIBttk4eB5yTz5fmeuN9YtK9Mpl2s+AhQgsBXzYXishEXLD4RFJJ4dc80bI8Prm/9nHK8DsNKltJ7kAZJgMDfeg3n8NF5mheiLaJzB6Z7mFe8rayK9crZY1iLICJFEg0vnfltQ399UQ2H66k6VPn+108A1+rELwvPVgY9vdSLlF69NSebxIgo2sXR1wO6tIl6Qpc4FDWbPm499S/1v+gR78KAYdrPV7oNfktQ2YCG2kMIMBDEOss9UMgCdVy4w=='),
(5, 1, 'request', 'lTugBPAv2Hu3RlzodQKHkDFWW5A+2mcKaePAie9Y+qJP8OoElabGAU5JIAn3whK9oNDD90ouJ99d2ZLmoB6vwmHDUmxpmrCt43p0nNnBvUmn49FDLd1sKnXINYTQe/1Xzq1PBymhzYuSsORTkcNi6Iw0BWmU1RWppgZD0m7NC51qdZKZwn2K08+TDcwsdVMdWdpGyWGqPNx1Vp89ujuzmcK5ms/I3Bi3PBFiZbJJvDYG61Rqk76c2xF7FQFfBetwoWrq3oAIh4pjKSTiPlhImrlyFxmLvSB2qHd52NdNUXRn2ZjI7HRcYIE8rPlL4z2UjZYO6lC2iZHUzD68y7avq+D8OF3f62Co1ObSTzD3Oeo1OemqAt55sH+QA76QpfLRPXkIuEmD0AlvKd19K/E5Y/NcGEy1+qD/2l3g8P8v5ALXqset8uq3hrvhUywAo1bmpIFAEPT3i6cHCNPaDuMUnE3r8n/UuBArSqxHVuv8KfYwiwrITayB70seI6NKow1EKtK26XrrKnn36jtb9M73fjUX8wQv/bqdKjne+Vx0ZFbJRbpHC5lII7MBkEvmupV8dZwWEs0xuley8eutjTEc4B2mf6U8vYPCGdNcbO4opOlKopVxrIrkLLdgCojbFdLhVbeGMH2sVJbsuoX/rJOlDwPJMG7BWiMc3PJAP4wSu5gbcKSRRKqVcP3NtKNE1LPLXDG6UIyR2zIuurUkWk8kQorR5JSfaRxfyiAW9C96+iUBCFfNyZjwdXpjuQoD6p/crE6ERhpiXYwpPE97CDiMQzETwL6+59MRwUVbc2DmRCLzk9jgHMjS5WVVcscsMAlIa5QjaBfq26P5GHfVUq+s4yuK077pZIMF0YLSnrErr1Pr4XeOG2gYxgVSnCWfvUo4icFf3aHyLBaN4KLoo2V1iIf4yg3WZbw2OZe56ZnNz30qsbxRlu2vfIH3FgJRQPyNiXoLbzoaVn3pnp/2RR5J9gf4K+2bl+qwOhaPFvEHqVw2sNoV7DldahDzwIVEnE/wMTgY5dBqNyKTR6fFqpbVDGkSH+r3i6P0bLwbFONoXqq3bcYW0q051Hfzcl0ESWPVrbAAMONjJUF6e68CAIaqrm8GS2aYgWqlkdnCu/Vt07XQFRwbTk5h0o1/gZsCqoCDSsb+Q+VPMxhQJ7LLfeF0KuB5oQwtKjWy1Pqq9HmJeIT9+sq/+tatzCwea9jI0eUFgdUaUkAqUzVKtIuICPldgA=='),
(6, 1, 'request', 'xIdKYDYI5xAHrZ0y1SDXaQppfVgusIV3COBk4UFLSODvMfUiImiREyhI3+tVyAcyc3NNg2W4Dg/1Vvf7u3uzKuYW3IeQaxF8mziF+tcIFwoVzg9gECpttDGTfInBF3DQVIzUt9bccqQj3W5cPbBEozCzCvQfeaDXejvZN9xJQVggz+vUkg0zU541rwFQBhsXSST9dbf/2fF32p2pWN2E+eUkY8qRuZtnlTvuDnPIJC8g1H0JYiR5zEyJ4JRskQnMaGAihvuy3q1OtJIfSO9Xgc8VvdJH0yXDqp9fWuGDPIg/yXakLEH6q0m6VZhHKbYYJNkOIOtJvZ4N5xBI4+cKWRgO9PTYHcDapWqw2g0vig5vAnf/I7SgaQKbAsD7AXGvZAyhzvC5q64ZdIoG5dzOWRkP2e0d/oY4QW0AGO18APiadQp3OqwCCP3fMtiK6fl0lDAZqjQe6IunfB9Bs27YcVagPEvoK8M+zJofnqU0l+sT79dUGqXuwdmEVO88NEfQ7nQOjCSZmc/Skj7eEkHqbwLaxky3+Hq/t10ttI96ooBrTfzqUEkRHGjw3l+Bx+u9VyJXisW4VesFlwBaA5m1UO7zTAhPOJh6dqLkNB22Tde2a63LL9syCfInw0jfI6UU/4YZvc/caBiCYVFWCrpuNUWXx5RbAUYsx9LMJp88XszEHxJqOK39X/7FB4NeHJYVsVi90hjQC6tfWNgjMb/vwkqnNSf9I9sTktDfCcK+V8nRAbVM9LfHd4xzRsPJRIuVq9xQ6pYvQr0WZXfUe2530YoLIunEVg7TKp+p6lbi4YS7CZ1ut3vBbVsnwaPxuAuz1TWo5loVhRJ+nYO+aeU7x5ppmkkej6B7oBSfEtpABuBK32al0GGeMNo9e6sTKJIp7SvVd0C75IctVinemAfrHM75bfoXx+PlbTSF5mNuzJ8+JZvFI4klD2WKTBtIN7rYkUmdEy9eZJeiaHATLcdgCpt3dAWpdCSWKyZfg8YgK+QaNrfferDvHCd3n7Jl56kc4ZAJ2eRsMk+8TFa8+tpf0PEO39OeoYNKGpXkV/9+IuAX0d5nZoINN4yE1yeeUB4zGRPMGmmwPi/LJYdisYXcAssiQ5uvyGLUivuf5ymIVxb1H/NGyvhPTJNWftovE/s2CLhRPwwdUS+v4d9hioQ2OnTGUxD33G5wQ+omdwZ3OmIm+qGwOpYGdQmVtDlkqceYbN6BrSjiqN6yB2WLseHJuw=='),
(7, 1, 'request', 'EFru9+5ihdsau9GESWdrOEMLHSH671dnHWzwQHk+p1swmGrT9YtE1I9heqmWKOa0y9X74pBORILUzmJyzFHz8/JoGkpdtH1W/xFU2fMbNP7nR1yNLxkOACthR7oK5d4bbrm10GRb5FTzlQKgy9UFp6G4mrpnqnJpU9Bsz+Zi5P6+VRlsgmLuoTmVOyRbEGL7bqrQ48vU5qwjezx/zY2/3vgvDAe7dE3xEan+wvAhk0w3nVKN/ge3OLuIKGoKQ79Ljk4InJZMdYCy6wtsacFwVJX5mjurMZ1WxMH2cZwjNQlB6lMRGiwSVTgrtFfa++OjaZ75waResZYq5HLcstrPdoMXzLKmDugeBjHhNGV+4pfrEtcjM15vPImJf56UcTc1VNsqmNn30Mkx4sbdIdn7t6h/EerElowrM2m5BGns9NQohr7pMaMnKG54jCx6JBNPNdfEI8OmIDOFbdJuCBuvC9oaqtjDCxyUws3ZKCJfqsdcp9zHouIUwinZxiBer1/tIVH1WN2NrUGk8PYwoi/D8qxaPkjNkXgLbiNTQuWs/5A+0UWpqs0k+swZyQiq+WcnQbilyWD4V5ZrEcL7aomKAddZJrw7AK4W1sfk5pivTCFUz1n8tLUv5/kvZVshkgdStQA26z5LI2fmPH3uFiseTRZPzfaCKFCpRb4kNY9HHPmFNSjzeKzlKMCcqQztPlFJD9IoxWXNg64WwWX9BacPw7thu1KckseptLuQ+WovaNPGDL5iH5agIrQDhyhJA0bOxiAXPE8UU2DO8y37JTOoL1yCo1ULDAHUbcNwAtx8JaR/Vrhapc/Sdmz59ZCfYXBInPeBH/wa0+FpAf0f7GmjR1BVACXpz4+w4tcaLKrPgsf9PsV9MCbSeKtHVvnF4tJNq68lQMYU4QEFGiEWkyJmY7tLmXI5u6DHj1PA8Yi4JL4QxAdcPLmMgwOjw+nNmyLSw7dFOsnI26hqlAcAKIdkd+e1CXXXx4r4kNF6uxzh0TZnFcav8RCGu7yoyIpPH0f+b0I3jSIc6EzLVoEsixoqIwFpusgMrlH9+n368dU19CVGbZwxd7qVhFsln6V0mNrRVYxc7f0srBJccvwzK7aPMg+mfhEE0MoGIy9gHWlleiSE3J38NpDmQeHgPg2uLZdPDB4WqHUFHjY2G59PVdzfY0K49jtmOpRxLLcnjkGUzoRbAM82Mk6bOW+EUJ6n549nQgBQNu76sxHXQslcGEjEbg=='),
(8, 1, 'request', 'a0nzaJhc7vXOgOE/8d2wFyBtSQIqTGGlTeq6X6TVeiQ3fhQIbkIl/3VSSCULuAviGIjwdc2Fbz6bM90Mgo8w+yvCD5PLXdF9HAZY6fYdav5rkiuz/CkXrFKNwudlMZRM1orsV8HAUUsyMo9f4hQLsvFFbcld0C1rHNQcxxq9yg4dq8g/Wm4Sfezn07kjBpasoXbR7djlJIA04WRN7XR+EpbWcq/32MWdbeM1YEcJkaPaYCBeGGjfzsLBLk49/I5/GlceDJ8g4WlX0OHohWV+2sjbfM9p8ey5IxcDrnZYJWXWjPG6VlAN2p2ccB8ZJ+i0l074j26RZxK6y+Qy54tLnAEwckGbM7iy3TLrVKbzdtiM1jJ8IQvDqOqHKVvuGHw6FWmDVAriZHvfkjTr9ofluu9s5ofm3wxZRDoUFKVtP+7mbRkGd7qXiItGTLSxcCl1QF5+AqggOghaZEudNzaQQMb7a05JcSzh+P/94R3KkI3jTiu558TQCdZs1Mhmbi/ZNmSwK3bXDjO4BcY+kXIp/lFnz+3mCiRjP9Ou/IpjbuKCTFwNwUfMEZ+l+VnKV+SZyDmmMRjQFsVUNkMNOXnMFkoWn4By/eXR8wmJYWzIOe6V5TBSRqlFWk3ZmlAmgWzhvZoYTz26DLMSfDwa6nS5ZBy1rIWXtdpf4vSjREYlgDxOkRDoQlL6CeXuaI7rD3p8+A5mSXWD3gxvCEgneH6luZZW1GQDKsbWs+/8zfg8heoqX1Sz6YkA5H524bZQ0D3m1apuskbTFtw25YOQBcvenQksZewXVGVajJrXmJjJHSbz2cK00QmN7fAfe8W1xRNBS9vj9gv9cD3n5t2XnsGfdX/i4+AtgEnbOGMoc3dr62EZC+ttPIxiFeGbnxlS/sSNscNCkdArkmCPnSCDzwSlKPMtIHBzLd3RydJWslkAxmBdfg6D8ddH3r6/ehqk0i8oXCeKLkT9mbQrAAUTWf34i4UrvDmxgbsdwyXDnHKFIv682V5SQmi+nJwwXxbHumPzkEybbeGIeyolE2mjW/3qpt0d1WewBK8c1t0AZBzmkpegWRoIqgp1s7H2XmQfCCvrLfnPkz6F/1uNEs6imfh9pNRSzw6Q7VPbbMmPa/EWuiRATb1h+nW4cF4T5U35x5RcRBs2GV07UZ6mtZof95y+iIvUbug4fmJ3AjlAFdH0d+P5TCujTdL3/ttV6H48uOkC2aUeoPRuAqja1QyaOjRuxw=='),
(9, 1, 'request', 'O3aSeC0MyhdpYWBbg8KUAEfghGYPvWjfP3FvYymxpGb2MvdGR0WdSX8jTu6d1UdUY+YgJtnRFbSO24yT3GpekdDzAb897QTbdCs7qyXTZaTsuYz50U5o5ud+7HKPR7raUKvDisAhjAynMO+1RPvunTC5iJBVD7rfIYwMULIa5KgGqmkjjgQfJGCTKMEi+p7FmJKVr2fQKuZ+Ux6rYJB0sFdTEzHKfI7rWCu3DICeKkS5l+ahwADShyDwuFHnXQR7bv4jgpV4vbKojnvBLrttftVXE/ACVVfwH46oN07BlnOkHwrZHPLEBiQjGaMz/acgZySDIeoleOeZwLCvhIIlqSbkKoAnnpRgnrzUsrjo+vg13W7R7J1BUgEmesNWsYqZDgL5HtdbyOHMaaTFDa51xDXi+fv1mlmnmDlflz3muE2OmBc3YmkKqsoJfSFLGYXuXPatWe3Uf9gSxZ0qt2EIdDUdjivfMlyNBFB3OHcTuLVixRLUIs28ttqnl6o9kBxQgemx/O62PFH/zLwgTcMHJK7ZLV7DTZAa8qGDjG6UaO+n4NFeEQQgNKJ0+6XWiTOMaA9IiEF2C5GhdtElFp5EnueJHLX7V6cG1zHu0e0UOMIE2pHsiXpjH8j8Ea+b4SEW7ivsph7iKxeFy5Eka3ha54taw9HNuXovcqyg7qBHeDXdzXC7P4Xkz5IxFtY5UiawfE3z3ZJBQjGpS/WGD5dOS/07J6S653NjqJXfwby+TCTkfm3rJQsAkmNvF3QxU3yLFrpYlZy4CUYObBAcTFQ6F/OPltVgFNggPMI45Hb/cidX5v8E/dku4dd3zWANH7C92E2Z2gAVR8lNTI1149AAtbEsYREmICa+Gf3Xi1ZTjmkaBh5UNaS882pR6wQlhSmULOYYn2VUQ20jncQd5FJ/qWYP3GKxt3uXqz5gUr/0D1jGh/bbFlNvq6qYbzMRNwatLkuCCzq2GgkBS5DqClKRyZ9cPUbBDJpDoYjTUm1Fy6Z6Dpz2tLBzDnkpapV0bZOwrHmXFzFQTGuTSZ5SN1sSaicnNv7FCBGUWT4XAZtXMPIbWkmczEzo8ZuvYsLZARI5M6rDSDg2V3KdDIqzn7SVjapnI+CoXNgOWnDJrc5+aHttXGNtl285Flj67kiLmI3WoW9iPD1F3hJML2aLlRqDwWKVnLxfTxHWGJsb6lKAgBBJunrWWM2Kpw8EBsDYQQ6V'),
(10, 1, 'request', '+yLjg5KN+7IkyvoXU3N513aUszF27xOm32+dUFWQAT84zEvbFGpFEux0QYJNkxtjQoqaS2C2A2f4eqO66Kxs1lsQGusamJ4tMlMGjI4XGT3OmOXLGzl0HKleUrO/U0JW08rLVceaIQrtw3U5HD6CU1HzX3lWWAcMO6NRl5AQf7UhpSYili+GLFalXNkU+9N/yVfYuD60+Y4l3JnDDXY2aMtcDNHSJWuMNJkNvrdPRxmtANxGqNqiQUE0XnYMgaZ8KxWwW9C0YYE7pujvrgpR+44O9b8A3OYW3Ovz37b1fq8+WylZ1lhWSekUDRmSww7omzrnXeq7nLQ0cYcKm6fPtehuJ0Xw3TsEOBbMOF2sc4VxuSfmxWR8d5I8HhVL+ibkqmCPIhEgWcDVshIJgsZi0D+Jn1fXo+0eG0aTYFnjlTTifaTPHKYJ1QkqLSCDQMHWvEpMcfZkm4Uk1e13PEWhwzA7c96CV5GkWyAP7ef7UXvFzyruxa92WzmJGLz1lFpWRxXl3JfKZ4gBNXbiXT8Hb6SAQABqDL/bdGlmluKF5W/846EmQTuTB9QlBBFddo3+YRSOhd0MdcdotK3hbX4ko1eeeDweZvpFOorzr6Qmw+4XHkymWFVg9Mi3BsN6h2atpuTT5cSJkFOTMeo2uPGNU8CwrfoejhIahDuXucjLjFP6Kwzxh5jkKoST0vlBbyLj3BUjAKWehO2KQL3624XjicHSq1ELUnwYh3qaLMZM1Ee3bqW8taCxO0N5pCenRCLMsJT96a4wEnvALFCZYO5V1yyUYfJ5S94AwWFqN7A9Z1LIAtHhSxA2WVz0w29adEvNrQzR3Vye/xLAo3EjaZ+UV2MZDJFqJd35mo9S+N1qYGD91X017lqFEQCYaoDkht4pcGMvt4V9u6PmF+rhN7JWjjy14GgEM3t4UgG/qFUMn5kJ0tnybe+Gb8gdm5X1f0WaS+voLRnMp9gE0zyxEq+9XI4D+FbyshFIkEUeTdgwAicB/IHCt+ydQoLiJG+1w5loy/doNOvC2FuHVvLhnrAkcQ2lQlPhLZxu4MAKVzaz4h9elVXDspN0Kxb+aj6GYgQeyvJ0gNkH0+LKMBLgQdeAShrZhdYaVhtbnmatrp7TTA19SMvrWatwCAsSrxIVlwExk56HqgIw0PTMG2YoQyJEek7GkJlWJoltRICOuJQHpcl964A/UKxuAqzDWc/FCeqk'),
(11, 1, 'request', 'nrEeoL5YzWgiR3/RuuiNfAFtQWzbJVA8YVLkzNF1Txn+4eo6cY0tPkt25EzTMjxcCxQovToSYDHAFpAiYJiFvaW5rKPvpgopA67idgCpm3VzGEz6sHVc2bfgHMpbt8EVLG0ZoSU2HyWafC3AX5Z59TfLORnz7zdK8Wnw4cnMUGDNX5EVmX7kIur0i5gCkZ9TFEgVznZKIiH0tKs8OFGDuNIUjFLXmqQyKSOscaKQ6vR3ymdqGqpAK3PfgvHWKXFtkauGVDPp6BzAqDvQ/ze+Cz4EYP7Yj8xek9gxhNAJHvbPGKaOEpUApg7967ZQrDO6jnI3+be7Utv8ZugpEhnsgYOJlA4inwqAByMcbJcw9W8z8KGSSeeqJQW9zF3I9iqdUPuIgDFHT6Tz6LxvNe58hvMnoliQcHHh0RqR13a7fjdiY+pG0lxXWcBDvEl5Uet5Ory1ndUJIwjasz6ulnm9Emj5TJvhDSsICTCK6z7BQF0O7p3pfnTo+ItLYbYFxRh2M4ol1a6U3Fi67T279FjDugHD7BxLBkEZZYzIEIxAtH1OPsjKKQV5G6BtYm8pnv/Ar44VI0oV7nT99dBVOUWdytTgM3srm3ZsPMuEaKtgzhC3b9nVU5JFUNAUY6RLlPx53FsMjHbNYBxJmikxIAji8sfX/dFtdwozTxLJpFx/1NDPLdKgRLat6wDwx0uEcUYx28qB1Z2mKyu5xXbbBrI0A+oOGsqz5lwKsrakIFhiunoIgi/0sN/NDCPAKA59WT+wKFCIOqAIvetDNuj66NW7uW0nA8uFXtTAFVJxIIdTRKjFUYrWYYleC3qOtTJLAn/bAOEFE6UEJsc1sYT0Sdui0wi8uoFTODEwSwXkUvkdLe8ev0TVKtHnpLyEpwe72FU1DztAeVhb4neIk2+9IpxXoFaLNJZk15xt55fj1lOSaRiUsOBhEJLyBd98qpoXSkrhXbLQXC7MNOwrxhodcnW2rpI0n0TVnOKZpvkxn5UZwzuDN3TXiYAz0SJzbbP/4xqUZlqaokO9ypn8AokbDmvGnnnL27gmNw9WvjXuctgbQVZ+HyQKktY8cfIshI6sgv8W72MCtIUwRIM6Hsno1L8K9v7x6Q479igdPeDZ6B4qDQVacsKjoeR85p+DpmDaRE/dvbk0Vu8eexj0GL0eL6GEj3Iw4qDjpOrVJ5/I+6fbrq9YSgChJGih3Dh3wb+OdWpl'),
(13, 1, 'request', 'l+d0pW/jjfp45DWq2Q1Dn99pZ6N/AKesLrleJYPM4xEJVhw6hQn4k1ylsS46L4pCNGm7Z0dx6A4GuBOHUZzk24lD30yhZnc8LgBy84Sk2kLshBq4ULESjmOHi7q4P684tCuzY6pfzh7pjS0f5d/Ic8g8Xmf+6Nvlo8xCGkMZMwp4iDZi1MeIt3OvFfHJj8VIyrdoH3ZO5SNKWxAET/7FqSarGylfi5F2ZZfIw5XTfO2aC04eXkVyIHecsyXf2s9FfmP7l/uwMiqDpz4TZgP/dcttHQX/OG9PiNwKX/q/nRQMQo/e6VfXmy0nR+1ZvoXaYb5sBc8hq49smr3ZgZnl/3AVU8LoRHEB4j9/wh7c6yKNuyilBv+8n1nwJMPpO361JYKmmC4Tq5aJtenmMjG1kvnfDbETQqEHV75ozilmaXw8uA3JSTpx9wQrmACQNISLRTm+KpPuTCXDFkCjSMDM17SuozoFGqss9UssgxchO1kgBw5W4XCqGr2GxtyQO+lFRdr5FTmaP1pnOv6/9ukKjxA3gcYHxNdy7Ytbe2AjIk7dBgYgHBqb6BqLl8KIYBrPqAehlD0ndB48e2tKQHuZnxOA6PF39Vyc4nZc/NVkXhoTy8TPdQLruSV0wOE0XsIyiwiL/XWfx1nao4WG1XyQVdOh7EWzFD9NBrNBdRUxumUuYeLgH/0oE3p1o4gZ5nNlajI/aptaYTPOhUZpfyPr3kOPyL/wRpTsIDMec9iZWfuMBLZlXD+RQuktp99tqXkFClCJQiMCcTcDHBNYsZxCGa6EZZuCVIP5vVIbX5rG6ZwpXKD+13NYEbqYnevCMBQAHaI6DwQm5HveeHYdD89QmBUsJUjAcsGLva7Xt0byyjixwDHrbMRm3RLkBPaiIjaua1TlTXcnZqoqYy50FtT/U97WT/D+LfUNtlyn0/gnmBB0Dh3k487NgNp/WaCOl3PkSvKyFk45o/OKxHl2iCkKRRiFeDrozR1fvXyWZY6hjw2hUDnP+71Hbl/xSYcQUN4MWFRFEgJCwXjbvVzPASK4qXhf6dhEyySOzdsGFqK6O6C5XrzoZTKZZRC+aljK0GyHWIJEgipSrrfaKAbvNs3eHeSxX5L9ut89uwQH0moIbkoC4SCL6OX9rvQvEy/XbQjW1jFBFKWqxvHru0fU5BzoOJqJ7FTr45af1UyQWixIVqMjKN4JyGzMzn3IbYfGa4+VsSDdXdDl91VolgKUBtMKrnwutyA2MdTuLUcdPokOUbUuOyaD6LNSMzZi5voUhY8m9HUquB3WZBCl6aKijkZWNJhPdhTj1QZF/604Tjm8gUhkr4I4PBcTNQ5wjPXaMKzNzgPMPdrgna/FYoCrKXgu7g=='),
(14, 1, 'incident', '3UT+MsEwpgK/3VjOucqgtsBcGTPRhCm64WN0HjxzpCPC25GxZuJB9oq4n4kydQzGmpm26ND7HOYasC9/jSDPMX7KPHCXTsXegtkSaBN6dBDKo8lK3xK3oXU4+bbdCbG8oD0rvPmUUzytX72FhqkXQF0auAeu8eM8+7LcCJih6XQ5ZBLnH2bTNjOkSBkBltTzBgZZ82WlihEdNnUA+stfyMvFpvC052Cm0Fwvsa2mVpQiluFHTsYe/ohsW3FsI4EIvfUz0tBjVGuSAyPk7VGot81icNhn6E7CD31yViwqHzB2gVx3FTRLyHNtGY1z1jpb4aJYLBQgmI1aSFRC6pZZGeqrOHr5NEZLcwQvMWl2dozwqpR5k45NZ4AniruMExXv8mw3vJ5BXC/0SSg/fvRRQC05E3TJKKxIkU/YduJUMWrW40ILChhkzs38tXIs6/VvEXvrwsZetnUoXVHUepCt5KD8wX6cyMS76Eb6l9lZcfgdZmlSBpAtqRyZwDrNqkcbPbO/WIAB2YM3aFFV2Q4Vz2BpCZSZFQVEWhPx3PB4KSBJHPtM8ZR+NmIsHzlIM61te6KHe1ws4E2LBDKOHp1F5ZaicN6viX+hSGBW0JuXmN5VkI2kYeIOCIiQ6HlR1yyzguMVoqYZ9bxJTl7FmJZAZt8t/xb2V833geWXN6XiK/ThJ5NY/midPT8ABBvHi25VtGiqdjrOMt5d0eFWO1p5bY4pNSef7A61YIx2vlLZrWLVhR08ZdOPndzUwcE6PKdbNlfTMjqDPJWxZIxzgB5rIFEfzULr5/QegVCauBRvCUo2tyX34vGlHzK5iAcIxk5DIK2/0g/1Z04TGKDDeTFjgUDsyYUqH0AW4PX+Mvzhq2TR3yp2sKxPbmyvSaBadWWBPJ7tKuUE3SuAXbLm/y/fkfc5QbDMFCNPNPy2laK8KbomX+h9YcyCsjyTgwe3L7vLH70MdoIJafSGFo3qRsclzQIp4gwH4JE9ovNVGJQfcybcpo+44/KBtCNQSIg3SJ8Yo1nJe4hIkQi+iETeT32mSd45dc2zr9UJqqPRFzK/jXgen/+WQ3HfG1+smYv8/lDR0ly4WQ5rHuqVNB2iUB7b3JTpJOFHtGtIZxQqWRcEt3u8uE0WZlf8+sr5E3m/slJVeW8C5Mrq1Ab2bNRkVEFtTdSlfAaygsKsJhaSAtAkzBKo0FDC7dw+PL4c8Ix6Z7XZfbPBvFnYOk5d3ILqBGy4vjsLh3auEcnc5f1xDFE0iJjp1Ua3XOCvMN85+Oqug4etV446Vh5AA5R/DbWjpY8rh0HqGEZ//c0Lfk44mVERu56+7IU7wm2161ch8cnpOu3Qu7IRUF5BuxwwomJqlmZNS2pWwC0/SLSUlcHcQUPX5S0+Jt5g4vLu+fRl1kOXrb5FOfEZM3tGg2UEFCIOqIRR8vAcC56FvV6JyfCYBnYE9kyJaevPL9lDjUuCk0O1W1ag'),
(15, 1, 'request', 'W6K3y+u/ByROT9OtPD2JGW5rHiv5Rr2BCIG2kWP64CI/kw2dO6n6u3BfKAWfxw0MCFyIcwL9iIB9eVBJ6xHC4A5mCPW7OWiRwaQ/kJBd94O2YZKD/497lZGJ+Tn2xvqWx6PRifOmdbIAz/SyZxDCaTOeLdasKK/4M3mUydnI/yq23HczAOyT9/5RejL0qv2IxCAf2HQ8RFV3GYDUj1/o7T8dZG6jxeGOsiJZuKKBZzKwNt6f2P54pfB9/HHPg+1jlrB3boSt+5NasZHfIyd3JHm8zJ4EGZhOpfDkIN9N4aKBmGd54dwUBUozSralRgOrv1mndOfURpecJHtjsqBBMXyBL/y7/bnoKiN73hjkSa2Jy+IEAl0NWSLvq1eEb2owoFM1VQDvw4PwV9ocbDEgLcyDC02q7z2NNeDx/tbVf3Li/c7pU8nS5UbbsIoNrtj9RQGzmWHgG+BrEJ83OlNDqmmFik4JrBG28tLO3ViLYerUDU42k4KbrN8UCJlrpemiDHKmG+/ao7yWGQSTlIr7S4fj9C2Fw4KxxVzd0TVU9vNEptwFs0pvsrHIAokNP8j5AcJ0seiuw9l3z1M65paL45QEyqYJIdG2JbN79HJksEsuux2cD1RufRsC9n6XSoOG+og3M7ifMBb9zUAQ7kcwea6hK4KDuaOMJk8AP8d+f+WhCHXF5mPZ8ayPgEnOuRnPUf9QK/pmS34+aC9Zzle0JOB1NGCtAQkzXkudLjR1+3cKgARCBcOyps/i5IDKURRx/iarpdZZmhQpgdMUAM9+5abuCgQBlKeea/I2qU9ocwqRzfNDLhekxyoHiX37df3n1fLxwvK9R4iW1tAFkDm77WUBQ0TvgZiMulWKPBBc3A94BFH9GmwIzRDqSYNikS5X9D7BYVJ7ljYzTdEv09q89/SGohjTpzEZDME11tKmIZE9p7Mwj9Vem5KDROEPGlphhlm9dIiv/fD5BwaTqYkvx8G0LsTNttnSIdvvIdh1E4ZjHsTFjj+1rxIJJgqO358FF6cv5JCYxsfyh98yaM6GhTBPL6GGUBkpIJodd3MjixIdHov+g8WvMJTGEF6f0LwUdF9fNTlRVPq2+mJoX75f0FqDX5VifdSfeHsFqykWX4Y1Pm41jtHn2S2W1gqwT6DxDecHfTfaQjiS/uqkoVRZ4WnAb8xvsThBQ7RRJZ5gZwJhGJq4dOunBsCForB1Lh9JBMij3y2ntY2oFSI1QYN0YcXC889vi4zbkNxoij27+twfnkUs+hdqSVcU1OIL0aPLVhFlMq7/BpKQ+pruQcwdD946Oy4D8OrTtzhe2Xv4/uM=');

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
-- Indices de la tabla `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`),
  ADD KEY `user` (`user`);

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
-- Indices de la tabla `survey_answers`
--
ALTER TABLE `survey_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`),
  ADD KEY `survey_question` (`survey_question`),
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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `notes`
--
ALTER TABLE `notes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `opportunity_areas`
--
ALTER TABLE `opportunity_areas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `opportunity_types`
--
ALTER TABLE `opportunity_types`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `promotional_codes`
--
ALTER TABLE `promotional_codes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `survey_answers`
--
ALTER TABLE `survey_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `survey_questions`
--
ALTER TABLE `survey_questions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `user_levels`
--
ALTER TABLE `user_levels`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `user_packages`
--
ALTER TABLE `user_packages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `user_permissions`
--
ALTER TABLE `user_permissions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `voxes`
--
ALTER TABLE `voxes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
-- Filtros para la tabla `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

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
