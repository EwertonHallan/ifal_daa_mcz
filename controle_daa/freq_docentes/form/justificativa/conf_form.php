<?php
    $form = new Formulario();
    $form->setClasseDados(new Justificativa());
    $form->__set('titulo', 'Cadastro de Justificativa');
    $form->__set('num_pagina', $pagina);
    $form->__set('id_editar', $id_editar);
    $form->__set('id_excluir', $id_excluir);
    
    //campo ID
    $campo = new Campo();
    $campo->setTitulo('Id');
    $campo->setNome('id_justificativa');
    $campo->setChave(true);
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(false);
    $campo->setRequerido(true);
    $form->addCampo($campo);

    //campo COMBO PROFESSOR
    $campo = new Campo();
    $campo->setTitulo('Professor');
    $campo->setNome('id_professor');
    $campo->setHint('insira o professor');
    $campo->setTipo(EnumTipoCampo::Pesquisa);
    $campo->setObj_Lookup(new Professor());
    $campo->setCampo_Lookup('nome');
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
    
    //campo DATA INICIAL
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Data Início'));
    $campo->setNome('dt_inicio');
    $campo->setHint('insira a data aqui DD/MM/YYYY');
    $campo->setTipo(EnumTipoCampo::Data);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
    
    //campo DATA INICIAL
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Data Término'));
    $campo->setNome('dt_termino');
    $campo->setHint('insira a data aqui DD/MM/YYYY');
    $campo->setTipo(EnumTipoCampo::Data);
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
        0 => array("codigo" => EnumTipoTurno::Todos, "valor" => EnumTipoTurno::getDescricao(EnumTipoTurno::Todos)),
        1 => array("codigo" => EnumTipoTurno::Matutino, "valor" => EnumTipoTurno::getDescricao(EnumTipoTurno::Matutino)),
        2 => array("codigo" => EnumTipoTurno::Vespertino, "valor" => EnumTipoTurno::getDescricao(EnumTipoTurno::Vespertino)),
        3 => array("codigo" => EnumTipoTurno::Noturno, "valor" => EnumTipoTurno::getDescricao(EnumTipoTurno::Noturno))
    );
    $campo->setValorLista($array_valores);
    $form->addCampo($campo);
       
    //campo JUSTIFICATIVA
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Justificativa'));
    $campo->setNome('justificativa');
    $campo->setHint('insira a justificativa aqui');
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
        
?>