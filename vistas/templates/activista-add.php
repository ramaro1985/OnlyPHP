<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
include_once("utiles/session.class.php");
$mySession = new Session();
$casoUso = 'activista';
require 'Zebra_Form.php';
include_once("utiles/utils.class.php");
include_once("idioma/pt.php");
include_once("controladores/provincia.class.php");
include_once("controladores/municipio.class.php");
include_once("controladores/comuna.class.php");
include_once("controladores/cap.class.php");
include_once("controladores/v_cap_buscar.class.php");
include_once("controladores/v_activista_buscar.class.php");
include_once("controladores/estadocivil.class.php");
include_once("controladores/organizacion.class.php");
include_once("controladores/profesion.class.php");
include_once("controladores/funciontrabajo.class.php");
include_once("controladores/nivelescolar.class.php");
include_once("controladores/funcionmesa.class.php");
include_once("controladores/dialecto.class.php");
include_once("controladores/usuario.class.php");
include_once("controladores/" . $casoUso . ".class.php");

if (isset($_GET["id"]) && ($_GET["id"] == 0)) {
    echo Utils::getDivTitulo($label["nuevo_actvista"]);
    //cargar los datos a modificar    
    $id = 0;
    $id_provincia = 0;
    $id_municipio = 0;
    $id_comuna = 0;
    $id_cap = 0;
    $id_estado_civil = 0;
    $estado_civil = 0;
    $org_partidista = 0;
    $profesion = 0;
    $nivel_escolar = 0;
    $nro_carton_militante = '';
    $nro_identidad = '';
    $nro_carton_electoral = '';
    $nombre_apellido = '';
    $direccion = '';
    $correo = '';
    $telefono = '';
    $sexo = '';
    $padre = '';
    $madre = '';
    $fecha_nacimiento = '';
    $mySession->registrarVariable('id_activista', 0);


    $MM_from = 'guardar_nuevo';
} else {
    echo Utils::getDivTitulo($label["modificar_activista"]);
    //cargar los datos a modificar
    $MyObj = new v_Actvista_buscar();
    $MyObj->getRecord($_GET["id"]);
    $aDatos = $MyObj->objConexion->crearArreglo();

    $id = $aDatos['id'];
    $id_provincia = $aDatos['id_provincia'];
    $id_municipio = $aDatos['id_municipio'];
    $id_comuna = $aDatos['id_comuna'];
    $id_cap = $aDatos['id_cap'];
    $cap = $aDatos['cap'];
    $id_estado_civil = $aDatos['id_estado_civil'];
    $estado_civil = $aDatos['estado_civil'];
    $org_partidista = $aDatos['org_partidista'];
    $profesion = $aDatos['profesion'];
    $nivel_escolar = $aDatos['nivel_escolar'];
    $nro_carton_militante = $aDatos['nro_carton_militante'];
    $nro_identidad = $aDatos['nro_identidad'];
    $nro_carton_electoral = $aDatos['nro_carton_electoral'];
    $nombre_apellido = $aDatos['nombre_apellido'];
    $direccion = $aDatos['direccion'];
    $correo = $aDatos['correo'];
    $telefono = $aDatos['telefono'];
    $sexo = $aDatos['sexo'];
    $padre = $aDatos['padre'];
    $madre = $aDatos['madre'];
    $fecha_nacimiento = $aDatos['fecha_nacimiento'];
    $id_organizacion = $aDatos['id_organizacion'];
    $id_profesion = $aDatos['id_profesion'];
    $id_funcion_trabajo = $aDatos['id_funcion_trabajo'];
    $id_nivel_escolar = $aDatos['id_nivel_escolar'];

    $mySession->registrarVariable('id_activista', $id);

    $MM_from = 'actualizar';
}

