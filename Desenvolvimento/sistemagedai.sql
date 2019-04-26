-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 27-Abr-2019 às 00:55
-- Versão do servidor: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistemagedai`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `artigo`
--

CREATE TABLE `artigo` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `titulo` varchar(60) NOT NULL,
  `objetivo` varchar(280) NOT NULL,
  `conteudo` text NOT NULL,
  `views` bigint(20) NOT NULL,
  `ativo` tinyint(1) NOT NULL,
  `autor` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentario`
--

CREATE TABLE `comentario` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_artigo` int(11) NOT NULL,
  `texto` text NOT NULL,
  `data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `evento`
--

CREATE TABLE `evento` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `local` text NOT NULL,
  `status` enum('Finalizado','Adiado','Marcado','') NOT NULL,
  `informacoes` text NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `galeria_eventos`
--

CREATE TABLE `galeria_eventos` (
  `id` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `ext` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `img_artigo`
--

CREATE TABLE `img_artigo` (
  `id` int(11) NOT NULL,
  `id_artigo` int(11) NOT NULL,
  `ext` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `seguir_evento`
--

CREATE TABLE `seguir_evento` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `senha` varchar(65) NOT NULL,
  `tipo` enum('administrador','moderador','normal','') NOT NULL,
  `ativo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `tipo`, `ativo`) VALUES
(10, 'Administrador', 'administrador@adm.com', 'admingedai', 'administrador', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artigo`
--
ALTER TABLE `artigo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_artigo` (`id_artigo`);

--
-- Indexes for table `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galeria_eventos`
--
ALTER TABLE `galeria_eventos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_evento` (`id_evento`);

--
-- Indexes for table `img_artigo`
--
ALTER TABLE `img_artigo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_artigo` (`id_artigo`);

--
-- Indexes for table `seguir_evento`
--
ALTER TABLE `seguir_evento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_evento` (`id_evento`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artigo`
--
ALTER TABLE `artigo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `comentario`
--
ALTER TABLE `comentario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `evento`
--
ALTER TABLE `evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `galeria_eventos`
--
ALTER TABLE `galeria_eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `img_artigo`
--
ALTER TABLE `img_artigo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seguir_evento`
--
ALTER TABLE `seguir_evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `artigo`
--
ALTER TABLE `artigo`
  ADD CONSTRAINT `artigo_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `comentario_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comentario_ibfk_2` FOREIGN KEY (`id_artigo`) REFERENCES `artigo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `galeria_eventos`
--
ALTER TABLE `galeria_eventos`
  ADD CONSTRAINT `galeria_eventos_ibfk_1` FOREIGN KEY (`id_evento`) REFERENCES `evento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `img_artigo`
--
ALTER TABLE `img_artigo`
  ADD CONSTRAINT `img_artigo_ibfk_1` FOREIGN KEY (`id_artigo`) REFERENCES `artigo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `seguir_evento`
--
ALTER TABLE `seguir_evento`
  ADD CONSTRAINT `seguir_evento_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `seguir_evento_ibfk_2` FOREIGN KEY (`id_evento`) REFERENCES `evento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
