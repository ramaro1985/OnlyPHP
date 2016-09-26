<script>
    $(function() {
        $( "#tabs" ).tabs();
    });
</script>
<?php echo (isset($error) ? $error : ''); ?>
<fieldset class="row"><legend><?php echo $label_datos_generales ?></legend>
    <div class="cell"><?php echo $label_nombre_empresa . $nombre_empresa ?></div>
    <div class="cell"><?php echo $label_direcion . $direccion ?></div>
    <div class="cell"><?php echo $label_id_tipo_servicio . $id_tipo_servicio ?></div>
</fieldset>
<fieldset class="row" aling="center" >
<div class="cell" align="right" style="width:50%"><?php echo $btn_submit ?></div>
<div class="cell" align="left" style="width:45%"><input type="button" class="button" value="Cancelar" onclick="location.href='index.php?frm=empresa&template=lst'" ></div>
</fieldset>









