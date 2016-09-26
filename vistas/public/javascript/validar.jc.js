// JavaScript Document

//*****************************************************
//Funciones para la validacion de direcciones de correo
//*****************************************************

function trim(str) {
  return str.replace(/^\s+|\s+$/g, '');
}

function delspace(str) {
  return str.replace(/\s+/g, '');
}


//Dado un texto valida si es una direcci?n electr?nica correcta
function validarEmail ( aMail) {
  var tfld = trim(aMail);  
  var email = /^[^@]+@[^@.]+\.[^@]*\w\w$/  ;
  if (!email.test(tfld)) { return false; }
  return true;
}

//Dado un texto de varias dirrecciones de correos, separadas por un caracter especifico
//las almacena en un arreglo y las valida una a una
function validarArrEmail (aEmail, aSeparador) {
	aArrEmail = aEmail.value.split(aSeparador);
	for(i=0;i<aArrEmail.length;i++) {   
		if ( ! validarEmail(aArrEmail[i])) { 
		    alert (aArrEmail[i] + document.getElementById("correo_valida").value);			
			aEmail.focus();
			return false; 
		}
	}
	return true;
}

//*****************************************************
//Funciones para la validacion de direcciones de correo
//*****************************************************

//*****************************************************
//Funciones para la validacion de n?meros enteros
//*****************************************************

//Dado un texto valida si es un n?mero entero entre 1 y 999
function validarNumeroEntero (aNumero, aMinimo) {
  var tfld = trim(aNumero);  
  var numeroEntero = /^[0-9]{1,3}$/ ;
  if (!numeroEntero.test(tfld)) { return false; }
  if (tfld < aMinimo) { return false; }
  return true;
}

//Dado un texto valida si es un n?mero entero entre 1 y 999
function validarNumeroEntero9Cifras (aNumero, aMinimo) {
  var tfld = trim(aNumero);  
  var numeroEntero = /^[0-9]{1,9}$/ ;
  if (!numeroEntero.test(tfld)) { return false; }
  if (tfld < aMinimo) { return false; }
  return true;
}

//*****************************************************
//Funciones para la validacion de n?meros enteros
//*****************************************************

//*****************************************************
//Funciones para la validacion de n?meros de tel?fonos
//*****************************************************

//Dado un texto valida si es un n?mero entero entre 1 y 99999999999999999999 (20 d?gitos)
function validarNumeroTelefono (aNumero, aMinimo, aCifras) {
  var tfld = delspace(aNumero); 
  var numeroEntero = /^[0-9]{1,20}$/ ;
  if (!numeroEntero.test(tfld)) { return false; }
  if ( tfld.length < aCifras ) { return false; }
  if ( tfld < aMinimo ) { return false; }
  return true;
}

//Dado un texto de varios n?meros de tel?fonos, separadas por un caracter especifico
//los almacena en un arreglo y las valida uno a uno
//aNumero es el componente que contiene el n?mero validar
function validarArrNumeroTelefono (aNumero, aSeparador, aMinimo, aCifras) {
	aArrNumeroTelefono = aNumero.value.split(aSeparador);
	for(i=0;i<aArrNumeroTelefono.length;i++) {   
		if ( ! validarNumeroTelefono(aArrNumeroTelefono[i], aMinimo, aCifras)) { 
		    alert (aArrNumeroTelefono[i] + document.getElementById("tel_valido").value);			
			aNumero.focus();
			return false; 
		}
	}
	return true;
}
//*****************************************************
//Funciones para la validacion de n?meros de tel?fonos
//*****************************************************

//Dado un texto valida si es un n?mero real mayor que cero
function validarNumeroReal (aNumero, aMinimo) {
	if ( isNaN(aNumero) ) { 
		return false; 
	} else { 
		if ( aNumero < aMinimo ) { return false; } 		
		return true; 
	} 
}

//Dado un texto valida si es un n?mero entero entre 1 y 999
function validarNombre (aNombre) {
  var tfld = delspace(aNombre);  
  var numeroEntero = /^[a-zA-Z]*$/;
  if (!numeroEntero.test(tfld)) { return false; }
  return true;
}
