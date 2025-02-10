-- --------------------------------------------------------
-- Anfitrião:                    127.0.0.1
-- Versão do servidor:           10.4.27-MariaDB - mariadb.org binary distribution
-- SO do servidor:               Win64
-- HeidiSQL Versão:              12.9.0.6999
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
  `nome` varchar(255) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `genero` varchar(50) DEFAULT NULL,
  `biografia` text DEFAULT NULL,
  `nacionalidade` varchar(100) DEFAULT NULL,
  `foto_url` varchar(500) DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT NULL,
  `atualizado_em` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela empresta_facil.autor_recurso
DROP TABLE IF EXISTS `autor_recurso`;
CREATE TABLE IF NOT EXISTS `autor_recurso` (
  `autor_fk` int(11) DEFAULT NULL,
  `recurso_fk` int(11) DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT NULL,
  `atualizado_em` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `autor_recurso_index_0` (`autor_fk`,`recurso_fk`),
  KEY `recurso_fk` (`recurso_fk`),
  CONSTRAINT `autor_recurso_ibfk_1` FOREIGN KEY (`autor_fk`) REFERENCES `autor` (`id`),
  CONSTRAINT `autor_recurso_ibfk_2` FOREIGN KEY (`recurso_fk`) REFERENCES `recurso` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela empresta_facil.avaliacoes
DROP TABLE IF EXISTS `avaliacoes`;
CREATE TABLE IF NOT EXISTS `avaliacoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recurso_fk` int(11) DEFAULT NULL,
  `utilizador_fk` int(11) DEFAULT NULL,
  `avaliacao` int(11) DEFAULT NULL COMMENT 'Valores de 0 a 5',
  `data_avaliacao` timestamp NULL DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT NULL,
  `atualizado_em` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recurso_fk` (`recurso_fk`),
  KEY `utilizador_fk` (`utilizador_fk`),
  CONSTRAINT `avaliacoes_ibfk_1` FOREIGN KEY (`recurso_fk`) REFERENCES `recurso` (`id`),
  CONSTRAINT `avaliacoes_ibfk_2` FOREIGN KEY (`utilizador_fk`) REFERENCES `utilizador` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela empresta_facil.biblioteca
DROP TABLE IF EXISTS `biblioteca`;
CREATE TABLE IF NOT EXISTS `biblioteca` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `morada` text DEFAULT NULL,
  `cod_postal` varchar(15) DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT NULL,
  `atualizado_em` timestamp NULL DEFAULT NULL,
  `ativo` char(1) DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela empresta_facil.categoria
DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(100) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT NULL,
  `atualizado_em` timestamp NULL DEFAULT NULL,
  `ativo` char(1) DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela empresta_facil.comentarios
DROP TABLE IF EXISTS `comentarios`;
CREATE TABLE IF NOT EXISTS `comentarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recurso_fk` int(11) DEFAULT NULL,
  `utilizador_fk` int(11) DEFAULT NULL,
  `comentario` text DEFAULT NULL,
  `data_comentario` timestamp NULL DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT NULL,
  `atualizado_em` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recurso_fk` (`recurso_fk`),
  KEY `utilizador_fk` (`utilizador_fk`),
  CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`recurso_fk`) REFERENCES `recurso` (`id`),
  CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`utilizador_fk`) REFERENCES `utilizador` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela empresta_facil.editora
DROP TABLE IF EXISTS `editora`;
CREATE TABLE IF NOT EXISTS `editora` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `editora` varchar(255) DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT NULL,
  `atualizado_em` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela empresta_facil.emprestimo
DROP TABLE IF EXISTS `emprestimo`;
CREATE TABLE IF NOT EXISTS `emprestimo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recurso_fk` int(11) DEFAULT NULL,
  `utilizador_fk` int(11) DEFAULT NULL,
  `funcionario_fk` int(11) DEFAULT NULL,
  `data_emprestimo_fk` timestamp NULL DEFAULT NULL,
  `data_devolucao_fk` timestamp NULL DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT NULL,
  `atualizado_em` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recurso_fk` (`recurso_fk`),
  KEY `utilizador_fk` (`utilizador_fk`),
  KEY `funcionario_fk` (`funcionario_fk`),
  CONSTRAINT `emprestimo_ibfk_1` FOREIGN KEY (`recurso_fk`) REFERENCES `recurso` (`id`),
  CONSTRAINT `emprestimo_ibfk_2` FOREIGN KEY (`utilizador_fk`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `emprestimo_ibfk_3` FOREIGN KEY (`funcionario_fk`) REFERENCES `funcionario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela empresta_facil.emprestimo_recurso
