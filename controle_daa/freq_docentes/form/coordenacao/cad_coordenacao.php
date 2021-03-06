<?php
require_once('../../../banco/conexao.php');
require_once('../../../banco/funcaobanco.php');
require_once('../../../util/funcaodata.php');
require_once('../../../util/funcaocaracter.php');
require_once('../../../classe/log.php');

require_once('../../classe/coordenacao.php');

//pegando os dados do formulario
$novo_cadastro = FALSE;
$mensagem = 'ERROR: \n';
$erro = FALSE;

if (!isset($_POST) || empty($_POST)) {
    $erro = TRUE;
    $mensagem .= 'Formulario vazio !';
} else {
    $dados = $_POST;
    //novo registro para inserir no banco
    if (!isset($dados['id_coordenacao']) || !is_numeric($dados['id_coordenacao'])) {
        $novo_cadastro = TRUE;
    }    
}

//var_dump($dados);


if (!isset($dados['nome'])) {
    $erro = TRUE;
    $mensagem .= 'Campo: NOME invalido! \n';
}


if (!$erro) {
   $grava = new Coordenacao();
   if ($novo_cadastro) {
       $mensagem = 'Dados gravados !';
       //$result = $grava->querySelectAll();
       $grava->queryInsert($dados);
       header('Location: '.$_SESSION["dir_base_html"].'?form='.FuncaoCaracter::lowerTexto(get_class($grava)).'&modulo='.$_SESSION["dir_modulo"].'&pagina=1');
   } else {
       $result = $grava->querySelect($dados['id_coordenacao']);
       if (!isset($result)) {
          $erro = TRUE;
          $mensagem .= 'Inconsistencia no banco de dados!';
       } else {
           $mensagem = 'Dados atualizados gravados !';
           $grava->queryUpdate($dados);
           header('Location: '.$_SESSION["dir_base_html"].'?form='.FuncaoCaracter::lowerTexto(get_class($grava)).'&modulo='.$_SESSION["dir_modulo"].'&pagina='.$dados['pagina'].'&editar_id='.$dados['id_coordenacao']);
       }
   }     
}
   
if ($erro) {
    echo '<script type="text/javascript">'.
        'alert("'.$mensagem.'");'.
        'history.go(-1);'.
        '</script>';
}
?>