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
require_once("../../classe/atendimento.php");
require_once("../../classe/enum/enumturnoatendimento.php");
require_once('../../../freq_docentes/classe/professor.php');

/* PEGA O PARAMETRO DO RELATORIO */
$erro = FALSE;
$mensagem = 'ERROR: \n';


 if (isset($_POST) && (!empty($_POST))) {
    $dados = $_POST;
 
 //var_dump($dados);
 }

 
if (!$erro) {
    $filtro = 'Filtro:';
    //COMANDO SQL DO RELATORIO
    $comandoSQL =  "SELECT a.id_atendimento, a.id_monitor, m.nome, m.id_professor, m.id_curso, "; 
    $comandoSQL .=  "       m.turma, a.local, a.id_turno, a.horario_seg, ";
    $comandoSQL .=  "       a.horario_ter, a.horario_qua, a.horario_qui, a.horario_sex ";
    $comandoSQL .=  "  FROM monitor_atendimento a, monitor m ";
    $comandoSQL .=  " WHERE a.id_monitor = m.id_monitor ";
    
    //CURSO
    if (!empty($dados['id_monitor'])) {
        $comandoSQL .= "   and a.id_monitor = ".$dados['id_monitor']." ";
        $filtro .= "Curso->".$dados['desc_id_monitor'].",";
    }
    
    //ORIENTADOR
    if (!empty($dados['id_turno'])) {
        if ($dados['id_turno'] != EnumTurnoAtendimento::Todos) {
           $comandoSQL .= "   and a.id_turno = ".$dados['id_turno']." ";
           $filtro .= "Turno->".EnumTurnoAtendimento::getDescricao($dados['id_turno']).",";
        }
    }
    
    $comandoSQL .= " order by m.nome";
    
    //Criando instancia do relatorio PDF
    $relatorio = new Relatorio('L','mm','A4');  // L-paisagem P-retrato
    
    //Ajustando configuracao do relatorio
    $relatorio->usuario_logado=FuncaoCaracter::upperTexto($_SESSION["login"]);
    $relatorio->nome_relatorio = 'REL_ATENDIMENTO';
    $relatorio->titulo_relatorio = 'RELAÇÃO DE ATENDIMENTO';
    $relatorio->filtro_relatorio = $filtro;
    $relatorio->query_comando = $comandoSQL;
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'Monitor';
    $coluna->nome = 'nome';
    $coluna->tipo = EnumTipoCampo::Texto;
    $coluna->objeto = new Monitor();
    $coluna->largura = 85;
    $coluna->alinhamento = EnumTipoAlinhamento::Esquerda;
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'Local';
    $coluna->nome = 'local';
    $coluna->tipo = EnumTipoCampo::Texto;
    $coluna->largura = 45;
    $coluna->alinhamento = EnumTipoAlinhamento::Esquerda;
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'Turno';
    $coluna->nome = 'id_turno';
    $coluna->tipo = EnumTipoCampo::Select;
    $coluna->objeto = new EnumTurnoAtendimento();
    $coluna->largura = 25;
    $coluna->alinhamento = EnumTipoAlinhamento::Centralizado;
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'Hor. Seg';
    $coluna->nome = 'horario_seg';
    $coluna->tipo = EnumTipoCampo::Texto;
    $coluna->largura = 25;
    $coluna->alinhamento = EnumTipoAlinhamento::Esquerda;
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'Hor. ter';
    $coluna->nome = 'horario_ter';
    $coluna->tipo = EnumTipoCampo::Texto;
    $coluna->largura = 25;
    $coluna->alinhamento = EnumTipoAlinhamento::Esquerda;
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'Hor. Qua';
    $coluna->nome = 'horario_qua';
    $coluna->tipo = EnumTipoCampo::Texto;
    $coluna->largura = 25;
    $coluna->alinhamento = EnumTipoAlinhamento::Esquerda;
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'Hor. Qui';
    $coluna->nome = 'horario_qui';
    $coluna->tipo = EnumTipoCampo::Texto;
    $coluna->largura = 25;
    $coluna->alinhamento = EnumTipoAlinhamento::Esquerda;
    $relatorio->addColunaRel($coluna);
    
    $coluna = new ColunaRel();
    $coluna->titulo = 'Hor. Sex';
    $coluna->nome = 'horario_sex';
    $coluna->tipo = EnumTipoCampo::Texto;
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