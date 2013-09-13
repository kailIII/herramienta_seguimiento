<?
header("Expires: Sun 25 Jul 1994 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
header("Pragma: no-cache"); 

include("../ctl_login_admin.php");

//------------- Guarda el registro de ingreso a la plataforma -------------
$ID				= $_REQUEST['ID'];
$primerIngreso	= $_REQUEST['primerIngreso'];
$usuPost		= $_REQUEST['usuarioPost'];
$usuario_call	= $_REQUEST['usuario_call'];
$origen			= $_REQUEST['origen'];

$mesActivo		= $trackActivo;
include("DML_cod_resultado.php");

$ip_c			= $_SERVER['REMOTE_ADDR'];
//echo '<BR>primerIngreso: '.$primerIngreso;

//---- consulta el estado del registro para el track actual
$sql_d = "SELECT nom_empresa,nom_contacto,finaliza_campo
			FROM ".tablaContacto." A LEFT JOIN ".tablaEstadoContacto." B USING(cod_empleado)
		WHERE A.cod_empleado='$ID' AND B.cod_empleado='$ID'";
//echo '<BR>'.$sql_d;
$consulta_d			= mysql_query($sql_d);
$campos_d			= mysql_fetch_array($consulta_d);
$nom_empresa		= $campos_d["nom_empresa"];
$nomContacto		= $campos_d["nom_contacto"];
$finaliza_campo		= $campos_d["finaliza_campo"];


$cId	= $ID;
if(empty($ID)){
	$cId	= $_REQUEST['cId'];
}
//echo '<BR>cId: '.$cId;

// Si viene del call
$indicadorObligatorio	= "	<font style='font-size:14px; color:#FF0000'>*</font>";

//------ consulta todas la llamadas realizadas al contacto
$sqlC = "SELECT C.cod_resultado,CR.nom_cod_resultado,C.observacion_call,
	DATE_FORMAT(fecha_registro, '%d/%m/%Y (%H:%i)') AS fechaRegistro
 FROM ".tablaResultContacto." C LEFT JOIN ".tablaCodResultado." CR ON(CR.cod_resultado=C.cod_resultado)
WHERE cod_empleado='$ID'
	ORDER BY fecha_registro DESC";
//echo '<BR>'.$sqlC;
$consultaC				= mysql_query($sqlC);
$filasRegContacto		= NULL;
$contador				= 0;
while($camposC			= mysql_fetch_array($consultaC)){
	++$contador;
	$codResultado		= $camposC['cod_resultado'];
	$nom_cod_resultado	= $camposC['nom_cod_resultado'];
	$fechaRegistro		= $camposC['fechaRegistro'];
	$observacion_call	= $camposC['observacion_call'];

	$colorBg = '#ECE9D8';
	if($contador % 2 == 0){
		$colorBg = '#FFFFFF';
	}

	$filasRegContacto	.= "
	 <TR height='20' style='background-color:$colorBg'>
	  <TD class='borderBR' align='center' valign='top' nowrap='nowrap'><div class='padding5' style='color:$colorFuente'>$contador</div></TD>
	  <TD class='borderBR' align='left' valign='top' nowrap='nowrap'><div class='padding5' style='color:$colorFuente'>$fechaRegistro</div></TD>
	  <TD class='borderBR' align='left' valign='top'><div class='padding5' style='color:$colorFuente'>$nom_cod_resultado</div></TD>
	  <TD class='borderBR' align='left' valign='top'><div class='padding5' style='color:$colorFuente'>$observacion_call</div></TD>
	 </TR>";
}

$displayDivFecha	= 'none';
if($codResultado==idCodResultadoCita){
	$displayDivFecha	= 'block';
}

$sqlG	= "SELECT tipo FROM ".tablaCodResultado." GROUP BY tipo";
//echo '<BR>'.$sqlG;
$consultaG	= mysql_query($sqlG);
$optionCR	= NULL;
while($camposG	= mysql_fetch_array($consultaG)){
	$tipo		= $camposG['tipo'];

	$optionCR	.= "<OPTGROUP label='".$arrayNomGrupoCodResultado[$tipo]."'>";

	$sqlCR	= "SELECT * FROM ".tablaCodResultado." WHERE estado=1 AND tipo='$tipo' ORDER BY 1";
	//echo '<BR>'.$sqlCR;
	$consultaCR	= mysql_query($sqlCR);
	while($camposCR			= mysql_fetch_array($consultaCR)){
		$cod_resultado		= $camposCR['cod_resultado'];
		$nom_cod_resultado	= $camposCR['nom_cod_resultado'];
	
		$selected	= NULL;
	//		if($cod_resultado == $codResultado){$selected	=' selected';}
		$optionCR	.= "<OPTION value='$cod_resultado' $selected>$nom_cod_resultado</OPTION>";
	}
	$optionCR	.= "</OPTGROUP>";
}
$arrayHora	= array('07','08','09','10','11','12','13','14','15','16','17','18');
$arrayMin	= array('00','05','10','15','20','25','30','35','40','45','50','55');
$arrayAMPM	= array('AM','PM');

$optionHora	= NULL;
foreach($arrayHora as $i => $j){
	//echo '<BR>campo: '.$i.' valor: '.$j;
	$selected	= NULL;
//		if($j == $hora_cita){$selected	=' selected';}
	$optionHora	.= "<OPTION value='$j' $selected>$j</OPTION>";
}
$optionMin	= NULL;
foreach($arrayMin as $i => $j){
	//echo '<BR>campo: '.$i.' valor: '.$j;
	$selected	= NULL;
//		if($j == $minuto_cita){$selected	=' selected';}
	$optionMin	.= "<OPTION value='$j' $selected>$j</OPTION>";
}

$vbID		= NULL;
//echo '<BR>ID: '.$ID;
if($_REQUEST['origen']=='callCNC'){
	$vbID	= "<BR>ID: $ID";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>..:: <?=tituloPag?> ::..</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<LINK rel="stylesheet" href="../style.css" type="text/css">
<link rel="STYLESHEET" type="text/css" href="../calendar.css">
<script language="JavaScript" src="../simplecalendar.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript" src="../js.js"></script>

<script>
function validar(idCodResultadoCita,idCodResultadoEfectiva){
	var codResultado	= document.getElementById('codResultado').value;
	if(codResultado == ''){
		alert('Por favor seleccione un código de resultado');
		document.getElementById('codResultado').focus();
		return(false);
	}
	else if(codResultado == idCodResultadoCita){// si es cita
		if(document.getElementById('fechaCita').value==''){
			alert('Por favor seleccione la fecha de la cita');
			document.getElementById('fechaCita').focus();
			return(false);
		}
		else if(document.getElementById('cHora').value==''){
			alert('Por favor seleccione la hora de la cita');
			document.getElementById('cHora').focus();
			return(false);
		}
		else if(document.getElementById('cMinuto').value==''){
			alert('Por favor seleccione la hora de la cita (minutos)');
			document.getElementById('cMinuto').focus();
			return(false);
		}
	}
	else if(codResultado == idCodResultadoEfectiva){// si es efectiva
		elemento	= 'serviciosEfectiva[]';
		frm			= document.formulario;
		if(typeof frm[elemento] != 'undefined'){
			var marcado	= false;
			for (var i = 0, total = frm[elemento].length; i < total; i++){
				if(frm[elemento][i].checked==true){
					marcado	= true;
				}
			}
			if(marcado == false){
				alert('Por favor seleccione los servicios donde aplicó la encuesta');
				return(false);
			}
		}
	}
	else{
		return(true);
	}
}

function mostrarCapa(idCodResultadoCita,idCodResultadoEfectiva){
	var codResultado	= document.getElementById('codResultado').value;
	if(codResultado == idCodResultadoCita){
		showdiv('divVbFechaCita');
		showdiv('divFechaCita');
	}
	else{
		hidediv('divVbFechaCita');
		hidediv('divFechaCita');
	}
	if(codResultado == idCodResultadoEfectiva){
		showdiv('divListaServicios');
	}
	else{
		hidediv('divListaServicios');
	}
}


//alert('ancho pantalla: '+screen.width + " x " + screen.height);

</script>
</HEAD>
<BODY style="background-color:#FFFFFF">
<!--<FORM name="formulario" id="formulario" method="post" action="index.php" onSubmit="return validar();">
-->
<FORM name="formulario" id="formulario" method="post" action="">
<INPUT type='hidden' name='nroEfectivas' id='nroEfectivas' value='0'>
<div id="idDiv_ContactoSIA" align="left" style="display:none; margin:auto; margin-left:150px; margin-top:0px; position:absolute; background-image:url(/imagenes/cdc_bgpage1.jpg); border-style:solid; border-color:#CCCCCC; border-width:4px; width:500px">
	  <TABLE width='10%' align='center' border='0' cellspacing='0' cellpadding='0'>
	   <TR>
	    <TD align="right" nowrap="nowrap" colspan="2" height="35"><div align='right'><a href="javascript:hidediv('idDiv_ContactoSIA')"><img src='/imagenes/errores.gif' height='25' border='0' alt='Cerrar' title='Cerrar'></a></div></TD>
	   </TR>
	   <TR>
	    <TD class="bb" nowrap="nowrap">Contacto</TD>
	    <TD class="bb">
		<input type='text' name="nom_contacto" id="nom_contacto" style="width:350px;">
	    </TD>
	   </TR>
	   <TR>
	    <TD class="bb" nowrap="nowrap">Tel&eacute;fono</TD>
	    <TD class="bb">
		<input type='text' name="tel_contacto" id="tel_contacto" style="width:350px;">
	    </TD>
	   </TR>
	   <TR>
	    <TD>&nbsp;</TD>
	    <TD align="left" colspan="1"><INPUT type='button' name='btn_grabar_contacto_sia' id='btn_grabar_contacto_sia' class='Button' value='Grabar' onClick="grabar_contacto_sia();"></TD>
	   </TR>
	   <TR>
	    <TD align="center" colspan="2"><div id="div_grabar_contacto_sia"></div></TD>
	   </TR>
	  </TABLE>
</div>
<? // include("nuevo_contacto.php"); ?>

<TABLE width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
 <TR>
  <TD style="height:110px; background-image:url(imagenes/header_back.jpg)">
  <? //=$sup?>
  <TABLE width="100%" cellspacing="0" cellpadding="0" align='center' border="0">
	<TR>
	 <TD width="91%" height="110" align='left' valign="top">
	  <TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
	   <TR>
		<TD align="left" valign='top'><IMG src='/imagenes/logoEcopetrolgnn2.jpg' height='75'></TD>
	   </TR>
	   <TR>
		<TD align="left" valign='top'><div style='font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #6699CC; font-weight: bold; margin-left:10px;'>Contacto: <?=$nomContacto?><?=$vbID?></div></TD>
	   </TR>
	  </TABLE>
	 </TD>
	 <TD width="9%" align='left'>
	  <TABLE width="100%" height="105" border="0" align="left" cellpadding="0" cellspacing="0">
	   <TR>
	<TD width="37%" height="30" align='right' valign="bottom"><a href="logout.php"><img src="/imagenes/icoblg_candado.png" alt="Salir" title="Salir" height="30" border="0" style="margin-right:5px;"></a></TD>
	   </TR>
	  </TABLE>
	 </TD>
	</TR>
  </TABLE>
  <? //=$inf?>
  </TD>
 </TR>
 <TR>
  <TD><IMG src='/imagenes/spacer.gif' width='1' height='1' border="0"></TD>
 </TR>
 <TR>
  <TD>
  <?=$sup?>
   <TABLE width="100%" cellspacing="0" cellpadding="0" align='center' border="0">
	<TR>
	  <TD align="left" height="35" style='background-color:#F0F0F0;'><font color="#336666" size="2">
<U><B>Objetivo del estudio:</B></U> conocer las percepciones de los usuarios, con el prop&oacute;sito final de mejorar los servicios que presta.</font></TD>
	</TR>
   </TABLE>

	<?
	if($finaliza_campo=='0'){
	?>
   <TABLE width='100%' align='center' border='0' cellspacing='0' cellpadding='0'>
    <TR>
     <TD colspan="2"><IMG src='/imagenes/spacer.gif' width='1' height='10' border="0"></TD>
    </TR>
    <TR>
	 <TD width="15%" class='TableRow' nowrap="nowrap"><div style="margin-right:5px;">Código de resultado:</div></TD>
	 <TD width="85%" align="left" colspan="5" class='TableRow'>
		<SELECT name='codResultado' id='codResultado' lang='SI' class='userText' onChange="mostrarCapa(<?=idCodResultadoCita?>,<?=idCodResultadoEfectiva?>);">
		 <OPTION value='' selected>Seleccione...</OPTION>
		 <?=$optionCR?>
		</SELECT><?=$indicadorObligatorio?>
	 </TD>
	</TR>

    <TR>
	 <TD class='TableRow' align="left"><div id="divVbFechaCita" style="display:<?=$displayDivFecha?>">Fecha cita</div></TD>
	 <TD class='TableRow' align="left" nowrap="nowrap"><div id="divFechaCita" style="display:<?=$displayDivFecha?>">
	  <TABLE width='100%' align='center' border='0' cellspacing='0' cellpadding='0'>
	   <TR>
	    <TD width="19%" align="left">
		<input type="text" name="fechaCita" id="fechaCita" size="14" maxlength="10" class="small txt"  value="<?=$fecha_cita?>" readonly=""/>
		<a href="javascript: void(0);" onClick="g_Calendar.show(event,'formulario.fechaCita',false, 'yyyy-mm-dd', new Date(),new Date(2013,11,14)); return false;"><img src="/graficas/calendar.gif" name="imgCalendar" border="0" alt="Seleccionar fecha" /></a>	    </TD>
	    <TD width="5%" align="left">Hora:</TD>
	    <TD width="7%" align="left">
		<select name="cHora" id="cHora" class="txt">
		  <option value="">--</option>
		  <?=$optionHora?>
		</select>	    </TD>
	    <TD width="4%" align="left">Min:</TD>
	    <TD width="65%" align="left">
		<select name="cMinuto" id="cMinuto" class="txt">
		  <option value="">--</option>
		  <?=$optionMin?>
		</select>
		</TD>
	   </TR>
	  </TABLE>
	  </div>
	 </TD>
	</TR>

    <TR>
	 <TD colspan="6" align="left">Observaciones<br/>
		<TEXTAREA name='observacionesCall' id='observacionesCall' lang='NO' class='userText borderB' style='width:100%; height:80px;'></TEXTAREA>	 </TD>
	</TR>
	 <TD colspan="6" align="center">
		<INPUT type='hidden' name='primerIngreso' id='primerIngreso' value='NO'>
		<INPUT type='hidden' name='usuario_call' id='usuario_call' value='<?=$usuario_call?>'>
		<INPUT type='hidden' name='usuarioPost' id='usuarioPost' value='<?=$usuPost?>'>
		<INPUT type='hidden' name='ID' id='ID' value='<?=$ID?>'>
		<INPUT type='hidden' name='origen' id='origen' value='<?=$origen?>'>
		<INPUT type='submit' name='btn_enviar_call' id='btn_enviar_call' class='Button' value='Enviar' onClick="return validar(<?=idCodResultadoCita?>,<?=idCodResultadoEfectiva?>);">
	 </TD>
	</TR>
   </TABLE>
<?
}
elseif($finaliza_campo=='1'){
?>
	<div align="center" style="height:40px; vertical-align:middle"><FONT style="font-size:16px; color:#CC6600;">El trabajo de campo del actual registro finaliz&oacute;</FONT></div>
<?
}
?>
   <TABLE width='100%' align='center' border='0' cellspacing='0' cellpadding='0' class="borderTL">
	<TR style='background-color:#DDDDDD'>
	 <TD width='4%' align="center" class='borderBR'><div class='padding5' style='color:#000000;'><B>Cont.</B></div></TD>
	 <TD width='12%' align="center" class='borderBR' nowrap="nowrap"><div class='padding5' style='color:#000000;'><B>Fecha</B></div></TD>
	 <TD width='20%' align="center" class='borderBR'><div class='padding5' style='color:#000000;'><B>Cod. resultado</B></div></TD>
	 <TD width='64%' align="center" class='borderBR'><div class='padding5' style='color:#000000;'><B>Comentario</B></div></TD>
	</TR>
	<?=$filasRegContacto?>
   </TABLE>
  <?=$inf?>
  </TD>
 </TR>
</TABLE>
</FORM>
</BODY>
</HTML>
