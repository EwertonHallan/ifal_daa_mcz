<?php
require_once('../../../banco/conexao.php');
require_once('../../../banco/funcaobanco.php');
require_once('../../../util/funcaodata.php');
require_once('../../../util/funcaocaracter.php');
require_once('../../../classe/log.php');

require_once('../../classe/usuario.php');
require_once('../../../classe/enum/enumativo.php');

require_once("../../../relatorio/classe/relatorio.php");
require_once("../../../relatorio/classe/colunarel.php");
require_once("../../../relatorio/classe/fonte.php");
require_once("../../../relatorio/classe/enumtipoestilofonte.php");
require_once("../../../relatorio/classe/enumtipoalinhamento.php");
require_once("../../../relatorio/classe/enumtiporelatorio.php");

require_once('../../../form/classe/enumtipocampo.php');

/* PEGA O PARAMETRO DO RELATORIO */
$erro = FALSE;
$mensagem = 'ERROR: \n';

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
    //Criando instancia do relatorio PDF
    $relatorio = new Relatorio('P','mm','A4');  // L-paisagem P-retrato
    
    //Ajustando configuracao do relatorio
    $relatorio->usuario_logado=FuncaoCaracter::upperTexto($_SESSION["login"]);
    $relatorio->nome_relatorio = 'REL_USUARIO';
    $relatorio->titulo_relatorio = 'RELA��O DE USU�RIO';
    $relatorio->filtro_relatorio = NULL;
     
    $coluna = new ColunaRel();
    $coluna->titulo = 'ID';
    $coluna->nome = 'id_usuario';
    $coluna->tipo = EnumTipoCampo::Numero;
    $coluna->largura = 10;
    $coluna->alinhamento = EnumTipoAlinhamento::Direita;
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'Nome';
    $coluna->nome = 'nome';
    $coluna->tipo = EnumTipoCampo::Texto;
    $coluna->largura = 55;
    $coluna->alinhamento = EnumTipoAlinhamento::Esquerda;
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'Login';
    $coluna->nome = 'login';
    $coluna->tipo = EnumTipoCampo::Texto;
    $coluna->largura = 35;
    $coluna->alinhamento = EnumTipoAlinhamento::Esquerda;
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'Telefone';
    $coluna->nome = 'telefone';
    $coluna->tipo = EnumTipoCampo::Texto;
    $coluna->largura = 30;
    $coluna->alinhamento = EnumTipoAlinhamento::Esquerda;
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'E-Mail';
    $coluna->nome = 'email';
    $coluna->tipo = EnumTipoCampo::Texto;
    $coluna->largura = 60;
    $coluna->alinhamento = EnumTipoAlinhamento::Esquerda;
    $relatorio->addColunaRel($coluna);
    
    //Dados para o relatorio
    $comandoSQL =  "SELECT id_usuario, nome, login, senha, telefone, email, ativo, tipo, ultacesso ";
    $comandoSQL .= "  FROM usuario";
    $comandoSQL .= " order by nome";
    
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