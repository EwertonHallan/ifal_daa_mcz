<?php

class Formulario {
    private $titulo;      // titulo da tela de cadastro
    private $classDados;  // nome da tabela que sera igual ao da class
    private $arrayCampos; // array de objetos campo
    private $id_editar;   // codigo id do registro a ser editado
    private $id_excluir;  // codigo id do registro a ser excluido
    private $num_pagina;  // numero da pagina atual para a paginacao da lista de dados
    private $bt_novo;        // monta novo
    private $bt_relatorio;   // monta relatorio
    private $bt_lista;       // monta lista de pesquisa
    private $bt_editar;      // monta lista de pesquisa
    private $bt_excluir;     // monta lista de pesquisa
    private $arrayDados;     // dados da tabela para modo edicao
    private $telaPesquisa;   //garanti a criacao apenas uma vez das tela de pesquisa
    
    public function __construct() {
        $this->bt_novo = true;
        $this->bt_relatorio = true;
        $this->bt_lista = true;
        $this->telaPesquisa = false;
        $this->bt_editar = true;
        $this->bt_excluir = true;
    }
    
    public function __set ($atributo, $valor) {
        $this->$atributo = $valor;
    }
    
    public function __get ($atributo) {
        return $this->$atributo;
    }
    
    public function setClasseDados(object $classe_dados) {
        $this->classDados = $classe_dados;
    }
    
    public function getClasseDados () {
        return $this->classDados;
    }
    
    public function getNameClasseDados () {
        return get_class($this->classDados);        
    }
    
    public function addCampo (Campo $campo) {
        $this->arrayCampos[] = $campo;        
    }
    
    public function getCampo (int $id) {
        return $this->arrayCampos[$id];
    }
    
    private function montaTelaPesquisa ($campo) {
        $obj_pesquisa_form = new Form_Pesquisa();
        $obj_pesquisa_form->setTitulo('PESQUISA DE '.FuncaoCaracter::upperTexto(FuncaoCaracter::acentoTexto($campo->__get('titulo'))).'');
        $obj_pesquisa_form->setClassPesq($campo->getObj_Lookup());
        $obj_pesquisa_form->setStatus('Total de registro:');
        
        if (!$this->telaPesquisa) {
            $this->telaPesquisa = TRUE;
            $obj_pesquisa_form->montaHTML();
        }
        $obj_pesquisa_form->montaJSPesquisa('./'.$_SESSION["dir_modulo"].'form/'.FuncaoCaracter::lowerTexto($this->getNameClasseDados()).'/pesquisa_'.FuncaoCaracter::lowerTexto(get_class($campo->getObj_Lookup())).'.php');
    }
    
