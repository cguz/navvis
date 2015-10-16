<?
	include "clases/Consultadb.php";
	$consulta= new ConsultaBD;
	$con = $consulta->conectar();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilo/admin.css" rel="stylesheet" type="text/css">
<title>::: SISTEMA ADMINISTRATIVO:::</title>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
<script>
	var maximo = 1000;
	var cant=0;
	var ind=0;
	var id_editar=-1;
	var num_sel=0;
	var tot=0;
	var colores = new Array(maximo);//Defino un arreglo de 100 posiciones para guardar los colores
	var popup;
	
	function comando2(color){
		if(id_editar>=0){
			if(document.getElementById("fondo"+id_editar).style.background=="")
				cant++;
			document.getElementById("fondo"+id_editar).style.background=color;
			document.getElementById("td"+id_editar).style.background="";
			colores[id_editar]=color;
			num_sel--;
			id_editar=-1;
		}else
		{
			if(document.getElementById("fondo"+cant)==null){
				insertar_filas(1);
				document.getElementById("fondo"+cant).style.background=color;
				colores[cant]=color;
				cant++;
			}else{
				document.getElementById("fondo"+cant).style.background=color;
				colores[cant]=color;
				cant++;
			}
		}
		document.getElementById("capa1").style.visibility="hidden";
		ind=0;	
		return;
	}
	
	function insertar_filas(num){
		var cadena="";
		var aux2;
		for(var j=0;j<num;j++){
			cadena="<table width='100%'  border='0' cellspacing='0' cellpadding='4'><tr>";
			aux=tot;
			for(var i=0;i<4;i++){
				cadena=cadena+"<td whidth='63' height='30' id=\"td"+aux+"\" onclick=\"javasctipt:editar('"+aux+"')\" align='center'><div id=\"fondo"+aux+"\" style=\"width:55px; height:40px;\">&nbsp;</div></td>";
				aux++;
			}
			cadena=cadena+"</tr><tr>";
			aux=tot;
			aux2=0;
			for(i=0;i<4;i++){
				cadena=cadena+"<td id=\"nom"+aux+"\" align='center'><input name=\"color["+aux+"]\" type=\"text\" id=\"color["+aux+"]\" size=\"7\"><input type='checkbox' name='selec["+aux+"]' value='1'></td>";
				aux++;
				aux2++;
			}
			tot=tot+aux2;
			cadena=cadena+"</tr></table>";
		
			document.getElementById("filas").innerHTML=document.getElementById("filas").innerHTML + cadena;
		}
	}
	
	function editar(id){
		if(num_sel==0){
			id_editar=id;
//			if(document.getElementById("fondo"+id_editar).style.background=="")
//
			document.getElementById("td"+id_editar).style.background="#efefef";
			num_sel++;
		}
		else if(document.getElementById("td"+id_editar).style.background=="#efefef"){
			document.getElementById("td"+id_editar).style.background="";
			num_sel--;
			id_editar=-1;
		}
			
	}
	
	function mostrar(){
		if(ind==0){
			popup = window.open("./pick.php","pick","Top=70, Left=250, width=310, height=210, resizable=no, scrollbars=no");
			//document.getElementById("capa1").style.visibility="visible";
			ind=1;
		}
		else{
			ind=0;
			document.getElementById("capa1").style.visibility="hidden";
		}
	}
	
	function quitar(){
		if(id_editar>=0)
		{
			document.getElementById("fondo"+id_editar).style.background="";
			colores[id_editar]="";
			//document.form1.color[id_editar].value="";
			document.getElementById("td"+id_editar).style.background="";
			id_editar=-1;
			cant--;
			num_sel--;
		}else
			alert("No ha seleccionado el color a quitar");
	}
	
	function enviar(){
		for(var i=0;i<maximo;i++){
			if(colores[i]){
				if(document.form1.colores.value=="")
					document.form1.colores.value=colores[i] + "@" + i;
				else
					document.form1.colores.value=document.form1.colores.value + "|" + colores[i] + "@" + i;
			
			}
		}
		document.form1.submit();
	}
	
	function cerr_paleta(){
		if(popup)
			popup.close();
	}
</script>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body onUnload="javascript:cerr_paleta()">
 <div id="capa1" style="position:absolute; width:210px; height:120px; z-index:1; top: 39px; left: 149px; visibility: hidden;">
	
