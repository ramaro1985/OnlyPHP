<fieldset class="row">
    <div class="cell"><?php echo $label_id_provincia . $id_provincia ?></div>
    <div class="cell"><?php echo $label_id_municipio . $id_municipio ?></div>
    <div class="cell"><?php echo $label_id_comuna . $id_comuna ?></div>
    <div class="cell"><?php echo $label_local . $local ?></div>
</fieldset>

<fieldset class="row">
    <div class="cell"><?php echo $label_id_tipo_organizacion_enevento . $id_tipo_organizacion_enevento ?><?php echo $label_id_organizacion . $id_organizacion ?></div>
    <div class="cell"><?php echo $label_id_dirigente . $id_dirigente ?></div>
    <div class="cell"><?php echo $label_presidente_acto . $presidente_acto ?></div>
    <div class="cell"><?php echo $label_cordinador . $cordinador ?></div>
</fieldset>
<!--
<div class="cell">
        <table>
            <tr class="row">
                <td class="cell"><?php// echo $label_add_prelectores . $add_prelectores ?></td>
                <td class="cell" aling="right"><?php// echo '<br>' . $add ?></td>
                <td class="cell" aling="left"><?php// echo '<br>' . $remove ?></td>
                <td class="cell" aling="left"><?php// echo '<br>'. $label_principales_ocurrencias ?></td>
            </tr>
            <tr>
                <td colspan="3" valign="top"><?php// echo $prelectores ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
               
            </tr>
        </table>
</div>
-->
<fieldset class="row">
    <div class="cell"><?php echo $label_fecha_planificada . $fecha_planificada ?></div>
    <div class="cell"><?php echo $label_hora_planificada . $hora_planificada?></div>
    <div class="cell"><?php echo $label_min_planificada . $min_planificada?></div>
    <div class="cell"><?php echo $label_horario_planificada .'<br>'. $horario_planificada?></div>
    <div class="cell">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
    <div class="cell"><?php echo $label_fecha_realizada . $fecha_realizada ?></div>
    <div class="cell"><?php echo $label_hora_realizada . $hora_realizada?></div>
    <div class="cell"><?php echo $label_horario_realizada. $min_realizada?></div>
    <div class="cell"></div>
</fieldset>

<fieldset class="row">
    <div class="cell"><?php echo $label_enfoque.$enfoque?></div>
</fieldset>
<fieldset class="row">
    <div class="cell"><?php echo $label_medidas_organizativas.$medidas_organizativas?></div>
</fieldset>
<fieldset class="row">
    <div class="cell"><?php echo $label_impacto.$impacto?></div>
</fieldset>
<fieldset class="row">
    <div class="cell"><?php echo $label_principales_ocurrencias.$principales_ocurrencias ?></div>
</fieldset>
<fieldset class="row">
    <div class="cell"><?php echo $label_dificultades.$dificultades ?></div>
</fieldset>

<fieldset class="row">
    <div class="cell"><?php echo $label_medidas_seguridad.$medidas_seguridad ?></div>
</fieldset>

<fieldset class="row">
<div class="cell"><?php echo $label_cantidad_participantes_aproximado . $cantidad_participantes?></div>
</fieldset>
<table width="100%">
    <tr>
        <td  align="center"><?php echo $btn_submit ?></td>
    </tr>
</table>