    public function montaFormHTML () {      
        // tag DIV
        $html = '<div id="dvCadUsuario">';
        // tag form
        $html .= '<form id="cad'.$this->getNameClasseDados().'" name="cad'.$this->getNameClasseDados().'" method="POST" '.
            '  action="'.$_SESSION["dir_base_html"].$_SESSION["dir_modulo"].'form/'.FuncaoCaracter::lowerTexto($this->getNameClasseDados()).'/cad_'.FuncaoCaracter::lowerTexto($this->getNameClasseDados()).'.php">';
        //'  action="/freq_docentes/form/'.FuncaoCaracter::lowerTexto($this->getNameClasseDados()).'/cad_'.FuncaoCaracter::lowerTexto($this->getNameClasseDados()).'.php">';
        
        // tag table titulo da pagina
        $html .= '<table border="0"><tr><td colspan="2" align="center">';
        //ATUALIZANDO DADOS CADASTRAIS
        //unset($this->arrayDados);
        $this->__set('arrayDados', NULL);
        $codigo_id = $this->__get('id_editar');
        if (isset($codigo_id)) {
            $modo = '[MODIFICAR]';
            $this->__set('arrayDados', $this->modoEdicao($codigo_id));
        } else {
            $modo = '[NOVO]';            
        }
        //EXCLUSAO
        $id_excluir = $this->__get('id_excluir');
        if (isset($id_excluir)) {
            $this->modoExclusao($id_excluir);
        }
        
        $html .= '<h2>'.FuncaoCaracter::acentoTexto($this->__get('titulo').' '.$modo).'</h2>';
        //$html .= 'TIPO DO CAMPOS:'.var_dump($this->arrayCampos);
        $html .= '<br><input type="hidden" id="pagina" name="pagina" value="'.$this->__get('num_pagina').'"</td></tr>';
        
        foreach ($this->arrayCampos as $objeto) {
            $tipo_campo = $objeto->__get('tipo'); // EnumTipoCampo
           
            switch ($tipo_campo) {                
                case EnumTipoCampo::Texto : $html .= $this->inputTypeText($objeto); break;
                case EnumTipoCampo::Senha : $html .= $this->inputTypePassword($objeto); break;
                case EnumTipoCampo::Numero : $html .= $this->inputTypeNumero($objeto); break;
                case EnumTipoCampo::EMail : $html .= $this->inputTypeEMail($objeto); break;
                case EnumTipoCampo::Data : $html .= $this->inputTypeData($objeto); break;
                case EnumTipoCampo::DataHora : $html .= $this->inputTypeData($objeto); break;
                case EnumTipoCampo::Telefone : $html .= $this->inputTypeTelefone($objeto); break;
                case EnumTipoCampo::Select : $html .= $this->selectType($objeto); break;
                case EnumTipoCampo::Pesquisa : $html .= $this->inputTypePesquisa($objeto); $html .= $this->montaTelaPesquisa ($objeto); break;
                case EnumTipoCampo::Foto : $html .= $this->imageType($objeto); break;
            }
        }
        
        $html .= '</table></form><br><br><center>';
        
        //botao NOVO
        if ($this->bt_novo) {
        $html .= '<button class="btnovo" name="limpar_'.$this->getNameClasseDados().'" id="limpar_'.$this->getNameClasseDados().'"'.
            ' onclick="window.location.assign(\'?form='.FuncaoCaracter::lowerTexto($this->getNameClasseDados()).'&modulo='.$_SESSION["dir_modulo"].'\');">Novo</button>&nbsp';
        }
        
        //botao GRAVAR
        $html .= '<input type="submit" form="cad'.$this->getNameClasseDados().'" class="btn" id="envia'.$this->getNameClasseDados().'"'.
            ' name="envia'.$this->getNameClasseDados().'" value="Gravar Dados"/>&nbsp';
        
        //botao RELATORIO
        if ($this->bt_relatorio) {
        $html .= '<button class="btn" name="rel_'.$this->getNameClasseDados().'" id="rel_'.$this->getNameClasseDados().'"'.
            ' onclick="window.open(\''.$_SESSION["dir_modulo"].'./relatorio/'.FuncaoCaracter::lowerTexto($this->getNameClasseDados()).'/rel_'.FuncaoCaracter::lowerTexto($this->getNameClasseDados()).'.php\', \'_blank\'); ">'.
            ' '.FuncaoCaracter::acentoTexto('Relatório').'</button>&nbsp';
        }
        
        if ($this->bt_lista) {
        //botao LISTAR
        $html .= '<button class="btn" name="listar_'.$this->getNameClasseDados().'" id="listar_'.$this->getNameClasseDados().'"'.
            ' onclick="ocultarExibir();">'.FuncaoCaracter::acentoTexto('Listar').'</button>';
        }
                
        //tag DIV
        $html .= '</center></div><div id="dvCentro">';
        
        if ($this->__get('num_pagina') == 0) {
            $html .= '<div id="dvLista" style="display:none">';
            $html .= '<script type="text/javascript"> visibilidade = false; </script>';
        } else {
            $html .= '<div id="dvLista">';
        }
        $html .= '<center><h3>'.FuncaoCaracter::acentoTexto('Lista de '.$this->getNameClasseDados()).'</h3></center>';
        $html .= $this->listaDados($this->getClasseDados(), $this->__get('num_pagina'));
        
        $html .= '</div></div>';
        
        return $html;
    }
    
