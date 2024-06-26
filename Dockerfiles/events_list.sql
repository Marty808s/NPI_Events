-- Nastavení pro databázi
SET NAMES utf8mb4;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

-- Tabulka registrovaných uživatelů
DROP TABLE IF EXISTS `uzivatele`;
CREATE TABLE `uzivatele` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jmeno` varchar(100) NOT NULL,
  `heslo` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jmeno` (`jmeno`)
);

INSERT INTO `uzivatele` (`id`, `jmeno`, `heslo`) VALUES
(4, 'uzivatel1', '$2y$10$EwvOmwHxHmTErmfMeLRRv.QUMNpSURNZNaZ8RLLuP7fPr6E/i0E7y'),
(2, 'admin', '$2y$10$0FjgB2L0J20NYdLzBczf/.lCOac6yYdYpjR0AB8C2i2x8enxfqHOi');


-- Tabulka eventů
DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kategorie` varchar(255) NOT NULL,
  `nazev` varchar(255) NOT NULL,
  `datum` varchar(255) NOT NULL,
  `forma` varchar(255) NOT NULL,
  `lektor` varchar(255) NOT NULL,
  `anotace` varchar(10000) NOT NULL,
  `odkaz` varchar(255) NOT NULL,
  `cena` int,
  `organizator` varchar(255) NOT NULL,
  `zobrazeno` int unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
);

-- Insert do tabulky events
-- Studia
INSERT INTO events (kategorie, nazev, datum, forma, lektor, anotace, odkaz, cena, organizator) VALUES
('Studia', 'Studium ICT koordinátor', '2024-09-01', 'Prezenční', 'Prof. Dr. Jan Novák', 'Kurz poskytuje hloubkové znalosti v oblasti informatiky a přípravu na akademickou kariéru.', 'https://www.npi.cz/vzdelavani/15-vzdelavaci-programy/84544-ict-koordinator-studium-k-vykonu-specializovane-cinnosti-15', 30000, 'admin');

-- DIGI kurzy
INSERT INTO events (kategorie, nazev, datum, forma, lektor, anotace, odkaz, cena, organizator) VALUES
('DIGI kurzy', 'Základy digitálního marketingu', '2024-05-15', 'Online', 'MgA. Petra Veselá', 'Kurz zavádí účastníky do světa digitálního marketingu, včetně SEO a sociálních sítí.', 'http://www.digiacademy.cz/kurzy/digitalni-marketing', 0, 'admin');

-- Kmenové VP
INSERT INTO events (kategorie, nazev, datum, forma, lektor, anotace, odkaz, cena, organizator) VALUES
('Kmenové VP', 'Adaptace dítěte v MŠ', '2024-08-20', 'Prezenční', 'Dr. Tomáš Černý', 'Kurz se zaměřuje na moderní metody při adaptaci dítěte v MŠ.', 'http://www.vlada.cz/kurzy/adaptacevMS', 15000, 'admin');
