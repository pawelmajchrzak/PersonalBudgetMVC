-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 31 Sty 2023, 23:19
-- Wersja serwera: 10.4.25-MariaDB
-- Wersja PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `personalbudget`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `expense_category_assigned_to_user_id` int(11) UNSIGNED NOT NULL,
  `payment_method_assigned_to_user_id` int(11) UNSIGNED NOT NULL,
  `amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `date_of_expense` date NOT NULL,
  `expense_comment` varchar(100) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `expenses`
--

INSERT INTO `expenses` (`id`, `user_id`, `expense_category_assigned_to_user_id`, `payment_method_assigned_to_user_id`, `amount`, `date_of_expense`, `expense_comment`) VALUES
(7, 29, 170, 16, '300.00', '2023-01-24', 'Paliwo'),
(8, 29, 172, 16, '150.00', '2023-01-24', 'Zakupy w biedronce'),
(9, 30, 189, 19, '1000.00', '2023-01-26', 'Czynsz'),
(10, 30, 188, 21, '6000.00', '2023-01-24', 'Kupno thermomixa'),
(11, 30, 186, 19, '3000.00', '2023-01-12', 'Za taxówkę'),
(12, 30, 200, 20, '2000.00', '2023-01-13', 'Wdowi grosz');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `expenses_category_assigned_to_users`
--

CREATE TABLE `expenses_category_assigned_to_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `expenses_category_assigned_to_users`
--