    /**
     * @param array $dados_form
     * @Nullable $erro
     */
    public function modoInclusao (array $dados_form) {
        $chave_codigo = NULL;
        $mensagem = 'ERRO \n';
        $showERRO = false;
        
        foreach ($this->arrayCampos as $campo) {
            $erro = false;
            
            $valor =  $dados_form[$campo->__get('nome')];          
            $tipo = $campo->__get('tipo'); // EnumTipoCampo
            $requerido = $campo->__get('requerido'); 
            
            if ($campo->__get('chave')) {
                $chave_codigo = $valor;
            }
            
            if ($requerido) {
                if (!isset($valor)) {
                    $erro = true;                    
                } else {
                    switch ($tipo) {
                        case EnumTipoCampo::Data : 
                            $dt = FuncaoBanco::formataData($valor);
                            $dados_form[$campo->__get('nome')] = $dt;
                            break;
                        case EnumTipoCampo::Numero : 
                            if (!is_numeric($valor)) {
                                $erro = true;
                            } 
                            break;
                        case EnumTipoCampo::EMail : 
                            if (!filter_var($valor, FILTER_VALIDATE_EMAIL)) { 
                                $erro =true;
                            }
                            break;
                        case EnumTipoCampo::Select :
                            $select_ok = false;
                            foreach ($campo->getValorLista() as $val_select) {
                                $selecionado = '';
                                if ($valor == $val_select['codigo']) {
                                    $select_ok = true;
                                }                                
                            }
                            
                            if (!$select_ok) {
                                $erro = true;                                
                            }
                            break;
                    }
                }
                
                if ($erro) {
                    $showERRO = true;
                    $mensagem .= 'Campo: '.$campo->__get('titulo').' invalido! \n';
                }
            }
            
        }
        
        // Processo de gravacao dos dados no banco
        if (!$showERRO) {
            
            if (!isset($chave_codigo) || ($chave_codigo<=0)) {
                echo 'Dados gravados !';
                $mensagem = 'Dados gravados !';

                $this->getClasseDados()->queryInsert($dados_form);
                header('location:http://localhost/biblioteca/form/?pagina=1');
            } else {
                echo 'atualizando dados...';
                $mensagem = 'Dados gravados !';
                
                $result = $this->getClasseDados()->querySelect($chave_codigo);
                if (!isset($result)) {
                    $erro = TRUE;
                    $mensagem .= 'Inconsistencia no banco de dados!';
                    echo 'dados nao localizado...';
                } else {
                    $mensagem = 'Dados atualizados gravados !';
                    echo 'updating ...';
                    $this->getClasseDados()->queryUpdate($dados_form);
                    header('location:http://localhost/biblioteca/form/?pagina=1&editar_id='.$chave_codigo);
                }
            }
        }
        
        if ($showERRO) {
            echo '<script type="text/javascript">'.
                'alert("'.$mensagem.'");'.
                'history.go(-1);'.
                '</script>';
        }
    }
    
    private function modoEdicao (int $codigo_id) {
        $resultado = $this->getClasseDados()->querySelect($codigo_id);
        
        return $resultado;
    }
    
    private function modoExclusao (int $codigo_id) {
        $this->getClasseDados()->queryDelete($codigo_id);
    }
    
    private function selectType (Campo $objeto) {
        $tag = '<tr>';
        if ($objeto->getVisivel()) {
            $tag .= '<td align="right">';
            $tag .= ' <label for="'.$objeto->getNome().'">'.FuncaoCaracter::acentoTexto($objeto->__get('titulo')).': </label>';
            $tag .= '</td>';
            $tag .= '<td align="left">';
            $tag .= '<select type="text" class="campo" id="'.$objeto->getNome().'" name="'.$objeto->getNome().'" >';
            foreach ($objeto->getValorLista() as $valores) {
                $selecionado = '';
                if ($this->arrayDados[$objeto->getNome()] == $valores['codigo']) {
                    $selecionado = 'selected="selected"';
                }
                $tag .= '  <option value="'.$valores['codigo'].'" '.$selecionado.'>'.$valores['valor'].'</option>';
            }
            $tag .= '</select>';
            
            if ($objeto->getRequerido()) {
                $tag .= '<font color="red" size="3">&nbsp*</font>';
            }
        
            $tag .= '</td>';
        }
        
        $tag .= '</tr>';
        return $tag;
        
    }
    
