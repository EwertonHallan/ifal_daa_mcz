<?php
require_once("./upload.php");

if (isset($_POST)) {
   $dados = $_POST;
} else  {
    echo '<script type="text/javascript">'.
        'alert(Escolha o arquivo para enviar !)'.
        'history.go(-1);'.
        '</script>';    
}

$parte = explode('.', $dados["nomeArquivoFoto"]);
$dados['extensao'] = strtolower($parte[1]);

//parametro da pagina
$nome_file = $dados["nomeArquivoFoto"];
$extensao = $dados['extensao'];
$coordenadaX = $dados["coord_x"];
$coordenadaY = $dados["coord_y"];
$largura = $dados["largura"];
$altura = $dados["altura"];
$dados["size"] = filesize( './downloads/'.$nome_file );

var_dump($dados);
echo "<br>";

//inicializacao das variaveis
$nome='';
$tipo='';
$tamanho=0;

//define os tipos permitidos
$tipos[0]=".gif";
$tipos[1]=".jpg";
$tipos[2]=".jpeg";
$tipos[3]=".png";

$nome = $_FILES['files']['name'];
$tipo = $_FILES['files']['type'];
$tamanho = $_FILES['files']['size'];
$dir_tmp = $_FILES['files']['tmp_name'];

var_dump($_FILES);

//if (isset($HTTP_POST_FILES["userfile"])) {
if (isset($_FILES["files"])) {
    $upArquivo = new Upload();
    //$upArquivo->resizeArquivo($coordenadaX, $coordenadaY, $largura, $altura);
    if ($upArquivo->UploadArquivo($_FILES["files"], 
         "./downloads/", $tipos, 2048)) {
        $nome = $upArquivo->nome;
        $tipo = $upArquivo->tipo;
        $tamanho = $upArquivo->tamanho;            
        
        $girou = FALSE;
        if ($upArquivo->getWidth() > $upArquivo->getHeight()) {
            echo "<br><b>GIRANDO FILE:</b>".$upArquivo->nome_dest;
            $upArquivo->giraImage(90);
            $girou = TRUE;
        }
        
        if ($upArquivo->getWidth() > 300 || $upArquivo->getHeight() > 400) {
            echo "<br><b>Nome Arquivo:</b>".$upArquivo->nome_dest;
            $upArquivo->redimenssionaImage();
            
            if ($girou) {
                $upArquivo->giraImage(270);
            }
        }
        
        if ($coordenadaX > 0) {
            $upArquivo->resizeArquivo($coordenadaX, $coordenadaY, $largura, $altura);
        }
        
        echo '<br>Dimensao:'.$upArquivo->getWidth().'x'.$upArquivo->getHeight();
        echo "<h3>Visualizando o Arquivo de Envio</h3><br>";
        //echo '<img src="'.$upArquivo->dir_dest.$upArquivo->nome_dest.'" width="15%" heigth="15%" />';
        echo '<br><br><br>';
        echo '<button class="btn" name="rel_usuario" id="rel_usuario" onclick="history.go(-1); ">Novo Upload</button>';
    } else {
        echo "Falha no envio<br />";
    }
}

header('Location: http://localhost/controle_daa/upload/?fileName='.$upArquivo->nome_dest.'');
/*
echo '<script type="text/javascript">'.
    'history.go(-1);'.
    '</script>';
*/
?>
<br>
<strong>Coordenada:</strong> <?php echo $coordenadaX .','. $coordenadaY; ?><br />
<strong>Dimensao:</strong> <?php echo $largura .'x'. $altura; ?><br />
<strong>Diretorio:</strong> <?php echo $upArquivo->dir_dest; ?><br />
<strong>File:</strong> <?php echo $upArquivo->nome_dest; ?><br />
<!-- 
<strong>Nome do Arquivo Enviado:</strong> <?php echo $nome ?><br />
<strong>Tipo do Arquivo Enviado:</strong> <?php echo $tipo ?><br />
<strong>Tamanho do Arquivo Enviado:</strong> <?php echo $tamanho ?><br />
<strong>Diretorio Temporario:</strong> <?php echo $dir_tmp ?><br />
 -->