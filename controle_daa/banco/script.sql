DROP TABLE if exists justificativa;
DROP TABLE if exists faltas;
DROP TABLE if exists professor;
DROP TABLE if exists coordenacao;
DROP TABLE if exists sala;

create table modulo (
   id_modulo    integer(11) not null AUTO_INCREMENT,
   nome         varchar(50) default '',
   path         varchar(100) not null,
   seq          integer(2) not null,
primary key (id_modulo),
unique key id_modulo (id_modulo),
unique key nome_modulo (nome)   
);

insert into modulo values('DOCENTES','freq_docentes',1);
insert into modulo values('MONITORES','monitor',2);
insert into modulo values('SISTEMA','geral',2);

drop table itemmenu;

create table itemmenu (
   id_modulo   integer(11) not null,
   id_itemmenu  varchar(11) not null,
   nome         varchar(50) not null,
   tipo_tela    varchar(50),
   tela         varchar(50),
   tipo         varchar(1) not null check (tipo in ('I','S')),
primary key (id_modulo, id_itemmenu),
unique key id_modulo_itemmenu (id_modulo, id_itemmenu),
FOREIGN KEY(id_modulo) REFERENCES modulo(id_modulo)
);

INSERT INTO `itemmenu` (`id_modulo`, `id_itemmenu`, `nome`, `tipo_tela`, `tela`, `tipo`) VALUES
(1, '1', 'Cadastro', NULL, NULL, 'S'),
(1, '1.1', 'Coordenacao', 'form', 'coordenacao', 'I'),
(1, '1.2', 'Professor', 'form', 'professor', 'I'),
(1, '1.3', 'Turma', 'form', 'sala', 'I'),
(1, '2', 'Apontamento', NULL, NULL, 'S'),
(1, '2.1', 'Faltas', 'form', 'faltas', 'I'),
(1, '2.2', 'Justificativa', 'form', 'justificativa', 'I'),
(1, '3', 'Controle Apontamento', 'form', 'fechamento', 'I'),
(1, '4', 'Relatorio', NULL, NULL, 'S'),
(1, '4.1', 'Relatorio de Turma', 'rel', 'sala/index', 'I'),
(1, '4.2', 'Relatorio de Coordenacao', 'rel', 'coordenacao/index', 'I'),
(1, '4.3', 'Relatorio de Professor', 'rel', 'professor/index_professor', 'I'),
(1, '4.4', 'Relatorio de Falta', 'rel', 'faltas/index_faltas', 'I'),
(1, '4.5', 'Relatorio de Justificativa', 'rel', 'justificativa/index', 'I'),
(1, '4.6', 'Relatorio de Controle Apontamento', 'rel', 'fechamento/index', 'I'),
(1, '4.7', 'Relatorio de Mapa de Falta', 'rel', 'faltas/index_mapafaltas', 'I');
INSERT INTO `itemmenu` (`id_modulo`, `id_itemmenu`, `nome`, `tipo_tela`, `tela`, `tipo`) VALUES
(2, '1', 'Cadastro', NULL, NULL, 'S'),
(2, '1.1', 'Curso', 'form', 'curso', 'I'),
(2, '1.1', 'Monitor', 'form', 'monitor', 'I');
INSERT INTO `itemmenu` (`id_modulo`, `id_itemmenu`, `nome`, `tipo_tela`, `tela`, `tipo`) VALUES
(3, '1', 'Usuario', 'form', 'usuario', 'I'),
(3, '2', 'Comando SQL', 'form', 'sql', 'I'),
(3, '3', 'Alterar Senha', 'form', 'senha', 'I'),
(3, '4', 'SAIR', 'session', 'logoff', 'I');

CREATE TABLE usuario (
  id_usuario   integer(11) not null AUTO_INCREMENT,
  nome         varchar(100) DEFAULT '',
  login        varchar(20) not null,
  senha        varchar(50) not null,
  telefone     varchar(20) not null,
  email        varchar(100),
  ativo        varchar(1),
  tipo         int(3) not null //,
  ultacesso    varchar(50),
  primary key (id_usuario),
  unique key id_sala (login)
);

create table permissao (
  id_usuario   integer(11) not null AUTO_INCREMENT,
  id_modulo   integer(11) not null,
  id_itemmenu  varchar(11) not null,
 PRIMARY KEY (id_usuario, id_modulo, id_itemmenu), 
 FOREIGN KEY(id_usuario) REFERENCES usuario(id_usuario), 
 FOREIGN KEY(id_modulo) REFERENCES modulo(id_modulo), 
 FOREIGN KEY(id_modulo, id_itemmenu) REFERENCES itemmenu(id_modulo, id_itemmenu) 
);

insert into permissao select 1, id_modulo, id_itemmenu from itemmenu;

CREATE TABLE sala (
  id_sala    integer(11) not null AUTO_INCREMENT,
  nome       varchar(100) DEFAULT '',
  primary key (id_sala),
  unique key id_sala (id_sala)
);


CREATE TABLE coordenacao ( 
 id_coordenacao  INTEGER(11) not null AUTO_INCREMENT, 
 nome            VARCHAR(100) DEFAULT '',
 email            VARCHAR(100) DEFAULT '',
 PRIMARY KEY (id_coordenacao), 
 UNIQUE KEY id_coordenacao (id_coordenacao)
 );  

INSERT INTO coordenacao (nome, email) values('NAO CADASTRADO','');
INSERT INTO coordenacao (nome, email) values('QUIMICA','');
INSERT INTO coordenacao (nome, email) values('INFORMATICA','');
INSERT INTO coordenacao (nome, email) values('SEGURANCA TRABALHO','');
INSERT INTO coordenacao (nome, email) values('LINGUAGENS E CODIGOS','');
INSERT INTO coordenacao (nome, email) values('ELETRONICA','');
INSERT INTO coordenacao (nome, email) values('DESIGN','');
INSERT INTO coordenacao (nome, email) values('TURISMO/HOTELARIA','');
INSERT INTO coordenacao (nome, email) values('FISICA','');
INSERT INTO coordenacao (nome, email) values('EDFICACOES','');
INSERT INTO coordenacao (nome, email) values('EIXO PEDAGOGICO','');
INSERT INTO coordenacao (nome, email) values('CIENCIAS HUMANAS','');
INSERT INTO coordenacao (nome, email) values('ELETROTECNICA','');
INSERT INTO coordenacao (nome, email) values('ESPORTES','');
INSERT INTO coordenacao (nome, email) values('MATEMATICA','');
INSERT INTO coordenacao (nome, email) values('MECANICA','');
INSERT INTO coordenacao (nome, email) values('ESTRADAS','');
INSERT INTO coordenacao (nome, email) values('LICENCIATURA EM MATEMATICA','');
INSERT INTO coordenacao (nome, email) values('BIOLOGIA','');
 
CREATE TABLE professor ( 
 id_professor    INTEGER(11) NOT NULL AUTO_INCREMENT, 
 siape           INTEGER(11) , 
 nome            VARCHAR(100) DEFAULT '',
 telefone        varchar(20),
 email           varchar(100),
 id_coordenacao  INTEGER(11),
 mes_ativo       date, 
 mes_inativo     date,
 carga_hr        INTEGER(4) default 0, 
 PRIMARY KEY (id_professor, siape), 
 UNIQUE KEY id_professor (id_professor, siape),
 FOREIGN KEY(id_coordenacao) REFERENCES coordenacao(id_coordenacao) 
);

