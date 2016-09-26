<script type="text/javascript">
    <!--
    function pp(){
        alert('kk')
    }
    -->
</script> 
<?php
include_once("controladores/v_recorrido_producto.class.php");
include_once("utiles/utils.class.php");
include_once("utiles/session.class.php");
include_once("controladores/mesaelecotoral_funcionario.class.php");
$mySession = new Session();
?>
<?php echo (isset($error) ? $error : ''); ?>
<?php $FuncionMesa = $mySession->obtenerVariable('FuncionMesa'); ?>
<?php $id_asamblea_resultado = $mySession->obtenerVariable('id_asamblea_resultado'); ?>
<?php $MesaOrgan = $mySession->obtenerVariable('MesaOrgan'); ?>
<?php $activo = $mySession->obtenerVariable('activo'); ?>
<?php
$ObjAsamblea_result = new Asamblea_resultado();
$ObjAsamblea_result->getRecords('id=' . "'$id_asamblea_resultado'");
$Obj = $ObjAsamblea_result->objConexion->crearArreglo();
$asamblea_cerrada = $Obj["cerrada"];
$asamblea_confirmada = $Obj["confirmada"];
?>

<fieldset class="row">
    <div class="cell" style="width: 75%"><?php echo $label_desc_mesa . $desc_mesa ?></div>
    <div class="cell">&nbsp;</div>
    <?php if ($mySession->obtenerVariable('id_mesa') > 0): ?>
        <?php if ($activo == FALSE): ?>
            <div class="cell" align="center"><?php echo $label_activo ?><input type="checkbox" name="activo" ></div>
        <?php elseif ($activo == 't' || $asamblea_cerrada == 't'): ?>   
            <div class="cell" align="center"><?php echo $label_activo ?><input type="checkbox" name="activo" checked="on"></div>
        <?php endif; ?>
    <?php endif; ?>
</fieldset>
<?php if ($mySession->obtenerVariable('id_mesa') > 0): ?>
    <table style="width: 100%">
        <tr class="row">
            <td><label><?php echo $label_organzacion ?></label></td>
            <td><label><?php echo $label_no_votos ?></label></td>
        </tr>
        <?php for ($i = 0; $i < count($MesaOrgan); $i++): ?>
            <?php //if ($MesaOrgan[$i]->abreviatura != 'UNITA'): ?>
                <tr class="row">
                    <td><label name ="<?php echo $i ?>" title="<?php echo $MesaOrgan[$i]->org_partidista ?>"><?php echo $MesaOrgan[$i]->abreviatura ?></label></td>
                    <td><input type="text" class="text" name="voto_efectuado<?php echo $MesaOrgan[$i]->id ?>"  onkeypress="return validar_numero(this, event)" value="<?php echo $MesaOrgan[$i]->voto_efectuado ?>"></td>
                </tr>
            <?php //endif; ?>
        <?php endfor; ?>
    </table>
    <fieldset class="row">
        <div class="cell"><?php echo $label_votos_blanco . $votos_blanco ?></div>
        <div class="cell"><?php echo $label_votos_nulos . $votos_nulos ?></div>
        <div class="cell"><?php echo $label_votos_reclamados . $votos_reclamados ?></div>
        <div class="cell"><?php echo $label_votos_validos . $votos_validos ?></div>
    </fieldset>
<?php endif; ?>
<!--Con este Fieldset garantizo las funciones de mesa de los funcionarios -->
<fieldset class="row">
    <table>
        <?php for ($i = 0; $i < count($FuncionMesa); $i++): ?>
            <?php
            $id_mesa = $mySession->obtenerVariable('id_mesa');
            $id_funcion_mesa = $FuncionMesa[$i]->id;
            $ObjFuncionario_Mesa = new Mesaelecotoral_funcionario();
            $ObjFuncionario_Mesa->getRecords('id_mesa=' . "'$id_mesa'" . 'AND id_funcion_mesa=' . "'$id_funcion_mesa'");
            $Funcionario_Mesa = $ObjFuncionario_Mesa->objConexion->crearArreglo();
            ?>    
            <input type="hidden" name="id_funcion_mesa<?php echo $FuncionMesa[$i]->id ?>" value="<?php echo $FuncionMesa[$i]->id ?>">
            <tr>
                <td colspan="2"><label class="label"><?php echo $FuncionMesa[$i]->funcion_mesa ?></label></td>
            </tr>
            <tr>
                <td><input type="text" name="nombre_apellido<?php echo $FuncionMesa[$i]->id ?>" class="text" value="<?php echo $Funcionario_Mesa["nombre_apellido"] ?>" title="Nome e apelidos"><?php echo $note_nombre ?></td>
                <td><input type="text" name="num_carton<?php echo $FuncionMesa[$i]->id ?>" class="text" value="<?php echo $Funcionario_Mesa["nro_carton_electoral"] ?>" title="Nº de cartão eleitoral"><?php echo $num_carton ?></td>
            </tr>
        <?php endfor; ?>
    </table>
</fieldset>
<?php
if ($asamblea_confirmada == 't') {
    echo $label_asamblea_cerrada;
} else {
    //if ($activo == FALSE) {
        echo '
    <table width="100%">
        <tr>
            <td  align="center">' . $btn_submit . '</td>
        </tr>
    </table>
           ';
   // }
}
?>