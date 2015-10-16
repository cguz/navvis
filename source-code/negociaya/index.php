<?php
// phpinfo();exit;

include_once "lib/config.php";
include_once "lib/funciones.php";
include_once "lib/clases/conexion.class.php";
include_once "lib/clases/ciudad.class.php";
include_once "lib/clases/categoria.class.php";
// include_once "lib/clases/usuario.class.php";
include_once "lib/clases/anuncio.class.php";
// include_once "lib/clases/imagen.class.php";
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
<br />
<br />
<?php
$vende = '';

if (isset($_REQUEST['vende']) && $_REQUEST['vende'] == 1)
{
    $vende = ': Se Vende';
}
elseif (isset($_REQUEST['vende']) && $_REQUEST['vende'] == 0)
{
    $vende = ': Se Compra';
}
?>
<table width="800px" border="0" cellspacing="0" cellpadding="3" align="center">
    <tr>
        <td width="50px" align="right"><img src="images/vi_titulo.gif" width="18" height="17" /></td>
        <td class="titulo">Anuncios<?php print $vende ?></td>
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
    
    $anuncios = $anuncio->listar_array($conexion, $registros_x_pagina, $inicio, $ordenar_por, $ordenar_dir, array("publicar = 1", $where_buscar, $where_ciudad, $where_categoria_id, $where_vende));
    
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
    <tr>
        <td colspan="2" class="text3" align="right">
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
        <td colspan="2">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="listing">
<?php
    foreach ($anuncios['anuncios'] as $info)
    {
?>
                <tr>
                    <td width="10%" nowrap><?php print $info['fecha'] ?>&nbsp;</td>
                    <td width="5%" nowrap class="text10">
                    <?php
                        if ($info['total_imagenes'] > 0)
                        {
                            if ($fotos == 'si')
                            {
                    ?>
                    <a href="ver_anuncio.php?id=<?php print $info['id'] ?>"><img class="imagen" src="<?php print "./lib/img_mostrar.php?imagen=".base64_encode($info['ruta'])."&ancho=$ancho_thumb&alto=$alto_thumb" ?>" width="<?php print $ancho_thumb ?>" height="<?php print $alto_thumb ?>" /></a>
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
                    <td><a class="g" href="ver_anuncio.php?id=<?php print $info['id'] ?>"><?php print $info['titulo'] ?></a>&nbsp;</td>
                    <td width="10%" align="right"><?php print $info['precio'] ?> &euro;&nbsp;</td>
                    <td width="20%"><?php print $info['categoria_nombre'] ?>&nbsp;</td>
                    <td width="7%"><?php print $info['visitas'] ?>&nbsp;Visita(s)</td>
                </tr>
<?php
    }
?>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2"><hr />
        <input type="hidden" name="fotos" value="<?php print $fotos ?>">
        <input type="hidden" name="total_paginas" value="<?php print $total_paginas ?>">
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
