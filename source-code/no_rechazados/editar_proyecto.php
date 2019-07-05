<?php
	include "./librerias/lib_session.inc";
	include "./librerias/lib_db.inc";
	include "./librerias/lib_mensajes.php";
	include "./librerias/operaciones.php";
	require_once("./img/guardajpg.php");
	
	if(!validar_session()){
		header("location: login.php");
		exit;
	}
	$campo_where = "";
	if($_SESSION['TipoUsuario'] != 'A'){
		$campo_where .= " AND proyectos.IdUsuario = $_SESSION[id_usuario_actual]";
	}
	
	if(isset($_GET[IdConcurso]) && ($_GET[IdConcurso] != "")){		
		$query =<<<QUERY
		SELECT * FROM concursos WHERE EstadoConcurso = 'A' 
		AND IdConcurso = $_GET[IdConcurso]
QUERY;
		$res=consultar($query);
		if(is_array($res) && (list($Id,$Dato) = each($res))){
			$IdConcurso = $Dato[IdConcurso];
			$NombreConcurso = quitar_caracteres_filtros($Dato[NombreConcurso]);
			$Descripcion = quitar_caracteres_filtros($Dato[Descripcion]);
		}else{
			$IdConcurso = "";
			$NombreConcurso = "";
			$Descripcion = "";
		}
	}
	$cadena=$_GET[cadena];	
	$primero=$_GET[primero];
	$IdProyecto=$_GET[IdProyecto];
	
	$mensaje_error = "";
	$datos_no_llenos = "";	
	if(isset($_GET[accion]) && ($_GET[accion] == "actualizar")){
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
		
		if(isset($_POST[NombreProyecto]) && $_POST[NombreProyecto] != ""){
			if(isset($_POST[texto]) && $_POST[texto] != ""){
				//if(isset($_POST[enlace]) && $_POST[enlace] != ""){			
          $bandera_enlace = true;
          if(isset($_POST[enlace]) && $_POST[enlace] != ""){ 
						 if(ValidarUrl($_POST[enlace])){
			          $bandera_enlace = true;
		         }else $bandera_enlace = false;
      		}
          if($bandera_enlace){		
					$fecha_hora_actual		= fecha_hora_actual();					
					$_POST[NombreProyecto]	= caracteres_filtros($_POST[NombreProyecto]);
					$_POST[texto]   	= caracteres_filtros($_POST[texto]);   
					$_POST[enlace]			= caracteres_filtros($_POST[enlace]);						
					$query=<<<QUERY
					UPDATE proyectos set NombreProyecto = '$_POST[NombreProyecto]', IdConcurso = '$_POST[IdConcurso]', 
					Texto = '$_POST[texto]', Enlace = '$_POST[enlace]' WHERE IdProyecto = $IdProyecto
					AND EstadoProyecto = 'A' $campo_where
QUERY;
					$res=actualizar($query);
					if($res==false){
						mensajes_advertencia("Error al actualizar proyecto, consulte con el administrador del sistema.","editar_eliminar_proyectos.php?cadena=$cadena&primero=$primero&IdProyecto=$IdProyecto&ban=get");
					}
					
					///para subir los archivos y las imagenes			
													
					$ruta_imagen = $_POST[imagen_vieja];
					$ComentarioImagen=quitar_caracteres_filtros($_POST[ComentarioImagen]);
					if ($imagen != "none" AND $imagen_size != 0){	
						$extension=substr($imagen_name,strrpos($imagen_name, "."),4);			
						$ruta_imagen = "./img_proyectos/imagen_proyecto_".$IdProyecto.$extension;
						$extension=strtolower($extension);
						if ( $extension == ".jpg" || $extension == ".png" || $extension == ".jpeg") {	
							if(file_exists ($ruta_imagen)){
								unlink ($ruta_imagen);
							}else{
								if (! copy ($imagen_tmp_name, $ruta_imagen)) {
									mensajes_advertencia("Error al subir los archivos, consulte con el administrador del sistema.","editar_eliminar_proyectos.php?cadena=$cadena&primero=$primero&IdProyecto=$IdProyecto&ban=get");
								}else{
									guardaJPG($ruta_imagen,"maximoBi", 450,450);
								}
							}
						}else
							mensajes_advertencia("Archivo no permitido, verifique que esta ingresando archivos de imagen jpg o png.","editar_proyecto.php?cadena=$cadena&primero=$primero&IdProyecto=$IdProyecto&ban=get");
					}
					//---------------------------------
					$ruta_imagen2 = $_POST[imagen2_vieja];
					$ComentarioImagen2=quitar_caracteres_filtros($_POST[ComentarioImagen2]);
					if ($imagen2 != "none" AND $imagen2_size != 0){	
						$extension=substr($imagen2_name,strrpos($imagen2_name, "."),4);					
						$ruta_imagen2 = "./img_proyectos/imagen2_proyecto_".$IdProyecto.$extension;
						$extension=strtolower($extension);
						if ( $extension == ".jpg" || $extension == ".png" || $extension == ".jpeg") {	
							if(file_exists ($ruta_imagen2)){
								unlink ($ruta_imagen2);
							}else{
								if (! copy ($imagen2_tmp_name, $ruta_imagen2)) {
									mensajes_advertencia("Error al subir los archivos, consulte con el administrador del sistema.","editar_eliminar_proyectos.php?cadena=$cadena&primero=$primero&IdProyecto=$IdProyecto&ban=get");
								}else{
									guardaJPG($ruta_imagen2,"maximoBi", 450,450);
								}
							}
						}else
							mensajes_advertencia("Archivo no permitido, verifique que esta ingresando archivos de imagen jpg o png.","editar_proyecto.php?cadena=$cadena&primero=$primero&IdProyecto=$IdProyecto&ban=get");
					}
					
					$ruta_imagen3 = $_POST[imagen3_vieja];
					$ComentarioImagen3=quitar_caracteres_filtros($_POST[ComentarioImagen3]);
					if ($imagen3 != "none" AND $imagen3_size != 0){	
						$extension=substr($imagen3_name,strrpos($imagen3_name, "."),4);					
						$ruta_imagen3 = "./img_proyectos/imagen3_proyecto_".$IdProyecto.$extension;
						$extension=strtolower($extension);
						if ( $extension == ".jpg" || $extension == ".png" || $extension == ".jpeg") {	
							if(file_exists ($ruta_imagen3)){
								unlink ($ruta_imagen3);
							}else{
								if (! copy ($imagen3_tmp_name, $ruta_imagen3)) {
									mensajes_advertencia("Error al subir los archivos, consulte con el administrador del sistema.","editar_eliminar_proyectos.php?cadena=$cadena&primero=$primero&IdProyecto=$IdProyecto&ban=get");
								}else{
									guardaJPG($ruta_imagen3,"maximoBi", 450,450);
								}
							}
						}else
							mensajes_advertencia("Archivo no permitido, verifique que esta ingresando archivos de imagen jpg o png.","editar_proyecto.php?cadena=$cadena&primero=$primero&IdProyecto=$IdProyecto&ban=get");
						
					}
					//---------------------------------
					
					if ($ruta_imagen=="")
						$ComentarioImagen="";
					if ($ruta_imagen2=="")
						$ComentarioImagen2="";
					if ($ruta_imagen3=="")
						$ComentarioImagen3="";
			
					$query=<<<QUERY
					UPDATE proyectos SET Imagen = '$ruta_imagen',
					Imagen2 = '$ruta_imagen2', ComentarioImagen='$ComentarioImagen', ComentarioImagen2='$ComentarioImagen2', ComentarioImagen3='$ComentarioImagen3', Imagen3 = '$ruta_imagen3'
					WHERE IdProyecto = $IdProyecto
QUERY;
					$res=actualizar($query);
					if($res==false){
						mensajes_advertencia("Error al insertar imagen en el proyecto, consulte con el administrador del sistema.","nuevo_proyecto_1.php");
					}
					
					$query =<<<QUERY
							SELECT Imagen, Imagen2, Imagen3 FROM proyectos WHERE IdProyecto=$IdProyecto 
QUERY;
					$res_ar=consultar($query);
							
					//------ Esto elimina las imagenes si activan la casilla
					if(isset($_POST["EImagen1"]) && $_POST["EImagen1"] != ""){
						$query=<<<QUERY
						UPDATE proyectos SET Imagen = '', ComentarioImagen=''
						WHERE IdProyecto = $IdProyecto
QUERY;
						$res=actualizar($query);
						if($res==true)
						{
							if(is_array($res_ar) && (list($Id,$Dato1) = each($res_ar))){
								$Archivo = $Dato1[Imagen];
								$borrad=borrar_Archivo($Archivo);
							}
						}
						
						if($res==false){
							mensajes_advertencia("Error al insertar imagen en el proyecto, consulte con el administrador del sistema.","nuevo_proyecto_1.php");
						}						
					}
					if(isset($_POST["EImagen2"]) && $_POST["EImagen2"] != ""){
						$query=<<<QUERY
						UPDATE proyectos SET Imagen2 = '', ComentarioImagen2=''
						WHERE IdProyecto = $IdProyecto
QUERY;
						$res=actualizar($query);
						
						if($res==true)
						{
							if(is_array($res_ar) && (list($Id,$Dato1) = each($res_ar))){
								$Archivo = $Dato1[Imagen2];
								$borrad=borrar_Archivo($Archivo);
							}
						}
						
						if($res==false){
							mensajes_advertencia("Error al insertar imagen en el proyecto, consulte con el administrador del sistema.","nuevo_proyecto_1.php");
						}						
					}	
					if(isset($_POST["EImagen3"]) && $_POST["EImagen3"] != ""){
						$query=<<<QUERY
						UPDATE proyectos SET Imagen3 = '', ComentarioImagen3=''
						WHERE IdProyecto = $IdProyecto
QUERY;
						$res=actualizar($query);
						
						if($res==true)
						{
							if(is_array($res_ar) && (list($Id,$Dato1) = each($res_ar))){
								$Archivo = $Dato1[Imagen3];
								$borrad=borrar_Archivo($Archivo);
							}
						}
						
						if($res==false){
							mensajes_advertencia("Error al insertar imagen en el proyecto, consulte con el administrador del sistema.","nuevo_proyecto_1.php");
						}						
					}
					//----------------------------------
					$query=<<<QUERY
					SELECT * FROM adjuntosproyectos WHERE IdProyecto = $IdProyecto AND EstadoAdjunto = 'A'
					ORDER BY IdAdjunto DESC
QUERY;
					$res_ad=consultar($query);
					while(is_array($res_ad) && (list($ID,$DATO)=each($res_ad))){
						$IdAdjunto = $DATO[IdAdjunto];
						$cad_iden = "E".$IdAdjunto;
						if(isset($_POST["$cad_iden"]) && $_POST["$cad_iden"] != ""){
							$query=<<<QUERY
							UPDATE adjuntosproyectos set EstadoAdjunto = 'I'
							WHERE IdAdjunto = $IdAdjunto
QUERY;
							$res=actualizar($query);
							
							if($res==true)
							{
								$query =<<<QUERY
								SELECT Archivo FROM adjuntosproyectos WHERE IdAdjunto=$IdAdjunto AND EstadoAdjunto = 'I' 
QUERY;
								$res_ar=consultar($query);
								//$borrad="hola ..$res_ar";
								if(is_array($res_ar) && (list($Id,$Dato1) = each($res_ar))){
									$Archivo = $Dato1[Archivo];
									$borrad=borrar_Archivo($Archivo);
								}
							}

							if($res==false){
								mensajes_advertencia("Error al actualizar proyecto, consulte con el administrador del sistema.","editar_eliminar_proyectos.php?cadena=$cadena&primero=$primero&IdProyecto=$IdProyecto&ban=get");
							}
							
						}
						
					}
					for($i=1;$i<=$CArchivos;$i++){
						$nom_archi 		= "archivos".$i;
						$nom_archi_name = "archivos".$i."_name";
						$nom_archi_size = "archivos".$i."_size";
						$nom_archi_tmp_name = "archivos".$i."_tmp_name";						
						if ($$nom_archi != "none" AND $$nom_archi_size != 0){	
							$extension=substr($$nom_archi_name,strrpos($$nom_archi_name, "."),4);					
							$nombre_adjunto = "./adj_proyectos/proyecto_".$IdProyecto.$$nom_archi_name;
							$extension=strtolower($extension);
							if ( $extension == ".pdf" || $extension == ".doc" || $extension == ".xdoc") {	
								if(file_exists ($nombre_adjunto)){
									unlink ($nombre_adjunto);
								}
								if (! copy ($$nom_archi_tmp_name, $nombre_adjunto)) {
									mensajes_advertencia("Error al subir los archivos, consulte con el administrador del sistema.","editar_eliminar_proyectos.php?cadena=$cadena&primero=$primero&IdProyecto=$IdProyecto&ban=get");
								}
		
								$query=<<<QUERY
								SELECT * FROM adjuntosproyectos WHERE Archivo = '$nombre_adjunto' AND EstadoAdjunto = 'A'
QUERY;
								$res_c=consultar($query);
								if(is_array($res_c) && (count($res_c)>0)){
									
								}else{
									$query=<<<QUERY
									INSERT INTO adjuntosproyectos (IdAdjunto, IdProyecto, Archivo, EstadoAdjunto)
									VALUES ('','$IdProyecto', '$nombre_adjunto', 'A')
QUERY;
									$res=insertar($query);
									if($res==false){
										mensajes_advertencia("Error al insertar archivo adjunto en el proyecto, consulte con el administrador del sistema.","editar_eliminar_proyectos.php?cadena=$cadena&primero=$primero&IdProyecto=$IdProyecto&ban=get");
									}
								}
							}else
								mensajes_advertencia("Archivo no permitido, solo se permiten archivos de tipo doc o pdf.","editar_proyecto.php?cadena=$cadena&primero=$primero&IdProyecto=$IdProyecto&ban=get");
						}
					}
					mensajes_exito("Proyecto insertado con &eacute;xito.","editar_eliminar_proyectos.php?cadena=$cadena&primero=$primero&IdProyecto=$IdProyecto&ban=get");
					}else $datos_no_llenos .= "Direccion web no valida, por favor verifique el campo enlace.";
				//}else $datos_no_llenos .= "enlace.";
			}else $datos_no_llenos .= "Texto.";
		}else $datos_no_llenos .= "Nombre Proyecto.";
		if($datos_no_llenos != "") $mensaje_error= $LLENAR_LOS_SIG_DATOS.$datos_no_llenos;		
		
		$IdConcurso		= $_POST[IdConcurso];
		$imagen_vieja 	= $_POST[imagen_vieja];
		$imagen2_vieja 	= $_POST[imagen2_vieja];
		$imagen3_vieja 	= $_POST[imagen3_vieja];
		$ComentarioImagen= quitar_caracteres_filtros($_POST[ComentarioImagen]);
		$ComentarioImagen2= quitar_caracteres_filtros($_POST[ComentarioImagen2]);
		$ComentarioImagen3= quitar_caracteres_filtros($_POST[ComentarioImagen3]);
		$NombreProyecto	= quitar_caracteres_filtros($_POST[NombreProyecto]);
		$texto   		= htmlentities($_POST[texto]);   
		$enlace			= quitar_caracteres_filtros($_POST[enlace]);
		$NombreConcurso	= quitar_caracteres_filtros($_POST[NombreConcurso]);   
		$Descripcion	= quitar_caracteres_filtros($_POST[Descripcion]);
	}else{
		$query =<<<QUERY
		SELECT *, proyectos.Enlace as EnlaceP FROM proyectos, concursos 
		WHERE proyectos.IdConcurso = concursos.IdConcurso
		AND EstadoProyecto = 'A' AND IdProyecto = $IdProyecto $campo_where	
		ORDER BY IdProyecto DESC		
QUERY;
		$res_p=consultar($query);
		if(is_array($res_p) && (list($Id,$Dato)=each($res_p))){ 
			if(!isset($IdConcurso))  $IdConcurso		= $Dato[IdConcurso];
			if(!isset($NombreConcurso))  $NombreConcurso	= quitar_caracteres_filtros($Dato[NombreConcurso]);
			if(!isset($Descripcion)) $Descripcion	= quitar_caracteres_filtros($Dato[Descripcion]);
			
			$NombreProyecto	= quitar_caracteres_filtros($Dato[NombreProyecto]);			
			$enlace			= quitar_caracteres_filtros($Dato[EnlaceP]);
			$texto   		= htmlentities($Dato[Texto]);
			$imagen_vieja	= $Dato[Imagen];
			$imagen2_vieja	= $Dato[Imagen2];
			$imagen3_vieja	= $Dato[Imagen3];
			$ComentarioImagen= quitar_caracteres_filtros($Dato[ComentarioImagen]);
			$ComentarioImagen2= quitar_caracteres_filtros($Dato[ComentarioImagen2]);
			$ComentarioImagen3= quitar_caracteres_filtros($Dato[ComentarioImagen3]);
		}
	}	

	$query=<<<QUERY
	SELECT * FROM adjuntosproyectos WHERE IdProyecto = $IdProyecto AND EstadoAdjunto = 'A'
	ORDER BY IdAdjunto DESC
