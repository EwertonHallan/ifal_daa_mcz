<?php
    $form = new Formulario();
    $form->setClasseDados(new Senha());
    $form->__set('titulo', 'Alterar Senha');
    $form->__set('num_pagina', NULL);
    //$form->__set('id_editar', $id_editar);
    $form->__set('id_editar', $_SESSION["id"]);
    $form->__set('id_excluir', NULL);
    $form->__set('bt_novo', false);
    $form->__set('bt_relatorio', false);
    $form->__set('bt_lista', false);
    
    //campo ID
    $campo = new Campo();
    $campo->setTitulo('Id');
    $campo->setNome('id_usuario');
    $campo->setChave(true);
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(false);
    $campo->setRequerido(true);
    $form->addCampo($campo);

    //campo SENHA
    $campo = new Campo();
    $campo->setTitulo('Nova Senha');
    $campo->setNome('novasenha');
    $campo->setHint('insira a nova senha');
    $campo->setTipo(EnumTipoCampo::Senha);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
       
    //campo CONFIRMACAO
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Confimaחדo'));
    $campo->setNome('confirmacao');
    $campo->setHint('insira a confirmacao');
    $campo->setTipo(EnumTipoCampo::Senha);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
        
?>