<?
$sql = "SELECT * FROM ".vistaMuestra." ORDER BY prioridad,id_servicio";
//echo '<BR>'.$sql;
$cont				= 0;
$totalMuestra		= 0;
$totalRealizadas	= 0;
$totalRealizadasI	= 0;
$totalPendientes	= 0;
$filasMuestra		= NULL;
$con				= mysql_query($sql);
while($campos		= mysql_fetch_array($con)){
	++$cont;
	$id_servicio	= $campos["id_servicio"];
	$nom_servicio	= $campos["nom_servicio"];
	$muestra		= $campos["muestra"];
	$realizadas		= $campos["realizadas"];
	$prioridad		= $campos["prioridad"];
	$estado			= $campos["estado"];
	$campo_indicador= $campos["campo_indicador"];
	$registros_con_tel	= $campos["registros_con_tel"];

	$pendientes		= $muestra-$realizadas;

	$vbRealizadas	= $realizadas;
	$colorBg		= '#FF0000';
	if($realizadas > $muestra){
//		$realizadas	= $muestra;
		$colorBg	= '#000000';
	}
	elseif($realizadas == $muestra){
		$colorBg	= '#009900';
	}
	$totalConTel		+= $registros_con_tel;
	$totalMuestra		+= $muestra;
	$totalRealizadas	+= $realizadas;

	$vbEstado			= $arrayNomEstado[$estado];

	$linkDB				= "&nbsp;";
	if($realizadas>0 && !empty($dowBase)){
		$linkDB			= "<a href='xls_base_rta.php?idServicio=$id_servicio' target='_blank'><IMG src='/imagenes/xls32.png' height='32' border='0'></a>";
	}
	$porIndicador		= "-";
	$porIndicadorI		= "-";
	if(!empty($campo_indicador)){
		//---- cuenta el total de encuestas por servicio
		$sqlE = "SELECT COUNT(1) AS total FROM ".tablaRTA."
			WHERE id_servicio='$id_servicio' AND es_externo=0 AND imputado=0 AND $campo_indicador IN(".dominioTodos.")";
		//echo '<BR>'.$sqlE;
		$totalRtas		= 0;
		$conE			= mysql_query($sqlE);
		while($camposE	= mysql_fetch_array($conE)){
			$totalRtas	= $camposE["total"];
		}
		//---- cuenta los t2b
		$sqlE = "SELECT COUNT(1) AS total FROM ".tablaRTA."
			WHERE id_servicio='$id_servicio' AND es_externo=0 AND imputado=0 AND $campo_indicador IN(".dominioT2B.")";
		//echo '<BR>'.$sqlE;
		$totalT2B		= 0;
		$conE			= mysql_query($sqlE);
		while($camposE	= mysql_fetch_array($conE)){
			$totalT2B	= $camposE["total"];
		}
		$porcentajeT	= porcentaje($totalRtas, $totalT2B, 0);
		$porIndicador	= $porcentajeT."%";

		//---- con imputación
		//---- cuenta el total de encuestas por servicio
		$sqlE = "SELECT COUNT(1) AS total FROM ".tablaRTA."
			WHERE id_servicio='$id_servicio' AND es_externo=0 AND $campo_indicador IN(".dominioTodos.")";
		//echo '<BR>'.$sqlE;
		$totalRtas		= 0;
		$conE			= mysql_query($sqlE);
		while($camposE	= mysql_fetch_array($conE)){
			$totalRtas	= $camposE["total"];
		}
		//---- cuenta los t2b
		$sqlE = "SELECT COUNT(1) AS total FROM ".tablaRTA."
			WHERE id_servicio='$id_servicio' AND es_externo=0 AND $campo_indicador IN(".dominioT2B.")";
		//echo '<BR>'.$sqlE;
		$totalT2B		= 0;
		$conE			= mysql_query($sqlE);
		while($camposE	= mysql_fetch_array($conE)){
			$totalT2B	= $camposE["total"];
		}
		$porcentajeI	= porcentaje($totalRtas, $totalT2B, 0);
		$porIndicadorI	= $porcentajeI."%";

		$semaforo		= "<IMG src='yellow16.png' height='16' border='0'>";
		if($porcentajeT > $porcentajeI){
			$semaforo	= "<IMG src='green16.png' height='16' border='0'>";
		}
		elseif($porcentajeT < $porcentajeI){
			$semaforo	= "<IMG src='red16.png' height='16' border='0'>";
		}
	}

	$muestra			= number_format($muestra);
	$registros_con_tel	= number_format($registros_con_tel);
	$vbRealizadas		= number_format($vbRealizadas);
	$pendientes			= number_format($pendientes);
	
	//---- total realizadas
	$sql_I = "SELECT * FROM ".vistaMuestra90." WHERE id_servicio='$id_servicio'";
	//echo '<BR>'.$sql_I;
	$realizadasI			= 0;
	$vbRealizadasI			= '-';
	$conI					= mysql_query($sql_I);
	while($camposI			= mysql_fetch_array($conI)){
		$realizadasI		= $camposI["realizadas"];
		$totalRealizadasI	+= $realizadasI;
		$vbRealizadasI		= number_format($realizadasI);
	}
	
	$filasMuestra	.= "
	 <TR>
	  <TD align='left' class='bb' valign='top'><div class='padding5'>$cont</div></TD>
	  <TD align='center' class='bb' valign='top'><div class='padding5'>$id_servicio</div></TD>
	  <TD align='left' class='bb' valign='top'><div class='padding5'>$linkDB</div></TD>
	  <TD align='left' class='bb' valign='top'><div class='padding5'>$nom_servicio</div></TD>
	  <TD align='center' class='bb' valign='top'><div class='padding5'>$registros_con_tel</div></TD>
	  <TD align='center' class='bb' valign='top'><div class='padding5'>$vbRealizadas</div></TD>
	  <TD align='center' class='bb' valign='top'><div class='padding5'>$vbRealizadasI</div></TD>
	  <TD align='center' class='bb' valign='top'><div class='padding5'>".$porIndicador."</div></TD>
	  <TD align='center' class='bb' valign='top'><div class='padding5'>".$porIndicadorI."</div></TD>
	  <TD align='center' class='bb' valign='top'><div class='padding5'>".$semaforo."</div></TD>
	  <TD align='center' class='bb' valign='top'><div class='padding5'>$prioridad</div></TD>
	  <TD align='center' class='bb' valign='top'><div class='padding5'>$vbEstado</div></TD>
	 </TR>";
}
//---- consulta el total del F
$sqlR = "SELECT COUNT(1) AS realizadas
 FROM ".tablaRTA." INNER JOIN ".tablaRtaGral." S USING(id_servicio,cod_empleado)";
