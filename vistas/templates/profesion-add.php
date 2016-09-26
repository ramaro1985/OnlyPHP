<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
// include the Zebra_Form class
$casoUso = 'profesion';
require 'Zebra_Form.php';
include_once("utiles/utils.class.php");
include_once("idioma/pt.php");
include_once("controladores/" . $casoUso . ".class.php");

if (isset($_GET["id"]) && ($_GET["id"] == 0)) {
    echo Utils::getDivTitulo($label["nueva_profesion"]);
    //cargar los datos a modificar    
    $id = 0;
    $profesion = '';

    $MM_from = 'guardar_nuevo';
} else {
    echo Utils::getDivTitulo($label["modificar_profesion"]);
    //cargar los datos a modificar
    $MyObj = new Profesiones();
    $MyObj->getRecord($_GET["id"]);
    $aDatos = $MyObj->objConexion->crearArreglo();

    $id = $aDatos['id'];
    $profesion = $aDatos['profesion'];

    $MM_from = 'actualizar';
}
echo Utils::getDivOpen();
if (isset($_GET["error"]) && $_GET["error"] == 1) {
    if ($_GET["tipo_error"] == 'insertar_update') {
        $error = $label["error_insertar_update"] . $label["profesion"] . $label['seleccionado'];
        echo Utils::getDivErrorLogin($error);
    }
} else {
    echo Utils::getDivError($label["usuario_pass_incorrecto"]);
}

// instantiate a Zebra_Form object
$form = new Zebra_Form('form', 'POST', '../negocio/crud_' . $casoUso . '.php');

//la etiqueta para el obj nombre de usuario
$form->add('label', 'label_profesion', 'profesion', $label["profesion"]);

//obj para el nombre del usuario
$obj = & $form->add('text', 'profesion', $profesion);

// set rules
$obj->set_rule(array(
    // error messages will be sent to a variable called "error", usable in custom templates
    'required' => array('error', $label["profesion_obligatorio"])
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