QUERY;
	$res_ad=consultar($query);
	if(is_array($res_ad)) $CArchivos = count($res_ad)+1;
	include "encabezado.php";
	include "menu.php";
?>
<script language="javascript" type="text/javascript" src="jscripts/qTip.js"></script>
<script language="javascript" type="text/javascript" src="./jscripts/funciones.js"></script>
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
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

<div id="contenido">







<div id="navegacion2"><a href="principal.php">inicio</a> > <a href="editar_eliminar_proyectos.php">actualizar proyectos</a> &gt; editar proyecto</div>

<div class="parrafoprincipal">
<h1>editar proyecto</h1>

<div class="introducirarticulo">


<form action="editar_proyecto.php?accion=actualizar&cadena=<?php echo $cadena; ?>&primero=<?php echo $primero; ?>&IdProyecto=<?php echo $IdProyecto; ?>&ban=get" method="post" enctype="multipart/form-data" name="formulario">
<input type="hidden" name="IdConcurso" id="IdConcurso" value="<?php echo $IdConcurso; ?>">
<input type="hidden" name="Descripcion" id="Descripcion" value="<?php echo $Descripcion; ?>">
<input type="hidden" name="imagen_vieja" id="imagen_vieja" value="<?php echo $imagen_vieja; ?>">
<input type="hidden" name="imagen2_vieja" id="imagen_vieja" value="<?php echo $imagen2_vieja; ?>">
<input type="hidden" name="imagen3_vieja" id="imagen_vieja" value="<?php echo $imagen3_vieja; ?>">
<input type="hidden" name="CArchivos" id="CArchivos" value="<?php echo $CArchivos; ?>">

