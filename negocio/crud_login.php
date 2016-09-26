<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
include_once("configuracion/configuracion.php");
include_once("acceso_datos/" . DRIVER_BD . "_acceso_datos.class.php");
include_once("utiles/session.class.php");
include_once("controladores/usuario.class.php");
include_once("controladores/v_permisos_por_usuario.class.php");

//Chequear los datos contra la tabla usuario
if (( isset($_POST["login"]) ) && ( isset($_POST["password"]) )) {
    
    $existe_dominio = FALSE;
    $ds = @ldap_connect(SERVIDOR_LDAP, PUERTO_LDAP);
/*
    if (@ldap_bind($ds, $_POST["login"] . DOMINIO, $_POST["password"])) {
        $existe_dominio = TRUE;
    } */
    if ($existe_dominio === TRUE) {

        $usuario = new Usuarios();
        $where = "usuario='" . $_POST["login"] . "'";
        $usuario->getRecords($where);
        $MyUsuario = $usuario->objConexion->crearArregloObjetos();
        if (is_array($MyUsuario) && count($MyUsuario) > 0) {
            foreach ($MyUsuario as $key) {
                $id_usuario = $key->id;
                $nombre_usuario = $key->usuario;
                $nombre_apellido = $key->nombre_apellido;
                $habilitado = $key->habilitado;
                $id_activista = $key->id_activista;
                $id_grupo = $key->id_grupo;
            }
            if ($habilitado == f) {
                $habilitado = FALSE;
            } else {
                $habilitado = TRUE;
            }

            $session = new Session();
            
            $data = array($nombre_usuario, $nombre_apellido, $_POST["password"], $habilitado, $id_grupo);
            $usuario->updateRecord($id_usuario, $data);

            header("Location: ../vistas/index.php?frm=principal&template=resumen");
            exit();
        } else {
            //Redireccionar a la pagina del login
            header("Location: ../vistas/index.php?frm=login&template=horizontal&error=1");
            exit();
        }
    } else {
        $usuario = new Usuarios();
        $where = "usuario='" . $_POST["login"] . "' AND clave='" . $_POST["password"] . "' ";
        $usuario->getRecords($where);
        $MyUsuario = $usuario->objConexion->crearArregloObjetos();

        if (is_array($MyUsuario) && count($MyUsuario) > 0) {
            $mySession = new Session();
               
            foreach ($MyUsuario as $key => $value) {
                $mySession->idusuario = $value->id;
                $mySession->usuario = $value->usuario;
                $mySession->nombreCompletoUsuario = $value->nombre_apellido;
                $mySession->logeado = true;
                $mySession->t_expirar = TIEMPO_SESION;
                $mySession->idgrupo = $value->id_grupo;
                $habilitado = $value->habilitado;
            }
            
            if ($habilitado == 'f') { 
                //Redireccionar a la pagina del login con mensaje usuario deshabilitado
                header("Location: ../vistas/index.php?frm=login&template=horizontal&error=3");
                exit();            
            }
            
            $myAcceso = new v_Permisos_por_usuario();
            $myAcceso->getRecords( ' id_usuario ='. $value->id);
            $mySession->arrAcceso = $myAcceso->objConexion->crearArregloPorNombreDeFilas();
            $mySession->actualizar();
           //print_r( $mySession->arrAcceso);die();
            
            //Redireccionar a la pagina del login
            header("Location: ../vistas/index.php?frm=principal&template=resumen");
            exit();
        } else {
            //Redireccionar a la pagina del login
            header("Location: ../vistas/index.php?frm=login&template=horizontal&error=1");
            exit();
        }
    }
}

?>