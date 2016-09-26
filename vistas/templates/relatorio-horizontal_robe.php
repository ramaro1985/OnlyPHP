<script>
    $(document).ready(function(){
        $( "#tabs" ).tabs();
    });
</script>
<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));

include_once("configuracion/configuracion.php");
include_once("acceso_datos/" . DRIVER_BD . "_acceso_datos.class.php");
include_once("utiles/session.class.php");
include_once("idioma/pt.php");
include_once("utiles/utils.class.php");
include_once("controladores/mesaelectoral_organizacion.class.php");
include_once("controladores/organizacion.class.php");
include_once("controladores/v_mesaelectoral_organizacion.class.php");
include_once("controladores/mesaelectoral.class.php");
include_once("controladores/asamblea.class.php");
include_once("controladores/v_asamblea_buscar.class.php");
include_once("controladores/asamblea_resultado.class.php");
include_once("controladores/provincia.class.php");
include_once("controladores/municipio.class.php");
include_once("controladores/relatorio.class.php");

$ObjOrg = new Organizaciones();
$ObjOrg->getRecords();
$Org = $ObjOrg->objConexion->crearArregloObjetos();

for ($i = 0; $i < count($Org); $i++) {
    $cant_votos_n = 0;
    $id_organizacion = $Org[$i]->id;

    $MesaOrg = new Mesaelectoral_organizacion();
    $MesaOrg->getRecords('id_organizacion=' . "'$id_organizacion'");
    $ObjMesaOrg = $MesaOrg->objConexion->crearArregloObjetos();
    for ($j = 0; $j < count($ObjMesaOrg); $j++) {
        $cant_votos_n += $ObjMesaOrg[$j]->voto_efectuado;
    }
    $cant_votos_total += $cant_votos_n;
}

$ObjAsamblea = new Asamblea();
$ObjAsamblea->getRecords();
$Asamblea = $ObjAsamblea->objConexion->crearArregloObjetos();

if (is_array($Asamblea)) {
    $num_asamblea = count($Asamblea);
} else {
    $num_asamblea = 0;
}

$ObjAsamblea_conf = new Asamblea_resultado();
$ObjAsamblea_conf->getRecords('confirmada=true');
$Asamblea_conf = $ObjAsamblea_conf->objConexion->crearArregloObjetos();
if (is_array($Asamblea_conf)) {
    $num_asamblea_confirm = count($Asamblea_conf);
} else {
    $num_asamblea_confirm = 0;
}
/*
  $var = new Mesaelectoral_organizacion();
  $var->getRecords();
  $mesa = $var->objConexion->crearArregloObjetos();
  for ($j = 0; $j < count($mesa); $j++) {
  $cant_votos_total+= $mesa[$j]->voto_efectuado;
  } */

$ObjAsamblea_res = new Asamblea_resultado();
$ObjAsamblea_res->getRecords();
$Asamblea_res = $ObjAsamblea_res->objConexion->crearArregloObjetos();
if (is_array($Asamblea_res) && count($Asamblea_res) > 0) {
    for ($i = 0; $i < count($Asamblea_res); $i++) {
        $votos_blanco += $Asamblea_res[$i]->votos_blanco;
        $votos_reclamados += $Asamblea_res[$i]->votos_reclamados;
        $votos_nulos += $Asamblea_res[$i]->votos_nulos;
        $votos_validos += $Asamblea_res[$i]->votos_validos;
    }
} else {
    $votos_blanco = 0;
    $votos_reclamados = 0;
    $votos_nulos = 0;
    $votos_validos = 0;
}

$objProvincia = new Provincias();
$objProvincia->getRecords();
$Provincia = $objProvincia->objConexion->crearArregloObjetos();

