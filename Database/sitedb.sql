-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 26 Cze 2018, 02:11
-- Wersja serwera: 10.1.21-MariaDB
-- Wersja PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `sitedb`
--
CREATE DATABASE IF NOT EXISTS `sitedb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `sitedb`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(30) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `categories`
--

INSERT INTO `categories` (`ID`, `Name`) VALUES
(1, 'IT'),
(2, 'Mathematics'),
(3, 'History'),
(4, 'Geography'),
(5, 'Movies'),
(6, 'Books'),
(7, 'Video Games');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `questions`
--

CREATE TABLE `questions` (
  `ID` int(11) NOT NULL,
  `Question` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `A` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `B` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `C` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `D` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Correct` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `questions`
--

INSERT INTO `questions` (`ID`, `Question`, `A`, `B`, `C`, `D`, `Correct`, `CategoryID`, `UserID`) VALUES
(1, 'What started in 1939', 'World War I', 'Vietnam War', 'Industrial Revolution', 'World War II', 'D', 3, 1),
(2, 'Who creates the Iphone line of smartphones:', 'Microsoft', 'Apple', 'Nintendo', 'Samsung', 'B', 1, 1),
(3, 'Who was Luke Skywalkers father in the Star Wars series: ', 'Darth Vader', 'Han Solo', 'Jabba', 'Jar Jar Binks', 'A', 5, 1),
(4, 'Which of the following products wasn\'t developed by Microsoft:', 'Windows OS', 'Xbox Video Game Console', 'Nokia Lumia Smartphone', 'Firefox browser', 'D', 1, 1),
(5, 'Which of the following consoles is not an unlicensed famicom clone:', 'Pegasus', 'Dendy', 'NES', 'Ending-Man Terminator', 'C', 7, 1),
(6, 'How many world exist in the first Super Mario Games on the NES', '4', '8', '12', '24', 'B', 7, 1),
(7, 'How many continents are there in the world?', '5', '6', '7', '8', 'c', 4, 1),
(8, 'The Witcher series originated from', 'Russia', 'Poland', 'Germany', 'Turkey', 'B', 6, 1),
(9, '2 + 2 equals', '4', '-4', '3', '5', 'A', 2, 1),
(10, 'Google is most famous for', 'Google Chrome', 'Google search engine', 'Google+', 'Google Earth', 'B', 1, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `stats`
--

CREATE TABLE `stats` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `QuizzesCompleted` int(11) NOT NULL,
  `PointsEarned` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `stats`
--

INSERT INTO `stats` (`Id`, `UserId`, `QuizzesCompleted`, `PointsEarned`) VALUES
(1, 1, 10, 15);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `Login` varchar(30) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Password` varchar(200) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Email` varchar(50) NOT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT '1',
  `Rank` varchar(30) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL DEFAULT 'User'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`ID`, `Login`, `Password`, `Email`, `IsActive`, `Rank`) VALUES
(1, 'Administrator', '$1$cyiyn6UQ$i917CHMeJmkaT1Ck3ngFm.', 'admin@admin.pl', 1, 'Administrator');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `questions_ibfk_1` (`UserID`),
  ADD KEY `questions_ibfk_2` (`CategoryID`);

--
-- Indexes for table `stats`
--
ALTER TABLE `stats`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT dla tabeli `questions`
--
ALTER TABLE `questions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT dla tabeli `stats`
--
ALTER TABLE `stats`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `questions_ibfk_2` FOREIGN KEY (`CategoryID`) REFERENCES `categories` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
