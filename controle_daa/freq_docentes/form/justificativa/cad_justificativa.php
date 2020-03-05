<?php
require_once('../../../banco/conexao.php');
require_once('../../../banco/funcaobanco.php');
require_once('../../../util/funcaodata.php');
require_once('../../../util/funcaocaracter.php');
require_once('../../../classe/enum/enumativo.php');
require_once('../../../classe/enum/enumtipoturno.php');
require_once('../../../classe/log.php');

require_once('../../classe/justificativa.php');
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
    if (!isset($dados['id_justificativa']) || !is_numeric($dados['id_justificativa'])) {
        $novo_cadastro = TRUE;
    }    
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


if (!isset($dados['id_professor']) || !is_numeric($dados['id_professor'])) {
    $erro = TRUE;
    $mensagem .= 'Campo: PROFESSOR invalido! \n';
}

if (!isset($dados['dt_inicio']) || !FuncaoData::validaData($dados['dt_inicio'])) {
    $erro = TRUE;
    $mensagem .= 'Campo: DATA INICIO invalido! \n';
} else {
    $dt = FuncaoBanco::formataData($dados['dt_inicio']);
    $dados['dt_inicio']=$dt;
}

if (!isset($dados['dt_termino']) || !FuncaoData::validaData($dados['dt_termino'])) {
    $erro = TRUE;
    $mensagem .= 'Campo: DATA TERMINO invalido! \n';
} else {
    $dt = FuncaoBanco::formataData($dados['dt_termino']);
    $dados['dt_termino']=$dt;
}

if (!isset($dados['id_turno']) || !is_numeric($dados['id_turno'])) {
    $erro = TRUE;
    $mensagem .= 'Campo: TURNO invalido! \n';
}

if (!isset($dados['justificativa'])) {
    $erro = TRUE;
    $mensagem .= 'Campo: JUSTIFICATIVA invalido! \n';
}


//VALIDA FECHAMENTO DO PERIODO
if (!$erro) {
    $fec_valida = new Fechamento();
    $result = $fec_valida->getValidaJustif($dados['dt_inicio'], $dados['dt_termino'], $dados['id_turno']);
    
    if (!empty($result['data_inicial'])) {
        $erro = TRUE;
        $mensagem .= 'DATA NAO PERMITIDA PARA JUSTIFICATIVA! \n PERIODO '.FuncaoData::formatoData($result['data_inicial']).' a '.FuncaoData::formatoData($result['data_final']).' BLOQUEADO.';
    }
}


if (!$erro) {
    echo 'Iniciando processo de gravacao...';
   $grava = new Justificativa();
   if ($novo_cadastro) {
       echo 'Dados gravados !';
       $mensagem = 'Dados gravados !';
       //$result = $grava->querySelectAll();
       $grava->queryInsert($dados);
       
       header('Location: '.$_SESSION["dir_base_html"].'?form='.FuncaoCaracter::lowerTexto(get_class($grava)).'&modulo='.$_SESSION["dir_modulo"].'&pagina=1');
   } else {
       echo 'atualizando dados...';
       $result = $grava->querySelect($dados['id_faltas']);
       if (!isset($result)) {
          $erro = TRUE;
          $mensagem .= 'Inconsistencia no banco de dados!';
          echo 'dados nao localizado...';
       } else {
           $mensagem = 'Dados atualizados gravados !';
           echo 'updating ...';
           $grava->queryUpdate($dados);
           header('Location: '.$_SESSION["dir_base_html"].'?form='.FuncaoCaracter::lowerTexto(get_class($grava)).'&modulo='.$_SESSION["dir_modulo"].'&pagina='.$dados['pagina'].'&editar_id='.$dados['id_justificativa']);
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