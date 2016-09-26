<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));

include_once("utiles/session.class.php");
$mySession = new Session();

$casoUso = 'recorrido';
$error = 0;
$tipo_error = '';

//$id_empresa = $mySession->obtenerVariable('id_empresa');
//$id_proyecto = $mySession->obtenerVariable('id_proyecto');

include_once("configuracion/configuracion.php");
include_once("acceso_datos/" . DRIVER_BD . "_acceso_datos.class.php");

include_once("utiles/utils.class.php");
include_once("controladores/" . $casoUso . ".class.php");
include_once("controladores/v_proyectoempresa.class.php");
include_once("controladores/producto.class.php");
include_once("controladores/recorrido_supervisor.class.php");
include_once("controladores/recorrido_producto.class.php");



//echo "GET -> ".print_r($_GET).'<br>';   
//echo "POST -> ".print_r($_POST).'<br>';   die();
//El caso de uso (usuario) --- accion --- buscar
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "buscar")) {
    $arrGet = Utils::arrayRecibePOST($_POST['arrGet']);
    $url = Utils::construirURLdeARRAY($_POST, $arrGet, 'arrGet', 'MM_from_recorrido');
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
if ((isset($_POST["MM_from_recorrido"])) && ($_POST["MM_from_recorrido"] == "guardar_nuevo_recorrido")) {
    if (isset($_POST["id_empresa"]) && $_POST["id_empresa"] != '') {

        $id_empresa = $_POST["id_empresa"];
        $id_proyecto = $_POST["id_proyecto"];

        $arrGet = $mySession->arrFiltro;
        $arrGet['frm'] = 'recorrido';
        $arrGet['template'] = 'lst';
        $url = Utils::construirURL($arrGet);
    } else {
        $arrGet = $mySession->arrFiltro;
        $arrGet['frm'] = 'proyecto';
        $arrGet['template'] = 'add';
        $arrGet['id'] = $mySession->obtenerVariable('id_proyecto');
        $url = Utils::construirURL($arrGet);

      $id_empresa = $mySession->obtenerVariable('id_empresa');
      $id_proyecto = $mySession->obtenerVariable('id_proyecto');
        
    }

    $nombre_recorrido = $_POST["nombre_recorrido"];
    $proyecto_empresa = new V_proyectoempresa();
    $proyecto_empresa->getRecords('id_empresa=' . "'$id_empresa'" . ' AND ' . 'id_proyecto=' . "'$id_proyecto'");
    $aDatos = $proyecto_empresa->objConexion->crearArreglo();

    $id_empresa_proyecto = $aDatos['id'];

    if (isset($_POST["id_comuna"]) && $_POST["id_comuna"] != '') {
        $id_comuna = $_POST["id_comuna"];
    } else {
        $id_comuna = 0;
    }

    $str = array($id_comuna, $_POST["id_municipio"], $_POST["id_provincia"], $_POST["id_estado"], $id_empresa_proyecto, $_POST["fecha_propuesta_inicio"], $_POST["fecha_inicio"], $_POST["fecha_propuesta_fin"], $_POST["fecha_fin"], $_POST["nombre_recorrido"]);

    $Obj = new Recorrido();
    $Obj->getRecords('nombre_recorrido=' . "'$nombre_recorrido'" . ' AND ' . 'id_proyecto_empresa=' . "'$id_empresa_proyecto'");
    $existe_recorrido = $Obj->objConexion->crearArreglo();

    if (is_array($existe_recorrido)) {
        $error = 1;
        $tipo_error = 'insertar_update';

        $arrGet = $mySession->arrFiltro;
        $arrGet['frm'] = $casoUso;
        $arrGet['template'] = 'add';
        $arrGet['id'] = '0';
        $arrGet['error'] = $error;
        $arrGet['tipo_error'] = $tipo_error;
    } else {
        $lastInsertUser = $Obj->insertRecord($str);

        $id_tipo_supervisor = $_POST['id_tipo_supervisor'];
        $id_usuario = $_POST['id_usuario'];

//------Insertar_tipo _supervisor---------//
        $tipo_supervisor = new Recorrido_supervisor();
        $str = array($id_tipo_supervisor, $id_usuario, $lastInsertUser['id']);
        $tipo_supervisor->insertRecord($str);
    }
    $url = Utils::construirURL($arrGet);
    header("Location: ../vistas/index.php" . $url);
    exit();
}

//El caso de uso (usuario) --- accion --- clic en el boton eliminar del listado (retorna al listado)
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "eliminar")) {
    $arrGet = $mySession->arrFiltro;
    $arrGet['frm'] = 'proyecto';
    $arrGet['template'] = 'add';
    $arrGet['id'] = $mySession->obtenerVariable('id_proyecto');

    $Obj = new Recorrido();
    //Tratamiento del borrado de elementos seleccionados
    if ((isset($_POST['chkDEL'])) && ($_POST['chkDEL'] != "")) {
        foreach ($_POST['chkDEL'] as $id_delete) {

            $Obj->deleteRecord($id_delete);
        }
    }

    $url = Utils::construirURL($arrGet);
    header("Location: ../vistas/index.php" . $url);
    exit();
}

