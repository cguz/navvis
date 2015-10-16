<?
	if(!$id)
	{
		$accion="insertar";
		$validar_form1="onSubmit='return validar_password(this.password,this.confirmar)'";	
	}else{
		$accion="actualizar";	
		$validar_form2="onSubmit='return validar_password(this.password,this.confirmar)'";	
	}
	//echo $id;
	$datos=$inmuebles->ObtenerDatosInmue($id);
	$datos1=$clientes->ObtenerDatosCli($datos[0]);
	//$id_grp_usr=$usuarios->ObtenerGrpUsr($id);
?>
<script type="text/javascript" language="javascript1.2">
function puntitos(donde,caracter){
	pat = /[\*,\+,\(,\),\?,\.,\,$,\[,\],\^]/
	valor = donde.value
	largo = valor.length
	crtr = true
	if(isNaN(caracter) || pat.test(caracter) == true){
		if (pat.test(caracter)==true){ 
			caracter = "\\" + caracter
		}
		carcter = new RegExp(caracter,"g")
		valor = valor.replace(carcter,"")
		donde.value = valor
		crtr = false
	}
	else{
		var nums = new Array()
		cont = 0
		for(m=0;m<largo;m++){
			if(valor.charAt(m) == "." || valor.charAt(m) == " ")
				{continue;}
			else{
				nums[cont] = valor.charAt(m)
				cont++
			}
		}
	}
	var cad1="",cad2="",tres=0
	if(largo > 3 && crtr == true){
		for (k=nums.length-1;k>=0;k--){
			cad1 = nums[k]
			cad2 = cad1 + cad2
			tres++
			if((tres%3) == 0){
				if(k!=0){
					cad2 = "" + cad2
				}
			}
		}
		donde.value = cad2
	}
}
</script>
<script src="scripts/calendario.js" type="text/javascript" language="javascript">
</script>
<form name="form1" method="post" action="home.php" <?=$validar_form1?>>
<input type="hidden" name="inc" value="<?=$inc?>">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="Id_cliente" value="<?=$datos1[0]?>">
<input type="hidden" name="sub" value="guardar_inmue">
<input type="hidden" name="accion" value="<?=$accion?>">
<table width="317" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#DDDDDD">
  <tr bgcolor="#CCCCCC">
    <td colspan="2"><div align="center"><strong>Datos del Cliente </strong></div></td>
  </tr>
  <tr>
    <td width="149" bgcolor="#EEEEEE"><div align="right"><strong>Nombre:</strong></div></td>
    <td width="153" bgcolor="#FFFFFF">
      
        <div align="center">
          <input name="nombre2" type="text" id="nombre2" size="25" value="<?=$datos1[1]?>" />
      </div></td>
  </tr>
  <tr>
    <td bgcolor="#EEEEEE"><div align="right"><strong>Apellidos:</strong></div></td>
    <td bgcolor="#FFFFFF"><div align="center">
      <input name="apellido2" type="text" id="apellido2" size="25" value="<?=$datos1[2]?>" />
    </div></td>
  </tr>
  <tr>
    <td bgcolor="#EEEEEE"><div align="right"><strong>Telefono:</strong></div></td>
    <td bgcolor="#FFFFFF"><div align="center">
      <input name="telefono2" type="text" id="telefono2" size="25" value="<?=$datos1[3]?>" />
    </div></td>
  </tr>
  <tr>
    <td bgcolor="#EEEEEE"><div align="right"><strong>Telefono Movil:</strong></div></td>
    <td bgcolor="#FFFFFF"><div align="center">
      <input name="celular2" type="text" id="celular2" size="25" value="<?=$datos1[5]?>" />
    </div></td>
  </tr>
  <tr>
    <td bgcolor="#EEEEEE"><div align="right"><strong>Correo electronico:</strong></div></td>
    <td bgcolor="#FFFFFF"><div align="center">
      <input name="email2" type="text" id="email2" size="25" value="<?=$datos1[4]?>" />
    </div></td>
  </tr>
  <tr>
    <td bgcolor="#EEEEEE"><div align="right"><strong>Ciudad: </strong></div></td>
    <td bgcolor="#FFFFFF"><div align="center">
        <input name="ciudad2" type="text" id="ciudad2" size="25" value="<?=$datos1[8]?>" />
    </div></td>
  </tr>
  <tr>
    <td bgcolor="#EEEEEE"><div align="right"><strong>C&oacute;digo postal : </strong></div></td>
    <td bgcolor="#FFFFFF"><div align="center">
        <input name="codigopostal2" type="text" id="codigopostal2" size="25" value="<?=$datos1[7]?>" />
    </div></td>
  </tr>
  <tr>
    <td height="52" valign="top" bgcolor="#EEEEEE"><div align="right"><strong>Direcci&oacute;n:</strong></div></td>
    <td bgcolor="#FFFFFF"><div align="center">
      <textarea name="direccion2" cols="22" rows="4" id="direccion2"><?=$datos1[6]?></textarea>
    </div></td>
  </tr>
  <tr>
    <td bgcolor="#EEEEEE"><div align="right"><strong>Numero:</strong></div></td>
    <td bgcolor="#FFFFFF"><div align="center">
        <input name="numero2" onKeyPress="return acceptNum(event)" type="text" id="numero2" size="25" value="<?=$datos1[11]?>" />
    </div></td>
  </tr>
  <tr>
    <td bgcolor="#EEEEEE"><div align="right"><strong>Planta:</strong></div></td>
    <td bgcolor="#FFFFFF"><div align="center">
      <input name="planta2" type="text" id="planta2" size="25" value="<?=$datos1[13]?>" />
    </div></td>
  </tr>
  <tr>
    <td bgcolor="#EEEEEE"><div align="right"><strong>Puerta:</strong></div></td>
    <td bgcolor="#FFFFFF"><div align="center">
        <input name="puerta2" type="text" id="puerta2" size="25" value="<?=$datos1[9]?>" />
    </div></td>
  </tr>
  <tr>
    <td bgcolor="#EEEEEE"><div align="right"><strong>Escalera:</strong></div></td>
    <td bgcolor="#FFFFFF"><div align="center">
      <input name="escalera2" type="text" id="escalera2" size="25" value="<?=$datos1[10]?>" />
      <input name="calle2" type="hidden" id="calle2" size="25" value="" />
