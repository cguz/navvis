<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
<?
	$i=0;
	while($privilegios[$i])
	{
		  echo "<tr>
			    <td bgcolor='#D51C38'>";
				$nomprv=$usuarios->ObtenerPrvPorId($privilegios[$i]);
		  echo "<a href='home.php?inc=$privilegios[$i]' class='letrasb'>$nomprv[0]</a>
		  		</td>
  				</tr>";
		$i++;
	}
?>
	<tr>
		<td bgcolor="#D51C38">
			<a href='salir.php' class='letrasb'>Salir</a>
		</td>
  	</tr>
</table>