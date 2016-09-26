<?php
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../'));
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../../'));     
include_once("utiles/lst.class.php");
include_once("idioma/pt.php"); 
?>
<div id="div_error" style="display:none;"><?php echo $label["usuario_pass_incorrecto"] ?></div><br>
<h2><?php echo $label["listado_activo"]; ?></h2>
<?php
$casoUso= "activo";
$template= "lst";
$hrefEdit = '?frm='.$casoUso.'&amp;template='.$template;    
$action= "../negocio/crud_".$casoUso.".php";
$myHtml = new lst($casoUso, 'activo', $label, $_GET, $hrefEdit, "", "", $action);
$myHtml->getLst();
?>