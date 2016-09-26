<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
include_once("configuracion/configuracion.php");
include_once("idioma/pt.php");
include_once("acceso_datos/" . DRIVER_BD . "_acceso_datos.class.php");
include_once("controladores/v_activista.class.php");
include_once("controladores/v_activista_buscar.class.php");
include_once("controladores/v_recorrido_buscar.class.php");
include_once("controladores/v_recorrido_resumen.class.php");
include_once("controladores/empresa.class.php");
include_once("controladores/v_mesaelectoral_organizacion.class.php");
include_once("controladores/mesaelectoral.class.php");
include_once("controladores/asamblea.class.php");
include_once("controladores/v_asamblea_buscar.class.php");
include_once("controladores/asamblea_resultado.class.php");
include_once("controladores/provincia.class.php");
include_once("controladores/municipio.class.php");
include_once("idioma/pt.php");

$id_provincia = $_GET['id'];
$empresas_provincia = array();
//Para ver los acvistas de la provincia//
$ObjActivista = new v_Actvista_buscar();
$ObjActivista->getRecords('id_provincia =' . "'$id_provincia'" . ' AND id_organizacion = 1');
$Activista = $ObjActivista->objConexion->crearArregloObjetos();

$nombre_provincia = $label["provincia"] . ':' . $Activista[0]->provincia;
for ($i = 1; $i < count($Activista); $i++) {

    $datos_actvista = '
            <tr>
               <td class="td">&nbsp;' . $Activista[$i]->nombre_apellido . '</td>
               <td class="td">&nbsp;' . $Activista[$i]->telefono . '</td>
            </tr>' . $datos_actvista;
}

//Para ver las asambleas de la provincia//
$objMunicipio = new Municipios();
$objMunicipio->getRecords('id_provincia=' . "'$id_provincia'" . ' AND ' . " municipio <> 'Desconocido'");
$municipio = $objMunicipio->objConexion->crearArregloObjetos();

$objAsamblea = new v_Asamblea_buscar();
$objAsamblea->getRecords('id_provincia = ' . "'$id_provincia'");
$asamblea_result_1 = $objAsamblea->objConexion->crearArregloObjetos();

$votos_validos_x_prov = 0;
$votos_blancos_x_prov = 0;
$votos_nulos_x_prov = 0;

foreach ($asamblea_result_1 as $key) {
    $votos_validos_x_prov += $key->votos_validos;
    $votos_blancos_x_prov += $key->votos_blanco;
    $votos_nulos_x_prov += $key->votos_nulos;
}

for ($j = 0; $j < count($municipio); $j++) {

    $electores_registrados = 0;
    $votos_validos = 0;
    $votos_blancos = 0;
    $votos_nulos = 0;

    $id_municipio = $municipio[$j]->id;
    $objAsamblea = new v_Asamblea_buscar();
    $objAsamblea->getRecords('id_municipio=' . "'$id_municipio'");
    $asamblea_result = $objAsamblea->objConexion->crearArregloObjetos();
    if (is_array($asamblea_result)) {
        $num_asamblea_prov = count($asamblea_result);
    } else {
        $num_asamblea_prov = 0;
    }

    foreach ($asamblea_result as $key) {
        $electores_registrados += $key->electores_registrados;
        $votos_validos += $key->votos_validos;
        $votos_blancos += $key->votos_blanco;
        $votos_nulos+= $key->votos_nulos;
    }
    $electores_registrados_total += $electores_registrados;
    //$votos_validos_total += $votos_validos;
    //$votos_blancos_total += $votos_blancos;
    //$votos_nulos_total += $votos_nulos;
    $datos_asamblea = '
        <tr>
            <td class="td">&nbsp;' . $municipio[$j]->municipio . '</td>
            <td class="td"><div align="center">' . $num_asamblea_prov . '</div></td>
            <td class="td"><div align="center">' . $electores_registrados . '</div></td>
            <td class="td"><div align="center">' . $votos_validos . '</div></td>
            <td class="td"><div align="center">' . round(($votos_validos * 100) / $votos_validos_x_prov, 2) . '</div></td>
            <td class="td"><div align="center">' . $votos_blancos . '</div></td>
            <td class="td"><div align="center">' . round(($votos_blancos * 100) / $votos_blancos_x_prov, 2) . '</div></td>
            <td class="td"><div align="center">' . $votos_nulos . '</div></td>
            <td class="td"><div align="center">' . round(($votos_nulos * 100) / $votos_nulos_x_prov, 2) . '</div></td>
          </tr>' . $datos_asamblea;

    //Con este Objeto recojo las empresas de la provincia
    $municipio_nombre = $municipio[$j]->municipio;
    $ObjRecorrido = new v_Recorrido_resumen();
    $ObjRecorrido->getRecords('municipio = ' . "'$municipio_nombre'");
    $Recorridos = $ObjRecorrido->objConexion->crearArregloObjetos();

    foreach ($Recorridos as $key) {

        if (!in_array($key->nombre_empresa, $empresas_provincia)) {
            $empresas_provincia [] = $key->nombre_empresa;
        }
    }
}