<?php echo $mensaje_error; ?>

<div class="campotexto">
<span id="noresaltado">Título proyecto</span><br />
<input name="NombreProyecto" type="text" value="<?php echo $NombreProyecto; ?>" size="30" maxlength="60" class="inputcampotexto">
</div>

<div class="campotexto">
<span id="noresaltado">Concurso&nbsp;</span>

<a href="#" onmouseover="window.status='Mostrar Concursos';return true;" onmouseout="window.status='';return true;"  onClick="javascript: retornar_concursos_ep('NombreConcurso','Descripcion','IdConcurso');" title="buscar otra convocatoria"><img src="./imagenes/vineta_submenu.gif" ></a>&nbsp;

<a href="nuevo_concurso.php?retorno=editarproyecto&cadena=<?php echo $cadena; ?>&primero=<?php echo $primero; ?>&IdProyecto=<?php echo $IdProyecto; ?>&ban=get" title="nuevo concurso"><img src="imagenes/nuevo_concurso.gif" /></a><br />

<input name="NombreConcurso" type="text" id="NombreConcurso" size="30" maxlength="80" readonly="true" value="<?php echo $NombreConcurso; ?>" class="inputcampotexto">


</div>

<div class="campotexto">
<span id="noresaltado">Texto</span><br />
<textarea name="texto" rows="20" class="mceEditor" id="texto"><?php echo $texto; ?></textarea>
</div>

