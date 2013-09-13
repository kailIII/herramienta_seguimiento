<?
@session_start();
header('Content-Type: text/html; charset=iso-8859-1');
include("../../libreria.php");
include("../../connection.php");
set_time_limit(0);

if(empty($_SESSION['userAdmin'])){
	?>
	<hr />
	<div id='f' style='display:block; height:80px; background-color:#E5E5E5; border:solid; border-color:#DFDFDF; border-width:10px; vertical-align:middle;' align='center'><br />
<span class="subtitulos_azules">Su sesión ha finalizado, por favor ingrese nuevamente</span><BR />
<BR />
	<div align="center"><a href="../campo/" class="enlace_titulo_noticia1">Ingresar</a></div>
	<div align="center">&nbsp;</div>
	</div>
	<?
	exit();
}
$userId			= $_SESSION['userAdmin'];

$ESTADO			= $_POST['estado'];
$cBuscar		= utf8_decode($cBuscar);
$regInicial		= !empty($_POST['cRegInicial'])?	$_POST['cRegInicial']:	0;
//echo '<BR>ESTADO: '.$ESTADO;

//$condTodos	= " tipo_usuario !='DEMO'";
$condTodos	= " avance < ".numPaginas;
// Si filtró pendientes
$FILA		= NULL;
$having		= NULL;
$limite		= NULL;
$filaCitas	= NULL;
$CONTADOR	= 0;
if($regInicial > 0){
	$CONTADOR	= $regInicial-1;
}
if($ESTADO == 'P'){
	$titulo		= "Encuestas Pendientes";
//	$COND_D		= " avance = 0 AND R.usuario_call='".$userId."'";
//	$COND_D		= " R.usuario_call='".$userId."'";
	$COND_D		= " 1";
	$ORDEN1		= '1';
	$nroRegistros1	= $nroRegistros+20;	
	$limit1		= "LIMIT $regInicial,$nroRegistros1";
//	$limit		= "LIMIT $regInicial,$nroRegistros";
	$limit		= "LIMIT $regInicial,$nroRegistros";

}
// Si filtró iniciadas
elseif($ESTADO == 'I'){
//	$titulo		= "Encuestas Iniciadas";
//	$COND_D		= " avance BETWEEN 1 AND ".(numPaginas-1);
//	$ORDEN1		= 'avance DESC,fecha_encuesta DESC';
}

$vistaContacto	= vistaContacto;
$whereBuscar	= NULL;
//echo '<BR>cBuscar: '.$cBuscar;

if(!empty($cBuscar)){
	$vistaContacto	= vistaContactoAll;
//	$COND_D		.= " AND D.cod_empleado LIKE '%$cBuscar%'";
	$whereBuscar	= " AND cod_empleado='$cBuscar'";
	$whereBuscar	= " WHERE cod_empleado='$cBuscar'";
}

