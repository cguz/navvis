<?php
	include "./librerias/lib_session.inc";
	include "./librerias/lib_db.inc";
	include "./librerias/operaciones.php";
	include "./librerias/lib_mensajes.php";
	if(!validar_session()){
		header("location: login.php");
		exit;
	}
	$mensaje_error = "";
	$datos_no_llenos = "";	
	if(isset($_GET[accion]) && $_GET[accion] == "agregar"){	
		if(isset($_POST[NombreConcurso]) && $_POST[NombreConcurso] != ""){
			if(isset($_POST[Convocante]) && $_POST[Convocante] != ""){
				if(isset($_POST[Descripcion]) && $_POST[Descripcion] != ""){
				//	if((isset($_POST[Enlace]) && $_POST[Enlace] != "") && (ValidarUrl($_POST[Enlace]))){
						$bandera_enlace = true;
						if(isset($_POST[Enlace]) && $_POST[Enlace] != ""){ 
									if(ValidarUrl($_POST[Enlace])){
										$bandera_enlace = true;
									}else $bandera_enlace = false;
						}
						if($bandera_enlace){
						$_POST[NombreConcurso]	= caracteres_filtros($_POST[NombreConcurso]);
						$_POST[Convocante]   	= caracteres_filtros($_POST[Convocante]);   
						$_POST[Descripcion]		= caracteres_filtros($_POST[Descripcion]);
						$_POST[Enlace]			= caracteres_filtros($_POST[Enlace]);
						$fecha_hora_actual		= fecha_hora_actual();
						$query =<<<QUERY
						INSERT INTO concursos (IdConcurso, NombreConcurso, Convocante, IdDiciplina, IdModalidad,
						FechaEntrega, Descripcion, Enlace, IdUsuario, FechaIngreso, EstadoConcurso)VALUES ('', '$_POST[NombreConcurso]', '$_POST[Convocante]', 
						'$_POST[Diciplina]', '$_POST[Modalidad]', '$_POST[FechaEntrega]', '$_POST[Descripcion]', '$_POST[Enlace]', 
						'$_SESSION[id_usuario_actual]', '$fecha_hora_actual','A')
QUERY;
						$res=insertar($query);
						if($res==false){
							$mensaje_error = $ERROR_INSERTAR_CONCURSO;
						}else{		
							if(isset($_GET[retorno]) && $_GET[retorno] == "editar_eliminar_concurso"){	
								mensajes_exito("Concurso insertado con &eacute;xito.","editar_eliminar_concurso.php");
							}else{
								if(isset($_GET[retorno]) && $_GET[retorno] == "editarproyecto"){
									mensajes_exito("Concurso insertado con &eacute;xito.","editar_proyecto.php?IdConcurso=$res&cadena=$_GET[cadena]&primero=$_GET[primero]&IdProyecto=$_GET[IdProyecto]&ban=$_GET[ban]");
								}
								else{
									mensajes_exito("Concurso insertado con &eacute;xito.","nuevo_concurso.php");
								}
							}							
						}
						}else $datos_no_llenos .= "Direccion web no valida, por favor verifique el campo enlace.";
				//	}else $datos_no_llenos .= "enlace.";
				}else $datos_no_llenos .= "Descripci&oacute;n. \n";
			}else $datos_no_llenos .= "Convocante. \n";
		}else $datos_no_llenos .= "Nombre Concurso. \n";
	}
	
	if($datos_no_llenos != "") $mensaje_error= $LLENAR_LOS_SIG_DATOS.$datos_no_llenos;
	
	$_POST[NombreConcurso]	= quitar_caracteres_filtros($_POST[NombreConcurso]);
	$_POST[Convocante]   	= quitar_caracteres_filtros($_POST[Convocante]);   
	$_POST[Diciplina]		= quitar_caracteres_filtros($_POST[Diciplina]);
	$_POST[Modalidad]		= quitar_caracteres_filtros($_POST[Modalidad]);
	$_POST[FechaEntrega]	= quitar_caracteres_filtros($_POST[FechaEntrega]);
	$_POST[Descripcion]		= quitar_caracteres_filtros($_POST[Descripcion]);
	$_POST[Enlace]			= quitar_caracteres_filtros($_POST[Enlace]);
	
	
	$arreglo_diciplinas = retornar_diciplinas();
	if(count($arreglo_diciplinas) <= 0){
		mensajes_advertencia($NO_HAY_DICIPLINAS,"principal.php");
	}
	$arreglo_modalidades = retornar_modalidades();
	if(count($arreglo_modalidades) <= 0){
		mensajes_advertencia($NO_HAY_MODALIDADES,"principal.php");
	}
	if(isset($_POST[FechaEntrega]) && $_POST[FechaEntrega] != ""){
		$FechaEntrega = $_POST[FechaEntrega];
	}else{
		$FechaEntrega = fecha_actual();
	}
	$completo_get = "";
	if(isset($_GET[retorno]) && $_GET[retorno] != ""){$completo_get .= "&retorno=$_GET[retorno]";}	
	if(isset($_GET[cadena]) && $_GET[cadena] != ""){$completo_get .= "&cadena=$_GET[cadena]";}	
	if(isset($_GET[primero]) && $_GET[primero] != ""){$completo_get .= "&primero=$_GET[primero]";}	
	if(isset($_GET[IdProyecto]) && $_GET[IdProyecto] != ""){$completo_get .= "&IdProyecto=$_GET[IdProyecto]";}	
	if(isset($_GET[ban]) && $_GET[ban] != ""){$completo_get .= "&ban=$_GET[ban]";}	

	include "encabezado.php";
	include "menu.php";
