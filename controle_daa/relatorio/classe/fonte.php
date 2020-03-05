<?php

class Fonte {
    private $nome;
    private $tamanho;
    private $estilo;    // string EnumTipoEstiloFonte
    
    public function __construct() {
        $this->nome = 'Times';
        $this->tamanho = 12;
        $this->estilo ='';
    }
    
    public function setFonte(String $nome, Int $tamanho, String $estilo) {
        $this->nome = $nome;
        $this->tamanho = $tamanho;
        $this->estilo = $estilo;
    }
    
    public function __set ($atributo, $valor) {
        $this->$atributo = $valor;
    }
    
    public function __get ($atributo) {
        return $this->$atributo;
    }
    
    public function __toString() {
        return ('Nome:'.$this->nome.
            ' Tamanho:'.$this->tamanho.
            ' Estilo:'.$this->estilo
            );
    }
        
    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }
    
    /**
     * @return number
     */
    public function getTamanho()
    {
        return $this->tamanho;
    }
    
    /**
     * @return string
     */
    public function getEstilo()
    {
        return $this->estilo;
    }
    
    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    
    /**
     * @param number $tamanho
     */
    public function setTamanho($tamanho)
    {
        $this->tamanho = $tamanho;
    }
    
    /**
     * @param EnumTipoEstiloFonte $estilo
     */
    public function setEstilo(EnumTipoEstiloFonte $estilo)
    {
        $this->estilo .= $estilo;
    }
    
    /**
     * @param EnumTipoEstiloFonte $estilo
     */
    public function delEstilo(EnumTipoEstiloFonte $estilo)
    {
        $this->estilo = str_replace($estilo, "", $this->estilo);
    }

    /**
     * @param EnumTipoEstiloFonte $estilo
     */
    public function addEstilo(EnumTipoEstiloFonte $estilo)
    {
        $this->estilo .= $estilo;
    }

}

?>