$sql_d = "SELECT * FROM ".$vistaContacto." $whereBuscar $limit";
//echo '<BR>'.$sql_d;
$consulta_d	= mysql_query($sql_d);
if(mysql_num_rows($consulta_d)==0){
	$FILA	.= "
	 <TR class='tableRow'>
	  <TD align='left' class='tableRow' valign='top' colspan='15'>
	   <div id='f' style='display:block; height:80px; background-color:#E5E5E5; border:solid; border-color:#DFDFDF; border-width:10px; vertical-align:middle;' align='center'><br />
	   <span class='subtitulos_azules'>No se encontraron registros para el filtro aplicado, por favor realice una nueva búsqueda.</span></div>
	  </TD>
	 </TR>";
}
while($campos_d			= mysql_fetch_array($consulta_d)){
	++$CONTADOR;
	$idRow				= $campos_d["id"];
	$ID					= $campos_d["cod_empleado"];
	$tipoUsuario		= $campos_d["tipo_usuario"];
	$nomContacto		= $campos_d["nom_contacto"];
	$nomCargo			= $campos_d["cargo"];
	$nom_ciudad			= $campos_d["nom_ciudad"];
	$direccion			= $campos_d["direccion"];
	$telefono			= $campos_d['telefono'];
	$telefono2			= $campos_d['telefono2'];
	$celular			= $campos_d['celular'];
	$ext				= $campos_d['ext'];
	$mailUsuario		= $campos_d['email'];
	$avance				= $campos_d['avance'];
	$observacion		= $campos_d['observacion'];
	$tipo_pedido		= $campos_d['tipo_pedido'];

	if(empty($nomContacto)){
		$nomContacto	= 'Sin definir';
	}
	if(empty($mailUsuario)){
		$mailUsuario	= '&nbsp;';
	}
	if(!empty($ext)){
		$telefono		.= ' Ext.'.$ext;
	}
	if(!empty($telefono2)){
		$telefono		.= ' / '.$telefono2;
	}
	if(!empty($celular)){
		$telefono		.= ' / '.$celular;
	}
	if(!$entidad)		$entidad = "&nbsp;";
	if(!$mailUsuario)	$mailUsuario = "&nbsp;";
	if(!$telefono)		$telefono = "No tiene";

	$linkEnviaMail		= "$mailUsuario";

	$linkCodResultado	= "<a target='_blank' title='Registrar resultado de la interacci&oacute;n' href='index_cod_resultado.php?usuarioPost=$ID&ID=$ID&usuario_call=".$userId."&origen=callCNC'><img src='/imagenes/icoblg_fondo1.png' height='18' border='0'></a>";


	$icoCodResult	= "&nbsp;";
	$colorBg		= "#FFFFFF";
//	if(!empty($codResultado)){
	if($encontroGestion=='SI'){
		$path_icono	= "/imagenes/btn_editar_1.gif";
		$height_icono	= 18;
//		$colorBg		= "#ECE9D8";
		$colorBg		= "#F4DDBD";
		//------ construye el ícono del código de resultado
		$icoCodResult	= "<img src='$path_icono' height='$height_icono' border='0' alt='$vbCodResultado' title='$vbCodResultado'>";
	}
	if($avance == numPaginas){
		$colorBg		= "#F4DDBD";
	}

	$colorBgEfectiva	= $colorBg;
	//---- consulta la lista de servicios que le aplican al usuario
	//---- si es admin le muestra todos los servicios que le aplican
	//echo '<BR>esADMIN: '.$esADMIN;
	if($esADMIN	== '1'){
		$sql_s = "
		SELECT M.id_servicio,M.nom_servicio,M.muestra,M.realizadas
		 FROM ".tablaServiciosAplica." C INNER JOIN ".vistaMuestra." M
		 	ON(M.id_servicio=C.id_servicio)
		WHERE C.cod_empleado='$ID' AND M.estado=1
		 ORDER BY M.prioridad ASC";
	}
	else{
		$sql_s = "
		SELECT M.id_servicio,M.nom_servicio,M.muestra,M.realizadas
		 FROM ".tablaServiciosAplica." C INNER JOIN ".vistaMuestra." M
		 	ON(M.id_servicio=C.id_servicio)
		WHERE C.cod_empleado='$ID' AND M.muestra > M.realizadas AND M.estado=1
			AND C.estado=1
		 ORDER BY M.prioridad ASC";
	}
	//echo '<BR>'.$sql_s;
	$servicio1				= NULL;
	$subServicio1			= NULL;
	$filasServicio			= NULL;
	$contSubservicios		= 0;
	$mostrarRegistro		= 0;
	$consulta_s				= mysql_query($sql_s);
	while($campos_d			= mysql_fetch_array($consulta_s)){
		++$contSubservicios;
		$id_servicio		= $campos_d['id_servicio'];
		$nom_servicio		= $campos_d["nom_servicio"];
		$muestra			= $campos_d["muestra"];
		$realizadas			= $campos_d["realizadas"];
		$efectiva			= $campos_d["efectiva"];

		$colorBgEfectiva	= $colorBg;
		if($efectiva=='1'){
			$colorBgEfectiva= "#E6F2E6";
		}
		//---- si ya se cumplió o superó la muestra
		$colorMuestra	= "#5F5F5F";
		$vbCerrado		= NULL;
		if($realizadas >= $muestra){
			$colorMuestra	= "#CC3300";
			$vbCerrado		= '(Cerrado) ';
		}

		if($contSubservicios == 1){
			$servicio1		= "<div class='marginL5' style='color:$colorMuestra;'>$vbCerrado$nom_servicio</div>";
			$subServicio1	= "<div class='marginL5' style='color:$colorMuestra;'>$nom_subservicio</div>";
		}
		else{
			$filasServicio		.= "
			 <TR height='20'>
			  <TD align='left' class='bb' valign='top' style='background-color:$colorBgEfectiva'><div class='marginL5' style='color:$colorMuestra;'>$vbCerrado$nom_servicio</div></TD>
			 </TR>";
		}
	}
	$linkEncuesta		= "<a target='_blank' alt='Ir a la encuesta' title='Ir a la encuesta' href='../cuestionario/index.php?idPost=".$idRow."&codEmpleado=".$ID."&usuario_call=".$userId."&origen=callCNC'><font color='#336666'>$nomContacto</font></a>";

	$rowspan	= NULL;
	if($contSubservicios > 1){
		$rowspan	= "rowspan='$contSubservicios'";
	}
	$vbContador		= number_format($CONTADOR);
	if($ESTADO == 'P' && $contSubservicios > 0){
		$FILA		.= "
		 <TR height='20' style='background-color:$colorBg'>
		  <TD align='left' class='bb' valign='top' $rowspan><div class='marginL5' style='color:#5F5F5F;'>$vbContador</div></TD>
		  <TD align='left' class='bb' valign='top' $rowspan><div class='marginL5' style='color:#5F5F5F;'>$linkCodResultado</div></TD>
		  <TD align='left' class='bb' valign='top' $rowspan><div class='marginL5' style='color:#5F5F5F;'>$ID</div></TD>
		  <TD align='left' class='bb' valign='top' $rowspan><div class='marginL5' style='color:#5F5F5F;'>$linkEncuesta</div></TD>
		  <TD align='left' class='bb' valign='top' $rowspan><div class='marginL5' style='color:#5F5F5F;'>$nomCargo</div></TD>
		  <TD align='left' class='bb' valign='top' style='background-color:$colorBgEfectiva'>$servicio1</TD>
		  <TD align='left' class='bb' valign='top' $rowspan><div class='marginL5' style='color:#5F5F5F;'>$tipo_pedido</div></TD>
		  <TD align='left' class='bb' valign='top' $rowspan><div class='marginL5' style='color:#5F5F5F;'>$nom_ciudad</div></TD>
		  <TD align='left' class='bb' valign='top' $rowspan><div class='marginL5' style='color:#5F5F5F;'>$telefono</div></TD>
		 </TR>
		 $filasServicio";

	}
}
?>
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
 <TR height='20' style='background-color:#DDDDDD'>
  <TD width="1%" align='left'><div class='marginL5' style='color:#5F5F5F;'><B>Cont</B></div></TD>
  <TD width="1%" align='left'>&nbsp;</TD>
  <TD width="4%" align='left'><div class='marginL5' style='color:#5F5F5F;'><B>Código</B></div></TD>
  <TD align='left'><div class='marginL5' style='color:#5F5F5F;'><B>Contacto</B></div></TD>
  <TD width="10%" align='left'><div class='marginL5' style='color:#5F5F5F;'><B>Cargo</B></div></TD>
  <TD width="15%" align='left'><div class='marginL5' style='color:#5F5F5F;'><B>Servicio</B></div></TD>
  <TD width="5%" align='left' nowrap="nowrap"><div class='marginL5' style='color:#5F5F5F;'><B>Tipo pedido</B></div></TD>
  <TD width="10%" align='left'><div class='marginL5' style='color:#5F5F5F;'><B>Ciudad</B></div></TD>
  <TD width="20%" align='left'><div class='marginL5' style='color:#5F5F5F;'><B>Teléfono</B></div></TD>
 </TR>
 <?=$FILA?>
</TABLE>
<!--<img src='/imagenes/spacer.gif' height='5' border='0' />
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
 <?=$filaVolverLlamar?>
</TABLE>
-->