</div>
 <form name="form1" method="post" action="edt_admin/guardar_carta.php">
 <input type="hidden" name="colores">
 <input type="hidden" name="id_producto" value="<?=$id_producto?>">
   <table width="430" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#F4F4F4">
     <tr>
       <td width="390" height="29" bgcolor="#FF0000"><div align="center" class="letrasb"><strong>Paleta de Colores </strong></div></td>
     </tr>
     <tr>
       <td height="315" valign="top" bgcolor="#FFFFFF">
         <table width="428" border="0" align="center" cellpadding="0" cellspacing="1">
           <tr>
             <td bgcolor="#EFEFEF"><div align="left">
			   <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                 <tr>
                   <td width="50%">Adicionar Nuevo Color <a href="javascript:mostrar();"><img src="imagenes/bgcolor.gif" width="21" height="21" border="0"></a> </td>
                   <td width="50%">
                     <div align="center">
                       <input type="button" name="Submit" value="Quitar Color" onClick="javascript:quitar()">
                     </div></td>
                 </tr>
                 <tr>
                   <td height="25" colspan="2" bgcolor="#FFFFFF">
				   <div style="width:430; height:290px; overflow:auto;">
				   <table width="95%"  border="0" cellspacing="0" cellpadding="0">
                     <tr>
                       <td><?
		   	$sql="SELECT * FROM pro_cartas ORDER BY codigo";
			$res=DoSQL::Obtener_Filas($sql);
			$sql="SELECT id_color FROM pro_carta_producto WHERE id_producto=$id_producto";
			$cprod=DoSQL::Obtener_Columna($sql);
			$total=0;
			$i=0;
			$fila=next($res);
                        $num=count($res)/4;
                        $ent=$num;
                        settype($ent,"integer");
                        if($ent!=$num)
                                $ent++;
			for($p=0;$p<$ent;$p++){
                                $fila=$res[$i];
				echo"<table width='100%'  border='0' cellspacing='0' cellpadding='4'><tr>";
				$aux=$total;
				if(in_array($fila[0],$cprod)) 
					$ch='checked';
				else
					$ch='';
				$campo0[0]="<td whidth='73' height='30' id=\"td$aux\" onclick=\"javasctipt:editar('$aux')\" align='center'><div id=\"fondo$aux\" style=\"width:55px; height:40px; background:".$fila[1].";\">&nbsp;</div></td>";
				$campo0[1]="<td id=\"nom$aux\" align='right'><input name=\"color[$aux]\" type=\"text\" id=\"color[$aux]\" size=\"6\" value='".$fila[2]."'><input type='checkbox' name='selec[$aux]' value='$fila[0]' $ch></td>";
				echo "<script>colores[$i]=\"".$fila[1]."\"</script>";
				$aux++;
				$i++;
				$fila=$res[$i];
				if(in_array($fila[0],$cprod)) 
					$ch='checked';
				else
					$ch='';
				$campo1[0]="<td whidth='73' height='30' id=\"td$aux\" onclick=\"javasctipt:editar('$aux')\" align='center'><div id=\"fondo$aux\" style=\"width:55px; height:40px; background:".$fila[1].";\">&nbsp;</div></td>";
				$campo1[1]="<td id=\"nom$aux\" align='right'><input name=\"color[$aux]\" type=\"text\" id=\"color[$aux]\" size=\"6\" value='".$fila[2]."'><input type='checkbox' name='selec[$aux]' value='$fila[0]' $ch></td>";
				echo "<script>colores[$i]=\"".$fila[1]."\"</script>";
				$aux++;
				$i++;
				$fila=$res[$i];
				if(in_array($fila[0],$cprod)) 
					$ch='checked';
				else
					$ch='';
				$campo2[0]="<td whidth='73' height='30' id=\"td$aux\" onclick=\"javasctipt:editar('$aux')\" align='center'><div id=\"fondo$aux\" style=\"width:55px; height:40px; background:".$fila[1].";\">&nbsp;</div></td>";
				$campo2[1]="<td id=\"nom$aux\" align='right'><input name=\"color[$aux]\" type=\"text\" id=\"color[$aux]\" size=\"6\" value='".$fila[2]."'><input type='checkbox' name='selec[$aux]' value='$fila[0]' $ch></td>";
				echo "<script>colores[$i]=\"".$fila[1]."\"</script>";
				$i++;
				$aux++;
				$fila=$res[$i];
				if(in_array($fila[0],$cprod)) 
					$ch='checked';
				else
					$ch='';
				$campo3[0]="<td whidth='73' height='30' id=\"td$aux\" onclick=\"javasctipt:editar('$aux')\" align='center'><div id=\"fondo$aux\" style=\"width:55px; height:40px; background:".$fila[1].";\">&nbsp;</div></td>";
				$campo3[1]="<td id=\"nom$aux\" align='right'><input name=\"color[$aux]\" type=\"text\" id=\"color[$aux]\" size=\"6\" value='".$fila[2]."'><input type='checkbox' name='selec[$aux]' value='1' $ch></td>";
				echo "<script>colores[$i]=\"".$fila[1]."\"</script>";
				$aux++;
				$i++;
				$fila=next($res);
				echo $campo0[0]."
					".$campo1[0]."
					".$campo2[0]."
					".$campo3[0];
				echo "</tr><tr>";
				echo $campo0[1]."".$campo1[1]."".$campo2[1]."".$campo3[1];
				echo "</tr></table>";
				$total=$total+4;
			}
			echo "<script>tot=".$total."; cant=".$total.";</script>"
		   ?>
                       </td>
                     </tr>
                     <tr>
                       <td><div id="filas" name="filas"></div></td>
                     </tr>
                   </table>
				   </div></td>
                  </tr>
               </table>
             </div></td>
           </tr>
       </table>
	   </td>
     </tr>
     <tr>
       <td height="28"><div align="center">
         <input type="button" name="Submit" value="Guardar" onClick="enviar()">
       </div></td>
     </tr>
   </table>
 </form>
 <?
 $consulta->desconectar($con);
 ?>
</body>
</html>