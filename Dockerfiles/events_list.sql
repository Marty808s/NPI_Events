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
(1, 'pavel', 'pavel'),
(2, 'alena', 'heslo'),
(3, 'petr', '12345');

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
  `zobrazeno` int unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
);

-- Insert do tabulky events
-- Studia
INSERT INTO events (kategorie, nazev, datum, forma, lektor, anotace, odkaz, cena) VALUES
('Studia', 'Magisterské studium informatiky', '2024-09-01', 'Prezenční', 'Prof. Dr. Jan Novák', 'Kurz poskytuje hloubkové znalosti v oblasti informatiky a přípravu na akademickou kariéru.', 'https://www.npi.cz/vzdelavani/15-vzdelavaci-programy/84544-ict-koordinator-studium-k-vykonu-specializovane-cinnosti-15', 30000),
('Studia', 'Magisterské studium polytechniky', '2024-09-01', 'Prezenční', 'Prof. Dr. Jan Novák', 'Kurz poskytuje hloubkové znalosti v oblasti informatiky a přípravu na akademickou kariéru.', 'https://www.npi.cz/vzdelavani/15-vzdelavaci-programy/84544-ict-koordinator-studium-k-vykonu-specializovane-cinnosti-15', 30000),
('Studia', 'Studium ICT koordinátor', '2024-09-01', 'Prezenční', 'Prof. Dr. Jan Novák', 'Kurz poskytuje hloubkové znalosti v oblasti informatiky a přípravu na akademickou kariéru.', 'https://www.npi.cz/vzdelavani/15-vzdelavaci-programy/84544-ict-koordinator-studium-k-vykonu-specializovane-cinnosti-15', 30000);

-- DIGI kurzy
INSERT INTO events (kategorie, nazev, datum, forma, lektor, anotace, odkaz, cena) VALUES
('DIGI kurzy', 'Základy digitálního marketingu', '2024-05-15', 'Online', 'MgA. Petra Veselá', 'Kurz zavádí účastníky do světa digitálního marketingu, včetně SEO a sociálních sítí.', 'http://www.digiacademy.cz/kurzy/digitalni-marketing', 0);

-- Kmenové VP
INSERT INTO events (kategorie, nazev, datum, forma, lektor, anotace, odkaz, cena) VALUES
('Kmenové VP', 'Veřejná správa a regionální rozvoj', '2024-08-20', 'Semestrální', 'Dr. Tomáš Černý', 'Kurz se zaměřuje na moderní metody a přístupy v oblasti veřejné správy a regionálního rozvoje.', 'http://www.vlada.cz/kurzy/verejna-sprava', 15000),
('Kmenové VP', 'Adaptace dítěte v MŠ', '2024-08-20', 'Semestrální', 'Dr. Tomáš Černý', 'Kurz se zaměřuje na moderní metody a přístupy v oblasti veřejné správy a regionálního rozvoje.', 'http://www.vlada.cz/kurzy/verejna-sprava', 15000);
