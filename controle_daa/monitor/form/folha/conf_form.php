<?php
    $form = new Formulario();
    $form->setClasseDados(new Folha());
    $form->__set('titulo', FuncaoCaracter::acentoTexto('Período da Folha'));
    $form->__set('num_pagina', $pagina);
    $form->__set('id_editar', $id_editar);
    $form->__set('id_excluir', $id_excluir);
    
    //campo ID
    $campo = new Campo();
    $campo->setTitulo('Id');
    $campo->setNome('id_folha');
    $campo->setChave(true);
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(false);
    $campo->setRequerido(true);
    $form->addCampo($campo);

    //campo TITULO
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Título'));
    $campo->setNome('nome');
    $campo->setHint('insira o titulo');
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
    
    //campo DATA INICIAL
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Data Inicial'));
    $campo->setNome('data_inicial');
    $campo->setHint('insira a data');
    $campo->setTipo(EnumTipoCampo::Data);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
    
    //campo DATA FINAL
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Data Final'));
    $campo->setNome('data_final');
    $campo->setHint('insira a data');
    $campo->setTipo(EnumTipoCampo::Data);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
    
    //campo TOTAL DIAS
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Dias Mês'));
    $campo->setNome('total_dias');
    $campo->setHint('insira total dias do mes');
    $campo->setTipo(EnumTipoCampo::Numero);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
    
    //campo VALOR DIARIA
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Valor Diária'));
    $campo->setNome('valor_diaria');
    $campo->setHint('insira o valor da diaria');
    $campo->setTipo(EnumTipoCampo::Numero);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
    
    //campo TURNO
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Critério'));
    $campo->setNome('criterio');
    $campo->setHint('insira o criterio');
    $campo->setTipo(EnumTipoCampo::Select);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $array_valores = array(
        1 => array("codigo" => 1, "valor" => 'Diaria x Frequencia'),
        2 => array("codigo" => 2, "valor" => 'Desconta Faltas'),
        9 => array("codigo" => 3, "valor" => 'Sem Desconto')
    );
    $campo->setValorLista($array_valores);
    $form->addCampo($campo);
    
?>