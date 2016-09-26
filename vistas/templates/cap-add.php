<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
// include the Zebra_Form class
$casoUso = 'cap';
require 'Zebra_Form.php';
include_once("utiles/utils.class.php");
include_once("idioma/pt.php");
include_once("controladores/" . $casoUso . ".class.php");
include_once("controladores/v_cap_buscar.class.php");
include_once("controladores/comuna.class.php");
include_once("controladores/provincia.class.php");
include_once("controladores/municipio.class.php");

if (isset($_GET["id"]) && ($_GET["id"] == 0)) {
    echo Utils::getDivTitulo($label["nuevo_cap"]);
    //cargar los datos a modificar    
    $id = 0;
    $id_provincia = 0;
    $id_municipio = 0;
    $id_comuna = 0;
    $cap = '';

    $MM_from = 'guardar_nuevo';
} else {
    echo Utils::getDivTitulo($label["modificar_cap"]);
    //cargar los datos a modificar
    $MyObj = new v_Cap_Buscar();
    $MyObj->getRecord($_GET["id"]);
    $aDatos = $MyObj->objConexion->crearArreglo();

    $id = $aDatos['id'];
    $id_provincia = $aDatos['id_provincia'];
    $id_municipio = $aDatos['id_municipio'];
    $id_comuna = $aDatos['id_comuna'];
    $cap = $aDatos['cap'];

    $MM_from = 'actualizar';
}
echo Utils::getDivOpen();
if (isset($_GET["error"]) && $_GET["error"] == 1) {
    if ($_GET["tipo_error"] == 'insertar_update') {
        $error = $label["error_insertar_update"] . $label["cap"] . $label['seleccionado'];
    }
    echo Utils::getDivErrorLogin($error);
} else {
    echo Utils::getDivError($label["usuario_pass_incorrecto"]);
}


// instantiate a Zebra_Form object
$form = new Zebra_Form('form', 'POST', '../negocio/crud_' . $casoUso . '.php');

// obj provincias
$form->add('label', 'label_id_provincia', 'id_provincia', $label["provincia"]);

$obj = & $form->add('select', 'id_provincia', $id_provincia, array(
            'onchange' => 'cargarDatosSelect(\'id_provincia\', \'id_municipio\',\''. $label["cargando"] .'\', \'Municipios\', \'id_provincia\', \'municipio\', 2);',
            'style' => 'width:150px'
        ));

$objProvincia = new Provincias();
$Datos = $objProvincia->getRecords();
$objDatos = $objProvincia->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'provincia', $label["seleccione_uno"]);

$obj->add_options($myArray, true);

$obj->set_rule(array(
    'required' => array('error', $label["provincia_obligatorio"])
));


//la etiqueta para el obj Municipios
$form->add('label', 'label_id_municipio', 'id_municipio', $label["municipio"]);

$obj = & $form->add('select', 'id_municipio', $id_municipio, array(
            'onchange' => 'cargarDatosSelect(\'id_municipio\', \'id_comuna\', \''. $label["cargando"] .'\', \'Comunas\', \'id_municipio\', \'comuna\', 2);',
            'style' => 'width:150px'
        ));

if ($id > 0) {
    $objMunicipio = new Municipios();
    $Datos = $objMunicipio->getRecords('id_provincia=' . $id_provincia);
    $objDatos = $objMunicipio->objConexion->crearArregloObjetos();
    $myArray = Utils::getArrayForSelect($objDatos, 'id', 'municipio', $label["seleccione_uno"]);

    $obj->add_options($myArray, true);
} else {
    $obj->add_options(array('' => $label["seleccione_uno"]), true);
};
$obj->set_rule(array(
    'required' => array('error', $label["municipio_obligatorio"])
));

// obj Comunas
$form->add('label', 'label_id_comuna', 'id_comuna', $label["comuna"]);

$obj = & $form->add('select', 'id_comuna', $id_comuna, array(
            'onchange' => 'cargarDatosSelect(\'id_comuna\', \'id_cap\', \''. $label["cargando"] .'\', \'Cap\', \'id_comuna\', \'cap\', 2);',
            'style' => 'width:150px'
        ));

if ($id > 0) {
    $objComuna = new Comunas();
    $Datos = $objComuna->getRecords('id_municipio=' . $id_municipio);
    $objDatos = $objComuna->objConexion->crearArregloObjetos();
    $myArray = Utils::getArrayForSelect($objDatos, 'id', 'comuna', $label["seleccione_uno"]);

    $obj->add_options($myArray, true);
} else {
    $obj->add_options(array('' => $label["seleccione_uno"]), true);
}
$obj->set_rule(array(
    'required' => array('error', $label["comuna_obligatorio"])
));


//la etiqueta para el obj provincias
$form->add('label', 'label_cap', 'cap', $label["cap"]);

//obj para el nombre del usuario
$obj = & $form->add('text', 'cap', $cap);

// set rules
$obj->set_rule(array(
    // error messages will be sent to a variable called "error", usable in custom templates
    'required' => array('error', $label["cap_obligatorio"])
));

// add the "hidden" field
$obj = & $form->add('hidden', 'MM_from', $MM_from);
$obj = & $form->add('hidden', 'id', $id);

// "submit"
$form->add('submit_1', 'btn_submit', $label["guardar"]);
//$form->add('submit', 'cancelar', $label["cancelar"]);



// auto generate output, labels to the left of form elements
$form->render('*horizontal');
echo Utils::getDivClose();
?>