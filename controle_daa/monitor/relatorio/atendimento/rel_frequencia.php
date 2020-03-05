<?php
require_once('../../../relatorio/Fpdf-16/fpdf.php');

require_once('../../../banco/conexao.php');
require_once('../../../banco/funcaobanco.php');
require_once('../../../util/funcaodata.php');
require_once('../../../util/funcaocaracter.php');

require_once('../../../classe/log.php');

require_once("../../classe/curso.php");
require_once("../../classe/atendimento.php");
require_once("../../classe/monitor.php");
require_once("../../classe/enum/enumturnoatendimento.php");
require_once("../../../freq_docentes/classe/professor.php");

$erro = FALSE;
$mensagem = 'ERROR: \n';

$dados = $_POST;

/*
 if (!isset($_POST) || empty($_POST)) {
    $erro = TRUE;
    $mensagem .= 'Formulario vazio !';
} else {
    $dados = $_POST;
    if (!isset($dados['mes_ano']) || !FuncaoData::validaData($dados['mes_ano'])) {
        $erro = TRUE;
        $mensagem .= 'Campo: MES invalido! \n';
    } else {
        $dt = FuncaoBanco::formataData($dados['data_inicial']);
        $dados['dia_inicial'] = $dt;
        $dados['dia_final'] = $dt;
    }
    //var_dump($dados);
}
*/    


class PDF extends FPDF {
    //Cabecera de página
    public $titulo_relatorio;
    public $filtro_relatorio;
    public $logo_tipo;
    public $fonte_titulo_relatorio;
    public $titulo_coluna;
    public $margem_coluna;
    public $fonte_titulo_coluna;
    public $query_result;
    public $fonte_dados_coluna;
    public $usuario_logado;
    public $mostra_subtotal;
    
    /*
     function PDF ($orientation='P', $unit='mm', $format='A4') {
     $this->FPDF($orientation,$unit,$format);
     
     if ($orientation == 'P') {
     $this->page_with = 190;
     } else {
     $this->page_with = 300;
     }
     
     }
     */
    //Cabecalho do relatorio
    function Header() {
        $this->author = 'Ewerton Hallan';
        $header=$this->titulo_coluna;
        $margem=$this->margem_coluna;
        $this->SetMargins(9, 0);
        $this->SetAutoPageBreak(true, 13);
        
        //Título
        //$this->Cell(190,20,$this->titulo_relatorio,0,0,'C');
        $this->Rect(7, 7, 140, 189);
        $this->Rect(147, 7, 140, 189);
        $this->SetFont('Arial','B',10);
        $this->SetXY(7, 8);
        $this->Cell(137,4,'INSTITUTO FEDERAL DE ALAGOAS - CAMPUS MACEIÓ',0,0,'C');
        $this->Cell(138,4,'INSTITUTO FEDERAL DE ALAGOAS - CAMPUS MACEIÓ',0,1,'C');
        $this->Cell(137,4,'DIRETORIA DE APOIO ACADÊMICO - DAA',0,0,'C');
        $this->Cell(138,4,'DIRETORIA DE APOIO ACADÊMICO - DAA',0,1,'C');
        $this->Line(7, 16, 287, 16);
        //Salto de línea
        $this->Ln(1);
    }
    
    //Pie de página
    function Footer() {
    }
    
