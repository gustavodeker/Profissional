-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 21-Fev-2023 às 23:53
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
(1, '200001', 'Diametro interno maior que o especificado'),
(2, '200002', 'Diametro externo menor que o especificado'),
(3, '200003', 'Diametro externo maior que o especificado'),
(4, '200004', 'Dimensão maior que o especificado'),
(5, '200005', 'Dimensão menor que o especificado'),
(6, '200006', 'Rosca fora do especificado'),
(7, '200007', 'Chanfro fora do especificado'),
(8, '200008', 'Linearidade fora do especificado'),
(9, '200009', 'Planicidade fora do especificado'),
(10, '200010', 'Circularidade fora do especificado'),
(11, '200011', 'Cilindricidade fora do especificado'),
(12, '200012', 'Perfil fora do especificado'),
(13, '200013', 'Paralelismo fora do especificado'),
(14, '200014', 'Perpendicularidade fora do especificado'),
(15, '200015', 'Angularidade fora do especificado'),
(16, '200016', 'Posição real fora do especificado'),
(17, '200017', 'Concentricidade fora do especificado'),
(18, '200018', 'Simetria fora do especificado'),
(19, '200019', 'Batimento fora do especificado'),
(20, '200020', 'Rugosidade fora do especificado'),
(21, '200021', 'Bocal deslocado'),
(22, '200023', 'Risco de ferramenta'),
(23, '200024', 'Marcas e batidas'),
(24, '200025', 'Rebarbas'),
(25, '200026', 'Oxidação'),
(26, '200027', 'Falha na montagem'),
(27, '200028', 'Aspecto visual não conforme'),
(28, '200029', 'Usinagem incompleta'),
(29, '200030', 'Peças rotina, liberação, pintadas de vermelho'),
(30, '200031', 'Espessura radial fora do especificado'),
(31, '200032', 'GAP fechado fora do especificado'),
(32, '200033', 'Falha de balanceamento'),
(33, '200034', 'GAP fora do especificado'),
(34, '200035', 'Vibração (ferramenta)'),
(35, '200036', 'Diametro interno menor que o especificado'),
(36, '200037', 'Empenamento'),
(37, '100001', 'Estanquierdade fora (impregna)'),
(38, '100002', 'Material fora do especificado'),
(39, '100003', 'Falha de Material'),
(40, '100004', 'Dureza fora do especificado'),
(41, '100005', 'Flotação de Grafita'),
(42, '100006', 'Matriz fora do especificado'),
(43, '100007', 'Empenamento'),
(44, '100008', 'Rechupe'),
(45, '100009', 'Porosidade (fora do criterio)'),
(46, '100010', 'Trinca'),
(47, '100011', 'Junta fria'),
(48, '100012', 'Bolha de gas'),
(49, '100013', 'Incrustação'),
(50, '100014', 'Agarramento'),
(51, '100015', 'Falha de enchimento'),
(52, '100016', 'Veiamento (trinca do macho)'),
(53, '100018', 'Superficie marmorizada manchada'),
(54, '100019', 'Inclusão'),
(55, '100020', 'Macho quebrado'),
(56, '100021', 'Cura inadequada'),
(57, '100022', 'Peça danificada no estampo'),
(58, '100023', 'Peça inicio de produção'),
(59, '100024', 'Pino quebrado'),
(60, '100025', 'Pino torto'),
(61, '100026', 'Inserto quebrado'),
(62, '100027', 'Peça manchada'),
(63, '100028', 'Quebra negativa'),
(64, '100029', 'Excesso de rebarbação'),
(65, '100030', 'Composição quimica fora do especificado'),
(66, '100031', 'Falha de balanceamento'),
(67, '100032', 'Corte de serrra incorreto'),
(68, '100033', 'Material para fusão (Retorno)'),
(69, '100034', 'Bocal deslocado - Fundição'),
(70, '100035', 'Marcas e batidas - Fundição'),
(71, '100036', 'Aspecto visual não conforme - Fundição'),
(72, '100037', 'Dimensão maior que o especificado '),
(73, '100038', 'Dimensão menor que o especificado'),
(74, '100039', 'Rugosidade fora do especificado'),
(75, '100040', 'Descontinuidade de cola'),
(76, '100041', 'Pino extrator avançado'),
(77, '100042', 'Pino extrator avançado'),
(78, '100043', 'Estanquiedade fora (refugo)'),
(79, '100044', 'GAP fora do especificado (Fundição)'),
(80, '100045', 'Teste de sanidade (Injeção)');

