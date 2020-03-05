    function uploadImagem(campoID, fileName) {
		
		document.getElementById("janelaUpload").style.position = 'absolute';
		document.getElementById("janelaUpload").style.top = '85px';
		document.getElementById("janelaUpload").style.left = '280px';
		document.getElementById("janelaUpload").style.height = '330px';
		document.getElementById("janelaUpload").style.width = '500px';
		document.getElementById("janelaUpload").style.display = 'block';
		document.getElementById("campoRetorno").value = campoID;
		document.getElementById("pesquisaDados").value = fileName;
		document.getElementById("pesquisaDados").focus();

		openTela_Curso ();
    }
 
    function ocultar() {
        document.getElementById("janelaUpload").style.display = "none";
    }
	
	function selCampo (obj, objDesc, codigo, texto) {
        //selCampo(cadFaltas.id_professor,cadFaltas.desc_id_professor,'10','ALAN JOHN DUARTE DE FREITAS');
		//outputForm.textofilho.value = texto;
		obj.value = codigo;
		objDesc.value = texto;
		document.getElementById("janelaUpload").style.display = "none";
	}