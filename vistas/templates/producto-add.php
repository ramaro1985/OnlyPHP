<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
// include the Zebra_Form class
$casoUso = 'producto';
require 'Zebra_Form.php';
include_once("utiles/utils.class.php");
include_once("idioma/pt.php");
include_once("controladores/" . $casoUso . ".class.php");
include_once("utiles/utils.class.php");
include_once("idioma/pt.php");

if (isset($_GET["id"]) && ($_GET["id"] == 0)) {
    echo Utils::getDivTitulo($label["nuevo_producto"]);
    $id = 0;
    $nombre = '';
    $cantidad_producto = '';
    $precio_costo = '';
    $descripcion = '';

    $MM_from = 'guardar_nuevo';
} else {
    echo Utils::getDivTitulo($label["modificar_producto"]);
    $MyObj = new Producto();
    $MyObj->getRecord($_GET["id"]);
    $aDatos = $MyObj->objConexion->crearArreglo();

    $id = $aDatos['id'];
    $nombre = $aDatos['nombre'];
    $cantidad_producto = $aDatos['cantidad_producto'];
    $precio_costo = $aDatos['precio_costo'];
    $descripcion = $aDatos['descripcion'];

    $MM_from = 'actualizar';
}
echo Utils::getDivOpen();
if (isset($_GET["error"]) && $_GET["error"] == 1) {
    if ($_GET["tipo_error"] == 'insertar_update') {
        $error = $label["error_insertar_update"] . $label["producto"] . $label['seleccionado'];
        echo Utils::getDivErrorLogin($error);
    }
} else {
    echo Utils::getDivError($label["usuario_pass_incorrecto"]);
}

// instantiate a Zebra_Form object
$form = new Zebra_Form('form', 'POST', '../negocio/crud_producto.php');

//Nombre 
$form->add('label', 'label_nombre', 'nombre', $label["nombre"]);

$obj = & $form->add('text', 'nombre', $nombre);

$obj->set_rule(array(
    'required' => array('error', $label["nombre_obligatorio"]),
));

//Canitdiad
$form->add('label', 'label_cantidad_producto', 'cantidad_producto', $label["cantidad_producto"]);

$obj = & $form->add('text', 'cantidad_producto', $cantidad_producto);

$obj->set_rule(array(
    'digits' => array('error', $label["cantidad_producto_error"]),
));

//precio
$form->add('label', 'label_precio_costo', 'precio_costo', $label["precio_costo"]);

$obj = & $form->add('text', 'precio_costo', $precio_costo);

$obj->set_rule(array(
    'digits' => array('error', $label["cantidad_producto_error"]),
));

//obj descripcion del Producto
$form->add('label', 'label_descripcion', $descripcion, $label['descripcion']);

$obj = & $form->add('textarea', 'descripcion', $descripcion);

$obj->set_rule(array(
    'required' => array('error', $label["descripcion_obligatorio"]),
));


// add the "hidden" field
$obj = & $form->add('hidden', 'MM_from', $MM_from);
$obj = & $form->add('hidden', 'id', $id);

// "submit"
$form->add('submit_1', 'btn_submit', $label["guardar"]);

// auto generate output, labels to the left of form elements
$form->render('*horizontal');
echo Utils::getDivClose();
?>