    //Tabla simple
    function paginaDireita($orientador)  {
        //Cabecera
        //Linha 01
        $this->SetXY(150, 19);
        $this->SetFont('Arial','B',8);
        $this->Cell(138,4,'1 - QUANTO A FREQUÊNCIA:',0,0,'L');
        $this->Ln(4);
        
        //Linha 02
        $this->SetXY(150, 27);
        $this->SetFont('Arial','B',8);
        $this->Cell(10,4,' ',0,0,'C');
        $this->Cell(30,4,'ÓTIMO',1,0,'C');
        $this->Cell(15,4,' ',0,0,'C');
        $this->Cell(30,4,'BOM',1,0,'C');
        $this->Cell(15,4,' ',0,0,'C');
        $this->Cell(30,4,'REGULAR',1,0,'C');
        $this->Ln(4);
        
        //Linha 03
        $this->SetXY(150, 35);
        $this->SetFont('Arial','B',8);
        $this->Cell(30,4,' ',0,0,'C');
        $this->Cell(118,4,'- O monitor apresentou justificativa, caso tenha falado:',0,0,'L');
        $this->Ln(4);
        
        //Linha 04
        $this->SetXY(150, 42);
        $this->SetFont('Arial','B',8);
        $this->Cell(45,4,' ',0,0,'C');
        $this->Cell(20,4,'SIM',1,0,'C');
        $this->Cell(15,4,' ',0,0,'C');
        $this->Cell(20,4,'NÃO',1,0,'C');
        $this->Ln(4);        

        //Linha 05
        $this->SetXY(150, 50);
        $this->SetFont('Arial','B',8);
        $this->Cell(138,4,'2 - QUANTO AO INTERESSE:',0,0,'L');
        $this->Ln(4);
        
        //Linha 06
        $this->SetXY(150, 57);
        $this->SetFont('Arial','B',8);
        $this->Cell(10,4,' ',0,0,'C');
        $this->Cell(30,4,'ÓTIMO',1,0,'C');
        $this->Cell(15,4,' ',0,0,'C');
        $this->Cell(30,4,'BOM',1,0,'C');
        $this->Cell(15,4,' ',0,0,'C');
        $this->Cell(30,4,'REGULAR',1,0,'C');
        $this->Ln(4);
        
        //Linha 07
        $this->SetXY(150, 70);
        $this->Cell(138,4,'3 - QUANTO A INICIATIVA DEMONSTRADA NESSE PERÍODO:',0,0,'L');
        $this->Ln(4);
        
        //Linha 08
        $this->SetXY(150, 77);
        $this->SetFont('Arial','B',8);
        $this->Cell(10,4,' ',0,0,'C');
        $this->Cell(30,4,'ÓTIMO',1,0,'C');
        $this->Cell(15,4,' ',0,0,'C');
        $this->Cell(30,4,'BOM',1,0,'C');
        $this->Cell(15,4,' ',0,0,'C');
        $this->Cell(30,4,'REGULAR',1,0,'C');
        $this->Ln(4);
        
        //Linha 09
        $this->SetXY(150, 88);
        $this->Cell(138,4,'4 – QUANTO A ORDEM, MÉTODO E APARÊNCIA DOS TRABALHOS:',0,0,'L');
        $this->Ln(4);
        
        //Linha 10
        $this->SetXY(150, 95);
        $this->SetFont('Arial','B',8);
        $this->Cell(10,4,' ',0,0,'C');
        $this->Cell(30,4,'ÓTIMO',1,0,'C');
        $this->Cell(15,4,' ',0,0,'C');
        $this->Cell(30,4,'BOM',1,0,'C');
        $this->Cell(15,4,' ',0,0,'C');
        $this->Cell(30,4,'REGULAR',1,0,'C');
        $this->Ln(4);
        
        //Linha 11
        $this->SetXY(150, 107);
        $this->Cell(138,4,'5 – OBSERVAÇÃO E SUGESTÕES DE MEDIDAS QUE CONTRIBUAM PARA MELHORAR A ORGANI-',0,0,'L');
        $this->Ln(4);
        $this->SetXY(150, 111);
        $this->Cell(138,4,'      ZAÇÃO DO TRABALHO:',0,0,'L');
        $this->Ln(4);
        
        //Linha 12
        $this->SetXY(150, 117);
        $this->Rect(152, 117, 132, 28);
        $this->Line(152, 124, 284, 124);
        $this->Line(152, 131, 284, 131);
        $this->Line(152, 138, 284, 138);
        $this->Ln(4);
        
        //Linha 13
        $this->SetXY(175, 153);
        $this->Cell(138,4,'Maceió / AL, _______ de ________________ de 20____.',0,0,'L');
        $this->Ln(4);
        
        //Linha 14
        $this->SetXY(175, 167);
        $this->Cell(138,4,'______________________________________________________',0,0,'L');
        $this->Ln(4);
        $this->SetXY(150, 171);
        $this->Cell(138,4,'Prof.'.$orientador,0,0,'C');
        $this->Ln(4);
        $this->SetXY(150, 175);
        $this->SetFont('Arial','',7);
        $this->Cell(138,4,'(Assinatura e Carimbo)',0,0,'C');
        $this->Ln(4);
        
        //Linha 15
        $this->SetXY(150, 185);
        $this->SetFont('Arial','B',8);
        $this->Cell(138,4,'Ciência do Monitor Avaliado:________________________________________________________',0,0,'L');
        $this->Ln(4);
        
        //Linha 16
        $this->SetXY(150, 190);
        $this->Cell(138,4,'Data: _______/____________/_________.',0,0,'L');
        $this->Ln(4);
        
    }
    
