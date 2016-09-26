// JavaScript Document

function CheckAll( frm, bhow ) {
    ocultardiv( "div_error"); 
    var formulario = document.getElementById( frm );
    for (var i=0;i<formulario.elements.length;i++) {
        var e = formulario.elements[i];
        if ( bhow =='0') e.checked = true;
        else if ( bhow =='1')    e.checked = false;
        else if ( bhow =='2')    e.checked = !e.checked ;
    }
    return (false);
}

function ValidateSomeChecked( frm, msgNo, msgConfirma ) {
    var SomeChecked= false; 
    for (var i=0;i<frm.elements.length;i++) {
        var e = frm.elements[i];
        SomeChecked    = ( (e.checked == true ) && ( e.name.indexOf("chk") != -1 )  ) ;
        if ( SomeChecked ) break;
    }
    if (!SomeChecked){
        mostrardiv( "div_error", msgNo );
        //alert( msgNo );
        return (false);
    }
    //return (confirm( msgConfirma ) );
    return (true);
}

function validateTxtFilter( frm ){
    /*if ( frm.txtSearch.value == "" )
   return false;*/
    return true;
}

function limpiar_filtro( id ){
    ocultardiv( "div_error"); 
    document.getElementById(id).value = "";
}

function AddElement( frm, act) {
    document.getElementById(frm).action = act;
    document.getElementById('MM_from').value = "frmAdd";   
    document.getElementById(frm).submit();
} 

function imprimirPdf( frm ) {
    document.getElementById(frm).submit();
}

function mostrardiv( id, msgNo ) {
    div = document.getElementById( id );
    if (div != null) {
        div.innerHTML = msgNo;
        div.style.display = "";
    }
}

function ocultardiv( id ) {
    div = document.getElementById( id );
    if (div != null) {
        div.innerText = "";    
        div.style.display= "none";
    }
}

function buscar_filtro ( idfrm, action, href ) {  
    ocultardiv( "div_error"); 
    document.getElementById( "MM_from" ).value = action;
    document.getElementById( idfrm ).action = href;    
    document.getElementById( idfrm ).submit();
}

function insertar_articulo ( idfrm, action, href ) {  
    ocultardiv( "div_error"); 
    document.getElementById( "MM_from" ).value = action;
    document.getElementById( idfrm ).action = href;    
    document.getElementById( idfrm ).submit();
}

function buscar_avanzada ( idfrm, action, href ) {  
    ocultardiv( "div_error"); 
    document.getElementById( "MM_from" ).value = action;
    document.getElementById( idfrm ).action = href;    
    document.getElementById( idfrm ).submit();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nombre                        : cargarDatosSelect (Hace una llamada al metodo ajax_cargarDatosSelect.php)
//parametros de entrada         
//  : idpadre = ID del control visual PADRE (para obtener el identificador activo)
//  : idHijo = ID del control visual HIJO (para poder actualizar en su InnerHTML el resultado de la consulta al metodo ajax_cargarDatosSelect.php)
//  : text = texto que aparecera mientras se esta ejecutando el metodo ajax_cargarDatosSelect.php
//  : claseName = Nombre de la clase controladora que utilizara el metodo ajax_cargarDatosSelect.php
//  : casoUso = Nombre del caso de uso (nombre del fichero php que contine la clase) que utilizara el metodo ajax_cargarDatosSelect.php
//  : campoFiltrar = Nombre del campo por el que se filtrara en el metodo ajax_cargarDatosSelect.php
//  : Index = Valor del Index para identificar el campo del que se obtendra el dato en el metodo ajax_cargarDatosSelect.php
//parametros de salida         :  retorna un texto con el contenido del control SELECT
//autor                        : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
//fecha    creacion            : 10 Junio 2012
//historico de modificaciones  :
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
function cargarDatosSelect(idpadre, idHijo, text, claseName, campoFiltrar, casoUso, Index){
    $('#' + idHijo).html('<option selected>' + text + '</option>');
 
    var id= $('#' + idpadre).val();
 
    var toLoad= 'public/ajax_cargarDatosSelect.php?id='+ id + '&cu=' + casoUso + '&cn=' + claseName + '&cf=' + campoFiltrar+ '&in=' + Index;
    $.post(toLoad,function (responseText){
        $('#' + idHijo).html(responseText);
    });
 
}

function cargarDatosSelect_1(id_recorrido,id_producto , cantidad_producto,id_recorrido_producto,zona_update,accion){

    if(accion=='adicionar'){
        var id_recorrido_param= $('#' + id_recorrido).val();
        var id_producto_param= $('#' + id_producto).val();
        var cantidad_producto_param= $('#' + cantidad_producto).val();
 
        var toLoad= 'public/prueba.php?id_recorrido='+ id_recorrido_param + '&id_producto=' + id_producto_param + '&cantidad_producto=' + cantidad_producto_param +'&accion='+accion ;
        $.post(toLoad,function (responseText){
            $('#' + zona_update).html(responseText);
        });
    }
    else if(accion=='modificar'){

        var cantidad_producto_param= cantidad_producto;
        var id_recorrido_producto = id_recorrido_producto;
           
        var toLoad= 'public/prueba.php?id_recorrido='+ id_recorrido +'&id_producto=' + id_producto  + '&id_recorrido_producto='+ id_recorrido_producto + '&cantidad_producto=' + cantidad_producto_param +'&accion='+accion ;
        $.post(toLoad,function (responseText){
            $('#' + zona_update).html(responseText);
        });
        
    }
    else if(accion == 'eliminar'){
        var cantidad_producto_param= cantidad_producto;
        var id_recorrido_producto = id_recorrido_producto;
           
        var toLoad= 'public/prueba.php?id_recorrido='+ id_recorrido +'&id_producto=' + id_producto  + '&id_recorrido_producto='+ id_recorrido_producto + '&cantidad_producto=' + cantidad_producto_param +'&accion='+accion ;
        $.post(toLoad,function (responseText){
            $('#' + zona_update).html(responseText);
        });
    }
}
function adicionarTrabajador(id_empresa,zona_trabajador,accion){
    
    var id_empresa= id_empresa;
           
    var toLoad= 'public/trabajador.php?id_empresa='+ id_empresa +'&accion='+accion ;
    $.post(toLoad,function (responseText){
        $('#' + zona_trabajador).html(responseText);
    });
}
function incluir_usuario(zona_usuario,marcado){
       
    var toLoad= 'public/usuario.php?marcado='+marcado;
    $.post(toLoad,function (responseText){
        $('#' + zona_usuario).html(responseText);
    });
}
function encriptarClave( id ) {
    objClave = document.getElementById( id );
    if (objClave != null) {
        objClave.value = hex_md5(objClave.value);
    }
    return;
}

function validar_numero(myfield, e, dec)   //nombre de la funcion.....
{
    var key;
    var keychar;
    if (window.event)
    {
        key = window.event.keyCode;
    }
    else if (e)
    {
        key = e.which;
    }
    else
    {
        return true;
    }
    keychar = String.fromCharCode(key);
       
    //esto es para permitir las teclas de control como BORRAR(8) entre otras
    if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) )
    {
        return true;
    }
    //donde estan los numeros pueden colocar todos los caracteres
    // que quieres aceptar por ejemplo: abcd...xyzABCD...XYZ
    else if ((("0123456789").indexOf(keychar) > -1))
    {
        return true;
    }                 //no se exactamente para que es pero bueno... xD
    else if (dec && (keychar == "."))// decimal point jump
    {
        myfield.form.elements[dec].focus();
        return false;
    }
    else
    {               //advertencia que da cuando se intenta ingresar un acracter no permitido
        return false;
    }
}
