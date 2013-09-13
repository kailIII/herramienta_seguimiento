<?
if(!empty($_POST['btn_enviar_call']) && !empty($_POST['codResultado'])){
	$codResultado		= $_POST['codResultado'];
	$fechaCita			= $_POST['fechaCita'];
	$cHora				= $_POST['cHora'];
	$cMinuto			= $_POST['cMinuto'];
	$usuario_call		= $_POST['usuario_call'];
	$observacionesCall	= $_POST['observacionesCall'];

	$camposUpd		= array();
	$camposUpd[]	= 'cod_resultado="'.$codResultado.'"';
	$camposUpd[]	= 'fecha_cita="'.$fechaCita.'"';
	$camposUpd[]	= 'hora_cita="'.$cHora.'"';
	$camposUpd[]	= 'minuto_cita="'.$cMinuto.'"';
	$camposUpd[]	= 'usuario_call="'.$usuario_call.'"';
	$camposUpd[]	= 'observacion_call="'.$observacionesCall.'"';

	$sql = "INSERT INTO ".tablaResultContacto."
		(cod_empleado,cod_resultado,fecha_registro,fecha_cita,hora_cita,minuto_cita,usuario_call,observacion_call)
		VALUES
	('$ID','$codResultado',NOW(),'$fechaCita','$cHora','$cMinuto','$usuario_call','$observacionesCall')";
//	echo '<BR>'.$sql;
	if(mysql_query($sql)){
		$idRow	= mysql_insert_id();
		//------ consulta el grupo y la prioridad del codigo de resultado seleccionado
		$sqlC = "SELECT prioridad,finaliza_campo
			FROM ".tablaCodResultado." WHERE cod_resultado='$codResultado'";
		//echo '<BR>'.$sqlC;
		$consultaC			= mysql_query($sqlC);
		$camposC			= mysql_fetch_array($consultaC);
		$prioridadSel		= $camposC['prioridad'];
		$finaliza_campo		= $camposC['finaliza_campo'];

		//------ consulta codigo de resultado actual del registro
		$sqlC = "SELECT cod_resultado FROM ".tablaEstadoContacto." WHERE cod_empleado = '".$ID."'";
		//echo '<BR>'.$sqlC;
		$consultaC				= mysql_query($sqlC);
		$camposC				= mysql_fetch_array($consultaC);
		$codResultadoContacto	= $camposC['cod_resultado'];

		//------ si el contacto tiene ya definido un código de resultado consulta su prioridad para determinar si la prioridad del nuevo código de resultado seleccionado es mayor, en este caso actualiza el cod_resultado en la tabla contacto
		$prioridadCont			= 0;
		if($codResultadoContacto > 0){
			$sqlC = "SELECT prioridad FROM ".tablaCodResultado." WHERE cod_resultado=$codResultadoContacto";
			//echo '<BR>'.$sqlC;
			$consultaC			= mysql_query($sqlC);
			$camposC			= mysql_fetch_array($consultaC);
			$prioridadCont		= $camposC['prioridad'];
		}
		elseif($codResultadoContacto == 0){
			//------ si aún el contacto no tiene definido ningun codigo de resultado actualiza por el actualmente seleccionado
			$sql_contacto = "UPDATE ".tablaEstadoContacto."
					SET cod_resultado=$codResultado, finaliza_campo='$finaliza_campo', id_row=$idRow
				WHERE cod_empleado = '".$ID."' AND cod_resultado=0";
		}
		//------ si la prioridad del nuevo código seleccionado es mayor a la actual actualiza el nuevo código en la tabla contactos
		if($prioridadSel >= $prioridadCont){
			$sql_contacto = "UPDATE ".tablaEstadoContacto."
					SET cod_resultado=$codResultado, finaliza_campo='$finaliza_campo', id_row=$idRow
				WHERE cod_empleado = '".$ID."'";
			//echo '<BR>'.$sql_contacto;
			if(mysql_query($sql_contacto)){}
			else{
				echo "<div style='color:#990000'>Atención!!! Error al actualizar el estado del registro, por favor intente nuevamente</div><br>".mysql_error();
			}
		}
	}
	else{
//		$sql = "UPDATE ".tablaResultContacto." SET ".implode(", ", $camposUpd)." WHERE cod_empleado = '".$ID."'";
		echo "<div style='color:#990000'>Atención!!! Error al guardar la información,
		por favor intente nuevamente</div><br>".mysql_error();
	}
}
?>