function validar_entrada(usuario,password)
{
	var passed=false;
	if(usuario.value!="")
	{
		if(password.value!="")
		{
			passed=true;
		}else{
			alert('Ingrese su contraseña');
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
			alert('La contraseña no es válida');
		}
	}else{
		alert('Escriba su contraseña');
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
				alert('Seleccione una sección');
			}
		}else{
			alert('Escriba el nombre de la sección en inglés');
		}
	}else{
		alert('Escriba el nombre de la sección');
	}
	return passed;
}