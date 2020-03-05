<?php
require_once('../../../banco/conexao.php');
require_once('../../../banco/funcaobanco.php');
require_once('../../../util/funcaodata.php');
require_once('../../../util/funcaocaracter.php');
require_once('../../../classe/log.php');

require_once('../../classe/fechamento.php');

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
    if (!isset($dados['id_fechamento']) || !is_numeric($dados['id_fechamento'])) {
        $novo_cadastro = TRUE;
    }    
}

//var_dump($dados);


if (!isset($dados['data_inicial']) || !FuncaoData::validaData($dados['data_inicial'])) {
    $erro = TRUE;
    $mensagem .= 'Campo: DATA INICIAL invalido! \n';
} else {
    $dt = FuncaoBanco::formataData($dados['data_inicial']);
    $dados['data_inicial']=$dt;
}

if (!isset($dados['data_final']) || !FuncaoData::validaData($dados['data_final'])) {
    $erro = TRUE;
    $mensagem .= 'Campo: DATA FINAL invalido! \n';
} else {
    $dt = FuncaoBanco::formataData($dados['data_final']);
    $dados['data_final']=$dt;
}

if (!isset($dados['turno']) || !is_numeric($dados['turno'])) {
    $erro = TRUE;
    $mensagem .= 'Campo: TURNO invalido! \n';
}

if (!isset($dados['tipo']) || !is_numeric($dados['tipo'])) {
    $erro = TRUE;
    $mensagem .= 'Campo: TIPO invalido! \n';
}


if (!$erro) {
    echo 'Iniciando processo de gravacao...';
   $grava = new Fechamento();
   if ($novo_cadastro) {
       echo 'Dados gravados !';
       $mensagem = 'Dados gravados !';
       //$result = $grava->querySelectAll();
       $grava->queryInsert($dados);
       header('Location: '.$_SESSION["dir_base_html"].'?form='.FuncaoCaracter::lowerTexto(get_class($grava)).'&modulo='.$_SESSION["dir_modulo"].'&pagina=1');
   } else {
       echo 'atualizando dados...';
       $result = $grava->querySelect($dados['id_fechamento']);
       if (!isset($result)) {
          $erro = TRUE;
          $mensagem .= 'Inconsistencia no banco de dados!';
          echo 'dados nao localizado...';
       } else {
           $mensagem = 'Dados atualizados gravados !';
           echo 'updating ...';
           $grava->queryUpdate($dados);
           header('Location: '.$_SESSION["dir_base_html"].'?form='.FuncaoCaracter::lowerTexto(get_class($grava)).'&modulo='.$_SESSION["dir_modulo"].'&pagina='.$dados['pagina'].'&editar_id='.$dados['id_fechamento']);
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