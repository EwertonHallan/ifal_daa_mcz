<?php
require_once('./banco/conexao.php');
require_once('./banco/funcaobanco.php');
require_once('./util/funcaodata.php');
require_once('./util/funcaocaracter.php');
require_once('./classe/log.php');

require_once('./relatorio/tela_parametro/tela.php');
require_once('./relatorio/tela_parametro/tela_pesquisa.php');
require_once('./form/classe/campo.php');
require_once('./form/classe/enumtipocampo.php');

require_once('./freq_docentes/classe/professor.php');

$form = new Tela();
$form->__set('titulo', 'Mapa de Faltas');
$form->__set('relatorio', 'faltas/rel_mapafaltas.php');

//campo DATA
$campo = new Campo();
$campo->setTitulo('Data Inicial');
$campo->setNome('data_inicial');
$campo->setHint('insira a data aqui DD/MM/YYYY');
$campo->setTipo(EnumTipoCampo::Data);
$campo->setVisivel(true);
$campo->setRequerido(true);
$form->addCampo($campo);

//campo DATA
$campo = new Campo();
$campo->setTitulo('Data Fnial');
$campo->setNome('data_final');
$campo->setHint('insira a data aqui DD/MM/YYYY');
$campo->setTipo(EnumTipoCampo::Data);
$campo->setVisivel(true);
$campo->setRequerido(true);
$form->addCampo($campo);

//campo COMBO COORDENACAO
$campo = new Campo();
$campo->setTitulo('Coordenaчуo');
$campo->setNome('id_coordenacao');
$campo->setHint('insira a coordenacao');
$campo->setTipo(EnumTipoCampo::Pesquisa);
$campo->setObj_Lookup(new Coordenacao());
$campo->setCampo_Lookup('nome');
$campo->setVisivel(true);
$campo->setRequerido(false);
$form->addCampo($campo);

//campo TURNO
$campo = new Campo();
$campo->setTitulo('Turno');
$campo->setNome('id_turno');
$campo->setHint('insira o turno');
$campo->setTipo(EnumTipoCampo::Select);
$campo->setVisivel(true);
$campo->setRequerido(false);
$array_valores = array(
    0 => array("codigo" => EnumTipoTurno::Todos, "valor" => EnumTipoTurno::getDescricao(EnumTipoTurno::Todos)),
    1 => array("codigo" => EnumTipoTurno::Matutino, "valor" => EnumTipoTurno::getDescricao(EnumTipoTurno::Matutino)),
    2 => array("codigo" => EnumTipoTurno::Vespertino, "valor" => EnumTipoTurno::getDescricao(EnumTipoTurno::Vespertino)),
    3 => array("codigo" => EnumTipoTurno::Noturno, "valor" => EnumTipoTurno::getDescricao(EnumTipoTurno::Noturno))
);
$campo->setValorLista($array_valores);
$form->addCampo($campo);

/*
$obj_pesquisa_form = new Form_Pesquisa();
$obj_pesquisa_form->setTitulo('PESQUISA DE COORDENACAO');
$obj_pesquisa_form->setClassPesq(new Coordenacao());
$obj_pesquisa_form->setStatus('Total de registro:');
*/

echo $form->montaTelaParametro();

/*
$obj_pesquisa_form->montaHTML();
$obj_pesquisa_form->montaJSPesquisa('./relatorio/faltas/pesquisa.php');
*/
?>