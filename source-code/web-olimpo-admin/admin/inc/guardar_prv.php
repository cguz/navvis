<?
	$patern=0;
	$prvs=$usuarios->ObtenerNomPrv($patern);
	foreach($prvs as $id_prvs)
	{
		$id_prv=$id_prvs[0];
		if($prv[$id_prv]=="si")	
		{
			$usuarios->GuardarPrivilegio($id,$id_prv,'si');
		}else{
			$usuarios->GuardarPrivilegio($id,$id_prv,'no');
		}
	}
	$nombre=$usuarios->ObtenerDatosUsr($id);	
?>
		<br><br><br><br>
		<table width="300" height="150" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="#999999">
  		<tr>
   		 <td bgcolor="#EEEEEE" align="center">
		 
		Se han cambiado los privilegios del usuario <b><?=$nombre[1]?></b> correctamente	
		<br><br>
		<input type="button" value="Aceptar" onClick="document.location.href='home.php?inc=<?=$inc?>'">
		</td>
  		</tr>
		</table>