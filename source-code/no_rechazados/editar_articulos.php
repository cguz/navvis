<?php
	include "./librerias/lib_session.inc";
	include "./librerias/lib_db.inc";
	include "./librerias/lib_mensajes.php";
	include "./librerias/operaciones.php";
	require_once("./img/guardajpg.php");
	
	if(!validar_session() || $_SESSION['TipoUsuario'] != "A"){
		header("location: login.php");
		exit;
	}
	$mensaje_error = "";
	$_POST[Titulo] = trim($_POST[Titulo]);
	$_POST[Texto] = trim($_POST[Texto]);
	$_POST[Firma] = trim($_POST[Firma]);
	if(isset($_GET[accion]) && $_GET[accion] == "agregar"){	
		if(isset($_POST[Titulo]) && $_POST[Titulo] != ""){
			if(isset($_POST[Texto]) && $_POST[Texto] != ""){
				if(isset($_POST[Firma]) && $_POST[Firma] != ""){
					$_POST[Titulo] = caracteres_filtros($_POST[Titulo]);
					$_POST[Texto] = caracteres_filtros($_POST[Texto]);
					$_POST[Firma] = caracteres_filtros($_POST[Firma]);
					$fecha_hora_actual		= fecha_hora_actual();
					$query=<<<QUERY
					UPDATE articulos SET TituloArticulo = '$_POST[Titulo]',
					TextoArticulo = '$_POST[Texto]', FirmaAutorArticulo ='$_POST[Firma]'
					WHERE IdArticulo = $_GET[IdArticulo]
QUERY;
					$res=actualizar($query);
					if($res==false){
						mensajes_exito("Error al actualizar art&iacute;culo.","editar_eliminar_articulos.php?primero$_GET[primero]");						
					}else{
						$IdArticulo = $_GET[IdArticulo];
						if (!empty($_POST)) {
							while(list($name, $value) = each($_POST)) {
								$$name = $value;
							}
						}
						if (!empty($_FILES)) {
							while(list($name, $value) = each($_FILES)) {
								$nom=$name."_name";
								$$nom=$_FILES[$name]['name'];
								$nom=$name."_type";
								$$nom=$_FILES[$name]['type'];
								$nom=$name."_size";
								$$nom=$_FILES[$name]['size'];
								$nom=$name."_tmp_name";
								$$nom=$_FILES[$name]['tmp_name'];
							}
						}
						///para subir las imagenes				
						$ruta_imagen = "";
						if ($imagen != "none" AND $imagen_size != 0){	
							$extension=substr($imagen_name,strrpos($imagen_name, "."),4);					
							$ruta_imagen = "./img_articulos/imagen_articulo_".$IdArticulo.$extension;
							if ( $extension == ".jpg" || $extension == ".png" || $extension == ".jpeg") {	
								if (! copy ($imagen_tmp_name, $ruta_imagen)) {
									mensajes_advertencia("Error al subir los archivos, consulte con el administrador del sistema.","editar_eliminar_articulos.php?primero$_GET[primero]");
								}else{
									guardaJPG($ruta_imagen,"maximoBi", 600,600);
								}
							}
							else
								mensajes_advertencia("Archivo no permitido, verifique que esta ingresando archivos de imagen jpg o png.","editar_eliminar_articulos.php?primero$_GET[primero]");								
							
								
							$query=<<<QUERY
							UPDATE articulos SET ImagenArticulo = '$ruta_imagen'
							WHERE IdArticulo = $IdArticulo
QUERY;
							$res=actualizar($query);
							if($res==false){
								mensajes_advertencia("Error al insertar imagen en el art&iacute;culo, consulte con el administrador del sistema.","editar_eliminar_articulos.php?primero$_GET[primero]");
							}
						}						
		
						mensajes_exito("Art&iacute;culo ingresado con &eacute;xito.","editar_eliminar_articulos.php?primero$_GET[primero]");						
					}
				}else $mensaje_error = "Debe agregar la firma del autor.";
			}else $mensaje_error = "Debe agregar el texto del art&iacute;culo.";
		}else $mensaje_error = "Debe agregar el titulo del art&iacute;culo.";
	}else{
		$query=<<<QUERY
		SELECT * FROM articulos WHERE EstadoArticulo = 'A'
		AND IdArticulo = $_GET[IdArticulo]
		LIMIT 1
QUERY;
		$res2 = consultar($query);
		if(is_array($res2) && (list($Id,$Dato) = each($res2))){
			$_POST[Titulo] = $Dato[TituloArticulo];
			$_POST[Texto] =  $Dato[TextoArticulo];
			$_POST[Firma] = $Dato[FirmaAutorArticulo];
			$_POST[Imagen] = $Dato[ImagenArticulo];
		}else{
			mensajes_advertencia("No hay informaci&oacute;n que mostrar.","editar_eliminar_articulos.php");
		}
	}
	
	$_POST[Titulo]			= quitar_caracteres_filtros($_POST[Titulo]);
	$_POST[Texto]   		= quitar_caracteres_filtros($_POST[Texto]);   
	$_POST[Firma]			= quitar_caracteres_filtros($_POST[Firma]);
	
	include "encabezado.php";
	include "menu.php";
