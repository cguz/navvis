<?
	$datos=$usuarios->ObtenerDatosUsr($usr_id);
	$grupo=$usuarios->ObtenerGrpUsr($datos[0]);
?>

<form name="form1" method="post" action="home.php" onSubmit='return validar_password(this.password,this.confirmar)'>
<input type="hidden" name="inc" value="<?=$inc?>">
<input type="hidden" name="id" value="<?=$usr_id?>">
<input type="hidden" name="grupo" value="<?=$grupo[1]?>">
<input type="hidden" name="sub" value="guardar_usr">
<input type="hidden" name="accion" value="actualizar">
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
          <input name="nick" type="hidden" value="<?=$datos[3]?>">
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Correo electr&oacute;nico </strong></div></td>
      <td bgcolor="#FFFFFF">
        <div align="center">
          <input name="correo" type="text" id="correo" size="25" value="<?=$datos[4]?>">
        </div></td>
    </tr>
  </table>
  <p align="center">  
    <input type="submit" name="Submit" value="Guardar">
    <input type="button" name="Submit" value="Cancelar" onClick="document.location.href='home.php'">

</form>
<form name="form2" method="post" action="home.php" onSubmit='return validar_password(this.password,this.confirmar)'>
<input type="hidden" name="inc" value="<?=$inc?>">
<input type="hidden" name="id" value="<?=$usr_id?>">
<input type="hidden" name="sub" value="guardar_prs">
<input type="hidden" name="accion" value="password">
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
    <input type="button" name="Submit" value="Cancelar" onClick="document.location.href='home.php'">
</p>
</form>
<br>
