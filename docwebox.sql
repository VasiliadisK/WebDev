-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: 127.0.0.1
-- Χρόνος δημιουργίας: 09 Ιαν 2023 στις 21:38:51
-- Έκδοση διακομιστή: 10.4.27-MariaDB
-- Έκδοση PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `docwebox`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `appointments`
--

CREATE TABLE `appointments` (
  `id` int(6) UNSIGNED NOT NULL,
  `patient_id` int(6) UNSIGNED NOT NULL,
  `doctor_id` int(6) UNSIGNED NOT NULL,
  `location` varchar(50) NOT NULL,
  `datetime` datetime NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `appointments`
--

INSERT INTO `appointments` (`id`, `patient_id`, `doctor_id`, `location`, `datetime`, `description`) VALUES
(2, 1, 1, 'Thessaloniki', '2023-01-11 15:00:00', 'Γενική εξέταση'),
(4, 1, 1, 'Athens', '2023-01-13 12:00:00', 'Τεστ προστάτη'),
(5, 5, 2, 'Crete', '2023-02-01 17:00:00', 'Τεστ παπανικολάου');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `doctors`
--

CREATE TABLE `doctors` (
  `id` int(6) UNSIGNED NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `specialty` varchar(30) NOT NULL,
  `biography` varchar(30) NOT NULL,
  `image` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `doctors`
--

INSERT INTO `doctors` (`id`, `firstname`, `lastname`, `email`, `phone_number`, `username`, `password`, `specialty`, `biography`, `image`) VALUES
(1, 'Nikos', 'Georgiou', 'nikos_georgiou@gmail.com', '+30 6974651234', 'nikos', '1234', 'Andrologos', '', 'doctors/doctors-1.jpg'),
(2, 'Kostas', 'Papapetrou', 'kostas_papa@gmail.com', '+30 6985421763', 'Kostas', '12345', 'Gynaikologos', '', 'doctors/doctors-3.jpg');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `patients`
--

CREATE TABLE `patients` (
  `id` int(6) UNSIGNED NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Άδειασμα δεδομένων του πίνακα `patients`
--

INSERT INTO `patients` (`id`, `firstname`, `lastname`, `email`, `phone_number`, `username`, `password`) VALUES
(1, 'Kostas', 'Papadopoulos', 'kostas_papado@gmail.com', '+30 6975496213', 'kostas', '1234'),
(5, '', '', 'kostas1@yahoo.com', '', 'kostas1', '$2y$10$UeI5kqTGAZwlk/LYr9RfGuNO0MBK8g7LYcu7dUPNDGJP.tIQucy4m');

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointments_users` (`patient_id`),
  ADD KEY `appointments_doctors` (`doctor_id`);

--
-- Ευρετήρια για πίνακα `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT για πίνακα `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT για πίνακα `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Περιορισμοί για άχρηστους πίνακες
--

--
-- Περιορισμοί για πίνακα `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_doctors` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`),
  ADD CONSTRAINT `appointments_users` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
