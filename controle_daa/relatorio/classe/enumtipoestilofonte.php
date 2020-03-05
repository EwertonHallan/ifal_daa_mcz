<?php
class EnumTipoEstiloFonte {
    // Texto, Numero, Data, Telefone, CPG, CPF, Select
    const __default = self::Nenhum;
    
    const Nenhum = '';
    const Negrito = 'B';
    const Italico = 'I';
    
    public function __construct() {
        
    }
    
    public static function getDescricao ($tipo_campo) {
        switch ($tipo_campo) {
            case self::Nenhum : return 'Nenhum'; break;
            case self::Negrito : return 'Negrito'; break;
            case self::Italico : return 'Italico'; break;
            default: return 'Nenhum'; break;
        }
    }
    
}

?>