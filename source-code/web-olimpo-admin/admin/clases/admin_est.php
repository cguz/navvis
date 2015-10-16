<?
  include_once("../clases/AdminEstadisticas.php");
  $estadisticas=new AdminEstadisticas;  
  $dia_act=date("d");
  $mes_act=date("m");
  $ano_act=date("Y");
   if($ano)
  {
    $dia_act=$dia;
    $mes_act=$mes;
    $ano_act=$ano;
  }
if(!isset($seccion))
  {
     $seccion="inicio";
	 $titulo="Inicio"; 
	 $idi=1;
  }	 
  if(!isset($opcion))
     $opcion=1;
  else
  {
      if(!$dia)
         $dia_act=date("d");
  }
    if($opcion==1)
       $fecha=$ano_act."-".$mes_act."-".$dia_act;
    else
       $fecha=$ano_act."-".$mes_act;	
    $total_home=$total_eventos=$total_concurso=0;
	$matriz=$estadisticas->ObtenerEstadisticas($fecha);
	$j=0;
	while($j<count($matriz))
	{
        if(strcmp($matriz[$j][2],"inicio")==0 and $matriz[$j][1]=="1")
           $total_inicio += $matriz[$j][0];		   	        
        else if(strcmp($matriz[$j][2],"inicio")==0 and $matriz[$j][1]=="2")
           $total_inicioIn += $matriz[$j][0];		
        else if(strcmp($matriz[$j][2],"Donde Estamos")==0 and $matriz[$j][1]=="1")
           $total_donde += $matriz[$j][0];		   	        
		else if(strcmp($matriz[$j][2],"Donde Estamos")==0 and $matriz[$j][1]=="2")
           $total_dondeIn += $matriz[$j][0];   		   
	    else if(strcmp($matriz[$j][2],"Producción")==0 and $matriz[$j][1]=="1")
           $total_produccion += $matriz[$j][0];
	    else if(strcmp($matriz[$j][2],"Producción")==0 and $matriz[$j][1]=="2")
           $total_produccionIn += $matriz[$j][0];		   	        
	    else if(strcmp($matriz[$j][2],"Historia")==0 and $matriz[$j][1]=="1")
           $total_historia += $matriz[$j][0];
	    else if(strcmp($matriz[$j][2],"Historia")==0 and $matriz[$j][1]=="2")
           $total_historiaIn += $matriz[$j][0];
	    else if(strcmp($matriz[$j][2],"Servicio integral")==0 and $matriz[$j][1]=="1")
           $total_servicio += $matriz[$j][0];
	    else if(strcmp($matriz[$j][2],"Servicio integral")==0 and $matriz[$j][1]=="2")
           $total_servicioIn += $matriz[$j][0];
	    else if(strcmp($matriz[$j][2],"Calidad")==0 and $matriz[$j][1]=="1")
           $total_calidad += $matriz[$j][0];
	    else if(strcmp($matriz[$j][2],"Calidad")==0 and $matriz[$j][1]=="2")
           $total_calidadIn += $matriz[$j][0];
	    else if(strcmp($matriz[$j][2],"Conózcanos")==0 and $matriz[$j][1]=="1")
           $total_conozcanos += $matriz[$j][0];
	    else if(strcmp($matriz[$j][2],"Conózcanos")==0 and $matriz[$j][1]=="2")
           $total_conozcanosIn += $matriz[$j][0];
	    else if(strcmp($matriz[$j][2],"Ropa Interior")==0 and $matriz[$j][1]=="1")
           $total_Rinterior += $matriz[$j][0];
	    else if(strcmp($matriz[$j][2],"Ropa Interior")==0 and $matriz[$j][1]=="2")
           $total_RinteriorIn += $matriz[$j][0];
	    else if(strcmp($matriz[$j][2],"Vestido de Baño")==0 and $matriz[$j][1]=="1")
           $total_Vbano += $matriz[$j][0];
	    else if(strcmp($matriz[$j][2],"Vestido de Baño")==0 and $matriz[$j][1]=="2")
           $total_VbanoIn += $matriz[$j][0];
	    else if(strcmp($matriz[$j][2],"Active Wear")==0 and $matriz[$j][1]=="1")
           $total_Awear += $matriz[$j][0];
	    else if(strcmp($matriz[$j][2],"Active Wear")==0 and $matriz[$j][1]=="2")
           $total_AwearIn += $matriz[$j][0];
	    else if(strcmp($matriz[$j][2],"Ropa Exterior")==0 and $matriz[$j][1]=="1")
           $total_Rexterior += $matriz[$j][0];
	    else if(strcmp($matriz[$j][2],"Ropa Exterior")==0 and $matriz[$j][1]=="2")
           $total_RexteriorIn += $matriz[$j][0];
	    else if(strcmp($matriz[$j][2],"Decoración")==0 and $matriz[$j][1]=="1")
           $total_decoracion += $matriz[$j][0];
	    else if(strcmp($matriz[$j][2],"Decoración")==0 and $matriz[$j][1]=="2")
           $total_decoracionIn += $matriz[$j][0];
	    else if(strcmp($matriz[$j][2],"Industrial")==0 and $matriz[$j][1]=="1")
           $total_industrial += $matriz[$j][0];
	    else if(strcmp($matriz[$j][2],"Industrial")==0 and $matriz[$j][1]=="2")
           $total_industrialIn += $matriz[$j][0];
	    else if(strcmp($matriz[$j][2],"Full Value")==0 and $matriz[$j][1]=="1")
           $total_value += $matriz[$j][0];
	    else if(strcmp($matriz[$j][2],"Full Value")==0 and $matriz[$j][1]=="2")
           $total_valueIn += $matriz[$j][0];
		   
		   $j++;  
    }
