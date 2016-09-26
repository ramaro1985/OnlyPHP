<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
include_once("configuracion/configuracion.php");
include_once("acceso_datos/" . DRIVER_BD . "_acceso_datos.class.php");
include_once("utiles/session.class.php");

$mySession = new Session();
$mySession->cerrar(); 

header("Location: ../vistas/index.php?frm=login&template=horizontal&error=4");
?>