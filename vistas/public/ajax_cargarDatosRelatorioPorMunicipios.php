<?php

//$_GET['id']  id del municipio para filtrar
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
include_once("configuracion/configuracion.php");
include_once("acceso_datos/" . DRIVER_BD . "_acceso_datos.class.php");
include_once("idioma/pt.php");

?>
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
                $relat = new Postgres_Acceso_Datos();
                $relat->abrirConexion();
                $query = 'select * from public.sp_resultados_por_partido_de_municipio('. $_GET['id'].')';
                $relat->realizarConsulta($query);
                $objrelat = $relat->crearArregloObjetos();
                $cant_votos_total = 0;
                
                for ($i = 0; $i < count($objrelat); $i++): ?>
                    <tr>
                        <?php  
                            $cadena = $objrelat[$i]->abreviatura . '/' .$objrelat[$i]->porciento . ',' . $cadena . '/'; 
                            //$cant_votos_total = $cant_votos_total + $objrelat[$i]->total;
                        ?>
                        <td class="td" nowrap style="width: 100px" ><label class="label">&nbsp;<?php echo $objrelat[$i]->abreviatura ?>&nbsp;</label></td>
                        <td class="td"><div align="center">&nbsp;<?php echo $objrelat[$i]->totalxpartido ?>&nbsp;</div></td>
                        <td class="td"><div align="center">&nbsp;<?php echo $objrelat[$i]->porciento ?>&nbsp;</div></td>
                    </tr>
                <?php endfor; ?> 
                <tr  bgcolor="#FFFF99">
                    <td class="td"><div>&nbsp;<?php echo $label["total"] ?>&nbsp;</div></td>
                    <td class="td"><div>&nbsp;<?php echo $objrelat[$i-1]->total ?>&nbsp;</div></td>
                    <td class="td"><div>&nbsp;<?php echo $label["100%"] ?>&nbsp;</div></td>
                </tr>     
                <tr>
                    <td colspan="3"><div align="center">&nbsp;</div></td>
                </tr>
            </table>
            <br>
            <img src="../vistas/libraries/phplot/graficar.php?cadena=<?php echo $cadena ?>">
            <br>
            <img src="../vistas/libraries/phplot/graficar_pie.php?cadena=<?php echo $cadena ?>"> 