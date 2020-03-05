<?php
require_once('../../../banco/conexao.php');
require_once('../../../banco/funcaobanco.php');
require_once('../../../util/funcaodata.php');
require_once('../../../util/funcaocaracter.php');
require_once('../../../classe/enum/enumativo.php');
require_once('../../../classe/enum/enumtipoturno.php');
require_once('../../../classe/log.php');

require_once('../../classe/monitor.php');

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
    if (!isset($dados['id_monitor']) || !is_numeric($dados['id_monitor'])) {
        $novo_cadastro = TRUE;
    }    
}

if (isset($_POST) || (!empty($_POST))) {
    $pagina = $_POST['pagina'];
}

//var_dump($dados);


/*
//validando as variaveis do formulario
foreach ($_POST as $index => $valor) {
    $$index = trim( strip_tags ($valor));
    
    if (empty($valor)) {
        $erro = TRUE;
        $mensagem .= 'Campo:'.$index.' esta vazio! \n';
    }       
}
*/


if (!empty($dados['matricula']) && !is_numeric($dados['matricula'])) {
    $erro = TRUE;
    $mensagem .= 'Campo: Matricula invalido! \n';
}

if (empty($dados['nome'])) {
    $erro = TRUE;
    $mensagem .= 'Campo: NOME invalido! \n';
}

if (!empty($dados['email']) && !filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
    $erro = TRUE;
    $mensagem .= 'Campo: E-MAIL invalido! ['.$dados['email'].'] \n';
}

if (!empty($dados['id_curso']) && !is_numeric($dados['id_curso'])) {
    $erro = TRUE;
    $mensagem .= 'Campo: CURSO invalido! \n';
}

if (empty($dados['turma'])) {
    $erro = TRUE;
    $mensagem .= 'Campo: TURMA invalido! \n';
}

if (!empty($dados['id_turno']) && !is_numeric($dados['id_turno'])) {
    $erro = TRUE;
    $mensagem .= 'Campo: TURNO invalido! \n';
}

if (!empty($dados['id_professor']) && !is_numeric($dados['id_professor'])) {
    $erro = TRUE;
    $mensagem .= 'Campo: PROFESSOR invalido! \n';
}

var_dump($dados);

if (!$erro) {
    echo 'Iniciando processo de gravacao...';
   $grava = new Monitor();
   if ($novo_cadastro) {
       echo 'Dados gravados !';
       $mensagem = 'Dados gravados !';
       //$result = $grava->querySelectAll();
       $grava->queryInsert($dados);
       header('Location: '.$_SESSION["dir_base_html"].'?form='.FuncaoCaracter::lowerTexto(get_class($grava)).'&modulo='.$_SESSION["dir_modulo"].'&pagina=1');
   } else {
       echo 'atualizando dados...';
       $result = $grava->querySelect($dados['id_monitor']);
       if (!isset($result)) {
          $erro = TRUE;
          $mensagem .= 'Inconsistencia no banco de dados!';
          echo 'dados nao localizado...';
       } else {
           $mensagem = 'Dados atualizados gravados !';
           echo 'updating ...';
           $grava->queryUpdate($dados);
           header('Location: '.$_SESSION["dir_base_html"].'?form='.FuncaoCaracter::lowerTexto(get_class($grava)).'&modulo='.$_SESSION["dir_modulo"].'&pagina='.$dados['pagina'].'&editar_id='.$dados['id_monitor']);
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