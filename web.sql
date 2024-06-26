-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: 127.0.0.1
-- Χρόνος δημιουργίας: 02 Απρ 2024 στις 22:40:08
-- Έκδοση διακομιστή: 10.4.27-MariaDB
-- Έκδοση PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `web`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `announcements`
--

CREATE TABLE `announcements` (
  `announcement_id` int(10) UNSIGNED NOT NULL,
  `civilian_id` int(4) UNSIGNED DEFAULT NULL,
  `announ_status` enum('free','updated','ended') DEFAULT 'free',
  `created_at` date DEFAULT curdate(),
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `announcements`
--

INSERT INTO `announcements` (`announcement_id`, `civilian_id`, `announ_status`, `created_at`, `updated_at`) VALUES
(1, NULL, '', '2023-12-26', '2023-12-26'),
(2, NULL, '', '2023-12-26', '2023-12-26'),
(3, NULL, '', '2023-12-26', '2023-12-26'),
(4, NULL, '', '2023-12-26', '2023-12-26'),
(5, NULL, '', '2023-12-26', '2023-12-26'),
(6, NULL, '', '2023-12-26', '2023-12-26'),
(7, NULL, '', '2023-12-26', '2023-12-26'),
(8, NULL, '', '2023-12-26', '2023-12-26'),
(9, NULL, '', '2023-12-27', '2023-12-27'),
(10, NULL, '', '2023-12-27', '2023-12-27'),
(11, NULL, '', '2023-12-27', '2023-12-27'),
(12, NULL, '', '2023-12-27', '2023-12-27'),
(13, NULL, '', '2023-12-27', '2023-12-27'),
(16, NULL, '', '2023-12-27', '2023-12-27'),
(18, NULL, '', '2023-12-27', '2023-12-27'),
(24, NULL, '', '2023-12-27', '2023-12-27'),
(25, NULL, '', '2023-12-27', '2023-12-27'),
(26, NULL, '', '2023-12-27', '2023-12-27'),
(27, NULL, '', '2023-12-27', '2023-12-27'),
(28, NULL, '', '2023-12-27', '2023-12-27'),
(29, NULL, '', '2023-12-27', '2023-12-27'),
(30, NULL, '', '2023-12-27', '2023-12-27'),
(31, NULL, '', '2023-12-27', '2023-12-27'),
(32, NULL, '', '2024-01-02', '2024-01-02'),
(33, NULL, '', '2024-01-02', '2024-01-02'),
(34, NULL, '', '2024-01-02', '2024-01-02'),
(35, NULL, '', '2024-01-02', '2024-01-02'),
(36, NULL, '', '2024-01-02', '2024-01-02'),
(37, NULL, '', '2024-01-03', '2024-01-03'),
(38, NULL, '', '2024-01-03', '2024-01-03');

--
-- Δείκτες `announcements`
--
DELIMITER $$
CREATE TRIGGER `announcements_before_update` BEFORE UPDATE ON `announcements` FOR EACH ROW SET NEW.updated_at = CURRENT_DATE
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `cargo`
--

CREATE TABLE `cargo` (
  `cargo_id` int(3) UNSIGNED NOT NULL,
  `amount` int(3) DEFAULT 0,
  `vehicles_id` int(4) UNSIGNED NOT NULL,
  `inventory_id` int(3) UNSIGNED DEFAULT NULL,
  `items_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `cargo`
--

INSERT INTO `cargo` (`cargo_id`, `amount`, `vehicles_id`, `inventory_id`, `items_id`) VALUES
(16, 0, 2, NULL, 38),
(17, 0, 2, NULL, 38),
(18, 123, 2, NULL, 104),
(19, 123, 2, NULL, 104),
(20, 555, 2, NULL, 102),
(21, 555, 2, NULL, 102),
(22, 2147483647, 2, NULL, 102),
(23, 2147483647, 2, NULL, 102),
(24, 2, 2, NULL, 17),
(25, 2, 2, NULL, 17),
(26, 2, 2, NULL, 17),
(27, 2, 2, NULL, 17),
(28, 2, 2, NULL, 17),
(29, 2, 2, NULL, 17),
(30, 2, 2, NULL, 17),
(31, 2, 2, NULL, 17),
(32, 2, 2, NULL, 17),
(33, 2, 2, NULL, 17),
(34, 2, 2, NULL, 17),
(35, 2, 2, NULL, 17),
(36, 2, 2, NULL, 17),
(37, 2, 2, NULL, 17),
(38, 2, 2, NULL, 17),
(39, 2, 2, NULL, 17),
(40, 2, 2, NULL, 17),
(41, 2, 2, NULL, 17),
(42, 2, 2, NULL, 17),
(43, 2, 2, NULL, 17),
(44, 2, 2, NULL, 17),
(45, 2, 2, NULL, 17),
(46, 2, 2, NULL, 17),
(47, 2, 2, NULL, 17),
(48, 2, 2, NULL, 17),
(49, 2, 2, NULL, 17),
(50, 2, 2, 25, 17),
(51, 2, 2, 25, 17),
(52, 2, 2, 25, 17),
(53, 2, 2, 25, 17),
(54, 2, 3, 25, 17);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `category`
--

CREATE TABLE `category` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(30) NOT NULL DEFAULT 'unknown'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `category`
--

INSERT INTO `category` (`id`, `category_name`) VALUES
(5, 'Food'),
(6, 'Beverages'),
(7, 'Clothing'),
(8, 'Hacker of class'),
(9, '2d hacker'),
(10, ''),
(11, 'Test'),
(13, '-----'),
(14, 'Flood'),
(15, 'new cat'),
(16, 'Medical Supplies'),
(19, 'Shoes'),
(21, 'Personal Hygiene '),
(22, 'Cleaning Supplies'),
(23, 'Tools'),
(24, 'Kitchen Supplies'),
(25, 'Baby Essentials'),
(26, 'Insect Repellents'),
(27, 'Electronic Devices'),
(28, 'Cold weather'),
(29, 'Animal Food'),
(30, 'Financial support'),
(31, 'stathios'),
(33, 'cake');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `civilian`
--

CREATE TABLE `civilian` (
  `civilian_id` int(4) UNSIGNED NOT NULL,
  `users_id` int(4) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL DEFAULT 'unknown',
  `lastname` varchar(30) NOT NULL DEFAULT 'unknown',
  `address` varchar(50) NOT NULL,
  `phone_num` bigint(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `civilian`
--

INSERT INTO `civilian` (`civilian_id`, `users_id`, `name`, `lastname`, `address`, `phone_num`) VALUES
(34, 37, 'ef', 'sta', 'ΜΑΙΖΩΝΟΣ 45', 6980905191),
(35, 38, 'gly', 'ka', 'maizwnos 45', 6980905191),
(36, 39, 'gl', 'ka', 'maizwnos 45', 6980905191),
(37, 40, 'new', 'new', 'new', 6987654321),
(38, 41, 'w', 'w', 'w', 6980905191),
(39, 42, 'as', 'as', 'as', 6980905191),
(40, 43, 'q', 'q', 'q', 6980905191),
(41, 44, 'd', 'd', 'd', 6980905191),
(42, 45, 'm', 'm', 'm', 6980905191),
(43, 46, 'c', 'c', 'c', 6980905191),
(44, 47, 'bb', 'bb', 'bb', 6980905191),
(45, 48, 'az', 'za', 'azz', 6980905191),
(46, 49, 'qwe', 'qwe', 'qwe', 6980905191),
(47, 50, 'qweqew', 'qweqwe', 'qweqw', 6980905191),
(48, 51, 'ASD', 'ASD', 'ASDA', 6980905191),
(49, 52, 'ad', 'adas', 'sad', 6980905191),
(50, 53, 'asaa', 'asaa', 'asa', 6980905191),
(51, 56, 'ga', 'ga', 'ga', 6980905191),
(52, 57, 'v', 'v', 'v', 6980905191),
(53, 58, 'ΕΥΣΤΑΘΙΟΣ', 'ΡΑΒΑΝΟΣ', 'ΜΑΙΖΩΝΟΣ 45', 6980905191),
(54, 59, 'sdasdad', 'asdasdas', 'asdasda', 6980905191),
(55, 60, 'ΕΥΣΤΑΘΙΟΣ', 'ΡΑΒΑΝΟΣ', 'ΜΑΙΖΩΝΟΣ 45', 6980905191),
(56, 61, 'ΕΥΣΤΑΘΙΟΣ', 'ΡΑΒΑΝΟΣ', 'ΜΑΙΖΩΝΟΣ 45', 6980905191),
(57, 62, 'University', 'Patras, Computer Engineering a', 'ΜΑΙΖΩΝΟΣ 45', 6980905191),
(58, 63, 'asdasdasd', 'asdasdasd', 'asdasdads', 6980905191),
(59, 64, 'fasdfsadfsdf', 'sdfsdfsdf', 'sdfsdafsdf', 6980905191),
(60, 65, 'asdasd', 'asdasd', 'asdad', 6980905191),
(61, 66, 'asDFSAD', 'ADSFASD', 'ΜΑΙΖΩΝΟΣ 45', 6980905191),
(62, 67, 'zaxaroyla', 'malliarh', 'argyrokastritoy 7', 6974094365),
(65, 103, 'aas', 'ass', '', 6980905191),
(66, 118, 'za', 'xa', '', 6980905191),
(67, 121, 'asd', 'asd', '', 6980905191),
(68, 122, 'ΕΥΣΤΑΘΙΟΣ', 'ΡΑΒΑΝΟΣ', '', 6980905191),
(69, 123, 'lo', 'lo', '', 6980905191),
(70, 124, 'te', 'te', '', 6980905191),
(71, 125, 'xa', 'xa', '', 6980905191),
(72, 126, 'xaxa', 'xaxa', '', 6980905191),
(73, 127, 'che', 'ck', '', 6980905191),
(74, 128, 'ch', 'e', '', 6980905191),
(75, 129, 'm', 'u', '', 6980905191),
(76, 130, 'ΕΥΣΤΑΘΙΟΣ', 'ΡΑΒΑΝΟΣ', '', 6980905191),
(77, 131, 'oo', 'oo', '', 6980905191),
(78, 132, '1a', '1a', '', 6980905191),
(79, 133, 'volde', 'mort', '', 6980905191),
(80, 134, 'bad', 'guy', '', 6980905191),
(81, 135, 'ha', 'bibi', '', 6980905191),
(82, 136, 'hmm', 'hmm', '', 6980905191),
(83, 137, 'aixx', 'aixx', '', 6980905191),
(84, 138, 'etoimh', 'etoimh', '', 6980905191),
(85, 139, 'etoimhh', 'etoimhh', '', 6980905191);

--
-- Δείκτες `civilian`
--
DELIMITER $$
CREATE TRIGGER `after_delete_civilian` AFTER DELETE ON `civilian` FOR EACH ROW BEGIN
    DELETE FROM users WHERE users_id = OLD.users_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `details`
--

CREATE TABLE `details` (
  `detail_id` int(10) UNSIGNED NOT NULL,
  `id` int(10) UNSIGNED NOT NULL,
  `detail_name` varchar(50) DEFAULT 'unknown',
  `detail_value` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `details`
--

INSERT INTO `details` (`detail_id`, `id`, `detail_name`, `detail_value`) VALUES
(16, 104, 'asd', 0),
(17, 105, '1kj', 1);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `inventory`
--

CREATE TABLE `inventory` (
  `inventory_id` int(3) UNSIGNED NOT NULL,
  `id` int(10) UNSIGNED NOT NULL,
  `amount` int(3) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `inventory`
--

INSERT INTO `inventory` (`inventory_id`, `id`, `amount`) VALUES
(16, 16, 5),
(17, 25, 6),
(18, 19, 7),
(19, 30, 9),
(20, 40, 11),
(21, 62, 13),
(22, 46, 15),
(23, 36, 17),
(24, 52, 19),
(25, 17, -59),
(26, 16, 1000),
(27, 17, 1000),
(28, 18, 1000),
(29, 19, 1000),
(30, 20, 1000),
(31, 21, 1000),
(32, 22, 1000),
(33, 23, 1000),
(34, 24, 1000),
(35, 25, 1000),
(36, 26, 1000),
(37, 28, 1000),
(38, 29, 1000),
(39, 30, 1000),
(40, 31, 1000),
(41, 32, 1000),
(42, 33, 1000),
(43, 34, 1000),
(44, 35, 1000),
(45, 36, 1000),
(46, 37, 1000),
(47, 38, 1000),
(48, 39, 1000),
(49, 40, 1000),
(50, 41, 1000),
(51, 42, 1000),
(52, 43, 1000),
(53, 44, 1000),
(54, 45, 1000),
(55, 46, 1000),
(56, 47, 1000),
(57, 48, 1000),
(58, 49, 1000),
(59, 50, 1000),
(60, 51, 1000),
(61, 52, 1000),
(62, 53, 1000),
(63, 54, 1000),
(64, 55, 1000),
(65, 56, 1000),
(66, 57, 1000),
(67, 58, 1000),
(68, 59, 1000),
(69, 60, 1000),
(70, 61, 1000),
(71, 62, 1000),
(72, 63, 1000),
(73, 64, 1000),
(74, 65, 1000),
(75, 66, 1000),
(76, 67, 1000),
(77, 68, 1000),
(78, 69, 1000),
(79, 70, 1000),
(80, 71, 1000),
(81, 72, 1000),
(82, 73, 1000),
(83, 74, 1000),
(84, 75, 1000),
(85, 76, 1000),
(86, 77, 1000),
(87, 78, 1000),
(88, 79, 1000),
(89, 80, 1000),
(90, 81, 1000),
(91, 82, 1000),
(92, 83, 1000),
(93, 84, 1000),
(94, 85, 1000),
(95, 86, 1000),
(96, 87, 1000),
(97, 88, 1000),
(98, 89, 1000),
(99, 90, 1000),
(100, 91, 1000),
(101, 92, 1000),
(102, 93, 1000),
(103, 94, 1000),
(104, 95, 1000),
(105, 96, 1000),
(106, 97, 1000),
(107, 98, 1000),
(108, 99, 1000),
(109, 100, 1000),
(110, 101, 1000),
(111, 102, 4885),
(112, 103, 1000);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `inventorylocation`
--

CREATE TABLE `inventorylocation` (
  `id` int(11) NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `inventorylocation`
--

INSERT INTO `inventorylocation` (`id`, `latitude`, `longitude`) VALUES
(1, 39.29009651735118, 23.717536003087055);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `items`
--

CREATE TABLE `items` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT 'unknown',
  `category_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `items`
--

INSERT INTO `items` (`id`, `name`, `category_id`) VALUES
(16, 'Water', 6),
(17, 'Orange juice', 6),
(18, 'Sardines', 5),
(19, 'Canned corn', 5),
(20, 'Bread', 5),
(21, 'Chocolate', 5),
(22, 'Men Sneakers', 7),
(23, 'Test Product', 9),
(24, 'Test Val', 14),
(25, 'Spaghetti', 5),
(26, 'Croissant', 5),
(28, '', 10),
(29, 'Biscuits', 5),
(30, 'Bandages', 16),
(31, 'Disposable gloves', 16),
(32, 'Gauze', 16),
(33, 'Antiseptic', 16),
(34, 'First Aid Kit', 16),
(35, 'Painkillers', 16),
(36, 'Blanket', 7),
(37, 'Fakes', 5),
(38, 'Menstrual Pads', 21),
(39, 'Tampon', 21),
(40, 'Toilet Paper', 21),
(41, 'Baby wipes', 21),
(42, 'Toothbrush', 21),
(43, 'Toothpaste', 21),
(44, 'Vitamin C', 16),
(45, 'Multivitamines', 16),
(46, 'Paracetamol', 16),
(47, 'Ibuprofen', 16),
(48, '', 10),
(49, '', 10),
(50, '', 10),
(51, 'Cleaning rag', 22),
(52, 'Detergent', 22),
(53, 'Disinfectant', 22),
(54, 'Mop', 22),
(55, 'Plastic bucket', 22),
(56, 'Scrub brush', 22),
(57, 'Dust mask', 22),
(58, 'Broom', 22),
(59, 'Hammer', 23),
(60, 'Skillsaw', 23),
(61, 'Prybar', 23),
(62, 'Shovel', 23),
(63, 'Flashlight', 23),
(64, 'Duct tape', 23),
(65, 'Underwear', 7),
(66, 'Socks', 7),
(67, 'Warm Jacket', 7),
(68, 'Raincoat', 7),
(69, 'Gloves', 7),
(70, 'Pants', 7),
(71, 'Boots', 7),
(72, 'Dishes', 24),
(73, 'Pots', 24),
(74, 'Paring knives', 24),
(75, 'Pan', 24),
(76, 'Glass', 24),
(77, '', 10),
(78, '', 10),
(79, '', 10),
(80, '', 10),
(81, '', 10),
(82, '', 10),
(83, 't22', 9),
(84, 'water ', 6),
(85, 'Coca Cola', 6),
(86, 'spray', 26),
(87, 'Outdoor spiral', 26),
(88, 'Baby bottle', 25),
(89, 'Pacifier', 25),
(90, 'Condensed milk', 5),
(91, 'Cereal bar', 5),
(92, 'Pocket Knife', 23),
(93, 'Water Disinfection Tablets', 16),
(94, 'Radio', 27),
(95, 'Kitchen appliances', 14),
(96, 'Winter hat', 28),
(97, 'Winter gloves', 28),
(98, 'Scarf', 28),
(99, 'Thermos', 28),
(100, 'Tea', 6),
(101, 'Dog Food ', 29),
(102, 'Cat Food', 29),
(103, 'Canned', 5),
(104, 'asd', 11),
(105, 'red velvet', 33);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `locations`
--

CREATE TABLE `locations` (
  `id` int(4) UNSIGNED NOT NULL,
  `users_id` int(4) UNSIGNED NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `date_recorded` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `locations`
--

INSERT INTO `locations` (`id`, `users_id`, `latitude`, `longitude`, `date_recorded`) VALUES
(1, 63, 38.2459433, 21.7495535, '2023-12-20'),
(8, 64, 38.2459433, 21.7495535, '2023-12-20'),
(9, 65, 38.2459433, 21.7495535, '2023-12-20'),
(10, 66, 38.2459433, 21.7495535, '2023-12-20'),
(11, 67, 38.4678905, 23.6085888, '2023-12-22'),
(14, 103, 38.4598016, 23.6158976, '2023-12-23'),
(15, 118, 38.4678905, 23.6085496, '2023-12-28'),
(16, 121, 38.4678905, 23.6085496, '2024-01-03'),
(17, 122, 38.4678905, 23.6085496, '2024-01-03'),
(18, 123, 38.250585, 21.7265203, '2024-01-16'),
(19, 124, 38.250585, 21.7265203, '2024-01-16'),
(20, 125, 38.2500864, 21.7350144, '2024-01-16'),
(21, 126, 40.2500954, 30.7350234, '2024-01-16'),
(22, 127, 38.2505661, 21.7257052, '2024-01-28'),
(23, 128, 38.2505661, 21.7257052, '2024-01-28'),
(24, 129, 38.2505661, 21.7257052, '2024-01-28'),
(25, 130, 38.2505661, 21.7257052, '2024-01-28'),
(26, 131, 38.2505661, 21.7257052, '2024-01-28'),
(27, 132, 38.2505661, 21.7257052, '2024-01-28'),
(28, 133, 38.2505661, 21.7257052, '2024-01-28'),
(29, 134, 38.2413826, 21.7328659, '2024-01-28'),
(30, 135, 38.2505661, 21.7257052, '2024-01-28'),
(31, 136, 38.2505661, 21.7257052, '2024-01-28'),
(32, 137, 38.2413843, 21.7328555, '2024-01-28'),
(33, 138, 38.2413644, 21.7328482, '2024-01-28'),
(34, 139, 38.2505661, 21.7257052, '2024-01-28');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `offers`
--

CREATE TABLE `offers` (
  `offers_id` int(3) UNSIGNED NOT NULL,
  `takeaway_date` date DEFAULT NULL,
  `submission_date` date NOT NULL,
  `offers_quantity` int(11) NOT NULL,
  `civilian_id` int(4) UNSIGNED NOT NULL,
  `offers_items` int(10) UNSIGNED NOT NULL,
  `tasks_id` int(3) UNSIGNED NOT NULL,
  `general_id` int(4) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `offers`
--

INSERT INTO `offers` (`offers_id`, `takeaway_date`, `submission_date`, `offers_quantity`, `civilian_id`, `offers_items`, `tasks_id`, `general_id`) VALUES
(99, NULL, '2024-01-16', 609, 67, 60, 95, 13),
(101, NULL, '2024-01-16', 609, 67, 103, 97, 17),
(103, NULL, '2024-01-16', 609, 67, 102, 99, 46),
(104, NULL, '2024-01-16', 609609, 67, 99, 100, 16),
(105, NULL, '2024-01-16', 699, 67, 17, 148, 20),
(106, NULL, '2024-01-16', 555, 67, 102, 149, 46),
(107, '2024-02-08', '2024-01-16', 555, 67, 102, 150, 46),
(108, '2024-02-01', '2024-01-16', 555, 67, 102, 151, 46),
(109, '2024-02-01', '2024-01-16', 123, 67, 104, 152, 44),
(110, '2024-02-01', '2024-01-16', 0, 67, 38, 153, 9),
(111, NULL, '2024-01-16', 555, 67, 102, 154, 46),
(112, NULL, '2024-01-16', 555, 67, 102, 155, 46),
(113, '2024-02-01', '2024-01-16', 555, 67, 102, 156, 46),
(127, NULL, '2024-01-16', 123452, 71, 102, 189, 46),
(128, '2024-02-01', '2024-01-16', 10101, 71, 102, 191, 46),
(129, NULL, '2024-01-17', 100, 71, 102, 207, 46),
(130, '2024-02-07', '2024-01-17', 2147483647, 72, 102, 208, 46),
(141, NULL, '2024-01-29', 333, 85, 102, 257, 42);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `requests`
--

CREATE TABLE `requests` (
  `requests_id` int(3) UNSIGNED NOT NULL,
  `takeaway_date` date DEFAULT NULL,
  `submission_date` date NOT NULL,
  `quantity` int(11) NOT NULL,
  `civilian_id` int(4) UNSIGNED NOT NULL,
  `items_id` int(10) UNSIGNED NOT NULL,
  `tasks_id` int(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `requests`
--

INSERT INTO `requests` (`requests_id`, `takeaway_date`, `submission_date`, `quantity`, `civilian_id`, `items_id`, `tasks_id`) VALUES
(16, '2024-01-01', '2024-01-02', 3, 62, 18, 18),
(17, NULL, '2024-01-02', 3, 62, 22, 19),
(18, NULL, '2024-01-02', 3, 62, 21, 20),
(19, NULL, '2024-01-02', 3, 62, 85, 21),
(20, NULL, '2024-01-03', 1, 62, 18, 26),
(21, NULL, '2024-01-03', 2, 62, 16, 74),
(22, NULL, '2024-01-03', 3, 62, 17, 77),
(23, NULL, '2024-01-03', 23, 62, 20, 87),
(24, NULL, '2024-01-16', 1234, 71, 18, 201),
(25, NULL, '2024-01-16', 123, 72, 19, 202),
(26, NULL, '2024-01-16', 4447, 72, 19, 203),
(27, NULL, '2024-01-16', 102, 72, 17, 204),
(28, NULL, '2024-01-16', 123, 72, 17, 205),
(29, NULL, '2024-01-17', 2147483647, 71, 16, 206),
(30, NULL, '2024-01-22', 3, 71, 17, 221),
(31, NULL, '2024-01-24', 2, 71, 16, 227),
(32, NULL, '2024-01-24', 12, 71, 16, 228),
(33, '2024-02-07', '2024-01-28', 2, 74, 17, 238),
(34, '2024-02-01', '2024-01-28', 123, 74, 17, 239),
(35, '2024-02-01', '2024-01-28', 123456789, 74, 19, 242),
(36, NULL, '2024-01-28', 123123132, 77, 16, 243),
(37, NULL, '2024-01-28', 15432, 77, 17, 244);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `resclocations`
--

CREATE TABLE `resclocations` (
  `id` int(11) NOT NULL,
  `users_id` int(4) UNSIGNED NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `date_recorded` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `resclocations`
--

INSERT INTO `resclocations` (`id`, `users_id`, `latitude`, `longitude`, `date_recorded`) VALUES
(14, 114, 38.49691596137872, 23.471436231995977, '2023-12-27'),
(16, 117, 39.289761025897675, 23.71710346164971, '2024-02-08'),
(17, 119, 38.482727276791074, 23.47804046105145, '2024-01-02'),
(18, 32, 38.1764555599298, 21.810513521762513, '2024-01-29'),
(19, 116, 38.33820968318663, 21.660814422305652, '2024-01-29'),
(20, 139, 38.54300984319516, 22.17026455505578, '2024-01-29'),
(21, 140, 39.28986066950801, 23.717388564635293, '2024-02-09');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `rescuer`
--

CREATE TABLE `rescuer` (
  `rescuer_id` int(4) UNSIGNED NOT NULL,
  `users_id` int(4) UNSIGNED NOT NULL,
  `vehicles_id` int(4) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `rescuer`
--

INSERT INTO `rescuer` (`rescuer_id`, `users_id`, `vehicles_id`) VALUES
(11, 113, 1),
(14, 116, 1),
(15, 117, 2),
(16, 119, 1),
(18, 140, 3);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `tasks`
--

CREATE TABLE `tasks` (
  `tasks_id` int(3) UNSIGNED NOT NULL,
  `tasks_status` enum('PENDING','ON-ROAD','COMPLETE') DEFAULT 'PENDING',
  `type` enum('REQUEST','OFFER') NOT NULL,
  `vehicles_id` int(4) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `tasks`
--

INSERT INTO `tasks` (`tasks_id`, `tasks_status`, `type`, `vehicles_id`) VALUES
(13, 'ON-ROAD', 'REQUEST', NULL),
(14, 'PENDING', 'REQUEST', NULL),
(15, 'PENDING', 'REQUEST', NULL),
(16, 'PENDING', 'REQUEST', NULL),
(17, 'PENDING', 'REQUEST', NULL),
(18, 'PENDING', 'REQUEST', NULL),
(19, 'PENDING', 'REQUEST', NULL),
(20, 'PENDING', 'REQUEST', NULL),
(21, 'PENDING', 'REQUEST', NULL),
(22, 'PENDING', 'OFFER', NULL),
(23, 'PENDING', 'OFFER', NULL),
(24, 'PENDING', 'OFFER', NULL),
(25, 'PENDING', 'OFFER', NULL),
(26, 'PENDING', 'REQUEST', NULL),
(27, 'PENDING', 'OFFER', NULL),
(28, 'PENDING', 'OFFER', NULL),
(29, 'PENDING', 'OFFER', NULL),
(30, 'PENDING', 'OFFER', NULL),
(31, 'PENDING', 'OFFER', NULL),
(32, 'PENDING', 'OFFER', NULL),
(33, 'PENDING', 'OFFER', NULL),
(34, 'PENDING', 'OFFER', NULL),
(35, 'PENDING', 'OFFER', NULL),
(36, 'PENDING', 'OFFER', NULL),
(37, 'ON-ROAD', 'OFFER', 1),
(38, 'PENDING', 'OFFER', NULL),
(39, 'PENDING', 'OFFER', NULL),
(40, 'PENDING', 'OFFER', NULL),
(41, 'PENDING', 'OFFER', NULL),
(42, 'PENDING', 'OFFER', NULL),
(43, 'PENDING', 'OFFER', NULL),
(44, 'PENDING', 'OFFER', NULL),
(45, 'PENDING', 'OFFER', NULL),
(46, 'PENDING', 'OFFER', NULL),
(47, 'PENDING', 'OFFER', NULL),
(48, 'PENDING', 'OFFER', NULL),
(49, 'PENDING', 'OFFER', NULL),
(50, 'PENDING', 'OFFER', NULL),
(51, 'PENDING', 'OFFER', NULL),
(52, 'PENDING', 'OFFER', NULL),
(53, 'PENDING', 'OFFER', NULL),
(54, 'PENDING', 'OFFER', NULL),
(55, 'PENDING', 'OFFER', NULL),
(56, 'PENDING', 'OFFER', NULL),
(57, 'PENDING', 'OFFER', NULL),
(58, 'PENDING', 'OFFER', NULL),
(59, 'PENDING', 'OFFER', NULL),
(60, 'PENDING', 'OFFER', NULL),
(61, 'PENDING', 'OFFER', NULL),
(62, 'PENDING', 'OFFER', NULL),
(63, 'PENDING', 'OFFER', NULL),
(64, 'PENDING', 'OFFER', NULL),
(65, 'PENDING', 'OFFER', NULL),
(66, 'PENDING', 'OFFER', NULL),
(67, 'PENDING', 'OFFER', NULL),
(68, 'PENDING', 'OFFER', NULL),
(69, 'PENDING', 'OFFER', NULL),
(70, 'PENDING', 'OFFER', NULL),
(71, 'PENDING', 'OFFER', NULL),
(72, 'PENDING', 'OFFER', NULL),
(73, 'PENDING', 'OFFER', NULL),
(74, 'COMPLETE', 'REQUEST', 2),
(75, 'PENDING', 'REQUEST', NULL),
(76, 'COMPLETE', 'REQUEST', NULL),
(77, 'COMPLETE', 'REQUEST', 2),
(78, 'PENDING', 'REQUEST', NULL),
(79, 'PENDING', 'REQUEST', NULL),
(80, 'PENDING', 'REQUEST', NULL),
(81, 'PENDING', 'REQUEST', NULL),
(82, 'PENDING', 'REQUEST', NULL),
(83, 'PENDING', 'REQUEST', NULL),
(84, 'PENDING', 'REQUEST', NULL),
(85, 'PENDING', 'REQUEST', NULL),
(86, 'PENDING', 'REQUEST', NULL),
(87, 'COMPLETE', 'REQUEST', 2),
(88, 'PENDING', 'OFFER', NULL),
(89, 'PENDING', 'OFFER', NULL),
(90, 'COMPLETE', 'REQUEST', NULL),
(91, 'PENDING', 'OFFER', NULL),
(92, 'PENDING', 'OFFER', NULL),
(93, 'PENDING', 'OFFER', NULL),
(94, 'PENDING', 'OFFER', NULL),
(95, 'PENDING', 'OFFER', NULL),
(96, 'PENDING', 'OFFER', NULL),
(97, 'PENDING', 'OFFER', NULL),
(98, 'PENDING', 'OFFER', NULL),
(99, 'PENDING', 'OFFER', NULL),
(100, 'PENDING', 'OFFER', NULL),
(101, 'PENDING', 'OFFER', NULL),
(102, 'PENDING', 'OFFER', NULL),
(103, 'PENDING', 'OFFER', NULL),
(104, 'PENDING', 'OFFER', NULL),
(105, 'PENDING', 'OFFER', NULL),
(106, 'PENDING', 'OFFER', NULL),
(107, 'PENDING', 'OFFER', NULL),
(108, 'PENDING', 'OFFER', NULL),
(109, 'PENDING', 'OFFER', NULL),
(110, 'PENDING', 'OFFER', NULL),
(111, 'PENDING', 'OFFER', NULL),
(112, 'PENDING', 'OFFER', NULL),
(113, 'PENDING', 'OFFER', NULL),
(114, 'PENDING', 'OFFER', NULL),
(115, 'PENDING', 'OFFER', NULL),
(116, 'PENDING', 'OFFER', NULL),
(117, 'PENDING', 'OFFER', NULL),
(118, 'PENDING', 'OFFER', NULL),
(119, 'PENDING', 'OFFER', NULL),
(120, 'PENDING', 'OFFER', NULL),
(121, 'PENDING', 'OFFER', NULL),
(122, 'PENDING', 'OFFER', NULL),
(123, 'PENDING', 'OFFER', NULL),
(124, 'PENDING', 'OFFER', NULL),
(125, 'COMPLETE', 'OFFER', NULL),
(126, 'PENDING', 'OFFER', NULL),
(127, 'PENDING', 'OFFER', NULL),
(128, 'PENDING', 'OFFER', NULL),
(129, 'PENDING', 'OFFER', NULL),
(130, 'PENDING', 'OFFER', NULL),
(131, 'PENDING', 'OFFER', NULL),
(132, 'PENDING', 'OFFER', NULL),
(133, 'PENDING', 'OFFER', NULL),
(134, 'PENDING', 'OFFER', NULL),
(135, 'PENDING', 'OFFER', NULL),
(136, 'PENDING', 'OFFER', NULL),
(137, 'PENDING', 'OFFER', NULL),
(138, 'PENDING', 'OFFER', NULL),
(139, 'PENDING', 'OFFER', NULL),
(140, 'PENDING', 'OFFER', NULL),
(141, 'PENDING', 'OFFER', NULL),
(142, 'COMPLETE', 'OFFER', NULL),
(143, 'PENDING', 'OFFER', NULL),
(144, 'PENDING', 'OFFER', NULL),
(145, 'PENDING', 'OFFER', NULL),
(146, 'PENDING', 'OFFER', NULL),
(147, 'PENDING', 'OFFER', NULL),
(148, 'PENDING', 'OFFER', NULL),
(149, 'PENDING', 'OFFER', NULL),
(150, 'ON-ROAD', 'OFFER', 3),
(151, 'COMPLETE', 'OFFER', 2),
(152, 'COMPLETE', 'OFFER', 2),
(153, 'COMPLETE', 'OFFER', 2),
(154, 'COMPLETE', 'OFFER', 2),
(155, 'COMPLETE', 'OFFER', 2),
(156, 'COMPLETE', 'OFFER', 2),
(157, 'PENDING', 'OFFER', NULL),
(158, 'PENDING', 'OFFER', NULL),
(159, 'PENDING', 'OFFER', NULL),
(160, 'PENDING', 'OFFER', NULL),
(161, 'PENDING', 'OFFER', NULL),
(162, 'PENDING', 'OFFER', NULL),
(163, 'PENDING', 'OFFER', NULL),
(164, 'PENDING', 'OFFER', NULL),
(165, 'PENDING', 'OFFER', NULL),
(166, 'PENDING', 'OFFER', NULL),
(167, 'PENDING', 'OFFER', NULL),
(168, 'PENDING', 'OFFER', NULL),
(169, 'PENDING', 'OFFER', NULL),
(170, 'PENDING', 'OFFER', NULL),
(171, 'PENDING', 'OFFER', NULL),
(172, 'PENDING', 'OFFER', NULL),
(173, 'PENDING', 'OFFER', NULL),
(174, 'PENDING', 'OFFER', NULL),
(175, 'PENDING', 'OFFER', NULL),
(176, 'ON-ROAD', 'OFFER', NULL),
(177, 'PENDING', 'OFFER', NULL),
(178, 'PENDING', 'OFFER', NULL),
(179, 'PENDING', 'OFFER', NULL),
(180, 'PENDING', 'OFFER', NULL),
(181, 'PENDING', 'OFFER', NULL),
(182, 'PENDING', 'OFFER', NULL),
(183, 'PENDING', 'OFFER', NULL),
(184, 'PENDING', 'OFFER', NULL),
(185, 'PENDING', 'OFFER', NULL),
(186, 'PENDING', 'OFFER', NULL),
(187, 'PENDING', 'OFFER', NULL),
(188, 'PENDING', 'OFFER', NULL),
(189, 'ON-ROAD', 'OFFER', 2),
(190, 'COMPLETE', 'OFFER', NULL),
(191, 'COMPLETE', 'OFFER', 2),
(192, 'PENDING', 'REQUEST', NULL),
(193, 'PENDING', 'REQUEST', NULL),
(194, 'PENDING', 'REQUEST', NULL),
(195, 'PENDING', 'REQUEST', NULL),
(196, 'PENDING', 'REQUEST', NULL),
(197, 'PENDING', 'REQUEST', NULL),
(198, 'PENDING', 'REQUEST', NULL),
(199, 'PENDING', 'REQUEST', NULL),
(200, 'PENDING', 'REQUEST', NULL),
(201, 'COMPLETE', 'REQUEST', NULL),
(202, 'PENDING', 'REQUEST', NULL),
(203, 'PENDING', 'REQUEST', NULL),
(204, 'PENDING', 'REQUEST', NULL),
(205, 'COMPLETE', 'REQUEST', NULL),
(206, 'ON-ROAD', 'REQUEST', 3),
(207, 'COMPLETE', 'OFFER', NULL),
(208, 'ON-ROAD', 'OFFER', 2),
(209, 'PENDING', 'OFFER', NULL),
(221, 'COMPLETE', 'REQUEST', NULL),
(222, 'COMPLETE', 'OFFER', NULL),
(223, 'ON-ROAD', 'OFFER', NULL),
(224, 'PENDING', 'REQUEST', NULL),
(225, 'PENDING', 'OFFER', NULL),
(226, 'PENDING', 'OFFER', NULL),
(227, 'COMPLETE', 'REQUEST', NULL),
(228, 'COMPLETE', 'REQUEST', NULL),
(229, 'PENDING', 'OFFER', NULL),
(230, 'PENDING', 'OFFER', NULL),
(231, 'PENDING', 'OFFER', NULL),
(232, 'PENDING', 'OFFER', NULL),
(233, 'PENDING', 'OFFER', NULL),
(234, 'PENDING', 'OFFER', NULL),
(235, 'PENDING', 'REQUEST', NULL),
(236, 'PENDING', 'OFFER', NULL),
(237, 'PENDING', 'OFFER', NULL),
(238, 'ON-ROAD', 'REQUEST', 2),
(239, 'COMPLETE', 'REQUEST', 2),
(240, 'PENDING', 'REQUEST', NULL),
(241, 'PENDING', 'REQUEST', NULL),
(242, 'ON-ROAD', 'REQUEST', 2),
(243, 'ON-ROAD', 'REQUEST', 2),
(244, 'COMPLETE', 'REQUEST', 2),
(245, 'PENDING', 'REQUEST', NULL),
(246, 'PENDING', 'REQUEST', NULL),
(247, 'PENDING', 'REQUEST', NULL),
(249, 'PENDING', 'REQUEST', NULL),
(257, 'ON-ROAD', 'OFFER', 1),
(258, 'PENDING', 'OFFER', NULL),
(259, 'PENDING', 'OFFER', NULL),
(260, 'PENDING', 'OFFER', NULL),
(261, 'PENDING', 'OFFER', NULL),
(262, 'PENDING', 'REQUEST', NULL),
(263, 'PENDING', 'OFFER', NULL),
(264, 'PENDING', 'REQUEST', NULL),
(265, 'PENDING', 'OFFER', NULL),
(266, 'PENDING', 'REQUEST', NULL);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `testan`
--

CREATE TABLE `testan` (
  `general_id` int(4) UNSIGNED NOT NULL,
  `announcement_id` int(4) UNSIGNED DEFAULT NULL,
  `item_id` int(10) UNSIGNED DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `civilian_id` int(4) UNSIGNED DEFAULT NULL,
  `announ_status` enum('free','updated','ended') DEFAULT 'free',
  `created_at` date DEFAULT curdate(),
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `testan`
--

INSERT INTO `testan` (`general_id`, `announcement_id`, `item_id`, `quantity`, `civilian_id`, `announ_status`, `created_at`, `updated_at`) VALUES
(8, 24, 36, 1, NULL, 'free', '2023-12-27', '2023-12-27'),
(9, 24, 38, 1, NULL, 'free', '2023-12-27', '2023-12-27'),
(10, 25, 99, 1, NULL, 'free', '2023-12-27', '2023-12-27'),
(11, 25, 101, 1, NULL, 'free', '2023-12-27', '2023-12-27'),
(12, 26, 56, 1, NULL, 'free', '2023-12-27', NULL),
(13, 26, 60, 1, NULL, 'free', '2023-12-27', NULL),
(14, 27, 32, 1, NULL, 'free', '2023-12-27', NULL),
(15, 27, 33, 1, NULL, 'free', '2023-12-27', NULL),
(16, 28, 99, 1, NULL, 'free', '2023-12-27', NULL),
(17, 28, 103, 1, NULL, 'free', '2023-12-27', NULL),
(18, 28, 104, 1, NULL, 'free', '2023-12-27', NULL),
(19, 29, 16, 1, NULL, 'free', '2023-12-27', NULL),
(20, 29, 17, 1, NULL, 'free', '2023-12-27', NULL),
(21, 30, 22, 1, NULL, 'free', '2023-12-27', NULL),
(22, 30, 39, 1, NULL, 'free', '2023-12-27', NULL),
(23, 31, 33, 1, NULL, 'free', '2023-12-27', NULL),
(24, 31, 34, 1, NULL, 'free', '2023-12-27', NULL),
(25, 32, 23, 1, NULL, 'free', '2024-01-02', NULL),
(26, 32, 24, 1, NULL, 'free', '2024-01-02', NULL),
(35, 34, 29, 1, NULL, 'free', '2024-01-02', NULL),
(36, 34, 30, 1, NULL, 'free', '2024-01-02', NULL),
(37, 35, 97, 1, NULL, 'free', '2024-01-02', NULL),
(38, 35, 98, 1, NULL, 'free', '2024-01-02', NULL),
(39, 35, 99, 1, NULL, 'free', '2024-01-02', NULL),
(40, 36, 31, 1, NULL, 'free', '2024-01-02', NULL),
(41, 36, 32, 1, NULL, 'free', '2024-01-02', NULL),
(42, 37, 102, 1, NULL, 'free', '2024-01-03', NULL),
(43, 37, 103, 1, NULL, 'free', '2024-01-03', NULL),
(44, 37, 104, 1, NULL, 'free', '2024-01-03', NULL),
(45, 38, 101, 1, NULL, 'free', '2024-01-03', NULL),
(46, 38, 102, 1, NULL, 'free', '2024-01-03', NULL);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `users`
--

CREATE TABLE `users` (
  `users_id` int(4) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL DEFAULT 'UNKNOWN',
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `users`
--

INSERT INTO `users` (`users_id`, `username`, `password`) VALUES
(31, 'eyty', '$2y$10$dFC3X5fl0o2f0kDpxhCjCezSM34ELgdZFo2aQU6ZwLWSwWsXEEQ6y'),
(32, 'stath', '$2y$10$7GjNwnMTDvNFu.Ya.z.ecebdgxvDbJyvDUzYnuhW1WPp8RDWURz6.'),
(33, 'desp', '$2y$10$uibtuM0jsNEfvutowvBwA.QJxq7BDJ5o6HzmP5SduMBknimg1qP7e'),
(37, 'stathios', '$2y$10$oJLazQZ00x2ID./2ynjBI.aag.R0h2e09.KHi4cGLdxIchOy5FBwq'),
(38, 'gkyka', '$2y$10$3zu3jb8d2cxlHo4bdxZduuS5gimUFIAthFACPQ5zvziDy2mpSOuM2'),
(39, 'glyka', '$2y$10$NZx8ZXNAtX4UFAQAKYtbD.iXYDLBWDxdSups4lrQphy300WO/nUqu'),
(40, 'new', '$2y$10$SO2fxOoEdHoEgjYlXCN93O21axEARk0OLyQf/Px00CWOKFZougo8a'),
(41, 'w', '$2y$10$3N.cqP66qHIirTzYxjCQ0u7pL8Tbk4i02YTehpFwMnCv7wzFa683e'),
(42, 'as', '$2y$10$.OPx/xuTr4uW0UELJt8eeeBuqn8E.LHNcl1eLU8Xs3RD7FYVEyk7S'),
(43, 'q', '$2y$10$Y1IMXbiUrzX35XBsghIkIOf5r7iC.gN1vFyeq5131E4y7TjuO.a0u'),
(44, 'd', '$2y$10$Wp7iaa9pmZf9Rt5eFeUB5.0k0M5o6.rR0KziIKLA3UDxvQbc8gnw6'),
(45, 'm', '$2y$10$jrFZtaSD6sn983mpoHPYNum66WRpGcEHpbng946/Q5IoZRsrnxgzu'),
(46, 'c', '$2y$10$dQ9JdYgRAukNwG4PnHUqXOEW8cqYWbyNGp2VQGjnHNh4k5he3zQpm'),
(47, 'bb', '$2y$10$qWWe6/i498g7PHAtldy0f./HGISa0aaMxlUDtgeZtDpFK8KOdt3yG'),
(48, 'az', '$2y$10$yQtCugYkH5e6XUEh56X4SelxFZUIVvbkK9zkqYeEzyCyWEokZl1PG'),
(49, 'qwe', '$2y$10$jkDK4rUa10WrcrL5MN9M5OCy3oCCplY8Z1nkMyPrwAze4mA3sC0T6'),
(50, 'qewqeqew', '$2y$10$R0VWPGipE6lOCs/GHyi8M.44IzofPtCRtLNhPaKOzot62xVDcL5ia'),
(51, 'qweqqq', '$2y$10$yjhAeBY6tgTSlr.yx8XFtuUwYZDGOBnErgBxpVv6y9Rm9KR5iCPZ.'),
(52, 'sdafadfsdf', '$2y$10$hfdm08JL7.6hLA9EI89IMOTFGkroXSIPDNFJTdsGzRmKSfoZkUlbO'),
(53, 'asdasaaa', '$2y$10$5OzsU/PLoZl9iHytEVtFUOBpCArCJN4GR4P7bf4PYEX.2YnMinWFW'),
(54, 'zzz', '$2y$10$8MjRWyctff2lKP3Hkz01BuuzjeYBfGLClDODhPY6Tdga78aTquRZa'),
(55, 'x', '$2y$10$W2cvfuQdXsC08aZVt1U53uWHAG08dWFlQto.dxuNgylmey3f921qu'),
(56, 'ga', '$2y$10$MQVySJaBgKPz7N7GQ2obvOvAKJ.BQfq2otGQ8Fhr72AOww6xZI3km'),
(57, 'v', '$2y$10$8NE/srufXRMaa1Ir4LJzOOyXVlr.LDkRAtmGhFDjts.Ia2PA3Dpcu'),
(58, 'vv', '$2y$10$uy6pvQ7k1tgzVQ9bbL5zauL1bqVevSzL/mZv1ZrdqJ4u18YP.Ropy'),
(59, 'adadadasdad', '$2y$10$dFgB/N2YTpiUdHLYVG.7TOU5ed7oxYrMe5C0hbsb9AxT5UGqS2bJ2'),
(60, 'l', '$2y$10$XKWkW9Y0y9dNrfzPHSphW.BwdA.ItvmFeBhmWUge5nHqjY9JhXtpy'),
(61, '78', '$2y$10$cGmjjY9s6gEqrbnXgZJl7eCDMZHM1EQYrKmWNX3yMqVABoctWsuFO'),
(62, 'cc', '$2y$10$NnTF6wa8Bib2MTW53c/3kuRPMvR1WvLli2PBILzQh7dMWyIJ8oxB.'),
(63, 'asdasdasd', '$2y$10$vJg62LKk9X6sT686ksdGaeUc2a4H9.16T6.0p/bAAd27n825xT4Fa'),
(64, 'asdasdsfasdfasdf', '$2y$10$8bKN3fdASjuWwHcRwaAisehsS8ajoSI9ln690NSMJ1dapLrm0Zbue'),
(65, 'asdasdasdasdasdasd', '$2y$10$bCsY0QDYRR5MzzmVpxyiiuiGa9SJ/iK0Ut9KZIJUkf8JnECsvsq2q'),
(66, 'asfadsfasdfsf', '$2y$10$EqQFg7voMqklFN0tS3mGdO2BiPZ4mJIH9v.sB2h5IAys7R6v6HV4m'),
(67, 'mamaxaroyla', '$2y$10$6o5iGp.ksVVvyQgi1ewwpeiFXc5HU7GnV9KQkyv0xlZB3MbiOPomC'),
(103, 'asd', '$2y$10$RjHRHEEJCQPoEJVssIjv8OoP3sPrzUVy2JTJ1xYOxMAo4VzGZH1aS'),
(104, 'rescuer_efstathios', '$2y$10$6tvAEu1G5.Ka32ljj4UeRORpiJrfOxeugSOTYdkFV/FE/UiKunsTm'),
(105, 'stath resc', '$2y$10$2giA.vu4YLas7wbA/XGiQOYNgXZal8UdTZYAR7o.lskkd7EWZ58Oy'),
(106, 'staresc', '$2y$10$.aNTNYJHReeidD0wYurWNexb2eJLC/15vhydEq7wrVWl0CBuMbmMO'),
(107, 'a', '$2y$10$GJ7tmOkYsXReJjlBeFDl..IiBZhpa3YJOlTw9fRil0Z/rpZ0xLbYu'),
(108, 'gabasfdcaasd', '$2y$10$LuisrgyWQgtBqG949BKzMeW1dBXFyBlucwgfGlYQNtvM0qP41mzoi'),
(109, 'sssssssssssssssssssssssssv', '$2y$10$BBOC5WbWcyShaVh4o2W76OIgf39UEIZh3X6u71G33Orgv6oJkHV5S'),
(110, 'bot', '$2y$10$eBgrC/pwbUqIwke95jMQeuMpwMvx.iZpf/mebaoIAvYQHTvP/Ahbi'),
(111, 'asdasdasdasd', '$2y$10$ehB0m1S5SqCh4ULZRoS95e51aM9OsxoYDGaOx1ORynsK.bI.Eo/Ki'),
(112, 'EYTYRESC', '$2y$10$qKIKfuYLXP/hIReUtWTu3u8Uw03i5twBlovaTjKHCKXDAdn1Ly7yy'),
(113, 'rescstath', '$2y$10$ZbhrZbuV7EWssgL1gRcu8ugquqTlAwxsdZZHBlbYU0efwdPnT4Nmu'),
(114, 'newresc', '$2y$10$V66DWzzqXiPMC/c1sLwxQuJunZ4uCBfPTJJdkVjl3tbhjE3EuK8oi'),
(115, 'newresc', '$2y$10$jyQMyE8d0k5SL/fXEstvPe0KPcZJOYVLY136GgupVpE0Fg/Jbsoci'),
(116, 'newnewresc', '$2y$10$I041pWFGs8V4Wga3xnIV0uxPiFI4zakA8Sn2KFsH/CSqMqVi3LQFe'),
(117, 'newrescuer', '$2y$10$HSk7viU04yomeh5MYcKOvejsAU69pyEC8CkgDTbjJHk/n7xTBq0eS'),
(118, 'zaxa', '$2y$10$WYOa9qJq0uwkzc0jhNm/HeR8aoTvdoJ8Ei1g7kiYqx9GMRc9RgHde'),
(119, 'newbot', '$2y$10$xMG1XZ3il551CPDw69PQLuLu8v4qkA2SGGe4KzQ5YNC/hNPdsF.XC'),
(120, 'qweqwe', '$2y$10$sDfFTTPuHy/0euZoumBFwuSQ.hG5.6ESHRJbZJt2jXSpkDh9dGpDC'),
(121, 'desssssssssss', '$2y$10$o4v/VvN4nDOVH1MYF32rOuI3P1NDJ2OSgn5ypyj9qlOVo0jnm6qBW'),
(122, 'd e', '$2y$10$vHFKdPuuXK.QUjqOm6tvH.rWGlyjvWtNYhBXMygKv5Q3GXFYWSFvK'),
(123, 'lo', '$2y$10$VT6ae3bfm7nHvMkxdu3ALupNmy0JxOotZbfMAVQExzLQzh5GtFvsu'),
(124, 'te', '$2y$10$NkBI6vNsjcNEyH21Us7RG.j7mBFO9xLLV/cDUvsrwBv7BKa/tjgzq'),
(125, 'xa', '$2y$10$kZg9s2.1eI6JGux8s35Ok.2uyqMf1AdXQjLTeMALiawA6J4m5JG1m'),
(126, 'xaxa', '$2y$10$SQir2s5MkcFb.63hQ3r9PewlAATMFbzoVIYDjaB9iAP.aBWtWe2M2'),
(127, 'check', '$2y$10$HC0uxOa6BCzHfiOIwXOPbuTg6MPRBKfY0DdY17stOPejVSoUA6P5a'),
(128, 'che', '$2y$10$GPcFM2UiDd4uzsjEFls1kuqj.snh1izIihtXxSSMZsaL3q.ipKRDe'),
(129, 'mu', '$2y$10$sOCNKCUz5yXHjZGF6qWv9ONpA5du3CS2ysBxCNIugQvUnlwi5YK9G'),
(130, 'ouf', '$2y$10$dJKyrDUeR3/4NIUqgyRCL.LiZnsyMn7HzfyDRhYciheiBVQL3nldW'),
(131, 'oo', '$2y$10$IjrKtFDsBt4I2iLa0HvMw.aYFCJCP9y7q7cR4lQf3cY5VldaOsxJa'),
(132, '1a', '$2y$10$uT6UMoMeCDtFzEVrtJ8oaujU2Y/sJQx.Nj8OlSk0ae2MgHsSIpAHi'),
(133, 'volde', '$2y$10$XvQpVxT0odUADMei.Oow4OzXo3DvLgyNl0WTYts2v8DpZ80XK.J.u'),
(134, 'bad guy', '$2y$10$zGqL5o3J7XghMkOeQYyz6Oty8GZMS4EY8ltbxh4HKmjgedmyuxsIu'),
(135, 'bibi', '$2y$10$GQiAMi/NfogVCOh0.G1O3ea6Jle.5lJt1cMQnCcLV8QPE.rKcUbbC'),
(136, 'hmm', '$2y$10$I1SdZEViUg43VGRZzRVnzuvidc1UjloKsAcM2e9S0OPNZONr6zNRC'),
(137, 'aixx', '$2y$10$10b4BoRC7LfQU28HKjZ2fOuS63yVUeGTI7Oq5pnXBg23QADwFk7JW'),
(138, 'etoimh', '$2y$10$PX0fkc0v/2zaegi6PwiyHOGtjiNltl.b3ZqWGlJYNcmusfORbSJue'),
(139, 'etoimhh', '$2y$10$1J6fmfX7hQX3WP59zuPfK.dkuyihThL7lq1zVH1Isf7SHQ9bCW5yu'),
(140, 're', '$2y$10$VwtPzUbk31kJi9Rnw6PGWu31MiCH.nqdSM8R8EapyDm.A9osfu.g2');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `vehicles`
--

CREATE TABLE `vehicles` (
  `vehicles_id` int(4) UNSIGNED NOT NULL,
  `vehicles_name` varchar(20) NOT NULL DEFAULT 'UNKNOWN',
  `active_tasks` tinyint(3) UNSIGNED DEFAULT NULL,
  `availability` enum('busy','not_busy') DEFAULT 'not_busy'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `vehicles`
--

INSERT INTO `vehicles` (`vehicles_id`, `vehicles_name`, `active_tasks`, `availability`) VALUES
(1, 'Ambulance', 0, 'not_busy'),
(2, 'Fire Truck', 22, 'busy'),
(3, 'Rescue Helicopter', 3, 'not_busy');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `_code`
--

CREATE TABLE `_code` (
  `id` int(11) NOT NULL,
  `code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `_code`
--

INSERT INTO `_code` (`id`, `code`) VALUES
(1, '1'),
(2, '1');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `_message`
--

CREATE TABLE `_message` (
  `id` int(11) NOT NULL,
  `message` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `_message`
--

INSERT INTO `_message` (`id`, `message`) VALUES
(1, 'Retrieved successfully'),
(2, 'Retrieved successfully');

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announcement_id`),
  ADD KEY `announciv` (`civilian_id`);

--
-- Ευρετήρια για πίνακα `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`cargo_id`),
  ADD KEY `assignedVehicle` (`vehicles_id`),
  ADD KEY `cargoTransaction` (`inventory_id`),
  ADD KEY `hasItem` (`items_id`);

--
-- Ευρετήρια για πίνακα `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `civilian`
--
ALTER TABLE `civilian`
  ADD PRIMARY KEY (`civilian_id`),
  ADD KEY `userType` (`users_id`);

--
-- Ευρετήρια για πίνακα `details`
--
ALTER TABLE `details`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `itemDetail` (`id`);

--
-- Ευρετήρια για πίνακα `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inventory_id`),
  ADD KEY `itemAvailable` (`id`);

--
-- Ευρετήρια για πίνακα `inventorylocation`
--
ALTER TABLE `inventorylocation`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoryType` (`category_id`);

--
-- Ευρετήρια για πίνακα `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usersloc` (`users_id`);

--
-- Ευρετήρια για πίνακα `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`offers_id`),
  ADD KEY `fCivilian` (`civilian_id`),
  ADD KEY `iRequest` (`offers_items`),
  ADD KEY `iTask` (`tasks_id`);

--
-- Ευρετήρια για πίνακα `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`requests_id`),
  ADD KEY `fromCivilian` (`civilian_id`),
  ADD KEY `itemRequest` (`items_id`),
  ADD KEY `isTask` (`tasks_id`);

--
-- Ευρετήρια για πίνακα `resclocations`
--
ALTER TABLE `resclocations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rescsloc` (`users_id`);

--
-- Ευρετήρια για πίνακα `rescuer`
--
ALTER TABLE `rescuer`
  ADD PRIMARY KEY (`rescuer_id`),
  ADD KEY `uType` (`users_id`),
  ADD KEY `hasVehicle` (`vehicles_id`);

--
-- Ευρετήρια για πίνακα `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`tasks_id`),
  ADD KEY `getVehicle` (`vehicles_id`);

--
-- Ευρετήρια για πίνακα `testan`
--
ALTER TABLE `testan`
  ADD PRIMARY KEY (`general_id`),
  ADD KEY `announ` (`civilian_id`),
  ADD KEY `announcitems` (`item_id`);

--
-- Ευρετήρια για πίνακα `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`);

--
-- Ευρετήρια για πίνακα `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`vehicles_id`);

--
-- Ευρετήρια για πίνακα `_code`
--
ALTER TABLE `_code`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `_message`
--
ALTER TABLE `_message`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announcement_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT για πίνακα `cargo`
--
ALTER TABLE `cargo`
  MODIFY `cargo_id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT για πίνακα `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT για πίνακα `civilian`
--
ALTER TABLE `civilian`
  MODIFY `civilian_id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT για πίνακα `details`
--
ALTER TABLE `details`
  MODIFY `detail_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT για πίνακα `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventory_id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT για πίνακα `items`
--
ALTER TABLE `items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT για πίνακα `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT για πίνακα `offers`
--
ALTER TABLE `offers`
  MODIFY `offers_id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT για πίνακα `requests`
--
ALTER TABLE `requests`
  MODIFY `requests_id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT για πίνακα `resclocations`
--
ALTER TABLE `resclocations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT για πίνακα `rescuer`
--
ALTER TABLE `rescuer`
  MODIFY `rescuer_id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT για πίνακα `tasks`
--
ALTER TABLE `tasks`
  MODIFY `tasks_id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=267;

--
-- AUTO_INCREMENT για πίνακα `testan`
--
ALTER TABLE `testan`
  MODIFY `general_id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT για πίνακα `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT για πίνακα `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `vehicles_id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT για πίνακα `_code`
--
ALTER TABLE `_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT για πίνακα `_message`
--
ALTER TABLE `_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Περιορισμοί για άχρηστους πίνακες
--

--
-- Περιορισμοί για πίνακα `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announciv` FOREIGN KEY (`civilian_id`) REFERENCES `civilian` (`civilian_id`);

--
-- Περιορισμοί για πίνακα `cargo`
--
ALTER TABLE `cargo`
  ADD CONSTRAINT `assignedVehicle` FOREIGN KEY (`vehicles_id`) REFERENCES `vehicles` (`vehicles_id`),
  ADD CONSTRAINT `cargoTransaction` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`inventory_id`),
  ADD CONSTRAINT `hasItem` FOREIGN KEY (`items_id`) REFERENCES `items` (`id`);

--
-- Περιορισμοί για πίνακα `civilian`
--
ALTER TABLE `civilian`
  ADD CONSTRAINT `userType` FOREIGN KEY (`users_id`) REFERENCES `users` (`users_id`);

--
-- Περιορισμοί για πίνακα `details`
--
ALTER TABLE `details`
  ADD CONSTRAINT `itemDetail` FOREIGN KEY (`id`) REFERENCES `items` (`id`);

--
-- Περιορισμοί για πίνακα `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `itemAvailable` FOREIGN KEY (`id`) REFERENCES `items` (`id`);

--
-- Περιορισμοί για πίνακα `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `categoryType` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Περιορισμοί για πίνακα `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `usersloc` FOREIGN KEY (`users_id`) REFERENCES `users` (`users_id`);

--
-- Περιορισμοί για πίνακα `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `fCivilian` FOREIGN KEY (`civilian_id`) REFERENCES `civilian` (`civilian_id`),
  ADD CONSTRAINT `iRequest` FOREIGN KEY (`offers_items`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `iTask` FOREIGN KEY (`tasks_id`) REFERENCES `tasks` (`tasks_id`);

--
-- Περιορισμοί για πίνακα `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `fromCivilian` FOREIGN KEY (`civilian_id`) REFERENCES `civilian` (`civilian_id`),
  ADD CONSTRAINT `isTask` FOREIGN KEY (`tasks_id`) REFERENCES `tasks` (`tasks_id`),
  ADD CONSTRAINT `itemRequest` FOREIGN KEY (`items_id`) REFERENCES `items` (`id`);

--
-- Περιορισμοί για πίνακα `resclocations`
--
ALTER TABLE `resclocations`
  ADD CONSTRAINT `rescsloc` FOREIGN KEY (`users_id`) REFERENCES `users` (`users_id`);

--
-- Περιορισμοί για πίνακα `rescuer`
--
ALTER TABLE `rescuer`
  ADD CONSTRAINT `hasVehicle` FOREIGN KEY (`vehicles_id`) REFERENCES `vehicles` (`vehicles_id`),
  ADD CONSTRAINT `uType` FOREIGN KEY (`users_id`) REFERENCES `users` (`users_id`);

--
-- Περιορισμοί για πίνακα `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `getVehicle` FOREIGN KEY (`vehicles_id`) REFERENCES `vehicles` (`vehicles_id`);

--
-- Περιορισμοί για πίνακα `testan`
--
ALTER TABLE `testan`
  ADD CONSTRAINT `announ` FOREIGN KEY (`civilian_id`) REFERENCES `civilian` (`civilian_id`),
  ADD CONSTRAINT `announcitems` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
