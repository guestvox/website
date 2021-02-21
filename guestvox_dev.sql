-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-02-2021 a las 02:58:25
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `guestvox_dev`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) NOT NULL,
  `token` char(8) NOT NULL,
  `name` text NOT NULL,
  `path` text NOT NULL,
  `type` enum('hotel','restaurant','others') NOT NULL,
  `country` text NOT NULL,
  `city` text NOT NULL,
  `zip_code` text NOT NULL,
  `address` text NOT NULL,
  `location` text NOT NULL,
  `time_zone` text NOT NULL,
  `currency` text NOT NULL,
  `language` enum('es','en') NOT NULL,
  `fiscal` text NOT NULL,
  `contact` text NOT NULL,
  `logotype` text NOT NULL,
  `qrs` text NOT NULL,
  `package` bigint(20) NOT NULL,
  `digital_menu` tinyint(1) NOT NULL,
  `operation` tinyint(1) NOT NULL,
  `surveys` tinyint(1) NOT NULL,
  `zaviapms` text NOT NULL,
  `ambit` text NOT NULL,
  `siteminder` text NOT NULL,
  `sms` int(11) NOT NULL,
  `whatsapp` int(11) NOT NULL,
  `settings` text NOT NULL,
  `payment` text NOT NULL,
  `signup_date` date NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `accounts`
--

