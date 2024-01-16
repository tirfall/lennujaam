-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Loomise aeg: Jaan 16, 2024 kell 11:06 EL
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
-- Tabeli struktuur tabelile `lennujaamkasutaja`
--

CREATE TABLE `lennujaamkasutaja` (
  `id` int(11) NOT NULL,
  `kasutaja` varchar(100) DEFAULT NULL,
  `parool` varchar(100) DEFAULT NULL,
  `onAdmin` int(11) DEFAULT 0,
  `onKasutaja` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Andmete tõmmistamine tabelile `lennujaamkasutaja`
--

INSERT INTO `lennujaamkasutaja` (`id`, `kasutaja`, `parool`, `onAdmin`, `onKasutaja`) VALUES
(1, 'admin', 'leShwoFF3RG5.', 1, 0);

--
-- Indeksid tõmmistatud tabelitele
--

--
-- Indeksid tabelile `lennujaamkasutaja`
--
ALTER TABLE `lennujaamkasutaja`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT tõmmistatud tabelitele
--

--
-- AUTO_INCREMENT tabelile `lennujaamkasutaja`
--
ALTER TABLE `lennujaamkasutaja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
