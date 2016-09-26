<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
include_once("configuracion/configuracion.php");
include_once("acceso_datos/" . DRIVER_BD . "_acceso_datos.class.php");
include_once("utiles/session.class.php");
include_once("utiles/utils.class.php");
include_once("controladores/empresa.class.php");
include_once("controladores/proyecto_empresa.class.php");
include_once("controladores/empresa_usuario.class.php");
//echo "GET -> ".print_r($_GET).'<br>';   
//echo "POST -> ".print_r($_POST).'<br>';   die();
$mySession = new Session();
$casoUso = 'empresa';
$error = 0;
$tipo_error = '';
//El caso de uso (usuario) --- accion --- buscar
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "buscar")) {
    $arrGet = Utils::arrayRecibePOST($_POST['arrGet']);
    $url = Utils::construirURLdeARRAY($_POST, $arrGet, 'arrGet', 'MM_from_empresa');
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
if ((isset($_POST["MM_from_empresa"])) && ($_POST["MM_from_empresa"] == "guardar_nuevo_empresa")) {
    $arrGet = $mySession->arrFiltro;
    $arrGet['frm'] = $casoUso;
    $arrGet['template'] = 'lst';
    $url = Utils::construirURL($arrGet);

    $Obj = new Empresa();
    $str = array($_POST["id_tipo_servicio"], $_POST["nombre_empresa"], $_POST["direccion"]);
    if (is_array($lastInsertUser = $Obj->insertRecord($str)) == FALSE) {
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
    }
    $Obj = new Empresa_usuario();
    $str = array($mySession->obtenerVariable('idusuario'), $lastInsertUser["id"]);
    $Obj->insertRecord($str);

    header("Location: ../vistas/index.php" . $url);
    exit();
}

//El caso de uso (usuario) --- accion --- clic en el boton eliminar del listado (retorna al listado)
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "eliminar")) {
    $arrGet['frm'] = $casoUso;
    $arrGet['template'] = 'lst';
    $url = Utils::construirURL($arrGet);

    $Obj = new Empresa();

    if ((isset($_POST['chkDEL'])) && ($_POST['chkDEL'] != "")) {
        foreach ($_POST['chkDEL'] as $id_delete) {

            $Obj_proyecto_empresa = new Proyecto_empresa();
            $Obj_proyecto_empresa->getRecords('id_empresa=' . $id_delete);
            $existe_emnpresa_con_proyectos = $Obj_proyecto_empresa->objConexion->crearArreglo();

            if (isset($existe_emnpresa_con_proyectos) && is_array($existe_emnpresa_con_proyectos)) {
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
            } else {
                $Obj->deleteRecord($id_delete);
                unset($mySession->arrFiltro['error']);
                unset($mySession->arrFiltro['tipo_error']);
                $mySession->actualizar();

                $arrGet = $mySession->arrFiltro;
                $arrGet['frm'] = $casoUso;
                $arrGet['template'] = 'lst';
                $url = Utils::construirURL($arrGet);
                header("Location: ../vistas/index.php" . $url);
                exit();
            }
        }
    }
}

//El caso de uso (usuario) --- accion --- clic en el boton guardar del formulario add (retorna al listado)
if ((isset($_POST["MM_from_empresa"])) && ($_POST["MM_from_empresa"] == "actualizar_empresa")) {
    $arrGet = $mySession->arrFiltro;
    $arrGet['frm'] = $casoUso;
    $arrGet['template'] = 'lst';
    $url = Utils::construirURL($arrGet);

    $Obj = new Empresa();
    $str = array($_POST["id_tipo_servicio"], $_POST["nombre_empresa"], $_POST["direccion"]);

    if (is_array($Obj->updateRecord($_POST['id'], $str)) == FALSE) {

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