?>
<script language="javascript" type="text/javascript" src="jscripts/qTip.js"></script>
<script src="./jscripts/calendario.js" type="text/javascript" language="javascript">
</script>
<div id="contenido">
<div id="navegacion2"><a href="principal.php">inicio</a> > <a href="editar_eliminar_concurso.php">actualizar convocatoria</a> > nueva convocatoria</div>
<div class="parrafoprincipal">

<h1>Introducir nuevo convocatoria/concurso</h1>
<div class="introducirconcurso">
<form name="formulario" method="post" action="nuevo_concurso.php?accion=agregar<?php echo $completo_get; ?>">

<div class="campotexto">
<span class="noresaltado">Nombre*</span><br />
<input name="NombreConcurso" type="text" size="30" maxlength="60" value="<?php echo $_POST[NombreConcurso]; ?>" class="inputcampotexto">
</div>

<div class="campotexto">
<span class="noresaltado">Convocante*</span><br />
<input name="Convocante" type="text" size="30" maxlength="60" value="<?php echo $_POST[Convocante]; ?>" class="inputcampotexto">
</div>

<div class="campotexto">
<span class="noresaltado">Disciplina*</span><br />
<select name="Diciplina" class="inputcampotexto">
<?php
		while(is_array($arreglo_diciplinas) && (list($Id,$Dato)=each($arreglo_diciplinas))){	
			$seleccion = "";
			if($Id == $_POST[Diciplina]){
				$seleccion = "selected";			
			}
			echo "<option value=\"".$Id."\" $seleccion>".$Dato."</option>";
		}
?>
</select>
</div>
<div class="campotexto">
<span class="noresaltado">Modalidad*</span><br />
<select name="Modalidad" class="inputcampotexto">
<?php
		while(is_array($arreglo_modalidades) && (list($Id,$Dato)=each($arreglo_modalidades))){	
			$seleccion = "";
			if($Id == $_POST[Modalidad]){
				$seleccion = "selected";			
			}
			echo "<option value=\"".$Id."\" $seleccion>".$Dato."</option>";
		}
?>
</select>
</div>
<div class="campotexto">
<span class="noresaltado">Fecha entrega*</span>  <a href="javascript:show_calendar('formulario.FechaEntrega');" onmouseover="window.status='Desplegar Calendario';return true;" onmouseout="window.status='';return true;" title="desplegar calendario"><img src="./imagenes/calendario.gif" border="0" align="absmiddle" alt="Desplegar Calendario"></a><br />
<input name="FechaEntrega" type="text" maxlength="10" value="<?php echo $FechaEntrega; ?>" readonly="true" class="inputcampotexto">
</div>

<div class="campotexto">
<span class="noresaltado">Descripci&oacute;n*</span><br />
<textarea name="Descripcion" class="inputcampotexto"><?php echo $_POST[Descripcion]; ?></textarea>
</div>

<div class="campotexto">
<span class="noresaltado">Enlace</span><br />
<input name="Enlace" type="text" size="30" maxlength="255" value="<?php echo $_POST[Enlace]; ?>" class="inputcampotexto">
</div>

<div class="campotexto">
<input type="submit" name="Submit" value="Agregar Concurso">&nbsp;<span class="noresaltado2">*campos obligatorios</span>
</div>
</form>
<br />
<div align="center"><span class="alerta"><?php echo $mensaje_error; ?></span></div>
</div>
</div>
</div>
<?php
	include "pie_pagina.php";
?>