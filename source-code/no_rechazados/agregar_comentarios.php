<?php
	include "./librerias/lib_session.inc";
	include "./librerias/lib_db.inc";
	include "./librerias/lib_mensajes.php";
	include "./librerias/operaciones.php";
	if(!validar_session() || $_SESSION['TipoUsuario'] != "A"){
		header("location: login.php");
		exit;
	}
	$mensaje_error = "";
	if(isset($_GET[accion]) && $_GET[accion] == "eliminar"){	
		if(isset($_GET[IdComentario]) && $_GET[IdComentario] != ""){
			$query=<<<QUERY
			UPDATE comentarios set EstadoComentario = 'I' 
			WHERE IdComentario = $_GET[IdComentario]
QUERY;
			$res=actualizar($query); 
			if($res==false){
				$mensaje_error = "Error al eliminar.";
			}else{
				$mensaje_error = "Comentario eliminado correctamente.";
			}
		}
	}

	$_POST[NombreComentario] = trim($_POST[NombreComentario]);
	$_POST[Comentario] = trim($_POST[Comentario]);	
	$_POST[tipocomentario] = trim($_POST[tipocomentario]);
	if(isset($_GET[tipocomentario]) && $_GET[tipocomentario] != "")
		if(isset($_GET[accion]) && $_GET[accion] == "agregar"){	
			if(isset($_POST[NombreComentario]) && $_POST[NombreComentario] != ""){
				if(isset($_POST[Comentario]) && $_POST[Comentario] != ""){
						$_POST[NombreComentario] = caracteres_filtros($_POST[NombreComentario]);
						$_POST[Comentario] = caracteres_filtros($_POST[Comentario]);
						$fecha_hora_actual		= fecha_hora_actual();
						$query=<<<QUERY
						INSERT INTO comentarios (IdComentario, NombreComentario, Comentario, IdForaneo, TipoForaneo, 
						FechaIngresoComentario, EstadoComentario) VALUES ('', '$_POST[NombreComentario]', '$_POST[Comentario]',
						'$_GET[IdForaneo]', '$_GET[TipoForaneo]', '$fecha_hora_actual', 'A');
QUERY;
						$res=insertar($query);
						$destino = "";
						if($_GET[TipoForaneo] == "P") 
							$destino = "detalles_proyecto.php?IdProyecto=$_GET[IdForaneo]";
						else 
							$destino = "detalles_concurso.php?IdConcurso=$_GET[IdForaneo]";
						if($res==false) 
							$mensaje_error = "Error al insertar comentario.";
						else 
							mensajes_exito("Comentario agragado con &eacute;xito.",$destino);
						
				}else $mensaje_error = "Debe agregar Comentario.";		
			}else $mensaje_error = "Debe agregar nombre del autor del comentario.";				
		}
	$_POST[NombreComentario]   	= quitar_caracteres_filtros($_POST[NombreComentario]);   
	$_POST[Comentario]			= quitar_caracteres_filtros($_POST[Comentario]);
	

	$arreglo_tipos_comentario_proyectos = retornar_tipos_comentario_proyectos();
	$arreglo_tipos_comentario_concursos = retornar_tipos_comentario_concursos();
	$arreglo_tipos_comentario_articulos = retornar_tipos_comentario_articulos();
	if(count($arreglo_tipos_comentario_proyectos) <= 0 && count($arreglo_tipos_comentario_concursos) <= 0 && count($arreglo_tipos_comentario_articulos) <= 0){
		mensajes_advertencia("No existen proyectos, concursos y articulos","principal.php");
	}
	
	$reemplazar = "AND (TipoForaneo = 'C' OR TipoForaneo = 'P' OR TipoForaneo = 'A')";
	if ($_POST[tipocomentario]!="")
	{
		$dominio = strstr($_POST[tipocomentario], '{');
		
		$_POST[tipocomentario] = preg_replace("/{(\w+)}/", "", $_POST[tipocomentario]);
		
		if ($dominio=="{PP}")
			$reemplazar = "AND (TipoForaneo = 'P')";
		if ($dominio=="{CC}")
			$reemplazar = "AND (TipoForaneo = 'C')";
		if ($dominio=="{AA}")
			$reemplazar = "AND (TipoForaneo = 'A')";
		if ($dominio=="{P}" || $dominio=="{C}" || $dominio=="{A}")
			$reemplazar = "AND (IdForaneo = $_POST[tipocomentario])";
	}
		
	$query="SELECT * FROM comentarios WHERE EstadoComentario = 'A' {REEMPLAZAR}";
	$query = preg_replace("!{REEMPLAZAR}!", $reemplazar, $query);
	
	$resultado = consultar($query);	
	include "encabezado.php";
	include "menu.php";
