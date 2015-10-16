	function newAjax()
	{ 
		/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
		lo que se puede copiar tal como esta aqui */
		var xmlhttp=false; 
		try 
		{ 
			// Creacion del objeto AJAX para navegadores no IE
			xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
		}
		catch(e)
		{ 
			try
			{ 
				// Creacion del objet AJAX para IE 
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
			} 
			catch(E) { xmlhttp=false; }
		}
		if (!xmlhttp && typeof XMLHttpRequest!='undefined') { xmlhttp=new XMLHttpRequest(); } 
	
		return xmlhttp; 
	}
	
	function changeBody(nl)
	{
		if(nl!=0)
		{
			ajax=newAjax();
			ajax.open("GET", "./_ajax.php?nl="+nl, true);
			ajax.onreadystatechange=function() 
			{ 
				if (ajax.readyState==1)
				{
					// Mientras carga elimino la opcion "Elige" y pongo una que dice "Cargando"
					combo=document.getElementById("cuerpo");
					combo.length=0;
					combo.innerHTML = "<br>Cargando...";
				}
				if (ajax.readyState==4)
				{ 
					document.getElementById("cuerpo").innerHTML=ajax.responseText;
				} 
			}
			ajax.send(null);
		}
	}