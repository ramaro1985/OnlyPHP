<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
// include the Zebra_Form class
$casoUso = 'dialecto';
require 'Zebra_Form.php';
include_once("utiles/utils.class.php");
include_once("idioma/pt.php");
include_once("controladores/" . $casoUso . ".class.php");
include_once("controladores/v_dialecto.class.php");
include_once("controladores/dialecto.class.php");

if (isset($_GET["id"]) && ($_GET["id"] == 0)) {
    echo Utils::getDivTitulo($label["nuevo_dialecto"]);
    //cargar los datos a modificar    
    $id = 0;
    $dialecto ='';
   
    $MM_from = 'guardar_nuevo';
} else {
    echo Utils::getDivTitulo($label["modificar_dialecto"]);
    //cargar los datos a modificar
    $MyObj = new v_Dialecto();
    $MyObj->getRecord($_GET["id"]);
    $aDatos = $MyObj->objConexion->crearArreglo();

    $id = $aDatos['id'];
    $dialecto =$aDatos['dialecto'];

    $MM_from = 'actualizar';
}
echo Utils::getDivOpen();
if (isset($_GET["error"]) && $_GET["error"] == 1) {
    if ($_GET["tipo_error"] == 'insertar_update') {
        $error = $label["error_insertar_update"] . $label["dialecto"] . $label['seleccionado'];
    }
    echo Utils::getDivErrorLogin($error);
} else {
    echo Utils::getDivError($label["usuario_pass_incorrecto"]);
}


// instantiate a Zebra_Form object
$form = new Zebra_Form('form', 'POST', '../negocio/crud_' . $casoUso . '.php');


$form->add('label', 'label_dialecto', 'dialecto', $label["dialecto"]);
$obj = & $form->add('text', 'dialecto', $dialecto);

// set rules
$obj->set_rule(array(
    'required' => array('error', $label["dialecto_obligatorio"])
));

// add the "hidden" field
$obj = & $form->add('hidden', 'MM_from', $MM_from);
$obj = & $form->add('hidden', 'id', $id);

// "submit"
$form->add('submit_1', 'btn_submit', $label["guardar"]);

$form->render('*horizontal');
echo Utils::getDivClose();
?>