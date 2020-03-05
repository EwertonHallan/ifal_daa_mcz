<?php
require_once './wideimage/WideImage.php';
/*
$url = $_SERVER["PHP_SELF"];
if(preg_match("class.Upload.php", "$url")) {
    header("Location: ../index.php");
}
*/

class Upload {
    var $nome;
    var $nome_dest;
    var $dir_dest;
    var $nome_tmp;
    var $dir_tmp;
    var $tipo;
    var $tamanho;
    
    public function __construct() {
    }
    
    public function __set ($atributo, $valor) {
        $this->$atributo = $valor;
    }
    
    public function __get ($atributo) {
        return $this->$atributo;
    }
    
    public function getWidth () {
        $imagem = WideImage::load($this->dir_dest . $this->nome_dest);
        return $imagem->getWidth();
    }
    
    public function getHeight () {
        $imagem = WideImage::load($this->dir_dest . $this->nome_dest);
        return $imagem->getHeight();
    }

    public function proporcaoImage (array $dimensao) {
        $tamMax = array(300, 400);
        list( $imgLarg, $imgAlt, $imgTipo ) = $dimensao;
        $novaLargura = 300;
        $novaAltura  = 400;
        
        // verifica se a imagem é maior que o máximo permitido
        if ( $imgLarg > $tamMax[0] || $imgAlt > $tamMax[1] ) {
            // verifica se a largura é maior que a altura
            if ( $imgLarg > $imgAlt ) {
                $novaLargura = $tamMax[0];
                $novaAltura = round( ($novaLargura / $imgLarg) * $imgAlt );
            }
            // se a altura for maior que a largura
            elseif ( $imgAlt > $imgLarg )  {
                $novaAltura = $tamMax[1];
                $novaLargura = round( ($novaAltura / $imgAlt) * $imgLarg );
            }
            // altura == largura
            else {
                $novaAltura = $novaLargura = max( $tamMax );
            }
        }
        else {
            $novaLargura = $imgLarg;
            $novaAltura = $imgAlt;
        }
        
        return array($novaLargura, $novaAltura, $imgLarg, $imgAlt);
    }
    /*
    public function sizeFile (String $nameFile) {
        $img_r = imagecreatefromjpeg($nameFile);
        $tam = image
    }
    */
    public function redimenssionaImage () {
        //$src = './downloads/foto0047-copia.jpg';
        $src = $this->dir_dest . $this->nome_dest;
        //$destImage = './downloads/foto0047-redim.jpg';
        $destImage = $src;
        
        //qualidade da imagem
        $jpeg_quality = 96;
        
        //medidas da imagem
        list($novaLargura, $novaAltura, $imgLarg, $imgAlt) = $this->proporcaoImage(getimagesize( $src ));
        
        $img_r = imagecreatefromjpeg($src);
        $dst_r = ImageCreateTrueColor($novaLargura, $novaAltura);
        
        imagecopyresampled($dst_r,$img_r,0,0,0,0, $novaLargura,$novaAltura,$imgLarg,$imgAlt);
        
        //para mostrar a imagem no browser, sem gravar em disco
        //header('Content-type: image/jpeg');
        //imagejpeg($dst_r,null,$jpeg_quality);
        //gravando em disco
        imagejpeg($dst_r,$destImage,$jpeg_quality);     
    
        // destrói as imagens geradas
        imagedestroy( $img_r );
        imagedestroy( $dst_r );
    }
    
    public function codigoBarra () {
        $tamanhofonte = 100;
        // Fonte de código de barras que eu tenho em um sistema
        $fonte = 'c39hrp48dhtt.ttf';
        
        // Texto que será impresso na imagem
        // Para que funcione com leitores é necessário
        // que seja iniciado e finalizado a String com o caracter '*'
        $texto = "*" . $_GET['nome'] . "*";
        
        // Retorna o tamanho da imagem criada pela fonte acima carregada.
        $tamanho = imagettfbbox($tamanhofonte, 0, $fonte, $texto);
        $largura = $tamanho[2] + $tamanho[0] + 8;
        $altura = abs($tamanho[1]) + abs($tamanho[7]);
        
        // cria a imagem exatamente do tamanho informado pelo imagettfbbox
        $imagem = imagecreate($largura, $altura);
        /* @Parametros
         * $largura - Largura que deve ser criada a imagem
         * $altura - Altura que deve ser criada a imagem
         */
        
        // Primeira chamada do imagecolorallocate cria a cor de fundo da imagem
        imagecolorallocate($imagem, 255, 255, 255);
        
        // As demais chamadas criam cores para serem usadas na imagem
        $preto = imagecolorallocate($imagem, 0, 0, 0);
        
        // Adiciona o texto a imagem
        imagefttext($imagem, $tamanhofonte, 0, 0, abs($tamanho[5]), $preto, $fonte, $texto);
        /* @Parametros
         * $imagem - Imagem previamente criada Usei imagecreate.
         poderia ter usado o imagecreatefromjpeg
         * $tamanhofonte - Tamanho da fonte em pixel
         * 0 - Posição X do texto na imagem
         * 0 - Posição Y do texto na imagem
         * abs($tamanho[5]) - Corrige o Y
         * $preto - Cor do texto
         * $fonte - Caminho relativo ou absoluto da fonte a ser carregada.
         * $texto - Texto que deverá ser escrito
         */
        
        // Header informando que é uma imagem JPEG
        header( 'Content-type: image/jpeg' );
        
        // eEnvia a imagem para o borwser ou arquivo
        imagejpeg( $imagem, NULL, 80 );
        /* @Parametros
         * $imagem - Imagem previamente criada Usei imagecreatefromjpeg
         * NULL - O caminho para salvar o arquivo.
         Se não definido ou NULL, o stream da imagem será mostrado diretamente.
         * 80 - Qualidade da compresão da imagem.
         */
    }
    
