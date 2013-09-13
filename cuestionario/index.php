<?
include("ctl_login_c.php");

//$codEmpleado	= $_REQUEST['codEmpleado'];
$conEncuesta	= $_REQUEST['conEncuesta'];//---- determina si ya llegó al index, es una restricción para no preguntar las preguntas generales en medio de formulario, asi garantiza que solo pregunta unicamente al inicio.

//$trackServicio	= $_REQUEST['trackServicio'];
//$trackServicio	= $trackActivo;
//echo '<BR>origen: '.$origen;

$aplicoFormGeneral				= $_POST['aplicoFormGeneral'];
$tablaRTA						= tablaRTA;
$aplicoFormRetroalimentacion	='0';
if($aplicoFormGeneral=='1'){
	$idServicio		= $_REQUEST['c_FormGeneral'];
	$tablaRTA		= tablaRtaGral;
}
elseif($_REQUEST['c_servicio']==idFormRetroalimentacion){
	$aplicoFormRetroalimentacion='1';
	$idServicio		= $_REQUEST['c_servicio'];
	$tablaRTA		= tablaRtaRetroalimentacion;
}
else{
	$c_servicio		= $_REQUEST['c_servicio'];
	$idServicio		= $c_servicio;
}

$cond_cap_sensibilizacion	= NULL;	//---- si es el call center carga preguntas de sensibilización
//---- si es autodiligenciada
if($origen!=idOrigenCallCNC){
	$aplicarFormGeneral	= 1;
	$idServicio		= $_REQUEST['c_servicio'];
	$tablaRTA		= tablaRTA;
	if($idServicio==idFormGeneral){
		$tablaRTA		= tablaRtaGral;
	}
	elseif($idServicio==idFormRetroalimentacion){
		$aplicoFormRetroalimentacion='1';
		$tablaRTA		= tablaRtaRetroalimentacion;
	}
	//echo '<BR>aplicarFormGeneral: '.$aplicarFormGeneral;
}  
include("../funciones.php");

include("dml_insert.php");

//---- si viene del call center consulta los servicios que le aplican para cargar el combo
if($origen==idOrigenCallCNC){
	include("sql_servicio.php");
}

$mostrarFormulario	= 0;
$aplicoFormGeneral	= 0;
//---- consulta si ya se aplicaron las preguntas generales
$sql = "SELECT submit,form_general,form_retroalimentacion
	FROM ".tablaEstadoContacto." WHERE cod_empleado='$codEmpleado'";
//echo '<BR>'.$sql;
$form_general				= 0;
$form_retroalimentacion		= 0;
$con						= mysql_query($sql);
while($campos				= mysql_fetch_array($con)){
	$submit					= $campos['submit'];
	$form_general			= $campos['form_general'];
	$form_retroalimentacion	= $campos['form_retroalimentacion'];
}
//---- si ya se realizó un envio anula la posibilidad de cargar las preguntas generales
if($submit == '1'){
	$aplicarFormGeneral = 0;
}
//echo '<BR>aplicarFormGeneral: '.$aplicarFormGeneral;
//if($form_general == '0' && $aplicarFormGeneral == 1 && empty($conEncuesta)){
if($form_general == '0' && $aplicarFormGeneral == 1 && $submit == '0'){
	$mostrarFormulario	= 1;
	$aplicoFormGeneral	= 1;
	$idServicioActivo	= idFormGeneral;
}
elseif($form_retroalimentacion == '0' && $aplicoFormRetroalimentacion == 1 && empty($conEncuesta)){
	$mostrarFormulario	= 1;
	$idServicioActivo	= idFormRetroalimentacion;
}  
elseif(!empty($idServicio) && empty($_POST['btn_enviar'])){
	$mostrarFormulario	= 1;
	$idServicioActivo	= $idServicio;
}
//---- si es autodiligenciada
elseif($origen!=idOrigenCallCNC){
	$mostrarFormulario	= 1;
}
//echo '<BR>mostrarFormulario: '.$mostrarFormulario;
//echo '<BR>idServicioActivo1: '.$idServicioActivo;

// ---- consulta los servicios que le aplican
$sql = "
	SELECT COUNT(1) totalServicios
	 FROM ".tablaServiciosAplica." C INNER JOIN ".vistaMuestra." M
		ON(M.id_servicio=C.id_servicio)
	WHERE C.cod_empleado='$codEmpleado' AND M.estado=1
		AND M.muestra > M.realizadas
			AND C.estado=1";
