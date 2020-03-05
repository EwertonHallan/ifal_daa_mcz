<?php
require_once('../../../banco/conexao.php');
require_once('../../../banco/funcaobanco.php');
require_once('../../../util/funcaodata.php');
require_once('../../../util/funcaocaracter.php');
require_once('../../../classe/log.php');

require_once('../../classe/folha.php');

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
    if (!isset($dados['id_folha']) || !is_numeric($dados['id_folha'])) {
        $novo_cadastro = TRUE;
    }    
}

//var_dump($dados);


if (!isset($dados['nome'])) {
    $erro = TRUE;
    $mensagem .= 'Campo: NOME invalido! \n';
}

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

if (!isset($dados['total_dias']) || !is_numeric($dados['total_dias'])) {
    $erro = TRUE;
    $mensagem .= 'Campo: TOTAL DE DIAS invalido! \n';
}

if (!isset($dados['valor_diaria']) || !is_numeric($dados['valor_diaria'])) {
    $erro = TRUE;
    $mensagem .= 'Campo: VALOR DA DIARIA invalido! \n';
}

var_dump($dados);

if (!$erro) {
   $grava = new Folha();
   if ($novo_cadastro) {
       $mensagem = 'Dados gravados !';
       //$result = $grava->querySelectAll();
       $grava->queryInsert($dados);
       header('Location: '.$_SESSION["dir_base_html"].'?form='.FuncaoCaracter::lowerTexto(get_class($grava)).'&modulo='.$_SESSION["dir_modulo"].'&pagina=1');
   } else {
       $result = $grava->querySelect($dados['id_curso']);
       if (!isset($result)) {
          $erro = TRUE;
          $mensagem .= 'Inconsistencia no banco de dados!';
       } else {
           $mensagem = 'Dados atualizados gravados !';
           $grava->queryUpdate($dados);
           header('Location: '.$_SESSION["dir_base_html"].'?form='.FuncaoCaracter::lowerTexto(get_class($grava)).'&modulo='.$_SESSION["dir_modulo"].'&pagina='.$dados['pagina'].'&editar_id='.$dados['id_folha']);
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