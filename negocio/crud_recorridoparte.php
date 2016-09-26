<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
include_once("utiles/session.class.php");
$mySession = new Session();

$casoUso = 'recorridoparte';
$error = 0;
$tipo_error = '';

include_once("configuracion/configuracion.php");
include_once("acceso_datos/" . DRIVER_BD . "_acceso_datos.class.php");
include_once("utiles/utils.class.php");
include_once("controladores/" . $casoUso . ".class.php");


//echo "GET -> ".print_r($_GET).'<br>';   
//echo "POST -> ".print_r($_POST).'<br>';   die();
//El caso de uso (usuario) --- accion --- buscar
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "buscar")) {
    $arrGet = Utils::arrayRecibePOST($_POST['arrGet']);
    $url = Utils::construirURLdeARRAY($_POST, $arrGet, 'arrGet', 'MM_from_recorrido_parte');
    header("Location: ../vistas/index.php" . $url);
    exit();
}

//El caso de uso (usuario) --- accion --- clic en el boton insertar del listado (llamada al formulario add)
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "insertar")) {
    unset($mySession->arrFiltro['error']);
    unset($mySession->arrFiltro['tipo_error']);
    $mySession->actualizar();
    header("Location: ../vistas/index.php?frm=" . $casoUso . '&template=add&id=0');
    exit();
}

//El caso de uso (usuario) --- accion --- clic en el boton guardar del formulario add (retorna al listado)
if ((isset($_POST["MM_from_recorrido_parte"])) && ($_POST["MM_from_recorrido_parte"] == "guardar_nuevo_recorrido_parte")) {
    $arrGet = $mySession->arrFiltro;
    $arrGet['frm'] = 'recorrido';
    $arrGet['template'] = 'add';
    $arrGet['id'] = $mySession->obtenerVariable('id_recorrido');
    $url = Utils::construirURL($arrGet);

    $ObjSession = new Session();
    $id_usuario = $ObjSession->obtenerVariable('idusuario');

     //$mySession->obtenerVariable('id_recorrido');die();
    
    $Obj = new Recorridoparte();
    $str = array($mySession->obtenerVariable('id_recorrido'), $id_usuario, $_POST["fecha_parte"], $_POST["descripcion"], $_POST["fecha_inicio_trabajo"], $_POST["fecha_fin_trabajo"]);
    $Obj->insertRecord($str);
    header("Location: ../vistas/index.php" . $url);
    exit();
}

//El caso de uso (usuario) --- accion --- clic en el boton eliminar del listado (retorna al listado)
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "eliminar")) {
    $arrGet = $mySession->arrFiltro;
    $arrGet['frm'] = 'recorrido';
    $arrGet['template'] = 'add';
    $arrGet['id'] = $mySession->obtenerVariable('id_recorrido');
    $url = Utils::construirURL($arrGet);

    $Obj = new Recorridoparte();
    //Tratamiento del borrado de elementos seleccionados
    if ((isset($_POST['chkDEL'])) && ($_POST['chkDEL'] != "")) {
        foreach ($_POST['chkDEL'] as $id_delete) {
            $Obj->deleteRecord($id_delete);
        }
    }
    header("Location: ../vistas/index.php" . $url);
    exit();
}

//El caso de uso (usuario) --- accion --- clic en el boton guardar del formulario add (retorna al listado)
if ((isset($_POST["MM_from_recorrido_parte"])) && ($_POST["MM_from_recorrido_parte"] == "actualizar_recorrido_parte")) {

    $arrGet = $mySession->arrFiltro;
    $arrGet['frm'] = 'recorrido';
    $arrGet['template'] = 'add';
    $arrGet['id'] = $mySession->obtenerVariable('id_recorrido');
    $url = Utils::construirURL($arrGet);

    $ObjSession = new Session();
    $id_usuario = $ObjSession->obtenerVariable('idusuario');

    $Obj = new Recorridoparte();
    $str = array($mySession->obtenerVariable('id_recorrido'), $id_usuario, $_POST["fecha_parte"], $_POST["descripcion"], $_POST["fecha_inicio_trabajo"], $_POST["fecha_fin_trabajo"]);

    $Obj->updateRecord($_POST['id'], $str);

    header("Location: ../vistas/index.php" . $url);
    exit();
}
?>