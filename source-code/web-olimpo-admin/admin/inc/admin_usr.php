<form name="form1" method="post" action="home.php">
<input type="hidden" name="inc" value="<?=$inc?>">
<p align="center"><a href="home.php?inc=<?=$inc?>&amp;sub=editar_usr"><img src="imagenes/add.gif" width="20" height="20" border="0"> Agregar Usuario </a> 
&nbsp;&nbsp;&nbsp;&nbsp;
Buscar Usuario
<input name="buscar" type="text" id="buscar" size="15">
  por
  <select name="campo" id="campo">
    <option value="nombre">nombre</option>
    <option value="apellido">apellido</option>
    <option value="nick">nick</option>
    <option value="email">correo</option>
  </select> 
&nbsp; 
<input name="imageField" type="image" src="imagenes/buscar.gif" width="20" height="20" border="0">
</p>
<table width="600" border="0" align="center" cellpadding="2" cellspacing="1">
  <tr bgcolor="#CCCCCC">
    <td width="115"><div align="center"><strong>Nombre</strong></div></td>
    <td width="107"><div align="center"><strong>Apellido</strong></div></td>
    <td width="114"><div align="center"><strong>Nick</strong></div></td>
    <td width="70"><div align="center"><strong>correo</strong></div></td>
    <td width="64"><div align="center"><strong>Grupo</strong></div></td>
    <td width="87"><div align="center"><strong>Opciones</strong></div></td>
  </tr>
<?
	if($buscar)
	{
		$id_usr=$usuarios->ObtenerUsrPorCampo($buscar,$campo);
	}else{
		$id_usr=$usuarios->ObtenerUsrPorId();
	}
	if(!$id_usr)
	{
		echo "<tr><td colspan='6' height='25' align=center>No se encontraron resultados para la búsqueda <b>$buscar</b></td></tr>";
	}
	$i=0;
	while($id_usr[$i])
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
		$datos=$usuarios->ObtenerDatosUsr($id_usr[$i]);
		$grupo=$usuarios->ObtenerGrpUsr($datos[0]);
		$nom_grupo=$grupos->ObtenerDatosGrp($grupo[1]);
		$j=1;
		while($j<=4)
		{
			echo "<td>$datos[$j]</td>";
			$j++;
		}
		echo "	<td>$nom_grupo[0]</td>
				<td nowrap align='center'>
				<a href='home.php?inc=$inc&sub=editar_usr&id=$datos[0]'><img src='./imagenes/edit.gif' border='0' alt='Editar'></a>
				<a href='home.php?inc=$inc&sub=prv_usr&id=$datos[0]'><img src='./imagenes/enable.gif' border='0' alt='Editar privilegios'></a>
				<a href='home.php?inc=$inc&sub=eliminar_usr&id=$datos[0]'><img src='./imagenes/delete.gif' border='0' alt='Eliminar'></a>		
		</td>
		</tr>";
		$i++;
	}
	
?>  
</table>
</form>