//El caso de uso (usuario) --- accion --- clic en el boton guardar del formulario add (retorna al listado)
if ((isset($_POST["MM_from_recorrido"])) && ($_POST["MM_from_recorrido"] == "actualizar_recorrido")) {

    $id_empresa = $mySession->obtenerVariable('id_empresa');
    $id_proyecto = $mySession->obtenerVariable('id_proyecto');

    $nombre_recorrido = $_POST["nombre_recorrido"];

    $proyecto_empresa = new V_proyectoempresa();
    $proyecto_empresa->getRecords('id_empresa=' . "'$id_empresa'" . ' AND ' . 'id_proyecto=' . "'$id_proyecto'");
    $aDatos = $proyecto_empresa->objConexion->crearArreglo();

    $id_empresa_proyecto = $aDatos['id'];

    if (isset($_POST["id_comuna"]) && $_POST["id_comuna"] != '') {
        $id_comuna = $_POST["id_comuna"];
    } else {
        $id_comuna = 0;
    }

    $str = array($id_comuna, $_POST["id_municipio"], $_POST["id_provincia"], $_POST["id_estado"], $id_empresa_proyecto, $_POST["fecha_propuesta_inicio"], $_POST["fecha_inicio"], $_POST["fecha_propuesta_fin"], $_POST["fecha_fin"], $_POST["nombre_recorrido"]);

    $Obj = new Recorrido();
    $Obj->getRecords('nombre_recorrido=' . "'$nombre_recorrido'" . ' AND ' . 'id_proyecto_empresa=' . "'$id_empresa_proyecto'");
    $existe_recorrido = $Obj->objConexion->crearArreglo();
    $existe_recorrido = $Obj->objConexion->crearArreglo();

    if (is_array($existe_recorrido)) {
        $error = 1;
        $tipo_error = 'insertar_update';

        $arrGet = $mySession->arrFiltro;
        $arrGet['frm'] = $casoUso;
        $arrGet['template'] = 'add';
        $arrGet['id'] = '0';
        $arrGet['error'] = $error;
        $arrGet['tipo_error'] = $tipo_error;
        $url = Utils::construirURL($arrGet);
    } else {

        $Obj->updateRecord($_POST['id'], $str);
        $id_tipo_supervisor = $_POST['id_tipo_supervisor'];
        $id_usuario = $_POST['id_usuario'];

        $tipo_supervisor = new Recorrido_supervisor();
        $str = array($id_tipo_supervisor, $id_usuario, $_POST['id']);
        $tipo_supervisor->updateRecord($_POST['id_recorrido_supervisor'], $str);

        $arrGet = $mySession->arrFiltro;
        $arrGet['frm'] = 'proyecto';
        $arrGet['template'] = 'add';
        $arrGet['id'] = $mySession->obtenerVariable('id_proyecto');
        $url = Utils::construirURL($arrGet);
    }

    header("Location: ../vistas/index.php" . $url);
    exit();
}
?>