<div class="campotexto">
<span id="noresaltado">Enlace web</span>&nbsp;&nbsp;<a href="#" onclick="MM_openBrWindow('ayuda/ayudaalojamiento.html','ayuda','scrollbars=yes,width=400,height=700')" title="donde alojar tu proyecto"><img src="imagenes/info.gif" /></a><br />
<input name="enlace" type="text" value="<?php echo $enlace; ?>" size="30" maxlength="60" class="inputcampotexto"> 
</div>

<div class="campotexto">
<span id="noresaltado">Imagenes y archivos adjuntos</span><br />
<div class="campotexto">
<!-- Imagen 1 -->
<table width="0%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="105">
    <?php if(trim($imagen_vieja) != ""){ ?>
   
    <a href="<?php echo $imagen_vieja; ?>" target="_blank"><img src="img/img.php?ancho=150&alto=120&cut=false&mark=false&file=.<?php echo $imagen_vieja; ?>" width="100" border="0"></a></td>
    <td width="430" valign="bottom">
        <span id="noresaltado">
        <input name="EImagen1" type="checkbox" id="EImagen1" value="SI" />
        Eliminar</span><br />
        &nbsp;<span class="noresaltado2">(Para reemplazar seleccione y suba otra imagen)</span><br />
	
	<?php }
	else {
	?>
    <img src="imagenes/sinimagen1.png" width="100" border="0">    </td>
	<td width="430" valign="bottom">
	<?php
    }
	?>

        <input name="imagen" type="file" size="30" />
        <br /> Descripcion