//echo '<BR>'.$sqlR;
$realizadasF		= 0;
$conR				= mysql_query($sqlR);
while($camposR		= mysql_fetch_array($conR)){
	$realizadasF	= $camposR["realizadas"];
}
$totalRealizadas	+= $realizadasF;
$totalRealizadasI	+= $realizadasF;
$vbRealizadas		= number_format($realizadasF);

++$cont;
$id_servicio		= "F";
$linkDB				= "&nbsp;";
$nom_servicio		= "DSC";
$muestra			= "-";
$registros_con_tel	= "-";
$pendientes			= "-";
$prioridad			= "-";
$prioridad			= "-";

//---- cuenta el total de encuestas
$sqlE = "SELECT COUNT(1) AS total FROM ".tablaRtaGral." WHERE id_servicio > 0 AND f1 IN(".dominioTodos.")";
//echo '<BR>'.$sqlE;
$totalRtas		= 0;
$conE			= mysql_query($sqlE);
while($camposE	= mysql_fetch_array($conE)){
	$totalRtas	= $camposE["total"];
}
//---- cuenta los t2b
$sqlE = "SELECT COUNT(1) AS total FROM ".tablaRtaGral." WHERE id_servicio > 0 AND f1 IN(".dominioT2B.")";
//echo '<BR>'.$sqlE;
$totalT2B		= 0;
$conE			= mysql_query($sqlE);
while($camposE	= mysql_fetch_array($conE)){
	$totalT2B	= $camposE["total"];
}
$porcentaje		= porcentaje($totalRtas, $totalT2B, 0);
$porIndicador	= $porcentaje."%";

