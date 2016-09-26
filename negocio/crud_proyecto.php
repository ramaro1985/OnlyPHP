<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
$casoUso = 'proyecto';
include_once("configuracion/configuracion.php");
include_once("acceso_datos/" . DRIVER_BD . "_acceso_datos.class.php");
include_once("utiles/session.class.php");
include_once("utiles/utils.class.php");
include_once("controladores/" . $casoUso . ".class.php");
include_once("controladores/proyecto_empresa.class.php");
include_once("controladores/v_proyectoempresa.class.php");
//echo "GET -> ".print_r($_GET).'<br>';   
//echo "POST -> ".print_r($_POST).'<br>';   die();
$mySession = new Session();
$casoUso = 'proyecto';
$error = 0;
$tipo_error = '';

//El caso de uso (usuario) --- accion --- buscar
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "buscar")) {
    $arrGet = Utils::arrayRecibePOST($_POST['arrGet']);
    $url = Utils::construirURLdeARRAY($_POST, $arrGet, 'arrGet', 'MM_from_proyecto');
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
if ((isset($_POST["MM_from_proyecto"])) && ($_POST["MM_from_proyecto"] == "guardar_nuevo_proyecto")) {

    if (isset($_POST["id_empresa"]) && $_POST["id_empresa"] != '') {

        $id_empresa = $_POST["id_empresa"];
        $arrGet = $mySession->arrFiltro;
        $arrGet['frm'] = 'proyecto';
        $arrGet['template'] = 'lst';
        $url = Utils::construirURL($arrGet);
    } else {
        $id_empresa = $mySession->obtenerVariable('id_empresa');
        $arrGet = $mySession->arrFiltro;
        $arrGet['frm'] = 'empresa';
        $arrGet['template'] = 'lst';
        $url = Utils::construirURL($arrGet);
    }
    
    $Obj = new Proyecto();
    $str_proyecto = array($_POST["nombre_proyecto"], $_POST["lider"], $_POST["descripcion"], $_POST["id_estado"]);

    $Obj_proyecto_empresa = new V_proyectoempresa();
    $Obj_proyecto_empresa->getRecords('id_empresa=' . $id_empresa . ' AND ' . 'nombre_proyecto=' . "'" . $_POST["nombre_proyecto"] . "'");
    $existe_emnpresa_con_proyectos = $Obj_proyecto_empresa->objConexion->crearArreglo();

    if (isset($existe_emnpresa_con_proyectos) && is_array($existe_emnpresa_con_proyectos)) {
        $error = 1;
        $tipo_error = 'insertar_update';

        $arrGet = $mySession->arrFiltro;
        $arrGet['frm'] = $casoUso;
        $arrGet['template'] = 'add';
        $arrGet['id'] = '0';
        $arrGet['error'] = $error;
        $arrGet['tipo_error'] = $tipo_error;
        $url = Utils::construirURL($arrGet);

        header("Location: ../vistas/index.php" . $url);
        exit();
    } else {
        $lastInsert = $Obj->insertRecord($str_proyecto);
        $str_proyecto_empresa = array($mySession->obtenerVariable('id_empresa'), $lastInsert['id']);

        $Obj = new Proyecto_empresa();
        $Obj->insertRecord($str_proyecto_empresa);

        $arrGet = $mySession->arrFiltro;
        $arrGet['frm'] = 'empresa';
        $arrGet['template'] = 'add';
        $arrGet['id'] = $mySession->obtenerVariable('id_empresa');
        $url = Utils::construirURL($arrGet);

        header("Location: ../vistas/index.php" . $url);
        exit();
    }
    header("Location: ../vistas/index.php" . $url);
    exit();
}

//El caso de uso (usuario) --- accion --- clic en el boton eliminar del listado (retorna al listado)
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "eliminar")) {

    unset($mySession->arrFiltro['error']);
    unset($mySession->arrFiltro['tipo_error']);
    $mySession->actualizar();

    $arrGet = $mySession->arrFiltro;
    $arrGet['frm'] = 'empresa';
    $arrGet['template'] = 'add';
    $arrGet['id'] = $mySession->obtenerVariable('id_empresa');
    $url = Utils::construirURL($arrGet);

    $Obj = new Proyecto();

    if ((isset($_POST['chkDEL'])) && ($_POST['chkDEL'] != "")) {
        foreach ($_POST['chkDEL'] as $id_delete) {

            if ($Obj->deleteRecord($id_delete) == 1 || $Obj->deleteRecord($id_delete) == -1) {
                $error = 1;
                $tipo_error = 'error_eliminar';

                $arrGet = $mySession->arrFiltro;
                $arrGet['frm'] = $casoUso;
                $arrGet['template'] = 'lst';
                $arrGet['error'] = $error;
                $arrGet['tipo_error'] = $tipo_error;
                $url = Utils::construirURL($arrGet);

                header("Location: ../vistas/index.php" . $url);
                exit();
            }
        }
    }
    header("Location: ../vistas/index.php" . $url);
    exit();
}

//El caso de uso (usuario) --- accion --- clic en el boton guardar del formulario add (retorna al listado)
if ((isset($_POST["MM_from_proyecto"])) && ($_POST["MM_from_proyecto"] == "actualizar_proyecto")) {

    $arrGet = $mySession->arrFiltro;
    $arrGet['frm'] = 'empresa';
    $arrGet['template'] = 'add';
    $arrGet['id'] = $mySession->obtenerVariable('id_empresa');
    $url = Utils::construirURL($arrGet);

    $Obj = new Proyecto();
    $str_proyecto = array($_POST["nombre_proyecto"], $_POST["lider"], $_POST["descripcion"], $_POST["id_estado"]);

    if (is_array($Obj->updateRecord($_POST['id'], $str_proyecto)) == FALSE) {

        $error = 1;
        $tipo_error = 'insertar_update';

        $arrGet = $mySession->arrFiltro;
        $arrGet['frm'] = $casoUso;
        $arrGet['template'] = 'add';
        $arrGet['id'] = $_POST['id'];
        $arrGet['error'] = $error;
        $arrGet['tipo_error'] = $tipo_error;
        $url = Utils::construirURL($arrGet);

        header("Location: ../vistas/index.php" . $url);
        exit();
    }

    header("Location: ../vistas/index.php" . $url);
    exit();
}
?>