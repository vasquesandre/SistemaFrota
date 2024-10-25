-- Configurações de codificação de caracteres
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Estrutura para tabela `tb_coordenadas`
CREATE TABLE `tb_coordenadas` (
  `id_viagem` int(11) NOT NULL,
  `coordenadas` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Estrutura para tabela `tb_login`
CREATE TABLE `tb_login` (
  `id_login` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `matricula` int(11) NOT NULL,
  `secretaria` int(11) NOT NULL,
  `setor` int(11) NOT NULL,
  `id_perfil` int(11) NOT NULL,
  `coordenadas` varchar(110) NOT NULL,
  `status_viagem` int(11) NOT NULL,
  `ativo` int(11) NOT NULL,
  PRIMARY KEY (`id_login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Estrutura para tabela `tb_login_veiculo`
CREATE TABLE `tb_login_veiculo` (
  `id_login` int(11) NOT NULL,
  `id_veiculo` int(11) NOT NULL,
  `disponivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Estrutura para tabela `tb_perfil`
CREATE TABLE `tb_perfil` (
  `id_perfil` int(11) NOT NULL AUTO_INCREMENT,
  `nome_perfil` varchar(110) NOT NULL,
  PRIMARY KEY (`id_perfil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Estrutura para tabela `tb_secretaria`
CREATE TABLE `tb_secretaria` (
  `id_secretaria` int(11) NOT NULL AUTO_INCREMENT,
  `nome_secretaria` varchar(110) NOT NULL,
  PRIMARY KEY (`id_secretaria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Estrutura para tabela `tb_setor`
CREATE TABLE `tb_setor` (
  `id_setor` int(11) NOT NULL AUTO_INCREMENT,
  `id_secretaria` int(11) NOT NULL,
  `nome_setor` varchar(110) NOT NULL,
  PRIMARY KEY (`id_setor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Estrutura para tabela `tb_solicitacoes`
CREATE TABLE `tb_solicitacoes` (
  `id_solicitacao` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` int(11) NOT NULL,
  `solicitador` varchar(255) NOT NULL,
  `texto` varchar(501) NOT NULL,
  `resolvido` int(11) NOT NULL,
  `data_solicitacao` datetime NOT NULL,
  `data_resolvido` datetime DEFAULT NULL,
  PRIMARY KEY (`id_solicitacao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Estrutura para tabela `tb_veiculo`
CREATE TABLE `tb_veiculo` (
  `id_veiculo` int(11) NOT NULL AUTO_INCREMENT,
  `placa` varchar(255) NOT NULL,
  `modelo` varchar(255) NOT NULL,
  `id_login` int(11) NOT NULL,
  `disponivel` int(11) NOT NULL,
  PRIMARY KEY (`id_veiculo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Estrutura para tabela `tb_viagem`
CREATE TABLE `tb_viagem` (
  `id_viagem` int(11) NOT NULL AUTO_INCREMENT,
  `id_login` int(11) NOT NULL,
  `id_carro` int(11) NOT NULL,
  `km_inicial` int(15) NOT NULL,
  `km_final` int(15) DEFAULT NULL,
  `destino` varchar(255) NOT NULL,
  `datahora` datetime NOT NULL,
  PRIMARY KEY (`id_viagem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;
