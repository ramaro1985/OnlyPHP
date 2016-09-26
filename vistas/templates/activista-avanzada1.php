<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
// include the Zebra_Form class
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
include_once("controladores/" . $casoUso . ".class.php");
?>
<h2><?php

    echo $label["busqueda"];
    //cargar los datos a modificar    
    $id = 0;
    $id_provincia = 0;
    $id_municipio = 0;
    $id_comuna = 0;
    $id_cap = 0;
    $id_funcion_mesa = 0;
    $funcion_mesa = 0;
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

    $MM_from = 'guardar_nuevo';

?>

</h2>
<?php
// instantiate a Zebra_Form object
$form = new Zebra_Form('form', 'POST', '../negocio/crud_' . $casoUso . '.php');

// obj provincias
$form->add('label', 'label_vincia', 'provincia', $label["provincia"]);

$obj = & $form->add('select', 'provincia', $id_provincia, array(
            'onchange' => 'cargarDatosSelect(\'provincia\', \'municipio\', \'Cargando...\', \'Municipios\', \'id_provincia\');',
            'style' => 'width:150px'
        ));

$objProvincia = new Provincias();
$Datos = $objProvincia->getRecords();
$objDatos = $objProvincia->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'provincia', $label["seleccione_uno"]);

$obj->add_options($myArray, true);


//la etiqueta para el obj Municipios
$form->add('label', 'label_municipio', 'municipio', $label["municipio"]);

$obj = & $form->add('select', 'municipio', $id_municipio, array(
            'onchange' => 'cargarDatosSelect(\'municipio\', \'comuna\', \'Cargando...\', \'Comunas\', \'id_municipio\');',
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
}


// obj Comunas
$form->add('label', 'label_comuna', 'comuna', $label["comuna"]);

$obj = & $form->add('select', 'comuna', $id_comuna, array(
            'onchange' => 'cargarDatosSelect(\'comuna\', \'cap\', \'Cargando...\', \'Cap\', \'id_comuna\');',
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

//obj cap
$form->add('label', 'label_cap', 'cap', $label["cap"]);

$obj = & $form->add('select', 'cap', $id_cap,array('style'=>'width:150px'));

if ($id > 0) {
    $objCap = new Cap();
    $Datos = $objCap->getRecords('id_comuna=' . $id_comuna);
    $objDatos = $objCap->objConexion->crearArregloObjetos();
    $myArray = Utils::getArrayForSelect($objDatos, 'id', 'cap', $label["seleccione_uno"]);

    $obj->add_options($myArray, true);
} else {
    $obj->add_options(array('' => $label["seleccione_uno"]), true);
}

// Estado civil
$form->add('label', 'label_estado_civil', 'estado_civil', $label["estado_civil"]);

$obj = & $form->add('select', 'estado_civil', $id_estado_civil,array('style'=>'width:150px'));

$objEstadoCivil = new Estadocivil();
$Datos = $objEstadoCivil->getRecords();
$objDatos = $objEstadoCivil->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'estado_civil', $label["seleccione_uno"]);

$obj->add_options($myArray, true);

//Organizacion
$form->add('label', 'label_org_partidista', 'org_partidista', $label["org_partidista"]);

$obj = & $form->add('select', 'org_partidista', $id_organizacion,array('style'=>'width:150px'));

$objOrganizacion = new Organizaciones();
$Datos = $objOrganizacion->getRecords();
$objDatos = $objOrganizacion->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'org_partidista', $label["seleccione_uno"]);

$obj->add_options($myArray, true);


// Combo para profesion
$form->add('label', 'label_profesion', 'profesion', $label["profesion"]);

$obj = & $form->add('select', 'profesion', $id_profesion,array('style'=>'width:150px'));

$objProfesion = new Profesiones();
$Datos = $objProfesion->getRecords();
$objDatos = $objProfesion->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'profesion', $label["seleccione_uno"]);

$obj->add_options($myArray, true);

// funcion de trabajo
$form->add('label', 'label_funcion_trabajo', 'funcion_trabajo', $label["funcion_trabajo"]);

$obj = & $form->add('select', 'funcion_trabajo', $id_funcion_trabajo,array('style'=>'width:150px'));

$objFuncionTrabajo = new Funciontrabajo();
$Datos = $objFuncionTrabajo->getRecords();
$objDatos = $objFuncionTrabajo->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'funcion_trabajo', $label["seleccione_uno"]);

$obj->add_options($myArray, true);

