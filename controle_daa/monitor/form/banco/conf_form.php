<?php
    $form = new Formulario();
    $form->setClasseDados(new Banco());
    $form->__set('titulo', FuncaoCaracter::acentoTexto('Cadastro de Banco'));
    $form->__set('num_pagina', $pagina);
    $form->__set('id_editar', $id_editar);
    $form->__set('id_excluir', $id_excluir);
    
    //campo ID
    $campo = new Campo();
    $campo->setTitulo('Id');
    $campo->setNome('id_banco');
    $campo->setChave(true);
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(false);
    $campo->setRequerido(true);
    $form->addCampo($campo);

    //campo CODIGO
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Código'));
    $campo->setNome('codigo');
    $campo->setHint('insira o codigo');
    $campo->setTipo(EnumTipoCampo::Numero);
    $campo->setVisivel(true);
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
     
  
?>