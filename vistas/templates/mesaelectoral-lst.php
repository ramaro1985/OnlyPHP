<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
include_once("utiles/session.class.php");
$mySession = new Session();
include_once("utiles/lst.class.php");
include_once("idioma/pt.php");
include_once("utiles/utils.class.php");


echo Utils::getDivError($label["usuario_pass_incorrecto"]);
echo Utils::getDivTitulo($label["listado_mesaelectoral"]);
$casoUso = "mesaelectoral";

$mySession->where[$casoUso]['where'] = 'id<>0';
$mySession->actualizar();

$mySession->registrarVariable('id_asamblea', NULL);

$template = "lst";
$hrefEdit = '?frm=' . $casoUso . '&amp;template=' . $template;
$action = "../negocio/crud_" . $casoUso . ".php";
$myHtml = new lst($casoUso, 'v_mesaelectoral', $label, $_GET, $hrefEdit, "", "", $action, $mySession);
$myHtml->getLst();
?>