switch ($_GET["error"]) {
    case 1:
        if ($_GET["tipo_error"] == 'insertar_update') {
            $error = $label["error_insertar_update"] . $label["nro_identidad"] . $label['seleccionado'];
            echo Utils::getDivErrorLogin($error);
        }
        break;
    case 2:
        if ($_GET["tipo_error"] == 'formato_error') {
            $error = $label["error_tipo_error"];
            echo Utils::getDivErrorLogin($error);
        }
        break;
    case 3:
        if ($_GET["tipo_error"] == 'insertar_usuario') {
            $error = $label["insertar_usuario"];
            echo Utils::getDivErrorLogin($error);
        }break;
    default:
        echo Utils::getDivError($label["usuario_pass_incorrecto"]);
        break;
}

// instantiate a Zebra_Form object
$form = new Zebra_Form('form', 'POST', '../negocio/crud_' . $casoUso . '.php', array('onsubmit' => 'return addUsuario();'));

// obj provincias
$id_usuario_loguin = $mySession->obtenerVariable('idusuario');
$arrAcceso = $mySession->arrAcceso;
$id_grupo_gestion = $arrAcceso[0]['id_grupo_gestion'];

$ObjUsuario = new Usuarios();
$ObjUsuario->getRecords('id=' . "'$id_usuario_loguin'");
$aDatos = $ObjUsuario->objConexion->crearArreglo();
$id_activista_loguin = $aDatos['id_activista'];

if ($id_grupo_gestion != 2 && $id_activista_loguin != NULL) {

    $ObjActivista = new v_Actvista_buscar();
    $ObjActivista->getRecords('id=' . "'$id_activista_loguin'");
    $aDatos = $ObjActivista->objConexion->crearArreglo();
    $id_provincia = $aDatos['id_provincia'];
}
$form->add('label', 'label_id_provincia', 'id_provincia', $label["id_provincia"]);

$obj = & $form->add('select', 'id_provincia', $id_provincia, array(
            'onchange' => 'cargarDatosSelect(\'id_provincia\', \'id_municipio\',\'' . $label["cargando"] . '\', \'Municipios\', \'id_provincia\', \'municipio\', 2);',
            'style' => 'width:150px'
        ));

$obj->set_rule(array(
    'required' => array('error', $label["provincia_obligatorio"])
));

if ($id_grupo_gestion != 2 && $id_activista_loguin != NULL) {
    $ObjActivista = new v_Actvista_buscar();
    $ObjActivista->getRecords('id=' . "'$id_activista_loguin'");
    $aDatos = $ObjActivista->objConexion->crearArreglo();
    $id_provincia = $aDatos['id_provincia'];

    $objProvincia = new Provincias();
    $Datos = $objProvincia->getRecords('id=' . "'$id_provincia'");
    $objDatos = $objProvincia->objConexion->crearArregloObjetos();
    $myArray = Utils::getArrayForSelect($objDatos, 'id', 'provincia', $label["seleccione_uno"]);
} else {
    $objProvincia = new Provincias();
    $Datos = $objProvincia->getRecords();
    $objDatos = $objProvincia->objConexion->crearArregloObjetos();
    $myArray = Utils::getArrayForSelect($objDatos, 'id', 'provincia', $label["seleccione_uno"]);
}


$obj->add_options($myArray, true);

//la etiqueta para el obj Municipios
$form->add('label', 'label_id_municipio', 'id_municipio', $label["id_municipio"]);

$obj = & $form->add('select', 'id_municipio', $id_municipio, array(
            'onchange' => 'cargarDatosSelect(\'id_municipio\', \'id_comuna\', \'' . $label["cargando"] . '\', \'Comunas\', \'id_municipio\', \'comuna\', 2);',
            'style' => 'width:150px'
        ));

if ($id > 0) {
    $objMunicipio = new Municipios();
    $Datos = $objMunicipio->getRecords('id_provincia=' . $id_provincia);
    $objDatos = $objMunicipio->objConexion->crearArregloObjetos();
    $myArray = Utils::getArrayForSelect($objDatos, 'id', 'municipio', $label["seleccione_uno"]);

    $obj->add_options($myArray, true);
} else {
    $obj->add_options(array('' => $label["seleccione_uno"]), true);
};
$obj->set_rule(array(
    'required' => array('error', $label["municipio_obligatorio"])
));