<input name="ComentarioImagen" type="text" size="30" value="<?php echo $ComentarioImagen; ?>" ><br />
   </td>
  </tr>
</table>
</div>

<div class="campotexto">
<!-- Imagen 2 -->
<table width="0%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="105">
    <?php if(trim($imagen2_vieja) != ""){ ?>
   
    <a href="<?php echo $imagen2_vieja; ?>" target="_blank"><img src="img/img.php?ancho=150&alto=120&cut=false&mark=false&file=.<?php echo $imagen2_vieja; ?>" width="100" border="0"></a></td>
    <td width="430" valign="bottom">
        <p><span id="noresaltado">
          <input name="EImagen2" type="checkbox" id="EImagen2" value="SI" />
          Eliminar<br />
        </span><span class="noresaltado2">(Para reemplazar seleccione y suba otra imagen)</span><br />
          
              <?php }
	else {
	?>
              <img src="imagenes/sinimagen2.png" width="100" border="0">    </p>
        </td>
	<td width="430" valign="bottom">
	<?php
    }
	?>


        <input name="imagen2" type="file" size="30" />
       <br /> Descripcion
<input name="ComentarioImagen2" type="text" size="30" value="<?php echo $ComentarioImagen2; ?>" ><br />    </td>
  </tr>
</table>
</div>