DROP TABLE IF EXISTS `emprestimo_recurso`;
CREATE TABLE IF NOT EXISTS `emprestimo_recurso` (
  `emprestimo_fk` int(11) DEFAULT NULL,
  `recurso_fk` int(11) DEFAULT NULL,
  `estado_levantou_fk` int(11) DEFAULT NULL,
  `estado_devolucao_fk` int(11) DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT NULL,
  `atualizado_em` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `emprestimo_recurso_index_2` (`emprestimo_fk`,`recurso_fk`),
  KEY `recurso_fk` (`recurso_fk`),
  KEY `estado_levantou_fk` (`estado_levantou_fk`),
  KEY `estado_devolucao_fk` (`estado_devolucao_fk`),
  CONSTRAINT `emprestimo_recurso_ibfk_1` FOREIGN KEY (`emprestimo_fk`) REFERENCES `emprestimo` (`id`),
  CONSTRAINT `emprestimo_recurso_ibfk_2` FOREIGN KEY (`recurso_fk`) REFERENCES `recurso` (`id`),
  CONSTRAINT `emprestimo_recurso_ibfk_3` FOREIGN KEY (`estado_levantou_fk`) REFERENCES `estado` (`id`),
  CONSTRAINT `emprestimo_recurso_ibfk_4` FOREIGN KEY (`estado_devolucao_fk`) REFERENCES `estado` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela empresta_facil.estado
DROP TABLE IF EXISTS `estado`;
CREATE TABLE IF NOT EXISTS `estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(50) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT NULL,
  `atualizado_em` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Exportação de dados não seleccionada.

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
  CONSTRAINT `foto_recurso_ibfk_1` FOREIGN KEY (`id_recurso`) REFERENCES `recurso` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela empresta_facil.funcionario
DROP TABLE IF EXISTS `funcionario`;
CREATE TABLE IF NOT EXISTS `funcionario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `utilizador_fk` int(11) DEFAULT NULL,
  `biblioteca_fk` int(11) DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT NULL,
  `atualizado_em` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `utilizador_fk` (`utilizador_fk`),
  KEY `biblioteca_fk` (`biblioteca_fk`),
  CONSTRAINT `funcionario_ibfk_1` FOREIGN KEY (`utilizador_fk`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `funcionario_ibfk_2` FOREIGN KEY (`biblioteca_fk`) REFERENCES `biblioteca` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela empresta_facil.localizacao
DROP TABLE IF EXISTS `localizacao`;
CREATE TABLE IF NOT EXISTS `localizacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod_loca` varchar(50) DEFAULT NULL,
  `biblioteca_fk` int(11) DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT NULL,
  `atualizado_em` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `biblioteca_fk` (`biblioteca_fk`),
  CONSTRAINT `localizacao_ibfk_1` FOREIGN KEY (`biblioteca_fk`) REFERENCES `biblioteca` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela empresta_facil.recurso
DROP TABLE IF EXISTS `recurso`;
CREATE TABLE IF NOT EXISTS `recurso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) DEFAULT NULL,
  `isbn` varchar(13) DEFAULT NULL COMMENT 'Formato padrão do ISBN',
  `ano_lancamento` int(11) DEFAULT NULL,
  `sinopse` text DEFAULT NULL,
  `idioma` varchar(50) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `tipo_recurso_fk` int(11) DEFAULT NULL,
  `editora_fk` int(11) DEFAULT NULL,
  `categoria_fk` int(11) DEFAULT NULL,
  `subcategoria_fk` int(11) DEFAULT NULL,
  `localizacao_fk` int(11) DEFAULT NULL,
  `estado_fk` int(11) DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT NULL,
  `atualizado_em` timestamp NULL DEFAULT NULL,
  `ativo` char(1) DEFAULT 'Y',
  PRIMARY KEY (`id`),
  KEY `tipo_recurso_fk` (`tipo_recurso_fk`),
  KEY `editora_fk` (`editora_fk`),
  KEY `categoria_fk` (`categoria_fk`),
  KEY `subcategoria_fk` (`subcategoria_fk`),
  KEY `localizacao_fk` (`localizacao_fk`),
  KEY `estado_fk` (`estado_fk`),
  CONSTRAINT `recurso_ibfk_1` FOREIGN KEY (`tipo_recurso_fk`) REFERENCES `tipo_recurso` (`id`),
  CONSTRAINT `recurso_ibfk_2` FOREIGN KEY (`editora_fk`) REFERENCES `editora` (`id`),
  CONSTRAINT `recurso_ibfk_3` FOREIGN KEY (`categoria_fk`) REFERENCES `categoria` (`id`),
  CONSTRAINT `recurso_ibfk_4` FOREIGN KEY (`subcategoria_fk`) REFERENCES `subcategoria` (`id`),
  CONSTRAINT `recurso_ibfk_5` FOREIGN KEY (`localizacao_fk`) REFERENCES `localizacao` (`id`),
  CONSTRAINT `recurso_ibfk_6` FOREIGN KEY (`estado_fk`) REFERENCES `estado` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela empresta_facil.reserva
DROP TABLE IF EXISTS `reserva`;
CREATE TABLE IF NOT EXISTS `reserva` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `utilizador_fk` int(11) DEFAULT NULL,
  `data_reserva` timestamp NULL DEFAULT NULL,
  `data_expiracao` timestamp NULL DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT NULL,
  `atualizado_em` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `utilizador_fk` (`utilizador_fk`),
  CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`utilizador_fk`) REFERENCES `utilizador` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Exportação de dados não seleccionada.

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
  CONSTRAINT `reserva_recurso_ibfk_2` FOREIGN KEY (`recurso_fk`) REFERENCES `recurso` (`id`),
  CONSTRAINT `reserva_recurso_ibfk_3` FOREIGN KEY (`localizacao_fk`) REFERENCES `localizacao` (`id`),
  CONSTRAINT `reserva_recurso_ibfk_4` FOREIGN KEY (`estado_reserva_fk`) REFERENCES `estado` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Exportação de dados não seleccionada.

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
  PRIMARY KEY (`id`),
  KEY `categoria_fk` (`categoria_fk`),
  CONSTRAINT `subcategoria_ibfk_1` FOREIGN KEY (`categoria_fk`) REFERENCES `categoria` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela empresta_facil.tipo_recurso
DROP TABLE IF EXISTS `tipo_recurso`;
CREATE TABLE IF NOT EXISTS `tipo_recurso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(100) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT NULL,
  `atualizado_em` timestamp NULL DEFAULT NULL,
  `ativo` char(1) DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela empresta_facil.tipo_utilizador
DROP TABLE IF EXISTS `tipo_utilizador`;
CREATE TABLE IF NOT EXISTS `tipo_utilizador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT NULL,
  `atualizado_em` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Exportação de dados não seleccionada.

-- A despejar estrutura para tabela empresta_facil.utilizador
DROP TABLE IF EXISTS `utilizador`;
CREATE TABLE IF NOT EXISTS `utilizador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `primeiro_nome` varchar(100) DEFAULT NULL,
  `ultimo_nome` varchar(100) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `nif` varchar(9) DEFAULT NULL COMMENT 'Formato padrão de NIF em Portugal',
  `cc` varchar(12) DEFAULT NULL COMMENT 'Cartão de Cidadão (12 caracteres)',
  `genero` varchar(10) DEFAULT NULL,
  `morada` text DEFAULT NULL,
  `telemovel` varchar(15) DEFAULT NULL,
  `nome_utilizador` varchar(50) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `tipo_utilizador_fk` int(11) DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT NULL,
  `atualizado_em` timestamp NULL DEFAULT NULL,
  `ativo` char(1) DEFAULT 'Y',
  PRIMARY KEY (`id`),
  KEY `tipo_utilizador_fk` (`tipo_utilizador_fk`),
  CONSTRAINT `utilizador_ibfk_1` FOREIGN KEY (`tipo_utilizador_fk`) REFERENCES `tipo_utilizador` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Exportação de dados não seleccionada.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
