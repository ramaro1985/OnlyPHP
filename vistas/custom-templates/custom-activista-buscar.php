<?php echo (isset($error) ? $error : ''); ?>
<div id="div_recorrido">
<fieldset class="row"><legend id="legend_title"><span><?php echo $label_datos_personales ?></span></legend>
    <div class="cell"><?php echo $label_nombre_completo . $nombre_apellido ?></div>
    <div class="cell"><?php echo $label_nro_identidad . $nro_identidad ?></div>        
    <div class="cell"><?php echo $label_correo . $correo ?></div>        
</fieldset>
<fieldset class="row">
    <div class="cell"><?php echo $label_vincia . $id_provincia ?></div>
    <div class="cell"><?php echo $label_municipio . $id_municipio ?></div>
    <div class="cell"><?php echo $label_comuna . $id_comuna ?></div>
    <div class="cell"><?php echo $label_cap . $id_cap ?></div>
</fieldset>
<fieldset class="row">
    <div class="cell"><?php echo $label_direccion . $direccion ?></div> 
    <div class="cell"><?php echo $label_telefono . $telefono ?></div>
    <div class="cell"><?php echo $label_fecha_nacimiento . $fecha_nacimiento ?></div>
</fieldset>
<fieldset class="row">
    <div class="cell"><?php echo $label_estado_civil . $id_estado_civil ?></div>
    <div class="cell">
        <div class="cell"><?php echo $label_sexo . $sexo ?>
            <div class="cell"><?php echo $label_sexo_F ?></div>
            <div class="cell"><?php echo $sexo_F ?></div>
        </div>
        <div class="cell"><br>
            <div class="cell"><?php echo $label_sexo_M ?></div>
            <div class="cell"><?php echo $sexo_M ?></div>
        </div>
    </div>    
    <div class="cell"><?php echo $label_padre . $padre ?></div>
    <div class="cell"><?php echo $label_madre . $madre ?></div>
</fieldset>
<br>
<fieldset class="row"><legend id="legend_title"><span><?php echo $label_datos_laborales ?></span></legend>
    <div class="cell"><?php echo $label_nivel_escolar . $id_nivel_escolar ?></div>
    <div class="cell"><?php echo $label_profesion . $id_profesion ?></div>
    <div class="cell"><?php echo $label_funcion_trabajo . $id_funcion_trabajo ?></div>
    <div class="cell"><?php echo $label_org_partidista . $id_organizacion ?></div>
</fieldset>
<br>
<fieldset class="row"><legend id="legend_title"><span><?php echo $label_datos_electorales ?></span></legend>
    <div class="cell"><?php echo $label_nro_carton_electoral . $nro_carton_electoral ?></div>
    <div class="cell"><?php echo $label_nro_carton_militante . $nro_carton_militante ?></div>
    <div class="cell"></div>
</fieldset>
<div class="row last" style="text-align:center"><?php echo $btn_submit;?></div>
</div>










