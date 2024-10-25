-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19/04/2024 às 13:04
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `frotapmj`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_coordenadas`
--

CREATE TABLE `tb_coordenadas` (
  `id_viagem` int(11) NOT NULL,
  `coordenadas` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT;

--
-- Despejando dados para a tabela `tb_coordenadas`
--

INSERT INTO `tb_coordenadas` (`id_viagem`, `coordenadas`) VALUES
(1, '-23.3072621, -45.9658132'),
(1, '-23.3072621, -45.9658132'),
(1, '-23.3072621, -45.9658132'),
(1, '-23.3072621, -45.9658132'),
(1, '-23.3072621, -45.9658132'),
(1, '-23.3072621, -45.9658132'),
(2, '-23.3072621, -45.9658132'),
(3, '-23.306353, -45.9760295'),
(3, '-23.306353, -45.9760295'),
(3, '-23.306353, -45.9760295'),
(3, '-23.306353, -45.9760295'),
(3, '-23.306353, -45.9760295'),
(4, '-23.3063041, -45.9759674'),
(4, '-23.3063041, -45.9759674'),
(4, '-23.3063041, -45.9759674'),
(5, '-23.3063043, -45.9759702'),
(5, '-23.3063043, -45.9759702');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_login`
--

CREATE TABLE `tb_login` (
  `id_login` int(11) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `matricula` int(11) NOT NULL,
  `secretaria` int(11) NOT NULL,
  `setor` int(11) NOT NULL,
  `id_perfil` int(11) NOT NULL,
  `coordenadas` varchar(110) NOT NULL,
  `status_viagem` int(11) NOT NULL,
  `ativo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT;

--
-- Despejando dados para a tabela `tb_login`
--

INSERT INTO `tb_login` (`id_login`, `usuario`, `nome`, `email`, `matricula`, `secretaria`, `setor`, `id_perfil`, `coordenadas`, `status_viagem`, `ativo`) VALUES
(1, 'andre.vasques', 'Andre Gabriel Vasques', 'andre.vasques@jacarei.sp.gov.br', 66434, 1, 20, 1, '-23.3063043, -45.9759702', 1, 1),
(2, 'teste.dti', 'teste dti', 'teste.dti@jacarei.sp.gov.br', 12345, 2, 18, 3, 'Sem coordenadas', 0, 1),
(3, 'pedro.braga', 'Pedro Vitor de C Oliveira Braga', 'pedro.braga@jacarei.sp.gov.br', 30632, 1, 20, 2, 'Sem coordenadas', 0, 1),
(4, 'wesley.barberi', 'Wesley Cesar Barberi', 'wesley.barberi@jacarei.sp.gov.br', 24501, 1, 20, 1, '-23.2987412, -45.9634334', 1, 1),
(5, 'marcos.alessandro', 'Marcos D Alessandro', 'marcos.alessandro@jacarei.sp.gov.br', 30631, 1, 20, 1, '-23.3063551, -45.9760108', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_login_veiculo`
--

CREATE TABLE `tb_login_veiculo` (
  `id_login` int(11) NOT NULL,
  `id_veiculo` int(11) NOT NULL,
  `disponivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT;

--
-- Despejando dados para a tabela `tb_login_veiculo`
--

INSERT INTO `tb_login_veiculo` (`id_login`, `id_veiculo`, `disponivel`) VALUES
(1, 1, 1),
(1, 2, 1),
(1, 3, 1),
(1, 4, 1),
(1, 5, 1),
(1, 6, 1),
(1, 7, 1),
(1, 8, 1),
(1, 9, 1),
(1, 10, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_perfil`
--

CREATE TABLE `tb_perfil` (
  `id_perfil` int(11) NOT NULL,
  `nome_perfil` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT;

--
-- Despejando dados para a tabela `tb_perfil`
--

INSERT INTO `tb_perfil` (`id_perfil`, `nome_perfil`) VALUES
(1, 'Administrador'),
(2, 'Supervisor'),
(3, 'Usuário Padrão');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_secretaria`
--

CREATE TABLE `tb_secretaria` (
  `id_secretaria` int(11) NOT NULL,
  `nome_secretaria` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT;

--
-- Despejando dados para a tabela `tb_secretaria`
--

INSERT INTO `tb_secretaria` (`id_secretaria`, `nome_secretaria`) VALUES
(1, 'SARH - Administração'),
(2, 'SAS - Assistência Social'),
(3, 'SDE - Desenvolvimento Econômico'),
(4, 'educação'),
(6, 'SF - Finanças'),
(7, 'GAB - Gabinete'),
(8, 'SEGOVPLAN - Governo e Planejamento'),
(9, 'SIM - Infraestrutura'),
(10, 'SMA - Meio Ambiente'),
(11, 'SEMOB - Mobilidade'),
(13, 'rhadfhadh'),
(14, 'dfjdjqetje'),
(15, 'rjeqjejj'),
(16, 'SS - Sáude'),
(17, 'dshejtjrsatjj'),
(18, 'dhjjaejerje'),
(19, 'erjhaejaej'),
(20, 'fgkjrtykrw'),
(21, 'rjrtkjwrtkrwk'),
(22, 'jrwejquj'),
(23, 'tjrtkjwst'),
(24, 'mjtksrt'),
(25, 'sdhjejtjerj'),
(26, 'djwewriwri'),
(27, 'hwhqehqe'),
(28, 'eheqrjher'),
(29, 'whqwhjqej'),
(30, 'sdhashsrh'),
(31, 'efjajwt'),
(32, 'dfhjejwjw'),
(33, 'ruj245jw4j'),
(34, 'hoty5p5'),
(35, 'Uduciviviig'),
(36, 'Ztsydiuxjck');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_setor`
--

CREATE TABLE `tb_setor` (
  `id_setor` int(11) NOT NULL,
  `id_secretaria` int(11) NOT NULL,
  `nome_setor` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT;

--
-- Despejando dados para a tabela `tb_setor`
--

INSERT INTO `tb_setor` (`id_setor`, `id_secretaria`, `nome_setor`) VALUES
(1, 1, 'whqrhqrhehe'),
(2, 4, 'hqerhqehhw'),
(3, 6, 'jwrtjwtjwr'),
(4, 1, 'rjeqjqewe'),
(7, 1, 'dfnadfnadfhndad'),
(8, 1, 'harheqrher'),
(9, 1, 'erherhehe'),
(12, 1, 'rhjetjwetjwtr'),
(14, 1, 'rejaejastj'),
(15, 1, 'DFNJSTJR'),
(16, 1, 'teste'),
(17, 1, 'teste1'),
(18, 2, 'teste1'),
(19, 2, 'teste'),
(20, 1, 'DTI - Diretoria de Tecnologia da Informação');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_solicitacoes`
--

CREATE TABLE `tb_solicitacoes` (
  `id_solicitacao` int(11) NOT NULL,
  `tipo` int(11) NOT NULL,
  `solicitador` varchar(255) NOT NULL,
  `texto` varchar(501) NOT NULL,
  `resolvido` int(11) NOT NULL,
  `data_solicitacao` datetime NOT NULL,
  `data_resolvido` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT;

--
-- Despejando dados para a tabela `tb_solicitacoes`
--

INSERT INTO `tb_solicitacoes` (`id_solicitacao`, `tipo`, `solicitador`, `texto`, `resolvido`, `data_solicitacao`, `data_resolvido`) VALUES
(1, 1, '1', '66434 / educação | hqerhqehhw', 1, '0000-00-00 00:00:00', '2024-04-12 08:10:52'),
(2, 2, '1', 'rjtjwr tjwrtjwrtj wrtjwr tjrt jwrt jrt jrt', 1, '0000-00-00 00:00:00', '2024-04-11 18:53:14'),
(3, 2, '1', 'rjtjwr tjwrtjwrtj wrtjwr tjrt jwrt jrt jrt', 1, '0000-00-00 00:00:00', '2024-04-11 13:56:25'),
(4, 2, '1', 'rjtjwr tjwrtjwrtj wrtjwr tjrt jwrt jrt jrt', 0, '0000-00-00 00:00:00', NULL),
(5, 2, '1', 'rj tjw tjtj w rtjwrt jrtj qwtjqt ujqt jwrt', 0, '0000-00-00 00:00:00', NULL),
(6, 1, '1', '66434 / SAS - Assistência Social | teste1', 0, '2024-04-11 18:52:04', NULL),
(7, 2, '1', 'ehqrehqe rhqrehj qejqe hqerhqer hqre hqerhqehqe', 0, '2024-04-11 18:52:11', NULL),
(8, 2, '1', 'jkdghiuwsaig g hb uyf ikuf u jcycyli f liugvli ,  iug i guyu f iug ijkdghiuwsaig g hb uyf ikuf u jcycyli f liugvli ,  iug i guyu f iug ijkdghiuwsaig g hb uyf ikuf u jcycyli f liugvli ,  iug i guyu f iug ijkdghiuwsaig g hb uyf ikuf u jcycyli f liugvli ,  i', 0, '2024-04-12 08:30:30', NULL),
(9, 2, '1', 'jkdghiuwsaig g hb uyf ikuf u jcycyli f liugvli ,  iug i guyu f iug ijkdghiuwsaig g hb uyf ikuf u jcycyli f liugvli ,  iug i guyu f iug ijkdghiuwsaig g hb uyf ikuf u jcycyli f liugvli ,  iug i guyu f iug ijkdghiuwsaig g hb uyf ikuf u jcycyli f liugvli ,  iug i guyu f iug ijkdghiuwsaig g hb uyf ikuf u jcycyli f liugvli ,  iug i guyu f iug ijkdghiuwsaig g hb uyf ikuf u jcycyli f liugvli ,  iug i guyu f iug ijkdghiuwsaig g hb uyf ikuf u jcycyli f liugvli ,  iug i guyu f iug i', 0, '2024-04-12 08:31:24', NULL),
(10, 2, '1', 'jkdghiuwsaig g hb uyf ikuf u jcycyli f liugvli ,  iug i guyu f iug ijkdghiuwsaig g hb uyf ikuf u jcycyli f liugvli ,  iug i guyu f iug ijkdghiuwsaig g hb uyf ikuf u jcycyli f liugvli ,  iug i guyu f iug ijkdghiuwsaig g hb uyf ikuf u jcycyli f liugvli ,  iug i guyu f iug ijkdghiuwsaig g hb uyf ikuf u jcycyli f liugvli ,  iug i guyu f iug ijkdghiuwsaig g hb uyf ikuf u jcycyli f liugvli ,  iug i guyu f iug ijkdghiuwsaig g hb uyf ikuf u jcycyli f liugvli ,  iug i guyu f iug i teste', 1, '2024-04-12 08:31:43', '2024-04-12 08:31:49');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_veiculo`
--

CREATE TABLE `tb_veiculo` (
  `id_veiculo` int(11) NOT NULL,
  `placa` varchar(255) NOT NULL,
  `modelo` varchar(255) NOT NULL,
  `id_login` int(11) NOT NULL,
  `disponivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT;

--
-- Despejando dados para a tabela `tb_veiculo`
--

INSERT INTO `tb_veiculo` (`id_veiculo`, `placa`, `modelo`, `id_login`, `disponivel`) VALUES
(1, 'GDQ-2A35', 'RENEGADE', 1, 1),
(2, 'SWM-0A80', 'TWISTER', 1, 1),
(3, 'YUF-3J43', 'IDGVGW', 1, 1),
(4, 'YFU-4F34', 'UYFUYWGFIWF', 1, 1),
(5, 'KJG-3Y34', 'U3FYVFJHVKHS', 1, 1),
(6, 'YFU-5G34', 'YFGWIUFGWF', 1, 1),
(7, 'JHF-4F54', 'UYFJHFGGEA', 1, 0),
(8, 'KGF-5J45', 'GDKIJGHTHW', 1, 1),
(9, 'UHF-8I34', 'DHVGKWHW', 1, 1),
(10, 'KJG-5J55', 'JHGKSJBVL', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_viagem`
--

CREATE TABLE `tb_viagem` (
  `id_viagem` int(11) NOT NULL,
  `id_login` int(11) NOT NULL,
  `id_carro` int(11) NOT NULL,
  `km_inicial` int(15) NOT NULL,
  `km_final` int(15) DEFAULT NULL,
  `destino` varchar(255) NOT NULL,
  `datahora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT;

--
-- Despejando dados para a tabela `tb_viagem`
--

INSERT INTO `tb_viagem` (`id_viagem`, `id_login`, `id_carro`, `km_inicial`, `km_final`, `destino`, `datahora`) VALUES
(1, 1, 0, 0, NULL, '', '2024-04-18 14:14:30'),
(2, 1, 0, 0, NULL, '', '2024-04-18 14:17:13'),
(3, 1, 0, 0, NULL, '', '2024-04-18 14:21:03'),
(4, 1, 0, 0, NULL, '', '2024-04-18 14:24:06'),
(5, 1, 0, 0, NULL, '', '2024-04-18 14:24:59');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tb_login`
--
ALTER TABLE `tb_login`
  ADD PRIMARY KEY (`id_login`);

--
-- Índices de tabela `tb_perfil`
--
ALTER TABLE `tb_perfil`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Índices de tabela `tb_secretaria`
--
ALTER TABLE `tb_secretaria`
  ADD PRIMARY KEY (`id_secretaria`);

--
-- Índices de tabela `tb_setor`
--
ALTER TABLE `tb_setor`
  ADD PRIMARY KEY (`id_setor`);

--
-- Índices de tabela `tb_solicitacoes`
--
ALTER TABLE `tb_solicitacoes`
  ADD PRIMARY KEY (`id_solicitacao`);

--
-- Índices de tabela `tb_veiculo`
--
ALTER TABLE `tb_veiculo`
  ADD PRIMARY KEY (`id_veiculo`);

--
-- Índices de tabela `tb_viagem`
--
ALTER TABLE `tb_viagem`
  ADD PRIMARY KEY (`id_viagem`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_login`
--
ALTER TABLE `tb_login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tb_perfil`
--
ALTER TABLE `tb_perfil`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tb_secretaria`
--
ALTER TABLE `tb_secretaria`
  MODIFY `id_secretaria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de tabela `tb_setor`
--
ALTER TABLE `tb_setor`
  MODIFY `id_setor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `tb_solicitacoes`
--
ALTER TABLE `tb_solicitacoes`
  MODIFY `id_solicitacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `tb_veiculo`
--
ALTER TABLE `tb_veiculo`
  MODIFY `id_veiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `tb_viagem`
--
ALTER TABLE `tb_viagem`
  MODIFY `id_viagem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
