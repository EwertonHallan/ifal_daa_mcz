<?php
class EnumTipoRelatorio {
    // Texto, Numero, Data, Telefone, CPG, CPF, Select
    const __default = self::Simples;
    
    const Simples = 1;
    const Agrupado = 3;
    const MestreDetalhe = 7;
    
    public function __construct() {
        
    }
    
    public static function getDescricao ($tipo_campo) {
        switch ($tipo_campo) {
            case self::Simples : return 'Simples'; break;
            case self::Agrupado : return 'Agrupado'; break;
            case self::MestreDetalhe : return 'MestreDetalhe'; break;
            default: return 'Simples'; break;
        }
    }
    
}

?>