    //DADOS DO MONITOR
    function dadosMonitor ($dados) {
        //Linha 01
        $this->SetFont('Arial','',8);
        $this->Cell(10,4,'Aluno:',0,0,'L');
        $this->SetFont('Arial','B',8);
        $this->Cell(127,4,$dados['monitor'],0,0,'L');
        $this->Ln(4);
        
        //Linha 02
        $this->SetFont('Arial','',8);
        $this->Cell(10,4,'Curso:',0,0,'L');
        $this->SetFont('Arial','B',8);
        $this->Cell(80,4,$dados['curso'],0,0,'L');
        $this->SetFont('Arial','',8);
        $this->Cell(10,4,'Turma:',0,0,'L');
        $this->SetFont('Arial','B',8);
        $this->Cell(37,4,$dados['turma'],0,0,'L');
        $this->Ln(4);
        
        //Linha 03
        $this->SetFont('Arial','',8);
        $this->Cell(10,4,'Local:',0,0,'L');
        $this->SetFont('Arial','B',8);
        $this->Cell(75,4,$dados['local'],0,0,'L');
        $this->SetFont('Arial','',8);
        $this->Cell(18,4,'Turno Atend.:',0,0,'L');
        $this->SetFont('Arial','B',8);
        $this->Cell(34,4,$dados['turno'],0,0,'L');
        $this->Ln(4);
        
        //Linha 03
        $this->SetFont('Arial','',8);
        $this->Cell(12,4,'Horário:',0,0,'L');
        $this->SetFont('Arial','B',8);
        $this->Cell(125,4,$dados['horario'],0,0,'L');
        $this->SetFont('Arial','B',8);
        $this->Ln(4);
        
        //Linha 04
        $this->SetFont('Arial','',8);
        $this->Cell(8,4,'Mês:',0,0,'L');
        $this->SetFont('Arial','B',8);
        $this->Cell(125,4,$dados['mes_ano'],0,0,'L');
        $this->Ln(4);
    }
    
    private function getFolga ($horario) {
        $txt = '';
        if (FuncaoCaracter::upperTexto($horario) == 'FOLGA') {
            $txt = 'FOLGA';
        }
        
        return $txt;
    }
    
    private function diaSemana ($data, $dados) {
        $txt = '';
        $dia =  FuncaoBanco::formataData($data);
        $dia_sem = FuncaoData::diaSemana($dia);
        
        switch ($dia_sem) {
            case 0: $txt = 'DOMINGO';   break;
            case 1: $txt = $this->getFolga(FuncaoCaracter::upperTexto($dados['horario_seg']));   break;
            case 2: $txt = $this->getFolga(FuncaoCaracter::upperTexto($dados['horario_ter']));   break;
            case 3: $txt = $this->getFolga(FuncaoCaracter::upperTexto($dados['horario_qua']));   break;
            case 4: $txt = $this->getFolga(FuncaoCaracter::upperTexto($dados['horario_qui']));   break;
            case 5: $txt = $this->getFolga(FuncaoCaracter::upperTexto($dados['horario_sex']));   break;
            case 6: $txt = 'SABADO';   break;
        }

        return $txt;
    }
    
    //Una tabla más completa
    function paginaEsquerda($qtd_dias, $dados) {
        //$this->SetXY($x, $y);
        
        //Titulo da TABELA
        $this->SetFont('Arial','BI',8);
        $this->Cell(30,4,'DATA',1,0,'C');
        $this->Cell(53,4,'ENTRADA',1,0,'C');
        $this->Cell(53,4,'SAÍDA',1,0,'C');
        $this->Ln(4);
        
        $txt_dia = '';
        for ($i = 1; $i <= $qtd_dias; $i++) {
            if ($i < 10) {
                $txt_dia = '0'.$i;
            } else {
                $txt_dia = $i;
            }
            
            $txt = $this->diaSemana($txt_dia.$dados['data'], $dados);
            
            //DIA 01
            $this->SetFont('Arial','BI',8);
            $this->Cell(30,5,$txt_dia,1,0,'C');
            $this->Cell(53,5,$txt,1,0,'C');
            $this->Cell(53,5,$txt,1,0,'C');
            $this->SetFont('Arial','B',8);
            $this->Ln();
        }
        
    }
    
