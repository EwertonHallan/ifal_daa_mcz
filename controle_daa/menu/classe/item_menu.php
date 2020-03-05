<?php

class Item_Menu {
    private $nome;
    private $link;
    private $target;
    private $tipo_item_menu;
    
    public function __construct() {
        $this->target = '';
        $this->tipo_item_menu = EnumTipoMenu::Item_Menu;
    }
    
    public function __set ($atributo, $valor) {
        $this->$atributo = $valor;
    }
    
    public function __get ($atributo) {
        return $this->$atributo;
    }
    
    public function __toString() {
        return (
            'Nome:'.$this->nome.''.
            'Modulo:'.$this->modulo.''.
            'Link:'.$this->link
            );
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
    public function getLink()
    {
        return $this->link;
    }
    
    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }
    
    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    
    /**
     * @param mixed $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }
    
    public function setTarget(int $target) {
        $this->target = '';
        if ($target == EnumTargetPage::New_Page) {
           $this->target = 'target="_blank" rel="noopener"';
        }        
    }
    
    public function getTipoMenu () {
        return $this->tipo_item_menu;
    }
        
}

?>