insert into professor (nome, siape, id_coordenacao) values ('ABEL COELHO DA SILVA NETO',1584720,2);
insert into professor (nome, siape, id_coordenacao) values ('ABHAAO VERCOSA AMORIM',1813804,4);
insert into professor (nome, siape, id_coordenacao) values ('ADELAYDE RODRIGUES A. DE OLIVEIRA',1880862,5);
insert into professor (nome, siape, id_coordenacao) values ('ADRIANA DOS SANTOS FRANCO',2311654,6);
insert into professor (nome, siape, id_coordenacao) values ('ADRIANA PAULA QUIXABEIRA R. E SILVA ',1223050,7);
insert into professor (nome, siape, id_coordenacao) values ('ADRIANA THIARA DE OLIVEIRA SILVA',1162493,8);
insert into professor (nome, siape, id_coordenacao) values ('ADRIANO MALTA LOBO',188496,9);
insert into professor (nome, siape, id_coordenacao) values ('AFRANIO JORGE BARBOSA CAMPOS',1201145,10);
insert into professor (nome, siape, id_coordenacao) values ('AILTON FELIX DE LIMA FILHO',20190800001,3);
insert into professor (nome, siape, id_coordenacao) values ('ALAN JOHN DUARTE DE FREITAS',1621894,2);
insert into professor (nome, siape, id_coordenacao) values ('ALBERTO JORGE SANTOS DE ALMEIDA',1703845,6);
insert into professor (nome, siape, id_coordenacao) values ('ALEX EMANUEL BARROS COSTA',1882268,9);
insert into professor (nome, siape, id_coordenacao) values ('ALEX MELO DA SILVA',3006502,3);
insert into professor (nome, siape, id_coordenacao) values ('ALEXANDRE CUNHA MACHADO ',1583979,10);
insert into professor (nome, siape, id_coordenacao) values ('ALEXANDRE FELIPE DE V. SANTOS',3024763,10);
insert into professor (nome, siape, id_coordenacao) values ('ALEXANDRE FLEMING VASQUES BASTOS',1582271,11);
insert into professor (nome, siape, id_coordenacao) values ('ALEXANDRE JOSE BRAGA DA SILVA',20190800002,3);
insert into professor (nome, siape, id_coordenacao) values ('ALEXANDRE LUIZ DE HOLANDA PADILHA',1194304,2);
insert into professor (nome, siape, id_coordenacao) values ('ALEXANDRE MELO DE OLIVIERA',2045126,5);
insert into professor (nome, siape, id_coordenacao) values ('ALICE MARIA MARINHO RODRIGUES LIMA',1914063,12);
insert into professor (nome, siape, id_coordenacao) values ('ALLAN CARLOS DA SILVA',1696916,12);
insert into professor (nome, siape, id_coordenacao) values ('ALMIR SANTOS DE MEDEIROS',1121799,5);
insert into professor (nome, siape, id_coordenacao) values ('ALISSON LUIZ NASCIMENTO DA SILVA',20190800003,13);
insert into professor (nome, siape, id_coordenacao) values ('ALYSSON MATIAS LOPES DE LIMA',1913140,14);
insert into professor (nome, siape, id_coordenacao) values ('AMARO HELIO LEITE DA SILVA',1306655,12);
insert into professor (nome, siape, id_coordenacao) values ('AMAURY NOGUEIRA NETO',1068312,3);
insert into professor (nome, siape, id_coordenacao) values ('ANA CRISTINA SANTOS LIMEIRA',2078360,11);
insert into professor (nome, siape, id_coordenacao) values ('ANA LUIZA ARAUJO PORTO',1812886,12);
insert into professor (nome, siape, id_coordenacao) values ('ANDERSON RANGEL BATISTA SIQUEIRA',1915695,15);
insert into professor (nome, siape, id_coordenacao) values ('ANDERSON RODRIGUES GOMES',1455322,3);
insert into professor (nome, siape, id_coordenacao) values ('ANDRE LUIZ NOVAES DE OLIVEIRA',1076872,13);
insert into professor (nome, siape, id_coordenacao) values ('ANDRE PINTO ROCHA',2695381,17);
insert into professor (nome, siape, id_coordenacao) values ('ANDREA LUCIA VITAL CORDEIRO LOPES',267567,10);
insert into professor (nome, siape, id_coordenacao) values ('ANDREA PEREIRA MORAES',2042063,12);
insert into professor (nome, siape, id_coordenacao) values ('ANGELA BARALDI PACHEGO',1047015,12);
insert into professor (nome, siape, id_coordenacao) values ('ANGELA CRISTINA PEREIRA BARROS',2347955,19);
insert into professor (nome, siape, id_coordenacao) values ('ANGELA SOUZA SALES',2111468,14);
insert into professor (nome, siape, id_coordenacao) values ('ANTENOR FARIAS BARBOSA',267525,6);
insert into professor (nome, siape, id_coordenacao) values ('ANTONIO ALBUQUERQUE DE SOUZA',1810293,2);
insert into professor (nome, siape, id_coordenacao) values ('ANTONIO CARLOS SANTOS DE LIMA',1809639,5);
insert into professor (nome, siape, id_coordenacao) values ('ANTONIO CELIO LINS DO NASCIMENTO',1188239,5);
insert into professor (nome, siape, id_coordenacao) values ('ANTONIO CICERO DE ARAUJO',1220676,5);
insert into professor (nome, siape, id_coordenacao) values ('ANTONIO JOSE PLACIDO DE MELO',1488664,1);
insert into professor (nome, siape, id_coordenacao) values ('ANTONIO WARNER DE A VASCONCELOS',1673843,5);
insert into professor (nome, siape, id_coordenacao) values ('ANWAR JOSE DE OLIVEIRA SOUZA',20190800004,3);
insert into professor (nome, siape, id_coordenacao) values ('ARI DENISSON DA SILVA',1656882,5);
insert into professor (nome, siape, id_coordenacao) values ('ARLYSON ALVES DO NASCIMENTO',3007967,18);
insert into professor (nome, siape, id_coordenacao) values ('ARMANDO CELESTINO DOS SANTOS',267517,15);
insert into professor (nome, siape, id_coordenacao) values ('ARNON CASSIANO DA SILVA',1191173,14);
insert into professor (nome, siape, id_coordenacao) values ('AUGUSTO CESAR MELO DE OLIVEIRA',1755972,3);
insert into professor (nome, siape, id_coordenacao) values ('AUREA LUIZA QUIXABEIRA ROSA E SILVA',2050828,7);
insert into professor (nome, siape, id_coordenacao) values ('BENEDITO NASCIMENTO',267260,16);
insert into professor (nome, siape, id_coordenacao) values ('BEROALDO RODRIGUES DOS SANTOS',1646861,4);
insert into professor (nome, siape, id_coordenacao) values ('BRENO JACINTO DUARTE DA COSTA',1746551,3);
insert into professor (nome, siape, id_coordenacao) values ('BRUNO RODRIGUES BESSA',2866185,3);
insert into professor (nome, siape, id_coordenacao) values ('CAMILA ANTUNES DE CARVALHO CASADO',1869589,7);
insert into professor (nome, siape, id_coordenacao) values ('CAMILA LIMA DA COSTA',2407352,15);
insert into professor (nome, siape, id_coordenacao) values ('CAMILA SAMPAIO BEZERRA DA SILVA',2615587,2);
insert into professor (nome, siape, id_coordenacao) values ('CARLOS ALBERTO DA SILVA',267348,13);
insert into professor (nome, siape, id_coordenacao) values ('CARLOS ALBERTO DE HYBI CERQUEIRA',1068622,13);
insert into professor (nome, siape, id_coordenacao) values ('CARLOS ALBERTO SILVA DOS SANTOS',1702583,18);
insert into professor (nome, siape, id_coordenacao) values ('CARLOS ALBERTO VANDERLEI VANGASSE',267417,6);
insert into professor (nome, siape, id_coordenacao) values ('CARLOS HENRIQUE ALMEIDA ALVES',981884,5);
insert into professor (nome, siape, id_coordenacao) values ('CARLOS MARCELO DE ARAUJO BIBIANO',981965,10);
insert into professor (nome, siape, id_coordenacao) values ('CARLOS MENEZES DE SOUZA JUNIOR',1670729,14);
insert into professor (nome, siape, id_coordenacao) values ('CARLSON LAMENHA APOLINARIO',267321,14);
insert into professor (nome, siape, id_coordenacao) values ('CASSIO HARTMANN',1809583,14);
insert into professor (nome, siape, id_coordenacao) values ('CECILIA DANTAS VICENTE ',1524170,2);
insert into professor (nome, siape, id_coordenacao) values ('CELENE ALVES DA SILVA',2415758,17);
insert into professor (nome, siape, id_coordenacao) values ('CELSO SILVA CALDAS ',1311882,2);
insert into professor (nome, siape, id_coordenacao) values ('CHARRIDY MAX FONTES PINTO',20718800,5);
insert into professor (nome, siape, id_coordenacao) values ('CHRISTIANE BATINGA AGRA',2045781,5);
insert into professor (nome, siape, id_coordenacao) values ('CLAUDIA CORDEIRO DE ASSIS',1454860,4);
insert into professor (nome, siape, id_coordenacao) values ('CLAUDIO ESTEVAO BERGAMINI',2893579,10);
insert into professor (nome, siape, id_coordenacao) values ('CLAUDIONOR FERREIRA ARAUJO',20190800005,5);
insert into professor (nome, siape, id_coordenacao) values ('CLEBER NAUBER DOS SANTOS',1976022,7);
insert into professor (nome, siape, id_coordenacao) values ('CLEIDE CALHEIROS DA SILVA',2045153,5);
insert into professor (nome, siape, id_coordenacao) values ('CLEUNIS BRANDAO RIBEIRO',2177836,16);
insert into professor (nome, siape, id_coordenacao) values ('CLEUSA SALVINA R. M. BARBOSA',1478667,5);
insert into professor (nome, siape, id_coordenacao) values ('CLEVERTON DA SILVA VASCONCELOS',1975284,15);
insert into professor (nome, siape, id_coordenacao) values ('CLEYLTON BEZERRA LOPES',1890963,2);
insert into professor (nome, siape, id_coordenacao) values ('CRISTINE GONCALVES DE CASTRO ',1584714,10);
insert into professor (nome, siape, id_coordenacao) values ('DACIO LOPES CAMERINO FILHO',20190800006,9);
insert into professor (nome, siape, id_coordenacao) values ('DAMIAO AUGUSTO DE FARIAS SANTOS',1033614,5);
insert into professor (nome, siape, id_coordenacao) values ('DANIEL COTRIM CAMERINO',1809188,15);
insert into professor (nome, siape, id_coordenacao) values ('DANIEL DE JESUS PEREIRA',2410916,8);
insert into professor (nome, siape, id_coordenacao) values ('DANIEL FERREIRA DA GUIA',267419,6);
insert into professor (nome, siape, id_coordenacao) values ('DANIEL RIBEIRO DE MENDONCA',1813350,2);
insert into professor (nome, siape, id_coordenacao) values ('DANIELA PEREIRA DE LIMA',3027081,1);
insert into professor (nome, siape, id_coordenacao) values ('DANIELA RIBEIRO BULHOES JOBIM',1675284,12);
insert into professor (nome, siape, id_coordenacao) values ('DANIELLE BARBOSA BEZERRA',1461814,19);
insert into professor (nome, siape, id_coordenacao) values ('DANIELLE COTTA DE MELO N. DA SILVA',1677699,2);
insert into professor (nome, siape, id_coordenacao) values ('DANIELLY CALDAS DE OLIVEIRA',1698960,5);
insert into professor (nome, siape, id_coordenacao) values ('DAVID GOMES COSTA',1609773,12);
insert into professor (nome, siape, id_coordenacao) values ('DAVID WANDERLEY SILVA LINS ',1187926,12);
insert into professor (nome, siape, id_coordenacao) values ('DEMETRIUS PEREIRA MORILLA',1900468,2);
insert into professor (nome, siape, id_coordenacao) values ('DENIS ROCHA CALAZANS',1420307,12);
insert into professor (nome, siape, id_coordenacao) values ('DENISE LAGES VIEIRA DA SILVA',1978706,7);
insert into professor (nome, siape, id_coordenacao) values ('DENISE MAGALHAES DUTRA',1674175,5);
insert into professor (nome, siape, id_coordenacao) values ('DEYSE FERREIRA ROCHA',1545942,19);
insert into professor (nome, siape, id_coordenacao) values ('DILZA GOMES DE OMENA',3113942,19);
insert into professor (nome, siape, id_coordenacao) values ('DIVANIR MARIA DE LIMA',1813588,1);
insert into professor (nome, siape, id_coordenacao) values ('DJALMA DE ALBUQUERQUE BARROS FILHO ',1372367,9);
insert into professor (nome, siape, id_coordenacao) values ('EBENEZER BERNANDES CORREIA SILVA',1673736,19);
insert into professor (nome, siape, id_coordenacao) values ('EDISON CAMILO DE MORAES JUNIOR',2191508,3);
insert into professor (nome, siape, id_coordenacao) values ('EDJA LAURINDO DE LIMA',3212537,10);
insert into professor (nome, siape, id_coordenacao) values ('EDMAR MARINHO DE AZEVEDO',2418964,2);
insert into professor (nome, siape, id_coordenacao) values ('EDNILSON GOMES MATIAS',2046330,12);
insert into professor (nome, siape, id_coordenacao) values ('EDRIANE TEIXEIRA DA SILVA',2118662,2);
insert into professor (nome, siape, id_coordenacao) values ('EDUARDO CARDOSO MORAES',1802501,3);
insert into professor (nome, siape, id_coordenacao) values ('EDUARDO FRIGOLETTO DE MENEZES',1510191,12);
insert into professor (nome, siape, id_coordenacao) values ('EDUARDO HENRIQUE OMENA BASTOS',1915332,7);
insert into professor (nome, siape, id_coordenacao) values ('EDUARDO HENRIQUE VIANA DE SOUSA',1653997,16);
insert into professor (nome, siape, id_coordenacao) values ('EDUARDO LIMA DO SANTOS',2721552,2);
insert into professor (nome, siape, id_coordenacao) values ('EDVANIA MEDEIROS DE OMENA',2055801,5);
insert into professor (nome, siape, id_coordenacao) values ('ELAINE CRISTINA DOS SANTOS LIMA',2045424,12);
insert into professor (nome, siape, id_coordenacao) values ('ELAINE DOS REIS SOEIRA',1666549,11);
insert into professor (nome, siape, id_coordenacao) values ('ELAINE DOS SANTOS SGARBI',2945023,5);
insert into professor (nome, siape, id_coordenacao) values ('ELIANE DOS SANTOS ALENCAR',3126584,9);
insert into professor (nome, siape, id_coordenacao) values ('ELISABETE DUARTE DE OLIVEIRA',1693451,11);
insert into professor (nome, siape, id_coordenacao) values ('ELTON NASCIMENTO BARRROS',20190800007,14);
insert into professor (nome, siape, id_coordenacao) values ('ELVYS ALVES SOARES',1688380,3);
insert into professor (nome, siape, id_coordenacao) values ('EMANUEL GOMES MARQUES',2201226,1);
insert into professor (nome, siape, id_coordenacao) values ('EMANUELLE SATIKO MONTEIRO MATSUMOTO',3123471,9);
insert into professor (nome, siape, id_coordenacao) values ('EMERSON MARTINS SILVA',2407352,3);
insert into professor (nome, siape, id_coordenacao) values ('ENALDO VIEIRA DE MELO',2040642,15);
insert into professor (nome, siape, id_coordenacao) values ('ERONILMA BARBOSA DA SILVA',1552757,5);
insert into professor (nome, siape, id_coordenacao) values ('ESTEVAM ALVES MOREIRA NETO',2042144,12);
insert into professor (nome, siape, id_coordenacao) values ('EUNICE PALMEIRA DA SILVA',2422219,1);
insert into professor (nome, siape, id_coordenacao) values ('EVERT ELVIS BATISTA DE ALMEIDA',2248031,16);
insert into professor (nome, siape, id_coordenacao) values ('FABIANO DOS SANTOS BRIAO',20190800008,15);
insert into professor (nome, siape, id_coordenacao) values ('FABIO JOSE DOS SANTOS',1723813,5);
insert into professor (nome, siape, id_coordenacao) values ('FABIO MAURICIO DO BONFIM CALAZANS',1186906,19);
insert into professor (nome, siape, id_coordenacao) values ('FABIO SOARES GOMES',1477734,8);
insert into professor (nome, siape, id_coordenacao) values ('FABRISIA FERREIRA DE ARAUJO',1186979,3);
insert into professor (nome, siape, id_coordenacao) values ('FELIPE CESAR MARQUES TUPINAMBA',2362071,12);
insert into professor (nome, siape, id_coordenacao) values ('FELIPE VASCONCELOS CAVALCANTE',2295926,8);
insert into professor (nome, siape, id_coordenacao) values ('FERNANDO GUSTAVO ALENCAR DE ALB. LINS',1187734,16);
insert into professor (nome, siape, id_coordenacao) values ('FERNANDO HENRIQUE M. VASCONCELOS',1033504,17);
insert into professor (nome, siape, id_coordenacao) values ('FERNANDO JOSE DA SILVA',1187505,16);
insert into professor (nome, siape, id_coordenacao) values ('FERNANDO KENJI KAMEI',1897878,3);
insert into professor (nome, siape, id_coordenacao) values ('FLAVIA BRAGA DO NASCIMENTO SERBIM',18923267,2);
insert into professor (nome, siape, id_coordenacao) values ('FLAVIA KAROLINA LIMA DUARTE BARBOSA',1805693,5);
insert into professor (nome, siape, id_coordenacao) values ('FLAVIO MOTA MEDEIROS',1812957,3);
insert into professor (nome, siape, id_coordenacao) values ('FRANCYMAIKEL ALVES DE OLIVEIRA COSTA',2000143,12);
insert into professor (nome, siape, id_coordenacao) values ('FRANK WESLEY XAVIER DA SILVA',1343376,16);
insert into professor (nome, siape, id_coordenacao) values ('FRED AUGUSTO RIBEIRO NOGUEIRA',1894009,2);
insert into professor (nome, siape, id_coordenacao) values ('FREDERICO SALGUEIRO PASSOS',1867551,9);
insert into professor (nome, siape, id_coordenacao) values ('FREDY LOBO MONTEIRO',1317879,5);
insert into professor (nome, siape, id_coordenacao) values ('GENIVALDO ROCHA WANDERLEY',1186916,16);
insert into professor (nome, siape, id_coordenacao) values ('GEORGE FLAVIO PEREIRA CHAVES',1478141,6);
insert into professor (nome, siape, id_coordenacao) values ('GERSON MACIEL GUIMARAES',2871947,12);
insert into professor (nome, siape, id_coordenacao) values ('GERTRUDES MAGNA SALES DA SILVA',1250196,8);
insert into professor (nome, siape, id_coordenacao) values ('GILMAR SOARES FURTADO ',1250196,8);
insert into professor (nome, siape, id_coordenacao) values ('GILMAR TEODOSIO SILVA',1915163,15);
insert into professor (nome, siape, id_coordenacao) values ('GILSON LAURENTINO DA SILVA',267351,13);
insert into professor (nome, siape, id_coordenacao) values ('GIULIANO RAPOSO RODRIGUES',1916114,9);
insert into professor (nome, siape, id_coordenacao) values ('GIVALDO OLIVEIRA DOS SANTOS',1181073,18);
insert into professor (nome, siape, id_coordenacao) values ('GRACINO FRANCISCO RODRIGUES',1976335,18);
insert into professor (nome, siape, id_coordenacao) values ('GREGOR GAMA DE CARVALHO',1977512,6);
insert into professor (nome, siape, id_coordenacao) values ('GREGORY AGUIAR CALDAS BARBOSA',1703854,17);
insert into professor (nome, siape, id_coordenacao) values ('GUSTAVO PESSOA',20190800009,12);
insert into professor (nome, siape, id_coordenacao) values ('HEBERTH BRAGA GONCALVES RIBEIRO',20190800010,3);
insert into professor (nome, siape, id_coordenacao) values ('HELCIO BEZERRA DO NASCIMENTO JUNIOR',1582362,9);
insert into professor (nome, siape, id_coordenacao) values ('HENRIQUE ADRIANO DE MACENA MARQUES ',1979620,9);
insert into professor (nome, siape, id_coordenacao) values ('HERCULES DE LUCENA LIRA ',2568227,2);
insert into professor (nome, siape, id_coordenacao) values ('HERON TEIXEIRA AMORIM',1227660,9);
insert into professor (nome, siape, id_coordenacao) values ('HUDSON KLEBER PALMEIRA CANNUTO',1690338,5);
insert into professor (nome, siape, id_coordenacao) values ('HUGO SANTOS NUNES',223068,18);
insert into professor (nome, siape, id_coordenacao) values ('HUMBERTO JORGE BRAGA CAVALCANTI',1049961,10);
insert into professor (nome, siape, id_coordenacao) values ('IARA BARROS VALENTIM',1981781,2);
insert into professor (nome, siape, id_coordenacao) values ('ILKA DE CARVALHO CEDRIM',1893378,5);
insert into professor (nome, siape, id_coordenacao) values ('IOLITA MARQUES LIRA',267524,7);
insert into professor (nome, siape, id_coordenacao) values ('IVANILDO CAVALCANTI TIMOTEO',17805740,16);
insert into professor (nome, siape, id_coordenacao) values ('IVO AUGUSTO ANDRADE ROCHA CALADO',17805740,3);
insert into professor (nome, siape, id_coordenacao) values ('JACEGUAI SOARES DA SILVA',20190800011,2);
insert into professor (nome, siape, id_coordenacao) values ('JACKSON PINTO SILVA',1984834,12);
insert into professor (nome, siape, id_coordenacao) values ('JACSIEL JOSE DE ABREU',2781183,13);
insert into professor (nome, siape, id_coordenacao) values ('JAILTON CARDOSO DA CRUZ',1242869,3);
insert into professor (nome, siape, id_coordenacao) values ('JAKSON ISRAEL LIMA DE MENDES',2981398,14);
insert into professor (nome, siape, id_coordenacao) values ('JANAINA GOMES SOARES',2050032,2);
insert into professor (nome, siape, id_coordenacao) values ('JASETE MARIA DA SILVA PEREIRA',1514494,8);
insert into professor (nome, siape, id_coordenacao) values ('JEAN JACQUES BITTENCOURT DA ROCHA',1288303,13);
insert into professor (nome, siape, id_coordenacao) values ('JEANE MARIA DE MELO',1080952,5);
insert into professor (nome, siape, id_coordenacao) values ('JEILMA RODRIGUES DO NASCIMENTO',3025797,2);
insert into professor (nome, siape, id_coordenacao) values ('JEINNY CHRISTINE GOMES DOS SANTOS',1049674,2);
insert into professor (nome, siape, id_coordenacao) values ('JESU COSTA FERREIRA JUNIOR',1888951,2);
insert into professor (nome, siape, id_coordenacao) values ('JOACY VICENTE FERREIRA',1485255,2);
insert into professor (nome, siape, id_coordenacao) values ('JOAO GILBERTO TEIXEIRA SILVA',2615597,10);
insert into professor (nome, siape, id_coordenacao) values ('JOAO HENRIQUE DA COSTA CARDOSO',1034006,6);
insert into professor (nome, siape, id_coordenacao) values ('JOAQUIM ALEXANDRE MOREIRA AZEVEDO',2567890,12);
insert into professor (nome, siape, id_coordenacao) values ('JOEFERSON REIS MARTINS',1814627,19);
insert into professor (nome, siape, id_coordenacao) values ('JOHNNATAN DUARTE DE FREITAS',1524190,2);
insert into professor (nome, siape, id_coordenacao) values ('JONAS DOS SANTOS SOUSA',1677727,2);
insert into professor (nome, siape, id_coordenacao) values ('JORGE BATISTA SANTOS JUNIOR',267096,13);
insert into professor (nome, siape, id_coordenacao) values ('JORGE LEVINO SILVA',267319,4);
insert into professor (nome, siape, id_coordenacao) values ('JORGE LUIZ ARAUJO ROCHA',20190800012,9);
insert into professor (nome, siape, id_coordenacao) values ('JORGE LUIZ LAURIANO GAMA',2175844,16);
insert into professor (nome, siape, id_coordenacao) values ('JOSE ALMEIDA DOS SANTOS',1529641,8);
insert into professor (nome, siape, id_coordenacao) values ('JOSE ANTONIO FRANCA DE ARAUJO',2161943,16);
insert into professor (nome, siape, id_coordenacao) values ('JOSE DE HOLANDA CAVALCANTE JUNIOR',2895323,16);
insert into professor (nome, siape, id_coordenacao) values ('JOSE DIEGO MAGALHAES SOARES',2045094,2);
insert into professor (nome, siape, id_coordenacao) values ('JOSE DOS SANTOS',267087,16);
insert into professor (nome, siape, id_coordenacao) values ('JOSE JADILSON NUNES DE MACEDO',20190800013,19);
insert into professor (nome, siape, id_coordenacao) values ('JOSE MARTINS DOS SANTOS SOBRINHO',1210945,7);
insert into professor (nome, siape, id_coordenacao) values ('JOSE MAURICIO PEREIRA PINTO',1213713,12);
insert into professor (nome, siape, id_coordenacao) values ('JOSE ROBERTO NUNES DO SANTOS',20190800014,15);
insert into professor (nome, siape, id_coordenacao) values ('JOSE SILVIO DOS SANTOS',1964212,12);
insert into professor (nome, siape, id_coordenacao) values ('JOSENICE CLAUDIA MOURA DE LIMA',1672636,5);
insert into professor (nome, siape, id_coordenacao) values ('JOSIVAL NASCIMENTO DOS SANTOS',20190800015,1);
insert into professor (nome, siape, id_coordenacao) values ('JOSIVALDO ROCHA SANTOS',267278,16);
insert into professor (nome, siape, id_coordenacao) values ('JULIANA AGUIAR C. MONTEIRO',1924884,7);
insert into professor (nome, siape, id_coordenacao) values ('JULIO CESAR A . DA ROCHA',1337873,5);
insert into professor (nome, siape, id_coordenacao) values ('KALLYNE ROUSE VALERIANO NUNES',1914038,4);
insert into professor (nome, siape, id_coordenacao) values ('KARINA DIAS ALVES',1954061,19);
insert into professor (nome, siape, id_coordenacao) values ('KARINE VASCONCELOS LEITE',1372257,5);
insert into professor (nome, siape, id_coordenacao) values ('LAURO LOPES PEREIRA NETO',1199292,12);
insert into professor (nome, siape, id_coordenacao) values ('LEONARDO MELO MEDEIROS',1812154,3);
insert into professor (nome, siape, id_coordenacao) values ('LEONARDO VIEIRA DA SILVA',2170735,2);
insert into professor (nome, siape, id_coordenacao) values ('LEONIDAS LEAO BORGES ',1091241,13);
insert into professor (nome, siape, id_coordenacao) values ('LESSO BENEDITO DOS SANTOS ',10788141,16);
insert into professor (nome, siape, id_coordenacao) values ('LOURIVAL LOPES DOS SANTOS FILHO',1584053,10);
insert into professor (nome, siape, id_coordenacao) values ('LUCAS DE STEFANO MEIRA HENRIQUES',1918676,18);
insert into professor (nome, siape, id_coordenacao) values ('LUCIA CORDEIRO DOS SANTOS',267317,5);
insert into professor (nome, siape, id_coordenacao) values ('LUCIA GUIOMAR BASTO FRAGOSO',1813812,4);
insert into professor (nome, siape, id_coordenacao) values ('LUCIANO MARRA',1345026,12);
insert into professor (nome, siape, id_coordenacao) values ('LUIS CLAUDIO DE AVILA TRANI',1243040,13);
insert into professor (nome, siape, id_coordenacao) values ('LUIZ ANTONIO COSTA SILVA',1071869,7);
insert into professor (nome, siape, id_coordenacao) values ('LUIZ EDUARDO OMENA DA SILVA',20190800016,16);
insert into professor (nome, siape, id_coordenacao) values ('LUIZ GALDINO DA SILVA',1168188,18);
insert into professor (nome, siape, id_coordenacao) values ('LUIZ GOMES DUARTE NETO',1670692,16);
insert into professor (nome, siape, id_coordenacao) values ('LUIZ HENRIQUE DE GOUVEA LEMOS',267516,2);
insert into professor (nome, siape, id_coordenacao) values ('MAGNO FRANCISCO DA SILVA',1058840,12);
insert into professor (nome, siape, id_coordenacao) values ('MAGNO JOSE GOMES DA SILVA',267528,13);
insert into professor (nome, siape, id_coordenacao) values ('MANOEL MARTINS DOS SANTOS FILHO',257275,10);
insert into professor (nome, siape, id_coordenacao) values ('MANOEL MESSIAS DOMINGOS DA SILVA',267508,16);
insert into professor (nome, siape, id_coordenacao) values ('MARCELO ASSIS CORREA',1322996,13);
insert into professor (nome, siape, id_coordenacao) values ('MARCELO QUEIROZ DE ASSIS OLIVEIRA',1323234,3);
insert into professor (nome, siape, id_coordenacao) values ('MARCIAL DE ARAUJO LIMA SOBRINHO',981922,17);
insert into professor (nome, siape, id_coordenacao) values ('MARCIO CAVALCANTE VILA NOVA',1756700,19);
insert into professor (nome, siape, id_coordenacao) values ('MARCIO DE CARVALHO GOBBI',1668478,13);
insert into professor (nome, siape, id_coordenacao) values ('MARCOS ANTONIO SANTOS SILVA',1108326,1);
insert into professor (nome, siape, id_coordenacao) values ('MARCOS HENRIQUE ABREU DE OLIVEIRA',1076869,9);
insert into professor (nome, siape, id_coordenacao) values ('MARCUS ALEXANDRE BUARQUE DA SILVA',267322,16);
insert into professor (nome, siape, id_coordenacao) values ('MARCUS VINICIUS DE A. GOMES',267518,16);
insert into professor (nome, siape, id_coordenacao) values ('MARIA APARECIDA SILVA',1109462,5);
insert into professor (nome, siape, id_coordenacao) values ('MARIA CLEDILMA F. DA SILVA COSTA',1813640,11);
insert into professor (nome, siape, id_coordenacao) values ('MARIA DE FATIMA MONTEIRO MENEZES',267248,5);
insert into professor (nome, siape, id_coordenacao) values ('MARIA DE FATIMA VIANA',267476,2);
insert into professor (nome, siape, id_coordenacao) values ('MARIA DO CARMO MILITO GAMA',1220674,5);
insert into professor (nome, siape, id_coordenacao) values ('MARIA GABRIELA LIRA RANGEL',1119765,17);
insert into professor (nome, siape, id_coordenacao) values ('MARIA IVANA PATRIOTA CARNAUBA',20190800017,11);
insert into professor (nome, siape, id_coordenacao) values ('MARIA IZABEL CORREIA SILVA DE MESSIAS',1495644,12);
insert into professor (nome, siape, id_coordenacao) values ('MARIA LOUSANNE DAMASCENO CORREIA',1209915,19);
insert into professor (nome, siape, id_coordenacao) values ('MARIA LUCILENE DA SILVA',1813679,5);
insert into professor (nome, siape, id_coordenacao) values ('MARIA LUZENITA WAGNER MALLMANN',1121294,19);
insert into professor (nome, siape, id_coordenacao) values ('MARIA RENY GOMES DOS SANTOS',3781247,12);
insert into professor (nome, siape, id_coordenacao) values ('MARILIA NIEDJA SANTOS DA COSTA ANDRADE',2085181,1);
insert into professor (nome, siape, id_coordenacao) values ('MAURICIO DOS SANTOS CORREIA',1080959,12);
insert into professor (nome, siape, id_coordenacao) values ('MEIJORES DE OMENA TENORIO',3141769,5);
insert into professor (nome, siape, id_coordenacao) values ('MERYLANE PORTO DA SILVA',1809213,19);
insert into professor (nome, siape, id_coordenacao) values ('MICHEL PONDEUS DE CARVALHO',1206088,12);
insert into professor (nome, siape, id_coordenacao) values ('MIKAEL DE LIMA FREITAS',2049946,2);
insert into professor (nome, siape, id_coordenacao) values ('MIQUELINA RODRIGUES DOS S. CASTRO',1523779,7);
insert into professor (nome, siape, id_coordenacao) values ('MIRIAN TENORIO MARANHAO LEAO',1779113,12);
insert into professor (nome, siape, id_coordenacao) values ('MONICA XIMENES CARNEIRO DA CUNHA ',1186961,3);
insert into professor (nome, siape, id_coordenacao) values ('NAELSON TOLEDO MENDONCA',267354,13);
insert into professor (nome, siape, id_coordenacao) values ('NATALIA SANTOS  FREITAS ',2720016,12);
insert into professor (nome, siape, id_coordenacao) values ('NEIDE GUIMARAES BORGES',1222214,1);
insert into professor (nome, siape, id_coordenacao) values ('NEWTON CESAR DE LIMA MENDES',267416,14);
insert into professor (nome, siape, id_coordenacao) values ('NILSON SALVADOR DOS SANTOS',267383,15);
insert into professor (nome, siape, id_coordenacao) values ('PATRICIA SOARES LINS',1220990,7);
insert into professor (nome, siape, id_coordenacao) values ('PAULO DOS SANTOS SILVA',267203,16);
insert into professor (nome, siape, id_coordenacao) values ('PAULO JORGE DE OLIVEIRA',267535,17);
insert into professor (nome, siape, id_coordenacao) values ('PETRUCIO LEOPOLDINO DE ASSIS JUNIOR',1953317,16);
insert into professor (nome, siape, id_coordenacao) values ('POLIANA PIMENTEL SILVA',20190800018,5);
insert into professor (nome, siape, id_coordenacao) values ('RAYNA VALERIA MACIEL DE OLIVEIRA',2358150,17);
insert into professor (nome, siape, id_coordenacao) values ('REGINA MARIA DE OLIVEIRA BRASILEIRO',1536968,11);
insert into professor (nome, siape, id_coordenacao) values ('RENATA MEDEIROS FRAGOSO ou CARVALHO',20190800019,1);
insert into professor (nome, siape, id_coordenacao) values ('RENATO CARVALHO MENEZES',1200325,4);
insert into professor (nome, siape, id_coordenacao) values ('RICARDO ALEX DE LIMA BARBOSA',267530,6);
insert into professor (nome, siape, id_coordenacao) values ('RICARDO DE ALBUQUERQUE AGUIAR',267118,2);
insert into professor (nome, siape, id_coordenacao) values ('RICARDO JORGE DE SOUSA CAVALCANTI',1813783,5);
insert into professor (nome, siape, id_coordenacao) values ('RICARDO RUBENS GOMES NUNES FILHO',1686496,3);
insert into professor (nome, siape, id_coordenacao) values ('RITA DE CASSIA COSTA',1210310,13);
insert into professor (nome, siape, id_coordenacao) values ('ROBERTO CARLOS COIMBRA PEIXOTO',1094720,7);
insert into professor (nome, siape, id_coordenacao) values ('ROBERTO DE ARAUJO ALECIO ',267511,16);
insert into professor (nome, siape, id_coordenacao) values ('RODRIGO MERO SARMENTO DA SILVA',1608323,10);
insert into professor (nome, siape, id_coordenacao) values ('ROGERIO DE ALENCAR GOUVEIA',1913683,8);
insert into professor (nome, siape, id_coordenacao) values ('ROGERIO FERNANDES DE SOUZA',1096606,6);
insert into professor (nome, siape, id_coordenacao) values ('ROMILDO JOSE DE SOUZA',267519,17);
insert into professor (nome, siape, id_coordenacao) values ('ROMILSON GOMES DOS SANTOS',3128626,15);
insert into professor (nome, siape, id_coordenacao) values ('ROMULO AFONSO LUNA VIANNA DE OMENA',2171529,13);
insert into professor (nome, siape, id_coordenacao) values ('ROMULO PIRES COELHO FERREIRA',1107575,6);
insert into professor (nome, siape, id_coordenacao) values ('ROOSEVELT PONTES SILVA',267521,16);
insert into professor (nome, siape, id_coordenacao) values ('ROSANIA DE ALMEIDA LIMA',1421785,5);
insert into professor (nome, siape, id_coordenacao) values ('ROSEANE SANTOS DA SILVA',1243669,7);
insert into professor (nome, siape, id_coordenacao) values ('ROSIVALDO PEREIRA DA SILVA',1533652,15);
insert into professor (nome, siape, id_coordenacao) values ('ROSSANA VIANA GAIA',1243600,5);
insert into professor (nome, siape, id_coordenacao) values ('SANDRA RODRIGUES DA SILVA',20190800020,1);
insert into professor (nome, siape, id_coordenacao) values ('SANDRO ALBERTO PEDROSA B. BELTRAO',1187660,16);
insert into professor (nome, siape, id_coordenacao) values ('SARAH MEDEIROS SOUTO GOMES',2331051,4);
insert into professor (nome, siape, id_coordenacao) values ('SDENISON DE ARAUJO CALDAS',1009037,10);
insert into professor (nome, siape, id_coordenacao) values ('SERGIO DE ALMEIDA FRANCO',267372,6);
insert into professor (nome, siape, id_coordenacao) values ('SERGIO TEIXEIRA COSTA',267355,1);
insert into professor (nome, siape, id_coordenacao) values ('SHEYLA FERREIRA LIMA COELHO',1811626,19);
insert into professor (nome, siape, id_coordenacao) values ('SILIER MORAIS DE SOUZA',1186912,8);
insert into professor (nome, siape, id_coordenacao) values ('SILVIO LEONARDO N. DE OLIVEIRA',267373,14);
insert into professor (nome, siape, id_coordenacao) values ('SIQUELES ROSEANE DE CARVALHO CAMPELO',1396553,11);
insert into professor (nome, siape, id_coordenacao) values ('SOLANGE ENOI MELO DE RESENDE',1882384,12);
insert into professor (nome, siape, id_coordenacao) values ('SORAYA FERNANDES DA SILVA',1455025,5);
insert into professor (nome, siape, id_coordenacao) values ('TACIANA SANTIAGO DE MELO',2160674,7);
insert into professor (nome, siape, id_coordenacao) values ('TAINARA RAMOS DA R. LINS BRITO RODRIGUES',20190800021,17);
insert into professor (nome, siape, id_coordenacao) values ('TAISE MONIQUE DE O. CARVALHO',2185041,17);
insert into professor (nome, siape, id_coordenacao) values ('TAMINEZ DE AZEVEDO FARIAS',4821508,14);
insert into professor (nome, siape, id_coordenacao) values ('TARCIO BEZERRA RODRIGUES',1186930,3);
insert into professor (nome, siape, id_coordenacao) values ('THAIS FREITAS DE RESENDE',3011762,1);
insert into professor (nome, siape, id_coordenacao) values ('THARCILA MARIA SOARES LEAO',1783740,7);
insert into professor (nome, siape, id_coordenacao) values ('UELMO SIMOES DE OLIVEIRA',1047731,15);
insert into professor (nome, siape, id_coordenacao) values ('UZIEL RIBEIRO LIMEIRA',6267381,10);
insert into professor (nome, siape, id_coordenacao) values ('VALDIR SOARES COSTA',179995,18);
insert into professor (nome, siape, id_coordenacao) values ('VALERIA ALVES MONTES',1227195,8);
insert into professor (nome, siape, id_coordenacao) values ('VALERIA GOIA VASCO TEIXEIRA ',1227195,8);
insert into professor (nome, siape, id_coordenacao) values ('VALERIA RODRIGUES TELES',2226849,7);
insert into professor (nome, siape, id_coordenacao) values ('VALMIR JOSE MORETI',267388,6);
insert into professor (nome, siape, id_coordenacao) values ('VALMIR PIMENTEL AMARAL',1168583,5);
insert into professor (nome, siape, id_coordenacao) values ('VANESSA LUCIA DA SILVA',1699890,15);
insert into professor (nome, siape, id_coordenacao) values ('VANIA NASCIMENTO TENORIO SILVA',1670546,2);
insert into professor (nome, siape, id_coordenacao) values ('VINICIUS DANTAS',1708952,10);
insert into professor (nome, siape, id_coordenacao) values ('VIVIA DAYANA GOMES DOS SANTOS',1783861,18);
insert into professor (nome, siape, id_coordenacao) values ('WALESKA BARBOSA ZANOTTO ',30214119,1);
insert into professor (nome, siape, id_coordenacao) values ('WALTER PEREIRA VIANNA JUNIOR',1187417,10);
insert into professor (nome, siape, id_coordenacao) values ('WANDERLAN SANTOS PORTO',1348498,12);
insert into professor (nome, siape, id_coordenacao) values ('WILNEY DE JESUS RODRIGUES SANTOS',2056758,2);
insert into professor (nome, siape, id_coordenacao) values ('WLADIA BESSA DA CRUZ',1513864,3);
insert into professor (nome, siape, id_coordenacao) values ('YANA KELLEN DIOCLECIO MENDES',3112957,3);
insert into professor (nome, siape, id_coordenacao) values ('YRAPUAN FONSENCA  DE LIMA',3318557,12);
insert into professor (nome, siape, id_coordenacao) values ('YVES MAIA DE ALBUQUERQUE',1223052,12);

