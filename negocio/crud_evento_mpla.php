<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
include_once("configuracion/configuracion.php");
include_once("acceso_datos/" . DRIVER_BD . "_acceso_datos.class.php");
include_once("utiles/session.class.php");
include_once("utiles/utils.class.php");
include_once("controladores/evento_mpla.class.php");
include_once("controladores/ubicacion_evento.class.php");

$mySession = new Session();
$id_ubicacion_evento = $mySession->obtenerVariable('id_ubicacion_evento');
//echo "GET -> ".print_r($_GET).'<br>';   
// "POST -> ".print_r($_POST);die();
//print_r($_POST['prelectores']) ;  die();

$casoUso = 'evento_mpla';
//--- accion --- clic en el botón filtrar del listado
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "buscar")) {
    $arrGet = Utils::arrayRecibePOST($_POST['arrGet']);
    $url = Utils::construirURLdeARRAY($_POST, $arrGet, 'arrGet', 'MM_from');
    header("Location: ../vistas/index.php" . $url);
    exit();
}

//--- accion --- clic en el boton insertar del listado (llamada al formulario add)
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "insertar")) {
    header("Location: ../vistas/index.php?frm=" . $casoUso . '&template=add&id=0');
    exit();
}

//--- accion --- clic en el boton guardar del formulario add (retorna al listado)
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "guardar_nuevo")) {
    $arrGet = $mySession->arrFiltro;
    if ($id_ubicacion_evento == 0) {
        $arrGet['frm'] = 'evento_oposc';
    } elseif ($id_ubicacion_evento == 1) {
        $arrGet['frm'] = 'precampanna';
    } elseif ($id_ubicacion_evento == 2) {
        $arrGet['frm'] = 'encampanna';
    } elseif ($id_ubicacion_evento == 3) {
        $arrGet['frm'] = 'postcampanna';
    }
    $arrGet['template'] = 'lst';
    $url = Utils::construirURL($arrGet);

    $hora_planificada = $_POST['hora_planificada'] . ":" . $_POST['min_planificada'] . ":" . $_POST['horario_planificada'];
    $hora_realizada = $_POST['hora_realizada'] . ":" . $_POST['min_realizada'];

    $Obj = new Evento_mpla();
    $str = array($mySession->idusuario, $_POST['id_municipio'], $_POST['id_comuna'], $_POST['id_tipo_organizacion_enevento'], $id_ubicacion_evento, $_POST['presidente_acto'], $_POST['cantidad_participantes'], $_POST['principales_ocurrencias'], $_POST['fecha_planificada'], $hora_planificada, $_POST['fecha_realizada'], $hora_realizada, $prelectores, $_POST['id_dirigente'], $_POST['local'], $_POST['cordinador'], $_POST['enfoque'], $_POST['medidas_organizativas'], $_POST['impacto'], $_POST['dificultades'], $_POST['medidas_seguridad'], $_POST['id_organizacion']);

    $ObjUbicacion_evento = new Ubicacion_evento();
    $ObjUbicacion_evento->getRecords('id=' . "'$id_ubicacion_evento'");
    $aDatos = $ObjUbicacion_evento->objConexion->crearArreglo();
    
    if (isset($id_ubicacion_evento) && $id_ubicacion_evento > 0) {
        if ($id_ubicacion_evento != 3) {
            if (strtotime($_POST['fecha_planificada']) < strtotime($aDatos['fecha_inicio']) || strtotime($_POST['fecha_planificada']) > strtotime($aDatos['fecha_fin'])) {

                $error = 1;
                $tipo_error = 'fecha';

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
        } else {
            if (strtotime($_POST['fecha_planificada']) < strtotime($aDatos['fecha_inicio'])) {

                echo '2';
                $error = 1;
                $tipo_error = 'fecha';

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
        }
    }
    if (is_array($lastInsertUser = $Obj->insertRecord($str)) == FALSE) {
        $error = 1;
        $tipo_error = 'insertar_update';

        $arrGet = $mySession->arrFiltro;
        $arrGet['frm'] = 'envento_mpla';
        $arrGet['template'] = 'add';
        $arrGet['id'] = '0';
        $arrGet['error'] = $error;
        $arrGet['tipo_error'] = $tipo_error;
        $url = Utils::construirURL($arrGet);
    }
    header("Location: ../vistas/index.php" . $url);
    exit();
}

//--- accion --- clic en el boton eliminar del listado (retorna al listado)
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "eliminar")) {
    $arrGet = $mySession->arrFiltro;
    if ($id_ubicacion_evento == 0) {
        $arrGet['frm'] = 'evento_oposc';
    } elseif ($id_ubicacion_evento == 1) {
        $arrGet['frm'] = 'precampanna';
    } elseif ($id_ubicacion_evento == 2) {
        $arrGet['frm'] = 'encampanna';
    } elseif ($id_ubicacion_evento == 3) {
        $arrGet['frm'] = 'postcampanna';
    }
    $arrGet['template'] = 'lst';
    $url = Utils::construirURL($arrGet);

    $Obj = new Evento_mpla();
    //Tratamiento del borrado de elementos seleccionados
    if ((isset($_POST['chkDEL'])) && ($_POST['chkDEL'] != "")) {
        foreach ($_POST['chkDEL'] as $id_delete) {
            if ($Obj->deleteRecord($id_delete) == 1 || $Obj->deleteRecord($id_delete) == -1) {
                $error = 1;
                $tipo_error = 'error_eliminar';

                $arrGet = $mySession->arrFiltro;
                if ($id_ubicacion_evento == 1) {
                    $arrGet['frm'] = 'precampanna';
                } elseif ($id_ubicacion_evento == 2) {
                    $arrGet['frm'] = 'encampanna';
                } elseif ($id_ubicacion_evento == 3) {
                    $arrGet['frm'] = 'postcampanna';
                }
                $arrGet['template'] = 'lst';
                $arrGet['error'] = $error;
                $arrGet['tipo_error'] = $tipo_error;
            }
        }
    }
    header("Location: ../vistas/index.php" . $url);
    exit();
}

