<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));

$casoUso = 'recorridoevaluacion';
require 'Zebra_Form.php';
include_once("utiles/utils.class.php");
include_once("idioma/pt.php");
include_once("controladores/v_recorridoevaluacion_buscar.class.php");
include_once("controladores/tipoevaluacion.class.php");
include_once("controladores/" . $casoUso . ".class.php");

if (isset($_GET["id"]) && ($_GET["id"] == 0)) {
    echo Utils::getDivTitulo($label["nuevo_evaluacion"]);

    $id = 0;
    //$id_recorrido = 0;
    $id_tipo_evaluacion = 0;
    $id_fichero = 0;
    $descripcion = '';
    $fecha_evaluacion = '';
    
    $MM_from_eval= 'guardar_nuevo_eval';
} else {
    echo Utils::getDivTitulo($label["modificar_evaluacion"]);

    $MyObj = new v_Recorridoevaluacion_buscar();
    $MyObj->getRecord($_GET["id"]);
    $aDatos = $MyObj->objConexion->crearArreglo();

    $id = $aDatos['id'];
    $id_recorrido= $aDatos['id_recorrido'];
    $id_tipo_evaluacion = $aDatos['id_tipo_evaluacion'];
    $id_fichero = $aDatos['id_fichero'];
    $descripcion = $aDatos['descripcion'];
    $fecha_evaluacion = $aDatos['fecha_evaluacion'];
        
    $MM_from_eval= 'actualizar_eval';
}
echo Utils::getDivOpen();
if (isset($_GET["error"]) && $_GET["error"] == 1) {
    if ($_GET["tipo_error"] == 'insertar_update') {
        $error = $label["error_insertar_update"] . $label["recorrido"] . $label['seleccionado'];
        echo Utils::getDivErrorLogin($error);
    }
} else {
    echo Utils::getDivError($label["usuario_pass_incorrecto"]);
}
$form = new Zebra_Form('form', 'POST', '../negocio/crud_' . $casoUso . '.php');

//Recorridos

if ($fecha_evaluacion != '') {
    $fecha_evaluacion = split(' ', $fecha_evaluacion);
}
$form->add('label', 'label_fecha_evaluacion', 'fecha_evaluacion', $label["fecha_evaluacion"]);

$date = & $form->add('date', 'fecha_evaluacion', $fecha_evaluacion[0], array('style' => 'width:242px'));

$date->format('Y-m-d');

$date->set_rule(array(
    'required' => array('error', $label['fecha_nacimiento_obligatorio']),
    'date' => array('error', $label['fecha_nacimiento_incorrecta']),
));

$form->add('label', 'label_descripcion', 'descripcion', $label["descripcion"]);

$obj = & $form->add('textarea', 'descripcion', $descripcion, array('style' => 'width:250px'));

$obj->set_rule(array(
    'required' => array('error', $label["descripcion_obligatorio"])
));


$form->add('label', 'label_id_tipo_evaluacion', 'id_tipo_evaluacion', $label["id_tipo_evaluacion"]);

$obj = & $form->add('select', 'id_tipo_evaluacion', $id_tipo_evaluacion, array('style' => 'width:150px'));

$obj->set_rule(array(
    'required' => array('error', $label["provincia_obligatorio"])
));

$objtipo = new Tipoevaluacion();
$objtipo->getRecords();
$objDatos = $objtipo->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'tipo_evaluacion', $label["seleccione_uno"]);

$obj->add_options($myArray, true);

$obj = & $form->add('hidden', 'MM_from_eval', $MM_from_eval);
$obj = & $form->add('hidden', 'id', $id);

$form->add('submit_1', 'btn_submit', $label["guardar"]);
$form->render('*horizontal');
echo Utils::getDivClose();
?>