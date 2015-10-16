<?php
include_once "../lib/validar_sesion.php";
include_once "../lib/config.php";
include_once "../lib/funciones.php";
include_once "../lib/clases/conexion.class.php";
include_once "../lib/clases/ciudad.class.php";
include_once "../lib/clases/categoria.class.php";
include_once "../lib/clases/usuario.class.php";
include_once "../lib/clases/anuncio.class.php";
include_once "../lib/clases/imagen.class.php";

// print "Request = <pre>";print_r($_REQUEST);print "</pre><hr>";

$conexion = new Conexion();
$conexion->conectar();

$editar = false;
if (isset($_POST['editar']) && $_POST['editar'] == "Editar")
{
    $editar = true;
}

if (isset($_REQUEST['actualizar']) && $_REQUEST['actualizar'] == 'Actualizar')
{
    $actualizar = true;
}

$previsu = false;
if (isset($_POST['previsualizar']) && $_POST['previsualizar'] == "Previsualizar")
{
    $previsu = true;
}

if (!(isset($_REQUEST['id']) && $_REQUEST['id'] != ""))
{
    print "No se recibió el Id del Anuncio a Editar<br /><br /><a href='index.php'>Volver</a>";
    exit;
}
elseif(!$editar && !$previsu && !$actualizar)
{
    if (!$conexion->getEnlace())
    {
        print "No hay conexión con la Base de Datos<br /><br /><a href='index.php'>Volver</a>";
        exit;
    }
    else
    {
        $anuncio = new Anuncio();
        
        $anuncio->setId($_REQUEST['id']);
        
        if ($info_anuncio = $anuncio->cargarBD_array($conexion))
        {
            $info = $info_anuncio['anuncio'];
            $imgs = $info_anuncio['imagenes'];
            
            $_REQUEST['codigo'] = $info['codigo_ciudad'];
            $_REQUEST['particular'] = $info['particular'];
            $_REQUEST['nombre'] = $info['usuario_nombre'];
            $_REQUEST['email'] = $info['email'];
            $_REQUEST['telefono'] = $info['telefono'];
            
            if ($info['mostrar_tel'] == "1")
            {
                $_REQUEST['mostrar_tel'] = 1;
            }
            
            $_REQUEST['categoria_id'] = $info['categoria_id'];
            $_REQUEST['vende'] = $info['vende'];
            $_REQUEST['titulo'] = $info['titulo'];
            $_REQUEST['descripcion'] = $info['descripcion'];
            $_REQUEST['precio'] = $info['precio'];
            
            if (!is_array($imgs))
            {
                $imgs = array();
            }
            
            $_REQUEST['total_imagenes'] = count($imgs);
            
            $i = 0;
            foreach ($imgs as $img)
            {
                $_REQUEST["imagen_$i"] = $img['ruta'];
                $_REQUEST["imagen_url_$i"] = $img['url'];
                
                $nombre_img = basename($img['ruta']);
                $nombre_img = substr($nombre_img, strpos($nombre_img, "_") + 1);
                
                $_REQUEST["imagen_nombre_$i"] = $nombre_img;
                
                $i++;
            }
            
            $editar = true;
        }
        else
        {
            print "No se encontró el Anuncio a Editar<br /><br /><a href='index.php'>Volver</a>";
            exit;
        }
    }
}

if (!isset($_REQUEST['paso']) || $_REQUEST['paso'] == '' || $_REQUEST['paso'] == 'previsualizar' || $editar)
{
    $hay_ciudades   = false;
    $hay_categorias = false;
    if ($conexion->getEnlace())
    {
        $ciudad = new Ciudad();
        
        if (($ciudades = $ciudad->listar($conexion, '', '', 'nombre')))
        {
            $ciudades = $ciudades['objetos'];
            $hay_ciudades = true;
            
        }
        
        $categoria = new Categoria();
        
        if (($categorias_objs = $categoria->listar($conexion, '', '', 'grupo')))
        {
            $categorias_objs = $categorias_objs['objetos'];
            $hay_categorias = true;
            
            foreach ($categorias_objs as $obj)
            {
                $categorias[$obj->getGrupo()][$obj->getId()]= $obj->getNombre();
            }
            
            /*print "categorias = <pre>";print_r($categorias);print "</pre><hr />";
            $categorias = $categorias_objs;*/
        }
    }
}

