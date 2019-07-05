<?
	$msg1="Esta seguro que desea eliminar el grupo ";
	$msg2="El grupo ha sido eliminado correctamente ";
	$msg3="No se ha podido eliminar el grupo. Por favor intente nuevamente";
	if(!$confirm)
	{
?>
		<br><br><br><br>
		<table width="300" height="150" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="#999999">
  		<tr>
   		 <td bgcolor="#EEEEEE" align="center">
		<?
		 $nombre=$grupos->ObtenerDatosGrp($id);
		 echo "<img src='imagenes/warning.gif' width='30' height='30'><br><br>$msg1 <b>$nombre[0]</b>";
		 ?>		
		<br><br>
		<input type="button" value="Aceptar" onClick="document.location.href='home.php?inc=<?=$inc?>&sub=eliminar_grp&confirm=true&id=<?=$id?>'">
		&nbsp;
		<input type="button" value="Cancelar" onClick="document.location.href='home.php?inc=<?=$inc?>'">
		</td>
  		</tr>
		</table>
<?
	}else{
		$borrar=$grupos->EliminarGrp($id);
		$grupos->BorrarPrvGrp($id);
		if($borrar==true)
		{
			$msg=$msg2;
		}else{
			$msg=$msg3;
		}
?>
		<br><br><br><br>
		<table width="300" height="150" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="#999999">
  		<tr>
   		 <td bgcolor="#EEEEEE" align="center">
		<?=$msg ?>		
		<br><br>
		<input type="button" value="Aceptar" onClick="document.location.href='home.php?inc=<?=$inc?>'">
		</td>
  		</tr>
		</table>
<?
	}
?>


