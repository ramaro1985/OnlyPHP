<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
include_once("utiles/session.class.php");
include_once("idioma/pt.php");
include_once("utiles/utils.class.php");

$mySession = new Session();
$template = isset($_GET['template']) ? strtolower($_GET['template']) : '';

if (isset($_GET['frm']) && is_file('templates/' . $_GET['frm'] . '-' . $template . '.php')) {
    $frm = strtolower($_GET['frm']);
} else {
    $template = 'horizontal';
    $frm = 'login';
    $mySession->cerrar();
}

if (!$mySession->logeado && $frm != 'login') { header("Location: ../vistas/index.php?frm=login&template=horizontal&error=2"); }
if ((@$_GET['error'] == '3') || (@$_GET['error'] == '4')) { $mySession->reiniciar(); }

if ($mySession->logeado) {
    $menutop = ' <div id="bienvenida">
                    <span>&nbsp;&nbsp;'. $label["bienvenido"] .'&nbsp;</span>
                    <span>'. $mySession->nombreCompletoUsuario .'&nbsp;&nbsp;</span>                    
                </div>
                <div id="reloj">
                    <span id="separador" style="text-align: right;">&nbsp;&nbsp;</span>
                    <span id="digiclock" style="text-align: right;"></span>
                    <span id="separador" style="text-align: right;">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
                    <span id="index" style="text-align: right;"><a href="?frm=principal&template=resumen" target="_top" title="'. $label["index"] .'">'. $label["index"] .'</a></span>
                    <span id="separador" style="text-align: right;">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
                    <span id="ayuda" style="text-align: right;"><a href= "#">'. $label["ayuda"] .'</a></span>                    
                    <span id="separador" style="text-align: right;">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
                    <span id="perfil" style="text-align: right;"><a href="?frm=modificarperfil&template=horizontal" target="_top">'. $label["perfil"] .'</a></span>
                    <span id="separador" style="text-align: right;">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
                    <span id="salir" style="text-align: right;"><a href="../negocio/crud_cerrarsession.php" target="_top" title="'. $label["cerrar_session"] .'">'. $label["salir"] .'</a></span>
                    <span id="separador" style="text-align: right;">&nbsp;&nbsp;</span>
                </div>'; 
} else { $iconos = "";}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title><?php echo $label["nombre_pagina"]?></title>

        <meta http-equiv="content-type" content="text/html;charset=UTF-8">
        <meta http-equiv="Content-Script-Type" content="text/javascript">
        <meta http-equiv="Content-Style-Type" content="text/css">
        <!--css de la aplicaion -->
        <link rel="stylesheet" href="public/css/reset.css" type="text/css">
        <link rel="stylesheet" href="libraries/highlight/public/css/ir_black.css" type="text/css">
        <link rel="stylesheet" href="public/css/style.css" type="text/css">
        <link rel="stylesheet" href="public/css/zebra_form.css" type="text/css">
        <link rel="stylesheet" href="public/css/plantilla.css" type="text/css">
        <link rel="stylesheet" href="public/css/redandblack.css" type="text/css">
        <link rel="stylesheet" href="public/css/errores.css" type="text/css"> 
        <!--css de la aplicaion de JQuery-->
        <link rel="stylesheet" href="public/css/jquery.ui.all.css" type="text/css ">
        <link rel="stylesheet" href="public/css/jquery.ui.tabs.css" type="text/css ">
        <link rel="stylesheet" href="public/css/jquery.ui.theme.css" type="text/css ">	
        <link rel="stylesheet" href="public/css/jquery.ui.dialog.css" type="text/css ">
        
        <!-- JS de JQuery-->
        <script type="text/javascript" src="public/javascript/jquery-1.7.js"></script>
        <script type="text/javascript" src="public/javascript/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="public/javascript/jquery-ui-1.8.21.custom.js"></script>
        <script type="text/javascript" src="libraries/highlight/public/javascript/highlight.js"></script>
        <script type="text/javascript" src="public/javascript/jquery.bgiframe-2.1.2.js"></script>
        <script type="text/javascript" src="public/javascript/jquery.ui.core.js"></script>
        <script type="text/javascript" src="public/javascript/jquery.ui.widget.js"></script>
        <script type="text/javascript" src="public/javascript/jquery.ui.tabs.js"></script>
            <!--Efectos de JQuery------------>
        <script type="text/javascript" src="public/javascript/jquery.ui.mouse.js"></script>
        <script type="text/javascript" src="public/javascript/jquery.ui.draggable.js"></script>
        <script type="text/javascript" src="public/javascript/jquery.ui.position.js"></script>
        <script type="text/javascript" src="public/javascript/jquery.ui.resizable.js"></script>
        <script type="text/javascript" src="public/javascript/jquery.effects.explode.js"></script>
        
        <!-- JS de la aplicacion-->
        <script type="text/javascript" src="public/javascript/zebra_form.js"></script>
        <script type="text/javascript" src="public/javascript/functions.js"></script>
        <script type="text/javascript" src="public/javascript/funciones.jc.js"></script>   
        <script type="text/javascript" src="public/javascript/duallist.jc.js"></script>
        <script type="text/javascript" src="public/javascript/md5.jc.js"></script>        
        <script type="text/javascript" src="public/javascript/validar.jc.js"></script>
	
        <link rel="stylesheet" href="public/css/jquery.lightbox-0.5.css" type="text/css ">        
        <script src="public/javascript/jquery.lightbox-0.5.js" type="text/javascript"></script> 
        <?php if ($mySession->logeado) { ?>
        <script language="JavaScript" type="text/javascript">
            function doTheClock(idioma, idcontrol) {
                //alert(idcontrol.innerHTML);
               //window.setTimeout( "doTheClock('"+idioma+"','"+idcontrol+"')", 1000 );
               //var meses = new Array();
               //var diasSemana = new Array();
               //var del = new Array();
              /* meses["pt"] = new Array ("Janeiro","Fevereiro","Marzo","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
               meses["es"] = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
               diasSemana["es"] = new Array("Domingo","Lunes","Martes","Mi&eacute;rcoles","Jueves","Viernes","S&aacute;bado");
               diasSemana["pt"] = new Array("Domingo","Segunda-feira","Terça-feira","Quarta-feira","Quinta-feira","Sexta-feira","S&aacute;bado");               
               del["es"] = " del ";
               del["pt"] = " de ";
               document.write(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
               t = new Date();
               
               if(document.all || document.getElementById){
                 // document.getElementById(idcontrol).innerHTML = diasSemana[idioma][t.getDay()] + ", " + t.getDate() + " " + meses[idioma][t.getMonth()] + del[idioma] + t.getFullYear() + ' ' + t.getHours()+':'+t.getMinutes()+':'+t.getSeconds();
               }else{   
                  self.status = diasSemana[idioma][t.getDay()] + ", " + t.getDate() + " " + meses[idioma][t.getMonth()] + del[idioma] + t.getFullYear() + ' ' + t.getHours()+':'+t.getMinutes()+':'+t.getSeconds();
               }*/
            }
            doTheClock('<?php echo LENGUAJE; ?>', 'digiclock');
        </script>
        <?php } ?>
    </head>
    <body> 
        <div id="container"> 
            <div id="header"> 
                <div style = "float: left; z-index: 6;"><img src="public/imagenes/logo.png" height="120" width="120"></div>
                <div style = "float: left; margin-left: 30px; margin-top: 20px;">
                   <img src="public/imagenes/bandera.png" height="50" width="100"> 
                </div>
                <div style = "float: right; width: 219;"><img src="public/imagenes/barner_top_derecha-n.png" height="100"></div>
            </div>
	    <div id="barramenutop">
		<?php if ($mySession->logeado) { echo $menutop; }?>
	    </div>
            <?php if ($frm != 'login') { ?>
                <div id="menuleft">
                    <br>
                    <ul class="navigation default">
                        <?php
                        $arrAdminUsuario = Utils::getArrMenu($label, $mySession->arrAcceso, 'adminusuario', $mySession->idusuario);
                        $arrActivista = Utils::getArrMenu($label, $mySession->arrAcceso, 'menuactivista', $mySession->idusuario);                        
                        $arrAdminNomenclador = Utils::getArrMenu($label, $mySession->arrAcceso, 'adminnomenclador', $mySession->idusuario);
                        $arrAsamblea = Utils::getArrMenu($label, $mySession->arrAcceso, 'menuasamblea', $mySession->idusuario);
                        $arrMenuProyectos = Utils::getArrMenu($label, $mySession->arrAcceso, 'menuproyecto', $mySession->idusuario);                                                
                        $arrActividades = Utils::getArrMenu($label, $mySession->arrAcceso, 'menuactividades', $mySession->idusuario);                        

                        if ($arrAdminUsuario != NULL) {
                            echo Utils::getMenu($arrAdminUsuario, $template, $frm);
                        }
                        if ($arrAdminNomenclador != NULL) {
                            echo Utils::getMenu($arrAdminNomenclador, $template, $frm);
                        }
                        if ($arrActivista != NULL) {
                            echo Utils::getMenu($arrActivista, $template, $frm);
                        }                        
                        if ($arrMenuProyectos != NULL) {
                            echo Utils::getMenu($arrMenuProyectos, $template, $frm);
                        }                                                
                        if ($arrActividades != NULL) {
                            echo Utils::getMenu($arrActividades, $template, $frm);
                        }                        
                        if ($arrAsamblea != NULL) {
                            echo Utils::getMenu($arrAsamblea, $template, $frm);
                        }
                        ?>
                    </ul>
                </div>
                <div id="view">
                    <?php require 'templates/' . $frm . '-' . $template . '.php'; ?>
                </div>		
            <?php } else { ?>
                <div id="wrapper">
                    <div id="div_title" style="margin:0px auto; text-align:center; margin-top:50px;">
                        <h2><span><?php echo $label["descripcion_sistema"]; ?></span></h2>
                    </div>
                    <div id="div_login">
                        <?php require 'templates/' . $frm . '-' . $template . '.php'; ?>
                    </div>
                </div>
            <?php } ?>
        </div> 
    </body>
</html>