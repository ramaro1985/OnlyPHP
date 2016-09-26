<?php
include_once("utiles/session.class.php");
$mySession = new Session();
include_once("utiles/lst.class.php");
include_once("idioma/pt.php");
include_once("utiles/utils.class.php");

if (isset($_GET["error"]) && $_GET["error"] == 1) {
    if ($_GET["tipo_error"] == 'error_eliminar') {
        $error = $label["error_eliminar"] . $label["cap"] . $label['seleccionado'];
        echo Utils::getDivErrorLogin($error);
    }
} else {
    echo Utils::getDivError($label["usuario_pass_incorrecto"]);
}

echo Utils::getDivTitulo($label["listado_cargo_trabajo"]);
$casoUso= "cargotrabajo";
$template= "lst";
$hrefEdit = '?frm='.$casoUso.'&amp;template='.$template;    
$action= "../negocio/crud_".$casoUso.".php";
$myHtml = new lst($casoUso, 'cargotrabajo', $label, $_GET, $hrefEdit, "", "", $action,$mySession);
$myHtml->getLst();
?>