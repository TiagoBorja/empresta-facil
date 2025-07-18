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
  `atualizado_em` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `ativo` char(1) NOT NULL DEFAULT 'Y',
  `criado_fk` int(11) DEFAULT NULL,
  `atualizado_fk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_criado_fk` (`criado_fk`),
  KEY `fk_atualizado_fk` (`atualizado_fk`),
  CONSTRAINT `fk_atualizado_fk` FOREIGN KEY (`atualizado_fk`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `fk_criado_fk` FOREIGN KEY (`criado_fk`) REFERENCES `utilizador` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.autor: ~10 rows (aproximadamente)
DELETE FROM `autor`;
INSERT INTO `autor` (`id`, `primeiro_nome`, `ultimo_nome`, `data_nascimento`, `genero`, `biografia`, `nacionalidade`, `img_url`, `criado_em`, `atualizado_em`, `ativo`, `criado_fk`, `atualizado_fk`) VALUES
	(15, 'Yuval', 'Harari', '1976-02-24', 'M', 'Historiador e professor na Universidade Hebraica de Jerusalém. Ficou internacionalmente conhecido pelo seu livro Sapiens: Uma Breve História da Humanidade, onde aborda a história da humanidade de forma acessível e interdisciplinar.', 'Israelense', '686fb984964f2_yuval-harari.jpg', '2025-07-10 13:00:52', NULL, 'Y', 10, NULL),
	(16, 'Robert', 'Martin', '1952-12-05', 'M', 'Conhecido como &#34;Uncle Bob&#34;, é um dos autores e especialistas mais influentes em engenharia de software e práticas de programação limpa (clean code). Escreveu vários livros fundamentais para programadores, como Clean Code e The Clean Coder.', 'Estadunidense', NULL, '2025-07-10 13:12:47', NULL, 'Y', 10, NULL),
	(17, 'George', 'Orwell', '1903-06-25', 'M', 'George Orwell foi um escritor, ensaísta e jornalista britânico, conhecido pelo seu posicionamento político contra o totalitarismo. A sua obra mais conhecida, 1984, denuncia regimes opressivos e defende a liberdade de pensamento. Também escreveu A Quinta dos Animais. Morreu em 1950.', 'Britânico ', NULL, '2025-07-13 21:56:18', '2025-07-13 21:57:22', 'Y', 10, 10),
	(18, 'Charles', 'Duhigg', '1974-01-01', 'M', 'Charles Duhigg é um jornalista investigativo e escritor norte-americano. Ganhou um Prémio Pulitzer pelas suas reportagens e ficou mundialmente conhecido com o best-seller O Poder do Hábito, no qual explora como os hábitos moldam as nossas vidas e como podemos alterá-los conscientemente.', 'Americano', NULL, '2025-07-13 21:57:08', NULL, 'Y', 10, NULL),
	(19, 'Dan', 'Brown', '1964-06-22', 'M', 'Dan Brown é conhecido pelos seus thrillers com temáticas religiosas e simbólicas, que misturam ficção com factos históricos. O seu maior sucesso, O Código Da Vinci, gerou debates e adaptações cinematográficas. As suas obras envolvem mistério, arte e religião, com ritmo acelerado e enigmas complexos.', 'Americano', NULL, '2025-07-13 21:58:05', NULL, 'Y', 10, NULL),
	(20, 'Ray', 'Dalio', '1949-08-08', 'M', 'Ray Dalio é um investidor bilionário e fundador da Bridgewater Associates, um dos maiores fundos de investimento do mundo. É também autor e mentor de líderes, tendo escrito Princípios para partilhar os fundamentos que usou na sua vida pessoal e profissional. É conhecido pela sua abordagem sistemática à tomada de decisões.&#13;&#10;&#13;&#10;', 'Americano ', NULL, '2025-07-13 21:58:47', NULL, 'Y', 10, NULL),
	(21, 'Gabriel', 'Márquez', '1927-03-06', 'M', 'Escritor e jornalista colombiano, vencedor do Prémio Nobel da Literatura em 1982. É conhecido pelo seu estilo de realismo mágico e pelas suas contribuições à literatura latino-americana.', 'Colombiana', NULL, '2025-07-14 15:25:09', NULL, 'Y', 10, NULL),
	(22, 'Jane', 'Austen', '1675-12-16', 'F', 'Escritora inglesa do período georgiano, famosa pelas suas sátiras sociais e pela forma como retratou as relações humanas e a condição feminina da sua época.', 'Britânica', NULL, '2025-07-14 15:25:50', NULL, 'Y', 10, NULL),
	(23, 'Fiódor', 'Dostoiévski', '1821-11-11', 'M', 'Um dos maiores romancistas russos, explorou temas como a psicologia humana, religião, moral e existencialismo.&#13;&#10;&#13;&#10;', 'Russa', NULL, '2025-07-14 15:26:26', NULL, 'Y', 10, NULL),
	(24, 'José', 'Saramago', '1992-11-16', 'M', 'Escritor português galardoado com o Prémio Nobel da Literatura em 1998. É conhecido pela sua escrita densa e estilo único de pontuação.', 'Português', NULL, '2025-07-14 15:26:54', NULL, 'Y', 10, NULL);

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

-- A despejar dados para tabela empresta_facil.autor_livro: ~9 rows (aproximadamente)
DELETE FROM `autor_livro`;
INSERT INTO `autor_livro` (`autor_fk`, `livro_fk`, `criado_em`, `atualizado_em`, `criado_fk`, `atualizado_fk`) VALUES
	(15, 141, '2025-07-14 16:19:35', NULL, NULL, NULL),
	(16, 139, '2025-07-14 16:16:47', NULL, NULL, NULL),
	(17, 140, '2025-07-14 16:17:34', NULL, NULL, NULL),
	(18, 142, '2025-07-14 16:18:02', NULL, NULL, NULL),
	(19, 143, '2025-07-14 16:18:37', NULL, NULL, NULL),
	(20, 144, '2025-07-14 16:19:15', NULL, NULL, NULL),
	(21, 145, '2025-07-14 15:38:21', NULL, NULL, NULL),
	(22, 146, '2025-07-14 15:39:23', NULL, NULL, NULL),
	(23, 147, '2025-07-14 15:40:42', NULL, NULL, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `atualizado_em` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `ativo` char(1) NOT NULL DEFAULT 'Y',
  `criado_fk` int(11) DEFAULT NULL,
  `atualizado_fk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_biblioteca_criado_fk` (`criado_fk`),
  KEY `fk_biblioteca_atualizado_fk` (`atualizado_fk`),
  CONSTRAINT `fk_biblioteca_atualizado_fk` FOREIGN KEY (`atualizado_fk`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `fk_biblioteca_criado_fk` FOREIGN KEY (`criado_fk`) REFERENCES `utilizador` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.biblioteca: ~3 rows (aproximadamente)
DELETE FROM `biblioteca`;
INSERT INTO `biblioteca` (`id`, `nome`, `email`, `morada`, `cod_postal`, `criado_em`, `atualizado_em`, `ativo`, `criado_fk`, `atualizado_fk`) VALUES
	(3, 'Biblioteca Central de Gaia', 'email-exemplo@gmail.com', 'Rua das Letras, 123', '4400-123', '2025-06-15 15:25:12', '2025-07-13 10:44:13', 'Y', 10, 10),
	(4, 'Biblioteca Escolar António Sérgio', 'email-exemplo@gmail.com', 'Av. das Escolas, 45', '4405-321', '2025-06-15 15:25:12', '2025-07-13 10:44:13', 'Y', 10, NULL),
	(5, 'Biblioteca Municipal do Porto', 'email-exemplo@gmail.com', 'Praça do Saber, 10', '4050-230', '2025-06-15 15:25:12', '2025-07-13 10:44:13', 'Y', 10, NULL),
	(6, 'Biblioteca Santa Marinha', 'email-exemplo@gmail.com', 'Rua da Liberdade, 8', '4430-456', '2025-06-15 15:25:12', '2025-07-13 10:44:13', 'Y', 10, NULL),
	(7, 'Biblioteca Escolar Santa Bárbara', 'email-exemplo@gmail.com', 'Travessa do Estudo, 17', '4410-998', '2025-06-15 15:25:12', '2025-07-13 10:44:13', 'Y', 10, NULL),
	(8, 'Biblioteca Comunitária de Valadares', 'email-exemplo@gmail.com', 'Estrada Nacional 1, 250', '4415-112', '2025-06-15 15:25:12', '2025-07-13 10:44:13', 'N', 10, NULL),
	(9, 'Biblioteca de Mafamude', 'email-exemplo@gmail.com', 'Rua dos Livros, 88', '4400-789', '2025-06-15 15:25:12', '2025-07-13 10:44:13', 'Y', 10, NULL),
	(10, 'Biblioteca de Vilar do Paraíso', 'email-exemplo@gmail.com', 'Rua da Cultura, 33', '4410-220', '2025-06-15 15:25:12', '2025-07-13 10:44:13', 'Y', 10, NULL),
	(11, 'Biblioteca dos Tangas Master Value', 'tangas@gmail.com', 'Rua das tangas', '123456', '2025-07-13 10:21:20', '2025-07-13 10:44:13', 'Y', 10, NULL);

-- A despejar estrutura para tabela empresta_facil.categoria
DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(100) NOT NULL,
  `descricao` varchar(50) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `ativo` char(1) NOT NULL DEFAULT 'Y',
  `criado_fk` int(11) DEFAULT NULL,
  `atualizado_fk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_categoria_criado_fk` (`criado_fk`),
  KEY `fk_categoria_atualizado_fk` (`atualizado_fk`),
  CONSTRAINT `fk_categoria_atualizado_fk` FOREIGN KEY (`atualizado_fk`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `fk_categoria_criado_fk` FOREIGN KEY (`criado_fk`) REFERENCES `utilizador` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.categoria: ~10 rows (aproximadamente)
DELETE FROM `categoria`;
INSERT INTO `categoria` (`id`, `categoria`, `descricao`, `criado_em`, `atualizado_em`, `ativo`, `criado_fk`, `atualizado_fk`) VALUES
	(11, 'Tecnologia da Informação', 'Computadores', '2025-07-10 12:07:43', NULL, 'Y', NULL, NULL),
	(12, 'Ação', 'adas', '2025-07-10 12:28:49', '2025-07-11 09:49:17', 'Y', 10, 10),
	(13, 'Ficção', 'Narrativas criadas a partir da imaginação, com per', '2025-07-13 21:51:20', NULL, 'Y', 52, NULL),
	(14, 'Não-ficção', 'Livros baseados em factos reais, dados históricos,', '2025-07-13 21:51:40', NULL, 'Y', 52, NULL),
	(15, 'Desenvolvimento Pessoal', 'Obras que ajudam os leitores a melhorar aspetos da', '2025-07-13 21:52:19', NULL, 'Y', 52, NULL),
	(16, 'Negócios', 'Livros que abordam estratégias, gestão e funcionam', '2025-07-13 21:52:42', NULL, 'Y', 52, NULL),
	(17, 'Literatura Portuguesa', ' ', '2025-07-14 15:18:19', NULL, 'Y', 10, NULL),
	(18, 'Biografia', ' ', '2025-07-14 15:18:38', NULL, 'Y', 10, NULL),
	(19, 'Fantasia', ' ', '2025-07-14 15:18:54', NULL, 'Y', 10, NULL),
	(20, 'Literatura', ' ', '2025-07-14 15:28:59', NULL, 'Y', 10, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.comentarios: ~0 rows (aproximadamente)
DELETE FROM `comentarios`;

-- A despejar estrutura para tabela empresta_facil.editora
DROP TABLE IF EXISTS `editora`;
CREATE TABLE IF NOT EXISTS `editora` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `editora` varchar(120) NOT NULL,
  `ativo` varchar(1) NOT NULL DEFAULT 'Y',
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `criado_fk` int(11) DEFAULT NULL,
  `atualizado_fk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_editora_criado_fk` (`criado_fk`),
  KEY `fk_editora_atualizado_fk` (`atualizado_fk`),
  CONSTRAINT `fk_editora_atualizado_fk` FOREIGN KEY (`atualizado_fk`) REFERENCES `utilizador` (`id`),
  CONSTRAINT `fk_editora_criado_fk` FOREIGN KEY (`criado_fk`) REFERENCES `utilizador` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.editora: ~3 rows (aproximadamente)
DELETE FROM `editora`;
INSERT INTO `editora` (`id`, `editora`, `ativo`, `criado_em`, `atualizado_em`, `criado_fk`, `atualizado_fk`) VALUES
	(1, 'Editora do Porto', 'Y', '2025-05-26 14:33:58', NULL, NULL, NULL),
	(2, 'Editora de Gaia', 'N', '2025-05-26 15:22:16', '2025-07-10 12:02:27', NULL, 10),
	(3, 'Editora do Brasil', 'Y', '2025-07-03 08:14:50', NULL, NULL, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.emprestimo: ~0 rows (aproximadamente)
DELETE FROM `emprestimo`;

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

-- A despejar dados para tabela empresta_facil.emprestimo_livro: ~0 rows (aproximadamente)
DELETE FROM `emprestimo_livro`;

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
	(4, 'NOVO', 'LIVRO', '2025-06-22 13:47:45', NULL, NULL, NULL),
	(5, 'SEMI-NOVO', 'LIVRO', '2025-06-22 13:47:45', NULL, NULL, NULL),
	(6, 'MANCHADO', 'LIVRO', '2025-06-22 13:47:45', NULL, NULL, NULL),
	(7, 'PERDIDO', 'LIVRO', '2025-06-22 13:47:45', NULL, NULL, NULL),
	(8, 'DANIFICADO', 'LIVRO', '2025-06-22 13:47:45', NULL, NULL, NULL),
	(9, 'EM ANDAMENTO', 'EMPRÉSTIMO', '2025-06-22 13:47:45', NULL, NULL, NULL),
	(10, 'CONCLUIDO', 'EMPRÉSTIMO', '2025-06-22 13:47:45', NULL, NULL, NULL),
	(11, 'ATRASADO', 'EMPRÉSTIMO', '2025-06-22 13:47:45', NULL, NULL, NULL),
	(12, 'CANCELADO', 'EMPRÉSTIMO', '2025-06-22 13:47:45', NULL, NULL, NULL),
	(13, 'EM ANDAMENTO', 'RESERVA', '2025-06-22 13:47:45', NULL, NULL, NULL),
	(14, 'CONCLUIDA', 'RESERVA', '2025-06-22 13:47:45', NULL, NULL, NULL),
	(15, 'EXPIRADA', 'RESERVA', '2025-06-22 13:47:45', NULL, NULL, NULL),
	(16, 'CANCELADA', 'RESERVA', '2025-06-22 13:47:45', NULL, NULL, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.funcionario: ~3 rows (aproximadamente)
DELETE FROM `funcionario`;
INSERT INTO `funcionario` (`id`, `utilizador_fk`, `biblioteca_fk`, `criado_em`, `atualizado_em`, `ativo`, `criado_fk`, `atualizado_fk`) VALUES
	(21, 10, NULL, '2025-07-03 08:00:55', NULL, 'Y', NULL, NULL),
	(28, 52, 4, '2025-07-14 14:25:28', NULL, 'Y', NULL, NULL),
	(29, 77, 4, '2025-07-14 14:25:37', NULL, 'Y', NULL, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.livro: ~9 rows (aproximadamente)
DELETE FROM `livro`;
INSERT INTO `livro` (`id`, `titulo`, `isbn`, `ano_lancamento`, `sinopse`, `idioma`, `editora_fk`, `categoria_fk`, `subcategoria_fk`, `img_url`, `criado_fk`, `criado_em`, `atualizado_fk`, `atualizado_em`, `ativo`) VALUES
	(139, 'Clean Code: A Handbook of Agile Software Craftsmanship', '978-013235088', '2008', 'É um dos livros mais influentes na área de programação, focado em práticas para escrever código limpo, legível e sustentável.', 'Inglês', 1, 11, 1, '6870f03931d65_clean-code.jpg', 10, '2025-07-10 13:15:16', 10, '2025-07-13 10:44:24', 'Y'),
	(140, '1984', '978-0-123456-', '1949', 'Num mundo dominado por um governo tirânico, onde até os pensamentos são vigiados, Winston Smith começa a questionar o sistema. Uma das mais influentes obras do século XX sobre liberdade, verdade e manipulação.', 'Inglês', 1, 13, 3, '68752d9e35dd5_1984.jpg', 10, '2025-07-13 22:09:20', 77, '2025-07-14 16:17:34', 'Y'),
	(141, 'Sapiens: Uma Breve História da Humanidade', '978-0-234567-', '2011', 'Uma análise fascinante da evolução do Homo sapiens, desde o domínio da agricultura até à era digital. Harari explica como as ideias moldaram o mundo e continua a moldar a sociedade moderna.', 'Inglês', 1, 14, 4, '68742f4922d0b_Sapiens Uma Breve História da Humanidade.jpg', 10, '2025-07-13 22:12:25', NULL, NULL, 'Y'),
	(142, 'A Força do Hábito', '978-0-345678-', '2012', 'Por que fazemos o que fazemos? Este livro revela como os hábitos funcionam e como podem ser transformados para melhorar a vida pessoal e profissional.', 'Inglês', 1, 15, 5, '68742fc1a9530_A-Forca-do-Habito.jpg', 10, '2025-07-13 22:13:31', 10, '2025-07-13 22:14:25', 'Y'),
	(143, 'O Código Da Vinci', '978-0-456789-', '2003', 'Robert Langdon é arrastado para um mistério que envolve arte, religião e sociedades secretas. Cada pista desvenda um segredo mais chocante que o anterior.', 'Inglês', 1, 13, 6, '6874301081996_DaVinciCode.jpg', 10, '2025-07-13 22:15:44', NULL, NULL, 'Y'),
	(144, 'Princípios: Vida e Trabalho', '978-0-567890-', '2017', 'Dalio partilha os princípios que usou para criar uma das maiores empresas de investimentos do mundo, oferecendo orientações práticas para decisões pessoais e profissionais.', 'Inglês', 1, 16, 7, '68743069549df_Vida e Trabalho.jpg', 10, '2025-07-13 22:17:13', NULL, NULL, 'Y'),
	(145, 'Cem Anos de Solidão', '006-0883286', '1967', 'A saga da família Buendía na aldeia fictícia de Macondo, onde o fantástico e o real se misturam para criar um épico que atravessa várias gerações. Uma obra-prima do realismo mágico que explora temas como o tempo, a solidão e o destino.', 'Espanhol', 1, 20, 12, '6875246db349a_1507-1.jpg', 10, '2025-07-14 15:38:21', NULL, NULL, 'Y'),
	(146, 'Orgulho e Preconceito', '014-1439513', '0000', 'Retrata a vida e as relações da alta sociedade inglesa do século XIX através da história de Elizabeth Bennet e Mr. Darcy, destacando o orgulho, o preconceito e as tensões sociais.', 'Inglês', 1, 20, 13, '687524abca5f2_Orgulho-e-Preconceito.jpg', 10, '2025-07-14 15:39:23', NULL, NULL, 'Y'),
	(147, 'Os Irmãos Karamazov', '037-4528373', '0000', 'A história complexa de três irmãos e seu pai, explorando questões morais, religiosas e existenciais na Rússia do século XIX. Uma análise profunda da natureza humana e da fé.', 'Russo', 1, 20, 14, '687524fa66db6_1507-1 (1).jpg', 10, '2025-07-14 15:40:42', NULL, NULL, 'Y');

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
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.livro_localizacao: ~11 rows (aproximadamente)
DELETE FROM `livro_localizacao`;
INSERT INTO `livro_localizacao` (`id`, `livro_fk`, `localizacao_fk`, `quantidade`, `criado_fk`, `atualizado_fk`) VALUES
	(46, 139, 28, 3, NULL, NULL),
	(48, 141, 31, 3, NULL, NULL),
	(50, 144, 34, 3, NULL, NULL),
	(51, 140, 37, 4, NULL, NULL),
	(52, 147, 44, 5, NULL, NULL),
	(53, 142, 40, 5, NULL, NULL),
	(54, 145, 46, 5, NULL, NULL),
	(55, 143, 39, 5, NULL, NULL),
	(56, 146, 45, 6, NULL, NULL),
	(57, 144, 38, 5, NULL, NULL),
	(58, 141, 43, 1, NULL, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.localizacao: ~15 rows (aproximadamente)
DELETE FROM `localizacao`;
INSERT INTO `localizacao` (`id`, `cod_local`, `biblioteca_fk`, `criado_em`, `atualizado_em`, `ativo`, `criado_fk`, `atualizado_fk`) VALUES
	(28, 'TI-123', 5, '2025-07-11 11:22:09', NULL, 'N', NULL, NULL),
	(29, 'TESTE-LOC', 5, '2025-07-13 11:54:24', NULL, 'Y', NULL, NULL),
	(30, 'FI-DIS', 5, '2025-07-13 22:21:50', NULL, 'Y', NULL, NULL),
	(31, 'NF-HIS', 5, '2025-07-13 22:22:20', NULL, 'Y', NULL, NULL),
	(32, 'DP-PSI', 5, '2025-07-13 22:22:23', NULL, 'Y', NULL, NULL),
	(33, 'FI-THM', 5, '2025-07-13 22:22:30', NULL, 'Y', NULL, NULL),
	(34, 'NE-LF', 5, '2025-07-13 22:22:38', NULL, 'Y', NULL, NULL),
	(37, 'FI-DIS', 4, '2025-07-14 08:05:32', NULL, 'Y', NULL, NULL),
	(38, 'NE-LF', 4, '2025-07-13 22:22:38', NULL, 'Y', NULL, NULL),
	(39, 'FI-THM', 4, '2025-07-14 08:06:30', NULL, 'Y', NULL, NULL),
	(40, 'DP-PSI', 4, '2025-07-14 08:06:59', NULL, 'Y', NULL, NULL),
	(43, 'NF-HIS', 4, '2025-07-14 08:08:32', NULL, 'Y', NULL, NULL),
	(44, 'LT-RFO', 4, '2025-07-14 16:05:31', NULL, 'Y', NULL, NULL),
	(45, 'LT-RCO', 4, '2025-07-14 16:05:47', NULL, 'Y', NULL, NULL),
	(46, 'LT-RLM', 4, '2025-07-14 16:06:00', NULL, 'Y', NULL, NULL);

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
  `estado_fk` int(11) NOT NULL DEFAULT 13,
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
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.reserva: ~0 rows (aproximadamente)
DELETE FROM `reserva`;

-- A despejar estrutura para tabela empresta_facil.subcategoria
DROP TABLE IF EXISTS `subcategoria`;
CREATE TABLE IF NOT EXISTS `subcategoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_fk` int(11) NOT NULL,
  `subcategoria` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  `criado_em` timestamp NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `ativo` char(1) DEFAULT 'Y',
  `criado_fk` int(11) DEFAULT NULL,
  `atualizado_fk` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria_fk` (`categoria_fk`),
  KEY `fk_subcategoria_criado_fk` (`criado_fk`),
  KEY `fk_subcategoria_atualizado_fk` (`atualizado_fk`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.subcategoria: ~16 rows (aproximadamente)
DELETE FROM `subcategoria`;
INSERT INTO `subcategoria` (`id`, `categoria_fk`, `subcategoria`, `descricao`, `criado_em`, `atualizado_em`, `ativo`, `criado_fk`, `atualizado_fk`) VALUES
	(1, 11, 'Programação', 'Livros que ensinam linguagens como Java, Python, JavaScript, etc.', NULL, '2025-07-11 09:50:52', 'Y', 10, 10),
	(2, 11, 'Redes de Computadores', 'Livros sobre protocolos, infraestrutura de redes, segurança de redes, etc.', '2025-07-10 12:46:37', '2025-07-11 09:50:30', 'Y', 10, 10),
	(3, 13, 'Distopia', 'Obras que retratam sociedades futuristas e opressivas, geralmente com críticas sociais ou políticas.', '2025-07-13 21:53:17', NULL, 'Y', 52, NULL),
	(4, 14, 'História', 'Estudo das sociedades humanas ao longo do tempo, com base em factos documentados.', '2025-07-13 21:53:34', NULL, 'Y', 52, NULL),
	(5, 15, 'Psicologia Comportamental', 'Estudo de como os comportamentos humanos são formados, influenciados e modificados.', '2025-07-13 21:53:57', NULL, 'Y', 52, NULL),
	(6, 13, 'Thriller/Mistério', 'Histórias que envolvem suspense, enigmas e investigação, mantendo o leitor em tensão.', '2025-07-13 21:54:29', NULL, 'Y', 52, NULL),
	(7, 16, 'Liderança/Finanças', 'Foco em competências de liderança, gestão de equipas e inteligência financeira.', '2025-07-13 21:54:38', NULL, 'Y', 52, NULL),
	(8, 17, 'Romance Realista', ' ', '2025-07-14 15:19:24', NULL, 'Y', 10, NULL),
	(9, 18, 'Segunda Guerra Mundial', ' ', '2025-07-14 15:19:40', NULL, 'Y', 10, NULL),
	(10, 13, 'Fábula filosófica', ' ', '2025-07-14 15:19:57', NULL, 'Y', 10, NULL),
	(11, 19, 'Literatura Juvenil', ' ', '2025-07-14 15:20:13', NULL, 'Y', 10, NULL),
	(12, 20, 'Realismo Mágico', ' ', '2025-07-14 15:29:12', NULL, 'Y', 10, NULL),
	(13, 20, 'Romance Clássico', ' ', '2025-07-14 15:29:24', NULL, 'Y', 10, NULL),
	(14, 20, 'Romance Filosófico', ' ', '2025-07-14 15:29:36', NULL, 'Y', 10, NULL),
	(15, 20, 'Ficção Contemporânea', ' ', '2025-07-14 15:29:49', NULL, 'Y', 10, NULL),
	(16, 20, 'Ficção Distópica', ' ', '2025-07-14 15:30:00', NULL, 'Y', 10, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.tipo_utilizador: ~4 rows (aproximadamente)
DELETE FROM `tipo_utilizador`;
INSERT INTO `tipo_utilizador` (`id`, `tipo`, `descricao`, `criado_em`, `atualizado_em`, `ativo`, `criado_fk`, `atualizado_fk`) VALUES
	(4, 'Administrador', '', '2025-07-14 08:15:00', NULL, 'Y', NULL, NULL),
	(41, 'Gestor', '', '2025-07-14 08:15:05', NULL, 'Y', NULL, NULL),
	(42, 'Utilizador Comum', '', '2025-04-27 13:37:37', NULL, 'Y', NULL, NULL),
	(44, 'Funcionario', '', '2025-07-14 08:15:06', NULL, 'Y', NULL, NULL);

-- A despejar estrutura para tabela empresta_facil.utilizador
DROP TABLE IF EXISTS `utilizador`;
CREATE TABLE IF NOT EXISTS `utilizador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `primeiro_nome` varchar(100) NOT NULL,
  `ultimo_nome` varchar(100) NOT NULL,
  `data_nascimento` date NOT NULL,
  `nif` int(9) DEFAULT NULL COMMENT 'Formato padrão de NIF em Portugal',
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
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela empresta_facil.utilizador: ~3 rows (aproximadamente)
DELETE FROM `utilizador`;
INSERT INTO `utilizador` (`id`, `primeiro_nome`, `ultimo_nome`, `data_nascimento`, `nif`, `cc`, `genero`, `morada`, `telemovel`, `nome_utilizador`, `senha`, `email`, `img_url`, `tipo_utilizador_fk`, `criado_em`, `atualizado_em`, `ativo`, `criado_fk`, `atualizado_fk`) VALUES
	(10, 'admin', 'admin', '2004-12-17', 311404626, '', 'F', NULL, '3519278145', 'admin', '$2y$10$0e52qpYjkdbjX/erql4.LefWHdbIQiaRfulKgWG9gk.jzhuf0I5MK', 'admin@gmail.com', '6861b00e51e6a_Untitled.png', 4, '2025-04-27 13:59:42', NULL, 'Y', NULL, NULL),
	(52, 'funcionario', 'funcionario', '2005-12-02', 311566260, '19718579Z01P', 'M', NULL, '963446548', 'funcionario', '$2y$10$WmmbLLgZv8/bzxVrWBdK5OBjRcsobhzOTtQTGtDyRDu65vI.5P2RK', 'tiagomatx@gmail.com', NULL, 44, '2025-07-03 07:58:36', NULL, 'Y', NULL, NULL),
	(77, 'gestor', 'gestor', '2005-12-02', 311404626, '', 'M', NULL, '962193439', 'gestor', '$2y$10$k9qClh.t7il6RaL7/SDjRu1tewy/7tUk9FegFDDj7kfX2zvM5DexC', 'gestor@gmail.com', 'male-icon.jpg', 41, '2025-07-14 14:24:55', NULL, 'Y', NULL, NULL);

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

-- A despejar dados para tabela empresta_facil.utilizador_biblioteca: ~3 rows (aproximadamente)
DELETE FROM `utilizador_biblioteca`;
INSERT INTO `utilizador_biblioteca` (`utilizador_fk`, `biblioteca_fk`, `codigo_validacao`, `validado`, `data_pedido`, `data_expirado`, `data_validacao`) VALUES
	(10, 5, 'I089P6', 0, '2025-07-13', '2025-07-27', NULL),
	(52, 4, '3AG0PC', 0, '2025-07-14', '2025-07-28', NULL),
	(77, 4, 'PFBMLT', 1, '2025-07-14', '2025-07-28', '2025-07-14');

-- A despejar estrutura para disparador empresta_facil.atualizar_estado_reserva_apos_emprestimo
DROP TRIGGER IF EXISTS `atualizar_estado_reserva_apos_emprestimo`;
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER atualizar_estado_reserva_apos_emprestimo
AFTER INSERT ON emprestimo
FOR EACH ROW
BEGIN
    DECLARE v_id_concluido INT;

    -- Buscar o ID do estado 'CONCLUIDO' para reservas
    SELECT id INTO v_id_concluido
    FROM estado
    WHERE estado = 'CONCLUIDA' AND observacoes = 'RESERVA'
    LIMIT 1;

    -- Verificar se a reserva_fk foi informada
    IF NEW.reserva_fk IS NOT NULL THEN
        -- Atualizar o estado da reserva correspondente
        UPDATE reserva
        SET estado_fk = v_id_concluido
        WHERE id = NEW.reserva_fk;
    END IF;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

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

-- A despejar estrutura para disparador empresta_facil.trg_adiciona_quantidade_devolucao
DROP TRIGGER IF EXISTS `trg_adiciona_quantidade_devolucao`;
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER trg_adiciona_quantidade_devolucao
AFTER UPDATE ON emprestimo_livro
FOR EACH ROW
BEGIN
  -- Só adiciona se a devolução foi feita agora (antes estava null, agora tem valor)
  IF NEW.estado_devolucao_fk IS NOT NULL AND NEW.data_devolvido IS NOT NULL AND
     (OLD.estado_devolucao_fk IS NULL OR OLD.data_devolvido IS NULL) THEN
  
    UPDATE livro_localizacao
    SET quantidade = quantidade + 1
    WHERE id = NEW.livro_localizacao_fk;
  
  END IF;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- A despejar estrutura para disparador empresta_facil.trg_before_insert_user_imgurl
DROP TRIGGER IF EXISTS `trg_before_insert_user_imgurl`;
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER trg_before_insert_user_imgurl
BEFORE INSERT ON utilizador
FOR EACH ROW
BEGIN
    IF NEW.img_url IS NULL THEN
        IF NEW.genero = 'M' THEN
            SET NEW.img_url = 'male-icon.jpg';
        ELSEIF NEW.genero = 'F' THEN
            SET NEW.img_url = 'female-icon.jpg';
        END IF;
    END IF;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- A despejar estrutura para disparador empresta_facil.trg_subtrai_quantidade_emprestimo
DROP TRIGGER IF EXISTS `trg_subtrai_quantidade_emprestimo`;
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER trg_subtrai_quantidade_emprestimo
AFTER INSERT ON emprestimo_livro
FOR EACH ROW
BEGIN
  UPDATE livro_localizacao
  SET quantidade = quantidade - 1
  WHERE id = NEW.livro_localizacao_fk;
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
