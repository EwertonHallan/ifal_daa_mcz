<?php
    $form = new Formulario();
    $form->setClasseDados(new Folha_Monitor());
    $form->__set('titulo', FuncaoCaracter::acentoTexto('Folha de Monitor'));
    $form->__set('num_pagina', $pagina);
    $form->__set('id_editar', $id_editar);
    $form->__set('id_excluir', $id_excluir);
    $form->__set('bt_novo', false);
    $form->__set('bt_excluir', false);
    
    //campo ID
    $campo = new Campo();
    $campo->setTitulo('ID');
    $campo->setNome('id');
    $campo->setChave(true);
    $campo->setTipo(EnumTipoCampo::Texto);
    $campo->setVisivel(false);
    $campo->setRequerido(true);
    $form->addCampo($campo);
    
    //campo FOLHA
    $campo = new Campo();
    $campo->setTitulo('Folha');
    $campo->setNome('id_folha');
    $campo->setTipo(EnumTipoCampo::Pesquisa);
    $campo->setObj_Lookup(new Folha());
    $campo->setCampo_Lookup('nome');
    $campo->setVisivel(true);
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
    
    //campo QUANT. FALTAS
    $campo = new Campo();
    $campo->setTitulo('Total Faltas');
    $campo->setNome('qtde_faltas');
    $campo->setHint('insira a quant. faltas');
    $campo->setTipo(EnumTipoCampo::Numero);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
    
    //campo QUANT. JUSTIFICATIVA
    $campo = new Campo();
    $campo->setTitulo('Total Justificativa');
    $campo->setNome('qtde_justificada');
    $campo->setHint('insira a quant. justificativa');
    $campo->setTipo(EnumTipoCampo::Numero);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $form->addCampo($campo);
    
    
?>