/*
 CREATE TABLE faltas ( 
 id_faltas       INTEGER(11) NOT NULL AUTO_INCREMENT,
 data            date NOT NULL,
 turno           INTEGER(11) NOT NULL,
 id_professor    INTEGER(11), 
 horario_1       INTEGER(11), 
 horario_2       INTEGER(11), 
 horario_3       INTEGER(11), 
 horario_4       INTEGER(11), 
 horario_5       INTEGER(11), 
 horario_6       INTEGER(11), 
 observacao      VARCHAR(100), 
 PRIMARY KEY (id_faltas), 
 UNIQUE KEY id_faltas (id_faltas),
 FOREIGN KEY(id_professor) REFERENCES professor(id_professor), 
 FOREIGN KEY(horario_1) REFERENCES sala(id_sala), 
 FOREIGN KEY(horario_2) REFERENCES sala(id_sala), 
 FOREIGN KEY(horario_3) REFERENCES sala(id_sala), 
 FOREIGN KEY(horario_4) REFERENCES sala(id_sala), 
 FOREIGN KEY(horario_5) REFERENCES sala(id_sala), 
 FOREIGN KEY(horario_6) REFERENCES sala(id_sala)
);
*/
 
 CREATE TABLE faltas ( 
 id_faltas       INTEGER(11) NOT NULL AUTO_INCREMENT,
 data            date NOT NULL,
 turno           INTEGER(11) NOT NULL,
 id_professor    INTEGER(11), 
 horario_1       varchar(10), 
 horario_2       varchar(10), 
 horario_3       varchar(10), 
 horario_4       varchar(10), 
 horario_5       varchar(10), 
 horario_6       varchar(10), 
 observacao      VARCHAR(100), 
 PRIMARY KEY (id_faltas), 
 UNIQUE KEY id_faltas (id_faltas),
 FOREIGN KEY(id_professor) REFERENCES professor(id_professor) 
);

