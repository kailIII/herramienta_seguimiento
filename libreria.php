<?
define("tablaMuestra","ecp_ci_muestra");
define("tablaMuestraFormGeneral","ecp_ci_muestra_gen");
define("tablaServicio","ecp_ci_servicio");
define("tablaSubServicio","ecp_ci_subservicio");
define("tablaUsoServicio","ecp_ci_uso_servicio");
define("tablaServiciosAplica","ecp_ci_servicios_aplica");
define("tablaContacto","ecp_ci_empleado");
define("tablaEstadoContacto","ecp_ci_estado_contacto");
define("tablaRTA","ecp_ci_rta");
define("tablaRtaGral","ecp_ci_rta_gral");
define("tablaRtaRetroalimentacion","ecp_ci_rta_retroalimentacion");
define("tablaTiempo","ecp_ci_tiempo");
define("tablaConsulta","ecp_ci_consulta");
define("tablaSegmento","ecp_ci_segmento");

define("tablaUsuario","ecp_ci_usuario");

define("tablaAtributo","ecp_ci_atributo");

define("vistaContacto","ecp_ci_v_contacto");
define("vistaContactoAll","ecp_ci_t_contacto_all");
//define("vistaMuestra","ecp_ci_v_ci_muestra");
define("vistaMuestra","ecp_ci_v_muestra");
define("vistaMuestra90","ecp_ci_v_muestra90"); //---- contempla los imputados

define("vistaRTA90","ecp_ci_v_rta90"); //---- contempla las rta del formulario 90

define("tablaCodResultado","ecp_ci_cod_resultado");
define("tablaResultContacto","ecp_ci_result_contacto");

define("idOrigenCallCNC","callCNC");
define("idFormGeneral","99");	//---- identificador del formulario de preguntas generales
define("idFormRetroalimentacion","98");	//---- identificador del formulario de Retroalimentación
define("basePorAvance","3");	//---- define 3 como si se tratara del máximo de servicios que le aplican, se usa esta base para determinar el % de avance
define("maximoFormularios","7");	//---- define el máximo de cuestionarios a diligenciar


$nroRegistros	= 30;
$trackActivo	= 9;
$arrayNomEstado	= array('0'=>'Inactivo','1'=>'Activo');
define("colorON","#FF3300");
define("colorOFF","#000000");

define("tituloPag","ECOPETROL");
define("valorOtro","77");

define("userAdmin","ADMIN");
define("userCliente","CLIENTE");
define("userProveedor","PROV");
define("userEncuestador","ENC");
define("nroRegistros",30);// numero de registros a mostrar en las páginas de lista de clientes
define("nroPaginas",13);// numero de páginas que componen la encuesta
define("numPaginas",13);// numero de páginas que componen la encuesta
$arrayLetras	= array(1=>'a',2=>'b',3=>'c',4=>'d',5=>'e',6=>'f',7=>'g',8=>'h');

$arrayNomGrupoCodResultado	= array('A'=>'Registros inválidos','C'=>'Si hay contacto con el informante','NC'=>'No hay contacto con el informante');
define("idCodResultadoCita","6");	// identificador del codigo de resultado de CITA
define("idCodResultadoEfectiva","13");	// identificador del codigo de resultado de encuesta
define("idContactado","C");	// identificador de los contactados

//------ Define las opciones de respuesta para cada escala de respuesta
/*
define("dominioR1","'01','02','03','04'");
define("dominioR2","'05','06'");
*/
define("dominioR1","'01'");
define("dominioR2","'02'");
define("dominioR3","'03'");
define("dominioR4","'04'");
define("dominioR5","'05'");
define("dominioR6","'06'");
define("dominioR7","'07'");
define("dominioR8","'08'");
define("dominioR9","'09'");
define("dominioR10","'10'");

define("dominioTodos","'01','02','03','04','05','06','07','08','09','10'");
define("dominioT2B","'07','08','09','10'");
$arrayColor		= array();
$arrayColor[]	= '006600';

$arrayColor[]	= '006699';
$arrayColor[]	= 'FF6600';
$arrayColor[]	= 'F6BD0F';
$arrayColor[]	= '66CCCC';
$arrayColor[]	= 'A66EDD';
$arrayColor[]	= 'CC6699';


define("vrSI","'1'");
define("vrNO","'2'");
define("paletaSI","../imagenes/colorR3.png"); // color de la barra para las respuesta SI
define("paletaNO","../imagenes/colorR1.png"); // color de la barra para las respuesta NO

define("vrMedio1","'01'");	// Código del medio 01 Visitas /reuniones con Ejecutivos
define("vrMedio2","'02'");	// Código del medio 02 Atención telefónica de Ejecutivos
define("vrMedio3","'03'");	// Código del medio 03 Conmutador o Call center o Línea de atención telefónica
define("vrMedio4","'04'");	// Código del medio 04 Emails
define("vrMedio5","'05'");	// Código del medio 05 Otros
?>
