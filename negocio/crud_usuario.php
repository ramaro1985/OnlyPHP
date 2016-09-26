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

//echo "GET -> ".print_r($_GET).'<br>';   
echo "POST -> " . print_r($_POST) . '<br>';

$casoUso = 'usuario';

if (isset($_POST["redirect_password"]) && $_POST["redirect_password"] != '') {
    header("Location: ../vistas/index.php?frm=modificarclave&template=horizontal&id_usuario=" . $_POST["id"]);
    exit();
}

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
    //$arrGet = Utils::arrayRecibePOST($_POST['arrGet']);
    $arrGet = $mySession->arrFiltro;
    $arrGet['frm'] = $casoUso;
    $arrGet['template'] = 'lst';
    $url = Utils::construirURL($arrGet);
    //$url = Utils::construirURLdeARRAY($_POST, $arrGet, 'arrGet', 'MM_from');
    $nuevoUsuario = new Usuarios();
    $str = array($_POST["usuario"], $_POST["nombre_completo"], $_POST["clave"], 'true');

    //Se obtiene la tupla del usuario insertado
    $lastInsertUser = $nuevoUsuario->insertRecord($str);

    //Se procede a elimiar los grupos a los cuales pertece
    $nuevosGrupos = new Grupogestion_usuario();
    $sqlDelete = "DELETE FROM grupogestion_usuario WHERE id_usuario = " . $lastInsertUser["id"];
    $nuevosGrupos->objConexion->realizarConsulta($sqlDelete);

    //Se procede a insertar los grupos nuevos o actualizados
    if ((isset($_POST['incluido'])) && ($_POST['incluido'] != "")) {
        foreach ($_POST['incluido'] as $item) {
            $dataInsert = array($item, $lastInsertUser["id"]);
            $nuevosGrupos->insertRecord($dataInsert);
        }
    }
    header("Location: ../vistas/index.php" . $url);
    exit();
}

//El caso de uso (usuario) --- accion --- clic en el boton eliminar del listado (retorna al listado)
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "eliminar")) {
    //$arrGet = Utils::arrayRecibePOST($_POST['arrGet']);
    $arrGet = $mySession->arrFiltro;
    $url = Utils::construirURL($arrGet);
    //    $url = Utils::construirURLdeARRAY($_POST, $arrGet, 'arrGet', 'MM_from');
    //Se procede a elimiar los grupos a los cuales pertece
    $Grupos = new Grupogestion_usuario();
    $Usuario = new Usuarios();
    //Tratamiento del borrado de elementos seleccionados
    if ((isset($_POST['chkDEL'])) && ($_POST['chkDEL'] != "")) {
        foreach ($_POST['chkDEL'] as $id_delete) {
            $Grupos->objConexion->realizarConsulta("DELETE FROM grupogestion_usuario WHERE id_usuario = " . $id_delete);
            $Usuario->deleteRecord($id_delete);
        }
    }
    header("Location: ../vistas/index.php" . $url);
    exit();
}

//El caso de uso (usuario) --- accion --- clic en el boton guardar del formulario add (retorna al listado)
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "actualizar")) {
    //$arrGet = Utils::arrayRecibePOST($_POST['arrGet']);
    $arrGet = $mySession->arrFiltro;
    $arrGet['frm'] = $casoUso;
    $arrGet['template'] = 'lst';
    $url = Utils::construirURL($arrGet);
    //$url = Utils::construirURLdeARRAY($_POST, $arrGet, 'arrGet', 'MM_from');
    $updateUser = new Usuarios();
    $str = array($_POST["usuario"], $_POST["nombre_completo"], $_POST["pass"], $_POST["habilitado"]);

    //Se actualiza la tupla del usuario a modificar
    $updateUser->updateRecord($_POST['id'], $str);

    //Se procede a elimiar los grupos a los cuales pertece
    $nuevosGrupos = new Grupogestion_usuario();
    $sqlDelete = "DELETE FROM grupogestion_usuario WHERE id_usuario = " . $_POST['id'];
    $nuevosGrupos->objConexion->realizarConsulta($sqlDelete);

    //Se procede a insertar los grupos nuevos o actualizados
    if ((isset($_POST['incluido'])) && ($_POST['incluido'] != "")) {
        foreach ($_POST['incluido'] as $item) {
            $dataInsert = array($item, $_POST['id']);
            $nuevosGrupos->insertRecord($dataInsert);
        }
    }

    header("Location: ../vistas/index.php" . $url);
    exit();
}
?>