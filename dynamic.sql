-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Vært: 127.0.0.1
-- Genereringstid: 19. 01 2018 kl. 11:54:03
-- Serverversion: 10.1.26-MariaDB
-- PHP-version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dynamic`
--
CREATE DATABASE IF NOT EXISTS `dynamic` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `dynamic`;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `pagecontent`
--

CREATE TABLE `pagecontent` (
  `pagecontent_id` int(11) NOT NULL,
  `pagecontent_content` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `pageimage`
--

CREATE TABLE `pageimage` (
  `pageimage_id` int(11) NOT NULL,
  `pageimage_filename` varchar(126) DEFAULT NULL,
  `pageimage_position` int(11) DEFAULT NULL,
  `fk_pageConent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `pages`
--

CREATE TABLE `pages` (
  `page_id` int(11) NOT NULL,
  `page_title` varchar(45) DEFAULT NULL,
  `page_link` varchar(45) DEFAULT NULL,
  `fk_pageContent` int(11) DEFAULT NULL,
  `fk_pageSettings` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `pages`
--

INSERT INTO `pages` (`page_id`, `page_title`, `page_link`, `fk_pageContent`, `fk_pageSettings`) VALUES
(22, 'New Page', 'newpage', NULL, 23);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `pagesettings`
--

CREATE TABLE `pagesettings` (
  `pagesettings_id` int(11) NOT NULL,
  `pagesetting_filename` varchar(126) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `pagesettings`
--

INSERT INTO `pagesettings` (`pagesettings_id`, `pagesetting_filename`) VALUES
(23, 'newpage');

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `pagecontent`
--
ALTER TABLE `pagecontent`
  ADD PRIMARY KEY (`pagecontent_id`);

--
-- Indeks for tabel `pageimage`
--
ALTER TABLE `pageimage`
  ADD PRIMARY KEY (`pageimage_id`),
  ADD KEY `pageimage_fk_pageConent_idx` (`fk_pageConent`);

--
-- Indeks for tabel `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`page_id`),
  ADD KEY `page_fk_pageContent_idx` (`fk_pageContent`),
  ADD KEY `page_fk_pageSettings_idx` (`fk_pageSettings`);

--
-- Indeks for tabel `pagesettings`
--
ALTER TABLE `pagesettings`
  ADD PRIMARY KEY (`pagesettings_id`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `pagecontent`
--
ALTER TABLE `pagecontent`
  MODIFY `pagecontent_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tilføj AUTO_INCREMENT i tabel `pageimage`
--
ALTER TABLE `pageimage`
  MODIFY `pageimage_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tilføj AUTO_INCREMENT i tabel `pages`
--
ALTER TABLE `pages`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tilføj AUTO_INCREMENT i tabel `pagesettings`
--
ALTER TABLE `pagesettings`
  MODIFY `pagesettings_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `pageimage`
--
ALTER TABLE `pageimage`
  ADD CONSTRAINT `pageimage_fk_pageConent` FOREIGN KEY (`fk_pageConent`) REFERENCES `pagecontent` (`pagecontent_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Begrænsninger for tabel `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `page_fk_pageContent` FOREIGN KEY (`fk_pageContent`) REFERENCES `pagecontent` (`pagecontent_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `page_fk_pageSettings` FOREIGN KEY (`fk_pageSettings`) REFERENCES `pagesettings` (`pagesettings_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
