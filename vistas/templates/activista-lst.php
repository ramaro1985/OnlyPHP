<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
include_once("utiles/session.class.php");
$mySession = new Session();
include_once("utiles/lst.class.php");
include_once("idioma/pt.php");
include_once("controladores/usuario.class.php");
include_once("controladores/v_activista_buscar.class.php");

if (isset($_GET["error"]) && $_GET["error"] == 1) {
    if ($_GET["tipo_error"] == 'error_eliminar') {
        $error = $label["error_eliminar"] . $label["activista_eliminar"] . $label['seleccionado'];
    }
    echo Utils::getDivErrorLogin($error);
} else {
    echo Utils::getDivError($label["usuario_pass_incorrecto"]);
}

echo Utils::getDivTitulo($label["listado_actvista"]);
$casoUso = "activista";
$id_usuario_loguin = $mySession->obtenerVariable('idusuario');
$arrAcceso = $mySession->arrAcceso;
$id_grupo_gestion = $arrAcceso[0]['id_grupo_gestion'];

$ObjUsuario = new Usuarios();
$ObjUsuario->getRecords('id=' . "'$id_usuario_loguin'");
$aDatos = $ObjUsuario->objConexion->crearArreglo();
$id_activista = $aDatos['id_activista'];


if ($id_grupo_gestion != 2 && $id_activista != NULL) {

    $ObjActivista = new v_Actvista_buscar();
    $ObjActivista->getRecords('id=' . "'$id_activista'");
    $aDatos = $ObjActivista->objConexion->crearArreglo();
    $id_provincia = $aDatos['id_provincia'];

    $mySession->where[$casoUso]['where'] = 'id_provincia =' . "'$id_provincia'";
    $mySession->actualizar();
} else {
    $mySession->where[$casoUso]['where'] = 'id<>0';
    $mySession->actualizar();
}

$template = "lst";
$hrefEdit = '?frm=' . $casoUso . '&amp;template=' . $template;
$action = "../negocio/crud_" . $casoUso . ".php";
$myHtml = new lst($casoUso, 'v_Activista', $label, $_GET, $hrefEdit, "", "", $action, $mySession);
$myHtml->getLst();
?>