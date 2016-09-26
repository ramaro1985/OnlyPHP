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
include_once("controladores/v_proyecto.class.php");
include_once("controladores/proyecto.class.php");
include_once("controladores/empresa.class.php");
include_once("controladores/proyecto_empresa.class.php");
include_once("controladores/estado.class.php");
include_once("controladores/trabajador.class.php");
include_once("controladores/recorrido.class.php");
include_once("controladores/v_recorrido.class.php");
include_once("controladores/v_empresa.class.php");

if (isset($_GET["id"]) && ($_GET["id"] == 0)) {
    echo Utils::getDivTitulo($label["nuevo_proyecto"]);
    $id = 0;
    $nombre_proyecto = '';
    $lider = '';
    $descripcion = '';
    $id_estado = '';

    $mySession->registrarVariable('id_proyecto', 0);

    // echo $id_empresa = $mySession->obtenerVariable('id_empresa');
    // echo $id_proyecto = $mySession->obtenerVariable('id_proyecto');
    //die();

    $MM_from_proyecto = 'guardar_nuevo_proyecto';
} else {
    echo Utils::getDivTitulo($label["modificar_proyecto"]);
    $MyObj = new v_Proyecto();
    $MyObj->getRecord($_GET["id"]);
    $aDatos = $MyObj->objConexion->crearArreglo();

    $MyObjPro = new Proyecto();
    $MyObjPro->getRecord($_GET["id"]);
    $aDatosPro = $MyObjPro->objConexion->crearArreglo();

    $id = $aDatos['id'];
    $nombre_proyecto = $aDatos['nombre_proyecto'];
    $lider = $aDatos['lider'];
    $descripcion = $aDatosPro['descripcion'];
    $id_estado = $aDatosPro['id_estado'];

    $ObjEmpres_proyecto = New Proyecto_empresa();
    $ObjEmpres_proyecto->getRecords('id_proyecto=' . "'$id'");
    $datosEmpresa = $ObjEmpres_proyecto->objConexion->crearArreglo();
    $id_empresa = $datosEmpresa['id_empresa'];

    //echo $id_empresa = $mySession->obtenerVariable('id_empresa');
    $mySession->registrarVariable('id_proyecto', $id);
    //echo $id_proyecto = $mySession->obtenerVariable('id_proyecto');
    //die();


    $MM_from_proyecto = 'actualizar_proyecto';
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

// instantiate a Zebra_Form object
$form = new Zebra_Form('form', 'POST', '../negocio/crud_proyecto.php');
//Empresa en caso de que sea Directo
if ($id == 0 && $mySession->obtenerVariable('empresa_activo') == 0) {
    $form->add('label', 'label_id_empresa', 'id_empresa', $label["id_empresa"]);

    $obj = & $form->add('select', 'id_empresa', '', array('style' => 'width:225px'));

    $id_usuario_loguin = $mySession->obtenerVariable('idusuario');
    $arrAcceso = $mySession->arrAcceso;
    $id_grupo_gestion = $arrAcceso[0]['id_grupo_gestion'];

    $objEmpresa = new v_Empresa();
    if ($id_grupo_gestion != 2) {
        $objEmpresa->getRecords('id_usuario=' . "'$id_usuario_loguin'");
    } else {
        $objEmpresa->getRecords();
    }
    $objDatos = $objEmpresa->objConexion->crearArregloObjetos();
    $myArray = Utils::getArrayForSelect($objDatos, 'id', 'nombre_empresa', $label["seleccione_uno"]);

    $obj->add_options($myArray, true);

    $obj->set_rule(array(
        'required' => array('error', $label["nombre_obligatorio"])
    ));
}

//Nombre de la proyecto
$form->add('label', 'label_nombre_proyecto', 'nombre_proyecto', $label["nombre_proyecto"]);

$obj = & $form->add('text', 'nombre_proyecto', $nombre_proyecto);

$obj->set_rule(array(
    'required' => array('error', $label["nombre_obligatorio"]),
));

//Nombre de la proyecto
$form->add('label', 'label_lider', 'lider', $label["lider"]);

$obj = & $form->add('text', 'lider', $lider);

$obj->set_rule(array(
    'required' => array('error', $label["lider_obligatorio"]),
));

//Nombre de la proyecto
$form->add('label', 'label_lider', 'lider', $label["lider"]);

$obj = & $form->add('text', 'lider', $lider);

$obj->set_rule(array(
    'required' => array('error', $label["lider_obligatorio"]),
));

//obj descripcion del Proyect
$form->add('label', 'label_descripcion', $descripcion, $label['descripcion']);

$obj = & $form->add('textarea', 'descripcion', $descripcion);

//Estado 
$form->add('label', 'label_id_estado', 'id_estado', $label["id_estado"]);

$obj = & $form->add('select', 'id_estado', $id_estado);

$objEstado = new Estado();
$Datos = $objEstado->getRecords();
$objDatos = $objEstado->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'estado', $label["seleccione_uno"]);

$obj->add_options($myArray, true);

