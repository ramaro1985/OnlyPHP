<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
$mySession = new Session();
include_once("utiles/session.class.php");

$casoUso = 'asamblea';
require 'Zebra_Form.php';
include_once("utiles/utils.class.php");
include_once("idioma/pt.php");
include_once("utiles/lst.class.php");
include_once("controladores/" . $casoUso . ".class.php");
include_once("controladores/cap.class.php");
include_once("controladores/comuna.class.php");
include_once("controladores/provincia.class.php");
include_once("controladores/municipio.class.php");
include_once("controladores/v_asamblea_buscar.class.php");
include_once("controladores/usuario.class.php");
include_once("controladores/asamblea_resultado.class.php");
include_once("controladores/mesaelectoral.class.php");


if (isset($_GET["id"]) && ($_GET["id"] == 0)) {
    echo Utils::getDivTitulo($label["nuevo_asamblea"]);
    //cargar los datos a modificar    
    $id = 0;
    $id_cap = 0;
    $id_comuna = 0;
    $id_municipio = 0;
    $id_provincia = 0;
    $localidad = '';
    $poblado = '';
    $presidente_asamblea = '';
    $codigo_asamblea = '';
    $id_usuario = 0;
    $fecha_cierre = '';
    $votos_blanco = '';
    $votos_reclamados = '';
    $votos_nulos = '';
    $votos_validos = '';
    $cerrada = 'f';
    $confirmada = 'f';
    $electores_registrados = 0;
    $mySession->registrarVariable('id_asamblea', $id);
    $mySession->registrarVariable('cerrada', $cerrada);
    $mySession->registrarVariable('confirmada', $confirmada);


    $MM_from_asamblea = 'guardar_nuevo_asamblea';
} else {
    echo Utils::getDivTitulo($label["asamblea"]);
    //cargar los datos a modificar
    $MyObj = new v_Asamblea_buscar();
    $MyObj->getRecord($_GET["id"]);
    $aDatos = $MyObj->objConexion->crearArreglo();

    $id = $aDatos['id'];
    $id_cap = $aDatos['id_cap'];
    $id_comuna = $aDatos['id_comuna'];
    $id_municipio = $aDatos['id_municipio'];
    $id_provincia = $aDatos['id_provincia'];
    $localidad = $aDatos['localidad'];
    $poblado = $aDatos['poblado'];
    $presidente_asamblea = $aDatos['presidente_asamblea'];
    $codigo_asamblea = $aDatos['codigo_asamblea'];
    $id_usuario = $aDatos['id_usuario'];
    $fecha_cierre = $aDatos['fecha_cierre'];
    $id_asamblea_resultado = $aDatos['id_asamblea_resultado'];
    $cerrada = $aDatos['cerrada'];
    $confirmada = $aDatos['confirmada'];
    $electores_registrados = $aDatos['electores_registrados'];

    $mySession->registrarVariable('cerrada', $cerrada);
    $mySession->registrarVariable('confirmada', $confirmada);

    $ObjMesaElectoral = new Mesaelectoral();
    $ObjMesaElectoral->getRecords('id_asamblea_resultado=' . "'$id_asamblea_resultado'");
    $DatosMesa = $ObjMesaElectoral->objConexion->crearArregloObjetos();

    if (count($DatosMesa) > 0 && is_array($DatosMesa)) {

        for ($i = 0; $i < count($DatosMesa); $i++) {
            $votos_blanco += $DatosMesa[$i]->votos_blanco;
            $votos_reclamados += $DatosMesa[$i]->votos_reclamados;
            $votos_nulos += $DatosMesa[$i]->votos_nulos;
            $votos_validos += $DatosMesa[$i]->votos_validos;
        }
    } else {
        $votos_blanco = $aDatos['votos_blanco'];
        $votos_reclamados = $aDatos['votos_reclamados'];
        $votos_nulos = $aDatos['votos_nulos'];
        $votos_validos = $aDatos['votos_validos'];
    }

    $votos_blanco = $aDatos['votos_blanco'];
    $votos_reclamados = $aDatos['votos_reclamados'];
    $votos_nulos = $aDatos['votos_nulos'];
    $votos_validos = $aDatos['votos_validos'];

    $mySession->registrarVariable('id_asamblea', $id);
    $mySession->registrarVariable('id_asamblea_resultado', $id_asamblea_resultado);
    $mySession->registrarVariable('cerrada', $cerrada);
    $mySession->registrarVariable('confirmada', $confirmada);

    $MM_from_asamblea = 'actualizar_asamblea';
}
echo Utils::getDivOpen();
if (isset($_GET["error"]) && $_GET["error"] == 1) {
    if ($_GET["tipo_error"] == 'insertar_update') {
        $error = $label["error_insertar_update"] . $label["asamblea"] . $label['seleccionado'];
    }
    echo Utils::getDivErrorLogin($error);
} else {
    echo Utils::getDivError($label["usuario_pass_incorrecto"]);
}

