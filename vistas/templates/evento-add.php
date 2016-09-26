<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
// include the Zebra_Form class
require 'Zebra_Form.php';
include_once("controladores/grupo.class.php");
include_once("utiles/utils.class.php");
include_once("idioma/pt.php");
include_once("controladores/evento.class.php");
include_once("controladores/v_evento_buscar.class.php");
include_once("controladores/tipoevento.class.php");
include_once("controladores/comuna.class.php");
include_once("controladores/provincia.class.php");
include_once("controladores/municipio.class.php");
include_once("controladores/organizacion.class.php");

$casoUso = 'evento';

if (isset($_GET["id"]) && ($_GET["id"] == 0)) {
    echo Utils::getDivTitulo($label["nuevo_evento"]);
    //cargar los datos a modificar    
    $id = 0;
    $id_usuario = 0;
    $id_municipio = 0;
    $id_comuna = 0;
    $id_tipo_evento = 0;
    $fecha = '';
    $descripcion = '';
    $nro_participante = 0;
    $quien_dirige = '';
    $otros_miembros = '';

    $MM_from = 'guardar_nuevo';
} else {
    echo Utils::getDivTitulo($label["modificar_evento"]);
    //cargar los datos a modificar
    $MyEvento = new v_Evento_Buscar();
    $MyEvento->getRecord($_GET["id"]);
    $aDatos = $MyEvento->objConexion->crearArreglo();

    $id = $aDatos['id'];
    $id_usuario = $aDatos['id_usuario'];
    $id_provincia = $aDatos['id_provincia'];
    $id_municipio = $aDatos['id_municipio'];
    $id_comuna = $aDatos['id_comuna'];
    $id_tipo_evento = $aDatos['id_tipo_evento'];
    $fecha = $aDatos['fecha'];
    $descripcion = $aDatos['descripcion'];
    $nro_participante = $aDatos['nro_participante'];
    $quien_dirige = $aDatos['quien_dirige'];
    $otros_miembros = $aDatos['otros_miembros'];
    $id_organizacion= $aDatos['id_organizacion'];


    $MM_from = 'actualizar';
}
echo Utils::getDivOpen();
if (isset($_GET["error"]) && $_GET["error"] == 1) {
    if ($_GET["tipo_error"] == 'insertar_update') {
        $error = $label["error_insertar_update"] . $label["nombre_evento"] . $label['seleccionado'];
        echo Utils::getDivErrorLogin($error);
    } elseif ($_GET["tipo_error"] == 'fecha') {
        $error = $label["error_fecha"];
        echo Utils::getDivErrorLogin($error);
    }
} else {
    echo Utils::getDivError($label["usuario_pass_incorrecto"]);
}

$form = new Zebra_Form('form', 'POST', '../negocio/crud_evento.php');

// obj provincias
$form->add('label', 'label_id_provincia', 'id_provincia', $label["provincia"]);

$obj = & $form->add('select', 'id_provincia', $id_provincia, array(
            'onchange' => 'cargarDatosSelect(\'id_provincia\', \'id_municipio\',\'' . $label["cargando"] . '\', \'Municipios\', \'id_provincia\', \'municipio\', 2);',
            'style' => 'width:172px'
        ));

$objProvincia = new Provincias();
$Datos = $objProvincia->getRecords();
$objDatos = $objProvincia->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'provincia', $label["seleccione_uno"]);

$obj->add_options($myArray, true);

$obj->set_rule(array(
    'required' => array('error', $label["provincia_obligatorio"])
));


//la etiqueta para el obj Municipios
$form->add('label', 'label_id_municipio', 'id_municipio', $label["municipio"]);

$obj = & $form->add('select', 'id_municipio', $id_municipio, array(
            'onchange' => 'cargarDatosSelect(\'id_municipio\', \'id_comuna\', \'' . $label["cargando"] . '\', \'Comunas\', \'id_municipio\', \'comuna\', 2);',
            'style' => 'width:172px'
        ));

if ($id > 0) {
    $objMunicipio = new Municipios();
    $Datos = $objMunicipio->getRecords('id_provincia=' . $id_provincia);
    $objDatos = $objMunicipio->objConexion->crearArregloObjetos();
    $myArray = Utils::getArrayForSelect($objDatos, 'id', 'municipio', $label["seleccione_uno"]);

    $obj->add_options($myArray, true);
} else {
    $obj->add_options(array('' => $label["seleccione_uno"]), true);
};
$obj->set_rule(array(
    'required' => array('error', $label["municipio_obligatorio"])
));

// obj Comunas
$form->add('label', 'label_id_comuna', 'id_comuna', $label["comuna"]);

$obj = & $form->add('select', 'id_comuna', $id_comuna, array(
            'onchange' => 'cargarDatosSelect(\'id_comuna\', \'id_cap\', \'' . $label["cargando"] . '\', \'Cap\', \'id_comuna\', \'cap\', 2);',
            'style' => 'width:172px'
        ));

if ($id > 0) {
    $objComuna = new Comunas();
    $Datos = $objComuna->getRecords('id_municipio=' . $id_municipio);
    $objDatos = $objComuna->objConexion->crearArregloObjetos();
    $myArray = Utils::getArrayForSelect($objDatos, 'id', 'comuna', $label["seleccione_uno"]);

    $obj->add_options($myArray, true);
} else {
    $obj->add_options(array('' => $label["seleccione_uno"]), true);
}