    private function inputTypeText (Campo $objeto) {
        $tag = '<tr>';
        if ($objeto->getVisivel()) {
            $tag .= '<td align="right">';
            $tag .= ' <label for="'.$objeto->getNome().'">'.FuncaoCaracter::acentoTexto($objeto->__get('titulo')).': </label>';
            $tag .= '</td>';
            $tag .= '<td align="left">';
            $tag .= '<input type="text" class="campo" id="'.$objeto->getNome().
            '" name="'.$objeto->getNome().'" value="'.FuncaoCaracter::acentoTexto($this->arrayDados[$objeto->getNome()]).'" placeholder="'.$objeto->getHint().'"';
            if ($objeto->getRequerido()) {
                $tag .= ' required />';
                $tag .= '<font color="red" size="3">&nbsp*</font>';
            } else {
                $tag .= '/>';
            }
            $tag .= '</td>';
        } else {
            $tag .= '<td colspan="2" align="left">';
            $tag .= '<input type="hidden" class="campo" id="'.$objeto->getNome().
            '" name="'.$objeto->getNome().'" value="'.$this->arrayDados[$objeto->getNome()].'"'.$objeto->getHint().'"';
            if ($objeto->getRequerido()) {
                $tag .= ' required />';
            } else {
                $tag .= '/>';
            }
            $tag .= '</td>';
        }
        
        $tag .= '</tr>';
        return $tag;
    }
    
    private function inputTypePassword (Campo $objeto) {
        $tag = '<tr>';
        if ($objeto->getVisivel()) {
            $tag .= '<td align="right">';
            $tag .= ' <label for="'.$objeto->getNome().'">'.FuncaoCaracter::acentoTexto($objeto->__get('titulo')).': </label>';
            $tag .= '</td>';
            $tag .= '<td align="left">';
            $tag .= '<input type="password" class="campo" id="'.$objeto->getNome().
            '" name="'.$objeto->getNome().'" value="'.FuncaoCaracter::acentoTexto($this->arrayDados[$objeto->getNome()]).'" placeholder="'.$objeto->getHint().'"';
            if ($objeto->getRequerido()) {
                $tag .= ' required />';
                $tag .= '<font color="red" size="3">&nbsp*</font>';
            } else {
                $tag .= '/>';
            }
            $tag .= '</td>';
        } else {
            $tag .= '<td colspan="2" align="left">';
            $tag .= '<input type="hidden" class="campo" id="'.$objeto->getNome().
            '" name="'.$objeto->getNome().'" value="'.$this->arrayDados[$objeto->getNome()].'"'.$objeto->getHint().'"';
            if ($objeto->getRequerido()) {
                $tag .= ' required />';
            } else {
                $tag .= '/>';
            }
            $tag .= '</td>';
        }
        
        $tag .= '</tr>';
        return $tag;
    }
    
    private function inputTypeNumero (Campo $objeto) {
        $tag = '<tr>';
        if ($objeto->__get('visivel')) {
            $tag .= '<td align="right">';
            $tag .= ' <label for="'.$objeto->__get('nome').'">'.FuncaoCaracter::acentoTexto($objeto->__get('titulo')).': </label>';
            $tag .= '</td>';
            $tag .= '<td align="left">';
            $tag .= '<input type="text" class="campo" id="'.$objeto->__get('nome').
            '" name="'.$objeto->__get('nome').'" value="'.$this->arrayDados[$objeto->getNome()].'" placeholder="'.$objeto->getHint().'"';
            if ($objeto->__get('requerido')) {
                $tag .= ' required onkeypress="mascaraNumero(this)" />';
                $tag .= '<font color="red" size="3">&nbsp*</font>';
            }
        } else {
            $tag .= '<td colspan="2" align="left">';
            $tag .= '<input type="hidden" class="campo" id="'.$objeto->__get('nome').
            '" name="'.$objeto->__get('nome').'" value="'.$this->arrayDados[$objeto->getNome()].'"'.$objeto->getHint().'"';
            if ($objeto->__get('requerido')) {
                $tag .= ' required />';
            }
        }
        
        $tag .= '</td></tr>';
        
        return $tag;
    }
    
    private function inputTypeEMail (Campo $objeto) {
        $tag = '<tr>';
        if ($objeto->__get('visivel')) {
            $tag .= '<td align="right">';
            $tag .= ' <label for="'.$objeto->__get('nome').'">'.FuncaoCaracter::acentoTexto($objeto->__get('titulo')).': </label>';
            $tag .= '</td>';
            $tag .= '<td align="left">';
            $tag .= '<input type="email" class="campo" id="'.$objeto->__get('nome').
            '" name="'.$objeto->__get('nome').'" value="'.$this->arrayDados[$objeto->getNome()].'" placeholder="'.$objeto->getHint().'"';
            if ($objeto->__get('requerido')) {
                $tag .= ' required />';
                $tag .= '<font color="red" size="3">&nbsp*</font>';
            }
        } else {
            $tag .= '<td colspan="2" align="left">';
            $tag .= '<input type="hidden" class="campo" id="'.$objeto->__get('nome').
            '" name="nome" value="'.$this->arrayDados[$objeto->getNome()].'" placeholder="'.$objeto->getHint().'"';
            if ($objeto->__get('requerido')) {
                $tag .= ' required />';
            }
        }
        
        $tag .= '</td></tr>';
        
        return $tag;
    }
    
