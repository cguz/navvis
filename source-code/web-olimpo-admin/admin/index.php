<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>::: SISTEMA DE ADMINISTRACION DE CONTENIDOS :::</title>
</head>
<link href="estilo/admin.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="edt_admin/scripts/validar.js"></script>
<body>
<form name="form1" method="post" action="login.php" onSubmit="return validar_entrada(this.usuario,this.password)">
<table width="791" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><? include "./tpl/cabezote.php"; ?></td>
  </tr>
  <tr>
    <td height="400" valign="middle"><table width="400" border="0" align="center" cellpadding="2" cellspacing="0">
      <tr>
        <td height="28"><div align="right">Usuario</div></td>
        <td width="11">&nbsp;</td>
        <td width="222"><input name="usuario" type="text" class="cajas2_peq" id="usuario" size="15"></td>
      </tr>
      <tr>
        <td height="17"><div align="right">Contarse&ntilde;a</div></td>
        <td height="17">&nbsp;</td>
        <td height="17"><input name="password" type="password" class="cajas2_peq" id="password" size="15"></td>
      </tr>
      <tr>
        <td height="10"><div align="right"> </div></td>
        <td height="10">&nbsp;</td>
        <td height="10"><input name="Submit" type="submit" value="Ingresar" ></td>
      </tr>
      <tr>
        <td height="10" colspan="3"><div align="center" class="alertas">
            <?=$msg?>
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><? include "./tpl/abajo.php" ?></td>
  </tr>
</table>
</form>

</body>
</html>
