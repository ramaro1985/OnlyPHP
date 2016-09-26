<?php echo (isset($error) ? $error : ''); ?>
<table> 
    <tr>
        <td><?php echo $label_usuario ?></td>
        <td class="row"><?php echo $usuario ?></td>
    </tr>
    <tr>
        <td><?php echo $label_nombre_completo ?></td>
        <td class="row"><?php echo $nombre_completo ?></td>
    </tr> 
    <tr class="row last"> 
        <td valign="top" align="right" size="90%"></td> 
        <td valign="top" align="center"><?php echo $btn_submit ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $redirect_password ?></td> 
    </tr>    
</table>