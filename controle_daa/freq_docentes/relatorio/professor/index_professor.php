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

$form = new Tela();
$form->__set('titulo', 'RELAÇÃO DE PROFESSORES');
$form->__set('relatorio', 'professor/rel_professor.php');

//campo COMBO COORDENACAO
$campo = new Campo();
$campo->setTitulo('Coordenação');
$campo->setNome('id_coordenacao');
$campo->setHint('insira a coordenacao');
$campo->setTipo(EnumTipoCampo::Pesquisa);
$campo->setObj_Lookup(new Coordenacao());
$campo->setCampo_Lookup('nome');
$campo->setVisivel(true);
$campo->setRequerido(false);
$form->addCampo($campo);

echo $form->montaTelaParametro();

?>