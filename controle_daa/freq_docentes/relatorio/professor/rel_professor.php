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

require_once("../../classe/coordenacao.php");

/* PEGA O PARAMETRO DO RELATORIO */
$erro = FALSE;
$mensagem = 'ERROR: \n';


 if (isset($_POST) && (!empty($_POST))) {
    $dados = $_POST;
 
    if (!empty($dados['id_coordenacao']) && !is_numeric($dados['id_coordenacao'])) {
        $erro = TRUE;
        $mensagem .= 'Campo: COORDENACAO invalido! \n';
    }
 
 //var_dump($dados);
 }

 
if (!$erro) {
    //Criando instancia do relatorio PDF
    $relatorio = new Relatorio('L','mm','A4');  // L-paisagem P-retrato
    
    //Ajustando configuracao do relatorio
    $relatorio->usuario_logado=FuncaoCaracter::upperTexto($_SESSION["login"]);
    $relatorio->nome_relatorio = 'REL_PROFESSOR';
    $relatorio->titulo_relatorio = 'RELAÇÃO DE PROFESSORES';
    $relatorio->filtro_relatorio = NULL;
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'ID';
    $coluna->nome = 'id_professor';
    $coluna->tipo = EnumTipoCampo::Numero;
    $coluna->largura = 10;
    $coluna->alinhamento = EnumTipoAlinhamento::Direita;
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'SIAPE';
    $coluna->nome = 'siape';
    $coluna->tipo = EnumTipoCampo::Texto;
    $coluna->largura = 25;
    $coluna->alinhamento = EnumTipoAlinhamento::Direita;
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'Nome';
    $coluna->nome = 'nome';
    $coluna->tipo = EnumTipoCampo::Texto;
    $coluna->largura = 90;
    $coluna->alinhamento = EnumTipoAlinhamento::Esquerda;
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'E-Mail';
    $coluna->nome = 'email';
    $coluna->tipo = EnumTipoCampo::Texto;
    $coluna->largura = 90;
    $coluna->alinhamento = EnumTipoAlinhamento::Esquerda;
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'Coordenação';
    $coluna->nome = 'id_coordenacao';
    $coluna->tipo = EnumTipoCampo::Pesquisa;
    $coluna->objeto = new Coordenacao();
    $coluna->largura = 65;
    $coluna->alinhamento = EnumTipoAlinhamento::Esquerda;
    $relatorio->addColunaRel($coluna);
    
    //Dados para o relatorio
    $comandoSQL =  "SELECT id_professor, siape, nome, telefone, email, id_coordenacao, mes_ativo, mes_inativo, carga_hr ";
    $comandoSQL .= "  FROM professor";
    
    //COORDENACAO
    if (!empty($dados['id_coordenacao'])) {
        $comandoSQL .= "   where id_coordenacao = ".$dados['id_coordenacao']." ";
    }
    
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