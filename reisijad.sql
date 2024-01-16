-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Loomise aeg: Jaan 16, 2024 kell 10:06 EL
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
-- Tabeli struktuur tabelile `reisijad`
--

CREATE TABLE `reisijad` (
  `id` int(11) NOT NULL,
  `FK_lennu_nr` varchar(30) DEFAULT NULL,
  `Nimi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Andmete tõmmistamine tabelile `reisijad`
--

INSERT INTO `reisijad` (`id`, `FK_lennu_nr`, `Nimi`) VALUES
(1, NULL, 'admin\r\n');

--
-- Indeksid tõmmistatud tabelitele
--

--
-- Indeksid tabelile `reisijad`
--
ALTER TABLE `reisijad`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT tõmmistatud tabelitele
--

--
-- AUTO_INCREMENT tabelile `reisijad`
--
ALTER TABLE `reisijad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tõmmistatud tabelite piirangud
--

--
-- Piirangud tabelile `reisijad`
--
ALTER TABLE `reisijad`
  ADD CONSTRAINT `FK_lennu_nr` FOREIGN KEY (`id`) REFERENCES `lend` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
