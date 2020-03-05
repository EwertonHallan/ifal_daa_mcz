<?php 
require_once ('../classe/form_pesquisa.php');
require_once ('../../classe/professor.php');
require_once ('../../banco/conexao.php');

echo '<!DOCTYPE HTML>';
echo '<html lang="pt-BR">';
echo '<head>';
echo ' <script type="text/javascript" src="./js/jquery-2.1.0.js"></script>';
echo ' <script type="text/javascript" src="./js/pesquisa.js"></script>';
echo ' <script type="text/javascript" src="./js/janela.js"></script>';
echo ' <link rel="stylesheet" type="text/css" href="./css/janela.css" />';
echo ' <link rel="stylesheet" type="text/css" href="../formulario.css" />';

$obj_pesquisa = new Form_Pesquisa();
$obj_pesquisa->setTitulo('PESQUISA DE PROFESSOR');
$obj_pesquisa->setClassPesq(new Professor());
$obj_pesquisa->setStatus('Total de registro:');

echo '</head>';
echo '<body>';
echo '<br/>';
//echo '<form name="outputForm">';
echo '<form name="formTeste">';
echo '<label for="texto_pesq">Campo:</label>';
echo '<input type=text value="" name="textofilho" size=20 />';
echo '<input type=button id="bt_pesq" name="bt_pesq" onclick="exibir();" value="popup" />';
echo '</form>';

$obj_pesquisa->montaHTML();

echo '</body>';
echo '</html>';

?>