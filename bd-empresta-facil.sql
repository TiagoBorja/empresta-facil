-- --------------------------------------------------------
-- Anfitrião:                    127.0.0.1
-- Versão do servidor:           10.4.28-MariaDB - mariadb.org binary distribution
-- SO do servidor:               Win64
-- HeidiSQL Versão:              12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- A despejar estrutura da base de dados para empresta_facil
DROP DATABASE IF EXISTS `empresta_facil`;
CREATE DATABASE IF NOT EXISTS `empresta_facil` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `empresta_facil`;

-- A despejar estrutura para tabela empresta_facil.autor
DROP TABLE IF EXISTS `autor`;
CREATE TABLE IF NOT EXISTS `autor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `primeiro_nome` varchar(100) NOT NULL,
  `ultimo_nome` varchar(100) NOT NULL,
  `data_nascimento` date NOT NULL,
  `genero` char(1) NOT NULL,
  `biografia` text NOT NULL,
  `nacionalidade` varchar(100) NOT NULL,
  `img_url` varchar(255) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NULL DEFAULT NULL,
  `ativo` char(1) NOT NULL DEFAULT 'Y',
  `criado_fk` int(11) DEFAULT NULL,
  `atualizado_fk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_criado_fk` (`criado_fk`),
  KEY `fk_atualizado_fk` (`atualizado_fk`),
  CONSTRAINT `fk_atualizado_fk` FOREIGN KEY (`atualizado_fk`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `fk_criado_fk` FOREIGN KEY (`criado_fk`) REFERENCES `utilizador` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.autor: ~3 rows (aproximadamente)
DELETE FROM `autor`;
INSERT INTO `autor` (`id`, `primeiro_nome`, `ultimo_nome`, `data_nascimento`, `genero`, `biografia`, `nacionalidade`, `img_url`, `criado_em`, `atualizado_em`, `ativo`, `criado_fk`, `atualizado_fk`) VALUES
	(1, 'Fernando', 'Pessoa', '2025-05-26', 'M', 'a', 'Espanhol', NULL, '2025-05-26 16:32:56', NULL, 'Y', NULL, NULL),
	(2, 'José', 'Saramago', '1947-01-01', 'M', 'adasdsD', 'Português', 'upload/6834a24fc8f62_WhatsApp Image 2025-03-10 at 9.26.52 PM.jpeg', '2025-05-26 17:18:07', NULL, 'Y', NULL, NULL),
	(3, 'Tiago', 'Borja', '2025-05-01', 'M', 'sdadadssadsadsad', 'Brasileiro', NULL, '2025-05-30 11:40:58', NULL, 'Y', NULL, NULL);

-- A despejar estrutura para tabela empresta_facil.autor_livro
DROP TABLE IF EXISTS `autor_livro`;
CREATE TABLE IF NOT EXISTS `autor_livro` (
  `autor_fk` int(11) NOT NULL,
  `livro_fk` int(11) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NULL DEFAULT NULL,
  `criado_fk` int(11) DEFAULT NULL,
  `atualizado_fk` int(11) DEFAULT NULL,
  UNIQUE KEY `autor_recurso_index_0` (`autor_fk`,`livro_fk`) USING BTREE,
  KEY `livro_fk` (`livro_fk`) USING BTREE,
  KEY `FK_autor_livro_utilizador` (`criado_fk`),
  KEY `FK_autor_livro_utilizador_2` (`atualizado_fk`),
  CONSTRAINT `FK_autor_livro_utilizador` FOREIGN KEY (`criado_fk`) REFERENCES `utilizador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_autor_livro_utilizador_2` FOREIGN KEY (`atualizado_fk`) REFERENCES `utilizador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `autor_livro_ibfk_1` FOREIGN KEY (`autor_fk`) REFERENCES `autor` (`id`),
  CONSTRAINT `autor_livro_ibfk_2` FOREIGN KEY (`livro_fk`) REFERENCES `livro` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.autor_livro: ~18 rows (aproximadamente)
DELETE FROM `autor_livro`;
INSERT INTO `autor_livro` (`autor_fk`, `livro_fk`, `criado_em`, `atualizado_em`, `criado_fk`, `atualizado_fk`) VALUES
	(1, 30, '2025-06-12 23:09:29', NULL, NULL, NULL),
	(1, 32, '2025-06-15 13:01:46', NULL, NULL, NULL),
	(1, 33, '2025-06-15 13:01:46', NULL, NULL, NULL),
	(1, 34, '2025-06-27 09:21:35', NULL, NULL, NULL),
	(1, 35, '2025-06-15 13:01:46', NULL, NULL, NULL),
	(1, 36, '2025-06-15 13:01:46', NULL, NULL, NULL),
	(1, 39, '2025-06-15 13:01:46', NULL, NULL, NULL),
	(2, 30, '2025-06-15 13:01:46', NULL, NULL, NULL),
	(2, 31, '2025-06-15 13:01:46', NULL, NULL, NULL),
	(2, 34, '2025-06-27 09:21:35', NULL, NULL, NULL),
	(2, 37, '2025-06-15 13:01:46', NULL, NULL, NULL),
	(2, 40, '2025-06-15 13:01:46', NULL, NULL, NULL),
	(3, 30, '2025-06-12 23:09:29', NULL, NULL, NULL),
	(3, 32, '2025-06-15 13:01:46', NULL, NULL, NULL),
	(3, 34, '2025-06-27 09:21:35', NULL, NULL, NULL),
	(3, 35, '2025-06-15 13:01:46', NULL, NULL, NULL),
	(3, 38, '2025-06-15 13:01:46', NULL, NULL, NULL),
	(3, 41, '2025-06-15 13:01:46', NULL, NULL, NULL);

