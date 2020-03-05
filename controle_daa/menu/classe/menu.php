<?php

class Menu {
    private $nome_menu;
    private $array_itens;
    
    public function __construct() {
        
    }
    
    public function __set ($atributo, $valor) {
        $this->$atributo = $valor;
    }
    
    public function __get ($atributo) {
        return $this->$atributo;
    }
    
    public function __toString() {
        return (var_dump($this->$array_item_menu));
    }
    
    public function setTituloMenu (String $titulo_menu) {
        $this->nome_menu = $titulo_menu;
    }
    
    public function getTituloMenu () {
        return $this->nome_menu;
    }
    
    public function addItemMenu (Item_Menu $obj_item) {
        $this->array_itens[] = $obj_item;
    }
    
    public function getItemMenu (int $id) {
        return $this->$array_itens[$id];
    }
        
    public function addSubMenu (Sub_Menu $obj_sub_menu) {
        $this->array_itens[] = $obj_sub_menu;
    }
    
    public function getSubMenu (int $id) {
        return $this->array_itens[$id];
    }
    
    public function getItens () {
        return $this->array_itens;
    }
}

?>