<?php
require_once('../../../banco/conexao.php');
require_once('../../../banco/funcaobanco.php');
require_once('../../../util/funcaodata.php');
require_once('../../../util/funcaocaracter.php');
require_once('../../../classe/log.php');

require_once('../../classe/professor.php');
require_once('../../classe/faltas.php');
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
    if (!isset($dados['id_faltas']) || !is_numeric($dados['id_faltas'])) {
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


if (!isset($dados['data']) || !FuncaoData::validaData($dados['data'])) {
    $erro = TRUE;
    $mensagem .= 'Campo: DATA invalido! \n';
} else {
    $dt = FuncaoBanco::formataData($dados['data']);
    $dados['data']=$dt;
}

if (!isset($dados['turno']) || !is_numeric($dados['turno'])) {
    $erro = TRUE;
    $mensagem .= 'Campo: TURNO invalido! \n';
}

if (!isset($dados['id_professor']) || !is_numeric($dados['id_professor'])) {
    $erro = TRUE;
    $mensagem .= 'Campo: PROFESSOR invalido! \n';
}

if (!isset($dados['horario_1']) &&
    !isset($dados['horario_2']) &&
    !isset($dados['horario_3']) &&
    !isset($dados['horario_4']) &&
    !isset($dados['horario_5']) &&
    !isset($dados['horario_6'])
    ) {
    $erro = TRUE;
    $mensagem .= 'Campo: HORARIO invalido! \n';
    }
/*
    else {
        if (!empty($dados['horario_1']) && (!is_numeric($dados['horario_1']))) {
            $erro = TRUE;
            $mensagem = 'Campo HORARIO 1 invalido !';
        }

        if (!empty($dados['horario_2']) && (!is_numeric($dados['horario_2']))) {
            $erro = TRUE;
            $mensagem = 'Campo HORARIO 2 invalido !';
        }
        
        if (!empty($dados['horario_3']) && (!is_numeric($dados['horario_3']))) {
            $erro = TRUE;
            $mensagem = 'Campo HORARIO 3 invalido !';
        }
        
        if (!empty($dados['horario_4']) && (!is_numeric($dados['horario_4']))) {
            $erro = TRUE;
            $mensagem = 'Campo HORARIO 4 invalido !';
        }
        
        if (!empty($dados['horario_5']) && (!is_numeric($dados['horario_5']))) {
            $erro = TRUE;
            $mensagem = 'Campo HORARIO 5 invalido !';
        }
        
        if (!empty($dados['horario_6']) && (!is_numeric($dados['horario_6']))) {
            $erro = TRUE;
            $mensagem = 'Campo HORARIO 6 invalido !';
        }
    }
*/
//VALIDA FECHAMENTO DO PERIODO
if (!$erro) {
    $fec_valida = new Fechamento();
    $result = $fec_valida->getValidaApont($dados['data'], $dados['turno']);
    
    if (!empty($result['data_inicial'])) {
        $erro = TRUE;
        $mensagem .= 'DATA NAO PERMITIDA PARA APONTAMENTO! \n PERIODO '.FuncaoData::formatoData($result['data_inicial']).' a '.FuncaoData::formatoData($result['data_final']).' BLOQUEADO.';
    }
    
    $prof_ativo = new Professor();
    $result = $prof_ativo->querySelect($dados['id_professor']);
    
    if (!empty($result['mes_inativo'])) {
        if (strtotime($dados['data']) > strtotime($result['mes_inativo']) && (!empty(FuncaoData::formatoData($result['mes_inativo'])))) {
            $erro = true;
            $mensagem = 'Apontamento NAO PERMITIDO, PROFESSOR COM DATA DE SAIDA DO CAMPUS NO DIA '.FuncaoData::formatoData($result['mes_inativo']).' ! ';
        }
    }
}


if (!$erro) {
    echo 'Iniciando processo de gravacao...';
   $grava = new Faltas();
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
           header('Location: '.$_SESSION["dir_base_html"].'?form='.FuncaoCaracter::lowerTexto(get_class($grava)).'&modulo='.$_SESSION["dir_modulo"].'&pagina='.$dados['pagina'].'&editar_id='.$dados['id_faltas']);
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