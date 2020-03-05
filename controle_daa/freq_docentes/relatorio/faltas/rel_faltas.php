<?php
//require_once("../../session/valida.php");
//require_once('../Fpdf-16/fpdf.php');
require_once('../../../relatorio/classe/relatorio.php');
require_once('../../../relatorio/classe/colunarel.php');
require_once('../../../relatorio/classe/fonte.php');
require_once('../../../relatorio/classe/enumtipoestilofonte.php');
require_once('../../../relatorio/classe/enumtipoalinhamento.php');
require_once('../../../relatorio/classe/enumtiporelatorio.php');

require_once('../../../form/classe/enumtipocampo.php');

require_once('../../../banco/conexao.php');
require_once('../../../banco/funcaobanco.php');
require_once('../../../util/funcaodata.php');
require_once('../../../util/funcaocaracter.php');

require_once('../../../classe/log.php');
require_once('../../../classe/enum/enumtipoturno.php');

require_once("../../classe/faltas.php");

/* PEGA O PARAMETRO DO RELATORIO */
$erro = FALSE;
$mensagem = 'ERROR: \n';

$erro = FALSE;
$mensagem = 'ERROR: \n';

if (!isset($_POST) || empty($_POST)) {
    $erro = FALSE;
    $mensagem .= 'Formulario vazio !';
    
    $dados['data_inicial'] = '2019-11-01';
    $dados['data_final'] = '2019-11-30';


    //Dados para o relatorio
    $comandoSQL =  "SELECT f.id_faltas, f.id_professor, p.nome, f.data, f.turno, (if(trim(f.horario_1) = ' ',0,1)+if(trim(f.horario_2) = ' ',0,1)+ ";
    $comandoSQL .= "       if(trim(f.horario_3) = ' ',0,1)+if(trim(f.horario_4) = ' ',0,1)+if(trim(f.horario_5) = ' ',0,1)+  ";
    $comandoSQL .= "       if(trim(f.horario_6) = ' ',0,1)) as n_faltas ";
    $comandoSQL .= "  FROM faltas f, professor p";
    $comandoSQL .= " where f.id_professor = p.id_professor";
    $comandoSQL .= "   and f.data > (select max(data_final) from fechamento where tipo in (1,9))";
    $comandoSQL .= "   and f.data between '".$dados['data_inicial']."' and '".$dados['data_final']."' ";
    $comandoSQL .= " order by p.nome, f.data";
    
} else {
    $dados = $_POST;

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
    
    //Dados para o relatorio
    $comandoSQL =  "SELECT f.id_faltas, f.id_professor, p.nome, f.data, f.turno, (if(trim(f.horario_1) = ' ',0,1)+if(trim(f.horario_2) = ' ',0,1)+ ";
    $comandoSQL .= "       if(trim(f.horario_3) = ' ',0,1)+if(trim(f.horario_4) = ' ',0,1)+if(trim(f.horario_5) = ' ',0,1)+  ";
    $comandoSQL .= "       if(trim(f.horario_6) = ' ',0,1)) as n_faltas ";
    $comandoSQL .= "  FROM faltas f, professor p";
    $comandoSQL .= " where f.id_professor = p.id_professor";
    //$comandoSQL .= "   and f.data > (select max(data_final) from fechamento where tipo in (1,9))";
    $comandoSQL .= "   and f.data between '".$dados['data_inicial']."' and '".$dados['data_final']."' ";
    $comandoSQL .= " order by p.nome, f.data";
    
    //var_dump($dados);
}


if (!$erro) {
    //Criando instancia do relatorio PDF
    $relatorio = new Relatorio('P','mm','A4');  // L-paisagem P-retrato
    
    //Ajustando configuracao do relatorio
    $relatorio->usuario_logado=FuncaoCaracter::upperTexto($_SESSION["login"]);
    $relatorio->nome_relatorio = 'REL_FALTAS';
    $relatorio->titulo_relatorio = 'RELATÓRIO DE FALTAS';
    $relatorio->filtro_relatorio = 'Periodo: '.FuncaoData::formatoData($dados['data_inicial']).' a '.FuncaoData::formatoData($dados['data_final']).'';

    $coluna = new ColunaRel();
    $coluna->titulo = 'ID';
    $coluna->nome = 'id_faltas';
    $coluna->tipo = EnumTipoCampo::Numero;
    $coluna->largura = 15;
    $coluna->alinhamento = EnumTipoAlinhamento::Direita;    
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'Professor';
    $coluna->nome = 'nome';
    $coluna->tipo = EnumTipoCampo::Texto;
    $coluna->largura = 110;
    $coluna->alinhamento = EnumTipoAlinhamento::Esquerda;
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'Data';
    $coluna->nome = 'data';
    $coluna->tipo = EnumTipoCampo::Data;
    $coluna->largura = 22;
    $coluna->alinhamento = EnumTipoAlinhamento::Centralizado;
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'Turno';
    $coluna->nome = 'turno';
    $coluna->tipo = EnumTipoCampo::Select;
    $coluna->largura = 22;
    $coluna->alinhamento = EnumTipoAlinhamento::Centralizado;
    $coluna->objeto = new EnumTipoTurno();
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'Faltas';
    $coluna->nome = 'n_faltas';
    $coluna->tipo = EnumTipoCampo::Numero;
    $coluna->largura = 21;
    $coluna->alinhamento = EnumTipoAlinhamento::Centralizado;
    $relatorio->addColunaRel($coluna);
    
/*    
    //Dados para o relatorio
    $comandoSQL =  "SELECT f.id_faltas, f.id_professor, p.nome, f.data, f.turno, (if(trim(f.horario_1) = ' ',0,1)+if(trim(f.horario_2) = ' ',0,1)+ ";
    $comandoSQL .= "       if(trim(f.horario_3) = ' ',0,1)+if(trim(f.horario_4) = ' ',0,1)+if(trim(f.horario_5) = ' ',0,1)+  ";
    $comandoSQL .= "       if(trim(f.horario_6) = ' ',0,1)) as n_faltas ";
    $comandoSQL .= "  FROM faltas f, professor p";
    $comandoSQL .= " where f.id_professor = p.id_professor";
    $comandoSQL .= "   and f.data > (select max(data_final) from fechamento where tipo in (1,9))";
    $comandoSQL .= "   and f.data between '".$dados['data_inicial']."' and '".$dados['data_final']."' ";
    $comandoSQL .= " order by p.nome, f.data";
*/    
    $relatorio->query_comando = $comandoSQL;
    
    $relatorio->execRelatorio();
} else {
    if ($erro) {
        echo '<script type="text/javascript">'.
            'alert("'.$mensagem.'");'.
            'history.go(-1);'.
            '</script>';
    }
    
}

?>