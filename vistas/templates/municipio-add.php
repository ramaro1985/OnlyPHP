<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
// include the Zebra_Form class
$casoUso = 'municipio';
require 'Zebra_Form.php';
include_once("utiles/utils.class.php");
include_once("idioma/pt.php");
include_once("controladores/provincia.class.php");
include_once("controladores/" . $casoUso . ".class.php");
include_once("controladores/v_municipio_buscar.class.php");
include_once("controladores/municipio.class.php");

if (isset($_GET["id"]) && ($_GET["id"] == 0)) {
    echo Utils::getDivTitulo($label["nuevo_municipio"]);
    $id = 0;
    $id_provincia = 0;
    $municipio = '';
    $MM_from = 'guardar_nuevo';
} else {
    echo Utils::getDivTitulo($label["modificar_municipio"]);

    $MyObj = new v_Municipios_Buscar();
    $MyObj->getRecord($_GET["id"]);
    $aDatos = $MyObj->objConexion->crearArreglo();

    $id = $aDatos['id'];
    $id_provincia = $aDatos['id_provincia'];
    $municipio = $aDatos['municipio'];

    $MM_from = 'actualizar';
}
echo Utils::getDivOpen();
if (isset($_GET["error"]) && $_GET["error"] == 1) {
    if ($_GET["tipo_error"] == 'insertar_update') {
        $error = $label["error_insertar_update"] . $label["municipio"] . $label['seleccionado'];
        echo Utils::getDivErrorLogin($error);
    }
    
} else {
    echo Utils::getDivError($label["usuario_pass_incorrecto"]);
}

// instantiate a Zebra_Form object
$form = new Zebra_Form('form', 'POST', '../negocio/crud_' . $casoUso . '.php');

//la etiqueta para el obj provincias
$form->add('label', 'label_vincia', 'provincia', $label["provincia"]);

$obj = & $form->add('select', 'provincia', $id_provincia);

$objProvincia = new Provincias();
$Datos = $objProvincia->getRecords();
$objDatos = $objProvincia->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'provincia', $label["seleccione_uno"]);

$obj->add_options($myArray, true);

$obj->set_rule(array(
    'required' => array('error', $label["provincia_obligatorio"])
));

//la etiqueta para el obj provincias
$form->add('label', 'label_municipio', 'municipio', $label["municipio"]);

//obj para el nombre del usuario
$obj = & $form->add('text', 'municipio', $municipio);

// set rules
$obj->set_rule(array(
    // error messages will be sent to a variable called "error", usable in custom templates
    'required' => array('error', $label["municipio_obligatorio"])
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