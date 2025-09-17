-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Tempo de geração: 10/09/2025 às 21:12
-- Versão do servidor: 5.7.39
-- Versão do PHP: 8.2.0

SET SQL_MODE
= "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone
= "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `olympikus`--

--
-- Despejando dados para a tabela `segmentacao`--

SET FOREIGN_KEY_CHECKS = 0;

DELETE FROM `calendario`;


TRUNCATE TABLE `colors`;
TRUNCATE TABLE `product_numeracao`;
TRUNCATE TABLE `product_sizes`;
TRUNCATE TABLE `user_wishlists`;
TRUNCATE TABLE `caracteristicas_product`;

DELETE FROM `products`;
DELETE FROM `collections`;
DELETE FROM `categories`;

DELETE FROM `segmentacao`;

DELETE FROM `conteudo`;

DELETE FROM `conteudo_categories`;

INSERT INTO `segmentacao` (`id`,`segmento`, `image`, `image_mobile`, `slug`, `active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Calçados', 'images/segmentacao/1756832248.png', 'images/segmentacao/1756832248-mobile.png', 'calcados', 1, '2025-06-25 23:05:32', '2025-09-02 19:57:28', NULL),
(2, 'Vestuário e Acessórios', 'images/segmentacao/1756832261.png', 'images/segmentacao/1756832261-mobile.png', 'vestuario-e-acessorios', 1, '2025-06-25 23:07:16', '2025-09-02 19:57:41', NULL),
(3, 'Corre', 'images/segmentacao/1756832278.png', 'images/segmentacao/1756832278-mobile.png', 'corre', 1, '2025-06-25 23:08:14', '2025-09-02 19:57:58', NULL);


--
-- Despejando dados para a tabela `categories`--



INSERT INTO `categories` (`id`,`segmento_id`, `name`, `slug`, `active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Corrida', 'corrida', 1, '2025-06-26 19:00:38', '2025-06-26 19:07:27', NULL),
(2, 1, 'Treino', 'treino', 1, '2025-06-26 19:04:00', '2025-06-26 19:04:00', NULL),
(3, 1, 'Casual', 'casual', 1, '2025-06-26 19:04:11', '2025-06-26 19:09:26', NULL),
(4, 1, 'Chinelo', 'chinelo', 1, '2025-06-26 19:09:54', '2025-09-10 23:13:27', NULL),
(5, 1, 'Infantil', 'infantil', 1, '2025-06-26 19:10:03', '2025-06-26 19:10:03', NULL),
(6, 2, 'Corrida', 'corrida', 1, '2025-06-26 19:00:38', '2025-06-26 19:07:27', NULL),
(7, 2, 'Treino', 'treino', 1, '2025-06-26 19:04:00', '2025-06-26 19:04:00', NULL),
(8, 2, 'Casual', 'casual', 1, '2025-06-26 19:04:11', '2025-06-26 19:09:26', NULL),
(9, 1, 'Caminhada', 'caminhada', 1, '2025-09-10 23:13:12', '2025-09-10 23:13:12', NULL);

--
-- Despejando dados para a tabela `collections`--



INSERT INTO `collections` (`id`,`segmentacao_id`,`name`,`description`, `bg_color`,`codigo_colecao`, `image`, `slug`, `active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'SAPATARIA', 'Exclusivo Sapatarias', '#2735D4', '1S25', NULL, 'sapataria-1s25', 1, '2023-06-24 22:10:24', '2025-09-10 21:58:15', '2025-09-10 21:58:15'),
(3, 1, 'SAPATARIA', 'Exclusivo Sapatarias 2024', '#0a0a0a', '1S24', NULL, 'sapataria-1s24', 1, '2024-06-26 17:20:42', '2025-09-10 21:58:18', '2025-09-10 21:58:18'),
(4, 1, 'FAMÍLIA CORRE', 'FAMÍLIA CORRE', '#ffffff', '1S25', 'images/collections/1752598087.jpg', 'familia-corre-1s25', 1, '2024-07-15 19:48:07', '2025-09-10 21:58:20', '2025-09-10 21:58:20'),
(8, 2, 'VESTUÁRIO', 'Exclusivo Sapatarias', '#2735D4', '1S25', NULL, 'vestuario-sapataria-1s25', 1, '2025-06-24 22:10:24', '2025-09-10 21:58:22', '2025-09-10 21:58:22'),
(9, 2, 'VESTUÁRIO FAMÍLIA CORRE', 'FAMÍLIA CORRE', '#ffffff', '1S25', 'images/collections/1752598087.jpg', 'vestuario-familia-corre-1s25', 1, '2025-07-15 19:48:07', '2025-09-10 21:58:26', '2025-09-10 21:58:26'),
(10, 3, 'CORRE', 'Exclusivo Sapatarias', '#2735D4', '1S25', NULL, 'corre-1s25', 1, '2025-06-24 22:10:24', '2025-09-10 21:58:28', '2025-09-10 21:58:28'),
(11, 1, '2S25', 'Geral', '#ae0909', '2S25', NULL, '2s25-2s25', 1, '2025-09-10 20:51:24', '2025-09-10 21:00:14', NULL);

--
-- Despejando dados para a tabela `conteudo_categories`--



INSERT INTO `conteudo_categories` (`id`,`category`, `icon`, `order`, `active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Fotos/Vídeos', 'images/conteudos/1756323360.png', 1, 1, '2025-08-27 22:36:00', '2025-09-10 17:32:21', NULL),
(2, 'Manuais/Marca', 'images/conteudos/1756323372.png', 2, 1, '2025-08-27 22:36:12', '2025-09-10 17:32:06', NULL),
(3, 'Templates/Apresentações', 'images/conteudos/1756323398.png', 3, 1, '2025-08-27 22:36:38', '2025-09-10 17:32:29', NULL);

--
-- Despejando dados para a tabela `conteudo`--



INSERT INTO `conteudo` (`id`,`conteudo_category_id`, `name`, `link_url`, `description`, `order`, `active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Vídeo Lançamento Família Corre', 'https://google.com/', 'Descrição Lançamento Família Corre\r\nDescrição Lançamento Família Corre\r\nDescrição Lançamento Família Corre', 1, 1, '2025-08-27 22:38:22', '2025-08-27 22:39:02', NULL),
(2, 2, 'Manual de Marca 2025', 'https://google.com/', 'Descrição de Marca 2025\r\nDescrição de Marca 2025\r\nDescrição de Marca 2025\r\nDescrição de Marca 2025', 1, 1, '2025-08-27 22:40:47', '2025-08-27 22:40:47', NULL),
(3, 3, 'Template Apresentação 2025', 'https://www.google.com/', 'Descrição Apresentação 2025\r\nDescrição Apresentação 2025\r\nDescrição Apresentação 2025', 1, 1, '2025-08-27 22:41:17', '2025-08-27 22:41:17', NULL),
(4, 1, 'Vídeo Lançamento Família Corre', 'https://google.com/', 'Descrição Lançamento Família Corre\r\nDescrição Lançamento Família Corre\r\nDescrição Lançamento Família Corre', 2, 1, '2025-08-27 22:38:22', '2025-08-27 22:39:02', NULL),
(5, 2, 'Manual de Marca 2025', 'https://google.com/', 'Descrição de Marca 2025\r\nDescrição de Marca 2025\r\nDescrição de Marca 2025\r\nDescrição de Marca 2025', 2, 1, '2025-08-27 22:40:47', '2025-08-27 22:40:47', NULL),
(6, 3, 'Template Apresentação 2025', 'https://www.google.com/', 'Descrição Apresentação 2025\r\nDescrição Apresentação 2025\r\nDescrição Apresentação 2025', 2, 1, '2025-08-27 22:41:17', '2025-08-27 22:41:17', NULL),
(7, 1, 'Vídeo Lançamento Família Corre', 'https://google.com/', 'Descrição Lançamento Família Corre\r\nDescrição Lançamento Família Corre\r\nDescrição Lançamento Família Corre', 3, 1, '2025-08-27 22:38:22', '2025-08-27 22:39:02', NULL),
(8, 2, 'Manual de Marca 2025', 'https://google.com/', 'Descrição de Marca 2025\r\nDescrição de Marca 2025\r\nDescrição de Marca 2025\r\nDescrição de Marca 2025', 3, 1, '2025-08-27 22:40:47', '2025-08-27 22:40:47', NULL),
(9, 3, 'Template Apresentação 2025', 'https://www.google.com/', 'Descrição Apresentação 2025\r\nDescrição Apresentação 2025\r\nDescrição Apresentação 2025', 3, 1, '2025-08-27 22:41:17', '2025-08-27 22:41:17', NULL),
(10, 1, 'Vídeo Lançamento Família Corre', 'https://google.com/', 'Descrição Lançamento Família Corre\r\nDescrição Lançamento Família Corre\r\nDescrição Lançamento Família Corre', 4, 1, '2025-08-27 22:38:22', '2025-08-27 22:39:02', NULL),
(11, 2, 'Manual de Marca 2025', 'https://google.com/', 'Descrição de Marca 2025\r\nDescrição de Marca 2025\r\nDescrição de Marca 2025\r\nDescrição de Marca 2025', 4, 1, '2025-08-27 22:40:47', '2025-08-27 22:40:47', NULL),
(12, 3, 'Template Apresentação 2025', 'https://www.google.com/', 'Descrição Apresentação 2025\r\nDescrição Apresentação 2025\r\nDescrição Apresentação 2025', 4, 1, '2025-08-27 22:41:17', '2025-08-27 22:41:17', NULL);


--
-- Despejando dados para a tabela `numeracao`--

TRUNCATE TABLE `numeracao`;

INSERT INTO `numeracao` (`id`,`numero`, `active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '28/36', 1, '2025-07-21 19:25:33', '2025-07-21 19:26:45', NULL),
(2, '33/44', 1, '2025-07-21 19:27:03', '2025-07-21 19:27:03', NULL),
(3, '34/45', 1, '2025-07-21 19:27:10', '2025-07-21 19:27:10', NULL),
(4, '34/44', 1, '2025-07-21 19:27:18', '2025-07-21 19:27:18', NULL),
(5, '37/44', 1, '2025-07-21 19:27:25', '2025-07-21 19:27:25', NULL),
(6, '34/41', 1, '2025-07-21 19:27:31', '2025-07-21 19:27:31', NULL),
(7, '34/48', 1, '2025-07-21 19:27:38', '2025-07-21 19:27:38', NULL),
(8, '36/44', 1, '2025-07-21 19:27:45', '2025-07-22 18:43:07', NULL),
(9, '33/34 a 43/44', 1, '2025-07-21 19:27:52', '2025-07-21 19:27:52', NULL),
(10, '35/48', 1, '2025-09-10 23:16:45', '2025-09-10 23:16:45', NULL),
(11, '35/44', 1, '2025-09-10 23:17:29', '2025-09-10 23:17:29', NULL);

--
-- Despejando dados para a tabela `sizes`--

DELETE FROM `sizes`;

INSERT INTO `sizes` (`id`,`size`, `active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'PP', 1, '2025-07-21 18:57:30', '2025-07-21 19:01:59', NULL),
(2, 'P', 1, '2025-07-21 19:02:04', '2025-07-21 19:02:04', NULL),
(3, 'M', 1, '2025-07-21 19:02:15', '2025-07-21 19:02:15', NULL),
(4, 'G', 1, '2025-07-21 19:02:18', '2025-07-21 19:02:18', NULL),
(5, 'GG', 1, '2025-07-21 19:02:22', '2025-07-21 19:02:22', NULL),
(6, '2GG', 1, '2025-07-21 19:02:33', '2025-07-21 19:02:33', NULL),
(7, '3GG', 1, '2025-07-21 19:02:44', '2025-07-21 19:02:44', NULL),
(8, 'Ú', 1, '2025-07-21 19:03:01', '2025-07-21 19:03:01', NULL);
COMMIT;


DELETE FROM `flag_product`;

INSERT INTO `flag_product` (`id`,`flag_title`,`flag_description`, `flag_bg`, `flag_color_text_bg`, `icon`, `alinhamento`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Cor nova', 'cor nova', '#2735d4', '#ffffff', NULL, 'left', 1, '2025-07-02 23:16:50', '2025-07-02 23:19:42', NULL),
(2, 'Continuidade', 'Continuidade', '#cccccc', '#FFFFFF', NULL, 'left', 1, '2025-07-02 23:45:43', '2025-07-02 23:45:43', NULL),
(3, 'Exclusivo Netshoes', 'Exclusivo Netshoes', '#000000', '#000000', 'images/flags/1757020984_68ba033866011.png', 'right', 1, '2025-09-05 00:23:04', '2025-09-05 00:23:04', NULL),
(4, 'Authentic Feet', 'Authentic Feet', '#000000', '#000000', 'images/flags/1757537727_68c1e5bf9e1a4.png', 'right', 1, '2025-09-10 23:55:27', '2025-09-10 23:55:27', NULL);
COMMIT;




INSERT INTO `products` (`id`, `name`, `description`, `code`, `sku`, `price`, `slug`, `category_id`, `technologies`, `flag_calendario`, `data_mkt`, `data_trade`, `data_cliente`, `data_dtc`, `active`, `created_at`, `updated_at`, `deleted_at`) VALUES

(27, 'CORRE SUPRA2', 'A segunda edição do Olympikus Corre Supra chega para entregar ainda mais desempenho nas ruas. Tecnologia Oxitec 4.0, que permite maior respirabilidade, \r\nresistência e leveza. Lingueta macia e leve ao toque feita em Eco Suede com perfuros. Atacador aprimorado para garantir um ajuste mais preciso e seguro na \r\namarração. Forro interno confeccionado em mescla de poliéster e elastano, trazendo mais conforto, durabilidade e flexibilidade. Puxador traseiro em fita para \r\nfacilitar o calce. Palmilha NT-X 2mm, gerando leveza e mais energia a cada passada. Solado NT-X 2 PRO, que proporciona maior amortecimento e alto nível \r\nde resiliência e leveza, além de um baixo nível de deformação. Tecnologia CARBON-G para aumentar a eficiência na impulsão e na estabilização. Borracha \r\nantiderrapante Michelin, que proporciona maior resistência. Com drop de 6mm, o modelo equilibra conforto e desempenho, ideal para corridas de alta \r\nperformance.', '43777397', '43777397', '1299.99', 'corre-supra2', 1, '[\"1\",\"2\",\"3\",\"10\"]', '1', '2025-08-01 00:00:00', '2025-08-01 00:00:00', '2025-08-01 00:00:00', '2025-08-01 00:00:00', 1, '2025-09-10 20:59:44', '2025-09-10 20:59:44', NULL),
(28, 'PRIDE 4', 'Projetado para corridas intensas, o Olympikus PRIDE chega em sua quarta edição com diversas novidades. Entressola com tecnologia Eleva Pro 2.0, garantindo\r\nmaior resiliência, conforto e responsividade. Solado com tecnologia Gripper, altamente durável, resistente e antiderrapante. Palmilha em EVA que oferece maior\r\nrespirabilidade e um encaixe perfeito para os pés. Atacador em poliéster texturizado. Puxador traseiro em fita para auxiliar no calce. Gáspea produzida com\r\ntecido giro inglês, uma tecnologia inovadora e flexível, que conta com fios de TPU e TPE para oferecer maior resistência, leveza e um toque macio. Logo em TPU\r\ncom detalhes de pintura e laminado feitos com a tecnologia high frequency, um material diferenciado de espessura mínima. Lingueta em tecido duplo frontura +\r\nespuma e interior produzido em poliéster, oferecendo conforto ao caminhar.', '43561394', '43561394', '399.99', 'pride-4', 1, '[\"1\",\"2\"]', '1', '2025-06-16 00:00:00', '2025-06-16 00:00:00', '2025-06-16 00:00:00', '2025-06-16 00:00:00', 1, '2025-09-10 21:22:05', '2025-09-10 21:22:05', NULL),
(29, 'QUADRA BR1', 'Co-criado junto com um dos maiores jogadores da história do vôlei mundial, Bruno Rezende, o Olympikus QU4DRA BR1 é uma expressão de excelência, paixão\r\ne legado para quem vive as 4 linhas. Possui tecnologia Eleva Pro 2.0, que proporciona leveza e amortecimento, trazendo maior conforto e efeito trampolim.\r\nConta também com borracha antiderrapante Gripper, que mantém aderência firme ao solo. O solado apresenta design em curvas e linhas orgânicas, evitando\r\no desgaste e garantindo maior segurança nas mudanças de direções em quadra. Já o cabedal confeccionado em poliéster envolve o tornozelo com mais\r\nsegurança e suporte. As tramas mais espaçadas permitem maior respirabilidade dos pés para maior conforto. Sua palmilha anatômica moldada é composta por\r\ntecido poliéster e EVA com 4mm de espessura, adaptando-se ao pé para evitar o deslizamento. O forro possui tecido respirável que se molda ao pé como uma\r\nmeia, pois é unido a lingueta, o que resulta num alto ajuste e maior sensação de conforto. Apresenta puxador traseiro que auxilia no calce e puxador frontal\r\nque ajuda na disposição dos atacadores. Além disso, seu atacador em tecido poliéster e com textura diferenciada, proporciona uma amarração superior e mais\r\nsegura.', '43391327', '43391327', '499.99', 'quadra-br1', 2, '[\"1\",\"2\"]', '1', '2025-07-08 00:00:00', '2025-07-08 00:00:00', '2025-07-08 00:00:00', '2025-07-08 00:00:00', 1, '2025-09-10 21:28:45', '2025-09-10 21:28:45', NULL),
(30, 'TREINO', 'Ideal para quem busca estilo e leveza nos treinos. Conta com a tecnologia de amortecimento EVASENSE, que proporciona mais leveza, maciez e flexibilidade \r\nnas passadas. Cabedal em poliéster com impressão digital e tecnologia HIGH FREQUENCY, logo em TPU, além de pintura e detalhes em laminado. Lingueta \r\nconfortável, produzida em poliéster e espuma. Puxador em fita com arte gráfica e atacador em poliéster texturizado. Puxador traseiro em fita com arte gráfica \r\npara facilitar o calce. Forro em tecido Poliéster com espuma, para maior conforto ao caminhar. Palmilha em poliéster e EVA com aplicação gráfica. Solado em \r\nborracha antiderrapante com tecnologia GRIPPER, que oferece maior durabilidade e resistência.', '43210417', '43210417', '399.99', 'treino', 2, '[\"1\",\"2\"]', '1', '2025-04-29 00:00:00', '2025-04-29 00:00:00', '2025-04-29 00:00:00', '2025-04-29 00:00:00', 1, '2025-09-10 23:02:38', '2025-09-10 23:02:38', NULL),
(31, 'PASSO', 'Ideal para quem busca estilo e conforto nas corridas. Cabedal com tecnologia HYPERSOX, que facilita o calce e oferece melhor caimento, conforto e maciez. \r\nVistas em laminado e TPU com pintura e detalhes em tecnologia HIGH FREQUENCY. Lingueta em tecido dupla frontura com alta capacidade de transpiração, \r\nalém de etiqueta em fita gráfica. Atacador em poliéster chato texturizado. Forro em poliéster canelado com espuma, garantindo maior conforto ao caminhar. \r\nPuxador traseiro em fita texturizada para facilitar o calce. Palmilha em poliéster e EVA com aplicação gráfica. Solado com design exclusivo e tecnologia ELEVA+, \r\nque aprimora a resiliência, leveza e conforto do modelo.', '43242437', '43242437', '279.99', 'passo', 9, '[\"1\",\"2\"]', '1', '2025-08-13 00:00:00', '2025-08-13 00:00:00', '2025-08-13 00:00:00', '2025-08-13 00:00:00', 1, '2025-09-10 23:09:27', '2025-09-10 23:30:39', NULL),
(32, 'NIVEL', 'A combinação perfeita entre leveza e flexibilidade. Tecnologia HYPERSOX, com estrutura que facilita o calce e oferece melhor caimento, conforto e maciez. \r\nVistas em laminado e TPU com pinturas que levam a tecnologia HIGH FREQUENCY. Lingueta em dupla frontura e etiqueta com arte gráfica em high frequency. \r\nAtacador em poliéster redondo bicolor texturizado. Forro em poliéster com espuma, que proporciona maior conforto ao caminhar. Puxador traseiro em fita \r\ntexturizada para melhor auxílio no calce. Palmilha composta por poliéster e EVA, com aplicação gráfica. Tecnologia de amortecimento EVASENSE, em um único \r\nbloco de EVA, que proporciona maior leveza, maciez e flexibilidade nas passadas.', '43211421', '43211421', '249.99', 'nivel', 9, '[\"1\",\"2\"]', '1', '2025-06-05 00:00:00', '2025-06-05 00:00:00', '2025-06-05 00:00:00', '2025-06-05 00:00:00', 1, '2025-09-10 23:15:23', '2025-09-10 23:30:46', NULL),
(33, 'EASY 3', 'Em sua terceira edição, o Olympikus EASY é a escolha ideal para quem busca leveza a cada passada. Cabedal com mescla de tecido bicolor e parte traseira em \r\npoliéster texturizado. Elástico no cabedal que ressalta a marca. Etiqueta em laminado com arte gráfica. Forro em poliéster com espuma, para maior conforto \r\nao caminhar. Puxador traseiro em fita texturizada para melhor auxílio no calce. Palmilha composta por poliéster e espuma, com aplicação gráfica. Tecnologia \r\nEVASENSE de amortecimento, em um único bloco de EVA, que proporciona maior leveza, maciez e flexibilidade nas passadas.', '43609415', '43609415', '229.99', 'easy-3', 3, '[\"1\"]', '1', '2025-05-10 00:00:00', '2025-05-10 00:00:00', '2025-05-10 00:00:00', '2025-05-10 00:00:00', 1, '2025-09-10 23:29:23', '2025-09-10 23:29:23', NULL),
(34, 'VERSA', 'O Olympikus Versa é um tênis clássico que nunca sai de moda, perfeito para quem busca mais estilo e conforto para o dia a dia. O seu solado tem o tradicional\r\nvisual de sola caixa e possui a Tecnologia Evasense, que proporciona conforto e amortecimento. Conta também com a tecnologia Gripper, uma borracha\r\nantiderrapante que aumenta a resistência à abrasão e proporciona maior aderência e segurança. Já o cabedal é feito em laminado sintético texturizado e conta\r\ncom detalhes como a costura dupla, costura zigue e perfuros laterais distribuídos na gáspea. Possui ainda forro em poliéster com espuma, e palmilha plana\r\ncomposta por tecido poliéster e EVA, com aplicação gráfica.', '43752263', '43752263', '259.99', 'versa', 8, '[\"1\",\"10\"]', '1', '2025-03-20 00:00:00', '2025-03-20 00:00:00', '2025-03-20 00:00:00', '2025-03-20 00:00:00', 1, '2025-09-10 23:35:10', '2025-09-10 23:39:53', NULL),
(35, 'ACQUA INFANTIL', 'Cabedal em tecido jacquard com detalhes que combinam resistência e versatilidade. Vistas em laminado e TPU com tecnologia HIGH FREQUENCY. Lingueta \r\nconfortável, com combinação de poliéster e espuma. Atacador em poliéster oval texturizado. Forro em poliéster com espuma, para maior conforto ao caminhar. \r\nPuxador traseiro em fita, para auxiliar no calce. Palmilha composta por poliéster e EVA, com aplicação gráfica. Tecnologia ELEVA+, que melhora a resiliência, \r\nleveza e conforto do modelo.', '43306412', '43306412', '199.99', 'acqua-infantil', 9, '[\"1\",\"2\"]', '1', '2025-08-28 00:00:00', '2025-08-28 00:00:00', '2025-08-28 00:00:00', '2025-08-28 00:00:00', 1, '2025-09-10 23:39:28', '2025-09-10 23:39:28', NULL),
(36, 'VENUM 2 INFANTIL', 'Em sua segunda edição, o Olympikus VENUM INFANTIL se destaca pela tecnologia COVERGRID no cabedal, que proporciona maior proteção, resistência e durabilidade. \r\nLogo com pintura que dá destaque ao conjunto, criando efeito visual em 3D que muda conforme o movimento da passada. Lingueta em dupla frontura, com alta \r\ncapacidade de transpiração, e etiqueta minimalista em high frequency. Atacador em poliéster texturizado com efeito pontilhado. Puxador traseiro em fita para facilitar \r\no calce. Forro em tecido Poliéster com espuma, para maior conforto ao caminhar. Palmilha composta por poliéster e EVA, com aplicação gráfica. Tecnologia EVASENSE \r\nde amortecimento, em um único bloco de EVA, que proporciona maior leveza, maciez e flexibilidade nas passadas. Visual com cavidades nas laterais oferece aspecto \r\ncontemporâneo e estrutura funcional ao modelo. Superfície plantar com componentes distribuídos, que garantem máxima flexão e aderência ao solo.', '43284434', '43284434', '199.99', 'venum-2-infantil', 9, '[\"1\",\"2\"]', '1', '2025-07-17 00:00:00', '2025-07-17 00:00:00', '2025-07-17 00:00:00', '2025-07-17 00:00:00', 1, '2025-09-10 23:47:26', '2025-09-10 23:47:26', NULL),
(37, 'LIVRE', '\"O LIVRE é a escolha ideal para quem busca conforto e descanso para os pés. Tiras em PVC com aplicação do logotipo. Palmilha e solado em EVA. Borracha \r\nantiderrapante com tecnologia GRIPPER, que proporciona maior durabilidade e resistência.', '54110438', '54110438', '99.99', 'livre', 4, '[\"1\"]', '1', '2025-07-10 00:00:00', '2025-07-10 00:00:00', '2025-07-10 00:00:00', '2025-07-10 00:00:00', 1, '2025-09-10 23:53:40', '2025-09-10 23:53:40', NULL),
(38, 'CORRE MAX', 'Graças à extrema leveza resultante de nossa mais recente tecnologia, o Olympikus Corre Max oferece um desempenho superior e um conforto incomparável \r\ndurante as corridas. Sua entressola possui a tecnologia Eleva Pro Max, que melhora os índices de resiliência, leveza, conforto e responsividade. Conta também \r\ncom a tecnologia Gripper, que garante contato firme com o chão. Seu desenho curvilíneo com pontos de contato distribuídos em seções favorecem a flexão e \r\naderência. Apresenta cabedal e lingueta confeccionados em dupla frontura Jacquard, utilizando fio de poliéster texturizado no enchimento para proporcionar \r\nconforto, mobilidade e respirabilidade. Além disso, seu logo é aplicado em high frequency e seu atacador é composto por tecido de poliéster texturizado, \r\ngarantindo uma amarração precisa e confortável. Já o forro é confeccionado com uma mistura de poliéster, elastano e espuma, oferecendo alta permeabilidade. \r\nConta ainda com palmilha de Ortholite 6mm conformada, complementada por tecido de poliéster, proporcionando ótimo ajuste.', '43758365', '43758365', '549.99', 'corre-max', 1, '[\"1\",\"2\"]', '1', '2025-07-30 00:00:00', '2025-07-30 00:00:00', '2025-07-30 00:00:00', '2025-07-30 00:00:00', 1, '2025-09-11 00:00:26', '2025-09-11 00:00:26', NULL);

--
-- Despejando dados para a tabela `colors`--


INSERT INTO `colors` (`id`, `color_name`, `color_description`, `color_code`, `product_id`, `collection_id`, `flag_product_id`, `is_new`, `active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(314, 'AREOLY', 'Arenito/Olympian', 'AREOLY', 27, 11, 1, 0, 1, '2025-09-10 20:59:44', '2025-09-10 21:00:47', '2025-09-10 21:00:47'),
(315, 'ARESOL', 'Arenito/Solar', 'ARESOL', 27, 11, 1, 0, 1, '2025-09-10 20:59:44', '2025-09-10 21:00:47', '2025-09-10 21:00:47'),
(316, 'RYLVRD', 'Royal/Verde', 'RYLVRD', 27, 11, 1, 0, 1, '2025-09-10 20:59:44', '2025-09-10 21:00:47', '2025-09-10 21:00:47'),
(317, 'AREOLY', 'Arenito/Olympian', 'AREOLY', 27, 11, 1, 0, 1, '2025-09-10 21:00:47', '2025-09-10 21:10:44', '2025-09-10 21:10:44'),
(318, 'ARESOL', 'Arenito/Solar', 'ARESOL', 27, 11, 1, 0, 1, '2025-09-10 21:00:47', '2025-09-10 21:10:44', '2025-09-10 21:10:44'),
(319, 'RYLVRD', 'Royal/Verde', 'RYLVRD', 27, 11, 1, 0, 1, '2025-09-10 21:00:47', '2025-09-10 21:10:44', '2025-09-10 21:10:44'),
(320, 'AREOLY', 'Arenito/Olympian', 'AREOLY', 27, 11, 1, 0, 1, '2025-09-10 21:10:44', '2025-09-10 23:17:53', '2025-09-10 23:17:53'),
(321, 'ARESOL', 'Arenito/Solar', 'ARESOL', 27, 11, 1, 0, 1, '2025-09-10 21:10:44', '2025-09-10 23:17:53', '2025-09-10 23:17:53'),
(322, 'RYLVRD', 'Royal/Verde', 'RYLVRD', 27, 11, 1, 0, 1, '2025-09-10 21:10:44', '2025-09-10 23:17:53', '2025-09-10 23:17:53'),
(323, 'Branco/Olympian', 'Branco/Olympian', 'BCOOLY', 28, 11, 1, 0, 1, '2025-09-10 21:22:05', '2025-09-10 21:22:05', NULL),
(324, 'Arenito/Multi', 'Arenito/Multi', 'ARENML', 28, 11, 1, 0, 1, '2025-09-10 21:22:05', '2025-09-10 21:22:05', NULL),
(325, 'Preto/Chumbo', 'Preto/Chumbo', 'PTO/CH', 28, 11, 1, 0, 1, '2025-09-10 21:22:05', '2025-09-10 21:22:05', NULL),
(326, 'Mist', 'Mist', 'MIST', 28, 11, 1, 0, 1, '2025-09-10 21:22:05', '2025-09-10 21:22:05', NULL),
(327, 'Petroleo/Solar', 'Petroleo/Solar', 'PTLSLR', 28, 11, 1, 0, 1, '2025-09-10 21:22:05', '2025-09-10 21:22:05', NULL),
(328, 'Chumbo/Arenito', 'Chumbo/Arenito', 'CHBARE', 29, 11, 1, 0, 1, '2025-09-10 21:28:45', '2025-09-10 23:16:59', '2025-09-10 23:16:59'),
(329, 'Arenito/Olympian', 'Arenito/Olympian', 'AREOLY', 29, 11, 1, 0, 1, '2025-09-10 21:28:45', '2025-09-10 23:16:59', '2025-09-10 23:16:59'),
(330, 'Preto/Chumbo', 'Preto/Chumbo', 'PTO/CH', 30, 11, 1, 0, 1, '2025-09-10 23:02:38', '2025-09-10 23:03:27', '2025-09-10 23:03:27'),
(331, 'Militar/Preto', 'Militar/Preto', 'MLT/PT', 30, 11, 1, 0, 1, '2025-09-10 23:02:38', '2025-09-10 23:03:27', '2025-09-10 23:03:27'),
(332, 'Branco/Preto', 'Branco/Preto', 'BCOPTO', 30, 11, 1, 0, 1, '2025-09-10 23:02:38', '2025-09-10 23:03:27', '2025-09-10 23:03:27'),
(333, 'Arenito/Lilas', 'Arenito/Lilas', 'ARELLS', 30, 11, 1, 0, 1, '2025-09-10 23:02:38', '2025-09-10 23:03:27', '2025-09-10 23:03:27'),
(334, 'Preto/Chumbo', 'Preto/Chumbo', 'PTO/CH', 30, 11, 1, 0, 1, '2025-09-10 23:03:27', '2025-09-10 23:03:27', NULL),
(335, 'Militar/Preto', 'Militar/Preto', 'MLT/PT', 30, 11, 1, 0, 1, '2025-09-10 23:03:27', '2025-09-10 23:03:27', NULL),
(336, 'Branco/Preto', 'Branco/Preto', 'BCOPTO', 30, 11, 1, 0, 1, '2025-09-10 23:03:27', '2025-09-10 23:03:27', NULL),
(337, 'Arenito/Lilas', 'Arenito/Lilas', 'ARELLS', 30, 11, 1, 0, 1, '2025-09-10 23:03:27', '2025-09-10 23:03:27', NULL),
(338, 'Chumbo/Preto', 'Chumbo/Preto', 'CHB/PT', 31, 11, 1, 0, 1, '2025-09-10 23:09:27', '2025-09-10 23:30:39', '2025-09-10 23:30:39'),
(339, 'Elderme/Ameixa', 'Elderme/Ameixa', 'ELDAME', 31, 11, 1, 0, 1, '2025-09-10 23:09:27', '2025-09-10 23:30:39', '2025-09-10 23:30:39'),
(340, 'Preto/Preto', 'Preto/Preto', 'PTO/PT', 31, 11, 1, 0, 1, '2025-09-10 23:09:27', '2025-09-10 23:30:39', '2025-09-10 23:30:39'),
(341, 'Algodão/Dusty', 'Algodão/Dusty', 'ALGDST', 31, 11, 1, 0, 1, '2025-09-10 23:09:27', '2025-09-10 23:30:39', '2025-09-10 23:30:39'),
(342, 'Cinza/Steel', 'Cinza/Steel', 'CZASTE', 31, 11, 1, 0, 1, '2025-09-10 23:09:27', '2025-09-10 23:30:39', '2025-09-10 23:30:39'),
(343, 'Arenito/Marfim', 'Arenito/Marfim', 'ARTMRF', 31, 11, 1, 0, 1, '2025-09-10 23:09:27', '2025-09-10 23:30:39', '2025-09-10 23:30:39'),
(344, 'Chumbo/Verde', 'Chumbo/Verde', 'CHB/VD', 32, 11, 1, 0, 1, '2025-09-10 23:15:23', '2025-09-10 23:30:46', '2025-09-10 23:30:46'),
(345, 'Preto/Preto', 'Preto/Preto', 'PTO/PT', 32, 11, 1, 0, 1, '2025-09-10 23:15:23', '2025-09-10 23:30:46', '2025-09-10 23:30:46'),
(346, 'Marinho/Dourado', 'Marinho/Dourado', 'MRHDRD', 32, 11, 1, 0, 1, '2025-09-10 23:15:23', '2025-09-10 23:30:46', '2025-09-10 23:30:46'),
(347, 'Arenito/Chumbo', 'Arenito/Chumbo', 'ARECHB', 32, 11, 1, 0, 1, '2025-09-10 23:15:23', '2025-09-10 23:30:46', '2025-09-10 23:30:46'),
(348, 'Chumbo/Arenito', 'Chumbo/Arenito', 'CHBARE', 29, 11, 1, 0, 1, '2025-09-10 23:16:59', '2025-09-10 23:16:59', NULL),
(349, 'Arenito/Olympian', 'Arenito/Olympian', 'AREOLY', 29, 11, 1, 0, 1, '2025-09-10 23:16:59', '2025-09-10 23:16:59', NULL),
(350, 'AREOLY', 'Arenito/Olympian', 'AREOLY', 27, 11, 1, 0, 1, '2025-09-10 23:17:53', '2025-09-10 23:17:53', NULL),
(351, 'ARESOL', 'Arenito/Solar', 'ARESOL', 27, 11, 1, 0, 1, '2025-09-10 23:17:53', '2025-09-10 23:17:53', NULL),
(352, 'RYLVRD', 'Royal/Verde', 'RYLVRD', 27, 11, 1, 0, 1, '2025-09-10 23:17:53', '2025-09-10 23:17:53', NULL),
(353, 'Mescla/Stone', 'Mescla/Stone', 'MCSTON', 33, 11, 1, 0, 1, '2025-09-10 23:29:23', '2025-09-10 23:29:23', NULL),
(354, 'Mescla/Preto/Preto', 'Mescla/Preto/Preto', 'MCPTPT', 33, 11, 1, 0, 1, '2025-09-10 23:29:23', '2025-09-10 23:29:23', NULL),
(355, 'Mescla/Preto', 'Mescla/Preto', 'MC/PTO', 33, 11, 1, 0, 1, '2025-09-10 23:29:23', '2025-09-10 23:29:23', NULL),
(356, 'Mescla/Vanguarda', 'Mescla/Vanguarda', 'MCVANG', 33, 11, 1, 0, 1, '2025-09-10 23:29:23', '2025-09-10 23:29:23', NULL),
(357, 'Chumbo/Preto', 'Chumbo/Preto', 'CHB/PT', 31, 11, 1, 0, 1, '2025-09-10 23:30:39', '2025-09-10 23:30:39', NULL),
(358, 'Elderme/Ameixa', 'Elderme/Ameixa', 'ELDAME', 31, 11, 1, 0, 1, '2025-09-10 23:30:39', '2025-09-10 23:30:39', NULL),
(359, 'Preto/Preto', 'Preto/Preto', 'PTO/PT', 31, 11, 1, 0, 1, '2025-09-10 23:30:39', '2025-09-10 23:30:39', NULL),
(360, 'Algodão/Dusty', 'Algodão/Dusty', 'ALGDST', 31, 11, 1, 0, 1, '2025-09-10 23:30:39', '2025-09-10 23:30:39', NULL),
(361, 'Cinza/Steel', 'Cinza/Steel', 'CZASTE', 31, 11, 1, 0, 1, '2025-09-10 23:30:39', '2025-09-10 23:30:39', NULL),
(362, 'Arenito/Marfim', 'Arenito/Marfim', 'ARTMRF', 31, 11, 1, 0, 1, '2025-09-10 23:30:39', '2025-09-10 23:30:39', NULL),
(363, 'Chumbo/Verde', 'Chumbo/Verde', 'CHB/VD', 32, 11, 1, 0, 1, '2025-09-10 23:30:46', '2025-09-10 23:30:46', NULL),
(364, 'Preto/Preto', 'Preto/Preto', 'PTO/PT', 32, 11, 1, 0, 1, '2025-09-10 23:30:46', '2025-09-10 23:30:46', NULL),
(365, 'Marinho/Dourado', 'Marinho/Dourado', 'MRHDRD', 32, 11, 1, 0, 1, '2025-09-10 23:30:46', '2025-09-10 23:30:46', NULL),
(366, 'Arenito/Chumbo', 'Arenito/Chumbo', 'ARECHB', 32, 11, 1, 0, 1, '2025-09-10 23:30:46', '2025-09-10 23:30:46', NULL),
(367, 'Preto/Preto', 'Preto/Preto', 'PTO/PT', 34, 11, 1, 0, 1, '2025-09-10 23:35:10', '2025-09-10 23:35:21', '2025-09-10 23:35:21'),
(368, 'Preto/Preto', 'Preto/Preto', 'PTO/PT', 34, 11, 1, 0, 1, '2025-09-10 23:35:21', '2025-09-10 23:39:53', '2025-09-10 23:39:53'),
(369, 'Chumbo/Organza', 'Chumbo/Organza', 'CHBORG', 35, 11, 1, 0, 1, '2025-09-10 23:39:28', '2025-09-10 23:39:28', NULL),
(370, 'Marinho/Cristal', 'Marinho/Cristal', 'MRHDRD', 35, 11, 1, 0, 1, '2025-09-10 23:39:28', '2025-09-10 23:39:28', NULL),
(371, 'Arenito', 'Arenito', 'ARENIT', 35, 11, 1, 0, 1, '2025-09-10 23:39:28', '2025-09-10 23:39:28', NULL),
(372, 'Preto', 'Preto', 'PRETO', 35, 11, 1, 0, 1, '2025-09-10 23:39:28', '2025-09-10 23:39:28', NULL),
(373, 'Preto/Preto', 'Preto/Preto', 'PTO/PT', 34, 11, 1, 0, 1, '2025-09-10 23:39:53', '2025-09-10 23:39:53', NULL),
(374, 'Preto/Chumbo', 'Preto/Chumbo', 'PTO/CH', 36, 11, 1, 0, 1, '2025-09-10 23:47:26', '2025-09-10 23:47:26', NULL),
(375, 'Preto/Preto', 'Preto/Preto', 'PTO/PT', 36, 11, 1, 0, 1, '2025-09-10 23:47:26', '2025-09-10 23:47:26', NULL),
(376, 'Chumbo/Preto', 'Chumbo/Preto', 'CHB/PT', 36, 11, 1, 0, 1, '2025-09-10 23:47:26', '2025-09-10 23:47:26', NULL),
(377, 'Preto', 'Preto', 'PRETO', 37, 11, 1, 0, 1, '2025-09-10 23:53:40', '2025-09-10 23:53:40', NULL),
(378, 'Azul Claro', 'Azul Claro', 'AZL/CL', 37, 11, 1, 0, 1, '2025-09-10 23:53:40', '2025-09-10 23:53:40', NULL),
(379, 'Verde Militar', 'Verde Militar', 'VDEMLT', 37, 11, 1, 0, 1, '2025-09-10 23:53:40', '2025-09-10 23:53:40', NULL),
(380, 'Preto/Madeira', 'Preto/Madeira', 'PTOMAD', 37, 11, 1, 0, 1, '2025-09-10 23:53:40', '2025-09-10 23:53:40', NULL),
(381, 'Areniti/Marrom', 'Areniti/Marrom', 'AREMRO', 37, 11, 1, 0, 1, '2025-09-10 23:53:40', '2025-09-10 23:53:40', NULL),
(382, 'Whisky', 'Whisky', 'WHISKY', 38, 11, 4, 0, 1, '2025-09-11 00:00:26', '2025-09-11 00:00:26', NULL);


--
-- Despejando dados para a tabela `product_numeracao`--

INSERT INTO `product_numeracao` (`id`, `product_id`, `numeracao_id`, `stock`, `created_at`, `updated_at`) VALUES
(9, 28, 4, 0, '2025-09-10 21:22:05', '2025-09-10 21:22:05'),
(11, 30, 4, 0, '2025-09-10 23:03:27', '2025-09-10 23:03:27'),
(12, 31, 4, 0, '2025-09-10 23:09:27', '2025-09-10 23:30:39'),
(13, 32, 4, 0, '2025-09-10 23:15:23', '2025-09-10 23:30:46'),
(14, 29, 10, 0, '2025-09-10 23:16:59', '2025-09-10 23:16:59'),
(15, 27, 11, 0, '2025-09-10 23:17:53', '2025-09-10 23:17:53'),
(16, 33, 6, 0, '2025-09-10 23:29:23', '2025-09-10 23:29:23'),
(17, 34, 7, 0, '2025-09-10 23:35:10', '2025-09-10 23:39:53'),
(18, 35, 1, 0, '2025-09-10 23:39:28', '2025-09-10 23:39:28'),
(19, 36, 1, 0, '2025-09-10 23:47:26', '2025-09-10 23:47:26'),
(20, 37, 9, 0, '2025-09-10 23:53:40', '2025-09-10 23:53:40'),
(21, 38, 4, 0, '2025-09-11 00:00:26', '2025-09-11 00:00:26');

--
-- Despejando dados para a tabela `product_sizes`--

INSERT INTO `product_sizes` (`id`, `product_id`, `size_id`, `stock`, `created_at`, `updated_at`) VALUES
(10, 27, 8, 0, '2025-09-10 20:59:44', '2025-09-10 23:17:53'),
(11, 28, 8, 0, '2025-09-10 21:22:05', '2025-09-10 21:22:05'),
(12, 29, 8, 0, '2025-09-10 21:28:45', '2025-09-10 23:16:59'),
(13, 30, 8, 0, '2025-09-10 23:03:27', '2025-09-10 23:03:27'),
(14, 31, 8, 0, '2025-09-10 23:09:27', '2025-09-10 23:30:39'),
(15, 32, 8, 0, '2025-09-10 23:15:23', '2025-09-10 23:30:46'),
(16, 33, 8, 0, '2025-09-10 23:29:23', '2025-09-10 23:29:23'),
(17, 34, 8, 0, '2025-09-10 23:35:10', '2025-09-10 23:39:53'),
(18, 35, 8, 0, '2025-09-10 23:39:28', '2025-09-10 23:39:28'),
(19, 36, 8, 0, '2025-09-10 23:47:26', '2025-09-10 23:47:26'),
(20, 37, 8, 0, '2025-09-10 23:53:40', '2025-09-10 23:53:40'),
(21, 38, 8, 0, '2025-09-11 00:00:26', '2025-09-11 00:00:26');
COMMIT;
--
-- Índices para tabelas despejadas
--

INSERT INTO `calendario` (`id`, `product_id`, `title`, `img`, `ano`, `mes`, `info_1`, `info_2`, `data`, `data_mkt`, `data_trade`, `data_cliente`, `data_dtc`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'Convenção 1s25', 'calendario/y8pgq4RBecRfcFvLwnBX7FLouHCRS86qdFOB2BCN.png', '2024', 1, 'Corrida', '43720366', '2025-08-25', '2025-05-06', '2025-05-07', '2025-05-10', '2025-05-01', '2025-08-22 22:57:54', '2025-08-25 19:08:46', NULL),
(3, NULL, 'Convenção 1s25', 'calendario/y8pgq4RBecRfcFvLwnBX7FLouHCRS86qdFOB2BCN.png', '2025', 1, 'Corrida', '43720366', '2025-08-25', '2025-05-06', '2025-05-07', '2025-05-10', '2025-05-01', '2025-08-22 22:57:54', '2025-08-25 19:08:16', NULL),
(5, NULL, 'Convenção 1s25', 'calendario/y8pgq4RBecRfcFvLwnBX7FLouHCRS86qdFOB2BCN.png', '2025', 2, 'Corrida', '43720366', '2025-08-25', '2025-05-06', '2025-05-07', '2025-05-10', '2025-05-01', '2025-08-22 22:57:54', '2025-08-25 19:08:16', NULL),
(7, NULL, 'Convenção 1s25', 'calendario/y8pgq4RBecRfcFvLwnBX7FLouHCRS86qdFOB2BCN.png', '2025', 5, 'Corrida', '43720366', '2025-08-25', '2025-05-06', '2025-05-07', '2025-05-10', '2025-05-01', '2025-08-22 22:57:54', '2025-08-25 19:08:16', NULL),
(12, 27, 'CORRE SUPRA2', NULL, '2025', 8, 'Produto: 43777397', 'A segunda edição do Olympikus Corre Supra chega para entregar ainda mais desempenho nas ruas. Tecnologia Oxitec 4.0, que permite maior respirabilidade, \r\nresistência e leveza. Lingueta macia e leve ao toque feita em Eco Suede com perfuros. Atacador apr', '2025-08-01', '2025-08-01', '2025-08-01', '2025-08-01', '2025-08-01', '2025-09-10 20:59:44', '2025-09-10 23:17:53', NULL),
(13, 28, 'PRIDE 4', NULL, '2025', 6, 'Produto: 43561394', 'Projetado para corridas intensas, o Olympikus PRIDE chega em sua quarta edição com diversas novidades. Entressola com tecnologia Eleva Pro 2.0, garantindo\r\nmaior resiliência, conforto e responsividade. Solado com tecnologia Gripper, altamente durável,', '2025-06-16', '2025-06-16', '2025-06-16', '2025-06-16', '2025-06-16', '2025-09-10 21:22:05', '2025-09-10 21:22:05', NULL),
(14, 29, 'QUADRA BR1', NULL, '2025', 7, 'Produto: 43391327', 'Co-criado junto com um dos maiores jogadores da história do vôlei mundial, Bruno Rezende, o Olympikus QU4DRA BR1 é uma expressão de excelência, paixão\r\ne legado para quem vive as 4 linhas. Possui tecnologia Eleva Pro 2.0, que proporciona leveza e am', '2025-07-08', '2025-07-08', '2025-07-08', '2025-07-08', '2025-07-08', '2025-09-10 21:28:45', '2025-09-10 21:28:45', NULL),
(15, 30, 'TREINO', NULL, '2025', 4, 'Produto: 43210417', 'Ideal para quem busca estilo e leveza nos treinos. Conta com a tecnologia de amortecimento EVASENSE, que proporciona mais leveza, maciez e flexibilidade \r\nnas passadas. Cabedal em poliéster com impressão digital e tecnologia HIGH FREQUENCY, logo em TPU,', '2025-04-29', '2025-04-29', '2025-04-29', '2025-04-29', '2025-04-29', '2025-09-10 23:03:27', '2025-09-10 23:03:27', NULL),
(16, 31, 'PASSO', NULL, '2025', 8, 'Produto: 43242437', 'Ideal para quem busca estilo e conforto nas corridas. Cabedal com tecnologia HYPERSOX, que facilita o calce e oferece melhor caimento, conforto e maciez. \r\nVistas em laminado e TPU com pintura e detalhes em tecnologia HIGH FREQUENCY. Lingueta em tecido du', '2025-08-13', '2025-08-13', '2025-08-13', '2025-08-13', '2025-08-13', '2025-09-10 23:09:27', '2025-09-10 23:09:27', NULL),
(17, 32, 'NIVEL', NULL, '2025', 6, 'Produto: 43211421', 'A combinação perfeita entre leveza e flexibilidade. Tecnologia HYPERSOX, com estrutura que facilita o calce e oferece melhor caimento, conforto e maciez. \r\nVistas em laminado e TPU com pinturas que levam a tecnologia HIGH FREQUENCY. Lingueta em dupla fr', '2025-06-05', '2025-06-05', '2025-06-05', '2025-06-05', '2025-06-05', '2025-09-10 23:15:23', '2025-09-10 23:15:23', NULL),
(18, 33, 'EASY 3', NULL, '2025', 5, 'Produto: 43609415', 'Em sua terceira edição, o Olympikus EASY é a escolha ideal para quem busca leveza a cada passada. Cabedal com mescla de tecido bicolor e parte traseira em \r\npoliéster texturizado. Elástico no cabedal que ressalta a marca. Etiqueta em laminado com art', '2025-05-10', '2025-05-10', '2025-05-10', '2025-05-10', '2025-05-10', '2025-09-10 23:29:23', '2025-09-10 23:29:23', NULL),
(19, 34, 'VERSA', NULL, '2025', 3, 'Produto: 43752263', 'O Olympikus Versa é um tênis clássico que nunca sai de moda, perfeito para quem busca mais estilo e conforto para o dia a dia. O seu solado tem o tradicional\r\nvisual de sola caixa e possui a Tecnologia Evasense, que proporciona conforto e amortecimento', '2025-03-20', '2025-03-20', '2025-03-20', '2025-03-20', '2025-03-20', '2025-09-10 23:35:10', '2025-09-10 23:39:53', NULL),
(20, 35, 'ACQUA INFANTIL', NULL, '2025', 8, 'Produto: 43306412', 'Cabedal em tecido jacquard com detalhes que combinam resistência e versatilidade. Vistas em laminado e TPU com tecnologia HIGH FREQUENCY. Lingueta \r\nconfortável, com combinação de poliéster e espuma. Atacador em poliéster oval texturizado. Forro em ', '2025-08-28', '2025-08-28', '2025-08-28', '2025-08-28', '2025-08-28', '2025-09-10 23:39:28', '2025-09-10 23:39:28', NULL),
(21, 36, 'VENUM 2 INFANTIL', NULL, '2025', 7, 'Produto: 43284434', 'Em sua segunda edição, o Olympikus VENUM INFANTIL se destaca pela tecnologia COVERGRID no cabedal, que proporciona maior proteção, resistência e durabilidade. \r\nLogo com pintura que dá destaque ao conjunto, criando efeito visual em 3D que muda confo', '2025-07-17', '2025-07-17', '2025-07-17', '2025-07-17', '2025-07-17', '2025-09-10 23:47:26', '2025-09-10 23:47:26', NULL),
(22, 37, 'LIVRE', NULL, '2025', 7, 'Produto: 54110438', '\"O LIVRE é a escolha ideal para quem busca conforto e descanso para os pés. Tiras em PVC com aplicação do logotipo. Palmilha e solado em EVA. Borracha \r\nantiderrapante com tecnologia GRIPPER, que proporciona maior durabilidade e resistência.', '2025-07-10', '2025-07-10', '2025-07-10', '2025-07-10', '2025-07-10', '2025-09-10 23:53:40', '2025-09-10 23:53:40', NULL),
(23, 38, 'CORRE MAX', NULL, '2025', 7, 'Produto: 43758365', 'Graças à extrema leveza resultante de nossa mais recente tecnologia, o Olympikus Corre Max oferece um desempenho superior e um conforto incomparável \r\ndurante as corridas. Sua entressola possui a tecnologia Eleva Pro Max, que melhora os índices de res', '2025-07-30', '2025-07-30', '2025-07-30', '2025-07-30', '2025-07-30', '2025-09-11 00:00:26', '2025-09-11 00:00:26', NULL);



INSERT INTO `caracteristicas_product` (`id`,`title`, `description`, `destaque`, `product_id`, `created_at`, `updated_at`, `deleted_at`) VALUES

(198, 'Peso', '215g - Ref. nº40', 0, 27, '2025-09-10 20:59:44', '2025-09-10 21:00:47', '2025-09-10 21:00:47'),
(199, 'Numeração', '35/44', 0, 27, '2025-09-10 20:59:44', '2025-09-10 21:00:47', '2025-09-10 21:00:47'),
(200, 'Drop', '6mm', 0, 27, '2025-09-10 20:59:44', '2025-09-10 21:00:47', '2025-09-10 21:00:47'),
(201, 'Origem', 'Nacional', 0, 27, '2025-09-10 20:59:44', '2025-09-10 21:00:47', '2025-09-10 21:00:47'),
(202, 'Indicação', 'Responsividade', 0, 27, '2025-09-10 20:59:44', '2025-09-10 21:00:47', '2025-09-10 21:00:47'),
(203, 'Peso', '215g - Ref. nº40', 0, 27, '2025-09-10 20:59:44', '2025-09-10 21:00:47', '2025-09-10 21:00:47'),
(204, 'Numeração', '35/44', 0, 27, '2025-09-10 20:59:44', '2025-09-10 21:00:47', '2025-09-10 21:00:47'),
(205, 'Drop', '6mm', 0, 27, '2025-09-10 20:59:44', '2025-09-10 21:00:47', '2025-09-10 21:00:47'),
(206, 'Origem', 'Nacional', 0, 27, '2025-09-10 20:59:44', '2025-09-10 21:00:47', '2025-09-10 21:00:47'),
(207, 'Indicação', 'Responsividade', 0, 27, '2025-09-10 20:59:44', '2025-09-10 21:00:47', '2025-09-10 21:00:47'),
(208, 'Peso', '215g - Ref. nº40', 0, 27, '2025-09-10 21:00:47', '2025-09-10 21:10:44', '2025-09-10 21:10:44'),
(209, 'Numeração', '35/44', 1, 27, '2025-09-10 21:00:47', '2025-09-10 21:10:44', '2025-09-10 21:10:44'),
(210, 'Drop', '6mm', 0, 27, '2025-09-10 21:00:47', '2025-09-10 21:10:44', '2025-09-10 21:10:44'),
(211, 'Origem', 'Nacional', 0, 27, '2025-09-10 21:00:47', '2025-09-10 21:10:44', '2025-09-10 21:10:44'),
(212, 'Indicação', 'Responsividade', 0, 27, '2025-09-10 21:00:47', '2025-09-10 21:10:44', '2025-09-10 21:10:44'),
(213, 'Peso', '215g - Ref. nº40', 0, 27, '2025-09-10 21:00:47', '2025-09-10 21:10:44', '2025-09-10 21:10:44'),
(214, 'Numeração', '35/44', 0, 27, '2025-09-10 21:00:47', '2025-09-10 21:10:44', '2025-09-10 21:10:44'),
(215, 'Drop', '6mm', 0, 27, '2025-09-10 21:00:47', '2025-09-10 21:10:44', '2025-09-10 21:10:44'),
(216, 'Origem', 'Nacional', 0, 27, '2025-09-10 21:00:47', '2025-09-10 21:10:44', '2025-09-10 21:10:44'),
(217, 'Indicação', 'Responsividade', 0, 27, '2025-09-10 21:00:47', '2025-09-10 21:10:44', '2025-09-10 21:10:44'),
(218, 'Peso', '215g - Ref. nº40', 0, 27, '2025-09-10 21:10:44', '2025-09-10 23:17:53', '2025-09-10 23:17:53'),
(219, 'Numeração', '35/44', 1, 27, '2025-09-10 21:10:44', '2025-09-10 23:17:53', '2025-09-10 23:17:53'),
(220, 'Drop', '6mm', 0, 27, '2025-09-10 21:10:44', '2025-09-10 23:17:53', '2025-09-10 23:17:53'),
(221, 'Origem', 'Nacional', 0, 27, '2025-09-10 21:10:44', '2025-09-10 23:17:53', '2025-09-10 23:17:53'),
(222, 'Indicação', 'Responsividade', 0, 27, '2025-09-10 21:10:44', '2025-09-10 23:17:53', '2025-09-10 23:17:53'),
(223, 'Peso', 'Ref. nº40', 0, 28, '2025-09-10 21:22:05', '2025-09-10 21:22:05', NULL),
(224, 'Numeração', '34/44', 1, 28, '2025-09-10 21:22:05', '2025-09-10 21:22:05', NULL),
(225, 'Origem', 'Nacional', 0, 28, '2025-09-10 21:22:05', '2025-09-10 21:22:05', NULL),
(226, 'Indicação', 'Corrida Leve', 0, 28, '2025-09-10 21:22:05', '2025-09-10 21:22:05', NULL),
(227, 'Peso', 'Ref. nº40', 0, 28, '2025-09-10 21:22:05', '2025-09-10 21:22:05', NULL),
(228, 'Numeração', '34/44', 1, 28, '2025-09-10 21:22:05', '2025-09-10 21:22:05', NULL),
(229, 'Origem', 'Nacional', 0, 28, '2025-09-10 21:22:05', '2025-09-10 21:22:05', NULL),
(230, 'Indicação', 'Corrida Leve', 0, 28, '2025-09-10 21:22:05', '2025-09-10 21:22:05', NULL),
(231, 'Numeração', '35/48', 1, 29, '2025-09-10 21:28:45', '2025-09-10 23:16:59', '2025-09-10 23:16:59'),
(232, 'Origem', 'Nacional', 0, 29, '2025-09-10 21:28:45', '2025-09-10 23:16:59', '2025-09-10 23:16:59'),
(233, 'Indicação', 'Quadra', 0, 29, '2025-09-10 21:28:45', '2025-09-10 23:16:59', '2025-09-10 23:16:59'),
(234, 'Numeração', '35/48', 1, 29, '2025-09-10 21:28:45', '2025-09-10 23:16:59', '2025-09-10 23:16:59'),
(235, 'Origem', 'Nacional', 0, 29, '2025-09-10 21:28:45', '2025-09-10 23:16:59', '2025-09-10 23:16:59'),
(236, 'Indicação', 'Quadra', 0, 29, '2025-09-10 21:28:45', '2025-09-10 23:16:59', '2025-09-10 23:16:59'),
(237, 'Peso', 'Ref. nº40', 0, 30, '2025-09-10 23:02:38', '2025-09-10 23:03:27', '2025-09-10 23:03:27'),
(238, 'Numeração', '34/44', 1, 30, '2025-09-10 23:02:38', '2025-09-10 23:03:27', '2025-09-10 23:03:27'),
(239, 'Origem', 'Nacional', 0, 30, '2025-09-10 23:02:38', '2025-09-10 23:03:27', '2025-09-10 23:03:27'),
(240, 'Indicação', 'Academia', 0, 30, '2025-09-10 23:02:38', '2025-09-10 23:03:27', '2025-09-10 23:03:27'),
(241, 'Peso', 'Ref. nº40', 0, 30, '2025-09-10 23:02:38', '2025-09-10 23:03:27', '2025-09-10 23:03:27'),
(242, 'Numeração', '34/44', 1, 30, '2025-09-10 23:02:38', '2025-09-10 23:03:27', '2025-09-10 23:03:27'),
(243, 'Origem', 'Nacional', 0, 30, '2025-09-10 23:02:38', '2025-09-10 23:03:27', '2025-09-10 23:03:27'),
(244, 'Indicação', 'Academia', 0, 30, '2025-09-10 23:02:38', '2025-09-10 23:03:27', '2025-09-10 23:03:27'),
(245, 'Peso', 'Ref. nº40', 0, 30, '2025-09-10 23:03:27', '2025-09-10 23:03:27', NULL),
(246, 'Numeração', '34/44', 1, 30, '2025-09-10 23:03:27', '2025-09-10 23:03:27', NULL),
(247, 'Origem', 'Nacional', 0, 30, '2025-09-10 23:03:27', '2025-09-10 23:03:27', NULL),
(248, 'Indicação', 'Academia', 0, 30, '2025-09-10 23:03:27', '2025-09-10 23:03:27', NULL),
(249, 'Peso', 'Ref. nº40', 0, 30, '2025-09-10 23:03:27', '2025-09-10 23:03:27', NULL),
(250, 'Numeração', '34/44', 1, 30, '2025-09-10 23:03:27', '2025-09-10 23:03:27', NULL),
(251, 'Origem', 'Nacional', 0, 30, '2025-09-10 23:03:27', '2025-09-10 23:03:27', NULL),
(252, 'Indicação', 'Academia', 0, 30, '2025-09-10 23:03:27', '2025-09-10 23:03:27', NULL),
(253, 'Peso', 'Ref. nº40', 0, 31, '2025-09-10 23:09:27', '2025-09-10 23:30:39', '2025-09-10 23:30:39'),
(254, 'Numeração', '34/44', 1, 31, '2025-09-10 23:09:27', '2025-09-10 23:30:39', '2025-09-10 23:30:39'),
(255, 'Origem', 'Nacional', 0, 31, '2025-09-10 23:09:27', '2025-09-10 23:30:39', '2025-09-10 23:30:39'),
(256, 'Indicação', 'Conforto', 0, 31, '2025-09-10 23:09:27', '2025-09-10 23:30:39', '2025-09-10 23:30:39'),
(257, 'Peso', 'Ref. nº40', 0, 31, '2025-09-10 23:09:27', '2025-09-10 23:30:39', '2025-09-10 23:30:39'),
(258, 'Numeração', '34/44', 1, 31, '2025-09-10 23:09:27', '2025-09-10 23:30:39', '2025-09-10 23:30:39'),
(259, 'Origem', 'Nacional', 0, 31, '2025-09-10 23:09:27', '2025-09-10 23:30:39', '2025-09-10 23:30:39'),
(260, 'Indicação', 'Conforto', 0, 31, '2025-09-10 23:09:27', '2025-09-10 23:30:39', '2025-09-10 23:30:39'),
(261, 'Numeração', '34/44', 1, 32, '2025-09-10 23:15:23', '2025-09-10 23:30:46', '2025-09-10 23:30:46'),
(262, 'Origem', 'Nacional', 0, 32, '2025-09-10 23:15:23', '2025-09-10 23:30:46', '2025-09-10 23:30:46'),
(263, 'Indicação', 'Conforto', 0, 32, '2025-09-10 23:15:23', '2025-09-10 23:30:46', '2025-09-10 23:30:46'),
(264, 'Numeração', '34/44', 1, 32, '2025-09-10 23:15:23', '2025-09-10 23:30:46', '2025-09-10 23:30:46'),
(265, 'Origem', 'Nacional', 0, 32, '2025-09-10 23:15:23', '2025-09-10 23:30:46', '2025-09-10 23:30:46'),
(266, 'Indicação', 'Conforto', 0, 32, '2025-09-10 23:15:23', '2025-09-10 23:30:46', '2025-09-10 23:30:46'),
(267, 'Numeração', '35/48', 1, 29, '2025-09-10 23:16:59', '2025-09-10 23:16:59', NULL),
(268, 'Origem', 'Nacional', 0, 29, '2025-09-10 23:16:59', '2025-09-10 23:16:59', NULL),
(269, 'Indicação', 'Quadra', 0, 29, '2025-09-10 23:16:59', '2025-09-10 23:16:59', NULL),
(270, 'Numeração', '35/48', 1, 29, '2025-09-10 23:16:59', '2025-09-10 23:16:59', NULL),
(271, 'Origem', 'Nacional', 0, 29, '2025-09-10 23:16:59', '2025-09-10 23:16:59', NULL),
(272, 'Indicação', 'Quadra', 0, 29, '2025-09-10 23:16:59', '2025-09-10 23:16:59', NULL),
(273, 'Peso', '215g - Ref. nº40', 0, 27, '2025-09-10 23:17:53', '2025-09-10 23:17:53', NULL),
(274, 'Numeração', '35/44', 1, 27, '2025-09-10 23:17:53', '2025-09-10 23:17:53', NULL),
(275, 'Drop', '6mm', 0, 27, '2025-09-10 23:17:53', '2025-09-10 23:17:53', NULL),
(276, 'Origem', 'Nacional', 0, 27, '2025-09-10 23:17:53', '2025-09-10 23:17:53', NULL),
(277, 'Indicação', 'Responsividade', 0, 27, '2025-09-10 23:17:53', '2025-09-10 23:17:53', NULL),
(278, 'Numeração', '34/41', 1, 33, '2025-09-10 23:29:23', '2025-09-10 23:29:23', NULL),
(279, 'Origem', 'Nacional', 0, 33, '2025-09-10 23:29:23', '2025-09-10 23:29:23', NULL),
(280, 'Indicação', 'Conforto', 0, 33, '2025-09-10 23:29:23', '2025-09-10 23:29:23', NULL),
(281, 'Numeração', '34/41', 1, 33, '2025-09-10 23:29:23', '2025-09-10 23:29:23', NULL),
(282, 'Origem', 'Nacional', 0, 33, '2025-09-10 23:29:23', '2025-09-10 23:29:23', NULL),
(283, 'Indicação', 'Conforto', 0, 33, '2025-09-10 23:29:23', '2025-09-10 23:29:23', NULL),
(284, 'Peso', 'Ref. nº40', 0, 31, '2025-09-10 23:30:39', '2025-09-10 23:30:39', NULL),
(285, 'Numeração', '34/44', 1, 31, '2025-09-10 23:30:39', '2025-09-10 23:30:39', NULL),
(286, 'Origem', 'Nacional', 0, 31, '2025-09-10 23:30:39', '2025-09-10 23:30:39', NULL),
(287, 'Indicação', 'Conforto', 0, 31, '2025-09-10 23:30:39', '2025-09-10 23:30:39', NULL),
(288, 'Peso', 'Ref. nº40', 0, 31, '2025-09-10 23:30:39', '2025-09-10 23:30:39', NULL),
(289, 'Numeração', '34/44', 1, 31, '2025-09-10 23:30:39', '2025-09-10 23:30:39', NULL),
(290, 'Origem', 'Nacional', 0, 31, '2025-09-10 23:30:39', '2025-09-10 23:30:39', NULL),
(291, 'Indicação', 'Conforto', 0, 31, '2025-09-10 23:30:39', '2025-09-10 23:30:39', NULL),
(292, 'Numeração', '34/44', 1, 32, '2025-09-10 23:30:46', '2025-09-10 23:30:46', NULL),
(293, 'Origem', 'Nacional', 0, 32, '2025-09-10 23:30:46', '2025-09-10 23:30:46', NULL),
(294, 'Indicação', 'Conforto', 0, 32, '2025-09-10 23:30:46', '2025-09-10 23:30:46', NULL),
(295, 'Numeração', '34/44', 1, 32, '2025-09-10 23:30:46', '2025-09-10 23:30:46', NULL),
(296, 'Origem', 'Nacional', 0, 32, '2025-09-10 23:30:46', '2025-09-10 23:30:46', NULL),
(297, 'Indicação', 'Conforto', 0, 32, '2025-09-10 23:30:46', '2025-09-10 23:30:46', NULL),
(298, 'Numeração', '34/48', 1, 34, '2025-09-10 23:35:10', '2025-09-10 23:35:21', '2025-09-10 23:35:21'),
(299, 'Origem', 'Nacional', 0, 34, '2025-09-10 23:35:10', '2025-09-10 23:35:21', '2025-09-10 23:35:21'),
(300, 'Indicação', 'Classico', 0, 34, '2025-09-10 23:35:10', '2025-09-10 23:35:21', '2025-09-10 23:35:21'),
(301, 'Numeração', '34/48', 1, 34, '2025-09-10 23:35:10', '2025-09-10 23:35:21', '2025-09-10 23:35:21'),
(302, 'Origem', 'Nacional', 0, 34, '2025-09-10 23:35:10', '2025-09-10 23:35:21', '2025-09-10 23:35:21'),
(303, 'Indicação', 'Classico', 0, 34, '2025-09-10 23:35:10', '2025-09-10 23:35:21', '2025-09-10 23:35:21'),
(304, 'Numeração', '34/48', 1, 34, '2025-09-10 23:35:21', '2025-09-10 23:39:53', '2025-09-10 23:39:53'),
(305, 'Origem', 'Nacional', 0, 34, '2025-09-10 23:35:21', '2025-09-10 23:39:53', '2025-09-10 23:39:53'),
(306, 'Indicação', 'Classico', 0, 34, '2025-09-10 23:35:21', '2025-09-10 23:39:53', '2025-09-10 23:39:53'),
(307, 'Numeração', '34/48', 1, 34, '2025-09-10 23:35:21', '2025-09-10 23:39:53', '2025-09-10 23:39:53'),
(308, 'Origem', 'Nacional', 0, 34, '2025-09-10 23:35:21', '2025-09-10 23:39:53', '2025-09-10 23:39:53'),
(309, 'Indicação', 'Classico', 0, 34, '2025-09-10 23:35:21', '2025-09-10 23:39:53', '2025-09-10 23:39:53'),
(310, 'Numeração', '28/36', 1, 35, '2025-09-10 23:39:28', '2025-09-10 23:39:28', NULL),
(311, 'Origem', 'Nacional', 0, 35, '2025-09-10 23:39:28', '2025-09-10 23:39:28', NULL),
(312, 'Indicação', 'Conforto', 0, 35, '2025-09-10 23:39:28', '2025-09-10 23:39:28', NULL),
(313, 'Numeração', '28/36', 1, 35, '2025-09-10 23:39:28', '2025-09-10 23:39:28', NULL),
(314, 'Origem', 'Nacional', 0, 35, '2025-09-10 23:39:28', '2025-09-10 23:39:28', NULL),
(315, 'Indicação', 'Conforto', 0, 35, '2025-09-10 23:39:28', '2025-09-10 23:39:28', NULL),
(316, 'Numeração', '34/48', 1, 34, '2025-09-10 23:39:53', '2025-09-10 23:39:53', NULL),
(317, 'Origem', 'Nacional', 0, 34, '2025-09-10 23:39:53', '2025-09-10 23:39:53', NULL),
(318, 'Indicação', 'Classico', 0, 34, '2025-09-10 23:39:53', '2025-09-10 23:39:53', NULL),
(319, 'Numeração', '34/48', 1, 34, '2025-09-10 23:39:53', '2025-09-10 23:39:53', NULL),
(320, 'Origem', 'Nacional', 0, 34, '2025-09-10 23:39:53', '2025-09-10 23:39:53', NULL),
(321, 'Indicação', 'Classico', 0, 34, '2025-09-10 23:39:53', '2025-09-10 23:39:53', NULL),
(322, 'Numeração', '28/36', 1, 36, '2025-09-10 23:47:26', '2025-09-10 23:47:26', NULL),
(323, 'Origem', 'Nacional', 0, 36, '2025-09-10 23:47:26', '2025-09-10 23:47:26', NULL),
(324, 'Indicação', 'Conforto', 0, 36, '2025-09-10 23:47:26', '2025-09-10 23:47:26', NULL),
(325, 'Numeração', '28/36', 1, 36, '2025-09-10 23:47:26', '2025-09-10 23:47:26', NULL),
(326, 'Origem', 'Nacional', 0, 36, '2025-09-10 23:47:26', '2025-09-10 23:47:26', NULL),
(327, 'Indicação', 'Conforto', 0, 36, '2025-09-10 23:47:26', '2025-09-10 23:47:26', NULL),
(328, 'Numeração', '33/34 a 43/44', 1, 37, '2025-09-10 23:53:40', '2025-09-10 23:53:40', NULL),
(329, 'Origem', 'Nacional', 0, 37, '2025-09-10 23:53:40', '2025-09-10 23:53:40', NULL),
(330, 'Indicação', 'Chinelos', 0, 37, '2025-09-10 23:53:40', '2025-09-10 23:53:40', NULL),
(331, 'Numeração', '33/34 a 43/44', 1, 37, '2025-09-10 23:53:40', '2025-09-10 23:53:40', NULL),
(332, 'Origem', 'Nacional', 0, 37, '2025-09-10 23:53:40', '2025-09-10 23:53:40', NULL),
(333, 'Indicação', 'Chinelos', 0, 37, '2025-09-10 23:53:40', '2025-09-10 23:53:40', NULL),
(334, 'Peso', '284g - Ref. nº40', 0, 38, '2025-09-11 00:00:26', '2025-09-11 00:00:26', NULL),
(335, 'Numeração', '34/44', 1, 38, '2025-09-11 00:00:26', '2025-09-11 00:00:26', NULL),
(336, 'Drop', '8mm', 0, 38, '2025-09-11 00:00:26', '2025-09-11 00:00:26', NULL),
(337, 'Origem', 'Nacional', 0, 38, '2025-09-11 00:00:26', '2025-09-11 00:00:26', NULL),
(338, 'Indicação', 'Corrida Leve', 0, 38, '2025-09-11 00:00:26', '2025-09-11 00:00:26', NULL),
(339, 'Peso', '284g - Ref. nº40', 0, 38, '2025-09-11 00:00:26', '2025-09-11 00:00:26', NULL),
(340, 'Numeração', '34/44', 1, 38, '2025-09-11 00:00:26', '2025-09-11 00:00:26', NULL),
(341, 'Drop', '8mm', 0, 38, '2025-09-11 00:00:26', '2025-09-11 00:00:26', NULL),
(342, 'Origem', 'Nacional', 0, 38, '2025-09-11 00:00:26', '2025-09-11 00:00:26', NULL),
(343, 'Indicação', 'Corrida Leve', 0, 38, '2025-09-11 00:00:26', '2025-09-11 00:00:26', NULL);

--
-- Despejando dados para a tabela `user_wishlists`--

INSERT INTO `user_wishlists` (`id`,`user_id`, `product_id`, `color_code`, `created_at`, `updated_at`) VALUES
(9, 3, 27, 'AREOLY', '2025-09-10 21:11:04', '2025-09-10 21:11:04');
COMMIT;


SET FOREIGN_KEY_CHECKS = 1;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
