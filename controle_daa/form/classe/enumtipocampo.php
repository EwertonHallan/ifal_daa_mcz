<?php
class EnumTipoCampo {
    // Texto, Numero, Data, Telefone, CPG, CPF, Select
    const __default = self::Texto;
    
    const Texto = 1;
    const Numero = 2;
    const Telefone = 3;
    const CPF = 4;
    const CGC = 5;
    const EMail = 6;
    const Data = 7;
    const DataHora = 12;
    const Select = 8;
    const Pesquisa = 9;
    const Senha = 10;
    const Foto = 11;
    
    public function __construct() {
        
    }
    
    public static function getDescricao ($tipo_campo) {
        switch ($tipo_campo) {
            case self::Texto : return 'Texto'; break;
            case self::Numero : return 'Numero'; break;
            case self::Telefone : return 'Telefone'; break;
            case self::CPF : return 'CPF'; break;
            case self::CGC : return 'CGC'; break;
            case self::EMail : return 'E-Mail'; break;
            case self::Data : return 'Data'; break;
            case self::DataHora : return 'DataHora'; break;
            case self::Select : return 'Select'; break;
            case self::Pesquisa : return 'Pesquisa'; break;
            case self::Senha : return 'Senha'; break;
            case self::Foto : return 'Foto'; break;
            default: return 'Texto'; break;
        }
    }
    
}

?>