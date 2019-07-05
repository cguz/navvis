<?
	if(!$id)
	{
		$accion="insertar";
	}else{
		$accion="actualizar";	
	}
	$datos=$grupos->ObtenerDatosGrp($id);
?>
<form name="form1" method="post" action="home.php" Onsubmit="return valide_nombre(this.nombre);">
<input type="hidden" name="inc" value="<?=$inc?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="sub" value="guardar_grp">
<input type="hidden" name="accion" value="<?=$accion?>">
  <table width="300" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#DDDDDD">
    <tr bgcolor="#CCCCCC">
      <td colspan="2">
      <div align="center"><strong>Agregar grupo </strong></div></td>
    </tr>
    <tr>
      <td width="130" bgcolor="#EEEEEE"><div align="right"><strong>Nombre:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
        <input name="nombre" type="text" id="nombre" size="25" value="<?=$datos[0]?>">
      </div></td>
    </tr>
  </table>
  <p>
  <table width="350" border="0" align="center" cellpadding="2" cellspacing="1">
    <tr bgcolor="#CCCCCC">
      <td width="312"><strong>Privilegio</strong></td>
      <td width="50" align="center"><strong>Si</strong></td>
      <td width="50" align="center"><strong>No</strong></td>
    </tr>
    <?
	$patern=0;
	$prvs=$usuarios->ObtenerNomPrv($patern);
	foreach($prvs as $prv)
	{
		if($grupos->VerificarPrivilegio($id,$prv[0])==true)
		{
			$chekced1="checked";
			$chekced2="";
		}else{
			$chekced2="checked";
			$chekced1="";
		}
		$id_prv=$prv[0];
		if($color==1)
		{
			$bgcolor="#EEEEEE";
			$color=2;
		}else{
			$bgcolor="#FFFFFF";
			$color=1;
		}
		echo "<tr bgcolor='$bgcolor'>
				<td>$prv[1]</td>
				<td align='center' bgcolor='#EEEEEE'><input type=radio name=prv[$id_prv] value='si' $chekced1></td>
				<td align='center' bgcolor='#EEEEEE'><input type=radio name=prv[$id_prv] value='no' $chekced2></td>
			 </tr>";
	}
?>
    <tr>
      <td width="312"></td>
      <td width="50" align="center"><a href="javascript:selAll('si');"><img src="imagenes/permitir.gif" width="17" height="17" alt="Permitir todo" border='0'></a></td>
      <td width="50" align="center"><a href="javascript:selAll('no');"><img src="imagenes/denegar.gif" width="17" height="17" alt="Denegar todo" border='0'></a></td>
    </tr>
  </table>  
  </p>
  <p align="center">
    <input type="submit" name="Submit" value="Guardar">
    <input type="button" name="Submit" value="Cancelar" onClick="document.location.href='home.php?inc=<?=$inc?>'">
  </p>
</form>
<br>
