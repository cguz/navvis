<?php

//Directorio donde se va almacenar la img o archivo.
$upload_dir = "/var/www";

if (isset($_POST['fileframe'])){

$result = 'ERROR';

if (isset($_FILES['file'])){
if ($_FILES['file']['error'] == UPLOAD_ERR_OK){

//Obteniendo el nombre del archivo
$filename = $_FILES['file']['name'];

//Moviendo el archivo al directorio indicado arriba
move_uploaded_file($_FILES['file']['tmp_name'], $upload_dir.'/'.$filename);

//Cambiando el status del result
$result = 'OK';
}
}

echo '<html><head><title>-</title></head><body>';
echo '<script language="JavaScript" type="text/javascript">'."\n";
echo 'var Doc = window.parent.document;';

if ($result == 'OK'){

//Asignando los valores a los distintos input
echo 'Doc.getElementById("upload_status").value = "El Archivo ha sido cargado…";';
echo 'Doc.getElementById("filenamei").value = "'.$filename.'";';
echo 'Doc.getElementById("img").src="'.$filename.'";';
}
else{
echo 'Doc.getElementById("upload_status").value = "ERROR al Subir Archivo";';
}

echo "\n".'</script></body></html>';

exit();
}
?>

<!– Beginning of main page –>
<html><head>
<title>Subir Archivo con PHP y AJAX</title>
</head>
<body>

<form action="#" target="upload_iframe" method="post" enctype="multipart/form-data">
<input type="hidden" name="fileframe" value="true">
<input type="file" name="file" id="file" onChange="subirArchivo(this)">

</form>

<script type="text/javascript">
function subirArchivo(upload_field){

//Aqui se puede agregar otras extensiones…
var re_text = /\.jpg|\.png|\.gif/i;
var filename = upload_field.value;

// Verificando que el tipo.
if (filename.search(re_text) == -1){
alert("El archivo no es de tipo(.jpg, .png) extension ");
upload_field.form.reset();
return false;
}

upload_field.form.submit();
document.getElementById('upload_status').value = "Subiendo Archivo...";
return true;
}
</script>

<iframe name="upload_iframe" style="width: 400px; height: 100px; display: none;"></iframe><br>

Status:<br>
<input type="text" name="upload_status" id="upload_status" value="No" size="64? disabled>
<br><br>

Nombre del Archivo:<br>
<input type="text" name="filenamei" id="filenamei" value="Ninguno" disabled><br />

<div align="center">
<!–Aqui podemos colocar una imagen por defecto–>
<img id="img" src="" style="border: 1px solid black;margin: 5px;" width="128?/>
</div>
</body>
</html>