insert into faltas (data, turno, id_professor, horario_1, horario_2, horario_3, horario_4, horario_5, horario_6, observacao)
VALUES ('2019-09-19',2,83,'211A','211A','','','512B','512B','');
insert into faltas (data, turno, id_professor, horario_1, horario_2, horario_3, horario_4, horario_5, horario_6, observacao)
VALUES ('2019-09-19',1,11,'212A','','','','','512B','');  
 

CREATE TABLE justificativa ( 
 id_justificativa   INTEGER(11) NOT NULL AUTO_INCREMENT,
 id_professor       INTEGER(11), 
 dt_inicio          date NOT NULL,
 dt_termino         date NOT NULL,
 id_turno           INTEGER(11) NOT NULL,
 justificativa      VARCHAR(100), 
 PRIMARY KEY (id_justificativa), 
 UNIQUE KEY (id_justificativa),
 FOREIGN KEY(id_professor) REFERENCES professor(id_professor) 
); 

insert into justificativa (id_professor, dt_inicio, dt_termino, id_turno, justificativa)
values (113, '2019-09-16', '2019-09-27', 9, 'Licenca Medica'); 
 
// tipo -> 1 - apontamento faltas, 2 - justificativa 
CREATE TABLE fechamento (
 id_fechamento    INTEGER(11) NOT NULL AUTO_INCREMENT, 
 data_inicial     date,
 data_final       date,
 turno            INTEGER(1) NOT NULL,
 tipo             INTEGER(1) NOT NULL,
 observacao       VARCHAR(200),  
 PRIMARY KEY (id_fechamento), 
 UNIQUE KEY id_fechamento (id_fechamento)
); 
 
