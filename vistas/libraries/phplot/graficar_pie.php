<?php
require_once 'phplot.php';
include_once("utiles/session.class.php");
$cadena = $_GET['cadena'];
$org = split(',', $cadena);


for ($i = 0; $i < count($org); $i++) {
    if ($org[$i] != '') {
        $valor = split('/', $org[$i]);
        if($valor[0]!='')
        $data[] = array($valor[0], $valor [1]);
    }
}

//$data = array(array('Gold', 100), array('Silver',35), array('Copper',12));
$plot = new PHPlot();
$plot->SetPlotType('pie');
$plot->SetDataType('text-data-single');
$plot->SetDataValues($data);
$plot->SetDataColors(array('red', 'pink', 'lavender', 'brown', 'magenta','cyan', 'yellow', 'gray', 'blue'));
foreach ($data as $row) $plot->SetLegend($row[0]); // Copy labels to legend
$plot->SetLegendPixels(5, 5);
$plot->SetLabelScalePosition(0.6);
$plot->DrawGraph();
?>