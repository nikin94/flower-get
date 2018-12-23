-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 23 2018 г., 17:29
-- Версия сервера: 5.7.20
-- Версия PHP: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `flowers`
--

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL DEFAULT '-1',
  `list_flowers` text NOT NULL,
  `price_bank` varchar(20) NOT NULL DEFAULT 'tinkoff',
  `price_flowers` int(11) NOT NULL,
  `price_delivery` int(11) NOT NULL,
  `bus_delivery` tinyint(1) DEFAULT '0',
  `payment` tinyint(1) DEFAULT '0',
  `payment_part` tinyint(1) DEFAULT '0',
  `departure` tinyint(1) DEFAULT '0',
  `price_summary` int(11) NOT NULL,
  `tracking_number` varchar(20) NOT NULL DEFAULT '0',
  `date_payment` varchar(20) DEFAULT '0',
  `date_departure` varchar(20) DEFAULT '0',
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_complete` varchar(20) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `name`, `address`, `phone`, `list_flowers`, `price_bank`, `price_flowers`, `price_delivery`, `bus_delivery`, `payment`, `payment_part`, `departure`, `price_summary`, `tracking_number`, `date_payment`, `date_departure`, `date_create`, `date_complete`) VALUES
(11, 'testest', '244asdas', '12332232', 'qwe 123, asda 545', 'tinkoff', 668, 350, 0, 1, 0, 1, 1018, '29500078901234', '2018-12-22 19:01:06', '2018-12-23 17:12:29', '2018-12-22 19:00:00', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `orders_deleted`
--

CREATE TABLE `orders_deleted` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL DEFAULT '-1',
  `list_flowers` text NOT NULL,
  `price_bank` varchar(20) NOT NULL DEFAULT 'tinkoff',
  `price_flowers` int(11) NOT NULL,
  `price_delivery` int(11) NOT NULL,
  `bus_delivery` tinyint(1) DEFAULT '0',
  `payment` tinyint(1) DEFAULT '0',
  `payment_part` tinyint(1) DEFAULT '0',
  `departure` tinyint(1) DEFAULT '0',
  `price_summary` int(11) NOT NULL,
  `tracking_number` varchar(20) NOT NULL DEFAULT '0',
  `date_payment` varchar(20) DEFAULT '0',
  `date_departure` varchar(20) DEFAULT '0',
  `date_create` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_complete` varchar(20) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders_deleted`
--
ALTER TABLE `orders_deleted`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `orders_deleted`
--
ALTER TABLE `orders_deleted`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
