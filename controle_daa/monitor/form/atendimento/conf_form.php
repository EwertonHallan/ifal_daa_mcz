<?php
    $form = new Formulario();
    $form->setClasseDados(new Atendimento());
    $form->__set('titulo', 'Atendimento do Monitor');
    $form->__set('num_pagina', $pagina);
    $form->__set('id_editar', $id_editar);
    $form->__set('id_excluir', $id_excluir);
    
    //campo ID
    $campo = new Campo();
    $campo->setTitulo('Id');
    $campo->setNome('id_atendimento');
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
    $campo->setTitulo('Monitor');
    $campo->setNome('id_monitor');
    $campo->setHint('insira o monitor');
    $campo->setTipo(EnumTipoCampo::Pesquisa);
    $campo->setObj_Lookup(new Monitor());
    $campo->setCampo_Lookup('nome');
    $campo->setVisivel(true);
    $campo->setRequerido(false);
    $form->addCampo($campo);
    
    //campo NOME
    $campo = new Campo();
    $campo->setTitulo('Local');
    $campo->setNome('local');
    $campo->setHint('insira o local');
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
        0 => array("codigo" => EnumTurnoAtendimento::Matutino, "valor" => EnumTurnoAtendimento::getDescricao(EnumTurnoAtendimento::Matutino)),
        1 => array("codigo" => EnumTurnoAtendimento::Vespertino, "valor" => EnumTurnoAtendimento::getDescricao(EnumTurnoAtendimento::Vespertino)),
        2 => array("codigo" => EnumTurnoAtendimento::Noturno, "valor" => EnumTurnoAtendimento::getDescricao(EnumTurnoAtendimento::Noturno)),
        3 => array("codigo" => EnumTurnoAtendimento::Matutino_Vespertino, "valor" => EnumTurnoAtendimento::getDescricao(EnumTurnoAtendimento::Matutino_Vespertino)),
        4 => array("codigo" => EnumTurnoAtendimento::Vespertino_Noturno, "valor" => EnumTurnoAtendimento::getDescricao(EnumTurnoAtendimento::Vespertino_Noturno)),
        5 => array("codigo" => EnumTurnoAtendimento::Matutino_Noturno, "valor" => EnumTurnoAtendimento::getDescricao(EnumTurnoAtendimento::Matutino_Noturno)),
        6 => array("codigo" => EnumTurnoAtendimento::Todos, "valor" => EnumTurnoAtendimento::getDescricao(EnumTurnoAtendimento::Todos))
    );
    $campo->setValorLista($array_valores);
    $form->addCampo($campo);
    
    //campo Horario Segunda
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Horario Segunda'));
    $campo->setNome('horario_seg');
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(true);
    $campo->setRequerido(false);
    $form->addCampo($campo);
    
    //campo Horario Terca
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Horario Terça'));
    $campo->setNome('horario_ter');
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(true);
    $campo->setRequerido(false);
    $form->addCampo($campo);
    
    //campo Horario QUarta
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Horario Quarta'));
    $campo->setNome('horario_qua');
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(true);
    $campo->setRequerido(false);
    $form->addCampo($campo);
    
    //campo Horario Quinta
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Horario Quinta'));
    $campo->setNome('horario_qui');
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(true);
    $campo->setRequerido(false);
    $form->addCampo($campo);
    
    //campo Horario Sexta
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Horario Sexta'));
    $campo->setNome('horario_sex');
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(true);
    $campo->setRequerido(false);
    $form->addCampo($campo);
    
?>