<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
include_once("utiles/session.class.php");
$mySession = new Session();

$casoUso = 'recorridoparte';
require 'Zebra_Form.php';
include_once("utiles/utils.class.php");
//include_once("utiles/upload.class.php");
include_once("idioma/pt.php");
include_once("controladores/provincia.class.php");
include_once("controladores/municipio.class.php");
include_once("controladores/comuna.class.php");
include_once("controladores/proyecto_empresa.class.php");
include_once("controladores/recorrido.class.php");
include_once("controladores/v_recorridoparte_buscar.class.php");
include_once("controladores/" . $casoUso . ".class.php");

if (isset($_GET["id"]) && ($_GET["id"] == 0)) {
    echo Utils::getDivTitulo($label["nuevo_parte"]);

    $id = 0;
    //$id_recorrido = 0;
    $nombre_recorrido = 0;
    $id_usuario = 0;
    $fecha_parte = '';
    $descripcion = '';
    $fecha_inicio_trabajo = '';
    $fecha_fin_trabajo = '';
 
    $mySession->obtenerVariable('id_recorrido');
//echo $_SESSION['id_recorrido'];
    $MM_from_recorrido_parte = 'guardar_nuevo_recorrido_parte';
} else {
    echo Utils::getDivTitulo($label["modificar_parte"]);

    $MyObj = new V_recorridoparte_buscar();
    $MyObj->getRecord($_GET["id"]);
    $aDatos = $MyObj->objConexion->crearArreglo();

    $id = $aDatos['id'];
    $id_recorrido= $aDatos['id_recorrido'];
    $nombre_recorrido = $aDatos['nombre_recorrido'];
    $id_usuario = $aDatos['id_usuario'];
    $fecha_parte = $aDatos['fecha_parte'];
    $descripcion = $aDatos['descripcion'];
    $fecha_inicio_trabajo = $aDatos['fecha_inicio_trabajo'];
    $fecha_fin_trabajo = $aDatos['fecha_fin_trabajo'];
    
    $MM_from_recorrido_parte = 'actualizar_recorrido_parte';
}
echo Utils::getDivOpen();
if (isset($_GET["error"]) && $_GET["error"] == 1) {
    if ($_GET["tipo_error"] == 'insertar_update') {
        $error = $label["error_insertar_update"] . $label["recorrido"] . $label['seleccionado'];
        echo Utils::getDivErrorLogin($error);
    }
} else {
    echo Utils::getDivError($label["usuario_pass_incorrecto"]);
}
$form = new Zebra_Form('form', 'POST', '../negocio/crud_' . $casoUso . '.php');

//Recorridos

if ($fecha_parte != '') {
    $fecha_parte = split(' ', $fecha_parte);
}
$form->add('label', 'label_fecha_parte', 'fecha_parte', $label["fecha_parte"]);

$date = & $form->add('date', 'fecha_parte', $fecha_parte[0], array('style' => 'width:242px'));

$date->format('Y-m-d');

$date->set_rule(array(
    'required' => array('error', $label['fecha_nacimiento_obligatorio']),
    'date' => array('error', $label['fecha_nacimiento_incorrecta']),
));

if ($fecha_inicio_trabajo != '') {
    $fecha_inicio_trabajo = split(' ', $fecha_inicio_trabajo);
}
$form->add('label', 'label_fecha_inicio_trabajo', 'fecha_inicio_trabajo', $label["fecha_inicio_trabajo"]);

$date = & $form->add('date', 'fecha_inicio_trabajo', $fecha_inicio_trabajo[0], array('style' => 'width:242px'));

$date->format('Y-m-d');

$date->set_rule(array(
    'date' => array('error', $label['fecha_nacimiento_incorrecta']),
));

if ($fecha_fin_trabajo != '') {
    $fecha_fin_trabajo = split(' ', $fecha_fin_trabajo);
}
$form->add('label', 'label_fecha_fin_trabajo', 'fecha_fin_trabajo', $label["fecha_fin_trabajo"]);

$date = & $form->add('date', 'fecha_fin_trabajo', $fecha_fin_trabajo[0], array('style' => 'width:242px'));

$date->format('Y-m-d');

$date->set_rule(array(
    'date' => array('error', $label['$echa_fin_trabajo_incorrecta']),
));

$form->add('label', 'label_descripcion', 'descripcion', $label["descripcion"]);

$obj = & $form->add('textarea', 'descripcion', $descripcion, array('style' => 'width:250px'));

$obj = & $form->add('hidden', 'MM_from_recorrido_parte', $MM_from_recorrido_parte);
$obj = & $form->add('hidden', 'id', $id);

$form->add('submit_1', 'btn_submit', $label["guardar"]);
$form->render('*horizontal');
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
        action: '../utiles/upload.class.php?cu=<?php echo $casoUso.'&id='.$id; ?>',
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
                <li><a href="#tabs-1"><?php echo $label["imagenes"] ?></a></li>
               <!-- <li><a href="#tabs-2"><?php// echo $label["documentos"] ?></a></li>-->
            </ul>
            <div id="tabs-1">
                <div>
                    <div id="error_img" hidden="true" class="error"><?php echo Utils::getDivErrorLogin($label["error_img"]);?></div>
                    <div ><image src="../vistas/public/imagenes/add_img.jpg" id="upload_imagen" ><!--<image src="../vistas/public/imagenes/remove_img.jpg" id="" >--></div>            
                    <div id="gallery">
                    <?php
                        include_once("utiles/gallery.class.php");
                        $mygallery = new gallery();
                        $pathFolder = '../'. CAMINO_DOC_ADJUNTOS. '/'. $casoUso. '/'. $id;
                        @$mygallery->loadFolder( $pathFolder );
                        $mygallery->show(550, 100, 10);
                    ?>
                    </div>
                </div>
            </div>
            <div id="tabs-2">
                <div ><?php// echo $label["documentos"] ?></div>
            </div>
        </div>
    </div>
    <?php
endif;
echo Utils::getDivClose();
?>