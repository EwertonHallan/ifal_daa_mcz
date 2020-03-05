<?php
class EnumTipoAlinhamento {
    // Texto, Numero, Data, Telefone, CPG, CPF, Select
    const __default = self::Esquerda;
    
    const Esquerda = 'L';
    const Direita = 'R';
    const Centralizado = 'C';
    
    public function __construct() {
        
    }
    
    public static function getDescricao ($tipo_campo) {
        switch ($tipo_campo) {
            case self::Esquerda : return 'Esquerda'; break;
            case self::Direita : return 'Direita'; break;
            case self::Centralizado : return 'Centralizado'; break;
            default: return 'Esquerda'; break;
        }
    }
    
}

?>