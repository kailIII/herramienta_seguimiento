//---- cuando ya marcó una opción
function marcarSeleccion(idObjValidar){
//	alert('idObjValidar: '+idObjValidar);
	document.getElementById(idObjValidar).value	= '1';
}
//---- Habilita el otro cual
function habilitarOtro(estado,idObj){
	if(estado == true){
		document.getElementById(idObj).disabled=false;
		document.getElementById(idObj).focus();
	}
	else{
		document.getElementById(idObj).value='';
		document.getElementById(idObj).disabled=true;
	}
}
//---- desHabilita el otro cual
function desHabilitarOtro(estado,idObj){
	if(estado == true){
		document.getElementById(idObj).value='';
		document.getElementById(idObj).disabled=true;
	}
}

//---- salto
function salto(idObj,valor,valores,rows,objetos){
//	alert('idObj: '+idObj);
	var tipoObj	= document.getElementById(idObj).type;
	valores	= 'NA,'+valores;
	rows	= 'NA,'+rows;
	objetos	= 'NA,'+objetos;
	frm		= document.formulario;
//	alert('rows '+rows);
	var nroCols		= 13;
	var	verFilas	= 0;

//	alert('tipoObj: '+tipoObj);
//	alert('valor: '+valor);
	if(tipoObj == 'radio' || tipoObj == 'select-one'){
		var arrayRows	= valores.split(","); // create array 
		for (var i = 1, total = arrayRows.length; i < total; i++){
			vrSalto	= arrayRows[i];
			//---- verifica si debe hacer el pase
			if(vrSalto==valor){
				verFilas	= 1;
				i			= total;
			}
		}
	}
	else if(tipoObj == 'checkbox'){
		if(document.getElementById(idObj).checked==true){
			verFilas	= 1;
		}
	}
	//alert('verFilas: '+verFilas);

	var arrayRows	= rows.split(","); // create array 
	for (var i = 1, total = arrayRows.length; i < total; i++){
		idRow	= arrayRows[i];
		//---- verifica si existe un obj de validación para el registro
		var	idObjValidacion	= 'objVal'+idRow;
		var objValidacion	= document.getElementById(idObjValidacion);
//		if(objValidacion){
//			alert('objValidacion '+objValidacion.name+' value '+objValidacion.value);
//		}
		if(verFilas==1){
			if(objValidacion){
				objValidacion.value	= '0';
			}
		}else{
			if(objValidacion){
				objValidacion.value	= '1';
			}
		}
		//---- recorre todas las divs que existen
		for (var j = 1; j <= nroCols; j++){
			idCol	= idRow+j;
			//alert('idCol '+idCol);
			if(verFilas==1){
				showdiv(idCol);
			}else{
				hidediv(idCol);
			}
		}
	}
	//---- limpia los objetos
	//alert('objetos '+objetos);
	var arrayRows	= objetos.split(","); // create array 
	for (var i = 1, total = arrayRows.length; i < total; i++){
		idObjeto	= arrayRows[i];
		//alert('idObjeto '+idObjeto);
		var objeto 	= document.getElementById(idObjeto);
		//if(typeof frm[objeto] != 'undefined'){
		//alert('objeto '+objeto);
		if(objeto != 'undefined'){
			//alert('name: '+objeto.id+' type: '+objeto.type);
			if(objeto.type == 'select-one' || objeto.type == 'textarea' || objeto.type == 'text'){
				if(verFilas==1){
					objeto.lang='1';
					//objeto.focus();
				}
				else{
					objeto.value='';
					objeto.lang='0';
				}
			}
			if(objeto.type == 'text'){
				//alert('name: '+objeto.name+' type: '+objeto.type);
				if(verFilas==1){}
				else{
					objeto.disabled=true;
				}
			}
			else if(objeto.type == 'hidden' && objeto.lang!='0'){
				if(verFilas==1){
					objeto.value='0';
				}
				else{
					objeto.value='1';
				}
			}
			else if(objeto.type == 'checkbox'){
				if(verFilas==1){
				}
				else{
					objeto.checked=false;
				}
			}
			else if(objeto.type == 'radio'){
				//alert('idObjeto '+idObjeto);
				if(verFilas==0){
					for (var ob = 0, total_ob = frm[idObjeto].length; ob < total_ob; ob++){
						//alert('checked '+frm[idObjeto][ob].checked);
						frm[idObjeto][ob].checked=false;
					}
				}
			}
		}
	}
}

function validarPagina(){
	var elementos = document.formulario.elements.length;
	for(i=0; i<elementos; i++){
		var objeto	= document.formulario.elements[i];
		//alert('type: '+objeto.type+' name: '+objeto.name+' value: '+objeto.value+' lang: '+objeto.lang);
		if(objeto.type == 'select-one' && objeto.lang=='1' && (objeto.value=='0' || objeto.value=='')){
			objeto.focus();
			alert(objeto.title);
			return(false);
		}
		else if(objeto.type == 'hidden' && objeto.value=='0' && objeto.lang!='0'){
			var objFocus	= objeto.title;
			//alert('objFocus: '+objFocus);
			if(objFocus && document.getElementById(objFocus)){
				document.getElementById(objFocus).focus();
			}
			alert(objeto.lang);
			return(false);
		}
		else if(objeto.type == 'text' && objeto.disabled==false && objeto.lang=='1' && trimAll(objeto.value).length==0){
			objeto.focus();
			objeto.select();
			alert(objeto.title);
			return(false);
		}
		else if(objeto.type == 'textarea' && objeto.lang=='1' && trimAll(objeto.value).length==0){
			objeto.focus();
			objeto.select();
			alert(objeto.title);
			return(false);
		}
	}
}
