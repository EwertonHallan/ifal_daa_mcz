<?php
require_once('./geral/classe/enum/enumtipousuario.php');

//barra de menu
$array_barra_menu = NULL;

//menu DOCENTES
$menu = new Menu();
$menu->setTituloMenu("DOCENTES");

if (($_SESSION['tipo_user'] <> EnumTipoUsuario::Apont_Faltas) &&
    ($_SESSION['tipo_user'] <> EnumTipoUsuario::Apont_Justificativa)) {
   //submenu CADASTRO
   $sub_menu = new Sub_Menu();
   $sub_menu->setNome("Cadastro");
       //item
       $item_menu = new Item_Menu();
       $item_menu->setNome("Coordenação");
       $item_menu->setLink($_SESSION["dir_base_html"].'?form=coordenacao&modulo=freq_docentes');
       $item_menu->setTarget(EnumTargetPage::Self_Page);
   //add item_menu no submenu
   $sub_menu->addItemMenu($item_menu);
   
   //item
   $item_menu = new Item_Menu();
   $item_menu->setNome("Professor");
   $item_menu->setLink($_SESSION["dir_base_html"].'?form=professor&modulo=freq_docentes');
   $item_menu->setTarget(EnumTargetPage::Self_Page);
   //add item_menu no submenu
   $sub_menu->addItemMenu($item_menu);
   
   //item
   $item_menu = new Item_Menu();
   $item_menu->setNome("Sala");
   $item_menu->setLink($_SESSION["dir_base_html"].'?form=sala&modulo=freq_docentes');
   $item_menu->setTarget(EnumTargetPage::Self_Page);
   //add item_menu no submenu
   $sub_menu->addItemMenu($item_menu);
   
//add submenu no menu
$menu->addSubMenu($sub_menu);
}

if (($_SESSION['tipo_user'] == EnumTipoUsuario::Apont_Faltas) ||
    ($_SESSION['tipo_user'] == EnumTipoUsuario::Apont_Justificativa) ||
    ($_SESSION['tipo_user'] == EnumTipoUsuario::Controle_Apont) ||
    ($_SESSION['tipo_user'] == EnumTipoUsuario::Administrador)) {
   //submenu APONTAMENTO
      $sub_menu = new Sub_Menu();
      $sub_menu->setNome("Apontamento");

   if (($_SESSION['tipo_user'] == EnumTipoUsuario::Apont_Faltas) ||
       ($_SESSION['tipo_user'] == EnumTipoUsuario::Controle_Apont) ||
       ($_SESSION['tipo_user'] == EnumTipoUsuario::Administrador)) {
      //item
      $item_menu = new Item_Menu();
      $item_menu->setNome("Faltas");
      $item_menu->setLink($_SESSION["dir_base_html"].'?form=faltas&modulo=freq_docentes');
      $item_menu->setTarget(EnumTargetPage::Self_Page);
   
      //add item_menu no submenu
      $sub_menu->addItemMenu($item_menu);
   }
      
   if (($_SESSION['tipo_user'] == EnumTipoUsuario::Apont_Justificativa) ||
       ($_SESSION['tipo_user'] == EnumTipoUsuario::Controle_Apont) ||
       ($_SESSION['tipo_user'] == EnumTipoUsuario::Administrador)) {
           //item
      $item_menu = new Item_Menu();
      $item_menu->setNome("Justificativa");
      $item_menu->setLink($_SESSION["dir_base_html"].'?form=justificativa&modulo=freq_docentes');
      $item_menu->setTarget(EnumTargetPage::Self_Page);
   
      //add item_menu no submenu
      $sub_menu->addItemMenu($item_menu);
   }

   //add submenu no menu
   $menu->addSubMenu($sub_menu);
}

if (($_SESSION['tipo_user'] == EnumTipoUsuario::Controle_Apont) ||
    ($_SESSION['tipo_user'] == EnumTipoUsuario::Administrador)) {
    //item
    $item_menu = new Item_Menu();
    $item_menu->setNome("Controle de Apontamento");
    $item_menu->setLink($_SESSION["dir_base_html"].'?form=fechamento&modulo=freq_docentes');
    $item_menu->setTarget(EnumTargetPage::Self_Page);
    
    //add submenu no menu
    $menu->addItemMenu($item_menu);
}

