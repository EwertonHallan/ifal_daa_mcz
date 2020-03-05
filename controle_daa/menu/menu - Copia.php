<?php 
/*
require_once ('./classe/menu.php');
require_once ('./classe/sub_menu.php');
require_once ('./classe/item_menu.php');
require_once ('./classe/enumtipomenu.php');
require_once ('../util/funcaocaracter.php');

require_once ('./conf_menu.php');
*/
$criaMenu = new Menu_Permissao();
//$array_barra_menu = $criaMenu->carregaMenu();
$criaMenu->montaMenu();

/*
echo '<DIV id="bar"><center>';
echo '<TABLE class="XulMenu" id="menu1" cellSpacing="0" cellPadding="0">';
echo '  <TBODY>';
echo '  <TR>';

    foreach ($array_barra_menu as $obj_barramenu) {
        echo '<TD align=left width="100px">';
        echo '<A class=button href="javascript:void(0)">'.FuncaoCaracter::acentoTexto($obj_barramenu->getTituloMenu()).'<IMG class="arrow" height="7" alt="" src="./menu/icons/marcador.gif" width="4"></A>';
        echo '<DIV class=section>';
        
        $array_menu = $obj_barramenu->getItens();
        foreach ($array_menu as $obj_menu) {            
            switch ($obj_menu->getTipoMenu()) {
                case EnumTipoMenu::Sub_Menu:
                    echo '<A class="item" href="javascript:void(0)">'.FuncaoCaracter::acentoTexto($obj_menu->getNome()).'<IMG class="arrow" height="7" alt="" src="./menu/icons/seta.gif" width="4"></A>';
                    echo ' <DIV class=section>';
                    $array_itens = $obj_menu->getItens();
                    foreach ($array_itens as $obj_itemmenu) {
                        echo '<A class=item href='.$obj_itemmenu->getLink().' '.$obj_itemmenu->getTarget().'>'.FuncaoCaracter::acentoTexto($obj_itemmenu->getNome()).'</a>';
                    }
                    echo ' </DIV>';
                    break;
                case EnumTipoMenu::Item_Menu:
                    echo '<A class="item" href='.$obj_menu->getLink().' '.$obj_itemmenu->getTarget().'>'.FuncaoCaracter::acentoTexto($obj_menu->getNome()).'</a>';
                    break;
            }
        }
        echo '</div>';
        echo '</TD>';
    }
echo '</TR>';
echo '</TBODY>';
echo '</TABLE>';
echo '</center>';
echo '</DIV>';
*/
?>