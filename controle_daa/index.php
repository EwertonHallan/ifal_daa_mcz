<?php
require_once ('./session/valida.php');

require_once('./banco/conexao.php');
require_once('./banco/funcaobanco.php');

require_once('./util/funcaodata.php');
require_once('./util/funcaocaracter.php');

require_once('./classe/log.php');
require_once('./classe/enum/enumtipoturno.php');
require_once('./classe/enum/enumativo.php');

require_once('./form/classe/formulario.php');
require_once('./form/classe/campo.php');
require_once('./form/classe/enumtipocampo.php');
require_once('./form/classe/form_pesquisa.php');

require_once ('./relatorio/tela_parametro/tela.php');
require_once ('./relatorio/tela_parametro/tela_pesquisa.php');

require_once ('./menu/classe/menu_permissao.php');
require_once ('./menu/classe/menu.php');
require_once ('./menu/classe/sub_menu.php');
require_once ('./menu/classe/item_menu.php');
require_once ('./menu/classe/enumtipomenu.php');
require_once ('./menu/classe/enumtargetpage.php');
//require_once ('./menu/conf_menu.php');

require_once('./geral/classe/usuario.php');
require_once('./geral/classe/senha.php');
require_once('./geral/classe/enum/enumtipousuario.php');

require_once('./freq_docentes/classe/sala.php');
require_once('./freq_docentes/classe/coordenacao.php');
require_once('./freq_docentes/classe/professor.php');
require_once('./freq_docentes/classe/faltas.php');
require_once('./freq_docentes/classe/justificativa.php');
require_once('./freq_docentes/classe/fechamento.php');
require_once('./freq_docentes/classe/enum/enumtipofechamento.php');

require_once('./monitor/classe/banco.php');
require_once('./monitor/classe/conta_bancaria.php');
require_once('./monitor/classe/curso.php');
require_once('./monitor/classe/monitor.php');
require_once('./monitor/classe/atendimento.php');
require_once('./monitor/classe/folha.php');
require_once('./monitor/classe/folha_monitor.php');
require_once('./monitor/classe/folha_fechamento.php');
require_once('./monitor/classe/enum/enumturnoatendimento.php');
require_once('./monitor/classe/enum/enumtipocurso.php');
require_once('./monitor/classe/enum/enumtipoconta_bancaria.php');


//verificando o modo de edicao ou exclusao
$id_editar = NULL;
$id_excluir = NULL;
$path_tela = NULL;
$path_rel = NULL;

if (isset($_GET['editar_id']) || !empty($_GET['editar_id'])) {
    $id_editar = $_GET['editar_id'];
}

if (isset($_GET['excluir_id']) || !empty($_GET['excluir_id'])) {
    $id_excluir = $_GET['excluir_id'];
}

if (!isset($_GET['pagina']) || !is_numeric($_GET['pagina'])) {
    $pagina = 0;
} else {
    $pagina = $_GET['pagina'];
}

if (isset($_GET['modulo'])) {
    if ($_GET['modulo'][strlen($_GET['modulo'])-1] <> '/') {
       $_SESSION["dir_modulo"] = $_GET['modulo'].'/';
    }
} else {
    $_SESSION["dir_modulo"] = 'geral/';
}

if (isset($_GET['form'])) {
    $path_tela = './'.$_SESSION["dir_modulo"].'form/'.$_GET['form'];
    $class_name = $_GET['form'];
}

if (isset($_GET['rel'])) {
    //?rel=professor/index_professor
    //pegar o diretorio base do relatorio
    $parte = explode('/',$_GET['rel']);
    
    $path_tela = './'.$_SESSION["dir_modulo"].'relatorio/'.$parte[0];
    $path_rel = './'.$_SESSION["dir_modulo"].'relatorio/'.$_GET['rel'].'.php';    
    $class_name = $_GET['rel'];
}

if (isset($_GET['session'])) {
    if ($_GET['session'] == 'logoff') {
        header("Location: ".$_SESSION["dir_base_html"]."session/logoff.php");
    }
}

echo '<html><head>';
//   echo '<!-- <meta charset="UTF-8">  -->';
   echo '<meta charset="ISO-8859-1">';
   echo '<link rel="shortcut icon" href="favicon.ico">';
   echo '<meta name="author" content="Ewerton Hallan" />';
   echo '<title>Controle D.A.A.</title>';

   echo '<link rel="stylesheet" type="text/css" href="./form/formulario.css" />';
   echo '<script type="text/javascript" src="./form/formulario.js"></script>';
   
   echo '<link type="text/css" rel="stylesheet" href="./form/calendario/calendar-green.css" />';
   echo '<script type="text/javascript" src="./form/calendario/calendar.js"></script>';
   echo '<script type="text/javascript" src="./form/calendario/calendar-pt.js"></script>';
   echo '<script type="text/javascript" src="./form/calendario/calendar-setup.js"></script>';
   
   echo ' <script type="text/javascript" src="./form/pesquisa/js/jquery-2.1.0.js"></script>';

   //echo ' <script type="text/javascript" src="./form/pesquisa/js/pesquisa.js"></script>';
   //usa aqui a variavel  $path_tela para identificar o arquivo pesquisa   
   //require_once('./form/pesquisa/js/pesquisa.js');
   
   echo ' <script type="text/javascript" src="./form/pesquisa/js/janela.js"></script>';
   echo ' <link rel="stylesheet" type="text/css" href="./form/pesquisa/css/janela.css" />';

   echo ' <LINK href="./menu/CSS/example1.css" type=text/css rel=stylesheet>';
   echo ' <LINK href="./menu/CSS/tree.css" type=text/css rel=stylesheet>';   
   echo ' <SCRIPT src="./menu/JavaScript/ie5.js" type=text/javascript></SCRIPT>';
   echo ' <SCRIPT src="./menu/JavaScript/XulMenu.js" type=text/javascript></SCRIPT>';   
   echo ' <SCRIPT type=text/javscript>';
   echo ' /* preload images */';
   echo ' var arrow1 = new Image(4, 7);';
   echo ' arrow1.src = "menu/icons/seta.gif";';
   echo ' var arrow2 = new Image(4, 7);';
   echo ' arrow2.src = "menu/icons/seta.gif";';
   echo ' </SCRIPT>';
   
   echo '</head>';
   echo '<body>';

   echo '<table width="100%" border=0 cellspacing="0" cellpadding="0">';
   echo '<tr><td width="100%">';
       require_once('./cabecalho.php');
   echo ' </td></tr>';
   echo '<tr><td width="100%" bgcolor=#AAAABB>';
       require_once('./menu/menu.php');
   echo ' </td></tr>';
   echo '<tr><td width="100%">';  
   
   //echo 'path_form='.$path_tela.'<br>';
   //echo 'path_rel='.$path_rel.'<br>';
    if (empty($path_rel) && !empty($path_tela)) {
       require_once($path_tela."/conf_form.php");
       require_once($path_tela."/index.php");
     }
        
     if (!empty($path_rel)) {
         require_once($path_rel);
     }
     
   echo ' </td></tr>';
   echo '</table>';

   echo '<SCRIPT type=text/javascript>';
   echo '  var menu1 = new XulMenu("menu1");';
   echo '  menu1.arrow1 = "icons/seta.gif";';
   echo '  menu1.arrow2 = "icons/seta.gif";';
   echo '  menu1.init();';
   echo '</SCRIPT>';
   
   
   //phpinfo();
   echo '</body></html>';
?>