<?php
	include "./librerias/lib_session.inc";
	include "./librerias/lib_db.inc";
	include "./librerias/lib_mensajes.php";
	include "./librerias/operaciones.php";
	
	$mensaje = "";
	$Nombre_AUX 	= "";
	$Mail_AUX 		= "";
	$Comentario_AUX = "";
	if(isset($_GET[bad])){
		if ($_GET[bad]=="si"){
			$mensaje = "Mensaje enviado con &eacute;xito.";
		}else{
			$campos_llenar =base64_decode($_GET[datos_a_llenar]);
			$mensaje = "Mensaje no enviado debe llenar los siguientes campos correctamente: $campos_llenar.";			
			$Nombre_AUX 	= base64_decode($_GET[nombre]);
			$Mail_AUX 		= base64_decode($_GET[email]);
			$Comentario_AUX = htmlentities(base64_decode($_GET[comentario]));
		}

		
	}
	include "encabezado.php";
	include "menu.php";
?>
<div id="contenido">
<script src="./jscripts/funciones.js" type="text/javascript" language="javascript">
</script>
<div id="navegacion2"><a href="principal.php">inicio</a> > contacto</div>
<div id="parrafoprincipal"><h1>&nbsp;</h1>

<div id="formulariologin">
<form action="enviar_mail.php" method="post" name="form1" target="_top">
<div class="titulo_cuadro"><span id="noresaltado">contacto administrador</span></div><br />
<p style="margin-left:39px; margin-right:39px; text-align:justify;"> Agradecemos que nos envies información sobre posibles fallos en la página, u opiniones sobre esta, para poder mejorar el proyecto.
Por favor usa el siguiente formulario para contactar con nosotros. Gracias.</p><br />
<div align="center">
 <table border="0" align="center">
    <tr>
      <td valign="bottom"><div align="left"><span class="noresaltado">nombre</span></div></td>
    </tr>
    <tr>
      <td>
        <div align="center">
          <input name="nombre" type="text" id="nombre2" value="<?php echo $Nombre_AUX; ?>" size="37" maxlength="60">
        </div></td>
    </tr>
    <tr>
      <td height="30px" valign="bottom"><div align="left"><span class="noresaltado">e-mail</span></div></td>
    </tr>
    <tr>
      <td>
        <div align="center">
          <input name="email" type="text" id="email" value="<?php echo $Mail_AUX; ?>" size="37" maxlength="60">
        </div></td>
    </tr>
    <tr>
      <td height="30px" valign="bottom"><div align="left"><span class="noresaltado">comentario</span></div></td>
    </tr>
    <tr>
      <td><div align="center">
        <textarea name="comentario" cols="40" rows="10" id="comentario"><?php echo $Comentario_AUX ; ?></textarea>
      </div></td>
    </tr>
    <tr>
      <td  height="30px" valign="bottom">
          
            <div align="left">
              <input name="enviar" type="submit" id="enviar" value="Enviar" onClick="return ValidarEmail(form1.email);">
              </div></td>
    </tr>
  </table>
  </div>
<p style="margin-left:39px; margin-right:39px; text-align:center;"><span class="alerta"><?php echo $mensaje; ?></span></p>
</form>
</div>
</div>
</div>
<?php
	include "pie_pagina.php";	
?>
