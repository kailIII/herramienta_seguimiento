<?
// ---- consulta los servicios que le aplican
$sql = "
	SELECT M.id_servicio,M.nom_servicio,M.muestra,M.realizadas,efectiva
	 FROM ".tablaServiciosAplica." C INNER JOIN ".vistaMuestra." M
		ON(M.id_servicio=C.id_servicio)
	WHERE C.cod_empleado='$codEmpleado' AND M.estado=1
		AND M.muestra > M.realizadas
		AND efectiva = '0'
			AND C.estado=1
	 ORDER BY M.prioridad ASC
	 	LIMIT 1";
//echo '<BR>'.$sql;
$idServicioActivo		= 0;
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
	
	$idServicioActivo	= $id_servicio;
}
?>