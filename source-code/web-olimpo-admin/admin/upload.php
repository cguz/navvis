
<?php

	require_once("../web/inmuebles/confi/dp.php");
	require_once("../guardajpg.php");

	//conecta();
	
	  $I = 0;
	  if ($_POST["I"]!="")
	  	$I = $_POST["I"];
	  else
		  if ($_GET["I"]!="")
		  	$I = $_GET["I"];
	  
	 conecta();
      $status = "";
	  if ($_GET["Opcion"])
	  {
	  	$II = $_GET['II'];
		$sql="DELETE FROM inmueble_inmobiliaria_imagenes WHERE Id=$II";
		
		$rs = mysql_query($sql);
	  }
	  
      if ($_POST["action"] == "upload") {
          // obtenemos los datos del archivo
          $tamano = $_FILES["archivo"]['size'];
          $tipo = $_FILES["archivo"]['type'];
          $archivo = $_FILES["archivo"]['name'];
          $prefijo = substr(md5(uniqid(rand())),0,6);
		
		if(($_FILES['archivo']['name'] != "") && !(strpos($_FILES['archivo']['type'],"image") === false)){
				
				// guardamos el archivo a la carpeta files
				$destino =  "files/".$prefijo."_".$archivo;
			  	$destino1 = "../".$destino;
				if (copy($_FILES['archivo']['tmp_name'],$destino1)) {
					//$imagen =  guardaImagen('imagen', DIR_IMG_PRE."/");
					//$imagen =  guardaJPG($_FILES['archivo']['tmp_name'],"maximoBi",300,220, "rutaDestino/");
					$imagen =  guardaJPG($destino1,"maximoBi",300,220);
					
					$sql = "Select count(nombre) total from inmueble_inmobiliaria_imagenes where Id_inmueble=$I";
					$rs = mysql_query($sql);
					$row = mysql_fetch_object($rs);
					
					$valor=$row->total;
					
					if ($valor<6)
					{
						$sql="INSERT INTO inmueble_inmobiliaria_imagenes (Id_inmueble, nombre, estado) VALUES ($I, '$destino', 0)";	
						 $rs = mysql_query($sql);
					}
				} else {
					$status = "Error al subir el archivo";
				}
			}	
	}
	$sql = "Select Id, nombre from inmueble_inmobiliaria_imagenes where Id_inmueble=$I";
	$rs = mysql_query($sql);
	$i=0;
	$j=0;
	$status = $status."<table width='80%' border='0' cellspacing='0' cellpadding='0'><tr>";
	
	while($row=mysql_fetch_object($rs)){ 
	
		$i++;
		$j++;
		$status=$status."<td><b><img src='../img.php?file=$row->nombre&ancho=80&alto=80&cut&mark=false' /><a href='upload.php?Opcion=E&II=$row->Id&I=$I'><img src='./imagenes/delete.gif' border='0' alt='Eliminar'></a></b></br></td>";
			if ($i==3)
			{
				$status=$status."</tr><tr height=10><td colspan=3></td></tr><tr>";
				$i=0;
			}
	}
	$faltante="";
	if ($i<3)
		$faltante="</tr>";
	while ($i<3)
	{
		$status = $status."<td></td>";
		$i++;
	}
	$status = $status.$faltante."</table>";
		
	if ($j==9){
?>
            <p>Maximo de imagenes permitidas.<a href="edt_admin/index.html" target="_parent" >Inicio</a></p>
			
			<hr />
<?php
	  }else {
?>
<form enctype="multipart/form-data" method="post" action="upload.php">
  <input name="archivo" type="file" size="35" />
  <input id="I" name="I" type="hidden" size="20" tabindex="12" value="<?php echo $I;?>" />
        <input name="enviar" type="submit" value="Subir imagen" />
        <input name="action" type="hidden" value="upload" />     

</form><hr />

<?php 
	  }
echo "<div align=center>".$status."</div>";
?>