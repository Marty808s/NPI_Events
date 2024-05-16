-- Nastavení pro databázi
SET NAMES utf8mb4;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

-- Tabulka registrovaných uživatelů (mohou nahrávat informace o filmech)
DROP TABLE IF EXISTS `uzivatele`;
CREATE TABLE `uzivatele` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jmeno` varchar(100) NOT NULL,
  `heslo` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jmeno` (`jmeno`)
);

INSERT INTO `uzivatele` (`id`, `jmeno`, `heslo`) VALUES
(1, 'pavel', 'pavel'),
(2, 'alena', 'heslo'),
(3, 'petr', '12345');

-- Tabulka filmů
CREATE TABLE `events` (
  `kategorie` varchar(255) NOT NULL,
  `nazev` varchar(255) NOT NULL,
  `datum` varchar(255) NOT NULL,
  `forma` varchar(255) NOT NULL,
  `lektor` varchar(255) NOT NULL,
  `anotace` varchar(10000) NOT NULL,
  `odkaz` varchar(255) NOT NULL,
  `cena` int,
  `zobrazeno` int unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`nazev`)
);
