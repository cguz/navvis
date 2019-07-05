
        <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td>
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
 * File Name: sample01.php
 * 	Sample page.
 * 
 * Version:  2.0 RC3
 * Modified: 2005-02-27 19:35:29
 * 
 * File Authors:
 * 		Frederico Caldeira Knabben (fredck@fckeditor.net)
 */

include("fckeditor.php") ;
?>
		<input type="hidden" name="inc" value="<?=$inc?>">
		<input type="hidden" name="id" value="<?=$id?>">
		<input type="hidden" name="accion" value="<?=$accion?>">
		<input type="hidden" name="sub" value="<?=$subcat?>">
<?php
// Automatically calculates the editor base path based on the _samples directory.
// This is usefull only for these samples. A real application should use something like this:
// $oFCKeditor->BasePath = '/FCKeditor/' ;	// '/FCKeditor/' is the default value.
//$sBasePath = $_SERVER['PHP_SELF'] ;
//$sBasePath = substr( $sBasePath, 0, strpos( $sBasePath, "home.php" ) ) ;
$sBasePath="/olimpo/admin/";
$oFCKeditor = new FCKeditor('FCKeditor1') ;
$oFCKeditor->BasePath	= $sBasePath ;
$oFCKeditor->Value		= '' ;
$oFCKeditor->Create() ;
?>
			</td>
          </tr>
</table>
