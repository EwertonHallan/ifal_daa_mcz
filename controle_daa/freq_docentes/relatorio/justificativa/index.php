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

require_once('./freq_docentes/classe/justificativa.php');

$form = new Tela();
$form->__set('titulo', 'MAPA DE JUSTIFICATIVA');
$form->__set('relatorio', 'justificativa/rel_justificativa.php');

echo $form->montaTelaParametro();

?>