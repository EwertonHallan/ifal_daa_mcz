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

require_once("../../classe/monitor.php");
require_once("../../classe/curso.php");
require_once("../../classe/enum/enumturnoatendimento.php");
require_once('../../../freq_docentes/classe/professor.php');

/* PEGA O PARAMETRO DO RELATORIO */
$erro = FALSE;
$mensagem = 'ERROR: \n';


 if (isset($_POST) && (!empty($_POST))) {
    $dados = $_POST;
 
    if (!empty($dados['id_professor']) && !is_numeric($dados['id_professor'])) {
        $erro = TRUE;
        $mensagem .= 'Campo: PROFESSOR invalido! \n';
    }
 
 //var_dump($dados);
 }

 
if (!$erro) {
    $filtro = 'Filtro:';
    //COMANDO SQL DO RELATORIO
    $comandoSQL =  "select id_monitor, matricula, nome, id_curso, id_professor, id_turno ";
    $comandoSQL .= "  FROM monitor where 1 = 1 ";
    
    //CURSO
    if (!empty($dados['id_curso'])) {
        $comandoSQL .= "   and id_curso = ".$dados['id_curso']." ";
        $filtro .= "Curso->".$dados['desc_id_curso'].",";
    }
    
    //ORIENTADOR
    if (!empty($dados['id_professor'])) {
        $comandoSQL .= "   and id_professor = ".$dados['id_professor']." ";
        $filtro .= "Professor->".$dados['desc_id_professor'].",";
    }
    
    //ORIENTADOR
    if (!empty($dados['id_turno'])) {
        if ($dados['id_turno'] != EnumTurnoAtendimento::Todos) {
           $comandoSQL .= "   and id_turno = ".$dados['id_turno']." ";
           $filtro .= "Turno->".EnumTurnoAtendimento::getDescricao($dados['id_turno']).",";
        }
    }
    
    $comandoSQL .= " order by nome";
    
    //Criando instancia do relatorio PDF
    $relatorio = new Relatorio('L','mm','A4');  // L-paisagem P-retrato
    
    //Ajustando configuracao do relatorio
    $relatorio->usuario_logado=FuncaoCaracter::upperTexto($_SESSION["login"]);
    $relatorio->nome_relatorio = 'REL_MONITOR';
    $relatorio->titulo_relatorio = 'RELAÇÃO DE MONITORES';
    $relatorio->filtro_relatorio = $filtro;
    $relatorio->query_comando = $comandoSQL;
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'ID';
    $coluna->nome = 'id_monitor';
    $coluna->tipo = EnumTipoCampo::Texto;
    $coluna->largura = 10;
    $coluna->alinhamento = EnumTipoAlinhamento::Esquerda;
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'Nome';
    $coluna->nome = 'nome';
    $coluna->tipo = EnumTipoCampo::Texto;
    $coluna->largura = 83;
    $coluna->alinhamento = EnumTipoAlinhamento::Esquerda;
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'Matricula';
    $coluna->nome = 'matricula';
    $coluna->tipo = EnumTipoCampo::Texto;
    $coluna->largura = 22;
    $coluna->alinhamento = EnumTipoAlinhamento::Direita;
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'Orientador';
    $coluna->nome = 'id_professor';
    $coluna->tipo = EnumTipoCampo::Pesquisa;
    $coluna->objeto = new Professor();
    $coluna->largura = 85;
    $coluna->alinhamento = EnumTipoAlinhamento::Esquerda;
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'Curso';
    $coluna->nome = 'id_curso';
    $coluna->tipo = EnumTipoCampo::Pesquisa;
    $coluna->objeto = new Curso();
    $coluna->largura = 50;
    $coluna->alinhamento = EnumTipoAlinhamento::Esquerda;
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'Turno';
    $coluna->nome = 'id_turno';
    $coluna->tipo = EnumTipoCampo::Select;
    $coluna->objeto = new EnumTurnoAtendimento();
    $coluna->largura = 30;
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