// instantiate a Zebra_Form object
$form = new Zebra_Form('form', 'POST', '../negocio/crud_' . $casoUso . '.php');

// obj provincias
$form->add('label', 'label_id_provincia', 'id_provincia', $label["provincia"]);
$id_usuario_loguin = $mySession->obtenerVariable('idusuario');
$arrAcceso = $mySession->arrAcceso;
$id_grupo_gestion = $arrAcceso[0]['id_grupo_gestion'];

$obj = & $form->add('select', 'id_provincia', $id_provincia, array(
            'onchange' => 'cargarDatosSelect(\'id_provincia\', \'id_municipio\',\'' . $label["cargando"] . '\', \'Municipios\', \'id_provincia\', \'municipio\', 2);',
            'style' => 'width:150px'
        ));

if ($id_grupo_gestion != 2 && $id_grupo_gestion != 4) {

    $ObjUsuario = new Usuarios();
    $ObjUsuario->getRecord($id_usuario_loguin);
    $aDatosUsuario = $ObjUsuario->objConexion->crearArreglo();

    $id_activista = $aDatosUsuario['id_activista'];

    $ObjActvista = new v_Activista();
    $ObjActvista->getRecord($id_activista);
    $aDatosAct = $ObjActvista->objConexion->crearArreglo();

    $provincia_act = $aDatosAct['provincia'];

    $objProvincia = new Provincias();
    $Datos = $objProvincia->getRecords('provincia=' . "'$provincia_act'");
    $objDatos = $objProvincia->objConexion->crearArregloObjetos();
    $myArray = Utils::getArrayForSelect($objDatos, 'id', 'provincia', $label["seleccione_uno"]);
} else {
    //echo 'pp';
    $objProvincia = new Provincias();
    $Datos = $objProvincia->getRecords();
    $objDatos = $objProvincia->objConexion->crearArregloObjetos();
    $myArray = Utils::getArrayForSelect($objDatos, 'id', 'provincia', $label["seleccione_uno"]);
}


$obj->add_options($myArray, true);

$obj->set_rule(array(
    'required' => array('error', $label["provincia_obligatorio"])
));

//la etiqueta para el obj Municipios
$form->add('label', 'label_id_municipio', 'id_municipio', $label["municipio"]);

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
$form->add('label', 'label_id_comuna', 'id_comuna', $label["comuna"]);

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

// obj Cap
$form->add('label', 'label_id_cap', 'id_cap', $label["cap"]);

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

$form->add('label', 'label_localidad', 'localidad', $label["localidad"]);
$obj = & $form->add('text', 'localidad', $localidad, array('style' => 'width:140px'));

$form->add('label', 'label_poblado', 'poblado', $label["poblado"]);
$obj = & $form->add('text', 'poblado', $poblado, array('style' => 'width:140px'));

$form->add('label', 'label_presidente_asamblea', 'presidente_asamblea', $label["presidente_asamblea"]);
$obj = & $form->add('text', 'presidente_asamblea', $presidente_asamblea, array('style' => 'width:200px'));

$form->add('label', 'label_codigo_asamblea', 'codigo_asamblea', $label["codigo_asamblea"]);
$obj = & $form->add('text', 'codigo_asamblea', $codigo_asamblea, array('style' => 'width:160px'));
$obj->set_rule(array(
    'required' => array('error', $label["codigo_asamblea_obligatorio"])
));

$form->add('label', 'label_cabo_electoral', 'cabo_electoral', $label["cabo_electoral"]);
$obj = & $form->add('select', 'id_usuario', $id_usuario, array('style' => 'width:175px'));

$objUsuarios = new Usuarios();
$Datos = $objUsuarios->getRecords('id<>1');
$objDatos = $objUsuarios->objConexion->crearArregloObjetos();
$myArray = Utils::getArrayForSelect($objDatos, 'id', 'nombre_apellido', $label["seleccione_uno"]);
$obj->add_options($myArray, true);

