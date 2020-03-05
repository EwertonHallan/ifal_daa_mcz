<?php
require_once('../../../banco/conexao.php');
require_once('../../../banco/funcaobanco.php');
require_once('../../../util/funcaodata.php');
require_once('../../../util/funcaocaracter.php');
require_once('../../../classe/log.php');

require_once('../../classe/folha_monitor.php');

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
    if (!isset($dados['id']) || !is_numeric($dados['id'])) {
        $erro = TRUE;
        $mensagem .= 'NAO PERMITIDO INSERIR NOVO VALOR! \n';
    }
}

//var_dump($dados);

if (!isset($dados['id_folha']) || !is_numeric($dados['id_folha'])) {
    $erro = TRUE;
    $mensagem .= 'Campo: CODIGO DA FOLHA invalido! \n';
}

if (!isset($dados['id_monitor']) || !is_numeric($dados['id_monitor'])) {
    $erro = TRUE;
    $mensagem .= 'Campo: CODIGO DO MONITOR invalido! \n';
}

if (!isset($dados['qtde_faltas']) || !is_numeric($dados['qtde_faltas'])) {
    $erro = TRUE;
    $mensagem .= 'Campo: QUANT. DE FALTAS invalido! \n';
}

if (!isset($dados['qtde_justificada']) || !is_numeric($dados['qtde_justificada'])) {
    $erro = TRUE;
    $mensagem .= 'Campo: QUANT. DE JUSTIFICATIVA invalido! \n';
}

var_dump($dados);

if (!$erro) {
   $grava = new Folha_Monitor();

   $result = $grava->querySelect($dados['id_folha'].'-'.$dados['id_monitor']);
   if (!isset($result)) {
      $erro = TRUE;
      $mensagem .= 'Inconsistencia no banco de dados!';
   } else {
       $mensagem = 'Dados atualizados gravados !';
       $grava->queryUpdate($dados);
       header('Location: '.$_SESSION["dir_base_html"].'?form='.FuncaoCaracter::lowerTexto(get_class($grava)).'&modulo='.$_SESSION["dir_modulo"].'&pagina='.$dados['pagina'].'&editar_id='.$dados['id']);
   }
        
}
   
if ($erro) {
    echo '<script type="text/javascript">'.
        'alert("'.$mensagem.'");'.
        'history.go(-1);'.
        '</script>';
}
?>