$filasMuestra	.= "
 <TR style='background-color:#CCFFFF'>
  <TD align='left' class='bb' valign='top'><div class='padding5'>$cont</div></TD>
  <TD align='center' class='bb' valign='top'><div class='padding5'>$id_servicio</div></TD>
  <TD align='left' class='bb' valign='top'><div class='padding5'>$linkDB</div></TD>
  <TD align='left' class='bb' valign='top'><div class='padding5'><B>$nom_servicio</B></div></TD>
  <TD align='center' class='bb' valign='top'><div class='padding5'>$registros_con_tel</div></TD>
  <TD align='center' class='bb' valign='top'><div class='padding5'><B>$vbRealizadas</B></div></TD>
  <TD align='center' class='bb' valign='top'><div class='padding5'><B>$vbRealizadas</B></div></TD>
  <TD align='center' class='bb' valign='top'><div class='padding5'><B>$porIndicador</B></div></TD>
  <TD align='center' class='bb' valign='top'><div class='padding5'>&nbsp;</div></TD>
  <TD align='center' class='bb' valign='top'><div class='padding5'>&nbsp;</div></TD>
  <TD align='center' class='bb' valign='top'><div class='padding5'>&nbsp;</div></TD>
  <TD align='center' class='bb' valign='top'><div class='padding5'>$vbEstado</div></TD>
 </TR>";
//---- dato del tracking
++$cont;
$realizadasT		= 4012;
$totalRealizadas	+= $realizadasT;
$totalRealizadasI	+= $realizadasT;

$vbRealizadas		= number_format($realizadasT);
$id_servicio		= "T";
$linkDB				= "&nbsp;";
$nom_servicio		= "Tracking";
$muestra			= "-";
$registros_con_tel	= "-";
$pendientes			= "-";
$prioridad			= "-";
$prioridad			= "-";
$vbEstado			= "-";

$filasMuestra	.= "
 <TR style='background-color:#CCFFFF'>
  <TD align='left' class='bb' valign='top'><div class='padding5'>$cont</div></TD>
  <TD align='center' class='bb' valign='top'><div class='padding5'>$id_servicio</div></TD>
  <TD align='left' class='bb' valign='top'><div class='padding5'>$linkDB</div></TD>
  <TD align='left' class='bb' valign='top'><div class='padding5'><B>$nom_servicio</B></div></TD>
  <TD align='center' class='bb' valign='top'><div class='padding5'>$registros_con_tel</div></TD>
  <TD align='center' class='bb' valign='top'><div class='padding5'><B>$vbRealizadas</B></div></TD>
  <TD align='center' class='bb' valign='top'><div class='padding5'><B>$vbRealizadas</B></div></TD>
  <TD align='center' class='bb' valign='top'><div class='padding5'>&nbsp;</div></TD>
  <TD align='center' class='bb' valign='top'><div class='padding5'>&nbsp;</div></TD>
  <TD align='center' class='bb' valign='top'><div class='padding5'>&nbsp;</div></TD>
  <TD align='center' class='bb' valign='top'><div class='padding5'>&nbsp;</div></TD>
  <TD align='center' class='bb' valign='top'><div class='padding5'>&nbsp;</div></TD>
 </TR>";

//---- totales
$totalPendientes	= $totalMuestra-$totalRealizadas;
$porcentajeTotal	= round(($totalRealizadas/$totalMuestra)*100,1);

$totalMuestra		= number_format($totalMuestra);
$totalConTel		= number_format($totalConTel);
$totalRealizadas	= number_format($totalRealizadas);
$totalPendientes	= number_format($totalPendientes);

$totalRealizadasI	= number_format($totalRealizadasI);

$filasMuestra	.= "
 <TR>
  <TD align='left' colspan='4'><div class='padding5'><B>TOTAL</B></div></TD>
  <TD align='center'><div class='padding5'><B>$totalConTel</B></div></TD>
  <TD align='center'><div class='padding5'><B>$totalRealizadas</B></div></TD>
  <TD align='center'><div class='padding5'><B>$totalRealizadasI</B></div></TD>
  <TD align='center'>&nbsp;</TD>
  <TD align='center'>&nbsp;</TD>
  <TD align='center'>&nbsp;</TD>
  <TD align='center'>&nbsp;</TD>
 </TR>";
?>