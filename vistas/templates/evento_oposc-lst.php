<?php
include_once("utiles/session.class.php");
$mySession = new Session();
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
include_once("utiles/lst.class.php");
include_once("idioma/pt.php");
if (isset($_GET["error"]) && $_GET["error"] == 1) {
    if ($_GET["tipo_error"] == 'error_eliminar') {
        $error = $label["error_eliminar"] . $label["evento"] . $label['seleccionado'];
        echo Utils::getDivErrorLogin($error);
    }
} else {
    echo Utils::getDivError($label["usuario_pass_incorrecto"]);
}
echo Utils::getDivTitulo($label["evento_oposc"]);

$casoUso = "evento_mpla";
$template = "lst";

$mySession->where[$casoUso]['where'] = 'id_ubicacion_evento = 0';
$mySession->actualizar();
$mySession->registrarVariable('id_ubicacion_evento', 0);

$hrefEdit = '?frm=' . $casoUso . '&amp;template=lst';
$action = "../negocio/crud_" . $casoUso . ".php";
$myHtml = new lst($casoUso, 'v_evento_mpla', $label, $_GET, $hrefEdit, "", "", $action, $mySession);
$myHtml->getLst();
?>