<?php
if (!isset($_GET['id']) || $_GET['id'] == '')
{
    header("Location: index.php");
}

include_once "lib/config.php";
include_once "lib/funciones.php";
include_once "lib/clases/conexion.class.php";
include_once "lib/clases/anuncio.class.php";
?>
<!doctype html>
<html><!-- InstanceBegin template="/Templates/Plantilla_Anuncios.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta charset="UTF-8"/>
<!-- InstanceBeginEditable name="doctitle" -->
<title><?php print $nombre_sitio; ?></title>
<!-- InstanceEndEditable -->
<link href="css/styles.css" rel="stylesheet" type="text/css">
<script language="javascript" src="js/funciones.js"></script>
</head>
<body bgcolor="#ffffff" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="preloadImages()">
<header>
<table width="800px" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td><img src="images/cabecera.gif" alt="<?php print $nombre_sitio; ?>" width="364" height="131" /></td>
        <td><img src="images/cabecera2.gif" width="436" height="131" /></td>
    </tr>
</table>
</header>
<table width="800px" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td colspan="7"><img src="images/top_menu.gif" width="800" height="14" /></td>
    </tr>
    <tr>
        <td><img src="images/left_menu.gif" width="31" height="19" /></td>
        <td><a href="index.php" onMouseOver="cambiarImagen('home', true)" onMouseOut="cambiarImagen('home', false)">
        	<img name="home" src="images/home.gif" width="126" height="19" border="0" alt="home" /></a></td>
        <td><a href="crear_anuncio.php" onMouseOver="cambiarImagen('crear_anuncio', true)" onMouseOut="cambiarImagen('crear_anuncio', false)">
       	<img name="crear_anuncio" src="images/crear_anuncio.gif" width="207" height="19" border="0" alt="Crear Anuncio" /></a></td>
        <td><a href="index.php?vende=1" onMouseOver="cambiarImagen('se_vende', true)" onMouseOut="cambiarImagen('se_vende', false)">
       	<img name="se_vende" src="images/se_vende.gif" width="160" height="19" border="0" alt="Se Vende" /></a></td>
        <td><a href="index.php?vende=0" onMouseOver="cambiarImagen('se_compra', true)" onMouseOut="cambiarImagen('se_compra', false)">
       	<img name="se_compra" src="images/se_compra.gif" width="157" height="19" border="0" alt="Se Compra" /></a></td>
        <td><a href="ayuda.php" onMouseOver="cambiarImagen('ayuda', true)" onMouseOut="cambiarImagen('ayuda', false)">
       	<img name="ayuda" src="images/ayuda.gif" width="79" height="19" border="0" alt="Ayuda" /></a></td>
        <td><img src="images/right_menu.gif" width="40" height="19" /></td>
    </tr>
    <tr>
        <td colspan="7"><img src="images/bottom_menu.gif" width="800" height="30" /></td>
    </tr>
</table>
<!-- InstanceBeginEditable name="head" -->
<?php
if (isset($_REQUEST['enviar']) && $_REQUEST['enviar'] == 'Enviar')
{
    $ok = true;
    $msj = '';
    
    $nombre = $_REQUEST['nombre'];
    $nombre_class = 'inputstyle';
    if ($nombre == '')
    {
        $msj .= 'El campo nombre es obligatorio<br />';
        $nombre_class = 'inputstyle_alert';
        $ok = false;
    }
    
    $email = $_REQUEST['email'];
    $email_class = 'inputstyle';
    if ($email == '')
    {
        $msj .= 'El campo de Correo Electrónico es obligatorio<br />';
        $email_class = 'inputstyle_alert';
        $ok = false;
    }
    elseif (!valida_email($email))
    {
        $msj .= 'El Correo Electrónico introducido no es válido<br />';
        $email_class = 'inputstyle_alert';
        $ok = false;
    }
    
    $asunto = $_REQUEST['asunto'];
    $asunto_class = 'inputstyle';
    if ($asunto == '')
    {
        $msj .= 'El Asunto es obligatorio<br />';
        $asunto_class = 'inputstyle_alert';
        $ok = false;
    }
    
    $mensaje = $_REQUEST['mensaje'];
    $mensaje_class = 'areastyle';
    if ($mensaje == '')
    {
        $msj .= 'El Mensaje es obligatorio<br />';
        $mensaje_class = 'area_alert';
        $ok = false;
    }
}
else
{
    $ok = false;
}
?>
<table width="800px" border="0" cellspacing="0" cellpadding="3" align="center">
    <tr>
        <td width="50px" align="right"><img src="images/vi_titulo.gif" width="18" height="17" /></td>
        <td class="titulo">Escribir al Anunciante</td>
    </tr>
