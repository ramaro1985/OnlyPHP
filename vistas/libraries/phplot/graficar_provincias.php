<?php
require_once 'phplot.php';
include_once("utiles/session.class.php");
$cadena = $_GET['cadena'];
$org = split(',', $cadena);


for ($i = 0; $i < count($org); $i++) {
    if ($org[$i] != '') {
        $valor = split('/', $org[$i]);
        $datos = split('-', $valor [1]);
        $data[] = array(utf8_decode($valor[0]), $datos[0],$datos[1]);
    }
}
$shapes = array('Votos validos', 'Votos nulos');

$plot = new PHPlot(800, 400);
$plot->SetImageBorderType('plain');
$plot->SetPlotType('bars');

$plot->SetDataType('text-data');
$plot->SetDataValues($data);

$plot->SetYLabelType('data');
$plot->SetPrecisionY(0);

$plot->SetTitle('Grafica de resultados');
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');
$plot->SetLegend($shapes);
$plot->DrawGraph();
?>