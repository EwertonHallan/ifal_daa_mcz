<?php
    $form = new Formulario();
    $form->setClasseDados(new Professor());
    $form->__set('titulo', 'Cadastro de Professor');
    $form->__set('num_pagina', $pagina);
    $form->__set('id_editar', $id_editar);
    $form->__set('id_excluir', $id_excluir);
    
    //campo ID
    $campo = new Campo();
    $campo->setTitulo('Id');
    $campo->setNome('id_professor');
    $campo->setChave(true);
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(false);
    $campo->setRequerido(true);
    $form->addCampo($campo);

    //campo SIAPE
    $campo = new Campo();
    $campo->setTitulo('SIAPE');
    $campo->setNome('siape');
    $campo->setHint('insira o siape');
    $campo->setTipo(EnumTipoCampo::Numero);
    $campo->setVisivel(true);
    $campo->setRequerido(false);
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
    
    //campo TELEFONE
    $campo = new Campo();
    $campo->setTitulo('Telefone');
    $campo->setNome('telefone');
    $campo->setHint('insira o telefone');
    $campo->setTipo(EnumTipoCampo::Telefone);
    $campo->setVisivel(true);
    $campo->setRequerido(false);
    $form->addCampo($campo);
    
    //campo EMAIL
    $campo = new Campo();
    $campo->setTitulo('E-Mail');
    $campo->setNome('email');
    $campo->setHint('insira o e-mail');
    $campo->setTipo(EnumTipoCampo::EMail);
    $campo->setVisivel(true);
    $campo->setRequerido(false);
    $form->addCampo($campo);
    
    //campo COMBO ATIVO
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Coordenaзгo'));
    $campo->setNome('id_coordenacao');
    $campo->setHint('insira a coordenacao');
//    $campo->setTipo(EnumTipoCampo::Select);
    $campo->setTipo(EnumTipoCampo::Pesquisa);
    $campo->setObj_Lookup(new Coordenacao());
    $campo->setCampo_Lookup('nome');    
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
    
    //campo DATA ATIVACAO
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Data Exercнcio no Campus'));
    $campo->setNome('mes_ativo');
    $campo->setHint('defina a data de ativacao');
    $campo->setTipo(EnumTipoCampo::Data);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
    
    //campo DATA INATIVACAO
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Data Saнda do Campus'));
    $campo->setNome('mes_inativo');
    $campo->setTipo(EnumTipoCampo::Data);
    $campo->setVisivel(true);
    $campo->setRequerido(false);
    $form->addCampo($campo);
/*    
    //campo DATA CARGA HORARIA
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Carga Horбria'));
    $campo->setNome('carga_hr');
    $campo->setTipo(EnumTipoCampo::Numero);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
*/    
    
?>