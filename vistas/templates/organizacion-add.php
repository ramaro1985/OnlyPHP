<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));

$casoUso = 'organizacion';
require 'Zebra_Form.php';
include_once("utiles/utils.class.php");
include_once("idioma/pt.php");
include_once("controladores/" . $casoUso . ".class.php");

if (isset($_GET["id"]) && ($_GET["id"] == 0)) {
    echo Utils::getDivTitulo($label["nueva_organizacion"]);
    //cargar los datos a modificar    
    $id = 0;
    $org_partidista = '';
    $abreviatura = '';

    $MM_from = 'guardar_nuevo';
} else {
    echo Utils::getDivTitulo($label["modificar_organizacion"]);
    //cargar los datos a modificar
    $MyObj = new Organizaciones();
    $MyObj->getRecord($_GET["id"]);
    $aDatos = $MyObj->objConexion->crearArreglo();

    $id = $aDatos['id'];
    $org_partidista = $aDatos['org_partidista'];
    $abreviatura = $aDatos['abreviatura'];

    $MM_from = 'actualizar';
}
echo Utils::getDivOpen();
if (isset($_GET["error"]) && $_GET["error"] == 1) {
    if ($_GET["tipo_error"] == 'insertar_update') {
        $error = $label["error_insertar_update"] . $label["org_partidista"] . $label['seleccionado'];
        echo Utils::getDivErrorLogin($error);
    }
} else {
    echo Utils::getDivError($label["usuario_pass_incorrecto"]);
}

// instantiate a Zebra_Form object
$form = new Zebra_Form('form', 'POST', '../negocio/crud_' . $casoUso . '.php');

//la etiqueta para el obj nombre de usuario
$form->add('label', 'label_org_partidista', 'org_partidista', $label["org_partidista"]);

//obj para el nombre del usuario
$obj = & $form->add('text', 'org_partidista', $org_partidista);

// set rules
$obj->set_rule(array(
    // error messages will be sent to a variable called "error", usable in custom templates
    'required' => array('error', $label["org_partidista_obligatorio"])
));


$form->add('label', 'label_abreviatura', 'abreviatura', $label["abreviatura"]);

$obj = & $form->add('text', 'abreviatura', $abreviatura);

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