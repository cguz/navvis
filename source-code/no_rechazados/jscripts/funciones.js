function retornar_concursos(control1,control2,control3)
{
	ventana = window.open("popup_concursos.php?control1="+control1+"&control2="+control2+"&control3="+control3, "Consultar", "width=620,height=600,status=no,resizable=yes,top=200,left=200,scrollbars=auto");
}
function retornar_concursos_ep(control1,control2,control3)
{
	ventana = window.open("popup_concursos_ep.php?control1="+control1+"&control2="+control2+"&control3="+control3, "Consultar", "width=620,height=550,status=no,resizable=yes,top=200,left=200");
}
function abrir_imagen(control1,control2)
{
	ventana = window.open("popup_imagen.php?control1="+control1+"&control2="+control2, "Imagen", "width=670,height=670,status=no,resizable=no,top=200,left=200");
}
function trim(cadena){
	for(i=0; i < cadena.length; ){
		if(cadena.charAt(i)==" ")
			cadena=cadena.substring(i+1, cadena.length);
		else
			break;
	}
	
	for(i=cadena.length-1; i >= 0; i=cadena.length-1){
		if(cadena.charAt(i)==" ")
			cadena=cadena.substring(0,i);
		else
			break;
	}
	
	return cadena;
}

//funciones de nuevo_proyecto_2.php

	function validar(formulario){	
		var strcadena = new RegExp("^\\s*\\S+\\s*");	
		if (formulario.NombreProyecto.value.length == 0 || (trim(formulario.NombreProyecto.value) == '')){
			alert("Nombre de Proyecto no v\u00E1lido");
			return false;
		}//else if (formulario.enlace.value.length == 0 || (trim(formulario.enlace.value) == '')){
			//alert("Enlace no v\u00E1lido");
			//return false;
		//}
		else{return true;}
	}
	function  cambio2(){	
		document.getElementById('CArchivos').value = parseInt(document.getElementById('CArchivos').value) + 1;
		var iden = document.getElementById('CArchivos').value;
		if(document.getElementById('quota').innerHTML == '&nbsp;'){
			document.getElementById('quota').innerHTML = "<tr><td><input name=\"archivos"+iden+"\" type=\"file\" size=\"30\"><br></td></tr>";
		}else{
			document.getElementById('quota').innerHTML = document.getElementById('quota').innerHTML + "<tr><td><input name=\"archivos"+iden+"\" type=\"file\" size=\"30\" readonly=\"readonly\"><br></td></tr>";
		}			
	}
	
	
function validar_concursos()
{
	if (document.formulario.IdConcurso.value == "")
	{
		alert("Debe seleccionar un concurso");
		return false;
	}
	document.formulario.submit();
}


////////////////////////////////////////////////////
///validar mail
function ValidarEmail(Campo) {
	var perfect = true;
	with (Campo) {
		// Validar que los caracteres que contiene la cuenta de correo
		// esten dentro de los caracteres de la siguiente lista
		var car_validos = "0123456789abcdefghijlkmnopqrstuvwxyzABCDEFGHIJKMNOPQRSTUVWXYZ@.-_"
		var car_otros = "@.-_";
		for (var i=0; i < value.length; i++) {
			var ch = value.substring(i, i+1);
			if (car_validos.indexOf(ch) == -1) perfect = false;
		}
		apos = value.indexOf("@");
		lastpos = value.length-1;
		// Validar primer y ultimo caracter
		var car1 = value.substring(0, 1);
		var car2 = value.substring(lastpos, lastpos+1);
		if ((car_otros.indexOf(car1) != -1) || (car_otros.indexOf(car2) != -1)) perfect = false;
		// Validar anterior y siguiente caracter despues de "@"
		car1 = value.substring(apos-1, apos);
		car2= value.substring(apos+1, apos+2);
		if ((car_otros.indexOf(car1) != -1) || (car_otros.indexOf(car2) != -1)) perfect = false;
		// Buscar si existe otro simbolo "@" en el campo
		var subcadena = value.substring(apos + 1, 100);
		a2pos = subcadena.indexOf("@");
		spacepos = value.indexOf(" ");
		dotpos = value.lastIndexOf(".");
		posh=subcadena.indexOf(".");
		//if (apos < 1 || a2pos != -1 || dotpos - apos < 2 || lastpos - dotpos > 3 || lastpos - dotpos < 2 || spacepos != -1) {
		if (apos < 1 || a2pos != -1 || lastpos - dotpos < 2 || spacepos != -1||posh==-1) perfect = false;
	}
	if (!perfect)  {
		alert('\nEl valor del correo electronico es inválido.\n\nPor favor corrija la información.');
		Campo.focus();return false;
	}
	return true;
}