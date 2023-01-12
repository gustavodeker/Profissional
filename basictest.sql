-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 12-Jan-2023 às 01:06
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
-- Estrutura da tabela `registro`
--

CREATE TABLE `registro` (
  `registro_id` int NOT NULL,
  `registro_nome` varchar(255) NOT NULL,
  `registro_setor` varchar(255) NOT NULL,
  `registro_servico` varchar(255) NOT NULL,
  `registro_desc` varchar(255) NOT NULL,
  `registro_data` varchar(255) NOT NULL
);

--
-- Extraindo dados da tabela `registro`
--

INSERT INTO `registro` (`registro_id`, `registro_nome`, `registro_setor`, `registro_servico`, `registro_desc`, `registro_data`) VALUES
(1, 'Gustavo', 'Administrativo', 'Designar almoço', 'Mandar funcionário comer batata', '2023-01-12 00:35:36'),
(2, 'Bruno', 'RH', 'Contratação', 'Contratação de funcionarios novos', '2023-01-12 00:55:43'),
(3, 'Ricardo', 'Financeiro', 'Notas', 'Lançamento de notas de serviço', '2023-01-12 00:37:29');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `user_nome` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_senha` varchar(255) NOT NULL,
  `user_nivel` varchar(255) NOT NULL,
  `user_token` varchar(255) DEFAULT NULL
);

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`user_id`, `user_nome`, `user_email`, `user_senha`, `user_nivel`, `user_token`) VALUES
(2, 'Gustavo', '123@123.com', '601f1889667efaebb33b8c12572835da3f027f78', '', '26a4dd375c9dc352132e6d0845df0cf1069e0e68'),
(3, 'Admin', 'admin@admin.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'admin', 'f6bd22a3f3388e21150afd908bb7e76bce2def7c');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `registro`
--
ALTER TABLE `registro`
  ADD PRIMARY KEY (`registro_id`);

--
-- Índices para tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `registro`
--
ALTER TABLE `registro`
  MODIFY `registro_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
