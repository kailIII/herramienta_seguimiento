<?
$sql = "SELECT S.id_servicio,S.nom_servicio,M.muestra_gen AS muestra
 FROM ".tablaMuestraFormGeneral." M INNER JOIN ".tablaServicio." S USING(id_servicio)
ORDER BY S.id_servicio";
//echo '<BR>'.$sql;
$cont				= 0;
$totalMuestra		= 0;
$totalRealizadas	= 0;
$totalPendientes	= 0;
$filasMuestra		= NULL;
$con				= mysql_query($sql);
while($campos		= mysql_fetch_array($con)){
	++$cont;
	$id_servicio	= $campos["id_servicio"];
	$nom_servicio	= $campos["nom_servicio"];
	$muestra		= $campos["muestra"];
	$realizadas		= $campos["realizadas"];
	$estado			= $campos["estado"];

	$sqlR = "SELECT COUNT(1) AS realizadas
	 FROM ".tablaRtaGral."
		WHERE id_servicio='$id_servicio'";
	//echo '<BR>'.$sqlR;
	$realizadas			= 0;
	$conR				= mysql_query($sqlR);
	while($camposR		= mysql_fetch_array($conR)){
		$realizadas		= $camposR["realizadas"];
	}

	$pendientes		= $muestra-$realizadas;

	$vbRealizadas	= $realizadas;
	$colorBg		= '#FF0000';
	if($realizadas > $muestra){
		$realizadas	= $muestra;
		$colorBg	= '#000000';
	}
	elseif($realizadas == $muestra){
		$colorBg	= '#009900';
	}
	$totalMuestra		+= $muestra;
	$totalRealizadas	+= $realizadas;

	$filasMuestra	.= "
	 <TR>
	  <TD align='left' class='bb' valign='top'><div class='padding5'>$cont</div></TD>
	  <TD align='center' class='bb' valign='top'><div class='padding5'>$id_servicio</div></TD>
	  <TD align='left' class='bb' valign='top'><div class='padding5'>$nom_servicio</div></TD>
	  <TD align='center' class='bb' valign='top'><div class='padding5'>$muestra</div></TD>
	  <TD align='center' class='bb' valign='top'><div class='padding5'>$vbRealizadas</div></TD>
	  <TD align='center' class='bb' valign='top'><div class='padding5' style='color:$colorBg; font-size:14px'><B>$pendientes</B></div></TD>
	 </TR>";
}
$totalPendientes	= $totalMuestra-$totalRealizadas;
$porcentajeTotal	= 0;
if($totalMuestra > 0){
	$porcentajeTotal	= round(($totalRealizadas/$totalMuestra)*100,1);
}
$filasMuestra	.= "
 <TR>
  <TD align='left' colspan='3'><div class='padding5'><B>TOTAL</B></div></TD>
  <TD align='center'><div class='padding5'><B>$totalMuestra</B></div></TD>
  <TD align='center'><div class='padding5'><B>$totalRealizadas</B></div></TD>
  <TD align='center'><div class='padding5'><B>$totalPendientes</B></div></TD>
 </TR>";
?>