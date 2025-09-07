-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06-Set-2025 às 15:27
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ecoride`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `admins`
--

INSERT INTO `admins` (`id`, `nome`, `email`, `senha`) VALUES
(1, '', '', ''),
(2, 'Joelson Rita', 'Joelsonrita6@gamil.com', 'Joelson123'),
(3, 'Teste antes do demplo', 'JoelsecSSZSedonrita6@gamil.com', 'JoelsoSZn123'),
(4, 'Teste antes do dsssemplo', 'JoelsecSSZSedonritass6@gamil.com', 'JoelsoSZn123s'),
(5, 'Teste antes dco dsssemplo', 'JoelfsecSSZSedonritass6@gamil.com', 'sxdxeccec');

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacoes`
--

CREATE TABLE `avaliacoes` (
  `id` int(11) NOT NULL,
  `viagem_id` int(11) DEFAULT NULL,
  `passageiro_id` int(11) DEFAULT NULL,
  `nota` int(11) DEFAULT NULL CHECK (`nota` between 1 and 5),
  `comentario` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pendente',
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `avaliacoes`
--

INSERT INTO `avaliacoes` (`id`, `viagem_id`, `passageiro_id`, `nota`, `comentario`, `status`, `criado_em`) VALUES
(1, 1, 2, 4, 'scdcce', 'aprovada', '2025-05-16 13:33:50'),
(2, 0, 0, 4, 'dce', 'aprovada', '2025-05-16 13:34:54'),
(3, 0, 0, 4, 'dce', 'aprovada', '2025-05-16 13:35:32'),
(4, 1, 2, 1, 'lh!lll', 'aprovada', '2025-05-22 16:27:15'),
(5, 1, 2, 4, 'xzdfzfzefre', 'aprovada', '2025-05-22 17:17:00'),
(6, 10, 3, 5, 'Trés bonne voyage', 'pendente', '2025-07-03 10:56:27');

-- --------------------------------------------------------

--
-- Estrutura da tabela `confirmacoes_viagem`
--

CREATE TABLE `confirmacoes_viagem` (
  `id` int(11) NOT NULL,
  `viagem_id` int(11) DEFAULT NULL,
  `passageiro_id` int(11) DEFAULT NULL,
  `confirmacao` enum('ok','problema') DEFAULT NULL,
  `comentario` text DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `confirmacoes_viagem`
--

INSERT INTO `confirmacoes_viagem` (`id`, `viagem_id`, `passageiro_id`, `confirmacao`, `comentario`, `criado_em`) VALUES
(1, NULL, NULL, 'ok', '', '2025-05-16 13:34:50'),
(2, NULL, NULL, 'ok', 'vyujfdktu', '2025-05-21 18:18:37'),
(3, NULL, NULL, 'problema', 'vyujfdktu', '2025-05-21 18:18:42'),
(4, NULL, NULL, '', 'vyujfdktu', '2025-05-21 18:37:00'),
(5, NULL, NULL, 'ok', '', '2025-05-21 18:37:03'),
(6, NULL, NULL, '', 'e', '2025-05-21 18:39:49'),
(7, NULL, NULL, '', 'Motorista estava bebado', '2025-05-21 22:00:14'),
(8, NULL, NULL, '', 'Motorista estava bebadodeeede', '2025-05-21 22:09:03'),
(9, NULL, NULL, 'ok', '', '2025-05-21 22:11:07'),
(10, NULL, NULL, '', 'Motorista estava bebadodeeede', '2025-05-21 22:12:42'),
(11, NULL, NULL, '', 'Motorista estava bebadodeeede', '2025-05-21 22:18:56'),
(12, NULL, NULL, 'ok', '', '2025-05-21 22:18:58');

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id`, `nome`, `email`, `senha`) VALUES
(1, 'Joelson Rita', 'Joelsonrita6@gamil.com', 'Joelson123');

-- --------------------------------------------------------

--
-- Estrutura da tabela `participacoes`
--

CREATE TABLE `participacoes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `viagem_id` int(11) DEFAULT NULL,
  `data_participacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `participacoes`
--

INSERT INTO `participacoes` (`id`, `usuario_id`, `viagem_id`, `data_participacao`) VALUES
(5, 5, 10, '2025-07-02 18:32:39'),
(6, 5, 8, '2025-07-08 09:59:55');

-- --------------------------------------------------------

--
-- Estrutura da tabela `problemas`
--

CREATE TABLE `problemas` (
  `id` int(11) NOT NULL,
  `viagem_id` int(11) NOT NULL,
  `passageiro_id` int(11) NOT NULL,
  `comentario` text NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `creditos` int(11) DEFAULT 20,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `foto` varchar(255) DEFAULT 'default.jpg',
  `ativo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `pseudo`, `email`, `senha`, `creditos`, `criado_em`, `foto`, `ativo`) VALUES
(1, 'Dias Otilia', 'Joelsoee@gmail.com', '$2y$10$MNN5Sxz.IhYS1iydPerIPOowcd30j6yIGrrXS1phnL.bLwHtfSOjq', 20, '2025-05-13 16:35:35', 'uploads/foto_682f2996c6598.jpg', 1),
(2, 'xcececec TERERE', 'Joelseceonrita6@gamil.com', '$2y$10$.l1wBUebhEaNzfvmMwskp.luYuXPHGnVDrZudv4CSlNYVREPVlrfy', 0, '2025-05-19 10:56:57', 'default.jpg', 1),
(3, 'Teste Final', 'Testefina@gmail.com', '$2y$10$PcXXY.JCGJLR/0FgF.gnse51M9Uu0.Mh78kRllOdTfnTMYFbiVjFK', 44, '2025-05-22 15:55:35', 'uploads/foto_68654fc40d426.png', 1),
(4, 'Teste deploy', 'Joelsececedonrita6@gamil.com', '$2y$10$rUT0agZqEKPSoOXnpkw1BO.eslALHk3j6wsGPi6t9AC0VUEKMprcG', 34, '2025-07-02 16:26:36', 'uploads/foto_68655e92a002e.jpg', 1),
(5, 'Joelsno sfefe', 'Joelsecedonrita6@gamil.com', '$2y$10$sDehSjiWQfV402e8cF6DVuvAUuU803zohLT/AZnaTE2e30szf7436', 4, '2025-07-02 16:31:02', 'uploads/foto_6866550491d8b.webp', 1),
(6, 'Otilia Dias', 'Otiliamadalenadias@gma.com', '$2y$10$ZDqHtnVjb8P.851PYDytQuTpiF7jkv4eePGi5..T4kEHuFeRSc03e', 20, '2025-07-03 10:50:58', 'default.jpg', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `veiculos`
--

CREATE TABLE `veiculos` (
  `id` int(11) NOT NULL,
  `motorista_id` int(11) DEFAULT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `cor` varchar(50) DEFAULT NULL,
  `placa` varchar(20) DEFAULT NULL,
  `data_primeira_immatriculation` date DEFAULT NULL,
  `preferencias` text DEFAULT NULL,
  `tipo_energia` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `veiculos`
--

INSERT INTO `veiculos` (`id`, `motorista_id`, `marca`, `modelo`, `cor`, `placa`, `data_primeira_immatriculation`, `preferencias`, `tipo_energia`) VALUES
(1, 1, 'Citroën', 'c3', 'Noir', '1312332544', '0000-00-00', NULL, NULL),
(6, 1, 'Volkswagen', 'FHGGH', 'Rouge', '11432435352352', '0000-00-00', 'FBFDBBF', 'Électrique'),
(7, 1, 'DDDF', 'FDFDFD', 'Noir', '21423234', '0000-00-00', 'DVDVDSVSDVDFVF', 'Essence'),
(8, 1, '', '', '', '', '0000-00-00', '', ''),
(9, 3, 'Citroën', 'c4', 'Noir', '123333', '0000-00-00', 'dccrtr', 'Électrique'),
(10, 3, 'svfs', 'vf', 'vfsvfv', 'vfvdfv', '0000-00-00', 'fvsvdvssvdvsdv', 'Essence'),
(11, 4, 'Mercedes', 'cccc', 'Blanc', '119716893131', '0000-00-00', 'Nao goste de quem fuma', 'Hybride'),
(12, 5, ',yuu', 'uy', 'u,', 'jyjyjyu,u', '0000-00-00', ',uyr,u', 'Électrique');

-- --------------------------------------------------------

--
-- Estrutura da tabela `viagens`
--

CREATE TABLE `viagens` (
  `id` int(11) NOT NULL,
  `motorista_id` int(11) DEFAULT NULL,
  `partida` varchar(255) DEFAULT NULL,
  `chegada` varchar(255) DEFAULT NULL,
  `preco` int(11) DEFAULT NULL,
  `lugares_disponiveis` int(11) DEFAULT NULL,
  `data_partida` datetime DEFAULT NULL,
  `veiculo_id` int(11) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pendente','em_andamento','concluida') DEFAULT 'pendente',
  `finalizada_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `viagens`
--

INSERT INTO `viagens` (`id`, `motorista_id`, `partida`, `chegada`, `preco`, `lugares_disponiveis`, `data_partida`, `veiculo_id`, `criado_em`, `status`, `finalizada_em`) VALUES
(1, 1, 'Portugal', 'France', 20, 2, '2025-02-12 17:50:00', 1, '2025-05-14 11:26:23', '', NULL),
(5, 2, 'FVFSVS', 'FVSFV', 22, 2, '2025-05-13 12:12:00', 2, '2025-05-19 14:45:28', 'pendente', NULL),
(6, 2, 'FVFSVS', 'FVSFV', 22, 2, '2025-05-13 12:12:00', 2, '2025-05-19 14:45:44', 'pendente', NULL),
(8, 1, 'Europa', 'Lisboa', 15, 1, '2025-12-12 12:02:00', 1, '2025-05-21 21:45:17', '', NULL),
(9, 1, 'DSVSDVVF', 'FVFDVF', 6, 2, '2025-01-12 16:07:00', 1, '2025-05-22 13:38:46', 'pendente', NULL),
(10, 3, '  fv rfg gvgvf', 'fvdsfvfvfvf', 1, 1, '2000-12-12 12:12:00', 9, '2025-05-22 17:06:29', '', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `confirmacoes_viagem`
--
ALTER TABLE `confirmacoes_viagem`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `participacoes`
--
ALTER TABLE `participacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `viagem_id` (`viagem_id`);

--
-- Índices para tabela `problemas`
--
ALTER TABLE `problemas`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `veiculos`
--
ALTER TABLE `veiculos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `motorista_id` (`motorista_id`);

--
-- Índices para tabela `viagens`
--
ALTER TABLE `viagens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `motorista_id` (`motorista_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `confirmacoes_viagem`
--
ALTER TABLE `confirmacoes_viagem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `participacoes`
--
ALTER TABLE `participacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `problemas`
--
ALTER TABLE `problemas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `veiculos`
--
ALTER TABLE `veiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `viagens`
--
ALTER TABLE `viagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `participacoes`
--
ALTER TABLE `participacoes`
  ADD CONSTRAINT `participacoes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `participacoes_ibfk_2` FOREIGN KEY (`viagem_id`) REFERENCES `viagens` (`id`);

--
-- Limitadores para a tabela `veiculos`
--
ALTER TABLE `veiculos`
  ADD CONSTRAINT `veiculos_ibfk_1` FOREIGN KEY (`motorista_id`) REFERENCES `usuarios` (`id`);

--
-- Limitadores para a tabela `viagens`
--
ALTER TABLE `viagens`
  ADD CONSTRAINT `viagens_ibfk_1` FOREIGN KEY (`motorista_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
