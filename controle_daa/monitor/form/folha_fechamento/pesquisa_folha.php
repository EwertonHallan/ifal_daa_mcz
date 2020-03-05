<?php
require_once('../../../banco/conexao.php');
require_once('../../../classe/log.php');

require_once('../../../monitor/classe/folha.php');

	//recebemos nosso parâmetro vindo do form
	$parametro = isset($_POST['pesquisaDados']) ? $_POST['pesquisaDados'] : null;
	$objeto = new Folha();
	//$objeto = $obj_pesquisa_form->getClassPesq();
	$resultado = $objeto->querySelectAll('upper(nome) LIKE upper(\''.$parametro.'%\')',0,10);
	
	$msg = '';
	//começamos a concatenar nossa tabela
	$msg .='<table border=1 width="100%" cellspacing=0px cellpadding=0px bordercolor="#AA6633">';
	$msg .='	<thead>';
	$msg .='		<tr bgcolor="#D3D3D3">';
	$msg .='			<th width="74%"><font size=2>NOME</font></th>';
	$msg .='			<th width="13%"><font size=2>CODIGO</font></th>';
	$msg .='			<th width="13%"><font size=2>#</font></th>';
	$msg .='		</tr>';
	$msg .='	</thead>';
	$msg .='	<tbody>';

	if (count($resultado)) {
	    $i=0;
	    foreach ($resultado as $res) {
	        if ($i % 2) {
	            $msg .='<tr bgcolor="#D3D3D3">';
	        } else {
	            $msg .='<tr>';
	        }
	        $msg .=' <td align="left"><font size=2>'.$res['nome'].'</font></td>';
	        $msg .=' <td align="right"><font size=2>'.$res['id_folha'].' </font></td>';
	        $msg .=' <td align="center"><input type=button id=bt_sel'.$res['id_folha'].' name=bt_sel'.$res['id_folha'].' value="Selecionar" onclick="selCampo(cadFolha_Fechamento.id_folha,cadFolha_Fechamento.desc_id_folha,\''.$res['id_folha'].'\',\''.$res['nome'].'\');" /></td>';
	        $msg .='</tr>';
	        
	        $i++;
	    }
	} else {
	    $msg = '';
	    $msg .='Nenhum resultado foi encontrado...';
	}
	$msg .='	</tbody>';
	$msg .='</table>';
	
	//retorna a msg concatenada
	echo $msg;
?>