INSERT INTO `accounts` (`id`, `token`, `name`, `path`, `type`, `country`, `city`, `zip_code`, `address`, `location`, `time_zone`, `currency`, `language`, `fiscal`, `contact`, `logotype`, `qrs`, `package`, `digital_menu`, `operation`, `surveys`, `zaviapms`, `ambit`, `siteminder`, `sms`, `whatsapp`, `settings`, `payment`, `signup_date`, `status`) VALUES
(1, 'mdger168', 'Royal Hotel', 'royalhotel', 'hotel', 'MEX', 'Cancún', '77500', 'Zona hotelera', '{\"lat\":\"21.145545306338878\",\"lng\":\"-86.78020330266114\"}', 'America/Cancun', 'MXN', 'es', '{\"id\":\"ABDC123456789\",\"name\":\"Royal Hotel SA de CV\",\"address\":\"Zona hotelera\"}', '{\"firstname\":\"Gerardo\",\"lastname\":\"Suarez\",\"department\":\"Direcci\\u00f3n general\",\"email\":\"demo@guestvox.com\",\"phone\":{\"lada\":\"52\",\"number\":\"0987654321\"}}', 'royalhotel_account_logotype_wR6w0RTGZyxaegrG.jpeg', '{\"account\":\"royalhotel_account_qr_mdger168.png\",\"menu_delivery\":\"royalhotel_menu_delivery_qr_mdger168.png\",\"reviews\":\"royalhotel_reviews_qr_mdger168.png\"}', 8, 1, 1, 1, '{\"status\":true,\"username\":\"guestvoxmagic\",\"password\":\"guestvoxmagic\"}', '{\"status\":false,\"username\":\"\",\"password\":\"\", \"store_id\":\"\"}', '{\"status\":false,\"username\":\"\",\"password\":\"\"}', 0, 0, '{\"myvox\":{\"request\":{\"status\":true,\"title\":{\"es\":\"Alguna petici\\u00f3n\",\"en\":\"Any request\"}},\"incident\":{\"status\":true,\"title\":{\"es\":\"Quejas\",\"en\":\"Complaints\"}},\"menu\":{\"status\":true,\"title\":{\"es\":\"Men\\u00fa digital\",\"en\":\"Digital menu\"},\"currency\":\"MXN\",\"opportunity_area\":\"1\",\"opportunity_type\":\"1\",\"delivery\":false,\"requests\":true,\"schedule\":{\"monday\":{\"status\":\"open\",\"opening\":\"09:00\",\"closing\":\"23:59\"},\"tuesday\":{\"status\":\"open\",\"opening\":\"09:00\",\"closing\":\"23:59\"},\"wednesday\":{\"status\":\"open\",\"opening\":\"09:00\",\"closing\":\"23:59\"},\"thursday\":{\"status\":\"open\",\"opening\":\"09:00\",\"closing\":\"23:59\"},\"friday\":{\"status\":\"open\",\"opening\":\"09:00\",\"closing\":\"23:59\"},\"saturday\":{\"status\":\"open\",\"opening\":\"09:00\",\"closing\":\"23:59\"},\"sunday\":{\"status\":\"open\",\"opening\":\"09:00\",\"closing\":\"23:59\"}},\"multi\":false,\"sell_radius\":\"\"},\"survey\":{\"status\":true,\"title\":{\"es\":\"Responde nuestra encuesta\",\"en\":\"Take our survey\"},\"mail\":{\"subject\":{\"es\":\"\\u00a1Gracias por responder nuestra encuesta!\",\"en\":\"Thanks for taking our survey!\"},\"description\":{\"es\":\"Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et.\",\"en\":\"Lorem ipsum pain sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget pain. Aenean massa. Cum sociis natoque penatibus et.\"},\"image\":\"royalhotel_settings_myvox_survey_mail_image_alF1wPiaJvXmHdmE.png\",\"attachment\":\"royalhotel_settings_myvox_survey_mail_attachment_3Yzg14fJnz1Rvawe.pdf\"},\"widget\":\"\"}},\"reviews\":{\"status\":true,\"email\":\"contacto@royalhotel.com\",\"phone\":{\"lada\":\"52\",\"number\":\"0123456789\"},\"website\":\"www.royalhotel.com\",\"description\":{\"es\":\"Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a.\",\"en\":\"Lorem ipsum pain sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget pain. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede fair, fringilla vel, aliquet nec, vulputate eget, arcu. In enim fair, rhoncus ut, imperdiet a, venenatis vitae, fair. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a.\"},\"seo\":{\"keywords\":{\"es\":\"Lorem, ipsum, dolor, sit, amet.\",\"en\":\"Lorem, ipsum, pain, sit, amet.\"},\"description\":{\"es\":\"Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.\",\"en\":\"Lorem ipsum pain sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget pain.\"}},\"social_media\":{\"facebook\":\"https:\\/\\/www.facebook.com\\/\",\"instagram\":\"https:\\/\\/www.instagram.com\\/\",\"twitter\":\"https:\\/\\/www.twitter.com\\/\",\"linkedin\":\"https:\\/\\/www.linkedin.com\\/\",\"youtube\":\"https:\\/\\/www.youtube.com\\/\",\"google\":\"https:\\/\\/www.google.com\\/\",\"tripadvisor\":\"https:\\/\\/www.tripadvisor.com\\/\"}},\"voxes\":{\"attention_times\":{\"request\":{\"low\":\"40\",\"medium\":\"20\",\"high\":\"10\"},\"incident\":{\"low\":\"40\",\"medium\":\"20\",\"high\":\"10\"}}}}', '{\"status\":true,\"type\":\"mit\",\"mit\":{\"code\":\"12691\",\"types\":\"401,402\"},\"contract\":{\"status\":\"activated\",\"place\":\"Canc\\u00fan Quintana Roo\",\"date\":\"2021-02-11\",\"signature\":\"royalhotel_tA3KYeZDLQacDo0n.png\",\"titular\":{\"fiscal\":{\"person\":\"moral\",\"id\":\"ABCD123456789\",\"name\":\"Royal Hotel SA de CV\",\"activity\":\"Actividad empresarial\"},\"address\":{\"street\":\"Boulevard ZH\",\"external_number\":\"Lote 13\",\"internal_number\":\"\",\"cp\":\"77500\",\"colony\":\"Zona Hotelera\",\"delegation\":\"Benito Ju\\u00e1rez\",\"city\":\"Canc\\u00fan\",\"state\":\"Quintana Roo\",\"country\":\"M\\u00e9xico\"},\"bank\":{\"name\":\"BBVA\",\"branch\":\"002\",\"checkbook\":\"0987654321\",\"clabe\":\"0987654321\"},\"personal_references\":{\"first\":{\"name\":\"Mi referencia 1\",\"phone\":{\"country\":\"52\",\"number\":\"0987654321\"}},\"second\":{\"name\":\"Mi referencia 2\",\"phone\":{\"country\":\"52\",\"number\":\"0987654321\"}},\"third\":{\"name\":\"Mi referencia 3\",\"phone\":{\"country\":\"52\",\"number\":\"0987654321\"}},\"fourth\":{\"name\":\"Mi referencia 4\",\"phone\":{\"country\":\"52\",\"number\":\"0987654321\"}}},\"email\":\"demo@guestvox.com\",\"phone\":{\"country\":\"52\",\"number\":\"0987654321\"},\"tpv\":\"not\"},\"company\":{\"writing_number\":\"0987654321\",\"writing_date\":\"2010-01-01\",\"public_record_folio\":\"0987654321\",\"public_record_date\":\"2010-01-01\",\"notary_name\":\"Notar\\u00eda 9\",\"notary_number\":\"0987654321\",\"city\":\"Canc\\u00fan\",\"legal_representative\":{\"name\":\"Jos\\u00e9 Hern\\u00e1ndez Ram\\u00edrez\",\"writing_number\":\"0987654321\",\"writing_date\":\"2010-01-01\",\"notary_name\":\"Notar\\u00eda 9\",\"notary_number\":\"0987654321\",\"city\":\"Canc\\u00fan\",\"card\":{\"type\":\"ine\",\"number\":\"0987654321\",\"expedition_date\":\"2010-01-01\",\"validity\":\"2010-01-01\"}}}}}', '2020-07-31', 1),
(2, 'fyiyeznp', 'Hot Restaurant', 'hotrestaurant', 'restaurant', 'MEX', 'Cancún', '77500', 'Zona Hotelera', '{\"lat\":\"21.159198566133863\",\"lng\":\"-86.82573387226238\"}', 'America/Cancun', 'MXN', 'es', '{\"id\":\"ABCD123456789\",\"name\":\"Hot Restaurant SA de CV\",\"address\":\"Canc\\u00fan centro\"}', '{\"firstname\":\"Marcos\",\"lastname\":\"Ram\\u00edrez\",\"department\":\"Direcci\\u00f3n general\",\"email\":\"desarrollo@guestvox.com\",\"phone\":{\"lada\":\"52\",\"number\":\"9981579343\"}}', 'hotrestaurant_account_logotype_VVVZ5o8ttJ6hLGDH.jpeg', '{\"account\":\"hotrestaurant_account_qr_fyiyeznp.png\",\"menu_delivery\":\"hotrestaurant_menu_delivery_qr_fyiyeznp.png\",\"reviews\":\"hotrestaurant_reviews_qr_fyiyeznp.png\"}', 21, 1, 1, 1, '{\"status\":false,\"username\":\"\",\"password\":\"\"}', '{\"status\":true,\"username\":\"casapepe@ambit.com.mx\",\"password\":\"Ambit123\",\"store_id\":\"ca4017acfd33f4ec69d508783327df0c\"}', '{\"status\":false,\"username\":\"\",\"password\":\"\"}', 0, 0, '{\"myvox\":{\"request\":{\"status\":true,\"title\":{\"es\":\"\\u00bfEn que te podemos apoyar?\",\"en\":\"How can we support you?\"}},\"incident\":{\"status\":true,\"title\":{\"es\":\"D\\u00e9janos tus comentarios o quejas\",\"en\":\"Leave us your comments or complaints\"}},\"menu\":{\"status\":true,\"title\":{\"es\":\"Men\\u00fa digital\",\"en\":\"Digital menu\"},\"currency\":\"MXN\",\"opportunity_area\":\"2\",\"opportunity_type\":\"2\",\"delivery\":true,\"requests\":true,\"schedule\":{\"monday\":{\"status\":\"open\",\"opening\":\"02:00\",\"closing\":\"23:59\"},\"tuesday\":{\"status\":\"open\",\"opening\":\"02:00\",\"closing\":\"23:59\"},\"wednesday\":{\"status\":\"open\",\"opening\":\"02:00\",\"closing\":\"23:59\"},\"thursday\":{\"status\":\"open\",\"opening\":\"02:00\",\"closing\":\"23:59\"},\"friday\":{\"status\":\"open\",\"opening\":\"02:00\",\"closing\":\"23:59\"},\"saturday\":{\"status\":\"open\",\"opening\":\"02:00\",\"closing\":\"23:59\"},\"sunday\":{\"status\":\"open\",\"opening\":\"02:00\",\"closing\":\"23:59\"}},\"multi\":false,\"sell_radius\":\"10000\"},\"survey\":{\"status\":true,\"title\":{\"es\":\"\\u00a1Responde nuestra encuesta!\",\"en\":\"Take our survey!\"},\"mail\":{\"subject\":{\"es\":\"\\u00a1Gracias por responder nuestra encuesrta!\",\"en\":\"Thanks for taking our survey!\"},\"description\":{\"es\":\"Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis.\",\"en\":\"Lorem ipsum pain sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget pain. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis.\"},\"image\":\"hotrestaurant_settings_myvox_survey_mail_image_oOsg3zTp1KkX2G6Y.png\",\"attachment\":\"hotrestaurant_settings_myvox_survey_mail_attachment_i6Lqrp7ppcBOR2CP.pdf\"},\"widget\":\"\"}},\"reviews\":{\"status\":true,\"email\":\"contacto@hotrestaurant.com\",\"phone\":{\"lada\":\"52\",\"number\":\"0123456789\"},\"website\":\"www.hotrestaurant.com\",\"description\":{\"es\":\"Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a.\",\"en\":\"Lorem ipsum pain sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget pain. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede fair, fringilla vel, aliquet nec, vulputate eget, arcu. In enim fair, rhoncus ut, imperdiet a, venenatis vitae, fair. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a.\"},\"seo\":{\"keywords\":{\"es\":\"Lorem ipsum dolor sit amet\",\"en\":\"Lorem ipsum pain sit amet\"},\"description\":{\"es\":\"Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.\",\"en\":\"Lorem ipsum pain sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget pain.\"}},\"social_media\":{\"facebook\":\"https:\\/\\/www.facebook.com\\/\",\"instagram\":\"https:\\/\\/www.instagram.com\\/\",\"twitter\":\"https:\\/\\/www.twitter.com\\/\",\"linkedin\":\"https:\\/\\/www.linkedin.com\\/\",\"youtube\":\"https:\\/\\/www.youtube.com\\/\",\"google\":\"https:\\/\\/www.google.com\\/\",\"tripadvisor\":\"https:\\/\\/www.tripadvisor.com\\/\"}},\"voxes\":{\"attention_times\":{\"request\":{\"low\":\"40\",\"medium\":\"20\",\"high\":\"10\"},\"incident\":{\"low\":\"40\",\"medium\":\"20\",\"high\":\"10\"}}}}', '{\"status\":true,\"type\":\"mit\",\"mit\":{\"code\":\"12691\",\"types\":\"401,402\"},\"contract\":{\"status\":\"activated\",\"place\":\"Canc\\u00fan Quintana Roo M\\u00e9xico\",\"date\":\"2020-11-13\",\"signature\":\"hotrestaurant_wBztpwQX3kuK0oMu.png\",\"titular\":{\"fiscal\":{\"person\":\"moral\",\"id\":\"ABCD0123456789\",\"name\":\"Hot Restaurant SA de CV\",\"activity\":\"Empresarial\"},\"address\":{\"street\":\"Calle 3\",\"external_number\":\"Manzana 7 Lote 4\",\"internal_number\":\"\",\"cp\":\"77526\",\"colony\":\"Lombardo Toledano\",\"delegation\":\"Benito Juarez\",\"city\":\"Canc\\u00fan\",\"state\":\"Quintana Roo\",\"country\":\"M\\u00e9xico\"},\"bank\":{\"name\":\"Bancomer\",\"branch\":\"2001\",\"checkbook\":\"0123456789\",\"clabe\":\"0123456789\"},\"personal_references\":{\"first\":{\"name\":\"Persona 1\",\"phone\":{\"country\":\"52\",\"number\":\"0123456789\"}},\"second\":{\"name\":\"Persona 2\",\"phone\":{\"country\":\"52\",\"number\":\"0123456789\"}},\"third\":{\"name\":\"Persona 3\",\"phone\":{\"country\":\"52\",\"number\":\"0123456789\"}},\"fourth\":{\"name\":\"Persona 4\",\"phone\":{\"country\":\"52\",\"number\":\"0123456789\"}}},\"email\":\"facturacion@hotrestaurant.com\",\"phone\":{\"country\":\"52\",\"number\":\"0123456789\"},\"tpv\":\"not\"},\"company\":{\"writing_number\":\"0123456789\",\"writing_date\":\"2010-01-01\",\"public_record_folio\":\"0123456789\",\"public_record_date\":\"2010-01-01\",\"notary_name\":\"Notar\\u00eda N. 19\",\"notary_number\":\"19\",\"city\":\"Canc\\u00fan\",\"legal_representative\":{\"name\":\"Marcos Juan Barraza M\\u00e9ndez\",\"writing_number\":\"0123456789\",\"writing_date\":\"2010-01-01\",\"notary_name\":\"Notar\\u00eda N. 19\",\"notary_number\":\"19\",\"city\":\"Canc\\u00fan\",\"card\":{\"type\":\"ine\",\"number\":\"0123456789\",\"expedition_date\":\"2010-01-01\",\"validity\":\"2025-01-01\"}}}}}', '2020-07-31', 1),
(4, 'xmvduxcj', 'Foxmedia', 'foxmedia', 'others', 'MEX', 'Cancún', '77500', 'Zona Hotelera', '{\"lat\":\"\",\"lng\":\"\"}', 'America/Cancun', 'MXN', 'es', '{\"id\":\"\",\"name\":\"\",\"address\":\"\"}', '{\"firstname\":\"\",\"lastname\":\"\",\"department\":\"\",\"email\":\"\",\"phone\":{\"lada\":\"\",\"number\":\"\"}}', 'foxmedia_account_logotype_0fxM2DEgdSHRqd01.jpeg', '{\"account\":\"foxmedia_account_qr_xmvduxcj.png\",\"menu_delivery\":\"foxmedia_menu_delivery_qr_xmvduxcj.png\",\"reviews\":\"foxmedia_reviews_qr_xmvduxcj.png\"}', 23, 1, 1, 1, '{\"status\":false,\"username\":\"\",\"password\":\"\"}', '{\"status\":false,\"username\":\"\",\"password\":\"\", \"store_id\":\"\"}', '{\"status\":false,\"username\":\"\",\"password\":\"\"}', 0, 0, '{\"myvox\":{\"request\":{\"status\":false,\"title\":{\"es\":\"\",\"en\":\"\"}},\"incident\":{\"status\":false,\"title\":{\"es\":\"\",\"en\":\"\"}},\"menu\":{\"status\":true,\"title\":{\"es\":\"Men\\u00fa digital\",\"en\":\"Digital menu\"},\"currency\":\"MXN\",\"opportunity_area\":\"\",\"opportunity_type\":\"\",\"delivery\":true,\"requests\":false,\"schedule\":{\"monday\":{\"status\":\"open\",\"opening\":\"10:00\",\"closing\":\"23:59\"},\"tuesday\":{\"status\":\"open\",\"opening\":\"10:00\",\"closing\":\"23:59\"},\"wednesday\":{\"status\":\"open\",\"opening\":\"10:00\",\"closing\":\"23:59\"},\"thursday\":{\"status\":\"open\",\"opening\":\"10:00\",\"closing\":\"23:59\"},\"friday\":{\"status\":\"open\",\"opening\":\"10:00\",\"closing\":\"23:59\"},\"saturday\":{\"status\":\"open\",\"opening\":\"10:00\",\"closing\":\"23:59\"},\"sunday\":{\"status\":\"open\",\"opening\":\"10:00\",\"closing\":\"23:59\"}},\"multi\":false,\"sell_radius\":\"10000\"},\"survey\":{\"status\":false,\"title\":{\"es\":\"\",\"en\":\"\"},\"mail\":{\"subject\":{\"es\":\"\",\"en\":\"\"},\"description\":{\"es\":\"\",\"en\":\"\"},\"image\":\"\",\"attachment\":\"\"},\"widget\":\"\"}},\"reviews\":{\"status\":false,\"email\":\"\",\"phone\":{\"lada\":\"\",\"number\":\"\"},\"website\":\"\",\"description\":{\"es\":\"\",\"en\":\"\"},\"seo\":{\"keywords\":{\"es\":\"\",\"en\":\"\"},\"description\":{\"es\":\"\",\"en\":\"\"}},\"social_media\":{\"facebook\":\"\",\"instagram\":\"\",\"twitter\":\"\",\"linkedin\":\"\",\"youtube\":\"\",\"google\":\"\",\"tripadvisor\":\"\"}},\"voxes\":{\"attention_times\":{\"request\":{\"low\":\"40\",\"medium\":\"20\",\"high\":\"10\"},\"incident\":{\"low\":\"40\",\"medium\":\"20\",\"high\":\"10\"}}}}', '{\"status\":false,\"type\":\"mit\",\"mit\":{\"code\":\"\",\"types\":\"\"},\"contract\":{\"status\":\"deactivated\",\"place\":\"\",\"date\":\"\",\"signature\":\"\",\"titular\":{\"fiscal\":{\"person\":\"\",\"id\":\"\",\"name\":\"\",\"activity\":\"\"},\"address\":{\"street\":\"\",\"external_number\":\"\",\"internal_number\":\"\",\"cp\":\"\",\"colony\":\"\",\"delegation\":\"\",\"city\":\"\",\"state\":\"\",\"country\":\"\"},\"bank\":{\"name\":\"\",\"branch\":\"\",\"checkbook\":\"\",\"clabe\":\"\"},\"personal_references\":{\"first\":{\"name\":\"\",\"phone\":{\"country\":\"\",\"number\":\"\"}},\"second\":{\"name\":\"\",\"phone\":{\"country\":\"\",\"number\":\"\"}},\"third\":{\"name\":\"\",\"phone\":{\"country\":\"\",\"number\":\"\"}},\"fourth\":{\"name\":\"\",\"phone\":{\"country\":\"\",\"number\":\"\"}}},\"email\":\"\",\"phone\":{\"country\":\"\",\"number\":\"\"},\"tpv\":\"\"},\"company\":{\"writing_number\":\"\",\"writing_date\":\"\",\"public_record_folio\":\"\",\"public_record_date\":\"\",\"notary_name\":\"\",\"notary_number\":\"\",\"city\":\"\",\"legal_representative\":{\"name\":\"\",\"writing_number\":\"\",\"writing_date\":\"\",\"notary_name\":\"\",\"notary_number\":\"\",\"city\":\"\",\"card\":{\"type\":\"\",\"number\":\"\",\"expedition_date\":\"\",\"validity\":\"\"}}}}}', '2020-07-31', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) NOT NULL,
  `name` text NOT NULL,
  `code` varchar(4) NOT NULL,
  `lada` varchar(4) NOT NULL,
  `priority` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`, `lada`, `priority`) VALUES
(1, '{\"es\":\"Afganistán\",\"en\":\"Afghanistan\"}', 'AFG', '93', NULL),
(2, '{\"es\":\"Albania\",\"en\":\"Albania\"}', 'ALB', '355', NULL),
(3, '{\"es\":\"Alemania\",\"en\":\"Germany\"}', 'DEU', '49', NULL),
(4, '{\"es\":\"Argelia\",\"en\":\"Algeria\"}', 'DZA', '213', NULL),
(5, '{\"es\":\"Andorra\",\"en\":\"Andorra\"}', 'AND', '376', NULL),
(6, '{\"es\":\"Angola\",\"en\":\"Angola\"}', 'AGO', '244', NULL),
(7, '{\"es\":\"Anguila\",\"en\":\"Anguila\"}', 'AIA', '264', NULL),
(8, '{\"es\":\"Antártida\",\"en\":\"Antarctica\"}', 'ATA', '672', NULL),
(9, '{\"es\":\"Antigua y Barbuda\",\"en\":\"Old and bearded\"}', 'ATG', '268', NULL),
(10, '{\"es\":\"Antillas Neerlandesas\",\"en\":\"Netherlands Antilles\"}', 'ANT', '599', NULL),
(11, '{\"es\":\"Arabia Saudita\",\"en\":\"Saudi Arabia\"}', 'SAU', '966', NULL),
(12, '{\"es\":\"Argentina\",\"en\":\"Argentina\"}', 'ARG', '54', NULL),
(13, '{\"es\":\"Armenia\",\"en\":\"Armenia\"}', 'ARM', '374', NULL),
(14, '{\"es\":\"Aruba\",\"en\":\"Aruba\"}', 'ABW', '297', NULL),
(15, '{\"es\":\"Australia\",\"en\":\"Australia\"}', 'AUS', '61', '8'),
(16, '{\"es\":\"Austria\",\"en\":\"Austria\"}', 'AUT', '43', NULL),
(17, '{\"es\":\"Azerbayán\",\"en\":\"Azerbaijan\"}', 'AZE', '994', NULL),
(18, '{\"es\":\"Bahamas\",\"en\":\"Bahamas\"}', 'BHS', '242', NULL),
(19, '{\"es\":\"Bahrein\",\"en\":\"Bahrain\"}', 'BHR', '973', NULL),
(20, '{\"es\":\"Bangladesh\",\"en\":\"Bangladesh\"}', 'BGD', '880', NULL),
(21, '{\"es\":\"Barbados\",\"en\":\"Barbados\"}', 'BRB', '246', NULL),
(22, '{\"es\":\"Bélgica\",\"en\":\"Belgium\"}', 'BEL', '32', NULL),
(23, '{\"es\":\"Belice\",\"en\":\"Belize\"}', 'BLZ', '501', NULL),
(24, '{\"es\":\"Ben\\u00edn\",\"en\":\"Ben\\u00edn\"}', 'BEN', '229', NULL),
(25, '{\"es\":\"Bhut\\u00e1n\",\"en\":\"Bhut\\u00e1n\"}', 'BTN', '975', NULL),
(26, '{\"es\":\"Bielorrusia\",\"en\":\"Belarus\"}', 'BLR', '375', NULL),
(27, '{\"es\":\"Birmania\",\"en\":\"Burma\"}', 'MMR', '95', NULL),
(28, '{\"es\":\"Bolivia\",\"en\":\"Bolivia\"}', 'BOL', '591', NULL),
(29, '{\"es\":\"Bosnia y Herzegovina\",\"en\":\"Bosnia and Herzegovina\"}', 'BIH', '387', NULL),
(30, '{\"es\":\"Botsuana\",\"en\":\"Botswana\"}', 'BWA', '267', NULL),
(31, '{\"es\":\"Brasil\",\"en\":\"Brazil\"}', 'BRA', '55', '9'),
(32, '{\"es\":\"Brun\\u00e9i\",\"en\":\"Brun\\u00e9i\"}', 'BRN', '673', NULL),
(33, '{\"es\":\"Bulgaria\",\"en\":\"Bulgaria\"}', 'BGR', '359', NULL),
(34, '{\"es\":\"Burkina Faso\",\"en\":\"Burkina Faso\"}', 'BFA', '226', NULL),
(35, '{\"es\":\"Burundi\",\"en\":\"Burundi\"}', 'BDI', '257', NULL),
(36, '{\"es\":\"Cabo Verde\",\"en\":\"Cape Verde\"}', 'CPV', '238', NULL),
(37, '{\"es\":\"Camboya\",\"en\":\"Cambodia\"}', 'KHM', '855', NULL),
(38, '{\"es\":\"Camer\\u00fan\",\"en\":\"Camer\\u00fan\"}', 'CMR', '237', NULL),
(39, '{\"es\":\"Canad\\u00e1\",\"en\":\"Canada\"}', 'CAN', '1', '10'),
(40, '{\"es\":\"Chad\",\"en\":\"Chad\"}', 'TCD', '235', NULL),
(41, '{\"es\":\"Chile\",\"en\":\"Chile\"}', 'CHL', '56', NULL),
(42, '{\"es\":\"China\",\"en\":\"China\"}', 'CHN', '86', NULL),
(43, '{\"es\":\"Chipre\",\"en\":\"Cyprus\"}', 'CYP', '357', NULL),
(44, '{\"es\":\"Ciudad del Vaticano\",\"en\":\"Vatican City\"}', 'VAT', '39', NULL),
(45, '{\"es\":\"Colombia\",\"en\":\"Colombia\"}', 'COL', '57', NULL),
(46, '{\"es\":\"Comoras\",\"en\":\"Comoros\"}', 'COM', '269', NULL),
(47, '{\"es\":\"Congo\",\"en\":\"Congo\"}', 'COG', '242', NULL),
(48, '{\"es\":\"Corea del Norte\",\"en\":\"North Korea\"}', 'PRK', '850', NULL),
(49, '{\"es\":\"Corea del Sur\",\"en\":\"South Korea\"}', 'KOR', '82', NULL),
(50, '{\"es\":\"Costa de Marfil\",\"en\":\"Ivory Coast\"}', 'CIV', '225', NULL),
(51, '{\"es\":\"Costa Rica\",\"en\":\"Costa Rica\"}', 'CRI', '506', NULL),
(52, '{\"es\":\"Croacia\",\"en\":\"Croatia\"}', 'HRV', '385', NULL),
(53, '{\"es\":\"Cuba\",\"en\":\"Cuba\"}', 'CUB', '53', NULL),
(54, '{\"es\":\"Dinamarca\",\"en\":\"Denmark\"}', 'DNK', '45', NULL),
(55, '{\"es\":\"Dominica\",\"en\":\"Dominica\"}', 'DMA', '767', NULL),
(56, '{\"es\":\"Ecuador\",\"en\":\"Ecuador\"}', 'ECU', '593', NULL),
(57, '{\"es\":\"Egipto\",\"en\":\"Egypt\"}', 'EGY', '20', NULL),
(58, '{\"es\":\"El Salvador\",\"en\":\"The Savior\"}', 'SLV', '503', NULL),
(59, '{\"es\":\"Emiratos \\u00c1rabes Unidos\",\"en\":\"United Arab Emirates\"}', 'ARE', '971', NULL),
(60, '{\"es\":\"Eritrea\",\"en\":\"Eritrea\"}', 'ERI', '291', NULL),
(61, '{\"es\":\"Eslovaquia\",\"en\":\"Slovakia\"}', 'SVK', '421', NULL),
(62, '{\"es\":\"Eslovenia\",\"en\":\"Slovenia\"}', 'SVN', '386', NULL),
(63, '{\"es\":\"Espa\\u00f1a\",\"en\":\"Spain\"}', 'ESP', '34', '5'),
(64, '{\"es\":\"Estados Unidos de Am\\u00e9rica\",\"en\":\"United States of America\"}', 'USA', '1', '2'),
(65, '{\"es\":\"Estonia\",\"en\":\"Estonia\"}', 'EST', '372', NULL),
(66, '{\"es\":\"Etiop\\u00eda\",\"en\":\"Ethiopia\"}', 'ETH', '251', NULL),
(67, '{\"es\":\"Filipinas\",\"en\":\"Philippines\"}', 'PHL', '63', NULL),
(68, '{\"es\":\"Finlandia\",\"en\":\"Finland\"}', 'FIN', '358', NULL),
(69, '{\"es\":\"Fiyi\",\"en\":\"Fiji\"}', 'FJI', '679', NULL),
(70, '{\"es\":\"Francia\",\"en\":\"France\"}', 'FRA', '33', '3'),
(71, '{\"es\":\"Gab\\u00f3n\",\"en\":\"Gab\\u00f3n\"}', 'GAB', '241', NULL),
(72, '{\"es\":\"Gambia\",\"en\":\"Gambia\"}', 'GMB', '220', NULL),
(73, '{\"es\":\"Georgia\",\"en\":\"Georgia\"}', 'GEO', '995', NULL),
(74, '{\"es\":\"Ghana\",\"en\":\"Ghana\"}', 'GHA', '233', NULL),
(75, '{\"es\":\"Gibraltar\",\"en\":\"Gibraltar\"}', 'GIB', '350', NULL),
(76, '{\"es\":\"Granada\",\"en\":\"Granada\"}', 'GRD', '473', NULL),
(77, '{\"es\":\"Grecia\",\"en\":\"Greece\"}', 'GRC', '30', NULL),
(78, '{\"es\":\"Groenlandia\",\"en\":\"Greenland\"}', 'GRL', '299', NULL),
(79, '{\"es\":\"Guadalupe\",\"en\":\"Guadalupe\"}', 'GLP', '0', NULL),
(80, '{\"es\":\"Guam\",\"en\":\"Guam\"}', 'GUM', '671', NULL),
(81, '{\"es\":\"Guatemala\",\"en\":\"Guatemala\"}', 'GTM', '502', NULL),
(82, '{\"es\":\"Guayana Francesa\",\"en\":\"French Guiana\"}', 'GUF', '0', NULL),
(83, '{\"es\":\"Guernsey\",\"en\":\"Guernsey\"}', 'GGY', '0', NULL),
(84, '{\"es\":\"Guinea\",\"en\":\"Guinea\"}', 'GIN', '224', NULL),
(85, '{\"es\":\"Guinea Ecuatorial\",\"en\":\"Equatorial Guinea\"}', 'GNQ', '240', NULL),
(86, '{\"es\":\"Guinea-Bissau\",\"en\":\"Guinea-Bissau\"}', 'GNB', '245', NULL),
(87, '{\"es\":\"Guyana\",\"en\":\"Guyana\"}', 'GUY', '592', NULL),
(88, '{\"es\":\"Hait\\u00ed\",\"en\":\"Haiti\"}', 'HTI', '509', NULL),
(89, '{\"es\":\"Honduras\",\"en\":\"Honduras\"}', 'HND', '504', NULL),
(90, '{\"es\":\"Hong kong\",\"en\":\"Hong kong\"}', 'HKG', '852', NULL),
(91, '{\"es\":\"Hungr\\u00eda\",\"en\":\"Hungary\"}', 'HUN', '36', NULL),
(92, '{\"es\":\"India\",\"en\":\"India\"}', 'IND', '91', NULL),
(93, '{\"es\":\"Indonesia\",\"en\":\"Indonesia\"}', 'IDN', '62', NULL),
(94, '{\"es\":\"Irak\",\"en\":\"Irak\"}', 'IRQ', '964', NULL),
(95, '{\"es\":\"Ir\\u00e1n\",\"en\":\"Ir\\u00e1n\"}', 'IRN', '98', NULL),
(96, '{\"es\":\"Irlanda\",\"en\":\"Ireland\"}', 'IRL', '353', NULL),
(97, '{\"es\":\"Isla Bouvet\",\"en\":\"Bouvet island\"}', 'BVT', '0', NULL),
(98, '{\"es\":\"Isla de Man\",\"en\":\"Isle of Man\"}', 'IMN', '44', NULL),
(99, '{\"es\":\"Isla de Navidad\",\"en\":\"Christmas island\"}', 'CXR', '61', NULL),
(100, '{\"es\":\"Isla Norfolk\",\"en\":\"Norfolk Island\"}', 'NFK', '0', NULL),
(101, '{\"es\":\"Islandia\",\"en\":\"Iceland\"}', 'ISL', '354', NULL),
(102, '{\"es\":\"Islas Bermudas\",\"en\":\"Bermuda Islands\"}', 'BMU', '441', NULL),
(103, '{\"es\":\"Islas Caim\\u00e1n\",\"en\":\"Cayman Islands\"}', 'CYM', '345', NULL),
(104, '{\"es\":\"Islas Cocos (Keeling)\",\"en\":\"Cocos islands (Keeling)\"}', 'CCK', '61', NULL),
(105, '{\"es\":\"Islas Cook\",\"en\":\"Islas Cook\"}', 'COK', '682', NULL),
(106, '{\"es\":\"Islas de \\u00c5land\",\"en\":\"Islas de \\u00c5land\"}', 'ALA', '0', NULL),
(107, '{\"es\":\"Islas Feroe\",\"en\":\"Faroe Islands\"}', 'FRO', '298', NULL),
(108, '{\"es\":\"Islas Georgias del Sur y Sandwich del Sur\",\"en\":\"South Georgia and the South Sandwich Islands\"}', 'SGS', '0', NULL),
(109, '{\"es\":\"Islas Heard y McDonald\",\"en\":\"Heard and McDonald Islands\"}', 'HMD', '0', NULL),
(110, '{\"es\":\"Islas Maldivas\",\"en\":\"Islas Maldivas\"}', 'MDV', '960', NULL),
(111, '{\"es\":\"Islas Malvinas\",\"en\":\"Falkland Islands\"}', 'FLK', '500', NULL),
(112, '{\"es\":\"Islas Marianas del Norte\",\"en\":\"Northern Mariana Islands\"}', 'MNP', '670', NULL),
(113, '{\"es\":\"Islas Marshall\",\"en\":\"Marshall Islands\"}', 'MHL', '692', NULL),
(114, '{\"es\":\"Islas Pitcairn\",\"en\":\"Pitcairn Islands\"}', 'PCN', '870', NULL),
(115, '{\"es\":\"Islas Salom\\u00f3n\",\"en\":\"Islas Salom\\u00f3n\"}', 'SLB', '677', NULL),
(116, '{\"es\":\"Islas Turcas y Caicos\",\"en\":\"Turks and Caicos Islands\"}', 'TCA', '649', NULL),
(117, '{\"es\":\"Islas Ultramarinas Menores de Estados Unidos\",\"en\":\"United States Minor Outlying Islands\"}', 'UMI', '0', NULL),
(118, '{\"es\":\"Islas V\\u00edrgenes Brit\\u00e1nicas\",\"en\":\"Islas V\\u00edrgenes Brit\\u00e1nicas\"}', 'VG', '284', NULL),
(119, '{\"es\":\"Islas V\\u00edrgenes de los Estados Unidos\",\"en\":\"Islas V\\u00edrgenes de los Estados Unidos\"}', 'VIR', '340', NULL),
(120, '{\"es\":\"Israel\",\"en\":\"Israel\"}', 'ISR', '972', NULL),
(121, '{\"es\":\"Italia\",\"en\":\"Italy\"}', 'ITA', '39', '6'),
(122, '{\"es\":\"Jamaica\",\"en\":\"Jamaica\"}', 'JAM', '876', NULL),
(123, '{\"es\":\"Jap\\u00f3n\",\"en\":\"Japan\"}', 'JPN', '81', NULL),
(124, '{\"es\":\"Jersey\",\"en\":\"Jersey\"}', 'JEY', '0', NULL),
(125, '{\"es\":\"Jordania\",\"en\":\"Jordan\"}', 'JOR', '962', NULL),
(126, '{\"es\":\"Kazajist\\u00e1n\",\"en\":\"Kazakhstan\"}', 'KAZ', '7', NULL),
(127, '{\"es\":\"Kenia\",\"en\":\"Kenya\"}', 'KEN', '254', NULL),
(128, '{\"es\":\"Kirgizst\\u00e1n\",\"en\":\"Kirgizst\\u00e1n\"}', 'KGZ', '996', NULL),
(129, '{\"es\":\"Kiribati\",\"en\":\"Kiribati\"}', 'KIR', '686', NULL),
(130, '{\"es\":\"Kuwait\",\"en\":\"Kuwait\"}', 'KWT', '965', NULL),
(131, '{\"es\":\"Laos\",\"en\":\"Laos\"}', 'LAO', '856', NULL),
(132, '{\"es\":\"Lesoto\",\"en\":\"Lesotho\"}', 'LSO', '266', NULL),
(133, '{\"es\":\"Letonia\",\"en\":\"Latvia\"}', 'LVA', '371', NULL),
(134, '{\"es\":\"L\\u00edbano\",\"en\":\"L\\u00edbano\"}', 'LBN', '961', NULL),
(135, '{\"es\":\"Liberia\",\"en\":\"Liberia\"}', 'LBR', '231', NULL),
(136, '{\"es\":\"Libia\",\"en\":\"Libya\"}', 'LBY', '218', NULL),
(137, '{\"es\":\"Liechtenstein\",\"en\":\"Liechtenstein\"}', 'LIE', '423', NULL),
(138, '{\"es\":\"Lituania\",\"en\":\"Lithuania\"}', 'LTU', '370', NULL),
(139, '{\"es\":\"Luxemburgo\",\"en\":\"Luxembourg\"}', 'LUX', '352', NULL),
(140, '{\"es\":\"Macao\",\"en\":\"Macao\"}', 'MAC', '853', NULL),
(141, '{\"es\":\"Maced\\u00f4nia\",\"en\":\"Maced\\u00f4nia\"}', 'MKD', '389', NULL),
(142, '{\"es\":\"Madagascar\",\"en\":\"Madagascar\"}', 'MDG', '261', NULL),
(143, '{\"es\":\"Malasia\",\"en\":\"Malaysia\"}', 'MYS', '60', NULL),
(144, '{\"es\":\"Malawi\",\"en\":\"Malawi\"}', 'MWI', '265', NULL),
(145, '{\"es\":\"Mali\",\"en\":\"Mali\"}', 'MLI', '223', NULL),
(146, '{\"es\":\"Malta\",\"en\":\"Maltese\"}', 'MLT', '356', NULL),
(147, '{\"es\":\"Marruecos\",\"en\":\"Morocco\"}', 'MAR', '212', NULL),
(148, '{\"es\":\"Martinica\",\"en\":\"Martinique\"}', 'MTQ', '0', NULL),
(149, '{\"es\":\"Mauricio\",\"en\":\"Mauritius\"}', 'MUS', '230', NULL),
(150, '{\"es\":\"Mauritania\",\"en\":\"Mauritania\"}', 'MRT', '222', NULL),
(151, '{\"es\":\"Mayotte\",\"en\":\"Mayotte\"}', 'MYT', '262', NULL),
(152, '{\"es\":\"M\\u00e9xico\",\"en\":\"Mexico\"}', 'MEX', '52', '1'),
(153, '{\"es\":\"Micronesia\",\"en\":\"Micronesia\"}', 'FSM', '691', NULL),
(154, '{\"es\":\"Moldavia\",\"en\":\"Moldova\"}', 'MDA', '373', NULL),
(155, '{\"es\":\"M\\u00f3naco\",\"en\":\"Monaco\"}', 'MCO', '377', NULL),
(156, '{\"es\":\"Mongolia\",\"en\":\"Mongolia\"}', 'MNG', '976', NULL),
(157, '{\"es\":\"Montenegro\",\"en\":\"Montenegro\"}', 'MNE', '382', NULL),
(158, '{\"es\":\"Montserrat\",\"en\":\"Montserrat\"}', 'MSR', '664', NULL),
(159, '{\"es\":\"Mozambique\",\"en\":\"Mozambique\"}', 'MOZ', '258', NULL),
(160, '{\"es\":\"Namibia\",\"en\":\"Namibia\"}', 'NAM', '264', NULL),
(161, '{\"es\":\"Nauru\",\"en\":\"Nauru\"}', 'NRU', '674', NULL),
(162, '{\"es\":\"Nepal\",\"en\":\"Nepal\"}', 'NPL', '977', NULL),
(163, '{\"es\":\"Nicaragua\",\"en\":\"Nicaragua\"}', 'NIC', '505', NULL),
(164, '{\"es\":\"Niger\",\"en\":\"Niger\"}', 'NER', '227', NULL),
(165, '{\"es\":\"Nigeria\",\"en\":\"Nigeria\"}', 'NGA', '234', NULL),
(166, '{\"es\":\"Niue\",\"en\":\"Niue\"}', 'NIU', '683', NULL),
(168, '{\"es\":\"Noruega\",\"en\":\"Norway\"}', 'NOR', '47', NULL),
(169, '{\"es\":\"Nueva Caledonia\",\"en\":\"New Caledonia\"}', 'NCL', '687', NULL),
(170, '{\"es\":\"Nueva Zelanda\",\"en\":\"New Zealand\"}', 'NZL', '64', NULL),
(171, '{\"es\":\"Om\\u00e1n\",\"en\":\"Om\\u00e1n\"}', 'OMN', '968', NULL),
(172, '{\"es\":\"Pa\\u00edses Bajos\",\"en\":\"Netherlands\"}', 'NLD', '31', '7'),
(173, '{\"es\":\"Pakist\\u00e1n\",\"en\":\"Pakistan\"}', 'PAK', '92', NULL),
(174, '{\"es\":\"Palau\",\"en\":\"Palau\"}', 'PLW', '680', NULL),
(175, '{\"es\":\"Palestina\",\"en\":\"Palestine\"}', 'PSE', '0', NULL),
(176, '{\"es\":\"Panam\\u00e1\",\"en\":\"Panama\"}', 'PAN', '507', NULL),
(177, '{\"es\":\"Pap\\u00faa Nueva Guinea\",\"en\":\"Pap\\u00faa Nueva Guinea\"}', 'PNG', '675', NULL),
(178, '{\"es\":\"Paraguay\",\"en\":\"Paraguay\"}', 'PRY', '595', NULL),
(179, '{\"es\":\"Per\\u00fa\",\"en\":\"Peru\"}', 'PER', '51', NULL),
(180, '{\"es\":\"Polinesia Francesa\",\"en\":\"French Polynesia\"}', 'PYF', '689', NULL),
(181, '{\"es\":\"Polonia\",\"en\":\"Poland\"}', 'POL', '48', NULL),
(182, '{\"es\":\"Portugal\",\"en\":\"Portugal\"}', 'PRT', '351', NULL),
(183, '{\"es\":\"Puerto Rico\",\"en\":\"Puerto Rico\"}', 'PRI', '787', NULL),
(184, '{\"es\":\"Qatar\",\"en\":\"Qatar\"}', 'QAT', '974', NULL),
(185, '{\"es\":\"Reino Unido\",\"en\":\"United Kingdom\"}', 'GBR', '44', '4'),
(186, '{\"es\":\"Rep\\u00fablica Centroafricana\",\"en\":\"Central African Republic\"}', 'CAF', '236', NULL),
(187, '{\"es\":\"Rep\\u00fablica Checa\",\"en\":\"Czech Republic\"}', 'CZE', '420', NULL),
(188, '{\"es\":\"Rep\\u00fablica Dominicana\",\"en\":\"Dominican Republic\"}', 'DOM', '809', NULL),
(189, '{\"es\":\"Reuni\\u00f3n\",\"en\":\"Reuni\\u00f3n\"}', 'REU', '0', NULL),
(190, '{\"es\":\"Ruanda\",\"en\":\"Rwanda\"}', 'RWA', '250', NULL),
(191, '{\"es\":\"Ruman\\u00eda\",\"en\":\"Romania\"}', 'ROU', '40', NULL),
(192, '{\"es\":\"Rusia\",\"en\":\"Russia\"}', 'RUS', '7', NULL),
(193, '{\"es\":\"Sahara Occidental\",\"en\":\"Occidental Sahara\"}', 'ESH', '0', NULL),
(194, '{\"es\":\"Samoa\",\"en\":\"Samoa\"}', 'WSM', '685', NULL),
(195, '{\"es\":\"Samoa Americana\",\"en\":\"American Samoa\"}', 'ASM', '684', NULL),
(196, '{\"es\":\"San Bartolom\\u00e9\",\"en\":\"San Bartolome\"}', 'BLM', '590', NULL),
(197, '{\"es\":\"San Crist\\u00f3bal y Nieves\",\"en\":\"Saint Kitts and Nevis\"}', 'KNA', '869', NULL),
(198, '{\"es\":\"San Marino\",\"en\":\"San Marino\"}', 'SMR', '378', NULL),
(199, '{\"es\":\"San Mart\\u00edn (Francia)\",\"en\":\"San Martin (French)\"}', 'MAF', '599', NULL),
(200, '{\"es\":\"San Pedro y Miquel\\u00f3n\",\"en\":\"San Pedro y Miquel\\u00f3n\"}', 'SPM', '508', NULL),
(201, '{\"es\":\"San Vicente y las Granadinas\",\"en\":\"St. Vincent and the Grenadines\"}', 'VCT', '784', NULL),
(202, '{\"es\":\"Santa Elena\",\"en\":\"St. Helen\"}', 'SHN', '290', NULL),
(203, '{\"es\":\"Santa Luc\\u00eda\",\"en\":\"St. Lucia\"}', 'LCA', '758', NULL),
(204, '{\"es\":\"Santo Tom\\u00e9 y Pr\\u00edncipe\",\"en\":\"Sao Tome and Principe\"}', 'STP', '239', NULL),
(205, '{\"es\":\"Senegal\",\"en\":\"Senegal\"}', 'SEN', '221', NULL),
(206, '{\"es\":\"Serbia\",\"en\":\"Serbia\"}', 'SRB', '381', NULL),
(207, '{\"es\":\"Seychelles\",\"en\":\"Seychelles\"}', 'SYC', '248', NULL),
(208, '{\"es\":\"Sierra Leona\",\"en\":\"Sierra Leone\"}', 'SLE', '232', NULL),
(209, '{\"es\":\"Singapur\",\"en\":\"Singapore\"}', 'SGP', '65', NULL),
(210, '{\"es\":\"Siria\",\"en\":\"Syria\"}', 'SYR', '963', NULL),
(211, '{\"es\":\"Somalia\",\"en\":\"Somalia\"}', 'SOM', '252', NULL),
(212, '{\"es\":\"Sri lanka\",\"en\":\"Sri lanka\"}', 'LKA', '94', NULL),
(213, '{\"es\":\"Sud\\u00e1frica\",\"en\":\"South Africa\"}', 'ZAF', '27', NULL),
(214, '{\"es\":\"Sud\\u00e1n\",\"en\":\"Sudan\"}', 'SDN', '249', NULL),
(215, '{\"es\":\"Suecia\",\"en\":\"Sweden\"}', 'SWE', '46', NULL),
(216, '{\"es\":\"Suiza\",\"en\":\"Switzerland\"}', 'CHE', '41', NULL),
(217, '{\"es\":\"Surin\\u00e1m\",\"en\":\"Surinam\"}', 'SUR', '597', NULL),
(218, '{\"es\":\"Svalbard y Jan Mayen\",\"en\":\"Svalbard and Jan Mayen\"}', 'SJM', '0', NULL),
(219, '{\"es\":\"Swazilandia\",\"en\":\"Swaziland\"}', 'SWZ', '268', NULL),
(220, '{\"es\":\"Tadjikist\\u00e1n\",\"en\":\"Tajikistan\"}', 'TJK', '992', NULL),
(221, '{\"es\":\"Tailandia\",\"en\":\"Thailand\"}', 'THA', '66', NULL),
(222, '{\"es\":\"Taiw\\u00e1n\",\"en\":\"Taiwan\"}', 'TWN', '886', NULL),
(223, '{\"es\":\"Tanzania\",\"en\":\"Tanzania\"}', 'TZA', '255', NULL),
(224, '{\"es\":\"Territorio Brit\\u00e1nico del Oc\\u00e9ano \\u00cdndico\",\"en\":\"British Territory of the Indian Ocean\"}', 'IOT', '0', NULL),
(225, '{\"es\":\"Territorios Australes y Ant\\u00e1rticas Franceses\",\"en\":\"French Southern and Antarctic Territories\"}', 'ATF', '0', NULL),
(226, '{\"es\":\"Timor Oriental\",\"en\":\"West timor\"}', 'TLS', '670', NULL),
(227, '{\"es\":\"Togo\",\"en\":\"Togo\"}', 'TGO', '228', NULL),
(228, '{\"es\":\"Tokelau\",\"en\":\"Tokelau\"}', 'TKL', '690', NULL),
(229, '{\"es\":\"Tonga\",\"en\":\"Tonga\"}', 'TON', '676', NULL),
(230, '{\"es\":\"Trinidad y Tobago\",\"en\":\"Trinidad and Tobago\"}', 'TTO', '868', NULL),
(231, '{\"es\":\"Tunez\",\"en\":\"Tunisia\"}', 'TUN', '216', NULL),
(232, '{\"es\":\"Turkmenist\\u00e1n\",\"en\":\"Turkmenistan\"}', 'TKM', '993', NULL),
(233, '{\"es\":\"Turqu\\u00eda\",\"en\":\"Turkey\"}', 'TUR', '90', NULL),
(234, '{\"es\":\"Tuvalu\",\"en\":\"Tuvalu\"}', 'TUV', '688', NULL),
(235, '{\"es\":\"Ucrania\",\"en\":\"Ukraine\"}', 'UKR', '380', NULL),
(236, '{\"es\":\"Uganda\",\"en\":\"Uganda\"}', 'UGA', '256', NULL),
(237, '{\"es\":\"Uruguay\",\"en\":\"Uruguay\"}', 'URY', '598', NULL),
(238, '{\"es\":\"Uzbekist\\u00e1n\",\"en\":\"Uzbekistan\"}', 'UZB', '998', NULL),
(239, '{\"es\":\"Vanuatu\",\"en\":\"Vanuatu\"}', 'VUT', '678', NULL),
(240, '{\"es\":\"Venezuela\",\"en\":\"Venezuela\"}', 'VEN', '58', NULL),
(241, '{\"es\":\"Vietnam\",\"en\":\"Vietnam\"}', 'VNM', '84', NULL),
(242, '{\"es\":\"Wallis y Futuna\",\"en\":\"Wallis and Futuna\"}', 'WLF', '681', NULL),
(243, '{\"es\":\"Yemen\",\"en\":\"Yemen\"}', 'YEM', '967', NULL),
(244, '{\"es\":\"Yibuti\",\"en\":\"Djibouti\"}', 'DJI', '253', NULL),
(245, '{\"es\":\"Zambia\",\"en\":\"Zambia\"}', 'ZMB', '260', NULL),
(246, '{\"es\":\"Zimbabue\",\"en\":\"Zimbabwe\"}', 'ZWE', '263', NULL),
(247, '{\"es\":\"Gales\",\"en\":\"Welsh\"}', 'GBR', '44', '11'),
(248, '{\"es\":\"Escocia\",\"en\":\"Scotland\"}', 'SCO', '44', NULL),
(249, '{\"es\":\"Inglaterra\",\"en\":\"England\"}', 'ENG', '44', NULL),
(250, '{\"es\":\"Holanda\",\"en\":\"Holland\"}', 'NLD', '31', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) NOT NULL,
  `name` text NOT NULL,
  `code` varchar(4) NOT NULL,
  `priority` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `code`, `priority`) VALUES
(1, '{\"es\":\"Afgani afgano\",\"en\":\"Afgani afgano\"}', 'AFN', NULL),
(2, '{\"es\":\"Lek alban\\u00e9s\",\"en\":\"Lek alban\\u00e9s\"}', 'ALL', NULL),
(3, '{\"es\":\"Euro\",\"en\":\"Euro\"}', 'EUR', 4),
(5, '{\"es\":\"Kwanza angole\\u00f1o\",\"en\":\"Kwanza angole\\u00f1o\"}', 'AOA', NULL),
(6, '{\"es\":\"D\\u00f3lar del Caribe Oriental\",\"en\":\"D\\u00f3lar del Caribe Oriental\"}', 'XCD', NULL),
(7, '{\"es\":\"Riyal saud\\u00ed\",\"en\":\"Riyal saud\\u00ed\"}', 'SAR', NULL),
(8, '{\"es\":\"Dinar argelino\",\"en\":\"Dinar argelino\"}', 'DZD', NULL),
(9, '{\"es\":\"Peso argentino\",\"en\":\"Peso argentino\"}', 'ARS', NULL),
(10, '{\"es\":\"Dram armenio\",\"en\":\"Dram armenio\"}', 'AMD', NULL),
(11, '{\"es\":\"D\\u00f3lar australiano\",\"en\":\"D\\u00f3lar australiano\"}', 'AUD', NULL),
(13, '{\"es\":\"Manat azer\\u00ed\",\"en\":\"Manat azer\\u00ed\"}', 'AZN', NULL),
(14, '{\"es\":\"D\\u00f3lar bahame\\u00f1o\",\"en\":\"D\\u00f3lar bahame\\u00f1o\"}', 'BSD', NULL),
(15, '{\"es\":\"Taka bangladesh\\u00ed\",\"en\":\"Taka bangladesh\\u00ed\"}', 'BDT', NULL),
(16, '{\"es\":\"D\\u00f3lar de Barbados\",\"en\":\"D\\u00f3lar de Barbados\"}', 'BBD', NULL),
(17, '{\"es\":\"Dinar bahrein\\u00ed\",\"en\":\"Dinar bahrein\\u00ed\"}', 'BHD', NULL),
(19, '{\"es\":\"D\\u00f3lar belice\\u00f1o\",\"en\":\"D\\u00f3lar belice\\u00f1o\"}', 'BZD', NULL),
(20, '{\"es\":\"Franco CFA de \\u00c1frica Occidental\",\"en\":\"Franco CFA de \\u00c1frica Occidental\"}', 'XOF', NULL),
(21, '{\"es\":\"Rublo bielorruso\",\"en\":\"Rublo bielorruso\"}', 'BYN', NULL),
(22, '{\"es\":\"Kyat birmano\",\"en\":\"Kyat birmano\"}', 'MMK', NULL),
(23, '{\"es\":\"Boliviano\",\"en\":\"Boliviano\"}', 'BOB', NULL),
(24, '{\"es\":\"Marco convertible\",\"en\":\"Marco convertible\"}', 'BAM', NULL),
(25, '{\"es\":\"Pula\",\"en\":\"Pula\"}', 'BWP', NULL),
(26, '{\"es\":\"Real brasile\\u00f1o\",\"en\":\"Real brasile\\u00f1o\"}', 'BRL', NULL),
(27, '{\"es\":\"D\\u00f3lar de Brun\\u00e9i\",\"en\":\"D\\u00f3lar de Brun\\u00e9i\"}', 'BND', NULL),
(28, '{\"es\":\"Lev b\\u00falgaro\",\"en\":\"Lev b\\u00falgaro\"}', 'BGN', NULL),
(30, '{\"es\":\"Franco de Burundi\",\"en\":\"Franco de Burundi\"}', 'BIF', NULL),
(31, '{\"es\":\"Ngultrum butan\\u00e9s\",\"en\":\"Ngultrum butan\\u00e9s\"}', 'BTN', NULL),
(32, '{\"es\":\"Escudo caboverdiano\",\"en\":\"Escudo caboverdiano\"}', 'CVE', NULL),
(33, '{\"es\":\"Riel camboyano\",\"en\":\"Riel camboyano\"}', 'KHR', NULL),
(34, '{\"es\":\"Franco CFA de \\u00c1frica Central\",\"en\":\"Franco CFA de \\u00c1frica Central\"}', 'XAF', NULL),
(35, '{\"es\":\"D\\u00f3lar canadiense\",\"en\":\"D\\u00f3lar canadiense\"}', 'CAD', 3),
(36, '{\"es\":\"Riyal qatar\\u00ed\",\"en\":\"Riyal qatar\\u00ed\"}', 'QAR', NULL),
(38, '{\"es\":\"Peso chileno\",\"en\":\"Peso chileno\"}', 'CLP', NULL),
(39, '{\"es\":\"Yuan chino\",\"en\":\"Yuan chino\"}', 'CNY', NULL),
(41, '{\"es\":\"Peso colombiano\",\"en\":\"Peso colombiano\"}', 'COP', NULL),
(42, '{\"es\":\"Franco comorano\",\"en\":\"Franco comorano\"}', 'KMF', NULL),
(44, '{\"es\":\"Won norcoreano\",\"en\":\"Won norcoreano\"}', 'KPW', NULL),
(47, '{\"es\":\"Col\\u00f3n costarricense\",\"en\":\"Col\\u00f3n costarricense\"}', 'CRC', NULL),
(48, '{\"es\":\"Kuna croata\",\"en\":\"Kuna croata\"}', 'HRK', NULL),
(49, '{\"es\":\"Peso cubano\",\"en\":\"Peso cubano\"}', 'CUP', NULL),
(50, '{\"es\":\"Corona danesa\",\"en\":\"Corona danesa\"}', 'DKK', NULL),
(52, '{\"es\":\"D\\u00f3lar estadounidense\",\"en\":\"D\\u00f3lar estadounidense\"}', 'USD', 2),
(53, '{\"es\":\"Libra egipcia\",\"en\":\"Libra egipcia\"}', 'EGP', NULL),
(55, '{\"es\":\"Dirham de los Emiratos \\u00c1rabes Unidos\",\"en\":\"Dirham de los Emiratos \\u00c1rabes Unidos\"}', 'AED', NULL),
(56, '{\"es\":\"Nakfa\",\"en\":\"Nakfa\"}', 'ERN', NULL),
(62, '{\"es\":\"Birr et\\u00edope\",\"en\":\"Birr et\\u00edope\"}', 'ETB', NULL),
(63, '{\"es\":\"Peso filipino\",\"en\":\"Peso filipino\"}', 'PHP', NULL),
(65, '{\"es\":\"D\\u00f3lar fiyiano\",\"en\":\"D\\u00f3lar fiyiano\"}', 'FJD', NULL),
(68, '{\"es\":\"Dalasi\",\"en\":\"Dalasi\"}', 'GMD', NULL),
(69, '{\"es\":\"Lari georgiano\",\"en\":\"Lari georgiano\"}', 'GEL', NULL),
(70, '{\"es\":\"Cedi\",\"en\":\"Cedi\"}', 'GHS', NULL),
(73, '{\"es\":\"Quetzal guatemalteco\",\"en\":\"Quetzal guatemalteco\"}', 'GTQ', NULL),
(74, '{\"es\":\"Franco guineano\",\"en\":\"Franco guineano\"}', 'GNF', NULL),
(77, '{\"es\":\"D\\u00f3lar guyan\\u00e9s\",\"en\":\"D\\u00f3lar guyan\\u00e9s\"}', 'GYD', NULL),
(78, '{\"es\":\"Gourde haitiano\",\"en\":\"Gourde haitiano\"}', 'HTG', NULL),
(79, '{\"es\":\"Lempira hondure\\u00f1o\",\"en\":\"Lempira hondure\\u00f1o\"}', 'HNL', NULL),
(80, '{\"es\":\"Forinto h\\u00fangaro\",\"en\":\"Forinto h\\u00fangaro\"}', 'HUF', NULL),
(81, '{\"es\":\"Rupia india\",\"en\":\"Rupia india\"}', 'INR', NULL),
(82, '{\"es\":\"Rupia indonesia\",\"en\":\"Rupia indonesia\"}', 'IDR', NULL),
(83, '{\"es\":\"Dinar iraqu\\u00ed\",\"en\":\"Dinar iraqu\\u00ed\"}', 'IQD', NULL),
(84, '{\"es\":\"Rial iran\\u00ed\",\"en\":\"Rial iran\\u00ed\"}', 'IRR', NULL),
(86, '{\"es\":\"Corona islandes\",\"en\":\"Corona islandes\"}', 'ISK', NULL),
(88, '{\"es\":\"D\\u00f3lar de las Islas Salom\\u00f3n\",\"en\":\"D\\u00f3lar de las Islas Salom\\u00f3n\"}', 'SBD', NULL),
(89, '{\"es\":\"Nuevo sh\\u00e9quel\",\"en\":\"Nuevo sh\\u00e9quel\"}', 'ILS', NULL),
(91, '{\"es\":\"D\\u00f3lar jamaiquino\",\"en\":\"D\\u00f3lar jamaiquino\"}', 'JMD', NULL),
(92, '{\"es\":\"Yen\",\"en\":\"Yen\"}', 'JPY', NULL),
(93, '{\"es\":\"Dinar jordano\",\"en\":\"Dinar jordano\"}', 'JOD', NULL),
(94, '{\"es\":\"Tenge kazajo\",\"en\":\"Tenge kazajo\"}', 'KZT', NULL),
(95, '{\"es\":\"Chel\\u00edn keniano\",\"en\":\"Chel\\u00edn keniano\"}', 'KES', NULL),
(96, '{\"es\":\"Som kirgu\\u00eds\",\"en\":\"Som kirgu\\u00eds\"}', 'KGS', NULL),
(99, '{\"es\":\"Dinar kuwait\\u00ed\",\"en\":\"Dinar kuwait\\u00ed\"}', 'KWD', NULL),
(100, '{\"es\":\"Kip laosiano\",\"en\":\"Kip laosiano\"}', 'LAK', NULL),
(101, '{\"es\":\"Loti\",\"en\":\"Loti\"}', 'LSL', NULL),
(103, '{\"es\":\"Libra libanesa\",\"en\":\"Libra libanesa\"}', 'LBP', NULL),
(104, '{\"es\":\"D\\u00f3lar liberiano\",\"en\":\"D\\u00f3lar liberiano\"}', 'LRD', NULL),
(105, '{\"es\":\"Dinar libio\",\"en\":\"Dinar libio\"}', 'LYD', NULL),
(106, '{\"es\":\"Franco suizo\",\"en\":\"Franco suizo\"}', 'CHF', NULL),
(109, '{\"es\":\"Denar macedonio\",\"en\":\"Denar macedonio\"}', 'MKD', NULL),
(110, '{\"es\":\"Ariary malgache\",\"en\":\"Ariary malgache\"}', 'MGA', NULL),
(111, '{\"es\":\"Ringgit malayo\",\"en\":\"Ringgit malayo\"}', 'MYR', NULL),
(112, '{\"es\":\"Kwacha malau\\u00ed\",\"en\":\"Kwacha malau\\u00ed\"}', 'MWK', NULL),
(113, '{\"es\":\"Rupia de Maldivas\",\"en\":\"Rupia de Maldivas\"}', 'MVR', NULL),
(116, '{\"es\":\"Dirham marroqu\\u00ed\",\"en\":\"Dirham marroqu\\u00ed\"}', 'MAD', NULL),
(117, '{\"es\":\"Rupia de Mauricio\",\"en\":\"Rupia de Mauricio\"}', 'MUR', NULL),
(118, '{\"es\":\"Uguiya\",\"en\":\"Uguiya\"}', 'MRO', NULL),
(119, '{\"es\":\"Peso mexicano\",\"en\":\"Peso mexicano\"}', 'MXN', 1),
(121, '{\"es\":\"Leu moldavo\",\"en\":\"Leu moldavo\"}', 'MDL', NULL),
(123, '{\"es\":\"Tugrik mongol\",\"en\":\"Tugrik mongol\"}', 'MNT', NULL),
(125, '{\"es\":\"Metical mozambique\\u00f1o\",\"en\":\"Metical mozambique\\u00f1o\"}', 'MZN', NULL),
(126, '{\"es\":\"D\\u00f3lar namibio\",\"en\":\"D\\u00f3lar namibio\"}', 'NAD', NULL),
(128, '{\"es\":\"Rupia nepal\\u00ed\",\"en\":\"Rupia nepal\\u00ed\"}', 'NPR', NULL),
(129, '{\"es\":\"C\\u00f3rdoba nicarag\\u00fcense\",\"en\":\"C\\u00f3rdoba nicarag\\u00fcense\"}', 'NIO', NULL),
(131, '{\"es\":\"Naira\",\"en\":\"Naira\"}', 'NGN', NULL),
(132, '{\"es\":\"Corona noruega\",\"en\":\"Corona noruega\"}', 'NOK', NULL),
(133, '{\"es\":\"D\\u00f3lar neozeland\\u00e9s\",\"en\":\"D\\u00f3lar neozeland\\u00e9s\"}', 'NZD', NULL),
(134, '{\"es\":\"Rial oman\\u00ed\",\"en\":\"Rial oman\\u00ed\"}', 'OMR', NULL),
(136, '{\"es\":\"Rupia pakistan\\u00ed\",\"en\":\"Rupia pakistan\\u00ed\"}', 'PKR', NULL),
(139, '{\"es\":\"Balboa paname\\u00f1o\",\"en\":\"Balboa paname\\u00f1o\"}', 'PAB', NULL),
(140, '{\"es\":\"Kina\",\"en\":\"Kina\"}', 'PGK', NULL),
(141, '{\"es\":\"Guaran\\u00ed\",\"en\":\"Guaran\\u00ed\"}', 'PYG', NULL),
(142, '{\"es\":\"Nuevo sol\",\"en\":\"Nuevo sol\"}', 'PEN', NULL),
(143, '{\"es\":\"Zloty\",\"en\":\"Zloty\"}', 'PLN', NULL),
(145, '{\"es\":\"Libra brit\\u00e1nica\",\"en\":\"Libra brit\\u00e1nica\"}', 'GBP', NULL),
(147, '{\"es\":\"Corona checa\",\"en\":\"Corona checa\"}', 'CZK', NULL),
(148, '{\"es\":\"Franco congole\\u00f1o\",\"en\":\"Franco congole\\u00f1o\"}', 'CDF', NULL),
(149, '{\"es\":\"Peso dominicano\",\"en\":\"Peso dominicano\"}', 'DOP', NULL),
(150, '{\"es\":\"Franco ruand\\u00e9s\",\"en\":\"Franco ruand\\u00e9s\"}', 'RWF', NULL),
(151, '{\"es\":\"Leu rumano\",\"en\":\"Leu rumano\"}', 'RON', NULL),
(152, '{\"es\":\"Rublo ruso\",\"en\":\"Rublo ruso\"}', 'RUB', NULL),
(153, '{\"es\":\"Tala\",\"en\":\"Tala\"}', 'WST', NULL),
(158, '{\"es\":\"Dobra\",\"en\":\"Dobra\"}', 'STD', NULL),
(160, '{\"es\":\"Dinar serbio\",\"en\":\"Dinar serbio\"}', 'RSD', NULL),
(161, '{\"es\":\"Rupia de Seychelles\",\"en\":\"Rupia de Seychelles\"}', 'SCR', NULL),
(162, '{\"es\":\"Leone\",\"en\":\"Leone\"}', 'SLL', NULL),
(163, '{\"es\":\"D\\u00f3lar de Singapur\",\"en\":\"D\\u00f3lar de Singapur\"}', 'SGD', NULL),
(164, '{\"es\":\"Libra siria\",\"en\":\"Libra siria\"}', 'SYP', NULL),
(165, '{\"es\":\"Chel\\u00edn somal\\u00ed\",\"en\":\"Chel\\u00edn somal\\u00ed\"}', 'SOS', NULL),
(166, '{\"es\":\"Rupia de Sri Lanka\",\"en\":\"Rupia de Sri Lanka\"}', 'LKR', NULL),
(167, '{\"es\":\"Lilangeni\",\"en\":\"Lilangeni\"}', 'SZL', NULL),
(168, '{\"es\":\"Rand sudafricano\",\"en\":\"Rand sudafricano\"}', 'ZAR', NULL),
(169, '{\"es\":\"Libra sudanesa\",\"en\":\"Libra sudanesa\"}', 'SDG', NULL),
(170, '{\"es\":\"Libra sursudanesa\",\"en\":\"Libra sursudanesa\"}', 'SSP', NULL),
(171, '{\"es\":\"Corona sueca\",\"en\":\"Corona sueca\"}', 'SEK', NULL),
(173, '{\"es\":\"D\\u00f3lar surinam\\u00e9s\",\"en\":\"D\\u00f3lar surinam\\u00e9s\"}', 'SRD', NULL),
(174, '{\"es\":\"Baht tailand\\u00e9s\",\"en\":\"Baht tailand\\u00e9s\"}', 'THB', NULL),
(175, '{\"es\":\"Nuevo d\\u00f3lar taiwan\\u00e9s\",\"en\":\"Nuevo d\\u00f3lar taiwan\\u00e9s\"}', 'TWD', NULL),
(176, '{\"es\":\"Chel\\u00edn tanzano\",\"en\":\"Chel\\u00edn tanzano\"}', 'TZS', NULL),
(177, '{\"es\":\"Somoni tayiko\",\"en\":\"Somoni tayiko\"}', 'TJS', NULL),
(180, '{\"es\":\"Paanga\",\"en\":\"Paanga\"}', 'TOP', NULL),
(181, '{\"es\":\"D\\u00f3lar trinitense\",\"en\":\"D\\u00f3lar trinitense\"}', 'TTD', NULL),
(182, '{\"es\":\"Dinar tunecino\",\"en\":\"Dinar tunecino\"}', 'TND', NULL),
(183, '{\"es\":\"Manat turcomano\",\"en\":\"Manat turcomano\"}', 'TMT', NULL),
(184, '{\"es\":\"Lira turca\",\"en\":\"Lira turca\"}', 'TRY', NULL),
(186, '{\"es\":\"Grivna\",\"en\":\"Grivna\"}', 'UAH', NULL),
(187, '{\"es\":\"Chel\\u00edn ugand\\u00e9s\",\"en\":\"Chel\\u00edn ugand\\u00e9s\"}', 'UGX', NULL),
(188, '{\"es\":\"Peso uruguayo\",\"en\":\"Peso uruguayo\"}', 'UYU', NULL),
(189, '{\"es\":\"Som uzbeko\",\"en\":\"Som uzbeko\"}', 'UZS', NULL),
(190, '{\"es\":\"Vatu\",\"en\":\"Vatu\"}', 'VUV', NULL),
(192, '{\"es\":\"Bol\\u00edvar fuerte\",\"en\":\"Bol\\u00edvar fuerte\"}', 'VEF', NULL),
(193, '{\"es\":\"Dong vietnamita\",\"en\":\"Dong vietnamita\"}', 'VND', NULL),
(194, '{\"es\":\"Rial yemen\\u00ed\",\"en\":\"Rial yemen\\u00ed\"}', 'YER', NULL),
(195, '{\"es\":\"Franco yibutiano\",\"en\":\"Franco yibutiano\"}', 'DJF', NULL),
(196, '{\"es\":\"Kwacha zambiano\",\"en\":\"Kwacha zambiano\"}', 'ZMW', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guests_treatments`
--

