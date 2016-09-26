<?php
include_once("utiles/session.class.php");
$mySession = new Session();
include_once("utiles/lst.class.php");
include_once("idioma/pt.php");
include_once("utiles/utils.class.php");

if (isset($_GET["error"]) && $_GET["error"] == 1) {
    if ($_GET["tipo_error"] == 'error_eliminar') {
        $error = $label["error_eliminar"] . $label["municipio"] . $label['seleccionado'];
        echo Utils::getDivErrorLogin($error);
    }
    
} else {
    echo Utils::getDivError($label["usuario_pass_incorrecto"]);
}

echo Utils::getDivTitulo($label["listado_municipio"]);

$casoUso = "municipio";
$template = "lst";
$hrefEdit = '?frm=' . $casoUso . '&amp;template=' . $template;
$action = "../negocio/crud_" . $casoUso . ".php";
$myHtml = new lst($casoUso, 'v_Municipios', $label, $_GET, $hrefEdit, "", "", $action,$mySession);
$myHtml->getLst();
?>