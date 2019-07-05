<?php
	$query = "SELECT * FROM usuarios WHERE IdUsuario = $_SESSION[id_usuario_actual]";
	$resul = consultar($query);
	if(is_array($resul) && (list($key,$registro)=each($resul))){
		$USUARIO_B = quitar_caracteres_filtros($registro[CuentaUsuario]);
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Proyecto: No Rechazados</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos_sitio.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="imagenes/logo.ico">
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<script language="javascript" type="text/javascript" src="jscripts/qTip.js"></script>
<body>
<!--<div id="imagenfondo">
</div>-->
<div id="cuerpopagina">
<div id="logo"><a href="#" class="info" onClick="MM_openBrWindow('ayuda/creditos.html','ayuda','scrollbars=yes,width=400,height=700')" title="Créditos"><img src="imagenes/logo-no-rechazadosok.png" alt="Proyecto No Rechazados"></a></div>
	<div id="encabezado">
		
<p id="sesion">
		  <?php if(validar_session()) echo "Bienvenido ".$USUARIO_B ."&nbsp;|"; else echo "&nbsp;";?>
		
		<?php	if(validar_session()) echo "<a class=\"info\" href=\"logout.php\">Cerrar Sesi&oacute;n</a>"; else echo "<a class=\"info\" href=\"login.php\">Iniciar Sesion</a>"; ?>
		|  
		<a href="#" class="info" onClick="MM_openBrWindow('ayuda/ayuda.html','ayuda','scrollbars=yes,width=400,height=700')">Ayuda</a>		</p>
</div>