</table>
<br />
<form method="post" name="form_escribir" action="">
<?php
if (!$ok)
{
?>

<table width="800px" border="0" cellspacing="0" cellpadding="3" align="center">
<?php
        if ($msj != '')
        {
?>
    <tr>
        <td colspan="2" class="text3" align="center">Se encontraron los Siguientes Errores:<br /><br /><span class="text10"><?php print $msj ?></span><br /></td>
    </tr>
<?php
        }
?>
    <tr>
        <td align="right" valign="top" class="text3" width="40%"><span class="text10">*</span> Tu nombre:</td>
        <td><input name="nombre" type="text" class="<?php (isset($nombre_class) && $nombre_class != '' ? print $nombre_class : print "inputstyle") ?>" id="nombre" size="70" value="<?php (isset($nombre) ? print $nombre : print "") ?>"></td>
    </tr>
    <tr>
        <td align="right" valign="top" class="text3"><span class="text10">*</span> Correo Electr&oacute;nico:</td>
        <td class="text7"><input name="email" type="text" class="<?php (isset($email_class) && $email_class != '' ? print $email_class : print "inputstyle") ?>" id="email" size="70" value="<?php (isset($email) ? print $email : print "") ?>"><br />
            Esta direcci&oacute;n no ser&aacute; p&uacute;blica ni se almacenar&aacute;, solo se utiliza para que el anunciante se ponga en contacto contigo.</td>
    </tr>
    <tr>
        <td align="right" valign="top" class="text3" width="40%"><span class="text10">*</span> Asunto:</td>
        <td><input name="asunto" type="text" class="<?php (isset($asunto_class) && $asunto_class != '' ? print $asunto_class : print "inputstyle") ?>" id="asunto" size="70" value="<?php (isset($asunto) ? print $asunto : print "") ?>"></td>
    </tr>
    <tr>
        <td align="right" valign="top" class="text3"><span class="text10">*</span> Mensaje:</td>
        <td><textarea name="mensaje" id="mensaje" cols="100" rows="10" class="<?php (isset($mensaje_class) && $mensaje_class != '' ? print $mensaje_class : print "areastyle") ?>"><?php if (isset($mensaje)) print $mensaje; ?></textarea></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><input name="id" type="hidden" id="id" value="<?php print $_GET['id'] ?>"></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><input name="enviar" type="submit" class="inputstyle" id="enviar" value="Enviar"></td>
    </tr>
</table>
<?php
}
else
{
    $envio_ok = false;
    
    $conexion = new Conexion();
    $conexion->conectar();

    $anuncio_obj = new Anuncio();

    $anuncio_obj->setId($_GET['id']);

    $info_anuncio = $anuncio_obj->cargarBD_array($conexion);
    
    if ($info_anuncio['anuncio']['email'] != '')
    {
        $br = "<br>";
        $mensaje_email = "$nombre se ha contactado contigo por tu Anuncio '".$info_anuncio['anuncio']['titulo']."'.$br$br".
                   "Mensaje de $nombre:$br$br\"$mensaje\".$br$br".
                   "Para ver tu anuncio entra en esta dirección: <a href='".$url_sitio."ver_anuncio.php?id=".$_REQUEST['id']."'>Ver Anuncio</a>$br$br<a href='$url_sitio'>$nombre_sitio</a>".$br."Compre y Venda de forma fácil y segura";
        $cabeceras = "From: $nombre_sitio - $nombre <$email>\r\nReply-To: $nombre_sitio - $nombre <$email>\r\nContent-type: text/html; charset=latin1";
        
        // print "$mensaje_email<hr>$cabeceras<hr>".$info_anuncio['anuncio']['email']."<hr>";
        
        $envio_ok = @mail($info_anuncio['anuncio']['email'], $asunto, $mensaje_email, $cabeceras);
    }
?>
<table width="800px" border="0" cellspacing="0" cellpadding="3" align="center">
<?php
        if (!$envio_ok)
        {
            foreach ($_REQUEST as $campo => $value)
            {
                if ($campo == 'enviar')
                {
                    continue;
                }
                print "<input type='hidden' name='$campo' value='$value'>\r\n";
            }
?>
    <tr>
        <td class="text3" align="center">No se pudo enviar el Correo Electrónico, inténtelo nuevamente pulsando Enviar</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td align='center'><input name="enviar" type="submit" class="inputstyle" id="enviar" value="Enviar"></td>
    </tr>
<?php
        }
        else
        {
?>
    <tr>
        <td class="text3" align="center">Se envió correctamente el Correo Electrónico al Anunciante</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
<?php
        }
?>
</table>
<?php
}
?>
</form>
<!-- InstanceEndEditable -->
<FOOTER> <!-- site wide footer -->
<table width="800px" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
    	<td><img src="images/bottom.gif" width="800" height="18"></td>
    </tr>
    <tr>
    	<td class="text10" align="center"><a href="index.php" class="a">Home</a> | <a href="crear_anuncio.php" class="a">Crear Anuncio</a> | <a href="misventas/index.php" class="a">Mis Ventas</a> | 
        <a href="se_vende.php" class="a">Se Vende</a> | <a href="se_compra.php" class="a">Se Compra</a> | <a href="ayuda.php" class="a">Ayuda</a></td>
    </tr>
    <tr>
    	<td class="text10" align="center"><br />Copyright &copy; <?php print $nombre_sitio; ?></td>
    </tr>
</table>
</FOOTER> 
</body>
<!-- InstanceEnd --></html>