INSERT INTO `expenses_category_assigned_to_users` (`id`, `user_id`, `name`) VALUES
(26, 19, 'Dzieci'),
(27, 19, 'Rozrywka'),
(28, 19, 'Wycieczka'),
(29, 19, 'Oszczędności'),
(30, 19, 'Emerytura'),
(31, 19, 'Spłata długów'),
(32, 19, 'Darowizna'),
(33, 19, 'Inne wydatki'),
(34, 21, 'Transport'),
(35, 21, 'Książki'),
(36, 21, 'Jedzenie'),
(37, 21, 'Mieszkanie'),
(38, 21, 'Telekomunikacja'),
(39, 21, 'Opieka zdrowotna'),
(40, 21, 'Ubranie'),
(41, 21, 'Higiena'),
(42, 21, 'Dzieci'),
(43, 21, 'Rozrywka'),
(44, 21, 'Wycieczka'),
(45, 21, 'Oszczędności'),
(46, 21, 'Emerytura'),
(47, 21, 'Spłata długów'),
(48, 21, 'Darowizna'),
(49, 21, 'Inne wydatki'),
(50, 22, 'Transport'),
(51, 22, 'Książki'),
(52, 22, 'Jedzenie'),
(53, 22, 'Mieszkanie'),
(54, 22, 'Telekomunikacja'),
(55, 22, 'Opieka zdrowotna'),
(56, 22, 'Ubranie'),
(57, 22, 'Higiena'),
(58, 22, 'Dzieci'),
(59, 22, 'Rozrywka'),
(60, 22, 'Wycieczka'),
(61, 22, 'Oszczędności'),
(62, 22, 'Emerytura'),
(63, 22, 'Spłata długów'),
(64, 22, 'Darowizna'),
(65, 22, 'Inne wydatki'),
(66, 23, 'Transport'),
(67, 23, 'Książki'),
(68, 23, 'Jedzenie'),
(69, 23, 'Mieszkanie'),
(70, 23, 'Telekomunikacja'),
(71, 23, 'Opieka zdrowotna'),
(72, 23, 'Ubranie'),
(73, 23, 'Higiena'),
(74, 23, 'Dzieci'),
(75, 23, 'Rozrywka'),
(76, 23, 'Wycieczka'),
(77, 23, 'Oszczędności'),
(78, 23, 'Emerytura'),
(79, 23, 'Spłata długów'),
(80, 23, 'Darowizna'),
(81, 23, 'Inne wydatki'),
(82, 24, 'Transport'),
(83, 24, 'Książki'),
(84, 24, 'Jedzenie'),
(85, 24, 'Mieszkanie'),
(86, 24, 'Telekomunikacja'),
(87, 24, 'Opieka zdrowotna'),
(88, 24, 'Ubranie'),
(89, 24, 'Higiena'),
(90, 24, 'Dzieci'),
(91, 24, 'Rozrywka'),
(92, 24, 'Wycieczka'),
(93, 24, 'Oszczędności'),
(94, 24, 'Emerytura'),
(95, 24, 'Spłata długów'),
(96, 24, 'Darowizna'),
(97, 24, 'Inne wydatki'),
(98, 24, 'Gotówka'),
(99, 24, 'Karta płatnicza'),
(100, 24, 'Przelew/BLIK'),
(101, 24, 'Inne'),
(102, 25, 'Transport'),
(103, 25, 'Książki'),
(104, 25, 'Jedzenie'),
(105, 25, 'Mieszkanie'),
(106, 25, 'Telekomunikacja'),
(107, 25, 'Opieka zdrowotna'),
(108, 25, 'Ubranie'),
(109, 25, 'Higiena'),
(110, 25, 'Dzieci'),
(111, 25, 'Rozrywka'),
(112, 25, 'Wycieczka'),
(113, 25, 'Oszczędności'),
(114, 25, 'Emerytura'),
(115, 25, 'Spłata długów'),
(116, 25, 'Darowizna'),
(117, 25, 'Inne wydatki'),
(118, 5, 'costam'),
(119, 5, 'costam'),
(120, 5, 'costam'),
(121, 5, 'costam'),
(122, 26, 'Transport'),
(123, 26, 'Książki'),
(124, 26, 'Jedzenie'),
(125, 26, 'Mieszkanie'),
(126, 26, 'Telekomunikacja'),
(127, 26, 'Opieka zdrowotna'),
(128, 26, 'Ubranie'),
(129, 26, 'Higiena'),
(130, 26, 'Dzieci'),
(131, 26, 'Rozrywka'),
(132, 26, 'Wycieczka'),
(133, 26, 'Oszczędności'),
(134, 26, 'Emerytura'),
(135, 26, 'Spłata długów'),
(136, 26, 'Darowizna'),
(137, 26, 'Inne wydatki'),
(138, 27, 'Transport'),
(139, 27, 'Książki'),
(140, 27, 'Jedzenie'),
(141, 27, 'Mieszkanie'),
(142, 27, 'Telekomunikacja'),
(143, 27, 'Opieka zdrowotna'),
(144, 27, 'Ubranie'),
(145, 27, 'Higiena'),
(146, 27, 'Dzieci'),
(147, 27, 'Rozrywka'),
(148, 27, 'Wycieczka'),
(149, 27, 'Oszczędności'),
(150, 27, 'Emerytura'),
(151, 27, 'Spłata długów'),
(152, 27, 'Darowizna'),
(153, 27, 'Inne wydatki'),
(154, 28, 'Transport'),
(155, 28, 'Książki'),
(156, 28, 'Jedzenie'),
(157, 28, 'Mieszkanie'),
(158, 28, 'Telekomunikacja'),
(159, 28, 'Opieka zdrowotna'),
(160, 28, 'Ubranie'),
(161, 28, 'Higiena'),
(162, 28, 'Dzieci'),
(163, 28, 'Rozrywka'),
(164, 28, 'Wycieczka'),
(165, 28, 'Oszczędności'),
(166, 28, 'Emerytura'),
(167, 28, 'Spłata długów'),
(168, 28, 'Darowizna'),
(169, 28, 'Inne wydatki'),
(170, 29, 'Transport'),
(171, 29, 'Książki'),
(172, 29, 'Jedzenie'),
(173, 29, 'Mieszkanie'),
(174, 29, 'Telekomunikacja'),
(175, 29, 'Opieka zdrowotna'),
(176, 29, 'Ubranie'),
(177, 29, 'Higiena'),
(178, 29, 'Dzieci'),
(179, 29, 'Rozrywka'),
(180, 29, 'Wycieczka'),
(181, 29, 'Oszczędności'),
(182, 29, 'Emerytura'),
(183, 29, 'Spłata długów'),
(184, 29, 'Darowizna'),
(185, 29, 'Inne wydatki'),
(186, 30, 'Transport'),
(187, 30, 'Książki'),
(188, 30, 'Jedzenie'),
(189, 30, 'Mieszkanie'),
(190, 30, 'Telekomunikacja'),
(191, 30, 'Opieka zdrowotna'),
(192, 30, 'Ubranie'),
(193, 30, 'Higiena'),
(194, 30, 'Dzieci'),
(195, 30, 'Rozrywka'),
(196, 30, 'Wycieczka'),
(197, 30, 'Oszczędności'),
(198, 30, 'Emerytura'),
(199, 30, 'Spłata długów'),
(200, 30, 'Darowizna'),
(201, 30, 'Inne wydatki');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `expenses_category_default`
--

