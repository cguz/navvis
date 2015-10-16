<?php
include_once "config.php";

function valida_email($str)
{
    $at = "@";
    $dot = ".";
    $lat = strpos($str, $at);
    $lstr = strlen($str);
    $ldot = strpos($str, $dot);
    
    if ($lat == FALSE)
    {
       return false;
    }

    if ($lat === FALSE || $lat == 0 || $lat == $lstr)
    {
       return false;
    }

    if ($ldot === FALSE || $ldot == 0 || $ldot == $lstr)
    {
        return false;
    }

    if (strpos(substr($str, $lat + 1), $at) !== FALSE)
    {
        return false;
    }

    if (substr($str, $lat - 1, $lat) == $dot || substr($str, $lat + 1, $lat + 2) == $dot)
    {
        return false;
    }

    if (strpos(substr($str, $lat + 2), $dot) === FALSE)
    {
        return false;
    }
    
    if (strpos($str, " ") !== FALSE)
    {
        return false;
    }

     return true;
}


// Valida el que la imagen subida sea de un tipo aceptado
// Retorna falso o la información de la imagen
function validar_imagen($info_imagen, &$error)
{
    global $imagenes_soportadas;
    
    if ($info_imagen['tmp_name'] != "")
    {
        $_info = getimagesize($info_imagen['tmp_name']);
        
        $info_retornar = false;
        
        if ($_info)
        {
            if (array_key_exists($_info[2], $imagenes_soportadas))
            {
                $info_retornar = array();
                
                $info_retornar['ancho'] = $_info[0];
                $info_retornar['alto'] = $_info[1];
                $info_retornar['tipo'] = $imagenes_soportadas[$_info[2]];
                $info_retornar['mime'] = $_info['mime'];
            }
            else
            {
                $error = "El archivo subido no es una imagen soportada, los tipos de imagen soportados son ".implode("/", $imagenes_soportadas);
            }
        }
        else
        {
            $error = "No se pudo validar el tipo del archivo ".$info_imagen['name'].", al parecer no es un archivo de imagen";
        }
    }
    else
    {
        $error = "No se recibió archivo";
    }
    
    return $info_retornar;
}

// Sube la imágen al directoria destinado para ello
function subir_imagen($info_imagen, &$error)
{
    global $ancho_imagenes, $alto_imagenes, $ruta_imagenes, $tamano_max_img, $imagenes_soportadas;
    
    $error = '';
    
    if ($tam_img = validar_imagen($info_imagen, $error))
    {
        if ($info_imagen['size'] > $tamano_max_img)
        {
            $error = "La imagen subida ocupa mas espacio del permitido, El tamaño máximo es de ".($tamano_max_img / 1024 / 1024)." Mb";
        }
        else
        {
            $nombre_imagen_base = mktime()."_".$info_imagen['name'];
            $nombre_imagen = $ruta_imagenes.$nombre_imagen_base;
            
            if (!move_uploaded_file($info_imagen['tmp_name'], $nombre_imagen))
            {
                $error = "El archivo ".$info_imagen['name']." no pudo ser movido";
            }
            else
            {
                // redimensionamiento
                if ($tam_img['ancho'] > $ancho_imagenes || $tam_img['alto'] > $alto_imagenes)
                {
                    $img_org = false;
                    
                    if ($tam_img['tipo'] == "GIF")
                    {
                        $img_org = imagecreatefromgif($nombre_imagen);
                    }
                    elseif ($tam_img['tipo'] == "JPEG")
                    {
                        $img_org = imagecreatefromjpeg($nombre_imagen);
                    }
                    elseif ($tam_img['tipo'] == "PNG")
                    {
                        $img_org = imagecreatefrompng($nombre_imagen);
                    }
                    
                    $img_dest = imagecreatetruecolor($ancho_imagenes, $alto_imagenes);
                    
                    if ($img_org && $img_dest)
                    {
                        if (imagecopyresampled($img_dest, $img_org, 0, 0, 0, 0, $ancho_imagenes, $alto_imagenes, $tam_img['ancho'], $tam_img['alto']))
                        {
                            $img = false;
                            
                            if ($tam_img['tipo'] == "GIF")
                            {
                                $img = imagegif($img_dest, $nombre_imagen);
                            }
                            elseif ($tam_img['tipo'] == "JPEG")
                            {
                                $img = imagejpeg($img_dest, $nombre_imagen, 90);
                            }
                            elseif ($tam_img['tipo'] == "PNG")
                            {
                                $img = imagepng($img_dest, $nombre_imagen, 8);
                            }
                            
                            if (!$img)
                            {
                                $error = "Error (3) redimensionando la imagen ".$info_imagen['name'];
                            }
                        }
                        else
                        {
                            $error = "Error (2) redimensionando la imagen ".$info_imagen['name'];
                        }
                    }
                    else
                    {
                        $error = "Error (1) redimensionando la imagen ".$info_imagen['name'];
                    }
                }
                
                return array($nombre_imagen, $nombre_imagen_base);
            }
        }
    }
    
    return ($error == '' ? $nombre_imagen : false);
}
?>
