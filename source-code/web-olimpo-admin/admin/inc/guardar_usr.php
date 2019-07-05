<?
	$msg1="Los datos han sido guardados correctamente";
	$msg2="Los datos no se pudieron guardar. Intente nuevamente";
	$msg3="La contraseña fue cambiada correctamente";
	$msg4="El nick de usuario ya se encuentra registrado. Intente nuevamente.";
	if($accion=="actualizar"){
		$usuarios->CambiarCarpGrp($id,$grupo);
		$act=$usuarios->ActualizarDatosUsr($id,$nombre,$apellido,$nick,$correo,$grupo);
		//Cambio las carpetas si se cambia de grupo
		if($act==true)
		{
			$msg=$msg1;
		}else{
			$msg=$msg2;
		}
	}else if($accion=="insertar"){
		$act=$usuarios->InsertarDatosUsr($id,$nombre,$apellido,$nick,$correo,$password,$grupo);
		$query="SELECT MAX(id) FROM pav_usuarios";
		$ultimo_usuario=DoSQL::obtener_Columna($query);
		if(!isset($ftp)){
			echo "No esta definido";
			
		}
		
		if($act==1)
		{
			$msg=$msg1;
		}else if($act=="existe"){
			$msg=$msg4;
		}else{
			$msg=$msg2;
		}
	}else if($accion=="password"){
		$act=$usuarios->CambiarPassUsr($id,$password);
		if($act==true)
		{
			$msg=$msg3;
			$act=0;
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