CREATE TABLE `expenses_category_default` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `expenses_category_default`
--

INSERT INTO `expenses_category_default` (`id`, `name`) VALUES
(1, 'Transport'),
(2, 'Książki'),
(3, 'Jedzenie'),
(4, 'Mieszkanie'),
(5, 'Telekomunikacja'),
(6, 'Opieka zdrowotna'),
(7, 'Ubranie'),
(8, 'Higiena'),
(9, 'Dzieci'),
(10, 'Rozrywka'),
(11, 'Wycieczka'),
(12, 'Oszczędności'),
(13, 'Emerytura'),
(14, 'Spłata długów'),
(15, 'Darowizna'),
(16, 'Inne wydatki');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `incomes`
--

CREATE TABLE `incomes` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `income_category_assigned_to_user_id` int(11) UNSIGNED NOT NULL,
  `amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `date_of_income` date NOT NULL,
  `income_comment` varchar(100) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `incomes`
--

INSERT INTO `incomes` (`id`, `user_id`, `income_category_assigned_to_user_id`, `amount`, `date_of_income`, `income_comment`) VALUES
(13, 29, 49, '2000.00', '2023-01-22', 'Wypłata za nagodziny'),
(14, 29, 52, '500.00', '2023-01-06', '500 plus'),
(15, 30, 53, '5000.00', '2023-01-23', 'Z pracę w firmie krzak w styczniu'),
(16, 30, 54, '25.00', '2023-01-28', 'Z lokaty'),
(17, 30, 54, '30.00', '2023-02-09', 'Konto oszcz'),
(18, 30, 54, '30.00', '2022-12-22', 'Kryptowaluty'),
(19, 30, 54, '30.00', '2023-01-11', 'Kryptowaluty'),
(20, 30, 55, '5000.00', '2023-01-26', 'Sprzedaż w sklepie'),
(21, 29, 52, '6000.00', '2023-01-26', 'Tajemnica'),
(22, 30, 55, '150.00', '2023-02-15', 'Sprzedaż starych sukienek');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `incomes_category_assigned_to_users`
--

CREATE TABLE `incomes_category_assigned_to_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `incomes_category_assigned_to_users`
--

