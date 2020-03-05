<?php
    $form = new Formulario();
    $form->setClasseDados(new Monitor());
    $form->__set('titulo', 'Cadastro de Monitor');
    $form->__set('num_pagina', $pagina);
    $form->__set('id_editar', $id_editar);
    $form->__set('id_excluir', $id_excluir);
    
    //campo ID
    $campo = new Campo();
    $campo->setTitulo('Id');
    $campo->setNome('id_monitor');
    $campo->setChave(true);
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(false);
    $campo->setRequerido(true);
    $form->addCampo($campo);
/*
    //campo FOTO
    $campo = new Campo();
    $campo->setTitulo('Foto 3x4');
    $campo->setNome('foto');
    $campo->setHint('escolha uma foto');
    $campo->setTipo(EnumTipoCampo::Foto);
    $campo->setFileImage('./monitor/foto/hellen_1e70fae198d6eea931f84874d2dd0138_9d94fa8673e29cf704a82bd49aa18b26_d3934574d274c97aba8554721dc5100b.jpg');
    $campo->setVisivel(true);
    $campo->setRequerido(false);
    $form->addCampo($campo);
*/    
    //campo MATRICULA
    $campo = new Campo();
    $campo->setTitulo('Matricula');
    $campo->setNome('matricula');
    $campo->setHint('insira a matricula');
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
    
    //campo COMBO CURSO
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Curso'));
    $campo->setNome('id_curso');
    $campo->setHint('insira o curso');
//    $campo->setTipo(EnumTipoCampo::Select);
    $campo->setTipo(EnumTipoCampo::Pesquisa);
    $campo->setObj_Lookup(new Curso());
    $campo->setCampo_Lookup('nome');    
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
    
    //campo TURMA
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Turma'));
    $campo->setNome('turma');
    $campo->setHint('insira a turma');
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
    
    //campo TURNO
    $campo = new Campo();
    $campo->setTitulo('Turno');
    $campo->setNome('id_turno');
    $campo->setHint('insira o turno');
    $campo->setTipo(EnumTipoCampo::Select);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $array_valores = array(
        0 => array("codigo" => 9, "valor" => "TODOS"),
        1 => array("codigo" => 1, "valor" => 'MATUTINO'),
        2 => array("codigo" => 2, "valor" => 'VESPERTINO'),
        3 => array("codigo" => 3, "valor" => 'NOTURNO')
    );
    $campo->setValorLista($array_valores);
    $form->addCampo($campo);
    
    //campo SETOR
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Setor'));
    $campo->setNome('setor');
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(true);
    $campo->setRequerido(false);
    $form->addCampo($campo);
    
    //campo COMBO ORIENTADOR
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Orientador'));
    $campo->setNome('id_professor');
    $campo->setHint('insira o orientador');
    //    $campo->setTipo(EnumTipoCampo::Select);
    $campo->setTipo(EnumTipoCampo::Pesquisa);
    $campo->setObj_Lookup(new Professor());
    $campo->setCampo_Lookup('nome');
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
    
?>