CREATE TABLE log ( 
 id          INTEGER(20) NOT NULL AUTO_INCREMENT, 
 id_usuario  INTEGER(11) NOT NULL, 
 tela        VARCHAR(50) NOT NULL, 
 opcao       VARCHAR(50) NOT NULL, 
 comando     VARCHAR(200), 
 observacao  VARCHAR(200),
 data        date,
 hora        VARCHAR(10), 
 PRIMARY KEY (id), 
 UNIQUE KEY id (id),
 FOREIGN KEY(id_usuario) REFERENCES usuario(id_usuario)  ) 
 
 insert into log (id_usuario, tela, opcao, comando, observacao, data, hora)
 values (1, 'coordenacao', 'update', 'update coordenacao set nome=:param_nome, email=:param_email where id_coordenacao = :param_id', 'ID:2 NOME:QUIMICA E-MAIL:', '2019-09-27', '07:35:21'); 

create table banco (
   id_banco     integer(11) not null AUTO_INCREMENT,
   codigo       integer(11) not null,
   nome         varchar(50) default '',
primary key (id_banco),
unique key id_banco (id_banco),
unique key codigo_banco (codigo)   
);


create table conta_bancaria (
   id           integer(11) not null AUTO_INCREMENT,
   id_monitor   integer(11) not null,
   id_banco     integer(11) not null,
   agencia      varchar(15) not null,
   nome         varchar(50) default '',
   conta        varchar(15) not null,
   tipo         integer(1) not null,
primary key (id),
unique key id_conta_bancaria (id),
FOREIGN KEY(id_monitor) REFERENCES monitor(id_monitor),
FOREIGN KEY(id_banco) REFERENCES banco(id_banco)
);