//Para Nivel escolar
$form->add('label', 'label_nivel_escolar', 'nivel_escolar', $label["nivel_escolar"]);

$obj = & $form->add('select', 'nivel_escolar', $id_nivel_escolar,array('style'=>'width:152px'));

$objNivelEscolar = new Nivelescolar();
$Datos = $objNivelEscolar->getRecords();
$objDatos = $objNivelEscolar->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'nivel_escolar', $label["seleccione_uno"]);

$obj->add_options($myArray, true);


$form->add('label', 'label_nro_carton_militante', 'nro_carton_militante', $label["nro_carton_militante"]);

$obj = & $form->add('text', 'nro_carton_militante', $nro_carton_militante,array('style'=>'width:150px'));

//Para el numero de identidad
$form->add('label', 'label_nro_identidad', 'nro_identidad', $label["nro_identidad"]);

$obj = & $form->add('text', 'nro_identidad', $nro_identidad,array('style'=>'width:140px'));


// Numero de Carton electoral
$form->add('label', 'label_nro_carton_electoral', 'nro_carton_electoral', $label["nro_carton_electoral"]);

$obj = & $form->add('text', 'nro_carton_electoral', $nro_carton_electoral,array('style'=>'width:150px'));

//Nombre y apellidos
$form->add('label', 'label_nombre_completo', 'nombre_completo', $label["nombre_completo"]);

$obj = & $form->add('text', 'nombre_completo', $nombre_apellido,array('style'=>'width:145px'));


//Direccion 
$form->add('label', 'label_direccion', 'direccion', $label["direccion"]);

$obj = & $form->add('text', 'direccion', $direccion,array('style'=>'width:145px'));

//Correo
$form->add('label', 'label_correo', 'correo', $label["correo"]);

$obj = & $form->add('text', 'correo', $correo,array('style'=>'width:140px'));

$obj->set_rule(array(
    'email' => array('error', $label["tipo_correo"]),
));

//telefono
$form->add('label', 'label_telefono', 'telefono', $label["telefono"]);

$obj = & $form->add('text', 'telefono', $telefono,array('style'=>'width:140px'));

$obj->set_rule(array(
    'digits' => array('error', $label["telefono_numeros"]),
));

//Sexo
$form->add('label', 'label_sexo', 'sexo', $label['sexo']);

$obj = & $form->add('radios', 'sexo', array(
            'F' => 'Mujer',
            'M' => 'Hombre',
                ), array('checked' => $sexo));
//Padre
$form->add('label', 'label_padre', 'padre', $label["padre"]);

$obj = & $form->add('text', 'padre', $padre,array('style'=>'width:145px'));

//Madre
$form->add('label', 'label_madre', 'madre', $label["madre"]);

$obj = & $form->add('text', 'madre', $madre,array('style'=>'width:145px'));

//Fecha de nacimiento
if ($fecha_nacimiento != '') {
    $fecha_nacimiento = split(' ', $fecha_nacimiento);
}
$form->add('label', 'label_fecha_nacimiento', 'fecha_nacimiento', $label["fecha_nacimiento"]);

$date = & $form->add('date', 'fecha_nacimiento', $fecha_nacimiento[0],array('style'=>'width:140px'));

$date->format('Y-m-d');

$date->set_rule(array(
    'date' => array('error', $label['fecha_nacimiento_incorrecta']),
));
//$date->format('d/m/Y');
//Para funcion de mesa
$form->add('label', 'label_id_funcion_mesa', 'id_funcion_mesa', $label["id_funcion_mesa"]);

$obj = & $form->add('select', 'id_funcion_mesa', $id_funcion_mesa,array('style'=>'width:150px'));

$objFuncionMesa = new Funcionmesa();
$Datos = $objFuncionMesa->getRecords();
$objDatos = $objFuncionMesa->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'funcion_mesa', $label["seleccione_uno"]);

$obj->add_options($myArray, true);

$form->add('label', 'label_busqueda', 'otros', $label["busqueda"]);
// add the "hidden" field
$MM_from = 'buscar';
$obj = & $form->add('hidden', 'MM_from', $MM_from);
$obj = & $form->add('hidden', 'id', $id);

// "submit"
$form->add('submit', 'btn_submit', $label["guardar"]);

// validate the form
if ($form->validate()) {

    // do stuff here
}

// auto generate output, labels to the left of form elements
//$form->render('*horizontal');
$form->render('custom-templates/activista.php');
?>