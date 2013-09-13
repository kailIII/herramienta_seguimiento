<?
// ---- consulta los servicios que le aplican
//---- el estado = 0 indica que el servicion no se le debe aplicar
$sql = "
	SELECT M.id_servicio,M.nom_servicio,M.muestra,M.realizadas,efectiva
	 FROM ".tablaServiciosAplica." C INNER JOIN ".vistaMuestra." M
		ON(M.id_servicio=C.id_servicio)
	WHERE C.cod_empleado='$codEmpleado' AND M.estado=1
		AND C.estado=1
	 ORDER BY M.prioridad ASC";
//echo '<BR>'.$sql;
$contServicios			= 0;
$aplicarFormGeneral		= 0;
$option_servicios		= NULL;
$nomServicio			= NULL;
$vbArticulo1			= NULL;
$vbArticulo2			= NULL;
$con					= mysql_query($sql);
while($campos			= mysql_fetch_array($con)){
	++$contServicios;
	$id_servicio		= $campos['id_servicio'];
	$nom_servicio		= $campos["nom_servicio"];
	$articulo1			= $campos["articulo1"];
	$articulo2			= $campos["articulo2"];
	$muestra			= $campos["muestra"];
	$realizadas			= $campos["realizadas"];
	$efectiva			= $campos["efectiva"];

	$estadoOption		= NULL;
//	if($realizadas >= $muestra){
	if($realizadas >= $muestra && $tipo_usuario!='P'){//---- para que no inactive el formulario de salud a los pensionados
		$estadoOption		= "disabled='disabled'"; //---- Quitar el comentario
	}
	$colorEfectiva			= "#333333";
	if($efectiva == '1'){
		$estadoOption		= "disabled='disabled'";
		$colorEfectiva		= "#009900";
	}

	// ---- consulta la muestra del formulario general del servicio
	$sqlM = "SELECT muestra_gen
		FROM ".tablaMuestraFormGeneral."
			WHERE id_servicio='$id_servicio'";
	//echo '<BR>'.$sqlM;
	$muestra_gen			= 0;
	$conM					= mysql_query($sqlM);
	while($camposM			= mysql_fetch_array($conM)){
		$muestra_gen		= $camposM["muestra_gen"];
	}
	// ---- consulta las encuestas realizadas del formulario general para el actual servicio
	$sqlR = "SELECT COUNT(1) AS realizadas_gen
		FROM ".tablaRtaGral." A INNER JOIN ".tablaRTA." B
		 ON(A.id_servicio=B.id_servicio AND A.cod_empleado=B.cod_empleado)
			WHERE A.id_servicio='$id_servicio' AND B.id_servicio='$id_servicio'";
	//echo '<BR>'.$sqlR;
	$realizadas_gen			= 0;
	$conR					= mysql_query($sqlR);
	while($camposR			= mysql_fetch_array($conR)){
		$realizadas_gen		= $camposR["realizadas_gen"];
	}
	//---- calcula el porcentaje de las encuestas realizadas del servicio
	$porAvanceServicio		= porcentaje($muestra, $realizadas, 1);
	//---- calcula el porcentaje del avance de las preguntas generales
	$porAvanceGenerales		= porcentaje($muestra_gen, $realizadas_gen, 1);
//	echo '<BR>porAvanceServicio: '.$porAvanceServicio;
//	echo '<BR>porAvanceGenerales: '.$porAvanceGenerales;

	//---- verifica si debe aplicar preguntas generales
//	if($porAvanceGenerales <= $porAvanceServicio && $porAvanceServicio>0 && $aplicarFormGeneral == 0 && $muestra_gen > 0){
	if($porAvanceGenerales <= $porAvanceServicio && $aplicarFormGeneral == '0' && $muestra_gen > 0){
		$aplicarFormGeneral	= 1;
	}
	$selected		= NULL;
	if($id_servicio == $idServicio){
		$selected		= " selected";
		$nomServicio	= $nom_servicio;
		$vbArticulo1	= $articulo1;
		$vbArticulo2	= $articulo2;
	}
	//---- si el usuario es demo muestra todos los formularios sin tener en cuenta si ya cumplió la muestra
	if($codEmpleado=='demo'){
		$estadoOption		= NULL;
	}
	$option_servicios	.= "<OPTION value='$id_servicio' $selected $estadoOption style='color:$colorEfectiva'>$id_servicio - $nom_servicio</OPTION>";
}
//---- consulta si ya realizó la encuesta
$sql = "SELECT cod_resultado,form_retroalimentacion
	FROM ".tablaEstadoContacto."
		WHERE cod_empleado='$codEmpleado' AND cod_resultado='".idCodResultadoEfectiva."'";
//echo '<BR>'.$sql;
$codResultadoActual		= 0;
$form_retroalimentacion	= 0;
$con				= mysql_query($sql);
while($campos		= mysql_fetch_array($con)){
	$codResultadoActual		= $campos['cod_resultado'];
	$form_retroalimentacion	= $campos['form_retroalimentacion'];
}

$colorOption		= "#336600";
$estadoOption		= "disabled='disabled'";
$selected			= NULL;
if($aplicoFormRetroalimentacion == '1'){
	$selected		= " selected";
}
//echo '<BR>codResultadoActual: '.$codResultadoActual;
//echo '<BR>form_retroalimentacion: '.$form_retroalimentacion;
//---- si ya hay encuestas efectivas del usuario y no se a aplicado las preguntas de retroalimentación
if($codResultadoActual==idCodResultadoEfectiva && $form_retroalimentacion=='0'){
	$estadoOption		= NULL;
}
$option_servicios	.= "<OPTION value='".idFormRetroalimentacion."' $selected $estadoOption style='color:$colorOption'>Retroalimentación</OPTION>";
?>