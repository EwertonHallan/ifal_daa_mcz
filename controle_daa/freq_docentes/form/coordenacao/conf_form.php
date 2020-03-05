<?php
    $form = new Formulario();
    $form->setClasseDados(new Coordenacao());
    $form->__set('titulo', FuncaoCaracter::acentoTexto('Cadastro de Coordenaчуo'));
    $form->__set('num_pagina', $pagina);
    $form->__set('id_editar', $id_editar);
    $form->__set('id_excluir', $id_excluir);
    
    //campo ID
    $campo = new Campo();
    $campo->setTitulo('Id');
    $campo->setNome('id_coordenacao');
    $campo->setChave(true);
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(false);
    $campo->setRequerido(true);
    $form->addCampo($campo);

    //campo NOME
    $campo = new Campo();
    $campo->setTitulo('Nome');
    $campo->setNome('nome');
    $campo->setHint('insira o nome');
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
    
    //campo EMAIL
    $campo = new Campo();
    $campo->setTitulo('E-Mail');
    $campo->setNome('email');
    $campo->setHint('insira o e-mail');
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(true);
    $campo->setRequerido(false);
    $form->addCampo($campo);
    
    
?>