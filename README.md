# Drone Fleet Management Web Application

## Introduction
This application allows users to register and keep track of their drone fleet, maintenance activities, flight hours, and total flight time. Additionally, users can record flight details such as the drone used, flight duration, departure coordinates or location, and any additional notes.

## Features
- User Registration: Users can create an account to access the platform and manage their drone fleet.
- Drone Management: Users can add, view, update, and delete drone records, including details such as drone model, serial number, and purchase date.
- Maintenance Tracking: Users can record maintenance activities for each drone, including maintenance type, date, and any additional notes.
- Flight Hours Tracking: Users can log flight hours for each drone, keeping track of total flight time.
- Flight Record Management: Users can create flight records, specifying the drone used, flight duration, departure coordinates or location, and any additional notes.
- Dashboard: Users have access to a personalized dashboard displaying an overview of their drone fleet, maintenance status, and flight statistics.

## Technologies Used
- Front-end: HTML, CSS
- Back-end: PHP, JavaScript, JQuery
- Database: MySQL

## Installation
1. Clone the repository: `git clone https://github.com/PietroVidoni/Drone-managerial.git`
2. Set up the database: Create a MySQL database and import the provided SQL file.
3. Configure the database connection: Update the database credentials in the `config.php` file.
4. Deploy the application: Copy the application files to a web server with PHP support.

## Usage
1. Register an account on the platform.
2. Log in using your credentials.
3. Navigate through the different sections to manage your drone fleet, record maintenance activities, log flight hours, and create flight records.
4. Use the dashboard to gain insights into your fleet's performance and maintenance needs.

## Future Enhancements
- Integration with mapping services to display flight paths and locations visually.
- Notification system to remind users of upcoming maintenance activities or flight hour thresholds.
- Reporting and analytics features to generate custom reports on fleet performance and maintenance history.

## License
This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).

## Contact
If you have any questions, suggestions, or issues, please feel free to contact us at [pietrovidoni4@gmail.com](mailto:pietrovidoni4@gmail.com).

## SQL DB

``` SQL
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Mag 25, 2023 alle 03:21
-- Versione del server: 10.5.18-MariaDB-0+deb11u1
-- Versione PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `c35login`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `droni`
--

CREATE TABLE `droni` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `modello` varchar(255) NOT NULL,
  `anno_acquisto` int(11) NOT NULL,
  `utente_id` int(11) NOT NULL,
  `ore_di_volo` int(11) NOT NULL,
  `ultima_manutenzione` date NOT NULL,
  `icon` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `record_di_volo`
--

CREATE TABLE `record_di_volo` (
  `id` int(11) NOT NULL,
  `drone_id` int(11) NOT NULL,
  `utente_id` int(11) NOT NULL,
  `tempo_di_volo` int(11) NOT NULL,
  `coordinate` varchar(255) NOT NULL,
  `luogo_di_partenza` varchar(255) NOT NULL,
  `note` varchar(255) NOT NULL,
  `data_volo` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cognome` varchar(255) NOT NULL,
  `session_id` varchar(32) DEFAULT NULL,
  `last_activity` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `droni`
--
ALTER TABLE `droni`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_droni_utenti_idx` (`utente_id`);

--
-- Indici per le tabelle `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `record_di_volo`
--
ALTER TABLE `record_di_volo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_record_di_volo_droni_idx` (`drone_id`),
  ADD KEY `fk_record_di_volo_utenti_idx` (`utente_id`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `droni`
--
ALTER TABLE `droni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT per la tabella `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT per la tabella `record_di_volo`
--
ALTER TABLE `record_di_volo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `droni`
--
ALTER TABLE `droni`
  ADD CONSTRAINT `fk_droni_utenti` FOREIGN KEY (`utente_id`) REFERENCES `utenti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `record_di_volo`
--
ALTER TABLE `record_di_volo`
  ADD CONSTRAINT `fk_record_di_volo_droni` FOREIGN KEY (`drone_id`) REFERENCES `droni` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_record_di_volo_utenti` FOREIGN KEY (`utente_id`) REFERENCES `utenti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

```