//Fecha del evento
if ($fecha != '') {
    $fecha = split(' ', $fecha);
}
$form->add('label', 'label_fecha', 'fecha', $label["fecha"]);

$date = & $form->add('date', 'fecha', $fecha[0], array('style' => 'width:140px'));

$date->format('Y-m-d');

$date->set_rule(array(
    'date' => array('error', $label['fecha_nacimiento_incorrecta']),
    'required' => array('error', $label["fecha_obligatorio"]),
));

//Descripcion del evento
$form->add('label', 'label_descripcion', 'descripcion', $label["desc_evento"]);

$obj = & $form->add('textarea', 'descripcion', $descripcion, array('style' => 'width:520px', 'rows' => '2'));
$obj->set_rule(array(
    'required' => array('error', $label["nombre_obligatorio"]),
));

// Tipo del evento
$form->add('label', 'label_id_tipo_evento', 'id_tipo_evento', $label["tipo_evento"]);

$obj = & $form->add('select', 'id_tipo_evento', $id_tipo_evento);

$objTipoServ = new Tipoevento();
$Datos = $objTipoServ->getRecords();
$objDatos = $objTipoServ->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'tipo_evento', $label["seleccione_uno"]);

$obj->add_options($myArray, true);

$obj->set_rule(array(
    'required' => array('error', $label["tipo_evento_obligatorio"])
));

// Cantidad de participantes 
$form->add('label', 'label_nro_participante', 'nro_participante', $label["nro_participantes"]);

$obj = & $form->add('text', 'nro_participante', $nro_participante, array('style' => 'width:150px'));

$obj->set_rule(array(
    'digits' => array('error', $label["cantidad_producto_error"]),
));

//Quien lo dirige
$form->add('label', 'label_quien_dirige', 'quien_dirige', $label["quien_dirige"]);

$obj = & $form->add('text', 'quien_dirige', $quien_dirige, array('style' => 'width:250px'));


//Otros mienbros
$form->add('label', 'label_otros_miembros', 'otros_miembros', $label["otros_miembros"]);

$obj = & $form->add('textarea', 'otros_miembros', $otros_miembros, array('style' => 'width:250px'));

//Para las organizaciones que participan
$form->add('label', 'label_id_organizacion', 'id_organizacion', $label["id_organizacion"]);

$obj = & $form->add('select', 'id_organizacion', $id_organizacion, array('style' => 'width:260px'));

$objOrgEvento = new Organizaciones();
$objOrgEvento->getRecords("id<>1");
$objDatos = $objOrgEvento->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'org_partidista', $label["seleccione_uno"]);

$obj->add_options($myArray, true);

$obj->set_rule(array(
    'required' => array('error', $label["id_organizacion_enevento_obligatorio"])
));

// add the "hidden" field
$obj = & $form->add('hidden', 'MM_from', $MM_from);
$obj = & $form->add('hidden', 'id', $id);

$form->add('submit_1', 'btn_submit', $label["guardar"]);
$form->render('custom-templates/custom-evento.php');
?>
<script language="javascript" src="public/javascript/AjaxUpload.2.0.min.js"></script>
<?php if ($id != 0): ?>
    <?php echo'
<script>
    $(document).ready(function(){
        $( "#tabs" ).tabs();
    });
</script>';
    ?>

<script language="javascript">
$(document).ready(function(){
    var button = $('#upload_imagen'), interval;
    var error = $('#error_img');
    new AjaxUpload('#upload_imagen', {
        action: '../utiles/upload.class.php?cu=<?php echo $casoUso.'&id='.$id; ?>',
        onSubmit : function(file , ext){
        if (! (ext && /^(jpg|png|jpeg|gif|bmp)$/.test(ext))){
            // extensiones permitidas
           // alert('Error: Solo se permiten imagenes');
           error.show();
            
            // cancela upload
            return false;
        } else {
            //Cambio el texto del boton y lo deshabilito
            error.hide();
            button.text('Uploading');
            this.disable();
        }
        },
        onComplete: function(file, response){
            $('#gallery').html(response);
             
            button.text('Upload');
            // habilito upload button  
                                
            this.enable();         
        }  
    });
});
</script>
    <script language="javascript">
        $(document).ready(function(){
            $("a[rel = 'lightbox']").lightBox();					   
        });
    </script>
    <div class="demo">
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1"><?php echo $label["imagenes"] ?></a></li>
                <li><a href="#tabs-2"><?php echo $label["documentos"] ?></a></li>
            </ul>
            <div id="tabs-1">
                <div>
                    <div id="error_img" hidden="true" class="error"><?php echo Utils::getDivErrorLogin($label["error_img"]);?></div>
                    <div ><image src="../vistas/public/imagenes/add_img.jpg" id="upload_imagen" ><!--<image src="../vistas/public/imagenes/remove_img.jpg" id="" >--></div>            
                    <div id="gallery">
                    <?php
                        include_once("utiles/gallery.class.php");
                        $mygallery = new gallery();
                        $pathFolder = '../'. CAMINO_DOC_ADJUNTOS. '/'. $casoUso. '/'. $id;
                        @$mygallery->loadFolder( $pathFolder );
                        $mygallery->show(550, 100, 10);
                    ?>
                    </div>
                </div>
            </div>
            <div id="tabs-2">
                <div ><?php echo $label["documentos"] ?></div>
            </div>
        </div>
    </div>
    <?php
endif;

echo Utils::getDivClose();
?>
