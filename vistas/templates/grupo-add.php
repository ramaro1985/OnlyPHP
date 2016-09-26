<?php
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../'));
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../../'));     
// include the Zebra_Form class
$casoUso = 'grupo';
require 'Zebra_Form.php';
include_once("utiles/utils.class.php");       
include_once("idioma/pt.php");
include_once("controladores/".$casoUso.".class.php");
include_once("controladores/caso_uso.class.php");   
include_once("controladores/funcionalidad.class.php");
include_once("controladores/v_caso_uso_funcionalidad.class.php");

if (isset($_GET["id"]) && ($_GET["id"]==0)) {
    echo Utils::getDivTitulo( $label["nuevo_grupo"] );
    //cargar los datos a modificar    
    $id                 = 0;
    $grupo              = '';
    $descripcion        = '';
    $habilitado         = 'true';
    
    $MM_from            = 'guardar_nuevo';
} else {
    echo Utils::getDivTitulo( $label["modificar_grupo"] );
    //cargar los datos a modificar
    $MyObj = new Grupos();
    $MyObj->getRecord($_GET["id"]);
    $aDatos = $MyObj->objConexion->crearArreglo(); 

    $id                 = $aDatos['id'];
    $grupo              = $aDatos['grupo'];
    $descripcion        = $aDatos['descripcion'];
    ($aDatos['activo'] != 't') ? $habilitado = 'false': $habilitado = 'true';
        
    $MM_from            = 'actualizar';    
} 

    // instantiate a Zebra_Form object
    $form = new Zebra_Form('form', 'POST', '../negocio/crud_'.$casoUso.'.php', array('onsubmit' => 'return selectedIncluidos( document.getElementById(\'incluido\') );'));

    //la etiqueta para el obj nombre de usuario
    $form->add('label', 'label_grupo', 'grupo', $label["grupo"]);

    //obj para el nombre del usuario
    $obj = & $form->add('text', 'grupo', $grupo);

    // set rules
    $obj->set_rule(array(
        // error messages will be sent to a variable called "error", usable in custom templates
        'required' => array('error', $label["grupo_obligatorio"])
    ));
    
    $form->add('label', 'label_descripcion', 'descripcion', $label["descripcion"]);

    $obj = & $form->add('text', 'descripcion', $descripcion);

    // "habilitado"
    $form->add('label', 'label_habilitado', 'habilitado', $label["habilitado"]);

    $obj = & $form->add('radios', 'habilitado', array(
        'true' =>  'Habilitado',
        'false' =>  'Deshabilitado'
    ), $habilitado);    

    // "Grupos disponibles"
    $form->add('label', 'label_funcion_disponible', 'funcion_disponible', $label["funcion_disponibles"]);

    $obj = &$form->add('select', 'disponible', '', array('multiple' => 'multiple', 'size' => '12', 'style' => 'width:250px')); 
    $caso_uso_funcionalidad = new v_Caso_uso_funcionalidad();
    $sqlDisponibles = "SELECT * FROM v_caso_uso_funcionalidad WHERE v_caso_uso_funcionalidad.id NOT IN ";
    $sqlDisponibles .= " ( SELECT id_caso_uso_funcionalidad FROM funcionalidad_grupo_gestion WHERE id_grupo_gestion = ".$id.")";
    $Datos = $caso_uso_funcionalidad ->objConexion->realizarConsulta($sqlDisponibles);
    $objDatos = $caso_uso_funcionalidad ->objConexion->crearArregloObjetos();
    $myArray = Utils::getArrayForSelect($objDatos, 'id', 'nombre_completo'); 
    $obj->add_options($myArray, true);                  

    
    // "Grupos incluidos"
    $form->add('label', 'label_funcion_incluido', 'funcion_incluido', $label["funcion_incluidos"]);

    $obj = & $form->add('select', 'incluido[]', '', array('multiple' => 'multiple', 'size' => '12', 'style' => 'width:250px')); 
    $caso_uso_funcionalidad = new v_Caso_uso_funcionalidad();
    $sqlIncluidos = "SELECT * FROM v_caso_uso_funcionalidad WHERE v_caso_uso_funcionalidad.id IN ";
    $sqlIncluidos .= " ( SELECT id_caso_uso_funcionalidad FROM funcionalidad_grupo_gestion WHERE id_grupo_gestion = ".$id.")";
    $Datos = $caso_uso_funcionalidad ->objConexion->realizarConsulta($sqlIncluidos);
    $objDatos = $caso_uso_funcionalidad ->objConexion->crearArregloObjetos();
    $myArray = Utils::getArrayForSelect($objDatos, 'id', 'nombre_completo'); 
    $obj->add_options($myArray, true);                  
         
    // "boton >"
    $form->add('button', 'pasaruno', '&gt;', array(
        'type'  =>  'button',
        'onclick' => 'moveDualList( document.getElementById(\'disponible\'),  document.getElementById(\'incluido\'), false );',
        'title' => $label["pasaruno"], 'style' => 'width: 100%;'
    ));    

    // "boton >>"
    $form->add('button', 'pasartodos', '&gt;&gt;', array(
        'type'  =>  'button',
        'onclick' => 'moveDualList( this.form.disponible,  document.getElementById(\'incluido\'), true );',
        'title' => $label["pasartodos"], 'style' => 'width: 100%;'
    ));    

    // "boton <"
    $form->add('button', 'retornaruno', '&lt;', array(
        'type'  =>  'button',
        'onclick' => 'moveDualList( document.getElementById(\'incluido\'), this.form.disponible, false );',
        'title' => $label["retornaruno"], 'style' => 'width: 100%;'
    ));    
    
    // "boton <<"
    $form->add('button', 'retornartodos', '&lt;&lt;', array(
        'type'  =>  'button',
        'onclick' => 'moveDualList( document.getElementById(\'incluido\'), this.form.disponible, true );',
        'title' => $label["retornartodos"], 'style' => 'width: 100%;'
    ));    
    
    // add the "hidden" field
    $obj = & $form->add('hidden', 'MM_from', $MM_from);
    $obj = & $form->add('hidden', 'id', $id);
    
    // "submit"
    $form->add('submit_1', 'btn_submit', $label["guardar"]);

    // validate the form
    if ($form->validate()) {

        // do stuff here

    }

    // auto generate output, labels to the left of form elements
    //$form->render('*horizontal');
    $form->render('custom-templates/custom-grupo.php');        

?>