<?php
include_once "../lib/validar_sesion.php";
include_once "../lib/config.php";
include_once "../lib/funciones.php";
include_once "../lib/clases/conexion.class.php";
include_once "../lib/clases/ciudad.class.php";
include_once "../lib/clases/categoria.class.php";
include_once "../lib/clases/anuncio.class.php";

// print "REQUEST = <pre>";print_r($_REQUEST);print "</pre><hr>";
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
<br />
<br />
<?php
$vende = '';

if (isset($_REQUEST['vende']) && $_REQUEST['vende'] === "1")
{
    $vende = ': Se Vende';
}
elseif (isset($_REQUEST['vende']) && $_REQUEST['vende'] === "0")
{
    $vende = ': Se Compra';
}
?>
<table width="800px" border="0" cellspacing="0" cellpadding="3" align="center">
    <tr>
        <td width="50px">&nbsp;</td>
        <td align="right" class="text3">Bienvenid@ <?php print sesion_valorVariable("nombre") ?> | <a class="g" href="../lib/cerrar_sesion.php">Cerrar Sesión</a></td>
    </tr>
    <tr>
        <td width="50px" align="right"><img src="../images/vi_titulo.gif" width="18" height="17" /></td>
        <td class="titulo">Administar Anuncios<?php print $vende ?></td>
    </tr>
</table>
<br />
<form method="post" name="form_lista_anuncios" action="">
<br />
<?php

$conexion = new Conexion();
$conexion->conectar();

$ciudad = new Ciudad();

if (($ciudades = $ciudad->listar($conexion, '', '', 'nombre')))
{
    $ciudades = $ciudades['objetos'];
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
}

$error = '';
?>
<table width="800px" cellspacing="0" cellpadding="5" align="center" class="caja_buscar">
    <tr>
        <td class="text3" align="center">
            Buscar: <input name="buscar" value="<?php print $_REQUEST['buscar'] ?>" class="inputstyle" size="25" /> 
            Provincia: <select name="codigo_ciudad" class="inputstyle">
                <option value="">---</option>
                <?php
                    $isset = isset($_REQUEST['codigo_ciudad']);
                    foreach ($ciudades as $obj)
                    {
                        $selected = '';
                        if ($isset && $obj->getCodigo() == $_REQUEST['codigo_ciudad'])
                        {
                            $selected = 'selected';
                        }
                        print "<option $selected value=\"".$obj->getCodigo()."\">".$obj->getNombre()."</option>\r\n";
                    }
                ?>
            </select> 
            Categorias: <select name="categoria_id" class="inputstyle">
                <option value="">---</option>
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
            Tipo: <select name="vende" class="inputstyle">
                <option value=""<?php if ($_REQUEST['vende'] == "") print " selected"; ?>>---</option>
                <option value="1"<?php if ($_REQUEST['vende'] == "1") print " selected"; ?>>Se Vende</option>
                <option value="0"<?php if ($_REQUEST['vende'] == "0") print " selected"; ?>>Se Compra</option>
            </select> 
            <input type="submit" name="btn_buscar" value="Buscar" class="inputstyle" />
        </td>
    </tr>
</table>
<br />
<?php

