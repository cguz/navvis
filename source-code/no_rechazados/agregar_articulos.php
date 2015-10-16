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
					INSERT INTO articulos (IdArticulo,TituloArticulo,TextoArticulo,FirmaAutorArticulo,ImagenArticulo,
					EstadoArticulo,FechaIngresoArticulo) 
					VALUES('','$_POST[Titulo]','$_POST[Texto]','$_POST[Firma]','','A','$fecha_hora_actual')
QUERY;
					$res=insertar($query);
					if($res==false){
						$mensaje_error = "Error al insertar art&iacute;culo.";
					}else{
						$IdArticulo = $res;
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
							$extension=strtolower($extension);
							if ( $extension == ".jpg" || $extension == ".png" || $extension == ".jpeg") {	
								if (! copy ($imagen_tmp_name, $ruta_imagen)) {
									mensajes_advertencia("Error al subir los archivos, consulte con el administrador del sistema.","agregar_articulo.php");
								}else{
									guardaJPG($ruta_imagen,"maximoBi", 600,600);
								}
							}
							else
								mensajes_advertencia("Archivo no permitido, verifique que esta ingresando archivos de imagen jpg o png.","agregar_articulos.php");
						}
						
						$query=<<<QUERY
						UPDATE articulos SET ImagenArticulo = '$ruta_imagen'
						WHERE IdArticulo = $IdArticulo
QUERY;
						$res=actualizar($query);
						if($res==false){
							mensajes_advertencia("Error al insertar imagen en el art&iacute;culo, consulte con el administrador del sistema.","agregar_articulos.php");
						}
						$mensaje_error = "Art&iacute;culo ingresado con &eacute;xito.";
						$_POST[Titulo] = "";
						$_POST[Texto] = "";
						$_POST[Firma] = "";
					}
				}else $mensaje_error = "Debe agregar la firma del autor.";
			}else $mensaje_error = "Debe agregar el texto del art&iacute;culo.";
		}else $mensaje_error = "Debe agregar el titulo del art&iacute;culo.";
	}
	
	$_POST[Titulo]			= quitar_caracteres_filtros($_POST[Titulo]);
	$_POST[Texto]   		= quitar_caracteres_filtros($_POST[Texto]);   
	$_POST[Firma]			= quitar_caracteres_filtros($_POST[Firma]);
	
	include "encabezado.php";
	include "menu.php";
?>

<!-- TINY_MCE-->
<script language="javascript"
type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js">
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
<div id="navegacion2"><a href="principal.php">inicio</a> > nuevo art&iacute;culo</div>	

<div class="parrafoprincipal">

<h1>Introducir nuevo artículo</h1>

<div class="introducirarticulo">
<div id="titulo_cuadro"><span id="noresaltado">nuevo articulo</span></div>

<form action="agregar_articulos.php?accion=agregar" method="post" enctype="multipart/form-data" name="form1">



<div class="campotexto">
<span id="noresaltado">T&iacute;tulo</span><br />
<input name="Titulo" type="text" id="Titulo" maxlength="60" class="inputcampotexto" value="<?php echo $_POST[Titulo]; ?>">
</div>

<div class="campotexto">
<span id="noresaltado">Texto</span><br />
<textarea name="Texto" rows="20" class="mceEditor" id="Texto"><?php echo $_POST[Texto]; ?></textarea>
</div>

<div class="campotexto">
<span id="noresaltado">Firma autor</span><br />
<input name="Firma" type="text" id="Firma" maxlength="60" value="<?php echo $_POST[Firma]; ?>" class="inputcampotexto">
</div>

<div class="campotexto">
<span id="noresaltado">Imagen</span><br />
<input name="imagen" type="file" id="imagen" class="inputcampotexto">
</div>


<div class="campotexto">
<input type="submit" name="Submit" value="Guardar" class="boton"><br />
</div>



</form>





<div align="center"><span class="alerta"><?php echo $mensaje_error; ?></span></div>
</div>
</div>
  </div>
<?php
	include "pie_pagina.php";
?>
