-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: d123172.mysql.zonevs.eu
-- Loomise aeg: Mai 06, 2024 kell 09:10 EL
-- Serveri versioon: 10.4.32-MariaDB-log
-- PHP versioon: 8.2.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Andmebaas: `d123172_andmebaas`
--

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `lend`
--

CREATE TABLE `lend` (
  `id` int(11) NOT NULL,
  `lennu_nr` varchar(30) DEFAULT NULL,
  `kohtade_arv` int(11) DEFAULT NULL,
  `reisijate_arv` int(11) DEFAULT 0,
  `ots` varchar(100) DEFAULT NULL,
  `siht` varchar(100) DEFAULT NULL,
  `valjumisaeg` datetime DEFAULT current_timestamp(),
  `lopetatud` datetime DEFAULT '0000-00-00 00:00:00',
  `kestvus` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Andmete tõmmistamine tabelile `lend`
--

INSERT INTO `lend` (`id`, `lennu_nr`, `kohtade_arv`, `reisijate_arv`, `ots`, `siht`, `valjumisaeg`, `lopetatud`, `kestvus`) VALUES
(17, 'mnmm', 5, 0, 'hfghfg', 'hfghfg', '2024-01-19 14:15:00', '0000-00-00 00:00:00', 4162),
(18, 'asd', 12, 0, 'sad', 'asd', '2024-01-20 13:43:00', '0000-00-00 00:00:00', NULL),
(19, 'RAK500', 50, 50, 'Tallinn', 'Tromse', '2024-01-22 22:20:00', '2024-01-23 05:05:00', 405),
(20, 'teree', 50, 0, 'Tartu', 'Narva', '2024-01-04 02:02:00', '0000-00-00 00:00:00', NULL),
(21, 'JAK39', 14, 10, 'Tallinn', 'Vilnius', '2024-04-08 09:27:00', '0000-00-00 00:00:00', NULL),
(32, 'LX123', 5, 0, 'Tallinn', 'Valga', '2024-04-07 10:15:00', '0000-00-00 00:00:00', NULL),
(33, 'XXX123', 5, 5, 'Valga', 'Tallinn', '2024-04-27 10:16:00', '0000-00-00 00:00:00', NULL),
(34, 'Eeeee timur ezheeee kak dela', 1, 0, 'kkk', 'lll', '2024-05-05 08:48:00', '0000-00-00 00:00:00', NULL),
(35, 'mmm', 10, 0, 'mmm', 'lll', '2024-05-31 08:49:00', '0000-00-00 00:00:00', NULL);

--
-- Indeksid tõmmistatud tabelitele
--

--
-- Indeksid tabelile `lend`
--
ALTER TABLE `lend`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT tõmmistatud tabelitele
--

--
-- AUTO_INCREMENT tabelile `lend`
--
ALTER TABLE `lend`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
