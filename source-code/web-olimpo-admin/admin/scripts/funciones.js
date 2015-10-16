/*
funcion abrir
entradas=url, ancho,alto,scrollbar si o no
salida=Abre popup con las dimensiones ancho y alto mostrando la url enviada, con o sin scrollbars
*/
function abrir(url,ancho,alto,scrollbar)
{
	window.open("./inc/"+ url,"popups","width="+ ancho +",height="+ alto +",top=100,left=150,resizable=no,scrollbars=" + scrollbar + ",status=no");
}

<!--
var nav4 = window.Event ? true : false;
function acceptNum(evt){
// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
	var key = nav4 ? evt.which : evt.keyCode;
	return (key <= 13 || (key >= 48 && key <= 57));
}
//-->

function selAll(cual)
{
	var campo=document.form1.elements.length
	if(cual=="si")
	{
		for(i=0; i<campo; i++)
		{
			if(i%2!=0)
			{
				document.form1.elements[i].checked=true;
			}
		}
	}else{
		for(i=0; i<campo; i++)
		{
			if(i%2==0)
			{
				document.form1.elements[i].checked=true;
			}
		}		
	}
}

function ordenar()
{
	document.form1.orden.value="ordenar";
	document.form1.submit();
}

function contar(nombre,cuantos)
{
		var contenido=eval("document.form1."+nombre+".value");
		if(contenido.length>cuantos)
		{				
			var max_car=contenido.substr(0,cuantos);			
			contenidos=eval("document.form1."+nombre);
			contenidos.value=max_car;
		}		
}

function enviar(idioma,acc)
{
	document.form1.sub.value=acc;
	document.form1.idioma.value=idioma;
	document.form1.submit();
}
function validar()
{
	if (document.getElementById('nombre2').value=="")
	{
		alert("El nombre del cliente es obligatorio");
		document.getElementById('nombre2').focus();
		return false;
	}
	if (document.getElementById('ciudad2').value=="")
	{
		alert("La ciudad del cliente es un campo obligatorio");
		document.getElementById('ciudad2').focus();
		return false;
	}
	document.form1.submit();
}
