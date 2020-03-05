<?php
    $form = new Formulario();
    $form->setClasseDados(new Conta_Bancaria());
    $form->__set('titulo', FuncaoCaracter::acentoTexto('Cadastro de Conta Bancária'));
    $form->__set('num_pagina', $pagina);
    $form->__set('id_editar', $id_editar);
    $form->__set('id_excluir', $id_excluir);
    
    //campo ID
    $campo = new Campo();
    $campo->setTitulo('ID');
    $campo->setNome('id');
    $campo->setChave(true);
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(false);
    $campo->setRequerido(true);
    $form->addCampo($campo);
    
    //campo MONITOR
    $campo = new Campo();
    $campo->setTitulo('Monitor');
    $campo->setNome('id_monitor');
    $campo->setTipo(EnumTipoCampo::Pesquisa);
    $campo->setObj_Lookup(new Monitor());
    $campo->setCampo_Lookup('nome');
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
    
    //campo BANCO
    $campo = new Campo();
    $campo->setTitulo('Banco');
    $campo->setNome('id_banco');
    $campo->setTipo(EnumTipoCampo::Pesquisa);
    $campo->setObj_Lookup(new Banco());
    $campo->setCampo_Lookup('nome');    
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
    
    //campo AGENCIA
    $campo = new Campo();
    $campo->setTitulo(FuncaoCaracter::acentoTexto('Agênca'));
    $campo->setNome('agencia');
    $campo->setHint('insira a agencia');
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
    
    //campo NOME
    $campo = new Campo();
    $campo->setTitulo('Nome');
    $campo->setNome('nome');
    $campo->setHint('insira o nome da agencia');
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
    
    //campo CONTA
    $campo = new Campo();
    $campo->setTitulo('Conta');
    $campo->setNome('conta');
    $campo->setHint('insira a conta');
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
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
        0 => array("codigo" => EnumTipoConta_Bancaria::Corrente, "valor" => EnumTipoConta_Bancaria::getDescricao(EnumTipoConta_Bancaria::Corrente)),
        1 => array("codigo" => EnumTipoConta_Bancaria::Poupanca, "valor" => EnumTipoConta_Bancaria::getDescricao(EnumTipoConta_Bancaria::Poupanca))
    );
    $campo->setValorLista($array_valores);
    $form->addCampo($campo);
    
?>