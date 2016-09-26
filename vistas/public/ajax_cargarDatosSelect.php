<?php

//$_GET['id']  id del padre para filtrar
//$_GET['cf']  nombre del campo para filtrar
//$_GET['cu']  Caso de uso por a cargar
//$_GET['cn']  Nombre de la clase que necesito incluir
//$_GET['in']  Nombre de la clase que necesito incluir
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
include_once("configuracion/configuracion.php");
include_once("acceso_datos/" . DRIVER_BD . "_acceso_datos.class.php");
include_once("controladores/" . $_GET['cu'] . ".class.php");
include_once("controladores/v_proyectoempresa.class.php");
include_once("idioma/pt.php");

$claseName = ucwords($_GET['cn']);
$obj = new $claseName;
$srt = $_GET['cf'] . '=' . $_GET['id'];
$objDatos = $obj->getRecords($srt);
$objDatos = $obj->objConexion->crearArregloReporte();
$resultString = '<option value="">' . $label["seleccione_uno"] . '</option>';

(isset($_GET['in'])) ? $index = $_GET['in'] : $index = 2;

if ($index == 2) {
    $valor = 0;
} else {
    $valor = 2;
}
if (is_array($objDatos) && count($objDatos) > 0) {
    for ($i = 1; $i < count($objDatos); $i++) {
        $resultString.= '<option value="' . $objDatos[$i][$valor] . '">' . utf8_encode($objDatos[$i][$index]) . '</option>';
    }
}
echo $resultString;
?>