create table curso (
 id_curso      integer(11) not null AUTO_INCREMENT,
 nome          varchar(50),
 PRIMARY KEY (id_curso), 
 UNIQUE KEY id (id_curso) 
);
 
 create table monitor (
  id_monitor     integer(11) not null AUTO_INCREMENT,
  matricula      integer(15),
  nome           varchar(50) not null,
  telefone       varchar(15),
  email          varchar(50),
  id_curso       integer(11) not null,
  turma          varchar(50),
  id_turno       integer(11),
  setor          varchar(50) not null,
  id_professor   integer(11) not null,
  horario_seg    varchar(10) not null,       
  horario_ter    varchar(10) not null,       
  horario_qua    varchar(10) not null,       
  horario_qui    varchar(10) not null,       
  horario_sex    varchar(10) not null,
 PRIMARY KEY (id_monitor), 
 UNIQUE KEY id_monitor (id_monitor),
 FOREIGN KEY(id_professor) REFERENCES professor(id_professor),
 FOREIGN KEY(id_curso) REFERENCES curso(id_curso)          
 );

create table monitor_atendimento (
  id_atendimento integer(11) not null AUTO_INCREMENT,
  id_monitor     integer(11) not null,
  local          varchar(50) not null,
  id_turno       integer(11),
  horario_seg    varchar(10) not null,       
  horario_ter    varchar(10) not null,       
  horario_qua    varchar(10) not null,       
  horario_qui    varchar(10) not null,       
  horario_sex    varchar(10) not null,
 PRIMARY KEY (id_atendimento), 
 UNIQUE KEY id_atendimento (id_atendimento),
 FOREIGN KEY(id_monitor) REFERENCES monitor(id_monitor)
);

