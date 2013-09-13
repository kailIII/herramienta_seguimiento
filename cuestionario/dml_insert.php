<?
@header('Content-Type: text/html; charset=iso-8859-1');
//$r2_cargo_emp			= utf8_decode($r2_cargo_emp);
//$c_direccion			= strtoupper($_POST['c_direccion']);
// Actualiza las respuestas enviadas
function actualizar($codEmpleado,$idServicio, $campos,$tablaRTA,$aplicoFormGeneral,$aplicoFormRetroalimentacion){
	if(!empty($codEmpleado) and sizeof($campos)){
		foreach($campos as $i => $j){
			$actualizar[]=$i." = '".$j."'";
		}
		if($aplicoFormGeneral=='1' || $aplicoFormRetroalimentacion=='1'){
			$sql = "UPDATE ".$tablaRTA." SET ".implode(", ", $actualizar)."
				WHERE cod_empleado='$codEmpleado'";
		}
		else{
			$sql = "UPDATE ".$tablaRTA." SET ".implode(", ", $actualizar)."
				WHERE cod_empleado='$codEmpleado' AND id_servicio='$idServicio'";
		}
		//echo '<BR>'.$sql;
		mysql_query($sql) or die("$sql<br>".mysql_error());
	
		return mysql_affected_rows();
	}
	else
		return 0;
}
$idEncuestador		= $_SESSION['userAdmin'];
$nomEncuestador		= $_SESSION['nomUsuario'];

