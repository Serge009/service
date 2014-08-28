-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 28 2014 г., 13:14
-- Версия сервера: 5.5.20
-- Версия PHP: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `sailor`
--

-- --------------------------------------------------------

--
-- Структура таблицы `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `company`
--

INSERT INTO `company` (`id`, `name`, `status`) VALUES
(1, 'Company 1', 1),
(2, 'Company 2', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `currency`
--

CREATE TABLE IF NOT EXISTS `currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `company` int(11) NOT NULL,
  `version` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `Ref_06` (`company`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `currency`
--

INSERT INTO `currency` (`id`, `name`, `company`, `version`, `status`) VALUES
(1, 'TL', 1, 1, 1),
(2, 'USD', 1, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `company` int(11) NOT NULL,
  `longitude` double(15,3) DEFAULT NULL,
  `latitude` double(15,3) DEFAULT NULL,
  `version` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `Ref_05` (`company`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `customers`
--

INSERT INTO `customers` (`id`, `name`, `company`, `longitude`, `latitude`, `version`, `status`) VALUES
(1, 'Customer 1', 1, 345345.000, 3534535.000, 1, 1),
(2, 'Customer 2', 1, 43534.000, 456546.000, 1, 1),
(3, 'Customer 3', 2, 7567.000, 567567.000, 1, 1),
(4, 'Customer 4', 2, 657657.000, 35345.000, 1, 1),
(5, 'Customer 5', 1, 563456.000, 54654.000, 1, 2),
(6, 'Customer 6', 1, 234.000, 23423.000, 1, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `company` int(11) NOT NULL,
  `version` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `Ref_16` (`company`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `department`
--

INSERT INTO `department` (`id`, `name`, `company`, `version`) VALUES
(1, 'Department 1', 1, 1),
(2, 'Department 2', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `devices`
--

CREATE TABLE IF NOT EXISTS `devices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` text NOT NULL,
  `license` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `status` int(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `Ref_26` (`license`),
  KEY `Ref_27` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `devices`
--

INSERT INTO `devices` (`id`, `uuid`, `license`, `user`, `status`) VALUES
(1, '666', 1, 2, 1),
(2, '777', 1, 2, 1),
(3, '888', 1, 2, 1),
(5, 'ecace720494b8abe7963639a120bc53d', 1, 2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `division`
--

CREATE TABLE IF NOT EXISTS `division` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `company` int(11) NOT NULL,
  `version` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `Ref_19` (`company`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `division`
--

INSERT INTO `division` (`id`, `name`, `company`, `version`) VALUES
(1, 'Division 1', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `item_types`
--

CREATE TABLE IF NOT EXISTS `item_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL COMMENT 'product(1) or service(2)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `item_types`
--

INSERT INTO `item_types` (`id`, `type`) VALUES
(1, 'Product'),
(2, 'Service');

-- --------------------------------------------------------

--
-- Структура таблицы `licenses`
--

CREATE TABLE IF NOT EXISTS `licenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serial` varchar(10) NOT NULL,
  `owner` int(11) NOT NULL,
  `user_count` int(5) NOT NULL DEFAULT '1',
  `status` int(1) NOT NULL DEFAULT '1',
  `distributor` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `serial` (`serial`),
  KEY `Ref_04` (`owner`),
  KEY `Ref_31` (`distributor`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `licenses`
--

INSERT INTO `licenses` (`id`, `serial`, `owner`, `user_count`, `status`, `distributor`) VALUES
(1, '5555555555', 1, 4, 1, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL COMMENT 'created by',
  `date` date NOT NULL,
  `customer` int(11) NOT NULL,
  `slip_number` text,
  `special_code` text,
  `subtotal` double(15,3) DEFAULT NULL,
  `total` float(10,2) NOT NULL,
  `version` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `Ref_08` (`user`),
  KEY `Ref_09` (`customer`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user`, `date`, `customer`, `slip_number`, `special_code`, `subtotal`, `total`, `version`, `status`) VALUES
(17, 2, '2014-08-18', 1, '554464', '5645', 500.000, 700.00, 1, 1),
(18, 2, '2014-08-18', 1, '554464', '5645', 500.000, 700.00, 2, 1),
(19, 2, '2014-08-18', 1, '554464', '5645', 500.000, 700.00, 3, 1),
(20, 2, '2014-08-19', 1, '554464', '5645', 500.000, 700.00, 4, 1),
(21, 2, '2014-08-20', 1, '554464', '5645', 500.000, 700.00, 5, 1),
(22, 2, '2014-08-20', 1, '554464', '5645', 500.000, 700.00, 6, 1),
(23, 2, '2014-08-20', 1, '554464', '5645', 500.000, 700.00, 7, 1),
(24, 2, '2014-08-20', 1, '554464', '5645', 500.000, 700.00, 8, 1),
(25, 2, '2014-08-20', 1, '554464', '5645', 500.000, 700.00, 9, 1),
(26, 2, '2014-08-20', 1, '554464', '5645', 500.000, 700.00, 10, 1),
(27, 2, '2014-08-22', 1, '554464', '5645', 500.000, 700.00, 11, 1),
(28, 2, '2014-08-22', 1, '554464', '5645', 500.000, 700.00, 12, 1),
(29, 2, '2014-08-22', 1, '554464', '5645', 500.000, 700.00, 13, 1),
(30, 2, '2014-08-22', 1, '554464', '5645', 500.000, 700.00, 14, 1),
(31, 2, '2014-08-22', 1, '554464', '5645', 500.000, 700.00, 15, 1),
(32, 2, '2014-08-22', 1, '554464', '5645', 500.000, 700.00, 16, 1),
(33, 2, '2014-08-22', 1, '554464', '5645', 500.000, 700.00, 17, 1),
(34, 2, '2014-08-22', 1, '554464', '5645', 500.000, 700.00, 18, 1),
(35, 2, '2014-08-22', 1, '554464', '5645', 500.000, 700.00, 19, 1),
(36, 2, '2014-08-22', 1, '554464', '5645', 500.000, 700.00, 20, 1),
(37, 2, '2014-08-23', 1, '554464', '5645', 500.000, 700.00, 21, 1),
(38, 2, '2014-08-23', 1, '554464', '5645', 500.000, 700.00, 22, 1),
(39, 2, '2014-08-23', 1, '554464', '5645', 500.000, 700.00, 23, 1),
(40, 2, '2014-08-23', 1, '554464', '5645', 500.000, 700.00, 24, 1),
(41, 2, '2014-08-23', 1, '554464', '5645', 500.000, 700.00, 25, 1),
(42, 2, '2016-11-28', 1, 'Some Slip Number', '4646546498163521', 12.200, 14.20, 26, 1),
(43, 2, '2016-11-28', 1, 'Some Slip Number', '4646546498163521', 12.200, 14.20, 27, 1),
(44, 2, '2016-11-28', 1, 'Some Slip Number', '4646546498163521', 12.200, 14.20, 28, 1),
(45, 2, '2016-11-28', 1, 'Some Slip Number', '4646546498163521', 12.200, 14.20, 29, 1),
(46, 2, '2016-11-28', 1, 'Some Slip Number', '4646546498163521', 12.200, 14.20, 30, 1),
(47, 2, '2016-11-28', 1, 'Some Slip Number', '4646546498163521', 12.200, 14.20, 30, 1),
(48, 2, '2016-11-28', 1, 'Some Slip Number', '4646546498163521', 12.200, 14.20, 31, 1),
(49, 2, '2016-11-28', 1, 'Some Slip Number', '4646546498163521', 12.200, 14.20, 31, 1),
(50, 2, '2016-11-28', 1, 'Some Slip Number', '4646546498163521', 12.200, 14.20, 32, 1),
(51, 2, '2016-11-28', 1, 'Some Slip Number', '4646546498163521', 12.200, 14.20, 32, 1),
(52, 2, '2016-11-28', 1, 'Some Slip Number', '4646546498163521', 12.200, 14.20, 33, 1),
(53, 2, '2016-11-28', 1, 'Some Slip Number', '4646546498163521', 12.200, 14.20, 33, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `order_item`
--

CREATE TABLE IF NOT EXISTS `order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `version` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `Ref_10` (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=137 ;

--
-- Дамп данных таблицы `order_item`
--

INSERT INTO `order_item` (`id`, `item`, `type`, `order_id`, `version`, `status`) VALUES
(38, 1, 1, 17, 1, 1),
(39, 1, 2, 17, 1, 1),
(40, 2, 1, 17, 1, 1),
(41, 1, 1, 18, 2, 1),
(42, 1, 2, 18, 2, 1),
(43, 2, 1, 18, 2, 1),
(44, 1, 1, 19, 3, 1),
(45, 1, 2, 19, 3, 1),
(46, 2, 1, 19, 3, 1),
(47, 1, 1, 20, 4, 1),
(48, 1, 2, 20, 4, 1),
(49, 2, 1, 20, 4, 1),
(50, 1, 1, 21, 5, 1),
(51, 1, 2, 21, 5, 1),
(52, 2, 1, 21, 5, 1),
(53, 1, 1, 22, 6, 1),
(54, 1, 2, 22, 6, 1),
(55, 2, 1, 22, 6, 1),
(56, 1, 1, 23, 7, 1),
(57, 1, 2, 23, 7, 1),
(58, 2, 1, 23, 7, 1),
(59, 1, 1, 24, 8, 1),
(60, 1, 2, 24, 8, 1),
(61, 2, 1, 24, 8, 1),
(62, 1, 1, 25, 9, 1),
(63, 1, 2, 25, 9, 1),
(64, 2, 1, 25, 9, 1),
(65, 1, 1, 26, 10, 1),
(66, 1, 2, 26, 10, 1),
(67, 2, 1, 26, 10, 1),
(68, 1, 1, 27, 11, 1),
(69, 1, 2, 27, 11, 1),
(70, 2, 1, 27, 11, 1),
(71, 1, 1, 28, 12, 1),
(72, 1, 2, 28, 12, 1),
(73, 2, 1, 28, 12, 1),
(74, 1, 1, 29, 13, 1),
(75, 1, 2, 29, 13, 1),
(76, 2, 1, 29, 13, 1),
(77, 1, 1, 30, 14, 1),
(78, 1, 2, 30, 14, 1),
(79, 2, 1, 30, 14, 1),
(80, 1, 1, 31, 15, 1),
(81, 1, 2, 31, 15, 1),
(82, 2, 1, 31, 15, 1),
(83, 1, 1, 32, 16, 1),
(84, 1, 2, 32, 16, 1),
(85, 2, 1, 32, 16, 1),
(86, 1, 1, 33, 17, 1),
(87, 1, 2, 33, 17, 1),
(88, 2, 1, 33, 17, 1),
(89, 1, 1, 34, 18, 1),
(90, 1, 2, 34, 18, 1),
(91, 2, 1, 34, 18, 1),
(92, 1, 1, 35, 19, 1),
(93, 1, 2, 35, 19, 1),
(94, 2, 1, 35, 19, 1),
(95, 1, 1, 36, 20, 1),
(96, 1, 2, 36, 20, 1),
(97, 2, 1, 36, 20, 1),
(98, 1, 1, 37, 21, 1),
(99, 1, 2, 37, 21, 1),
(100, 2, 1, 37, 21, 1),
(101, 1, 1, 38, 22, 1),
(102, 1, 2, 38, 22, 1),
(103, 2, 1, 38, 22, 1),
(104, 1, 1, 39, 23, 1),
(105, 1, 2, 39, 23, 1),
(106, 2, 1, 39, 23, 1),
(107, 1, 1, 40, 24, 1),
(108, 1, 2, 40, 24, 1),
(109, 2, 1, 40, 24, 1),
(110, 1, 1, 41, 25, 1),
(111, 1, 2, 41, 25, 1),
(112, 2, 1, 41, 25, 1),
(113, 12, 1, 42, 26, 1),
(114, 12, 1, 42, 26, 1),
(115, 12, 1, 43, 27, 1),
(116, 12, 1, 43, 27, 1),
(117, 12, 1, 44, 28, 1),
(118, 12, 1, 44, 28, 1),
(119, 12, 1, 45, 29, 1),
(120, 12, 1, 45, 29, 1),
(121, 12, 1, 46, 30, 1),
(122, 12, 1, 46, 30, 1),
(123, 12, 1, 47, 30, 1),
(124, 12, 1, 47, 30, 1),
(125, 12, 1, 48, 31, 1),
(126, 12, 1, 48, 31, 1),
(127, 12, 1, 49, 31, 1),
(128, 12, 1, 49, 31, 1),
(129, 12, 1, 50, 32, 1),
(130, 12, 1, 50, 32, 1),
(131, 12, 1, 51, 32, 1),
(132, 12, 1, 51, 32, 1),
(133, 12, 1, 52, 33, 1),
(134, 12, 1, 52, 33, 1),
(135, 12, 1, 53, 33, 1),
(136, 12, 1, 53, 33, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `plant`
--

CREATE TABLE IF NOT EXISTS `plant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `company` int(11) NOT NULL,
  `version` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `Ref_18` (`company`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `plant`
--

INSERT INTO `plant` (`id`, `name`, `company`, `version`) VALUES
(1, 'Plant 1', 1, 1),
(2, 'Plant 2', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `description` text,
  `vat` int(3) NOT NULL DEFAULT '0',
  `unit` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `version` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  `code` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Ref_21` (`unit`),
  KEY `Ref_24` (`company`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `quantity`, `description`, `vat`, `unit`, `company`, `version`, `status`, `code`) VALUES
(1, 'Product 1', 3, 'Some product description', 0, 1, 1, 1, 1, '5555555'),
(2, 'Product 2', 4, 'Some other description', 0, 1, 1, 1, 1, '1111111');

-- --------------------------------------------------------

--
-- Структура таблицы `product_prices`
--

CREATE TABLE IF NOT EXISTS `product_prices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product` int(11) NOT NULL,
  `price` float(9,2) NOT NULL,
  `currency` int(11) NOT NULL,
  `version` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `Ref_12` (`product`),
  KEY `Ref_13` (`currency`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `product_prices`
--

INSERT INTO `product_prices` (`id`, `product`, `price`, `currency`, `version`) VALUES
(1, 1, 100.00, 1, 1),
(2, 1, 100.00, 2, 1),
(3, 2, 50.00, 1, 1),
(4, 2, 50.00, 2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text,
  `vat` int(3) NOT NULL DEFAULT '0',
  `unit` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `version` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  `code` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Ref_20` (`unit`),
  KEY `Ref_23` (`company`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `vat`, `unit`, `company`, `version`, `status`, `code`) VALUES
(1, 'Service 1', 'Some service description', 0, 2, 1, 1, 1, '54654'),
(2, 'Service 2', 'Some other service description', 0, 2, 1, 1, 1, '5465');

-- --------------------------------------------------------

--
-- Структура таблицы `service_prices`
--

CREATE TABLE IF NOT EXISTS `service_prices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service` int(11) NOT NULL,
  `price` float(9,2) NOT NULL,
  `currency` int(11) NOT NULL,
  `version` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `Ref_14` (`currency`),
  KEY `Ref_15` (`service`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `service_prices`
--

INSERT INTO `service_prices` (`id`, `service`, `price`, `currency`, `version`) VALUES
(1, 1, 500.00, 1, 1),
(2, 1, 500.00, 2, 1),
(3, 2, 1000.00, 1, 1),
(4, 2, 1000.00, 2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(32) NOT NULL,
  `device` int(11) NOT NULL,
  `status` int(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `session_id` (`session_id`),
  KEY `Ref_25` (`device`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`id`, `session_id`, `device`, `status`) VALUES
(1, 'd07a5600b20b27a6dc4f27e1af535779', 1, 2),
(2, '390ed8cd76ccbac2dd02f40210208900', 2, 1),
(3, 'fb9babee67ce7013bee5b5575f0d5955', 3, 1),
(4, '1ec80c874b97080f1309b81ffbd7ad7f', 1, 2),
(5, '3e4ab9ab605a8fd8e12c03ff783e7640', 1, 1),
(7, '2d60235ce70038db803883ca7198c451', 5, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `statuses`
--

CREATE TABLE IF NOT EXISTS `statuses` (
  `id` int(3) NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `statuses`
--

INSERT INTO `statuses` (`id`, `name`) VALUES
(1, 'Active'),
(2, 'Not Active');

-- --------------------------------------------------------

--
-- Структура таблицы `unit`
--

CREATE TABLE IF NOT EXISTS `unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `company` int(11) NOT NULL,
  `version` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `Ref_28` (`company`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `unit`
--

INSERT INTO `unit` (`id`, `name`, `company`, `version`, `status`) VALUES
(1, 'Length', 1, 1, 1),
(2, 'Weight', 1, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `unit_detail`
--

CREATE TABLE IF NOT EXISTS `unit_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `main` tinyint(4) NOT NULL DEFAULT '0',
  `version` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `Ref_22` (`unit`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `unit_detail`
--

INSERT INTO `unit_detail` (`id`, `unit`, `name`, `from`, `to`, `main`, `version`) VALUES
(1, 1, 'm', 1, 1, 1, 1),
(2, 1, 'dm', 10, 1, 0, 1),
(3, 2, 'kg', 1, 1, 1, 1),
(4, 2, 'gr', 1000, 1, 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `salt` varchar(23) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `company` int(11) NOT NULL,
  `creator` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`email`),
  KEY `Ref_07` (`company`),
  KEY `Ref_30` (`creator`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `type`, `name`, `surname`, `email`, `password`, `salt`, `status`, `company`, `creator`) VALUES
(1, 1, 'admin', 'admin', 'admin@admin.com', '83fe3b346747af7eae56ecc18938aa16', '25354', 1, 1, NULL),
(2, 5, 'Mobile', 'User', 'loh@example.com', '2d2197640f5b7b3ae4b12ef01b44bc60', '24524', 1, 1, 1),
(3, 1, 'admin', 'admin', 'admin', '$2y$12$53fdcb94837d58.444724u2D.JXxQWGWySreJ.d77NqtCoG1mxWUC', '53fdcb94837d58.44472408', 1, 1, NULL),
(4, 2, 'distributor', 'test', 'test', '$2y$12$53fdd48b11b871.173179ueE5cS1CPWBT7kW2pAL7xuHo5gWYfeLe', '53fdd48b11b871.17317965', 1, 1, 1),
(5, 2, 'Test', 'test', 'test@test', '$2y$12$53feecc1054ac6.630052uMckVekPK3x/1yx9d2sYU4GF5wXsgHH2', '53feecc1054ac6.63005213', 1, 1, 1),
(7, 2, 'sdf', 'sdfsd', 'sdfds@dsf', '$2y$12$53feed49b30245.979590uPHZVtSbXO18yM/RjnLx3..IXddwhnte', '53feed49b30245.97959002', 1, 1, 1),
(9, 2, 'ghfhf', 'fghfg', 'fghfg@dfg', '$2y$12$53feee252db867.586713ujo4MmA.CFjROCfp186qIR9KBs8UeTxi', '53feee252db867.58671317', 1, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `user_status`
--

CREATE TABLE IF NOT EXISTS `user_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `user_status`
--

INSERT INTO `user_status` (`id`, `description`) VALUES
(1, 'Active'),
(2, 'Not Active');

-- --------------------------------------------------------

--
-- Структура таблицы `user_type`
--

CREATE TABLE IF NOT EXISTS `user_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `user_type`
--

INSERT INTO `user_type` (`id`, `name`) VALUES
(1, 'Administrator'),
(2, 'Distributor'),
(3, 'Account Owner'),
(4, 'Manager'),
(5, 'Mobile User');

-- --------------------------------------------------------

--
-- Структура таблицы `warehouse`
--

CREATE TABLE IF NOT EXISTS `warehouse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `company` int(11) NOT NULL,
  `version` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `Ref_17` (`company`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `warehouse`
--

INSERT INTO `warehouse` (`id`, `name`, `company`, `version`) VALUES
(1, 'Warehouse 1', 1, 1),
(2, 'Warehouse 2', 1, 1);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `currency`
--
ALTER TABLE `currency`
  ADD CONSTRAINT `Ref_06` FOREIGN KEY (`company`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `Ref_05` FOREIGN KEY (`company`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `Ref_16` FOREIGN KEY (`company`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `devices`
--
ALTER TABLE `devices`
  ADD CONSTRAINT `Ref_26` FOREIGN KEY (`license`) REFERENCES `licenses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Ref_27` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `division`
--
ALTER TABLE `division`
  ADD CONSTRAINT `Ref_19` FOREIGN KEY (`company`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `licenses`
--
ALTER TABLE `licenses`
  ADD CONSTRAINT `Ref_31` FOREIGN KEY (`distributor`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `Ref_04` FOREIGN KEY (`owner`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `Ref_08` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Ref_09` FOREIGN KEY (`customer`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `plant`
--
ALTER TABLE `plant`
  ADD CONSTRAINT `Ref_18` FOREIGN KEY (`company`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `Ref_21` FOREIGN KEY (`unit`) REFERENCES `unit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Ref_24` FOREIGN KEY (`company`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `product_prices`
--
ALTER TABLE `product_prices`
  ADD CONSTRAINT `Ref_12` FOREIGN KEY (`product`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Ref_13` FOREIGN KEY (`currency`) REFERENCES `currency` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `Ref_20` FOREIGN KEY (`unit`) REFERENCES `unit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Ref_23` FOREIGN KEY (`company`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `service_prices`
--
ALTER TABLE `service_prices`
  ADD CONSTRAINT `Ref_14` FOREIGN KEY (`currency`) REFERENCES `currency` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Ref_15` FOREIGN KEY (`service`) REFERENCES `services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `Ref_25` FOREIGN KEY (`device`) REFERENCES `devices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `unit`
--
ALTER TABLE `unit`
  ADD CONSTRAINT `Ref_28` FOREIGN KEY (`company`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `unit_detail`
--
ALTER TABLE `unit_detail`
  ADD CONSTRAINT `Ref_22` FOREIGN KEY (`unit`) REFERENCES `unit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `Ref_07` FOREIGN KEY (`company`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Ref_30` FOREIGN KEY (`creator`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `warehouse`
--
ALTER TABLE `warehouse`
  ADD CONSTRAINT `Ref_17` FOREIGN KEY (`company`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
