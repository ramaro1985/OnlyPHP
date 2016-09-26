<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
include_once("utiles/session.class.php");
$mySession = new Session();
require 'Zebra_Form.php';
include_once("controladores/grupo.class.php");
include_once("utiles/utils.class.php");
include_once("utiles/lst.class.php");
include_once("idioma/pt.php");
include_once("controladores/empresa.class.php");
include_once("controladores/proyecto.class.php");
include_once("controladores/tiposervicio.class.php");
include_once("controladores/v_empresa_buscar.class.php");
include_once("controladores/v_trabajador.class.php");

if (isset($_GET["id"]) && ($_GET["id"] == 0)) {
    echo Utils::getDivTitulo($label["Nueva_Empresa"]);
    $id = 0;
    $nombre_empresa = '';
    $id_tipo_servicio = 0;
    $direccion = '';
    
    $mySession->registrarVariable('id_empresa',0);

    $MM_from_empresa = 'guardar_nuevo_empresa';
} else {
    echo Utils::getDivTitulo($label["modificar_empresa"]);
    $MyEmpresa = new v_Empresa_buscar();
    $MyEmpresa->getRecord($_GET["id"]);
    $aDatos = $MyEmpresa->objConexion->crearArreglo();

    $id = $aDatos['id'];
    $nombre_empresa = $aDatos['nombre_empresa'];
    $id_tipo_servicio = $aDatos['id_tipo_servicio'];
    $direccion = $aDatos['direccion'];
    
    $mySession->registrarVariable('id_empresa',$id);

    $MM_from_empresa = 'actualizar_empresa';
};
echo Utils::getDivOpen();
if (isset($_GET["error"]) && $_GET["error"] == 1) {
    if ($_GET["tipo_error"] == 'insertar_update') {
        $error = $label["error_insertar_update"] . $label["nombre_empresa"] . $label['seleccionado'];
        echo Utils::getDivErrorLogin($error);
    }
} else {
    echo Utils::getDivError($label["usuario_pass_incorrecto"]);
}

$form = new Zebra_Form('form', 'POST', '../negocio/crud_empresa.php');

//Nombre de la empresa
$form->add('label', 'label_nombre_empresa', 'nombre_empresa', $label["nombre_empresa"]);

$obj = & $form->add('text', 'nombre_empresa', $nombre_empresa);

$obj->set_rule(array(
    'required' => array('error', $label["nombre_obligatorio"]),
));

//direccion de la empresa
$form->add('label', 'label_direcion', 'direccion', $label["direccion"]);

$obj = & $form->add('text', 'direccion', $direccion);

$obj->set_rule(array(
    'required' => array('error', $label["direccion_obligatorio"]),
));

// tipo_servivicio
$form->add('label', 'label_id_tipo_servicio', 'id_tipo_servicio', $label["id_tipo_servicio"]);

$obj = & $form->add('select', 'id_tipo_servicio', $id_tipo_servicio);

$objTipoServ = new Tiposervicio();
$Datos = $objTipoServ->getRecords();
$objDatos = $objTipoServ->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'tipo_servicio', $label["seleccione_uno"]);

$obj->add_options($myArray, true);

$obj->set_rule(array(
    'required' => array('error', $label["profesion_obligatorio"])
));

// add the "hidden" field
$obj = & $form->add('hidden', 'MM_from_empresa', $MM_from_empresa);
$obj = & $form->add('hidden', 'id', $id);

$form->add('submit', 'btn_submit', $label["guardar"]);

$form->render('custom-templates/custom-empresa-add.php');
?>
<?php if ($id != 0): ?>
    <div class="demo">
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1"><?php echo $label["trabajadores"] ?></a></li>
                <li><a href="#tabs-2"><?php echo $label["listado_proyecto"] ?></a></li>
            </ul>
            <div id="tabs-1">
                <?php
                $id = $mySession->obtenerVariable('id_empresa');
                $casoUso = "trabajador";
                $mySession->where[$casoUso]['where'] = 'id_empresa=' . "'" . $id. "'";
                $mySession->actualizar();

                $template = "lst";
                $hrefEdit = '?frm=' . $casoUso . '&amp;template=' . $template;
                $action = "../negocio/crud_" . $casoUso . ".php";
                $myHtml = new lst($casoUso, 'v_trabajador', $label, $_GET, $hrefEdit, "", "", $action, $mySession);
                $myHtml->getLst();
                ?>
            </div>
            <div id="tabs-2">
                <?php
                $id = $mySession->obtenerVariable('id_empresa');
                $casoUso = "proyecto";
                $mySession->where[$casoUso]['where'] = 'id_empresa=' . "'" . $id. "'";
                $mySession->actualizar();

                $template = "lst";
                $hrefEdit = '?frm=' . $casoUso . '&amp;template=' . $template;
                $action = "../negocio/crud_" . $casoUso . ".php";
                $myHtml = new lst($casoUso, 'v_proyecto', $label, $_GET, $hrefEdit, "", "", $action, $mySession);
                $myHtml->getLst();
                ?>
            </div>
        </div>
    </div>
<?php endif; ?>