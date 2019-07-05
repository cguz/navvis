<?
    session_start();
	include "clases/Consultadb.php";
	include "clases/AdminUsuarios.php";
    $consulta= new ConsultaBD;
	$usuarios= new AdminUsuarios;
    $conectar=$consulta->conectar();
	$id_aut=$usuarios->ValidarEntrada($usuario,$password);
	
	if($id_aut)
	{
    	$usr_id=$id_aut;
    	$usr_nombre=$usuario;
    	session_register("usr_id","usr_nombre");
    	echo "<script>document.location.href='home.php';</script>";
	}else{
		$msg="Nombre de usuario o contraseña no validos";
		echo "<script>document.location.href='index.php?msg=$msg';</script>";
	}

?>
