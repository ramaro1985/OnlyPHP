<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
$casoUso = 'asamblea';
$error = 0;
$tipo_error = '';

include_once("configuracion/configuracion.php");
include_once("acceso_datos/" . DRIVER_BD . "_acceso_datos.class.php");
include_once("utiles/session.class.php");
include_once("utiles/utils.class.php");
include_once("controladores/" . $casoUso . ".class.php");
include_once("controladores/asamblea_resultado.class.php");

$mySession = new Session();
//echo "GET -> ".print_r($_GET).'<br>';   
//echo "POST -> ".print_r($_POST).'<br>';die();   
//El caso de uso (usuario) --- accion --- buscar

if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "buscar")) {
    $arrGet = Utils::arrayRecibePOST($_POST['arrGet']);
    $url = Utils::construirURLdeARRAY($_POST, $arrGet, 'arrGet', 'MM_from_asamblea');
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
if ((isset($_POST["MM_from_asamblea"])) && ($_POST["MM_from_asamblea"] == "guardar_nuevo_asamblea")) {

    $Obj = new Asamblea();
    $cerrada;
    $confirmada;
    $str = array($_POST["id_cap"], $_POST["id_comuna"], $_POST["id_municipio"], $_POST["localidad"], $_POST["poblado"], $_POST["presidente_asamblea"], $_POST["codigo_asamblea"]);
    if (is_array($lastInsert = $Obj->insertRecord($str)) == FALSE) {
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

        $Obj = new Asamblea_resultado();
        $str = array($lastInsert['id'], $_POST["id_usuario"], $fecha_cierre, 0, 0, 0, 0, 0, 0,$_POST["electores_registrados"]);
        $Obj->insertRecord($str);

        $arrGet = $mySession->arrFiltro;
        $arrGet['frm'] = $casoUso;
        $arrGet['template'] = 'lst';
        $url = Utils::construirURL($arrGet);
    }
    header("Location: ../vistas/index.php" . $url);
    exit();
}

//El caso de uso (usuario) --- accion --- clic en el boton eliminar del listado (retorna al listado)
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "eliminar")) {
    $arrGet = $mySession->arrFiltro;
    $arrGet['frm'] = $casoUso;
    $arrGet['template'] = 'lst';
    $url = Utils::construirURL($arrGet);

    $Obj = new Asamblea();
    //Tratamiento del borrado de elementos seleccionados
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
if ((isset($_POST["MM_from_asamblea"])) && ($_POST["MM_from_asamblea"] == "actualizar_asamblea")) {
    $arrGet = $mySession->arrFiltro;
    $arrGet['frm'] = $casoUso;
    $arrGet['template'] = 'lst';
    $url = Utils::construirURL($arrGet);

    $Obj = new Asamblea();
    $str = array($_POST["id_cap"], $_POST["id_comuna"], $_POST["id_municipio"], $_POST["localidad"], $_POST["poblado"], $_POST["presidente_asamblea"], $_POST["codigo_asamblea"]);
    if (is_array($Obj->updateRecord($_POST['id'], $str)) == FALSE) {
        $error = 1;
        $tipo_error = 'insertar_update';

        $arrGet = $mySession->arrFiltro;
        $arrGet['frm'] = $casoUso;
        $arrGet['template'] = 'add';
        $arrGet['id'] = $id;
        $arrGet['error'] = $error;
        $arrGet['tipo_error'] = $tipo_error;
        $url = Utils::construirURL($arrGet);

        header("Location: ../vistas/index.php" . $url);
        exit();
    } else {
        $cerrada = $_POST["cerrada"];
        $confirmada = $_POST["confirmada"];

        if ($cerrada == NULL) {
            $cerrada = 0;
        }
        if($confirmada==NULL){
            $confirmada=0;
        }
        
        $Obj = new Asamblea_resultado();
        $str = array($_POST['id'], $_POST["id_usuario"], $fecha_cierre, $_POST["votos_blanco"], $_POST["votos_nulos"], $_POST["votos_reclamados"], $_POST["votos_validos"], $cerrada, $confirmada,$_POST["electores_registrados"]);
        $Obj->updateRecord($_POST['id_asamblea_resultado'], $str);

        $arrGet = $mySession->arrFiltro;
        $arrGet['frm'] = $casoUso;
        $arrGet['template'] = 'lst';
        $url = Utils::construirURL($arrGet);
    }

    header("Location: ../vistas/index.php" . $url);
    exit();
}
?>