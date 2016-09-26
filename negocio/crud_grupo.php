<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
$casoUso = 'grupo';
include_once("configuracion/configuracion.php");
include_once("acceso_datos/" . DRIVER_BD . "_acceso_datos.class.php");
include_once("utiles/session.class.php");
include_once("utiles/utils.class.php");
include_once("controladores/" . $casoUso . ".class.php");
include_once("controladores/caso_uso.class.php");
include_once("controladores/funcionalidad.class.php");
include_once("controladores/v_caso_uso_funcionalidad.class.php");
include_once("controladores/funcionalidad_grupo_gestion.class.php");

$mySession = new Session();

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
    //$arrGet = Utils::arrayRecibePOST($_POST['arrGet']);
    $arrGet = $mySession->arrFiltro;
    $arrGet['frm'] = $casoUso;
    $arrGet['template'] = 'lst';
    $url = Utils::construirURL($arrGet);
    //$url = Utils::construirURLdeARRAY($_POST, $arrGet, 'arrGet', 'MM_from');
    $nuevoGrupo = new Grupos();
    $str = array($_POST["grupo"], $_POST["descripcion"], $_POST["habilitado"]);

    //Se obtiene la tupla del grupo insertado
    $lastInsertGrupo = $nuevoGrupo->insertRecord($str);

    //Se procede a elimiar las funcionalidades a las que tiene permiso
    $nuevasFuncionalidades = new Funcionalidad_grupo_gestion();
    $sqlDelete = "DELETE FROM funcionalidad_grupo_gestion WHERE id_grupo_gestion = " . $lastInsertGrupo["id"];
    $nuevasFuncionalidades->objConexion->realizarConsulta($sqlDelete);

    //Se procede a insertar las nuevas funcionalidades a las que tiene permiso el grupo
    if ((isset($_POST['incluido'])) && ($_POST['incluido'] != "")) {
        foreach ($_POST['incluido'] as $item) {
            $dataInsert = array($lastInsertGrupo["id"], $item);
            $nuevasFuncionalidades->insertRecord($dataInsert);
        }
    }
    header("Location: ../vistas/index.php" . $url);
    exit();
}

//El caso de uso (grupo) --- accion --- clic en el boton eliminar del listado (retorna al listado)
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "eliminar")) {
    $arrGet = $mySession->arrFiltro;
    $url = Utils::construirURL($arrGet);
    $myObj = new Grupos();
    //Tratamiento del borrado de elementos seleccionados
    if ((isset($_POST['chkDEL'])) && ($_POST['chkDEL'] != "")) {
        foreach ($_POST['chkDEL'] as $id_delete) {
            if ($id_delete != 2) {
                $myObj->deleteRecord($id_delete);
            }
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
    //$url = Utils::construirURLdeARRAY($_POST, $arrGet, 'arrGet', 'MM_from');
    $url = Utils::construirURL($arrGet);

    $updateGrupo = new Grupos();
    $str = array($_POST["grupo"], $_POST["descripcion"], $_POST["habilitado"]);
    $updateGrupo->updateRecord($_POST['id'], $str);

    //Se actualiza la tupla del usuario a modificar
    $updateGrupo->updateRecord($_POST['id'], $str);

    //Se procede a elimiar los grupos a los cuales pertece
    $nuevasFuncionalidades = new Funcionalidad_grupo_gestion();
    $sqlDelete = "DELETE FROM funcionalidad_grupo_gestion WHERE id_grupo_gestion = " . $_POST['id'];
    $nuevasFuncionalidades->objConexion->realizarConsulta($sqlDelete);

    //Se procede a insertar los grupos nuevos o actualizados
    if ((isset($_POST['incluido'])) && ($_POST['incluido'] != "")) {
        foreach ($_POST['incluido'] as $item) {
            $dataInsert = array($_POST['id'], $item);
            $nuevasFuncionalidades->insertRecord($dataInsert);
        }
    }

    header("Location: ../vistas/index.php" . $url);
    exit();
}
?>