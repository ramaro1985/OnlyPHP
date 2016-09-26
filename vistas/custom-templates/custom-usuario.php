<?php echo (isset($error) ? $error : ''); ?>
<div id="div_recorrido">
    <table> 
        <tr class="row"> 
            <td valign="top"><?php echo $label_usuario ?></td> 
            <td valign="top"><?php echo $usuario ?></td> 
        </tr>
        <tr class="row even"> 
            <td valign="top"><?php echo $label_nombre_completo ?></td> 
            <td valign="top"><?php echo $nombre_completo ?></td> 
        </tr>
        <?php if ($label_password != null) { ?>
            <tr class="row"> 
                <td valign="top"><?php echo $label_password ?></td> 
                <td valign="top"><?php echo $clave . $note_clave ?></td> 
            </tr>
            <tr class="row even"> 
                <td valign="top"><?php echo $label_confirm_clave ?></td> 
                <td valign="top"><?php echo $confirm_clave ?></td> 
            </tr>    
        <?php } ?>
        <tr class="row"> 
            <td valign="top"><?php echo $label_habilitado ?></td> 
            <td valign="top">
                <div class="cell"><?php echo $habilitado_true ?></div>
                <div class="cell"><?php echo $label_habilitado_true ?></div>
                <div class="clear"></div>
                <div class="cell"><?php echo $habilitado_false ?></div>
                <div class="cell"><?php echo $label_habilitado_false ?></div>
                <div class="clear"></div>
            </td> 
        </tr>
        <tr class="row even"> 
            <td align="right" colspan="2"> 
                <table cellpadding="0" cellspacing="2" width="650" border="0"> 
                    <tr> 
                        <td colspan="2"><?php echo $label_grupo_disponible ?></td> 
                        <td colspan="2"></td> 
                        <td colspan="2"><?php echo $label_grupo_incluido ?></td> 
                    </tr> 
                    <tr> 
                        <td colspan="2" align="center" valign="top"><?php echo $disponible ?></td> 
                        <td colspan="2" width="90" nowrap>
                            <table cellpadding="1" width="100%" align="center"> 
                                <tr> 
                                    <td><?php echo $pasaruno ?></td> 
                                </tr> 
                                <tr> 
                                    <td><?php echo $pasartodos ?></td> 
                                </tr> 
                                <tr> 
                                    <td><?php echo $retornaruno ?></td> 
                                </tr> 
                                <tr> 
                                    <td><?php echo $retornartodos ?></td> 
                                </tr> 
                            </table>
                        </td> 
                        <td colspan="2" align="center" valign="top"><?php echo $incluido; /* if ($label_password != null) { echo substr_replace($incluido, "</select>", strpos($incluido, "<option"), strlen($incluido)); } else { echo $incluido; } */ ?></td> 
                    </tr> 
                </table>
            </td> 
        </tr>    
        <tr class="row last"> 
            <td valign="top"></td> 
            <td valign="top"><?php echo $btn_submit ?><?php echo $redirect_password?></td> 
        </tr>    
    </table>
</div>