// obj Comunas
$form->add('label', 'label_id_comuna', 'id_comuna', $label["id_comuna"]);

$obj = & $form->add('select', 'id_comuna', $id_comuna, array(
            'onchange' => 'cargarDatosSelect(\'id_comuna\', \'id_cap\', \'' . $label["cargando"] . '\', \'Cap\', \'id_comuna\', \'cap\', 2);',
            'style' => 'width:150px'
        ));

if ($id > 0) {
    $objComuna = new Comunas();
    $Datos = $objComuna->getRecords('id_municipio=' . $id_municipio);
    $objDatos = $objComuna->objConexion->crearArregloObjetos();
    $myArray = Utils::getArrayForSelect($objDatos, 'id', 'comuna', $label["seleccione_uno"]);

    $obj->add_options($myArray, true);
} else {
    $obj->add_options(array('' => $label["seleccione_uno"]), true);
}
$obj->set_rule(array(
    'required' => array('error', $label["comuna_obligatorio"])
));
//obj cap
$form->add('label', 'label_id_cap', 'id_cap', $label["id_cap"]);

$obj = & $form->add('select', 'id_cap', $id_cap, array('style' => 'width:150px'));

if ($id > 0) {
    $objCap = new Cap();
    $Datos = $objCap->getRecords('id_comuna=' . $id_comuna);
    $objDatos = $objCap->objConexion->crearArregloObjetos();
    $myArray = Utils::getArrayForSelect($objDatos, 'id', 'cap', $label["seleccione_uno"]);

    $obj->add_options($myArray, true);
} else {
    $obj->add_options(array('' => $label["seleccione_uno"]), true);
}
$obj->set_rule(array(
    'required' => array('error', $label["cap_obligatorio"])
));

// Estado civil
$form->add('label', 'label_estado_civil', 'estado_civil', $label["estado_civil"]);

$obj = & $form->add('select', 'estado_civil', $id_estado_civil, array('style' => 'width:150px'));

$objEstadoCivil = new Estadocivil();
$Datos = $objEstadoCivil->getRecords();
$objDatos = $objEstadoCivil->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'estado_civil', $label["seleccione_uno"]);

$obj->add_options($myArray, true);

$obj->set_rule(array(
    'required' => array('error', $label["estado_civil_obligatorio"])
));

//Organizacion
$form->add('label', 'label_org_partidista', 'org_partidista', $label["org_partidista"]);

$obj = & $form->add('select', 'org_partidista', $id_organizacion, array('style' => 'width:150px'));

$objOrganizacion = new Organizaciones();
$Datos = $objOrganizacion->getRecords();
$objDatos = $objOrganizacion->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'org_partidista', $label["seleccione_uno"]);

$obj->add_options($myArray, true);


$obj->set_rule(array(
    'required' => array('error', $label["org_partidista_obligatorio"])
));

// Combo para profesion
$form->add('label', 'label_profesion', 'profesion', $label["profesion"]);

$obj = & $form->add('select', 'profesion', $id_profesion, array('style' => 'width:150px'));

$objProfesion = new Profesiones();
$Datos = $objProfesion->getRecords();
$objDatos = $objProfesion->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'profesion', $label["seleccione_uno"]);

$obj->add_options($myArray, true);

$obj->set_rule(array(
    'required' => array('error', $label["profesion_obligatorio"])
));

// funcion de trabajo
$form->add('label', 'label_funcion_trabajo', 'funcion_trabajo', $label["funcion_trabajo"]);

$obj = & $form->add('select', 'funcion_trabajo', $id_funcion_trabajo, array('style' => 'width:150px'));

$objFuncionTrabajo = new Funciontrabajo();
$Datos = $objFuncionTrabajo->getRecords();
$objDatos = $objFuncionTrabajo->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'funcion_trabajo', $label["seleccione_uno"]);

$obj->add_options($myArray, true);

$obj->set_rule(array(
    'required' => array('error', $label["funcion_trabajo_obligatorio"])
));

//Para Nivel escolar
$form->add('label', 'label_nivel_escolar', 'nivel_escolar', $label["nivel_escolar"]);

