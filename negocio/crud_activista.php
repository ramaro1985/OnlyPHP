<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
include_once("utiles/session.class.php");
$mySession = new Session();

$casoUso = 'activista';
$error = 0;
$tipo_error = '';

include_once("configuracion/configuracion.php");
include_once("acceso_datos/" . DRIVER_BD . "_acceso_datos.class.php");
include_once("utiles/utils.class.php");
include_once("controladores/activista_dialecto.class.php");
include_once("controladores/usuario.class.php");
include_once("controladores/usuario_extendido.class.php");
include_once("controladores/" . $casoUso . ".class.php");


//echo "GET -> ".print_r($_GET).'<br>';   
//echo "POST -> ".print_r($_POST).'<br>';   die();
//El caso de uso (usuario) --- accion --- buscar
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "buscar")) {
    $arrGet = Utils::arrayRecibePOST($_POST['arrGet']);
    $url = Utils::construirURLdeARRAY($_POST, $arrGet, 'arrGet', 'MM_from');
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
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "guardar_nuevo")) {
    $arrGet = $mySession->arrFiltro;
    $arrGet['frm'] = $casoUso;
    $arrGet['template'] = 'lst';
    $url = Utils::construirURL($arrGet);

    $Obj = new Activista();
    $str = array($_POST["estado_civil"], $_POST["org_partidista"], $_POST["profesion"], $_POST["funcion_trabajo"], $_POST["nivel_escolar"], $_POST["id_cap"], $_POST["nro_carton_militante"], $_POST["nro_identidad"], $_POST["nro_carton_electoral"], $_POST["nombre_completo"], $_POST["direccion"], $_POST["correo"], $_POST["telefono"], $_POST["sexo"], $_POST["padre"], $_POST["madre"], $_POST["fecha_nacimiento"]);

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
    } else {
        $nuevosLeguanjes = new Activista_dialecto();
        $sqlDelete = "DELETE FROM activista_dialecto WHERE id_activista = " . $lastInsertUser["id"];
        $nuevosLeguanjes->objConexion->realizarConsulta($sqlDelete);

        if ((isset($_POST['incluido'])) && ($_POST['incluido'] != "")) {
            foreach ($_POST['incluido'] as $item) {

                $dataInsert = array($lastInsertUser["id"], $item);
                $nuevosLeguanjes->insertRecord($dataInsert);
            }
        }

        if (isset($_POST["usuario"]) && $_POST["usuario"] != '') {

            $nuevoUsuario = new Usuario_extendido();
            $str = array($_POST["usuario"], $_POST["nombre_completo"], md5($_POST["clave"]), 'true', $lastInsertUser["id"]);
            $nuevoUsuario->insertRecord($str);
        }

        $uploads_dir = '../imagenes/tmp_activistas';
        $_FILES['foto_activista']['name'];
        $_FILES['foto_activista']['type'];
        $_FILES['foto_activista']['tmp_name'];
        $_FILES['foto_activista']['size'];

        $id_insert = $lastInsertUser["id"];
        $tmp_name = $_FILES['foto_activista']['tmp_name'];
        move_uploaded_file($tmp_name, "$uploads_dir/$id_insert.jpg");
    }


    $url = Utils::construirURL($arrGet);
    header("Location: ../vistas/index.php" . $url);
    exit();
}

//El caso de uso (usuario) --- accion --- clic en el boton eliminar del listado (retorna al listado)
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "eliminar")) {
    $arrGet = $mySession->arrFiltro;
    $arrGet['frm'] = $casoUso;
    $arrGet['template'] = 'lst';

    $Obj = new Activista();
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

    $url = Utils::construirURL($arrGet);
    header("Location: ../vistas/index.php" . $url);
    exit();
}

//El caso de uso (usuario) --- accion --- clic en el boton guardar del formulario add (retorna al listado)
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "actualizar")) {

    $arrGet = $mySession->arrFiltro;
    $arrGet['frm'] = $casoUso;
    $arrGet['template'] = 'lst';

    $Obj = new Activista();
    $str = array($_POST["estado_civil"], $_POST["org_partidista"], $_POST["profesion"], $_POST["funcion_trabajo"], $_POST["nivel_escolar"], $_POST["id_cap"], $_POST["nro_carton_militante"], $_POST["nro_identidad"], $_POST["nro_carton_electoral"], $_POST["nombre_completo"], $_POST["direccion"], $_POST["correo"], $_POST["telefono"], $_POST["sexo"], $_POST["padre"], $_POST["madre"], $_POST["fecha_nacimiento"]);

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

    //Se procede a elimiar los grupos a los cuales pertece
    $nuevosDialectos = new Activista_dialecto();
    $sqlDelete = "DELETE FROM activista_dialecto WHERE id_activista = " . $_POST['id'];
    $nuevosDialectos->objConexion->realizarConsulta($sqlDelete);

    //Se procede a insertar los grupos nuevos o actualizados
    if ((isset($_POST['incluido'])) && ($_POST['incluido'] != "")) {
        foreach ($_POST['incluido'] as $item) {
            $dataInsert = array($_POST['id'], $item);
            $nuevosDialectos->insertRecord($dataInsert);
        }
    }
    if (isset($_POST["usuario"]) && $_POST["usuario"] != '') {

        $nuevoUsuario = new Usuario_extendido();
        $str = array($_POST["usuario"], $_POST["nombre_completo"], md5($_POST["clave"]), 'true', $_POST['id']);
        $nuevoUsuario->insertRecord($str);
    }
    $uploads_dir = '../imagenes/tmp_activistas';
    $_FILES['foto_activista']['name'];
    $_FILES['foto_activista']['type'];
    $_FILES['foto_activista']['tmp_name'];
    $_FILES['foto_activista']['size'];

    $id_insert = $_POST['id'];
    $tmp_name = $_FILES['foto_activista']['tmp_name'];
    move_uploaded_file($tmp_name, "$uploads_dir/$id_insert.jpg");

    $url = Utils::construirURL($arrGet);
    header("Location: ../vistas/index.php" . $url);
    exit();
}

if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "buscar_avanzado")) {
    unset($mySession->arrFiltro['txtSearch']);
    unset($mySession->arrFiltro['orden']);
    unset($mySession->arrFiltro['por']);
    $mySession->actualizar();
    header("Location: ../vistas/index.php?frm=" . $casoUso . '&template=buscar');
    exit();
}

if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "buscar_resultado")) {
    unset($mySession->arrFiltro['txtSearch']);
    unset($mySession->arrFiltro['orden']);
    unset($mySession->arrFiltro['por']);

    $arrString = array('nombre_apellido', 'nro_identidad', 'correo', 'direccion', 'telefono', 'padre', 'madre', 'nro_carton_electoral', 'nro_carton_militante', 'sexo');
    $arrNumeric = array('id_provincia', 'id_municipio', 'id_comuna', 'id_cap', 'id_estado_civil', 'id_nivel_escolar', 'id_profesion', 'id_funcion_trabajo', 'id_organizacion');
    $arrDate = array('fecha_nacimiento');

    $mySession->where['activista'] = Utils::construirFiltro($_POST, $arrString, $arrNumeric, NULL, $arrDate, NULL, $operador = 'OR');
    $mySession->actualizar();

    $url = Utils::construirURL($arrGet);
    header("Location: ../vistas/index.php?frm=" . $casoUso . '&template=lst');
    exit();
}
?>