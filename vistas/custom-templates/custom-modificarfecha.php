<?php echo (isset($error) ? $error : ''); ?>
<div id="div_recorrido" style="width:auto">
<table> 
    <tr class="row">
        <td class="row"><?php echo $label_pre_campanna ?></td>
        <td class="row"><?php echo $label_fecha_inicio_pre.$fecha_inicio_pre?></td>
        <td class="row"><?php echo $label_fecha_fin_pre.$fecha_fin_pre?></td>
    </tr>
    <tr class="row">
        <td class="row"><?php echo $label_en_campanna ?></td>
        <td class="row"><?php echo $label_fecha_inicio_en.$fecha_inicio_en?></td>
        <td class="row"><?php echo $label_fecha_fin_en.$fecha_fin_en?></td></td>
    </tr>
    <tr class="row">
        <td class="row"></td>
        <td class="row" aling="center"><?php echo $btn_submit ?></td>
        <td class="row"></td>
    </tr>
</table>
</div>    