$obj = & $form->add('select', 'nivel_escolar', $id_nivel_escolar, array('style' => 'width:152px'));

$objNivelEscolar = new Nivelescolar();
$Datos = $objNivelEscolar->getRecords();
$objDatos = $objNivelEscolar->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'nivel_escolar', $label["seleccione_uno"]);

$obj->add_options($myArray, true);

$obj->set_rule(array(
    'required' => array('error', $label["nivel_escolar_obligatorio"])
));


$form->add('label', 'label_nro_carton_militante', 'nro_carton_militante', $label["nro_carton_militante"]);

$obj = & $form->add('text', 'nro_carton_militante', $nro_carton_militante, array('style' => 'width:150px'));

//Para el numero de identidad
$form->add('label', 'label_nro_identidad', 'nro_identidad', $label["nro_identidad"]);

$obj = & $form->add('text', 'nro_identidad', $nro_identidad, array('style' => 'width:140px'));

// Numero de Carton electoral
$form->add('label', 'label_nro_carton_electoral', 'nro_carton_electoral', $label["nro_carton_electoral"]);

$obj = & $form->add('text', 'nro_carton_electoral', $nro_carton_electoral, array('style' => 'width:150px'));

//Nombre y apellidos
$form->add('label', 'label_nombre_completo', 'nombre_completo', $label["nombre_completo"]);

$obj = & $form->add('text', 'nombre_completo', $nombre_apellido, array('style' => 'width:220px'));

$obj->set_rule(array(
    'required' => array('error', $label["nombre_completo_obligatorio"]),
));

//Direccion 
$form->add('label', 'label_direccion', 'direccion', $label["direccion"]);

$obj = & $form->add('text', 'direccion', $direccion, array('style' => 'width:297px'));

//Correo
$form->add('label', 'label_correo', 'correo', $label["correo"]);

$obj = & $form->add('text', 'correo', $correo, array('style' => 'width:300px'));

$obj->set_rule(array(
    'email' => array('error', $label["tipo_correo"]),
));

//telefono
$form->add('label', 'label_telefono', 'telefono', $label["telefono"]);

$obj = & $form->add('text', 'telefono', $telefono, array('style' => 'width:140px'));

$obj->set_rule(array(
    'digits' => array('error', $label["telefono_numeros"]),
));

//Sexo
$form->add('label', 'label_sexo', 'sexo', $label['sexo']);

$obj = & $form->add('radios', 'sexo', array(
            'F' => 'Mulher',
            'M' => 'Homem',
                ), array('checked' => $sexo));

$obj->set_rule(array(
    'required' => array('error', $label["sexo_obligatorio"])
));

//Padre
$form->add('label', 'label_padre', 'padre', $label["padre"]);

$obj = & $form->add('text', 'padre', $padre, array('style' => 'width:302px'));

//Madre
$form->add('label', 'label_madre', 'madre', $label["madre"]);

$obj = & $form->add('text', 'madre', $madre, array('style' => 'width:302px'));

//Fecha de nacimiento
if ($fecha_nacimiento != '') {
    $fecha_nacimiento = split(' ', $fecha_nacimiento);
}
$form->add('label', 'label_fecha_nacimiento', 'fecha_nacimiento', $label["fecha_nacimiento"]);

$date = & $form->add('date', 'fecha_nacimiento', $fecha_nacimiento[0], array('style' => 'width:140px'));

$date->format('Y-m-d');

$date->set_rule(array(
    'date' => array('error', $label['fecha_nacimiento_incorrecta']),
));

$form->add('label', 'label_otros', 'otros', $label["otros"]);
$form->add('label', 'label_datos_generales', 'datos_generales', $label["datos_generales"]);
$form->add('label', 'label_datos_personales', 'datos_personales', $label["datos_personales"]);
$form->add('label', 'label_datos_laborales', 'datos_laborales', $label["datos_laborales"]);
$form->add('label', 'label_datos_electorales', 'datos_electorales', $label["datos_electorales"]);
$form->add('label', 'label_foto_activista', 'foto_activista', $label["foto_activista"]);

