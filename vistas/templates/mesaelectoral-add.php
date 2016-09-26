<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
$mySession = new Session();
include_once("utiles/session.class.php");

$casoUso = 'mesaelectoral';
require 'Zebra_Form.php';
include_once("utiles/utils.class.php");
include_once("idioma/pt.php");
include_once("utiles/lst.class.php");
include_once("controladores/" . $casoUso . ".class.php");
include_once("controladores/mesaelectoral_organizacion.class.php");
include_once("controladores/v_activista_asamblea.class.php");
include_once("controladores/funcionmesa.class.php");
include_once("controladores/activista_mesaelectoral.class.php");
include_once("controladores/asamblea_resultado.class.php");
include_once("controladores/v_activista_mesaelectoral.class.php");
include_once("controladores/v_mesaelectoral_organizacion.class.php");
include_once("controladores/mesaelecotoral_funcionario.class.php");
include_once("controladores/mesaelecotoral_funcionario.class.php");

if (isset($_GET["id"]) && ($_GET["id"] == 0)) {
    echo Utils::getDivTitulo($label["nueva_mesaelectoral"]);

    //cargar los datos a modificar    
    $id = 0;
    $desc_mesa = '';

    $mySession->registrarVariable('activo', FALSE);
    $mySession->registrarVariable('MesaOrgan', 0);
    $mySession->registrarVariable('id_mesa', 0);
    $mySession->registrarVariable('Activista_Mesa', NULL);

    $id_asamblea_resultado = $mySession->obtenerVariable('id_asamblea_resultado');


    $MM_from_mesaelectoral = 'guardar_nuevo_mesaelectoral';
} else {
    echo Utils::getDivTitulo($label["modificar_mesaelectoral"]);
    //cargar los datos a modificar
    $MyMesaElectoral = new Mesaelectoral();
    $MyMesaElectoral->getRecord($_GET["id"]);
    $aDatos = $MyMesaElectoral->objConexion->crearArreglo();

    $id = $aDatos["id"];
    $desc_mesa = $aDatos["desc_mesa"];
    $activo = $aDatos["activo"];
    $id_asamblea_resultado = $aDatos["id_asamblea_resultado"];
    $votos_blanco = $aDatos["votos_blanco"];
    $votos_nulos = $aDatos["votos_nulos"];
    $votos_reclamados = $aDatos["votos_reclamados"];
    $votos_validos = $aDatos["votos_validos"];
    $mySession->registrarVariable('id_mesa', $id);

    $mySession->registrarVariable('activo', $activo);

    $ObjMesaOrgan = new v_Mesaelectoral_organizacion();
    $ObjMesaOrgan->getRecords('id_mesa=' . "'$id'");
    $MesaOrgan = $ObjMesaOrgan->objConexion->crearArregloObjetos();

    $mySession->registrarVariable('MesaOrgan', $MesaOrgan);

    $MM_from_mesaelectoral = 'actualizar_mesaelectoral';
}

// instantiate a Zebra_Form object
$form = new Zebra_Form('form', 'POST', '../negocio/crud_mesaelectoral.php');

$objFuncionMesa = new Funcionmesa();
$objFuncionMesa->getRecords();
$FuncionMesa = $objFuncionMesa->objConexion->crearArregloObjetos();
$mySession->registrarVariable('FuncionMesa', $FuncionMesa);

$form->add('label', 'label_desc_mesa', 'desc_mesa', $label["desc_mesa"]);
$obj = & $form->add('textarea', 'desc_mesa', $desc_mesa, array('style' => 'width:80%', 'rows' => '1'));

$form->add('label', 'label_activo', 'activo', $label["activo"], array('style' => "color:red"));
$form->add('label', 'label_organzacion', 'organzacion', $label["listado_organizacion"]);
$form->add('label', 'label_no_votos', 'no_votos', $label["label_no_votos"]);

//votos_blanco
$form->add('label', 'label_votos_blanco', 'votos_blanco', $label["votos_blanco"]);
$obj = & $form->add('text', 'votos_blanco', $votos_blanco);
$obj->set_rule(array(
    'digits' => array('error', $label["cantidad_producto_error"]),
));

//votos_nulos
$form->add('label', 'label_votos_nulos', 'votos_nulos', $label["votos_nulos"]);
$obj = & $form->add('text', 'votos_nulos', $votos_nulos);
$obj->set_rule(array(
    'digits' => array('error', $label["cantidad_producto_error"]),
));

//votos_reclamados
$form->add('label', 'label_votos_reclamados', 'votos_reclamados', $label["votos_reclamados"]);
$obj = & $form->add('text', 'votos_reclamados', $votos_reclamados);
$obj->set_rule(array(
    'digits' => array('error', $label["cantidad_producto_error"]),
));

//votos_reclamados
$form->add('label', 'label_votos_validos', 'votos_validos', $label["votos_validos"]);
$obj = & $form->add('text', 'votos_validos', $votos_validos);
$obj->set_rule(array(
    'digits' => array('error', $label["cantidad_producto_error"]),
));

$form->add('note', 'note_nombre', 'nombre_apellido', $label["note_nombre"]);
$form->add('note', 'num_carton', 'num_carton', $label["num_carton"]);
$form->add('label', 'label_asamblea_cerrada', 'asamblea_cerrada', $label["asamblea_cerrada"], array('style' => 'color:red'));

// add the "hidden" field
$obj = & $form->add('hidden', 'MM_from_mesaelectoral', $MM_from_mesaelectoral);
$obj = & $form->add('hidden', 'id', $id);
$obj = & $form->add('hidden', 'id_asamblea_resultado', $id_asamblea_resultado);

// "submit"

$form->add('submit_1', 'btn_submit', $label["guardar"]);

$form->render('custom-templates/custom-mesaelectoral.php');
//$form->render('*horizontal');
?>