if ($conexion->getEnlace())
{
    $anuncio = new Anuncio();
    
    $mensaje = "";
    if ($_REQUEST['publicar'] == 'Publicar' || $_REQUEST['no_publicar'] == 'No Publicar' || $_REQUEST['eliminar'] == 'Eliminar')
    {
        if ($_REQUEST['publicar'] == 'Publicar' && is_array($_REQUEST['checks'])) // && $_REQUEST['comentario'] != ""
        {
            $anuncio->setPublicar('1');
            $anuncio->setComentario($_REQUEST['comentario']);
            
            $emails = array();
            if ($anuncio->publicar($conexion, $_REQUEST['checks'], $emails))
            {
                $mensaje = "Se publicaron exitosamente los Anuncios seleccionados";
                
                foreach ($emails as $mail)
                {
                    $mensaje_publicado_temp = $mensaje_publicado;
                    
                    if ($_REQUEST['comentario'] == "")
                    {
                        $mensaje_publicado_temp = str_replace("|<comentario>|", "", $mensaje_publicado_temp);
                    }
                    else
                    {
                        $comentario_publicado_temp = str_replace("|<comentario>|", $_REQUEST['comentario'], $comentario_publicado);
                        $mensaje_publicado_temp = str_replace("|<comentario>|", $comentario_publicado_temp, $mensaje_publicado_temp);
                    }
                    
                    $mensaje_publicado_temp = str_replace("|<id>|", $mail['id'], $mensaje_publicado_temp);
                    
                    $cabeceras = "From: $nombre_sitio <$remitente_admin>\r\nContent-type: text/html; charset=latin1";
                    
                    @mail($mail['nombre']." <".$mail['email'].">", "$nombre_sitio - Se ha publicado tu Anuncio!", $mensaje_publicado_temp, $cabeceras);
                }
            }
            else
            {
                $mensaje = "Ocurrió un error al intentar publicar los anuncios seleccionados";
            }
        }
        elseif($_REQUEST['publicar'] == 'Publicar' && (!is_array($_REQUEST['checks']))) // || $_REQUEST['comentario'] == ""
        {
            $mensaje = "Debe seleccionar por lo menos un Anuncio";
        }
        
        if ($_REQUEST['no_publicar'] == 'No Publicar' && is_array($_REQUEST['checks']) && $_REQUEST['comentario'] != "")
        {
            $anuncio->setPublicar('0');
            $anuncio->setComentario($_REQUEST['comentario']);
            
            $emails = array();
            if ($anuncio->publicar($conexion, $_REQUEST['checks'], $emails))
            {
                $mensaje = "Se quitaron de publicación los Anuncios seleccionados";
                
                $br = "<br>";
                foreach ($emails as $mail)
                {
                    $mensaje_no_publicado_temp = str_replace("|<comentario>|", $_REQUEST['comentario'], $mensaje_no_publicado);
                    
                    $cabeceras = "From: $nombre_sitio <$remitente_admin>\r\nContent-type: text/html; charset=latin1";
                    
                    @mail($mail['nombre']." <".$mail['email'].">", "$nombre_sitio - No se ha publicado tu Anuncio", $mensaje_no_publicado_temp, $cabeceras);
                }
            }
            else
            {
                $mensaje = "Ocurrió un error al intentar quitar de publicación los anuncios seleccionados";
            }
        }
        elseif($_REQUEST['no_publicar'] == 'No Publicar' && (!is_array($_REQUEST['checks']) || $_REQUEST['comentario'] == ""))
        {
            $mensaje = "Debe seleccionar por lo menos un Anuncio y escribir un comentario";
        }
        
        if ($_REQUEST['eliminar'] == 'Eliminar' && is_array($_REQUEST['checks']))
        {
            if ($anuncio->eliminar_varios($conexion, $_REQUEST['checks']))
            {
                $mensaje = "Se Eliminaron los Anuncios seleccionados";
            }
            else
            {
                $mensaje = "Ocurrió un error al intentar Eliminar los anuncios seleccionados";
            }
        }
        elseif($_REQUEST['eliminar'] == 'Eliminar')
        {
            $mensaje = "Debe seleccionar por lo menos un Anuncio";
        }
    }
    
    $pagina = isset($_REQUEST['pagina']) ? $_REQUEST['pagina'] : 1;
    $inicio = ($pagina - 1) * $registros_x_pagina;
    $ordenar_por = isset($_REQUEST['orderby']) ? $_REQUEST['orderby'] : 'fecha';
    $ordenar_dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'DESC';
    $mostrando = "";
    $total_paginas = 0;
    
    $fotos = isset($_REQUEST['fotos']) ? $_REQUEST['fotos'] : 'si';
    
    $where_buscar = (isset($_REQUEST['buscar']) && $_REQUEST['buscar'] != '') ? "(titulo LIKE '%".$_REQUEST['buscar']."%' OR precio LIKE '%".$_REQUEST['buscar']."%' OR categoria.nombre LIKE '%".$_REQUEST['buscar']."%')" : '';
    $where_ciudad = (isset($_REQUEST['codigo_ciudad']) && $_REQUEST['codigo_ciudad'] != '') ? "codigo_ciudad = '".$_REQUEST['codigo_ciudad']."'" : '';
    $where_categoria_id = (isset($_REQUEST['categoria_id']) && $_REQUEST['categoria_id'] != '') ? "categoria.id = ".$_REQUEST['categoria_id'] : '';
    
    $where_vende = (isset($_REQUEST['vende']) && $_REQUEST['vende'] != '') ? "vende = '".$_REQUEST['vende']."'" : '';
    
    $where_usuario_id = "";
    if (sesion_valorVariable("administrador") <= 0)
    {
        $where_usuario_id = "usuario_id = ".sesion_valorVariable("id");
    }
    
    $anuncios = $anuncio->listar_array($conexion, $registros_x_pagina, $inicio, $ordenar_por, $ordenar_dir, array($where_buscar, $where_ciudad, $where_categoria_id, $where_vende, $where_usuario_id));
    
    // print "anuncios['anuncios'] = <pre>";print_r($anuncios['anuncios']);print "</pre><hr>";
    
    if (!$anuncios)
    {
        $error = "No hay anuncios disponibles";
    }
    else
    {
        $total_paginas = ceil($anuncios['total_bd'] / $registros_x_pagina);
        $registros_en_pag = ($anuncios['total_bd'] < ($inicio + $registros_x_pagina) ? $anuncios['total_bd'] : ($inicio + $registros_x_pagina));
        $mostrando = "Mostrando ".($inicio + 1)." - ".$registros_en_pag." de ".$anuncios['total_bd']." Anuncio(s)";
        
        $primera = 1;
        $siguiente = ($pagina + 1) > $total_paginas ? $total_paginas : ($pagina + 1);
        $anterior = ($pagina - 1) < 1 ? 1 : ($pagina - 1);
        $ultima = $total_paginas;
    }
}
else
{
    $error = "No hay conexión con la Base de Datos";
}