INSERT INTO `incomes_category_assigned_to_users` (`id`, `user_id`, `name`) VALUES
(26, 23, 'Odsetki bankowe'),
(27, 23, 'Sprzedaż online'),
(28, 23, 'Inne'),
(29, 24, 'Wynagrodzenie'),
(30, 24, 'Odsetki bankowe'),
(31, 24, 'Sprzedaż online'),
(32, 24, 'Inne'),
(33, 25, 'Wynagrodzenie'),
(34, 25, 'Odsetki bankowe'),
(35, 25, 'Sprzedaż online'),
(36, 25, 'Inne'),
(37, 26, 'Wynagrodzenie'),
(38, 26, 'Odsetki bankowe'),
(39, 26, 'Sprzedaż online'),
(40, 26, 'Inne'),
(41, 27, 'Wynagrodzenie'),
(42, 27, 'Odsetki bankowe'),
(43, 27, 'Sprzedaż online'),
(44, 27, 'Inne'),
(45, 28, 'Wynagrodzenie'),
(46, 28, 'Odsetki bankowe'),
(47, 28, 'Sprzedaż online'),
(48, 28, 'Inne'),
(49, 29, 'Wynagrodzenie'),
(50, 29, 'Odsetki bankowe'),
(51, 29, 'Sprzedaż online'),
(52, 29, 'Inne'),
(53, 30, 'Wynagrodzenie'),
(54, 30, 'Odsetki bankowe'),
(55, 30, 'Sprzedaż online'),
(56, 30, 'Inne');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `incomes_category_default`
--

CREATE TABLE `incomes_category_default` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `incomes_category_default`
--

INSERT INTO `incomes_category_default` (`id`, `name`) VALUES
(1, 'Wynagrodzenie'),
(2, 'Odsetki bankowe'),
(3, 'Sprzedaż online'),
(4, 'Inne');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `payment_methods_assigned_to_users`
--

CREATE TABLE `payment_methods_assigned_to_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `payment_methods_assigned_to_users`
--

INSERT INTO `payment_methods_assigned_to_users` (`id`, `user_id`, `name`) VALUES
(15, 29, 'Gotówka'),
(16, 29, 'Karta płatnicza'),
(17, 29, 'Przelew/BLIK'),
(18, 29, 'Inne'),
(19, 30, 'Gotówka'),
(20, 30, 'Karta płatnicza'),
(21, 30, 'Przelew/BLIK'),
(22, 30, 'Inne');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `payment_methods_default`
--

CREATE TABLE `payment_methods_default` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `payment_methods_default`
--

INSERT INTO `payment_methods_default` (`id`, `name`) VALUES
(1, 'Gotówka'),
(2, 'Karta płatnicza'),
(3, 'Przelew/BLIK'),
(4, 'Inne');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES
(29, 'Adam', '$2y$10$QgRs04m9Pw6RoSVNmtrXCOS6rrLYM9mO5c2ww5MiAa0VmTdF07wWS', 'adam@adam.pl'),
(30, 'Paweł', '$2y$10$MGQITBRcxQrdLSZFKdkvb.08xUB8UaA3L7Ks23uSUsDvP2noxS7Ba', 'pawelmaj0@gmail.com');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `expenses_category_assigned_to_users`
--
ALTER TABLE `expenses_category_assigned_to_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `expenses_category_default`
--
ALTER TABLE `expenses_category_default`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `incomes`
--
ALTER TABLE `incomes`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `incomes_category_assigned_to_users`
--
ALTER TABLE `incomes_category_assigned_to_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `incomes_category_default`
--
ALTER TABLE `incomes_category_default`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `payment_methods_assigned_to_users`
--
ALTER TABLE `payment_methods_assigned_to_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `payment_methods_default`
--
ALTER TABLE `payment_methods_default`
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
-- AUTO_INCREMENT dla tabeli `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `expenses_category_assigned_to_users`
--
ALTER TABLE `expenses_category_assigned_to_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT dla tabeli `expenses_category_default`
--
ALTER TABLE `expenses_category_default`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT dla tabeli `incomes`
--
ALTER TABLE `incomes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT dla tabeli `incomes_category_assigned_to_users`
--
ALTER TABLE `incomes_category_assigned_to_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT dla tabeli `incomes_category_default`
--
ALTER TABLE `incomes_category_default`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `payment_methods_assigned_to_users`
--
ALTER TABLE `payment_methods_assigned_to_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT dla tabeli `payment_methods_default`
--
ALTER TABLE `payment_methods_default`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