    private function inputTypeTelefone (Campo $objeto) {
        $tag = '<tr>';
        if ($objeto->__get('visivel')) {
            $tag .= '<td align="right">';
            $tag .= ' <label for="'.$objeto->__get('nome').'">'.FuncaoCaracter::acentoTexto($objeto->__get('titulo')).': </label>';
            $tag .= '</td>';
            $tag .= '<td align="left">';
            $tag .= '<input type="text" class="campo" id="'.$objeto->__get('nome').'" ';
            $tag .= ' name="'.$objeto->__get('nome').'" value="'.$this->arrayDados[$objeto->getNome()].'" ';
            $tag .= ' placeholder="'.$objeto->getHint().'" ';
            if ($objeto->__get('requerido')) {
                $tag .= ' required maxlength="15" onkeypress="mascaraFone(this)" />';
                $tag .= '<font color="red" size="3">&nbsp*</font>';
            }
        } else {
            $tag .= '<td colspan="2" align="left">';
            $tag .= '<input type="hidden" class="campo" id="'.$objeto->__get('nome').'"  ';
            $tag .= ' name="'.$objeto->__get('nome').'" value="'.$this->arrayDados[$objeto->getNome()].'" ';
            $tag .= ' placeholder="'.$objeto->getHint().'" ';
            if ($objeto->__get('requerido')) {
                $tag .= ' required />';
            }
        }
        
        $tag .= '</td></tr>';
        
        return $tag;
    }
    
    private function inputTypeData (Campo $objeto) {
        $tag = '<tr>';
        if ($objeto->__get('visivel')) {
            $tag .= '<td align="right">';
            $tag .= ' <label for="'.$objeto->__get('nome').'">'.FuncaoCaracter::acentoTexto($objeto->__get('titulo')).': </label>';
            $tag .= '</td>';
            $tag .= '<td align="left">';
            $tag .= '<input type="text" class="campo_data" id="'.$objeto->__get('nome').
            '" name="'.$objeto->__get('nome').'" value="'.FuncaoData::formatoData($this->arrayDados[$objeto->getNome()]).'" '.
            ' placeholder="'.$objeto->getHint().'"';
            if ($objeto->__get('requerido')) {
                $tag .= ' required';
            }
            $tag .= ' maxlength="10" onkeypress="mascaraData(this)" />';
            $tag .= '&nbsp<input type="button" id="calend_'.$objeto->__get('nome').'" name="calend_'.$objeto->__get('nome').'" value="..." alt="Calendario">';
        
            if ($objeto->__get('requerido')) {
                $tag .= '<font color="red" size="3">&nbsp*</font>';
            }
            
            $tag .= '<script type="text/javascript">';
            $tag .= 'Calendar.setup({'.
                '    inputField     :    "'.$objeto->__get('nome').'",'.   // campo de texto do formulario que contera a data
                '    ifFormat       :    "%d/%m/%Y",'.                     // formato da data
                '    button         :    "calend_'.$objeto->__get('nome').'"'.                 // botao que chama o calendario
                '});';
        } else {
            $tag .= '<td colspan="2" align="left">';
            $tag .= '<input type="hidden" class="campo_data" id="'.$objeto->__get('nome').
            '" name="'.$objeto->__get('nome').'" value="'.FuncaoData::formatoData($this->arrayDados[$objeto->getNome()]).'" '.
            ' placeholder="'.$objeto->getHint().'"';
            if ($objeto->__get('requerido')) {
                $tag .= ' required />';
            }
        }
        
        
        
        if (!isset($this->arrayDados[$objeto->getNome()])) {
            $tag .= ' '.$objeto->__get('nome').'.value="";';
        }
        $tag .= '</script>';
        $tag .= '</td></tr>';
        
        return $tag;
    }
    
