<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));

include_once("configuracion/configuracion.php");
include_once("acceso_datos/" . DRIVER_BD . "_acceso_datos.class.php");
include_once("utiles/session.class.php");
include_once("utiles/utils.class.php");
include_once("controladores/trabajador_proyecto.class.php");
//echo "GET -> ".print_r($_GET).'<br>';   
//echo "POST -> ".print_r($_POST).'<br>';   die();
$mySession = new Session();
//El caso de uso (usuario) --- accion --- clic en el boton guardar del formulario add (retorna al listado)
if ((isset($_POST["MM_from_proyecto_trabajador"])) && ($_POST["MM_from_proyecto_trabajador"] == "guardar_proyecto_trabajador")) {

    $nuevosTrabajador = new Trabajador_proyecto();
    $sqlDelete = "DELETE FROM trabajador_proyecto WHERE id_proyecto = " . $_POST['id'];
    $nuevosTrabajador->objConexion->realizarConsulta($sqlDelete);

    //Se procede a insertar los grupos nuevos o actualizados
    if ((isset($_POST['incluido'])) && ($_POST['incluido'] != "")) {
        foreach ($_POST['incluido'] as $item) {
            $dataInsert = array($_POST['id'], $item);
            $nuevosTrabajador->insertRecord($dataInsert);
        }
    }
    $arrGet = $mySession->arrFiltro;
    $arrGet['frm'] = 'proyecto';
    $arrGet['template'] = 'add';
    $arrGet['id'] = $_POST['id'];
    $url = Utils::construirURL($arrGet);
    header("Location: ../vistas/index.php" . $url);
    exit();
}
?>