echo Utils::getDivTitulo($label["relatorio"]);
echo Utils::getDivOpen();
?>
<div class="demo">
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1"><?php echo $label["relatorio_1"] ?></a></li>
            <li><a href="#tabs-2"><?php echo $label["relatorio_2"] ?></a></li>
            <li><a href="#tabs-3"><?php echo $label["relatorio_3"] ?></a></li>
            <li><a href="#tabs-4"><?php echo 'Relatorio 4' ?></a></li>
        </ul>
        <div id="tabs-1">
            <table width="100%" class="table" cellspacing="2" cellpadding="2">
                <tr  bgcolor="#FFFF99" >
                    <td rowspan="2" class="td"><div align="center"><label class="label">&nbsp;<?php echo $label["partido"] ?>&nbsp;</label></div></td>
                    <td colspan="2" class="td"><div align="center"><label class="label">Votos</label></div></td>
                </tr>
                <tr  bgcolor="#FFFF99">
                    <td><div align="center" class="td" ><label>&nbsp;<?php echo $label["qte"] ?>&nbsp;</label></div></td>
                    <td><div align="center" class="td"><label>&nbsp;%&nbsp;</label></div></td>
                </tr>
                <?php
                $relat = new Relatorio();
                $relat->getRecords();
                $objrelat = $relat->objConexion->crearArregloObjetos();
                ?>
                <?php for ($i = 0; $i < count($objrelat); $i++): ?>
                    <tr>
                        <?php
                        $cadena = $objrelat[$i]->abreviatura . '/' . $objrelat[$i]->porciento . ',' . $cadena . '/'
                        ?>

                        <td class="td"><label class="label">&nbsp;<?php echo $objrelat[$i]->abreviatura ?>&nbsp;</label></td>
                        <td class="td"><div align="center">&nbsp;<?php echo $objrelat[$i]->totalxpartido ?>&nbsp;</div></td>
                        <td class="td"><div align="center">&nbsp;<?php echo $objrelat[$i]->porciento ?>&nbsp;</div></td>
                    </tr>
                <?php endfor; ?> 
                <tr  bgcolor="#FFFF99">
                    <td class="td"><div>&nbsp;<?php echo $label["total"] ?>&nbsp;</div></td>
                    <td class="td"><div>&nbsp;<?php echo $cant_votos_total ?>&nbsp;</div></td>
                    <td class="td"><div>&nbsp;<?php echo $label["100%"] ?>&nbsp;</div></td>
                </tr>     
                <tr>
                    <td colspan="3"><div align="center">&nbsp;</div></td>
                </tr>
                <tr>
                    <td class="td"><div><label><?php echo $label["total_votos_blanco"] ?></label></div></td>
                    <td colspan="2" class="td"><div align="center"><?php echo $votos_blanco ?></div></td>
                </tr>
                <tr>
                    <td class="td"><div><label><?php echo $label["total_votos_nulos"] ?></label></div></td>
                    <td colspan="2" class="td"><div align="center"><?php echo $votos_nulos ?></div></td>
                </tr>
                <tr>
                    <td class="td"><div><label><?php echo $label["total_votos_reclamados"] ?></label></div></td>
                    <td colspan="2" class="td"><div align="center"><?php echo $votos_reclamados ?></div></td>
                </tr>
                <tr>
                    <td class="td"><div><label><?php echo $label["total_votos_validos"] ?></label></div></td>
                    <td colspan="2" class="td"><div align="center"><?php echo $votos_validos ?></div></td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td class="td"><div><label><?php echo $label["total_asambleas"] ?></label></div></td>
                    <td colspan="2" class="td"><div align="center"><?php echo $num_asamblea ?></div></td>
                </tr>
                <tr>
                    <td class="td"><div><label><?php echo $label["total_asambleas_procesadas"] ?></label></div></td>
                    <td colspan="2" class="td"><div align="center"><?php echo $num_asamblea_confirm ?></div></td>
                </tr>
            </table>
            <br>
            <img src="../vistas/libraries/phplot/graficar.php?cadena=<?php echo $cadena ?>">
            <br>
            <img src="../vistas/libraries/phplot/graficar_pie.php?cadena=<?php echo $cadena ?>"> 
        </div>
        <div id="tabs-2">
            <div>
                <table width="100%" border="1" class="table" cellspacing="2" cellpadding="2">
                    <tr bgcolor="#FFFF99">
                        <td width="25%" rowspan="2" class="td"><div align="center"><?php echo $label["provincia"] ?></div></td>
                        <td width="15%" rowspan="2" class="td"><div align="center"><?php echo $label["num_asambleas"] ?></div></td>
                        <td width="15%" rowspan="2" class="td"><div align="center"><?php echo $label["electores_registrados"] ?></div></td>
                        <td colspan="2" class="td"><div align="center"><?php echo $label["total_votos_validos"] ?></div></td>
                        <td colspan="2" class="td"><div align="center"><?php echo $label["total_votos_blanco"] ?></div></td>
                        <td colspan="2" class="td"><div align="center"><?php echo $label["total_votos_nulos"] ?></div></td>
                    </tr>
                    <tr bgcolor="#FFFF99">
                        <td width="8%" class="td"><div align="center"><?php echo $label["qte"] ?></div></td>
                        <td width="7%" class="td"><div align="center">%</div></td>
                        <td width="8%" class="td"><div align="center"><?php echo $label["qte"] ?></div></td>
                        <td width="7%" class="td"><div align="center">%</div></td>
                        <td width="8%" class="td"><div align="center"><?php echo $label["qte"] ?></div></td>
                        <td width="7%" class="td"><div align="center">%</div></td>
                    </tr>
                    <?php for ($i = 0; $i < count($Provincia); $i++): ?>
                        <tr>
                            <td class="td">&nbsp;<?php echo $Provincia[$i]->provincia ?>&nbsp;</td>
                            <?php
                            $electores_registrados = 0;
                            $votos_validos_x_prov = 0;
                            $votos_blancos_x_prov = 0;
                            $votos_nulos_x_prov = 0;

                            $id_provincia = $Provincia[$i]->id;
                            $objAsamblea = new v_Asamblea_buscar();
                            $objAsamblea->getRecords('id_provincia = ' . "'$id_provincia'");
                            $asamblea_result = $objAsamblea->objConexion->crearArregloObjetos();

                            if (is_array($asamblea_result)) {
                                $num_asamblea_prov = count($asamblea_result);
                            } else {
                                $num_asamblea_prov = 0;
                            }
                            $asamblea_total += $num_asamblea_prov;

                            foreach ($asamblea_result as $key) {

                                $electores_registrados += $key->electores_registrados;
                                $votos_validos_x_prov += $key->votos_validos;
                                $votos_blancos_x_prov += $key->votos_blanco;
                                $votos_nulos_x_prov += $key->votos_nulos;
                            }
                            $electores_registrados_total += $electores_registrados;
                            if ($Provincia[$i]->provincia == 'Lunda-Norte') {
                                $cadena_1 = 'L.Norte' . '/' . $votos_validos_x_prov . '-' . $votos_nulos_x_prov . ',' . $cadena_1 . '/';
                            } elseif ($Provincia[$i]->provincia == 'Lunda-Sul') {
                                $cadena_1 = 'L.Sul' . '/' . $votos_validos_x_prov . '-' . $votos_nulos_x_prov . ',' . $cadena_1 . '/';
                            } elseif ($Provincia[$i]->provincia == 'Cuanza-Norte') {
                                $cadena_1 = 'C.Norte' . '/' . $votos_validos_x_prov . '-' . $votos_nulos_x_prov . ',' . $cadena_1 . '/';
                            } elseif ($Provincia[$i]->provincia == 'Cuanza-Sul') {
                                $cadena_1 = 'C.Sul' . '/' . $votos_validos_x_prov . '-' . $votos_nulos_x_prov . ',' . $cadena_1 . '/';
                            } elseif ($Provincia[$i]->provincia == 'Cuando Cubango') {
                                $cadena_1 = ' C.Cubango ' . '/' . $votos_validos_x_prov . '-' . $votos_nulos_x_prov . ',' . $cadena_1 . '/';
                            } else {
                                $cadena_1 = $Provincia[$i]->provincia . '/' . $votos_validos_x_prov . '-' . $votos_nulos_x_prov . ',' . $cadena_1 . '/';
                            }
                            ?>
                            <?php
                            $total_validos_x_prov[$id_provincia] = $votos_validos_x_prov;
                            $total_blancos_x_prov[$id_provincia] = $votos_blancos_x_prov;
                            $total_nulos_x_prov[$id_provincia] = $votos_nulos_x_prov;
                            $total_electores_x_prov[$id_provincia] = $electores_registrados;
                            $total_asamblea_x_prov[$id_provincia] = $num_asamblea_prov;
                            ?>
                            <td class="td"><div align="center"><?php echo $num_asamblea_prov ?></div></td>
                            <td class="td"><div align="center"><?php echo $electores_registrados; ?></div></td>
                            <td class="td"><div align="center"><?php echo $votos_validos_x_prov; ?></div></td>
                            <td class="td"><div align="center"><?php echo round(($votos_validos_x_prov * 100) / $votos_validos, 2); ?></div></td>
                            <td class="td"><div align="center"><?php echo $votos_blancos_x_prov; ?></div></div></td>
                            <td class="td"><div align="center"><?php echo round(($votos_blancos_x_prov * 100) / $votos_blanco, 2); ?></div></td>
                            <td class="td"><div align="center"><?php echo $votos_nulos_x_prov; ?></div></td>
                            <td class="td"><div align="center"><?php echo round(($votos_nulos_x_prov * 100) / $votos_nulos, 2); ?></div></td>
                        </tr>
                    <?php endfor; ?>
                    <tr bgcolor="#FFFF99">
                        <td class="td"><?php echo $label["total"] ?></td>
                        <td class="td"><div align="center"><?php echo $asamblea_total; ?></div></td>
                        <td class="td"><div align="center"><?php echo $electores_registrados_total; ?></td>
                        <td class="td"><div align="center"><?php echo $votos_validos; ?></td>
                        <td class="td"><div align="center">100%</div></td>
                        <td class="td"><div align="center"><?php echo $votos_blanco; ?></td>
                        <td class="td"><div align="center">100%</div></td>
                        <td class="td"><div align="center"><?php echo $votos_nulos; ?></td>
                        <td class="td"><div align="center">100%</div></td>
                    </tr>
                </table> 
                <br>
                <img src="../vistas/libraries/phplot/graficar_provincias.php?cadena=<?php echo $cadena_1 ?>">
            </div>
        </div>
        <div id="tabs-3">
            <div >
                <?php for ($i = 0; $i < count($Provincia); $i++): ?>
                    <table width="100%" border="1" class="table" cellspacing="2" cellpadding="2">
                        <tr bgcolor="#FFFF33">
                            <td colspan="9"  class="td">&nbsp;<?php echo $label["provincia"] ?>:&nbsp;<?php echo $Provincia[$i]->provincia ?></td>
                        </tr>
                        <tr bgcolor="#FFFF99">
                            <td width="25%" rowspan="2" class="td"><div align="center"><?php echo $label["municipio"] ?></div></td>
                            <td width="15%" rowspan="2" class="td"><div align="center"><?php echo $label["num_asambleas"] ?></div></td>
                            <td width="15%" rowspan="2" class="td"><div align="center"><?php echo $label["electores_registrados"] ?></div></td>
                            <td colspan="2" class="td"><div align="center"><?php echo $label["total_votos_validos"] ?></div></td>
                            <td colspan="2" class="td"><div align="center"><?php echo $label["total_votos_blanco"] ?></div></td>
                            <td colspan="2" class="td"><div align="center"><?php echo $label["total_votos_nulos"] ?></div></td>
                        </tr>
                        <tr bgcolor="#FFFF99">
                            <td width="8%" class="td"><div align="center"><?php echo $label["qte"] ?></div></td>
                            <td width="7%" class="td"><div align="center">%</div></td>
                            <td width="8%" class="td"><div align="center"><?php echo $label["qte"] ?></div></td>
                            <td width="7%" class="td"><div align="center">%</div></td>
                            <td width="8%" class="td"><div align="center"><?php echo $label["qte"] ?></div></td>
                            <td width="7%" class="td"><div align="center">%</div></td>
                        </tr>
                        <?php
                        $id_provincia = $Provincia[$i]->id;
                        $objMunicipio = new Municipios();
                        $objMunicipio->getRecords('id_provincia=' . "'$id_provincia'" . ' AND ' . " municipio <> 'Desconhecido'");
                        $municipio = $objMunicipio->objConexion->crearArregloObjetos();
                        ?>

                        <?php for ($j = 0; $j < count($municipio); $j++): ?>
                            <?php
                            $electores_registrados = 0;
                            $votos_validos = 0;
                            $votos_blancos = 0;
                            $votos_nulos = 0;
                            ?>
                            <tr>
                                <td class="td">&nbsp;<?php echo $municipio[$j]->municipio ?>&nbsp;</td>
                                <?php
                                $id_municipio = $municipio[$j]->id;
                                $objAsamblea = new v_Asamblea_buscar();
                                $objAsamblea->getRecords('id_municipio=' . "'$id_municipio'");
                                $asamblea_result = $objAsamblea->objConexion->crearArregloObjetos();

                                if (is_array($asamblea_result)) {
                                    $num_asamblea_prov = count($asamblea_result);
                                } else {
                                    $num_asamblea_prov = 0;
                                }
                                $asamblea_total += $num_asamblea_prov;

                                foreach ($asamblea_result as $key) {
                                    $electores_registrados += $key->electores_registrados;
                                    $votos_validos += $key->votos_validos;
                                    $votos_blancos += $key->votos_blanco;
                                    $votos_nulos+= $key->votos_nulos;
                                }
                                $electores_registrados_total += $electores_registrados;
                                ?>
                                <td class="td"><div align="center"><?php echo $num_asamblea_prov ?></div></td>
                                <td class="td"><div align="center"><?php echo $electores_registrados; ?></div></td>
                                <td class="td"><div align="center"><?php echo $votos_validos; ?></div></td>
                                <td class="td"><div align="center"><?php echo round(($votos_validos * 100) / $total_validos_x_prov[$id_provincia], 2); ?></div></td>
                                <td class="td"><div align="center"><?php echo $votos_blancos; ?></div></div></td>
                                <td class="td"><div align="center"><?php echo round(($votos_blancos * 100) / $total_blancos_x_prov[$id_provincia], 2); ?></div></td>
                                <td class="td"><div align="center"><?php echo $votos_nulos; ?></div></td>
                                <td class="td"><div align="center"><?php echo round(($votos_nulos * 100) / $total_nulos_x_prov[$id_provincia], 2); ?></div></td>
                            </tr>
                        <?php endfor; ?>
                        <tr bgcolor="#FFFF99">
                            <td class="td"><?php echo $label["total"] ?></td>
                            <td class="td"><div align="center"><?php echo $total_asamblea_x_prov[$id_provincia]; ?></div></td>
                            <td class="td"><div align="center"><?php echo $total_electores_x_prov[$id_provincia]; ?></td>
                            <td class="td"><div align="center"><?php echo $total_validos_x_prov[$id_provincia]; ?></td>
                            <td class="td"><div align="center">100%</div></td>
                            <td class="td"><div align="center"><?php echo $total_blancos_x_prov[$id_provincia]; ?></td>
                            <td class="td"><div align="center">100%</div></td>
                            <td class="td"><div align="center"><?php echo $total_nulos_x_prov[$id_provincia]; ?></td>
                            <td class="td"><div align="center">100%</div></td>
                        </tr>
                    </table>
                    <br>
                <?php endfor; ?>
            </div>
        </div>
        <div id="tabs-4">
            <?php
            require 'Zebra_Form.php';
            $form = new Zebra_Form();
            $id_provincia=0;
            $form->add('label', 'label_id_provincia', 'id_provincia', $label["provincia"]);
            $obj = & $form->add('select', 'id_provincia', $id_provincia, array(
                        'onchange' => 'cargarDatosSelect(\'id_provincia\', \'id_municipio\',\'' . $label["cargando"] . '\', \'Municipios\', \'id_provincia\', \'municipio\', 2);',
                        'style' => 'width:150px'
                    ));
            $objProvincia = new Provincias();
            $Datos = $objProvincia->getRecords();
            $objDatos = $objProvincia->objConexion->crearArregloObjetos();
            $myArray = Utils::getArrayForSelect($objDatos, 'id', 'provincia', $label["seleccione_uno"]);
            $obj->add_options($myArray, true);

            $obj->set_rule(array(
                'required' => array('error', $label["provincia_obligatorio"])
            ));
            $form->add('label', 'label_id_municipio', 'id_municipio', $label["municipio"]);
            $obj = & $form->add('select', 'id_municipio', $id_municipio, array('style' => 'width:150px'));

            $objMunicipio = new Municipios();
            $Datos = $objMunicipio->getRecords('id_provincia=' . $id_provincia);
            $objDatos = $objMunicipio->objConexion->crearArregloObjetos();
            $myArray = Utils::getArrayForSelect($objDatos, 'id', 'municipio', $label["seleccione_uno"]);
            $obj->add_options($myArray, true);
            
            $obj = & $form->add('hidden', 'MM_from', $MM_from);
            $obj = &$form->add('button', 'my_button', 'Buscar', array('onclick' => 'return relatoriomun( document.getElementById(\'zon_mun\') );'));
            $form->render('*horizontal');
            ?>
            <div id="zon_mun"></div>
        </div>
    </div>
</div>
<?php echo Utils::getDivClose(); ?>
