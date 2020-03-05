<?php
class EnumTipoUsuario {
    // Texto, Numero, Data, Telefone, CPG, CPF, Select
    const __default = self::Cadastramento;
    
    const Cadastramento = 1;
    const Apont_Faltas = 3;
    const Apont_Justificativa = 5;
    const Controle_Apont = 7;
    const Administrador = 9;
    
    public function __construct() {
        
    }
    
    public static function getDescricao ($tipo_campo) {
        switch ($tipo_campo) {
            case self::Cadastramento : return 'Cadastramento'; break;
            case self::Apont_Faltas : return 'Apont_Faltas'; break;
            case self::Apont_Justificativa : return 'Apont_Justificativa'; break;
            case self::Controle_Apont : return 'Controle_Apont'; break;
            case self::Administrador : return 'Administrador'; break;
            default: return 'Cadastramento'; break;
        }
    }
    
}

?>