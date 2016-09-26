<?php
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../'));
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../../'));     
include_once("configuracion/configuracion.php");  
include_once("acceso_datos/".DRIVER_BD."_acceso_datos.class.php");
include_once("controladores/municipio.class.php");
include_once("controladores/comuna.class.php");
include_once("controladores/cap.class.php");
include_once("controladores/activista.class.php");
include_once("utiles/file.class.php");

/*
$municipio = new Municipios();
$municipio->getRecords(" 0=0 ");
$arr = $municipio->objConexion->crearArregloPorNombreDeFilas();
$cantElementos = count($arr);
for ($i = 0; $i < $cantElementos; $i++) {
    echo 'INSERT INTO nmcomuna ("id_municipio", "comuna") VALUES ('.$arr[$i]['id'].", 'Desconocido');<br>";
}
echo "Total = ".$cantElementos."<br>"; 


$comuna = new Comunas();
$comuna->getRecords(" 0=0 ");
$arr = $comuna->objConexion->crearArregloPorNombreDeFilas();
$cantElementos = count($arr);
for ($i = 0; $i < $cantElementos; $i++) {
    echo 'INSERT INTO nmcap ("id_comuna", "cap") VALUES ('.$arr[$i]['id'].", 'Desconocido');<br>";
}
echo "Total = ".$cantElementos."<br>"; 
*/
/*
 $Obj = new Activista();
 $data = array('2', '1', '1', '2', '4', '2', '123', '12354', '123', 'Juan B', '15 de Abril', 'admin@admin.com', '123456789', 'M', "Bi/env'eni/'do", '', '');
 //$Obj->insertRecord($data);
 $Obj->updateRecord(10, $data)
*/

/* Subir ficheros */
?>
<style>
#upload_button {
    width:120px;
    height:35px;
    text-align:center;
    background-image:url(boton.png);
    color:#CCCCCC;
    font-weight:bold;
    padding-top:15px;
    margin:auto;
}
</style>

<script language="javascript" src="public/javascript/jquery-1.7.js"></script>
<script language="javascript" src="public/javascript/AjaxUpload.2.0.min.js"></script>
<script language="javascript">
$(document).ready(function(){
    var button = $('#upload_button'), interval;
    new AjaxUpload('#upload_button', {
        action: '../utiles/upload.class.php?cu=ocurrencia',
        onSubmit : function(file , ext){
        if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
            // extensiones permitidas
            alert('Error: Solo se permiten imagenes');
            // cancela upload
            return false;
        } else {
                       //Cambio el texto del boton y lo deshabilito
            button.text('Uploading');
            this.disable();
        }
        },
        onComplete: function(file, response){
            //$(".imagen").html('<img class="asd" src="'+response+'" width=145px height=210px');
            alert('responde =' + response);  
            
            $(".asd").attr({'src':response,
            'width':'145',
            'height':'210'
            });           
               
            button.text('Upload');
            // habilito upload button  
                                
            this.enable();         
            // Agrega archivo a la lista
            $('#lista').appendTo('.files').text(file);
        }  
    });
});
</script>

<div id="upload_button">Upload</div>
<div class="imagen"><img class="asd" src="" width="145" height="210" /></div>
<ul id="lista">
</ul>