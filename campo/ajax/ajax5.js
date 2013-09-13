function objetoAjax()
{
	var xmlhttp=false;
	try
	{
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} 
	catch (e)
	{
		try
		{
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch (E)
		{
			xmlhttp = false;
  		}
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined')
	{
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

var loader2 = "<div align='center'><img src='/imagenes/loader2.gif' width='220' height='18'><br>Guardando...</div>";
var imagen_loader = "<br> <div align='center'><img src='/imagenes/loader_new.gif' width='50' height='58'></div>";
var loader1 = "<img src='/imagenes/loader1.gif' alt='Cargando...'>&nbsp;";
function select_pesta(divid){
	document.getElementById('pesta1').style.background = 'url(/imagenes/pesta.gif)';
//	document.getElementById('pesta2').style.background = 'url(/imagenes/pesta.gif)';
	document.getElementById('pesta3').style.background = 'url(/imagenes/pesta.gif)';
	document.getElementById(divid).style.background = 'url(/imagenes/pesta_select.gif)';

//	document.getElementById('pesta_activa').value=divid;
}

// consulta el avance del estudio
function con_avance(estado){
	//// si seleccionó una empresa
	divResultado = document.getElementById('div_informe');
	ajax=objetoAjax();
	var texto_loader = imagen_loader+"<BR><div align='center'>Generando informe, por favor espere...</div><BR>";
	divResultado.innerHTML = texto_loader;
	document.getElementById('cRegInicial').value	= 0;
	var cRegInicial		= document.getElementById('cRegInicial').value;

	ajax.open("POST", "ajax/con_avance.php",true);
	ajax.onreadystatechange=function(){
		if (ajax.readyState==4){
			divResultado.innerHTML = ajax.responseText;
			con_avance_det(estado);
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send('estado='+estado+'&cRegInicial='+cRegInicial);
}

//----
function buscar_contacto(e,estado,tipoAvance){
	var charCode = '';
	if(navigator.appName == "Netscape"){
		charCode = e.which; // leo la tecla que ingreso
	}else{
		charCode = e.keyCode; // leo la tecla que ingreso
	}
	//  status = charCode 
	if(charCode == 13){
		fxAvance(estado,tipoAvance);
	return(false);
	}
}

/////// CONSULTA LAS EMPRESAS REGISTRADAS EN EL TRACK ACTUAL
function con_avance_det(estado){
	divResultado = document.getElementById('div_informe_det');
	ajax=objetoAjax();
	var cRegInicial		= document.getElementById('cRegInicial').value;
		var texto_loader = imagen_loader+"<BR><div align='center'>Generando informe, por favor espere...</div><BR>";
		divResultado.innerHTML = texto_loader;

		var cBuscar		= document.getElementById('cBuscar').value;
	
		ajax.open("POST", "ajax/con_avance_det.php",true);
		ajax.onreadystatechange=function(){
			if (ajax.readyState==4){
				divResultado.innerHTML = ajax.responseText;
				if(estado=='P'){
				}
			}
		}
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send('estado='+estado+'&cRegInicial='+cRegInicial+'&cBuscar='+cBuscar);
}

//---- señala el número de la página actual
function ubicar_pag(estado,RegInicial,idDivPag,total_pag){
	for(var i=1; i<=total_pag; i++){
		var idDiv	= 'divPag'+i;
		if(document.getElementById(idDiv)){
			document.getElementById(idDiv).style.backgroundColor = '#333333';
		}
	}
	document.getElementById(idDivPag).style.backgroundColor = '#CC0000';

	document.getElementById('cRegInicial').value	= RegInicial;
	con_avance_det(estado);
}

/////// CONSULTA LAS EMPRESAS REGISTRADAS EN EL TRACK ACTUAL
function fxAvance(estado,tipoAvance){
	var RegInicial		= parseInt(document.getElementById('cRegInicial').value);
	if(tipoAvance == 'Siguiente'){
		RegInicial		+= 10;
	}
	else if(tipoAvance == 'Anterior'){
		RegInicial		-= 10;
	}
	else if(tipoAvance == 'none'){
		RegInicial		= 0;
	}
	if(RegInicial < 0){
		RegInicial = 0;
	}
	document.getElementById('cRegInicial').value	= RegInicial;
	con_avance_det(estado);
}

/////// CONSULTA LAS EMPRESAS REGISTRADAS EN EL TRACK ACTUAL
function quitaFiltro(estado,tipoAvance){
	document.getElementById('cBuscar').value	= '';
	fxAvance(estado,tipoAvance);
}

// Limpia el informe
function resetInf(){
	divResultado = document.getElementById('div_informe');
	var texto = "<div style='display:block; height:80px; background-color:#E5E5E5; border:solid; border-color:#DFDFDF; border-width:10px; vertical-align:middle;' align='center'><br /><span class='subtitulos_azules'>Seleccione los criterios deseados y haga clic en ''Ver''</span></div>";
	divResultado.innerHTML = texto;
}
