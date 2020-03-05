<?php
class EnumTipoCurso {
    // Texto, Numero, Data, Telefone, CPG, CPF, Select
    const __default = self::Integrado;
    
    const Integrado = 1;
    const Subsequente = 2;
    const Graduacao = 3;
    const Pos_Graduacao = 4;
    
    public function __construct() {
        
    }
    
    public static function getDescricao ($tipo_campo) {
        switch ($tipo_campo) {
            case self::Integrado : return 'Integrado'; break;
            case self::Subsequente : return 'Subsequente'; break;
            case self::Graduacao : return 'Graduacao'; break;
            case self::Pos_Graduacao : return 'Pos_Graduacao'; break;
            default: return 'Integrado'; break;
        }
    }
    
}

?>