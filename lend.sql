-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Loomise aeg: Jaan 16, 2024 kell 08:32 EL
-- Serveri versioon: 10.4.27-MariaDB
-- PHP versioon: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Andmebaas: `lennujaam`
--

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `lend`
--

CREATE TABLE `lend` (
  `id` int(11) NOT NULL,
  `lennu_nr` varchar(30) DEFAULT NULL,
  `kohtade_arv` int(11) DEFAULT NULL,
  `reisijate_arv` int(11) DEFAULT NULL,
  `ots` varchar(100) DEFAULT NULL,
  `siht` varchar(100) DEFAULT NULL,
  `valjumisaeg` datetime DEFAULT NULL,
  `lopetatud` datetime DEFAULT NULL,
  `kestvus` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Andmete tõmmistamine tabelile `lend`
--

INSERT INTO `lend` (`id`, `lennu_nr`, `kohtade_arv`, `reisijate_arv`, `ots`, `siht`, `valjumisaeg`, `lopetatud`, `kestvus`) VALUES
(1, 'RAK739', 70, 50, 'Tallinn', 'Riga', '2024-01-17 10:20:00', '2024-01-17 11:00:00', 100);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
