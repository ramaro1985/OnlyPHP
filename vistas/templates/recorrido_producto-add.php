<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
// include the Zebra_Form class
$casoUso = 'recorrido_producto';
require 'Zebra_Form.php';
include_once("utiles/utils.class.php");
include_once("idioma/pt.php");
include_once("controladores/" . $casoUso . ".class.php");
include_once("controladores/v_recorrido_producto.class.php");
include_once("controladores/v_recorrido_producto_buscar.class.php");
include_once("controladores/producto.class.php");

if (isset($_GET["id"]) && ($_GET["id"] == 0)) {
    echo Utils::getDivTitulo($label["add_producto_recorrido"]);
    $id = 0;
    $id_recorrido = $mySession->obtenerVariable('id_recorrido');
    $id_producto = 0;
    $cantidad_producto = 0;

    $MM_from_producto_recorrido = 'guardar_nuevo_producto_recorrido';
} else {
    echo Utils::getDivTitulo($label["modificar_producto_recorrido"]);

    $MyObj = new v_Recorrido_producto_buscar();
    $MyObj->getRecord($_GET["id"]);
    $aDatos = $MyObj->objConexion->crearArreglo();
    $id = $aDatos['id'];
    $nombre = $aDatos['nombre'];
    $id_recorrido = $aDatos['id_recorrido'];
    $id_producto = $aDatos['id_producto'];
    $cantidad_producto = $aDatos['cantidad_producto'];

    $MM_from_producto_recorrido = 'actualizar_producto_recorrido';
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
$form = new Zebra_Form('form', 'POST', '../negocio/crud_' . $casoUso . '.php');

if ($id == 0) {
    $form->add('label', 'label_nombre', 'nombre', $label["nombre"]);

    $obj = & $form->add('select', 'nombre', $nombre, array('style' => 'width:210px'));

    $nombre_producto = new Producto();
    $sqlDisponibles = "SELECT id, nombre FROM nmproducto WHERE nmproducto.id NOT IN ";
    $sqlDisponibles .= " ( SELECT id_producto FROM recorrido_producto WHERE recorrido_producto.id_recorrido = " . $id_recorrido . ")";
    $Datos = $nombre_producto->objConexion->realizarConsulta($sqlDisponibles);
    $objDatos = $nombre_producto->objConexion->crearArregloObjetos();
    $myArray = Utils::getArrayForSelect($objDatos, 'id', 'nombre',$label["seleccione_uno"]);

    $obj->add_options($myArray, true);

    $obj->set_rule(array(
        'required' => array('error', $label["producto_recorrido_obligatorio"])
    ));
} else {
    $form->add('label', 'label_nombre', 'nombre', $label["nombre"]);
    $obj = & $form->add('text', 'nombre', $nombre, array('readonly' => 'true'));
}


$form->add('label', 'label_cantidad_producto', 'cantidad_producto', $label["cantidad_producto"]);

$obj = & $form->add('text', 'cantidad_producto', $cantidad_producto);

// set rules
$obj->set_rule(array(
    'required' => array('error', $label["cantidad_producto_obligatorio"]),
    'digits' => array('error', $label["telefono_numeros"]),
));

// add the "hidden" field
$obj = & $form->add('hidden', 'MM_from_producto_recorrido', $MM_from_producto_recorrido);
$obj = & $form->add('hidden', 'id', $id);
$obj = & $form->add('hidden', 'id_producto', $id_producto);
$obj = & $form->add('hidden', 'id_recorrido', $id_recorrido);

// "submit"
$form->add('submit_1', 'btn_submit', $label["guardar"]);

$form->render('*horizontal');
echo Utils::getDivClose();
?>