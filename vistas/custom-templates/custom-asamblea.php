<?php
include_once("utiles/session.class.php");
$mySession = new Session();
$cerrada = $mySession->obtenerVariable('cerrada');
$confirmada = $mySession->obtenerVariable('confirmada');
?>
<?php echo (isset($error) ? $error : ''); ?>
<fieldset class="row">
    <div class="cell"><?php echo $label_id_provincia . $id_provincia ?></div>
    <div class="cell"><?php echo $label_id_municipio . $id_municipio ?></div>
    <div class="cell"><?php echo $label_id_comuna . $id_comuna ?></div>
    <div class="cell"><?php echo $label_id_cap . $id_cap ?></div>
    <div class="cell"><?php echo $label_cabo_electoral . $id_usuario ?></div>
</fieldset>
<fieldset class="row">
    <div class="cell"><?php echo $label_localidad . $localidad ?></div>
    <div class="cell"><?php echo $label_poblado . $poblado ?></div>
    <div class="cell"><?php echo $label_presidente_asamblea . $presidente_asamblea ?></div>
    <div class="cell"><?php echo $label_codigo_asamblea . $codigo_asamblea ?></div>
    <div class="cell"><?php echo $label_electores_registrados . $electores_registrados ?></div>
</fieldset>

<?php if ($mySession->obtenerVariable('id_asamblea') > 0): ?>

    <?php echo $votos_blanco ?>
    <?php echo $votos_nulos ?>
    <?php echo $votos_reclamados ?>
    <?php echo $votos_validos ?>

<?php endif; ?>

<?php if ($cerrada == 't' && $confirmada == 't'): ?>
    <?php echo $label_asamablea_confirmada; ?>
<?php else: ?>
    <fieldset class="row" aling="center" >

        <div class="cell" align="right" style="width:50%"><?php echo $btn_submit ?></div>
        <div class="cell" align="left" style="width:25%"><input type="button" class="button" value="Cancelar" onclick="location.href='index.php?frm=asamblea&template=lst'" ></div>

        <?php if ($cerrada == 'f' && $mySession->obtenerVariable('id_asamblea') > 0): ?>
            <input type="hidden" name="confirmada" id="confirmada" value="0">
            <div class="cell" align="right" style="width:20%"><label style="color: red"><?php echo $label_cerrar_asamablea ?></label></div>
            <div class="cell" align="left"> <input type="checkbox" class="checkbox" id="cerrada" name="cerrada" value="1"></div>
        <?php elseif ($confirmada == 'f' && $mySession->obtenerVariable('id_asamblea') > 0): ?>
            <input type="hidden" name="cerrada" id="cerrada" value="1">
            <div class="cell" align="right" style="width:20%"><label style="color: red"><?php echo $label_confirmar_asamablea ?></label></div>
            <div class="cell" align="left"><input type="checkbox" class="checkbox" id="confirmada" name="confirmada" value="1"></div>
            <?php endif; ?>

    </fieldset>
<?php endif; ?>













