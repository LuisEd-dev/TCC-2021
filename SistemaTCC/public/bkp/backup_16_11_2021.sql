set foreign_key_checks=0;


#
# //Criação da Tabela : tb_agendas
#

CREATE TABLE `tb_agendas` (
  `agd_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tb_usuarios_usr_id` int(10) unsigned NOT NULL,
  `agd_titulo` varchar(255) DEFAULT NULL,
  `agd_descricao` varchar(255) DEFAULT NULL,
  `agd_data` datetime DEFAULT NULL,
  `agd_cor` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`agd_id`),
  KEY `tb_agendas_FKIndex1` (`tb_usuarios_usr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_agendas VALUES('1', '1', 'Evento 1', '', '2021-10-06 00:00:00', 'primary')
,('2', '1', 'Evento 2', 'Visitar Cliente', '2021-10-19 00:00:00', 'success')
,('3', '1', 'Evento 3', 'Visitar Cliente', '2021-10-28 00:00:00', 'warning')
,('4', '1', 'Evento 4', 'Visitar Cliente', '2021-10-28 00:00:00', 'info')
,('5', '1', 'Test', 'etsf', '2021-11-02 00:00:00', 'secondary')
;

#
# //Criação da Tabela : tb_clientes
#

CREATE TABLE `tb_clientes` (
  `cli_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cli_nome` varchar(255) DEFAULT NULL,
  `cli_tipo_pessoa` char(2) DEFAULT NULL,
  `cli_cpf_cnpj` varchar(14) DEFAULT NULL,
  `cli_rg_ie` varchar(14) DEFAULT NULL,
  `cli_endereco` varchar(255) DEFAULT NULL,
  `cli_numero` varchar(20) DEFAULT NULL,
  `cli_bairro` varchar(255) DEFAULT NULL,
  `cli_cidade` varchar(255) DEFAULT NULL,
  `cli_uf` varchar(2) DEFAULT NULL,
  `cli_cep` varchar(8) DEFAULT NULL,
  `cli_complemento` varchar(255) DEFAULT NULL,
  `cli_celular` varchar(11) DEFAULT NULL,
  `cli_telefone` varchar(10) DEFAULT NULL,
  `cli_email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cli_id`),
  UNIQUE KEY `campos_unicos` (`cli_cpf_cnpj`,`cli_celular`,`cli_telefone`,`cli_email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_clientes VALUES('1', 'Guilherme José Porto', 'PF', '95677537179', '303945138', 'Quadra 10', '578', 'João XXIII', 'Parnaíba', 'PI', '64205228', '', '86995884086', '8637287389', 'guilhermejoseporto_@uninorte.com.br')
,('2', 'Luan Emanuel Bruno da Cruz', 'PF', '50709649410', '140783076', 'Rua dos Pinheiros', '877', 'Jardim Palácios', 'Aparecida de Goiânia', 'GO', '74913047', '', '62991754636', '6236179611', 'luanemanuelbrunodacruz_@bn.com.br')
,('3', 'Roberto Raimundo Tomás da Costa', 'PF', '82090536985', '504758809', 'Rua Genciana', '173', 'Jardim Nova Jerusalém', 'Campo Grande', 'MS', '79065640', '', '67988909661', '6736338084', 'robertoraimundotomasdacosta__robertoraimundotomasdacosta@bol.br')
,('4', 'Bianca Jaqueline Luciana Monteiro', 'PF', '69272801974', '486700434', 'Avenida Felipe Schmidt 1949', '600', 'Centro', 'Braço do Norte', 'SC', '88750970', '', '48995925642', '4838280118', 'biancajaquelinelucianamonteiro-96@yhaoo.com.br')
,('5', 'Fabiana Maitê Dias', 'PF', '36786032460', '436183638', 'Rua Rosa da Fonsêca', '365', 'Barroso', 'Fortaleza', 'CE', '60863052', '', '85998826063', '8529800508', 'fabianamaitedias__fabianamaitedias@grupoitaipu.com.br')
;

#
# //Criação da Tabela : tb_compras
#

CREATE TABLE `tb_compras` (
  `cmp_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tb_fornecedores_for_id` int(10) unsigned NOT NULL,
  `cmp_data` datetime DEFAULT NULL,
  `cmp_observacao` varchar(255) DEFAULT NULL,
  `cmp_conta_lancada` datetime DEFAULT NULL,
  PRIMARY KEY (`cmp_id`),
  KEY `tb_entrada_FKIndex1` (`tb_fornecedores_for_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_compras VALUES('1', '1', '2021-10-26 11:27:40', '', '2021-10-26 15:04:58')
,('2', '2', '2021-10-26 11:28:43', 'Compra', '')
,('3', '3', '2021-10-26 11:29:25', '', '2021-10-26 11:41:28')
;

#
# //Criação da Tabela : tb_contas_pagar
#

CREATE TABLE `tb_contas_pagar` (
  `contp_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tb_fornecedores_for_id` int(10) unsigned NOT NULL,
  `tb_compras_cmp_id` int(10) unsigned NOT NULL,
  `contp_data` datetime DEFAULT NULL,
  `contp_data_venc` datetime DEFAULT NULL,
  `contp_data_pag` datetime DEFAULT NULL,
  `contp_valor` decimal(18,2) DEFAULT NULL,
  `contp_descricao` varchar(255) DEFAULT NULL,
  `contp_num_parcela` int(10) unsigned DEFAULT NULL,
  `contp_total_parcelas` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`contp_id`),
  KEY `tb_contas_pagar_FKIndex1` (`tb_compras_cmp_id`),
  KEY `tb_contas_pagar_FKIndex2` (`tb_fornecedores_for_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_contas_pagar VALUES('5', '3', '3', '2021-10-26 11:41:28', '2021-11-26 00:00:00', '', '15.00', '', '1', '1')
,('12', '1', '1', '2021-10-26 15:04:58', '2021-10-26 00:00:00', '', '111.00', '', '1', '3')
,('13', '1', '1', '2021-10-26 15:04:58', '2021-11-26 00:00:00', '', '111.00', '', '2', '3')
,('14', '1', '1', '2021-10-26 15:04:58', '2021-12-26 00:00:00', '', '111.00', '', '3', '3')
;

#
# //Criação da Tabela : tb_contas_receber
#

CREATE TABLE `tb_contas_receber` (
  `contr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tb_vendas_ven_id` int(10) unsigned NOT NULL,
  `tb_clientes_cli_id` int(10) unsigned NOT NULL,
  `contr_data` datetime DEFAULT NULL,
  `contr_data_venc` datetime DEFAULT NULL,
  `contr_data_rec` datetime DEFAULT NULL,
  `contr_valor` decimal(18,2) DEFAULT NULL,
  `contr_descricao` varchar(255) DEFAULT NULL,
  `contr_num_parcela` int(10) unsigned DEFAULT NULL,
  `contr_total_parcelas` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`contr_id`),
  KEY `tb_contas_receber_FKIndex1` (`tb_vendas_ven_id`),
  KEY `tb_contas_receber_FKIndex2` (`tb_clientes_cli_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_contas_receber VALUES('1', '1', '1', '2021-10-26 11:30:50', '2021-10-26 00:00:00', '2021-10-26 11:41:43', '28.00', '', '1', '2')
,('2', '1', '1', '2021-10-26 11:30:50', '2021-11-26 00:00:00', '', '28.00', '', '2', '2')
,('3', '2', '5', '2021-10-26 11:31:09', '2021-11-26 00:00:00', '', '90.00', '', '1', '1')
,('5', '3', '4', '2021-10-26 11:37:32', '2021-10-26 00:00:00', '2021-10-26 11:41:00', '40.00', '', '1', '1')
;

#
# //Criação da Tabela : tb_fornecedores
#

CREATE TABLE `tb_fornecedores` (
  `for_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `for_nome` varchar(255) DEFAULT NULL,
  `for_tipo_pessoa` char(2) DEFAULT NULL,
  `for_cpf_cnpj` varchar(14) DEFAULT NULL,
  `for_rg_ie` varchar(14) DEFAULT NULL,
  `for_endereco` varchar(255) DEFAULT NULL,
  `for_numero` int(10) unsigned DEFAULT NULL,
  `for_bairro` varchar(255) DEFAULT NULL,
  `for_cidade` varchar(255) DEFAULT NULL,
  `for_uf` varchar(2) DEFAULT NULL,
  `for_cep` varchar(8) DEFAULT NULL,
  `for_complemento` varchar(255) DEFAULT NULL,
  `for_celular` varchar(11) DEFAULT NULL,
  `for_telefone` varchar(10) DEFAULT NULL,
  `for_email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`for_id`),
  UNIQUE KEY `campos_unicos` (`for_cpf_cnpj`,`for_celular`,`for_telefone`,`for_email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_fornecedores VALUES('1', 'Ricardo e Nicolas Distribuidora', 'PJ', '34002690000130', '896704688521', 'Avenida Hum', '191', 'Jardim Oliveira II', 'Guarulhos', 'SP', '07152836', '', '11993203573', '1125710098', 'cobranca@ricardoenicolasconsultoriafinanceirame.com.br')
,('2', 'Alana e Manuela Produtora', 'PJ', '77690187000127', '781129399209', 'Rua João Sierra', '618', 'Distrito Industrial II', 'Araras', 'SP', '13602054', '', '19996635744', '1937056289', 'treinamento@alanaemanuelafinanceirame.com.br')
,('3', 'Luana e Marcelo Lavanderia ME', 'PJ', '61106390000173', '157771897899', 'Rua Nove', '147', 'Jardim Ana Maria', 'Guarujá', 'SP', '11441020', '', '13998478108', '1327571513', 'estoque@luanaemarcelolavanderiame.com.br')
;

#
# //Criação da Tabela : tb_img_prod
#

CREATE TABLE `tb_img_prod` (
  `pimg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tb_produtos_prod_id` int(10) unsigned NOT NULL,
  `pimg_url` varchar(255) DEFAULT NULL,
  `pimg_index` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`pimg_id`),
  KEY `tb_img_prod_FKIndex1` (`tb_produtos_prod_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_img_prod VALUES('1', '1', '/images/produtos/1635257490606.jpg', '1')
,('2', '2', '/images/produtos/1635257540273.jpg', '1')
;

#
# //Criação da Tabela : tb_insumos
#

CREATE TABLE `tb_insumos` (
  `ins_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ins_nome` varchar(255) DEFAULT NULL,
  `ins_descricao` varchar(255) DEFAULT NULL,
  `ins_preco` decimal(18,2) DEFAULT NULL,
  `ins_estoque` int(10) unsigned DEFAULT NULL,
  `ins_consumo` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`ins_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_insumos VALUES('1', 'Embalagem 500ml', 'Embalagem 500ml', '2.00', '100', '1')
,('2', 'Embalagem 1L', 'Embalagem para suco de 1 litro', '3.00', '190', '1')
,('3', 'Laranja (500ml)', 'Laranjas para suco de 500 ml', '0.50', '200', '5')
,('4', 'Laranja (1L)', 'Laranjas para suco de 1 litro', '0.50', '100', '10')
;

#
# //Criação da Tabela : tb_insumos_produto
#

CREATE TABLE `tb_insumos_produto` (
  `insprod_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tb_produtos_prod_id` int(10) unsigned NOT NULL,
  `tb_insumos_ins_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`insprod_id`),
  KEY `tb_insumos_produto_FKIndex1` (`tb_insumos_ins_id`),
  KEY `tb_insumos_produto_FKIndex2` (`tb_produtos_prod_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_insumos_produto VALUES('1', '1', '1')
,('2', '2', '2')
,('3', '1', '3')
,('4', '2', '4')
,('5', '2', '1')
;

#
# //Criação da Tabela : tb_insumos_venda
#

CREATE TABLE `tb_insumos_venda` (
  `insven_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tb_itens_venda_iven_id` int(10) unsigned NOT NULL,
  `tb_insumos_ins_id` int(10) unsigned NOT NULL,
  `insven_consumo` int(10) unsigned DEFAULT NULL,
  `insven_preco` decimal(18,2) DEFAULT NULL,
  PRIMARY KEY (`insven_id`),
  KEY `tb_insumos_venda_FKIndex1` (`tb_itens_venda_iven_id`),
  KEY `tb_insumos_venda_FKIndex2` (`tb_insumos_ins_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_insumos_venda VALUES('5', '4', '1', '1', '2.00')
,('6', '4', '3', '5', '0.50')
,('7', '5', '2', '1', '3.00')
,('8', '5', '4', '10', '0.50')
,('9', '6', '2', '1', '3.00')
,('10', '6', '4', '10', '0.50')
,('11', '7', '1', '1', '2.00')
,('12', '7', '3', '5', '0.50')
,('13', '8', '2', '1', '3.00')
,('14', '8', '4', '10', '0.50')
;

#
# //Criação da Tabela : tb_itens_compra
#

CREATE TABLE `tb_itens_compra` (
  `icmp_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tb_compras_cmp_id` int(10) unsigned NOT NULL,
  `tb_insumos_ins_id` int(10) unsigned NOT NULL,
  `icmp_quantidade` int(10) unsigned DEFAULT NULL,
  `icmp_preco` decimal(18,2) DEFAULT NULL,
  PRIMARY KEY (`icmp_id`,`tb_compras_cmp_id`),
  KEY `tb_itens_entrada_FKIndex1` (`tb_compras_cmp_id`),
  KEY `tb_itens_compra_FKIndex2` (`tb_insumos_ins_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_itens_compra VALUES('1', '1', '1', '6', '2.00')
,('2', '1', '2', '7', '3.00')
,('3', '2', '4', '70', '0.50')
,('4', '3', '3', '30', '0.50')
,('5', '1', '2', '100', '3.00')
;

#
# //Criação da Tabela : tb_itens_venda
#

CREATE TABLE `tb_itens_venda` (
  `iven_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tb_vendas_ven_id` int(10) unsigned NOT NULL,
  `tb_produtos_prod_id` int(10) unsigned NOT NULL,
  `iven_quantidade` int(10) unsigned NOT NULL,
  `iven_venda` decimal(18,2) DEFAULT NULL,
  `iven_custo` decimal(18,2) DEFAULT NULL,
  PRIMARY KEY (`iven_id`),
  KEY `tb_itens_venda_FKIndex1` (`tb_produtos_prod_id`),
  KEY `tb_itens_venda_FKIndex2` (`tb_vendas_ven_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_itens_venda VALUES('4', '1', '1', '2', '10.00', '5.00')
,('5', '1', '2', '2', '18.00', '10.00')
,('6', '2', '2', '5', '18.00', '10.00')
,('7', '3', '1', '4', '10.00', '5.00')
,('8', '4', '2', '10', '18.00', '10.00')
;

#
# //Criação da Tabela : tb_lgpd
#

CREATE TABLE `tb_lgpd` (
  `lgpd_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tb_usuarios_usr_id` int(10) unsigned NOT NULL,
  `lgpd_data` datetime DEFAULT NULL,
  PRIMARY KEY (`lgpd_id`),
  KEY `tb_lgpd_FKIndex1` (`tb_usuarios_usr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_lgpd VALUES('1', '1', '2021-10-26 10:34:07')
;

#
# //Criação da Tabela : tb_produtos
#

CREATE TABLE `tb_produtos` (
  `prod_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prod_nome` varchar(255) DEFAULT NULL,
  `prod_descricao` varchar(255) DEFAULT NULL,
  `prod_preco_venda` decimal(18,2) DEFAULT NULL,
  `prod_preco_custo` decimal(18,2) DEFAULT NULL,
  PRIMARY KEY (`prod_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_produtos VALUES('1', 'Suco Laranja 500ml', 'Suco 500ml', '10.00', '5.00')
,('2', 'Suco laranja 1L', 'Suco de 1 litro', '18.00', '10.00')
;

#
# //Criação da Tabela : tb_usuarios
#

CREATE TABLE `tb_usuarios` (
  `usr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usr_email` varchar(255) DEFAULT NULL,
  `usr_nome` varchar(255) DEFAULT NULL,
  `usr_senha` varchar(255) DEFAULT NULL,
  `usr_status` char(1) DEFAULT NULL,
  PRIMARY KEY (`usr_id`),
  UNIQUE KEY `campos_unicos` (`usr_email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_usuarios VALUES('1', 'luis@luis', 'Luis Eduardo', 'luis', 'A')
,('2', 'teste@teste', 'Teste', 'teste', 'A')
;

#
# //Criação da Tabela : tb_vendas
#

CREATE TABLE `tb_vendas` (
  `ven_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tb_clientes_cli_id` int(10) unsigned NOT NULL,
  `ven_data` datetime DEFAULT NULL,
  `ven_observacao` varchar(255) DEFAULT NULL,
  `ven_conta_lancada` datetime DEFAULT NULL,
  PRIMARY KEY (`ven_id`),
  KEY `tb_venda_FKIndex1` (`tb_clientes_cli_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 ;

#
# //Dados a serem incluídos na tabela
#

INSERT INTO tb_vendas VALUES('1', '1', '2021-10-26 11:16:56', '', '2021-10-26 11:30:50')
,('2', '5', '2021-10-26 11:22:11', 'Teste', '2021-10-26 11:31:09')
,('3', '4', '2021-10-26 11:24:29', '', '2021-10-26 11:37:32')
,('4', '3', '2021-10-26 11:42:32', '', '')
;
