<?php
session_start();
include("connection.php");
include("libreria.php");

//echo'<BR>userAdmin: '.$_SESSION['userAdmin'];
$v_usuarioAdmin		= $_REQUEST['c_usuarioAdmin'];
$v_claveAdmin		= $_REQUEST['c_claveAdmin'];
if(empty($v_usuarioAdmin)){
	$v_usuarioAdmin	= $_SESSION['usuarioAdmin'];
	$v_claveAdmin	= $_SESSION['claveAdmin'];
}
if(empty($v_usuarioAdmin)){
//if(empty($_SESSION['userAdmin']) || empty($usuarioAdmin)){
?>
<!--*** Traiga el HTML correspondiente a Bienvenida y LOGIN **-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>..:: <?=tituloPag?> ::..</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<LINK rel="stylesheet" href="../style.css" type="text/css">
<HEAD>
<BODY style="background-color:#FFFFFF">
<TABLE width="947" border="0" cellspacing="0" cellpadding="0" align="center">
 <TR>
  <TD>
  <? //=$sup?>
  <TABLE width="100%" cellspacing="0" cellpadding="0" align='center' border="0">
	 <TR>
	   <TD align="left"><IMG src='/imagenes/ecopetrol_logo.jpg' height="80" border='0'></TD>
	 </TR>
   </TABLE>
  <? //=$inf?>
  </TD>
 </TR>
 <TR>
  <TD><IMG src='/imagenes/spacer.gif' width='1' height='10'></TD>
 </TR>

 <TR>
  <TD align="center">
  <?=$sup?>
   <TABLE width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	 <TR>
	  <TD><IMG src='/imagenes/spacer.gif' width='1' height='50'></TD>
	 </TR>
	
	 <TR>
	  <TD align="center">
		  <TABLE width="350" border="0" align="center" cellpadding="0" cellspacing="0" class="Border">
			<TR>
			  <TD width="50%" height="77" align="center" valign="middle">
			  <img src="/imagenes/ie7security.png" width='51' border='0'>
			  </TD>
			  <TD width="50%" valign="top" align="right">
			  <IMG src="/imagenes/cta_dr.jpg" width="113" height="82"></TD>
			</TR>
			<TR>
			  <TD colspan="2" valign="top">
			  <FORM name="frm" method=POST action="<?=$PHP_SELF?>" enctype="multipart/form-data">
				<DIV align="center">
				  <TABLE width="100%">
					<TR>
					  <TD width="51%" nowrap="nowrap" class="texto_gral" align="right">Login:</TD>
					  <TD width="49%"><INPUT type="text" name="c_usuarioAdmin" style="width:100px;" value=""></TD>
					</TR>
					<TR>
					  <TD width="51%" nowrap="nowrap" class="texto_gral" align="right">Clave:</TD>
					  <TD width="49%"><INPUT type="password" name="c_claveAdmin" style="width:100px;" value=""></TD>
					</TR>
				  </TABLE>
				  <FONT size="2" face="Verdana" color="#FFFFFF">
				  <INPUT type="submit" name="Start_survey" value="Submit" class="Button" >
				  </FONT></DIV>
			  </FORM>
			  </TD>
			</TR>
		  </TABLE>
			<script language=JavaScript>
			<!-- Ignore
			today = new Date()
			month = today.getMonth()
			dia = today.getDay()
			day = today.getDate()
			year = today.getYear()
			if (year < 2000)
			{
			year = year + 1900}
			document.write ("<font FACE='Arial' size=1 color='#000000'><B>")
			
			if (month == 0)
			document.write ("Enero. ")
			else if (month == 1)
			document.write ("Febrero. ")
			else if (month == 2)
			document.write ("Marzo. ")
			else if (month == 3)
			document.write ("Abril. ")
			else if(month == 4)
			document.write ("Mayo. ")
			else if (month == 5)
			document.write ("Junio. ")
			else if (month == 6)
			document.write ("Julio. ")
			else if (month == 7)
			document.write ("Agosto. ")
			else if (month == 8)
			document.write ("Septiembre. ")
			else if (month == 9)
			document.write ("Octubre. ")
			else if (month == 10)
			document.write ("Noviembre. ")
			else if (month == 11)
			document.write ("Diciembre. ")
			document.write (" "+day+", ")
			document.writeln ( year)
			
			RightNow=new Date();
			var timeValue = "";
			var timeValue = "";
			var hours = RightNow.getHours();
			var minutes = RightNow.getMinutes();
			timeValue += ((hours <= 12) ? hours : hours - 12);
			timeValue += ((minutes < 10) ? ":0" : ":") + minutes;
			timeValue += (hours < 12) ? " a.m." : " p.m.";
			
			document.write(""+timeValue+"");
			document.writeln ("</font></B></div>")
			// End ignoring  -->
			</script>
		 </TD>
		</TR>
	
	 <TR>
	  <TD><IMG src='/imagenes/ifun_footer1.jpg' width='100%' height='47'></TD>
	 </TR>
	 <TR>
	  <TD bgcolor='#6ba231' align="center" height="15"><FONT color='#FFFFFF'>Si 
					durante la operaci&oacute;n del sistema, se presentan dificultades 
					t&eacute;cnicas, por favor contactar al <A href="mailto:wvalencia@cnccol.com" >Webmaster</A>.</FONT>
	  </TD>
	 </TR>
   </TABLE>
  <?=$inf?>
  </TD>
 </TR>
</TABLE>
</BODY>
</HTML>
<?php
  exit;
}
$sql_usu = "
SELECT id_empleado AS usuario_id,'ADMIN' AS tipoUsuario,CONCAT_WS(' ',Nombres,Apellidos) AS nomUsuario
FROM empleado WHERE id_empleado = '$v_usuarioAdmin' AND password = '$v_claveAdmin'
UNION
SELECT id_usuario AS usuario_id,tipo_usuario AS tipoUsuario,CONCAT_WS(' ',nombre,apellido) AS nomUsuario
FROM ".tablaUsuario." WHERE id_usuario = '$v_usuarioAdmin' AND clave = '$v_claveAdmin'";
//echo '<BR>'.$sql_usu;
$es_valido 		= mysql_query($sql_usu);
if(mysql_num_rows($es_valido) > 0){
	$datosusuario				= mysql_fetch_array($es_valido);
	$nomUsuario					= $datosusuario["nomUsuario"];
	$usuario_id					= $datosusuario["usuario_id"];
	$tipoUsuario				= $datosusuario["tipoUsuario"];
	$_SESSION['userAdmin']		= $usuario_id;
	$_SESSION['nomUsuario']		= $nomUsuario;

	$_SESSION['usuarioAdmin']	= $v_usuarioAdmin;
	$_SESSION['claveAdmin']		= $v_claveAdmin;

	$esADMIN	= '0';
}
else{
	$_SESSION['userAdmin']		= NULL;
	$_SESSION['usuarioAdmin']	= NULL;
	$_SESSION['claveAdmin']		= NULL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>..:: <?=tituloPag?> ::..</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<LINK rel="stylesheet" href="../style.css" type="text/css">
</HEAD>
<BODY style="background-color:#FFFFFF">
<TABLE width="947" border="0" cellspacing="0" cellpadding="0" align="center">
 <TR>
  <TD>
  <? //=$sup?>
  <TABLE width="100%" cellspacing="0" cellpadding="0" align='center' border="0">
	 <TR>
	  <TD align="left"><IMG src='/imagenes/ecopetrol_logo.jpg' height="80" border='0'></TD>
	 </TR>
   </TABLE>
  <? //=$inf?>
  </TD>
 </TR>
 <TR>
  <TD>
  </TD>
 </TR>
 <TR>
  <TD>
  <IMG src='/imagenes/spacer.gif' width='1' height='10'>
  <?=$sup?>
   <TABLE width="100%" cellspacing="0" cellpadding="2" align='center' border="0">
	<TR height="25">
	 <TD align='center'>
			<p>&nbsp;</p>
			<p align="center"><font face="Times New Roman" color="#FF0000" size="4"><b>Usuario incorrecto.</b></font></p>
			<img src="/imagenes/errorsmiley.png" width=128>
			<p align="center" class="newsLink"><font face="Verdana" color="#DCDBCD"><a href="<?=$PHP_SELF?>">Intentar nuevamente</a></font></p>
			<p>&nbsp;</p>
	 </TD>
	</TR>
   </TABLE>
  <?=$inf?>
  </TD>
 </TR>
</TABLE>
</BODY>
</HTML>
<?php
  exit;
}
?>