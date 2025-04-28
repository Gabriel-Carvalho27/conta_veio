-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2025 at 07:39 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `conta_veio`
--

-- --------------------------------------------------------

--
-- Table structure for table `chamadas`
--

CREATE TABLE `chamadas` (
  `id` int(11) NOT NULL,
  `idoso_id` int(11) DEFAULT NULL,
  `data_chamada` date DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `hora_chamada` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chamadas`
--

INSERT INTO `chamadas` (`id`, `idoso_id`, `data_chamada`, `status`, `hora_chamada`) VALUES
(64, 5, '2025-04-11', 'Presente', NULL),
(65, 5, '2025-04-11', 'Presente', NULL),
(66, 3, '2025-04-11', 'Presente', NULL),
(67, 5, '2025-04-10', 'Presente', '22:24:44'),
(68, 1, '2025-04-11', 'Ausente', NULL),
(69, 2, '2025-04-10', 'Presente', '22:28:03'),
(70, 6, '2025-04-10', 'Presente', '22:43:57'),
(71, 7, '2025-04-10', 'Presente', '23:20:43');

-- --------------------------------------------------------

--
-- Table structure for table `idosos`
--

CREATE TABLE `idosos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `idade` int(11) DEFAULT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `observacoes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `idosos`
--

INSERT INTO `idosos` (`id`, `nome`, `idade`, `cpf`, `telefone`, `endereco`, `observacoes`) VALUES
(1, 'mario', 78, '061.692.031-23', '66996036117', 'R: Varzea grande Vila Isabel', 'hipertenso'),
(2, 'maria', 98, '061.692.238-84', '66 996125845', 'R: Varzea grande Vila Isabel', 'cadeirante'),
(3, 'rodrigo', 105, '548545555', '0632263106', 'asdqwd', 'asfldas´podf'),
(4, 'Gabriel Carvalho', 402, '061.692.238-84', '66996036117', 'R: Varzea grande Vila Isabel', ''),
(5, 'Antonio Carlos', 456, '061.692.238-84', '66996036117', 'Vila Isabel', ''),
(6, 'julia', 85, '061.65551515', '6699494', 'Vila Isabel', ''),
(7, 'Roberto', 75, '061.256.238-84', '66996036117', 'R: Varzea grande Vila Isabel', '');

-- --------------------------------------------------------

--
-- Table structure for table `responsaveis`
--

CREATE TABLE `responsaveis` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `responsaveis`
--

INSERT INTO `responsaveis` (`id`, `nome`, `email`, `senha`, `telefone`) VALUES
(1, 'Gabriel', 'admiin@gmail.com.br', '123', '66996036117');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chamadas`
--
ALTER TABLE `chamadas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idoso_id` (`idoso_id`);

--
-- Indexes for table `idosos`
--
ALTER TABLE `idosos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `responsaveis`
--
ALTER TABLE `responsaveis`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chamadas`
--
ALTER TABLE `chamadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `idosos`
--
ALTER TABLE `idosos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `responsaveis`
--
ALTER TABLE `responsaveis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chamadas`
--
ALTER TABLE `chamadas`
  ADD CONSTRAINT `chamadas_ibfk_1` FOREIGN KEY (`idoso_id`) REFERENCES `idosos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
