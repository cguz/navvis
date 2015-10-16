<?
	$msg1="Los datos han sido guardados correctamente";
	$msg2="Los datos no se pudieron guardar. Intente nuevamente";
	$msg3="El nombre del grupo ya se encuentra registrado. Intente nuevamente.";	
	if($accion=="actualizar"){
		$act=$grupos->ActualizarDatosGrp($id,$nombre);
		if($act==true)
		{
			$msg=$msg1;
		}else{
			$msg=$msg2;
		}
	}else if($accion=="insertar"){
		$act=$grupos->InsertarDatosGrp($nombre);
		if($act==1)
		{
			$msg=$msg1;
		}else if($act=="existe"){
			$msg=$msg3;
		}else{
			$msg=$msg2;
		}
	}
	if(!$id)
	{
		$id=$grupos->ObtenerUltimaId();
		$id=$id[0];		
	}
	if($act==1)
	{
		$patern=0;
		$prvs=$usuarios->ObtenerNomPrv($patern);
		foreach($prvs as $id_prvs)
		{
			$id_prv=$id_prvs[0];
			if($prv[$id_prv]=="si")	
			{
				$grupos->GuardarPrivilegio($id,$id_prv,'si');
			}else{
				$grupos->GuardarPrivilegio($id,$id_prv,'no');
			}
		}
		/* Actuaiza los privilegios de los usuarios pertenecientes al grupo*/
		$usuarios_grp=$grupos->ObtenerUsrGrp($id);
		/*echo "<script>alert('$usuarios_grp');</script>";*/
		foreach($usuarios_grp as $idusr)
		{
			foreach($prvs as $id_prvs)
			{
				$id_prv=$id_prvs[0];
				if($prv[$id_prv]=="si")	
				{
					$usuarios->GuardarPrivilegio($idusr[0],$id_prv,'si');
				}else{
					$usuarios->GuardarPrivilegio($idusr[0],$id_prv,'no');
				}
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