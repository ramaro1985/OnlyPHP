<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
include_once("utiles/session.class.php");
$mySession = new Session();

$casoUso = 'recorrido';
require 'Zebra_Form.php';
include_once("utiles/utils.class.php");
include_once("utiles/lst.class.php");
include_once("idioma/pt.php");
include_once("controladores/provincia.class.php");
include_once("controladores/municipio.class.php");
include_once("controladores/comuna.class.php");
include_once("controladores/empresa.class.php");
include_once("controladores/proyecto.class.php");
include_once("controladores/estado.class.php");
include_once("controladores/v_recorrido_buscar.class.php");
include_once("controladores/v_empresa.class.php");
include_once("controladores/v_proyectoempresa.class.php");
include_once("controladores/usuario.class.php");
include_once("controladores/supervisor.class.php");
include_once("controladores/producto.class.php");
include_once("controladores/v_recorrido_producto.class.php");
include_once("controladores/recorrido_producto.class.php");
include_once("controladores/v_recorridoevaluacion.class.php");
include_once("controladores/recorridoevaluacion.class.php");

include_once("controladores/" . $casoUso . ".class.php");
if (isset($_GET["error"]) && $_GET["error"] == 1) {
    if ($_GET["tipo_error"] == 'insertar_update') {
        $error = $label["error_insertar_update"] . $label["recorrido"] . $label['seleccionado'];
        echo Utils::getDivErrorLogin($error);
    }
} else {
    echo Utils::getDivError($label["usuario_pass_incorrecto"]);
}

if (isset($_GET["id"]) && ($_GET["id"] == 0)) {
    echo Utils::getDivTitulo($label["nuevo_recorrido"]);

    $id = 0;
    $id_comuna = 0;
    $id_municipio = 0;
    $id_provincia = 0;
    $id_estado = 0;
    $id_proyecto_empresa = 0;
    $nombre_recorrido = '';
    $provincia = '';
    $municipio = '';
    $comuna = '';
    $estado = '';
    $id_proyecto_1 = 0;
    $id_empresa_1 = 0;
    $fecha_propuesta_inicio = '';
    $fecha_inicio = '';
    $fecha_propuesta_fin = '';
    $fecha_fin = '';
    $id_tipo_supervisor = 0;
    $id_usuario = 0;
    $tipo_supervisor = 0;
    $nombre_apellido = '';
    $habilitado = 0;

    $mySession->eliminarVariable('id_recorrido');

    $MM_from_recorrido = 'guardar_nuevo_recorrido';
} else {

    echo Utils::getDivTitulo($label["modificar_recorrido"]);
    //cargar los datos a modificar
    $MyObj = new v_Recorrido_buscar();
    $MyObj->getRecord($_GET["id"]);
    $aDatos = $MyObj->objConexion->crearArreglo();

    $id = $aDatos['id'];
    $id_comuna = $aDatos['id_comuna'];
    $id_municipio = $aDatos['id_municipio'];
    $id_provincia = $aDatos['id_provincia'];
    $id_estado = $aDatos['id_estado'];
    $id_proyecto_empresa = $aDatos['id_proyecto_empresa'];
    $nombre_recorrido = $aDatos['nombre_recorrido'];
    $provincia = $aDatos['provincia'];
    $municipio = $aDatos['municipio'];
    $comuna = $aDatos['comuna'];
    $estado = $aDatos['estado'];
    $id_proyecto = $aDatos['id_proyecto'];
    $id_empresa = $aDatos['id_empresa'];
    $fecha_propuesta_inicio = $aDatos['fecha_propuesta_inicio'];
    $fecha_inicio = $aDatos['fecha_inicio'];
    $fecha_propuesta_fin = $aDatos['fecha_propuesta_fin'];
    $fecha_fin = $aDatos['fecha_fin'];
    $id_tipo_supervisor = $aDatos['id_tipo_supervisor'];
    $id_usuario = $aDatos['id_usuario'];
    $tipo_supervisor = $aDatos['tipo_supervisor '];
    $nombre_apellido = $aDatos['nombre_apellido'];
    $habilitado = $aDatos['habilitado '];
    $id_recorrido_supervisor = $aDatos['id_recorrido_supervisor'];

    //$_SESSION['id_recorrido'] = $id;
   $mySession->registrarVariable('id_recorrido', $id);
    

    $MM_from_recorrido = 'actualizar_recorrido';
}


echo Utils::getDivOpen();
// instantiate a Zebra_Form object
$form = new Zebra_Form('form', 'POST', '../negocio/crud_' . $casoUso . '.php');

