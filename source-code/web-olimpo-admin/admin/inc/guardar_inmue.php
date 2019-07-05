<?
	$msg1="Los datos han sido guardados correctamente";
	$msg2="Los datos no se pudieron guardar. Intente nuevamente";
	$msg3="Otro mensaje";
	$msg4="Intente nuevamente.";
	//echo $accion;
	if($accion=="actualizar"){
		$act=$inmuebles->ActualizarDatosInmue($id,$Id_cliente, $poblacion, $orientacion, $codigopostal, $direccion, $puerta, $escalera, $numero, $calle, $tipo, $estado_inmueble, $alturapor_planta, $cuadrados_construidos, $cuadrados_utiles, $no_habitaciones, $no_banos, $estado, $precio, $precio_inmobiliaria, $exterior_inte, $no_garajes, $no_ascensores, $no_armarios, $tipo_suelo, $garaje_incluido, $observacion, $puerta_seguridad, $alarma, $cocinafull, $aire_acondicionado,$trastero, $servicio_agua, $calefaccion,$antena,$terraza, $tendero,$gastos_comunidad,$pisicina, $conserge, $altura_edificio, $antiguedad, $puertaspor_plantas, $zonas_comunales, $activo,$captador,$vendedor,$tipo_alquiler,$precio_mes,$precio_mes_comision,$gastos_incluidos,$fecha_venta, $referencia, $planta, $fecha_baja, $fecha_alta,$observacion_oculta, $amueblado);
		
		$act1=$clientes->ActualizarDatosCli($Id_cliente,$nombre2,$apellido2,$telefono2,$email2,$celular2,$direccion2, $codigopostal2,$ciudad2, $puerta2, $escalera2, $numero2, $calle2, $planta2, $observacion_oculta2, $tipo_cliente2);
		
		//Cambio las carpetas si se cambia de grupo
		if($act==true)
		{
			$msg=$msg1;
		}else{
			$msg=$msg2;
		}
	}else if($accion=="insertar"){
		$act_cliente = $clientes->InsertarDatosCli($nombre2,$apellido2,$telefono2,$celular2,$email2,$direccion2, $codigopostal2,$ciudad2, $puerta2, $escalera2, $numero2, $calle2,$planta2, $observacion_oculta2, $tipo_cliente2);
		//echo "hola: $act_cliente Client: $Id_cliente";
		if($act_cliente == 1)
		{
			
			$Id_cliente=$clientes->ObtenerUltimoId();
			//echo $Id_cliente;
			$act=$inmuebles->InsertarDatosInmue($Id_cliente, $poblacion, $orientacion, $codigopostal, $direccion, $puerta, $escalera, $numero, $calle, $tipo, $estado_inmueble, $alturapor_planta, $cuadrados_construidos, $cuadrados_utiles, $no_habitaciones, $no_banos, $estado, $precio, $precio_inmobiliaria, $exterior_inte, $no_garajes, $no_ascensores, $no_armarios, $tipo_suelo, $garaje_incluido, $observacion, $puerta_seguridad, $alarma, $cocinafull, $aire_acondicionado,$trastero, $servicio_agua, $calefaccion,$antena,$terraza, $tendero,$gastos_comunidad,$pisicina, $conserge, $altura_edificio, $antiguedad, $puertaspor_plantas, $zonas_comunales, $activo,$captador,$vendedor,$tipo_alquiler,$precio_mes,$precio_mes_comision,$gastos_incluidos,$fecha_venta, $referencia, $planta, $fecha_baja, $fecha_alta,$observacion_oculta, $amueblado);
			
		}
	
		if($act==1)
		{
			$msg=$msg1;
			$id_1 = $inmuebles->ObtenerUltimoId();
		}else if($act=="existe"){
			$msg=$msg4;
		}else{
			$msg=$msg2;
		}
	}
?>
<br><br><br><br>
<table width="300" height="150" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="#999999">
  <tr>
    <td bgcolor="#EEEEEE" align="center">
		<?=$msg?>
		<br><br> 
	  <?php  if($id_1){  ?>	
	  </strong><a href="upload.php?I=<?php echo $id_1; ?>" target="_blank">Subir Fotos</a><br><br>
	  <?php }  ?>
		<input type="button" value="Aceptar" onClick="document.location.href='home.php?inc=<?=$inc?>'">
	</td>
  </tr>
</table>