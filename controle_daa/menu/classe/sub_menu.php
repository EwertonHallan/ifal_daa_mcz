<?php

class Sub_Menu {
    private $nome;
    private $array_itens;
    private $tipo_item_menu;
    
    public function __construct() {
        $this->tipo_item_menu = EnumTipoMenu::Sub_Menu;
    }
/*    
    public function __set ($atributo, $valor) {
        $this->$atributo = $valor;
    }
    
    public function __get ($atributo) {
        return $this->$atributo;
    }
*/    
    public function __toString() {
        return (
            'Nome:'.$this->nome.''.
            'Itens:'.var_dump($this->array_itens)
            );
    }

    public function setNome (String $nome) {
        $this->nome = $nome;
    }
    
    public function getNome () {
        return $this->nome;
    }
    
    public function addItemMenu (Item_Menu $obj_item) {
        $this->array_itens[] = $obj_item;
    }
    
    public function getItemMenu (int $id) {
        return $this->array_itens[$id];
    }
    
    public function getItens () {
        return $this->array_itens;
    }
    
    public function getTipoMenu () {
        return $this->tipo_item_menu;
    }
    
}

?>