<script language="javascript">
    function miSubmit(){       
        encriptarClave('clave');
        encriptarClave('confirm_clave');
        value = selectedIncluidos( document.getElementById('incluido') );     
        return value;
    }
</script>
<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
// include the Zebra_Form class
require 'Zebra_Form.php';
include_once("controladores/grupo.class.php");
include_once("utiles/utils.class.php");
include_once("idioma/pt.php");
include_once("controladores/usuario.class.php");
include_once("controladores/grupogestion_usuario.class.php");

if (isset($_GET["id"]) && ($_GET["id"] == 0)) {
    echo Utils::getDivTitulo($label["nuevo_usuario"]);
    //cargar los datos a modificar    
    $id = 0;
    $usuario = '';
    $nombre_apellido = '';
    $clave = '';
    $habilitado = 'true';
    $id_activista = null;

    $MM_from = 'guardar_nuevo';
} else {
    echo Utils::getDivTitulo($label["modificar_usuario"]);
    //cargar los datos a modificar
    $MyUsuario = new Usuarios();
    $MyUsuario->getRecord($_GET["id"]);
    $aDatos = $MyUsuario->objConexion->crearArreglo();

    $id = $aDatos['id'];
    $usuario = $aDatos['usuario'];
    $nombre_apellido = $aDatos['nombre_apellido'];
    $clave = $aDatos['clave'];
    ($aDatos['habilitado'] != 't') ? $habilitado = 'false' : $habilitado = 'true';
    $id_activista = $aDatos['id_activista'];

    $MM_from = 'actualizar';
}
// instantiate a Zebra_Form object
$form = new Zebra_Form('form', 'POST', '../negocio/crud_usuario.php', array('onsubmit' => 'return miSubmit();'));

//la etiqueta para el obj nombre de usuario
$form->add('label', 'label_usuario', 'usuario', $label["usuario"]);

//obj para el nombre del usuario
$obj = & $form->add('text', 'usuario', $usuario);

// set rules
$obj->set_rule(array(
    // error messages will be sent to a variable called "error", usable in custom templates
    'required' => array('error', $label["usuario_obligatorio"])
));


$form->add('label', 'label_nombre_completo', 'nombre_completo', $label["nombre_completo"]);

$obj = & $form->add('text', 'nombre_completo', $nombre_apellido, array('style' => 'width:300px'));

$obj->set_rule(array(
    'required' => array('error', $label["nombre_completo_obligatorio"]),
));

if ($id == 0) {
    // "password"
    $form->add('label', 'label_password', 'clave', $label["clave"]);

    $obj = & $form->add('password', 'clave', $clave);

    $obj->set_rule(array(
        'required' => array('error', $label["contrasena_obligatoria"]),
        'length' => array(6, 'error', $label["contrasena_minimo"]),
    ));

    $form->add('note', 'note_clave', 'clave', $label["contrasena_minimo"]);

    // "confirm password"
    $form->add('label', 'label_confirm_clave', 'confirm_clave', $label["confirmar_clave"]);

    $obj = & $form->add('password', 'confirm_clave', $clave);

    $obj->set_rule(array(
        'compare' => array('clave', 'error', $label["contrasena_no_confirmada"])
    ));
}

// "habilitado"
$form->add('label', 'label_habilitado', 'habilitado', $label["habilitado"]);

$obj = & $form->add('radios', 'habilitado', array(
            'true' => 'Habilitado',
            'false' => 'Deshabilitado'
                ), $habilitado);



// "Grupos disponibles"
$form->add('label', 'label_grupo_disponible', 'grupo_disponible', $label["grupos_disponibles"]);

$obj = &$form->add('select', 'disponible', '', array('multiple' => 'multiple', 'size' => '12', 'style' => 'width:250px'));
$disponibles = new Grupos();
$sqlDisponibles = "SELECT id, grupo FROM nmgrupo_gestion WHERE nmgrupo_gestion.id NOT IN ";
$sqlDisponibles .= " ( SELECT id_grupo FROM grupogestion_usuario WHERE grupogestion_usuario.id_usuario = " . $id . ")";
$Datos = $disponibles->objConexion->realizarConsulta($sqlDisponibles);
$objDatos = $disponibles->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'grupo');
$obj->add_options($myArray, true);


// "Grupos incluidos"
$form->add('label', 'label_grupo_incluido', 'grupo_incluido', $label["grupos_incluidos"]);

$obj = & $form->add('select', 'incluido[]', '', array('multiple' => 'multiple', 'size' => '12', 'style' => 'width:250px'));
$incluidos = new Grupos();
$arrIncluido = array();
$sqlIncluidos = "SELECT id, grupo FROM nmgrupo_gestion WHERE nmgrupo_gestion.id IN ";
$sqlIncluidos .= " ( SELECT id_grupo FROM grupogestion_usuario WHERE grupogestion_usuario.id_usuario = " . $id . ")";
$Datos = $incluidos->objConexion->realizarConsulta($sqlIncluidos);
$objDatos = $incluidos->objConexion->crearArregloObjetos();
$arrIncluido = Utils::getArrayForSelect($objDatos, 'id', 'grupo');
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

// add the "hidden" field
$obj = & $form->add('hidden', 'MM_from', $MM_from);
$obj = & $form->add('hidden', 'id', $id);
$obj = & $form->add('hidden', 'pass', $clave);

// "submit"
$form->add('submit_1', 'btn_submit', $label["guardar"]);

if ($id > 0) {

    $form->add('submit', 'redirect_password', $label["redirect_password"]);
}

// validate the form
if ($form->validate()) {

    // do stuff here
}

// auto generate output, labels to the left of form elements
//$form->render('*horizontal');
$form->render('custom-templates/custom-usuario.php');
?>