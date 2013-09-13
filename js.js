//funcion que retorna un verifica si un caractér digitado es un número
function esNumero(e) 
{
  var charCode
  if (navigator.appName == "Netscape")
    charCode = e.which // leo la tecla que ingreso
  else
    charCode = e.keyCode // leo la tecla que ingreso
  
//  status = charCode 
  if (charCode > 31 && (charCode < 48 || charCode > 57)) 
  { // Chequeamos que sea un numero comparandolo con los valores ASCII
    return false
  }
  
  return true
}

//funcion que retorna un verifica si un caractér digitado es una letra
function esLetra(e) 
{
 	var charCode
	
	if (navigator.appName == "Netscape")
    	charCode = e.which // leo la tecla que ingreso
	else
    	charCode = e.keyCode // leo la tecla que ingreso
  
//	status = charCode 
	if (charCode > 47 && charCode < 58)
	{ // Chequeamos que sea un numero comparandolo con los valores ASCII
    	return false
  	}
	
	return true
}
function leftTrim(sString) 
{
	while (sString.substring(0,1) == ' ')
	{
		sString = sString.substring(1, sString.length);
	}
	
	return sString;
}
function rightTrim(sString) 
{
	while (sString.substring(sString.length-1, sString.length) == ' ')
	{
		sString = sString.substring(0,sString.length-1);
	}
	
	return sString;
}
function trimAll(sString) 
{
	while (sString.substring(0,1) == ' ')
	{
		sString = sString.substring(1, sString.length);
	}
	
	while (sString.substring(sString.length-1, sString.length) == ' ')
	{
		sString = sString.substring(0,sString.length-1);
	}
	
	return sString;
}

//---- Función para mostrar DIVISIONES
function showdiv(divid) {
	var div = document.getElementById(divid);
	if(div != null) {
		div.style.visibility = 'visible';
		div.style.display = 'block';
	}
}
//---- Función para ocultar DIVISIONES
function hidediv(divid) {
	var div = document.getElementById(divid);
	if(div != null) {
		div.style.visibility = 'hidden';
		div.style.display = 'none';
	}
}

//---- Función para mostrar y ocultar DIVISIONES
function switchdiv(divid){
	var div = document.getElementById(divid);
	if(div != null){
		if(div.style.visibility == 'visible' || div.style.display == 'block'){
			//alert('es visible');
			div.style.visibility	= 'hidden';
			div.style.display		= 'none';
		}
		else{
			//alert('es oculta');
			div.style.visibility	= 'visible';
			div.style.display		= 'block';
		}
	}
}
