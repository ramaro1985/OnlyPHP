<?php echo (isset($error) ? $error : ''); ?>
<table> 
    <tr class="row even"> 
        <td align="right" colspan="2"> 
            <table cellpadding="0" cellspacing="2" width="650" border="0"> 
                <tr> 
                    <td colspan="2"><?php echo $label_trabajadores_disponibles ?></td> 
                    <td colspan="2"></td> 
                    <td colspan="2"><?php echo $label_trabajadores_incluidos ?></td> 
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
        <td valign="top">&nbsp;&nbsp;</td> 
        <td valign="top">&nbsp;&nbsp;<?php echo $btn_submit ?></td> 
        <td valign="top"></td>
    </tr>    
</table>