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

require_once('./freq_docentes/classe/faltas.php');

$form = new Tela();
$form->__set('titulo', 'RELATÓRIO DE FALTAS');
$form->__set('relatorio', 'faltas/rel_faltas.php');

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

echo $form->montaTelaParametro();

?>