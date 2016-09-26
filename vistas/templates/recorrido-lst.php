<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
include_once("utiles/session.class.php");
$mySession = new Session();
include_once("utiles/lst.class.php");
include_once("idioma/pt.php");

if (isset($_GET["error"]) && $_GET["error"] == 1) {
    if ($_GET["tipo_error"] == 'error_eliminar') {
        $error = $label["error_eliminar"] . $label["recorrido_eliminar"] . $label['seleccionado'];
    }
    echo Utils::getDivErrorLogin($error);
} else {
    echo Utils::getDivError($label["usuario_pass_incorrecto"]);
}

echo Utils::getDivTitulo($label["listado_recorrido"]);

$mySession->registrarVariable('empresa_activo',0);

$casoUso = "recorrido";

$id_usuario_loguin = $mySession->obtenerVariable('idusuario');
$arrAcceso= $mySession->arrAcceso;
$id_grupo_gestion = $arrAcceso[0]['id_grupo_gestion'];

if ($id_grupo_gestion != 2) {
    $mySession->where[$casoUso]['where'] = 'id_usuario =' . "'$id_usuario_loguin'";
    $mySession->actualizar();
}else{
    $mySession->where[$casoUso]['where'] = 'id<>0';
    $mySession->actualizar();
}

$template = "lst";
$hrefEdit = '?frm=' . $casoUso . '&amp;template=' . $template;
$action = "../negocio/crud_" . $casoUso . ".php";
$myHtml = new lst($casoUso, 'v_recorrido', $label, $_GET, $hrefEdit, "", "", $action, $mySession);
$myHtml->getLst();
?>