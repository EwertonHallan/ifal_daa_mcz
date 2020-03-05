<?php
class Tela_Pesquisa {
    private $titulo;      // titulo da tela de cadastro
    private $status;      // titulo da tela de cadastro
    private $classDados;  // nome da tabela que sera igual ao da class
    
    public function __construct() {
    }
    
    public function __set ($atributo, $valor) {
        $this->$atributo = $valor;
    }
    
    public function __get ($atributo) {
        return $this->$atributo;
    }
    
    public function setTitulo (String $titulo) {
        $this->titulo = $titulo;
    }
    
    public function getTitulo () {
        return $this->titulo;
    }
    
    public function setStatus (String $status) {
        $this->status = $status;
    }
    
    public function getStatus () {
        return $this->status;
    }
    
    public function setClassPesq (object $classPesq) {
        $this->ClassPesq = $classPesq;
    }
    
    public function getClassPesq () {
        return $this->classDados;
    }
    
    public function montaHTML () {
        $html = '';
        
        $html .= ' <div id="janela">';
        $html .= '  <table border=0 width="100%">';
        $html .= '   <tr>'; 
        $html .= '    <td colspan=2>';
        $html .= '     <div id="barra_titulo">';
        $html .= '      <table>';
        $html .= '       <tr>';
        $html .= '        <td width="90%">';
        $html .= '         <div id="titulo">';
        $html .= '       	<font FACE="Verdana" size=2 color="white"><b>'.$this->getTitulo().'</b></font>';
        $html .= '         </div>';
        $html .= '        </td>';        
        $html .= '        <td width="10%">';
        $html .= '         <div id="bt_fechar">';
        $html .= '   	    <input type="button" value=" X " onclick="ocultar();">';
        $html .= '         </div>';
        $html .= '        </td>';		
        $html .= '       </tr>';
        $html .= '      </table>';
        $html .= '     </div>';
        $html .= '    </td>';
	    $html .= '   </tr>';
	    $html .= '   <tr>';
	    $html .= '    <td colspan=2>';
	    $html .= '     <br>';
	    $html .= '     <form name="form_pesquisa" id="form_pesquisa" method="post" action="">';
	    $html .= '      <label for="pesquisaDados">Texto:</label>';
	    $html .= '      <input type="text" name="pesquisaDados" id="pesquisaDados" value="" placeholder="Digite o texto a pesquisar ..." size="55"/>';
	    $html .= '     </form>';
	    $html .= '    </td>';
	    $html .= '   </tr>';
	    $html .= '   <tr>';
	    $html .= '    <td colspan=2>';
	    $html .= '     <!-- carregad imagem de processamento -->';
	    $html .= '     <div id="contentLoading" style="display:none">';
	    $html .= '      <div id="loading" style="display:none"></div>';
	    $html .= '     </div>';	
	    $html .= '    </td>';
	    $html .= '   </tr>';
	    $html .= '   <tr>';
	    $html .= '    <td colspan=2>';
	    $html .= '     <!-- mostra resultado da pesquisa -->';
	    $html .= '     <div id="MostraPesq">';
	    $html .= '     </div>';
	    $html .= '    </td>';
	    $html .= '   </tr>';
	    $html .= '  </table>';
	    $html .= '  <div id="barra_status">';
	    $html .= '   <div id="titulo">';
	    $html .= '    <center><font FACE="Verdana" size="1" color="black"><b>'.$this->getStatus().'</b></font></center>';
	    $html .= '   </div>';
	    $html .= '  </div>';
	    $html .= ' </div>';
	    
	    echo $html;
    }
}

?>