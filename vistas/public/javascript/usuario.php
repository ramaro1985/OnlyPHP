<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
include_once("controladores/usuario.class.php");

$usuario = $_GET["usuario"];
$clave = $_GET["clave"];
$clave_confirm = $_GET["clave_confirm"];

$nuevoUsuario = new Usuarios();
$nuevoUsuario->getRecords("lower(usuario)= lower('$usuario')");
$exist_usuario = $nuevoUsuario->objConexion->crearArreglo();

if (is_array($exist_usuario) && count($exist_usuario) > 0) {
    echo '<p id="div_error">El usuario seleccionado ya existe!</p>';
} else {
    if ($clave != $clave_confirm || $clave_confirm == '' || strlen($clave) <= 5) {
       echo '<p id="div_error">La claves deben ser iguales y tener un mínimo de 6 cáracteres!</p>';
    } else {
         echo 'true';
    }
}
?>