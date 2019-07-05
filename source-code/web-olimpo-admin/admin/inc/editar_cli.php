<?
	if(!$id)
	{
		$accion="insertar";
		$validar_form1="onSubmit='return validar_password(this.password,this.confirmar)'";	
	}else{
		$accion="actualizar";	
		$validar_form2="onSubmit='return validar_password(this.password,this.confirmar)'";	
	}
	$datos=$clientes->ObtenerDatosCli($id);
	//$id_grp_usr=$usuarios->ObtenerGrpUsr($id);
?>

<form name="form1" method="post" action="home.php" <?=$validar_form1?>>
  <p>
  <input type="hidden" name="inc" value="<?=$inc?>">
  <input type="hidden" name="id" value="<?=$id?>">
  <input type="hidden" name="sub" value="guardar_cli">
  <input type="hidden" name="accion" value="<?=$accion?>">
    Actualmente ningun dato es obligatorio</p>
  <p>&nbsp;  </p>
  <table width="300" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#DDDDDD">
    <tr bgcolor="#CCCCCC">
      <td colspan="2">
      <div align="center"><strong>Datos del cliente </strong></div></td>
    </tr>
    <tr>
      <td width="130" bgcolor="#EEEEEE"><div align="right"><strong>Nombre:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
        <input name="nombre" type="text" id="nombre" size="25" value="<?=$datos[1]?>">
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Apellidos:</strong></div></td>
      <td bgcolor="#FFFFFF">
        <div align="center">
          <input name="apellido" type="text" id="apellido" size="25" value="<?=$datos[2]?>">
        </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Telefono:</strong></div></td>
      <td bgcolor="#FFFFFF">
        <div align="center">
          <input name="telefono" type="text" id="telefono" size="25" value="<?=$datos[3]?>">
        </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Telefono Movil :</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input name="celular" type="text" id="celular" size="25" value="<?=$datos[5]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Correo electronico:</strong></div></td>
      <td bgcolor="#FFFFFF">
        <div align="center">
          <input name="email" type="text" id="email" size="25" value="<?=$datos[4]?>">
        </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Ciudad: </strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input name="ciudad" type="text" id="ciudad" size="25" value="<?=$datos[8]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>C&oacute;digo postal : </strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
        <input name="codigopostal" type="text" id="codigopostal" size="25" value="<?=$datos[7]?>" />
      </div></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EEEEEE"><div align="right"><strong>Direcci&oacute;n:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
        <textarea name="direccion" cols="22" rows="4" id="direccion"><?=$datos[6]?></textarea>
      </div></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EEEEEE"><div align="right"><strong>Numero:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input name="numero" type="text" id="numero" onKeyPress="return acceptNum(event)" size="25" value="<?=$datos[11]?>" />
          <input name="calle" type="hidden" cols="22" rows="4" id="calle"/>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Planta</strong>:</div></td>
      <td bgcolor="#FFFFFF"><div align="center">
        <input name="planta" type="text" id="planta" size="25" value="<?=$datos[13]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Puerta:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input name="puerta" type="text" id="puerta" size="25" value="<?=$datos[9]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Escalera:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
		<input name="escalera" type="text" id="escalera" size="25" value="<?=$datos[10]?>" />
      </div></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EEEEEE"><div align="right"><strong>Tipo Cliente: </strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <select name="tipo_cliente" id="tipo_cliente">
            <option value="0"<?=($datos[15]==0)? "selected":""?>>- -</option>
            <option value="1"<?=($datos[15]==1)? "selected":""?>>Comprador</option>
            <option value="2"<?=($datos[15]==2)? "selected":""?>>Vendedor</option>
            <option value="3"<?=($datos[15]==3)? "selected":""?>>Busca Alquiler</option>
            <option value="4"<?=($datos[15]==4)? "selected":""?>>Alquila</option>
          </select>
      </div></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EEEEEE"><div align="right"><strong>Observacion oculta: </strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
        <textarea name="observacion_oculta" cols="22" rows="4" id="observacion_oculta"><?=$datos[14]?></textarea>
      </div></td>
    </tr>
  </table>
    <div align="center">
      <p>&nbsp;      </p>
      <p>
        <input type="submit" name="Submit" value="Guardar">
        <input type="button" name="Submit" value="Cancelar" onClick="document.location.href='home.php?inc=<?=$inc?>'">
      </p>
        </p>
  </div>
</form>
<br>
