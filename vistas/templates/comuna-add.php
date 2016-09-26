<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
$casoUso = 'comuna';
require 'Zebra_Form.php';
include_once("utiles/utils.class.php");
include_once("idioma/pt.php");
include_once("controladores/provincia.class.php");
include_once("controladores/" . $casoUso . ".class.php");
include_once("controladores/v_comuna_buscar.class.php");
include_once("controladores/municipio.class.php");

if (isset($_GET["id"]) && ($_GET["id"] == 0)) {
    echo Utils::getDivTitulo($label["nueva_comuna"]);
    //cargar los datos a modificar    
    $id = 0;
    $id_provincia = 0;
    $id_municipio = 0;
    $comuna = '';

    $MM_from = 'guardar_nuevo';
} else {
    echo Utils::getDivTitulo($label["modificar_comuna"]);
    //cargar los datos a modificar
    $MyObj = new v_Comunas_Buscar();
    $MyObj->getRecord($_GET["id"]);
    $aDatos = $MyObj->objConexion->crearArreglo();

    $id = $aDatos['id'];
    $id_provincia = $aDatos['id_provincia'];
    $id_municipio = $aDatos['id_municipio'];
    $comuna = $aDatos['comuna'];

    $MM_from = 'actualizar';
}
echo Utils::getDivOpen();
if (isset($_GET["error"]) && $_GET["error"] == 1) {
    if ($_GET["tipo_error"] == 'insertar_update') {
        $error = $label["error_insertar_update"] . $label["comuna"] . $label['seleccionado'];
        echo Utils::getDivErrorLogin($error);
    }
} else {
    echo Utils::getDivError($label["usuario_pass_incorrecto"]);
}

// instantiate a Zebra_Form object
$form = new Zebra_Form('form', 'POST', '../negocio/crud_' . $casoUso . '.php');

// instantiate a Zebra_Form object
$form = new Zebra_Form('form', 'POST', '../negocio/crud_' . $casoUso . '.php',array('onsubmit' => 'return selectedIncluidos( document.getElementById(\'incluido\') );'));

// obj provincias
$form->add('label', 'label_id_provincia', 'id_provincia', $label["id_provincia"]);

$obj = & $form->add('select', 'id_provincia', $id_provincia, array(
            'onchange' => 'cargarDatosSelect(\'id_provincia\', \'id_municipio\',\''. $label["cargando"] .'\', \'Municipios\', \'id_provincia\', \'municipio\', 2);',
            'style' => 'width:150px'
        ));

$objProvincia = new Provincias();
$Datos = $objProvincia->getRecords();
$objDatos = $objProvincia->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'provincia', $label["seleccione_uno"]);

$obj->add_options($myArray, true);

//la etiqueta para el obj Municipios
$form->add('label', 'label_id_municipio', 'id_municipio', $label["id_municipio"]);

$obj = & $form->add('select', 'id_municipio', $id_municipio, array(
            'onchange' => 'cargarDatosSelect(\'id_municipio\', \'id_comuna\', \''. $label["cargando"] .'\', \'Comunas\', \'id_municipio\', \'comuna\', 2);',
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

//la etiqueta para el obj provincias
$form->add('label', 'label_comuna', 'comuna', $label["comuna"]);

//obj para el nombre del usuario
$obj = & $form->add('text', 'comuna', $comuna);

// set rules
$obj->set_rule(array(
    // error messages will be sent to a variable called "error", usable in custom templates
    'required' => array('error', $label["comuna_obligatorio"])
));

// add the "hidden" field
$obj = & $form->add('hidden', 'MM_from', $MM_from);
$obj = & $form->add('hidden', 'id', $id);

// "submit"
$form->add('submit_1', 'btn_submit', $label["guardar"]);

// validate the form
if ($form->validate()) {

    // do stuff here
}
// auto generate output, labels to the left of form elements
$form->render('*horizontal');
echo Utils::getDivClose();
?>