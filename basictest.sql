-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 18-Jan-2023 às 04:32
-- Versão do servidor: 8.0.30
-- versão do PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `basictest`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `codes`
--

CREATE TABLE `codes` (
  `code_id` int NOT NULL,
  `code_code` varchar(50) NOT NULL,
  `code_desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `codes`
--

INSERT INTO `codes` (`code_id`, `code_code`, `code_desc`) VALUES
(1, '2000001', 'Diametro interno maior que o especificado'),
(2, '2000002', 'Diametro externo menor que o especificado'),
(3, '2000003', 'Diametro externo maior que o especificado'),
(4, '2000004', 'Dimensão maior que o especificado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `machines`
--

CREATE TABLE `machines` (
  `machine_id` int NOT NULL,
  `machine_code` varchar(50) NOT NULL,
  `machine_user_id` int NOT NULL,
  `machine_desc` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `machines`
--

INSERT INTO `machines` (`machine_id`, `machine_code`, `machine_user_id`, `machine_desc`) VALUES
(1, 'MAQ001', 2, ''),
(2, 'MAQ002', 2, ''),
(3, 'MAQ003', 2, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `production`
--

CREATE TABLE `production` (
  `production_id` int NOT NULL,
  `production_user_id` int NOT NULL,
  `production_machine_id` int NOT NULL,
  `production_value` int NOT NULL,
  `production_reason` varchar(255) NOT NULL,
  `production_time` varchar(50) NOT NULL,
  `production_altertime` varchar(50) DEFAULT NULL,
  `production_alterby` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `production`
--

INSERT INTO `production` (`production_id`, `production_user_id`, `production_machine_id`, `production_value`, `production_reason`, `production_time`, `production_altertime`, `production_alterby`) VALUES
(1, 2, 1, 2, 'Maquina emperrou', '2023-01-18 04:17:35', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `refuse`
--

CREATE TABLE `refuse` (
  `refuse_id` int NOT NULL,
  `refuse_user_id` int NOT NULL,
  `refuse_machine_id` int NOT NULL,
  `refuse_code_id` int NOT NULL,
  `refuse_value` int NOT NULL,
  `refuse_time` varchar(50) NOT NULL,
  `refuse_altertime` varchar(50) DEFAULT NULL,
  `refuse_alterby` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `refuse`
--

INSERT INTO `refuse` (`refuse_id`, `refuse_user_id`, `refuse_machine_id`, `refuse_code_id`, `refuse_value`, `refuse_time`, `refuse_altertime`, `refuse_alterby`) VALUES
(1, 2, 1, 1, 1, '2023-01-18 03:42:39', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `user_level` varchar(10) NOT NULL,
  `user_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_pass`, `user_level`, `user_token`) VALUES
(1, 'MASTER', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'admin', 'f8b38292393c335255ff9b706be61306280b5f25'),
(2, 'MAQ001', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'user', 'd60362c591912d751ee1ec3654f51b43a7d9a848'),
(3, 'MAQ002', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'user', 'dcc5df52ae21dae91a2f8b4eeadcfce88e37d84f');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `codes`
--
ALTER TABLE `codes`
  ADD PRIMARY KEY (`code_id`),
  ADD UNIQUE KEY `code_code` (`code_code`);

--
-- Índices para tabela `machines`
--
ALTER TABLE `machines`
  ADD PRIMARY KEY (`machine_id`),
  ADD UNIQUE KEY `machine_code` (`machine_code`),
  ADD KEY `machine_user_id` (`machine_user_id`);

--
-- Índices para tabela `production`
--
ALTER TABLE `production`
  ADD PRIMARY KEY (`production_id`),
  ADD KEY `production_user_id` (`production_user_id`),
  ADD KEY `production_machine_id` (`production_machine_id`);

--
-- Índices para tabela `refuse`
--
ALTER TABLE `refuse`
  ADD PRIMARY KEY (`refuse_id`),
  ADD KEY `refuse_user_id` (`refuse_user_id`),
  ADD KEY `refuse_machine_id` (`refuse_machine_id`),
  ADD KEY `refuse_code_id` (`refuse_code_id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `codes`
--
ALTER TABLE `codes`
  MODIFY `code_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `machines`
--
ALTER TABLE `machines`
  MODIFY `machine_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `production`
--
ALTER TABLE `production`
  MODIFY `production_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `refuse`
--
ALTER TABLE `refuse`
  MODIFY `refuse_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `machines`
--
ALTER TABLE `machines`
  ADD CONSTRAINT `machines_ibfk_1` FOREIGN KEY (`machine_user_id`) REFERENCES `users` (`user_id`);

--
-- Limitadores para a tabela `production`
--
ALTER TABLE `production`
  ADD CONSTRAINT `production_ibfk_1` FOREIGN KEY (`production_user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `production_ibfk_2` FOREIGN KEY (`production_machine_id`) REFERENCES `machines` (`machine_id`);

--
-- Limitadores para a tabela `refuse`
--
ALTER TABLE `refuse`
  ADD CONSTRAINT `refuse_ibfk_1` FOREIGN KEY (`refuse_user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `refuse_ibfk_2` FOREIGN KEY (`refuse_machine_id`) REFERENCES `machines` (`machine_id`),
  ADD CONSTRAINT `refuse_ibfk_3` FOREIGN KEY (`refuse_code_id`) REFERENCES `codes` (`code_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
