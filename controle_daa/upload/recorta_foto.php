<?php
require_once("./upload.php");

if (isset($_GET)) {
    $dados = $_GET;
} else  {
    echo '<script type="text/javascript">'.
        'alert(Escolha o arquivo para enviar !)'.
        'history.go(-1);'.
        '</script>';
}

$parte = explode('.', $dados["fileName"]);
$dados['extensao'] = strtolower($parte[1]);

$parte = $dados["dim"];
$parte = str_replace('[','',$parte);
$parte = str_replace(']','',$parte);

$parte = explode(',', $parte);
$dados['coord_x'] = $parte[0];
$dados['coord_y'] = $parte[1];
$dados['largura'] = $parte[2];
$dados['altura']  = $parte[3];

//parametro da pagina
$nome_file = $dados["fileName"];
$extensao = $dados['extensao'];
$coordenadaX = $dados["coord_x"];
$coordenadaY = $dados["coord_y"];
$largura = $dados["largura"];
$altura = $dados["altura"];

if (file_exists('./downloads/'.$nome_file)) {
    $dados["size"] = intdiv(filesize( './downloads/'.$nome_file ), 1024);  // KB
    
    var_dump($dados);
    echo "<br>";
    
    
    $upArquivo = new Upload();
    $upArquivo->dir_dest = './downloads/';
    $upArquivo->nome_dest = $nome_file;
    $upArquivo->nome = $nome_file;
    $upArquivo->tipo = '.'.$extensao;
    
    $upArquivo->resizeArquivo($coordenadaX, $coordenadaY, $largura, $altura);
    
    header('Location: http://localhost/controle_daa/upload/?fileName='.$upArquivo->nome_dest.'');
} else {
    echo "Arquivo nao encontrado !";
}
?>