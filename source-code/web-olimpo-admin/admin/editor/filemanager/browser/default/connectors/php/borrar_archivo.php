<?php 
/*
 * FCKeditor - The text editor for internet
 * Copyright (C) 2003-2004 Frederico Caldeira Knabben
 * 
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 * 
 * For further information visit:
 * 		http://www.fckeditor.net/
 * 
 * File Name: connector.php
 * 	This is the File Manager Connector for PHP.
 * 
 * Version:  2.0 RC3
 * Modified: 2005-02-08 11:48:55
 * 
 * File Authors:
 * 		Frederico Caldeira Knabben (fredck@fckeditor.net)
 */

include('config.php') ;
include('util.php') ;
include('io.php') ;
include('basexml.php') ;
include('commands.php') ;

// Get the "UserFiles" path.
$GLOBALS["UserFilesPath"] = '' ;

if ( isset( $Config['UserFilesPath'] ) )
	$GLOBALS["UserFilesPath"] = $Config['UserFilesPath'] ;
else if ( isset( $_GET['ServerPath'] ) )
	$GLOBALS["UserFilesPath"] = $_GET['ServerPath'] ;
else
	$GLOBALS["UserFilesPath"] = '' ;

if ( ! ereg( '/$', $GLOBALS["UserFilesPath"] ) )
	$GLOBALS["UserFilesPath"] .= '/' ;

// Map the "UserFiles" path to a local directory.
//$GLOBALS["UserFilesDirectory"] = GetRootPath() . str_replace( '/', '\\', $GLOBALS["UserFilesPath"] ) ;
$GLOBALS["UserFilesDirectory"] = GetRootPath() . $GLOBALS["UserFilesPath"] ;
$url=substr($url,'1');
$ruta=$GLOBALS["UserFilesDirectory"].$url ;
if(unlink($ruta))
{
	echo "<script>alert('El archivo se elimino exitosamente');
		document.location.href='../../frmresourceslist.html?type=media';
	</script>";
	
}else{
	echo "<script>alert('El archivo no se pudo eliminar');</script>";
}

?>