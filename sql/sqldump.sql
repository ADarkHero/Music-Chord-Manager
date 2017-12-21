-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 21. Dez 2017 um 08:55
-- Server-Version: 10.1.25-MariaDB
-- PHP-Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `music`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `menu`
--

CREATE TABLE `menu` (
  `MenuID` int(11) NOT NULL,
  `MenuName` text NOT NULL,
  `MenuLink` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `menu`
--

INSERT INTO `menu` (`MenuID`, `MenuName`, `MenuLink`) VALUES
(1, 'Guitar CS', 'http://www.halfhill.com/cheatsheet.gif');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `music`
--

CREATE TABLE `music` (
  `MusicID` int(11) NOT NULL,
  `MusicArtist` text NOT NULL,
  `MusicTitle` text NOT NULL,
  `MusicText` text NOT NULL,
  `MusicNotes` text NOT NULL,
  `MusicLink` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `music`
--

INSERT INTO `music` (`MusicID`, `MusicArtist`, `MusicTitle`, `MusicText`, `MusicNotes`, `MusicLink`) VALUES
(1, 'Ed Sheeran', 'Galway Girl', 'She played the fiddle in an Irish band \r\nBut she fell in love with an English man\r\nKissed her on the neck and then I took her by the hand\r\nSaid baby I just want to dance', 'F#m A E D', 'https://www.azchords.com/e/edsheeran-tabs-34959/galwaygirl-tabs-903431.html'),
(9, 'Saltatio Mortis', 'Eulenspiegel', 'Eulenspiegel Narrenkaiser, \r\ntrage stolz mein Eselsohr.\r\nEulenspiegel Narrenkaiser,\r\nhaltÂ´ der Welt den Spiegel vor!', 'Dm C G A', 'https://tabs.ultimate-guitar.com/tab/saltatio_mortis/eulenspiegel_chords_1095959'),
(10, 'Irie Revoltes', 'Antifaschist', 'Ich wurde so geboren\r\nIch werde so bleiben bis ich sterb\r\nIch wurde so geboren\r\nAntifaschist fÃ¼r immer, fÃ¼r immer', 'A B G B', 'https://genius.com/Irie-revoltes-antifaschist-lyrics'),
(11, 'Jan Hegenberg', 'Dalaran im Kreis', 'Ihr lauft in Dalaran im Kreis\r\nImmer wieder, in Dalaran im Kreis\r\nGeiler ScheiÃŸ, in Dalaran im Kreis\r\nJa immer wieder, in Dalaran im Kreis', '', 'http://www.songtexte.com/songtext/jan-hegenberg/dalaran-im-kreis-g2bfa8452.html'),
(12, 'Slade / Mandowar', 'Far Far Away', 'And I\'m far, far away\r\nWith my head up in the clouds\r\nAnd I\'m far, far away\r\nWith my feet down in the crowds\r\nLetting loose around the world\r\nBut the call of home is loud\r\nStill as loud', 'D D/C# D/B  D/A\r\nG A', 'https://tabs.ultimate-guitar.com/tab/slade/far_far_away_chords_84915'),
(13, 'Kings of the city', 'Make me worse', 'Mother there\'s a side to me you don\'t know\r\nDifferent to the child with the smile in your photo,\r\nMade some decisions some wrong some right, now strangers call my number\r\nWhen I\'m sleeping at night\r\nBut they\'re sinners too\r\nAnd they\'ll only make me worse.\r\nDon\'t let me go\r\nAnd roll away like a penny down a hole in the road.', 'Am G Dm F', 'http://www.songtexte.com/songtext/kings-of-the-city/make-me-worse-7bb68a1c.html'),
(15, 'Timi Hendrix', 'Hunderttausend Meilen', 'Wenn es sein muss lauf\' ich nochmal diese Hunderttausend Meilen\r\n(Hunderttausend Meilen, diese Hunderttausend Meilen)\r\nIch komm bei dir vorbei, halt\' \'n Platz fÃ¼r mich frei\r\nAuf deiner Wolke, denn ich wollte immer nur bei dir sein', 'F#M D A E', 'https://tabs.ultimate-guitar.com/tab/timi_hendrix/hunderttausend_meilen_chords_1907657'),
(16, 'KMPFSPRT', 'Intervention', 'Und ich schrei:\r\nDas ist niemals mein Plan\r\nUnd ich kanns mir nicht anhÃ¶ren\r\nUnd ich weiÃŸ\r\nWir sind bestimmt nicht so gleich wie du denkst , dass es aussieht\r\nIntervention', '', 'https://genius.com/Kmpfsprt-intervention-lyrics'),
(17, 'Die Ã„rzte', 'Wie es geht', 'Bitte geh noch  nicht, ich weiÃŸ, es ist schon  spÃ¤t,\r\nich will dir noch was sagen ich weiÃŸ nur nicht wie es geht.\r\nBleib noch 1 bisschen hier und schau mich nicht so an,\r\nweil ich sonst ganz bestimmt Ã¼berhaupt gar nichts sagen kann.', 'F C A F C', 'https://tabs.ultimate-guitar.com/tab/1047297'),
(18, 'Die Ã„rzte', 'Zu spÃ¤t', 'Doch eines Tages, werd ich mich rÃ¤chen,\r\nich werd die Herzen aller MÃ¤dchen brechen.\r\nDann bin ich eis Star, der in der Zeitung steht,\r\nund dann tut es dir leid, doch dann ist es zu SpÃ¤t', 'G em C D', 'https://tabs.ultimate-guitar.com/tab/1082126'),
(19, 'Donots', 'So long', 'Who\'s to hold up the sky\r\nif not you and I?\r\nSo long so long so long\r\nWho\'s to tame the volcanoes\r\non mountains high?\r\nSo long so long so long', 'Am F C G', 'https://tabs.ultimate-guitar.com/tab/donots/so_long_chords_1482846'),
(38, 'DAT ADAM', 'Party in the Clouds', 'Don\'t tell me how to live my life now\r\nWhat I really can\'t do now, where I really can\'t go now\r\nLeaving all of my problems back at home with the money\r\nToday is all about GÃ¶nnung â€“ in the end I know I\'mma be alright\r\nYeah, yeah, yeah, yeah, yeah!\r\nAnd I know I\'mma be alright\r\nYeah, yeah, yeah, yeah, yeah!\r\nAnd I know I\'mma be alright', 'E Fm B E', 'https://genius.com/Dat-adam-party-in-the-clouds-lyrics');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`MenuID`);

--
-- Indizes für die Tabelle `music`
--
ALTER TABLE `music`
  ADD PRIMARY KEY (`MusicID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `menu`
--
ALTER TABLE `menu`
  MODIFY `MenuID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `music`
--
ALTER TABLE `music`
  MODIFY `MusicID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