//echo '<BR>'.$sql;
$totalServicios			= 0;
$con					= mysql_query($sql);
while($campos			= mysql_fetch_array($con)){
	$totalServicios		= $campos['totalServicios'];
}
// ---- consulta los servicios que ya respondió
$sql = "
	SELECT COUNT(1) totalServicios
	 FROM ".tablaServiciosAplica." C INNER JOIN ".vistaMuestra." M
		ON(M.id_servicio=C.id_servicio)
	WHERE C.cod_empleado='$codEmpleado' AND M.estado=1
			AND efectiva = '1'";
//echo '<BR>'.$sql;
$totalDiligenciados		= 0;
$con					= mysql_query($sql);
while($campos			= mysql_fetch_array($con)){
	$totalDiligenciados	= $campos['totalServicios'];
}

$sql = "
	SELECT COUNT(1) aplicoEstrategico
	  FROM ".tablaRTA." WHERE id_servicio = 90 AND cod_empleado='$codEmpleado'";
//echo '<BR>'.$sql;
$aplicoEstrategico		= 0;
$con					= mysql_query($sql);
while($campos			= mysql_fetch_array($con)){
	$aplicoEstrategico	= $campos['aplicoEstrategico'];
}

//---- verifica si terminó o diligenció 7 cuestionarios
//if(($totalDiligenciados >= $totalServicios || $totalDiligenciados >= maximoFormularios) && $origen!=idOrigenCallCNC){
if(($totalDiligenciados >= $totalServicios || $totalDiligenciados >= maximoFormularios || $aplicoEstrategico > 0) && $origen!=idOrigenCallCNC){
	include("pag_gracias.php");
	exit();
}

//---- verifica si el total de servicios
if($totalServicios >= basePorAvance){
	$basePorAvance	= basePorAvance;
}
else{
	$basePorAvance	= $totalServicios;
}

if($totalDiligenciados == basePorAvance+1){
	$totalDiligenciados	= $totalDiligenciados+2;
}
elseif($totalDiligenciados == basePorAvance+2){
	$totalDiligenciados	= $totalDiligenciados+4;
}
elseif($totalDiligenciados == basePorAvance+3){
	$totalDiligenciados	= $totalDiligenciados+6;
}
elseif($totalDiligenciados == basePorAvance+4){
	$totalDiligenciados	= $totalDiligenciados+8;
}

