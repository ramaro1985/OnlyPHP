<?php
include_once("utiles/session.class.php");
$mySession = new Session();
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
// include the Zebra_Form class
require 'Zebra_Form.php';
include_once("utiles/utils.class.php");
include_once("idioma/pt.php");
include_once("controladores/v_evento_mpla_buscar.class.php");
include_once("controladores/v_evento_opsc_buscar.class.php");
include_once("controladores/tipoevento.class.php");
include_once("controladores/comuna.class.php");
include_once("controladores/provincia.class.php");
include_once("controladores/municipio.class.php");
include_once("controladores/organizacion_enevento.class.php");
include_once("controladores/organizacion.class.php");
include_once("controladores/dirigente.class.php");
$casoUso = 'evento_mpla';
if (isset($_GET["id"]) && ($_GET["id"] == 0)) {
    echo Utils::getDivTitulo($label["nuevo_evento_mpla"]);
    //cargar los datos a modificar    
    $id = 0;
    $id_usuario;
    $id_provincia;
    $id_municipio;
    $id_comuna;
    $id_tipo_organizacion_enevento;
    $id_ubicacion_evento;
    $presidente_acto = '';
    $cantidad_participantes = '';
    $principales_ocurrencias = '';
    $fecha_planificada = '';
    $hora_planificada = '';
    $fecha_realizada = '';
    $hora_realizada = '';
    $prelectores = '';
    $id_dirigente;
    $local = '';
    $cordinador = '';
    $enfoque = '';
    $medidas_organizativas = '';
    $impacto = '';
    $dificultades = '';
    $medidas_seguridad = '';
    $id_organizacion = '';
    $id_ubicacion_evento = $mySession->obtenerVariable('id_ubicacion_evento');

    $MM_from = 'guardar_nuevo';
} else {
    echo Utils::getDivTitulo($label["modificar_evento_mpla"]);
    //cargar los datos a modificar
    $id_ubicacion_evento = $mySession->obtenerVariable('id_ubicacion_evento');
    if ($id_ubicacion_evento == 0) {
        $MyEvento = new v_Evento_opsc_buscar();
    } else {
        $MyEvento = new v_Evento_mpla_buscar();
    }

    $MyEvento->getRecord($_GET["id"]);
    $aDatos = $MyEvento->objConexion->crearArreglo();

    $id = $aDatos['id'];
    $id_usuario = $aDatos['id_usuario'];
    $id_provincia = $aDatos['id_provincia'];
    $id_municipio = $aDatos['id_municipio'];
    $id_comuna = $aDatos['id_comuna'];
    $id_tipo_organizacion_enevento = $aDatos['id_tipo_organizacion_enevento'];
    $id_ubicacion_evento = $aDatos['id_ubicacion_evento'];
    $presidente_acto = $aDatos['presidente_acto'];
    $cantidad_participantes = $aDatos['cantidad_participantes'];
    $principales_ocurrencias = $aDatos['principales_ocurrencias'];
    $fecha_planificada = $aDatos['fecha_planificada'];
    $hora_planificada = $aDatos['hora_planificada'];
    $fecha_realizada = $aDatos['fecha_realizada'];
    $hora_realizada = $aDatos['hora_realizada'];
    $prelectores = $aDatos['prelectores'];
    $id_dirigente = $aDatos['id_dirigente'];

    $local = $aDatos['local'];
    $cordinador = $aDatos['cordinador'];
    $enfoque = $aDatos['enfoque'];
    $medidas_organizativas = $aDatos['medidas_organizativas'];
    $impacto = $aDatos['impacto'];
    $dificultades = $aDatos['dificultades'];
    $medidas_seguridad = $aDatos['medidas_seguridad'];
    $id_organizacion = $aDatos['id_organizacion'];


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

$form = new Zebra_Form('form', 'POST', '../negocio/crud_evento_mpla.php', array('onsubmit' => 'return selectedIncluidos( document.getElementById(\'prelectores\') );'));

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

$form->add('label', 'label_local', 'local', $label["local"]);
$form->add('text', 'local', $local);

$form->add('label', 'label_cordinador', 'local', $label["cordinador"]);
$form->add('text', 'cordinador', $cordinador);


// obj Organizacion en Evento si la $id_ubicacion_evento  es igual a 0 es que la organizacion
// que se musstra es la opositora
// si no se muestran las organizaciones del MPLA
if ($id_ubicacion_evento == 0) {
    $form->add('label', 'label_id_organizacion', 'id_organizacion', $label["id_organizacion"]);

    $obj = & $form->add('select', 'id_organizacion', $id_organizacion, array('style' => 'width:172px'));

    $objOrg = new Organizaciones();
    $Datos = $objOrg->getRecords('id > 1');
    $objDatos = $objOrg->objConexion->crearArregloObjetos();
    $myArray = Utils::getArrayForSelect($objDatos, 'id', 'abreviatura', $label["seleccione_uno"]);

    $obj->add_options($myArray, true);
    $obj->set_rule(array(
        'required' => array('error', $label["id_organizacion_obligatorio"])
    ));
} else {
    $form->add('label', 'label_id_tipo_organizacion_enevento', 'id_tipo_organizacion_enevento', $label["id_tipo_organizacion_enevento"]);

    $obj = & $form->add('select', 'id_tipo_organizacion_enevento', $id_tipo_organizacion_enevento, array('style' => 'width:172px'));

    $objOrg = new Organizacion_enevento();
    $Datos = $objOrg->getRecords();
    $objDatos = $objOrg->objConexion->crearArregloObjetos();
    $myArray = Utils::getArrayForSelect($objDatos, 'id', 'nombre_organizacion', $label["seleccione_uno"]);

    $obj->add_options($myArray, true);
    $obj->set_rule(array(
        'required' => array('error', $label["id_tipo_organizacion_enevento_obligatorio"])
    ));
}

// obj Dirigentes
$form->add('label', 'label_id_dirigente', 'id_dirigente', $label["id_dirigente"]);

$obj = & $form->add('select', 'id_dirigente', $id_dirigente, array('style' => 'width:172px'));

$objD = new Dirigente();
$Datos = $objD->getRecords();
$objDatos = $objD->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'dirigente', $label["seleccione_uno"]);