?>
<script language="javascript" type="text/javascript" src="jscripts/qTip.js"></script>
<!-- TINY_MCE-->
<script language="javascript" type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js">
</script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
mode : "textareas",
theme : "simple",
content_css : "example_advanced.css",
editor_selector : "mceEditor",
editor_deselector : "mceNoEditor"

});
</script>
<!-- TINY_MCE-->

<div id="contenido">
<div id="navegacion2"><a href="principal.php">inicio</a> &gt; <a href="editar_eliminar_articulos.php">actualizar art&iacute;culos</a> &gt; editar art&iacute;culo</div>

<div class="parrafoprincipal">

<h1>Editar artículo</h1>

<div class="introducirarticulo">
<div id="titulo_cuadro"><span id="noresaltado">editar art&iacute;culo</span></div>

<form action="editar_articulos.php?accion=agregar&IdArticulo=<?php echo $_GET[IdArticulo]; ?>&primero=<?php echo $_GET[primero]; ?>" method="post" enctype="multipart/form-data" name="form1">
  <input name="Imagen" type="hidden" value="<?php echo $_POST[Imagen]; ?>">


<?php echo $mensaje_error; ?>



<div class="campotexto">
<span id="noresaltado">Titulo</span><br />
<input name="Titulo" type="text" id="Titulo" size="30" maxlength="60" value="<?php echo $_POST[Titulo]; ?>" class="inputcampotexto">
</div>


<div class="campotexto">
<span id="noresaltado">Texto</span><br />
<textarea name="Texto" rows="18" class="mceEditor" id="Texto"><?php echo $_POST[Texto]; ?></textarea>
</div>


<div class="campotexto">            
<span id="noresaltado">Firma autor</span><br />
<input name="Firma" type="text" id="Firma" size="30" maxlength="60" value="<?php echo $_POST[Firma]; ?>">
</div>


<div class="campotexto">
<span id="noresaltado">Imagen</span><br />
<a href="<?php echo $_POST[Imagen]; ?>" target="_blank"><img src="img/img.php?ancho=150&alto=120&cut&mark=false&file=.<?php echo $_POST[Imagen]; ?>" width="100"></a>
<span class="noresaltado2">(Para cambiar la imagen, seleccione y suba otro archivo de imagen)</span>
</div>



<input name="imagen" type="file" id="imagen" size="30">


<input type="submit" name="Submit" value="Guardar">

<div align="center"><span class="alerta"><?php echo $mensaje_error; ?></span></div>


</form>
</div>
</div>
</div>
<?php
	include "pie_pagina.php";
?>
