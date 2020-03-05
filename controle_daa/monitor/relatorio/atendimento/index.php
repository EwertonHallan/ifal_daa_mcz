<?php
require_once('./banco/conexao.php');
require_once('./banco/funcaobanco.php');
require_once('./util/funcaodata.php');
require_once('./util/funcaocaracter.php');
require_once('./classe/log.php');

require_once('./relatorio/tela_parametro/tela.php');
//require_once('./relatorio/tela_parametro/tela_pesquisa.php');
require_once('./form/classe/form_pesquisa.php');
require_once('./form/classe/campo.php');
require_once('./form/classe/enumtipocampo.php');

require_once('./freq_docentes/classe/professor.php');
require_once('./freq_docentes/classe/coordenacao.php');
require_once("./monitor/classe/monitor.php");
require_once("./monitor/classe/curso.php");
require_once("./monitor/classe/enum/enumturnoatendimento.php");

$form = new Tela();
$form->__set('titulo', '');
$form->__set('relatorio', 'atendimento/rel_frequencia.php');

//campo ORIENTADOR
$campo = new Campo();
$campo->setTitulo('Mês');
$campo->setNome('mes_ano');
$campo->setHint('insira o mes');
$campo->setTipo(EnumTipoCampo::Select);
$array_valores = array(
    0 => array("codigo" => '11/2019', "valor" => 'Novembro/2019'),
    1 => array("codigo" => '12/2019', "valor" => 'Dezembro/2019'),
    2 => array("codigo" => '01/2020', "valor" => 'Janeiro/2020')
);
$campo->setValorLista($array_valores);
$campo->setVisivel(true);
$campo->setRequerido(false);
$form->addCampo($campo);

//campo MONITOR
$campo = new Campo();
$campo->setTitulo('Monitor');
$campo->setNome('id_monitor');
$campo->setHint('insira o monitor');
$campo->setTipo(EnumTipoCampo::Pesquisa);
$campo->setObj_Lookup(new Monitor());
$campo->setCampo_Lookup('nome');
$campo->setVisivel(true);
$campo->setRequerido(false);
$form->addCampo($campo);

//campo CURSO
$campo = new Campo();
$campo->setTitulo('Curso');
$campo->setNome('id_curso');
$campo->setHint('insira o curso');
$campo->setTipo(EnumTipoCampo::Pesquisa);
$campo->setObj_Lookup(new Curso ());
$campo->setCampo_Lookup('nome');
$campo->setVisivel(true);
$campo->setRequerido(false);
$form->addCampo($campo);

//campo ORIENTADOR
$campo = new Campo();
$campo->setTitulo('Orientador');
$campo->setNome('id_professor');
$campo->setHint('insira o orientador');
$campo->setTipo(EnumTipoCampo::Pesquisa);
$campo->setObj_Lookup(new Professor());
$campo->setCampo_Lookup('nome');
$campo->setVisivel(true);
$campo->setRequerido(false);
$form->addCampo($campo);

//campo ORIENTADOR
$campo = new Campo();
$campo->setTitulo('Turno');
$campo->setNome('id_turno');
$campo->setHint('insira o turno');
$campo->setTipo(EnumTipoCampo::Select);
$array_valores = array(
    0 => array("codigo" => EnumTurnoAtendimento::Todos, "valor" => EnumTurnoAtendimento::getDescricao(EnumTurnoAtendimento::Todos)),
    1 => array("codigo" => EnumTurnoAtendimento::Matutino, "valor" => EnumTurnoAtendimento::getDescricao(EnumTurnoAtendimento::Matutino)),
    2 => array("codigo" => EnumTurnoAtendimento::Vespertino, "valor" => EnumTurnoAtendimento::getDescricao(EnumTurnoAtendimento::Vespertino)),
    3 => array("codigo" => EnumTurnoAtendimento::Noturno, "valor" => EnumTurnoAtendimento::getDescricao(EnumTurnoAtendimento::Noturno)),
    4 => array("codigo" => EnumTurnoAtendimento::Matutino_Vespertino, "valor" => EnumTurnoAtendimento::getDescricao(EnumTurnoAtendimento::Matutino_Vespertino)),
    5 => array("codigo" => EnumTurnoAtendimento::Vespertino_Noturno, "valor" => EnumTurnoAtendimento::getDescricao(EnumTurnoAtendimento::Vespertino_Noturno)),
    6 => array("codigo" => EnumTurnoAtendimento::Matutino_Noturno, "valor" => EnumTurnoAtendimento::getDescricao(EnumTurnoAtendimento::Matutino_Noturno))    
);
$campo->setValorLista($array_valores);
$campo->setVisivel(true);
$campo->setRequerido(false);
$form->addCampo($campo);

echo $form->montaTelaParametro();

?>