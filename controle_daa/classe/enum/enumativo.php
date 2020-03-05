<?php
class EnumAtivo {
    const __default = self::SIM;
    
    const SIM = 'S';
    const NAO = 'N';
    
    
    public function __construct() {
        
    }
    
    public static function getDescricao ($tipo_usuario) {
        switch ($tipo_usuario) {
            case self::SIM : return 'SIM'; break;
            case self::NAO : return 'NÃO'; break;
            default: return 'SIM'; break;
        }
    }
}

?>