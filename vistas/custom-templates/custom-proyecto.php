<?php
include_once("utiles/session.class.php");
$mySession = new Session();
?>
<?php echo (isset($error) ? $error : ''); ?>
<table> 
    <tr>
        <td class="cell"><?php echo $label_id_empresa ?></td>
        <td class="row"><?php echo $id_empresa ?></td>
    </tr>
    <tr>
        <td class="cell"><?php echo $label_nombre_proyecto ?></td>
        <td class="row"><?php echo $nombre_proyecto ?></td>
    </tr>
    <tr>
        <td class="cell"><?php echo $label_lider ?></td>
        <td class="row"><?php echo $lider ?></td>
    </tr> 
    <tr>
        <td class="cell"><?php echo $label_descripcion ?></td>
        <td class="row"><?php echo $descripcion ?></td>
    </tr> 
    <tr>
        <td class="cell"><?php echo $label_id_estado ?></td>
        <td class="row"><?php echo $id_estado ?></td>
    </tr> 
</table>
<fieldset class="row" aling="center" >
<div class="cell" align="right" style="width:50%"><?php echo $btn_submit ?></div>
<div class="cell" align="left" style="width:45%"><input type="button" class="button" value="Cancelar" onclick="location.href='index.php?frm=proyecto&template=lst'" ></div>
</fieldset>
