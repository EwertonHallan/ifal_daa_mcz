<?php 

$arquivo = '';
$imgLarg = 300;
$imgAlt = 400;

if (isset($_GET) && !empty($_GET)) {
    $arquivo = $_GET['fileName']; 
    
    if (file_exists('./downloads/'.$arquivo)) {
        list($imgLarg, $imgAlt, $tipo) = getimagesize( './downloads/'.$arquivo );
        
        //if ($imgLarg < 300) {$imgLarg = 300;}
        //if ($imgAlt < 400) {$imgAlt = 400;}
    }
    //echo "file name:".$arquivo."<br> Dimensao:[".$imgLarg.",".$imgAlt."]";
}

echo '<!DOCTYPE html><html><head>';
echo '	<title>Upload de Arquivo</title>';
echo '  <link rel="stylesheet" type="text/css" href="./css/canvas.css" />';
echo '  <script type="text/javascript" src="./js/image.js"></script>';
echo '  <script type="text/javascript" src="./js/janela_upload.js"></script>';
echo '</head><body>';
echo '<form id="formFoto" action="envia_arquivos.php" method="post" enctype="multipart/form-data">';
//echo '<label for="nomeArquivoFoto">Arquivo:</label><input type="text" id="nomeArquivoFoto" value="'.$arquivo.'" size="10" />';
echo ' <input type="hidden" id="nomeArquivoFoto" name="nomeArquivoFoto" value="" size="39" />';
echo ' <table border=1 width="310px" height="410px">';
echo ' <tr><td align="left" colspan="2" height="20px"><font size="1" color="red">** Tamanho ideal da foto (120px x 160px) ou (150px x 200px). </font> </td></tr>';
echo ' <tr><td align="left" height="30px"><input type="file" id="files" name="files" onchange="desenhaImagem(this.value);" /> </td>';
echo '   <td><input type="submit" id="envia_file" name="envia_file" value="Enviar" /> </td></tr>';
echo '  <tr height="'.($imgAlt+50).'px">    <td colspan="2" align="left">';
echo '    <div style="position:relative;overflow:scroll;width:'.($imgLarg+50).'px;height:'.($imgAlt+50).'px;overflow:auto">';
echo '	  <canvas id="tela" name="tela" width="'.($imgLarg+20).'" height="'.($imgAlt+20).'" style="border:1px solid #000000;" onmousedown="mouseDown(this);" onmouseup="mouseUp(this);"></canvas>';
echo '    </div>   </td>  </tr>  <tr>    <td colspan="2" align="center">';
if (isset($arquivo)) {
echo ' <script>  desenhaImagem(\''.$arquivo.'\');  </script>';
}
echo '    </td>  </tr>  <tr>    <td colspan="2">  <table border="0" width="100%" align="left"> ';
echo '    <tr>  <td>   Coord. X:<input type="number" id="coord_x" name="coord_x" size="5" />   </td>';
echo '    <td>   Coord. Y:<input type="number" id="coord_y" name="coord_y" size="5" />  </td>  </tr>';
echo '    <tr>  <td>   Largura:<input type="number" id="largura" name="largura" size="5" /> </td>  ';
echo '    <td>   Altura:<input type="number" id="altura" name="altura" size="5" />   </td>   </tr>   </table>';
echo '    </td>  </tr>  <tr>    <td colspan="2" align="center"> <table border="0" width="100%"><tr align="center">';
echo '      <td> <input type="button" onclick="desenhaImagem(\''.$arquivo.'\');" value="Limpar"> </td>';
echo '      <td>  <input type="button" onclick="desenhaRetangulo(coord_x.value,coord_y.value,largura.value,altura.value);" value="Moldura"> </td>';
echo '      <td>  <input type="button" onclick="paginaGravacao();" value="Recorta"> </td>';
echo '      <td>  <input type="button" onclick="paginaGravacao();" value="Gravar"> </td>';
echo '    </td>  </tr> </table>';
echo '    </td>  </tr> </table>  </form>  </body>';
echo '<!--'; 
echo 'https://www.html5rocks.com/pt/tutorials/file/dndfiles/'; 
echo 'https://developer.mozilla.org/pt-BR/docs/Web/Guide/HTML/Canvas_tutorial/Drawing_shapes';
echo '-->';	
echo '</html>';

?>
