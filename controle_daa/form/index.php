<?php
   require_once '../banco/conexao.php';
   require_once '../banco/funcaobanco.php';
   require_once '../util/funcaodata.php';
   require_once("../util/funcaocaracter.php");
   
   require_once("../classe/calculo_faltas.php");
   require_once("./classe/formulario.php");
   require_once("./classe/campo.php");
   require_once("./classe/enumtipocampo.php");
   require_once ('./classe/form_pesquisa.php');
   
      
   echo '<html lang="pt-BR"><head>';
   echo '<!-- <meta charset="ISO-8859-1">  -->';
   echo '<meta charset="UTF-8"/>';
   echo '<title>Frequencia de Docentes</title>';
   echo '<link rel="stylesheet" type="text/css" href="./formulario.css" />';
   echo '<script type="text/javascript" src="./formulario.js"></script>';
   echo '<link type="text/css" rel="stylesheet" href="./calendario/calendar-green.css" />';
   echo '<script type="text/javascript" src="./calendario/calendar.js"></script>';
   echo '<script type="text/javascript" src="./calendario/calendar-pt.js"></script>';
   echo '<script type="text/javascript" src="./calendario/calendar-setup.js"></script>';

   echo ' <script type="text/javascript" src="./pesquisa/js/jquery-2.1.0.js"></script>';
   echo ' <script type="text/javascript" src="./pesquisa/js/pesquisa.js"></script>';
   echo ' <script type="text/javascript" src="./pesquisa/js/janela.js"></script>';
   echo ' <link rel="stylesheet" type="text/css" href="./pesquisa/css/janela.css" />';
   
   echo '</head>';
   echo '<body>';
   echo '<h4>TESTE DO PROCESSO DE CALCULO DAS FALTAS</h4>';
   
   echo '</body></html>';
?>