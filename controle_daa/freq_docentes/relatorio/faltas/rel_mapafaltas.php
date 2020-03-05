<?php
/*require_once('../../../relatorio/classe/relatorio.php');
require_once('../../../relatorio/classe/colunarel.php');
require_once('../../../relatorio/classe/fonte.php');
require_once('../../../relatorio/classe/enumtipoestilofonte.php');
require_once('../../../relatorio/classe/enumtipoalinhamento.php');
require_once('../../../relatorio/classe/enumtiporelatorio.php');

require_once('../../../form/classe/enumtipocampo.php');
*/
require_once('../../../relatorio/Fpdf-16/fpdf.php');

require_once('../../../banco/conexao.php');
require_once('../../../banco/funcaobanco.php');
require_once('../../../util/funcaodata.php');
require_once('../../../util/funcaocaracter.php');

require_once('../../../classe/log.php');
require_once('../../../classe/enum/enumtipoturno.php');

require_once("../../classe/faltas.php");
require_once("../../classe/justificativa.php");
require_once("../../classe/professor.php");

$erro = FALSE;
$mensagem = 'ERROR: \n';

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
        
        
        //Logo
        $this->Image($this->logo_tipo,10,5,33,30);
        //Arial bold 15
        $this->SetFont($this->fonte_titulo_relatorio[0], $this->fonte_titulo_relatorio[1], $this->fonte_titulo_relatorio[2]);
        //Título
        $this->Cell(190,20,$this->titulo_relatorio,0,0,'C');
        //Salto de línea
        $this->Ln(20);
        
        $this->SetFont('Arial','I',8);
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
        $grupo = null;
        $total_faltas = 0;
        $total_grp_faltas = 0;
        $total_rel_faltas = 0;
        $just = new Justificativa();
        
        foreach($data as $row) {
            $faltas = 0;
            
            if ($grupo <> $row[0]) {
                $fill=true;

                //SUB-TOTAL POR COORDENACAO
                if ($total_grp_faltas > 0) {
                    $this->SetFont('Times','BI',12);
                    
                    $this->Cell((array_sum($margem)-$margem[4]),6,'TOTAL DA COORDENAÇÃO:','LR',0,'C',$fill);
                    $this->Cell($margem[4],6,$total_grp_faltas,'LR',0,'C',$fill);
                    $this->Ln();                    
                }
                
                //INICIO DO GRUPO COORDENACAO               
                $this->SetFont('Times','B',12);
                
                $this->Cell(array_sum($margem),6,$row[1],'LR',0,'L',$fill);
                $this->Ln();
                $fill=false;
                
                $grupo = $row[0];
                $total_grp_faltas = 0;
            }
            
            //checa justificativa de faltas
            $eliminaFalta = FALSE;
            $result = $just->checkJustificativa($row[2], $row[5], $row[4]);
            if (strlen($result['dt_inicio']) > 0) {
                $eliminaFalta = TRUE;
            }
            
            $this->SetFont($this->fonte_dados_coluna[0], $this->fonte_dados_coluna[1], $this->fonte_dados_coluna[2]);
            
            if (!$eliminaFalta) {
                if (!empty(trim($row[6]))) { $faltas++; }
                if (!empty(trim($row[7]))) { $faltas++; }
                if (!empty(trim($row[8]))) { $faltas++; }
                if (!empty(trim($row[9]))) { $faltas++; }
                if (!empty(trim($row[10]))) { $faltas++; }
                if (!empty(trim($row[11]))) { $faltas++; }
                
                $this->Cell($margem[0],6,number_format($row[2]),'LR',0,'L',$fill);
                $this->Cell($margem[1],6,$row[3],'LR',0,'L',$fill);
                $this->Cell($margem[2],6,FuncaoData::formatoData($row[4]),'LR',0,'L',$fill);
                $this->Cell($margem[3],6,EnumTipoTurno::getDescricao($row[5]),'LR',0,'L',$fill);
                $this->Cell($margem[4],6,$faltas,'LR',0,'C',$fill);
                $this->Ln();
                $fill=!$fill;
                
                $total_grp_faltas += $faltas;
                $total_rel_faltas += $faltas;
            }
        }
        
        //SUB-TOTAL POR COORDENACAO
        if (($total_grp_faltas > 0) && ($this->mostra_subtotal)) {
            $this->SetFont('Times','BI',12);
            
            $this->Cell((array_sum($margem)-$margem[4]),6,'TOTAL DA COORDENAÇÃO:','LR',0,'C',$fill);
            $this->Cell($margem[4],6,$total_grp_faltas,'LR',0,'C',$fill);
            $this->Ln();
        }
        
        //TOTAL DO RELATORIO
        $this->SetFillColor(200,200,200);
        $this->SetTextColor(10);
        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(.2);
        $this->SetFont($this->fonte_titulo_coluna[0], $this->fonte_titulo_coluna[1], $this->fonte_titulo_coluna[2]);
        
        $this->Cell((array_sum($margem)-$margem[4]),6,'TOTAL DE FALTAS:','LR',0,'L',$fill);
        $this->Cell($margem[4],6,$total_rel_faltas,'LR',0,'C',$fill);
        $this->Ln();
        
        $this->Cell(array_sum($margem),0,'','T');
    }
}

