<?php
class FuncaoData {
/*    
    public static function dataAtual () {
        return (new DateTime())->format("d/m/Y");
    }
    
    public static function horaAtual () {
        return (new DateTime())->format("H:i:s");
    }
    
    public static function data_horaAtual () {
        return (new DateTime())->format("d/m/Y H:i:s");
    }
*/
    
    /*
     * parametro data tipo string no formato yyyy-mm-dd
     */
    public static function diaSemana ($data) {
        if (!empty($data) || (isset($data))) {
            if (FuncaoData::validaData(FuncaoData::formatoData($data))) {
                return (date('w', strtotime($data)));
            } else {
                return NULL;
            }
        } else {
            return NULL;
        }
        
    }
    
    /*
     * parametro data tipo string no formato yyyy-mm-dd
     */
    public static function formatoData ($data) {
        try {            
            if (!empty($data) || (isset($data))) {
               $dt = date_create($data);
               $dt = (date_format($dt, 'd/m/Y'));
                     
               if ($dt == '31/12/2999') {
                   $dt = null;
               }
               
               return $dt;
            } else {
               return NULL; 
            }
        } catch (Exception $e) {
            return NULL;
        }
        
        
    }
    
    /*
     * parametro data tipo string no formato yyyy-mm-dd
     */
    public static function formatoDataHora ($data) {
        if (!empty($data) || (isset($data))) {
           $dt = date_create($data);
           return (date_format($dt, 'd/m/Y H:i:s'));
        } else {
           return NULL; 
        }
    }
    
    /*
     * parametro formato da data dd/mm/yyyy
     */
    public static function validaData ($data) {
        if (!empty($data) || (isset($data))) {
            $parte = explode('/',$data);
            
            if (!count($parte) == 3) {
                return FALSE;
                if (!checkdate($parte[1], $parte[0], $parte[2])) {
                   return FALSE; 
                }            
            }
        }
        return TRUE;
    }
    
    /*
     * parametro formato da data dd/mm/yyyy
     */
    public static function mesExtenso ($data) {
        $txt = '';
        if (!empty($data) || (isset($data))) {
            $parte = explode('/',$data);
            
            switch ($parte[1]) {
                case '01': $txt = 'JANEIRO / '.$parte[2]; break;
                case '02': $txt = 'FEVEREIRO / '.$parte[2]; break;
                case '03': $txt = 'MARÇO / '.$parte[2]; break;
                case '04': $txt = 'ABRIL / '.$parte[2]; break;
                case '05': $txt = 'MAIO / '.$parte[2]; break;
                case '06': $txt = 'JUNHO / '.$parte[2]; break;
                case '07': $txt = 'JULHO / '.$parte[2]; break;
                case '08': $txt = 'AGOSTO / '.$parte[2]; break;
                case '09': $txt = 'SETEMBRO / '.$parte[2]; break;
                case '10': $txt = 'OUTUBRO / '.$parte[2]; break;
                case '11': $txt = 'NOVEMBRO / '.$parte[2]; break;
                case '12': $txt = 'DEZEMBRO / '.$parte[2]; break;
            }
        }
        return $txt;
    }
    
/*
  $date = date_create('2000-01-01');
  echo date_format($date, 'Y-m-d H:i:s');
 * 
 */    
}
?>