    private function inputTypePesquisa (Campo $objeto) {
        $tag = '<tr>';
        if ($objeto->__get('visivel')) {
            $tag .= '<td align="right">';
            $tag .= ' <label for="'.$objeto->__get('nome').'">'.FuncaoCaracter::acentoTexto($objeto->__get('titulo')).': </label>';
            $tag .= '</td>';
            $tag .= '<td align="left">';
            $tag .= '<input type="text" class="campoPesquisa" id="'.$objeto->__get('nome').
            '" name="'.$objeto->__get('nome').'" value="'.$this->arrayDados[$objeto->getNome()].'" '.
            ' placeholder="'.$objeto->getHint().'"';
            if ($objeto->__get('requerido')) {
                $tag .= ' required';
            }
        } else {
            $tag .= '<td colspan="2" align="left">';
            $tag .= '<input type="hidden" class="campoPesquisa" id="'.$objeto->__get('nome').
            '" name="'.$objeto->__get('nome').'" value="'.$this->arrayDados[$objeto->getNome()].'" '.
            ' placeholder="'.$objeto->getHint().'"';
            if ($objeto->__get('requerido')) {
                $tag .= ' required ';
            }
        }
        
        $tag .= ' maxlength="10"  />';
        $tag .= '&nbsp<input type="button" id="bt_'.$objeto->__get('nome').'" name="bt_'.$objeto->__get('nome').'" value="..." alt="Pesquisa" onclick="exibir(\''.$objeto->__get('nome').'\');">';
             
        $desc = $objeto->getObj_Lookup()->querySelect($this->arrayDados[$objeto->getNome()])[$objeto->getCampo_Lookup()];
        
        $tag .= '&nbsp<input type="text" class="campoDescricao" id="desc_'.$objeto->__get('nome').'" name="desc_'.$objeto->__get('nome').'" value="'.$desc.'" />';
        
        if ($objeto->__get('requerido')) {
            $tag .= '<font color="red" size="3">&nbsp*</font>';
        }
        
        $tag .= '</td></tr>';
        
        return $tag;
    }
    
    private function imageType (Campo $objeto) {
        $tag = '<tr>';
        if ($objeto->__get('visivel')) {
            $tag .= '<td align="right">';
            $tag .= ' <label for="'.$objeto->__get('nome').'">'.FuncaoCaracter::acentoTexto($objeto->__get('titulo')).': </label>';
            $tag .= '</td>';
            $tag .= '<td align="left">';
            $tag .= '<img id="'.$objeto->__get('nome').
            '" name="'.$objeto->__get('nome').'" src="'.$objeto->getFileImage().'" ';
            $tag .= ' width="90px" heght="120px"  />';
        
            $tag .= '&nbsp<input type="button" id="bt_'.$objeto->__get('nome').'" name="bt_'.$objeto->__get('nome').'" value="..." alt="Pesquisa" onclick="uploadImagem(\''.$objeto->getNome().'\',\''.$objeto->getFileImage().'\');">';
            
            if ($objeto->getRequerido()) {
                $tag .= '<font color="red" size="3">&nbsp*</font>';
            }
        } else {
            $tag .= '<td colspan="2" align="left">';
        }
        
        $tag .= '</td></tr>';
        
        return $tag;
    }
    