//Para todos los proyectos que inciden en la provincia//
for ($h = 0; $h < count($empresas_provincia); $h++) {
    $var_prov = $Activista[0]->provincia;
    $var_datos = null;
    $nombre_empresa = $empresas_provincia[$h];
    $ObjRecorrido = new v_Recorrido_resumen();
    $ObjRecorrido->getRecords('nombre_empresa = ' . "'$nombre_empresa'" . 'AND provincia = ' . "'$var_prov'");
    $Recorridos = $ObjRecorrido->objConexion->crearArregloObjetos();
    for ($c = 0; $c < count($Recorridos); $c++) {
        $var_datos =
                '<tr bgcolor="#FFFF99">
                <td width="25%" class="td">&nbsp;' . $Recorridos[$c]->nombre_proyecto . '</td>
                <td width="25%" class="td">&nbsp;' . $Recorridos[$c]->nombre_recorrido . '</td>
                <td width="25%" class="td">&nbsp;' . $Recorridos[$c]->estado . '</td>
                <td width="25%" class="td">&nbsp;' . $Recorridos[$c]->municipio . '</td>
        </tr>' . $var_datos;
    }


    $datos_empresas = '
        <table width="100%" border="1">
            <tr bgcolor="#FFFF33">
                <td colspan="5" class="td" align="center">' . $nombre_empresa . '</td>
            </tr>
            <tr bgcolor="#FFFF99">
                <td width="25%" class="td">&nbsp;' . $label["listado_proyecto"] . '</td>
                <td width="25%" class="td">&nbsp;' . $label['nombre_recorrido'] . '</td>
                <td width="25%" class="td">&nbsp;' . $label['estado'] . '</td>
                <td width="25%" class="td">&nbsp;' . $label["municipios"] . '</td>    
           </tr>
           ' . $var_datos . '
         </table>
      <br>' . $datos_empresas;
}
if ($id_provincia == 4 || $id_provincia == 16) {
    $w = '50%';
    $h = '50%';
} else {
    $w = '100%';
    $h = '100%';
}
echo'
<script>
    $(document).ready(function(){
        $( "#tabs" ).tabs();
    });
</script>
<table width="100%" border="1" class="table" cellspacing="2" cellpadding="2">
    <tr bgcolor="#FFFF33">
        <td colspan="2" class="td">&nbsp;' . $nombre_provincia . '</td>
    </tr>
    <tr>
        <td width="50%" valign="top"><div align="center"><img src="public/imagenes/provincias/' . $id_provincia . '.jpg" width="' . $w . '" height="' . $h . '"></div></td>
        <td width="50%" class="td" valign="top">
            <div class="demo">
                <div id="tabs">
                    <ul>
                        <li><a href="#tabs-1">Actvistas</a></li>
                        <li><a href="#tabs-2">' . $label["listado_empresa"] . '-' . $label["listado_proyecto"] . '</a></li>
                        <li><a href="#tabs-3">' . $label["listado_asamblea"] . '</a></li>    
                    </ul>
                    <div id="tabs-1">
                        <!--Tabla de Activistas-->
                        <table width="100%" border="1">
                            <tr bgcolor="#FFFF33">
                                <td colspan="2" class="td" align="center">Activistas</td>
                            </tr>
                            <tr bgcolor="#FFFF99">
                                <td width="25%" class="td">&nbsp;' . $label["nombre_completo"] . '</td>
                                <td width="25%" class="td">&nbsp;' . $label["telefono"] . '</td>
                            </tr>' . $datos_actvista . '
                        </table>
                    </div>
                    <div id="tabs-2">
                    ' . $datos_empresas . '
                    </div>
                    <div id="tabs-3">
                    <table width="100%" border="1" class="table" cellspacing="2" cellpadding="2">
                            <tr bgcolor="#FFFF33">
                                <td colspan="9"  class="td" align="center">' . $label["listado_asamblea"] . '</td>
                            </tr>
                            <tr bgcolor="#FFFF99">
                                <td width="25%" rowspan="2" class="td"><div align="center">' . $label["municipio"] . '</div></td>
                                <td width="15%" rowspan="2" class="td"><div align="center">' . $label["num_asambleas"] . '</div></td>
                                <td width="15%" rowspan="2" class="td"><div align="center">' . $label["electores_registrados"] . '</div></td>
                                <td colspan="2" class="td"><div align="center">' . $label["total_votos_validos"] . '</div></td>
                                <td colspan="2" class="td"><div align="center">' . $label["total_votos_blanco"] . '</div></td>
                                <td colspan="2" class="td"><div align="center">' . $label["total_votos_nulos"] . '</div></td>
                            </tr>
                            <tr bgcolor="#FFFF99">
                                <td width="8%" class="td"><div align="center">' . $label["qte"] . '</div></td>
                                <td width="7%" class="td"><div align="center">%</div></td>
                                <td width="8%" class="td"><div align="center">' . $label["qte"] . '</div></td>
                                <td width="7%" class="td"><div align="center">%</div></td>
                                <td width="8%" class="td"><div align="center">' . $label["qte"] . '</div></td>
                                <td width="7%" class="td"><div align="center">%</div></td>
                            </tr>
                            ' . $datos_asamblea . '
                            <tr bgcolor="#FFFF99">
                            <td class="td">' . $label["total"] . '</td>
                            <td class="td"><div align="center">' . count($asamblea_result_1) . '</div></td>
                            <td class="td"><div align="center">' . $electores_registrados_total . '</div></td>
                            <td class="td"><div align="center">' . $votos_validos_x_prov . '</div></td>
                            <td class="td"><div align="center">100%</div></td>
                            <td class="td"><div align="center">' . $votos_blancos_x_prov . '</div></td>
                            <td class="td"><div align="center">100%</div></td>
                            <td class="td"><div align="center">' . $votos_nulos_x_prov . '</div></td>
                            <td class="td"><div align="center">100%</div></td>
                        </tr>    
                        </table>
                    </div>
                </div>
            </div>   
        </td>
    </tr>
</table>
';
?>

