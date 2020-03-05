<?php
//require_once("../../session/valida.php");
require_once("../../classe/faltas.php");
require_once("../../classe/professor.php");
require_once("../../classe/enum/enumtipoturno.php");
require_once '../../banco/conexao.php';
require_once '../../banco/funcaobanco.php';
require_once("../../util/funcaodata.php");
require_once("../../util/funcaocaracter.php");
require_once('../../relatorio/Fpdf-16/fpdf.php');

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
        
        
        //Logo
        $this->Image($this->logo_tipo,10,5,33,30);
        //Arial bold 15
        $this->SetFont($this->fonte_titulo_relatorio[0], $this->fonte_titulo_relatorio[1], $this->fonte_titulo_relatorio[2]);
        //Título
        $this->Cell(190,20,$this->titulo_relatorio,0,0,'C');
        //Salto de línea
        $this->Ln(20);
        
        $this->SetFont('Arial','I',10);
        $this->Cell(190,4,$this->filtro_relatorio,0,0,'R');
        $this->Ln(5);
        
        //Desenha caixa para titulo das colunas
        $this->SetFillColor(200,200,200);
        $this->SetTextColor(10);
        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(.2);
        $this->SetFont($this->fonte_titulo_coluna[0], $this->fonte_titulo_coluna[1], $this->fonte_titulo_coluna[2]);
        //Cabecera
        //$w=array(40,35,40,45);
        
        for($i=0;$i<count($header);$i++) {
            $this->Cell($margem[$i],4,$header[$i],1,0,'C',1);
        }
        $this->Ln();        
    }
    
    //Pie de página
    function Footer() {
        //Posición: a 1,5 cm del final
        $this->SetY(-15);
        //Arial italic 8
        $this->SetFont('Arial','I',8);
        //Número de página
        //$this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',1,0,'C');
        //$this->Cell(30,5,'Data:28-08-2018 as 13:00',1,0,'R');
        
        $this->Cell(190,0,'','T');
        $this->Ln();
        $this->Cell(80,5,'Usuário: '.$this->usuario_logado,0,0,'LR');
        $this->Cell(30,5,'Página '.$this->PageNo().'/{nb}',0,0,'C');
        $this->Cell(80,5,'Data: '.FuncaoData::formatoDataHora(FuncaoBanco::data_horaAtual()).'',0,0,'R');
    }
    
    //Tabla simple
    function BasicTable($header,$data)  {
        //Cabecera
        foreach($header as $col) {
            $this->Cell(40,7,$col,1);
        }
        $this->Ln();
        //Datos
        foreach($data as $row) {
            foreach($row as $col)
                $this->Cell(40,6,$col,1);
                $this->Ln();
        }
    }
    
    //Una tabla más completa
    function printTable($header,$data) {
        //Anchuras de las columnas
        //$w=array(10,70,60,20,30);
        $margem=$margem_coluna;
        //Cabeceras
        for($i=0;$i<count($header);$i++) {
            $this->Cell($margem[$i],7,$header[$i],1,0,'C');
        }
        $this->Ln();
        //Datos
        foreach($data as $row) {
            $this->Cell($margem[0],6,number_format($row[0]),'LR',0,'L');
            $this->Cell($margem[1],6,$row[1],'LR');
            $this->Cell($margem[2],6,$row[2],'LR');
            $this->Cell($margem[3],6,number_format($row[4]),'LR',0,'C');
            $this->Cell($margem[4],6,$row[5],'LR');
            $this->Ln();
        }
        //Línea de cierre
        $this->Cell(array_sum($margem),0,'-','T');
    }
    
    //Tabla coloreada
    function FancyTable() {
        //Dados para montar relatorio
        $header=$this->titulo_coluna;
        $data=$this->query_result;
        $margem=$this->margem_coluna;        
/*        
        //Desenha caixa para titulo das colunas
        $this->SetFillColor(200,200,200);
        $this->SetTextColor(10);
        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(.2);
        $this->SetFont($this->fonte_titulo_coluna[0], $this->fonte_titulo_coluna[1], $this->fonte_titulo_coluna[2]);
        
        //cabelhaco das colunas
        for($i=0;$i<count($header);$i++) {
            $this->Cell($margem[$i],4,$header[$i],1,0,'C',1);
        }
        $this->Ln();
*/        
        //DADOS DO RELATORIO
        $this->SetFillColor(220,220,220);
        $this->SetTextColor(50);
        $this->SetFont($this->fonte_dados_coluna[0], $this->fonte_dados_coluna[1], $this->fonte_dados_coluna[2]);
        //Datos
        $fill=false;
        $total_faltas = 0;
        
        foreach($data as $row) {
            $faltas = 0;
                
            if (!empty(trim($row[4]))) { $faltas++; }
            if (!empty(trim($row[5]))) { $faltas++; }
            if (!empty(trim($row[6]))) { $faltas++; }
            if (!empty(trim($row[7]))) { $faltas++; }
            if (!empty(trim($row[8]))) { $faltas++; }
            if (!empty(trim($row[9]))) { $faltas++; }
            
            $this->Cell($margem[0],6,number_format($row[0]),'LR',0,'L',$fill);
            $this->Cell($margem[1],6,$row[1],'LR',0,'L',$fill);
            $this->Cell($margem[2],6,FuncaoData::formatoData($row[2]),'LR',0,'L',$fill);            
            $this->Cell($margem[3],6,EnumTipoTurno::getDescricao($row[3]),'LR',0,'L',$fill);
            $this->Cell($margem[4],6,$faltas,'LR',0,'C',$fill);
            $this->Ln();
            $fill=!$fill;
            
            $total_faltas += $faltas; 
        }

        //TOTAL DO RELATORIO
        $this->SetFillColor(200,200,200);
        $this->SetTextColor(10);
        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(.2);
        $this->SetFont($this->fonte_titulo_coluna[0], $this->fonte_titulo_coluna[1], $this->fonte_titulo_coluna[2]);
        
        $this->Cell((array_sum($margem)-$margem[4]),6,'TOTAL DE FALTAS:','LR',0,'L',$fill);
        $this->Cell($margem[4],6,$total_faltas,'LR',0,'C',$fill);
        $this->Ln();
        
        $this->Cell(array_sum($margem),0,'','T');
    }
}

