<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
$casoUso = 'mesaelectoral';
include_once("configuracion/configuracion.php");
include_once("acceso_datos/" . DRIVER_BD . "_acceso_datos.class.php");
include_once("utiles/session.class.php");
include_once("utiles/utils.class.php");
include_once("controladores/$casoUso.class.php");
include_once("controladores/funcionmesa.class.php");
include_once("controladores/activista_mesaelectoral.class.php");
include_once("controladores/activista.class.php");
include_once("controladores/mesaelectoral_organizacion.class.php");
include_once("controladores/organizacion.class.php");
include_once("controladores/v_mesaelectoral_organizacion.class.php");
include_once("controladores/mesaelecotoral_funcionario.class.php");
include_once("controladores/asamblea_resultado.class.php");

$mySession = new Session();
//echo "GET -> ".print_r($_GET).'<br>';   
//echo "POST -> ".print_r($_POST).'<br>'.die();   
//El caso de uso (usuario) --- accion --- buscar
$fecha = date('Y-m-d');
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "buscar")) {
    $arrGet = Utils::arrayRecibePOST($_POST['arrGet']);
    $url = Utils::construirURLdeARRAY($_POST, $arrGet, 'arrGet', 'MM_from_mesaelectoral');
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


if ((isset($_POST["MM_from_mesaelectoral"])) && ($_POST["MM_from_mesaelectoral"] == "guardar_nuevo_mesaelectoral")) {

    $id_asamblea = $mySession->obtenerVariable('id_asamblea');
    $arrGet = $mySession->arrFiltro;
    if ($id_asamblea != NULL) {
        $arrGet['frm'] = 'asamblea';
        $arrGet['template'] = 'add';
        $arrGet['id'] = $id_asamblea;
    } else {
        $arrGet['frm'] = 'mesaelectoral';
        $arrGet['template'] = 'lst';
    }

    $url = Utils::construirURL($arrGet);

    $activo = FALSE;

    //-------Inserto en la tabla nmmesaelectoral
    $ObjMesa = new Mesaelectoral();
    $str = array($_POST["desc_mesa"], $activo, $fecha, $_POST["id_asamblea_resultado"], 0, 0, 0, 0);
    $lastInserMesa = $ObjMesa->insertRecord($str);

//----Con esto garantizo las funciones de mesa de los actvistas de esa provincia 
    $objFuncionMesa = new Funcionmesa();
    $objFuncionMesa->getRecords();
    $FuncionMesa = $objFuncionMesa->objConexion->crearArregloObjetos();

    for ($i = 0; $i < count($FuncionMesa); $i++) {
        if ($_POST['nombre_apellido' . $FuncionMesa[$i]->id] != '') {

            $ActivistaMesa = new Mesaelecotoral_funcionario();
            $str_act_mesa = array($lastInserMesa["id"], $_POST['id_funcion_mesa' . $FuncionMesa[$i]->id], $_POST['nombre_apellido' . $FuncionMesa[$i]->id], $_POST['num_carton' . $FuncionMesa[$i]->id], date('Y-m-d'));
            $ActivistaMesa->insertRecord($str_act_mesa);

            $carton_electoral = $_POST['num_carton' . $FuncionMesa[$i]->id];
            $ObjActivista = new Activista();
            $ObjActivista->getRecords('nro_carton_electoral=' . "'$carton_electoral'");
            $Activista = $ObjActivista->objConexion->crearArreglo();

            if (isset($Activista["id"]) && $Activista["id"] > 0) {

                $ObjActivista_mesaelectoral = new Activista_mesaelectoral();
                $str_act_mesa = array($Activista["id"], $lastInserMesa["id"], $_POST['id_funcion_mesa' . $FuncionMesa[$i]->id]);
                $ObjActivista_mesaelectoral->insertRecord($str_act_mesa);
            }
        }
    }
    //Inserto los en la tabla mesaelectoral_organozacion los valores en 0
    $ObjOrg = new Organizaciones();
    $ObjOrg->getRecords();
    $Org = $ObjOrg->objConexion->crearArregloObjetos();

    for ($i = 0; $i < count($Org); $i++) {

        $ObjOrg = new Mesaelectoral_organizacion();
        $str_mesa_org = array($lastInserMesa["id"], $Org[$i]->id, 0);
        $ObjOrg->insertRecord($str_mesa_org);
    }
    header("Location: ../vistas/index.php" . $url);
    exit();
}

//El caso de uso (usuario) --- accion --- clic en el boton eliminar del listado (retorna al listado)
if ((isset($_POST["MM_from"])) && ($_POST["MM_from"] == "eliminar")) {

    $id_asamblea = $mySession->obtenerVariable('id_asamblea');
    $arrGet = $mySession->arrFiltro;
    if ($id_asamblea != NULL) {
        $arrGet['frm'] = 'asamblea';
        $arrGet['template'] = 'add';
        $arrGet['id'] = $id_asamblea;
    } else {
        $arrGet['frm'] = 'mesaelectoral';
        $arrGet['template'] = 'lst';
    }
    $url = Utils::construirURL($arrGet);

    $Obj = new Mesaelectoral();
    //Tratamiento del borrado de elementos seleccionados
    if ((isset($_POST['chkDEL'])) && ($_POST['chkDEL'] != "")) {
        foreach ($_POST['chkDEL'] as $id_delete) {

            $ObjMesa = new Mesaelectoral();
            $ObjMesa->getRecord($id_delete);
            $aDatos = $ObjMesa->objConexion->crearArreglo();
            //Aki obtengo los votos antiguos de la mesa
            $votos_blanco_old_mesa = $aDatos["votos_blanco"];
            $votos_nulos_old_mesa = $aDatos["votos_nulos"];
            $votos_reclamados_old_mesa = $aDatos["votos_reclamados"];
            $votos_validos_old_mesa = $aDatos["votos_validos"];
            $id_asamblea_resultado = $aDatos["id_asamblea_resultado"];

            //Aki hago la consulta en Asamblea resultado para darle update a los valores de los votos.
            //cojo los viejos de los 2 y los resto y luego le sumo lo que recivo por POST;
            $ObjAsamblea_result = new Asamblea_resultado();
            $ObjAsamblea_result->getRecord($id_asamblea_resultado);
            $aDatosAsamblea_result = $ObjAsamblea_result->objConexion->crearArreglo();

            $id_asamblea = $aDatosAsamblea_result["id_asamblea"];
            $id_usuario = $aDatosAsamblea_result["id_usuario"];
            $fecha_cierre = $aDatosAsamblea_result["fecha_cierre"];

            $votos_blanco_asamblea_result = $aDatosAsamblea_result["votos_blanco"];
            $votos_nulos_asamblea_result = $aDatosAsamblea_result["votos_nulos"];
            $votos_reclamados_asamblea_result = $aDatosAsamblea_result["votos_reclamados"];
            $votos_validos_asamblea_result = $aDatosAsamblea_result["votos_validos"];

            $cerrada = 0;
            $confirmada = 0;
            $electores_registrados = $aDatosAsamblea_result["electores_registrados"];

            if ($votos_blanco_asamblea_result > 0) {
                $nuevo_voto_blanco_asamblea = ($votos_blanco_asamblea_result - $votos_blanco_old_mesa );
            } else {
                $nuevo_voto_blanco_asamblea = 0;
            }

            if ($votos_nulos_asamblea_result > 0) {
                $nuevo_voto_nulos_asamblea = ($votos_nulos_asamblea_result - $votos_nulos_old_mesa );
            } else {
                $nuevo_voto_nulos_asamblea = 0;
            }

            if ($votos_reclamados_asamblea_result > 0) {
                $nuevo_voto_reclamados_asamblea = ($votos_reclamados_asamblea_result - $votos_reclamados_old_mesa );
            } else {
                $nuevo_voto_reclamados_asamblea = 0;
            }

            if ($votos_validos_asamblea_result > 0) {
                $nuevo_voto_validos_asamblea = ($votos_validos_asamblea_result - $votos_validos_old_mesa );
            } else {
                $nuevo_voto_validos_asamblea = 0;
            }
            //Actualizzo los votos en la tabla asamblea_resultado
            $str_asamblea_resultado = array($id_asamblea, $id_usuario, $fecha_cierre, $nuevo_voto_blanco_asamblea, $nuevo_voto_nulos_asamblea, $nuevo_voto_reclamados_asamblea, $nuevo_voto_validos_asamblea, $cerrada, $confirmada, $electores_registrados);
            $ObjAsamblea_result->updateRecord($id_asamblea_resultado, $str_asamblea_resultado);
            
            //elimino la mesa
            $Obj->deleteRecord($id_delete);
        }
    }
    $url = Utils::construirURL($arrGet);
    header("Location: ../vistas/index.php" . $url);
    exit();
}

//El caso de uso (usuario) --- accion --- clic en el boton guardar del formulario add (retorna al listado)
if ((isset($_POST["MM_from_mesaelectoral"])) && ($_POST["MM_from_mesaelectoral"] == "actualizar_mesaelectoral")) {

    $id_asamblea = $mySession->obtenerVariable('id_asamblea');
    $arrGet = $mySession->arrFiltro;
    if ($id_asamblea != NULL) {
        $arrGet['frm'] = 'asamblea';
        $arrGet['template'] = 'add';
        $arrGet['id'] = $id_asamblea;
    } else {
        $arrGet['frm'] = 'mesaelectoral';
        $arrGet['template'] = 'lst';
    }
    $url = Utils::construirURL($arrGet);

    if ($_POST["activo"] == 'on') {
        $activo = TRUE;
    } else {
        $activo = FALSE;
    }


    //actulizo los votos validos en la tabla asamblea_resultados.
    $ObjMesa = new Mesaelectoral();
    $ObjMesa->getRecord($_POST['id']);
    $aDatos = $ObjMesa->objConexion->crearArreglo();
    //Aki obtengo los votos antiguos de la mesa
    $votos_blanco_old_mesa = $aDatos["votos_blanco"];
    $votos_nulos_old_mesa = $aDatos["votos_nulos"];
    $votos_reclamados_old_mesa = $aDatos["votos_reclamados"];
    $votos_validos_old_mesa = $aDatos["votos_validos"];

    $id_asamblea_resultado = $aDatos["id_asamblea_resultado"];

    //Aki hago la consulta en Asamblea resultado para darle update a los valores de los votos.
    //cojo los viejos de los 2 y los resto y luego le sumo lo que recivo por POST;
    $ObjAsamblea_result = new Asamblea_resultado();
    $ObjAsamblea_result->getRecord($id_asamblea_resultado);
    $aDatosAsamblea_result = $ObjAsamblea_result->objConexion->crearArreglo();

    $id_asamblea = $aDatosAsamblea_result["id_asamblea"];
    $id_usuario = $aDatosAsamblea_result["id_usuario"];
    $fecha_cierre = $aDatosAsamblea_result["fecha_cierre"];

    $votos_blanco_asamblea_result = $aDatosAsamblea_result["votos_blanco"];
    $votos_nulos_asamblea_result = $aDatosAsamblea_result["votos_nulos"];
    $votos_reclamados_asamblea_result = $aDatosAsamblea_result["votos_reclamados"];
    $votos_validos_asamblea_result = $aDatosAsamblea_result["votos_validos"];

    $cerrada = 0;
    $confirmada = 0;
    $electores_registrados = $aDatosAsamblea_result["electores_registrados"];

    if ($votos_blanco_asamblea_result > 0) {
        $nuevo_voto_blanco_asamblea = ($votos_blanco_asamblea_result - $votos_blanco_old_mesa ) + $_POST["votos_blanco"];
    } else {
        $nuevo_voto_blanco_asamblea = $_POST["votos_blanco"];
    }

    if ($votos_nulos_asamblea_result > 0) {
        $nuevo_voto_nulos_asamblea = ($votos_nulos_asamblea_result - $votos_nulos_old_mesa ) + $_POST["votos_nulos"];
    } else {
        $nuevo_voto_nulos_asamblea = $_POST["votos_nulos"];
    }

    if ($votos_reclamados_asamblea_result > 0) {
        $nuevo_voto_reclamados_asamblea = ($votos_reclamados_asamblea_result - $votos_reclamados_old_mesa ) + $_POST["votos_reclamados"];
    } else {
        $nuevo_voto_reclamados_asamblea = $_POST["votos_reclamados"];
    }

    if ($votos_validos_asamblea_result > 0) {
        $nuevo_voto_validos_asamblea = ($votos_validos_asamblea_result - $votos_validos_old_mesa ) + $_POST["votos_validos"];
    } else {
        $nuevo_voto_validos_asamblea = $_POST["votos_validos"];
    }

    //update en la tabla mesa electoral----------------
    $str = array($_POST["desc_mesa"], $activo, $fecha, $_POST["id_asamblea_resultado"], $_POST["votos_blanco"], $_POST["votos_nulos"], $_POST["votos_reclamados"], $_POST["votos_validos"]);
    $ObjMesa->updateRecord($_POST['id'], $str);

    //Actualizzo los votos en la tabla asamblea_resultado
    $str_asamblea_resultado = array($id_asamblea, $id_usuario, $fecha_cierre, $nuevo_voto_blanco_asamblea, $nuevo_voto_nulos_asamblea, $nuevo_voto_reclamados_asamblea, $nuevo_voto_validos_asamblea, $cerrada, $confirmada, $electores_registrados);
    $ObjAsamblea_result->updateRecord($id_asamblea_resultado, $str_asamblea_resultado);

    //Elimino las funciones de mesa de los activista de esa mesa
    $ActivistaMesa = new Activista_mesaelectoral();
    $sqlDelete = "DELETE FROM activista_mesaelectoral WHERE id_mesaelectoral = " . $_POST['id'];
    $ActivistaMesa->objConexion->realizarConsulta($sqlDelete);

    //Elimino los fucnionarios que pertenecen a esa mesa
    $FuncionarioMesa = new Mesaelecotoral_funcionario();
    $sqlDelete = "DELETE FROM mesaelecotoral_funcionario WHERE id_mesa = " . $_POST['id'];
    $FuncionarioMesa->objConexion->realizarConsulta($sqlDelete);

//Actualizo las nevas funciones de mesa
    $objFuncionMesa = new Funcionmesa();
    $objFuncionMesa->getRecords();
    $FuncionMesa = $objFuncionMesa->objConexion->crearArregloObjetos();

    for ($i = 0; $i < count($FuncionMesa); $i++) {
        if ($_POST['nombre_apellido' . $FuncionMesa[$i]->id] != '') {

            $ActivistaMesa = new Mesaelecotoral_funcionario();
            $str_act_mesa = array($_POST['id'], $_POST['id_funcion_mesa' . $FuncionMesa[$i]->id], $_POST['nombre_apellido' . $FuncionMesa[$i]->id], $_POST['num_carton' . $FuncionMesa[$i]->id], date('Y-m-d'));
            $ActivistaMesa->insertRecord($str_act_mesa);

            $carton_electoral = $_POST['num_carton' . $FuncionMesa[$i]->id];
            $ObjActivista = new Activista();
            $ObjActivista->getRecords('nro_carton_electoral=' . "'$carton_electoral'");
            $Activista = $ObjActivista->objConexion->crearArreglo();

            if (isset($Activista["id"]) && $Activista["id"] > 0) {

                $ObjActivista_mesaelectoral = new Activista_mesaelectoral();
                $str_act_mesa = array($Activista["id"], $_POST['id'], $_POST['id_funcion_mesa' . $FuncionMesa[$i]->id]);
                $ObjActivista_mesaelectoral->insertRecord($str_act_mesa);
            }
        }
    }

    //Esto es para actulizar los votos
    $id_mesa = $_POST['id'];
    $ObjMesaOrgan = new v_Mesaelectoral_organizacion();
    $ObjMesaOrgan->getRecords('id_mesa=' . "'$id_mesa'");
    $MesaOrgan = $ObjMesaOrgan->objConexion->crearArregloObjetos();

    for ($i = 0; $i < count($MesaOrgan); $i++) {

        $ObjMesaOrg = new Mesaelectoral_organizacion();

        $str = array($_POST['id'], $MesaOrgan[$i]->id_organizacion, $_POST['voto_efectuado' . $MesaOrgan[$i]->id]);
        $condition = 'id_mesa =' . $_POST['id'];

        $ObjMesaOrg->updateRecord_by_condition($MesaOrgan[$i]->id, $condition, $str);
    }
    header("Location: ../vistas/index.php" . $url);
    exit();
}
?>