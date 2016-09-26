<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
include_once("configuracion/configuracion.php");
include_once("acceso_datos/" . DRIVER_BD . "_acceso_datos.class.php");
include_once("utiles/session.class.php");
include_once("utiles/utils.class.php");
include_once("controladores/usuario.class.php");
include_once("controladores/grupogestion_usuario.class.php");

$mySession = new Session();

if (isset($_POST["redirect_password"]) && $_POST["redirect_password"] != '') {
    header("Location: ../vistas/index.php?frm=modificarclave&template=horizontal");
    exit();
}

//El caso de uso (usuario) --- accion --- clic en el boton guardar del formulario add (retorna al listado)
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "actualizar")) {
    //$arrGet = Utils::arrayRecibePOST($_POST['arrGet']);
    $arrGet = $mySession->arrFiltro;
    $arrGet['frm'] = $casoUso;
    $arrGet['template'] = 'lst';
    $url = Utils::construirURL($arrGet);

    $updateUser = new Usuarios();
    $str = array($_POST["usuario"], $_POST["nombre_completo"], $_POST["pass"], $_POST["habilitado"], $_POST["id_activista"]);

    $updateUser->updateRecord($_POST['id'], $str);

    header("Location: ../vistas/index.php?frm=principal&template=resumen");
    exit();
}
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "clave")) {

    $editar_pass = $_POST["editar_pass"];
    $clave_usuario = $_POST["clave"];
    $old_clave = $_POST["old_clave"];
    $new_clave = $_POST["new_clave"];
    $confirm_clave = $_POST["confirm_clave"];
    if ($editar_pass != NULL) {
        if ($new_clave == $confirm_clave) {

            $updateUser = new Usuarios();
            $str = array($_POST["usuario"], $_POST["nombre_completo"], md5($new_clave), $_POST["habilitado"], $_POST["id_activista"]);
            $updateUser->updateRecord($_POST['id'], $str);

            header("Location: ../vistas/index.php?frm=principal&template=resumen");
            exit();
        } else {
            $arrGet = $mySession->arrFiltro;
            $arrGet['frm'] = 'modificarclave';
            $arrGet['template'] = 'horizontal';
            $arrGet['error'] = 1;
            $arrGet['tipo_error'] = 'claves_distintas';

            $url = Utils::construirURL($arrGet);
            header("Location: ../vistas/index.php" . $url);
            exit();
        }
    }
    if ($clave_usuario == md5($old_clave)) {

        if ($new_clave == $confirm_clave) {

            $updateUser = new Usuarios();
            $str = array($_POST["usuario"], $_POST["nombre_completo"], md5($new_clave), $_POST["habilitado"], $_POST["id_activista"]);
            $updateUser->updateRecord($_POST['id'], $str);

            header("Location: ../vistas/index.php?frm=principal&template=resumen");
            exit();
        } else {
            $arrGet = $mySession->arrFiltro;
            $arrGet['frm'] = 'modificarclave';
            $arrGet['template'] = 'horizontal';
            $arrGet['error'] = 1;
            $arrGet['tipo_error'] = 'claves_distintas';

            $url = Utils::construirURL($arrGet);
            header("Location: ../vistas/index.php" . $url);
            exit();
        }
    } else {
        $arrGet = $mySession->arrFiltro;
        $arrGet['frm'] = 'modificarclave';
        $arrGet['template'] = 'horizontal';
        $arrGet['error'] = 2;
        $arrGet['tipo_error'] = 'claves_distintas_usuario';

        $url = Utils::construirURL($arrGet);
        header("Location: ../vistas/index.php" . $url);
        exit();
    }
}
?>