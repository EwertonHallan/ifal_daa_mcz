<?php 

if (isset($_SESSION['dir_base_html'])){    
    $image_logo = $_SESSION["dir_base_html"].'relatorio/image/logo.jpg';
} else {
    $image_logo = '../relatorio/image/logo.jpg';
}

      echo '<table noborder width="800px">';
      echo ' <tr> <td width=15% align=left>';
      echo '   <img src="'.$image_logo.'" align="left" width="100" height="80" alt="icone" border="0">';
      echo ' </td>';
      echo ' <td width=75% align=center><font size=6 color=#00AACC face=arial><b>Sistema de Controle <br> D.A.A.</b></font>';
      echo ' </td> <td width=20% align=right> ';
      echo '<font face="arial,verdana" size="1" color="black">';
      echo ' <b>'. $_SESSION["login"].'</b> <br>';
      echo ' <b>'.FuncaoData::formatoDataHora($_SESSION["user_acess"]).'</b><br>';
      echo ' <b>'.$_SESSION['versao'].'</b>';
      echo '</font>';
      echo ' </td>  </tr>  </table>';

?>
