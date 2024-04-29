-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 29 2024 г., 17:55
-- Версия сервера: 8.0.30
-- Версия PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `Single_Test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Admins`
--

CREATE TABLE `Admins` (
  `id` int NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Admins`
--

INSERT INTO `Admins` (`id`, `login`, `password`) VALUES
(1, 'admin', '$2y$10$uYv65GFFJ5peU8A7kODs...IJVqHnmBDBMfvcU1nWLRRNFqaB10hK');

-- --------------------------------------------------------

--
-- Структура таблицы `Answers`
--

CREATE TABLE `Answers` (
  `id` int NOT NULL,
  `anser_text` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Answers`
--

INSERT INTO `Answers` (`id`, `anser_text`) VALUES
(1, 'Финансовые мотивы'),
(2, 'Общественное признание'),
(3, 'Отношение с руководством'),
(4, 'Карьера, продвижение по службе'),
(5, 'Достижение личного успеха'),
(6, 'Содержание работы'),
(7, 'Сотрудничество в коллективе'),
(8, 'Крутые цели компании'),
(9, 'Имидж компании'),
(10, 'Престиж профессии'),
(11, '«Белая зарплата»'),
(12, 'Комфортная атмосфера в коллективе'),
(13, 'Возможность обучения'),
(14, 'Возможность профессионального роста'),
(15, 'Масштабные интересные задачи'),
(16, 'Гибкий график'),
(17, 'Возможность удалённой работы'),
(18, 'Близость работы'),
(19, 'Современный офис'),
(20, 'Удовольствие от процесса работы'),
(21, 'Обеспеченность оргтехникой / упакованное рабочее место'),
(22, 'Самостоятельность в работе'),
(23, 'Разнообразие работы'),
(24, 'Низкая напряжённость труда'),
(25, 'Возможность участия в управлении'),
(26, 'Другое');

-- --------------------------------------------------------

--
-- Структура таблицы `Companies`
--

CREATE TABLE `Companies` (
  `id` int NOT NULL,
  `is_anon` tinyint(1) NOT NULL,
  `name` varchar(255) NOT NULL,
  `max_answers` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Companies`
--

INSERT INTO `Companies` (`id`, `is_anon`, `name`, `max_answers`) VALUES
(1, 1, 'Компания 1', 5),
(4, 0, 'robo', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `UserAnswers`
--

CREATE TABLE `UserAnswers` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `answer_id` int NOT NULL,
  `answer_priority` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `UserAnswers`
--

INSERT INTO `UserAnswers` (`id`, `user_id`, `answer_id`, `answer_priority`) VALUES
(18, 7, 2, 1),
(19, 7, 3, 2),
(20, 7, 4, 3),
(24, 8, 20, 1),
(25, 8, 18, 2),
(26, 8, 1, 3),
(27, 9, 9, 1),
(28, 9, 11, 2),
(29, 9, 10, 3),
(30, 9, 6, 4),
(31, 10, 1, 1),
(32, 10, 3, 2),
(33, 10, 8, 3),
(34, 10, 5, 4),
(35, 10, 11, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `Users`
--

CREATE TABLE `Users` (
  `id` int NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `second_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `post_position` varchar(255) DEFAULT NULL,
  `is_anon` tinyint(1) NOT NULL,
  `company_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Users`
--

INSERT INTO `Users` (`id`, `first_name`, `second_name`, `last_name`, `post_position`, `is_anon`, `company_id`) VALUES
(7, 'Анонимный', '', '', '', 1, 1),
(8, 'Анонимный', '', '', '', 1, 1),
(9, 'Никита', 'Прокофьев', 'Вячеславович', 'Программист', 0, 4),
(10, 'Анонимный', '', '', '', 1, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Admins`
--
ALTER TABLE `Admins`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Answers`
--
ALTER TABLE `Answers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Companies`
--
ALTER TABLE `Companies`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `UserAnswers`
--
ALTER TABLE `UserAnswers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `answer_id` (`answer_id`);

--
-- Индексы таблицы `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Admins`
--
ALTER TABLE `Admins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `Answers`
--
ALTER TABLE `Answers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT для таблицы `Companies`
--
ALTER TABLE `Companies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `UserAnswers`
--
ALTER TABLE `UserAnswers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT для таблицы `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `UserAnswers`
--
ALTER TABLE `UserAnswers`
  ADD CONSTRAINT `useranswers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`),
  ADD CONSTRAINT `useranswers_ibfk_2` FOREIGN KEY (`answer_id`) REFERENCES `Answers` (`id`);

--
-- Ограничения внешнего ключа таблицы `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `Companies` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
