<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
// include the Zebra_Form class
$casoUso = 'organizacion_enevento';
require 'Zebra_Form.php';
include_once("utiles/utils.class.php");
include_once("idioma/pt.php");
include_once("controladores/" . $casoUso . ".class.php");

if (isset($_GET["id"]) && ($_GET["id"] == 0)) {
    echo Utils::getDivTitulo($label["nueva_organizacion"]);
    //cargar los datos a modificar    
    $id = 0;
    $nombre_organizacion = '';
    $abreviatura = '';

    $MM_from = 'guardar_nuevo';
} else {
    echo Utils::getDivTitulo($label["modificar_organizacion"]);
    //cargar los datos a modificar
    $MyObj = new Organizacion_enevento();
    $MyObj->getRecord($_GET["id"]);
    $aDatos = $MyObj->objConexion->crearArreglo();

    $id = $aDatos['id'];
    $nombre_organizacion = $aDatos['nombre_organizacion'];
    $abreviatura = $aDatos['abreviatura'];

    $MM_from = 'actualizar';
}
echo Utils::getDivOpen();
if (isset($_GET["error"]) && $_GET["error"] == 1) {
    if ($_GET["tipo_error"] == 'insertar_update') {
        $error = $label["error_insertar_update"] . $label["org_partidista"] . $label['seleccionado'];
    }
    echo Utils::getDivErrorLogin($error);
} else {
    echo Utils::getDivError($label["usuario_pass_incorrecto"]);
}


// instantiate a Zebra_Form object
$form = new Zebra_Form('form', 'POST', '../negocio/crud_' . $casoUso . '.php');


//la etiqueta para el obj nombre_organizacion
$form->add('label', 'label_nombre_organizacion', 'nombre_organizacion', $label["nombre_organizacion"]);

//obj para el nombre del usuario
$obj = & $form->add('text', 'nombre_organizacion', $nombre_organizacion);

// set rules
$obj->set_rule(array(
    // error messages will be sent to a variable called "error", usable in custom templates
    'required' => array('error', $label["nombre_organizacion_obligatorio"])
));


//la etiqueta para el obj abrevitura
$form->add('label', 'label_abreviatura', 'abreviatura', $label["abreviatura"]);

//obj para el nombre del usuario
$obj = & $form->add('text', 'abreviatura', $abreviatura);

// set rules
$obj->set_rule(array(
    // error messages will be sent to a variable called "error", usable in custom templates
    'required' => array('error', $label["nombre_organizacion_obligatorio"])
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