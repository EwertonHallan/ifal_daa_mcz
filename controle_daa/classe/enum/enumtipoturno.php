<?php
class EnumTipoTurno {
    // Texto, Numero, Data, Telefone, CPG, CPF, Select
    const __default = self::Matutino;
    
    const Matutino = 1;
    const Vespertino = 2;
    const Noturno = 3;
    const Todos = 9;
    
    public function __construct() {
        
    }
    
    public static function getDescricao ($tipo_campo) {
        switch ($tipo_campo) {
            case self::Matutino : return 'Matutino'; break;
            case self::Vespertino : return 'Vespertino'; break;
            case self::Noturno : return 'Noturno'; break;
            case self::Todos : return 'Todos'; break;
            default: return 'Matutino'; break;
        }
    }
    
}

?>