-- A despejar estrutura para tabela empresta_facil.avaliacoes
DROP TABLE IF EXISTS `avaliacoes`;
CREATE TABLE IF NOT EXISTS `avaliacoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `livro_fk` int(11) DEFAULT NULL,
  `utilizador_fk` int(11) DEFAULT NULL,
  `avaliacao` int(1) DEFAULT NULL COMMENT 'Valores de 0 a 5',
  `criado_em` timestamp NULL DEFAULT NULL,
  `atualizado_em` timestamp NULL DEFAULT NULL,
  `criado_fk` int(11) DEFAULT NULL,
  `atualizado_fk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `utilizador_fk` (`utilizador_fk`),
  KEY `fk_avaliacoes_criado_fk` (`criado_fk`),
  KEY `fk_avaliacoes_atualizado_fk` (`atualizado_fk`),
  KEY `FK_avaliacoes_livro` (`livro_fk`),
  CONSTRAINT `FK_avaliacoes_livro` FOREIGN KEY (`livro_fk`) REFERENCES `livro` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_avaliacoes_utilizador` FOREIGN KEY (`utilizador_fk`) REFERENCES `utilizador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_avaliacoes_atualizado_fk` FOREIGN KEY (`atualizado_fk`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `fk_avaliacoes_criado_fk` FOREIGN KEY (`criado_fk`) REFERENCES `utilizador` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.avaliacoes: ~0 rows (aproximadamente)
DELETE FROM `avaliacoes`;

-- A despejar estrutura para tabela empresta_facil.biblioteca
DROP TABLE IF EXISTS `biblioteca`;
CREATE TABLE IF NOT EXISTS `biblioteca` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `morada` text NOT NULL,
  `cod_postal` varchar(15) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NULL DEFAULT NULL,
  `ativo` char(1) NOT NULL DEFAULT 'Y',
  `criado_fk` int(11) DEFAULT NULL,
  `atualizado_fk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_biblioteca_criado_fk` (`criado_fk`),
  KEY `fk_biblioteca_atualizado_fk` (`atualizado_fk`),
  CONSTRAINT `fk_biblioteca_atualizado_fk` FOREIGN KEY (`atualizado_fk`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `fk_biblioteca_criado_fk` FOREIGN KEY (`criado_fk`) REFERENCES `utilizador` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.biblioteca: ~8 rows (aproximadamente)
DELETE FROM `biblioteca`;
INSERT INTO `biblioteca` (`id`, `nome`, `email`, `morada`, `cod_postal`, `criado_em`, `atualizado_em`, `ativo`, `criado_fk`, `atualizado_fk`) VALUES
	(3, 'Biblioteca Central de Gaia', 'email-exemplo@gmail.com', 'Rua das Letras, 123', '4400-123', '2025-06-15 15:25:12', NULL, 'Y', NULL, NULL),
	(4, 'Biblioteca Escolar António Sérgio', 'email-exemplo@gmail.com', 'Av. das Escolas, 45', '4405-321', '2025-06-15 15:25:12', NULL, 'Y', NULL, NULL),
	(5, 'Biblioteca Municipal do Porto', 'email-exemplo@gmail.com', 'Praça do Saber, 10', '4050-230', '2025-06-15 15:25:12', NULL, 'Y', NULL, NULL),
	(6, 'Biblioteca Santa Marinha', 'email-exemplo@gmail.com', 'Rua da Liberdade, 8', '4430-456', '2025-06-15 15:25:12', NULL, 'Y', NULL, NULL),
	(7, 'Biblioteca Escolar Santa Bárbara', 'email-exemplo@gmail.com', 'Travessa do Estudo, 17', '4410-998', '2025-06-15 15:25:12', NULL, 'Y', NULL, NULL),
	(8, 'Biblioteca Comunitária de Valadares', 'email-exemplo@gmail.com', 'Estrada Nacional 1, 250', '4415-112', '2025-06-15 15:25:12', NULL, 'N', NULL, NULL),
	(9, 'Biblioteca de Mafamude', 'email-exemplo@gmail.com', 'Rua dos Livros, 88', '4400-789', '2025-06-15 15:25:12', NULL, 'Y', NULL, NULL),
	(10, 'Biblioteca de Vilar do Paraíso', 'email-exemplo@gmail.com', 'Rua da Cultura, 33', '4410-220', '2025-06-15 15:25:12', NULL, 'Y', NULL, NULL);

-- A despejar estrutura para tabela empresta_facil.categoria
DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(100) NOT NULL,
  `descricao` varchar(50) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `atualizado_em` timestamp NULL DEFAULT NULL,
  `ativo` char(1) NOT NULL DEFAULT 'Y',
  `criado_fk` int(11) DEFAULT NULL,
  `atualizado_fk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_categoria_criado_fk` (`criado_fk`),
  KEY `fk_categoria_atualizado_fk` (`atualizado_fk`),
  CONSTRAINT `fk_categoria_atualizado_fk` FOREIGN KEY (`atualizado_fk`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `fk_categoria_criado_fk` FOREIGN KEY (`criado_fk`) REFERENCES `utilizador` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.categoria: ~2 rows (aproximadamente)
DELETE FROM `categoria`;
INSERT INTO `categoria` (`id`, `categoria`, `descricao`, `criado_em`, `atualizado_em`, `ativo`, `criado_fk`, `atualizado_fk`) VALUES
	(1, 'Ação', 'Destinado a quem gosta de conteúdos emocionantes ', '2025-05-23 14:16:58', NULL, 'Y', NULL, NULL),
	(3, 'Terror', 'Tema pra quem gosta de se cagar nas calças', '2025-06-09 17:15:12', NULL, 'N', NULL, NULL);

-- A despejar estrutura para tabela empresta_facil.comentarios
DROP TABLE IF EXISTS `comentarios`;
CREATE TABLE IF NOT EXISTS `comentarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `livro_fk` int(11) NOT NULL,
  `utilizador_fk` int(11) NOT NULL,
  `comentario` text NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NULL DEFAULT NULL,
  `criado_fk` int(11) DEFAULT NULL,
  `atualizado_fk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `utilizador_fk` (`utilizador_fk`),
  KEY `fk_comentarios_criado_fk` (`criado_fk`),
  KEY `fk_comentarios_atualizado_fk` (`atualizado_fk`),
  KEY `FK_comentarios_livro` (`livro_fk`),
  CONSTRAINT `FK_comentarios_livro` FOREIGN KEY (`livro_fk`) REFERENCES `livro` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_comentarios_utilizador_2` FOREIGN KEY (`utilizador_fk`) REFERENCES `utilizador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_comentarios_atualizado_fk` FOREIGN KEY (`atualizado_fk`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `fk_comentarios_criado_fk` FOREIGN KEY (`criado_fk`) REFERENCES `utilizador` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.comentarios: ~0 rows (aproximadamente)
DELETE FROM `comentarios`;

-- A despejar estrutura para tabela empresta_facil.editora
DROP TABLE IF EXISTS `editora`;
CREATE TABLE IF NOT EXISTS `editora` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `editora` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL DEFAULT 'Y',
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NULL DEFAULT NULL,
  `criado_fk` int(11) DEFAULT NULL,
  `atualizado_fk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_editora_criado_fk` (`criado_fk`),
  KEY `fk_editora_atualizado_fk` (`atualizado_fk`),
  CONSTRAINT `fk_editora_atualizado_fk` FOREIGN KEY (`atualizado_fk`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `fk_editora_criado_fk` FOREIGN KEY (`criado_fk`) REFERENCES `utilizador` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.editora: ~2 rows (aproximadamente)
DELETE FROM `editora`;
INSERT INTO `editora` (`id`, `editora`, `ativo`, `criado_em`, `atualizado_em`, `criado_fk`, `atualizado_fk`) VALUES
	(1, 'Editora do Porto com pobressssssss', 'Y', '2025-05-26 14:33:58', NULL, NULL, NULL),
	(2, 'Editoras dos Emanueis Gays', 'N', '2025-05-26 15:22:16', NULL, NULL, NULL);

-- A despejar estrutura para tabela empresta_facil.emprestimo
DROP TABLE IF EXISTS `emprestimo`;
CREATE TABLE IF NOT EXISTS `emprestimo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reserva_fk` int(11) DEFAULT NULL,
  `utilizador_fk` int(11) NOT NULL,
  `funcionario_fk` int(11) DEFAULT NULL,
  `criado_em` date NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` date DEFAULT NULL,
  `data_devolucao` date NOT NULL,
  `criado_fk` int(11) DEFAULT NULL,
  `atualizado_fk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `utilizador_fk` (`utilizador_fk`),
  KEY `funcionario_fk` (`funcionario_fk`),
  KEY `reserva_fk` (`reserva_fk`),
  KEY `fk_emprestimo_criado_fk` (`criado_fk`),
  KEY `fk_emprestimo_atualizado_fk` (`atualizado_fk`),
  CONSTRAINT `FK_emprestimo_reserva` FOREIGN KEY (`reserva_fk`) REFERENCES `reserva` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_emprestimo_utilizador` FOREIGN KEY (`utilizador_fk`) REFERENCES `utilizador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `emprestimo_ibfk_3` FOREIGN KEY (`funcionario_fk`) REFERENCES `funcionario` (`id`),
  CONSTRAINT `fk_emprestimo_atualizado_fk` FOREIGN KEY (`atualizado_fk`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `fk_emprestimo_criado_fk` FOREIGN KEY (`criado_fk`) REFERENCES `utilizador` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.emprestimo: ~2 rows (aproximadamente)
DELETE FROM `emprestimo`;
INSERT INTO `emprestimo` (`id`, `reserva_fk`, `utilizador_fk`, `funcionario_fk`, `criado_em`, `atualizado_em`, `data_devolucao`, `criado_fk`, `atualizado_fk`) VALUES
	(32, NULL, 13, 16, '2025-06-25', NULL, '2025-06-25', NULL, NULL),
	(33, NULL, 18, 16, '2025-06-25', NULL, '2025-06-30', NULL, NULL);

-- A despejar estrutura para tabela empresta_facil.emprestimo_livro
DROP TABLE IF EXISTS `emprestimo_livro`;
CREATE TABLE IF NOT EXISTS `emprestimo_livro` (
  `emprestimo_fk` int(11) NOT NULL,
  `livro_localizacao_fk` int(11) NOT NULL,
  `estado_levantou_fk` int(11) NOT NULL,
  `estado_devolucao_fk` int(11) DEFAULT NULL,
  `estado_emprestimo_fk` int(11) NOT NULL DEFAULT 9,
  `data_devolvido` date DEFAULT NULL,
  `criado_fk` int(11) DEFAULT NULL,
  `atualizado_fk` int(11) DEFAULT NULL,
  UNIQUE KEY `emprestimo_livro_index_2` (`emprestimo_fk`,`livro_localizacao_fk`) USING BTREE,
  KEY `estado_levantou_fk` (`estado_levantou_fk`),
  KEY `estado_devolucao_fk` (`estado_devolucao_fk`),
  KEY `emprestimo_fk` (`emprestimo_fk`),
  KEY `recurso_fk` (`livro_localizacao_fk`) USING BTREE,
  KEY `estado_emprestimo` (`estado_emprestimo_fk`) USING BTREE,
  KEY `fk_emprestimo_livro_criado_fk` (`criado_fk`),
  KEY `fk_emprestimo_livro_atualizado_fk` (`atualizado_fk`),
  CONSTRAINT `FK_emprestimo_livro_emprestimo` FOREIGN KEY (`emprestimo_fk`) REFERENCES `emprestimo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_emprestimo_livro_estado` FOREIGN KEY (`estado_levantou_fk`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_emprestimo_livro_estado_2` FOREIGN KEY (`estado_devolucao_fk`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_emprestimo_livro_estado_3` FOREIGN KEY (`estado_emprestimo_fk`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_emprestimo_livro_livro_localizacao` FOREIGN KEY (`livro_localizacao_fk`) REFERENCES `livro_localizacao` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_emprestimo_livro_atualizado_fk` FOREIGN KEY (`atualizado_fk`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `fk_emprestimo_livro_criado_fk` FOREIGN KEY (`criado_fk`) REFERENCES `utilizador` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.emprestimo_livro: ~4 rows (aproximadamente)
DELETE FROM `emprestimo_livro`;
INSERT INTO `emprestimo_livro` (`emprestimo_fk`, `livro_localizacao_fk`, `estado_levantou_fk`, `estado_devolucao_fk`, `estado_emprestimo_fk`, `data_devolvido`, `criado_fk`, `atualizado_fk`) VALUES
	(32, 1, 8, 8, 11, '2025-06-26', NULL, NULL),
	(32, 4, 8, 4, 10, '2025-06-25', NULL, NULL),
	(32, 5, 8, 8, 10, '2025-06-24', NULL, NULL),
	(33, 19, 8, 8, 11, '2025-07-01', NULL, NULL);

-- A despejar estrutura para tabela empresta_facil.estado
DROP TABLE IF EXISTS `estado`;
CREATE TABLE IF NOT EXISTS `estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(50) NOT NULL,
  `observacoes` text DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NULL DEFAULT NULL,
  `criado_fk` int(11) DEFAULT NULL,
  `atualizado_fk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_estado_criado_fk` (`criado_fk`),
  KEY `fk_estado_atualizado_fk` (`atualizado_fk`),
  CONSTRAINT `fk_estado_atualizado_fk` FOREIGN KEY (`atualizado_fk`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `fk_estado_criado_fk` FOREIGN KEY (`criado_fk`) REFERENCES `utilizador` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.estado: ~16 rows (aproximadamente)
DELETE FROM `estado`;
INSERT INTO `estado` (`id`, `estado`, `observacoes`, `criado_em`, `atualizado_em`, `criado_fk`, `atualizado_fk`) VALUES
	(1, 'Pendente', ':observation 22', '2025-04-27 17:54:51', NULL, NULL, NULL),
	(2, 'Em andamento', 'aaaa sd', '2025-04-27 17:58:50', NULL, NULL, NULL),
	(3, 'sssssss sds', 'aaaa', '2025-05-04 21:37:19', NULL, NULL, NULL),
	(4, 'DISPONÍVEL', 'LIVRO', '2025-06-22 13:47:45', NULL, NULL, NULL),
	(5, 'EMPRESTADO', 'LIVRO', '2025-06-22 13:47:45', NULL, NULL, NULL),
	(6, 'RESERVADO', 'LIVRO', '2025-06-22 13:47:45', NULL, NULL, NULL),
	(7, 'PERDIDO', 'LIVRO', '2025-06-22 13:47:45', NULL, NULL, NULL),
	(8, 'DANIFICADO', 'LIVRO', '2025-06-22 13:47:45', NULL, NULL, NULL),
	(9, 'EM ANDAMENTO', 'EMPRÉSTIMO', '2025-06-22 13:47:45', NULL, NULL, NULL),
	(10, 'CONCLUIDO', 'EMPRÉSTIMO', '2025-06-22 13:47:45', NULL, NULL, NULL),
	(11, 'ATRASADO', 'EMPRÉSTIMO', '2025-06-22 13:47:45', NULL, NULL, NULL),
	(12, 'CANCELADO', 'EMPRÉSTIMO', '2025-06-22 13:47:45', NULL, NULL, NULL),
	(13, 'PENDENTE', 'RESERVA', '2025-06-22 13:47:45', NULL, NULL, NULL),
	(14, 'ATENDIDA', 'RESERVA', '2025-06-22 13:47:45', NULL, NULL, NULL),
	(15, 'EXPIRADA', 'RESERVA', '2025-06-22 13:47:45', NULL, NULL, NULL),
	(16, 'CANCELADA', 'RESERVA', '2025-06-22 13:47:45', NULL, NULL, NULL);

-- A despejar estrutura para tabela empresta_facil.foto_recurso
DROP TABLE IF EXISTS `foto_recurso`;
CREATE TABLE IF NOT EXISTS `foto_recurso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_recurso` int(11) DEFAULT NULL,
  `tipo_imagem` varchar(50) DEFAULT NULL,
  `foto_url` varchar(500) DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT NULL,
  `atualizado_em` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_recurso` (`id_recurso`),
  CONSTRAINT `foto_recurso_ibfk_1` FOREIGN KEY (`id_recurso`) REFERENCES `livro` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.foto_recurso: ~0 rows (aproximadamente)
DELETE FROM `foto_recurso`;

-- A despejar estrutura para tabela empresta_facil.funcionario
DROP TABLE IF EXISTS `funcionario`;
CREATE TABLE IF NOT EXISTS `funcionario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `utilizador_fk` int(11) NOT NULL,
  `biblioteca_fk` int(11) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NULL DEFAULT NULL,
  `ativo` varchar(1) NOT NULL DEFAULT 'Y',
  `criado_fk` int(11) DEFAULT NULL,
  `atualizado_fk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `utilizador_fk` (`utilizador_fk`),
  KEY `biblioteca_fk` (`biblioteca_fk`),
  KEY `fk_funcionario_criado_fk` (`criado_fk`),
  KEY `fk_funcionario_atualizado_fk` (`atualizado_fk`),
  CONSTRAINT `FK_funcionario_utilizador` FOREIGN KEY (`utilizador_fk`) REFERENCES `utilizador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_funcionario_atualizado_fk` FOREIGN KEY (`atualizado_fk`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `fk_funcionario_criado_fk` FOREIGN KEY (`criado_fk`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `funcionario_ibfk_2` FOREIGN KEY (`biblioteca_fk`) REFERENCES `biblioteca` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.funcionario: ~4 rows (aproximadamente)
DELETE FROM `funcionario`;
INSERT INTO `funcionario` (`id`, `utilizador_fk`, `biblioteca_fk`, `criado_em`, `atualizado_em`, `ativo`, `criado_fk`, `atualizado_fk`) VALUES
	(12, 12, NULL, '2025-06-16 22:56:49', NULL, 'Y', NULL, NULL),
	(13, 19, NULL, '2025-06-16 22:57:11', NULL, 'Y', NULL, NULL),
	(15, 9, 5, '2025-06-16 23:31:32', NULL, 'Y', NULL, NULL),
	(16, 10, 5, '2025-06-22 15:20:11', NULL, 'Y', NULL, NULL);

-- A despejar estrutura para tabela empresta_facil.livro
DROP TABLE IF EXISTS `livro`;
CREATE TABLE IF NOT EXISTS `livro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `isbn` varchar(13) NOT NULL COMMENT 'Formato padrão do ISBN',
  `ano_lancamento` year(4) NOT NULL,
  `sinopse` text NOT NULL,
  `idioma` varchar(50) NOT NULL,
  `editora_fk` int(11) NOT NULL,
  `categoria_fk` int(11) NOT NULL,
  `subcategoria_fk` int(11) NOT NULL,
  `img_url` varchar(255) DEFAULT NULL,
  `criado_fk` int(11) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_fk` int(11) DEFAULT NULL,
  `atualizado_em` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `ativo` char(1) NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`),
  UNIQUE KEY `isbn` (`isbn`),
  KEY `editora_fk` (`editora_fk`),
  KEY `categoria_fk` (`categoria_fk`),
  KEY `subcategoria_fk` (`subcategoria_fk`),
  KEY `criado_fk` (`criado_fk`),
  KEY `atualizado_fk` (`atualizado_fk`),
  CONSTRAINT `FK_livro_utilizador` FOREIGN KEY (`criado_fk`) REFERENCES `utilizador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_livro_utilizador_2` FOREIGN KEY (`atualizado_fk`) REFERENCES `utilizador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `livro_ibfk_2` FOREIGN KEY (`editora_fk`) REFERENCES `editora` (`id`),
  CONSTRAINT `livro_ibfk_3` FOREIGN KEY (`categoria_fk`) REFERENCES `categoria` (`id`),
  CONSTRAINT `livro_ibfk_4` FOREIGN KEY (`subcategoria_fk`) REFERENCES `subcategoria` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.livro: ~12 rows (aproximadamente)
DELETE FROM `livro`;
INSERT INTO `livro` (`id`, `titulo`, `isbn`, `ano_lancamento`, `sinopse`, `idioma`, `editora_fk`, `categoria_fk`, `subcategoria_fk`, `img_url`, `criado_fk`, `criado_em`, `atualizado_fk`, `atualizado_em`, `ativo`) VALUES
	(30, 'A ameaça agora é outra', '9781234567778', '2011', 'ds', 'Português', 1, 1, 1, NULL, NULL, '2025-06-12 23:09:29', NULL, NULL, 'Y'),
	(31, 'O Pequeno Príncipe', '9788520933107', '1943', 'Uma história filosófica sobre a vida e o amor.', 'Português', 1, 1, 1, NULL, NULL, '2025-06-15 12:57:42', NULL, NULL, 'Y'),
	(32, 'Dom Casmurro', '9788578882954', '0000', 'Obra clássica de Machado de Assis sobre ciúme e dúvida.', 'Português', 2, 1, 1, NULL, NULL, '2025-06-15 12:57:42', NULL, NULL, 'Y'),
	(33, 'A Revolução dos Bichos', '9788535909556', '1945', 'Uma sátira política de George Orwell.', 'Português', 1, 3, 8, NULL, NULL, '2025-06-15 12:57:42', NULL, NULL, 'Y'),
	(34, '1984', '9788535914840', '1949', 'Uma distopia sobre vigilância e totalitarismo.', 'Português', 2, 3, 8, NULL, NULL, '2025-06-15 12:57:42', NULL, '2025-06-27 09:22:03', 'Y'),
	(35, 'Capitães da Areia', '9788520932711', '1937', 'A juventude marginalizada de Salvador.', 'Português', 1, 1, 1, NULL, NULL, '2025-06-15 12:57:42', NULL, NULL, 'Y'),
	(36, 'O Alquimista', '9788575421133', '1988', 'Uma fábula sobre seguir seus sonhos.', 'Português', 2, 3, 8, NULL, NULL, '2025-06-15 12:57:42', NULL, NULL, 'Y'),
	(37, 'Ensaio Sobre a Cegueira', '9788535914841', '1995', 'Uma epidemia de cegueira branca assola uma cidade.', 'Português', 1, 3, 8, NULL, NULL, '2025-06-15 12:57:42', NULL, NULL, 'Y'),
	(38, 'Memórias Póstumas de Brás Cubas', '9788573263193', '0000', 'Narrado por um defunto-autor.', 'Português', 2, 1, 1, NULL, NULL, '2025-06-15 12:57:42', NULL, NULL, 'Y'),
	(39, 'Harry Potter e a Pedra Filosofal', '9788532511011', '1997', 'Um jovem bruxo descobre seu destino.', 'Português', 1, 3, 8, NULL, NULL, '2025-06-15 12:57:42', NULL, NULL, 'Y'),
	(40, 'O Hobbit', '9788595084742', '1937', 'Bilbo Bolseiro parte em uma aventura inesperada.', 'Português', 2, 3, 8, NULL, NULL, '2025-06-15 12:57:42', NULL, NULL, 'Y'),
	(41, 'Vidas Secas', '9788508150738', '1938', 'A luta de uma família sertaneja contra a seca.', 'Português', 1, 1, 1, NULL, NULL, '2025-06-15 12:57:42', NULL, NULL, 'Y');

-- A despejar estrutura para tabela empresta_facil.livro_localizacao
DROP TABLE IF EXISTS `livro_localizacao`;
CREATE TABLE IF NOT EXISTS `livro_localizacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `livro_fk` int(11) NOT NULL,
  `localizacao_fk` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `criado_fk` int(11) DEFAULT NULL,
  `atualizado_fk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `livro_fk` (`livro_fk`),
  KEY `localizacao_fk` (`localizacao_fk`),
  KEY `fk_livro_localizacao_criado_fk` (`criado_fk`),
  KEY `fk_livro_localizacao_atualizado_fk` (`atualizado_fk`),
  CONSTRAINT `FK_livro_localizacao_livro` FOREIGN KEY (`livro_fk`) REFERENCES `livro` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_livro_localizacao_localizacao` FOREIGN KEY (`localizacao_fk`) REFERENCES `localizacao` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_livro_localizacao_atualizado_fk` FOREIGN KEY (`atualizado_fk`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `fk_livro_localizacao_criado_fk` FOREIGN KEY (`criado_fk`) REFERENCES `utilizador` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.livro_localizacao: ~19 rows (aproximadamente)
DELETE FROM `livro_localizacao`;
INSERT INTO `livro_localizacao` (`id`, `livro_fk`, `localizacao_fk`, `quantidade`, `criado_fk`, `atualizado_fk`) VALUES
	(1, 30, 11, 3, NULL, NULL),
	(2, 30, 16, 2, NULL, NULL),
	(3, 31, 13, 4, NULL, NULL),
	(4, 32, 14, 5, NULL, NULL),
	(5, 33, 15, 1, NULL, NULL),
	(6, 34, 16, 6, NULL, NULL),
	(7, 35, 17, 1, NULL, NULL),
	(8, 36, 18, 3, NULL, NULL),
	(9, 37, 19, 2, NULL, NULL),
	(10, 38, 20, 4, NULL, NULL),
	(11, 39, 21, 3, NULL, NULL),
	(12, 40, 22, 5, NULL, NULL),
	(13, 41, 23, 2, NULL, NULL),
	(14, 31, 24, 3, NULL, NULL),
	(15, 32, 25, 2, NULL, NULL),
	(16, 33, 26, 1, NULL, NULL),
	(17, 30, 15, 3, NULL, NULL),
	(18, 36, 16, 6, NULL, NULL),
	(19, 34, 16, 3, NULL, NULL);

-- A despejar estrutura para tabela empresta_facil.localizacao
DROP TABLE IF EXISTS `localizacao`;
CREATE TABLE IF NOT EXISTS `localizacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod_local` varchar(50) NOT NULL,
  `biblioteca_fk` int(11) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NULL DEFAULT NULL,
  `ativo` varchar(1) NOT NULL DEFAULT 'Y',
  `criado_fk` int(11) DEFAULT NULL,
  `atualizado_fk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unq_cod_local_por_biblioteca` (`cod_local`,`biblioteca_fk`),
  KEY `biblioteca_fk` (`biblioteca_fk`),
  KEY `fk_localizacao_criado_fk` (`criado_fk`),
  KEY `fk_localizacao_atualizado_fk` (`atualizado_fk`),
  CONSTRAINT `fk_localizacao_atualizado_fk` FOREIGN KEY (`atualizado_fk`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `fk_localizacao_criado_fk` FOREIGN KEY (`criado_fk`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `localizacao_ibfk_1` FOREIGN KEY (`biblioteca_fk`) REFERENCES `biblioteca` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.localizacao: ~16 rows (aproximadamente)
DELETE FROM `localizacao`;
INSERT INTO `localizacao` (`id`, `cod_local`, `biblioteca_fk`, `criado_em`, `atualizado_em`, `ativo`, `criado_fk`, `atualizado_fk`) VALUES
	(11, 'EST-001', 3, '2025-06-15 15:27:14', NULL, 'Y', NULL, NULL),
	(12, 'SALA-INFANTIL', 3, '2025-06-15 15:27:14', NULL, 'Y', NULL, NULL),
	(13, 'EST-002', 4, '2025-06-15 15:27:14', NULL, 'Y', NULL, NULL),
	(14, 'ANDAR-1', 4, '2025-06-15 15:27:14', NULL, 'Y', NULL, NULL),
	(15, 'EST-003', 5, '2025-06-15 15:27:14', NULL, 'Y', NULL, NULL),
	(16, 'SALA-ADULTOS', 5, '2025-06-15 15:27:14', NULL, 'Y', NULL, NULL),
	(17, 'EST-004', 6, '2025-06-15 15:27:14', NULL, 'Y', NULL, NULL),
	(18, 'ANDAR-2', 6, '2025-06-15 15:27:14', NULL, 'Y', NULL, NULL),
	(19, 'EST-005', 7, '2025-06-15 15:27:14', NULL, 'Y', NULL, NULL),
	(20, 'SALA-HISTORIA', 7, '2025-06-15 15:27:14', NULL, 'Y', NULL, NULL),
	(21, 'EST-006', 8, '2025-06-15 15:27:14', NULL, 'Y', NULL, NULL),
	(22, 'ARQUIVO', 8, '2025-06-15 15:27:14', NULL, 'Y', NULL, NULL),
	(23, 'EST-007', 9, '2025-06-15 15:27:14', NULL, 'Y', NULL, NULL),
	(24, 'SALA-CIENCIA', 9, '2025-06-15 15:27:14', NULL, 'Y', NULL, NULL),
	(25, 'EST-008', 10, '2025-06-15 15:27:14', NULL, 'Y', NULL, NULL),
	(26, 'ANDAR-3', 10, '2025-06-15 15:27:14', NULL, 'Y', NULL, NULL);

-- A despejar estrutura para tabela empresta_facil.reserva
DROP TABLE IF EXISTS `reserva`;
CREATE TABLE IF NOT EXISTS `reserva` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `livro_localizacao_fk` int(11) NOT NULL,
  `utilizador_fk` int(11) NOT NULL,
  `data_levantamento` date NOT NULL,
  `data_expiracao` date NOT NULL,
  `criado_em` date NOT NULL DEFAULT current_timestamp(),
  `atualiado_em` date DEFAULT NULL,
  `estado_fk` int(11) NOT NULL DEFAULT 1,
  `criado_fk` int(11) DEFAULT NULL,
  `atualizado_fk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `livro_localizacao_fk` (`livro_localizacao_fk`),
  KEY `utilizador_fk` (`utilizador_fk`),
  KEY `estado_fk` (`estado_fk`),
  KEY `fk_reserva_criado_fk` (`criado_fk`),
  KEY `fk_reserva_atualizado_fk` (`atualizado_fk`),
  CONSTRAINT `FK_reserva_estado` FOREIGN KEY (`estado_fk`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_reserva_livro_localizacao` FOREIGN KEY (`livro_localizacao_fk`) REFERENCES `livro_localizacao` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_reserva_utilizador` FOREIGN KEY (`utilizador_fk`) REFERENCES `utilizador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_reserva_atualizado_fk` FOREIGN KEY (`atualizado_fk`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `fk_reserva_criado_fk` FOREIGN KEY (`criado_fk`) REFERENCES `utilizador` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.reserva: ~4 rows (aproximadamente)
DELETE FROM `reserva`;
INSERT INTO `reserva` (`id`, `livro_localizacao_fk`, `utilizador_fk`, `data_levantamento`, `data_expiracao`, `criado_em`, `atualiado_em`, `estado_fk`, `criado_fk`, `atualizado_fk`) VALUES
	(75, 10, 9, '2025-06-20', '2025-06-27', '2025-06-17', NULL, 13, NULL, NULL),
	(81, 1, 10, '2025-06-18', '2025-06-25', '2025-06-22', NULL, 13, NULL, NULL),
	(82, 2, 10, '2025-06-23', '2025-06-26', '2025-06-22', NULL, 13, NULL, NULL),
	(83, 4, 10, '2025-06-30', '2025-07-03', '2025-06-22', NULL, 1, NULL, NULL);

-- A despejar estrutura para tabela empresta_facil.reserva_recurso
DROP TABLE IF EXISTS `reserva_recurso`;
CREATE TABLE IF NOT EXISTS `reserva_recurso` (
  `reserva_fk` int(11) DEFAULT NULL,
  `recurso_fk` int(11) DEFAULT NULL,
  `localizacao_fk` int(11) DEFAULT NULL,
  `estado_reserva_fk` int(11) DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT NULL,
  `atualizado_em` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `reserva_recurso_index_1` (`reserva_fk`,`recurso_fk`),
  KEY `recurso_fk` (`recurso_fk`),
  KEY `localizacao_fk` (`localizacao_fk`),
  KEY `estado_reserva_fk` (`estado_reserva_fk`),
  CONSTRAINT `reserva_recurso_ibfk_1` FOREIGN KEY (`reserva_fk`) REFERENCES `reserva` (`id`),
  CONSTRAINT `reserva_recurso_ibfk_2` FOREIGN KEY (`recurso_fk`) REFERENCES `livro` (`id`),
  CONSTRAINT `reserva_recurso_ibfk_3` FOREIGN KEY (`localizacao_fk`) REFERENCES `localizacao` (`id`),
  CONSTRAINT `reserva_recurso_ibfk_4` FOREIGN KEY (`estado_reserva_fk`) REFERENCES `estado` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.reserva_recurso: ~0 rows (aproximadamente)
DELETE FROM `reserva_recurso`;

-- A despejar estrutura para tabela empresta_facil.subcategoria
DROP TABLE IF EXISTS `subcategoria`;
CREATE TABLE IF NOT EXISTS `subcategoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_fk` int(11) DEFAULT NULL,
  `subcategoria` varchar(100) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT NULL,
  `atualizado_em` timestamp NULL DEFAULT NULL,
  `ativo` char(1) DEFAULT 'Y',
  `criado_fk` int(11) DEFAULT NULL,
  `atualizado_fk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria_fk` (`categoria_fk`),
  KEY `fk_subcategoria_criado_fk` (`criado_fk`),
  KEY `fk_subcategoria_atualizado_fk` (`atualizado_fk`),
  CONSTRAINT `fk_subcategoria_atualizado_fk` FOREIGN KEY (`atualizado_fk`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `fk_subcategoria_criado_fk` FOREIGN KEY (`criado_fk`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `subcategoria_ibfk_1` FOREIGN KEY (`categoria_fk`) REFERENCES `categoria` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.subcategoria: ~2 rows (aproximadamente)
DELETE FROM `subcategoria`;
INSERT INTO `subcategoria` (`id`, `categoria_fk`, `subcategoria`, `descricao`, `criado_em`, `atualizado_em`, `ativo`, `criado_fk`, `atualizado_fk`) VALUES
	(1, 1, 'Suspense', 'Sou gay', '2025-05-19 15:26:35', NULL, 'Y', NULL, NULL),
	(8, 3, 'Medinho', 'Aiiiii', NULL, NULL, 'Y', NULL, NULL);

-- A despejar estrutura para tabela empresta_facil.tipo_utilizador
DROP TABLE IF EXISTS `tipo_utilizador`;
CREATE TABLE IF NOT EXISTS `tipo_utilizador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) NOT NULL,
  `descricao` text DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `atualizado_em` timestamp NULL DEFAULT NULL,
  `ativo` varchar(1) NOT NULL DEFAULT 'Y',
  `criado_fk` int(11) DEFAULT NULL,
  `atualizado_fk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tipo_utilizador_criado_fk` (`criado_fk`),
  KEY `fk_tipo_utilizador_atualizado_fk` (`atualizado_fk`),
  CONSTRAINT `fk_tipo_utilizador_atualizado_fk` FOREIGN KEY (`atualizado_fk`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `fk_tipo_utilizador_criado_fk` FOREIGN KEY (`criado_fk`) REFERENCES `utilizador` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.tipo_utilizador: ~5 rows (aproximadamente)
DELETE FROM `tipo_utilizador`;
INSERT INTO `tipo_utilizador` (`id`, `tipo`, `descricao`, `criado_em`, `atualizado_em`, `ativo`, `criado_fk`, `atualizado_fk`) VALUES
	(4, 'Administrador', 'Com descrição ds ds', '2025-06-24 11:29:16', NULL, 'Y', NULL, NULL),
	(40, 'aaaa', 'a dsd', '2025-04-07 23:30:36', NULL, 'Y', NULL, NULL),
	(41, 'Gestor', 'Com descrição', '2025-04-07 20:57:58', NULL, 'Y', NULL, NULL),
	(42, 'Utilizador Comum', '', '2025-04-27 13:37:37', NULL, 'Y', NULL, NULL),
	(43, 'Sou gay', 'Sou bem gay', '2025-05-13 14:47:38', NULL, 'Y', NULL, NULL);

-- A despejar estrutura para tabela empresta_facil.utilizador
DROP TABLE IF EXISTS `utilizador`;
CREATE TABLE IF NOT EXISTS `utilizador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `primeiro_nome` varchar(100) NOT NULL,
  `ultimo_nome` varchar(100) NOT NULL,
  `data_nascimento` date NOT NULL,
  `nif` varchar(9) DEFAULT NULL COMMENT 'Formato padrão de NIF em Portugal',
  `cc` varchar(12) DEFAULT NULL COMMENT 'Cartão de Cidadão (12 caracteres)',
  `genero` varchar(10) DEFAULT NULL,
  `morada` text DEFAULT NULL,
  `telemovel` varchar(15) NOT NULL,
  `nome_utilizador` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `img_url` varchar(255) DEFAULT NULL,
  `tipo_utilizador_fk` int(11) NOT NULL,
  `criado_em` timestamp NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NULL DEFAULT NULL,
  `ativo` char(1) NOT NULL DEFAULT 'Y',
  `criado_fk` int(11) DEFAULT NULL,
  `atualizado_fk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tipo_utilizador_fk` (`tipo_utilizador_fk`),
  KEY `fk_utilizador_criado_fk` (`criado_fk`),
  KEY `fk_utilizador_atualizado_fk` (`atualizado_fk`),
  CONSTRAINT `fk_utilizador_atualizado_fk` FOREIGN KEY (`atualizado_fk`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `fk_utilizador_criado_fk` FOREIGN KEY (`criado_fk`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `utilizador_ibfk_1` FOREIGN KEY (`tipo_utilizador_fk`) REFERENCES `tipo_utilizador` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.utilizador: ~17 rows (aproximadamente)
DELETE FROM `utilizador`;
INSERT INTO `utilizador` (`id`, `primeiro_nome`, `ultimo_nome`, `data_nascimento`, `nif`, `cc`, `genero`, `morada`, `telemovel`, `nome_utilizador`, `senha`, `email`, `img_url`, `tipo_utilizador_fk`, `criado_em`, `atualizado_em`, `ativo`, `criado_fk`, `atualizado_fk`) VALUES
	(4, 'Tiago', 'Borja', '2005-12-02', '311566260', '123456789123', 'F', NULL, '962193439', 'tiagomatx', '', 'tiagomatx@gmail.com', 'upload/681d24de30d1b_escola_secundaria_antonio_sergio_2.jpg', 4, '2025-04-21 23:08:17', NULL, 'Y', NULL, NULL),
	(8, 'Natalia', 'Rodrigues', '1997-05-30', '311123456', '321654987', 'F', NULL, '351963446548', 'nati', '$2y$10$C.9g5op832wBeSHehgGs8OuOV1kyk0FXPwkqv1dBcQogFN0fWrHD.', 'natibreis@gmail.com', NULL, 42, '2025-04-27 13:33:42', NULL, 'N', NULL, NULL),
	(9, 'Guilherme', 'Borja', '2025-04-11', '311566260', '321654987', 'M', NULL, '962193439', 'guigui123', '123456', 'guigui@gmail.com', NULL, 42, '2025-04-27 13:43:25', NULL, 'N', NULL, NULL),
	(10, 'Maria', 'Zamberlan', '2004-12-17', '3115489', '321654789', 'F', NULL, '3519278145', 'mzamberlan', '$2y$10$0e52qpYjkdbjX/erql4.LefWHdbIQiaRfulKgWG9gk.jzhuf0I5MK', 'Maria.eduarda1712@gmail.com', 'upload/683dbe3b5d1ec_can-like.jpg', 4, '2025-04-27 13:59:42', NULL, 'Y', NULL, NULL),
	(11, 'Julia', 'Correa', '2007-07-07', '12345678', '1111111111', 'F', NULL, '962193439', '3eddaa', '$2y$10$c5ixHn1u33RAfyYYqg6D5.EoMNhTFAvRgwownGVeSTwdbmbzMIdlm', 'aaaaaaa@gmail.com', NULL, 42, '2025-04-27 14:03:17', NULL, 'Y', NULL, NULL),
	(12, 'Admin', 'Admin', '2005-12-02', '', '', '', NULL, '351962193439', 'admin', '$2y$10$C.9g5op832wBeSHehgGs8OuOV1kyk0FXPwkqv1dBcQogFN0fWrHD.', 'tiagomatx@gmail.com', 'upload/681d20ee589d1_escola_secundaria_antonio_sergio_2.jpg', 4, '2025-04-27 14:09:25', NULL, 'Y', NULL, NULL),
	(13, 'Maria Eduarda', 'Zamberlan', '2004-12-17', '', '', 'F', NULL, '927252387', 'dudinhadocreu123', '$2y$10$KDraR.i4/nGi7QBR5AK0k.lSb9v5zbyO2wiV2TwHL.HByd3V84apm', 'mzamberlan8@gmail.com', NULL, 41, '2025-05-06 20:12:32', NULL, 'Y', NULL, NULL),
	(15, 'Marcos', 'Santos', '2025-05-01', '', '', 'M', '136 Rua de Valverde', '962193439', 'flaviodino', '$2y$10$fPpHRjpugtWLu/fqNHrLzOva4jNwjI2v6KV23GsGyPd2HGTFunnNi', 'tiagomatx@gmail.com', NULL, 42, '2025-05-11 03:04:27', NULL, 'Y', NULL, NULL),
	(17, 'Rafael ', 'Mota', '2006-06-11', '', '', 'M', '', '351123456789', 'rmota', '$2y$10$2TxQt10VhaiemnrABsdaV.EkaY6fY8mywispAw0EvdBxJ3qD3TBYi', 'rafaelfilipemota543@gmail.com', NULL, 42, '2025-05-12 15:27:20', NULL, 'Y', NULL, NULL),
	(18, 'Rafael', 'Mota', '2006-06-11', '', '', 'M', '136 Rua de Valverde', '962193439', 'rmota', '$2y$10$O612JzLLCuhkqQh9KIR11eU1P/mGc9dCqAvcxHUonuFRkMKi3NaXW', 'rafaelfilipemota543@gmail.com', NULL, 42, '2025-05-12 15:35:26', NULL, 'Y', NULL, NULL),
	(19, 'Emanuel', 'Oliveira', '2005-12-22', '12345678', '123456789123', 'M', NULL, '351910090617', 'fulaninho', '1414159', 'emanuelhenrique05@gmail.com', 'upload/6823555b10f9e_primeira-kill.png', 4, '2025-05-13 14:21:15', NULL, 'N', NULL, NULL),
	(20, 'Marcos', 'Santos', '2025-06-03', '311444555', '123456789123', 'M', NULL, '962193439', 'msantos', '147258369', 'msantos@gmail.com', NULL, 4, '2025-06-03 15:27:35', NULL, 'Y', NULL, NULL),
	(21, 'Tiago', 'Borja', '2005-12-02', '123456783', '12345674324', 'M', NULL, '962193439', 'tteste', '123456', 'exemplo-teste@gmail.com', NULL, 42, '2025-06-26 13:37:52', NULL, 'Y', NULL, NULL),
	(22, 'ZEDAMANGA', 'DAMANGA', '2002-12-02', '1235', '1478529654', 'M', NULL, '962193439', 'DASMANGAS', 'DASMANGAS', 'tiagomatx@gmail.com', NULL, 42, '2025-06-26 13:42:32', NULL, 'Y', NULL, NULL),
	(23, 'dsad', 'sdsda', '2002-12-02', '', '', 'M', NULL, '789456123', 'aaaa', 'sdsdsadas', 'sdadssa@gmail.com', NULL, 4, '2025-06-26 13:46:59', NULL, 'Y', NULL, NULL),
	(24, 'dsad', 'sdsda', '2002-12-02', '', '', 'M', NULL, '789456123', 'aaaa', 'sdsdsadas', 'sdadssa@gmail.com', NULL, 4, '2025-06-26 13:47:28', NULL, 'Y', NULL, NULL),
	(31, 'Tiago', 'Borja', '2004-05-12', '1234321', '123456789124', 'O', '136 Rua de Valverde', '962193439', 'tbrja', '$2y$10$ckDMX1MSljqvJKSxq7n/EuMXTpu6nLg3Gmm0Lj1Vc2rF2aw1TGg5u', 'tiagomatx@gmail.com', NULL, 42, '2025-06-27 11:20:46', NULL, 'P', NULL, NULL),
	(32, 'Tiago', 'Borja', '2004-05-12', '1234321', '123456789124', 'O', '136 Rua de Valverde', '962193439', 'tbrja', '$2y$10$rferiu3JnktJHA2aUpfVreCEEoyU3OsAvD4zXzH9pm2zGYVAnnGJy', 'tiagomatx@gmail.com', NULL, 42, '2025-06-27 11:22:28', NULL, 'P', NULL, NULL);

-- A despejar estrutura para tabela empresta_facil.utilizador_biblioteca
DROP TABLE IF EXISTS `utilizador_biblioteca`;
CREATE TABLE IF NOT EXISTS `utilizador_biblioteca` (
  `utilizador_fk` int(11) NOT NULL,
  `biblioteca_fk` int(11) NOT NULL,
  `codigo_validacao` varchar(12) NOT NULL,
  `validado` tinyint(1) NOT NULL DEFAULT 0,
  `data_pedido` date NOT NULL DEFAULT current_timestamp(),
  `data_expirado` date NOT NULL,
  `data_validacao` date DEFAULT NULL,
  KEY `FK_utilizador_biblioteca_utilizador` (`utilizador_fk`),
  KEY `FK_utilizador_biblioteca_biblioteca` (`biblioteca_fk`),
  CONSTRAINT `FK_utilizador_biblioteca_biblioteca` FOREIGN KEY (`biblioteca_fk`) REFERENCES `biblioteca` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_utilizador_biblioteca_utilizador` FOREIGN KEY (`utilizador_fk`) REFERENCES `utilizador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.utilizador_biblioteca: ~9 rows (aproximadamente)
DELETE FROM `utilizador_biblioteca`;
INSERT INTO `utilizador_biblioteca` (`utilizador_fk`, `biblioteca_fk`, `codigo_validacao`, `validado`, `data_pedido`, `data_expirado`, `data_validacao`) VALUES
	(24, 3, '1234HFG', 0, '2025-06-26', '2025-07-10', NULL),
	(24, 8, '1234HFG', 0, '2025-06-26', '2025-07-10', NULL),
	(24, 9, '1234HFG', 0, '2025-06-26', '2025-07-10', NULL),
	(31, 4, '9CALN7C3RISF', 0, '2025-06-27', '2025-07-11', NULL),
	(31, 7, '9CALN7C3RISF', 0, '2025-06-27', '2025-07-11', NULL),
	(31, 5, '9CALN7C3RISF', 0, '2025-06-27', '2025-07-11', NULL),
	(31, 6, '9CALN7C3RISF', 0, '2025-06-27', '2025-07-11', NULL),
	(32, 4, 'JF2RVSDFXH9I', 0, '2025-06-27', '2025-07-11', NULL),
	(32, 7, 'JF2RVSDFXH9I', 0, '2025-06-27', '2025-07-11', NULL),
	(32, 5, 'JF2RVSDFXH9I', 0, '2025-06-27', '2025-07-11', NULL),
	(32, 6, 'JF2RVSDFXH9I', 0, '2025-06-27', '2025-07-11', NULL);

-- A despejar estrutura para disparador empresta_facil.before_insert_utilizador
DROP TRIGGER IF EXISTS `before_insert_utilizador`;
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER before_insert_utilizador
BEFORE INSERT ON utilizador
FOR EACH ROW
BEGIN
    -- Verifique se o campo tipo_utilizador_fk está vazio
    IF NEW.tipo_utilizador_fk IS NULL OR NEW.tipo_utilizador_fk = '' THEN
        -- Se estiver vazio, atribua o ID do "Utilizador Comum"
        SET NEW.tipo_utilizador_fk = (SELECT id FROM tipo_utilizador WHERE tipo = 'Utilizador Comum' LIMIT 1);
    END IF;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- A despejar estrutura para disparador empresta_facil.trg_update_estado_emprestimo
DROP TRIGGER IF EXISTS `trg_update_estado_emprestimo`;
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER trg_update_estado_emprestimo
BEFORE UPDATE ON emprestimo_livro
FOR EACH ROW
BEGIN
    DECLARE v_id_andamento INT;
    DECLARE v_id_concluido INT;
    DECLARE v_id_atrasado INT;
    DECLARE v_data_devolucao DATE;

    -- Buscar os IDs dos estados
    SELECT id INTO v_id_andamento
    FROM estado
    WHERE estado = 'EM ANDAMENTO' AND observacoes = 'EMPRESTIMO'
    LIMIT 1;

    SELECT id INTO v_id_concluido
    FROM estado
    WHERE estado = 'CONCLUIDO' AND observacoes = 'EMPRESTIMO'
    LIMIT 1;

    SELECT id INTO v_id_atrasado
    FROM estado
    WHERE estado = 'ATRASADO' AND observacoes = 'EMPRESTIMO'
    LIMIT 1;

    -- Obter a data_devolucao da tabela emprestimo
    SELECT data_devolucao
    INTO v_data_devolucao
    FROM emprestimo
    WHERE id = NEW.emprestimo_fk;

    -- Verificar se o livro já foi devolvido
    IF NEW.data_devolvido IS NOT NULL THEN
        IF v_data_devolucao IS NOT NULL AND NEW.data_devolvido > v_data_devolucao THEN
            SET NEW.estado_emprestimo_fk = v_id_atrasado;
        ELSE
            SET NEW.estado_emprestimo_fk = v_id_concluido;
        END IF;
    ELSE
        -- Se ainda não devolveu, mas já tem data de devolução prevista
        IF v_data_devolucao IS NOT NULL THEN
            SET NEW.estado_emprestimo_fk = v_id_andamento;
        END IF;
    END IF;

END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