CREATE TABLE `guests_treatments` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `name` text NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `guests_treatments`
--

INSERT INTO `guests_treatments` (`id`, `account`, `name`, `status`) VALUES
(1, 1, 'Sr.', 1),
(2, 1, 'Sra.', 1),
(3, 1, 'Srita.', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guests_types`
--

CREATE TABLE `guests_types` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `name` text NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `guests_types`
--

INSERT INTO `guests_types` (`id`, `account`, `name`, `status`) VALUES
(1, 1, 'Club vacacional', 1),
(2, 1, 'Day pass', 1),
(3, 1, 'Externo', 1),
(4, 1, 'Gold', 1),
(5, 1, 'Platinium', 1),
(6, 1, 'Regular', 1),
(7, 1, 'VIP', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `icons`
--

CREATE TABLE `icons` (
  `id` bigint(20) NOT NULL,
  `name` text NOT NULL,
  `url` text NOT NULL,
  `type` enum('food') NOT NULL,
  `color` text NOT NULL,
  `menu` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `icons`
--

INSERT INTO `icons` (`id`, `name`, `url`, `type`, `color`, `menu`) VALUES
(1, '{\"es\":\"Verengena\",\"en\":\"Aubergine\"}', 'aubergine.png', 'food', '#bff796', 1),
(2, '{\"es\":\"Cerveza\",\"en\":\"Beer\"}', 'beer.png', 'food', '#c63c22', 1),
(3, '{\"es\":\"Pastel\",\"en\":\"Cake\"}', 'cake.png', 'food', '#c63c22', 1),
(4, '{\"es\":\"Galleta\",\"en\":\"Cookie\"}', 'cookie.png', 'food', '#b85627', 1),
(5, '{\"es\":\"Pan\",\"en\":\"Bread\"}', 'bread.png', 'food', '#5e4534', 1),
(6, '{\"es\":\"Desayuno\",\"en\":\"Breakfast\"}', 'breakfast.png', 'food', '#503b2c', 1),
(7, '{\"es\":\"Brocheta\",\"en\":\"Brochettes\"}', 'brochettes.png', 'food', '#ffa800', 1),
(8, '{\"es\":\"Hamburguesa\",\"en\":\"Burger\"}', 'burger.png', 'food', '#79302a', 1),
(9, '{\"es\":\"Zanahoria\",\"en\":\"Carrot\"}', 'carrot.png', 'food', '#d5c295', 1),
(10, '{\"es\":\"Queso\",\"en\":\"Cheese\"}', 'cheese.png', 'food', '#b85627', 1),
(11, '{\"es\":\"Pollo 1\",\"en\":\"Chicken 1\"}', 'chicken_1.png', 'food', '#e67e22', 1),
(12, '{\"es\":\"Pollo 2\",\"en\":\"Chicken 2\"}', 'chicken_2.png', 'food', '#e67e22', 1),
(13, '{\"es\":\"Chocolate 1\",\"en\":\"Chocolate 1\"}', 'chocolate_1.png', 'food', '#ae9676', 1),
(14, '{\"es\":\"Chocolate 2\",\"en\":\"Chocolate 2\"}', 'chocolate_2.png', 'food', '#ae9676', 1),
(15, '{\"es\":\"Chocolate 3\",\"en\":\"Chocolate 3\"}', 'chocolate_3.png', 'food', '#f4af30', 1),
(16, '{\"es\":\"Cocktel\",\"en\":\"Cocktail\"}', 'cocktail.png', 'food', '#345f41', 1),
(17, '{\"es\":\"Cafe\",\"en\":\"Coffee\"}', 'coffee.png', 'food', '#27ae60', 1),
(18, '{\"es\":\"Refresco\",\"en\":\"Soda\"}', 'soda.png', 'food', '#ffa800', 1),
(19, '{\"es\":\"Cuvierta\",\"en\":\"Covering\"}', 'covering.png', 'food', '#345065', 1),
(20, '{\"es\":\"Cuernitos\",\"en\":\"Croissant\"}', 'croissant.png', 'food', '#5e4534', 1),
(21, '{\"es\":\"Taza\",\"en\":\"Cup\"}', 'cup.png', 'food', '#345065', 1),
(22, '{\"es\":\"Magdalena\",\"en\":\"Cupcake\"}', 'cupcake.png', 'food', '#4f2b4f', 1),
(23, '{\"es\":\"Dona\",\"en\":\"Donut\"}', 'donut.png', 'food', '#4f2b4f', 1),
(24, '{\"es\":\"Huevo\",\"en\":\"Egg\"}', 'egg.png', 'food', '#17ab93', 1),
(25, '{\"es\":\"Pescado\",\"en\":\"Fish\"}', 'fish.png', 'food', '#5e4534', 1),
(26, '{\"es\":\"Papas\",\"en\":\"Fries\"}', 'fries.png', 'food', '#d5c295', 1),
(27, '{\"es\":\"Miel\",\"en\":\"Honey\"}', 'honey.png', 'food', '#b85627', 1),
(28, '{\"es\":\"Perro caliente\",\"en\":\"Hotdog\"}', 'hotdog.png', 'food', '#662621', 1),
(29, '{\"es\":\"Mermelada\",\"en\":\"Jam\"}', 'jam.png', 'food', '#5e4534', 1),
(30, '{\"es\":\"Gelatina\",\"en\":\"Jelly\"}', 'jelly.png', 'food', '#5e345e', 1),
(31, '{\"es\":\"Jugo\",\"en\":\"Juice\"}', 'juice.png', 'food', '#e67e22', 1),
(32, '{\"es\":\"Ketchup\",\"en\":\"Ketchup\"}', 'ketchup.png', 'food', '#ffa800', 1),
(33, '{\"es\":\"Lim\\u00f3n\",\"en\":\"Lemon\"}', 'lemon.png', 'food', '#79302a', 1),
(34, '{\"es\":\"Lechuga\",\"en\":\"Lettuce\"}', 'lettuce.png', 'food', '#345f41', 1),
(35, '{\"es\":\"Hogaza\",\"en\":\"Loaf\"}', 'loaf.png', 'food', '#5e4534', 1),
(36, '{\"es\":\"Leche\",\"en\":\"Milk\"}', 'milk.png', 'food', '#394c81', 1),
(37, '{\"es\":\"Tallarines\",\"en\":\"Noodles\"}', 'noodles.png', 'food', '#cb6f3d', 1),
(38, '{\"es\":\"Pimienta\",\"en\":\"Pepper\"}', 'pepper.png', 'food', '#a5c63b', 1),
(39, '{\"es\":\"Pepinillos\",\"en\":\"Pickles\"}', 'pickles.png', 'food', '#3c5768', 1),
(40, '{\"es\":\"Pay\",\"en\":\"Pie\"}', 'pie.png', 'food', '#4f2b4f', 1),
(41, '{\"es\":\"Pizza\",\"en\":\"Pizza\"}', 'pizza.png', 'food', '#c0392b', 1),
(42, '{\"es\":\"Arroz\",\"en\":\"Rice\"}', 'rice.png', 'food', '#5e4534', 1),
(43, '{\"es\":\"Salchicha\",\"en\":\"Sausage\"}', 'sausage.png', 'food', '#d95459', 1),
(44, '{\"es\":\"Spaguetti\",\"en\":\"Spaguetti\"}', 'spaguetti.png', 'food', '#c0392b', 1),
(45, '{\"es\":\"Carne\",\"en\":\"Steak\"}', 'steak.png', 'food', '#f86e51', 1),
(46, '{\"es\":\"T\\u00e9\",\"en\":\"Tea\"}', 'tea.png', 'food', '#d95459', 1),
(47, '{\"es\":\"Agua\",\"en\":\"Water\"}', 'water.png', 'food', '#0ea6cb', 1),
(48, '{\"es\":\"Sand\\u00eda\",\"en\":\"Watermelon\"}', 'watermelon.png', 'food', '#345f41', 1),
(49, '{\"es\":\"Vino\",\"en\":\"Wine\"}', 'wine.png', 'food', '#d95459', 1),
(50, '{\"es\":\"Helado\",\"en\":\"Icecream\"}', 'icecream.png', 'food', '#4f2b4f', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) NOT NULL,
  `name` text NOT NULL,
  `code` varchar(2) NOT NULL,
  `priority` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `priority`) VALUES
(1, 'Español', 'es', 1),
(2, 'English', 'en', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `name` text NOT NULL,
  `request` tinyint(1) NOT NULL,
  `incident` tinyint(1) NOT NULL,
  `workorder` tinyint(1) NOT NULL,
  `public` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `locations`
--

INSERT INTO `locations` (`id`, `account`, `name`, `request`, `incident`, `workorder`, `public`, `status`) VALUES
(1, 2, '{\"es\":\"Ubicaci\\u00f3n 1\",\"en\":\"Location 1\"}', 1, 1, 1, 1, 1),
(2, 2, '{\"es\":\"Ubicaci\\u00f3n 2\",\"en\":\"Location 2\"}', 1, 1, 1, 1, 1),
(3, 1, '{\"es\":\"Ubicaci\\u00f3n 1\",\"en\":\"Location 1\"}', 1, 1, 1, 1, 1),
(26, 1, '{\"es\":\"Ubicacion 2\",\"en\":\"Location 2\"}', 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_categories`
--

CREATE TABLE `menu_categories` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `name` text NOT NULL,
  `position` int(11) NOT NULL,
  `icon` bigint(20) NOT NULL,
  `map` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `menu_categories`
--

INSERT INTO `menu_categories` (`id`, `account`, `name`, `position`, `icon`, `map`, `status`) VALUES
(8, 2, '{\"es\":\"Paquetes\",\"en\":\"packages\"}', 1, 42, NULL, 1),
(9, 2, '{\"es\":\"Categor\\u00eda 2\",\"en\":\"Category 2\"}', 2, 31, NULL, 1),
(10, 2, '{\"es\":\"Categor\\u00eda 3\",\"en\":\"Category 3\"}', 3, 8, NULL, 1),
(11, 2, '{\"es\":\"Categor\\u00eda 4\",\"en\":\"Category 4\"}', 4, 11, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_orders`
--

CREATE TABLE `menu_orders` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `token` char(8) NOT NULL,
  `type_service` enum('owner','delivery') DEFAULT NULL,
  `owner` bigint(20) DEFAULT NULL,
  `delivery` enum('bring','collect') DEFAULT NULL,
  `contact` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `location` text DEFAULT NULL,
  `date` date NOT NULL,
  `hour` time NOT NULL,
  `total` double NOT NULL,
  `currency` text NOT NULL,
  `payment_method` enum('credit_card','debit_card','cash') NOT NULL,
  `shopping_cart` longtext NOT NULL,
  `declined` tinyint(1) NOT NULL,
  `accepted` tinyint(1) NOT NULL,
  `delivered` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `menu_orders`
--

INSERT INTO `menu_orders` (`id`, `account`, `token`, `type_service`, `owner`, `delivery`, `contact`, `address`, `location`, `date`, `hour`, `total`, `currency`, `payment_method`, `shopping_cart`, `declined`, `accepted`, `delivered`) VALUES
(1, 2, 'yb1ucsgh', 'delivery', NULL, 'bring', '{\"firstname\":\"Gers\\u00f3n Aar\\u00f3n\",\"lastname\":\"G\\u00f3mez Mac\\u00edas\",\"email\":\"gergomez18@gmail.com\",\"phone\":{\"lada\":\"52\",\"number\":\"9981579341\"}}', 'Supermanzana 74 Manzana 7 Lote 4 Calle 3', '{\"lat\":\"21.181611209206967\",\"lng\":\"-86.81489989202144\"}', '2021-02-13', '16:39:04', 220, 'MXN', 'cash', '{\"12\":[{\"quantity\":\"1\",\"id\":\"12\",\"code\":\"\",\"name\":{\"es\":\"Producto 1\",\"en\":\"Product 1\"},\"topics\":[{\"id\":\"14\",\"price\":\"10\",\"selection\":\"checkbox\",\"name\":{\"es\":\"Extra 1\",\"en\":\"Extra 1\"}},{\"id\":\"15\",\"price\":\"10\",\"selection\":\"checkbox\",\"name\":{\"es\":\"Extra 2\",\"en\":\"Extra 2\"}}],\"price\":\"100\",\"total\":120}],\"15\":[{\"quantity\":\"1\",\"id\":\"15\",\"code\":\"\",\"name\":{\"es\":\"Producto 4\",\"en\":\"Product 4\"},\"topics\":[],\"price\":\"100\",\"total\":100}]}', 0, 1, 1),
(2, 2, 'd5xdnvv0', 'delivery', NULL, 'bring', '{\"firstname\":\"Gers\\u00f3n Aar\\u00f3n\",\"lastname\":\"G\\u00f3mez Mac\\u00edas\",\"email\":\"gergomez18@gmail.com\",\"phone\":{\"lada\":\"52\",\"number\":\"0987654321\"}}', 'Mi dirección', '{\"lat\":\"21.181617213572363\",\"lng\":\"-86.8148977458777\"}', '2021-02-15', '21:43:47', 120, 'MXN', 'cash', '{\"12\":[{\"quantity\":\"1\",\"id\":\"12\",\"code\":\"\",\"name\":{\"es\":\"Producto 1\",\"en\":\"Product 1\"},\"topics\":[{\"id\":\"14\",\"price\":\"10\",\"selection\":\"checkbox\",\"name\":{\"es\":\"Extra 1\",\"en\":\"Extra 1\"}},{\"id\":\"15\",\"price\":\"10\",\"selection\":\"checkbox\",\"name\":{\"es\":\"Extra 2\",\"en\":\"Extra 2\"}}],\"price\":\"100\",\"total\":120}]}', 0, 1, 1),
(3, 2, 'yjngnnar', 'delivery', NULL, 'bring', '{\"firstname\":\"Gers\\u00f3n Aar\\u00f3n\",\"lastname\":\"G\\u00f3mez Mac\\u00edas\",\"email\":\"gergomez18@gmail.com\",\"phone\":{\"lada\":\"52\",\"number\":\"0987654321\"}}', 'ngfxhthtrth', '{\"lat\":\"21.163276556330317\",\"lng\":\"-86.82031298639866\"}', '2021-02-18', '15:23:36', 90, 'MXN', 'cash', '{\"658\":[{\"quantity\":\"1\",\"id\":\"658\",\"name\":{\"es\":\"Producto\",\"en\":\"Product\"},\"topics\":[{\"id\":\"14\",\"price\":\"20\",\"selection\":\"checkbox\",\"name\":{\"es\":\"Extra 1\",\"en\":\"Extra 1\"}},{\"id\":\"15\",\"price\":\"0\",\"selection\":\"checkbox\",\"name\":{\"es\":\"Extra 2\",\"en\":\"Extra 2\"}},{\"id\":\"16\",\"price\":\"0\",\"selection\":\"checkbox\",\"name\":{\"es\":\"Extra 3\",\"en\":\"Extra 3\"}},{\"id\":\"17\",\"price\":\"0\",\"selection\":\"checkbox\",\"name\":{\"es\":\"Extra 4\",\"en\":\"Extra 4\"}}],\"price\":\"70\",\"total\":90,\"map\":\"\"}]}', 0, 1, 1),
(4, 2, 'z8ykhhss', 'delivery', NULL, 'bring', '{\"firstname\":\"Gers\\u00f3n Aar\\u00f3n\",\"lastname\":\"G\\u00f3mez Mac\\u00edas\",\"email\":\"gergomez18@gmail.com\",\"phone\":{\"lada\":\"52\",\"number\":\"0987654321\"}}', 'Mi direccion', '{\"lat\":\"21.148278449281708\",\"lng\":\"-86.83556374527778\"}', '2021-02-18', '15:29:42', 70, 'MXN', 'cash', '{\"658\":[{\"quantity\":\"1\",\"id\":\"658\",\"name\":{\"es\":\"Puntas de res a la mexicana\",\"en\":\"Mexican beef tips\"},\"topics\":[{\"id\":\"14\",\"price\":\"0\",\"selection\":\"checkbox\",\"name\":{\"es\":\"Arroz|\",\"en\":\"Rice\"}},{\"id\":\"15\",\"price\":\"0\",\"selection\":\"checkbox\",\"name\":{\"es\":\"Frijol\",\"en\":\"Beans\"}},{\"id\":\"16\",\"price\":\"0\",\"selection\":\"checkbox\",\"name\":{\"es\":\"Tortilla\",\"en\":\"Tortilla\"}},{\"id\":\"17\",\"price\":\"0\",\"selection\":\"checkbox\",\"name\":{\"es\":\"Agua del d\\u00eda\",\"en\":\"Water of the day\"}}],\"price\":\"70\",\"total\":70,\"map\":\"\"}]}', 1, 1, 0),
(5, 2, 'a4m9xjzv', 'delivery', NULL, 'collect', '{\"firstname\":\"Gerson\",\"lastname\":\"Gomez\",\"email\":\"gergomez18@gmail.com\",\"phone\":{\"lada\":\"52\",\"number\":\"0987654321\"}}', '', '{\"lat\":\"21.159198566133863\",\"lng\":\"-86.82573387226238\"}', '2021-02-20', '18:01:35', 120, 'MXN', 'cash', '{\"12\":[{\"quantity\":\"1\",\"id\":\"12\",\"name\":{\"es\":\"Producto 1\",\"en\":\"Product 1\"},\"topics\":[{\"id\":\"14\",\"price\":\"10\",\"selection\":\"checkbox\",\"name\":{\"es\":\"Arroz|\",\"en\":\"Rice\"}},{\"id\":\"15\",\"price\":\"10\",\"selection\":\"checkbox\",\"name\":{\"es\":\"Frijol\",\"en\":\"Beans\"}}],\"price\":\"100\",\"total\":120,\"map\":\"\"}]}', 0, 1, 1),
(6, 2, 'obgln4af', 'delivery', NULL, 'collect', '{\"firstname\":\"Gerson\",\"lastname\":\"Gomez\",\"email\":\"gergomez18@gmail.com\",\"phone\":{\"lada\":\"52\",\"number\":\"0987654321\"}}', '', '{\"lat\":\"21.159198566133863\",\"lng\":\"-86.82573387226238\"}', '2021-02-20', '18:15:04', 0, 'MXN', 'cash', '[]', 1, 1, 0),
(7, 2, 'z6xgtbyf', 'delivery', NULL, 'collect', '{\"firstname\":\"Gerson\",\"lastname\":\"Gomez\",\"email\":\"gergomez18@gmail.com\",\"phone\":{\"lada\":\"52\",\"number\":\"0987654321\"}}', '', '{\"lat\":\"21.159198566133863\",\"lng\":\"-86.82573387226238\"}', '2021-02-20', '18:15:54', 0, 'MXN', 'cash', '[]', 0, 0, 0),
(8, 2, 'mvuoyh8l', 'delivery', NULL, 'collect', '{\"firstname\":\"Gerson\",\"lastname\":\"Gomez\",\"email\":\"gergomez18@gmail.com\",\"phone\":{\"lada\":\"52\",\"number\":\"0987654321\"}}', '', '{\"lat\":\"21.159198566133863\",\"lng\":\"-86.82573387226238\"}', '2021-02-20', '18:18:21', 120, 'MXN', 'cash', '{\"12\":[{\"quantity\":\"1\",\"id\":\"12\",\"name\":{\"es\":\"Producto 1\",\"en\":\"Product 1\"},\"topics\":[{\"id\":\"14\",\"price\":\"10\",\"selection\":\"checkbox\",\"name\":{\"es\":\"Arroz|\",\"en\":\"Rice\"}},{\"id\":\"15\",\"price\":\"10\",\"selection\":\"checkbox\",\"name\":{\"es\":\"Frijol\",\"en\":\"Beans\"}}],\"price\":\"100\",\"total\":120,\"map\":\"\"}]}', 0, 1, 0),
(9, 2, '5tcmdill', 'delivery', NULL, 'collect', '{\"firstname\":\"Gerson\",\"lastname\":\"Gomez\",\"email\":\"gergomez18@gmail.com\",\"phone\":{\"lada\":\"52\",\"number\":\"987654319\"}}', '', '{\"lat\":\"21.159198566133863\",\"lng\":\"-86.82573387226238\"}', '2021-02-20', '18:22:38', 120, 'MXN', 'cash', '{\"12\":[{\"quantity\":\"1\",\"id\":\"12\",\"name\":{\"es\":\"Producto 1\",\"en\":\"Product 1\"},\"topics\":[{\"id\":\"14\",\"price\":\"10\",\"selection\":\"checkbox\",\"name\":{\"es\":\"Arroz|\",\"en\":\"Rice\"}},{\"id\":\"15\",\"price\":\"10\",\"selection\":\"checkbox\",\"name\":{\"es\":\"Frijol\",\"en\":\"Beans\"}}],\"price\":\"100\",\"total\":120,\"map\":\"\"}]}', 0, 1, 0),
(10, 2, 'asrrhvrf', 'delivery', NULL, 'collect', '{\"firstname\":\"Gerson\",\"lastname\":\"Gomez\",\"email\":\"gergomez18@gmail.com\",\"phone\":{\"lada\":\"52\",\"number\":\"987654318\"}}', '', '{\"lat\":\"21.159198566133863\",\"lng\":\"-86.82573387226238\"}', '2021-02-20', '18:24:07', 100, 'MXN', 'cash', '{\"12\":[{\"quantity\":\"1\",\"id\":\"12\",\"name\":{\"es\":\"Producto 1\",\"en\":\"Product 1\"},\"topics\":[],\"price\":\"100\",\"total\":100,\"map\":\"\"}]}', 1, 0, 0),
(11, 2, 'czgxweol', 'delivery', NULL, 'collect', '{\"firstname\":\"Gerson\",\"lastname\":\"Gomez\",\"email\":\"gergomez18@gmail.com\",\"phone\":{\"lada\":\"52\",\"number\":\"0987654321\"}}', '', '{\"lat\":\"21.159198566133863\",\"lng\":\"-86.82573387226238\"}', '2021-02-20', '18:30:09', 100, 'MXN', 'cash', '{\"12\":[{\"quantity\":\"1\",\"id\":\"12\",\"name\":{\"es\":\"Producto 1\",\"en\":\"Product 1\"},\"topics\":[],\"price\":\"100\",\"total\":100,\"map\":\"\"}]}', 0, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_products`
--

CREATE TABLE `menu_products` (
  `id` int(11) NOT NULL,
  `account` bigint(20) NOT NULL,
  `name` text NOT NULL,
  `description` text DEFAULT NULL,
  `topics` text DEFAULT NULL,
  `price` double NOT NULL,
  `position` int(11) NOT NULL,
  `available` text DEFAULT NULL,
  `avatar` enum('image','icon') NOT NULL,
  `image` text DEFAULT NULL,
  `icon` bigint(20) DEFAULT NULL,
  `categories` text DEFAULT NULL,
  `restaurant` bigint(20) DEFAULT NULL,
  `map` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `menu_products`
--

INSERT INTO `menu_products` (`id`, `account`, `name`, `description`, `topics`, `price`, `position`, `available`, `avatar`, `image`, `icon`, `categories`, `restaurant`, `map`, `status`) VALUES
(12, 2, '{\"es\":\"Producto 1\",\"en\":\"Product 1\"}', '{\"es\":\"Mi descripci\\u00f3n\",\"en\":\"My description\"}', '[[{\"id\":\"14\",\"price\":\"10\",\"selection\":\"checkbox\"},{\"id\":\"15\",\"price\":\"10\",\"selection\":\"checkbox\"}]]', 100, 2, '{\"days\":[\"monday\",\"tuesday\",\"wednesday\",\"thursday\",\"friday\",\"saturday\",\"sunday\"],\"start_date\":\"\",\"end_date\":\"\"}', 'icon', NULL, 41, '[\"8\"]', NULL, NULL, 1),
(13, 2, '{\"es\":\"Producto 2\",\"en\":\"Product 2\"}', '{\"es\":\"Mi descripci\\u00f3n\",\"en\":\"My description\"}', '[[{\"id\":\"16\",\"price\":\"10\",\"selection\":\"radio\"},{\"id\":\"17\",\"price\":\"10\",\"selection\":\"radio\"}]]', 100, 3, '{\"days\":[\"monday\",\"tuesday\",\"wednesday\",\"thursday\",\"friday\",\"saturday\",\"sunday\"],\"start_date\":\"\",\"end_date\":\"\"}', 'icon', NULL, 45, '[\"9\"]', NULL, NULL, 1),
(14, 2, '{\"es\":\"Producto 3\",\"en\":\"Product 3\"}', '{\"es\":\"Mi descripci\\u00f3n\",\"en\":\"My description\"}', '[]', 100, 4, '{\"days\":[\"monday\",\"tuesday\",\"wednesday\",\"thursday\",\"friday\",\"saturday\",\"sunday\"],\"start_date\":\"\",\"end_date\":\"\"}', 'icon', NULL, 50, '[\"10\"]', NULL, NULL, 1),
(15, 2, '{\"es\":\"Producto 4\",\"en\":\"Product 4\"}', '{\"es\":\"Mi descripci\\u00f3n\",\"en\":\"My description\"}', '[]', 100, 5, '{\"days\":[\"monday\",\"tuesday\",\"wednesday\",\"thursday\",\"friday\",\"saturday\",\"sunday\"],\"start_date\":\"\",\"end_date\":\"\"}', 'icon', NULL, 31, '[\"11\"]', NULL, NULL, 1),
(658, 2, '{\"es\":\"Puntas de res a la mexicana\",\"en\":\"Mexican beef tips\"}', '{\"es\":\"Ricas fajitas de res estilo M\\u00e9xico\",\"en\":\"Rich Mexican style beef fajitas\"}', '[[{\"id\":\"14\",\"price\":\"0\",\"selection\":\"checkbox\"},{\"id\":\"15\",\"price\":\"0\",\"selection\":\"checkbox\"},{\"id\":\"16\",\"price\":\"0\",\"selection\":\"checkbox\"},{\"id\":\"17\",\"price\":\"0\",\"selection\":\"checkbox\"}]]', 70, 1, '{\"days\":[\"thursday\"],\"start_date\":\"\",\"end_date\":\"\"}', 'icon', NULL, 7, '[\"8\"]', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_restaurants`
--

CREATE TABLE `menu_restaurants` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `token` char(8) NOT NULL,
  `name` text NOT NULL,
  `qr` text NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_topics`
--

CREATE TABLE `menu_topics` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `name` text NOT NULL,
  `position` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `menu_topics`
--

INSERT INTO `menu_topics` (`id`, `account`, `name`, `position`, `status`) VALUES
(14, 2, '{\"es\":\"Arroz|\",\"en\":\"Rice\"}', 1, 1),
(15, 2, '{\"es\":\"Frijol\",\"en\":\"Beans\"}', 2, 1),
(16, 2, '{\"es\":\"Tortilla\",\"en\":\"Tortilla\"}', 3, 1),
(17, 2, '{\"es\":\"Agua del d\\u00eda\",\"en\":\"Water of the day\"}', 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opportunity_areas`
--

CREATE TABLE `opportunity_areas` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `name` text NOT NULL,
  `request` tinyint(1) NOT NULL,
  `incident` tinyint(1) NOT NULL,
  `workorder` tinyint(1) NOT NULL,
  `public` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `opportunity_areas`
--

INSERT INTO `opportunity_areas` (`id`, `account`, `name`, `request`, `incident`, `workorder`, `public`, `status`) VALUES
(5, 2, '{\"es\":\"Área de oportunidad 1\",\"en\":\"Opportunity area 1\"}', 1, 1, 1, 1, 1),
(6, 2, '{\"es\":\"Área de oportunidad 2\",\"en\":\"Opportunity area 2\"}', 1, 1, 1, 1, 1),
(7, 1, '{\"es\":\"Área de oportunidad 1\",\"en\":\"Opportunity area 1\"}', 1, 1, 1, 1, 1),
(10, 1, '{\"es\":\"Área de oportunidad 2\",\"en\":\"Opportunity area 2\"}', 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opportunity_types`
--

CREATE TABLE `opportunity_types` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `opportunity_area` bigint(20) NOT NULL,
  `name` text NOT NULL,
  `request` tinyint(1) NOT NULL,
  `incident` tinyint(1) NOT NULL,
  `workorder` tinyint(1) NOT NULL,
  `public` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `opportunity_types`
--

INSERT INTO `opportunity_types` (`id`, `account`, `opportunity_area`, `name`, `request`, `incident`, `workorder`, `public`, `status`) VALUES
(5, 2, 5, '{\"es\":\"Tipo de oportunidad 1\",\"en\":\"Opportunity Type 1\"}', 1, 1, 1, 1, 1),
(6, 2, 6, '{\"es\":\"Tipo de oportunidad 2\",\"en\":\"Opportunity Type 2\"}', 1, 1, 1, 1, 1),
(7, 1, 7, '{\"es\":\"Tipo  de oportunidad 1\",\"en\":\"Opportunity Type 1\"}', 1, 1, 1, 1, 1),
(9, 1, 10, '{\"es\":\"Tipo de oportunidad 2\",\"en\":\"Opportunity Type 2\"}', 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `owners`
--

CREATE TABLE `owners` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `token` char(8) NOT NULL,
  `name` text NOT NULL,
  `number` int(11) DEFAULT NULL,
  `request` tinyint(1) NOT NULL,
  `incident` tinyint(1) NOT NULL,
  `workorder` tinyint(1) NOT NULL,
  `survey` tinyint(1) NOT NULL,
  `public` tinyint(1) NOT NULL,
  `qr` text NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `owners`
--

INSERT INTO `owners` (`id`, `account`, `token`, `name`, `number`, `request`, `incident`, `workorder`, `survey`, `public`, `qr`, `status`) VALUES
(1, 2, 'hlsunb5q', '{\"es\":\"Propietario 1\",\"en\":\"Owner 1\"}', 1, 1, 1, 1, 1, 1, 'hotrestaurant_owner_qr_hlsunb5q.png', 1),
(2, 2, 'gkryqrm2', '{\"es\":\"Propietario 2\",\"en\":\"Owner 2\"}', 2, 1, 1, 1, 1, 1, 'hotrestaurant_owner_qr_gkryqrm2.png', 1),
(6, 1, 'qrvmtzzt', '{\"es\":\"Propietario 1\",\"en\":\"Owner 1\"}', 0, 1, 1, 1, 1, 1, 'royalhotel_owner_qr_qrvmtzzt.png', 1),
(7, 1, 'ntsmvqah', '{\"es\":\"Propietario 2\",\"en\":\"Owner 2\"}', 0, 1, 1, 1, 1, 1, 'royalhotel_owner_qr_ntsmvqah.png', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) NOT NULL,
  `type` enum('hotel','restaurant','others') NOT NULL,
  `quantity_start` int(11) NOT NULL,
  `quantity_end` int(11) NOT NULL,
  `price` text NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `packages`
--

INSERT INTO `packages` (`id`, `type`, `quantity_start`, `quantity_end`, `price`, `status`) VALUES
(1, 'hotel', 1, 6, '{\"operation\":\"1462\",\"reputation\":\"1462\"}', 1),
(2, 'hotel', 7, 10, '{\"operation\":\"2154\",\"reputation\":\"2154\"}', 1),
(3, 'hotel', 11, 15, '{\"operation\":\"2308\",\"reputation\":\"2308\"}', 1),
(4, 'hotel', 16, 20, '{\"operation\":\"2462\",\"reputation\":\"2462\"}', 1),
(5, 'hotel', 21, 25, '{\"operation\":\"2615\",\"reputation\":\"2615\"}', 1),
(6, 'hotel', 26, 30, '{\"operation\":\"2769\",\"reputation\":\"2769\"}', 1),
(7, 'hotel', 31, 35, '{\"operation\":\"2923\",\"reputation\":\"2923\"}', 1),
(8, 'hotel', 36, 40, '{\"operation\":\"3077\",\"reputation\":\"3077\"}', 1),
(9, 'hotel', 41, 45, '{\"operation\":\"3154\",\"reputation\":\"3154\"}', 1),
(10, 'hotel', 46, 50, '{\"operation\":\"3231\",\"reputation\":\"3231\"}', 1),
(11, 'hotel', 51, 55, '{\"operation\":\"3308\",\"reputation\":\"3308\"}', 1),
(12, 'hotel', 56, 60, '{\"operation\":\"3385\",\"reputation\":\"3385\"}', 1),
(13, 'hotel', 61, 65, '{\"operation\":\"3462\",\"reputation\":\"3462\"}', 1),
(14, 'hotel', 66, 70, '{\"operation\":\"3538\",\"reputation\":\"3538\"}', 1),
(15, 'hotel', 71, 75, '{\"operation\":\"3615\",\"reputation\":\"3615\"}', 1),
(16, 'hotel', 76, 80, '{\"operation\":\"3692\",\"reputation\":\"3692\"}', 1),
(17, 'hotel', 81, 85, '{\"operation\":\"3769\",\"reputation\":\"3769\"}', 1),
(18, 'hotel', 86, 90, '{\"operation\":\"3846\",\"reputation\":\"3846\"}', 1),
(19, 'hotel', 91, 95, '{\"operation\":\"3923\",\"reputation\":\"3923\"}', 1),
(20, 'hotel', 96, 100, '{\"operation\":\"4000\",\"reputation\":\"4000\"}', 1),
(21, 'restaurant', 1, 100, '{\"operation\":\"1340\",\"reputation\":\"1340\"}', 1),
(23, 'others', 1, 100, '{\"operation\":\"1340\",\"reputation\":\"1340\"}', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `token` varchar(8) NOT NULL,
  `code` varchar(8) NOT NULL,
  `response` longtext NOT NULL,
  `date` date NOT NULL,
  `hour` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) NOT NULL,
  `name` text NOT NULL,
  `code` text NOT NULL,
  `group` text NOT NULL,
  `type` text NOT NULL,
  `digital_menu` tinyint(1) NOT NULL,
  `operation` tinyint(1) NOT NULL,
  `surveys` tinyint(1) NOT NULL,
  `hotel` tinyint(1) NOT NULL,
  `restaurant` tinyint(1) NOT NULL,
  `others` tinyint(1) NOT NULL,
  `priority` int(11) NOT NULL,
  `unique` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `code`, `group`, `type`, `digital_menu`, `operation`, `surveys`, `hotel`, `restaurant`, `others`, `priority`, `unique`) VALUES
(1, '{\"es\":\"Todo\",\"en\":\"All\"}', '{view_all}', 'view', 'operational', 1, 1, 1, 1, 1, 1, 2, 1),
(2, '{\"es\":\"Áreas de oportunidad\",\"en\":\"Opportunity areas\"}', '{view_opportunity_areas}', 'view', 'operational', 1, 1, 1, 1, 1, 1, 4, 1),
(3, '{\"es\":\"Propio\",\"en\":\"Own\"}', '{view_own}', 'view', 'operational', 1, 1, 1, 1, 1, 1, 3, 1),
(4, '{\"es\":\"Confidencialidad\",\"en\":\"Confidentiality\"}', '{view_confidentiality}', 'view', 'supervision', 0, 1, 0, 1, 1, 1, 1, 0),
(5, '{\"es\":\"Crear\",\"en\":\"Create\"}', '{voxes_reports_create}', 'voxes_reports', 'administrative', 0, 1, 0, 1, 1, 1, 2, 0),
(6, '{\"es\":\"Editar\",\"en\":\"Update\"}', '{voxes_reports_update}', 'voxes_reports', 'administrative', 0, 1, 0, 1, 1, 1, 3, 0),
(7, '{\"es\":\"Desactivar\",\"en\":\"Deactivate\"}', '{voxes_reports_deactivate}', 'voxes_reports', 'administrative', 0, 1, 0, 1, 1, 1, 4, 0),
(8, '{\"es\":\"Activar\",\"en\":\"Activate\"}', '{voxes_reports_activate}', 'voxes_reports', 'administrative', 0, 1, 0, 1, 1, 1, 5, 0),
(9, '{\"es\":\"Eliminar\",\"en\":\"Delete\"}', '{voxes_reports_delete}', 'voxes_reports', 'administrative', 0, 1, 0, 1, 1, 1, 6, 0),
(10, '{\"es\":\"Ver\",\"en\":\"View\"}', '{voxes_reports_print}', 'voxes_reports', 'supervision', 0, 1, 0, 1, 1, 1, 1, 0),
(11, '{\"es\":\"Ver\",\"en\":\"View\"}', '{voxes_stats_view}', 'voxes_stats', 'supervision', 0, 1, 0, 1, 1, 1, 5, 0),
(12, '{\"es\":\"Crear\",\"en\":\"Create\"}', '{surveys_questions_create}', 'surveys_questions', 'administrative', 0, 0, 1, 1, 1, 1, 1, 0),
(13, '{\"es\":\"Editar\",\"en\":\"Update\"}', '{surveys_questions_update}', 'surveys_questions', 'administrative', 0, 0, 1, 1, 1, 1, 2, 0),
(14, '{\"es\":\"Desactivar\",\"en\":\"Deactivate\"}', '{surveys_questions_deactivate}', 'surveys_questions', 'administrative', 0, 0, 1, 1, 1, 1, 3, 0),
(15, '{\"es\":\"Activar\",\"en\":\"Activate\"}', '{surveys_questions_activate}', 'surveys_questions', 'administrative', 0, 0, 1, 1, 1, 1, 4, 0),
(16, '{\"es\":\"Eliminar\",\"en\":\"Delete\"}', '{surveys_questions_delete}', 'surveys_questions', 'administrative', 0, 0, 1, 1, 1, 1, 5, 0),
(17, '{\"es\":\"Ver\",\"en\":\"View\"}', '{surveys_answers_view}', 'surveys_answers', 'supervision', 0, 0, 1, 1, 1, 1, 1, 0),
(18, '{\"es\":\"Ver\",\"en\":\"View\"}', '{surveys_stats_view}', 'surveys_stats', 'supervision', 0, 0, 1, 1, 1, 1, 1, 0),
(19, '{\"es\":\"Crear\",\"en\":\"Create\"}', '{owners_create}', 'owners', 'administrative', 1, 1, 1, 1, 1, 1, 1, 0),
(20, '{\"es\":\"Editar\",\"en\":\"Update\"}', '{owners_update}', 'owners', 'administrative', 1, 1, 1, 1, 1, 1, 2, 0),
(21, '{\"es\":\"Desactivar\",\"en\":\"Deactivate\"}', '{owners_deactivate}', 'owners', 'administrative', 1, 1, 1, 1, 1, 1, 3, 0),
(22, '{\"es\":\"Activar\",\"en\":\"Activate\"}', '{owners_activate}', 'owners', 'administrative', 1, 1, 1, 1, 1, 1, 4, 0),
(23, '{\"es\":\"Eliminar\",\"en\":\"Delete\"}', '{owners_delete}', 'owners', 'administrative', 1, 1, 1, 1, 1, 1, 5, 0),
(24, '{\"es\":\"Crear\",\"en\":\"Create\"}', '{opportunity_areas_create}', 'opportunity_areas', 'administrative', 0, 1, 0, 1, 1, 1, 1, 0),
(25, '{\"es\":\"Editar\",\"en\":\"Update\"}', '{opportunity_areas_update}', 'opportunity_areas', 'administrative', 0, 1, 0, 1, 1, 1, 2, 0),
(26, '{\"es\":\"Desactivar\",\"en\":\"Deactivate\"}', '{opportunity_areas_deactivate}', 'opportunity_areas', 'administrative', 0, 1, 0, 1, 1, 1, 3, 0),
(27, '{\"es\":\"Activar\",\"en\":\"Activate\"}', '{opportunity_areas_activate}', 'opportunity_areas', 'administrative', 0, 1, 0, 1, 1, 1, 4, 0),
(28, '{\"es\":\"Eliminar\",\"en\":\"Delete\"}', '{opportunity_areas_delete}', 'opportunity_areas', 'administrative', 0, 1, 0, 1, 1, 1, 5, 0),
(29, '{\"es\":\"Crear\",\"en\":\"Create\"}', '{opportunity_types_create}', 'opportunity_types', 'administrative', 0, 1, 0, 1, 1, 1, 1, 0),
(30, '{\"es\":\"Editar\",\"en\":\"Update\"}', '{opportunity_types_update}', 'opportunity_types', 'administrative', 0, 1, 0, 1, 1, 1, 2, 0),
(31, '{\"es\":\"Desactivar\",\"en\":\"Deactivate\"}', '{opportunity_types_deactivate}', 'opportunity_types', 'administrative', 0, 1, 0, 1, 1, 1, 3, 0),
(32, '{\"es\":\"Activar\",\"en\":\"Activate\"}', '{opportunity_types_activate}', 'opportunity_types', 'administrative', 0, 1, 0, 1, 1, 1, 4, 0),
(33, '{\"es\":\"Eliminar\",\"en\":\"Delete\"}', '{opportunity_types_delete}', 'opportunity_types', 'administrative', 0, 1, 0, 1, 1, 1, 5, 0),
(34, '{\"es\":\"Crear\",\"en\":\"Create\"}', '{locations_create}', 'locations', 'administrative', 1, 1, 0, 1, 1, 1, 1, 0),
(35, '{\"es\":\"Editar\",\"en\":\"Update\"}', '{locations_update}', 'locations', 'administrative', 1, 1, 0, 1, 1, 1, 2, 0),
(36, '{\"es\":\"Desactivar\",\"en\":\"Deactivate\"}', '{locations_deactivate}', 'locations', 'administrative', 1, 1, 0, 1, 1, 1, 3, 0),
(37, '{\"es\":\"Activar\",\"en\":\"Activate\"}', '{locations_activate}', 'locations', 'administrative', 1, 1, 0, 1, 1, 1, 4, 0),
(38, '{\"es\":\"Eliminar\",\"en\":\"Delete\"}', '{locations_delete}', 'locations', 'administrative', 1, 1, 0, 1, 1, 1, 5, 0),
(39, '{\"es\":\"Crear\",\"en\":\"Create\"}', '{guests_treatments_create}', 'guests_treatments', 'administrative', 0, 1, 0, 1, 0, 0, 1, 0),
(40, '{\"es\":\"Editar\",\"en\":\"Update\"}', '{guests_treatments_update}', 'guests_treatments', 'administrative', 0, 1, 0, 1, 0, 0, 2, 0),
(41, '{\"es\":\"Desactivar\",\"en\":\"Deactivate\"}', '{guests_treatments_deactivate}', 'guests_treatments', 'administrative', 0, 1, 0, 1, 0, 0, 3, 0),
(42, '{\"es\":\"Activar\",\"en\":\"Activate\"}', '{guests_treatments_activate}', 'guests_treatments', 'administrative', 0, 1, 0, 1, 0, 0, 4, 0),
(43, '{\"es\":\"Eliminar\",\"en\":\"Delete\"}', '{guests_treatments_delete}', 'guests_treatments', 'administrative', 0, 1, 0, 1, 0, 0, 5, 0),
(44, '{\"es\":\"Crear\",\"en\":\"Create\"}', '{guests_types_create}', 'guests_types', 'administrative', 0, 1, 0, 1, 0, 0, 1, 0),
(45, '{\"es\":\"Editar\",\"en\":\"Update\"}', '{guests_types_update}', 'guests_types', 'administrative', 0, 1, 0, 1, 0, 0, 2, 0),
(46, '{\"es\":\"Desactivar\",\"en\":\"Deactivate\"}', '{guests_types_deactivate}', 'guests_types', 'administrative', 0, 1, 0, 1, 0, 0, 3, 0),
(47, '{\"es\":\"Activar\",\"en\":\"Activate\"}', '{guests_types_activate}', 'guests_types', 'administrative', 0, 1, 0, 1, 0, 0, 4, 0),
(48, '{\"es\":\"Eliminar\",\"en\":\"Delete\"}', '{guests_types_delete}', 'guests_types', 'administrative', 0, 1, 0, 1, 0, 0, 5, 0),
(49, '{\"es\":\"Crear\",\"en\":\"Create\"}', '{reservations_statuses_create}', 'reservations_statuses', 'administrative', 0, 1, 0, 1, 0, 0, 1, 0),
(50, '{\"es\":\"Editar\",\"en\":\"Update\"}', '{reservations_statuses_update}', 'reservations_statuses', 'administrative', 0, 1, 0, 1, 0, 0, 2, 0),
(51, '{\"es\":\"Desactivar\",\"en\":\"Deactivate\"}', '{reservations_statuses_deactivate}', 'reservations_statuses', 'administrative', 0, 1, 0, 1, 0, 0, 3, 0),
(52, '{\"es\":\"Activar\",\"en\":\"Activate\"}', '{reservations_statuses_activate}', 'reservations_statuses', 'administrative', 0, 1, 0, 1, 0, 0, 4, 0),
(53, '{\"es\":\"Eliminar\",\"en\":\"Delete\"}', '{reservations_statuses_delete}', 'reservations_statuses', 'administrative', 0, 1, 0, 1, 0, 0, 5, 0),
(54, '{\"es\":\"Crear\",\"en\":\"Create\"}', '{users_levels_create}', 'users_levels', 'administrative', 1, 1, 1, 1, 1, 1, 1, 0),
(55, '{\"es\":\"Editar\",\"en\":\"Update\"}', '{users_levels_update}', 'users_levels', 'administrative', 1, 1, 1, 1, 1, 1, 2, 0),
(56, '{\"es\":\"Desactivar\",\"en\":\"Deactivate\"}', '{users_levels_deactivate}', 'users_levels', 'administrative', 1, 1, 1, 1, 1, 1, 3, 0),
(57, '{\"es\":\"Activar\",\"en\":\"Activate\"}', '{users_levels_activate}', 'users_levels', 'administrative', 1, 1, 1, 1, 1, 1, 4, 0),
(58, '{\"es\":\"Eliminar\",\"en\":\"Delete\"}', '{users_levels_delete}', 'users_levels', 'administrative', 1, 1, 1, 1, 1, 1, 5, 0),
(59, '{\"es\":\"Crear\",\"en\":\"Create\"}', '{users_create}', 'users', 'administrative', 1, 1, 1, 1, 1, 1, 1, 0),
(60, '{\"es\":\"Editar\",\"en\":\"Update\"}', '{users_update}', 'users', 'administrative', 1, 1, 1, 1, 1, 1, 2, 0),
(61, '{\"es\":\"Restablecer contraseña\",\"en\":\"Restore password\"}', '{users_restore_password}', 'users', 'administrative', 1, 1, 1, 1, 1, 1, 3, 0),
(62, '{\"es\":\"Desactivar\",\"en\":\"Deactivate\"}', '{users_deactivate}', 'users', 'administrative', 1, 1, 1, 1, 1, 1, 4, 0),
(63, '{\"es\":\"Activar\",\"en\":\"Activate\"}', '{users_activate}', 'users', 'administrative', 1, 1, 1, 1, 1, 1, 5, 0),
(64, '{\"es\":\"Eliminar\",\"en\":\"Delete\"}', '{users_delete}', 'users', 'administrative', 1, 1, 1, 1, 1, 1, 6, 0),
(65, '{\"es\":\"Editar\",\"en\":\"Update\"}', '{account_update}', 'account', 'administrative', 1, 1, 1, 1, 1, 1, 1, 0),
(66, '{\"es\":\"Crear\",\"en\":\"Create\"}', '{menu_products_create}', 'menu_products', 'administrative', 1, 0, 0, 1, 1, 1, 1, 0),
(67, '{\"es\":\"Editar\",\"en\":\"Update\"}', '{menu_products_update}', 'menu_products', 'administrative', 1, 0, 0, 1, 1, 1, 2, 0),
(68, '{\"es\":\"Desactivar\",\"en\":\"Deactivate\"}', '{menu_products_deactivate}', 'menu_products', 'administrative', 1, 0, 0, 1, 1, 1, 3, 0),
(69, '{\"es\":\"Activar\",\"en\":\"Activate\"}', '{menu_products_activate}', 'menu_products', 'administrative', 1, 0, 0, 1, 1, 1, 4, 0),
(70, '{\"es\":\"Eliminar\",\"en\":\"Delete\"}', '{menu_products_delete}', 'menu_products', 'administrative', 1, 0, 0, 1, 1, 1, 5, 0),
(71, '{\"es\":\"Crear\",\"en\":\"Create\"}', '{menu_restaurants_create}', 'menu_restaurants', 'administrative', 1, 0, 0, 1, 1, 1, 1, 0),
(72, '{\"es\":\"Editar\",\"en\":\"Update\"}', '{menu_restaurants_update}', 'menu_restaurants', 'administrative', 1, 0, 0, 1, 1, 1, 2, 0),
(73, '{\"es\":\"Desactivar\",\"en\":\"Deactivate\"}', '{menu_restaurants_deactivate}', 'menu_restaurants', 'administrative', 1, 0, 0, 1, 1, 1, 3, 0),
(74, '{\"es\":\"Activar\",\"en\":\"Activate\"}', '{menu_restaurants_activate}', 'menu_restaurants', 'administrative', 1, 0, 0, 1, 1, 1, 4, 0),
(75, '{\"es\":\"Eliminar\",\"en\":\"Delete\"}', '{menu_restaurants_delete}', 'menu_restaurants', 'administrative', 1, 0, 0, 1, 1, 1, 5, 0),
(76, '{\"es\":\"Crear\",\"en\":\"Create\"}', '{menu_categories_create}', 'menu_categories', 'administrative', 1, 0, 0, 1, 1, 1, 1, 0),
(77, '{\"es\":\"Editar\",\"en\":\"Update\"}', '{menu_categories_update}', 'menu_categories', 'administrative', 1, 0, 0, 1, 1, 1, 2, 0),
(78, '{\"es\":\"Desactivar\",\"en\":\"Deactivate\"}', '{menu_categories_deactivate}', 'menu_categories', 'administrative', 1, 0, 0, 1, 1, 1, 3, 0),
(79, '{\"es\":\"Activar\",\"en\":\"Activate\"}', '{menu_categories_activate}', 'menu_categories', 'administrative', 1, 0, 0, 1, 1, 1, 4, 0),
(80, '{\"es\":\"Eliminar\",\"en\":\"Delete\"}', '{menu_categories_delete}', 'menu_categories', 'administrative', 1, 0, 0, 1, 1, 1, 5, 0),
(81, '{\"es\":\"Crear\",\"en\":\"Create\"}', '{menu_topics_create}', 'menu_topics', 'administrative', 1, 0, 0, 1, 1, 1, 1, 0),
(82, '{\"es\":\"Editar\",\"en\":\"Update\"}', '{menu_topics_update}', 'menu_topics', 'administrative', 1, 0, 0, 1, 1, 1, 2, 0),
(83, '{\"es\":\"Desactivar\",\"en\":\"Deactivate\"}', '{menu_topics_deactivate}', 'menu_topics', 'administrative', 1, 0, 0, 1, 1, 1, 3, 0),
(84, '{\"es\":\"Activar\",\"en\":\"Activate\"}', '{menu_topics_activate}', 'menu_topics', 'administrative', 1, 0, 0, 1, 1, 1, 4, 0),
(85, '{\"es\":\"Eliminar\",\"en\":\"Delete\"}', '{menu_topics_delete}', 'menu_topics', 'administrative', 1, 0, 0, 1, 1, 1, 5, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservations_statuses`
--

CREATE TABLE `reservations_statuses` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `name` text NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `reservations_statuses`
--

INSERT INTO `reservations_statuses` (`id`, `account`, `name`, `status`) VALUES
(1, 1, 'En casa', 1),
(2, 1, 'Fuera de casa', 1),
(3, 1, 'Pre llegada', 1),
(4, 1, 'Llegada', 1),
(5, 1, 'Pre salida', 1),
(6, 1, 'Salida', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `surveys_answers`
--

CREATE TABLE `surveys_answers` (
  `id` int(11) NOT NULL,
  `account` bigint(20) NOT NULL,
  `token` char(8) NOT NULL,
  `owner` bigint(20) NOT NULL,
  `values` text NOT NULL,
  `comment` text DEFAULT NULL,
  `reservation` text DEFAULT NULL,
  `date` date NOT NULL,
  `hour` time NOT NULL,
  `public` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `surveys_answers`
--

INSERT INTO `surveys_answers` (`id`, `account`, `token`, `owner`, `values`, `comment`, `reservation`, `date`, `hour`, `public`) VALUES
(3, 1, '6aupgjs1', 6, '{\"8\":\"5\",\"9\":\"yes\",\"10\":[\"kU6m9O\\u00d16\",\"3kkf1Ix5\",\"EB3t1Q07\",\"\\u00d1z4AAkYp\"],\"11\":\"Mi respuesta\"}', ' Mis comentarios', '{\"status\":\"success\",\"firstname\":\"\",\"lastname\":\"\",\"guest_id\":\"\",\"reservation_number\":\"\",\"check_in\":\"\",\"check_out\":\"\",\"nationality\":\"\",\"input_channel\":\"\",\"traveler_type\":\"\",\"age_group\":\"\"}', '2021-02-11', '11:11:03', 0),
(4, 2, 'rnwmfjhj', 1, '{\"12\":\"5\",\"13\":\"yes\",\"14\":[\"ncu9d7XF\",\"LC8ljj\\u00d1q\"],\"15\":\"Mi respuesta\"}', 'Mis comentarios', NULL, '2021-02-13', '17:55:18', 0),
(5, 2, 'jaakm5n9', 1, '{\"12\":\"5\",\"13\":\"yes\",\"14\":[\"ncu9d7XF\",\"LC8ljj\\u00d1q\"],\"15\":\"Mi respuesta\"}', 'Mis comentarios', NULL, '2021-02-13', '17:59:29', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `surveys_questions`
--

CREATE TABLE `surveys_questions` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) DEFAULT NULL,
  `name` text NOT NULL,
  `type` enum('nps','open','rate','twin','check') NOT NULL,
  `values` text DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `system` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `surveys_questions`
--

INSERT INTO `surveys_questions` (`id`, `account`, `name`, `type`, `values`, `parent`, `system`, `status`) VALUES
(8, 1, '{\"es\":\"Pregunta 1\",\"en\":\"Question 1\"}', 'rate', NULL, NULL, 0, 1),
(9, 1, '{\"es\":\"Pregunta 2\",\"en\":\"Question 2\"}', 'twin', NULL, NULL, 0, 1),
(10, 1, '{\"es\":\"Pregunta 3\",\"en\":\"Question 3\"}', 'check', '[{\"token\":\"kU6m9O\\u00d16\",\"es\":\"Valor 1\",\"en\":\"Value 1\"},{\"token\":\"3kkf1Ix5\",\"es\":\"Valor 2\",\"en\":\"Value 2\"},{\"token\":\"EB3t1Q07\",\"es\":\"Valor 3\",\"en\":\"Value 3\"},{\"token\":\"\\u00d1z4AAkYp\",\"es\":\"Valor 4\",\"en\":\"Value 4\"}]', NULL, 0, 1),
(11, 1, '{\"es\":\"Pregunta 4\",\"en\":\"Question 4\"}', 'open', NULL, NULL, 0, 1),
(12, 2, '{\"es\":\"Pregunta 1\",\"en\":\"Question 1\"}', 'rate', NULL, NULL, 0, 1),
(13, 2, '{\"es\":\"Pregunta 2\",\"en\":\"Question 2\"}', 'twin', NULL, NULL, 0, 1),
(14, 2, '{\"es\":\"Pregunta 3\",\"en\":\"Question 3\"}', 'check', '[{\"token\":\"ncu9d7XF\",\"es\":\"Valor 1\",\"en\":\"Value 1\"},{\"token\":\"LC8ljj\\u00d1q\",\"es\":\"Valor 2\",\"en\":\"Value 2\"}]', NULL, 0, 1),
(15, 2, '{\"es\":\"Pregunta 4\",\"en\":\"Question 4\"}', 'open', NULL, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `times_zones`
--

CREATE TABLE `times_zones` (
  `id` bigint(20) NOT NULL,
  `code` text NOT NULL,
  `zone` enum('america','africa','antarctica','artic','asia','atlantic','australia','europe','indian','pacific') NOT NULL,
  `priority` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `times_zones`
--

INSERT INTO `times_zones` (`id`, `code`, `zone`, `priority`) VALUES
(1, 'America/Adak', 'america', NULL),
(2, 'America/Anchorage', 'america', NULL),
(3, 'America/Anguilla', 'america', NULL),
(4, 'America/Antigua', 'america', NULL),
(5, 'America/Araguaina', 'america', NULL),
(6, 'America/Argentina/Buenos_Aires', 'america', NULL),
(7, 'America/Argentina/Catamarca', 'america', NULL),
(8, 'America/Argentina/Cordoba', 'america', NULL),
(9, 'America/Argentina/Jujuy', 'america', NULL),
(10, 'America/Argentina/La_Rioja', 'america', NULL),
(11, 'America/Argentina/Mendoza', 'america', NULL),
(12, 'America/Argentina/Rio_Gallegos', 'america', NULL),
(13, 'America/Argentina/Salta', 'america', NULL),
(14, 'America/Argentina/San_Juan', 'america', NULL),
(15, 'America/Argentina/San_Luis', 'america', NULL),
(16, 'America/Argentina/Tucuman', 'america', NULL),
(17, 'America/Argentina/Ushuaia', 'america', NULL),
(18, 'America/Aruba', 'america', NULL),
(19, 'America/Asuncion', 'america', NULL),
(20, 'America/Atikokan', 'america', NULL),
(21, 'America/Bahia', 'america', NULL),
(22, 'America/Bahia_Banderas', 'america', NULL),
(23, 'America/Barbados', 'america', NULL),
(24, 'America/Belem', 'america', NULL),
(25, 'America/Belize', 'america', NULL),
(26, 'America/Blanc-Sablon', 'america', NULL),
(27, 'America/Boa_Vista', 'america', NULL),
(28, 'America/Bogota', 'america', NULL),
(29, 'America/Boise', 'america', NULL),
(30, 'America/Cambridge_Bay', 'america', NULL),
(31, 'America/Campo_Grande', 'america', NULL),
(32, 'America/Cancun', 'america', 1),
(33, 'America/Caracas', 'america', NULL),
(34, 'America/Cayenne', 'america', NULL),
(35, 'America/Cayman', 'america', NULL),
(36, 'America/Chicago', 'america', NULL),
(37, 'America/Chihuahua', 'america', 5),
(38, 'America/Costa_Rica', 'america', NULL),
(39, 'America/Creston', 'america', NULL),
(40, 'America/Cuiaba', 'america', NULL),
(41, 'America/Curacao', 'america', NULL),
(42, 'America/Danmarkshavn', 'america', NULL),
(43, 'America/Dawson', 'america', NULL),
(44, 'America/Dawson_Creek', 'america', NULL),
(45, 'America/Denver', 'america', NULL),
(46, 'America/Detroit', 'america', NULL),
(47, 'America/Dominica', 'america', NULL),
(48, 'America/Edmonton', 'america', NULL),
(49, 'America/Eirunepe', 'america', NULL),
(50, 'America/El_Salvador', 'america', NULL),
(51, 'America/Fort_Nelson', 'america', NULL),
(52, 'America/Fortaleza', 'america', NULL),
(53, 'America/Glace_Bay', 'america', NULL),
(54, 'America/Godthab', 'america', NULL),
(55, 'America/Goose_Bay', 'america', NULL),
(56, 'America/Grand_Turk', 'america', NULL),
(57, 'America/Grenada', 'america', NULL),
(58, 'America/Guadeloupe', 'america', NULL),
(59, 'America/Guatemala', 'america', NULL),
(60, 'America/Guayaquil', 'america', NULL),
(61, 'America/Guyana', 'america', NULL),
(62, 'America/Halifax', 'america', NULL),
(63, 'America/Havana', 'america', NULL),
(64, 'America/Hermosillo', 'america', 6),
(65, 'America/Indiana/Indianapolis', 'america', NULL),
(66, 'America/Indiana/Knox', 'america', NULL),
(67, 'America/Indiana/Marengo', 'america', NULL),
(68, 'America/Indiana/Petersburg', 'america', NULL),
(69, 'America/Indiana/Tell_City', 'america', NULL),
(70, 'America/Indiana/Vevay', 'america', NULL),
(71, 'America/Indiana/Vincennes', 'america', NULL),
(72, 'America/Indiana/Winamac', 'america', NULL),
(73, 'America/Inuvik', 'america', NULL),
(74, 'America/Iqaluit', 'america', NULL),
(75, 'America/Jamaica', 'america', NULL),
(76, 'America/Juneau', 'america', NULL),
(77, 'America/Kentucky/Louisville', 'america', NULL),
(78, 'America/Kentucky/Monticello', 'america', NULL),
(79, 'America/Kralendijk', 'america', NULL),
(80, 'America/La_Paz', 'america', 7),
(81, 'America/Lima', 'america', NULL),
(82, 'America/Los_Angeles', 'america', NULL),
(83, 'America/Lower_Princes', 'america', NULL),
(84, 'America/Maceio', 'america', NULL),
(85, 'America/Managua', 'america', NULL),
(86, 'America/Manaus', 'america', NULL),
(87, 'America/Marigot', 'america', NULL),
(88, 'America/Martinique', 'america', NULL),
(89, 'America/Matamoros', 'america', 8),
(90, 'America/Mazatlan', 'america', 9),
(91, 'America/Menominee', 'america', NULL),
(92, 'America/Merida', 'america', 10),
(93, 'America/Metlakatla', 'america', NULL),
(94, 'America/Mexico_City', 'america', 2),
(95, 'America/Miquelon', 'america', NULL),
(96, 'America/Moncton', 'america', NULL),
(97, 'America/Monterrey', 'america', 3),
(98, 'America/Montevideo', 'america', NULL),
(99, 'America/Montserrat', 'america', NULL),
(100, 'America/Nassau', 'america', NULL),
(101, 'America/New_York', 'america', NULL),
(102, 'America/Nipigon', 'america', NULL),
(103, 'America/Nome', 'america', NULL),
(104, 'America/Noronha', 'america', NULL),
(105, 'America/North_Dakota/Beulah', 'america', NULL),
(106, 'America/North_Dakota/Center', 'america', NULL),
(107, 'America/North_Dakota/New_Salem', 'america', NULL),
(108, 'America/Ojinaga', 'america', NULL),
(109, 'America/Panama', 'america', NULL),
(110, 'America/Pangnirtung', 'america', NULL),
(111, 'America/Paramaribo', 'america', NULL),
(112, 'America/Phoenix', 'america', NULL),
(113, 'America/Port-au-Prince', 'america', NULL),
(114, 'America/Port_of_Spain', 'america', NULL),
(115, 'America/Porto_Velho', 'america', NULL),
(116, 'America/Puerto_Rico', 'america', NULL),
(117, 'America/Punta_Arenas', 'america', NULL),
(118, 'America/Rainy_River', 'america', NULL),
(119, 'America/Rankin_Inlet', 'america', NULL),
(120, 'America/Recife', 'america', NULL),
(121, 'America/Regina', 'america', NULL),
(122, 'America/Resolute', 'america', NULL),
(123, 'America/Rio_Branco', 'america', NULL),
(124, 'America/Santarem', 'america', NULL),
(125, 'America/Santiago', 'america', NULL),
(126, 'America/Santo_Domingo', 'america', NULL),
(127, 'America/Sao_Paulo', 'america', NULL),
(128, 'America/Scoresbysund', 'america', NULL),
(129, 'America/Sitka', 'america', NULL),
(130, 'America/St_Barthelemy', 'america', NULL),
(131, 'America/St_Johns', 'america', NULL),
(132, 'America/St_Kitts', 'america', NULL),
(133, 'America/St_Lucia', 'america', NULL),
(134, 'America/St_Thomas', 'america', NULL),
(135, 'America/St_Vincent', 'america', NULL),
(136, 'America/Swift_Current', 'america', NULL),
(137, 'America/Tegucigalpa', 'america', NULL),
(138, 'America/Thule', 'america', NULL),
(139, 'America/Thunder_Bay', 'america', NULL),
(140, 'America/Tijuana', 'america', 4),
(141, 'America/Toronto', 'america', NULL),
(142, 'America/Tortola', 'america', NULL),
(143, 'America/Vancouver', 'america', NULL),
(144, 'America/Whitehorse', 'america', NULL),
(145, 'America/Winnipeg', 'america', NULL),
(146, 'America/Yakutat', 'america', NULL),
(147, 'America/Yellowknife', 'america', NULL),
(148, 'Africa/Abidjan', 'africa', NULL),
(149, 'Africa/Accra', 'africa', NULL),
(150, 'Africa/Addis_Ababa', 'africa', NULL),
(151, 'Africa/Algiers', 'africa', NULL),
(152, 'Africa/Asmara', 'africa', NULL),
(153, 'Africa/Bamako', 'africa', NULL),
(154, 'Africa/Bangui', 'africa', NULL),
(155, 'Africa/Banjul', 'africa', NULL),
(156, 'Africa/Bissau', 'africa', NULL),
(157, 'Africa/Blantyre', 'africa', NULL),
(158, 'Africa/Brazzaville', 'africa', NULL),
(159, 'Africa/Bujumbura', 'africa', NULL),
(160, 'Africa/Cairo', 'africa', NULL),
(161, 'Africa/Casablanca', 'africa', NULL),
(162, 'Africa/Ceuta', 'africa', NULL),
(163, 'Africa/Conakry', 'africa', NULL),
(164, 'Africa/Dakar', 'africa', NULL),
(165, 'Africa/Dar_es_Salaam', 'africa', NULL),
(166, 'Africa/Djibouti', 'africa', NULL),
(167, 'Africa/Douala', 'africa', NULL),
(168, 'Africa/El_Aaiun', 'africa', NULL),
(169, 'Africa/Freetown', 'africa', NULL),
(170, 'Africa/Gaborone', 'africa', NULL),
(171, 'Africa/Harare', 'africa', NULL),
(172, 'Africa/Johannesburg', 'africa', NULL),
(173, 'Africa/Juba', 'africa', NULL),
(174, 'Africa/Kampala', 'africa', NULL),
(175, 'Africa/Khartoum', 'africa', NULL),
(176, 'Africa/Kigali', 'africa', NULL),
(177, 'Africa/Kinshasa', 'africa', NULL),
(178, 'Africa/Lagos', 'africa', NULL),
(179, 'Africa/Libreville', 'africa', NULL),
(180, 'Africa/Lome', 'africa', NULL),
(181, 'Africa/Luanda', 'africa', NULL),
(182, 'Africa/Lubumbashi', 'africa', NULL),
(183, 'Africa/Lusaka', 'africa', NULL),
(184, 'Africa/Malabo', 'africa', NULL),
(185, 'Africa/Maputo', 'africa', NULL),
(186, 'Africa/Maseru', 'africa', NULL),
(187, 'Africa/Mbabane', 'africa', NULL),
(188, 'Africa/Mogadishu', 'africa', NULL),
(189, 'Africa/Monrovia', 'africa', NULL),
(190, 'Africa/Nairobi', 'africa', NULL),
(191, 'Africa/Ndjamena', 'africa', NULL),
(192, 'Africa/Niamey', 'africa', NULL),
(193, 'Africa/Nouakchott', 'africa', NULL),
(194, 'Africa/Ouagadougou', 'africa', NULL),
(195, 'Africa/Porto-Novo', 'africa', NULL),
(196, 'Africa/Sao_Tome', 'africa', NULL),
(197, 'Africa/Tripoli', 'africa', NULL),
(198, 'Africa/Tunis', 'africa', NULL),
(199, 'Africa/Windhoek', 'africa', NULL),
(200, 'Antarctica/Casey', 'antarctica', NULL),
(201, 'Antarctica/Davis', 'antarctica', NULL),
(202, 'Antarctica/DumontDUrville', 'antarctica', NULL),
(203, 'Antarctica/Macquarie', 'antarctica', NULL),
(204, 'Antarctica/Mawson', 'antarctica', NULL),
(205, 'Antarctica/McMurdo', 'antarctica', NULL),
(206, 'Antarctica/Palmer', 'antarctica', NULL),
(207, 'Antarctica/Rothera', 'antarctica', NULL),
(208, 'Antarctica/Syowa', 'antarctica', NULL),
(209, 'Antarctica/Troll', 'antarctica', NULL),
(210, 'Antarctica/Vostok', 'antarctica', NULL),
(211, 'Arctic/Longyearbyen', 'artic', NULL),
(212, 'Asia/Aden', 'asia', NULL),
(213, 'Asia/Almaty', 'asia', NULL),
(214, 'Asia/Amman', 'asia', NULL),
(215, 'Asia/Anadyr', 'asia', NULL),
(216, 'Asia/Aqtau', 'asia', NULL),
(217, 'Asia/Aqtobe', 'asia', NULL),
(218, 'Asia/Ashgabat', 'asia', NULL),
(219, 'Asia/Atyrau', 'asia', NULL),
(220, 'Asia/Baghdad', 'asia', NULL),
(221, 'Asia/Bahrain', 'asia', NULL),
(222, 'Asia/Baku', 'asia', NULL),
(223, 'Asia/Bangkok', 'asia', NULL),
(224, 'Asia/Barnaul', 'asia', NULL),
(225, 'Asia/Beirut', 'asia', NULL),
(226, 'Asia/Bishkek', 'asia', NULL),
(227, 'Asia/Brunei', 'asia', NULL),
(228, 'Asia/Chita', 'asia', NULL),
(229, 'Asia/Choibalsan', 'asia', NULL),
(230, 'Asia/Colombo', 'asia', NULL),
(231, 'Asia/Damascus', 'asia', NULL),
(232, 'Asia/Dhaka', 'asia', NULL),
(233, 'Asia/Dili', 'asia', NULL),
(234, 'Asia/Dubai', 'asia', NULL),
(235, 'Asia/Dushanbe', 'asia', NULL),
(236, 'Asia/Famagusta', 'asia', NULL),
(237, 'Asia/Gaza', 'asia', NULL),
(238, 'Asia/Hebron', 'asia', NULL),
(239, 'Asia/Ho_Chi_Minh', 'asia', NULL),
(240, 'Asia/Hong_Kong', 'asia', NULL),
(241, 'Asia/Hovd', 'asia', NULL),
(242, 'Asia/Irkutsk', 'asia', NULL),
(243, 'Asia/Jakarta', 'asia', NULL),
(244, 'Asia/Jayapura', 'asia', NULL),
(245, 'Asia/Jerusalem', 'asia', NULL),
(246, 'Asia/Kabul', 'asia', NULL),
(247, 'Asia/Kamchatka', 'asia', NULL),
(248, 'Asia/Karachi', 'asia', NULL),
(249, 'Asia/Kathmandu', 'asia', NULL),
(250, 'Asia/Khandyga', 'asia', NULL),
(251, 'Asia/Kolkata', 'asia', NULL),
(252, 'Asia/Krasnoyarsk', 'asia', NULL),
(253, 'Asia/Kuala_Lumpur', 'asia', NULL),
(254, 'Asia/Kuching', 'asia', NULL),
(255, 'Asia/Kuwait', 'asia', NULL),
(256, 'Asia/Macau', 'asia', NULL),
(257, 'Asia/Magadan', 'asia', NULL),
(258, 'Asia/Makassar', 'asia', NULL),
(259, 'Asia/Manila', 'asia', NULL),
(260, 'Asia/Muscat', 'asia', NULL),
(261, 'Asia/Nicosia', 'asia', NULL),
(262, 'Asia/Novokuznetsk', 'asia', NULL),
(263, 'Asia/Novosibirsk', 'asia', NULL),
(264, 'Asia/Omsk', 'asia', NULL),
(265, 'Asia/Oral', 'asia', NULL),
(266, 'Asia/Phnom_Penh', 'asia', NULL),
(267, 'Asia/Pontianak', 'asia', NULL),
(268, 'Asia/Pyongyang', 'asia', NULL),
(269, 'Asia/Qatar', 'asia', NULL),
(270, 'Asia/Qyzylorda', 'asia', NULL),
(271, 'Asia/Riyadh', 'asia', NULL),
(272, 'Asia/Sakhalin', 'asia', NULL),
(273, 'Asia/Samarkand', 'asia', NULL),
(274, 'Asia/Seoul', 'asia', NULL),
(275, 'Asia/Shanghai', 'asia', NULL),
(276, 'Asia/Singapore', 'asia', NULL),
(277, 'Asia/Srednekolymsk', 'asia', NULL),
(278, 'Asia/Taipei', 'asia', NULL),
(279, 'Asia/Tashkent', 'asia', NULL),
(280, 'Asia/Tbilisi', 'asia', NULL),
(281, 'Asia/Tehran', 'asia', NULL),
(282, 'Asia/Thimphu', 'asia', NULL),
(283, 'Asia/Tokyo', 'asia', NULL),
(284, 'Asia/Tomsk', 'asia', NULL),
(285, 'Asia/Ulaanbaatar', 'asia', NULL),
(286, 'Asia/Urumqi', 'asia', NULL),
(287, 'Asia/Ust-Nera', 'asia', NULL),
(288, 'Asia/Vientiane', 'asia', NULL),
(289, 'Asia/Vladivostok', 'asia', NULL),
(290, 'Asia/Yakutsk', 'asia', NULL),
(291, 'Asia/Yangon', 'asia', NULL),
(292, 'Asia/Yekaterinburg', 'asia', NULL),
(293, 'Asia/Yerevan', 'asia', NULL),
(294, 'Atlantic/Azores', 'atlantic', NULL),
(295, 'Atlantic/Bermuda', 'atlantic', NULL),
(296, 'Atlantic/Canary', 'atlantic', NULL),
(297, 'Atlantic/Cape_Verde', 'atlantic', NULL),
(298, 'Atlantic/Faroe', 'atlantic', NULL),
(299, 'Atlantic/Madeira', 'atlantic', NULL),
(300, 'Atlantic/Reykjavik', 'atlantic', NULL),
(301, 'Atlantic/South_Georgia', 'atlantic', NULL),
(302, 'Atlantic/St_Helena', 'atlantic', NULL),
(303, 'Atlantic/Stanley', 'atlantic', NULL),
(304, 'Australia/Adelaide', 'australia', NULL),
(305, 'Australia/Brisbane', 'australia', NULL),
(306, 'Australia/Broken_Hill', 'australia', NULL),
(307, 'Australia/Currie', 'australia', NULL),
(308, 'Australia/Darwin', 'australia', NULL),
(309, 'Australia/Eucla', 'australia', NULL),
(310, 'Australia/Hobart', 'australia', NULL),
(311, 'Australia/Lindeman', 'australia', NULL),
(312, 'Australia/Lord_Howe', 'australia', NULL),
(313, 'Australia/Melbourne', 'australia', NULL),
(314, 'Australia/Perth', 'australia', NULL),
(315, 'Australia/Sydney', 'australia', NULL),
(316, 'Europe/Amsterdam', 'europe', NULL),
(317, 'Europe/Andorra', 'europe', NULL),
(318, 'Europe/Astrakhan', 'europe', NULL),
(319, 'Europe/Athens', 'europe', NULL),
(320, 'Europe/Belgrade', 'europe', NULL),
(321, 'Europe/Berlin', 'europe', NULL),
(322, 'Europe/Bratislava', 'europe', NULL),
(323, 'Europe/Brussels', 'europe', NULL),
(324, 'Europe/Bucharest', 'europe', NULL),
(325, 'Europe/Budapest', 'europe', NULL),
(326, 'Europe/Busingen', 'europe', NULL),
(327, 'Europe/Chisinau', 'europe', NULL),
(328, 'Europe/Copenhagen', 'europe', NULL),
(329, 'Europe/Dublin', 'europe', NULL),
(330, 'Europe/Gibraltar', 'europe', NULL),
(331, 'Europe/Guernsey', 'europe', NULL),
(332, 'Europe/Helsinki', 'europe', NULL),
(333, 'Europe/Isle_of_Man', 'europe', NULL),
(334, 'Europe/Istanbul', 'europe', NULL),
(335, 'Europe/Jersey', 'europe', NULL),
(336, 'Europe/Kaliningrad', 'europe', NULL),
(337, 'Europe/Kiev', 'europe', NULL),
(338, 'Europe/Kirov', 'europe', NULL),
(339, 'Europe/Lisbon', 'europe', NULL),
(340, 'Europe/Ljubljana', 'europe', NULL),
(341, 'Europe/London', 'europe', NULL),
(342, 'Europe/Luxembourg', 'europe', NULL),
(343, 'Europe/Madrid', 'europe', NULL),
(344, 'Europe/Malta', 'europe', NULL),
(345, 'Europe/Mariehamn', 'europe', NULL),
(346, 'Europe/Minsk', 'europe', NULL),
(347, 'Europe/Monaco', 'europe', NULL),
(348, 'Europe/Moscow', 'europe', NULL),
(349, 'Europe/Oslo', 'europe', NULL),
(350, 'Europe/Paris', 'europe', NULL),
(351, 'Europe/Podgorica', 'europe', NULL),
(352, 'Europe/Prague', 'europe', NULL),
(353, 'Europe/Riga', 'europe', NULL),
(354, 'Europe/Rome', 'europe', NULL),
(355, 'Europe/Samara', 'europe', NULL),
(356, 'Europe/San_Marino', 'europe', NULL),
(357, 'Europe/Sarajevo', 'europe', NULL),
(358, 'Europe/Saratov', 'europe', NULL),
(359, 'Europe/Simferopol', 'europe', NULL),
(360, 'Europe/Skopje', 'europe', NULL),
(361, 'Europe/Sofia', 'europe', NULL),
(362, 'Europe/Stockholm', 'europe', NULL),
(363, 'Europe/Tallinn', 'europe', NULL),
(364, 'Europe/Tirane', 'europe', NULL),
(365, 'Europe/Ulyanovsk', 'europe', NULL),
(366, 'Europe/Uzhgorod', 'europe', NULL),
(367, 'Europe/Vaduz', 'europe', NULL),
(368, 'Europe/Vatican', 'europe', NULL),
(369, 'Europe/Vienna', 'europe', NULL),
(370, 'Europe/Vilnius', 'europe', NULL),
(371, 'Europe/Volgograd', 'europe', NULL),
(372, 'Europe/Warsaw', 'europe', NULL),
(373, 'Europe/Zagreb', 'europe', NULL),
(374, 'Europe/Zaporozhye', 'europe', NULL),
(375, 'Europe/Zurich', 'europe', NULL),
(376, 'Indian/Antananarivo', 'indian', NULL),
(377, 'Indian/Chagos', 'indian', NULL),
(378, 'Indian/Christmas', 'indian', NULL),
(379, 'Indian/Cocos', 'indian', NULL),
(380, 'Indian/Comoro', 'indian', NULL),
(381, 'Indian/Kerguelen', 'indian', NULL),
(382, 'Indian/Mahe', 'indian', NULL),
(383, 'Indian/Maldives', 'indian', NULL),
(384, 'Indian/Mauritius', 'indian', NULL),
(385, 'Indian/Mayotte', 'indian', NULL),
(386, 'Indian/Reunion', 'indian', NULL),
(387, 'Pacific/Apia', 'pacific', NULL),
(388, 'Pacific/Auckland', 'pacific', NULL),
(389, 'Pacific/Bougainville', 'pacific', NULL),
(390, 'Pacific/Chatham', 'pacific', NULL),
(391, 'Pacific/Chuuk', 'pacific', NULL),
(392, 'Pacific/Easter', 'pacific', NULL),
(393, 'Pacific/Efate', 'pacific', NULL),
(394, 'Pacific/Enderbury', 'pacific', NULL),
(395, 'Pacific/Fakaofo', 'pacific', NULL),
(396, 'Pacific/Fiji', 'pacific', NULL),
(397, 'Pacific/Funafuti', 'pacific', NULL),
(398, 'Pacific/Galapagos', 'pacific', NULL),
(399, 'Pacific/Gambier', 'pacific', NULL),
(400, 'Pacific/Guadalcanal', 'pacific', NULL),
(401, 'Pacific/Guam', 'pacific', NULL),
(402, 'Pacific/Honolulu', 'pacific', NULL),
(403, 'Pacific/Kiritimati', 'pacific', NULL),
(404, 'Pacific/Kosrae', 'pacific', NULL),
(405, 'Pacific/Kwajalein', 'pacific', NULL),
(406, 'Pacific/Majuro', 'pacific', NULL),
(407, 'Pacific/Marquesas', 'pacific', NULL),
(408, 'Pacific/Midway', 'pacific', NULL),
(409, 'Pacific/Nauru', 'pacific', NULL),
(410, 'Pacific/Niue', 'pacific', NULL),
(411, 'Pacific/Norfolk', 'pacific', NULL),
(412, 'Pacific/Noumea', 'pacific', NULL),
(413, 'Pacific/Pago_Pago', 'pacific', NULL),
(414, 'Pacific/Palau', 'pacific', NULL),
(415, 'Pacific/Pitcairn', 'pacific', NULL),
(416, 'Pacific/Pohnpei', 'pacific', NULL),
(417, 'Pacific/Port_Moresby', 'pacific', NULL),
(418, 'Pacific/Rarotonga', 'pacific', NULL),
(419, 'Pacific/Saipan', 'pacific', NULL),
(420, 'Pacific/Tahiti', 'pacific', NULL),
(421, 'Pacific/Tarawa', 'pacific', NULL),
(422, 'Pacific/Tongatapu', 'pacific', NULL),
(423, 'Pacific/Wake', 'pacific', NULL),
(424, 'Pacific/Wallis', 'pacific', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `username` text NOT NULL,
  `password` varchar(120) NOT NULL,
  `permissions` longtext NOT NULL,
  `opportunity_areas` longtext DEFAULT NULL,
  `whatsapp` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `account`, `firstname`, `lastname`, `email`, `phone`, `avatar`, `username`, `password`, `permissions`, `opportunity_areas`, `whatsapp`, `status`) VALUES
(1, 1, 'Demo', 'Hotel', 'demo@guestvox.com', '{\"lada\":\"52\",\"number\":\"9981579343\"}', NULL, 'demo_hotel', '9e72f3df668320dc1130db0e20f4dab208fd881c:o9aJxkPEmJsjWrBYW9nGzTu0KTLfxxSDI4Sr0m9iqffGGf0a1F6i98eGdr3HLiaI', '[\"17\",\"18\",\"4\",\"10\",\"11\",\"65\",\"39\",\"40\",\"41\",\"42\",\"43\",\"44\",\"45\",\"46\",\"47\",\"48\",\"34\",\"35\",\"36\",\"37\",\"38\",\"76\",\"77\",\"78\",\"79\",\"80\",\"66\",\"67\",\"68\",\"69\",\"70\",\"71\",\"72\",\"73\",\"74\",\"75\",\"81\",\"82\",\"83\",\"84\",\"85\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"19\",\"20\",\"21\",\"22\",\"23\",\"49\",\"50\",\"51\",\"52\",\"53\",\"12\",\"13\",\"14\",\"15\",\"16\",\"59\",\"60\",\"61\",\"62\",\"63\",\"64\",\"54\",\"55\",\"56\",\"57\",\"58\",\"5\",\"6\",\"7\",\"8\",\"9\",\"1\"]', '[]', 0, 1),
(2, 2, 'Demo', 'Restaurante', 'test@guestvox.com', '{\"lada\":\"52\",\"number\":\"9981579343\"}', NULL, 'demo_restaurante', '9e72f3df668320dc1130db0e20f4dab208fd881c:o9aJxkPEmJsjWrBYW9nGzTu0KTLfxxSDI4Sr0m9iqffGGf0a1F6i98eGdr3HLiaI', '[\"17\",\"18\",\"4\",\"10\",\"11\",\"65\",\"39\",\"40\",\"41\",\"42\",\"43\",\"44\",\"45\",\"46\",\"47\",\"48\",\"34\",\"35\",\"36\",\"37\",\"38\",\"76\",\"77\",\"78\",\"79\",\"80\",\"66\",\"67\",\"68\",\"69\",\"70\",\"71\",\"72\",\"73\",\"74\",\"75\",\"81\",\"82\",\"83\",\"84\",\"85\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"19\",\"20\",\"21\",\"22\",\"23\",\"49\",\"50\",\"51\",\"52\",\"53\",\"12\",\"13\",\"14\",\"15\",\"16\",\"59\",\"60\",\"61\",\"62\",\"63\",\"64\",\"54\",\"55\",\"56\",\"57\",\"58\",\"5\",\"6\",\"7\",\"8\",\"9\",\"1\"]', '[]', 1, 1),
(4, 4, 'Demo', 'Otros', 'test@guestvox.com', '{\"lada\":\"52\",\"number\":\"9981579343\"}', NULL, 'demo_otros', '9e72f3df668320dc1130db0e20f4dab208fd881c:o9aJxkPEmJsjWrBYW9nGzTu0KTLfxxSDI4Sr0m9iqffGGf0a1F6i98eGdr3HLiaI', '[\"17\",\"18\",\"4\",\"10\",\"11\",\"65\",\"39\",\"40\",\"41\",\"42\",\"43\",\"44\",\"45\",\"46\",\"47\",\"48\",\"34\",\"35\",\"36\",\"37\",\"38\",\"76\",\"77\",\"78\",\"79\",\"80\",\"66\",\"67\",\"68\",\"69\",\"70\",\"71\",\"72\",\"73\",\"74\",\"75\",\"81\",\"82\",\"83\",\"84\",\"85\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"19\",\"20\",\"21\",\"22\",\"23\",\"49\",\"50\",\"51\",\"52\",\"53\",\"12\",\"13\",\"14\",\"15\",\"16\",\"59\",\"60\",\"61\",\"62\",\"63\",\"64\",\"54\",\"55\",\"56\",\"57\",\"58\",\"5\",\"6\",\"7\",\"8\",\"9\",\"1\"]', '[]', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_levels`
--

CREATE TABLE `users_levels` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `name` text NOT NULL,
  `permissions` longtext NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users_levels`
--

INSERT INTO `users_levels` (`id`, `account`, `name`, `permissions`, `status`) VALUES
(1, 1, 'Administrador', '[\"17\",\"18\",\"4\",\"10\",\"11\",\"65\",\"39\",\"40\",\"41\",\"42\",\"43\",\"44\",\"45\",\"46\",\"47\",\"48\",\"34\",\"35\",\"36\",\"37\",\"38\",\"76\",\"77\",\"78\",\"79\",\"80\",\"66\",\"67\",\"68\",\"69\",\"70\",\"71\",\"72\",\"73\",\"74\",\"75\",\"81\",\"82\",\"83\",\"84\",\"85\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"19\",\"20\",\"21\",\"22\",\"23\",\"49\",\"50\",\"51\",\"52\",\"53\",\"12\",\"13\",\"14\",\"15\",\"16\",\"59\",\"60\",\"61\",\"62\",\"63\",\"64\",\"54\",\"55\",\"56\",\"57\",\"58\",\"5\",\"6\",\"7\",\"8\",\"9\",\"1\"]', 1),
(2, 1, 'Director', '[\"17\",\"18\",\"4\",\"10\",\"11\",\"5\",\"6\",\"7\",\"8\",\"9\",\"1\"]', 1),
(4, 1, 'Supervisor', '[\"17\",\"18\",\"10\",\"11\",\"5\",\"6\",\"7\",\"8\",\"9\",\"2\"]', 1),
(6, 2, 'Administrador', '[\"17\",\"18\",\"4\",\"10\",\"11\",\"65\",\"39\",\"40\",\"41\",\"42\",\"43\",\"44\",\"45\",\"46\",\"47\",\"48\",\"34\",\"35\",\"36\",\"37\",\"38\",\"76\",\"77\",\"78\",\"79\",\"80\",\"66\",\"67\",\"68\",\"69\",\"70\",\"71\",\"72\",\"73\",\"74\",\"75\",\"81\",\"82\",\"83\",\"84\",\"85\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"19\",\"20\",\"21\",\"22\",\"23\",\"49\",\"50\",\"51\",\"52\",\"53\",\"12\",\"13\",\"14\",\"15\",\"16\",\"59\",\"60\",\"61\",\"62\",\"63\",\"64\",\"54\",\"55\",\"56\",\"57\",\"58\",\"5\",\"6\",\"7\",\"8\",\"9\",\"1\"]', 1),
(7, 2, 'Director', '[\"17\",\"18\",\"4\",\"10\",\"11\",\"5\",\"6\",\"7\",\"8\",\"9\",\"1\"]', 1),
(8, 2, 'Gerente', '[\"17\",\"18\",\"4\",\"10\",\"11\",\"5\",\"6\",\"7\",\"8\",\"9\",\"2\"]', 1),
(9, 2, 'Supervisor', '[\"17\",\"18\",\"10\",\"11\",\"5\",\"6\",\"7\",\"8\",\"9\",\"2\"]', 1),
(10, 2, 'Operador', '[\"3\"]', 1),
(16, 4, 'Administrador', '[\"17\",\"18\",\"4\",\"10\",\"11\",\"65\",\"39\",\"40\",\"41\",\"42\",\"43\",\"44\",\"45\",\"46\",\"47\",\"48\",\"34\",\"35\",\"36\",\"37\",\"38\",\"76\",\"77\",\"78\",\"79\",\"80\",\"66\",\"67\",\"68\",\"69\",\"70\",\"71\",\"72\",\"73\",\"74\",\"75\",\"81\",\"82\",\"83\",\"84\",\"85\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"19\",\"20\",\"21\",\"22\",\"23\",\"49\",\"50\",\"51\",\"52\",\"53\",\"12\",\"13\",\"14\",\"15\",\"16\",\"59\",\"60\",\"61\",\"62\",\"63\",\"64\",\"54\",\"55\",\"56\",\"57\",\"58\",\"5\",\"6\",\"7\",\"8\",\"9\",\"1\"]', 1),
(17, 4, 'Director', '[\"17\",\"18\",\"4\",\"10\",\"11\",\"5\",\"6\",\"7\",\"8\",\"9\",\"1\"]', 1),
(18, 4, 'Gerente', '[\"17\",\"18\",\"4\",\"10\",\"11\",\"5\",\"6\",\"7\",\"8\",\"9\",\"2\"]', 1),
(19, 4, 'Supervisor', '[\"17\",\"18\",\"10\",\"11\",\"5\",\"6\",\"7\",\"8\",\"9\",\"2\"]', 1),
(20, 4, 'Operador', '[\"3\"]', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `voxes`
--

CREATE TABLE `voxes` (
  `id` bigint(20) NOT NULL,
  `account` bigint(20) NOT NULL,
  `type` enum('request','incident','workorder') NOT NULL DEFAULT 'request',
  `token` char(8) NOT NULL,
  `owner` bigint(20) DEFAULT NULL,
  `opportunity_area` bigint(20) NOT NULL,
  `opportunity_type` bigint(20) NOT NULL,
  `started_date` date DEFAULT NULL,
  `started_hour` time DEFAULT NULL,
  `death_line` date DEFAULT NULL,
  `location` bigint(20) DEFAULT NULL,
  `cost` double DEFAULT NULL,
  `urgency` enum('low','medium','high') NOT NULL,
  `confidentiality` tinyint(1) NOT NULL,
  `assigned_users` text NOT NULL,
  `observations` text DEFAULT NULL,
  `subject` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `action_taken` text DEFAULT NULL,
  `firstname` text DEFAULT NULL,
  `lastname` text DEFAULT NULL,
  `guest_treatment` bigint(20) DEFAULT NULL,
  `guest_id` text DEFAULT NULL,
  `guest_type` bigint(20) DEFAULT NULL,
  `reservation_number` text DEFAULT NULL,
  `reservation_status` bigint(20) DEFAULT NULL,
  `check_in` date DEFAULT NULL,
  `check_out` date DEFAULT NULL,
  `attachments` text NOT NULL,
  `viewed_by` text NOT NULL,
  `comments` text NOT NULL,
  `changes_history` text NOT NULL,
  `created_user` bigint(20) DEFAULT NULL,
  `created_date` date NOT NULL,
  `created_hour` time NOT NULL,
  `edited_user` bigint(20) DEFAULT NULL,
  `edited_date` date DEFAULT NULL,
  `edited_hour` time DEFAULT NULL,
  `completed_user` bigint(20) DEFAULT NULL,
  `completed_date` date DEFAULT NULL,
  `completed_hour` time DEFAULT NULL,
  `reopened_user` bigint(20) DEFAULT NULL,
  `reopened_date` date DEFAULT NULL,
  `reopened_hour` time DEFAULT NULL,
  `automatic_start` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `origin` enum('internal','myvox','api') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `voxes`
--

INSERT INTO `voxes` (`id`, `account`, `type`, `token`, `owner`, `opportunity_area`, `opportunity_type`, `started_date`, `started_hour`, `death_line`, `location`, `cost`, `urgency`, `confidentiality`, `assigned_users`, `observations`, `subject`, `description`, `action_taken`, `firstname`, `lastname`, `guest_treatment`, `guest_id`, `guest_type`, `reservation_number`, `reservation_status`, `check_in`, `check_out`, `attachments`, `viewed_by`, `comments`, `changes_history`, `created_user`, `created_date`, `created_hour`, `edited_user`, `edited_date`, `edited_hour`, `completed_user`, `completed_date`, `completed_hour`, `reopened_user`, `reopened_date`, `reopened_hour`, `automatic_start`, `status`, `origin`) VALUES
(28, 1, 'request', 'jom8uc45', 6, 7, 7, '2021-02-10', '09:01:41', '2021-02-10', 3, NULL, 'medium', 0, '[\"1\"]', 'Mis observaciones', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"status\":\"success\",\"file\":\"royalhotel_vox_attachment_wBsoWDYYKOyGfuQO.docx\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\royalhotel_vox_attachment_wBsoWDYYKOyGfuQO.docx\"},{\"status\":\"success\",\"file\":\"royalhotel_vox_attachment_fc5Z0aYLxyPpIsPi.pdf\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\royalhotel_vox_attachment_fc5Z0aYLxyPpIsPi.pdf\"},{\"status\":\"success\",\"file\":\"royalhotel_vox_attachment_dffq0a9dkG3VtHcS.png\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\royalhotel_vox_attachment_dffq0a9dkG3VtHcS.png\"},{\"status\":\"success\",\"file\":\"royalhotel_vox_attachment_Sc0QzWqUaQeqBHjV.xlsx\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\royalhotel_vox_attachment_Sc0QzWqUaQeqBHjV.xlsx\"}]', '[\"1\"]', '[]', '[{\"type\":\"created\",\"user\":\"1\",\"date\":\"2021-02-10\",\"hour\":\"09:02:35\"},{\"type\":\"viewed\",\"user\":\"1\",\"date\":\"2021-02-10\",\"hour\":\"11:28:32\"}]', 1, '2021-02-10', '09:02:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 'internal'),
(29, 1, 'incident', 'hsxvmlrh', 6, 7, 7, '2021-02-10', '09:04:27', '2021-02-10', 3, 100, 'medium', 1, '[\"1\"]', NULL, 'Mi asunto', 'Mi descripción', 'Mi acción tomada', NULL, NULL, 1, '0987654321', 4, '0987654321', 1, '2021-02-01', '2021-02-28', '[{\"status\":\"success\",\"file\":\"royalhotel_vox_attachment_PFA7br6h7kvvBcW1.docx\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\royalhotel_vox_attachment_PFA7br6h7kvvBcW1.docx\"},{\"status\":\"success\",\"file\":\"royalhotel_vox_attachment_RuWkCE8uQopskT4c.pdf\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\royalhotel_vox_attachment_RuWkCE8uQopskT4c.pdf\"},{\"status\":\"success\",\"file\":\"royalhotel_vox_attachment_3RAUqojeUm9il8Xs.png\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\royalhotel_vox_attachment_3RAUqojeUm9il8Xs.png\"},{\"status\":\"success\",\"file\":\"royalhotel_vox_attachment_YZ22nfDJRZdRfdIT.xlsx\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\royalhotel_vox_attachment_YZ22nfDJRZdRfdIT.xlsx\"}]', '[\"1\"]', '[]', '[{\"type\":\"created\",\"user\":\"1\",\"date\":\"2021-02-10\",\"hour\":\"09:05:50\"},{\"type\":\"viewed\",\"user\":\"1\",\"date\":\"2021-02-10\",\"hour\":\"11:01:50\"}]', 1, '2021-02-10', '09:05:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 'internal'),
(30, 1, 'workorder', 'dmat0lu6', 6, 7, 7, '2021-02-10', '09:06:02', '2021-02-15', 3, 100, 'medium', 0, '[\"1\"]', 'Mis observaciones', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', '[\"1\"]', '[]', '[{\"type\":\"created\",\"user\":\"1\",\"date\":\"2021-02-10\",\"hour\":\"09:08:10\"},{\"type\":\"completed\",\"user\":\"1\",\"date\":\"2021-02-10\",\"hour\":\"10:32:42\"},{\"type\":\"reopened\",\"user\":\"1\",\"date\":\"2021-02-10\",\"hour\":\"10:34:15\"},{\"type\":\"viewed\",\"user\":\"1\",\"date\":\"2021-02-10\",\"hour\":\"11:01:48\"}]', 1, '2021-02-10', '09:08:10', NULL, NULL, NULL, 1, '2021-02-10', '10:32:42', 1, '2021-02-10', '10:34:15', 0, 1, 'internal'),
(31, 1, 'workorder', 'ryjyrsvw', 6, 7, 7, '2021-02-10', '11:00:24', '2021-02-15', 3, 100, 'medium', 0, '[\"1\"]', 'Mis observaciones', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"status\":\"success\",\"file\":\"royalhotel_vox_attachment_ljY1XPTENBZqNOLU.docx\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\royalhotel_vox_attachment_ljY1XPTENBZqNOLU.docx\"},{\"status\":\"success\",\"file\":\"royalhotel_vox_attachment_DRbhlp1enJ748JXO.pdf\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\royalhotel_vox_attachment_DRbhlp1enJ748JXO.pdf\"},{\"status\":\"success\",\"file\":\"royalhotel_vox_attachment_noVWYOF8kFSFiJp9.png\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\royalhotel_vox_attachment_noVWYOF8kFSFiJp9.png\"},{\"status\":\"success\",\"file\":\"royalhotel_vox_attachment_66GhkhQozqUyyqXn.xlsx\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\royalhotel_vox_attachment_66GhkhQozqUyyqXn.xlsx\"}]', '[\"1\"]', '[]', '[{\"type\":\"created\",\"user\":\"1\",\"date\":\"2021-02-10\",\"hour\":\"09:09:07\"},{\"type\":\"commented\",\"user\":\"1\",\"date\":\"2021-02-10\",\"hour\":\"11:00:24\"},{\"type\":\"completed\",\"user\":\"1\",\"date\":\"2021-02-10\",\"hour\":\"11:00:27\"},{\"type\":\"reopened\",\"user\":\"1\",\"date\":\"2021-02-10\",\"hour\":\"11:00:45\"},{\"type\":\"viewed\",\"user\":\"1\",\"date\":\"2021-02-10\",\"hour\":\"11:28:26\"}]', 1, '2021-02-10', '09:09:07', NULL, NULL, NULL, 1, '2021-02-10', '11:00:27', 1, '2021-02-10', '11:00:45', 1, 1, 'internal'),
(32, 1, 'workorder', 'ax3p7z8o', 6, 7, 7, '2021-02-10', '11:07:30', '2021-02-10', 3, NULL, 'medium', 0, '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', '[\"1\"]', '[]', '[{\"type\":\"created\",\"user\":\"1\",\"date\":\"2021-02-10\",\"hour\":\"11:04:37\"},{\"type\":\"completed\",\"user\":\"1\",\"date\":\"2021-02-10\",\"hour\":\"11:07:18\"},{\"type\":\"reopened\",\"user\":\"1\",\"date\":\"2021-02-10\",\"hour\":\"11:07:28\"},{\"type\":\"commented\",\"user\":\"1\",\"date\":\"2021-02-10\",\"hour\":\"11:07:30\"},{\"type\":\"completed\",\"user\":\"1\",\"date\":\"2021-02-10\",\"hour\":\"11:07:36\"},{\"type\":\"reopened\",\"user\":\"1\",\"date\":\"2021-02-10\",\"hour\":\"11:07:40\"},{\"type\":\"viewed\",\"user\":\"1\",\"date\":\"2021-02-10\",\"hour\":\"11:28:28\"}]', 1, '2021-02-10', '11:04:37', NULL, NULL, NULL, 1, '2021-02-10', '11:07:36', 1, '2021-02-10', '11:07:40', 1, 1, 'internal'),
(33, 1, 'request', 'rvbwzvld', 6, 7, 7, '2021-02-11', '11:04:54', NULL, 3, NULL, 'medium', 0, '[]', 'Mis observaciones', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', '[]', '[]', '[{\"type\":\"created\",\"user\":null,\"date\":\"2021-02-11\",\"hour\":\"11:05:22\"}]', NULL, '2021-02-11', '11:05:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 'myvox'),
(34, 1, 'incident', 'fkftit8g', 6, 7, 7, '2021-02-11', '11:06:54', NULL, 3, NULL, 'medium', 0, '[]', NULL, NULL, 'Mi descripción', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', '[]', '[]', '[{\"type\":\"created\",\"user\":null,\"date\":\"2021-02-11\",\"hour\":\"11:07:18\"}]', NULL, '2021-02-11', '11:07:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 'myvox'),
(35, 2, 'request', 'ycyuqxxd', 1, 5, 5, '2021-02-13', '17:51:34', NULL, 1, NULL, 'medium', 0, '[]', 'Mis observaciones', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', '[\"2\"]', '[]', '[{\"type\":\"created\",\"user\":null,\"date\":\"2021-02-13\",\"hour\":\"17:52:11\"},{\"type\":\"viewed\",\"user\":\"2\",\"date\":\"2021-02-13\",\"hour\":\"19:57:14\"}]', NULL, '2021-02-13', '17:52:11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 'myvox'),
(36, 2, 'incident', '5ceuvvhz', 1, 5, 5, '2021-02-13', '17:52:49', NULL, 1, NULL, 'medium', 0, '[]', NULL, NULL, 'Mi descripción', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', '[\"2\"]', '[]', '[{\"type\":\"created\",\"user\":null,\"date\":\"2021-02-13\",\"hour\":\"17:53:02\"},{\"type\":\"viewed\",\"user\":\"2\",\"date\":\"2021-02-13\",\"hour\":\"19:57:17\"}]', NULL, '2021-02-13', '17:53:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 'myvox'),
(37, 2, 'request', 'iqupenkl', 1, 5, 5, '2021-02-13', '19:54:37', '2021-02-13', 1, NULL, 'medium', 0, '[\"2\"]', 'Mis observaciones', NULL, NULL, NULL, 'Gersón Aarón', 'Gómez Macías', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"status\":\"success\",\"file\":\"hotrestaurant_vox_attachment_ziTvBrhv2axaCQZS.docx\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\hotrestaurant_vox_attachment_ziTvBrhv2axaCQZS.docx\"},{\"status\":\"success\",\"file\":\"hotrestaurant_vox_attachment_2DbOKAaOfiMlwrTj.pdf\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\hotrestaurant_vox_attachment_2DbOKAaOfiMlwrTj.pdf\"},{\"status\":\"success\",\"file\":\"hotrestaurant_vox_attachment_VwhFhwVlHJG8uQeX.png\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\hotrestaurant_vox_attachment_VwhFhwVlHJG8uQeX.png\"},{\"status\":\"success\",\"file\":\"hotrestaurant_vox_attachment_otBsHLXYvq88OW3V.xlsx\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\hotrestaurant_vox_attachment_otBsHLXYvq88OW3V.xlsx\"}]', '[\"2\"]', '[]', '[{\"type\":\"created\",\"user\":\"2\",\"date\":\"2021-02-13\",\"hour\":\"19:55:13\"},{\"type\":\"viewed\",\"user\":\"2\",\"date\":\"2021-02-13\",\"hour\":\"19:57:23\"}]', 2, '2021-02-13', '19:55:13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 'internal'),
(38, 2, 'incident', 'dwoqw58i', 1, 5, 5, '2021-02-13', '19:55:17', '2021-02-13', 1, 100, 'medium', 1, '[\"2\"]', NULL, 'Mi asunto', 'Mi descripción', 'Mi acción tomada', 'Gersón Aarón', 'Gómez Macías', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"status\":\"success\",\"file\":\"hotrestaurant_vox_attachment_4O1Mk8zr0KUdglru.docx\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\hotrestaurant_vox_attachment_4O1Mk8zr0KUdglru.docx\"},{\"status\":\"success\",\"file\":\"hotrestaurant_vox_attachment_lihfRSv3yqSIOCeZ.pdf\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\hotrestaurant_vox_attachment_lihfRSv3yqSIOCeZ.pdf\"},{\"status\":\"success\",\"file\":\"hotrestaurant_vox_attachment_ySBIBQmMHcdrzAvp.png\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\hotrestaurant_vox_attachment_ySBIBQmMHcdrzAvp.png\"},{\"status\":\"success\",\"file\":\"hotrestaurant_vox_attachment_HmvczEIxAybvGWF1.xlsx\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\hotrestaurant_vox_attachment_HmvczEIxAybvGWF1.xlsx\"}]', '[\"2\"]', '[]', '[{\"type\":\"created\",\"user\":\"2\",\"date\":\"2021-02-13\",\"hour\":\"19:56:00\"},{\"type\":\"viewed\",\"user\":\"2\",\"date\":\"2021-02-13\",\"hour\":\"19:56:01\"}]', 2, '2021-02-13', '19:56:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 'internal'),
(39, 2, 'workorder', 'niyofk8v', 1, 5, 5, '2021-02-13', '19:56:08', '2021-02-13', 1, 100, 'medium', 0, '[\"2\"]', 'Mis observaciones', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"status\":\"success\",\"file\":\"hotrestaurant_vox_attachment_5ZBDzPT7xKDddgns.docx\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\hotrestaurant_vox_attachment_5ZBDzPT7xKDddgns.docx\"},{\"status\":\"success\",\"file\":\"hotrestaurant_vox_attachment_WZJeqscdWSi90na8.pdf\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\hotrestaurant_vox_attachment_WZJeqscdWSi90na8.pdf\"},{\"status\":\"success\",\"file\":\"hotrestaurant_vox_attachment_QhTkuZuY4EqMqKZ3.png\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\hotrestaurant_vox_attachment_QhTkuZuY4EqMqKZ3.png\"},{\"status\":\"success\",\"file\":\"hotrestaurant_vox_attachment_36UqRijpS8QGKSJn.xlsx\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\hotrestaurant_vox_attachment_36UqRijpS8QGKSJn.xlsx\"}]', '[\"2\"]', '[]', '[{\"type\":\"created\",\"user\":\"2\",\"date\":\"2021-02-13\",\"hour\":\"19:56:28\"},{\"type\":\"viewed\",\"user\":\"2\",\"date\":\"2021-02-13\",\"hour\":\"19:57:25\"}]', 2, '2021-02-13', '19:56:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 'internal'),
(40, 2, 'workorder', '4mfxeuzk', 1, 5, 5, NULL, NULL, '2021-02-13', 1, 100, 'medium', 0, '[\"2\"]', 'Mis observaciones', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[{\"status\":\"success\",\"file\":\"hotrestaurant_vox_attachment_oUlTnmtlGbWCXE3v.docx\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\hotrestaurant_vox_attachment_oUlTnmtlGbWCXE3v.docx\"},{\"status\":\"success\",\"file\":\"hotrestaurant_vox_attachment_J07hnq27CdqUiazR.pdf\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\hotrestaurant_vox_attachment_J07hnq27CdqUiazR.pdf\"},{\"status\":\"success\",\"file\":\"hotrestaurant_vox_attachment_kAVV4wDZUl1naLPa.png\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\hotrestaurant_vox_attachment_kAVV4wDZUl1naLPa.png\"},{\"status\":\"success\",\"file\":\"hotrestaurant_vox_attachment_BYJZ53YEfMiHss7P.xlsx\",\"route\":\"C:\\\\xampp\\\\htdocs\\\\guestvox\\\\uploads\\\\hotrestaurant_vox_attachment_BYJZ53YEfMiHss7P.xlsx\"}]', '[\"2\"]', '[]', '[{\"type\":\"created\",\"user\":\"2\",\"date\":\"2021-02-13\",\"hour\":\"19:57:08\"},{\"type\":\"viewed\",\"user\":\"2\",\"date\":\"2021-02-13\",\"hour\":\"19:57:20\"}]', 2, '2021-02-13', '19:57:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 'internal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `voxes_reports`
--

CREATE TABLE `voxes_reports` (
  `id` int(11) NOT NULL,
  `account` bigint(20) NOT NULL,
  `name` text NOT NULL,
  `type` enum('all','request','incident','workorder') NOT NULL,
  `owner` bigint(20) DEFAULT NULL,
  `opportunity_area` bigint(20) DEFAULT NULL,
  `opportunity_type` bigint(20) DEFAULT NULL,
  `location` bigint(20) DEFAULT NULL,
  `order` enum('owner','name') NOT NULL,
  `time_period` text NOT NULL,
  `addressed_to` enum('alls','opportunity_areas','me') NOT NULL,
  `opportunity_areas` longtext DEFAULT NULL,
  `user` bigint(20) DEFAULT NULL,
  `fields` longtext NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `webinars`
--

CREATE TABLE `webinars` (
  `id` bigint(20) NOT NULL,
  `image` text NOT NULL,
  `link` text NOT NULL,
  `date` date NOT NULL,
  `hour` time NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `webinars_records`
--

CREATE TABLE `webinars_records` (
  `id` bigint(20) NOT NULL,
  `webinar` bigint(20) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `business` text NOT NULL,
  `job` text NOT NULL,
  `date` date NOT NULL,
  `hour` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `package` (`package`);

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
-- Indices de la tabla `guests_treatments`
--
ALTER TABLE `guests_treatments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`) USING BTREE;

--
-- Indices de la tabla `guests_types`
--
ALTER TABLE `guests_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`) USING BTREE;

--
-- Indices de la tabla `icons`
--
ALTER TABLE `icons`
  ADD PRIMARY KEY (`id`);

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
-- Indices de la tabla `menu_categories`
--
ALTER TABLE `menu_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`),
  ADD KEY `icon` (`icon`);

--
-- Indices de la tabla `menu_orders`
--
ALTER TABLE `menu_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`),
  ADD KEY `owner` (`owner`);

--
-- Indices de la tabla `menu_products`
--
ALTER TABLE `menu_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`),
  ADD KEY `restaurant` (`restaurant`),
  ADD KEY `icon` (`icon`);

--
-- Indices de la tabla `menu_restaurants`
--
ALTER TABLE `menu_restaurants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`);

--
-- Indices de la tabla `menu_topics`
--
ALTER TABLE `menu_topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`);

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
-- Indices de la tabla `owners`
--
ALTER TABLE `owners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`);

--
-- Indices de la tabla `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reservations_statuses`
--
ALTER TABLE `reservations_statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`) USING BTREE;

--
-- Indices de la tabla `surveys_answers`
--
ALTER TABLE `surveys_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`),
  ADD KEY `owner` (`owner`);

--
-- Indices de la tabla `surveys_questions`
--
ALTER TABLE `surveys_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`);

--
-- Indices de la tabla `times_zones`
--
ALTER TABLE `times_zones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`) USING BTREE;

--
-- Indices de la tabla `users_levels`
--
ALTER TABLE `users_levels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`) USING BTREE;

--
-- Indices de la tabla `voxes`
--
ALTER TABLE `voxes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`) USING BTREE,
  ADD KEY `owner` (`owner`),
  ADD KEY `opportunity_area` (`opportunity_area`),
  ADD KEY `opportunity_type` (`opportunity_type`),
  ADD KEY `location` (`location`),
  ADD KEY `guest_treatment` (`guest_treatment`),
  ADD KEY `guest_type` (`guest_type`),
  ADD KEY `reservation_status` (`reservation_status`),
  ADD KEY `created_user` (`created_user`),
  ADD KEY `edited_user` (`edited_user`),
  ADD KEY `completed_user` (`completed_user`),
  ADD KEY `reopened_user` (`reopened_user`);

--
-- Indices de la tabla `voxes_reports`
--
ALTER TABLE `voxes_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account` (`account`) USING BTREE,
  ADD KEY `reports_ibfk_1` (`opportunity_area`),
  ADD KEY `opportunity_type` (`opportunity_type`),
  ADD KEY `owner` (`owner`),
  ADD KEY `location` (`location`),
  ADD KEY `user` (`user`);

--
-- Indices de la tabla `webinars`
--
ALTER TABLE `webinars`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `webinars_records`
--
ALTER TABLE `webinars_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `webinar` (`webinar`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT de la tabla `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT de la tabla `guests_treatments`
--
ALTER TABLE `guests_treatments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `guests_types`
--
ALTER TABLE `guests_types`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `icons`
--
ALTER TABLE `icons`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `menu_categories`
--
ALTER TABLE `menu_categories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `menu_orders`
--
ALTER TABLE `menu_orders`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `menu_products`
--
ALTER TABLE `menu_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=659;

--
-- AUTO_INCREMENT de la tabla `menu_restaurants`
--
ALTER TABLE `menu_restaurants`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `menu_topics`
--
ALTER TABLE `menu_topics`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `opportunity_areas`
--
ALTER TABLE `opportunity_areas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `opportunity_types`
--
ALTER TABLE `opportunity_types`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `owners`
--
ALTER TABLE `owners`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT de la tabla `reservations_statuses`
--
ALTER TABLE `reservations_statuses`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `surveys_answers`
--
ALTER TABLE `surveys_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `surveys_questions`
--
ALTER TABLE `surveys_questions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `times_zones`
--
ALTER TABLE `times_zones`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=425;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `users_levels`
--
ALTER TABLE `users_levels`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `voxes`
--
ALTER TABLE `voxes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `voxes_reports`
--
ALTER TABLE `voxes_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `webinars`
--
ALTER TABLE `webinars`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `webinars_records`
--
ALTER TABLE `webinars_records`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`package`) REFERENCES `packages` (`id`);

--
-- Filtros para la tabla `guests_treatments`
--
ALTER TABLE `guests_treatments`
  ADD CONSTRAINT `guests_treatments_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`);

--
-- Filtros para la tabla `guests_types`
--
ALTER TABLE `guests_types`
  ADD CONSTRAINT `guests_types_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`);

--
-- Filtros para la tabla `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `locations_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`);

--
-- Filtros para la tabla `menu_categories`
--
ALTER TABLE `menu_categories`
  ADD CONSTRAINT `menu_categories_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `menu_categories_ibfk_2` FOREIGN KEY (`icon`) REFERENCES `icons` (`id`);

--
-- Filtros para la tabla `menu_orders`
--
ALTER TABLE `menu_orders`
  ADD CONSTRAINT `menu_orders_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `menu_orders_ibfk_2` FOREIGN KEY (`owner`) REFERENCES `owners` (`id`);

--
-- Filtros para la tabla `menu_products`
--
ALTER TABLE `menu_products`
  ADD CONSTRAINT `menu_products_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `menu_products_ibfk_2` FOREIGN KEY (`restaurant`) REFERENCES `menu_restaurants` (`id`),
  ADD CONSTRAINT `menu_products_ibfk_3` FOREIGN KEY (`icon`) REFERENCES `icons` (`id`);

--
-- Filtros para la tabla `menu_restaurants`
--
ALTER TABLE `menu_restaurants`
  ADD CONSTRAINT `menu_restaurants_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`);

--
-- Filtros para la tabla `menu_topics`
--
ALTER TABLE `menu_topics`
  ADD CONSTRAINT `menu_topics_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`);

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
-- Filtros para la tabla `owners`
--
ALTER TABLE `owners`
  ADD CONSTRAINT `owners_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`);

--
-- Filtros para la tabla `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`);

--
-- Filtros para la tabla `reservations_statuses`
--
ALTER TABLE `reservations_statuses`
  ADD CONSTRAINT `reservations_statuses_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`);

--
-- Filtros para la tabla `surveys_answers`
--
ALTER TABLE `surveys_answers`
  ADD CONSTRAINT `surveys_answers_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `surveys_answers_ibfk_2` FOREIGN KEY (`owner`) REFERENCES `owners` (`id`);

--
-- Filtros para la tabla `surveys_questions`
--
ALTER TABLE `surveys_questions`
  ADD CONSTRAINT `surveys_questions_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`);

--
-- Filtros para la tabla `users_levels`
--
ALTER TABLE `users_levels`
  ADD CONSTRAINT `users_levels_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`);

--
-- Filtros para la tabla `voxes`
--
ALTER TABLE `voxes`
  ADD CONSTRAINT `voxes_ibfk_1` FOREIGN KEY (`account`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `voxes_ibfk_10` FOREIGN KEY (`edited_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `voxes_ibfk_11` FOREIGN KEY (`completed_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `voxes_ibfk_12` FOREIGN KEY (`reopened_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `voxes_ibfk_2` FOREIGN KEY (`owner`) REFERENCES `owners` (`id`),
  ADD CONSTRAINT `voxes_ibfk_3` FOREIGN KEY (`opportunity_area`) REFERENCES `opportunity_areas` (`id`),
  ADD CONSTRAINT `voxes_ibfk_4` FOREIGN KEY (`opportunity_type`) REFERENCES `opportunity_types` (`id`),
  ADD CONSTRAINT `voxes_ibfk_5` FOREIGN KEY (`location`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `voxes_ibfk_6` FOREIGN KEY (`guest_treatment`) REFERENCES `guests_treatments` (`id`),
  ADD CONSTRAINT `voxes_ibfk_7` FOREIGN KEY (`guest_type`) REFERENCES `guests_types` (`id`),
  ADD CONSTRAINT `voxes_ibfk_8` FOREIGN KEY (`reservation_status`) REFERENCES `reservations_statuses` (`id`),
  ADD CONSTRAINT `voxes_ibfk_9` FOREIGN KEY (`created_user`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `voxes_reports`
--
ALTER TABLE `voxes_reports`
  ADD CONSTRAINT `voxes_reports_ibfk_1` FOREIGN KEY (`opportunity_area`) REFERENCES `opportunity_areas` (`id`),
  ADD CONSTRAINT `voxes_reports_ibfk_2` FOREIGN KEY (`opportunity_type`) REFERENCES `opportunity_types` (`id`),
  ADD CONSTRAINT `voxes_reports_ibfk_3` FOREIGN KEY (`owner`) REFERENCES `owners` (`id`),
  ADD CONSTRAINT `voxes_reports_ibfk_4` FOREIGN KEY (`location`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `voxes_reports_ibfk_5` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `webinars_records`
--
ALTER TABLE `webinars_records`
  ADD CONSTRAINT `webinars_records_ibfk_1` FOREIGN KEY (`webinar`) REFERENCES `webinars` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
