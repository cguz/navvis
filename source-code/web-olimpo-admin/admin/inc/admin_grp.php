<p align="center"><a href="home.php?inc=<?=$inc?>&amp;sub=editar_grp"><img src="imagenes/add.gif" width="20" height="20" border="0"> Agregar Grupo </a></p>
<table width="219" border="0" align="center" cellpadding="2" cellspacing="1">
  <tr bgcolor="#CCCCCC">
    <td width="121"><div align="center"><strong>Nombre</strong></div></td>
    <td width="87"><div align="center"><strong>Opciones</strong></div></td>
  </tr>
<?
	$id_grp=$grupos->ObtenerGrpPorId();
	foreach($id_grp as $grupo)
	{
		if($color=="1")
		{
			$bgcolor="bgcolor='#EEEEEE'";
			$color=2;
		}else{
			$bgcolor="bgcolor='#FFFFFF'";
			$color=1;		
		}
		echo "<tr $bgcolor>
				<td>$grupo[1]</td>
				<td nowrap align='center'>
				<a href='home.php?inc=$inc&sub=editar_grp&id=$grupo[0]'><img src='./imagenes/edit.gif' border='0' alt='Editar'></a>
				<a href='home.php?inc=$inc&sub=eliminar_grp&id=$grupo[0]'><img src='./imagenes/delete.gif' border='0' alt='Eliminar'></a>		
		</td>
		</tr>";
	}
	
?>  
</table>
