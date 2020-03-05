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

require_once('./monitor/classe/conta_bancaria.php');
require_once('./monitor/classe/enum/enumtipocurso.php');

$form = new Tela();
$form->__set('titulo', 'RELATÓRIO DE CONTA BANCÁRIA');
$form->__set('relatorio', 'conta_bancaria/rel_conta_bancaria.php');


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

echo $form->montaTelaParametro();

?>