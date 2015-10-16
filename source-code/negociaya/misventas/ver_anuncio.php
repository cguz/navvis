<?php
if (!isset($_GET['id']) || $_GET['id'] == '')
{
    header("Location: index.php");
}

// print $_SERVER['SCRIPT_FILENAME']."<hr>";

include_once "../lib/config.php";
include_once "../lib/funciones.php";
include_once "../lib/clases/conexion.class.php";
include_once "../lib/clases/anuncio.class.php";

$conexion = new Conexion();
$conexion->conectar();

$anuncio_obj = new Anuncio();

$anuncio_obj->setId($_GET['id']);

$info_anuncio = $anuncio_obj->cargarBD_array($conexion);

// print "info_anuncio = <pre>";print_r($info_anuncio);print "</pre><hr>";

/*
if ($info_anuncio)
{
    $ip = str_replace(".", "_", $_SERVER["REMOTE_ADDR"]);
    
    if ((isset($_SERVER["REMOTE_ADDR"]) && $_SERVER["REMOTE_ADDR"] != '') && !isset($_COOKIE["anuncios_".$ip."_".$_GET['id']]))
    {
        if ($duracion_cookie > 0)
        {
            setcookie("anuncios_".$ip."_".$_GET['id'], "true", mktime(date("H") + $duracion_cookie, date("i"), date("s"), date("m"), date("d"), date("Y")));
        }
        
        $anuncio_obj->aumentarVisitas($conexion);
    }
// print "_COOKIE = <pre>";print_r($_COOKIE);print "</pre><hr>";
// print "_REQUEST = <pre>";print_r($_REQUEST);print "</pre><hr>";
// print "anuncios_".$ip."_".$_GET['id']." = '".$_COOKIE["anuncios_".$ip."_".$_GET['id']]."'<hr>";
}
*/
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
<?php
// print "info_anuncio = <pre>";print_r($info_anuncio);print "</pre><hr>";

if ($info_anuncio)
{
    $anuncio = $info_anuncio['anuncio'];
    $imagenes = $info_anuncio['imagenes'];
?>
<table width="800px" border="0" cellspacing="0" cellpadding="2" align="center">
    <tr>
        <td class="titulo">
        <img src="../images/vi_titulo.gif" width="18" height="17" />
        <?php
        if ($anuncio['vende'] == '1')
        {
            print "Se Vende: ".$anuncio['titulo'];
        }
        else
        {
            print "Se Compra: ".$anuncio['titulo'];
        }
        ?>
        <br /><br />
        </td>
    </tr>
    <tr>
        <td class="text7"><?php print $anuncio['visitas'] ?>&nbsp;Visita(s)<br /><br /></td>
    </tr>
<?php
    if ($imagenes)
    {
?>
    <tr>
        <td><img class="imagen2" name="imagen_a_cambiar" id="imagen_a_cambiar" src="<?php print "../lib/img_mostrar.php?imagen=".base64_encode($imagenes[0]['ruta'])."&ancho=$ancho_imagenes&alto=$alto_imagenes" ?>" width="<?php print $ancho_imagenes ?>" height="<?php print $alto_imagenes ?>" /></td>
    </tr>
<?php
        if (count($imagenes) > 1)
        {
?>
    <tr>
        <td>
<?php
            foreach ($imagenes as $imagen)
            {
?>
            <a href="#nogo" onclick="changeImages('imagen_a_cambiar', '<?php print "../lib/img_mostrar.php?imagen=".base64_encode($imagen['ruta'])."&ancho=$ancho_imagenes&alto=$alto_imagenes" ?>')"><img class="imagen" src="<?php print "../lib/img_mostrar.php?imagen=".base64_encode($imagen['ruta'])."&ancho=$ancho_thumb&alto=$alto_thumb" ?>" width="<?php print $ancho_thumb ?>" height="<?php print $alto_thumb ?>" /></a> 
<?php
            }
?>
        </td>
    </tr>
<?php
        }
    }
?>
    <tr>
        <td class="text11"><?php print nl2br($anuncio['descripcion']) ?><br /><br /></td>
    </tr>
    <tr>
        <td class="text7">
        <?php
        if ($anuncio['particular'] == '1')
        {
            print "Este Anuncio es de un Particular en la Provincia de ".$anuncio['ciudad_nombre'].".";
        }
        else
        {
            print "Este Anuncio es de una Empresa en la Provincia de ".$anuncio['ciudad_nombre'].".";
        }
        ?>
        </td>
    </tr>
    <tr>
        <td class="text7">Fecha: <span class="text9"><?php print $anuncio['fecha'] ?></span></td>
    </tr>
    <tr>
        <td class="text7">Categoria: <span class="text9"><?php print $anuncio['grupo']." -&gt; <a href='../index.php?categoria_id=".$anuncio['categoria_id']."' class='a'>".$anuncio['categoria_nombre']."</a>" ?></span></td>
    </tr>
    <tr>
        <td class="text7">Precio: <span class="text9"><?php print $anuncio['precio'] ?> &euro;</span></td>
    </tr>
    <tr>
        <td class="text9"><a target="_blank" href="../escribir_anunciante.php?id=<?php print $anuncio['id'] ?>" class="a">Escribir al Anunciante</a></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
</table>
<?php
}
else
{
?>
<table width="800px" border="0" cellspacing="0" cellpadding="2" align="center">
    <tr>
        <td align="right" width="40px"><img src="../images/vi_titulo.gif" width="18" height="17" /></td>
        <td class="titulo">
        Ver Anuncio
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td class="text3">No se encontró información del Anuncio seleccionado</td>
    </tr>
</table>
<?php
}
?>
<br /><br />
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
</FOOTER> 
</body>
<!-- InstanceEnd --></html>
