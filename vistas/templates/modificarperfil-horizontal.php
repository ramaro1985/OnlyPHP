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


echo Utils::getDivTitulo($label["editar_perfil"]);

$ObjSession = new Session();
$id_usuario = $ObjSession->obtenerVariable('idusuario');

$MyUsuario = new Usuarios();
$MyUsuario->getRecord($id_usuario);
$aDatos = $MyUsuario->objConexion->crearArreglo();

$id = $aDatos['id'];
$usuario = $aDatos['usuario'];
$nombre_apellido = $aDatos['nombre_apellido'];
$clave = $aDatos['clave'];
($aDatos['habilitado'] != 't') ? $habilitado = 'false' : $habilitado = 'true';
$id_activista = $aDatos['id_activista'];

$MM_from = 'actualizar';

echo Utils::getDivOpen();

// instantiate a Zebra_Form object
$form = new Zebra_Form('form', 'POST', '../negocio/crud_editarperfil.php');

$form->add('label', 'label_usuario', 'usuario', $label["usuario"]);
$obj = & $form->add('text', 'usuario', $usuario, array('readonly' => 'true'));

$form->add('label', 'label_nombre_completo', 'nombre_completo', $label["nombre_completo"]);
$obj = & $form->add('text', 'nombre_completo', $nombre_apellido, array('style' => 'width:300px'));
$obj->set_rule(array(
    'required' => array('error', $label["nombre_completo_obligatorio"]),
));


$obj = & $form->add('hidden', 'MM_from', $MM_from);
$obj = & $form->add('hidden', 'id', $id);
$obj = & $form->add('hidden', 'id_activista', $id_activista);
$obj = & $form->add('hidden', 'pass', $clave);
$obj = & $form->add('hidden', 'habilitado', $habilitado);

// "submit"
$form->add('submit', 'btn_submit', $label["guardar"]);
$form->add('submit', 'redirect_password', $label["redirect_password"]);
// validate the form
if ($form->validate()) {

    // do stuff here
}

//$form->render('*horizontal');
$form->render('custom-templates/custom-editarperfil.php');
echo Utils::getDivClose();
?>