$ip_c				= $_SERVER['REMOTE_ADDR'];
$FECHA_ACT			= date("Y-m-d H:i:s");
$campos_actualizar	= array();
if(!empty($_POST['btn_enviar'])){
	//echo '<BR>tablaRTA: '.$tablaRTA;

	//---- registra el tiempo que envió el formulario
	$sqlTiempo = "UPDATE ".tablaTiempo." SET hora_fin = NOW()
		WHERE cod_empleado = '$codEmpleado' AND id_servicio = $idServicio";
	//echo '<BR>'.$sqlTiempo;
	if(mysql_query($sqlTiempo)){}
	else{
		//echo "<br><font color='#990000' size='3'>Atención!!! Error al guardar la información</font><br>".mysql_error();
	}

	if($aplicoFormGeneral=='1'){
		$sqlInsert = "INSERT INTO ".$tablaRTA." (cod_empleado,id_servicio,fecha_encuesta) VALUES 
			('$codEmpleado','0',NOW())";
	}
	elseif($aplicoFormRetroalimentacion=='1'){
		$sqlInsert = "INSERT INTO ".$tablaRTA." (cod_empleado,fecha_encuesta) VALUES 
			('$codEmpleado',NOW())";
	}
	else{
		$sqlInsert = "INSERT INTO ".$tablaRTA." (cod_empleado,id_servicio,es_externo,fecha_encuesta,id_encuestador,nom_encuestador)
			 VALUES 
			('$codEmpleado','$idServicio','$esExterno',NOW(),'$idEncuestador','$nomEncuestador')";
	}
	//echo '<BR>'.$sqlInsert;
	if(mysql_query($sqlInsert)){}
	else{
//			echo "<br><font color='#990000' size='3'>Atención!!! Error al guardar la información, por favor intente nuevamente</font><br>".mysql_error();
	}	
	$campos_tabla	= array();
	$sqlDesc		= "DESC ".$tablaRTA;
	//echo '<BR>'.$sqlDesc;
	$rs	= mysql_query($sqlDesc) or die(mysql_error());
	while($row=mysql_fetch_array($rs)){
		$campos_tabla[]= $row["Field"];
	}

	$arrayRtas			= array();
	$arrayFuncionarios	= array();
	foreach($_REQUEST as $i => $j){
		//echo '<BR>campo: '.$i.' valor: '.$j;
		// si el campo es un arreglo
		if(is_array($j)){
			$j	= implode("",$j);
		}
		if(in_array($i, $campos_tabla)){
			//echo '<BR>Encontró: '.$i;
			$campos_actualizar[$i]	= $j;
		}
	}
	$retorno	= actualizar($codEmpleado,$idServicio, $campos_actualizar, $tablaRTA, $aplicoFormGeneral,$aplicoFormRetroalimentacion);
	if($retorno == 0){
		$errorGrabar	= 1;
	}
	else{
		$errorGrabar	= 10;
		//---- guarda una marca indicando que ya se envió un formulario y no puede cargar la preguntas generales en el futuro
		$sqlUpdM	= "UPDATE ".tablaEstadoContacto."
				SET submit='1'
			WHERE cod_empleado = '".$codEmpleado."'";
		//echo '<BR>'.$sql_contacto;
		if(mysql_query($sqlUpdM)){}

		//---- verifica si aplicó las preguntas generales
		if($aplicoFormGeneral=='1'){
			$sqlUpdM	= "UPDATE ".tablaEstadoContacto."
					SET form_general='$aplicoFormGeneral'
				WHERE cod_empleado = '".$codEmpleado."'";
			//echo '<BR>'.$sql_contacto;
			if(mysql_query($sqlUpdM)){}
			else{
				echo "<div style='color:#990000'>Atención!!! Error al marcar que aplicó las preguntas generales</div><br>".mysql_error();
			}
		}
		//---- verifica si aplicó las preguntas generales
		elseif($aplicoFormRetroalimentacion=='1'){
			$sqlUpdM	= "UPDATE ".tablaEstadoContacto."
					SET form_retroalimentacion='$aplicoFormRetroalimentacion'
				WHERE cod_empleado = '".$codEmpleado."'";
			//echo '<BR>'.$sql_contacto;
			if(mysql_query($sqlUpdM)){}
			else{
				echo "<div style='color:#990000'>Atención!!! Error al marcar que aplicó las preguntas de retroalimentación</div><br>".mysql_error();
			}
		}else{
			//echo '<BR>campo: '.$i.' valor: '.$idServicio;
			$sqlUpd			= "UPDATE ".tablaServiciosAplica."
					SET efectiva='1', fecha_encuesta=NOW()
				WHERE cod_empleado = '".$codEmpleado."' AND id_servicio='".$idServicio."'";
			//echo '<BR>'.$sql_contacto;
			//---- actualiza el id_servicio de la tabla de preguntas generales, unicamente actualizará si aplicó preguntas generales y el las preguntas generales se asociaran al primer servicio que responda aunque apliquen mas de 1 al informante
			$sqlUpdM	= "UPDATE ".tablaRtaGral."
					SET id_servicio='".$idServicio."'
				WHERE cod_empleado = '".$codEmpleado."' AND id_servicio='0'";
			//echo '<BR>'.$sql_contacto;
			if(mysql_query($sqlUpdM)){}
			else{
				//echo "<div style='color:#990000'>Atención!!! Error al actualizar el número de efectivas realizadas en el servicio $idServicio, por favor intente nuevamente</div><br>".mysql_error();
			}
			if(mysql_query($sqlUpd)){

				//---- crea un código de resultado y marca el registro como efectiva
				$sql = "
				SELECT * FROM ".tablaResultContacto."
					WHERE cod_empleado = '".$codEmpleado."' AND cod_resultado='".$idCodResultadoEfectiva."'";
				//echo '<BR>'.$sql;
				$encontroEfectiva		= 0;
				$con					= mysql_query($sql);
				//---- si aún no esta el registro de efectiva en la tabla tablaResultContacto
				if(mysql_num_rows($con)==0){
					$usuarioId			= 'Autodiligenciada';
					$origen_encuesta	= 'Autodiligenciada';
					$camposUpd = NULL;
					// ---- si la encuesta es realizada por un encuestados
					if(!empty($_REQUEST['origen']) && $_REQUEST['origen']==idOrigenCallCNC){
						$usuarioId			= $_REQUEST['usuario_call'];
						$origen_encuesta	= idOrigenCallCNC;
					}
					// ---- registra la encuesta efectiva
					$sqlCR = "INSERT INTO ".tablaResultContacto."
					(cod_empleado,cod_resultado,fecha_registro,usuario_call,observacion_call)
					VALUES
					('".$codEmpleado."','".idCodResultadoEfectiva."',NOW(),'".$usuarioId."','Encuesta efectiva')";
					//echo '<BR>'.$sql;
					if(mysql_query($sqlCR)){
						$idRow		= mysql_insert_id();
						$camposUpd	= "cod_resultado='".idCodResultadoEfectiva."',finaliza_campo='1', id_row='$idRow'";
						//echo '<BR>'.$sql_contacto;
						// ---- actualiza el avance en la tabla contacto
						$sql = "UPDATE ".tablaEstadoContacto." SET $camposUpd
						WHERE cod_empleado = '".$codEmpleado."'";
						//echo '<BR>'.$sql;
						mysql_query($sql) or die("$sql<br>".mysql_error());
					}
					else{
						echo "<script>alert('Atención!!! Error al registrar la encuesta efectiva');</script>";
					}
				}
			}
			else{
				echo "<div style='color:#990000'>Atención!!! Error al marcar el servicio $idServicio como efectivo, por favor intente nuevamente</div><br>".mysql_error();
			}
		}
	}
	$c_servicio		= NULL;
}
?>
