<?php
$casoUso = "funcionmesa";
require 'Zebra_Form.php';
include_once("controladores/grupo.class.php");
include_once("utiles/utils.class.php");
include_once("idioma/pt.php");
include_once("controladores/$casoUso.class.php");

if (isset($_GET["id"]) && ($_GET["id"] == 0)) {
    echo Utils::getDivTitulo($label["nuevo_funcionmesa"]);
    //cargar los datos a modificar    
     $id = 0;
    $funcion_mesa = '';
    $MM_from = 'guardar_nuevo';
} else {
    echo Utils::getDivTitulo($label["modificar_funcionmesa"]);
    //cargar los datos a modificar
    $MyfuncionMesa = new Funcionmesa();
    $MyfuncionMesa->getRecord($_GET["id"]);
    $aDatos = $MyfuncionMesa->objConexion->crearArreglo();

    $id = $aDatos['id'];
    $funcion_mesa = $aDatos['funcion_mesa'];

    $MM_from = 'actualizar';
}
echo Utils::getDivOpen();
if (isset($_GET["error"]) && $_GET["error"] == 1) {
    if ($_GET["tipo_error"] == 'insertar_update') {
        $error = $label["error_insertar_update"] . $label["id_funcion_mesa"] . $label['seleccionado'];
        echo Utils::getDivErrorLogin($error);
    }
} else {
    echo Utils::getDivError($label["usuario_pass_incorrecto"]);
}


// instantiate a Zebra_Form object
$form = new Zebra_Form('form', 'POST', '../negocio/crud_funcionmesa.php');

//la etiqueta para el obj nombre de usuario
$form->add('label', 'label_funcion_mesa', 'funcion_mesa', $label["funcion_mesa"]);

//obj para el nombre del usuario
$obj = & $form->add('text', 'funcion_mesa', $funcion_mesa);

// set rules
$obj->set_rule(array(
    // error messages will be sent to a variable called "error", usable in custom templates
    'required' => array('error', $label["funcion_mesa_obligatorio"])
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