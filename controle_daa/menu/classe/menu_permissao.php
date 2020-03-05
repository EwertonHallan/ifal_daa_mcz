<?php
session_start();

class Menu_Permissao {
    private $array_barra_menu;

    private $conexao;
    
    public function __construct() {
        $array_barra_menu = null;
        $this->conexao = new Conexao();
    }
    
    public function __set ($atributo, $valor) {
        $this->$atributo = $valor;
    }
    
    public function __get ($atributo) {
        return $this->$atributo;
    }
    
    public function __toString() {
        return (var_dump($array_barra_menu)
            );
    }
    
    private function querySelect ($id) {
        try {
            $cmd = "SELECT m.id_modulo, i.id_itemmenu,  m.nome as modulo, i.nome, m.path, i.tipo_tela, i.tela, i.tipo, m.seq ".
                   "  FROM itemmenu i, modulo m, permissao p".
                   " where m.id_modulo = i.id_modulo ".
                   "   and p.id_modulo=i.id_modulo and p.id_itemmenu=i.id_itemmenu ".
                   "   and p.id_usuario=:param_id".
                   " order by m.seq, i.id_itemmenu";
            
            $stm = $this->conexao->conectar()->prepare($cmd);
            $stm->bindParam(":param_id", $id, PDO::PARAM_INT);
            $stm->execute();
            
            return $stm->fetchAll();
        } catch (PDOException $ex) {
            return 'Error:'.$ex->getMessage();
        }
    }
    
    private function Menu($dados) {
        $id_menu = $dados['id_modulo'];
        $nome_menu = $dados['modulo'];
        $modulo = $dados['path'];
        
        //Menu
        $menu = new Menu();
        $menu->setTituloMenu($nome_menu);
        
        return ($menu);
    }
    
    private function subMenu($dados) {
        $id_menu = $dados['id_itemmenu'];
        $nome_menu = $dados['nome'];
        $modulo = $dados['path'];
        
        //submenu
        $sub_menu = new Sub_Menu();
        $sub_menu->setNome($nome_menu);        
        
        return ($sub_menu);
    }
    
    private function itemMenu($dados) {
        $id_menu = $dados['id_itemmenu'];
        $nome_menu = $dados['nome'];
        $modulo = $dados['path'];
        $tipo_tela = $dados['tipo_tela'];
        $tela = $dados['tela'];
        //$_SESSION["dir_base_html"].'?form=coordenacao&modulo=freq_docentes'
        $link = $_SESSION["dir_base_html"].'?modulo='.$modulo.'&'.$tipo_tela.'='.$tela;
        
        //itemmenu
        $item_menu = new Item_Menu();
        $item_menu->setNome($nome_menu);
        $item_menu->setLink($link);
        $item_menu->setTarget(EnumTargetPage::Self_Page);
        
        
        return ($item_menu);
    }
    
    private function carregaMenu ($id_usuario) {
        $inicio = TRUE;
        $id_modulo = null;
        $grupo = NULL;
        
        $array = $this->querySelect($id_usuario);

        foreach ($array as $registro) {
            $id_menu = $registro['id_itemmenu'];
            
            // verificar se mudou de grupo
            $item = explode('.', $id_menu);
            $item = $registro[0].$item[0];
            $new_grupo = 'F';
            
            //echo 'Inicio new grupo:'.$new_grupo.'<br>';
            
            if ($grupo <> $item) {
                if (isset($grupo)) {
                    $new_grupo = 'T';
                }
                $grupo = $item;                                
            }
            
            //mudanca de grupo
            if ($new_grupo == 'T') {
                if (isset($sub_menu)) {
                    //add submenu no menu
                    $menu->addSubMenu($sub_menu);
                }
                $sub_menu = NULL;
            }
            
            //menu DOCENTES
            if ($id_modulo <> $registro[0]) {
                $id_modulo = $registro[0];
                
                if (isset($menu)) {
                    //add menu na barra de menu
                    $this->array_barra_menu[] = $menu;
                }
                
                $menu = $this->Menu($registro);                
            }
            
            //echo 'Modulo:'.$id_modulo.'<br>';
            //echo 'Grupo:'.$grupo.'<br>';
            //echo 'Item:'.$id_menu.'<br>';
            
            // CRIANDO SUBMENU OU ITEMMENU
            $tipo = $registro[7];
            
            //echo 'Tipo:'.$tipo.'<br>';
            
            if ($tipo == 'S') {              
                //submenu
                $sub_menu = $this->subMenu($registro);
            } else {
                //itemmenu 
                $item_menu = $this->itemMenu($registro);               
            
                if (isset($sub_menu)) {
                    //add item_menu no submenu
                    $sub_menu->addItemMenu($item_menu);
                } else {
                    //add item_menu no menu
                    $menu->addItemMenu($item_menu);                    
                }
            }
            
        }

        if (isset($sub_menu)) {
            //add submenu no menu
            $menu->addSubMenu($sub_menu);
        }
        
        // inclusao do ultimo modulo
        $this->array_barra_menu[] = $menu;
        
        return $this->array_barra_menu;
    }
    
    public function montaMenu () {
        $this->array_barra_menu = $this->carregaMenu ($_SESSION["id"]);
        
        $html = '';
        $html .= '<DIV id="bar"><center>';
        $html .= '<TABLE class="XulMenu" id="menu1" cellSpacing="0" cellPadding="0">';
        $html .= '  <TBODY>';
        $html .= '  <TR>';
        
        foreach ($this->array_barra_menu as $obj_barramenu) {
            $html .= '<TD align=left width="100px">';
            $html .= '<A class=button href="javascript:void(0)">'.FuncaoCaracter::acentoTexto($obj_barramenu->getTituloMenu()).'<IMG class="arrow" height="7" alt="" src="./menu/icons/marcador.gif" width="4"></A>';
            $html .= '<DIV class=section>';
            
            $array_menu = $obj_barramenu->getItens();
            foreach ($array_menu as $obj_menu) {
                switch ($obj_menu->getTipoMenu()) {
                    case EnumTipoMenu::Sub_Menu:
                        $html .= '<A class="item" href="javascript:void(0)">'.FuncaoCaracter::acentoTexto($obj_menu->getNome()).'<IMG class="arrow" height="7" alt="" src="./menu/icons/seta.gif" width="4"></A>';
                        $html .= ' <DIV class=section>';
                        $array_itens = $obj_menu->getItens();
                        foreach ($array_itens as $obj_itemmenu) {
                            $html .= '<A class=item href='.$obj_itemmenu->getLink().' '.$obj_itemmenu->getTarget().'>'.FuncaoCaracter::acentoTexto($obj_itemmenu->getNome()).'</a>';
                        }
                        $html .= ' </DIV>';
                        break;
                    case EnumTipoMenu::Item_Menu:
                        $html .= '<A class="item" href='.$obj_menu->getLink().' '.$obj_itemmenu->getTarget().'>'.FuncaoCaracter::acentoTexto($obj_menu->getNome()).'</a>';
                        break;
                }
            }
            $html .= '</div>';
            $html .= '</TD>';
        }
        $html .= '</TR>';
        $html .= '</TBODY>';
        $html .= '</TABLE>';
        $html .= '</center>';
        $html .= '</DIV>';
        
        echo $html;
    }
}

?>