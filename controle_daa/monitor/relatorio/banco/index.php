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

require_once('./monitor/classe/curso.php');
require_once('./monitor/classe/enum/enumtipocurso.php');

$form = new Tela();
$form->__set('titulo', 'RELATÓRIO DE CURSO');
$form->__set('relatorio', 'curso/rel_curso.php');

echo $form->montaTelaParametro();

?>