$obj->add_options($myArray, true);
$obj->set_rule(array(
    'required' => array('error', $label["id_dirigente_obligatorio"])
));


$form->add('label', 'label_presidente_acto', 'presidente_acto', $label["presidente_acto"]);

$obj = & $form->add('text', 'presidente_acto', $presidente_acto, array('style' => 'width:172px'));

$form->add('label', 'label_enfoque', 'enfoque', $label["enfoque"]);
$obj = & $form->add('textarea', 'enfoque', $enfoque, array('style' => 'width:750px', 'rows' => '4'));

$form->add('label', 'label_medidas_organizativas', 'medidas_organizativas', $label["medidas_organizativas"]);
$obj = & $form->add('textarea', 'medidas_organizativas', $medidas_organizativas, array('style' => 'width:750px', 'rows' => '4'));

$form->add('label', 'label_impacto', 'impacto', $label["impacto"]);
$obj = & $form->add('textarea', 'impacto', $impacto, array('style' => 'width:750px', 'rows' => '4'));

$form->add('label', 'label_principales_ocurrencias', 'principales_ocurrencias', $label["principales_ocurrencias"]);
$obj = & $form->add('textarea', 'principales_ocurrencias', $principales_ocurrencias, array('style' => 'width:750px', 'rows' => '4'));

$form->add('label', 'label_dificultades', 'dificultades', $label["dificultades"]);
$obj = & $form->add('textarea', 'dificultades', $dificultades, array('style' => 'width:750px', 'rows' => '4'));