    private function listaDados($objeto, $pagina) {
        $tag_html ='';
        
        $total_reg_pagina = 10;
        
        if ($pagina < 1) {
            $pagina=1;
        }
        
        //$objeto = new Cliente();
        $result = $objeto->querySelectAll();
        
        $inicio=($pagina*$total_reg_pagina)-$total_reg_pagina;
        //$final=($pagina*$total_reg_pagina);
        
        $total_pagina=ceil(count($result)/$total_reg_pagina);
        $anterior=($inicio/$total_reg_pagina);
        $proximo=$anterior+2;
        
        $result = $objeto->querySelectAll(NULL,$inicio,$total_reg_pagina);
        
        if ($proximo>=$total_pagina) {
            $proximo=$total_pagina;
        }
        
        if ($anterior<=1) {
            $anterior=1;
        }
        
        $tag_html .= '<table border="1px solid" rules="all" cellspacing="0" cellpadding="2" bordercolor="000000" width="700px"><tr>';
        foreach ($this->arrayCampos as $obj_campos) {
            $tag_html .= '<th>'.$obj_campos->__get('titulo').'</th>';
        }
        $tag_html .= '<th colspan=2>#</th></tr>';
        
        foreach ($result as $valor) {
            $id_chave = '';
            $tag_html .= '<tr>';
            foreach ($this->arrayCampos as $obj_campos) {
                switch ($obj_campos->__get('tipo')) {
                    case EnumTipoCampo::Numero :
                    case EnumTipoCampo::CPF :
                    case EnumTipoCampo::CGC :
                    case EnumTipoCampo::Telefone :
                    case EnumTipoCampo::EMail :
                    case EnumTipoCampo::Texto :
                        $tag_html .= '<td>'.FuncaoCaracter::acentoTexto($valor[$obj_campos->__get('nome')]).'</td>';
                        break;
                    case EnumTipoCampo::Senha :
                        $tag_html .= '<td>'.FuncaoCaracter::substr($valor[$obj_campos->__get('nome')], 1, 10).'</td>';
                        break;
                    case EnumTipoCampo::Data :
                        $tag_html .= '<td>'.FuncaoData::formatoData($valor[$obj_campos->__get('nome')]).'</td>';
                        break;
                    case EnumTipoCampo::DataHora :
                        $tag_html .= '<td>'.FuncaoData::formatoDataHora($valor[$obj_campos->__get('nome')]).'</td>';
                        break;
                    case EnumTipoCampo::Pesquisa :
                        $id_campo = $valor[$obj_campos->__get('nome')];
                        $pesquisa = $obj_campos->getObj_Lookup();
                        $busca = $pesquisa->querySelect($id_campo);
                        $coluna_campo = $obj_campos->getCampo_Lookup();
                        $desc = $busca[$coluna_campo];
                        
                        $tag_html .= '<td>'.FuncaoCaracter::acentoTexto($valor[$obj_campos->__get('nome')]).'-'.$desc.'</td>';
                        break;
                    case EnumTipoCampo::Select :
                        $texto = '';
                        foreach ($obj_campos->getValorLista() as $arr_select) {
                            if ($arr_select['codigo'] == $valor[$obj_campos->__get('nome')]) {
                                $texto = $arr_select['valor'];
                            }
                        }
                        $tag_html .= '<td>'.$texto.'</td>';
                        break;                        
                }
                
                if ($obj_campos->__get('chave')) {
                    $id_chave = $valor[$obj_campos->__get('nome')];
                }
            }
            
            if ($this->bt_editar) {
                $tag_html .= '    <td><a href="?form='.FuncaoCaracter::lowerTexto($this->getNameClasseDados()).'&modulo='.$_SESSION["dir_modulo"].'&pagina='.$pagina.'&editar_id='.$id_chave.'" alt="Editar Cliente"><img src="./form/imagem/editar.jpg" width=25px heigth=25px /></a></td>';
            }
            
            if ($this->bt_excluir) {
                $tag_html .= '    <td><a href="?form='.FuncaoCaracter::lowerTexto($this->getNameClasseDados()).'&modulo='.$_SESSION["dir_modulo"].'&pagina='.$pagina.'&excluir_id='.$id_chave.'" alt="Apagar Cliente"><img src="./form/imagem/excluir.jpg" width=25px heigth=25px /></a></td>';
            }
            $tag_html .= '</tr>';
        }
        $tag_html .= '</table><table border="0" align="center"><tr valign="middle">';
        $tag_html .= '<td><a href=?form='.FuncaoCaracter::lowerTexto($this->getNameClasseDados()).'&modulo='.$_SESSION["dir_modulo"].'&pagina='.$anterior.'><img src="./form/imagem/seta_para_esquerda.jpg" width="25px" heigth="25px" /></a></td>';
        $tag_html .= '<td>&nbsp &nbsp [ '.$pagina.' / '.$total_pagina.'  ] &nbsp &nbsp</td>';
        $tag_html .= '<td><a href=?form='.FuncaoCaracter::lowerTexto($this->getNameClasseDados()).'&modulo='.$_SESSION["dir_modulo"].'&pagina='.$proximo.'><img src="./form/imagem/seta_para_direita.jpg" width="25px" heigth="25px" /> </a></td>';
        $tag_html .= '</tr></table>';
        
        return $tag_html;
    }
    
}

?>