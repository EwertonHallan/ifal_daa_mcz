<?php
require_once('../../../relatorio/Fpdf-16/fpdf.php');

class Relatorio extends FPDF {
    //Cabecera de página
    public $tipo_relatorio;
    public $nome_relatorio;
    public $titulo_relatorio;
    public $filtro_relatorio;
    private $page_with;
    public $logo_tipo;
    
    public $fonte_titulo_relatorio;
    public $fonte_filtro_relatorio;
    public $fonte_titulo_coluna;
    public $fonte_dados_coluna;
    
    public $arrayColuna;      // colecao da classe ColunaRel
    
    public $query_comando;
    public $query_result;
    public $usuario_logado;
    
    private $conexao;    // instancia da conexao do banco
    private $log;        // instancia da criacao do LOG
    
    
    public function __construct($orientation='P', $unit='mm', $format='A4') {
        $this->conexao = new Conexao();
        $this->log = new Log();
        $this->fonteDefault ();
        
        $this->FPDF($orientation,$unit,$format);
        
        if ($orientation == 'P') {
            $this->page_with = 190;
        } else {
            $this->page_with = 280;
        }
    }
    
    public function fonteDefault () {
        $this->tipo_relatorio = EnumTipoRelatorio::Simples;        
        $this->author = 'Ewerton Hallan';        
        $this->logo_tipo = '../../../relatorio/image/logo.jpg';
        
        $tipo_fonte = new Fonte();   $tipo_fonte->setFonte('Arial', 15, EnumTipoEstiloFonte::Negrito);        
        $this->fonte_titulo_relatorio = $tipo_fonte;
        
        $tipo_fonte = new Fonte();   $tipo_fonte->setFonte('Arial', 8, EnumTipoEstiloFonte::Italico);
        $this->fonte_filtro_relatorio = $tipo_fonte;
        
        $tipo_fonte = new Fonte();   $tipo_fonte->setFonte('Arial', 8, EnumTipoEstiloFonte::Negrito);
        $this->fonte_titulo_coluna = $tipo_fonte;
        
        $tipo_fonte = new Fonte();   $tipo_fonte->setFonte('Times', 11, EnumTipoEstiloFonte::Nenhum);
        $this->fonte_dados_coluna = $tipo_fonte;
    }
    
    public function addColunaRel (ColunaRel $coluna) {
        $this->arrayColuna[] = $coluna;
    }
    
    public function getColunaRel (int $indice) {
        return $this->arrayColuna[$indice];
    }
    
    private function countColuna () {
        return count($this->arrayColuna);
    }
    
    private function log_relatorio () {
        //$this->log = new Log();
        //LOG
        $this->log->queryInsert(
            $this->nome_relatorio,
            'RELATORIO',
            $this->query_comando,
            'ACESSO EM :'.FuncaoData::formatoDataHora(FuncaoBanco::data_horaAtual())
            );
        
    }    
    
    private function query () {
        //$this->conexao = new Conexao();
        try {
            $cmd = $this->query_comando;
            
            if (!is_null($cmd) || !empty($cmd)) {
                
                //echo 'query:'.$cmd.'<br>';
                $stm = $this->conexao->conectar()->prepare($cmd);
                $stm->execute();
                
                return $stm->fetchAll();
            } else {
                return FALSE;
            }
        } catch (PDOException $ex) {
            return 'Error:'.$ex->getMessage();
        }
    }
    
    public function execRelatorio () {
        //Prepara cabecalho e rodape do relatorio
        $this->AliasNbPages();
        $this->AddPage();
        
        $this->query_result = $this->query();
        
        //LOG DA EXECUCAO DO RELATORIO
        $this->log_relatorio();
        
        //Monta corpo do relatorio
        switch ($this->tipo_relatorio) {
            case EnumTipoRelatorio::Simples:
                $this->simplesRelatorio();
                break;
            case EnumTipoRelatorio::Agrupado:
                $this->FancyTable();
                break;
            case EnumTipoRelatorio::MestreDetalhe:
                $this->FancyTable();
                break;
        }
        
        $this->Output($this->nome_relatorio.'.pdf','D');  // D-download do arquivo sem exibir   , I-exibe no browser com nome do arquivo para download   F
    }
    
    private function formataValor(ColunaRel $coluna, $valor) {
        $retorno = NULL;
        $tipo = $coluna->getTipo();
        
        switch ($tipo) {
            case EnumTipoCampo::Numero:
                $retorno = number_format($valor);
                break;                
            case EnumTipoCampo::Data:
                $retorno = FuncaoData::formatoData($valor);
                break;
            case EnumTipoCampo::Select:
                $retorno = $coluna->getObjeto()::getDescricao($valor);
                break;
            case EnumTipoCampo::Pesquisa:
                $retorno = $valor.'-'.$coluna->getObjeto()->getNome($valor);
                break;
            default:
                $retorno = $valor;
                break;
        }
        
        return $retorno;
    }
    
