    function exibir(campoID) {
		    	
    	document.getElementById("titulo").innerHTML = "<font FACE='Verdana' size=2 color='white'><b>TELA DE PESQUISA ...</b></font>";
    	document.getElementById("janela").style.position = 'absolute';
		document.getElementById("janela").style.top = '85px';
		document.getElementById("janela").style.left = '280px';
		document.getElementById("janela").style.height = '330px';
		document.getElementById("janela").style.width = '500px';
		document.getElementById("janela").style.display = 'block';
		document.getElementById("campoRetorno").value = campoID;
		document.getElementById("pesquisaDados").value = "";
		document.getElementById("pesquisaDados").focus();

		if (campoID == 'id_professor') {
			document.getElementById("titulo").innerHTML = "<font FACE='Verdana' size=2 color='white'><b>PESQUISA DE PROFESSOR</b></font>";
			openTela_Professor ();
		}
		
		if (campoID == 'id_coordenacao') { 
			document.getElementById("titulo").innerHTML = "<font FACE='Verdana' size=2 color='white'><b>PESQUISA DE COORDENA&Ccedil;&Atilde;O</b></font>";
			openTela_Coordenacao ();
		}
		
		if (campoID == 'id_usuario') {
			document.getElementById("titulo").innerHTML = "<font FACE='Verdana' size=2 color='white'><b>PESQUISA DE USU&Aacute;RIO</b></font>";
			openTela_Usuario ();
		}
		
		if (campoID == 'id_curso') {
			document.getElementById("titulo").innerHTML = "<font FACE='Verdana' size=2 color='white'><b>PESQUISA DE CURSO</b></font>";
			openTela_Curso ();
		}
		
		if (campoID == 'id_monitor') {
			document.getElementById("titulo").innerHTML = "<font FACE='Verdana' size=2 color='white'><b>PESQUISA DE MONITOR</b></font>";
			openTela_Monitor ();
		}
		
		if (campoID == 'id_banco') {
			document.getElementById("titulo").innerHTML = "<font FACE='Verdana' size=2 color='white'><b>PESQUISA DE BANCO</b></font>";
			openTela_Banco ();
		}
		
		if (campoID == 'id_folha') {
			document.getElementById("titulo").innerHTML = "<font FACE='Verdana' size=2 color='white'><b>PESQUISA DA FOLHA MONITOR</b></font>";
			openTela_Folha ();
		}
		
		if (campoID == 'horario_1') {
			document.getElementById("titulo").innerHTML = "<font FACE='Verdana' size=2 color='white'><b>PESQUISA DE HOR&Aacute;RIO</b></font>";
			openTela_Sala ();
		}

    }
 
    function ocultar() {
        document.getElementById("janela").style.display = "none";
    }
	
	function selCampo (obj, objDesc, codigo, texto) {
        //selCampo(cadFaltas.id_professor,cadFaltas.desc_id_professor,'10','ALAN JOHN DUARTE DE FREITAS');
		//outputForm.textofilho.value = texto;
		obj.value = codigo;
		objDesc.value = texto;
		document.getElementById("janela").style.display = "none";
	}