?>
<form name="form1" method="post" action="home.php">
<input type="hidden" name="inc" value="<?=$inc?>">
<table width="80%" height="57"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#999999">
            <tr>
              <td><table width="100%" height="47"  border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#FFFFFF">
                <tr>
                  <td width="100%" height="45" bgcolor="#DDDDDD">

                      <input name="opcion" type="radio" value="1" <?if($opcion==1){echo "checked";}?> onClick="document.form1.submit()">

                      <span class="formularionegro Estilo2">Diaria &nbsp;</span><span class="Estilo2">&nbsp;

                      <input name="opcion" type="radio" value="2" <?if($opcion==2){echo "checked";}?> onClick="document.form1.submit()">
                      Mensual&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <input name="Submit" type="submit" class="botonescafes" value="Ver">
                      <select name="ano" class="cajasformulario" id="ano">
					  <?					   
					   for($h=2005;$h<date("Y")+2;$h++)
					    echo "<option value=$h>$h</option>";
					  ?>
                      </select>
                      <select name="mes" class="cajasformulario" id="mes">
                        <option value="01">Enero</option>
                        <option value="02">Febrero</option>
                        <option value="03">Marzo</option>
                        <option value="04">Abril</option>
                        <option value="05">Mayo</option>
                        <option value="06">Junio</option>
                        <option value="07">Julio</option>
                        <option value="08">Agosto</option>
                        <option value="09">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                      </select>
                      <?
   if($opcion==1)
   {
?>
                      <select name="dia" class="cajasformulario" id="dia">
                        <option value="01" selected>01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>
                        <option value="31">31</option>
                      </select>
                      <?
   }
?>
                  </span> </td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td><table width="100%" height="806"  border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#999999">
                <tr>
                  <td height="2"></td>
                </tr>
                <tr>
                  <td height="90" valign="top"><table width="600" height="327"  border="1" align="right" cellpadding="5" cellspacing="0" bordercolor="#FFFFFF">
                <tr align="center">
                  <td height="4" colspan="2" >Espa&ntilde;ol</td>
                  <td height="4" colspan="2">English</td>
                  </tr>
                <tr bgcolor="#EEEEEE">
                  <td height="5" ><a href="./home.php?inc=<?=$inc?>&seccion=inicio&idi=1&titulo=Inicio&opcion=<?=$opcion?>&ano=<?=$ano?>&mes=<?=$mes?>&dia=<?=$dia?>" >Inicio </a></td>
                  <td height="5">
                    <? if(strlen($total_inicio)==0) echo '0'; else echo $total_inicio?>
                  &nbsp;visitas </td>
                  <td height="5"><a href="./home.php?inc=<?=$inc?>&seccion=inicio&idi=2&titulo=Home&opcion=<?=$opcion?>&ano=<?=$ano?>&mes=<?=$mes?>&dia=<?=$dia?>" >Home </a></td>
                  <td height="5">
                    <? if(strlen($total_inicioIn)==0) echo '0'; else echo $total_inicioIn?>
&nbsp;visitas</td>
                </tr>
                <tr bgcolor="#FDFEFF"> 
                  <td width="190" height="5" ><a href="./home.php?inc=<?=$inc?>&seccion=Donde Estamos&idi=1&titulo=Donde Estamos&opcion=<?=$opcion?>&ano=<?=$ano?>&mes=<?=$mes?>&dia=<?=$dia?>">Donde Estamos </a></td>
                  <td width="185" height="5" bgcolor="#FDFEFF">
                    <?  if(strlen($total_donde)==0) echo '0'; else echo $total_donde?>
&nbsp;visitas  
                   </td>
                  <td width="180" height="5" bgcolor="#FDFEFF"><a href="./home.php?inc=<?=$inc?>&seccion=Donde Estamos&idi=2&titulo=Locations&opcion=<?=$opcion?>&ano=<?=$ano?>&mes=<?=$mes?>&dia=<?=$dia?>" >Locations</a></td>
                  <td width="195" height="5" bgcolor="#FDFEFF">
                    <? if(strlen($total_dondeIn)==0) echo '0'; else echo $total_dondeIn?>
&nbsp;visitas 
                 </td>
                </tr>
                <tr bgcolor="#EEEEEE">
                  <td width="190" height="5" ><a href="./home.php?inc=<?=$inc?>&seccion=Producción&idi=1&titulo=Producción&opcion=<?=$opcion?>&ano=<?=$ano?>&mes=<?=$mes?>&dia=<?=$dia?>">Producción </a></td>
                  <td height="5">
                    <? if(strlen($total_produccion)==0) echo '0'; else echo $total_produccion?>
