-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 21 Sie 2022, 20:21
-- Wersja serwera: 10.4.19-MariaDB
-- Wersja PHP: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `book-site`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `books-info`
--

CREATE TABLE `books-info` (
  `book_id` int(11) NOT NULL,
  `book_title` text COLLATE utf8_polish_ci NOT NULL,
  `book_author` text COLLATE utf8_polish_ci NOT NULL,
  `book_desc` text COLLATE utf8_polish_ci NOT NULL,
  `book_categories` text COLLATE utf8_polish_ci NOT NULL,
  `book_rate` int(11) NOT NULL,
  `path` text COLLATE utf8_polish_ci NOT NULL,
  `pages` int(11) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `books-info`
--

INSERT INTO `books-info` (`book_id`, `book_title`, `book_author`, `book_desc`, `book_categories`, `book_rate`, `path`, `pages`, `added_by`, `date`) VALUES
(1, 'książka', 'autor', 'To jest książka', 'sci-fi', 3, 'img/book-cover.jpg', 230, 1, '2022-01-02'),
(2, 'książka2', 'autor2', 'To jest książka nr2', 'komedia', 5, 'img/book-cover.jpg', 450, 1, '2022-02-05'),
(3, 'książka fajna taka', 'ja', 'na szybko napisane', 'sci-fi', 5, 'img/book-cover.jpg', 501, 1, '2022-06-30'),
(4, 'Książka3', 'ja', 'Kr&oacute;tki opis', 'sci-fi', 4, 'img/book-cover.jpg', 2137, 1, '2022-08-21');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `books-read`
--

CREATE TABLE `books-read` (
  `read_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `reader_id` int(11) NOT NULL,
  `pages_read` int(11) NOT NULL,
  `last_update` date NOT NULL,
  `isFinished` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `books-read`
--

INSERT INTO `books-read` (`read_id`, `book_id`, `reader_id`, `pages_read`, `last_update`, `isFinished`) VALUES
(1, 1, 1, 230, '2022-01-03', 1),
(3, 2, 2, 0, '2022-07-08', 0),
(4, 3, 1, 501, '2022-07-28', 1),
(5, 2, 1, 450, '2022-07-28', 1),
(6, 1, 28, 230, '2022-08-16', 1),
(7, 2, 28, 0, '2022-07-29', 0),
(8, 4, 1, 15, '2022-08-21', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `books-reviews`
--

CREATE TABLE `books-reviews` (
  `review-id` int(11) NOT NULL,
  `stars` int(11) NOT NULL,
  `description` text COLLATE utf8_polish_ci NOT NULL,
  `reviewer_id` int(11) NOT NULL,
  `book_reviewed_id` int(11) NOT NULL,
  `when_added` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `books-reviews`
--

INSERT INTO `books-reviews` (`review-id`, `stars`, `description`, `reviewer_id`, `book_reviewed_id`, `when_added`) VALUES
(10, 1, 'ww', 1, 1, '2022-07-07'),
(11, 5, 'Super', 28, 1, '2022-07-07'),
(12, 5, 'www', 28, 2, '2022-07-07'),
(13, 5, 'pwdajdawejj', 1, 3, '2022-07-08'),
(14, 5, 'Fajna', 1, 2, '2022-07-28'),
(15, 5, 'Nowa recenzja', 28, 3, '2022-07-29'),
(16, 4, 'Spoko', 1, 4, '2022-08-21');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `books-to-check`
--

CREATE TABLE `books-to-check` (
  `checkid` int(11) NOT NULL,
  `name` text COLLATE utf8_polish_ci NOT NULL,
  `description` text COLLATE utf8_polish_ci NOT NULL,
  `author` text COLLATE utf8_polish_ci NOT NULL,
  `addedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `books-to-check`
--

INSERT INTO `books-to-check` (`checkid`, `name`, `description`, `author`, `addedBy`) VALUES
(2, 'Książka4', 'www', 'nowy', 1),
(4, 'Książka5', 'www', 'www', 1),
(5, 'Książka5', 'www', 'www', 1),
(6, 'Nowa książka', 'Prosta Książka', 'autor', 28);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `eventlog`
--

CREATE TABLE `eventlog` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `event` text COLLATE utf8_polish_ci NOT NULL,
  `timestamp` date NOT NULL,
  `ipaddress` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `eventlog`
--

INSERT INTO `eventlog` (`id`, `userid`, `event`, `timestamp`, `ipaddress`) VALUES
(9, 28, 'b_startreading', '2022-07-29', '127.0.0.1'),
(10, 28, 'b_changedpages', '2022-07-29', '127.0.0.1'),
(13, 1, 'b_changedpages', '2022-07-29', '127.0.0.1'),
(14, 1, 'b_changedpages', '2022-07-29', '127.0.0.1'),
(15, 1, 'b_changedpages', '2022-07-29', '127.0.0.1'),
(18, 28, 'b_changedpages', '2022-07-29', '127.0.0.1'),
(19, 28, 'b_startreading', '2022-07-29', '127.0.0.1'),
(20, 28, 'b_changedpages', '2022-07-29', '127.0.0.1'),
(21, 28, 'b_newbook', '2022-07-29', '127.0.0.1'),
(22, 28, 'b_newreview', '2022-07-29', '127.0.0.1'),
(27, 1, 'u_chagemail', '2022-08-08', '127.0.0.1'),
(28, 1, 'u_chagemail', '2022-08-08', '127.0.0.1'),
(32, 1, 'u_changepass', '2022-08-10', '127.0.0.1'),
(36, 1, 'f_addfriend', '2022-08-15', '127.0.0.1'),
(37, 1, 'f_addfriend', '2022-08-15', '127.0.0.1'),
(38, 1, 'f_addfriend', '2022-08-15', '127.0.0.1'),
(39, 1, 'f_addfriend', '2022-08-15', '127.0.0.1'),
(40, 1, 'f_addfriend', '2022-08-15', '127.0.0.1'),
(41, 1, 'f_addfriend', '2022-08-15', '127.0.0.1'),
(42, 1, 'f_addfriend', '2022-08-15', '127.0.0.1'),
(43, 1, 'f_addfriend', '2022-08-15', '127.0.0.1'),
(45, 1, 'f_addfriend', '2022-08-16', '127.0.0.1'),
(46, 1, 'f_addfriend', '2022-08-16', '127.0.0.1'),
(48, 1, 'f_deletefriend', '2022-08-16', '127.0.0.1'),
(49, 1, 'f_deletefriend', '2022-08-16', '127.0.0.1'),
(50, 1, 'f_addfriend', '2022-08-16', '127.0.0.1'),
(51, 1, 'f_addfriend', '2022-08-16', '127.0.0.1'),
(58, 28, 'b_changedpages', '2022-08-16', '127.0.0.1'),
(63, 1, 'f_deletefriend', '2022-08-18', '127.0.0.1'),
(64, 1, 'f_deletefriend', '2022-08-18', '127.0.0.1'),
(65, 1, 'f_deletefriend', '2022-08-18', '127.0.0.1'),
(66, 1, 'f_addfriend', '2022-08-18', '127.0.0.1'),
(67, 1, 'f_addfriend', '2022-08-18', '127.0.0.1'),
(68, 28, 'f_addfriend', '2022-08-18', '127.0.0.1'),
(69, 28, 'f_deletefriend', '2022-08-18', '127.0.0.1'),
(70, 28, 'f_addfriend', '2022-08-18', '127.0.0.1'),
(71, 1, 'b_startreading', '2022-08-21', '127.0.0.1'),
(72, 1, 'b_changedpages', '2022-08-21', '127.0.0.1'),
(73, 1, 'b_changedpages', '2022-08-21', '127.0.0.1'),
(74, 1, 'b_newreview', '2022-08-21', '127.0.0.1');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` text COLLATE utf8_polish_ci NOT NULL,
  `pass` text COLLATE utf8_polish_ci NOT NULL,
  `email` text COLLATE utf8_polish_ci NOT NULL,
  `friends` text COLLATE utf8_polish_ci NOT NULL,
  `isAdmin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `username`, `pass`, `email`, `friends`, `isAdmin`) VALUES
(1, 'test', '$2y$10$m1EaJ9lZh8iA9FgRZSqUTeH88x92yMzWM59Hmjdd0kBXHoSJf2e5G', 'test2@test.com', '28, 2', 0),
(2, 'test2', '$2y$10$PXBaTo14vSV3iSj8iOUluuoUXsdGPCTUAjEkqnjYQMZLlmbfYPGUi', 'test2&commat;test&period;com', '', 0),
(3, 'test1', '$2y$10$AZ8eIxBcnjPOZpjTAjgBu.pyz9z3J1BFS10iS9uW3F9xxkhmigCX2 ', 'test1&commat;test&period;com', '', 0),
(4, 'test3', '$2y$10$SfFJ1sUcbdyZqOT3Lb08FeX4l4e0a6tCT6UWFR.B/gR4SdwjY6/PS', 'test3@test.com', '1', 0),
(5, 'testuser', '$2y$10$KKPjFRhXxXTRhow35MMmLuuOZaCk/sb5HyyAkcwsfux2MnJKVknK6', 'test4@test.com', '', 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `books-info`
--
ALTER TABLE `books-info`
  ADD PRIMARY KEY (`book_id`);

--
-- Indeksy dla tabeli `books-read`
--
ALTER TABLE `books-read`
  ADD PRIMARY KEY (`read_id`);

--
-- Indeksy dla tabeli `books-reviews`
--
ALTER TABLE `books-reviews`
  ADD PRIMARY KEY (`review-id`);

--
-- Indeksy dla tabeli `books-to-check`
--
ALTER TABLE `books-to-check`
  ADD PRIMARY KEY (`checkid`);

--
-- Indeksy dla tabeli `eventlog`
--
ALTER TABLE `eventlog`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `books-info`
--
ALTER TABLE `books-info`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `books-read`
--
ALTER TABLE `books-read`
  MODIFY `read_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `books-reviews`
--
ALTER TABLE `books-reviews`
  MODIFY `review-id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT dla tabeli `books-to-check`
--
ALTER TABLE `books-to-check`
  MODIFY `checkid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `eventlog`
--
ALTER TABLE `eventlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