//--- accion --- clic en el boton guardar del formulario add (retorna al listado)
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "actualizar")) {
    $arrGet = $mySession->arrFiltro;
    if ($id_ubicacion_evento == 0) {
        $arrGet['frm'] = 'evento_oposc';
    } elseif ($id_ubicacion_evento == 1) {
        $arrGet['frm'] = 'precampanna';
    } elseif ($id_ubicacion_evento == 2) {
        $arrGet['frm'] = 'encampanna';
    } elseif ($id_ubicacion_evento == 3) {
        $arrGet['frm'] = 'postcampanna';
    }
    $arrGet['template'] = 'lst';
    $url = Utils::construirURL($arrGet);

    if ((isset($_POST['prelectores'])) && ($_POST['prelectores'] != "")) {
        foreach ($_POST['prelectores'] as $item) {
            if ($item != '') {
                $prelectores = $item . ';' . $prelectores;
            }
        }
    }

    $hora_planificada = $_POST['hora_planificada'] . ":" . $_POST['min_planificada'] . ":" . $_POST['horario_planificada'];
    $hora_realizada = $_POST['hora_realizada'] . ":" . $_POST['min_realizada'] ;

    $Obj = new Evento_mpla();
    $str = array($mySession->idusuario, $_POST['id_municipio'], $_POST['id_comuna'], $_POST['id_tipo_organizacion_enevento'], $id_ubicacion_evento, $_POST['presidente_acto'], $_POST['cantidad_participantes'], $_POST['principales_ocurrencias'], $_POST['fecha_planificada'], $hora_planificada, $_POST['fecha_realizada'], $hora_realizada, $prelectores, $_POST['id_dirigente'], $_POST['local'], $_POST['cordinador'], $_POST['enfoque'], $_POST['medidas_organizativas'], $_POST['impacto'], $_POST['dificultades'], $_POST['medidas_seguridad'], $_POST['id_organizacion']);

    $ObjUbicacion_evento = new Ubicacion_evento();
    $ObjUbicacion_evento->getRecords('id=' . "'$id_ubicacion_evento'");
    $aDatos = $ObjUbicacion_evento->objConexion->crearArreglo();
    if (isset($id_ubicacion_evento) && $id_ubicacion_evento > 0) {
        if ($id_ubicacion_evento != 3) {
            if (strtotime($_POST['fecha_planificada']) < strtotime($aDatos['fecha_inicio']) || strtotime($_POST['fecha_planificada']) > strtotime($aDatos['fecha_fin'])) {

                $error = 1;
                $tipo_error = 'fecha';

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
        } else {
            if (strtotime($_POST['fecha_planificada']) < strtotime($aDatos['fecha_inicio'])) {

                $error = 1;
                $tipo_error = 'fecha';

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
        }
    }
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
    }

    header("Location: ../vistas/index.php" . $url);
    exit();
}
?>