<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
$mySession = new Session();

include_once("utiles/lst.class.php");
include_once("idioma/pt.php");
include_once("utiles/utils.class.php");

echo Utils::getDivTitulo( $label["listado_proyecto"] );

$id_usuario_loguin = $mySession->obtenerVariable('idusuario');
$arrAcceso= $mySession->arrAcceso;
$id_grupo_gestion = $arrAcceso[0]['id_grupo_gestion'];
$casoUso = 'proyecto';

if ($id_grupo_gestion != 2) {
    $mySession->where[$casoUso]['where'] = 'id_usuario =' . "'$id_usuario_loguin'";
    $mySession->actualizar();
}else{
     $mySession->where[$casoUso]['where'] = 'id <> 0';
    $mySession->actualizar();
}

$template = "lst";
$hrefEdit = '?frm=' . $casoUso . '&amp;template=' . $template;
$action = "../negocio/crud_proyecto.php";
$myHtml = new lst($casoUso, 'v_proyecto', $label, $_GET, $hrefEdit, "", "", $action,$mySession);
$myHtml->getLst();

?>