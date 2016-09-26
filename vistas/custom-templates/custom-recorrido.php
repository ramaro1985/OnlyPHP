<script>
    $(function() {
        $( "#tabs" ).tabs();
    });
</script>
<?php
include_once("controladores/v_recorrido_producto.class.php");
include_once("utiles/utils.class.php");
include_once("utiles/session.class.php");
$mySession = new Session();
?>
<?php echo (isset($error) ? $error : ''); ?>
<table>
    <tr>
        <td align="left" ><?php echo $label_datos_recorrido ?></td>
        <td align="left" ></td>
        <td align="left" ></td>
        <td align="left" ></td>
    </tr>
    <?php if ($mySession->obtenerVariable('id_recorrido') == 0): ?>
    <tr class="row">
            <td align="left" class="row"><?php echo $label_id_empresa . $id_empresa ?></td>
            <td align="left" class="row"><?php echo $label_id_proyecto . $id_proyecto ?></td>
            <td align="left" class="row"></td>
            <td align="left" class="row"></td>
        </tr>
    <?php endif; ?>
    <tr class="row" align="left">
        <td align="left" class="row"><?php echo $label_nombre_recorrido . $nombre_recorrido ?></td>
        <td align="left" class="row"><?php echo $label_id_estado . $id_estado ?></td>
        <td align="left" class="row"><?php echo $label_id_tipo_supervisor . $id_tipo_supervisor ?></td>
        <td align="left" class="row"><?php echo $label_id_usuario . $id_usuario ?></td>
    </tr>
    <tr class="row" align="left">
        <td align="left" class="row"><?php echo $label_fecha_propuesta_inicio . $fecha_propuesta_inicio ?></td>
        <td align="left" class="row"><?php echo $label_fecha_inicio . $fecha_inicio ?></td>
        <td align="left" class="row"><?php echo $label_fecha_propuesta_fin . $fecha_propuesta_fin ?></td>
        <td align="left" class="row"><?php echo $label_fecha_fin . $fecha_fin ?></td>
    </tr>
    <tr class="row" align="left">
        <td class="row" align="left"><?php echo $label_id_provincia . $id_provincia ?></td>
        <td class="row" align="left"><?php echo $label_id_municipio . $id_municipio ?></td>
        <td class="row" align="left"><?php echo $label_id_comuna . $id_comuna ?></td>
        <td class="row" align="left"></td>
    </tr>
</table> 
<fieldset class="row" aling="center" >
<div class="cell" align="right" style="width:50%"><?php echo $btn_submit ?></div>
<div class="cell" align="left" style="width:45%"><input type="button" class="button" value="Cancelar" onclick="location.href='index.php?frm=recorrido&template=lst'" ></div>
</fieldset>













