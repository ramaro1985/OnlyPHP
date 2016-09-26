<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require 'Zebra_Form.php';
include_once("utiles/utils.class.php");
include_once("idioma/pt.php");
include_once("controladores/provincia.class.php");
include_once("controladores/municipio.class.php");

//cargar los datos a modificar    
$id = 0;
$id_provincia = 0;
$id_municipio = 0;

// instantiate a Zebra_Form object
$form = new Zebra_Form('form', 'POST', '');

// obj provincias
$form->add('label', 'label_id_provincia', 'id_provincia', $label["id_provincia"]);

$obj = & $form->add('select', 'id_provincia', $id_provincia, array(
            'onchange' => 'cargarDatosSelect(\'id_provincia\', \'id_municipio\',\''. $label["cargando"] .'\', \'Municipios\', \'id_provincia\', \'municipio\', 2);',
            'style' => 'width:150px'
        ));

$objProvincia = new Provincias();
$Datos = $objProvincia->getRecords();
$objDatos = $objProvincia->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'provincia', $label["seleccione_uno"]);

$obj->add_options($myArray, true);

//la etiqueta para el obj Municipios
$form->add('label', 'label_id_municipio', 'id_municipio', $label["id_municipio"]);

$obj = & $form->add('select', 'id_municipio', $id_municipio, array(
            'onchange' => 'cargarRelatorioPorMunicipios(\'id_municipio\', \'div_fuente\');',
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

// add the "hidden" field
$obj = & $form->add('hidden', 'MM_from', $MM_from);
$obj = & $form->add('hidden', 'id', $id);

// validate the form
if ($form->validate()) {

    // do stuff here
}
// auto generate output, labels to the left of form elements
$form->render('custom-templates/custom-relatoriopormunicipios.php');
?>