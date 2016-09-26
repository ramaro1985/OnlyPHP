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

echo Utils::getDivTitulo($label["listado_asamblea"]." ".$label["porconfimar"]);
$casoUso = "asamblea";
$cerrada = '1';
$confirmada = '1';

$id_usuario_loguin = $mySession->obtenerVariable('idusuario');
$arrAcceso = $mySession->arrAcceso;
$id_grupo_gestion = $arrAcceso[0]['id_grupo_gestion'];

if ($id_grupo_gestion == 2 || $id_grupo_gestion == 4) {
    $mySession->where[$casoUso]['where'] = 'cerrada =' . "'$cerrada'" . 'AND confirmada=' . "'$confirmada'";
    $mySession->actualizar();
}else{
    $ObjUsuario = new Usuarios();
    $ObjUsuario->getRecord($id_usuario_loguin);
    $aDatosUsuario = $ObjUsuario->objConexion->crearArreglo();
    
    $id_activista = $aDatosUsuario['id_activista'];
    
    $ObjActvista = new v_Activista();
    $ObjActvista->getRecord($id_activista);
    $aDatosAct= $ObjActvista->objConexion->crearArreglo();
    
    $provincia_act = $aDatosAct['provincia'];
    
    $mySession->where[$casoUso]['where'] = 'cerrada =' . "'$cerrada'" . 'AND confirmada=' . "'$confirmada'".'AND provincia='."'$provincia_act'";
    $mySession->actualizar();
}
$hrefEdit = '?frm=' . $casoUso . '&amp;template=lst';
$action = "../negocio/crud_" . $casoUso . ".php";
$myHtml = new lst($casoUso, 'v_asamblea', $label, $_GET, $hrefEdit, "", "", $action,$mySession);
$myHtml->getLst();
?>