&nbsp;visitas </td>
                  <td height="5"><a href="./home.php?inc=<?=$inc?>&seccion=Producción&idi=2&titulo=Production&opcion=<?=$opcion?>&ano=<?=$ano?>&mes=<?=$mes?>&dia=<?=$dia?>">Manufacture</a></td>
                  <td height="5">
                    <? if(strlen($total_produccionIn)==0) echo '0'; else echo $total_produccionIn?>
&nbsp;visitas </td>
                </tr>
                <tr bgcolor="#FDFEFF">
                  <td width="190" height="5" ><a href="./home.php?inc=<?=$inc?>&seccion=Historia&idi=1&titulo=Historia&opcion=<?=$opcion?>&ano=<?=$ano?>&mes=<?=$mes?>&dia=<?=$dia?>" >Historia </a></td>
                  <td height="5" bgcolor="#FDFEFF">
                    <? if(strlen($total_historia)==0) echo '0'; else echo $total_historia?>
&nbsp;visitas </td>
                  <td height="5" bgcolor="#FDFEFF"><a href="./home.php?inc=<?=$inc?>&seccion=Historia&idi=2&titulo=Background&opcion=<?=$opcion?>&ano=<?=$ano?>&mes=<?=$mes?>&dia=<?=$dia?>" >Background</a></td>
                  <td height="5" bgcolor="#FDFEFF">
                    <? if(strlen($total_historiaIn)==0) echo '0'; else echo $total_historiaIn?>
&nbsp;visitas </td>
                </tr>
				<tr bgcolor="#EEEEEE"> 
                  <td width="190" height="5"><a href="./home.php?inc=<?=$inc?>&seccion=Servicio integral&idi=1&titulo=Servicio Integral&opcion=<?=$opcion?>&ano=<?=$ano?>&mes=<?=$mes?>&dia=<?=$dia?>" >Servicio Integral </a></td>
                  <td height="5">
                    <? if(strlen($total_servicio)==0) echo '0'; else echo $total_servicio?>
&nbsp;visitas 
                    </td>
                  <td height="5"><a href="./home.php?inc=<?=$inc?>&seccion=Servicio integral&idi=2&titulo=Integral Service&opcion=<?=$opcion?>&ano=<?=$ano?>&mes=<?=$mes?>&dia=<?=$dia?>">Integral Service </a></td>
                  <td height="5">
                    <? if(strlen($total_servicioIn)==0) echo '0'; else echo $total_servicioIn?>
&nbsp;visitas </td>
                </tr>				
  
  
  </table></td>
                </tr>
                <tr>
                  <td height="10" valign="top">&nbsp;</td>
                </tr>
                <tr>
				
<?

   $datay = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
    for($p=1;$p<=31;$p++)
    {
     $k=$p-1;
     $j=$p;
     if($p<10)
      $j="0".$p;
     $fecha2=$fecha."-".$j;		
     $total_home=$total_eventos=$total_concurso=0;
     $totales=$estadisticas->ObtenerTotales($fecha2,$seccion,$idi);				
     $datay[$k]=$totales[0][0];
   }
     $datay=implode(",",$datay);
?>
                  <td height="380" valign="top"><?if($opcion!=1){?>
                    <div align="center">
                        <iframe name="std" src="./inc/estadisticas.php?fecha=<?=$fecha?>&datay=<?=$datay?>&seccion=<?=$seccion?>&titulo=<?=$titulo?>" width="586" height="350" frameborder="0"></iframe>
                      <?}?>
                    </div></td>
                </tr>
              </table></td>
            </tr>
  </table>					

			  <?	
/*                <tr bgcolor="#EEEEEE"> 
                  <? echo "<td width='190' height='5' ><a href='./home.php?inc=$inc&seccion=Servicio integral&idi=1&titulo=Servicio Integral&opcion=$opcion&ano=$ano&mes=$mes&dia=$dia'>Servicio Integral </a></td>";?>
                  <td height="5">
                    <? if(strlen($total_servicio)==0) echo '0'; else echo $total_servicio?>
&nbsp;visitas 
                   </td>			  */
  echo "paso1";
  
 ?>
 </form>
<script>
     var total = document.form1.ano.length;
     for(p=0;p<total;p++)
     {
         if(document.form1.ano.options[p].text=="<?=$ano_act?>"){
           document.form1.ano.selectedIndex = p;
         }
     }

      var total = document.form1.mes.length;
     for(p=0;p<total;p++)
     {
         if(document.form1.mes.options[p].value=="<?=$mes_act?>"){
           document.form1.mes.selectedIndex = p;
         }
     }
	  
	  if(document.form1.dia)
	  {
      	var total = document.form1.dia.length;
	  
     	for(p=0;p<total;p++)
     	{
         	if(document.form1.dia.options[p].text=="<?=$dia_act?>"){
           		document.form1.dia.selectedIndex = p;
        	 }
     	}
	 }
</script>
