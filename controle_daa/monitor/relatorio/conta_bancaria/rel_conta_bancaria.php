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

require_once('../../../classe/log.php');
require_once('../../../banco/conexao.php');
require_once('../../../banco/funcaobanco.php');
require_once('../../../util/funcaodata.php');
require_once('../../../util/funcaocaracter.php');

require_once('../../../monitor/classe/enum/enumtipoconta_bancaria.php');
require_once('../../../monitor/classe/banco.php');
require_once('../../../monitor/classe/monitor.php');

/* PEGA O PARAMETRO DO RELATORIO */
$erro = FALSE;
$mensagem = 'ERROR: \n';

if (isset($_POST) && (!empty($_POST))) {
    $dados = $_POST;
}

/*
 if (!isset($_POST) || empty($_POST)) {
 $erro = TRUE;
 $mensagem .= 'Formulario vazio !';
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
 
 if (!empty($dados['id_coordenacao']) && !is_numeric($dados['id_coordenacao'])) {
 $erro = TRUE;
 $mensagem .= 'Campo: COORDENACAO invalido! \n';
 }
 
 if (!isset($dados['id_turno']) || !is_numeric($dados['id_turno'])) {
 $erro = TRUE;
 $mensagem .= 'Campo: TURNO invalido! \n';
 }
 
 //var_dump($dados);
 }
 */

if (!$erro) {
    $filtro = 'Filtro:';
    //Dados para o relatorio
    $comandoSQL =  "SELECT c.id_monitor, m.nome, c.id_banco, b.codigo, b.nome, c.agencia, c.nome, c.conta, c.tipo ";
    $comandoSQL .= "  FROM conta_bancaria c, monitor m, banco b ";
    $comandoSQL .= " WHERE c.id_monitor = m.id_monitor ";
    $comandoSQL .= "   and c.id_banco = b.id_banco ";

    //CURSO
    if (!empty($dados['id_curso'])) {
        $comandoSQL .= "   and m.id_curso = ".$dados['id_curso']." ";
        $filtro .= "Curso->".$dados['desc_id_curso'].",";
    }
    
    //ORIENTADOR
    if (!empty($dados['id_professor'])) {
        $comandoSQL .= "   and m.id_professor = ".$dados['id_professor']." ";
        $filtro .= "Professor->".$dados['desc_id_professor'].",";
    }
    
    $comandoSQL .= " order by m.nome ";
    
    //echo "comando SQL:".$comandoSQL."<br>";
        
    //Criando instancia do relatorio PDF
    $relatorio = new Relatorio('L','mm','A4');  // L-paisagem P-retrato
    
    //Ajustando configuracao do relatorio
    $relatorio->usuario_logado=FuncaoCaracter::upperTexto($_SESSION["login"]);
    $relatorio->nome_relatorio = 'REL_CONTA_BANCARIA';
    $relatorio->titulo_relatorio = 'RELAÇÃO DE CONTA BANCÁRIA';
    $relatorio->filtro_relatorio = $filtro;
    $relatorio->query_comando = $comandoSQL;
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'ID';
    $coluna->nome = 'id_monitor';
    $coluna->tipo = EnumTipoCampo::Pesquisa;
    $coluna->objeto = new Monitor();
    $coluna->largura = 90;
    $coluna->alinhamento = EnumTipoAlinhamento::Esquerda;
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'Banco';
    $coluna->nome = 'id_banco';
    $coluna->tipo = EnumTipoCampo::Pesquisa;
    $coluna->objeto = new Banco();
    $coluna->largura = 60;
    $coluna->alinhamento = EnumTipoAlinhamento::Esquerda;
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'Agência';
    $coluna->nome = 'agencia';
    $coluna->tipo = EnumTipoCampo::Texto;
    $coluna->largura = 25;
    $coluna->alinhamento = EnumTipoAlinhamento::Esquerda;
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'Nome';
    $coluna->nome = 'nome';
    $coluna->tipo = EnumTipoCampo::Texto;
    $coluna->largura = 50;
    $coluna->alinhamento = EnumTipoAlinhamento::Esquerda;
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'Conta';
    $coluna->nome = 'conta';
    $coluna->tipo = EnumTipoCampo::Texto;
    $coluna->largura = 30;
    $coluna->alinhamento = EnumTipoAlinhamento::Esquerda;
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'Tipo';
    $coluna->nome = 'tipo';
    $coluna->tipo = EnumTipoCampo::Select;
    $coluna->objeto = new EnumTipoConta_Bancaria();
    $coluna->largura = 25;
    $coluna->alinhamento = EnumTipoAlinhamento::Esquerda;
    $relatorio->addColunaRel($coluna);
        
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