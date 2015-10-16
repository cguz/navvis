<?php 
	/* hay que crear en el formulario los sig elementos. nombre, email, comentario y el boton que se llame enviar*/
	if (array_key_exists('enviar',$_POST)) {
		// script para procesar mail
		$para ='davidvina@gmail.com'; //direccion a ala que se le enviara el mail
		$asunto ='Cuestionario enviado por Usuario'; //asunto del mail
		
		// eliminar caracteres escape de array POST
		// stripslashes elimina las barras al meter las comillas
		if (get_magic_quotes_gpc()) {
			function stripslashes_deep($value) {
				$value =is_array($value) ? array_map('stripslashes_deep',$value) : stripslashes($value);
				return $value;
			}
			$_POST = array_map('stripslashes_deep', $_POST);
		}
		
		//Lista de archivos que se esperan
		$esperado = array('nombre', 'email', 'comentario');
		//Configurar archivos obligatorios
		$obligatorio = array('nombre', 'email', 'comentario');
		//Crear un array vacio para cualquier archivo perdido
		$perdido = array();
		//Crear un array vacio para los errores
		$error = array();
		
		//Asume que no hay nada sospechoso
		$sospechoso = false;
		//Crear un patrón para localizar frases sospechosas
		$patron = '/Content-Type:|BCC:|CC:/i';
		
		// funcion para comprobar frases sospechosas
		function esSospechoso($val, $patron, &$sospechoso) {
			// si la variable es un array, loop a través de cada elemento
			// y pasarlo recursivamente de vuelta a la misma función
			if (is_array($val)) {
				foreach ($val as $item) {
					esSospechoso($item, $patron, $sospechoso);
				}
			}
			else {
		// si es encontrada una de las frases sospechosas, configurar Boolean a true
				if (preg_match($patron, $val)) {
					$sospechoso = true;
				}
			}
		}
		
		//comprobar el array $_POST y todos los subarrays buscando contenido sospechoso
		esSospechoso($_POST, $patron, $sospechoso);
	
		if ($sospechoso) {
			$enviarMail = false;
			unset($perdido);
		}
		else {
	
	
			//Procesar las variables $_POST (esto quita los espacios en blanco de alfinal o al principio de los posts)
			foreach ($_POST as $key => $value) {
			//asignar a variable temporalmente y vacía espacion blanco si no un array
			$temp = is_array($value) ? $value : trim($value);
			//si vació y obligatorio, añadir a array $perdido
			if (empty($temp) && in_array($key, $obligatorio)) {
				array_push($perdido, $key);
			}
			//En otro caso, asignar a una variable del mismo nombre que $key
			elseif (in_array($key, $esperado)) {
				${$key} = $temp;
			}
			}
		}
		
		//validar la dirección email
		if (!empty($email)) {
			// expresion regular para identificar caracteres ilegales en direccion email
			$checkEmail = '/^[^@]+@[^\s\r\n\'";,@%]+$/';
			// rechazar la direccion email si  no cumple la expresion regular
			if (!preg_match($checkEmail, $email)) {
				$error['email'] = 'introduce un mail correcto';
				//$perdido deja de ser necesario si el mail es enviado, así que lo destruimos
			}
		}
		
		//Seguir sólo si todos los campos requeridos están OK
		if (!$sospechoso && empty($perdido)) {
		
			//Construir el mensaje para que aparezca en diferentes lineas
			$mensaje = "Nombre: $nombre\n\n";
			$mensaje .= "Email: $email\n\n"; // .= este es el operador de concatenacion 
			$mensaje .= "Comentario: $comentario\n\n";
		
			//Limitar tamaño de linea a 70 caracteres
			$mensaje = wordwrap($mensaje, 70);
		
			//crear cabeceras adicionales
			$cabeceras ="From: Proyecto: No-Rechazados<cguz@keopstd.com>\r\n";
			//$cabeceras .="Cc: cguz@keopstd.com\r\n";
			if (!empty($email)) {
				$cabeceras .= "\r\nReply-To: $email";
			}
		
			if (!$error) { //condicional que hace que se ejecute si no ha devuelto error
						//Enviarlo
				$enviarMail = mail ($para, $asunto, $mensaje, $cabeceras);
				if ($enviarMail) {
					//$perdido deja de ser necesario si el mail es enviado, así que lo destruimos con unset					
					unset($perdido);
					header("location: contactos.php?bad=si");
					exit;
				}
			}
		}
	}
	$datos_a_llenar = ""; 
	if (isset($perdido) && in_array('nombre', $perdido)) $datos_a_llenar .= "<br> Nombre."; 
	if (isset($perdido) && in_array('email', $perdido)) $datos_a_llenar .= "<br> Mail."; 
	if (isset($perdido) && in_array('comentario', $perdido)) $datos_a_llenar .= "<br> Comentario"; 
	if ($error) $datos_a_llenar .= "<br> Escriba un Mail Correcto."; 
	$datos_a_llenar = base64_encode($datos_a_llenar);
	$Nombre_AUX 	= base64_encode($_POST[nombre]);
	$Mail_AUX 		= base64_encode($_POST[email]);
	$Comentario_AUX = base64_encode($_POST[comentario]);
	header("location: contactos.php?bad=no&datos_a_llenar=$datos_a_llenar&nombre=$Nombre_AUX&email=$Mail_AUX&comentario=$Comentario_AUX");
	exit;
?>