-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 14. Mai 2021 um 23:09
-- Server-Version: 8.0.23-0ubuntu0.20.04.1
-- PHP-Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `Skuska`
--
CREATE DATABASE IF NOT EXISTS `Skuska` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `Skuska`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `AnswerTypeConnect`
--

CREATE TABLE `AnswerTypeConnect` (
  `id` int NOT NULL,
  `student_exam_fk` int NOT NULL,
  `question_type_fk` int NOT NULL,
  `points` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `AnswerTypeMath`
--

CREATE TABLE `AnswerTypeMath` (
  `id` int NOT NULL,
  `student_exam_fk` int NOT NULL,
  `question_type_fk` int NOT NULL,
  `answer` varchar(255) NOT NULL,
  `points` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `AnswerTypeMultiple`
--

CREATE TABLE `AnswerTypeMultiple` (
  `id` int NOT NULL,
  `question_type_fk` int NOT NULL,
  `student_exam_fk` int NOT NULL,
  `points` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `AnswerTypePicture`
--

CREATE TABLE `AnswerTypePicture` (
  `id` int NOT NULL,
  `student_exam_fk` int NOT NULL,
  `question_type_fk` int NOT NULL,
  `points` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `AnswerTypeText`
--

CREATE TABLE `AnswerTypeText` (
  `id` int NOT NULL,
  `question_type_fk` int NOT NULL,
  `answer` varchar(255) NOT NULL,
  `student_exam_fk` int NOT NULL,
  `points` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Exam`
--

CREATE TABLE `Exam` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `teacher_fk` int DEFAULT NULL,
  `code` varchar(5) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `LeftOption`
--

CREATE TABLE `LeftOption` (
  `id` int NOT NULL,
  `answer_type_fk` int NOT NULL,
  `option_type_fk` int NOT NULL,
  `connected_to` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `OptionMarkedAsCorrect`
--

CREATE TABLE `OptionMarkedAsCorrect` (
  `id` int NOT NULL,
  `option_type_fk` int NOT NULL,
  `answer_type_fk` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `OptionTypeConnect`
--

CREATE TABLE `OptionTypeConnect` (
  `id` int NOT NULL,
  `answer` varchar(255) NOT NULL,
  `is_left` tinyint(1) NOT NULL,
  `question_type_fk` int NOT NULL,
  `connect_option_fk` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `OptionTypeMultiple`
--

CREATE TABLE `OptionTypeMultiple` (
  `id` int NOT NULL,
  `answer` varchar(255) NOT NULL,
  `is_correct` tinyint(1) NOT NULL,
  `question_type_fk` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `QuestionTypeConnect`
--

CREATE TABLE `QuestionTypeConnect` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `exam_fk` int NOT NULL,
  `max_points` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `QuestionTypeMath`
--

CREATE TABLE `QuestionTypeMath` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `exam_fk` int NOT NULL,
  `max_points` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `QuestionTypeMultiple`
--

CREATE TABLE `QuestionTypeMultiple` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `exam_fk` int NOT NULL,
  `max_points` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `QuestionTypePicture`
--

CREATE TABLE `QuestionTypePicture` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `exam_fk` int NOT NULL,
  `max_points` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `QuestionTypeText`
--

CREATE TABLE `QuestionTypeText` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `correct_answer` varchar(255) NOT NULL,
  `exam_fk` int NOT NULL,
  `max_points` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Student`
--

CREATE TABLE `Student` (
  `ais_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Student_Exam`
--

CREATE TABLE `Student_Exam` (
  `id` int NOT NULL,
  `student_fk` varchar(255) NOT NULL,
  `exam_fk` int NOT NULL,
  `is_finished` tinyint(1) NOT NULL,
  `left_website` tinyint(1) NOT NULL,
  `start_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `points_earned` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Teacher`
--

CREATE TABLE `Teacher` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `Teacher`
--

INSERT INTO `Teacher` (`id`, `username`, `password`) VALUES
(1, 'teacher', '$2y$10$9agqbwxvpMAiWMTPvvyx7OyohP8X/AZFW1FkW13dE.273J0g0/G8S');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `AnswerTypeConnect`
--
ALTER TABLE `AnswerTypeConnect`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_type_fk` (`question_type_fk`),
  ADD KEY `student_exam_fk` (`student_exam_fk`);

--
-- Indizes für die Tabelle `AnswerTypeMath`
--
ALTER TABLE `AnswerTypeMath`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_exam_fk` (`student_exam_fk`),
  ADD KEY `question_type_fk` (`question_type_fk`);

--
-- Indizes für die Tabelle `AnswerTypeMultiple`
--
ALTER TABLE `AnswerTypeMultiple`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_type_fk` (`question_type_fk`),
  ADD KEY `student_exam_fk` (`student_exam_fk`);

--
-- Indizes für die Tabelle `AnswerTypePicture`
--
ALTER TABLE `AnswerTypePicture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_exam_fk` (`student_exam_fk`),
  ADD KEY `question_type_fk` (`question_type_fk`);

--
-- Indizes für die Tabelle `AnswerTypeText`
--
ALTER TABLE `AnswerTypeText`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_exam_fk` (`student_exam_fk`),
  ADD KEY `question_type_fk` (`question_type_fk`);

--
-- Indizes für die Tabelle `Exam`
--
ALTER TABLE `Exam`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `teacher_fk` (`teacher_fk`);

--
-- Indizes für die Tabelle `LeftOption`
--
ALTER TABLE `LeftOption`
  ADD PRIMARY KEY (`id`),
  ADD KEY `option_type_fk` (`option_type_fk`),
  ADD KEY `connected_to` (`connected_to`),
  ADD KEY `answer_type_fk` (`answer_type_fk`);

--
-- Indizes für die Tabelle `OptionMarkedAsCorrect`
--
ALTER TABLE `OptionMarkedAsCorrect`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answer_type_fk` (`answer_type_fk`),
  ADD KEY `option_type_fk` (`option_type_fk`);

--
-- Indizes für die Tabelle `OptionTypeConnect`
--
ALTER TABLE `OptionTypeConnect`
  ADD PRIMARY KEY (`id`),
  ADD KEY `connect_option_fk` (`connect_option_fk`),
  ADD KEY `question_type_fk` (`question_type_fk`);

--
-- Indizes für die Tabelle `OptionTypeMultiple`
--
ALTER TABLE `OptionTypeMultiple`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_type_fk` (`question_type_fk`);

--
-- Indizes für die Tabelle `QuestionTypeConnect`
--
ALTER TABLE `QuestionTypeConnect`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_fk` (`exam_fk`);

--
-- Indizes für die Tabelle `QuestionTypeMath`
--
ALTER TABLE `QuestionTypeMath`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_fk` (`exam_fk`);

--
-- Indizes für die Tabelle `QuestionTypeMultiple`
--
ALTER TABLE `QuestionTypeMultiple`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_fk` (`exam_fk`);

--
-- Indizes für die Tabelle `QuestionTypePicture`
--
ALTER TABLE `QuestionTypePicture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_fk` (`exam_fk`);

--
-- Indizes für die Tabelle `QuestionTypeText`
--
ALTER TABLE `QuestionTypeText`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_fk` (`exam_fk`);

--
-- Indizes für die Tabelle `Student`
--
ALTER TABLE `Student`
  ADD PRIMARY KEY (`ais_id`);

--
-- Indizes für die Tabelle `Student_Exam`
--
ALTER TABLE `Student_Exam`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_fk` (`exam_fk`),
  ADD KEY `student_fk` (`student_fk`);

--
-- Indizes für die Tabelle `Teacher`
--
ALTER TABLE `Teacher`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `AnswerTypeConnect`
--
ALTER TABLE `AnswerTypeConnect`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `AnswerTypeMath`
--
ALTER TABLE `AnswerTypeMath`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `AnswerTypeMultiple`
--
ALTER TABLE `AnswerTypeMultiple`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `AnswerTypePicture`
--
ALTER TABLE `AnswerTypePicture`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `AnswerTypeText`
--
ALTER TABLE `AnswerTypeText`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `Exam`
--
ALTER TABLE `Exam`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `LeftOption`
--
ALTER TABLE `LeftOption`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `OptionMarkedAsCorrect`
--
ALTER TABLE `OptionMarkedAsCorrect`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `OptionTypeConnect`
--
ALTER TABLE `OptionTypeConnect`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `OptionTypeMultiple`
--
ALTER TABLE `OptionTypeMultiple`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `QuestionTypeConnect`
--
ALTER TABLE `QuestionTypeConnect`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `QuestionTypeMath`
--
ALTER TABLE `QuestionTypeMath`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `QuestionTypeMultiple`
--
ALTER TABLE `QuestionTypeMultiple`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `QuestionTypePicture`
--
ALTER TABLE `QuestionTypePicture`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `QuestionTypeText`
--
ALTER TABLE `QuestionTypeText`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `Student_Exam`
--
ALTER TABLE `Student_Exam`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `Teacher`
--
ALTER TABLE `Teacher`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `AnswerTypeConnect`
--
ALTER TABLE `AnswerTypeConnect`
  ADD CONSTRAINT `AnswerTypeConnect_ibfk_1` FOREIGN KEY (`question_type_fk`) REFERENCES `QuestionTypeConnect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `AnswerTypeConnect_ibfk_2` FOREIGN KEY (`student_exam_fk`) REFERENCES `Student_Exam` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `AnswerTypeMath`
--
ALTER TABLE `AnswerTypeMath`
  ADD CONSTRAINT `AnswerTypeMath_ibfk_1` FOREIGN KEY (`student_exam_fk`) REFERENCES `Student_Exam` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `AnswerTypeMath_ibfk_2` FOREIGN KEY (`question_type_fk`) REFERENCES `QuestionTypeMath` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `AnswerTypeMultiple`
--
ALTER TABLE `AnswerTypeMultiple`
  ADD CONSTRAINT `AnswerTypeMultiple_ibfk_1` FOREIGN KEY (`question_type_fk`) REFERENCES `QuestionTypeMultiple` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `AnswerTypeMultiple_ibfk_2` FOREIGN KEY (`student_exam_fk`) REFERENCES `Student_Exam` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `AnswerTypePicture`
--
ALTER TABLE `AnswerTypePicture`
  ADD CONSTRAINT `AnswerTypePicture_ibfk_1` FOREIGN KEY (`student_exam_fk`) REFERENCES `Student_Exam` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `AnswerTypePicture_ibfk_2` FOREIGN KEY (`question_type_fk`) REFERENCES `QuestionTypePicture` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `AnswerTypeText`
--
ALTER TABLE `AnswerTypeText`
  ADD CONSTRAINT `AnswerTypeText_ibfk_1` FOREIGN KEY (`student_exam_fk`) REFERENCES `Student_Exam` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `AnswerTypeText_ibfk_2` FOREIGN KEY (`question_type_fk`) REFERENCES `QuestionTypeText` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `Exam`
--
ALTER TABLE `Exam`
  ADD CONSTRAINT `Exam_ibfk_1` FOREIGN KEY (`teacher_fk`) REFERENCES `Teacher` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `LeftOption`
--
ALTER TABLE `LeftOption`
  ADD CONSTRAINT `LeftOption_ibfk_1` FOREIGN KEY (`option_type_fk`) REFERENCES `OptionTypeConnect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LeftOption_ibfk_2` FOREIGN KEY (`connected_to`) REFERENCES `OptionTypeConnect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LeftOption_ibfk_3` FOREIGN KEY (`answer_type_fk`) REFERENCES `AnswerTypeConnect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `OptionMarkedAsCorrect`
--
ALTER TABLE `OptionMarkedAsCorrect`
  ADD CONSTRAINT `OptionMarkedAsCorrect_ibfk_1` FOREIGN KEY (`answer_type_fk`) REFERENCES `AnswerTypeMultiple` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `OptionMarkedAsCorrect_ibfk_2` FOREIGN KEY (`option_type_fk`) REFERENCES `OptionTypeMultiple` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `OptionTypeConnect`
--
ALTER TABLE `OptionTypeConnect`
  ADD CONSTRAINT `OptionTypeConnect_ibfk_1` FOREIGN KEY (`connect_option_fk`) REFERENCES `OptionTypeConnect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `OptionTypeConnect_ibfk_2` FOREIGN KEY (`question_type_fk`) REFERENCES `QuestionTypeConnect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `OptionTypeMultiple`
--
ALTER TABLE `OptionTypeMultiple`
  ADD CONSTRAINT `OptionTypeMultiple_ibfk_1` FOREIGN KEY (`question_type_fk`) REFERENCES `QuestionTypeMultiple` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `QuestionTypeConnect`
--
ALTER TABLE `QuestionTypeConnect`
  ADD CONSTRAINT `QuestionTypeConnect_ibfk_1` FOREIGN KEY (`exam_fk`) REFERENCES `Exam` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `QuestionTypeMath`
--
ALTER TABLE `QuestionTypeMath`
  ADD CONSTRAINT `QuestionTypeMath_ibfk_1` FOREIGN KEY (`exam_fk`) REFERENCES `Exam` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `QuestionTypeMultiple`
--
ALTER TABLE `QuestionTypeMultiple`
  ADD CONSTRAINT `QuestionTypeMultiple_ibfk_1` FOREIGN KEY (`exam_fk`) REFERENCES `Exam` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `QuestionTypePicture`
--
ALTER TABLE `QuestionTypePicture`
  ADD CONSTRAINT `QuestionTypePicture_ibfk_1` FOREIGN KEY (`exam_fk`) REFERENCES `Exam` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `QuestionTypeText`
--
ALTER TABLE `QuestionTypeText`
  ADD CONSTRAINT `QuestionTypeText_ibfk_1` FOREIGN KEY (`exam_fk`) REFERENCES `Exam` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `Student_Exam`
--
ALTER TABLE `Student_Exam`
  ADD CONSTRAINT `Student_Exam_ibfk_1` FOREIGN KEY (`exam_fk`) REFERENCES `Exam` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Student_Exam_ibfk_2` FOREIGN KEY (`student_fk`) REFERENCES `Student` (`ais_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
