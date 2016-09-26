<?php
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../'));
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../../'));     
include_once("utiles/lst.class.php");
include_once("idioma/pt.php"); 
?>
<h2><?php echo $label["resumen_electoral"]; ?></h2>
<?php
$hrefEdit = '?frm='.$_GET["frm"].'&amp;template='.$_GET["template"];    
$myHtml = new lst('Grupos', $label, $_GET, $hrefEdit, "", "");
$myHtml->getLst();
?>