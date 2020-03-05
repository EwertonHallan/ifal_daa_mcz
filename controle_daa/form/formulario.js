    var visibilidade = true; //Vari�vel que vai manipular o bot�o Exibir/ocultar
    var tipo_fone = 9;  // variavel para identificar o tipo de telefone celular ou fixo


    function ocultarExibir() { // Quando clicar no bot�o.
    	 
        if (visibilidade) {//Se a vari�vel visibilidade for igual a true, ent�o...
            document.getElementById("dvLista").style.display = "none";//Ocultamos a div
            visibilidade = false;//alteramos o valor da vari�vel para falso.
        } else {//ou se a vari�vel estiver com o valor false..
            document.getElementById("dvLista").style.display = "block";//Exibimos a div..
            visibilidade = true;//Alteramos o valor da vari�vel para true.
        }
    }
    
    function mascaraData(campo){ 
	    var key = event.keyCode;
		//alert("Tecla:"+key);
		if (key > 47 && key < 58) {
          if(campo.value.length == 2)
             campo.value = campo.value + '/'; 
        
		  if(campo.value.length == 5) 
             campo.value = campo.value + '/'; 
		}
	} 
    
	function mascaraFone(telefone) { 
	     var key = event.keyCode;
		 //alert("Tecla:"+key);
		 
        if (telefone.value.length == 0)
            telefone.value = '(' + telefone.value; 
            
        if (telefone.value.length == 3)
            telefone.value = telefone.value + ') '; 
        
		if (telefone.value.length == 5) {
            tipo = String.fromCharCode(event.keyCode);
			//alert("Tipo de telefone:"+tipo);
		}
		
        if (tipo==9) {
		    if(telefone.value.length == 10)
                telefone.value = telefone.value + '-';
        } else {
		    if(telefone.value.length == 9) {
                telefone.value = telefone.value + '-';	
			}

		    if(telefone.value.length == 14) {
				telefone.value = telefone.value + ' ';
			}
		}
	}