    //Tabla coloreada
    function FancyTable($mes_ano) {
        $data = $this->query_result;
        
        foreach($data as $dados) {
            $dados['turno'] = EnumTurnoAtendimento::getDescricao($dados['id_turno']);
            $dados['data'] = '/'.$mes_ano;
            $dados['mes_ano'] = FuncaoData::mesExtenso('01'.$dados['data']);
            $dados['horario'] = 'SEG:'.$dados['horario_seg'].' TER:'.$dados['horario_ter'].' QUA:'.$dados['horario_qua'].' QUI:'.$dados['horario_qui'].' SEX:'.$dados['horario_sex'];
            
            //var_dump($dados);
            
            $this->dadosMonitor($dados);
            $this->paginaEsquerda(31,$dados);
            $this->paginaDireita($dados['orientador']);
            
        }
        
    }
}

if (!$erro) {
    
    //$dados['mes_ano'] = '10/2019';
    
    //Dados para o relatorio
    $comandoSQL =  "SELECT a.id_atendimento, a.id_monitor, m.nome as monitor, m.id_professor, p.nome as orientador, ";
    $comandoSQL .=  "      m.id_curso, c.nome as curso, m.turma, a.local, a.id_turno,  ";
    $comandoSQL .=  "      a.horario_seg, a.horario_ter, a.horario_qua, a.horario_qui, a.horario_sex ";
    $comandoSQL .=  "  FROM monitor_atendimento a, monitor m, curso c, professor p ";
    $comandoSQL .=  " WHERE a.id_monitor = m.id_monitor and m.id_curso = c.id_curso and m.id_professor = p.id_professor ";
    
    //MONITOR
    if (!empty($dados['id_monitor'])) {
        $comandoSQL .= "   and a.id_monitor = ".$dados['id_monitor']." ";
    }
    
    //CURSO
    if (!empty($dados['id_curso'])) {
        $comandoSQL .= "   and m.id_curso = ".$dados['id_curso']." ";
    }
    
    //ORIENTADOR
    if (!empty($dados['id_professor'])) {
        $comandoSQL .= "   and m.id_professor = ".$dados['id_professor']." ";
    }
    
    //ORIENTADOR
    if (!empty($dados['id_turno'])) {
        if ($dados['id_turno'] != EnumTurnoAtendimento::Todos) {
            $comandoSQL .= "   and a.id_turno = ".$dados['id_turno']." ";
        }
    }
    
    $comandoSQL .=  " order by m.nome ";
    
    //Criando instancia do relatorio PDF
    $pdf=new PDF('L','mm','A4');  // L-paisagem P-retrato
    
    //Ajustando configuracao do relatorio
    $pdf->usuario_logado=FuncaoCaracter::upperTexto($_SESSION["login"]);
    $pdf->titulo_relatorio = 'INSTITUTO FEDERAL DE ALAGOAS - CAMPUS MACEIÓ /n DIRETORIA DE APOIO ACADÊMICO - DAA';
    $pdf->filtro_relatorio = 'MÊS: '.$dados['mes_ano'];

    $pdf->fonte_titulo_relatorio = array('Arial','B',15);
    $pdf->logo_tipo = '../../../relatorio/image/logo.jpg';
    $pdf->titulo_coluna = array('ID','Professor','Data','Turno','Faltas');
    $pdf->margem_coluna = array(10,115,22,22,20);
    $pdf->fonte_titulo_coluna = array('Arial','B',8);
    
    //Prepara cabecalho e rodape do relatorio
    
    $pdf->AliasNbPages();
    $pdf->AddPage();
    
    //Dados para o relatorio
    $objeto = new Atendimento();
    
    $pdf->query_result = $objeto->queryRelatorio($comandoSQL);
    $pdf->fonte_dados_coluna = array('Times','',12);
    
    //LOG
    $log_evento = new Log();
    $log_evento->queryInsert(
        'REL_FREQUENCIA',
        'RELATORIO',
        $comandoSQL,
        'ACESSO EM :'.FuncaoData::formatoDataHora(FuncaoBanco::data_horaAtual())
        );
    
    //Monta corpo do relatorio
    $pdf->FancyTable($dados['mes_ano']);
    
    $pdf->Output('rel_frequencia.pdf','D');  // D-download do arquivo sem exibir   , I-exibe no browser com nome do arquivo para download   F
    
} else {
    if ($erro) {
        echo '<script type="text/javascript">'.
            'alert("'.$mensagem.'");'.
            'history.go(-1);'.
            '</script>';
    }
    
}

?>
