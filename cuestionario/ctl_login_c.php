<?php
session_start();
include("../connection.php");
include("../libreria.php");
// Recibe el usuario ingresado
//$idPost			= str_replace(" ","",$_REQUEST['idPost']);
//$pwPost			= str_replace(" ","",$_REQUEST['pwPost']);

$codEmpleado	= str_replace(" ","",$_REQUEST['codEmpleado']);
$usuario_call	= str_replace(" ","",$_REQUEST['usuario_call']);
$origen			= str_replace(" ","",$_REQUEST['origen']);

//echo'$codEmpleado: '.$codEmpleado;
//---- si no llegó codEmpleado por $_REQUEST toma el valor de la variable de sesión
if(empty($codEmpleado) && !empty($_SESSION['usuarioECO'])){
	$codEmpleado	= $_SESSION['usuarioECO'];
}
//---- si no llegó usuarioCall por $_REQUEST toma el valor de la variable de sesión
if(empty($usuario_call) && !empty($_SESSION['usuarioCall_SS'])){
	$usuario_call	= $_SESSION['usuarioCall_SS'];
}
//---- si no llegó origen por $_REQUEST toma el valor de la variable de sesión
if(empty($origen) && !empty($_SESSION['origen_SS'])){
	$origen	= $_SESSION['origen_SS'];
}
//echo'<BR>codEmpleado: '.$codEmpleado;
//echo'<BR>origen: '.$origen;
if(empty($_SESSION['usuarioECO']) && empty($codEmpleado)){
?>
<!--*** Traiga el HTML correspondiente a Bienvenida y LOGIN **-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE><?=tituloPag?></TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META http-equiv="Pragma" content="no-cache">
<LINK rel="stylesheet" href="../style.css" type="text/css">
<HEAD>
<BODY style="background-color:#FFFFFF">
<TABLE width="947" border="0" cellspacing="0" cellpadding="0" align="center">
 <TR>
  <TD>
  <TABLE width="100%" cellspacing="0" cellpadding="0" align='center' border="0">
	<TR>
	 <TD align='left'>
	  <TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
	   <TR>
		<TD align="left" width="20%"><IMG src='/imagenes/ecopetrol_logo.jpg' height="80" border='0'></TD>
		<TD align="left">&nbsp;</TD>
	   </TR>
	  </TABLE>
	 </TD>
	</TR>
   </TABLE>
  </TD>
 </TR>

 <TR>
  <TD align="center">
   <TABLE width='100%' align='center' border='0' cellspacing='0' cellpadding='0' style="border:solid 1px #DDDDDD;">
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
			  <FORM name="frm" method=POST action="<?=$PHP_SELF?>">
				<DIV align="center">
				  <TABLE width="100%">
					<TR>
					  <TD colspan="2" align="left"class="texto_gral">Estimado usuario, por favor ingrese su registro de ECOPETROL y haga clic en el bot&oacute;n &quot;Ingresar&quot;. Ejemplo:<br />
					    Directo: EXXXXXX
					  <br />
					  Contratista: CXXXXXX<br />
					    Si presenta inconvenientes, le solicitamos comunicarse con <a href="mailto:asalazar@cnccol.com"><span class="volanta">asalazar@cnccol.com<br />
					  </span></a></TD>
					  </TR>
					<TR>
					  <TD width="51%" nowrap="nowrap" class="texto_gral" align="right" height="40">Registro:</TD>
					  <TD width="49%"><INPUT type="text" name="codEmpleado" id="codEmpleado" style="padding:5px;" size="15" /></TD>
					</TR>
				  </TABLE>
				  <FONT size="2" face="Verdana" color="#FFFFFF">
				  <INPUT type="submit" name="Start_survey" value="Ingresar" class="Button" style="padding:5px 10px;" />
				  <INPUT type='hidden' name='usuario_call' id='usuario_call' value='<?=$usuario_call?>' lang='0'>
				  <INPUT type='hidden' name='origen' id='origen' value='<?=$origen?>' lang='0'>
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
	  <TD align="left"><IMG src='/imagenes/ifun_footer1.jpg' width='100%' height='47'></TD>
	 </TR>
	 <TR>
	  <TD bgcolor='#6ba231' align="center" height="15"><FONT color='#FFFFFF'>Si 
					durante la operaci&oacute;n del sistema, se presentan dificultades 
					t&eacute;cnicas, por favor contactar al <A href="mailto:wvalencia@cnccol.com" >Webmaster</A>.</FONT>
	  </TD>
	 </TR>
   </TABLE>
  </TD>
 </TR>
</TABLE>
</BODY>
</HTML>
<?php
  exit;
}
$sql_usu = "SELECT * FROM ".tablaContacto." WHERE cod_empleado='$codEmpleado'";
//echo '<BR>'.$sql_usu;
$arrayDatosContacto	= array();
$es_valido			= mysql_query($sql_usu);
if(mysql_num_rows($es_valido) > 0){
	$campos_d		= mysql_fetch_array($es_valido);
	$codEmpleado	= $campos_d["cod_empleado"];
	$esExterno		= $campos_d["es_externo"];
	$nomContacto	= $campos_d["nom_contacto"];
	$tipo_pedido	= $campos_d["tipo_pedido"];
	$tipo_usuario	= $campos_d["tipo_usuario"];
	$es_ude			= $campos_d["es_ude"];
	$es_ugc			= $campos_d["es_ugc"];
	$es_uin			= $campos_d["es_uin"];
	$es_ust			= $campos_d["es_ust"];
	$unidad_juridica= $campos_d["unidad_juridica"];

	$arrayDatosContacto['tipo_pedido']	= $tipo_pedido;
	$arrayDatosContacto['tipo_usuario']	= $tipo_usuario;
	$arrayDatosContacto['es_ude']	= $es_ude;
	$arrayDatosContacto['es_ugc']	= $es_ugc;
	$arrayDatosContacto['es_uin']	= $es_uin;
	$arrayDatosContacto['es_ust']	= $es_ust;
	$arrayDatosContacto['unidad_juridica']	= $unidad_juridica;
	
	$_SESSION['usuarioECO']		= $codEmpleado;
	$_SESSION['usuarioCall_SS']	= $usuario_call;
	$_SESSION['origen_SS']		= $origen;
}else{
	$_SESSION['usuarioECO']		= NULL;
	$_SESSION['usuarioCall_SS']	= NULL;
	$_SESSION['origen_SS']		= NULL;
//	session_destroy();
//	session_unset();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE><?=$titulo_pag?></TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META http-equiv="Pragma" content="no-cache">
<LINK rel="stylesheet" href="../style.css" type="text/css">
<HEAD>
<BODY style="background-color:#FFFFFF">
<TABLE width="947" border="0" cellspacing="0" cellpadding="0" align="center">
 <TR>
  <TD>
  <TABLE width="100%" cellspacing="0" cellpadding="0" align='center' border="0">
	<TR>
	 <TD align='left'>
	  <TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
	   <TR>
		<TD align="left" width="77%"><IMG src='/imagenes/ecopetrol_logo.jpg' height="80" border='0'></TD>
		<TD align="left" width="23%">&nbsp;</TD>
	   </TR>
	  </TABLE>
	 </TD>
	</TR>
   </TABLE>
  </TD>
 </TR>
 <TR>
  <TD>
  </TD>
 </TR>
 <TR>
  <TD>
   <TABLE width='100%' align='center' border='0' cellspacing='0' cellpadding='0' style="border:solid 1px #DDDDDD;">
	<TR height="25">
	 <TD align='center'>
            <p>&nbsp;</p>
            <p align="center"><font face="Times New Roman" color="#FF0000" size="4"><b>Usuario incorrecto.</b></font></p>
            <img src="/imagenes/errorsmiley.png" width=128>
            <p align="center" class="newsLink"><font face="Verdana" color="#DCDBCD"><a href="<?=$PHP_SELF?>?codEmpleado=">Intentar nuevamente</a></font></p>
            <p>&nbsp;</p>
	 </TD>
	</TR>
   </TABLE>
  </TD>
 </TR>
</TABLE>
</BODY>
</HTML>
<?php
  exit;
}
?>