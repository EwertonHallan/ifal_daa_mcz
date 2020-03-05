<?php
class EnumTipoMenu {
    // Texto, Numero, Data, Telefone, CPG, CPF, Select
    const __default = self::Item_Menu;
    
    const Item_Menu = 1;
    const Sub_Menu = 2;
    
    public function __construct() {
        
    }
    
    public static function getDescricao ($tipo_campo) {
        switch ($tipo_campo) {
            case self::Item_Menu : return 'Item_Menu'; break;
            case self::Sub_Menu : return 'Sub_Menu'; break;
            default: return 'Item_Menu'; break;
        }
    }
    
}

?>