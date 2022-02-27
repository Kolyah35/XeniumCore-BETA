-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Фев 27 2022 г., 10:28
-- Версия сервера: 10.5.8-MariaDB-1:10.5.8+maria~buster
-- Версия PHP: 7.3.17-1+0~20200419.57+debian10~1.gbp0fda17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `kolyah35_gdmsrestore`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bannedips`
--

CREATE TABLE `bannedips` (
  `ip` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `levels`
--

CREATE TABLE `levels` (
  `levelID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `levelName` text NOT NULL,
  `levelDesc` text NOT NULL,
  `levelString` text NOT NULL,
  `levelVersion` int(11) NOT NULL,
  `levelLength` int(11) NOT NULL,
  `audioTrack` int(11) NOT NULL,
  `gameVersion` int(11) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `downloads` int(11) NOT NULL DEFAULT 0,
  `difficultyDenominator` int(11) NOT NULL DEFAULT 0 COMMENT '0 = NA, 10 = Assigned',
  `difficultyNumerator` int(11) NOT NULL DEFAULT 0 COMMENT '0 = unrated, 10 = easy, 20 = normal, 30 = hard, 40 = harder, 50 = insane.',
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `likes_log`
--

CREATE TABLE `likes_log` (
  `id` int(11) NOT NULL,
  `userName` text NOT NULL,
  `udid` text NOT NULL,
  `ip` text NOT NULL DEFAULT '127.0.0.1',
  `levelID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `rate_log`
--

CREATE TABLE `rate_log` (
  `ID` int(11) NOT NULL,
  `levelID` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `IP` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `userName` text NOT NULL DEFAULT 'Player',
  `udid` text NOT NULL,
  `ip` text NOT NULL DEFAULT '127.0.0.1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`levelID`);

--
-- Индексы таблицы `likes_log`
--
ALTER TABLE `likes_log`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `rate_log`
--
ALTER TABLE `rate_log`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `levels`
--
ALTER TABLE `levels`
  MODIFY `levelID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `likes_log`
--
ALTER TABLE `likes_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `rate_log`
--
ALTER TABLE `rate_log`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