<!--
<div class="campotexto">

<?php if(trim($imagen2_vieja) != ""){ ?>

<a href="<?php echo $imagen2_vieja; ?>" target="_blank"><img src="img/img.php?ancho=150&alto=120&cut=false&mark=false&file=.<?php echo $imagen2_vieja; ?>" width="100" border="0"></a>
<input name="EImagen2" type="checkbox" id="EImagen2" value="SI">
<span id="noresaltado">Eliminar (Para reemplazar seleccione y suba otra imagen)</span><br />

<?Php } ?>

<span id="noresaltado">Imagen2&nbsp;</span>
<input name="imagen2" type="file" size="30"><br />
</div>
-->

<div class="campotexto">
<!-- Imagen 3 -->
<table width="0%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="105">
    <?php if(trim($imagen3_vieja) != ""){ ?>
   
    <a href="<?php echo $imagen3_vieja; ?>" target="_blank"><img src="img/img.php?ancho=150&alto=120&cut=false&mark=false&file=.<?php echo $imagen3_vieja; ?>" width="100" border="0"></a></td>
    <td width="430" valign="bottom">
        <p><span id="noresaltado">
          <input name="EImagen3" type="checkbox" id="EImagen3" value="SI" />
          Eliminar<br />
        </span><span class="noresaltado2">(Para reemplazar seleccione y suba otra imagen)</span><br />
          
              <?php }
	else {
	?>
              <img src="imagenes/sinimagen3.png" width="100" border="0">    </p>
        </td>
	<td width="430" valign="bottom">
	<?php
    }
	?>


        <input name="imagen3" type="file" size="30" />
        <br /> Descripcion