if ($id == 0 && $mySession->obtenerVariable('empresa_activo') == 0) {

    $form->add('label', 'label_id_empresa', 'id_empresa', $label["id_empresa"]);

    $obj = & $form->add('select', 'id_empresa', 'id_empresa', array(
                'onchange' => 'cargarDatosSelect(\'id_empresa\', \'id_proyecto\',\'' . $label["cargando"] . '\', \'v_proyectoempresa\', \'id_empresa\', \'Proyecto\', 4);',
                'style' => 'width:130px'
            ));
    $id_usuario_loguin = $mySession->obtenerVariable('idusuario');
    $arrAcceso = $mySession->arrAcceso;
    $id_grupo_gestion = $arrAcceso[0]['id_grupo_gestion'];

    $objEmpresa = new v_Empresa();
    if ($id_grupo_gestion != 2) {
        $objEmpresa->getRecords('id_usuario=' . "'$id_usuario_loguin'");
    } else {
        $objEmpresa->getRecords();
    }
    $objDatos = $objEmpresa->objConexion->crearArregloObjetos();
    $myArray = Utils::getArrayForSelect($objDatos, 'id', 'nombre_empresa', $label["seleccione_uno"]);

    $obj->add_options($myArray, true);

    $obj->set_rule(array(
        'required' => array('error', $label["empresa_obligatorio"])
    ));

//la etiqueta para el obj Pro
    $form->add('label', 'label_id_proyecto', 'id_proyecto', $label["id_proyecto"]);

    $obj = & $form->add('select', 'id_proyecto', 'id_proyecto', array('style' => 'width:130px'));

    $obj->add_options(array('' => $label["seleccione_uno"]), true);

    $obj->set_rule(array(
        'required' => array('error', $label["id_proyecto_obligatorio"])
    ));
}
// obj provincias
$form->add('label', 'label_id_provincia', 'id_provincia', $label["id_provincia"]);

$obj = & $form->add('select', 'id_provincia', $id_provincia, array(
            'onchange' => 'cargarDatosSelect(\'id_provincia\', \'id_municipio\',\'' . $label["cargando"] . '\', \'Municipios\', \'id_provincia\', \'municipio\', 2);',
            'style' => 'width:150px'
        ));

$obj->set_rule(array(
    'required' => array('error', $label["provincia_obligatorio"])
));

$objProvincia = new Provincias();
$Datos = $objProvincia->getRecords();
$objDatos = $objProvincia->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'provincia', $label["seleccione_uno"]);

$obj->add_options($myArray, true);

//la etiqueta para el obj Municipios
$form->add('label', 'label_id_municipio', 'id_municipio', $label["id_municipio"]);