?>
<script language="javascript" type="text/javascript" src="jscripts/qTip.js"></script>
<div id="contenido">
<div id="navegacion2"><a href="principal.php">inicio</a> &gt; Actualizar Comentario </div>
<form name="form1" method="post" action="agregar_comentarios.php?accion=agregar">

 <div id="buscador">
  <table border="0" cellspacing="5" cellpadding="2">
    <tr>
      <td>
		  <select name="tipocomentario" id="tipocomentario" onchange="JavaScript: form1.submit();">
		  <option value="">- Filtrar por -</option>
		  <option value="{PP}">Proyectos</option>
		  <option value="{CC}">Concursos</option>
		  <option value="{AA}">Articulos</option>
		<?php
		 while(is_array($arreglo_tipos_comentario_proyectos) && (list($id,$dato)=each($arreglo_tipos_comentario_proyectos))){
		?>
			<option value="<?php echo $id; ?>{P}"><?php echo $dato; ?></option>
		<?php } ?>
		<?php
		 while(is_array($arreglo_tipos_comentario_concursos) && (list($id,$dato)=each($arreglo_tipos_comentario_concursos))){
		?>
			<option value="<?php echo $id; ?>{C}"><?php echo $dato; ?></option>
		<?php } ?>
		<?php
		 while(is_array($arreglo_tipos_comentario_articulos) && (list($id,$dato)=each($arreglo_tipos_comentario_articulos))){
		?>
			<option value="<?php echo $id; ?>{A}"><?php echo $dato; ?></option>
		<?php } ?>
		  </select></td>
      </tr>
  </table>
  </div>

     <div id="parrafoprincipal"><h1>&nbsp;</h1>



  <table>
        <tr>
          
          <td><span class="noresaltado">Autor</span></td>
          <td><span class="noresaltado">Tipo</span></td>
          <td><span class="noresaltado"></span></td>
          <td><span class="noresaltado"></span></td>
        </tr>
<?php
		if(is_array($resultado)){
			while(list($key,$registro)=each($resultado)){    ?>    
        <tr>
          
          <td><?php echo quitar_caracteres_filtros($registro[NombreComentario]); ?></td>
          <td>&nbsp;<?php echo quitar_caracteres_filtros($registro[TipoForaneo]); ?></td>
          <td>&nbsp;<a href="editar_comentarios.php?IdComentario=<?php echo $registro[IdComentario]; ?>" title="editar"><img src="iconos/edit.gif" /></a></td>
          <td>&nbsp;<a href="agregar_comentarios.php?accion=eliminar&IdComentario=<?php echo $registro[IdComentario]; ?>" target="_top" onClick="javascripts: return confirm('¿Deseas realmente eliminar este comentario?.');" title="eliminar"><img src="iconos/delete.gif" /></a></td>
        </tr>
        
<?php
			}
		}
?>        
        
</table>
        
        
        
<?php if($mensaje_error!=""){
echo "<div id=\"mensajeexito2\"><span class=\"alerta\">".$mensaje_error."</span></div>"; 
}
?>
</div>

</form>
</div>
<?php
	include "pie_pagina.php";
?>