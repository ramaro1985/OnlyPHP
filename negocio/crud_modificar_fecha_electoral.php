<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
$error = 0;
$tipo_error = '';

include_once("configuracion/configuracion.php");
include_once("acceso_datos/" . DRIVER_BD . "_acceso_datos.class.php");
include_once("utiles/session.class.php");
include_once("utiles/utils.class.php");
include_once("controladores/ubicacion_evento.class.php");

$mySession = new Session();
//echo "GET -> ".print_r($_GET).'<br>';   
//echo "POST -> ".print_r($_POST).'<br>';   
//El caso de uso (usuario) --- accion --- buscar
//El caso de uso (usuario) --- accion --- clic en el boton guardar del formulario add (retorna al listado)
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "actualizar")) {

    $arrGet = $mySession->arrFiltro;
    $arrGet['frm'] = 'modificarfecha';
    $arrGet['template'] = 'horizontal';
    $url = Utils::construirURL($arrGet);

    if (strtotime($_POST['fecha_inicio_pre']) > strtotime($_POST['fecha_fin_pre']) || strtotime($_POST['fecha_fin_pre']) > strtotime($_POST['fecha_inicio_en']) || strtotime($_POST['fecha_inicio_en']) > strtotime($_POST['fecha_fin_en'])) {

        $error = 1;
        $tipo_error = 'insertar_update';
        $arrGet = $mySession->arrFiltro;

        $arrGet = $mySession->arrFiltro;
        $arrGet['frm'] = 'modificarfecha';
        $arrGet['template'] = 'horizontal';
        $arrGet['error'] = $error;
        $arrGet['tipo_error'] = $tipo_error;
    } else {

        $Obj = new Ubicacion_evento();
        $str_pre = array('Pre-campña', $_POST['fecha_inicio_pre'], $_POST['fecha_fin_pre']);
        $str_en= array('En-campña', $_POST['fecha_inicio_en'], $_POST['fecha_fin_en']);
        $str_post= array('Post-campña', $_POST['fecha_fin_en'], $_POST['fecha_fin_en']);
        
        
        $Obj->updateRecord('1', $str_pre);
        $Obj->updateRecord('2', $str_en);
        $Obj->updateRecord('3', $str_post);
    }

    $url = Utils::construirURL($arrGet);
    header("Location: ../vistas/index.php" . $url);
    exit();
}
?>