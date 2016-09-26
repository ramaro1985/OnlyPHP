<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
$casoUso = 'trabajador';
require 'Zebra_Form.php';
include_once("utiles/utils.class.php");
include_once("idioma/pt.php");
include_once("controladores/cargotrabajo.class.php");
include_once("controladores/" . $casoUso . ".class.php");

if (isset($_GET["id"]) && ($_GET["id"] == 0)) {
    echo Utils::getDivTitulo($label["nuevo_trabajador"]);
    //cargar los datos a modificar    
    $id = 0;
    $id_cargo = 0;
    $nombre_apellido = '';
    $nro_identidad = '';
    $telefono = '';
    $correo = '';
    $sexo = '';

    $MM_from_trabajador = 'guardar_nuevo_trabajador';
} else {
    echo Utils::getDivTitulo($label["modificar_trabajador"]);
    //cargar los datos a modificar
    $MyObj = new Trabajador();
    $MyObj->getRecord($_GET["id"]);
    $aDatos = $MyObj->objConexion->crearArreglo();

    $id = $aDatos['id'];
    $id_cargo = $aDatos['id_cargo'];
    $nombre_apellido = $aDatos['nombre_apellido'];
    $nro_identidad = $aDatos['nro_identidad'];
    $telefono = $aDatos['telefono'];
    $correo = $aDatos['correo'];
    $sexo = $aDatos['sexo'];

    $MM_from_trabajador = 'actualizar_trabajador';
}
echo Utils::getDivOpen();
if (isset($_GET["error"]) && $_GET["error"] == 1) {
    if ($_GET["tipo_error"] == 'insertar_update') {
        $error = $label["error_insertar_update"] . $label["trabajador"] . $label['seleccionado'];
        echo Utils::getDivErrorLogin($error);
    }
} else {
    echo Utils::getDivError($label["usuario_pass_incorrecto"]);
}

// instantiate a Zebra_Form object
$form = new Zebra_Form('form', 'POST', '../negocio/crud_' . $casoUso . '.php');

// instantiate a Zebra_Form object
$form = new Zebra_Form('form', 'POST', '../negocio/crud_' . $casoUso . '.php');

$form->add('label', 'label_nombre_apellidos', 'nombre_apellido', $label["nombre_apellido"]);

$obj = & $form->add('text', 'nombre_apellido', $nombre_apellido,array('style' => 'width:300px'));

$obj->set_rule(array(
    // error messages will be sent to a variable called "error", usable in custom templates
    'required' => array('error', $label["trabajador_obligatorio"])
));

$form->add('label', 'label_id_cargo', 'id_cargo', $label["id_cargo"]);

$obj = & $form->add('select', 'id_cargo', $id_cargo, array('style' => 'width:310px'));

$objCargo = new Cargotrabajo();
$objCargo->getRecords();
$objDatos = $objCargo->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'cargo_trabajo', $label["seleccione_uno"]);

$obj->add_options($myArray, true);

$obj->set_rule(array(
    'required' => array('error', $label["trabajador_obligatorio"])
));

$form->add('label', 'label_nro_identidad', 'nro_identidad', $label["nro_identidad"]);

$obj = & $form->add('text', 'nro_identidad', $nro_identidad, array('style' => 'width:300px'));

$form->add('label', 'label_telefono', 'telefono', $label["telefono"]);

$obj = & $form->add('text', 'telefono', $telefono, array('style' => 'width:300px'));

$obj->set_rule(array(
    'digits' => array('error', $label["telefono_numeros"]),
));

$form->add('label', 'label_correo', 'correo', $label["correo"]);

$obj = & $form->add('text', 'correo', $correo, array('style' => 'width:300px'));

$obj->set_rule(array(
    'email' => array('error', $label["tipo_correo"]),
));

$form->add('label', 'label_sexo', 'sexo', $label['sexo']);

$obj = & $form->add('radios', 'sexo', array(
            'F' => 'Mujer',
            'M' => 'Hombre',
                ), array('checked' => $sexo));

$obj->set_rule(array(
    'required' => array('error', $label["sexo_obligatorio"])
));

$obj = & $form->add('hidden', 'MM_from_trabajador', $MM_from_trabajador);
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