//Criando instancia do relatorio PDF
$pdf=new PDF('P','mm','A4');  // L-paisagem P-retrato

//Ajustando configuracao do relatorio
$pdf->usuario_logado=FuncaoCaracter::upperTexto($_SESSION["login"]);
$pdf->titulo_relatorio = 'RELATÓRIO DE FALTAS';
$pdf->filtro_relatorio = 'Periodo: 01/10/2019 a 31/10/2019';
$pdf->fonte_titulo_relatorio = array('Arial','B',15);
$pdf->logo_tipo = '../image/logo.jpg';
$pdf->titulo_coluna = array('ID','Professor','Data','Turno','Faltas');
$pdf->margem_coluna = array(10,115,22,22,20);
$pdf->fonte_titulo_coluna = array('Arial','B',8);

//Prepara cabecalho e rodape do relatorio

$pdf->AliasNbPages();
$pdf->AddPage();

//Dados para o relatorio
$objeto = new Faltas();
$comandoSQL =  "SELECT f.id_professor, p.nome, f.data, f.turno, f.horario_1, f.horario_2,"; 
$comandoSQL .= "       f.horario_3, f.horario_4, f.horario_5, f.horario_6";
$comandoSQL .= "  FROM faltas f, professor p";
$comandoSQL .= " where f.id_professor = p.id_professor";
$comandoSQL .= "   and f.data > (select max(data_final) from fechamento where tipo in (1,9))";
$comandoSQL .= "   and f.data between '2019/10/01' and '2019/10/31' ";
$comandoSQL .= " order by p.nome, f.data";
$pdf->query_result = $objeto->queryRelatorio($comandoSQL);
$pdf->fonte_dados_coluna = array('Times','',12);


//LOG
$log_evento = new Log();
$log_evento->queryInsert(
    'REL_FALTAS',
    'RELATORIO',
    $comandoSQL,
    'ACESSO EM :'.FuncaoData::formatoDataHora(FuncaoBanco::data_horaAtual())
    );

//Monta corpo do relatorio
$pdf->FancyTable();

$pdf->Output('rel_faltas.pdf','I');  // D-download do arquivo sem exibir   , I-exibe no browser com nome do arquivo para download   F


?>