-- --------------------------------------------------------

--
-- Estrutura da tabela `gp`
--

CREATE TABLE `gp` (
  `gp_id` int NOT NULL,
  `gp_user` varchar(50) NOT NULL,
  `gp_machine` varchar(50) NOT NULL,
  `gp_reason` varchar(255) NOT NULL,
  `gp_value` int NOT NULL,
  `gp_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `gp_prod_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `gp`
--

INSERT INTO `gp` (`gp_id`, `gp_user`, `gp_machine`, `gp_reason`, `gp_value`, `gp_time`, `gp_prod_id`) VALUES
(1, 'Desenvolvedor', 'CF338', 'zdasd', 1, '2023-02-03 22:20:45', 1),
(2, 'Desenvolvedor', 'CF338', 'asdasdas', 1, '2023-02-03 22:20:47', 2),
(3, 'Desenvolvedor', 'CF309', 'asdasd', 2, '2023-02-03 22:20:50', 3),
(4, 'Desenvolvedor', 'CU311', 'asdasdas', 1, '2023-02-03 22:20:53', 4),
(5, 'Desenvolvedor', 'CF395', 'asdasdasd', 2, '2023-02-03 22:20:58', 5),
(6, 'Desenvolvedor', 'CU311', 'asdasda', 1, '2023-02-03 22:21:01', 6),
(7, 'Desenvolvedor', 'CU311', 'asdasd', 3, '2023-02-03 22:21:03', 7),
(8, 'Desenvolvedor', 'CU311', 'dasdasdas', 2, '2023-02-03 22:21:59', 8),
(9, 'Desenvolvedor', 'CU311', 'asdasd', 1, '2023-02-03 22:22:01', 9),
(10, 'Desenvolvedor', 'CF174', 'asdasd', 1, '2023-02-03 22:22:05', 10),
(11, 'Desenvolvedor', 'CF383', 'dfgdfgdf', 1, '2023-02-03 22:22:08', 11),
(12, 'Desenvolvedor', 'CF309', 'dfgdfgdf', 1, '2023-02-03 22:22:11', 12),
(13, 'Desenvolvedor', 'CU311', 'dfgdfg', 5, '2023-02-03 22:22:13', 13),
(14, 'Desenvolvedor', 'CF428', 'dfgd', 1, '2023-02-03 22:22:16', 14),
(15, 'Desenvolvedor', 'CF428', 'dfg', 1, '2023-02-03 22:22:18', 15),
(16, 'Desenvolvedor', 'CF428', 'dfg', 1, '2023-02-03 22:22:19', 16),
(17, 'Desenvolvedor', 'CF428', 'fghjgh', 1, '2023-02-03 22:22:21', 17),
(18, 'Desenvolvedor', 'CF428', 'jklkjlyuk', 3, '2023-02-03 22:22:22', 18),
(19, 'Desenvolvedor', 'CF428', '34523423', 5, '2023-02-03 22:22:24', 19),
(20, 'Desenvolvedor', 'CF428', 'kukyuk34', 3, '2023-02-03 22:22:27', 20),
(21, 'Administrador', 'CF428', 'fsdfsdfsdf', 1, '2023-02-05 12:58:59', 21),
(22, 'Desenvolvedor', 'CF428', 'qweqweqwe', 7, '2023-02-11 15:03:38', 22),
(23, 'Desenvolvedor', 'CF383', 'qwewqeqw', 5, '2023-02-11 15:03:40', 23),
(24, 'Desenvolvedor', 'CF174', 'qewqeqw', 6, '2023-02-11 15:03:47', 24),
(25, 'Desenvolvedor', 'CU311', 'qweqweqweqw', 3, '2023-02-11 15:03:50', 25),
(26, 'Desenvolvedor', 'CF309', 'qweqwewq', 6, '2023-02-11 15:03:55', 26),
(27, 'Desenvolvedor', 'CF428', 'qweqwewqeqweq', 4, '2023-02-11 15:03:58', 27),
(28, 'Desenvolvedor', 'CF338', 'qweqweqweqwewe', 6, '2023-02-11 15:04:02', 28),
(29, 'Desenvolvedor', 'CF428', 'qweqweqwewq', 6, '2023-02-11 15:04:06', 29),
(30, 'Desenvolvedor', 'CF310', 'asasd', 13, '2023-02-11 15:05:27', 30),
(31, 'Desenvolvedor', 'CF428', 'Sensor parou', 2, '2023-02-12 18:07:29', 31);

-- --------------------------------------------------------

--
-- Estrutura da tabela `gr`
--

CREATE TABLE `gr` (
  `gr_id` int NOT NULL,
  `gr_user` varchar(50) NOT NULL,
  `gr_machine` varchar(50) NOT NULL,
  `gr_code` varchar(50) NOT NULL,
  `gr_value` int NOT NULL,
  `gr_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `gr_refuse_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `gr`
--

INSERT INTO `gr` (`gr_id`, `gr_user`, `gr_machine`, `gr_code`, `gr_value`, `gr_time`, `gr_refuse_id`) VALUES
(1, 'Desenvolvedor', 'CF309', '200001', 1, '2023-02-03 22:20:25', 1),
(2, 'Desenvolvedor', 'CF309', '200001', 1, '2023-02-03 22:20:26', 2),
(3, 'Desenvolvedor', 'CF309', '200001', 1, '2023-02-03 22:20:29', 3),
(4, 'Desenvolvedor', 'CF309', '200001', 1, '2023-02-03 22:20:30', 4),
(5, 'Desenvolvedor', 'CF309', '200001', 1, '2023-02-03 22:20:31', 5),
(6, 'Desenvolvedor', 'CF309', '200001', 1, '2023-02-03 22:20:31', 5),
(7, 'Desenvolvedor', 'CF309', '200001', 1, '2023-02-03 22:20:32', 7),
(8, 'Desenvolvedor', 'CF309', '200001', 1, '2023-02-03 22:20:32', 8),
(9, 'Desenvolvedor', 'CF309', '200001', 1, '2023-02-03 22:20:33', 9),
(10, 'Desenvolvedor', 'CF309', '200001', 1, '2023-02-03 22:20:34', 10),
(11, 'Desenvolvedor', 'CF309', '200001', 1, '2023-02-03 22:20:35', 11),
(12, 'Desenvolvedor', 'CF383', '200006', 1, '2023-02-03 22:20:38', 12),
(13, 'Desenvolvedor', 'CF309', '200019', 1, '2023-02-03 22:20:41', 13),
(14, 'Desenvolvedor', 'CF310', '200005', 1, '2023-02-03 22:21:17', 14),
(15, 'Desenvolvedor', 'CF310', '200025', 1, '2023-02-03 22:21:20', 15),
(16, 'Desenvolvedor', 'CF310', '200006', 2, '2023-02-03 22:21:22', 16),
(17, 'Desenvolvedor', 'CF310', '200007', 2, '2023-02-03 22:21:23', 17),
(18, 'Desenvolvedor', 'CF310', '200004', 2, '2023-02-03 22:21:25', 18),
(19, 'Desenvolvedor', 'CF310', '200003', 1, '2023-02-03 22:21:26', 19),
(20, 'Desenvolvedor', 'CF310', '200004', 1, '2023-02-03 22:21:27', 20),
(21, 'Desenvolvedor', 'CF383', '200023', 1, '2023-02-03 22:21:31', 21),
(22, 'Desenvolvedor', 'CF383', '100031', 1, '2023-02-03 22:21:35', 22),
(23, 'Desenvolvedor', 'CF383', '100043', 1, '2023-02-03 22:21:38', 23),
(24, 'Desenvolvedor', 'CF383', '100045', 1, '2023-02-03 22:21:42', 24),
(25, 'Desenvolvedor', 'CF383', '100045', 1, '2023-02-03 22:21:48', 25),
(26, 'Desenvolvedor', 'CF428', '200011', 2, '2023-02-03 22:25:40', 26),
(27, 'Administrador', 'CF310', '200002', 1, '2023-02-05 12:58:52', 27),
(28, 'Desenvolvedor', 'CF428', '200003', 1, '2023-02-12 18:07:10', 28),
(29, 'Desenvolvedor', 'CF428', '200023', 2, '2023-02-12 18:07:16', 29),
(30, 'Desenvolvedor', 'CF428', '200001', 1, '2023-02-20 08:40:00', 30);

-- --------------------------------------------------------

--
-- Estrutura da tabela `machines`
--

CREATE TABLE `machines` (
  `machine_id` int NOT NULL,
  `machine_name` varchar(50) NOT NULL,
  `machine_marca` varchar(255) NOT NULL,
  `machine_users` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `machines`
--

INSERT INTO `machines` (`machine_id`, `machine_name`, `machine_marca`, `machine_users`) VALUES
(1, 'CF338', 'Marca', '#,704070,#'),
(2, 'CF428', 'Marca', '#,704070,#'),
(3, 'CF309', 'Marca', '#,704070,#'),
(4, 'CF310', 'Marca', '#,704070,#'),
(5, 'CU311', 'Marca', '#,Gaiolas Valeo 1,#'),
(6, 'CF174', 'Marca', '#,Gaiolas Valeo 1,#'),
(7, 'CF395', 'Marca', '#,Gaiolas Valeo 2,#'),
(8, 'CF383', 'Marca', '#,Gaiolas Valeo 2,#');

-- --------------------------------------------------------

--
-- Estrutura da tabela `prod`
--

CREATE TABLE `prod` (
  `prod_id` int NOT NULL,
  `prod_user_name` varchar(50) DEFAULT NULL,
  `prod_machine_name` varchar(50) NOT NULL,
  `prod_value` int NOT NULL,
  `prod_reason` varchar(255) DEFAULT NULL,
  `prod_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `prod_altertime` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `prod_alterby` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `prod`
--

INSERT INTO `prod` (`prod_id`, `prod_user_name`, `prod_machine_name`, `prod_value`, `prod_reason`, `prod_datetime`, `prod_altertime`, `prod_alterby`) VALUES
(1, 'Desenvolvedor', 'CF338', 1, 'zdasd', '2023-02-03 22:20:45', NULL, NULL),
(2, 'Desenvolvedor', 'CF338', 1, 'asdasdas', '2023-02-03 22:20:47', NULL, NULL),
(3, 'Desenvolvedor', 'CF309', 2, 'asdasd', '2023-02-03 22:20:50', NULL, NULL),
(4, 'Desenvolvedor', 'CU311', 1, 'asdasdas', '2023-02-03 22:20:53', NULL, NULL),
(5, 'Desenvolvedor', 'CF395', 2, 'asdasdasd', '2023-02-03 22:20:58', NULL, NULL),
(6, 'Desenvolvedor', 'CU311', 1, 'asdasda', '2023-02-03 22:21:01', NULL, NULL),
(7, 'Desenvolvedor', 'CU311', 3, 'asdasd', '2023-02-03 22:21:03', NULL, NULL),
(8, 'Desenvolvedor', 'CU311', 2, 'dasdasdas', '2023-02-03 22:21:59', NULL, NULL),
(9, 'Desenvolvedor', 'CU311', 1, 'asdasd', '2023-02-03 22:22:01', NULL, NULL),
(10, 'Desenvolvedor', 'CF174', 1, 'asdasd', '2023-02-03 22:22:05', NULL, NULL),
(11, 'Desenvolvedor', 'CF383', 1, 'dfgdfgdf', '2023-02-03 22:22:08', NULL, NULL),
(12, 'Desenvolvedor', 'CF309', 1, 'dfgdfgdf', '2023-02-03 22:22:11', NULL, NULL),
(13, 'Desenvolvedor', 'CU311', 5, 'dfgdfg', '2023-02-03 22:22:13', '2023-02-11 15:06:51', '1'),
(14, 'Desenvolvedor', 'CF428', 1, 'dfgd', '2023-02-03 22:22:16', NULL, NULL),
(15, 'Desenvolvedor', 'CF428', 1, 'dfg', '2023-02-03 22:22:18', NULL, NULL),
(16, 'Desenvolvedor', 'CF428', 1, 'dfg', '2023-02-03 22:22:19', NULL, NULL),
(17, 'Desenvolvedor', 'CF428', 1, 'fghjgh', '2023-02-03 22:22:21', NULL, NULL),
(18, 'Desenvolvedor', 'CF428', 3, 'jklkjlyuk', '2023-02-03 22:22:22', NULL, NULL),
(19, 'Desenvolvedor', 'CF428', 5, '34523423', '2023-02-03 22:22:24', '2023-02-11 15:06:47', '1'),
(20, 'Desenvolvedor', 'CF428', 3, 'kukyuk34', '2023-02-03 22:22:27', '2023-02-05 12:58:41', '2'),
(21, 'Administrador', 'CF428', 1, 'fsdfsdfsdf', '2023-02-05 12:58:59', NULL, NULL),
(22, 'Desenvolvedor', 'CF428', 7, 'qweqweqwe', '2023-02-11 15:03:38', '2023-02-11 15:06:41', '1'),
(23, 'Desenvolvedor', 'CF383', 5, 'qwewqeqw', '2023-02-11 15:03:40', '2023-02-11 15:06:37', '1'),
(24, 'Desenvolvedor', 'CF174', 6, 'qewqeqw', '2023-02-11 15:03:47', NULL, NULL),
(25, 'Desenvolvedor', 'CU311', 3, 'qweqweqweqw', '2023-02-11 15:03:50', NULL, NULL),
(26, 'Desenvolvedor', 'CF309', 6, 'qweqwewq', '2023-02-11 15:03:55', NULL, NULL),
(27, 'Desenvolvedor', 'CF428', 4, 'qweqwewqeqweq', '2023-02-11 15:03:58', '2023-02-11 15:06:34', '1'),
(28, 'Desenvolvedor', 'CF338', 6, 'qweqweqweqwewe', '2023-02-11 15:04:02', '2023-02-11 15:06:30', '1'),
(29, 'Desenvolvedor', 'CF428', 6, 'qweqweqwewq', '2023-02-11 15:04:06', '2023-02-11 15:06:27', '1'),
(30, 'Desenvolvedor', 'CF310', 13, 'asasd', '2023-02-11 15:05:27', NULL, NULL),
(31, 'Desenvolvedor', 'CF428', 2, 'Sensor parou', '2023-02-12 18:07:29', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `refuse`
--

CREATE TABLE `refuse` (
  `refuse_id` int NOT NULL,
  `refuse_user_name` varchar(50) NOT NULL,
  `refuse_machine_name` varchar(50) NOT NULL,
  `refuse_code_code` varchar(50) NOT NULL,
  `refuse_value` int NOT NULL,
  `refuse_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `refuse_altertime` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `refuse_alterby` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `refuse`
--

INSERT INTO `refuse` (`refuse_id`, `refuse_user_name`, `refuse_machine_name`, `refuse_code_code`, `refuse_value`, `refuse_datetime`, `refuse_altertime`, `refuse_alterby`) VALUES
(1, 'Desenvolvedor', 'CF309', '200001', 1, '2023-02-03 22:20:25', '2023-02-11 15:04:31', 'Desenvolvedor'),
(2, 'Desenvolvedor', 'CF309', '200001', 1, '2023-02-03 22:20:26', NULL, NULL),
(3, 'Desenvolvedor', 'CF309', '200001', 1, '2023-02-03 22:20:29', NULL, NULL),
(4, 'Desenvolvedor', 'CF309', '200001', 1, '2023-02-03 22:20:30', NULL, NULL),
(5, 'Desenvolvedor', 'CF309', '200001', 1, '2023-02-03 22:20:31', NULL, NULL),
(6, 'Desenvolvedor', 'CF309', '200001', 1, '2023-02-03 22:20:31', NULL, NULL),
(7, 'Desenvolvedor', 'CF309', '200001', 1, '2023-02-03 22:20:32', NULL, NULL),
(8, 'Desenvolvedor', 'CF309', '200001', 1, '2023-02-03 22:20:32', NULL, NULL),
(9, 'Desenvolvedor', 'CF309', '200001', 1, '2023-02-03 22:20:33', NULL, NULL),
(10, 'Desenvolvedor', 'CF309', '200001', 1, '2023-02-03 22:20:34', NULL, NULL),
(11, 'Desenvolvedor', 'CF309', '200001', 1, '2023-02-03 22:20:35', NULL, NULL),
(12, 'Desenvolvedor', 'CF383', '200006', 1, '2023-02-03 22:20:38', '2023-02-11 15:05:59', 'Desenvolvedor'),
(13, 'Desenvolvedor', 'CF309', '200019', 1, '2023-02-03 22:20:41', '2023-02-11 15:06:07', 'Desenvolvedor'),
(14, 'Desenvolvedor', 'CF310', '200005', 1, '2023-02-03 22:21:17', '2023-02-11 15:06:14', 'Desenvolvedor'),
(15, 'Desenvolvedor', 'CF310', '200025', 1, '2023-02-03 22:21:20', '2023-02-11 15:06:21', 'Desenvolvedor'),
(16, 'Desenvolvedor', 'CF310', '200006', 2, '2023-02-03 22:21:22', NULL, NULL),
(17, 'Desenvolvedor', 'CF310', '200007', 2, '2023-02-03 22:21:23', NULL, NULL),
(18, 'Desenvolvedor', 'CF310', '200004', 2, '2023-02-03 22:21:25', NULL, NULL),
(19, 'Desenvolvedor', 'CF310', '200003', 1, '2023-02-03 22:21:26', '2023-02-11 15:05:09', 'Desenvolvedor'),
(20, 'Desenvolvedor', 'CF310', '200004', 1, '2023-02-03 22:21:27', NULL, NULL),
(21, 'Desenvolvedor', 'CF383', '200023', 1, '2023-02-03 22:21:31', NULL, NULL),
(22, 'Desenvolvedor', 'CF383', '100031', 1, '2023-02-03 22:21:35', NULL, NULL),
(23, 'Desenvolvedor', 'CF383', '100043', 1, '2023-02-03 22:21:38', NULL, NULL),
(24, 'Desenvolvedor', 'CF383', '100045', 1, '2023-02-03 22:21:42', NULL, NULL),
(25, 'Desenvolvedor', 'CF383', '100045', 1, '2023-02-03 22:21:48', NULL, NULL),
(26, 'Desenvolvedor', 'CF428', '200011', 2, '2023-02-03 22:25:40', '2023-02-11 15:04:21', 'Desenvolvedor'),
(27, 'Administrador', 'CF310', '200002', 1, '2023-02-05 12:58:52', '2023-02-11 15:05:46', 'Desenvolvedor'),
(28, 'Desenvolvedor', 'CF428', '200003', 1, '2023-02-12 18:07:10', NULL, NULL),
(29, 'Desenvolvedor', 'CF428', '200023', 2, '2023-02-12 18:07:16', NULL, NULL),
(30, 'Desenvolvedor', 'CF428', '200001', 1, '2023-02-20 08:40:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_login` varchar(50) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `user_level` varchar(10) NOT NULL,
  `user_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_login`, `user_pass`, `user_level`, `user_token`) VALUES
(1, 'Desenvolvedor', 'master000', '7c222fb2927d828af22f592134e8932480637c0d', 'admin', 'adb84d71e532f0ad0006d2e31f2981f8f4b7e6a4'),
(2, 'Administrador', 'master001', '7c222fb2927d828af22f592134e8932480637c0d', 'admin', '6848fd89f5ee72ec49a6825629ce3d4bc52db69c'),
(3, '704070', '704070', '9cb948343154b143d025db2c5876268311257057', 'user', ''),
(4, 'Gaiolas Valeo 1', 'gaiolasvoleo1', '96c2c085110e085713fa2d4b7ee29571381eecf6', 'user', '9c9c970d863f3f4751b262e942588ebb5e3cb154'),
(5, 'Gaiolas Valeo 2', 'gaiolasvoleo2', '6666a95c81320c5b9efe9a781e334dd26745bea4', 'user', ''),
(6, 'Proturbo', 'proturbo', '8b573bd6e510fc123a1ccd606c0c22504a25469c', 'admin', NULL);

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
-- Índices para tabela `gp`
--
ALTER TABLE `gp`
  ADD PRIMARY KEY (`gp_id`);

--
-- Índices para tabela `gr`
--
ALTER TABLE `gr`
  ADD PRIMARY KEY (`gr_id`);

--
-- Índices para tabela `machines`
--
ALTER TABLE `machines`
  ADD PRIMARY KEY (`machine_id`),
  ADD UNIQUE KEY `machine_name` (`machine_name`);

--
-- Índices para tabela `prod`
--
ALTER TABLE `prod`
  ADD PRIMARY KEY (`prod_id`),
  ADD KEY `prod_machine_name` (`prod_machine_name`);

--
-- Índices para tabela `refuse`
--
ALTER TABLE `refuse`
  ADD PRIMARY KEY (`refuse_id`),
  ADD KEY `refuse_user_name` (`refuse_user_name`),
  ADD KEY `refuse_machine_name` (`refuse_machine_name`),
  ADD KEY `refuse_code_code` (`refuse_code_code`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_login` (`user_login`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `codes`
--
ALTER TABLE `codes`
  MODIFY `code_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT de tabela `gp`
--
ALTER TABLE `gp`
  MODIFY `gp_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de tabela `gr`
--
ALTER TABLE `gr`
  MODIFY `gr_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `machines`
--
ALTER TABLE `machines`
  MODIFY `machine_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `prod`
--
ALTER TABLE `prod`
  MODIFY `prod_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de tabela `refuse`
--
ALTER TABLE `refuse`
  MODIFY `refuse_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `prod`
--
ALTER TABLE `prod`
  ADD CONSTRAINT `prod_ibfk_1` FOREIGN KEY (`prod_machine_name`) REFERENCES `machines` (`machine_name`);

--
-- Limitadores para a tabela `refuse`
--
ALTER TABLE `refuse`
  ADD CONSTRAINT `refuse_ibfk_1` FOREIGN KEY (`refuse_user_name`) REFERENCES `users` (`user_name`),
  ADD CONSTRAINT `refuse_ibfk_2` FOREIGN KEY (`refuse_machine_name`) REFERENCES `machines` (`machine_name`),
  ADD CONSTRAINT `refuse_ibfk_3` FOREIGN KEY (`refuse_code_code`) REFERENCES `codes` (`code_code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
