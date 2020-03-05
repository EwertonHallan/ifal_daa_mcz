<?php
class Form_Pesquisa {
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
        $this->classDados = $classPesq;
    }
    
    public function getClassPesq () {
        return $this->classDados;
    }
    
    public function getNameClasseDados () {
        return get_class($this->classDados);
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
        $html .= '       	<font FACE="Verdana" size=2 color="white"><b>TITULO DA JANELA</b></font>';
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
	    $html .= '      <input type="hidden" name="campoRetorno" id="campoRetorno" value="" size="10"/>';
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

    public function montaJSPesquisa (String $file_pesquisa) {
        $scriptJS  = "<script>\n function openTela_".$this->getNameClasseDados()." () {";
        $scriptJS .= "$(document).ready(function(){ \n";
        $scriptJS .= " \n ";
        $scriptJS .= "  //Aqui a ativa a imagem de load \n";
        $scriptJS .= "  function loading_show() { \n";
        $scriptJS .= "    $('#loading').html(\"<img src='".$_SESSION["dir_base_html"]."form/pesquisa/img/loading.gif' />\").fadeIn('fast'); \n";
        $scriptJS .= "  } \n";
        $scriptJS .= " \n ";    
        $scriptJS .= "  //Aqui desativa a imagem de loading \n";
        $scriptJS .= "  function loading_hide(){ \n";
        $scriptJS .= "    $('#loading').fadeOut('fast'); \n";
        $scriptJS .= "  } \n";
        $scriptJS .= " \n ";
        $scriptJS .= "  //aqui a função ajax que busca os dados em outra pagina do tipo html, não é json\n";
        $scriptJS .= "  function load_dados(valores, page, div) { \n";
        $scriptJS .= "        $.ajax \n";
        $scriptJS .= "         ({ \n";
        $scriptJS .= "            type: 'POST', \n";
        $scriptJS .= "            dataType: 'html', \n";
        $scriptJS .= "            url: page, \n";
        $scriptJS .= "            beforeSend: function() { \n";
        $scriptJS .= "                           //Chama o loading antes do carregamento \n";
        $scriptJS .= "                           loading_show();  \n";
        $scriptJS .= "                        },\n";
        $scriptJS .= "            data: valores, \n";
        $scriptJS .= "            success: function(msg) {  \n";
        $scriptJS .= "                       loading_hide(); \n";
        $scriptJS .= "                       var data = msg; \n";
        $scriptJS .= "                       $(div).html(data).fadeIn(); \n";
        $scriptJS .= "                     } \n";
        $scriptJS .= "        }); \n";
        $scriptJS .= "    } \n";
        $scriptJS .= " \n ";
        $scriptJS .= "    //Aqui eu chamo o metodo de load pela primeira vez sem parametros para pode exibir todos \n";
        $scriptJS .= "    load_dados(null, '$file_pesquisa', '#MostraPesq'); \n";
        $scriptJS .= " \n ";
        $scriptJS .= "    //Aqui uso o evento key up para começar a pesquisar, se valor for maior q 0 ele faz a pesquisa \n";
        $scriptJS .= '    $(\'#pesquisaDados\').keyup(function(){'." \n";
        $scriptJS .= " \n ";
        $scriptJS .= '        var valores = $(\'#form_pesquisa\').serialize();'." \n";
        $scriptJS .= "        //o serialize retorna uma string pronta para ser enviada \n";
        $scriptJS .= "        //pegando o valor do campo #pesquisaCliente \n";
        $scriptJS .= '        var $parametro = $(this).val();'." \n";
        $scriptJS .= " \n ";
        $scriptJS .= '        if($parametro.length >= 1)  {'." \n";
        $scriptJS .= "            load_dados(valores, '$file_pesquisa', '#MostraPesq'); \n";
        $scriptJS .= "        } else { \n";
        $scriptJS .= "            load_dados(null, '$file_pesquisa', '#MostraPesq'); \n";
        $scriptJS .= "        } \n";
        $scriptJS .= "    }); \n";
        $scriptJS .= " \n ";
        $scriptJS .= "}); \n";
        $scriptJS .= "} </script> \n";
        
        echo $scriptJS;
        
        //onclick="enviarMetodo($(this).attr('data-id'));"
        //https://forum.imasters.com.br/topic/579843-pegar-evento-button/
    }
}

?>