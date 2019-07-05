<?
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");	
    session_start();
	if(!$usr_id)
	{
		echo "<script>document.location.href='salir.php'</script>";
	}else{
		include "clases/Consultadb.php";
		include "clases/AdminUsuarios.php";
		include "clases/AdminGrupos.php";
		include "clases/AdminClientes.php";
		include "clases/AdminNoticias.php";
		include "clases/AdminCorreos.php";
		include "clases/AdminSubsec.php";
		include "clases/AdminInmuebles.php";
		
		$inmuebles = new AdminInmuebles;
		$obj_subsec = new AdminSubsec;
		$correos= new AdminCorreos;
		$consulta= new ConsultaBD;
		$usuarios= new AdminUsuarios;
		$grupos= new AdminGrupos;
		$clientes= new AdminClientes;
		$noticias= new AdminNoticias;
    	$conectar=$consulta->conectar(); 
		$privilegios=$usuarios->ObtenerPrivilegios($usr_id);		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>::: Sistema Administrador de contenidos :::</title>
</head>
<link href="estilo/admin.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="scripts/validar.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/funciones.js"></script>
<body>
<table width="791" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2"><? include "./tpl/cabezote.php"; ?></td>
  </tr>
  <tr>
    <td width="160" valign="top" bgcolor="#666666"><? include "./tpl/menu.php" ?></td>
    <td width="631" height="400" valign="top">
	Bienvenid@ <b><? echo $usr_nombre ?></b>
	<br>
	<br>
	<?
		$q=0;
		while($privilegios[$q])
		{
			if($privilegios[$q]==$inc){
				$file=$usuarios->ObtenerVarPrv($inc);
				if(!$sub)
					include ("./inc/".$file.".php");
				else
					include ("./inc/".$sub.".php");
				$file_inc=true;
			}
			$q++;
			
		}
		if($file_inc!=true)
			include ("inc/default.php");
	?>
	</td>
  </tr>
  <tr>
    <td colspan="2"><? include "./tpl/abajo.php" ?></td>
  </tr>
</table>
</body>
</html>
<?
}
$des=$consulta->desconectar($conectar);
?>