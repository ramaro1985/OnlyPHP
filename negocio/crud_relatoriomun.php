<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));

include_once("configuracion/configuracion.php");
include_once("acceso_datos/" . DRIVER_BD . "_acceso_datos.class.php");
include_once("utiles/session.class.php");
include_once("utiles/utils.class.php");

$mySession = new Session();

if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "buscar")) {

   // echo $_POST["id_provincia"];
   // echo $_POST["id_municipio"];
   // echo $_POST["id_comuna"];
   
}
?>