		var tela = null;
		var c = null;
		var mdX = 0; 
		var mdY = 0; 
		var muX = 0; 
		var muY = 0; 
	    
		function mouseDown () {
			mdX = event.clientX;
			mdY = event.clientY;
			
			//desenhaImagem(NULL);			
	    }
	
		function mouseUp () {
			muX = event.clientX;
			muY = event.clientY;
			
			desenhaRetangulo ((mdX-25), (mdY-90), (muX-mdX), (muY-mdY));
			//desenhaRetangulo ((mdX-15), (mdY-15), (muX-mdX), (muY-mdY));
	    }
		
		function extractFileName (path_file) {
		   var aux = "";
		   
		   // C:\fakepath\vinicius.jpg
		   for(var i = 0; i < path_file.length; i++){
		      aux += path_file.charAt(i);
			  if (path_file.charAt(i) == "\\") {
			    aux = "";
			  }
		   }
		   
		   return aux;
		}

		function desenhaImagem(fileName) {
			var files = document.getElementById("files").value;
			var nome = extractFileName(files);

			//alert("file NOME:"+nome.toLowerCase()+".");
			
			if (nome == null || nome.trim() == '') {
				//alert("fileName preenchido"+fileName+".");
			    nome = fileName;
			}
			nome = nome.toLowerCase();
			nomeArquivoFoto.value = nome;
			//alert("Nome arquivo:"+nome);

			if (tela == null && tela == undefined) {
			  var tela = document.getElementById("tela");
			  var c = tela.getContext("2d");
			} 
			
			var imagem = new Image();			
			imagem.src = "./downloads/vazio.jpg";
			imagem.width = 400;
			imagem.height = 600;
			imagem.onload = function() {
				c.clearRect(0, 0, 600, 800);
				c.drawImage(imagem,5,5);				
			}

			var imagem = new Image();			
			imagem.src = "./downloads/"+nome;
			imagem.width = 400;
			imagem.height = 600;
			imagem.onload = function() {
				c.clearRect(0, 0, 600, 800);
				c.drawImage(imagem,5,5);				
			}
			//document.getElementById("myForm").submit();
		}
		
		function desenhaRetangulo (ponto_x, ponto_y, larg_quadro, alt_quadro) {
			if (tela == null && tela == undefined) {
			  var tela = document.getElementById("tela");
			  var c = tela.getContext("2d");
			}
			
			if (ponto_x > 0) {
				 //alert("Coordenada:"+ponto_x+","+ponto_y+" Largura:"+larg_quadro+" Altura:"+alt_quadro);
				 c.strokeStyle = "#FF0000";
				 c.strokeRect(ponto_x, ponto_y, larg_quadro, alt_quadro);
				 
				 coord_x.value = ponto_x;       coord_y.value = ponto_y;
				 largura.value = larg_quadro;   altura.value = alt_quadro;
			}
			
		}
		
		function paginaGravacao () {
			var comandoGet = "?fileName="+document.getElementById("nomeArquivoFoto").value;
			comandoGet += "&dim=["+document.getElementById("coord_x").value+","+document.getElementById("coord_y").value+",";
			comandoGet += ""+document.getElementById("largura").value+","+document.getElementById("altura").value+"]";
			//alert("Arquivo para GRAVACAO:"+comandoGet);
			location.href="http://localhost/controle_daa/upload/recorta_foto.php"+comandoGet;
			//<button type="button" onclick="location.href='home.php'" style="margin-left: 10%" class="bt2" >Voltar</button>
		}
		