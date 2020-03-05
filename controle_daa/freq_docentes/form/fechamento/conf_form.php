<?php
    $form = new Formulario();
    $form->setClasseDados(new Fechamento());
    $form->__set('titulo', 'Controle de Apontamento');
    $form->__set('num_pagina', $pagina);
    $form->__set('id_editar', $id_editar);
    $form->__set('id_excluir', $id_excluir);
    
    //campo ID
    $campo = new Campo();
    $campo->setTitulo('Id');
    $campo->setNome('id_fechamento');
    $campo->setChave(true);
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(false);
    $campo->setRequerido(true);
    $form->addCampo($campo);

    //campo DATA INICIAL
    $campo = new Campo();
    $campo->setTitulo('Data Inicial');
    $campo->setNome('data_inicial');
    $campo->setHint('insira a data aqui DD/MM/YYYY');
    $campo->setTipo(EnumTipoCampo::Data);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
    
    //campo DATA FINAL
    $campo = new Campo();
    $campo->setTitulo('Data Final');
    $campo->setNome('data_final');
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
        0 => array("codigo" => 9, "valor" => "TODOS"),
        1 => array("codigo" => 1, "valor" => 'MATUTINO'),
        2 => array("codigo" => 2, "valor" => 'VESPERTINO'),
        3 => array("codigo" => 3, "valor" => 'NOTURNO')
    );
    $campo->setValorLista($array_valores);
    $form->addCampo($campo);
     
    //campo TIPO
    $campo = new Campo();
    $campo->setTitulo('Tipo');
    $campo->setNome('tipo');
    $campo->setHint('insira o tipo');
    $campo->setTipo(EnumTipoCampo::Select);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $array_valores = array(
        0 => array("codigo" => 9, "valor" => "TODOS"),
        1 => array("codigo" => 1, "valor" => 'FALTAS'),
        2 => array("codigo" => 2, "valor" => 'JUSTIFICATIVAS')        
    );
    $campo->setValorLista($array_valores);
    $form->addCampo($campo);
    
    //campo OBSERVACAO
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Observaчуo'));
    $campo->setNome('observacao');
    $campo->setHint('insira a observacao aqui');
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(true);
    $campo->setRequerido(FALSE);
    $form->addCampo($campo);
        
?>