create table folha (
  id_folha       integer(11) not null AUTO_INCREMENT,
  nome           varchar(20) not null,
  data_inicial   date not null,
  data_final     date not null,
  total_dias     integer(3) default 30,
  valor_diaria   float(5,2), 
  criterio       integer(2) default 1,
 PRIMARY KEY (id_folha), 
 UNIQUE KEY id_folha (id_folha)  
);
 
create table folha_monitor (
  id                integer(11) not null AUTO_INCREMENT,
  id_folha          integer(11) not null,
  id_monitor        integer(11) not null,
  monitor           varchar(50) not null default '',
  id_orientador     integer(11) not null,
  orientador        varchar(50) not null default '',
  id_curso          integer(11) not null,
  curso             varchar(50) not null default '',
  turma             varchar(50),
  id_turno          integer(11) not null,
  turno             varchar(50) not null default '',
  setor             varchar(50) not null,
  horario_seg       varchar(10) not null,       
  horario_ter       varchar(10) not null,       
  horario_qua       varchar(10) not null,       
  horario_qui       varchar(10) not null,       
  horario_sex       varchar(10) not null,
  qtde_faltas       integer(2) not null default 0,
  qtde_justificada  integer(2) not null default 0,
 PRIMARY KEY (id), 
 UNIQUE KEY pk_folha_monitor (id)  
); 
 

