function validar_entrada(usuario,password)
{
	var passed=false;
	if(usuario.value!="")
	{
		if(password.value!="")
		{
			passed=true;
		}else{
			alert('Ingrese su contrase�a');
		}
	}else{
		alert('Ingrese su nombre de usuario');
	}
	return passed;
}

function validar_password(password,confirmar)
{

	var passed=false;
	if(password.value!="")
	{
		if(password.value==confirmar.value)
		{
			passed=true;
		}else{
			alert('La contrase�a no es v�lida');
		}
	}else{
		alert('Escriba su contrase�a');
	}
	return passed;
}

function valide_nombre(nombre)
{
	var passed=false;
	if(nombre.value!="")
	{	
		passed=true;
	}else{
		alert('Escriba el nombre del grupo');
	}
	return passed;
}

function valide_seccion(nombre,nombre_in,seccion)
{
	var passed=false;
	if(nombre.value!="")
	{	
		if(nombre_in.value!="")
		{
			if(seccion.value!="0")
			{	
				passed=true;
			}else{
				alert('Seleccione una secci�n');
			}
		}else{
			alert('Escriba el nombre de la secci�n en ingl�s');
		}
	}else{
		alert('Escriba el nombre de la secci�n');
	}
	return passed;
}