<?

if ( ! function_exists ( 'mime_content_type' ) )
{
   function mime_content_type ( $f )
   {
       return trim ( exec ('file -bi ' . escapeshellarg ( $f ) ) ) ;
   }
}


function ConvertBMP2GD($src, $dest = false) {
	if(!($src_f = fopen($src, "rb"))) {
		return false;
	}
	if(!($dest_f = fopen($dest, "wb"))) {
		return false;
	}
		$header = unpack("vtype/Vsize/v2reserved/Voffset", fread($src_f,14));
		$info = unpack("Vsize/Vwidth/Vheight/vplanes/vbits/Vcompression/Vimagesize/Vxres/Vyres/Vncolor/Vimportant",
		fread($src_f, 40));
	
		extract($info);
		extract($header);
	
		if($type != 0x4D42) { // signature "BM"
		return false;
	}
	
		$palette_size = $offset - 54;
		$ncolor = $palette_size / 4;
		$gd_header = "";
		// true-color vs. palette
		$gd_header .= ($palette_size == 0) ? "\xFF\xFE" : "\xFF\xFF";
		$gd_header .= pack("n2", $width, $height);
		$gd_header .= ($palette_size == 0) ? "\x01" : "\x00";
		if($palette_size) {
			$gd_header .= pack("n", $ncolor);
		}
		// no transparency
		$gd_header .= "\xFF\xFF\xFF\xFF";
	
		fwrite($dest_f, $gd_header);
	
		if($palette_size) {
			$palette = fread($src_f, $palette_size);
			$gd_palette = "";
			$j = 0;
			while($j < $palette_size) {
				$b = $palette{$j++};
				$g = $palette{$j++};
				$r = $palette{$j++};
				$a = $palette{$j++};
			$gd_palette .= "$r$g$b$a";
			}
			$gd_palette .= str_repeat("\x00\x00\x00\x00", 256 - $ncolor);
			fwrite($dest_f, $gd_palette);
		}
	
	$scan_line_size = (($bits * $width) + 7) >> 3;
	$scan_line_align = ($scan_line_size & 0x03) ? 4 - ($scan_line_size &
	0x03) : 0;
	
	for($i = 0, $l = $height - 1; $i < $height; $i++, $l--) {
	// BMP stores scan lines starting from bottom
	fseek($src_f, $offset + (($scan_line_size + $scan_line_align) *
	$l));
	$scan_line = fread($src_f, $scan_line_size);
	if($bits == 24) {
	$gd_scan_line = "";
	$j = 0;
	while($j < $scan_line_size) {
	$b = $scan_line{$j++};
	$g = $scan_line{$j++};
	$r = $scan_line{$j++};
	$gd_scan_line .= "\x00$r$g$b";
	}
	}
	else if($bits == 8) {
	$gd_scan_line = $scan_line;
	}
	else if($bits == 4) {
	$gd_scan_line = "";
	$j = 0;
	while($j < $scan_line_size) {
	$byte = ord($scan_line{$j++});
	$p1 = chr($byte >> 4);
	$p2 = chr($byte & 0x0F);
	$gd_scan_line .= "$p1$p2";
	}
	$gd_scan_line = substr($gd_scan_line, 0, $width);
	}
	else if($bits == 1) {
	$gd_scan_line = "";
	$j = 0;
	while($j < $scan_line_size) {
	$byte = ord($scan_line{$j++});
	$p1 = chr((int) (($byte & 0x80) != 0));
	$p2 = chr((int) (($byte & 0x40) != 0));
	$p3 = chr((int) (($byte & 0x20) != 0));
	$p4 = chr((int) (($byte & 0x10) != 0));
	$p5 = chr((int) (($byte & 0x08) != 0));
	$p6 = chr((int) (($byte & 0x04) != 0));
	$p7 = chr((int) (($byte & 0x02) != 0));
	$p8 = chr((int) (($byte & 0x01) != 0));
	$gd_scan_line .= "$p1$p2$p3$p4$p5$p6$p7$p8";
	}
			$gd_scan_line = substr($gd_scan_line, 0, $width);
		}

		fwrite($dest_f, $gd_scan_line);
	}
	fclose($src_f);
	fclose($dest_f);
	return true;
}

function imagecreatefrombmp($filename) {
	$tmp_name = tempnam("/tmp", "GD");
	if(ConvertBMP2GD($filename, $tmp_name)) {
		$img = imagecreatefromgd($tmp_name);
	unlink($tmp_name);
		return $img;
	}
	return false;
}

