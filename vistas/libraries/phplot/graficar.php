<?php
require_once 'phplot.php';
include_once("utiles/session.class.php");
$cadena = $_GET['cadena'];
$org = split(',', $cadena);


for ($i = 0; $i < count($org); $i++) {
    if ($org[$i] != '') {
        $valor = split('/', $org[$i]);
        $data[] = array($valor[0], $valor [1]);
    }
}

$plot = new PHPlot(600, 400);
$plot->SetImageBorderType('plain');
$plot->SetPlotType('bars');

$plot->SetDataType('text-data');
$plot->SetDataValues($data);
$plot->SetTitle('Grafica de resultados');
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');
$plot->DrawGraph();
?>