$obj->set_rule(array(
    'required' => array('error', $label["estado_obligatorio"])
));

$obj = & $form->add('hidden', 'MM_from_proyecto', $MM_from_proyecto);
$obj = & $form->add('hidden', 'id', $id);

$form->add('submit', 'btn_submit', $label["guardar"]);
$form->render('custom-templates/custom-proyecto.php');
?>
<?php if ($id != 0): ?>
    <?php echo'
<script>
    $(function() {
        $( "#tabs" ).tabs();
    });
</script>';
    ?>
    <div class="demo">
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1"><?php echo $label["trabajadores"] ?></a></li>

                <?php if (isset($id_empresa) && $id_empresa != NULL): ?>
                    <li><a href="#tabs-2"><?php echo $label["listado_recorrido"] ?></a></li>
                <?php endif; ?>
            </ul>
            <div id="tabs-1">
                <?php
                $id_empresa = $mySession->obtenerVariable('id_empresa');
                $form = new Zebra_Form('form', 'POST', '../negocio/crud_proyecto_trabajador.php', array('onsubmit' => 'return selectedIncluidos( document.getElementById(\'incluido\') );'));
                $MM_from_proyecto_trabajador = 'guardar_proyecto_trabajador';

                $form->add('label', 'label_trabajadores_disponibles', 'trabajadores_disponibles', $label["trabajadores_disponibles"]);

                $obj = &$form->add('select', 'disponible', '', array('multiple' => 'multiple', 'size' => '12', 'style' => 'width:250px'));
                $disponibles = new Grupos();
                $sqlDisponibles = "SELECT id, nombre_apellido FROM nmtrabajador WHERE nmtrabajador.id_empresa = " . $id_empresa . "  AND nmtrabajador.id NOT IN";
                $sqlDisponibles .= " ( SELECT id_trabajador FROM trabajador_proyecto WHERE trabajador_proyecto.id_proyecto = " . $id . ")";
                $Datos = $disponibles->objConexion->realizarConsulta($sqlDisponibles);
                $objDatos = $disponibles->objConexion->crearArregloObjetos();
                $myArray = Utils::getArrayForSelect($objDatos, 'id', 'nombre_apellido');
                $obj->add_options($myArray, true);


                // "Grupos incluidos"
                $form->add('label', 'label_trabajadores_incluidos', 'trabajadores_incluidos', $label["trabajadores_incluidos"]);

                $obj = & $form->add('select', 'incluido[]', '', array('multiple' => 'multiple', 'size' => '12', 'style' => 'width:250px'));
                $incluidos = new Grupos();
                $arrIncluido = array();
                $sqlIncluidos = "SELECT id, nombre_apellido FROM nmtrabajador WHERE nmtrabajador.id_empresa = " . $id_empresa . "  AND nmtrabajador.id IN";
                $sqlIncluidos .= " ( SELECT id_trabajador FROM trabajador_proyecto WHERE trabajador_proyecto.id_proyecto = " . $id . ")";
                $Datos = $incluidos->objConexion->realizarConsulta($sqlIncluidos);
                $objDatos = $incluidos->objConexion->crearArregloObjetos();
                $arrIncluido = Utils::getArrayForSelect($objDatos, 'id', 'nombre_apellido');
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
                $obj = & $form->add('hidden', 'MM_from_proyecto_trabajador', $MM_from_proyecto_trabajador);
                $obj = & $form->add('hidden', 'id', $id);

                // "submit"
                $form->add('submit', 'btn_submit', $label["guardar"]);
                $form->render('custom-templates/custom-trabajador-proyecto.php');
                ?>
            </div>
            <div id="tabs-2">
                <?php
                if (isset($id_empresa) && $id_empresa != NULL) {
                    $id_empresa = $mySession->obtenerVariable('id_empresa');
                    //echo $id_empresa = $mySession->obtenerVariable('id_empresa');
                    //echo $id_proyecto = $mySession->obtenerVariable('id_proyecto');
                    //die();
                    $id_proyecto = $id;
                    $obj = new Proyecto_empresa();
                    $obj->getRecords('id_empresa=' . "'$id_empresa'" . ' AND ' . 'id_proyecto=' . "'$id_proyecto'");
                    $aDatos = $obj->objConexion->crearArreglo();

                    $id_proyecto_empresa = $aDatos['id'];

                    $casoUso = "recorrido";
                    $mySession->where[$casoUso]['where'] = 'id_proyecto_empresa=' . "'" . $id_proyecto_empresa . "'";
                    $mySession->actualizar();

                    $template = "lst";
                    $hrefEdit = '?frm=' . $casoUso . '&amp;template=' . $template;
                    $action = "../negocio/crud_" . $casoUso . ".php";
                    $myHtml = new lst($casoUso, 'v_recorrido', $label, $_GET, $hrefEdit, "", "", $action, $mySession);
                    $myHtml->getLst();
                }
                ?>
            </div>
        </div>
    </div>
    <?php
    echo Utils::getDivClose();
endif;
?>

