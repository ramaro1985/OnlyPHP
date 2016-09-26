<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
// include the Zebra_Form class
require 'Zebra_Form.php';
include_once("controladores/grupo.class.php");
include_once("utiles/utils.class.php");
include_once("idioma/pt.php");
include_once("utiles/session.class.php");
include_once("controladores/usuario.class.php");

echo Utils::getDivTitulo($label["editar_clave"]);

if (isset($_GET['id_usuario']) && $_GET['id_usuario'] != NULL) {

    $id_usuario = $_GET['id_usuario'];
    $editar_pass = 'existe';
} else {
    $editar_pass;
    $ObjSession = new Session();
    $id_usuario = $ObjSession->obtenerVariable('idusuario');
}


$MyUsuario = new Usuarios();
$MyUsuario->getRecord($id_usuario);
$aDatos = $MyUsuario->objConexion->crearArreglo();

$id = $aDatos['id'];
$usuario = $aDatos['usuario'];
$nombre_apellido = $aDatos['nombre_apellido'];
$clave = $aDatos['clave'];
($aDatos['habilitado'] != 't') ? $habilitado = 'false' : $habilitado = 'true';
$id_activista = $aDatos['id_activista'];

$MM_from = 'clave';

echo Utils::getDivOpen();

if (isset($_GET["error"]) && $_GET["error"] == 1) {
    if ($_GET["tipo_error"] == 'claves_distintas') {
        $error = $label["claves_distintas"];
        echo Utils::getDivErrorLogin($error);
    }
} elseif (isset($_GET["error"]) && $_GET["error"] == 2) {
    if ($_GET["tipo_error"] == 'claves_distintas_usuario') {
        $error = $label["claves_distintas_usuario"];
        echo Utils::getDivErrorLogin($error);
    }
} else {
    echo Utils::getDivError($label["usuario_pass_incorrecto"]);
}
// instantiate a Zebra_Form object
$form = new Zebra_Form('form', 'POST', '../negocio/crud_editarperfil.php');

$form->add('label', 'label_usuario', 'usuario', $label["usuario"]);
$obj = & $form->add('text', 'usuario', $usuario, array('readonly' => 'true'));

if ($editar_pass != 'existe') {
    //---------Old Clave
    $form->add('label', 'label_password', 'old_clave', $label["clave"]);
    $obj = & $form->add('password', 'old_clave');
    $obj->set_rule(array(
        'required' => array('error', $label["contrasena_obligatoria"]),
    ));
}


//--------New Clave
$form->add('label', 'label_new_clave', 'new_clave', $label["new_clave"]);
$obj = & $form->add('password', 'new_clave');
$obj->set_rule(array(
    'required' => array('error', $label["contrasena_obligatoria"]),
    'length' => array(6, 'error', $label["contrasena_minimo"]),
));

//--------Confirm Clave
$form->add('label', 'label_confirm_clave', 'confirm_clave', $label["confirm_clave"]);
$obj = & $form->add('password', 'confirm_clave');
$obj->set_rule(array(
    'required' => array('error', $label["contrasena_obligatoria"]),
    'length' => array(6, 'error', $label["contrasena_minimo"]),
));

$form->add('note', 'note_clave', 'clave', $label["contrasena_minimo"]);

$obj = & $form->add('hidden', 'MM_from', $MM_from);
$obj = & $form->add('hidden', 'id', $id);
$obj = & $form->add('hidden', 'nombre_completo', $nombre_apellido);
$obj = & $form->add('hidden', 'id_activista', $id_activista);
$obj = & $form->add('hidden', 'habilitado', $habilitado);
$obj = & $form->add('hidden', 'clave', $clave);
$obj = & $form->add('hidden', 'editar_pass', $editar_pass);

// "submit"
$form->add('submit', 'btn_submit', $label["guardar"]);

// validate the form
if ($form->validate()) {

    // do stuff here
}

$form->render('*horizontal');
echo Utils::getDivClose();
?>