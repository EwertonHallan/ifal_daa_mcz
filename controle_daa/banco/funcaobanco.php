<?php
class FuncaoBanco {
    public static function removeAcento ($texto) {
        $aux = '';
        $char_num = null;
        
        for ($i = 0; $i < strlen($texto); $i++) {
            $char_num = ord($texto[$i]);
            $new_char = $texto[$i];

            switch ($char_num) {
                case 129: // Á
                case 130: // Â
                case 131: // Ã
                    $new_char = chr(65);
                    break;
                case 161: // á
                case 162: // â
                case 163: // ã
                    $new_char = chr(97);
                    break;
                case 137: // É
                case 138: // Ê
                    $new_char = chr(69);
                    break;
                case 169: // é
                case 170: // ê
                    $new_char = chr(101);
                    break;
                case 141: // Í
                    $new_char = chr(73);
                    break;
                case 173: // í
                    $new_char = chr(105);
                    break;
                case 147: // Ó
                case 148: // Ô
                case 149: // Õ
                    $new_char = chr(79);
                    break;
                case 179: // ó
                case 180: // ô
                case 181: // õ
                    $new_char = chr(111);
                    break;
                case 154: // Ú
                    $new_char = chr(85);
                    break;
                case 135: // Ç
                    $new_char = chr(67);
                    break;
                case 167: // Ç
                    $new_char = chr(99);
                    break;
                case 195: //marcador
                    $new_char = '';
                    break;
            }
            
            if ($new_char != '') { $aux .= $new_char; }
        }

        return $aux;
    }       
    
    public static function caracter ($valor, $tipo) {
        
    }
    
    public static function dataAtual () {
        return (new DateTime())->format("Y-m-d");
    }
    
    public static function horaAtual () {
        return (new DateTime())->format("H:i:s");
    }
    
    public static function data_horaAtual () {
        return (new DateTime())->format("Y-m-d H:i:s");
    }
    
    /*
     * formato da data dd/mm/yyyy
     */
    public static function formataData ($data) {
        $parte = explode('/',$data);
        return $parte[2].'-'.$parte[1].'-'.$parte[0];
    }
    
    public function encripta($dado) {
        return base64_encode($dado);
    }
    
    public function decripta($dado) {
        return base64_decode($dado);
    }
    
    public static function encriptaMD5 ($texto) {
        return md5($texto);
    }
}
?>
