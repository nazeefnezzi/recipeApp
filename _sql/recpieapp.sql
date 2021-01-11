-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 11. Jan 2021 um 13:21
-- Server-Version: 10.3.16-MariaDB
-- PHP-Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `recpieapp`
--
CREATE DATABASE IF NOT EXISTS `recpieapp` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `recpieapp`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `recipes`
--

DROP TABLE IF EXISTS `recipes`;
CREATE TABLE `recipes` (
  `rec_id` int(11) NOT NULL,
  `rec_title` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rec_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rec_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rec_imagePath` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT 'css/logo/noimage.png',
  `rec_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `recipes`
--

INSERT INTO `recipes` (`rec_id`, `rec_title`, `rec_content`, `rec_description`, `rec_imagePath`, `rec_date`) VALUES
(1, 'Tiramisu', 'dolor\r\ncdfds\r\ndolor 1*4\r\ndolor  1/4\r\ndolor 87g\r\ndolor 654\r\ndolor 121', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eaque saepe odit sequi corrupti est iure deserunt aliquid, officia fugiat molestiae officiis aliquam. Velit sequi voluptate repudiandae aperiam tenetur. Vitae error animi similique! Mollitia temporibus quis molestias eaque architecto modi quibusdam accusantium voluptatum eius, repellendus praesentium, perspiciatis, tempore qui quos blanditiis.', 'uploadedImage/642600efkugmxapyrwcbqztlonshivjd1610367317_tirmisu.jpg', '2021-01-11 12:15:17'),
(2, 'Apple grill', 'cupiditate 5/5 \r\ncupiditate  22\r\ncupiditate cupiditate cupiditate \r\ncupiditate  54\r\ncupiditat e \r\nsdfsd 68 \r\nsdfsd 54\r\nsdfgsdgg 21', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Similique cumque odit, sunt autem, fugit, et nesciunt officia temporibus natus maxime nobis delectus error maiores quos consequatur beatae magni? Doloribus quaerat nulla ea provident ad fugiat porro incidunt esse voluptatum laudantium ipsam enim itaque vitae, earum at tempora error eligendi in ab? Pariatur, cupiditate odit doloremque fugit repellendus temporibus dolorem placeat!', 'uploadedImage/793445txghyznwalbjsfpmrdecqkuivo1610367413_applebake.jpg', '2021-01-11 12:16:53'),
(3, 'Sugar Cookies', 'ipsam 21\r\nipsam 54\r\nipsam\r\n4\r\nd\r\nipsam\r\nipsam', 'cupiditate   Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quasi ullam quos fugiat expedita adipisci distinctio suscipit, deleniti asperiores architecto incidunt autem deserunt dignissimos libero aperiam odit quod nemo soluta sit, possimus ipsum ipsam qui. In facilis eum et? Nihil, laborum.', 'uploadedImage/879068dzptjovriufgchyakmqsbexlnw1610367482_sugar.jpg', '2021-01-11 12:18:02');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`rec_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `recipes`
--
ALTER TABLE `recipes`
  MODIFY `rec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
