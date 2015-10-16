<?php
include_once "../lib/config.php";

$img_org = false;

if (isset($_GET['imagen']) && $_GET['imagen'] != '')
{
    // $_GET['imagen'] = urldecode($_GET['imagen']);
    $_GET['imagen'] = base64_decode($_GET['imagen']);
    
    // echo $_GET['imagen'];exit;
    
    $info_img = getimagesize($_GET['imagen']);
    
    if ($info_img)
    {
        $info_img['ancho'] = $info_img[0];
        $info_img['alto'] = $info_img[1];
        $info_img['tipo'] = $imagenes_soportadas[$info_img[2]];
        $info_img['mime'] = $info_img['mime'];
    }
    
    if ($info_img['tipo'] == "GIF")
    {
        $img_org = imagecreatefromgif($_GET['imagen']);
    }
    elseif ($info_img['tipo'] == "JPEG")
    {
        $img_org = imagecreatefromjpeg($_GET['imagen']);
    }
    elseif ($info_img['tipo'] == "PNG")
    {
        $img_org = imagecreatefrompng($_GET['imagen']);
    }
}

if ($_GET['ancho'] == "" || !is_numeric($_GET['ancho']))
{
    $ancho = $ancho_thumb;
}
else
{
    $ancho = $_GET['ancho'];
}

if ($_GET['alto'] == "" || !is_numeric($_GET['alto']))
{
    $alto = $alto_thumb;
}
else
{
    $alto = $_GET['alto'];
}

if (!$img_org)
{
    $img_org = imagecreatetruecolor($ancho, $alto); /* Crear una imagen en blanco */
    $bgc = imagecolorallocate($img_org, 255, 255, 255);
    $tc = imagecolorallocate($img_org, 0, 0, 0);
    imagefilledrectangle($img_org, 0, 0, $ancho, $alto, $bgc);
    /* Generar un mensaje de error */
    imagestring($img_org, 5, 5, 5, "Error", $tc);
    imagestring($img_org, 5, 5, 20, "Cargando", $tc);
    imagestring($img_org, 5, 5, 35, "Imagen", $tc);
    
    header("Content-Type: image/gif");

    imagegif($img_org);
}
else
{
    $img_dest = imagecreatetruecolor($ancho, $alto);
    
    imagecopyresampled($img_dest, $img_org, 0, 0, 0, 0, $ancho, $alto, $info_img['ancho'], $info_img['alto']);
    
    if ($info_img['tipo'] == "GIF")
    {
        header("Content-Type: image/gif");
        imagegif($img_dest);
    }
    elseif ($info_img['tipo'] == "JPEG")
    {
        header("Content-Type: image/jpeg");
        imagejpeg($img_dest);
    }
    elseif ($info_img['tipo'] == "PNG")
    {
        header("Content-Type: image/png");
        imagepng($img_dest);
    }
}

?>
