<?
	$msg1="Los datos han sido guardados correctamente";
	$msg2="Los datos no se pudieron guardar. Intente nuevamente";
	$msg3="La contraseña fue cambiada correctamente";
	$msg4="El nick de usuario ya se encuentra registrado. Intente nuevamente.";
	if($accion=="actualizar"){
		$act=$usuarios->ActualizarDatosUsr($id,$nombre,$apellido,$nick,$correo,$grupo);
		if($act==true)
		{
			$msg=$msg1;
		}else{
			$msg=$msg2;
		}
	}else if($accion=="password"){
		$act=$usuarios->CambiarPassUsr($id,$password);
		if($act==true)
		{
			$msg=$msg3;
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
		<input type="button" value="Aceptar" onClick="document.location.href='home.php?inc=<?=$inc?>'">
	</td>
  </tr>
</table>