</div></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#EEEEEE"><div align="right"><strong>Tipo Cliente: </strong></div></td>
    <td bgcolor="#FFFFFF"><div align="center">
      <select name="tipo_cliente2" id="tipo_cliente2">
        <option value="0"<?=($datos1[15]==0)? "selected":""?>>- -</option>
        <option value="1"<?=($datos1[15]==1)? "selected":""?>>Comprador</option>
        <option value="2"<?=($datos1[15]==2)? "selected":""?>>Vendedor</option>
        <option value="3"<?=($datos1[15]==3)? "selected":""?>>Busca Alquiler</option>
        <option value="4"<?=($datos1[15]==4)? "selected":""?>>Alquila</option>
      </select>
    </div></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#EEEEEE"><div align="right"><strong>Observacion oculta: </strong></div></td>
    <td bgcolor="#FFFFFF"><div align="center">
      <textarea name="observacion_oculta2" cols="22" rows="4" id="observacion_oculta2"><?=$datos1[14]?></textarea>
    </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="317" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#DDDDDD">
    <tr bgcolor="#CCCCCC">
      <td colspan="2">
      <div align="center"><strong>Datos del Inmueble 
	  <?php  if($id){  ?>	
	  </strong><a href="upload.php?I=<?php echo $id; ?>" target="_blank">Fotos</a></div>
	  <?php }  ?>	  </td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Fecha de alta: <a href="javascript:show_calendar('form1.fecha_alta');" onmouseover="window.status='Desplegar Calendario';return true;" onmouseout="window.status='';return true;"><img src="imagenes/calendario.gif" width="18" height="18" border="0" align="absmiddle" alt="Desplegar Calendario" title="Desplegar Calendario"></a></strong></div></td>
      <td bgcolor="#FFFFFF"><input name="fecha_alta" type="text" id="fecha_alta" size="25" value="<?=$datos[45]?>" /></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Fecha de baja: <a href="javascript:show_calendar('form1.fecha_baja');" onmouseover="window.status='Desplegar Calendario';return true;" onmouseout="window.status='';return true;"><img src="imagenes/calendario.gif" width="18" height="18" border="0" align="absmiddle" alt="Desplegar Calendario" title="Desplegar Calendario"></a></strong></div></td>
      <td bgcolor="#FFFFFF"><input name="fecha_baja" type="text" id="fecha_baja" size="25" value="<?=$datos[47]?>" /></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Referencia:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
        <input name="referencia" type="text" id="referencia" size="25" value="<?=$datos[54]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Alquiler: </strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
        <select name="tipo_alquiler" id="tipo_alquiler">
          <option value="1"<?=($datos[50]==1)? "selected":""?>>Si</option>
          <option value="0"<?=($datos[50]==0)? "selected":""?>>No</option>
        </select>
      </div></td>
    </tr>
    <tr>
      <td width="149" bgcolor="#EEEEEE"><div align="right"><strong>Poblacion:</strong></div></td>
      <td width="153" bgcolor="#FFFFFF">
        <div align="center">
		<select name="poblacion" id="poblacion">
	  <option value="">-  -</option>
