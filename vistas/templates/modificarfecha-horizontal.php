<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
// include the Zebra_Form class
$casoUso='modificar_fecha_electoral';
require 'Zebra_Form.php';
include_once("utiles/utils.class.php");
include_once("idioma/pt.php");
include_once("controladores/ubicacion_evento.class.php");

if (isset($_GET["error"]) && $_GET["error"] == 1) {
    if ($_GET["tipo_error"] == 'insertar_update') {
        $error = $label["fechas_incorrectas"] ;
        echo Utils::getDivErrorLogin($error);
    }
} else {
    echo Utils::getDivError($label["usuario_pass_incorrecto"]);
}
echo Utils::getDivTitulo($label["modificar_fecha_electoral"]);

//Pre-campanna
$pre_camp = new Ubicacion_evento();
$pre_camp->getRecords('id=1');
$aDatos_pre = $pre_camp->objConexion->crearArreglo();

$id_pre = $aDatos_pre['id'];
$ubicacion_evento_pre = $aDatos['ubicacion_evento'];
$fecha_inicio_pre = $aDatos_pre['fecha_inicio'];
$fecha_fin_pre = $aDatos_pre['fecha_fin'];


//En-campanna
$en_camp = new Ubicacion_evento();
$en_camp->getRecords('id=2');
$aDatos_en = $en_camp->objConexion->crearArreglo();

$id_en = $aDatos_en['id'];
$ubicacion_evento_en = $aDatos_en['ubicacion_evento'];
$fecha_inicio_en = $aDatos_en['fecha_inicio'];
$fecha_fin_en = $aDatos_en['fecha_fin'];


//Post-campanna
$post_camp = new Ubicacion_evento();
$post_camp->getRecords('id=3');
$aDatos_post = $post_camp->objConexion->crearArreglo();

$id_post = $aDatos_post['id'];
$ubicacion_evento_post = $aDatos_post['ubicacion_evento'];
$fecha_inicio_post = $aDatos_post['fecha_inicio'];
$fecha_fin_post = $aDatos_post['fecha_fin'];

$MM_from = 'actualizar';


// instantiate a Zebra_Form object
$form = new Zebra_Form('form', 'POST', '../negocio/crud_' . $casoUso . '.php');

$form->add('label', 'label_pre_campanna', 'pre_campanna', $label["pre_campanna"]);
$form->add('label', 'label_en_campanna', 'en_campanna', $label["en_campanna"]);
$form->add('label', 'label_post_campanna', 'post_campanna', $label["post_campanna"]);

$form->add('label', 'label_fecha_inicio_en', 'fecha_inicio_en', $label["fecha_inicio_en"]);
$form->add('label', 'label_fecha_inicio_pre', 'fecha_inicio_pre', $label["fecha_inicio_pre"]);

//Fecha de nacimiento
/*if ($fecha_inicio_pre != '') {
    $fecha_inicio_pre = split(' ', $fecha_inicio_pre);
}*/

$date = & $form->add('date', 'fecha_inicio_pre', $fecha_inicio_pre, array('style' => 'width:140px'));

$date->format('Y-m-d');

$date->set_rule(array(
    'date' => array('error', $label['fecha_nacimiento_incorrecta']),
    'required' => array('error', $label["campo_obligatorio"]),
));

$date = & $form->add('date', 'fecha_inicio_en', $fecha_inicio_en, array('style' => 'width:140px'));

$date->format('Y-m-d');

$date->set_rule(array(
    'date' => array('error', $label['fecha_nacimiento_incorrecta']),
    'required' => array('error', $label["campo_obligatorio"]),
));



$form->add('label', 'label_fecha_fin_en', 'fecha_fin_en', $label["fecha_fin_en"]);
$form->add('label', 'label_fecha_fin_pre', 'fecha_fin_pre', $label["fecha_fin_pre"]);

$date = & $form->add('date', 'fecha_fin_pre', $fecha_fin_pre , array('style' => 'width:140px'));

$date->format('Y-m-d');

$date->set_rule(array(
    'date' => array('error', $label['fecha_nacimiento_incorrecta']),
    'required' => array('error', $label["campo_obligatorio"]),
));

$date = & $form->add('date', 'fecha_fin_en', $fecha_fin_en, array('style' => 'width:140px'));

$date->format('Y-m-d');

$date->set_rule(array(
    'date' => array('error', $label['fecha_nacimiento_incorrecta']),
    'required' => array('error', $label["campo_obligatorio"]),
));

$obj = & $form->add('hidden', 'MM_from', $MM_from);

$form->add('submit_1', 'btn_submit', $label["guardar"]);
$form->render('custom-templates/custom-modificarfecha.php');
?>