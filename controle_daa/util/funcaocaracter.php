<?php
class FuncaoCaracter {
    public static function acentoTexto ($texto) {
        $carEspecial = array('�', '�', '�', '�', '�', '�', '�', '�', '�', '�');
        $carHTML   = array('&aacute;','&eacute;','&iacute;','&oacute;','&uacute;','&ecirc;','&ocirc;','&atilde;','&otilde;','&ccedil;');
        $aux = str_replace($carEspecial, $carHTML, $texto);
        
        $carEspecial = array('�', '�', '�', '�', '�', '�', '�', '�', '�', '�');
        $carHTML   = array('&Aacute;','&Eacute;','&Iacute;','&Oacute;','&Uacute;','&Ecirc;','&Ocirc;','&Atilde;','&Otilde;','&Ccedil;');
        $aux = str_replace($carEspecial,$carHTML,$aux);
        
        return $aux;
    }
    
    public static function upperTexto ($texto) {
        return strtoupper($texto);
    }
    
    public static function lowerTexto ($texto) {
        return strtolower($texto);
    }
    
    public static function initUpperTexto ($texto) {
        return ucfirst($texto);
    }
    
    public static function firstUpperTexto ($texto) {
        return ucwords($texto);
    }
    
    public static function substr ($texto, $inicial, $final) {
        //"eu n�o sou besta pra tirar onda de her�i"
        //1234567890123456
        //substr($texto, 0, 16);  // eu n�o sou besta
        if (!is_null($inicial) || !empty($inicial)) {
            $posI = $inicial - 1;
        }

        if (!is_null($final) || !empty($final)) {
            $posF = $final - 1;
        } else {
            $posF = strlen($texto) - 1;
        }
        
        return substr($texto, $posI, $posF);
    }
    
    public static function substrFirstCaracter($texto, $caracter) {
        // 'name@example.com';
        // prints @example.com
        $aux = strstr($texto, $caracter);
        return substr($aux,1); 
    }

    public static function substrLastCaracter($texto, $caracter) {
        // 'name@example.com';
        // prints name
        $aux = strstr($texto, $caracter, TRUE);
        return $aux;
    }
    
    public static function posFirstCaracter ($texto, $caracter) {
        return strpos($texto, $caracter);
    }
}

?>