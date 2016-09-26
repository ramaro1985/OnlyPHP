<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
$casoUso = 'tiposervicio';
$error = 0;
$tipo_error = '';

include_once("configuracion/configuracion.php");
include_once("acceso_datos/" . DRIVER_BD . "_acceso_datos.class.php");
include_once("utiles/session.class.php");
include_once("utiles/utils.class.php");
include_once("controladores/" . $casoUso . ".class.php");

//echo "GET -> ".print_r($_GET).'<br>';   
//echo "POST -> ".print_r($_POST).'<br>';   
//El caso de uso (usuario) --- accion --- buscar
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "buscar")) {
    $arrGet = Utils::arrayRecibePOST($_POST['arrGet']);
    $url = Utils::construirURLdeARRAY($_POST, $arrGet, 'arrGet', 'MM_from');
    header("Location: ../vistas/index.php" . $url);
    exit();
}

//El caso de uso (usuario) --- accion --- clic en el boton insertar del listado (llamada al formulario add)
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "insertar")) {
    header("Location: ../vistas/index.php?frm=" . $casoUso . '&template=add&id=0');
    exit();
}

//El caso de uso (usuario) --- accion --- clic en el boton guardar del formulario add (retorna al listado)
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "guardar_nuevo")) {
    $arrGet = Utils::arrayRecibePOST($_POST['arrGet']);
    $arrGet['frm'] = $casoUso;
    $arrGet['template'] = 'lst';
    $url = Utils::construirURLdeARRAY($_POST, $arrGet, 'arrGet', 'MM_from');
    $Obj = new Tiposervicio();
    $str = array($_POST["tipo_servicio"]);
    if ($Obj->insertRecord($str)==1) {
        $error = 1;
        $tipo_error = 'insertar_update';
        header("Location: ../vistas/index.php?frm=" . $casoUso . '&template=add&id=0&error=' . $error . '&tipo_error=' . $tipo_error);
        exit();
    }
    header("Location: ../vistas/index.php" . $url);
    exit();
}

//El caso de uso (usuario) --- accion --- clic en el boton eliminar del listado (retorna al listado)
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "eliminar")) {
    $arrGet = Utils::arrayRecibePOST($_POST['arrGet']);
    $url = Utils::construirURLdeARRAY($_POST, $arrGet, 'arrGet', 'MM_from');

    $Obj = new Tiposervicio();
    //Tratamiento del borrado de elementos seleccionados
    if ((isset($_POST['chkDEL'])) && ($_POST['chkDEL'] != "")) {
        foreach ($_POST['chkDEL'] as $id_delete) {
            //$Estadocivil->deleteRecord($id_delete);
            if ($Obj->deleteRecord($id_delete)==1) {
                $error = 1;
                $tipo_error = 'error_eliminar';
                header("Location: ../vistas/index.php" . $url . '&error=' . $error . '&tipo_error=' . $tipo_error);
                exit();
            }
        }
    }
    header("Location: ../vistas/index.php" . $url);
    exit();
}

//El caso de uso (usuario) --- accion --- clic en el boton guardar del formulario add (retorna al listado)
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "actualizar")) {
    $arrGet = Utils::arrayRecibePOST($_POST['arrGet']);
    $arrGet['frm'] = $casoUso;
    $arrGet['template'] = 'lst';
    $url = Utils::construirURLdeARRAY($_POST, $arrGet, 'arrGet', 'MM_from');

    $Obj = new Tiposervicio();
    $str = array($_POST["tipo_servicio"]);
    if ($Obj->updateRecord($_POST['id'], $str)==1) {
        $error = 1;
        $tipo_error = 'insertar_update';
        header("Location: ../vistas/index.php?frm=" . $casoUso . '&template=add&id=' . $_POST['id'] . '&error=' . $error . '&tipo_error=' . $tipo_error);
        exit();
    }

    header("Location: ../vistas/index.php" . $url);
    exit();
}
?>