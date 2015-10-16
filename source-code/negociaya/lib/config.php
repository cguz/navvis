<?php
/*
Tipos de imágenes:

 1 IMAGETYPE_GIF 
 2 IMAGETYPE_JPEG 
 3 IMAGETYPE_PNG 
 4 IMAGETYPE_SWF 
 5 IMAGETYPE_PSD 
 6 IMAGETYPE_BMP 
 7 IMAGETYPE_TIFF_II (intel byte order) 
 8 IMAGETYPE_TIFF_MM (motorola byte order)  
 9 IMAGETYPE_JPC 
10 IMAGETYPE_JP2 
11 IMAGETYPE_JPX 
12 IMAGETYPE_JB2 
13 IMAGETYPE_SWC 
14 IMAGETYPE_IFF 
15 IMAGETYPE_WBMP 
16 IMAGETYPE_XBM 
*/

// Tipos de imagenes soportados
// Si se modifican se debe moficar la función de subir imagen en la parte de redimensionamiento ubicada en funciones.php
$imagenes_soportadas = array(IMAGETYPE_GIF => "GIF", IMAGETYPE_JPEG => "JPEG", IMAGETYPE_PNG => "PNG");

// URL y nombre del sitio Web, se utiliza para los links de los mensajes de correo electrónico
$url_sitio = "http://es.negociaya.com/";
$nombre_sitio = "Negocia Ya";
$remitente_admin = "no-reply@negociaya.com";

// Fin de linea para los mensajes enviados por email
$br = "<br>";
// Mensaje de publicado, el que se envia por email
$mensaje_publicado = "Tu Anuncio ha sido publicado en $nombre_sitio.$br$br|<comentario>|".
                     "Para ver tu anuncio entra en esta dirección: <a href='".$url_sitio."ver_anuncio.php?id=|<id>|'>Ver Anuncio</a>$br$br".
                     "Para editar tu anuncio entra en esta dirección y digita tu email y contraseña: <a href='".$url_sitio."misventas/login.php'>Login</a>$br$br".
                     "<a href='$url_sitio'>$nombre_sitio</a>".$br."Compre y Venda de forma fácil y segura";
// Comentario del email cuando se publica un anuncio
$comentario_publicado = "El administrador del sitio te ha escrito el siguiente comentario:$br$br\"|<comentario>|\".$br$br";

// Mensaje de no publicado, el que se envia por email
$mensaje_no_publicado = "Tu Anuncio no ha sido publicado en $nombre_sitio.$br$br".
           "El administrador del sitio te ha escrito el siguiente comentario:$br$br\"|<comentario>|\".$br$br".
           "Para editar tu anuncio entra en esta dirección y digita tu email y contraseña: <a href='".$url_sitio."misventas/login.php'>Login</a>$br$br".
           "Una vez edites tu Anuncio el administrador del sitio le hará una nueva revisión.$br$br".
           "<a href='$url_sitio'>$nombre_sitio</a>".$br."Compre y Venda de forma fácil y segura";

// Rutas donde se guardarán las imágenes
$url_imagenes = "./archivos/";
$ruta_imagenes = "/home/negociay/public_html/es/archivos/";
// $ruta_imagenes = "D:/Documentos/my_desarrollo/AnunciosOnLine/source/archivos/";
// $ruta_imagenes = "/home/jeyson/domains/cuenta1.homelinux.com/public_html/anunciosonline/archivos/";

// Ancho y alto de las imágenes subidas
$ancho_imagenes = 500;
$alto_imagenes = 400;
$ancho_thumb = 100;
$alto_thumb = 80;

// Tamaño máximo de la imagen (bytes)
$tamano_max_img = 5 * 1024 * 1024;// 5 Megas

// Tamaño mínimo de la contraseña
$min_contrasena = 5;

// Número de registros por página
$registros_x_pagina = 50;
// $registros_x_pagina = 10;

// Tiempo en horas de duración de la cookie que controla las visitas de un anuncio
$duracion_cookie = 2;
?>
