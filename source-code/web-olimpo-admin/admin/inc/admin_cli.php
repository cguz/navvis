<form name="form1" method="post" action="home.php">
<input type="hidden" name="inc" value="<?=$inc?>">
<table width="600" border="0" align="center" cellpadding="2" cellspacing="1">
  <tr>
    <td colspan="6"><div align="right"><a href="home.php?inc=<?=$inc?>&amp;sub=editar_cli"><img src="imagenes/add.gif" width="20" height="20" border="0" /> Agregar Cliente </a> &nbsp;&nbsp;&nbsp;&nbsp;
      Buscar Cliente
      <input name="buscar" type="text" id="buscar" size="15" />
      por
  <select name="campo" id="campo">
    <option value="Nombre">nombre</option>
    <option value="Apellidos">apellido</option>
    <option value="Telefono">telefono</option>
    <option value="Email">email</option>
    <option value="tipo_cliente">tipo cliente</option>
  </select>
  &nbsp;
  <input name="imageField" type="image" src="imagenes/buscar.gif" width="20" height="20" border="0" />
    </div></td>
  </tr>
  <tr>
    <td colspan="6"><div align="right">Mostrar tipos de cliente 
        <select name="tipo_cliente" id="tipo_cliente">
  <option value="0" selected="selected">- -</option>
  <option value="1">Comprador</option>
  <option value="2">Vendedor</option>
  <option value="3">Busca Alquiler</option>
  <option value="4">Alquila</option>
</select>
&nbsp;
<input name="imageField2" type="image" src="imagenes/buscar.gif" width="20" height="20" border="0" />
</div></td>
    </tr>
  <tr bgcolor="#CCCCCC">
    <td width="115"><div align="center"><strong>Nombre</strong></div></td>
    <td width="107"><div align="center"><strong>Apellido</strong></div></td>
    <td width="114"><div align="center"><strong>Telefono</strong></div></td>
    <td width="70"><div align="center"><strong>Email</strong></div></td>
    <td width="64"><div align="center"><strong>M&oacute;vil</strong></div></td>
    <td width="87"><div align="center"><strong>Opciones</strong></div></td>
  </tr>
<?
	if($buscar or $tipo_cliente)
	{
		$id_cli=$clientes->ObtenerCliPorCampo($buscar,$campo, $tipo_cliente);
	}else{
		$id_cli=$clientes->ObtenerCliPorId();
	}
	if(!$id_cli)
	{
		echo "<tr><td colspan='6' height='25' align=center>No se encontraron resultados para la busqueda <b>$buscar</b></td></tr>";
	}else
	{
	$i=0;
	while($id_cli[$i])
	{
		if($color=="1")
		{
			$bgcolor="bgcolor='#EEEEEE'";
			$color=2;
		}else{
			$bgcolor="bgcolor='#FFFFFF'";
			$color=1;		
		}
		echo "<tr $bgcolor>";
		$datos=$clientes->ObtenerDatosCli($id_cli[$i]);
		
		$j=1;
		while($j<=5)
		{
			echo "<td>$datos[$j]</td>";
			$j++;
		}
		echo "	<td nowrap align='center'>
				<a href='home.php?inc=$inc&sub=editar_cli&id=$datos[0]'><img src='./imagenes/edit.gif' border='0' alt='Editar'></a>
				<a href='home.php?inc=$inc&sub=eliminar_cli&id=$datos[0]'><img src='./imagenes/delete.gif' border='0' alt='Eliminar'></a>		
		</td>
		</tr>";
		$i++;
	}}
	
?>  
</table>
</form>


