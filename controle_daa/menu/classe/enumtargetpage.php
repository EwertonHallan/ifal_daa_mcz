<?php
class EnumTargetPage {
    // Texto, Numero, Data, Telefone, CPG, CPF, Select
    const __default = self::Self_Page;
    
    const New_Page = 1;
    const Self_Page = 2;
    
    public function __construct() {
        
    }
    
    public static function getDescricao ($tipo_campo) {
        switch ($tipo_campo) {
            case self::New_Page : return 'New_Page'; break;
            case self::Self_Page : return 'Self_Page'; break;
            default: return 'Self_Page'; break;
        }
    }
    
}

?>