$porAvance			= porcentaje($basePorAvance, $totalDiligenciados, $ndecimales=0);
//echo '<BR>totalServicios: '.$totalServicios.' totalDiligenciados: '.$totalDiligenciados.' porAvance: '.$porAvance;
if($porAvance < 1){
	$imgPorAvance	= "<IMG src='../progressbar0.png?v=1' height='33' border='0'>";
	$vbPorAvance	= "0%";
}
elseif($porAvance < 35){
	$imgPorAvance	= "<IMG src='../progressbar33.png' height='33' border='0'>";
	$vbPorAvance	= "33%";
}
elseif($porAvance <= 67){
	$imgPorAvance	= "<IMG src='../progressbar66.png' height='33' border='0'>";
	$vbPorAvance	= "66%";
}
elseif($porAvance > 67){
	$imgPorAvance	= "<IMG src='../progressbar100.png' height='33' border='0'>";
	$vbPorAvance	= $porAvance."%";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>..:: <?=tituloPag?> ::..</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META http-equiv="Pragma" content="no-cache">
<LINK rel="stylesheet" href="../style.css" type="text/css">
<script language="JavaScript" type="text/javascript" src="../js.js"></script>
<script language="JavaScript" type="text/javascript" src="funciones11.js"></script>
<style>
.contenedorRows{
	width:900px;
	text-align:left;
	border:none;
	background-color:#FFFFFF;
	border-bottom: 1px solid #D6D6D6;
	overflow:auto;
	position:relative;
}
.divCapitulo{
	width:100%;
	height:25px;
	text-align:center;
	vertical-align:middle;
	padding:5px;
	background-image:url(/imagenes/cnc_menubar_gris.gif);
}
.divInstruccion{
	background-color:#F0F0F0;
	color:#333366;
}
.divInstruccion2{
	background-color:#E6F2E6;
	color:#333366;
}
.divInstruccionItem{
	float:left;
	width:30px;
	text-align:left;
	vertical-align:middle;
	padding:5px;
}
.divInstruccionDes{
	float:left;
	width:400px;
	height:40px;
	text-align:left;
	vertical-align:middle;
	padding:5px;
	border-bottom: 1px solid #D6D6D6;
	border-right: 1px solid #D6D6D6;
	
}
.widthRadio {
	float:left;
	width:40px;
	position:relative;
	height:100%;
	min-height:100%;
	padding:auto;
	border-bottom: 1px solid #D6D6D6;
	border-right: 1px solid #D6D6D6;
}
</style>
<noscript><div align="center" style="font-size:24px; color:#FF0000;">¡Su navegador no soporta Javascript!...<br />
No continúe!!!<br />
Por favor consulte con el administrador.<br /></div>
<META HTTP-EQUIV="Refresh" CONTENT="1; URL=sinscripts.html">
<? // exit(); ?></noscript>
</HEAD>
<BODY style="background-color:#FFFFFF">
<FORM name="formulario" id="formulario" method="post" action="" onSubmit="return validarPagina();">
<INPUT type='hidden' name='conEncuesta' id='conEncuesta' value='1' lang="0">
<INPUT type='hidden' name='codEmpleado' id='codEmpleado' value='<?=$codEmpleado?>' lang="0">
<INPUT type='hidden' name='usuario_call' id='usuario_call' value='<?=$usuario_call?>' lang='0'>
<INPUT type='hidden' name='origen' id='origen' value='<?=$origen?>' lang='0'>
<TABLE width="900" border="0" cellspacing="0" cellpadding="0" align="center">
 <TR>
  <TD>
  <TABLE width="100%" cellspacing="0" cellpadding="0" align='center' border="0">
	<TR>
	 <TD align='left' width="10%"><IMG src='/imagenes/ecopetrol_logo.jpg' height="80" border='0'></TD>
	 <TD width="90%" align='left'>
	  <TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
	   <TR>
<!--		<TD align="left" width="30%" nowrap="nowrap"><div class="padding5 subtitulos_azules"><?=$vbNroPagina?></div></TD>
-->		<TD align='right' width="70%" nowrap="nowrap"><div class="padding5 subtitulos_azules" style="font-size:16px;">Bienvenid@: <?=$nomContacto?> (<?=$codEmpleado?>)</div><a href="logout.php?url=index.php"><img src="/imagenes/icoblg_candado.png" alt="Salir" title="Salir" height="30" border="0" style="margin-right:5px;"></a></TD>
	   </TR>
	  </TABLE>
	 </TD>
	</TR>
   </TABLE>
  </TD>
 </TR>

 <TR>
  <TD>
	<TABLE cellSpacing='0' cellPadding='0' width='100%' align='center' border='0'>
	  <TR>
	   <TD width="10" nowrap="nowrap">&nbsp;</TD>
	   <TD nowrap="nowrap"><IMG src='/imagenes/barra_colores.jpg' width='100%' height='8'></TD>
	   <TD width="10" nowrap="nowrap">&nbsp;</TD>
	  </TR>
	</TABLE>
  </TD>
 </TR>

 <TR>
  <TD><IMG src='/imagenes/spacer.gif' width='1' height='2'></TD>
 </TR>
 <TR>
  <TD align='right' height="40"><?=$imgPorAvance?><div style="position:absolute; margin-left:730px; margin-top:-25px; font-size:14px; color:#000000;"><B><?=$vbPorAvance?></B></div></TD>
 </TR>
 <TR>
  <TD align='right'><div class="padding5" style="font-size:14px;">Si tiene alguna inquietud por favor comunicarse con Alejandro Salazar <a href="mailto:asalazar@cnccol.com"><span style="color:#006699; font-size:14px"><B>asalazar@cnccol.com</B></span></a></div></TD>
 </TR>
<? 
if($porAvance >= 100){
?>
 <TR>
  <TD align='center' class="borderAll"><div style="font-size:16px; padding:10px 5px;">Muchas gracias por participar. Sus opiniones son muy importantes y servirán para mejorar los servicios que recibe. Si eres de los que da más del 100% continúa...</div></TD>
 </TR>
<? 
}
?>
 <TR>
  <TD><IMG src='/imagenes/spacer.gif' width='1' height='5'></TD>
 </TR>
 
<? 
if($origen==idOrigenCallCNC){
?>
 <TR>
  <TD>
<? 
$vbSaludo	= NULL;
if($form_general == '0' && $aplicarFormGeneral == 1){
	$vbSaludo	= "
	Buenos días/tardes/noches, Dr/Dra <em><B>$nomContacto</B></em>, mi nombre es _______ nos estamos comunicando del Centro Nacional de Consultoría actualmente nos encontramos realizando el estudio de evaluación de los procesos y servicios internos de ECOPETROL. El objetivo de la encuesta es escuchar por las oportunidades de mejora que tienen las áreas y procesos internos de ECOPETROL. La información que nos suministre es confidencial a menos que usted nos autorice compartir sus datos junto con sus respuestas.<BR />
Si usted desea conocer más sobre esta encuesta antes de contestarla, por favor comuníquese con el Centro Nacional de Consultoría, teléfono 3394888 Bogotá Colombia.";
?>
   <INPUT type='hidden' name='c_FormGeneral' id='c_FormGeneral' value='<?=idFormGeneral?>' lang="0">
<? 
}
else{
?>
   <TABLE width="100%" cellspacing="0" cellpadding="0" align='center' border="0" class="borderAll">
	<TR>
	  <TD align="left" width="5%"><div class="padding5">Servicio:</div></TD>
	  <TD align="left"><div class="padding5">
	  <SELECT name='c_servicio' id='c_servicio' onChange="document.formulario.submit()">
	   <OPTION value="0" selected="selected">Seleccione...</OPTION>
	   <?=$option_servicios?>
	  </SELECT>
</div></TD>
	</TR>
   </TABLE>
	<?
	if(empty($c_servicio)){
	?>
   <TABLE width="100%" cellspacing="0" cellpadding="0" align='center' border="0" class="borderAll">
	<TR>
	  <TD height="40" align="center"><div class="padding10" style='color:#336666; font-size:18px;'>Por favor seleccione el servicio para cargar el cuestionario</div></TD>
	</TR>
   </TABLE>
<? 
	}
	elseif(empty($aplicoFormRetroalimentacion)){
		$vbSaludo	= "
		Buenos días/tardes/noches, Dr/Dra <em><B>$nomContacto</B></em>, mi nombre es _______ nos estamos comunicando del Centro Nacional de Consultoría actualmente nos encontramos realizando el estudio de evaluación de los procesos y servicios de Ecopetrol. El objetivo de la encuesta <B><u>es escuchar por las oportunidades</u></b> de mejora que tienen las áreas y procesos de ECOPETROL. La información que nos suministre es confidencial a menos que usted nos autorice compartir sus datos junto con sus respuestas.
		<br />
Si usted desea conocer más sobre esta encuesta antes de contestarla, por favor comuníquese con el Centro Nacional de Consultoría, teléfono 3394888 Bogotá Colombia.";
	}
}
?>
  </TD>
 </TR>
 <TR>
  <TD><IMG src='/imagenes/spacer.gif' width='1' height='2'></TD>
 </TR>
<?
} //---- cierra si es es Call Center
?>
 <TR>
  <TD>
<? 
if($mostrarFormulario == 1){
	//---- si es autodiligenciada
	if($origen!=idOrigenCallCNC){
		$cond_cap_sensibilizacion	= " AND cap_sensibilizacion='0'";
		//echo '<BR>idServicioActivo3: '.$idServicioActivo;
		if(empty($idServicioActivo)){
			include("sql_buscar_servicio.php");
		}
		echo "<INPUT type='hidden' name='c_servicio' id='c_servicio' value='$idServicioActivo' lang='0'>";
		echo "<INPUT type='hidden' name='c_FormGeneral' id='c_FormGeneral' value='$idServicioActivo' lang='0'>";
	}
	//echo '<BR><BR>idServicioActivo: '.$idServicioActivo;
	// ---- consulta el nombre del servicio
	$sqlServ = "SELECT nom_servicio
		FROM ".tablaServicio."
			WHERE id_servicio='$idServicioActivo'";
	//echo '<BR>'.$sqlServ;
	$conServ			= mysql_query($sqlServ);
	while($camposServ	= mysql_fetch_array($conServ)){
		$nomServicio	= $camposServ["nom_servicio"];
	}
	//---- registra el tiempo cuando cargó el formulario
	$sqlTiempo = "REPLACE INTO ".tablaTiempo." (cod_empleado,id_servicio,hora_inicio) VALUES ('$codEmpleado','$idServicio',NOW())";
	//echo '<BR>'.$sqlTiempo;
	if(mysql_query($sqlTiempo)){}
	else{
	//echo "<br><font color='#990000' size='3'>Atención!!! Error al guardar la información</font><br>".mysql_error();
	}
?>
	<TABLE width="100%" cellspacing="0" cellpadding="0" align='center' border="0" class="borderALL">
	 <TR>
	  <TD align='left'><div class="padding5" style='color:#336666; font-size:12px;'><?=$vbSaludo?></div></TD>
	 </TR>
	</TABLE>
	<div><IMG src='/imagenes/spacer.gif' width='1' height='2'></div>
	<TABLE width="100%" cellspacing="0" cellpadding="0" align='center' border="0" class="borderTL">
	 <TR>
	  <TD colspan="15" align="left" class="borderBR"><div style='background-color:#FFCC66; font-size:14px; padding:5px;'><B>Usuario del servicio: <u><?=$nomServicio?></u></B></div></TD>
	 </TR>
	</TABLE>
<?
	$nomFile	= "servicio".$idServicioActivo.".php";
	include('form/'.$nomFile);
}
?>
  </TD>
 </TR>
</TABLE>
</FORM>
</BODY>
</HTML>
