<?php

class Campo {
    private $titulo;
    private $nome;
    private $hint;
    private $tipo;          // Texto, Numero, Data, Telefone, CPG, CPF, Select, Pesquisa, Foto
    private $valor_lista;   // se tipo=Select tera lista de valores
    private $obj_lookup;    // objeto (classe) campo descricao do Tipo Pesquisa
    private $campo_lookup;  // nome do campo descricao do Tipo Pesquisa
    private $file_image;    // link do arquivo de imagem
    private $visivel;
    private $requerido;
    private $chave;        // chave primaria da tabela

    public function __construct() {
    }

    public function __set ($atributo, $valor) {
        $this->$atributo = $valor;
    }
    
    public function __get ($atributo) {
        return $this->$atributo;
    }
    
    public function __toString() {
        return ('Titulo:'.$this->titulo.' '.
                'Nome:'.$this->nome.' '.
                'Tipo:'.$this->tipo.' '.
                'Valor da Lista:'.$this->valor_lista.' '.
                'Visivel:'.$this->visivel.' '.
                'Requerido:'.$this->requerido
               );
        
    }
    
    public function setTitulo (String $titulo) {
        $this->titulo = $titulo;
    }
    
    public function setNome (String $nome) {
        $this->nome = $nome;
    }
    
    public function setHint (String $hint) {
        $this->hint = $hint;
    }
    
    public function setTipo (int $tipo_campo) {
        $this->tipo = $tipo_campo;
    }
    
    public function setValorLista ($array_valores) {
        $this->valor_lista = $array_valores;
    }
    
    public function setFileImage (String $file) {
        $this->file_image = $file;
    }
    
    public function setVisivel (bool $visivel) {
        $this->visivel = $visivel;
    }
    
    public function setRequerido (bool $requerido) {
        $this->requerido = $requerido;
    }
    
    public function setChave (bool $chave) {
        $this->chave = $chave;
    }
    
    public function setObj_Lookup (object $obj_lookup) {
        $this->obj_lookup = $obj_lookup;
    }
    
    public function setCampo_Lookup (String $campo_lookup) {
        $this->campo_lookup = $campo_lookup;
    }
    
    public function getTitulo () {
        return $this->titulo;
    }
    
    public function getNome () {
        return $this->nome;
    }
    
    public function getHint () {
        return $this->hint;
    }
    
    public function getTipo () {
        return $this->tipo;
    }
    
    public function getValorLista () {
        return $this->valor_lista;
    }
    
    public function getFileImage () {
        return $this->file_image;
    }
    
    public function getVisivel () {
        return $this->visivel;
    }
    
    public function getRequerido () {
        return $this->requerido;
    }
    
    public function getChave () {
        return $this->chave;
    }
    
    public function getObj_Lookup () {
        return $this->obj_lookup;
    }
    
    public function getCampo_Lookup () {
        return $this->campo_lookup;
    }
    
    
}

?>