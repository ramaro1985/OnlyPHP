

<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
// include the Zebra_Form class
$casoUso = "funciontrabajo";
require 'Zebra_Form.php';
include_once("controladores/grupo.class.php");
include_once("utiles/utils.class.php");
include_once("idioma/pt.php");
include_once("controladores/$casoUso.class.php");

if (isset($_GET["id"]) && ($_GET["id"] == 0)) {
    echo Utils::getDivTitulo($label["nuevo_funciontrabajo"]);
    //cargar los datos a modificar    
    $id = 0;
    $funcion_trabajo = '';
    $MM_from = 'guardar_nuevo';
} else {
    echo Utils::getDivTitulo($label["modificar_funciontrabajo"]);
    //cargar los datos a modificar
    $MyfuncionTrabajo = new Funciontrabajo();
    $MyfuncionTrabajo->getRecord($_GET["id"]);
    $aDatos = $MyfuncionTrabajo->objConexion->crearArreglo();

    $id = $aDatos['id'];
    $funcion_trabajo = $aDatos['funcion_trabajo'];
    $MM_from = 'actualizar';
}
echo Utils::getDivOpen();
if (isset($_GET["error"]) && $_GET["error"] == 1) {
    if ($_GET["tipo_error"] == 'insertar_update') {
        $error = $label["error_insertar_update"] . $label["estado_civil"] . $label['seleccionado'];
        echo Utils::getDivErrorLogin($error);
    }
} else {
    echo Utils::getDivError($label["usuario_pass_incorrecto"]);
}
// instantiate a Zebra_Form object
$form = new Zebra_Form('form', 'POST', '../negocio/crud_funciontrabajo.php');

//la etiqueta para el obj nombre de usuario
$form->add('label', 'label_funcion_trabajo', 'funcion_trabajo', $label["funcion_trabajo"]);

//obj para el nombre del usuario
$obj = & $form->add('text', 'funcion_trabajo', $funcion_trabajo);

// set rules
$obj->set_rule(array(
    // error messages will be sent to a variable called "error", usable in custom templates
    'required' => array('error', $label["funcion_trabajo_obligatorio"])
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