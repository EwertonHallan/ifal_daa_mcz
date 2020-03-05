<?php

class ColunaRel {
    public $titulo;
    public $nome;
    public $largura;
    public $alinhamento;       // EnumTipoAlinhamento
    public $tipo;              // enumtipocampo /form/classe
    public $objeto;            // enumtipocampo /form/classe
    
    public function __construct() {

    }
    
    public function __set ($atributo, $valor) {
        $this->$atributo = $valor;
    }
    
    public function __get ($atributo) {
        return $this->$atributo;
    }
    
    public function __toString() {
        return ('Titulo:'.$this->titulo.
            ' Nome:'.$this->nome.
            ' Largura:'.$this->largura.
            ' Alinhamento:'.EnumTipoAlinhamento::getDescricao($this->alinhamento).
            ' Tipo:'.EnumTipoCampo::getDescricao($this->tipo)
            );
    }
    
    /**
     * @return mixed
     */
    public function getTitulo()
    {
        return $this->titulo;
    }
    
    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }
    
    /**
     * @return mixed
     */
    public function getLargura()
    {
        return $this->largura;
    }
    
    /**
     * @return mixed
     */
    public function getAlinhamento()
    {
        return $this->alinhamento;
    }
    
    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }
    
    /**
     * @return mixed
     */
    public function getObjeto()
    {
        return $this->objeto;
    }
    
/**
     * @param mixed $titulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }
    
    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    
    /**
     * @param mixed $largura
     */
    public function setLargura($largura)
    {
        $this->largura = $largura;
    }
    
    public function setAlinhamento(EnumTipoAlinhamento $alinhamento)
    {
        $this->alinhamento = $alinhamento;
    }
    
    public function setTipo(EnumTipoCampo $tipo)
    {
        $this->tipo = $tipo;
    }
    
    public function setObjeto($objeto)
    {
        $this->objeto = $objeto;
    }
    
}

?>