<? 
	$id_pobla=$inmuebles->ObtenerPobla();
	
	foreach($id_pobla as $poblacion)
	{
		if($datos[2]==$poblacion[1])
		{
			$sel="selected";
		}else{
			$sel="";
		}
		echo "<option value='$poblacion[1]' $sel>$poblacion[1]</option>";
	}
?>	  
      </select>
        </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>C&oacute;digo postal : </strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input name="codigopostal" type="text" id="codigopostal" size="25" value="<?=$datos[4]?>" />
      </div></td>
    </tr>
	<?php 
	/*
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Direcci&oacute;n:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
        
      </div></td>
    </tr>
	*/
	?>
    <tr>
      <td valign="top" bgcolor="#EEEEEE"><div align="right"><strong>Direcci&oacute;n:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input name="calle" type="hidden" id="calle" size="25" value="<?=$datos[9]?>" />
		  <textarea name="direccion" cols="22" rows="4" id="direccion"><?=$datos[5]?></textarea>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Numero:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input name="numero" type="text" onKeyPress="return acceptNum(event)" id="numero" size="25" value="<?=$datos[8]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Planta</strong>:</div></td>
      <td bgcolor="#FFFFFF"><div align="center">
        <input name="planta" type="text" id="planta" size="25" value="<?=$datos[55]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Puerta:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input name="puerta" type="text" id="puerta" size="25" value="<?=$datos[6]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Escalera:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input name="escalera" type="text" id="escalera" size="25" value="<?=$datos[7]?>" />
      </div></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#EEEEEE"><div align="center"><strong>Datos de venta </strong></div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Vendedor:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
        <input name="vendedor" type="text" id="vendedor" size="25" value="<?=$datos[49]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Captador:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
        <input name="captador" type="text" id="captador" size="25" value="<?=$datos[48]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Fecha de venta: <a href="javascript:show_calendar('form1.fecha_venta');" onmouseover="window.status='Desplegar Calendario';return true;" onmouseout="window.status='';return true;"><img src="imagenes/calendario.gif" width="18" height="18" border="0" align="absmiddle" alt="Desplegar Calendario" title="Desplegar Calendario"></a></strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
        <input name="fecha_venta"  type="text" id="fecha_venta" size="25" value="<?=$datos[46]?>" />
      </div></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#EEEEEE"><div align="center"><strong>Otros datos </strong></div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Tipo:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <select name="tipo" id="tipo">
            <option value="0">-  -</option>
            <? 
	$id_tipo=$inmuebles->ObtenerTipo();
	
	foreach($id_tipo as $tipo)
	{
		if($datos[10]==$tipo[0])
		{
			$sel="selected";
		}else{
			$sel="";
		}
		echo "<option value='$tipo[0]' $sel>$tipo[1]</option>";
	}
