<?php include_once("utiles/session.class.php"); ?>
<?php echo (isset($error) ? $error : ''); ?>
<fieldset class="row">
    <div class="cell"><?php echo $label_id_provincia . $id_provincia ?></div>
    <div class="cell"><?php echo $label_id_municipio . $id_municipio ?></div>
</fieldset>
<fieldset class="row" aling="center" id="zon_mun" name="zon_mun">
    <div class="cell" align="center" style="width:100%"><?php echo $my_button ?></div>
</fieldset>