    public function giraImage (int $angulo) {
/*
        $src = $this->dir_dest . $this->nome_dest;
        $new_file = strtolower(strstr($this->nome,'.',TRUE)).'-copia'.$this->tipo;
        
        echo "<br>Girando file:".$src."<br>";
        //qualidade da imagem
        $jpeg_quality = 96;
        
        $imagem = imagecreatefromjpeg($src);
        
        //imagerotate($imagem, $angulo, imageColorAllocateAlpha($imagem, 0, 0, 0, 127));
        imagerotate($imagem, $angulo, 0);
        echo "<br>Rotacionando:".$src."<br>";
        
        //gravando em disco
        imagejpeg($imagem, $this->dir_dest . $new_file, $jpeg_quality);
        
        echo "<br>Gravando:".$new_file."<br>";
        
        // destrói as imagens geradas
        imagedestroy( $imagem );
        
        $this->nome_dest = $new_file;
        echo "<br>Mudando o nome:".$new_file."<br>";
*/        
        
        $imagem = WideImage::load($this->dir_dest . $this->nome_dest);
        $imagem = $imagem->rotate($angulo, NULL, TRUE);
        
        //$new_file = strtolower(strstr($this->nome,'.',TRUE)).'-copia'.$this->tipo;
        $new_file = strtolower($this->dir_dest . $this->nome_dest);
        $imagem->saveToFile($new_file);
        //$this->nome_dest = $new_file;
        
    }
    
    public function saveImage (String $name) {
        $imagem = WideImage::load($this->dir_dest . $this->nome_dest);
        $imagem->saveToFile($this->dir_dest . $name);
    }
    
    public function resizeArquivo(int $coordenadaX, int $coordenadaY, int $largura, int $altura) {
        $imagem = WideImage::load($this->dir_dest . $this->nome_dest);
        $imagem = $imagem->crop($coordenadaX, $coordenadaY, $largura, $altura);
                
        $larg = $imagem->getWidth();
        $alt = $imagem->getHeight();
        
        $new_file = strtolower(strstr($this->nome,'.',TRUE)).'-'.$larg.'_'.$alt.$this->tipo;
        $imagem->saveToFile($this->dir_dest . $new_file);
        $this->nome_dest = $new_file;
    }
    
    public function moveAquivo (String $fileOrigem=NULL, String $fileDestino=NULL) {
        $arquivoPermitido = FALSE;
        
        if ($fileOrigem == NULL) {
            $fileOrigem = $this->dir_tmp . $this->nome_tmp;
        }
        
        if ($fileDestino == NULL) {
            $fileDestino = $this->dir_dest . $this->nome_dest;
        }
        
        if (move_uploaded_file($fileOrigem, $fileDestino)) {
            $arquivoPermitido = true;
        }
        
        return $arquivoPermitido;
    }

    public function UploadArquivo($arquivo, $pasta, $tipos, $tamMaximo = 2048) {
        $arquivoPermitido = false;
        
        if (isset($arquivo)) {
            $this->nome = $arquivo["name"];
            $this->nome_tmp = substr(strstr($arquivo["tmp_name"],'tmp'),4); //substr($texto, 0, 16)
            $this->dir_tmp = strstr($arquivo["tmp_name"],'tmp',TRUE).'tmp\\';
            $this->tipo = strrchr(strtolower($this->nome),".");
            $this->tamanho = ceil($arquivo["size"] / 1024);
            //$this->nome_dest = strtolower(strstr($this->nome,'.',TRUE)).'_'.md5($this->nome_tmp . date("dmYHis")).$this->tipo;
            $this->nome_dest = strtolower(strstr($this->nome,'.',TRUE)).$this->tipo;
            $this->dir_dest = $pasta;
            
            for ($i=0;$i<count($tipos);$i++) {
                if($tipos[$i] == $this->tipo) {
                    $arquivoPermitido=true;
                    //echo 'tipo='.$tipos[$i].'<br>';
                    break;
                }
            }
            
            if ($arquivoPermitido == false) {
                echo "Extensão de arquivo não permitido!!";
                return false;
                exit;
            }
            
            if ($this->tamanho > $tamMaximo) {
                echo "O tamanho do arquivo excede o limite ".$tamMaximo." KB <br>";
                return false;
                exit;
            }

            //echo '<br><br><br>';
            //echo 'Arquivo Sel.:<b>'.$this->nome.'</b><br>';
            //echo 'Diretorio Dest.:<b>'.$this->dir_dest.'</b><br>';
            //echo 'Nome Dest.:<b>'.$this->nome_dest.'</b><br>';
            //echo 'Diretorio Temp:<b>'.$this->dir_tmp.'</b><br>';
            //echo 'Nome Temp:<b>'.$this->nome_tmp.'</b><br>';
            //echo 'Tipo:<b>'.$this->tipo.'</b><br>';
            //echo 'Tamanho (KB):<b>'.$this->tamanho.'</b><br><br><br>';
            //echo 'aqui<br>';
            
            
            if (move_uploaded_file($this->dir_tmp . $this->nome_tmp, $this->dir_dest . $this->nome_dest)) {                
                $arquivoPermitido = true;
            }
            
            
        }
        
        return $arquivoPermitido;
    }
}
?>