create table folha_fechamento (
  id                integer(11) not null AUTO_INCREMENT,
  id_folha          integer(11) not null,
  usuario           varchar(50) not null default '',
  data              date not null,
 PRIMARY KEY (id), 
 UNIQUE KEY pk_folha_monitor (id),  
 FOREIGN KEY(id_folha) REFERENCES folha(id_folha)
); 
 
//ALTERANDO O CAMPO AUTO INCREMENTO
ALTER TABLE coordenacao  MODIFY id_coordenacao int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE professor  MODIFY id_professor int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE sala  MODIFY id_sala int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE usuario  MODIFY id_usuario int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE faltas  MODIFY id_faltas int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE justificativa  MODIFY id_justificativa int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE fechamento  MODIFY id_fechamento int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


/* ALTER TABLE 
ALTER TABLE funcionario ADD cpf varchar(20),rg varchar(15)

ALTER TABLE funcionario ALTER COLUMN cpf varchar(14)

ALTER TABLE funcionario DROP COLUMN cpf, rg

/* SELECT 


SELECT t1.`nome`
FROM funcionario t1
INNER JOIN plantio ON plantio.`funcID` = t1.`funcid`
INNER JOIN colhido ON colhido.`funcID` = t1.`funcid`
WHERE
((plantio.`plantioID` IN (SELECT planta.`ID` FROM planta WHERE planta.`nome` LIKE '%milho%' ))
OR
(colhido.`colhidoID` IN (SELECT planta.`ID` FROM planta WHERE planta.`nome` LIKE '%milho%' )))
AND
(
((plantio.`Data` > '2009-12-31') AND (plantio.`Data` < '2011-01-01')) OR ((colhido.`Data` > '2009-12-31') AND (colhido.`Data` < '2011-01-01'))
)

*/


--LIBERANDO ACESSO REMOTO AO PHPMYADMIN XAMPP
--E:\xampp\apache\conf\extra
--Require all granted