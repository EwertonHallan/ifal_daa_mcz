<?php
    $form = new Formulario();
    $form->setClasseDados(new Usuario());
    $form->__set('titulo', 'Cadastro de Usuário');
    $form->__set('num_pagina', $pagina);
    $form->__set('id_editar', $id_editar);
    $form->__set('id_excluir', $id_excluir);
    
    //campo ID
    $campo = new Campo();
    $campo->setTitulo('Id');
    $campo->setNome('id_usuario');
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
    
    //campo LOGIN
    $campo = new Campo();
    $campo->setTitulo('Login');
    $campo->setNome('login');
    $campo->setHint('insira o login');
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
    
    //campo SENHA
    $campo = new Campo();
    $campo->setTitulo('Senha');
    $campo->setNome('senha');
    $campo->setHint('');
    $campo->setTipo(EnumTipoCampo::Senha);
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
      
    //campo ATIVO
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Ativo'));
    $campo->setNome('ativo');
    $campo->setHint('');
    $campo->setTipo(EnumTipoCampo::Select);
    
    $array_valores = array(
        0 => array("codigo" => EnumAtivo::SIM, "valor" => FuncaoCaracter::acentoTexto(EnumAtivo::getDescricao(EnumAtivo::SIM))),
        1 => array("codigo" => EnumAtivo::NAO, "valor" => FuncaoCaracter::acentoTexto(EnumAtivo::getDescricao(EnumAtivo::NAO)))
    );
    $campo->setValorLista($array_valores);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
    
    //campo TIPO DE USUARIO (PERMISSAO)
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Tipo'));
    $campo->setNome('tipo');
    $campo->setHint('');
    $campo->setTipo(EnumTipoCampo::Select);
    
    $array_valores = array(
        0 => array("codigo" => EnumTipoUsuario::Cadastramento, "valor" => FuncaoCaracter::acentoTexto(EnumTipoUsuario::getDescricao(EnumTipoUsuario::Cadastramento))),
        1 => array("codigo" => EnumTipoUsuario::Apont_Faltas, "valor" => FuncaoCaracter::acentoTexto(EnumTipoUsuario::getDescricao(EnumTipoUsuario::Apont_Faltas))),
        2 => array("codigo" => EnumTipoUsuario::Apont_Justificativa, "valor" => FuncaoCaracter::acentoTexto(EnumTipoUsuario::getDescricao(EnumTipoUsuario::Apont_Justificativa))),
        3 => array("codigo" => EnumTipoUsuario::Controle_Apont, "valor" => FuncaoCaracter::acentoTexto(EnumTipoUsuario::getDescricao(EnumTipoUsuario::Controle_Apont))),
        4 => array("codigo" => EnumTipoUsuario::Administrador, "valor" => FuncaoCaracter::acentoTexto(EnumTipoUsuario::getDescricao(EnumTipoUsuario::Administrador)))
    );
    $campo->setValorLista($array_valores);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
    
    //campo ULTIMO ACESSO
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Último Acesso'));
    $campo->setNome('ultacesso');
    $campo->setHint('ultimo acesso');
    $campo->setTipo(EnumTipoCampo::Data);
    $campo->setVisivel(false);
    $campo->setRequerido(false);
    $form->addCampo($campo);
    
?>