<input name="ComentarioImagen3" type="text" size="30" value="<?php echo $ComentarioImagen3; ?>" ><br />    </td>
  </tr>
</table>
<span class="noresaltado2">Sólo se aceptan archivos de imagenes en jpg o png, con un tamaño máximo de 500kb.</span>
</div>

<!-- 
<div class="campotexto">

<?php if(trim($imagen3_vieja) != ""){ ?>

<a href="<?php echo $imagen3_vieja; ?>" target="_blank"><img src="<?php echo $imagen3_vieja; ?>" width="100" border="0"></a>
<input name="EImagen3" type="checkbox" id="EImagen3" value="SI">
<span id="noresaltado">Eliminar (Para reemplazar seleccione y suba otra imagen)</span><br />
<?Php } ?>

<span id="noresaltado">Imagen3&nbsp;</span>
<input name="imagen3" type="file" size="30"><br />
</div>
<input name="agregar" type="button" id="agregar" value="Agregar Archivo" onClick="javascript: cambio2();">
-->




<div class="campotexto">
<?php
if (is_array($res_ad) && count($res_ad)>0){
?>
<span id="noresaltado">Eliminar archivo</span>
	
<?php 
	}
	while (list($ID,$DATO)=each($res_ad)){
?>

<input type="checkbox" name="E<?php echo $DATO[IdAdjunto]; ?>" value="<?php echo $DATO[IdAdjunto]; ?>"><br />


<a href="<?php echo $DATO[Archivo]; ?>" target="_blank" title="descargar archivo"><?php echo $DATO[Archivo]; ?></a><br />
<?php }?>


<span id="noresaltado">Archivo</span>
<input name="archivos1" type="file" size="30" id="archivos1">    <br />  
<span class="noresaltado2">Sólo se aceptan archivos en formato pdf o word, con un tamaño máximo de 500kb.</span>
</div>


<input type="submit" name="Submit" value="Actualizar" onClick="return validar(formulario);" class="inputcampotexto">
      


<div align="center"><span class="alerta"><?php echo $mensaje_error; ?></span></div>
</div>
</form>
</div>
</div>
</div>
<?php
	include "pie_pagina.php";
?>