    //Cabecalho do relatorio
    function Header() {
        //Logo
        $this->Image($this->logo_tipo,10,5,33,30);
        //Arial bold 15
        //$this->SetFont($this->fonte_titulo_relatorio[0], $this->fonte_titulo_relatorio[1], $this->fonte_titulo_relatorio[2]);
        $this->SetFont($this->fonte_titulo_relatorio->getNome(), $this->fonte_titulo_relatorio->getEstilo(), $this->fonte_titulo_relatorio->getTamanho());
        
        //Título
        $this->Cell($this->page_with,20,$this->titulo_relatorio,0,0,'C');
        //Salto de línea
        $this->Ln(20);
        
        if (!empty($this->filtro_relatorio)) {
            //$this->SetFont('Arial','I',8);
            $this->SetFont($this->fonte_filtro_relatorio->getNome(), $this->fonte_filtro_relatorio->getEstilo(), $this->fonte_filtro_relatorio->getTamanho());
            
            $this->Cell($this->page_with,4,$this->filtro_relatorio,0,0,'R');
            $this->Ln(5);
            }
        
        //Desenha caixa para titulo das colunas
        $this->SetFillColor(200,200,200);
        $this->SetTextColor(10);
        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(.2);

        //$this->SetFont($this->fonte_titulo_coluna[0], $this->fonte_titulo_coluna[1], $this->fonte_titulo_coluna[2]);
        $this->SetFont($this->fonte_titulo_coluna->getNome(), $this->fonte_titulo_coluna->getEstilo(), $this->fonte_titulo_coluna->getTamanho());
        
        //Cabecalho
        
        $coluna = new ColunaRel();
        for($i = 0; $i < $this->countColuna(); $i++) {
            $coluna = $this->getColunaRel($i);
            $this->Cell($coluna->getLargura(),4,$coluna->getTitulo(),1,0,'C',1);
        }
        $this->Ln();
    }
    
    //Pie de página
    function Footer() {
        //Posición: a 1,5 cm del final
        $this->SetY(-15);
        //Arial italic 8
        
        //$this->SetFont('Arial','I',8);
        $this->SetFont($this->fonte_filtro_relatorio->getNome(), $this->fonte_filtro_relatorio->getEstilo(), $this->fonte_filtro_relatorio->getTamanho());
        
        //Número de página
        //$this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',1,0,'C');
        //$this->Cell(30,5,'Data:28-08-2018 as 13:00',1,0,'R');
        
        $this->Cell($this->page_with,0,'','T');
        $this->Ln();
        $this->Cell(($this->page_with*.40),5,'Usuário: '.$this->usuario_logado,0,0,'LR');
        $this->Cell(($this->page_with-($this->page_with*.40)*2),5,'Página '.$this->PageNo().'/{nb}',0,0,'C');
        $this->Cell(($this->page_with*.40),5,'Data: '.FuncaoData::formatoDataHora(FuncaoBanco::data_horaAtual()).'',0,0,'R');
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
        $data=$this->query_result;
        
        //DADOS DO RELATORIO
        $this->SetFillColor(220,220,220);
        $this->SetTextColor(50);
        //$this->SetFont($this->fonte_dados_coluna[0], $this->fonte_dados_coluna[1], $this->fonte_dados_coluna[2]);
        $this->SetFont($this->fonte_dados_coluna->getNome(), $this->fonte_dados_coluna->getEstilo(), $this->fonte_dados_coluna->getTamanho());
        //Datos
        $fill=false;
        $coluna = new ColunaRel();
        
        foreach($data as $row) {
            
            for ($i = 0; $i < $this->countColuna(); $i++) {
                $coluna = $this->getColunaRel($i);
                
                $larg = $coluna->getLargura();
                $alin = $coluna->getAlinhamento();
                $valor = $this->formataValor($coluna, $row[$coluna->getNome()]);
                
                $this->Cell($larg,6,$valor,'LR',0,$alin,$fill);                
                //$this->Cell($this->getColunaRel($i)->getLargura(),6,$row[$i],'LR',0,$this->getColunaRel($i)->getAlinhamento(),$fill);
            }
            $this->Ln();
            $fill=!$fill;
        }
        
        //TOTAL DO RELATORIO
        $this->SetFillColor(200,200,200);
        $this->SetTextColor(10);
        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(.2);
        //$this->SetFont($this->fonte_titulo_coluna[0], $this->fonte_titulo_coluna[1], $this->fonte_titulo_coluna[2]);
        $this->SetFont($this->fonte_titulo_coluna->getNome(), $this->fonte_titulo_coluna->getEstilo(), $this->fonte_titulo_coluna->getTamanho());
               
        $this->Cell($this->page_with,0,'','T');
    }

    //Tabla coloreada
    function simplesRelatorio() {
        //Dados para montar relatorio
        $data=$this->query_result;
        
        //DADOS DO RELATORIO
        $this->SetFillColor(220,220,220);
        $this->SetTextColor(50);
        
        //$this->SetFont($this->fonte_dados_coluna[0], $this->fonte_dados_coluna[1], $this->fonte_dados_coluna[2]);
        $this->SetFont($this->fonte_dados_coluna->getNome(), $this->fonte_dados_coluna->getEstilo(), $this->fonte_dados_coluna->getTamanho());
        
        //Datos
        $fill=false;
        $coluna = new ColunaRel();
        
        foreach($data as $row) {
            
            for ($i = 0; $i < $this->countColuna(); $i++) {
                $coluna = $this->getColunaRel($i);
                
                $larg = $coluna->getLargura();
                $alin = $coluna->getAlinhamento();
                $valor = $this->formataValor($coluna, $row[$coluna->getNome()]);
                
                $this->Cell($larg,6,$valor,'LR',0,$alin,$fill);
                //$this->Cell($this->getColunaRel($i)->getLargura(),6,$row[$i],'LR',0,$this->getColunaRel($i)->getAlinhamento(),$fill);
            }
            $this->Ln();
            $fill=!$fill;
        }
        
        //TOTAL DO RELATORIO
        $this->SetFillColor(200,200,200);
        $this->SetTextColor(10);
        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(.2);
        
        //$this->SetFont($this->fonte_titulo_coluna[0], $this->fonte_titulo_coluna[1], $this->fonte_titulo_coluna[2]);
        $this->SetFont($this->fonte_titulo_coluna->getNome(), $this->fonte_titulo_coluna->getEstilo(), $this->fonte_titulo_coluna->getTamanho());
        
        $this->Cell($this->page_with,0,'','T');
    }
}

?>