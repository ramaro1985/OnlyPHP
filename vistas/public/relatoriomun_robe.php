<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
include_once("configuracion/configuracion.php");
include_once("acceso_datos/" . DRIVER_BD . "_acceso_datos.class.php");
include_once("idioma/pt.php");
include_once("controladores/relatorio.class.php");

$id_provincia = $_GET['id_provincia'];
$id_municipio = $_GET['id_municipio'];
$cant_votos_total = 0;
$relat = new Relatorio();
$sqlDisponibles .= " ( select * from public.sp_resultados_por_partido_de_municipio(".$id_municipio."))";
$relat ->objConexion->realizarConsulta($sqlDisponibles);
$objrelat = $relat->objConexion->crearArregloObjetos();
for ($i = 0; $i < count($objrelat); $i++) {
    $cant_votos_total += $objrelat[$i]->totalxpartido;
    $cadena = $objrelat[$i]->abreviatura . '/' . $objrelat[$i]->porciento . ',' . $cadena . '/';
    $var_datos = '<tr>
                        <td class="td"><label class="label">&nbsp;' . $objrelat[$i]->abreviatura . '</label></td>
                        <td class="td"><div align="center">&nbsp;' . $objrelat[$i]->totalxpartido . '</div></td>
                        <td class="td"><div align="center">&nbsp;' . $objrelat[$i]->porciento . '</div></td>        
                </tr>' . $var_datos;
}
echo '
              <table width="100%" class="table" cellspacing="2" cellpadding="2">
                <tr  bgcolor="#FFFF99" >
                    <td rowspan="2" class="td"><div align="center"><label class="label">' . $label["partido"] . '&nbsp;</label></div></td>
                    <td colspan="2" class="td"><div align="center"><label class="label">Votos</label></div></td>
                </tr>
                <tr  bgcolor="#FFFF99">
                    <td><div align="center" class="td" ><label>&nbsp;' . $label["qte"] . '&nbsp;</label></div></td>
                    <td><div align="center" class="td"><label>&nbsp;%&nbsp;</label></div></td>
                </tr>' . $var_datos . ' 
                <tr  bgcolor="#FFFF99">
                    <td class="td"><div>&nbsp;' . $label["total"] . '</div></td>
                    <td class="td"><div>&nbsp;' . $cant_votos_total . '</div></td>
                    <td class="td"><div>&nbsp;' . $label["100%"] . '</div></td>
                </tr>     
            </table>
            <img src="../vistas/libraries/phplot/graficar.php?cadena=' . $cadena . '">
            <br>
            <img src="../vistas/libraries/phplot/graficar_pie.php?cadena=' . $cadena . '"> 
    '
;
?>