$form->add('label', 'label_electores_registrados', 'electores_registrados', $label["electores_registrados"]);
$obj = & $form->add('text', 'electores_registrados', $electores_registrados, array('style' => 'width:125px'));
$obj->set_rule(array(
    'digits' => array('error', $label["telefono_numeros"])
));


if ($id > 0) {
    $obj = & $form->add('hidden', 'votos_validos', $votos_validos);
    $obj = & $form->add('hidden', 'votos_blanco', $votos_blanco);
    $obj = & $form->add('hidden', 'votos_reclamados', $votos_reclamados);
    $obj = & $form->add('hidden', 'votos_nulos', $votos_nulos);
}

$form->add('label', 'label_cerrar_asamablea', 'cerrar_asamablea', $label["cerrar_asamablea"], array('style' => 'color:red'));
$form->add('label', 'label_confirmar_asamablea', 'confirmar_asamablea', $label["confirmar_asamablea"], array('style' => 'color:red'));
$form->add('label', 'label_asamablea_confirmada', 'asamablea_confirmada', $label["asamablea_confirmada"], array('style' => 'color:red'));


// add the "hidden" field
$obj = & $form->add('hidden', 'MM_from_asamblea', $MM_from_asamblea);
$obj = & $form->add('hidden', 'id', $id);
$obj = & $form->add('hidden', 'id_asamblea_resultado', $id_asamblea_resultado);

// "submit"

$form->add('submit', 'btn_submit', $label["guardar"]);
$form->render('custom-templates/custom-asamblea.php');
?>
<script language="javascript" src="public/javascript/AjaxUpload.2.0.min.js"></script>
<?php if ($id != 0): ?>
    <?php echo'
<script>
    $(document).ready(function(){
        $( "#tabs" ).tabs();
    });
</script>';
    ?>

    <script language="javascript">
        $(document).ready(function(){
            var button = $('#upload_imagen'), interval;
            var error = $('#error_img');
            new AjaxUpload('#upload_imagen', {
                action: '../utiles/upload.class.php?cu=<?php echo $casoUso . '&id=' . $id; ?>',
                onSubmit : function(file , ext){
                    if (! (ext && /^(jpg|png|jpeg|gif|bmp)$/.test(ext))){
                        // extensiones permitidas
                        // alert('Error: Solo se permiten imagenes');
                        error.show();
                                                        
                        // cancela upload
                        return false;
                    } else {
                        //Cambio el texto del boton y lo deshabilito
                        error.hide();
                        button.text('Uploading');
                        this.disable();
                    }
                },
                onComplete: function(file, response){
                    $('#gallery').html(response);
                                                         
                    button.text('Upload');
                    // habilito upload button  
                                                                            
                    this.enable();         
                }  
            });
        });
    </script>
    <script language="javascript">
        $(document).ready(function(){
            $("a[rel = 'lightbox']").lightBox();					   
        });
    </script>
    <div class="demo">
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1"><?php echo $label["mesas_electorales"] ?></a></li>
                <li><a href="#tabs-2"><?php echo $label["imagenes"] ?></a></li>
            </ul>
            <div id="tabs-1">
                <?php
                $casoUso = "mesaelectoral";
                $mySession->where[$casoUso]['where'] = "id_asamblea_resultado='$id_asamblea_resultado'";
                $mySession->actualizar();

                $template = "lst";
                $hrefEdit = '?frm=' . $casoUso . '&amp;template=' . $template;
                $action = "../negocio/crud_" . $casoUso . ".php";
                $myHtml = new lst($casoUso, 'v_mesaelectoral', $label, $_GET, $hrefEdit, "", "", $action, $mySession);
                $myHtml->getLst();
                ?>
            </div>
            <div id="tabs-2">
                <div>
                    <div id="error_img" hidden="true" class="error"><?php echo Utils::getDivErrorLogin($label["error_img"]); ?></div>
                    <div ><image src="../vistas/public/imagenes/add_img.jpg" id="upload_imagen" ><!--<image src="../vistas/public/imagenes/remove_img.jpg" id="" >--></div>            
                    <div id="gallery">
                        <?php
                        include_once("utiles/gallery.class.php");
                        $casoUso = 'asamblea';
                        $mygallery = new gallery();
                        $pathFolder = '../' . CAMINO_DOC_ADJUNTOS . '/' . $casoUso . '/' . $id;
                        @$mygallery->loadFolder($pathFolder);
                        $mygallery->show(550, 100, 10);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>    
<?php endif; ?>
<?php echo Utils::getDivClose(); ?>
