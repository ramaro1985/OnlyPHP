<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
$mySession = new Session();
include_once("utiles/session.class.php");

require 'Zebra_Form.php';
include_once("utiles/utils.class.php");
include_once("idioma/pt.php");
include_once("utiles/lst.class.php");
include_once("controladores/" . $casoUso . ".class.php");
include_once("controladores/cap.class.php");
include_once("controladores/comuna.class.php");
include_once("controladores/provincia.class.php");
include_once("controladores/municipio.class.php");
echo Utils::getDivTitulo('Relatorio-Municipios');
echo Utils::getDivOpen();
if (isset($_GET["error"]) && $_GET["error"] == 1) {
    if ($_GET["tipo_error"] == 'insertar_update') {
        $error = $label["error_insertar_update"] . $label["asamblea"] . $label['seleccionado'];
    }
    echo Utils::getDivErrorLogin($error);
} else {
    echo Utils::getDivError($label["usuario_pass_incorrecto"]);
}
$MM_from = 'buscar';
// instantiate a Zebra_Form object
$form = new Zebra_Form();

// obj provincias
$form->add('label', 'label_id_provincia', 'id_provincia', $label["provincia"]);
$obj = & $form->add('select', 'id_provincia', $id_provincia, array(
            'onchange' => 'cargarDatosSelect(\'id_provincia\', \'id_municipio\',\'' . $label["cargando"] . '\', \'Municipios\', \'id_provincia\', \'municipio\', 2);',
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
$obj = & $form->add('select', 'id_municipio', $id_municipio, array('style' => 'width:150px'));

$objMunicipio = new Municipios();
$Datos = $objMunicipio->getRecords('id_provincia=' . $id_provincia);
$objDatos = $objMunicipio->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'municipio', $label["seleccione_uno"]);
$obj->add_options($myArray, true);

$obj->set_rule(array(
    'required' => array('error', $label["municipio_obligatorio"])
));

$obj = & $form->add('hidden', 'MM_from', $MM_from);
$obj = &$form->add('button', 'my_button', 'Click me!', array('onclick' =>'return selectedIncluidos( document.getElementById(\'zon_mun\') );'));
$form->render('custom-templates/custom-relatoriomun.php');
?>
<?php echo Utils::getDivClose(); ?>