$obj = & $form->add('select', 'id_municipio', $id_municipio, array(
            'onchange' => 'cargarDatosSelect(\'id_municipio\', \'id_comuna\', \'' . $label["cargando"] . '\', \'Comunas\', \'id_municipio\', \'comuna\', 2);',
            'style' => 'width:150px'
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
$form->add('label', 'label_id_comuna', 'id_comuna', $label["id_comuna"]);

$obj = & $form->add('select', 'id_comuna', $id_comuna, array(
            'onchange' => 'cargarDatosSelect(\'id_comuna\', \'id_cap\', \'' . $label["cargando"] . '\', \'Cap\', \'id_comuna\', \'cap\', 2);',
            'style' => 'width:150px'
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

//Estado 
$form->add('label', 'label_id_estado', 'id_estado', $label["id_estado"]);

$obj = & $form->add('select', 'id_estado', $id_estado, array('style' => 'width:130px'));

$objEstado = new Estado();
$Datos = $objEstado->getRecords();
$objDatos = $objEstado->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'estado', $label["seleccione_uno"]);

$obj->add_options($myArray, true);

$obj->set_rule(array(
    'required' => array('error', $label["estado_obligatorio"])
));

$form->add('label', 'label_nombre_recorrido', 'nombre_recorrido', $label["nombre_recorrido"]);

$obj = & $form->add('text', 'nombre_recorrido', $nombre_recorrido, array('style' => 'width:130px'));

$obj->set_rule(array(
    'required' => array('error', $label["nombre_recorrido_obligatorio"])
));

// Fecha_propuesta_inicio
if ($fecha_propuesta_inicio != '') {
    $fecha_propuesta_inicio = split(' ', $fecha_propuesta_inicio);
}
$form->add('label', 'label_fecha_propuesta_inicio', 'fecha_propuesta_inicio', $label["fecha_propuesta_inicio"]);

$date = & $form->add('date', 'fecha_propuesta_inicio', $fecha_propuesta_inicio[0], array('style' => 'width:120px'));

$date->format('Y-m-d');

$date->set_rule(array(
    'required' => array('error', $label['fecha_propuesta_inicio_obligatorio']),
    'date' => array('error', $label['fecha_propuesta_inicio_incorrecta']),
));

// Fecha_inicio
if ($fecha_inicio != '') {
    $fecha_inicio = split(' ', $fecha_inicio);
}
$form->add('label', 'label_fecha_inicio', 'fecha_inicio', $label["fecha_inicio"]);

$date = & $form->add('date', 'fecha_inicio', $fecha_inicio[0], array('style' => 'width:120px'));

$date->format('Y-m-d');

$date->set_rule(array(
    'date' => array('error', $label['fecha_inicio_incorrecta'])
));

// Fecha_propuesta_fin
if ($fecha_propuesta_fin != '') {
    $fecha_propuesta_fin = split(' ', $fecha_propuesta_fin);
}
$form->add('label', 'label_fecha_propuesta_fin', 'fecha_propuesta_fin', $label["fecha_propuesta_fin"]);

$date = & $form->add('date', 'fecha_propuesta_fin', $fecha_propuesta_fin[0], array('style' => 'width:120px'));

$date->format('Y-m-d');

$date->set_rule(array(
    'date' => array('error', $label['fecha_propuesta_fin_incorrecta'])
));

// Fecha_inicio
if ($fecha_fin != '') {
    $fecha_fin = split(' ', $fecha_fin);
}
$form->add('label', 'label_fecha_fin', 'fecha_fin', $label["fecha_fin"]);

$date = & $form->add('date', 'fecha_fin', $fecha_fin[0], array('style' => 'width:120px'));

$date->format('Y-m-d');

$date->set_rule(array(
    'date' => array('error', $label['fecha_fin_incorrecta']),
));

//Supervisor
$form->add('label', 'label_id_tipo_supervisor', 'id_tipo_supervisor', $label["id_tipo_supervisor"]);

$obj = & $form->add('select', 'id_tipo_supervisor', $id_tipo_supervisor, array('style' => 'width:130px'));

$objSup = new Supervisor();
$Datos = $objSup->getRecords();
$objDatos = $objSup->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'tipo_supervisor', $label["seleccione_uno"]);

$obj->add_options($myArray, true);

$obj->set_rule(array(
    'required' => array('error', $label["id_tipo_supervisor_obligatorio"])
));

//Supervisor
$form->add('label', 'label_id_usuario', 'id_usuario', $label["id_usuario"]);

$obj = & $form->add('select', 'id_usuario', $id_usuario, array('style' => 'width:130px'));

$objUss = new Usuarios();
$Datos = $objUss->getRecords('id<>1');
$objDatos = $objUss->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'nombre_apellido', $label["seleccione_uno"]);

$obj->add_options($myArray, true);

$obj->set_rule(array(
    'required' => array('error', $label["estado_obligatorio"])
));

$form->add('submit', 'annadir', $label["annadir"], array('type' => 'button', 'onclick' => 'cargarDatosSelect_1(\'id\',\'id_producto\', \'cantidad_producto\', \'id_recorrido_producto\',\'zona_update\',\'adicionar\');'));

// add the "hidden" field
$form->add('label', 'label_datos_recorrido', 'datos_recorrido', $label["datos_recorrido"]);
$form->add('label', 'label_add_productos', 'add_productos', $label["add_productos"]);

$obj = & $form->add('hidden', 'MM_from_recorrido', $MM_from_recorrido);
$obj = & $form->add('hidden', 'id_recorrido_supervisor', $id_recorrido_supervisor);
$obj = & $form->add('hidden', 'id', $id);

$obj = & $form->add('hidden', 'id_proyecto_empresa', $id_proyecto_empresa);

// "submit"
$form->add('submit', 'btn_submit', $label["guardar"]);
$form->render('custom-templates/custom-recorrido.php');
?>
<?php if ($id != 0): ?>
    <div class="demo">
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1"><?php echo $label["listado_producto"] ?></a></li>
                <li><a href="#tabs-2"><?php echo $label["listado_partes"] ?></a></li>
                <li><a href="#tabs-3"><?php echo $label["listado_evaluacion"] ?></a></li>
            </ul>
            <div id="tabs-1">
                <?php
                $casoUso = "recorrido_producto";
                $mySession->where[$casoUso]['where'] = 'id_recorrido=' . "'" . $id . "'";
                $mySession->actualizar();
                //echo print_r($_GET).'<br>';    
                $template = "lst";
                $hrefEdit = '?frm=' . $casoUso . '&amp;template=' . $template;
                $action = "../negocio/crud_" . $casoUso . ".php";
                $myHtml = new lst($casoUso, 'v_recorrido_producto', $label, $_GET, $hrefEdit, "", "", $action, $mySession);
                $myHtml->getLst();
                ?>
            </div>
            <div id="tabs-2">
                <?php
                $casoUso = "recorridoparte";
                $mySession->where[$casoUso]['where'] = 'id_recorrido=' . "'" . $id . "'";
                $mySession->actualizar();

                $template = "lst";
                $hrefEdit = '?frm=' . $casoUso . '&amp;template=' . $template;
                $action = "../negocio/crud_" . $casoUso . ".php";
                $myHtml = new lst($casoUso, 'v_recorridoparte', $label, $_GET, $hrefEdit, "", "", $action, $mySession);
                $myHtml->getLst();
                ?>
            </div>
            <div id="tabs-3">
                <?php
                $casoUso = "recorridoevaluacion";
                $mySession->where[$casoUso]['where'] = 'id_recorrido=' . "'" . $id . "'";
                $mySession->actualizar();

                $template = "lst";
                $hrefEdit = '?frm=' . $casoUso . '&amp;template=' . $template;
                $action = "../negocio/crud_" . $casoUso . ".php";
                $myHtml = new lst($casoUso, 'v_recorridoevaluacion', $label, $_GET, $hrefEdit, "", "", $action, $mySession);
                $myHtml->getLst();
                ?>
            </div>
        </div>
    </div>
    <?php
endif;
echo Utils::getDivClose();
?>
