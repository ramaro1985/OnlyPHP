<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
$casoUso = 'cargotrabajo';
$error = 0;
$tipo_error = '';
require 'Zebra_Form.php';
include_once("configuracion/configuracion.php");
include_once("acceso_datos/" . DRIVER_BD . "_acceso_datos.class.php");
include_once("utiles/session.class.php");
include_once("utiles/utils.class.php");
include_once("controladores/" . $casoUso . ".class.php");

if (isset($_GET["id"]) && ($_GET["id"] == 0)) {
    echo Utils::getDivTitulo($label["nuevo_cargotrabajo"]);
    //cargar los datos a modificar    
    $id = 0;
    $cargo_trabajo = '';

    $MM_from = 'guardar_nuevo';
} else {
    echo Utils::getDivTitulo($label["modificar_cargotrabajo"]);
    //cargar los datos a modificar
    $MyObj = new CargoTrabajo();
    $MyObj->getRecord($_GET["id"]);
    $aDatos = $MyObj->objConexion->crearArreglo();

    $id = $aDatos['id'];
    $cargo_trabajo = $aDatos['cargo_trabajo'];

    $MM_from = 'actualizar';
}
echo Utils::getDivOpen();

if (isset($_GET["error"]) && $_GET["error"] == 1) {
    if ($_GET["tipo_error"] == 'insertar_update') {
        $error = $label["error_insertar_update"] . $label["cargo_trabajo"] . $label['seleccionado'];
    }
    echo Utils::getDivErrorLogin($error);
} else {
    echo Utils::getDivError($label["usuario_pass_incorrecto"]);
}

// instantiate a Zebra_Form object
$form = new Zebra_Form('form', 'POST', '../negocio/crud_cargotrabajo.php');

//Nombre de la empresa
$form->add('label', 'label_cargo_trabajo', 'cargo_trabajo', $label["cargo_trabajo"]);

$obj = & $form->add('text', 'cargo_trabajo', $cargo_trabajo);

$obj->set_rule(array(
    'required' => array('error', $label["nombre_cargo_trabajo"]),
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
?>