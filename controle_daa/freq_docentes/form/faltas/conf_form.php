<?php
    $form = new Formulario();
    $form->setClasseDados(new Faltas());
    $form->__set('titulo', 'Cadastro de Faltas');
    $form->__set('num_pagina', $pagina);
    $form->__set('id_editar', $id_editar);
    $form->__set('id_excluir', $id_excluir);
    
    //campo ID
    $campo = new Campo();
    $campo->setTitulo('Id');
    $campo->setNome('id_faltas');
    $campo->setChave(true);
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(false);
    $campo->setRequerido(true);
    $form->addCampo($campo);

    //campo DATA 
    $campo = new Campo();
    $campo->setTitulo('Data');
    $campo->setNome('data');
    $campo->setHint('insira a data aqui DD/MM/YYYY');
    $campo->setTipo(EnumTipoCampo::Data);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
    
    //campo TURNO 
    $campo = new Campo();
    $campo->setTitulo('Turno');
    $campo->setNome('turno');
    $campo->setHint('insira o turno');
    $campo->setTipo(EnumTipoCampo::Select);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $array_valores = array(
        0 => array("codigo" => "NULL", "valor" => "escolha o turno"),
        1 => array("codigo" => 1, "valor" => 'MATUTINO'),
        2 => array("codigo" => 2, "valor" => 'VESPERTINO'),
        3 => array("codigo" => 3, "valor" => 'NOTURNO')
    );
    $campo->setValorLista($array_valores);
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
    
    //campo HORARIO 1
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Horαrio 1'));
    $campo->setNome('horario_1');
    $campo->setHint('insira o codigo da sala');
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setObj_Lookup(new Sala());
    $campo->setCampo_Lookup('nome');
    $campo->setVisivel(true);
    $campo->setRequerido(FALSE);
    $form->addCampo($campo);
        
    //campo HORARIO 2
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Horαrio 2'));
    $campo->setNome('horario_2');
    $campo->setHint('insira o codigo da sala');
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(true);
    $campo->setRequerido(FALSE);
    $form->addCampo($campo);
    
    //campo HORARIO 3
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Horαrio 3'));
    $campo->setNome('horario_3');
    $campo->setHint('insira o codigo da sala');
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(true);
    $campo->setRequerido(FALSE);
    $form->addCampo($campo);
    
    //campo HORARIO 4
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Horαrio 4'));
    $campo->setNome('horario_4');
    $campo->setHint('insira o codigo da sala');
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(true);
    $campo->setRequerido(FALSE);
    $form->addCampo($campo);
    
    //campo HORARIO 5
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Horαrio 5'));
    $campo->setNome('horario_5');
    $campo->setHint('insira o codigo da sala');
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(true);
    $campo->setRequerido(FALSE);
    $form->addCampo($campo);
    
    //campo HORARIO 6
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Horαrio 6'));
    $campo->setNome('horario_6');
    $campo->setHint('insira o codigo da sala');
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(true);
    $campo->setRequerido(FALSE);
    $form->addCampo($campo);
    
    //campo OBSERVACAO
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Observaηγo'));
    $campo->setNome('observacao');
    $campo->setHint('insira a observacao aqui');
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(true);
    $campo->setRequerido(FALSE);
    $form->addCampo($campo);
        
?>