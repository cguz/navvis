<script src="scripts/calendario.js" type="text/javascript" language="javascript">
</script>
<form name="form1" method="post" action="home.php">
<input type="hidden" name="inc" value="<?=$inc?>">
<table width="600" border="0" align="center" cellpadding="2" cellspacing="1">
  <tr>
    <td colspan="6"><div align="right">
      <table width="98%" border="0">
        <tr>
          <td colspan="3"><div align="right"><a href="home.php?inc=<?=$inc?>&amp;sub=editar_inmue"><img src="imagenes/add.gif" width="20" height="20" border="0" /> Agregar Inmueble </a>Buscar Inmueble
            <input name="buscar" type="text" id="buscar" size="15" />
          </div></td>
          <td>&nbsp;</td>
          <td>por
            <select name="campo" id="campo">
              <option value="nombre">nombre cliente</option>
              <option value="direccion">direccion</option>
              <option value="Poblacion">poblacion</option>
              <option value="tipo">tipo</option>
              <option value="no_habitaciones">dormitorio</option>
			  <option value="referencia">referencia</option>
            </select></td>
          <td><input name="imageField3" type="image" src="imagenes/buscar.gif" width="20" height="20" border="0" /></td>
        </tr>
        <tr>
          <td width="31%"><div align="right">Desde
            <input name="buscar1" readonly="true" type="text" id="buscar1" size="15" />
          </div></td>
          <td width="4%"><a href="javascript:show_calendar('form1.buscar1');" onmouseover="window.status='Desplegar Calendario';return true;" onmouseout="window.status='';return true;"><img src="imagenes/calendario.gif" width="18" height="18" border="0" align="absmiddle" alt="Desplegar Calendario" title="Desplegar Calendario" /></a></td>
          <td width="23%"><div align="right">hasta
            <input name="buscar2" readonly="true" type="text" id="buscar2" size="15" />
            </div></td>
          <td width="4%"><a href="javascript:show_calendar('form1.buscar2');" onmouseover="window.status='Desplegar Calendario';return true;" onmouseout="window.status='';return true;"><img src="imagenes/calendario.gif" width="18" height="18" border="0" align="absmiddle" alt="Desplegar Calendario" title="Desplegar Calendario" /></a></td>
          <td width="34%">por
            <select name="campo1" id="campo1">
                <option value="fecha_alta">altas</option>
                <option value="fecha_baja">bajas</option>
                <option value="fecha_venta">ventas</option>
              </select>
            &nbsp;</td>
          <td width="4%"><input name="imageField2" type="image" src="imagenes/buscar.gif" width="20" height="20" border="0" /></td>
        </tr>
        <tr>
          <td><div align="right">Desde
            <input name="buscar3" type="text" id="buscar3" size="15" />
          </div></td>
          <td>&nbsp;</td>
          <td><div align="right">hasta
            <input name="buscar4" type="text" id="buscar4" size="15" />
          </div></td>
          <td>&nbsp;</td>
          <td>por
            precio</td>
          <td><input name="imageField22" type="image" src="imagenes/buscar.gif" width="20" height="20" border="0" /></td>
        </tr>
      </table>
    </div></td>
    </tr>
  <tr bgcolor="#CCCCCC">
    <td width="117"><div align="center"><strong>Cliente</strong></div></td>
    <td width="109"><div align="center"><strong>Poblacion</strong></div></td>
    <td width="95"><div align="center"><strong>Tipo</strong></div></td>
    <td width="92"><div align="center"><strong>Referencia</strong></div></td>
    <td width="65"><div align="center"><strong>Precio</strong></div></td>
    <td width="91"><div align="center"><strong>Opciones</strong></div></td>
  </tr>
<?
	if($buscar)
	{
		$id_inmue=$inmuebles->ObtenerInmuePorCampo($buscar,$campo);
	}else{
		if($buscar1)
		{
			$id_inmue=$inmuebles->ObtenerInmuePorCampo_fecha($buscar1,$buscar2,$campo1);
		}else{
			if($buscar3)
			{
				$id_inmue=$inmuebles->ObtenerInmuePorCampo_precio($buscar3,$buscar4);
			}else{
				$id_inmue=$inmuebles->ObtenerInmuePorId();
			}
		}
	}
	if(!$id_inmue)
	{
		echo "<tr><td colspan='6' height='25' align=center>No se encontraron resultados para la busqueda <b>$buscar</b></td></tr>";
	}else
	{
	$i=0;
	while($id_inmue[$i])
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
		$datos=$inmuebles->ObtenerDatosInmue2($id_inmue[$i]);
		
		$j=1;
		while($j<=5)
		{
			if ($j==1)
			{
				$datosc=$inmuebles->ObtenerDatosCli($datos[$j]);
				echo "<td>$datosc[1],$datosc[2]</td>";
			}
			else
				if ($j==3)
				{
					$datost=$inmuebles->ObtenerTipoPorId($datos[$j]);
					//echo "hola$datost[1]";
					echo "<td>$datost[1]</td>";
				}
				else
					echo "<td>$datos[$j]</td>";
			$j++;
		}
		echo "	<td nowrap align='center'>";
		
		if ($datos[6]==0)
			echo "<a href='home.php?inc=$inc&sub=editar_inmue&id=$datos[0]'><img src='./imagenes/denegar.gif' border='0' alt='No publicado'></a>";
		else
			echo "<a href='home.php?inc=$inc&sub=editar_inmue&id=$datos[0]'><img src='./imagenes/permitir.gif' border='0' alt='Publicado'></a>";
		echo"<a href='home.php?inc=$inc&sub=eliminar_inmue&id=$datos[0]'><img src='./imagenes/delete.gif' border='0' alt='Eliminar'></a>		
		</td>
		</tr>";
		$i++;
	}}
	
?>  
</table>

</form>
