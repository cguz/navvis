<?
	$msg1="Los datos han sido guardados correctamente";
	$msg2="Los datos no se pudieron guardar. Intente nuevamente";
	$msg3="La contraseña fue cambiada correctamente";
	$msg4="El correo electronico del usuario ya se encuentra registrado. Intente nuevamente.";
	//echo $accion;
	if($accion=="actualizar"){
		$act=$clientes->ActualizarDatosCli($id,$nombre,$apellido,$telefono,$email,$celular,$direccion, $codigopostal,$ciudad, $puerta, $escalera, $numero, $calle,$planta, $observacion_oculta, $tipo_cliente);
		//Cambio las carpetas si se cambia de grupo
		if($act==true)
		{
			$msg=$msg1;
		}else{
			$msg=$msg2;
		}
	}else if($accion=="insertar"){
		$act=$clientes->InsertarDatosCli($nombre,$apellido,$telefono,$celular,$email,$direccion,$codigopostal,$ciudad, $puerta, $escalera, $numero, $calle,$planta, $observacion_oculta, $tipo_cliente);
		
		if($act==1)
		{
			$msg=$msg1;
		}else if($act=="existe"){
			$msg=$msg4;
		}else{
			$msg=$msg2;
		}
	}
	if(!$id)
	{
		$id=$usuarios->ObtenerUltimoId();	
	}
	if($act==1)
	{
		$patern=0;
		$prvs=$usuarios->ObtenerNomPrv($patern);
		foreach($prvs as $id_prvs)
		{
			$id_prv=$id_prvs[0];
			$prv_grp=$grupos->VerificarPrivilegio($grupo,$id_prv);	
			if($prv_grp==true)	
			{
				$usuarios->GuardarPrivilegio($id,$id_prv,'si');
			}else{
				$usuarios->GuardarPrivilegio($id,$id_prv,'no');
			}
		}
	}
?>
<br><br><br><br>
<table width="300" height="150" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="#999999">
  <tr>
    <td bgcolor="#EEEEEE" align="center">
		<?=$msg?>
		<br><br>
		<input type="button" value="Aceptar" onClick="document.location.href='home.php?inc=<?=$inc?>'">
	</td>
  </tr>
</table>