<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
include_once("utiles/session.class.php");
include_once("controladores/usuario.class.php");
$mySession = new Session();
?>
<?php echo (isset($error) ? $error : ''); ?>
<div id="div_datos_personales">
    <?php $id = $mySession->obtenerVariable('id_activista'); ?>
    <?php if ($id > 0): ?>
        <?php if (file_exists('../imagenes/tmp_activistas/' . $id . '.jpg')): ?>
            <fieldset class="row" style="width: 150px"><legend id="legend_title"><span><?php echo $label_foto_activista ?></span></legend>
                <div class="cell"><image src="<?php echo '../imagenes/tmp_activistas/' . $id . '.jpg' ?>" style="width:145px; height:125px;" ></div>
            </fieldset>
        <?php else: ?>
            <fieldset class="row" style="width: 150px"><legend id="legend_title"><span><?php echo $label_foto_activista ?></span></legend>
                <div class="cell"><image src="../imagenes/tmp_activistas/no_face.jpg " style="width:145px; height:125px;" ></div>
            </fieldset>
        <?php endif; ?>
    <?php endif; ?>
    <fieldset class="row"><legend id="legend_title"><span><?php echo $label_datos_personales ?></span></legend>
        <div class="cell"><?php echo $label_foto_activista . $foto_activista ?></div>
        <div class="cell"><?php echo $label_nombre_completo . $nombre_completo ?></div>
        <div class="cell"><?php echo $label_nro_identidad . $nro_identidad ?></div>        
    </fieldset>
    <fieldset class="row">
        <div class="cell"><?php echo $label_id_provincia . $id_provincia ?></div>
        <div class="cell"><?php echo $label_id_municipio . $id_municipio ?></div>
        <div class="cell"><?php echo $label_id_comuna . $id_comuna ?></div>
        <div class="cell"><?php echo $label_id_cap . $id_cap ?></div>
    </fieldset>
    <fieldset class="row">
        <div class="cell"><?php echo $label_direccion . $direccion ?></div> 
        <div class="cell"><?php echo $label_telefono . $telefono ?></div>
        <div class="cell"><?php echo $label_fecha_nacimiento . $fecha_nacimiento ?></div>
    </fieldset>
    <fieldset class="row">
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
        <div class="cell"><?php echo $label_estado_civil . $estado_civil ?></div>
        <div class="cell"><?php echo $label_correo . $correo ?></div>    
    </fieldset>
</div>
<?php if ($mySession->obtenerVariable('id_activista') == 0): ?>
    <div class="div_datos_laborales">
    <?php else: ?>
        <div class="div_datos_laborales_mod">
        <?php endif; ?>
        <fieldset class="row"><legend id="legend_title"><span><?php echo $label_datos_laborales ?></span></legend>
            <div class="cell"><?php echo $label_nivel_escolar . $nivel_escolar ?></div>
            <div class="cell"><?php echo $label_profesion . $profesion ?></div>
            <div class="cell"><?php echo $label_funcion_trabajo . $funcion_trabajo ?></div>
            <div class="cell"><?php echo $label_org_partidista . $org_partidista ?></div>
        </fieldset>
        <fieldset class="row"><legend id="legend_title"><span><?php echo $label_datos_electorales ?></span></legend>
            <div class="cell"><?php echo $label_id_funcion_mesa . $id_funcion_mesa ?></div>
            <div class="cell"><?php echo $label_nro_carton_electoral . $nro_carton_electoral ?></div>
            <div class="cell"><?php echo $label_nro_carton_militante . $nro_carton_militante ?></div>
            <div class="cell"></div>
        </fieldset>
        <fieldset class="row"><legend id="legend_title"><span><?php echo $label_otros ?></span></legend>
            <div class="cell"><?php echo $label_padre . $padre ?></div>
            <div class="cell"><?php echo $label_madre . $madre ?></div>
            <div class="cell"></div>
        </fieldset>
    </div>
    <?php if ($mySession->obtenerVariable('id_activista') == 0): ?> 
        <div class="div_lenguas">
        <?php else: ?>
            <div class="div_lenguas_mod">
            <?php endif; ?>    
            <table>
                <tr class="row even"> 
                    <td align="right" colspan="2"> 
                        <table cellpadding="0" cellspacing="2" width="635" border="0"> 
                            <tr> 
                                <td colspan="2"><?php echo $label_dialecto_disponible ?></td> 
                                <td colspan="2"></td> 
                                <td colspan="2"><?php echo $label_dialecto_incluido ?></td> 
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
            </table>
            <?php if ($id == 0): ?>    
                <fieldset class="row">
                    <div class="cell"><?php echo $remember_me_yes ?></div>
                    <div class="cell"><?php echo $label_remember_me_yes ?></div>
                </fieldset>
                <div id="zona_usuario" style="width:75%"></div>   
                <fieldset class="row">
                    <div class="cell"><?php echo $label_usuario . $usuario ?></div>
                    <div class="cell"><?php echo $label_clave . $clave ?></div>
                    <div class="cell"><?php echo $label_clave_confirm . $clave_confirm ?></div>
                </fieldset>
            <?php else: ?>    
                <?php
                $nuevoUsuario = new Usuarios();
                $nuevoUsuario->getRecords('id_activista=' . "'$id'");
                $exist_usuario = $nuevoUsuario->objConexion->crearArreglo();
                ?>
                <?php if ($exist_usuario == NULL): ?>
                    <fieldset class="row">
                        <div class="cell"><?php echo $remember_me_yes ?></div>
                        <div class="cell"><?php echo $label_remember_me_yes ?></div>
                    </fieldset>
                    <div id="zona_usuario" style="width:75%"></div>   
                    <fieldset class="row">
                        <div class="cell"><?php echo $label_usuario . $usuario ?></div>
                        <div class="cell"><?php echo $label_clave . $clave ?></div>
                        <div class="cell"><?php echo $label_clave_confirm . $clave_confirm ?></div>
                    </fieldset>
                <?php endif; ?> 
            <?php endif; ?> 
            <div class="row last" style="text-align:center"><?php echo $btn_submit; ?></div>
        </div>