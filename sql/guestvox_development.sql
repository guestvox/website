-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-07-2019 a las 06:22:01
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
(1, 1, 'IWLMJBUA', 'H 1 VIP', '{\"name\":\"qr_IwlMjbuA.png\",\"code\":\"IwlMjbuA\"}'),
(2, 1, 'RIJ9VLHQ', 'H 2 VIP', '{\"name\":\"qr_rij9Vlhq.png\",\"code\":\"rij9Vlhq\"}'),
(3, 1, 'Y6PCQJWG', 'H 3 VIP', '{\"name\":\"qr_y6pCqJWg.png\",\"code\":\"y6pCqJWg\"}'),
(4, 1, 'TJBQFBRP', 'H 4 VIP', '{\"name\":\"qr_TJbQFbrP.png\",\"code\":\"TJbQFbrP\"}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `private_key` longtext CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `time_zone` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `language` enum('es','en') CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `sms` int(11) NOT NULL,
  `promotional_code` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `settings`
--

INSERT INTO `settings` (`id`, `account`, `private_key`, `time_zone`, `language`, `sms`, `promotional_code`) VALUES
(1, 1, 'OvX7WsT*^Ji35si,rEnFi8jrn(x9tHN3?.e3}]q0u)!D<GG9d~B(@7N5LE<psQgs:Mz-WJbRgm4!)pYiHPBGjZ#tnEFiZ0Cd)rc:uJNj(]_rZtHY0<:XkacT/!p|oV[7', 'America/Cancun', 'es', 0, NULL);

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
(1, 1, 'Gersón', 'Gómez', 'gerson@guestvox.com', '9988701057', 'gerson@guestvox.com', 'f53d6dd0204f8b2faaf10f1ccad212025ebc73f6:1X5m1Nx9jm4ugQTWmKOAat7eX8yreg6VfNVPiphTMSxiEZZyY1TOgs63vu4NupDT', NULL, 1, '[\"1\",\"2\",\"3\",\"38\",\"39\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"16\",\"17\",\"19\",\"20\",\"21\",\"18\",\"22\",\"23\",\"24\",\"25\",\"26\"]', '[\"1\",\"2\"]', 1),
(2, 1, 'Saúl', 'Poot', 'saul@guestvox.com', '9983856109', 'saul@guestvox.com', 'd7487bd4c393dadd052499e5e40d38b4410b7735:a8MuNTa3vH0kDcboWYw7v2dutpu6wBt0oxuwYuDvjSlOCktqAi2Ecd0ERR5C71AB', 'r4yAjXyZ', 1, '[\"1\",\"2\",\"3\",\"38\",\"39\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"16\",\"17\",\"19\",\"20\",\"21\",\"18\",\"22\",\"23\",\"24\",\"25\",\"26\"]', '[\"1\",\"2\"]', 1);

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
(4, 1, 'incident', '5qlcCOik5vVZkHyjXYk5TMZqCMk5mQdR0nZl1IMpObdj0rSMFcWdV51rZ2gaNtA/FMCbs0qBQUfsbUGthjZf5ZfXiHqV4Fck73RtLkLn3P2+k5637oU3Aq1INNfEJZ2Y/AuDInpD9VRqI1gW5vIy4rfXRXSrhzt4UmcMD2JHfU0eiMOvtyyHoVDQyMcPBWtX6sGGmuZf+tLrMIDZeQazuaESjqi01r5/ftOaVtd3it3zRJCEu3qXc1unqnATrHD3Y8kmxurv624nQsiTISRW0/vpoYKDYkF44gXgy8YvEb5TmoO6Jbh1xp8f5xjh/HYpVtV9e4c6QOHKrhvV/A/ATpMzIupMPQSgmourgtFLa2mbgI5PUgT9687MWoScunmlCN37F/odOtH7M8qEmJSZ9aNZrde/7GeybP7HyJctKNHAuZeQyVsY6OqcE0mdxUq8Gg3hPRYESALgnKnFD7hesgHqSyU9g2/j5iUh+OCsyVcfaXf8IgPZNX3Ta17QMqxvd3tErBjLrwgifd12B54ELJf3/pdVb8/NgQ9HYXfMoZ9pBvZQod6d+RZdeOOhLJXY0wnfk1O1JYALZwYfCEcEmO02y0CZt3c4IXQwqhm1c4Lz8VsyTRQcwrX9/SE66rpb4DCX5PhUzguYincJBm1Qu9T0Ih5lvtvBPt751ZvRHtbP4pEC83wc0LOHOoN0gTKrpOzRBe6iCkIWT0NIMXf6lMox0IzgKnZTgQV0hnfuQ5z+Ug5y+0Kll8hQYrnxxpCqt23nu8f81hnZbrOGxn104j/l0Rva+Y2bVomDjhpzBthTFQXbfCZ9TaFAomriXhpl4M0OhRn7PpiuP+DdRbhDii/3aXFoySYf63VdvN8jAdUAcrDKdhoHXrJNSeazH6C+5zxN8+JWw4uZxbqN46bYdgCp6LBQ5bdnDhLvbZJGbDLdQIScebY9pHx4H6sMYOgXnz0JX5p7tQ0JEPO2eMFC1tuLh287+kaTkC54fku/pqnBvnwMTZbHWexj+/61gzBgEvdToZas8RvOPpmFtivG/80KKfdCGHMNXFqrIH8Uv/UQapzZrbuUqdMhDMEST/bzKGERxWSVkjVjs8WNHhly5/hArIBttk4eB5yTz5fmeuN9YtK9Mpl2s+AhQgsBXzYXishEXLD4RFJJ4dc80bI8Prm/9nHK8DsNKltJ7kAZJgMDfeg3n8NF5mheiLaJzB6Z7mFe8rayK9crZY1iLICJFEg0vnfltQ399UQ2H66k6VPn+108A1+rELwvPVgY9vdSLlF69NSebxIgo2sXR1wO6tIl6Qpc4FDWbPm499S/1v+gR78KAYdrPV7oNfktQ2YCG2kMIMBDEOss9UMgCdVy4w==');

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
-- Indices de la tabla `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`) USING BTREE,
  ADD KEY `promotional_code` (`promotional_code`) USING BTREE;

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
-- AUTO_INCREMENT de la tabla `guest_treatments`
--
ALTER TABLE `guest_treatments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `guest_types`
--
ALTER TABLE `guest_types`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `opportunity_areas`
--
ALTER TABLE `opportunity_areas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `reservation_status`
--
ALTER TABLE `reservation_status`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `user_levels`
--
ALTER TABLE `user_levels`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `user_permissions`
--
ALTER TABLE `user_permissions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `voxes`
--
ALTER TABLE `voxes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  ADD CONSTRAINT `settings_ibfk_2` FOREIGN KEY (`promotional_code`) REFERENCES `promotional_codes` (`id`);

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