?>
<table width="800px" border="0" cellspacing="0" cellpadding="0" align="center">
<?php
if ($error == "")
{
?>
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
        <td class="text3">
        <?php
        if (sesion_valorVariable("administrador") > 0)
        {
        ?>
        <a href="#nogo" class="a" onclick="todos()">Todos</a> | <a href="#nogo" class="a" onclick="ninguno()">Ninguno</a> | 
        <input name="publicar_boton" id="publicar_boton" type="button" class="inputstyle" value="Publicar" onclick="publicar_clic()" /> 
        <input name="no_publicar_boton" id="no_publicar_boton" type="button" class="inputstyle" value="No Publicar" onclick="no_publicar_clic()" />
        <?php
        }
        ?>
        <input name="eliminar" type="submit" class="inputstyle" value="Eliminar" onclick="return confirm('Confirma que desea eliminar los Anuncios Seleccionados?')" />
        </td>
        <td class="text3" align="right">
            <?php
            if ($fotos == "no")
            {
            ?>
            <a href="#nogo" class="a" onClick="clic_fotos('si')">Ver Fotos</a>
            <?php
            }
            else
            {
            ?>
            <a href="#nogo" class="a" onClick="clic_fotos('no')">Ocultar Fotos</a>
            <?php
            }
            ?>
             | Ordenar Por: 
            <select name="orderby" class="inputstyle">
                <option value="fecha"<?php if ($ordenar_por == "fecha") print " selected"; ?>>Fecha</option>
                <option value="precio"<?php if ($ordenar_por == "precio") print " selected"; ?>>Precio</option>
                <option value="titulo"<?php if ($ordenar_por == "titulo") print " selected"; ?>>Titulo</option>
                <option value="visitas"<?php if ($ordenar_por == "visitas") print " selected"; ?>>Visitas</option>
                <option value="revisado"<?php if ($ordenar_por == "revisado") print " selected"; ?>>Revisado</option>
            </select>
             | Orden: 
            <select name="dir" class="inputstyle">
                <option value="DESC"<?php if ($ordenar_dir == "DESC") print " selected"; ?>>Descendente</option>
                <option value="ASC"<?php if ($ordenar_dir == "ASC") print " selected"; ?>>Ascendente</option>
            </select>
            <input type="submit" name="recargar" value="Recargar" class="inputstyle" />
        </td>
    </tr>
    <tr>
        <td colspan="2"><hr /></td>
    </tr>
    <tr>
        <td colspan="2" id="td_comentario" style="display:none">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="listing">
                <tr>
                    <td align="right" valign="top" class="text3" width="30%"><span class="text10">*</span> Comentario:</td>
                    <td><textarea name="comentario" id="comentario" cols="100" rows="10" class="areastyle"><?php if (isset($comentario)) print $comentario; ?></textarea></td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input name="publicar" id="publicar" type="submit" class="inputstyle" value="Publicar" /> 
                        <input name="no_publicar" id="no_publicar" type="submit" class="inputstyle" value="No Publicar" /> 
                        <input name="cancelar_comentario" id="cancelar_comentario" type="button" class="inputstyle" value="Cancelar" onclick="cancelar_clic()" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><hr /></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="listing">
<?php
    $i = 0;
    foreach ($anuncios['anuncios'] as $info)
    {
?>
                <tr <?php if ($info['revisado'] == "0") print "class='norevisado'"; ?>>
                    <td width="3%"><input name="checks[]" id="check_<?php print $i ?>" type="checkbox" value="<?php print $info['id'] ?>" /></td>
                    <td width="3%">
                    <?php
                    if ($info['publicar'] > 0)
                    {
                        $imagen = "../images/publicado.gif";
                        $img_alt = "Publicado";
                    }
                    else
                    {
                        $imagen = "../images/no_publicado.gif";
                        $img_alt = "No Publicado";
                    }
                    ?>
                    <img src="<?php print $imagen ?>" class="imagen2" alt="<?php print $img_alt ?>" />
                    </td>
                    <td width="10%" nowrap><?php print $info['fecha'] ?>&nbsp;</td>
                    <td width="5%" nowrap class="text10">
                    <?php
                        if ($info['total_imagenes'] > 0)
                        {
                            if ($fotos == 'si')
                            {
                    ?>
                    <a target='_blank' href="../ver_anuncio.php?id=<?php print $info['id'] ?>"><img class="imagen" src="<?php print "../lib/imagen.php?imagen=".base64_encode($info['ruta'])."&ancho=$ancho_thumb&alto=$alto_thumb" ?>" width="<?php print $ancho_thumb ?>" height="<?php print $alto_thumb ?>" /></a>
                    <?php
                            }
                            else
                            {
                                print "(".$info['total_imagenes']." Fotos)";
                            }
                        }
                        else
                        {
                            print "(Sin Fotos)";
                        }
                    ?>
                    &nbsp;</td>
                    <td><a target='_blank' class="g" href="../ver_anuncio.php?id=<?php print $info['id'] ?>"><?php print $info['titulo'] ?></a>&nbsp;</td>
                    <td width="10%" align="right"><?php print $info['precio'] ?> &euro;&nbsp;</td>
                    <td width="20%"><?php print $info['categoria_nombre'] ?>&nbsp;</td>
                    <td width="7%"><?php print $info['visitas'] ?>&nbsp;Visita(s)</td>
                    <td width="10%"><a class="a" target="_blank" href="editar_anuncio.php?id=<?php print $info['id'] ?>">Editar</a>&nbsp;</td>
                </tr>
<?php
        $i++;
    }
?>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2"><hr />
        <input type="hidden" name="fotos" value="<?php print $fotos ?>">
        <input type="hidden" name="total_paginas" value="<?php print $total_paginas ?>">
        <input type="hidden" name="total_mostrados" value="<?php print $i ?>">
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center" class="text3">
        <a href="#nogo" class="a" onClick="clic_pagina('<?php print $primera ?>')">&lt;&lt;Primera</a> <a href="#nogo" class="a" onClick="clic_pagina('<?php print $anterior ?>')">&lt;Anterior</a> | 
        <?php print $mostrando ?> | 
        Página <input type="text" size="2" name="pagina" value="<?php print $pagina ?>" class="inputstyle"> de <?php print $total_paginas ?> 
        <input type="button" onClick="clic_pagina(document.forms[0].pagina.value)" name="ir" value="Ir" class="inputstyle"> | 
        <a href="#nogo" class="a" onClick="clic_pagina('<?php print $siguiente ?>')">Siguiente&gt;</a> <a href="#nogo" class="a" onClick="clic_pagina('<?php print $ultima ?>')">Última&gt;&gt;</a>
        </td>
    </tr>
<?php
}
else
{
?>
    <tr>
        <td class="text3" align="center"><?php print $error ?><br /></td>
    </tr>
<?php
}
?>
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
</FOOTER> 
</body>
<!-- InstanceEnd --></html>