function guardaJPG($imagen,$modo,$tamMaxH="600",$tamMaxV="600",$marca="")
{
	//header("Content-Disposition: inline; filename=imagito.jpg;"); //Sirve para nombrar la imagen
	if(!isset($imagen))
		$imagen = '';
	else 
		$imagen = urldecode($imagen); 
	
	if(!isset($modo))
		$modo = '';
	else 
		$modo = $modo; 
		
	if(empty($imagen) || !file_exists($imagen)) { /* Si no se ha enviado una imagen como parámetro o 		                                                    esta no existe, enviaremos una imagen de error */ 

		//header("Content-Disposition: inline; filename=noimage.jpg;"); //Sirve para nombrar la imagen
		
		$im = imagecreate ( 100 , 70 ); // Tamaño de la imagen 

		$bg = imagecolorallocate ( $im , 255 , 255 , 255 ); // El primer color que indiquemos será el                                                               color de fondo
		$textcolor = imagecolorallocate ( $im , 0 , 0 , 0 ); // Color negro para el texto 

		imagestring ( $im , 2 , 25 , 18 , "Imagen no" , $textcolor );
		imagestring ( $im , 2 , 22 , 38 , "disponible" , $textcolor ); // Escribimos "Imagen no disponible" en la imagen

		imagejpeg($im,$imagen,90); // Mostramos la imagen por pantalla con una calidad de 90
		imagedestroy($im); 

	}else{
		
		$extensionTmp = end(explode(".", $imagen));
		
		//$src_img= @imagecreatefromgif($imagen);
		//$src_img= @imagecreatefromjpeg($imagen);
		if(strcasecmp($extensionTmp,"gif")==0)
		{
			$src_img= @imagecreatefromgif($imagen);
			//$inTmp = str_replace(".gif",".jpg",strtolower($imagen));
			$inTmp = preg_replace("/(\.gif)/i",".jpg",$imagen);
			rename($imagen,$inTmp);
			$imagen = $inTmp;
		}
		else if(strcasecmp("png", $extensionTmp)==0)
		{
			$src_img= @imagecreatefrompng($imagen);
			//$inTmp = str_replace(".png",".png",$imagen);
			//$inTmp = str_replace(".PNG",".png",$imagen);
			$inTmp = preg_replace("/(\.png)/i",".jpg",$imagen);
			rename($imagen,$inTmp);
			$imagen = $inTmp;
		}
		else if(strcasecmp("bmp", $extensionTmp)==0)
		{
			$src_img= @imagecreatefrombmp($imagen);
			//$inTmp = str_replace(".bmp",".bmp",strtolower($imagen));
			$inTmp = preg_replace("/(\.bmp)/i",".jpg",$imagen);
			rename($imagen,$inTmp);
			$imagen = $inTmp;
		}
		else
			$src_img= @imagecreatefromjpeg($imagen);
		
		if($modo == "peque")
		{
			$ancho = ImageSX($src_img)*0.33; //escalamos el tamano al 33%;
			$alto = ImageSY($src_img)*0.33; //escalamos el tamano al 33%;
			//$imname = substr($imname,0,strpos($imname,".")) . "Mini.jpg"; //El nombre indicará q es miniatura.
		}
		 else
		 if($modo == "cartel")
		 {
			
			$alto = 200; //escalamos el alto a 140 px;
			$ratio = 200.0/ImageSY($src_img);
			$ancho = ImageSX($src_img)*$ratio; //escalamos el ancho al ratio;
			//$imname = substr($imname,0,strpos($imname,".")) . "Mini.jpg"; //El nombre indicará q es miniatura.
		 }
		 else
		 if($modo == "peque2")
		{
			$ancho = ImageSX($src_img)*0.25; //escalamos el tamano al 25%;
			$alto = ImageSY($src_img)*0.25; //escalamos el tamano al 25%;
			//$imname = substr($imname,0,strpos($imname,".")) . "Mini.jpg"; //El nombre indicará q es miniatura.
		}
		else if($modo == "maximo")
		{
			$tamMax = 90;
			if(isset($tamMaxH))
				$tamMax = $tamMaxH;
				
			$ancho = ImageSX($src_img); 
			$alto = ImageSY($src_img);
			
			$ratio = $ancho / $alto;
			
			if($ratio >= 1) //Es mas ancho que alto;
			{
				$ancho = $tamMax;
				$alto = $tamMax / $ratio;
			}	
			else //es mas alto que ancho
			{
				$alto = $tamMax;
				$ancho = $tamMax * $ratio;
			}
			
			//$imname = substr($imname,0,strpos($imname,".")) . "Mini.jpg"; //El nombre indicará q es miniatura.
		}
		else if($modo == "maximoBi")
		{	
			//$tamMaxH = 90;
			//$tamMaxV = 90;
			if(!isset($tamMaxH))
				$tamMaxH = 90;
			if(!isset($tamMaxV))
				$tamMaxV = 90;
				
			$ancho = ImageSX($src_img); 
			$alto = ImageSY($src_img);
			
			if(($ancho > $tamMaxH) or ($alto > $tamMaxV))
			{
				$ratio = $ancho / $alto;
				
				if($ratio >= 1) //Es mas ancho que alto;
				{
					$ancho = $tamMaxH;
					$alto = $tamMaxH / $ratio;
				}	
				else //es mas alto que ancho
				{
					$alto = $tamMaxV;
					$ancho = $tamMaxV * $ratio;
				}
			}
			
			//$imname = substr($imname,0,strpos($imname,".")) . "Mini.jpg"; //El nombre indicará q es miniatura.
		}
		else
		{
			$ancho = ImageSX($src_img); //en este caso no se escala (tamaño original)
			$alto = ImageSY($src_img); //en este caso no se escala (tamaño original)
		} 
		
		//header("Content-Disposition: inline; filename=".$imname.";"); //Sirve para nombrar la imagen
		$dst_img = @imagecreatetruecolor($ancho, $alto); //creamos la imgen destino
	
		@imagecopyresized($dst_img, $src_img, 0,0,0,0, $ancho, $alto, ImageSX($src_img), ImageSY($src_img)); 
		
		//$bg = imagecolorallocate ( $dst_img , 255 , 255 , 255 );
		$textcolor = imagecolorallocate ( $dst_img , 200 , 0 , 0 );
		@imagestring ( $dst_img , 13 , 3 , 3 , $marca , $textcolor );
	
		imagejpeg($dst_img,$imagen);
		@imagedestroy($dst_img); 
	}
	
		if(!empty($imagen))
	{
		if(!strrchr ($imagen, "/")) //Sacamos el nombre de la imagen de la ruta completa.
			$imname = $imagen;
		else
			$imname = substr (strrchr ($imagen, "/"), 1 );
	}
	
	return $imname;
}
?>