if (!$erro) {
    //Criando instancia do relatorio PDF
    $pdf=new PDF('P','mm','A4');  // L-paisagem P-retrato
    
    //Ajustando configuracao do relatorio
    $pdf->usuario_logado=FuncaoCaracter::upperTexto($_SESSION["login"]);
    $pdf->titulo_relatorio = 'MAPA DE FALTAS';
    $pdf->filtro_relatorio = 'Periodo: '.FuncaoData::formatoData($dados['data_inicial']).' a '.FuncaoData::formatoData($dados['data_final']);
    if (empty($dados['id_coordenacao'])) {
        $pdf->filtro_relatorio .= ' | Coordenação: Todas';
    } else {
        $pdf->filtro_relatorio .= ' | Coordenação: '.$dados['id_coordenacao'].'-'.$dados['desc_id_coordenacao'];
    }
    $pdf->filtro_relatorio .= ' | Turno: '.EnumTipoTurno::getDescricao($dados['id_turno']);
    $pdf->fonte_titulo_relatorio = array('Arial','B',15);
    $pdf->logo_tipo = '../../../relatorio/image/logo.jpg';
    $pdf->titulo_coluna = array('ID','Professor','Data','Turno','Faltas');
    $pdf->margem_coluna = array(10,115,22,22,20);
    $pdf->fonte_titulo_coluna = array('Arial','B',8);
    
    //Prepara cabecalho e rodape do relatorio
    
    $pdf->AliasNbPages();
    $pdf->AddPage();
    
    //Dados para o relatorio
    $objeto = new Faltas();
    $comandoSQL =  "SELECT c.id_coordenacao, c.nome, f.id_professor, p.nome, ";
    $comandoSQL .= "       f.data, f.turno, f.horario_1, f.horario_2,";
    $comandoSQL .= "       f.horario_3, f.horario_4, f.horario_5, f.horario_6";
    $comandoSQL .= "  FROM faltas f, professor p, coordenacao c";
    $comandoSQL .= " where f.id_professor = p.id_professor";
    $comandoSQL .= "   and p.id_coordenacao = c.id_coordenacao";
    $comandoSQL .= "   and f.data between '".$dados['data_inicial']."' and '".$dados['data_final']."' ";

    //COORDENACAO
    $pdf->mostra_subtotal = true;
    if (!empty($dados['id_coordenacao'])) {
        $comandoSQL .= "   and c.id_coordenacao = ".$dados['id_coordenacao']." ";
        $pdf->mostra_subtotal = false;        
    }
    //TURNO
    if ($dados['id_turno'] <> EnumTipoTurno::Todos) {
        $comandoSQL .= "   and f.turno = ".$dados['id_turno']." ";
    }
    $comandoSQL .= " order by c.nome, p.nome, f.data";
    $pdf->query_result = $objeto->queryRelatorio($comandoSQL);
    $pdf->fonte_dados_coluna = array('Times','',12);
    
    //LOG
    $log_evento = new Log();
    $log_evento->queryInsert(
        'REL_MAPAFALTAS',
        'RELATORIO',
        $comandoSQL,
        'ACESSO EM :'.FuncaoData::formatoDataHora(FuncaoBanco::data_horaAtual())
        );
    
    //Monta corpo do relatorio
    $pdf->FancyTable();
    
    $pdf->Output('rel_mapafaltas.pdf','D');  // D-download do arquivo sem exibir   , I-exibe no browser com nome do arquivo para download   F

} else {
    if ($erro) {
        echo '<script type="text/javascript">'.
            'alert("'.$mensagem.'");'.
            'history.go(-1);'.
            '</script>';
    }
    
}

?>