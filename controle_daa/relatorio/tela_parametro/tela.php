<?php

class Tela {
    private $titulo;         // titulo da tela de cadastro
    private $relatorio;      // nome da tabela que sera igual ao da class
    private $className;
    private $nomeRel;
    private $arrayCampos;    // array de objetos campo
    private $telaPesquisa;   //garanti a criacao apenas uma vez das tela de pesquisa
    
    public function __construct() {
        $this->className = '';
        $this->nomeRel = '';
        $this->telaPesquisa = false;
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
    
    private function montaTelaPesquisa ($campo, $classe) {
        $obj_pesquisa_form = new Form_Pesquisa();
        $obj_pesquisa_form->setTitulo('PESQUISA DE '.FuncaoCaracter::upperTexto(FuncaoCaracter::acentoTexto($campo->__get('titulo'))).'');
        $obj_pesquisa_form->setClassPesq($campo->getObj_Lookup());
        $obj_pesquisa_form->setStatus('Total de registro:');
        
        if (!$this->telaPesquisa) {
            $this->telaPesquisa = TRUE;
            $obj_pesquisa_form->montaHTML();
        }
        $obj_pesquisa_form->montaJSPesquisa('./'.$_SESSION["dir_modulo"].'relatorio/'.FuncaoCaracter::lowerTexto($classe).'/pesquisa_'.FuncaoCaracter::lowerTexto(get_class($campo->getObj_Lookup())).'.php');
    }
    
    public function montaTelaParametro () {
        
        $parte = explode('/',$this->relatorio);
        //$parte = explode('.',$parte[1]);
        //$parte = explode('_',$parte[0]);
        $this->className = $parte[0];
        $parte = explode('.',$parte[1]);
        $parte = explode('_',$parte[0]);
        $this->nomeRel = $parte[1]; 
        
        // tag DIV
        $html = '<div id="dvCadUsuario">';
        // tag form
        $html .= '<form id="paramRel_'.$this->nomeRel.'" name="paramRel_'.$this->nomeRel.'" method="POST" '.
            '  action="'.$_SESSION["dir_base_html"].$_SESSION["dir_modulo"].'relatorio/'.$this->relatorio.'">';
        // tag table titulo da pagina
        $html .= '<table border="0"><tr><td colspan="2" align="center">';

        $html .= '<h2>'.FuncaoCaracter::acentoTexto($this->__get('titulo')).'</h2>';
        //$html .= 'TIPO DO CAMPOS:'.var_dump($this->arrayCampos);
        //$html .= '<br><input type="hidden" id="pagina" name="pagina" value="'.$this->__get('num_pagina').'"</td></tr>';
        $html .= '</td></tr>';

        foreach ($this->arrayCampos as $objeto) {
            $tipo_campo = $objeto->__get('tipo'); // EnumTipoCampo
           
            switch ($tipo_campo) {                
                case EnumTipoCampo::Texto : $html .= $this->inputTypeText($objeto); break;
                case EnumTipoCampo::Numero : $html .= $this->inputTypeNumero($objeto); break;
                case EnumTipoCampo::Data : $html .= $this->inputTypeData($objeto); break;
                case EnumTipoCampo::Telefone : $html .= $this->inputTypeTelefone($objeto); break;
                case EnumTipoCampo::Select : $html .= $this->selectType($objeto); break;
                case EnumTipoCampo::Pesquisa : $html .= $this->inputTypePesquisa($objeto);  $html .= $this->montaTelaPesquisa ($objeto, $this->className);  break;
            }
        }
        
        $html .= '</table></form><br><br><center>';
        
        //botao GRAVAR
        $html .= '<input type="submit" form="paramRel_'.$this->nomeRel.'" class="btn" id="enviaRel_'.$this->nomeRel.'"'.
            ' name="enviaRel_'.$this->nomeRel.'" value="Executa" />&nbsp';
/*
        $html .= '<a href="javascript: submitform()" target="_blank" rel="noopener">Envie</a>';
        $html .= '<script type="text/javascript">';
        $html .= 'function submitform() {';
        $html .= '    document.paramRel_'.$this->nomeRel.'.submit();';
        $html .= '} </script>';
*/        
        //<input type="submit" name="Visualizar" id="Visualizar" value="Visualizar" onclick="window.open(this.getAttribute('visualizaranuncio.php?id='), '_blank');"  />
                
        //tag DIV
        $html .= '</center></div>';
               
        return $html;
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
                $tag .= ' required';
            }
        } else {
            $tag .= '<td colspan="2" align="left">';
            $tag .= '<input type="hidden" class="campo" id="'.$objeto->__get('nome').
            '" name="'.$objeto->__get('nome').'" value="'.$this->arrayDados[$objeto->getNome()].'"'.$objeto->getHint().'"';
            if ($objeto->__get('requerido')) {
                $tag .= ' required';
            }
        }
        
        $tag .= 'onkeypress="mascaraNumero(this)" />';
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
                $tag .= ' required';
            }
        } else {
            $tag .= '<td colspan="2" align="left">';
            $tag .= '<input type="hidden" class="campo" id="'.$objeto->__get('nome').'"  ';
            $tag .= ' name="'.$objeto->__get('nome').'" value="'.$this->arrayDados[$objeto->getNome()].'" ';
            $tag .= ' placeholder="'.$objeto->getHint().'" ';
            if ($objeto->__get('requerido')) {
                $tag .= ' required ';
            }
        }
        
        $tag .= ' maxlength="15" onkeypress="mascaraFone(this)" />';
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
        $tag .= '&nbsp<input type="button" id="bt_'.$objeto->__get('nome').'" name="bt_'.$objeto->__get('nome').'" value="..." alt="Pesquisa" onclick="exibir(\''.$objeto->__get('nome').'\');"">';
             
        $desc = $objeto->getObj_Lookup()->querySelect($this->arrayDados[$objeto->getNome()])[$objeto->getCampo_Lookup()];
        
        $tag .= '&nbsp<input type="text" class="campoDescricao" id="desc_'.$objeto->__get('nome').'" name="desc_'.$objeto->__get('nome').'" value="'.$desc.'" />';
        $tag .= '</td></tr>';
        
        return $tag;
    }
        
}

?>