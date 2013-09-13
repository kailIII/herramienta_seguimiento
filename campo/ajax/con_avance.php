<?
@session_start();
header('Content-Type: text/html; charset=iso-8859-1');
include("../../libreria.php");
include("../../connection.php");
$userId			= $_SESSION['userAdmin'];

$ESTADO			= $_POST['estado'];
$cSegmento		= $_POST['cSegmento'];
//echo '<BR>ESTADO: '.$ESTADO;

//$condTodos	= " tipo_usuario !='DEMO'";
//$condTodos	= " ccosto = '".cCosto."'";
$condTodos	= " 1";
// Si filtró pendientes

if($ESTADO == 'P'){
	
	$sql_d = "SELECT COUNT(1) total FROM ".vistaContacto;
	//echo '<BR>'.$sql_d;
	$consulta_d		= mysql_query($sql_d);
	$campos_d		= mysql_fetch_array($consulta_d);
	$totalRegistros	= $campos_d["total"];
}
if($ESTADO == 'I'){
	$FILA		.= "
	 <TR height='25' style='background-color:#336699'>
	  <TD colspan='10' align='center'><font color='#CCCCCC' size='3'>$nom_tipo_docente
	  [$titulo: $TOTAL_FILTRO de $TOTAL_CONTACTOS ($PORCENTAJE_AVANCE%)]</font></TD>
	 </TR>";
}
//// SI BUSCA TERMINADOS O NO LLEGA EL PARAMETRO, POR DEFECTO MUESTRA LOS TERMINADOS
elseif($ESTADO == 'F'){
	$FILA		.= "
	 <TR height='25' style='background-color:#336699'>
	  <TD colspan='10' align='center'><font color='#CCCCCC' size='3'>$nom_tipo_docente
	  [$titulo: $TOTAL_FILTRO de $TOTAL_CONTACTOS ($PORCENTAJE_AVANCE%)]</font></TD>
	 </TR>";
}

//------ crea número de páginas
$total_pag	= 0;
for($i=1; $i<=$totalRegistros; $i+=$nroRegistros){
	++$total_pag;
	//echo '<BR>total_pag: '.$total_pag;
}
$paginas	= NULL;
$cont_pag	= 0;
for($i=1; $i<=$totalRegistros; $i+=$nroRegistros){
	++$cont_pag;
//	$regIni	= $i+1;
	$regIni	= $i;
	$regFin	= $i+$nroRegistros;
	$idDivPag	= 'divPag'.$cont_pag;
	$tituloPag	= $regIni." - ".$regFin;
	
	//------ ubica en rojo la página en la cual se encuentra
	$pagActual	= $regInicial+1;
	if($regInicial>0){
		$pagActual	= ($regInicial/$nroRegistros)+1;
	}
	$idDivAct	= 'divPag'.$pagActual;
	$bgDiv		= '#333333';
//	echo '<BR>idDivAct: '.$idDivAct;
	if($idDivPag == $idDivAct){
		$bgDiv	= '#CC0000';
	}
	$paginas	.= "<div id='$idDivPag' align='center' style='float:left; width:20px; height:15px; background-color:$bgDiv'><a href=\"javascript:ubicar_pag('$ESTADO',$i,'$idDivPag',$total_pag)\" alt='Registro $tituloPag' title='Registro $tituloPag'><div style='font-size:9px; color:#FFFFFF; padding:3px;'><B>$cont_pag</B></div></a></div>";
}
?>
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
 <TR height='25' style='background-color:#E5E5E5'>
  <TD colspan='10' align='center'>
	<TABLE width="728" border="0" cellspacing="0" cellpadding="0" align="left">
	 <TR height='25'>
	  <TD width="355" align='right' nowrap="nowrap">Para buscar un contacto por favor ingrese su código</TD>
	  <TD width="29" align='right' nowrap="nowrap"><div style='margin-left:5px; margin-right:5px;'><a href="javascript:quitaFiltro('<?=$ESTADO?>','none')"><img src='/imagenes/ico3_error.png' height='18' border='0' title='Quitar la condición de búsqueda' alt='Quitar la condición de búsqueda'></a></div></TD>
	  <TD width="300" align='right' nowrap="nowrap">
<!--	  	<INPUT type='text' name='cBuscar' id='cBuscar' class='borderB' style="width:300px;" onkeyup="buscar(this,'<?=$ESTADO?>');">
-->	  	<INPUT type='text' name='cBuscar' id='cBuscar' class='borderB' onkeypress="return buscar_contacto(event,'<?=$ESTADO?>','none');" style="width:300px;">
	  </TD>
	  <TD width="9" align='left'>&nbsp;</TD>
	  <TD width="35" align='left' nowrap="nowrap"><a href="javascript:fxAvance('<?=$ESTADO?>','none')">
		<img src='/imagenes/icoblg_lupacolor.png' height='30' border='0' title='Buscar' alt='Buscar'></a>	  </TD>
	 </TR>
	</TABLE>
  </TD>
 </TR>
 <?=$FILA?>
</TABLE>
 <TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
 <TR height='25' style='background-color:#333333'>
  <TD colspan='10' align='center'>
	<?=$paginas?>
  </TD>
 </TR>
</TABLE>
