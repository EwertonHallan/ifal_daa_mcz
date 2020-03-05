<?php
    $form = new Formulario();
    $form->setClasseDados(new Folha_Fechamento());
    $form->__set('titulo', FuncaoCaracter::acentoTexto('Período da Folha'));
    $form->__set('num_pagina', $pagina);
    $form->__set('id_editar', $id_editar);
    $form->__set('id_excluir', $id_excluir);
    
    //campo ID
    $campo = new Campo();
    $campo->setTitulo('Id');
    $campo->setNome('id');
    $campo->setChave(true);
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(false);
    $campo->setRequerido(true);
    $form->addCampo($campo);

    //campo TITULO
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Folha'));
    $campo->setNome('id_folha');
    $campo->setHint('insira o titulo');
    $campo->setTipo(EnumTipoCampo::Pesquisa);
    $campo->setObj_Lookup(new Folha());
    $campo->setCampo_Lookup('nome');
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
    
    //campo USUARIO
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Usuário'));
    $campo->setNome('usuario');
    $campo->setHint('insira o usuario');
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(true);
    $campo->setRequerido(false);
    $form->addCampo($campo);
    
    //campo DATA
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Data'));
    $campo->setNome('data');
    $campo->setHint('insira a data');
    $campo->setTipo(EnumTipoCampo::DataHora);
    $campo->setVisivel(false);
    $campo->setRequerido(false);
    $form->addCampo($campo);
    
  
?>