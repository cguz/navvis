<?
	if(!$id)
	{
		$accion="insertar";
		$validar_form1="onSubmit='return validar_password(this.password,this.confirmar)'";	
	}else{
		$accion="actualizar";	
		$validar_form2="onSubmit='return validar_password(this.password,this.confirmar)'";	
	}
	$datos=$usuarios->ObtenerDatosUsr($id);
	$id_grp_usr=$usuarios->ObtenerGrpUsr($id);
?>

<form name="form1" method="post" action="home.php" <?=$validar_form1?>>
<input type="hidden" name="inc" value="<?=$inc?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="sub" value="guardar_usr">
<input type="hidden" name="accion" value="<?=$accion?>">
  <table width="300" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#DDDDDD">
    <tr bgcolor="#CCCCCC">
      <td colspan="2">
      <div align="center"><strong>Datos personales</strong></div></td>
    </tr>
    <tr>
      <td width="130" bgcolor="#EEEEEE"><div align="right"><strong>Nombre:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
        <input name="nombre" type="text" id="nombre" size="25" value="<?=$datos[1]?>">
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Apellido</strong></div></td>
      <td bgcolor="#FFFFFF">
        <div align="center">
          <input name="apellido" type="text" id="apellido" size="25" value="<?=$datos[2]?>">
        </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Nick</strong></div></td>
      <td bgcolor="#FFFFFF">
        <div align="center">
          <input name="nick" type="text" id="nick" size="25" value="<?=$datos[3]?>">
        </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Correo electr&oacute;nico </strong></div></td>
      <td bgcolor="#FFFFFF">
        <div align="center">
          <input name="correo" type="text" id="correo" size="25" value="<?=$datos[4]?>">
        </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Grupo</strong></div></td>
      <td bgcolor="#FFFFFF" align="center">
	  <select name="grupo">
	  <option value="0">Ninguno</option>	  
<? 	
	$id_grp=$grupos->ObtenerGrpPorId();
	foreach($id_grp as $grupo)
	{
		if($id_grp_usr[1]==$grupo[0])
		{
			$sel="selected";
		}
		echo "<option value='$grupo[0]' $sel>$grupo[1]</option>\n";
		$sel="";
	}
?>  
	  </select></td>
    </tr>
  </table>
  <p align="center">  
<?
	if($accion=="actualizar")
	{
?>
    <input type="submit" name="Submit" value="Guardar">
    <input type="button" name="Submit" value="Cancelar" onClick="document.location.href='home.php?inc=<?=$inc?>'">

</form>
<form name="form2" method="post" action="home.php" <?=$validar_form2?>>
<input type="hidden" name="inc" value="<?=$inc?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="sub" value="guardar_usr">
<input type="hidden" name="accion" value="password">
<?
}
?>
</p>
  <table width="300" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#DDDDDD">
    <tr bgcolor="#CCCCCC">
      <td colspan="2"><div align="center"><strong>Cambiar contrase&ntilde;a 
      </strong></div></td>
    </tr>
    <tr>
      <td width="130" bgcolor="#EEEEEE"><div align="right"><strong>Contrase&ntilde;a:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
        <input name="password" type="password" id="password" size="25">
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Confirmar contrase&ntilde;a: </strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
        <input name="confirmar" type="password" id="confirmar" size="25">
      </div></td>
    </tr>
  </table>
  <p align="center">
    <input type="submit" name="Submit" value="Guardar">
    <input type="button" name="Submit" value="Cancelar" onClick="document.location.href='home.php?inc=<?=$inc?>'">
</p>
</form>
<br>
