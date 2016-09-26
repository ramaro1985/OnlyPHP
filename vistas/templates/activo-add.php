<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
// include the Zebra_Form class
require 'Zebra_Form.php';
include_once("controladores/grupo.class.php");
include_once("utiles/utils.class.php");
include_once("idioma/pt.php");
include_once("controladores/activo.class.php");
?>
<h2><?php
if (isset($_GET["id"]) && ($_GET["id"] == 0)) {
    echo $label["nuevo_activo"];
    //cargar los datos a modificar    
    $id = 0;
    $nombre_activo = '';
   
    $MM_from = 'guardar_nuevo';
} else {
    echo $label["modificar_activo"];
    //cargar los datos a modificar
    $MyObj = new Activo();
    $MyObj->getRecord($_GET["id"]);
    $aDatos = $MyObj->objConexion->crearArreglo();

    $id = $aDatos['id'];
    $nombre_activo = $aDatos['nombre_activo'];
    
    $MM_from = 'actualizar';
}
?></h2>
<?php
// instantiate a Zebra_Form object
$form = new Zebra_Form('form', 'POST', '../negocio/crud_activo.php');

//Nombre de la empresa
$form->add('label', 'label_nombre_activo', 'nombre_activo', $label["nombre_activo"]);

$obj = & $form->add('text', 'nombre_activo', $nombre_activo);

$obj->set_rule(array(
    'required' => array('error', $label["nombre_obligatorio"]),
));


// add the "hidden" field
$obj = & $form->add('hidden', 'MM_from', $MM_from);
$obj = & $form->add('hidden', 'id', $id);

// "submit"
$form->add('submit', 'btn_submit', $label["guardar"]);

// validate the form
if ($form->validate()) {

    // do stuff here
}

// auto generate output, labels to the left of form elements
$form->render('*horizontal');
?>