<?php
    $form = new Formulario();
    $form->setClasseDados(new Curso());
    $form->__set('titulo', FuncaoCaracter::acentoTexto('Cadastro de Curso'));
    $form->__set('num_pagina', $pagina);
    $form->__set('id_editar', $id_editar);
    $form->__set('id_excluir', $id_excluir);
    
    //campo ID
    $campo = new Campo();
    $campo->setTitulo('Id');
    $campo->setNome('id_curso');
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
     
    //campo TIPO
    $campo = new Campo();
    $campo->setTitulo('Tipo');
    $campo->setNome('tipo');
    $campo->setHint('insira o tipo');
    $campo->setTipo(EnumTipoCampo::Select);
    $campo->setVisivel(true);
    $campo->setRequerido(true);
    $array_valores = array(
        0 => array("codigo" => EnumTipoCurso::Integrado, "valor" => EnumTipoCurso::getDescricao(EnumTipoCurso::Integrado)),
        1 => array("codigo" => EnumTipoCurso::Subsequente, "valor" => EnumTipoCurso::getDescricao(EnumTipoCurso::Subsequente)),
        2 => array("codigo" => EnumTipoCurso::Graduacao, "valor" => EnumTipoCurso::getDescricao(EnumTipoCurso::Graduacao)),
        3 => array("codigo" => EnumTipoCurso::Pos_Graduacao, "valor" => EnumTipoCurso::getDescricao(EnumTipoCurso::Pos_Graduacao))
    );
    $campo->setValorLista($array_valores);
    $form->addCampo($campo);
    
?>