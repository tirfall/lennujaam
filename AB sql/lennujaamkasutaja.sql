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
-- Tabeli struktuur tabelile `lennujaamkasutaja`
--

CREATE TABLE `lennujaamkasutaja` (
  `id` int(11) NOT NULL,
  `kasutaja` varchar(100) DEFAULT NULL,
  `parool` varchar(100) DEFAULT NULL,
  `onAdmin` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Andmete tõmmistamine tabelile `lennujaamkasutaja`
--

INSERT INTO `lennujaamkasutaja` (`id`, `kasutaja`, `parool`, `onAdmin`) VALUES
(1, 'admin', 'su6FF4/MgjUAk', 1),
(4, 'timur', 'suWmxeHf1Q7LQ', 0),
(5, 'timur1', 'su1r0.kul3jfE', 0),
(6, 'timur12', 'suWmxeHf1Q7LQ', 0),
(7, 'timur123', 'suWmxeHf1Q7LQ', 0),
(10, 'sfdsdf', 'su6FF4/MgjUAk', 0),
(11, 'art', 'suaDM9xRYlOe2', 0),
(12, 'ad', 'sudeyEXUrFjcA', 0),
(13, 'dasfsd', 'su4fTk3V3hddw', 0),
(14, 'das', 'suDtGLl6YTDrs', 0),
(15, 'jah', 'susvSSHlRR3ZA', 0),
(16, 'test', 'su36ZVTJAmbDY', 0),
(17, '123', 'su.7ZLQEdBF/2', 0),
(18, 'dsffsf', 'sue9m0Y/syVHI', 0),
(19, 'opilane', 'suUQOcsPPcPyg', 0),
(20, 'fsdf', 'sujw4toFCYHMg', 0),
(21, 'user', 'su6/tfktDv4UM', 0),
(22, 'kkk', 'sutW9sgmwPfio', 0),
(23, '1234', 'suWmxeHf1Q7LQ', 0),
(24, 'jj', 'suXMeIAYwYWkw', 0),
(25, 'maksim', 'suyMO8iwDz0vU', 0),
(26, 'r', 'su4CyRgqFrjYk', 0),
(27, 'matvei', 'suWmxeHf1Q7LQ', 0),
(28, 'a', 'suVLez3wnyYTE', 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