?>
          </select>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Amueblado</strong>:</div></td>
      <td bgcolor="#FFFFFF"><div align="center">
        <select name="amueblado" id="amueblado">
          <option value="0"<?=($datos[57]==0)? "selected":""?>>- -</option>
          <option value="1"<?=($datos[57]==1)? "selected":""?>>Si</option>
          <option value="2"<?=($datos[57]==2)? "selected":""?>>No</option>
          <option value="3"<?=($datos[57]==3)? "selected":""?>>Semiamueblado</option>
        </select>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Estado del inmueble:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <select name="estado_inmueble" id="estado_inmueble">
            <option value="">-  -</option>
            <option value="segunda mano"<?=($datos[11]=="segunda mano")? "selected":""?>>segunda mano</option>
            <option value="promociones"<?=($datos[11]=="promociones")? "selected":""?>>promociones</option>
          </select>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Conserge:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <select name="conserge" id="conserge">
            <option value="0"<?=($datos[39]==0)? "selected":""?>>-  -</option>
            <option value="1"<?=($datos[39]==1)? "selected":""?>>Si</option>
            <option value="2"<?=($datos[39]==2)? "selected":""?>>No</option>
            <option value="3"<?=($datos[39]==3)? "selected":""?>>No se sabe</option>
            <option value=""<?=($datos[39]==4)? "selected":""?>>En tramite</option>
          </select>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Exterior</strong>:</div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <select name="exterior_inte" id="exterior_inte">
            <option value="0"<?=($datos[20]==0)? "selected":""?>>-  -</option>
            <option value="1"<?=($datos[20]==1)? "selected":""?>>Si</option>
            <option value="2"<?=($datos[20]==2)? "selected":""?>>No</option>
            <option value="3"<?=($datos[20]==3)? "selected":""?>>No se sabe</option>
          </select>
          <input name="no_garajes" type="hidden" id="no_garajes" size="25" value="<?=$datos[21]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Altura de planta: </strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input name="alturapor_planta" onKeyPress="return acceptNum(event)"  type="text" id="alturapor_planta" size="25" value="<?=$datos[12]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>M. cuadrados construidos: </strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input name="cuadrados_construidos"  onKeyPress="return acceptNum(event)" type="text" id="cuadrados_construidos" size="25" value="<?=$datos[13]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>M. cuadrados utiles: </strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
        <input name="cuadrados_utiles" onKeyPress="return acceptNum(event)"  type="text" id="cuadrados_utiles" size="25" value="<?=$datos[14]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>No habitaciones:</strong></div></td>
      <td bgcolor="#FFFFFF">
        <div align="center">
          <input name="no_habitaciones" onKeyPress="return acceptNum(event)"  type="text" id="no_habitaciones" size="25" value="<?=$datos[15]?>">
        </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>No. Ba&ntilde;os:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input name="no_banos" onKeyPress="return acceptNum(event)"  type="text" id="no_banos" size="25" value="<?=$datos[16]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Estado: </strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input name="estado" type="text" id="estado" size="25" value="<?=$datos[17]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Precio:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
        <input name="precio" onkeyup = "puntitos(this,this.value.charAt(this.value.length-1))" type="text" id="precio" size="25" value="<?=$datos[18]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Precio con comisi&oacute;n:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input name="precio_inmobiliaria" onkeyup = "puntitos(this,this.value.charAt(this.value.length-1))" type="text" id="precio_inmobiliaria" size="25" value="<?=$datos[19]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Precio mes: </strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
        <input name="precio_mes" type="text" id="precio_mes" onkeyup = "puntitos(this,this.value.charAt(this.value.length-1))" size="25" value="<?=$datos[51]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Precio mes comision:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input name="precio_mes_comision" type="text" onkeyup = "puntitos(this,this.value.charAt(this.value.length-1))" id="precio_mes_comision" size="25" value="<?=$datos[52]?>" />
      </div></td>
    </tr>
	<?php 
	/*
	
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>No. de Garajes:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input name="no_garajes" type="text" id="no_garajes" size="25" value="<?=$datos[21]?>" />
      </div></td>
    </tr>
	*/
	?>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Gastos Incluidos: </strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
        <input name="gastos_incluidos" type="text" id="gastos_incluidos" size="25" value="<?=$datos[53]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>No. de ascensores:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
        <select name="select" id="select">
          <option value="0"<?=($datos[22]==0)? "selected":""?>>- -</option>
          <option value="1"<?=($datos[22]==1)? "selected":""?>>Si</option>
          <option value="2"<?=($datos[22]==2)? "selected":""?>>No</option>
        </select>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong> Armarios empotrados:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input name="no_armarios" onKeyPress="return acceptNum(event)"  type="text" id="no_armarios" size="25" value="<?=$datos[23]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Plaza de garaje incluido en el precio:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input name="garaje_incluido" type="text" id="garaje_incluido" size="25" value="<?=$datos[25]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Trastero: </strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input name="trastero" type="text" id="trastero" size="25" value="<?=$datos[31]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Agua caliente:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input name="servicio_agua" type="text" id="servicio_agua" size="25" value="<?=$datos[32]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Calefaccion:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input name="calefaccion" type="text" id="calefaccion" size="25" value="<?=$datos[33]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Antena:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input name="antena" type="text" id="antena" size="25" value="<?=$datos[34]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Gastos comunidad (Eur/Mes):</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input name="gastos_comunidad" onkeyup = "puntitos(this,this.value.charAt(this.value.length-1))" type="text" id="gastos_comunidad" size="25" value="<?=$datos[37]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Piscina:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input name="pisicina" type="text" id="pisicina" size="25" value="<?=$datos[38]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Altura edificio :</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input name="altura_edificio" onKeyPress="return acceptNum(event)" type="text" id="altura_edificio" size="25" value="<?=$datos[40]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Antiguedad:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input name="antiguedad" type="text" id="antiguedad" size="25" value="<?=$datos[41]?>" />
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Puertas por plantas: </strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input name="puertaspor_plantas" onKeyPress="return acceptNum(event)" type="text" id="puertaspor_plantas" size="25" value="<?=$datos[42]?>" />
      </div></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EEEEEE"><div align="right"><strong>Orientacion: </strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <textarea name="orientacion" cols="22" rows="4" id="orientacion"><?=$datos[3]?></textarea>
      </div></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EEEEEE"><div align="right"><strong>Tipo de suelo:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <textarea name="tipo_suelo" cols="22" rows="4" id="tipo_suelo"><?=$datos[24]?></textarea>
      </div></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EEEEEE"><div align="right"><strong>Puerta seguridad :</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <textarea name="puerta_seguridad" cols="22" rows="4" id="puerta_seguridad"><?=$datos[27]?></textarea>
      </div></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EEEEEE"><div align="right"><strong>Sistema de alarma :</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
        <textarea name="alarma" cols="22" rows="4" id="alarma"><?=$datos[28]?></textarea>
      </div></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EEEEEE"><div align="right"><strong>Equipamiento cocina :</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
        <textarea name="cocinafull" cols="22" rows="4" id="cocinafull"><?=$datos[29]?></textarea>
      </div></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EEEEEE"><div align="right"><strong>Aire acondicionado: </strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <textarea name="aire_acondicionado" cols="22" rows="4" id="aire_acondicionado"><?=$datos[30]?></textarea>
      </div></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EEEEEE"><div align="right"><strong>Terraza (Metros cuadrado):</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <textarea name="terraza" cols="22" rows="4" id="terraza"><?=$datos[35]?></textarea>
      </div></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EEEEEE"><div align="right"><strong>Tendero:</strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <textarea name="tendero" cols="22" rows="4" id="tendero"><?=$datos[36]?></textarea>
      </div></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EEEEEE"><div align="right"><strong>Zonas comunes: </strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <textarea name="zonas_comunales" cols="22" rows="4" id="zonas_comunales"><?=$datos[43]?></textarea>
      </div></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EEEEEE"><div align="right"><strong>Observacion Oculta: </strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
        <textarea name="observacion_oculta" cols="22" rows="4" id="observacion_oculta"><?=$datos[56]?></textarea>
      </div></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#EEEEEE"><div align="right"><strong>Observacion: </strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <textarea name="observacion" cols="22" rows="4" id="observacion"><?=$datos[26]?></textarea>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#EEEEEE"><div align="right"><strong>Publicado: </strong></div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <select name="activo" id="activo">
            <option value="0"<?=($datos[44]==0)? "selected":""?>>No</option>
            <option value="1"<?=($datos[44]==1)? "selected":""?>>Si</option>
          </select>
      </div></td>
    </tr>
  </table>
    <div align="center">
      <p>&nbsp;      </p>
      <p>
        <input type="button" onclick="validar()" name="Button" value="Guardar">
        <input type="button" name="Submit" value="Cancelar" onClick="document.location.href='home.php?inc=<?=$inc?>'">
      </p>
        </p>
  </div>
</form>
<br>
