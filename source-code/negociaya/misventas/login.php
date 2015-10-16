<?php
include_once "../lib/config.php";
include_once "../lib/funciones.php";
include_once "../lib/sesion.php";
include_once "../lib/clases/conexion.class.php";
include_once "../lib/clases/usuario.class.php";

if (isset($_REQUEST['entrar']) && $_REQUEST['entrar'] == "Entrar")
{
    $conexion = new Conexion();
    $conexion->conectar();
    
    $mensaje = "";
    
    if ($conexion->getEnlace())
    {
        $usuario = new Usuario();
    
        $usuario->setAtributos($_REQUEST);
        
        if ($usuario->validarLogin($conexion))
        {
            sesion_crearVariables(array("id" => $usuario->getId(), "email" => $_REQUEST["email"], "contrasena" => $_REQUEST["contrasena"], "nombre" => $usuario->getNombre(), "administrador" => $usuario->getAdministrador()));
            
            header("Location: index.php");
        }
        
        $mensaje = "El email y/o Contraseña son Erroneos";
    }
    else
    {
        $mensaje = "No hay conexión con la Base de Datos";
    }
}
?>
<!doctype html>
<html><!-- InstanceBegin template="/Templates/Plantilla_Anuncios.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="UTF-8"/>
<!-- InstanceBeginEditable name="doctitle" -->
<title><?php print $nombre_sitio; ?></title>
<!-- InstanceEndEditable -->
<link href="../css/styles.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../js/funciones.js"></script>
</head>
<body bgcolor="#ffffff" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<header>
<table width="800px" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td><img src="../images/cabecera.gif" alt="<?php print $nombre_sitio; ?>" width="364" height="131" /></td>
        <td><img src="../images/cabecera2.gif" width="436" height="131" /></td>
    </tr>
</table>
</header>
<table width="800px" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td><img src="../images/bottom.gif" width="800" height="18"></td>
    </tr>
</table>
<!-- InstanceBeginEditable name="head" -->
<table width="800px" border="0" cellspacing="0" cellpadding="3" align="center">
    <tr>
        <td width="50px" align="right"><img src="../images/vi_titulo.gif" width="18" height="17" /></td>
        <td class="titulo">Login</td>
    </tr>
</table>
<br />
<form method="post" name="form_login" action="">
<table width="800px" border="0" cellspacing="0" cellpadding="3" align="center">
<?php
        if ($mensaje != '')
        {
?>
    <tr>
        <td colspan="2" class="text10" align="center"><?php print $mensaje ?></td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
<?php
        }
?>
    <tr>
        <td align="right" valign="top" class="text3"><span class="text10">*</span> Correo Electr&oacute;nico:</td>
        <td class="text7"><input name="email" type="text" class="inputstyle" id="email" size="40" value="<?php (isset($email) ? print $email : print "") ?>">
    </tr>
    <tr>
        <td align="right" valign="top" class="text3"><span class="text10">*</span> Contrase&ntilde;a:</td>
        <td class="text7"><input name="contrasena" type="password" class="inputstyle" id="contrasena" size="40" value="<?php (isset($contrasena) ? print $contrasena : print "") ?>">
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><input name="entrar" type="submit" class="inputstyle" id="entrar" value="Entrar"></td>
    </tr>
</table>
</form>
<!-- InstanceEndEditable -->
<FOOTER> <!-- site wide footer -->
<table width="800px" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
    	<td><img src="../images/bottom.gif" width="800" height="18"></td>
    </tr>
    <tr>
    	<td class="text10" align="center"><a href="../index.php" class="a">Home</a> | <a href="../crear_anuncio.php" class="a">Crear Anuncio</a> | 
        <a href="../se_vende.php" class="a">Se Vende</a> | <a href="../se_compra.php" class="a">Se Compra</a> | <a href="../ayuda.php" class="a">Ayuda</a></td>
    </tr>
    <tr>
    	<td class="text10" align="center"><br />Copyright &copy; <?php print $nombre_sitio; ?></td>
    </tr>
</table>
<FOOTER>
</body>
<!-- InstanceEnd --></html>
