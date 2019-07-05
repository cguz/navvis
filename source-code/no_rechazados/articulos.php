<?php
	include "./librerias/lib_session.inc";
	include "./librerias/lib_db.inc";
	include "./librerias/lib_mensajes.php";
	include "./librerias/operaciones.php";
	$ITEMS_CONSULTAS = 10;	
	$primero = $_GET[primero];	
	if (strlen($primero) == 0){$primero=0;}
	$ultimo = $ITEMS_CONSULTAS + 1;
	$completo = "ORDER BY IdArticulo DESC";
	if(isset($_GET[IdArticulo]) && $_GET[IdArticulo] != ""){	
		$completo = "AND IdArticulo = $_GET[IdArticulo]";		
	}
	
	$query=<<<QUERY
	SELECT * FROM articulos WHERE EstadoArticulo = 'A'
	$completo
	LIMIT 1
QUERY;
	$res2 = consultar($query);
	$Titulo = "";
	$TextoArticulo = "";
	$FirmaAutorArticulo = "";
	$Imagen = "";
	$IdArticulo = "";
	if(is_array($res2) && (list($Id,$Dato) = each($res2))){
		$Titulo = quitar_caracteres_filtros($Dato[TituloArticulo]);
		$IdArticulo = quitar_caracteres_filtros($Dato[IdArticulo]);
		$TextoArticulo = stripslashes($Dato[TextoArticulo]);
		$FirmaAutorArticulo = quitar_caracteres_filtros($Dato[FirmaAutorArticulo]);
		$FechaIngresoArticulo = substr($Dato[FechaIngresoArticulo ],0,10);
		$Imagen = $Dato[ImagenArticulo];
	}else{
		mensajes_advertencia("No hay informaci&oacute;n que mostrar.","principal.php");
	}
	$query=<<<QUERY
	SELECT * FROM articulos WHERE EstadoArticulo = 'A'
	ORDER BY FechaIngresoArticulo DESC
	LIMIT $primero,$ultimo
QUERY;
	$res = consultar($query);
	
	$query =<<<QUERY
	SELECT * FROM comentarios 
	WHERE IdForaneo = $_GET[IdArticulo] AND TipoForaneo = 'A' AND EstadoComentario = 'A'
	ORDER BY IdComentario DESC
QUERY;
	$res_com = consultar($query);
	
	include "encabezado.php";
	include "menu.php";
?>

<script language="javascript" type="text/javascript" src="jscripts/qTip.js"></script>
<script language="javascript" type="text/javascript" src="./jscripts/funciones.js"></script>

<div id="contenido">
<div id="navegacion2"><a href="principal.php">inicio</a> > articulos</div>
<div id="lista_articulo">
  <div id="titulo_cuadro"><span id="noresaltado">art&iacute;culos anteriores</span></div>
  <ul>
  
  <?php 
    $cont = 0;
    $total_items = count($res);
    while(is_array($res) && (list($Id,$Dato) = each($res)) && ($cont < $ultimo - 1)){
    $cont ++;
    ?>
    
  <li>  <a href="articulos.php?primero=<?php echo $primero; ?>&IdArticulo=<?php echo $Dato[IdArticulo]; ?>" target="_top"><?php echo $Dato[TituloArticulo];?></a><br />
<span class="noresaltado"><?php echo "".fecha_espenol(substr($Dato[FechaIngresoArticulo ],0,10)).""; ?></span> <br />
   </li> 
	<?php } ?>
    </ul>

         <div align="center">
        <table width="100%" border="0">
    <tr>
              <td width="50%"><div align="right">
<?php 
		$cadena=base64_encode($cadena);		
		if ($primero > 0){
			$anterior=$primero - $ITEMS_CONSULTAS;
			echo "<a href=\"articulos.php?primero=$anterior\" title=\"art&iacute;culos anteriores\"><img src=\"iconos/left.gif\" \></a>";
		}else{echo "&nbsp;";}           
?>
			  
			  </div></td>
              <td width="50%"><div align="left">
			  
<?php 
		if ($total_items > $ITEMS_CONSULTAS){
			$siguiente=$primero + $ITEMS_CONSULTAS;
			echo "<a href=\"articulos.php?primero=$siguiente\" title=\"art&iacute;culos posteriores\"><img src=\"iconos/right.gif\" \></a>";
		}else{echo "&nbsp;";}           
?>			  
</div></td>
            </tr>
      </table>
    </div>

    
</div>
<div class="parrafoprincipal2">
<h1><?php echo $Titulo; ?> <span class="noresaltado">&nbsp;(<?php echo fecha_espenol($FechaIngresoArticulo); ?>)</span></h1>

<a href="JavaScript: abrir_imagen('<?php echo $Imagen; ?>','')"><img src="img/img.php?ancho=150&alto=120&cut=false&mark=false&file=.<?php echo $Imagen; ?>" width="200" class="imgizquierda"/></a>
<?php echo $TextoArticulo; ?>
<p><span class="noresaltado">Por:</span> <?php echo $FirmaAutorArticulo; ?> (<?php echo fecha_espenol($FechaIngresoArticulo); ?>)</p>
<p><img src="imagenes/comment.png" />&nbsp;<a class="comentario" href="nuevo_comentario.php?TipoForaneo=A&IdForaneo=<?php echo $IdArticulo; ?>" target="_top">Agregar Comentario</a><br /></p>

 <?php 
 while (is_array($res_com) && (list($Id,$Dato)=each($res_com))){ ?>
<div class="comentario">
     <div class="comment-head mini-d-head">
       <img src="imagenes/icon_user.png" />&nbsp;&nbsp;<?php echo $Dato[NombreComentario]; ?>&nbsp;<span class="noresaltado"">(<?php echo fecha_espenol2($Dato[FechaIngresoComentario]); ?>)</span>
     </div>
            <div class="clear"></div>
     <div class="comment-body mini-d">
       <p><?php echo $Dato[Comentario]; ?></p>
     </div>
</div>
      <?php  } ?>
</div>
<br style="clear:left"/>
</div>
<?php
	include "pie_pagina.php";
?>