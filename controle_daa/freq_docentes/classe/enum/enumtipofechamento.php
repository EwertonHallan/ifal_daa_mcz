<?php
class EnumTipoFechamento {
    // Texto, Numero, Data, Telefone, CPG, CPF, Select
    const __default = self::Faltas;
    
    const Faltas = 1;
    const Justificativa = 2;
    const Todos = 9;
    
    public function __construct() {
        
    }
    
    public static function getDescricao ($tipo_campo) {
        switch ($tipo_campo) {
            case self::Faltas : return 'Faltas'; break;
            case self::Justificativa : return 'Justificativa'; break;
            case self::Todos : return 'Todos'; break;
            default: return 'Faltas'; break;
        }
    }
    
}

?>