if (($_SESSION['tipo_user'] <> EnumTipoUsuario::Cadastramento) &&
    ($_SESSION['tipo_user'] <> EnumTipoUsuario::Apont_Faltas) && 
    ($_SESSION['tipo_user'] <> EnumTipoUsuario::Apont_Justificativa)) {
     //submenu RELATORIOS
      $sub_menu = new Sub_Menu();
      $sub_menu->setNome("Relatorio");

      //item
      $item_menu = new Item_Menu();
      $item_menu->setNome("Relação Sala");
      $item_menu->setLink($_SESSION["dir_base_html"].'freq_docentes/relatorio/sala/rel_sala.php');
      $item_menu->setTarget(EnumTargetPage::New_Page);
      //add item_menu no submenu
      $sub_menu->addItemMenu($item_menu);
      
      //item
      $item_menu = new Item_Menu();
      $item_menu->setNome("Relação Coordenacao");
      $item_menu->setLink($_SESSION["dir_base_html"].'freq_docentes/relatorio/coordenacao/rel_coordenacao.php');
      $item_menu->setTarget(EnumTargetPage::New_Page);
   //add item_menu no submenu
   $sub_menu->addItemMenu($item_menu);
   
      //item
      $item_menu = new Item_Menu();
      $item_menu->setNome("Relação Professor");
      //$item_menu->setLink($_SESSION["dir_base_html"].'relatorio/professor/rel_professor.php');
      $item_menu->setLink($_SESSION["dir_base_html"].'?rel=professor/index_professor&modulo=freq_docentes');
      $item_menu->setTarget(EnumTargetPage::Self_Page);
   //add item_menu no submenu
   $sub_menu->addItemMenu($item_menu);

   //item
   $item_menu = new Item_Menu();
   $item_menu->setNome("Relação de Faltas");
   $item_menu->setLink($_SESSION["dir_base_html"].'freq_docentes/relatorio/faltas/rel_faltas.php');
   $item_menu->setTarget(EnumTargetPage::New_Page);
   //add item_menu no submenu
   $sub_menu->addItemMenu($item_menu);

   //item
   $item_menu = new Item_Menu();
   $item_menu->setNome("Relação de Justificativas");
   $item_menu->setLink($_SESSION["dir_base_html"].'freq_docentes/relatorio/justificativa/rel_justificativa.php');
   $item_menu->setTarget(EnumTargetPage::New_Page);
   //add item_menu no submenu
   $sub_menu->addItemMenu($item_menu);
   
   //item
   $item_menu = new Item_Menu();
   $item_menu->setNome("Controle de Apontamento");
   $item_menu->setLink($_SESSION["dir_base_html"].'freq_docentes/relatorio/fechamento/rel_fechamento.php');
   $item_menu->setTarget(EnumTargetPage::New_Page);
   //add item_menu no submenu
   $sub_menu->addItemMenu($item_menu);
   
   //item
   $item_menu = new Item_Menu();
   $item_menu->setNome("Mapa de Faltas");
   $item_menu->setLink($_SESSION["dir_base_html"].'?rel=faltas/index_mapafaltas&modulo=freq_docentes');
   //$item_menu->setLink($_SESSION["dir_base_html"].'relatorio/faltas/param_mapafaltas.php');
   $item_menu->setTarget(EnumTargetPage::Self_Page);
   //add item_menu no submenu
   $sub_menu->addItemMenu($item_menu);
   
//add submenu no menu
$menu->addSubMenu($sub_menu);
}

//add menu na barra de menu
$array_barra_menu[] = $menu;


//menu MONITORES
$menu = new Menu();
$menu->setTituloMenu("MONITORES");

   //submenu CADASTRO
   $sub_menu = new Sub_Menu();
   $sub_menu->setNome("Cadastro");
      //item
   $item_menu = new Item_Menu();
   $item_menu->setNome("Monitor");
   $item_menu->setLink($_SESSION["dir_base_html"].'?form=monitor&modulo=monitor');
   $item_menu->setTarget(EnumTargetPage::Self_Page);
   //add item_menu no submenu
   $sub_menu->addItemMenu($item_menu);

      //item
      $item_menu = new Item_Menu();
      $item_menu->setNome("Horário");
      $item_menu->setLink($_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'.?form=horario/');
      $item_menu->setTarget(EnumTargetPage::Self_Page);
   //add item_menu no submenu
   $sub_menu->addItemMenu($item_menu);

//add submenu no menu
$menu->addSubMenu($sub_menu);

   //submenu APONTAMENTO
   $sub_menu = new Sub_Menu();
   $sub_menu->setNome("Apontamento");
      //item
      $item_menu = new Item_Menu();
      $item_menu->setNome("Frequência");
      $item_menu->setLink($_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'.?form=frequencia/');
      $item_menu->setTarget(EnumTargetPage::Self_Page);
   //add item_menu no submenu
   $sub_menu->addItemMenu($item_menu);

      //item
      $item_menu = new Item_Menu();
      $item_menu->setNome("Cálculo da Folha");
      $item_menu->setLink($_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'.?form=calculo_folha/');
      $item_menu->setTarget(EnumTargetPage::Self_Page);
   //add item_menu no submenu
   $sub_menu->addItemMenu($item_menu);
//add submenu no menu
$menu->addSubMenu($sub_menu);

//add menu na barra de menu
$array_barra_menu[] = $menu;


//menu SISTEMA
$menu = new Menu();
$menu->setTituloMenu("SISTEMA");

if ($_SESSION['tipo_user'] == EnumTipoUsuario::Administrador) {
    //item
    $item_menu = new Item_Menu();
    $item_menu->setNome("Usuario");
    $item_menu->setLink($_SESSION["dir_base_html"].'?form=usuario&modulo=geral');
    $item_menu->setTarget(EnumTargetPage::Self_Page);
    //add item_menu no submenu
    $menu->addItemMenu($item_menu);

    //item
    $item_menu = new Item_Menu();
    $item_menu->setNome("Comando SQL");
    $item_menu->setLink($_SESSION["dir_base_html"].'?form=sql&modulo=geral');
    $item_menu->setTarget(EnumTargetPage::Self_Page);
    //add item_menu no submenu
    $menu->addItemMenu($item_menu);
}
    //item
    $item_menu = new Item_Menu();
    $item_menu->setNome("Alterar Senha");
    $item_menu->setLink($_SESSION["dir_base_html"].'?form=senha&modulo=geral');
    $item_menu->setTarget(EnumTargetPage::Self_Page);
    //add submenu no menu
    $menu->addItemMenu($item_menu);

    //item
    $item_menu = new Item_Menu();
    $item_menu->setNome("SAIR");
    $item_menu->setLink($_SESSION["dir_base_html"].'session/logoff.php');
    $item_menu->setTarget(EnumTargetPage::Self_Page);
    //add submenu no menu
    $menu->addItemMenu($item_menu);
    
    //add menu na barra de menu
$array_barra_menu[] = $menu;
?>