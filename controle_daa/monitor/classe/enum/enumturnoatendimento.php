<?php
class EnumTurnoAtendimento {
    // Texto, Numero, Data, Telefone, CPG, CPF, Select
    const __default = self::Matutino;
    
    const Matutino = 1;
    const Vespertino = 2;
    const Noturno = 3;
    const Matutino_Vespertino = 4;
    const Vespertino_Noturno = 5;
    const Matutino_Noturno = 6;
    const Todos = 9;
    
    public function __construct() {
        
    }
    
    public static function getDescricao ($tipo_campo) {
        switch ($tipo_campo) {
            case self::Matutino : return 'Matutino'; break;
            case self::Vespertino : return 'Vespertino'; break;
            case self::Noturno : return 'Noturno'; break;
            case self::Matutino_Vespertino : return 'Mat. / Vesp.'; break;
            case self::Vespertino_Noturno : return 'Vesp. / Not.'; break;
            case self::Matutino_Noturno : return 'Mat. / Not.'; break;
            case self::Todos : return 'Todos'; break;
            default: return 'Matutino'; break;
        }
    }
    
}

?>