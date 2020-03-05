<?php
class EnumTipoConta_Bancaria {
    // Texto, Numero, Data, Telefone, CPG, CPF, Select
    const __default = self::Corrente;
    
    const Corrente = 1;
    const Poupanca = 2;
    
    public function __construct() {
        
    }
    
    public static function getDescricao ($tipo_campo) {
        switch ($tipo_campo) {
            case self::Corrente : return 'Corrente'; break;
            case self::Poupanca : return 'Poupanca'; break;
            default: return 'Corrente'; break;
        }
    }
    
}

?>