$form->add('label', 'label_medidas_seguridad', 'medidas_seguridad', $label["medidas_seguridad"]);
$obj = & $form->add('textarea', 'medidas_seguridad', $medidas_seguridad, array('style' => 'width:750px', 'rows' => '4'));


//Falta por ubicar
$form->add('label', 'label_cantidad_participantes_aproximado', 'cantidad_participantes_aproximado', $label["cantidad_participantes_aproximado"]);
$obj = & $form->add('text', 'cantidad_participantes', $cantidad_participantes, array('style' => 'width:500px'));

//Falta por ubicar
$form->add('label', 'label_fecha_planificada', 'fecha_planificada', $label["fecha_planificada"]);
$date = & $form->add('date', 'fecha_planificada', $fecha_planificada, array('style' => 'width:140px'));

$date->format('Y-m-d');

$date->set_rule(array(
    'date' => array('error', $label['fecha_nacimiento_incorrecta']),
        //'required' => array('error', $label["fecha_planificada_obligatorio"]),
));
list($hora_planificada, $min_planificada, $horario_planificada) = split(':', $hora_planificada);

for ($i = 1; $i <= 12; $i++) {
    $myHoras[$i] = $i;
}
for ($i = 0; $i < 60; $i++) {
    $myMin[$i] = $i;
}

$form->add('label', 'label_hora_planificada', 'hora_planificada', $label["hora_planificada"]);
$obj = &$form->add('select', 'hora_planificada', $hora_planificada);
$obj->add_options($myHoras, true);

$form->add('label', 'label_min_planificada', 'min_planificada', $label["min_planificada"]);
$obj = &$form->add('select', 'min_planificada', $min_planificada);
$obj->add_options($myMin, true);

$form->add('label', 'label_horario_planificada', 'horario_planificada', $label["horario_planificada"]);
$obj = &$form->add('select', 'horario_planificada', $horario_planificada);
$obj->add_options(array('AM' => 'AM', 'PM' => 'PM',), true);


$form->add('label', 'label_fecha_realizada', 'fecha_realizada', $label["fecha_realizada"]);
$date = & $form->add('date', 'fecha_realizada', $fecha_realizada, array('style' => 'width:140px'));

$date->format('Y-m-d');
$date->set_rule(array(
    'date' => array('error', $label['fecha_nacimiento_incorrecta']),
));
list($hora_realizada, $min_realizada, /*$horario_realizada*/) = split(':', $hora_realizada);

for ($i = 1; $i <= 12; $i++) {
    $myHoras[$i] = $i.' H';
}
for ($j = 0; $j < 60; $j++) {
 $myMin[$j] = $j.' min';
}
$form->add('label', 'label_hora_realizada', 'hora_realizada', $label["hora_realizada"]);
$obj = &$form->add('select', 'hora_realizada', $hora_realizada);
$obj->add_options($myHoras, true);

//$form->add('label', 'label_min_realizada', 'min_realizada', $label["min_realizada"]);
$obj = &$form->add('select', 'min_realizada', $min_realizada);
$obj->add_options($myMin, true);

$form->add('label', 'label_horario_realizada', 'horario_realizada', $label["horario_realizada"]);
/*$obj = &$form->add('select', 'horario_realizada', $horario_realizada);
$obj->add_options(array('AM' => 'AM', 'PM' => 'PM',), true);*/


$form->add('label', 'label_cantidad_participantes', 'cantidad_participantes', $label["cantidad_participantes"]);
$obj = & $form->add('text', 'cantidad_participantes', $cantidad_participantes, array('style' => 'width:100px'));
$obj->set_rule(array(
    'digits' => array('error', $label["cantidad_producto_error"]),
));

// add the "hidden" field
$obj = & $form->add('hidden', 'MM_from', $MM_from);
$obj = & $form->add('hidden', 'id', $id);

$form->add('submit', 'btn_submit', $label["guardar"]);
$form->render('custom-templates/custom-eventompla.php');
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