if ($_REQUEST['paso'] == 'previsualizar' || $editar)
{
    $ok = true;
    $mensaje = '';

    $provincia = '';
    if ($conexion->getEnlace())
    {
        $ciudad_obj = new Ciudad();
        $ciudad_obj->setCodigo($_REQUEST['codigo']);
        
        if ($ciudad_obj->cargarBD($conexion))
        {
            $provincia = $ciudad_obj->getNombre();
        }
        else
        {
            $mensaje .= 'Error al consultar la Provincia<br />';
            $ok = false;
        }
    }
    else
    {
        $mensaje .= 'Error al consultar la Provincia (Conexión)<br />';
        $ok = false;
    }
    
    $particular = $_REQUEST['particular'];
    if ($particular == 1)
    {
        $particular = 'Particular';
    }
    else
    {
        $particular = 'Empresa';
    }
    
    $nombre = $_REQUEST['nombre'];
    $nombre_class = 'inputstyle';
    if ($nombre == '')
    {
        $mensaje .= 'El campo nombre es obligatorio<br />';
        $nombre_class = 'inputstyle_alert';
        $ok = false;
    }
    
    $email = $_REQUEST['email'];
    $email_class = 'inputstyle';
    if ($email == '')
    {
        $mensaje .= 'El campo de Correo Electrónico es obligatorio<br />';
        $email_class = 'inputstyle_alert';
        $ok = false;
    }
    elseif (!valida_email($email))
    {
        $mensaje .= 'El Correo Electrónico introducido no es válido<br />';
        $email_class = 'inputstyle_alert';
        $ok = false;
    }
    
    $telefono = $_REQUEST['telefono'];
    $telefono_class = 'inputstyle';
    $mostrar_tel = "";
    if ($telefono == '')
    {
        $mensaje .= 'El campo teléfono es obligatorio<br />';
        $telefono_class = 'inputstyle_alert';
        $ok = false;
    }
    elseif (isset($_REQUEST['mostrar_tel']))
    {
        $mostrar_tel = "Mostrar teléfono";
    }
    else
    {
        $mostrar_tel = "No mostrar teléfono";
    }
    
    $categoria = '';
    if ($conexion->getEnlace())
    {
        $categoria_obj = new Categoria();
        $categoria_obj->setId($_REQUEST['categoria_id']);
        
        if ($categoria_obj->cargarBD($conexion))
        {
            $categoria = $categoria_obj->getNombre();
        }
        else
        {
            $mensaje .= 'Error al consultar la Categoria<br />';
            $ok = false;
        }
    }
    else
    {
        $mensaje .= 'Error al consultar la Categoria (Conexión)<br />';
        $ok = false;
    }
    
    $vende = $_REQUEST['vende'];
    if ($vende == 1)
    {
        $vende = 'Se Vende';
    }
    else
    {
        $vende = 'Se Compra';
    }
    
    $titulo = $_REQUEST['titulo'];
    $titulo_class = 'inputstyle';
    if ($titulo == '')
    {
        $mensaje .= 'El campo titulo es obligatorio<br />';
        $titulo_class = 'inputstyle_alert';
        $ok = false;
    }
    
    $descripcion = $_REQUEST['descripcion'];
    $descripcion_class = 'areastyle';
    if ($descripcion == '')
    {
        $mensaje .= 'El campo descripción es obligatorio<br />';
        $descripcion_class = 'areastyle_alert';
        $ok = false;
    }
    
    $precio = $_REQUEST['precio'];
    $precio_class = 'inputstyle';
    if ($precio == '')
    {
        $mensaje .= 'El campo precio es obligatorio<br />';
        $precio_class = 'inputstyle_alert';
        $ok = false;
    }
    elseif (!is_numeric($precio))
    {
        $mensaje .= 'El campo precio debe ser numérico<br />';
        $precio_class = 'inputstyle_alert';
        $ok = false;
    }
    
    $quitar_imgs = "No";
    if (isset($_REQUEST['quitar_imgs']))
    {
        $quitar_imgs = "Si";
    }
    
    if (!$ok || $editar)
    {
        $_REQUEST['paso'] = '';
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
<table width="800px" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td><img src="../images/cabecera.gif" alt="<?php print $nombre_sitio; ?>" width="364" height="131" /></td>
        <td><img src="../images/cabecera2.gif" width="436" height="131" /></td>
    </tr>
</table>
<table width="800px" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td><img src="../images/bottom.gif" width="800" height="18"></td>
    </tr>
</table>
<!-- InstanceBeginEditable name="head" -->
<br />
<table width="800px" border="0" cellspacing="0" cellpadding="3" align="center">
    <tr>
        <td width="50px" align="right"><img src="../images/vi_titulo.gif" width="18" height="17" /></td>
        <td class="titulo">Editar Anuncio</td>
    </tr>
</table>
<br />
<form method="post" enctype="multipart/form-data" name="form_anuncio" action="">
<?php
if (!isset($_REQUEST['paso']) || $_REQUEST['paso'] == '')
{
    if ($hay_ciudades && $hay_categorias)
    {
?>
<table width="800px" border="0" cellspacing="0" cellpadding="3" align="center">
<?php
        if ($mensaje != '')
        {
?>
    <tr>
        <td colspan="2" class="text3" align="center">Se encontraron los Siguientes Errores:<br /><br /><span class="text10"><?php print $mensaje ?></span><br /></td>
    </tr>
<?php
        }
?>
    <tr>
        <td width="40%" align="right" valign="top" class="text3">Anuncio de:</td>
        <?php
        if (!isset($_REQUEST['particular']))
        {
            $particular = 1;
        }
        elseif ($particular == "Empresa")
        {
            $particular = 0;
        }
        else
        {
            $particular = 1;
        }
        ?>
        <td class="text7"><label for="particular"><input name="particular" type="radio" id="particular" value="1"<?php if ($particular == "1") print " checked"; ?>>
            Particular</label>
            <label for="empresa"><input type="radio" name="particular" id="empresa" value="0"<?php if ($particular == "0") print " checked"; ?>>
            Empresa</label>
        </td>
    </tr>
    <tr>
        <td align="right" valign="top" class="text3"><span class="text10">*</span> Tu nombre:</td>
        <td><input name="nombre" type="text" class="<?php (isset($nombre_class) && $nombre_class != '' ? print $nombre_class : print "inputstyle") ?>" id="nombre" size="70" value="<?php (isset($nombre) ? print $nombre : print "") ?>"></td>
    </tr>
    <tr>
        <td align="right" valign="top" class="text3"><span class="text10">*</span> Correo Electr&oacute;nico:</td>
        <td class="text7"><input readonly="yes" name="email" type="text" class="<?php (isset($email_class) && $email_class != '' ? print $email_class : print "inputstyle") ?>" id="email" size="70" value="<?php (isset($email) ? print $email : print "") ?>"><br />
            Esta direcci&oacute;n no ser&aacute; p&uacute;blica, es solo para uso interno de <?php print $nombre_sitio; ?></td>
    </tr>
    <tr>
        <td align="right" valign="top" class="text3"><span class="text10">*</span> Tel&eacute;fono:</td>
        <td class="text7"><input name="telefono" type="text" class="<?php (isset($telefono_class) && $telefono_class != '' ? print $telefono_class : print "inputstyle") ?>" id="telefono" size="30" value="<?php (isset($telefono) ? print $telefono : print "") ?>">
        <input type="checkbox" name="mostrar_tel" id="mostrar_tel"<?php (isset($_REQUEST['mostrar_tel']) ? print " checked" : print "") ?>> <label for="mostrar_tel">Mostrar Tel&eacute;fono en el Anuncio.</label></td>
    </tr>
    <tr>
        <td align="right" valign="top" class="text3">Provincia:</td>
        <td>
            <select name="codigo" class="inputstyle">
                <?php
                    $isset = isset($_REQUEST['codigo']);
                    foreach ($ciudades as $obj)
                    {
                        $selected = '';
                        if ($isset && $obj->getCodigo() == $_REQUEST['codigo'])
                        {
                            $selected = 'selected';
                        }
                        print "<option $selected value=\"".$obj->getCodigo()."\">".$obj->getNombre()."</option>\r\n";
                    }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td align="right" valign="top" class="text3">Categor&iacute;a:</td>
        <td>
            <select name="categoria_id" class="inputstyle">
                <?php
                    foreach ($categorias as $nombre_grupo => $grupo)
                    {
                        print "<optgroup class=\"text7\" label=\"-- $nombre_grupo --\">$nombre_grupo</optgroup>\r\n";
                        
                        $isset = isset($_REQUEST['categoria_id']);
                        foreach ($grupo as $id => $nombre)
                        {
                            $selected = '';
                            if ($isset && $id == $_REQUEST['categoria_id'])
                            {
                                $selected = 'selected';
                            }
                            print "<option $selected value=\"$id\">&nbsp;&nbsp;$nombre</option>\r\n";
                        }
                    }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td align="right" valign="top" class="text3">Tipo de Anuncio:</td>
        <td class="text7">
        <?php
        if (!isset($_REQUEST['vende']))
        {
            $vende = 1;
        }
        elseif ($vende == "Se Compra")
        {
            $vende = 0;
        }
        else
        {
            $vende = 1;
        }
        ?>
            <input type="radio" name="vende" id="se_vende" value="1"<?php if ($vende == 1) print " checked"; ?>><label for="se_vende">Se Vende</label>
            <input type="radio" name="vende" id="se_compra" value="0"<?php if ($vende == 0) print " checked"; ?>><label for="se_compra">Se Compra</label>
        </td>
    </tr>
    <tr>
        <td align="right" valign="top" class="text3"><span class="text10">*</span> T&iacute;tulo:</td>
        <td class="text7"><input name="titulo" type="text" class="<?php (isset($titulo_class) && $titulo_class != '' ? print $titulo_class : print "inputstyle") ?>" id="titulo" size="70" value="<?php if (isset($titulo)) print $titulo; ?>"><br />
            No escribas &quot;Se vende&quot; o &quot;Se compra&quot; aqu&iacute;.</td>
    </tr>
    <tr>
        <td align="right" valign="top" class="text3"><span class="text10">*</span> Descripci&oacute;n:</td>
        <td><textarea name="descripcion" id="descripcion" cols="100" rows="10" class="<?php (isset($descripcion_class) && $descripcion_class != '' ? print $descripcion_class : print "areastyle") ?>"><?php if (isset($descripcion)) print $descripcion; ?></textarea></td>
    </tr>
    <tr>
        <td align="right" valign="top" class="text3"><span class="text10">*</span> Precio:</td>
        <td class="text7"><input name="precio" type="text" class="<?php (isset($precio_class) && $precio_class != '' ? print $precio_class : print "inputstyle") ?>" id="precio" size="10" value="<?php if (isset($precio)) print $precio; ?>"> &euro;<br />
            Escriba el precio solo en números.</td>
    </tr>
    <tr>
        <td align="right" valign="top" class="text3">Quitar Imagenes:</td>
        <td class="text7"><input name="quitar_imgs" type="checkbox" <?php if ($quitar_imgs == "Si") print "checked"; ?>/></td>
    </tr>
    <tr>
        <td align="right" valign="top" class="text3">Imagen Principal:</td>
        <td class="text7"><input name="imagen_1" type="file" class="inputstyle" id="imagen_1" size="70"><br />
            El tama&ntilde;o de la Imagen se ajustar&aacute; autom&aacute;ticamente a <?php print $ancho_imagenes."x".$alto_imagenes; ?>.  Solo se permiten im&aacute;genes del tipo <?php print implode("/", $imagenes_soportadas); ?></td>
    </tr>
    <tr>
        <td align="right" valign="top" class="text3">Im&aacute;genes Adicionales:</td>
        <td class="text7"><input name="imagen_2" type="file" class="inputstyle" id="imagen_2" size="70"><br />
            <input name="imagen_3" type="file" class="inputstyle" id="imagen_3" size="70"><br />
            <input name="imagen_4" type="file" class="inputstyle" id="imagen_4" size="70"><br />
            El tama&ntilde;o de las Im&aacute;genes se ajust&aacute;n autom&aacute;ticamente a <?php print $ancho_imagenes."x".$alto_imagenes; ?>.  Solo se permiten im&aacute;genes del tipo <?php print implode("/", $imagenes_soportadas); ?>
        </td>
    </tr>
<?php
        if (isset($_REQUEST['total_imagenes']) && $_REQUEST['total_imagenes'] > 0)
        {
?>
    <tr>
        <td align="right" valign="top" class="text3">Imagenes Subidas:</td>
        <td class="text7"><?php
            for ($i = 0; $i < $_REQUEST['total_imagenes']; $i++)
            {
                $nom_img = $_REQUEST["imagen_nombre_$i"];
                print "&nbsp;* $nom_img<br />";
            }
        ?><span class="text10">Si adiciona otras estas se perderán.</span></td>
    </tr>
<?php
            for ($i = 0; $i < $_REQUEST['total_imagenes']; $i++)
            {
                $ruta = $_REQUEST["imagen_$i"];
                $url = $_REQUEST["imagen_url_$i"];
                $nom_img = $_REQUEST["imagen_nombre_$i"];
                print "<input type='hidden' name='imagen_$i' value='$ruta'>\r\n";
                print "<input type='hidden' name='imagen_url_$i' value='$url'>\r\n";
                print "<input type='hidden' name='imagen_nombre_$i' value='$nom_img'>\r\n";
            }
            $total_img = $_REQUEST['total_imagenes'];
            print "<input type='hidden' name='total_imagenes' value='$total_img'>\r\n";
        }
?>
    <tr>
        <td>&nbsp;</td>
        <td><input name="paso" type="hidden" id="paso" value="previsualizar">
        <input name="id" type="hidden" id="id" value="<?php print $_REQUEST['id'] ?>"></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><input name="previsualizar" type="submit" class="inputstyle" id="previsualizar" value="Previsualizar"></td>
    </tr>
</table>
<?php
    }
    elseif (!$hay_ciudades)
    {
?>
<br />
<table width="800px" border="0" cellspacing="0" cellpadding="3" align="center">
    <tr>
        <td align="center" class="text3">No se pudieron listar las Ciudades</td>
    </tr>
</table>
<br />
<br />
<?php
    }
    else
    {
?>
<br />
<table width="800px" border="0" cellspacing="0" cellpadding="3" align="center">
    <tr>
        <td align="center" class="text3">No se pudieron listar las Categorias</td>
    </tr>
</table>
<br />
<br />
<?php
    }
}
elseif($_REQUEST['paso'] == 'previsualizar')
{
    $mensajes_img = array();
    
    if (isset($_REQUEST['total_imagenes']) && $_REQUEST['total_imagenes'] > 0)
    {
        for ($i = 0; $i < $_REQUEST['total_imagenes']; $i++)
        {
            $nombre_img[] = $_REQUEST["imagen_nombre_$i"];
            $ruta_img[] = $_REQUEST["imagen_$i"];
            $url_img[] = $_REQUEST["imagen_url_$i"];
        }
    }
    else
    {
        $ruta_img = array();
        $url_img = array();
        $nombre_img = array();
    }
    
    $ruta_img_temp = array();
    $url_img_temp = array();
    $nombre_img_temp = array();
    
    foreach ($_FILES as $campo => $info)
    {
        $subir = subir_imagen($info, $error);
        
        if ($subir != false)
        {
            $mensajes_img[$campo] = $info['name']." Subida Exitosamente";
            $ruta_img_temp[] = $subir[0];
            $url_img_temp[] = $url_imagenes.$subir[1];
            $nombre_img_temp[] = $info['name'];
        }
        else
        {
            $mensajes_img[$campo] = $error;
        }
    }
    
    if (count($ruta_img_temp) > 0)
    {
        $ruta_img = $ruta_img_temp;
        $url_img = $url_img_temp;
        $nombre_img = $nombre_img_temp;
    }
?>
<table width="800px" border="0" cellspacing="0" cellpadding="3" align="center">
    <tr>
        <td width="40%" align="right" valign="top" class="text3">Anuncio de:</td>
        <td class="text7"><?php print $particular ?>&nbsp;</td>
    </tr>
    <tr>
        <td align="right" valign="top" class="text3"><span class="text10">*</span> Tu nombre:</td>
        <td class="text7"><?php print $nombre ?>&nbsp;</td>
    </tr>
    <tr>
        <td align="right" valign="top" class="text3"><span class="text10">*</span> Correo Electr&oacute;nico:</td>
        <td class="text7"><?php print $email ?>&nbsp;</td>
    </tr>
    <tr>
        <td align="right" valign="top" class="text3"><span class="text10">*</span> Tel&eacute;fono:</td>
        <td class="text7"><?php print $telefono." (".$mostrar_tel.")" ?>&nbsp;</td>
    </tr>
    <tr>
        <td align="right" valign="top" class="text3">Provincia:</td>
        <td class="text7"><?php print $provincia ?>&nbsp;</td>
    </tr>
    <tr>
        <td align="right" valign="top" class="text3">Categor&iacute;a:</td>
        <td class="text7"><?php print $categoria ?>&nbsp;</td>
    </tr>
    <tr>
        <td align="right" valign="top" class="text3">Tipo de Anuncio:</td>
        <td class="text7"><?php print $vende ?>&nbsp;</td>
    </tr>
    <tr>
        <td align="right" valign="top" class="text3"><span class="text10">*</span> T&iacute;tulo:</td>
        <td class="text7"><?php print $titulo ?>&nbsp;</td>
    </tr>
    <tr>
        <td align="right" valign="top" class="text3"><span class="text10">*</span> Descripci&oacute;n:</td>
        <td class="text7"><?php print nl2br($descripcion) ?>&nbsp;</td>
    </tr>
    <tr>
        <td align="right" valign="top" class="text3"><span class="text10">*</span> Precio:</td>
        <td class="text7"><?php print $precio ?>&nbsp; &euro;</td>
    </tr>
    <tr>
        <td align="right" valign="top" class="text3">Quitar Imagenes:</td>
        <td class="text7"><?php print $quitar_imgs ?>&nbsp;</td>
    </tr>
    <tr>
        <td align="right" valign="top" class="text3">Imágenes:</td>
        <td class="text7">
        <?php
            print implode("<br />", $mensajes_img);
        ?>&nbsp;
        </td>
    </tr>
<?php
        if (isset($_REQUEST['total_imagenes']) && $_REQUEST['total_imagenes'] > 0)
        {
?>
    <tr>
        <td align="right" valign="top" class="text3">Imagenes Subidas:</td>
        <td class="text7"><?php
            foreach ($nombre_img as $i => $nom_img)
            {
                print "* $nom_img<br />";
            }
        ?></td>
    </tr>
<?php
        }
?>
    <tr>
        <td align="right" valign="top" class="text3">Vista Previa Imágenes:</td>
        <td class="text7">
        <?php
            foreach ($url_img as $url)
            {
                print "<br /><img border='1' src='.$url' />";
            }
        ?>&nbsp;
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><input name="actualizar" type="submit" class="inputstyle" id="actualizar" value="Actualizar"> 
        <input name="editar" type="submit" class="inputstyle" id="editar" value="Editar"></td>
    </tr>
</table>
<?php
    foreach ($_REQUEST as $campo => $value)
    {
        if ($campo == 'paso')
        {
            $value = 'actualizar';
        }
        elseif ($campo == 'previsualizar')
        {
            continue;
        }
        print "<input type='hidden' name='$campo' value='$value'>\r\n";
    }
    foreach ($ruta_img as $i => $ruta)
    {
        print "<input type='hidden' name='imagen_$i' value='$ruta'>\r\n";
    }
    foreach ($url_img as $i => $url)
    {
        print "<input type='hidden' name='imagen_url_$i' value='$url'>\r\n";
    }
    foreach ($nombre_img as $i => $nom_img)
    {
        print "<input type='hidden' name='imagen_nombre_$i' value='$nom_img'>\r\n";
    }
    $total_img = count($ruta_img);
    print "<input type='hidden' name='total_imagenes' value='$total_img'>\r\n";
}
elseif ($actualizar)
{
    $mensaje = '';
    $usuario_ok = false;
    $anuncio_ok = false;
    $contrasena_hidden = true;
    
    if ($conexion->getEnlace())
    {
        $conexion->iniciarTransaccion();
        
        $usuario = new Usuario();
        $usuario_pa_buscar = new Usuario();
        $usuario_pa_buscar->setEmail($_REQUEST['email']);
        
        $usuario->setNombre($_REQUEST['nombre']);
        $usuario->setTelefono($_REQUEST['telefono']);
        $usuario->setMostrar_tel((isset($_REQUEST['mostrar_tel']) ? 1 : 0));
        
        if ($usuario_pa_buscar->cargarBD($conexion, true))
        {
            $usuario->setId($usuario_pa_buscar->getId());
            
            // print $usuario_pa_buscar->getContrasena()." | ".$usuario->getContrasena()." | ".$usuario->getContrasena(true)."<hr>";
            
            if ($usuario->editar($conexion) !== FALSE)
            {
                $mensaje .= "Se Editó la información del Usuario<br />";
                $usuario_ok = true;
            }
            else
            {
                $mensaje .= "No se pudo Editar la información del Usuario<br />";
            }
        }
        
        if ($usuario_ok)
        {
            $anuncio = new Anuncio();
            
            $anuncio->setId($_REQUEST['id']);
            $anuncio->setCodigo_ciudad($_REQUEST['codigo']);
            $anuncio->setParticular($_REQUEST['particular']);
            $anuncio->setCategoria_id($_REQUEST['categoria_id']);
            $anuncio->setVende($_REQUEST['vende']);
            $anuncio->setTitulo($_REQUEST['titulo']);
            $anuncio->setDescripcion($_REQUEST['descripcion']);
            $anuncio->setPrecio($_REQUEST['precio']);
            $anuncio->setUsuario_id($usuario->getId());
            $anuncio->setPublicar(0);
            $anuncio->setRevisado(0);
            
            if ($anuncio->editar($conexion) !== FALSE)
            {
                $mensaje .= "Se Editó la información del Anuncio<br />";
                $anuncio_ok = true;
            }
            else
            {
                $mensaje .= "No se pudo Actualizar la información del Anuncio.  Verifica que el título no se sea igual a otro anuncio creado por ti o ponte en contacto con nosotros<br />";
            }
        }
        
        if ($anuncio_ok)
        {
            $imagen_obj = new Imagen();
            
            if ($imagen_obj->eliminar($conexion, $_REQUEST['id']))
            {
                if (!isset($_REQUEST['quitar_imgs']))
                {
                    $imagen_obj->setAnuncio_id($anuncio->getId());
                    
                    for ($i = 0; $i < $_REQUEST['total_imagenes']; $i++)
                    {
                        $imagen_obj->setRuta($_REQUEST['imagen_'.$i]);
                        $imagen_obj->setUrl($_REQUEST['imagen_url_'.$i]);
                        
                        if (!$imagen_obj->guardar($conexion))
                        {
                            $mensaje .= "No se pudo Guardar la Imagen ".($i + 1)."<br />";
                        }
                    }
                }
                else
                {
                    $mensaje .= "Se eliminaron las imagenes relacionadas<br />";
                }
            }
            else
            {
                $mensaje .= "No se pudo Actualizar las imagenes, intente editar nuevamente el Anuncio<br />";
            }
        }
    }
    else
    {
        $mensaje .= "No hay conexión con la Base de Datos, intente nuevamente<br />";
    }
?>
<table width="800px" border="0" cellspacing="0" cellpadding="3" align="center">
<?php
        if ($mensaje != '')
        {
?>
    <tr>
        <td colspan="2" class="text3" align="center"><br /><?php print $mensaje ?><br /></td>
    </tr>
<?php
        }
?>
    <tr>
        <td width="40%">&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
<?php
        if ($usuario_ok && $anuncio_ok)
        {
            $conexion->finalizarTransaccion();
?>
    <tr>
        <td colspan="2" align="center" class="text7">Se ha editado el Anuncio con éxito, este será evaluado por nuestro personal quienes te enviarán un correo electrónico de confirmación.</td>
    </tr>
<?php
        }
        else
        {
            $conexion->finalizarTransaccion(false);
?>
    <tr>
        <td>&nbsp;</td>
        <td class="text7">Ocurrió un error al Actualizar el Anuncio, presiona Actualizar para intentarlo nuevamente</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><input name="actualizar" type="submit" class="inputstyle" id="actualizar" value="Actualizar"> 
        <input name="editar" type="submit" class="inputstyle" id="editar" value="Editar"></td>
    </tr>
<?php
            foreach ($_REQUEST as $campo => $value)
            {
                if ($campo == 'paso')
                {
                    $value = 'actualizar';
                }
                elseif ($campo == 'actualizar')
                {
                    continue;
                }
                print "<input type='hidden' name='$campo' value='$value'>\r\n";
            }
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