///----------Dialectos------------//
// "Grupos disponibles"
$form->add('label', 'label_dialecto_disponible', 'dialecto_disponible', $label["dialecto_disponible"]);

$obj = &$form->add('select', 'disponible', '', array('multiple' => 'multiple', 'size' => '12', 'style' => 'width:250px'));
$disponibles = new Dialecto();
$sqlDisponibles = "SELECT id, dialecto FROM nmdialecto WHERE nmdialecto.id NOT IN ";
$sqlDisponibles .= " ( SELECT id_dialecto FROM activista_dialecto WHERE activista_dialecto.id_activista = " . $id . ")";
$Datos = $disponibles->objConexion->realizarConsulta($sqlDisponibles);
$objDatos = $disponibles->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'dialecto');
$obj->add_options($myArray, true);

//"Grupos incluidos"
$form->add('label', 'label_dialecto_incluido', 'dialecto_incluido', $label["dialecto_incluido"]);

$obj = & $form->add('select', 'incluido[]', '', array('multiple' => 'multiple', 'size' => '12', 'style' => 'width:250px'));
$incluidos = new Dialecto();
$arrIncluido = array();
$sqlIncluidos = "SELECT id, dialecto FROM nmdialecto WHERE nmdialecto.id IN ";
$sqlIncluidos .= " ( SELECT id_dialecto FROM activista_dialecto WHERE activista_dialecto.id_activista = " . $id . ")";
$Datos = $incluidos->objConexion->realizarConsulta($sqlIncluidos);
$objDatos = $incluidos->objConexion->crearArregloObjetos();
$arrIncluido = Utils::getArrayForSelect($objDatos, 'id', 'dialecto');
$obj->add_options($arrIncluido, true);

// "boton >"
$form->add('button', 'pasaruno', '&gt;', array(
    'type' => 'button',
    'onclick' => 'moveDualList( document.getElementById(\'disponible\'),  document.getElementById(\'incluido\'), false );',
    'title' => $label["pasaruno"], 'style' => 'width: 100%;'
));

// "boton >>"
$form->add('button', 'pasartodos', '&gt;&gt;', array(
    'type' => 'button',
    'onclick' => 'moveDualList( this.form.disponible,  document.getElementById(\'incluido\'), true );',
    'title' => $label["pasartodos"], 'style' => 'width: 100%;'
));

// "boton <"
$form->add('button', 'retornaruno', '&lt;', array(
    'type' => 'button',
    'onclick' => 'moveDualList( document.getElementById(\'incluido\'), this.form.disponible, false );',
    'title' => $label["retornaruno"], 'style' => 'width: 100%;'
));

// "boton <<"
$form->add('button', 'retornartodos', '&lt;&lt;', array(
    'type' => 'button',
    'onclick' => 'moveDualList( document.getElementById(\'incluido\'), this.form.disponible, true );',
    'title' => $label["retornartodos"], 'style' => 'width: 100%;'
));

$form->add('label', 'label_foto_activista', 'foto_activista', $label["foto_activista"]);
$obj = & $form->add('file', 'foto_activista', 'foto_activista', array('class' => 'file'));

$form->add('label', 'label_remember_me_yes', 'remember_me_yes', $label["es_usuario"]);

$form->add('label', 'label_usuario', 'usuario', $label["usuario"]);
$form->add('text', 'usuario', '', $label["usuario"]);

$form->add('label', 'label_clave', 'clave', $label["clave"]);
$form->add('password', 'clave', '', $label["clave"]);

$form->add('label', 'label_clave_confirm', 'clave_confirm', $label["clave"]);
$form->add('password', 'clave_confirm', '', $label["clave_confirm"]);

$obj = & $form->add('hidden', 'MM_from', $MM_from);
$obj = & $form->add('hidden', 'id', $id);

// "submit"
if ($form->validate()) {

    // do stuff here
}

$form->add('submit_1', 'btn_submit', $label["guardar"]);
$form->render('custom-templates/custom-activista.php');
?>