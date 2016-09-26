<?php

class gallery {

    var $files = array();
    var $path;

    function loadFolder($path) {

        $this->path = $path;
        if (!file_exists($path)) {
            mkdir($path);
        }

        //---Guardar en un arreglo todos los archivos en el directorio	
        $folder = opendir($this->path);

        while ($fil = readdir($folder)) {

            //---Si no es un directorio
            if (!is_dir($fil)) {

                $arr = explode('.', $fil);

                if (count($arr) > 1) {

                    //---Ir guardando los nombres en un arreglo
                    $this->files[] = $fil;
                }
            }
        }

        //---Cerrar el directorio
        closedir($folder);

        //---Ordenar alfabeticamente el arreglo
        sort($this->files);
    }

    function show($area = 500, $width = 100, $space = 10) {

        //---Crear la galería con los nombres de todos los archivos
        $total = count($this->files);
        $cont = 0;

        $style = '<style type="text/css" media="screen">#divfoto {';
        //$style.= ' width:' . $width . 'px; float:left; padding-right:' . $space . 'px; padding-bottom:' . $space . 'px;';                
        $style.= ' width:' . $width . 'px; float:left;';
        $style.= ' padding: 10px 10px 10px 10px;';
        $style.= ' -webkit-border-radius: 5px;';
        $style.= ' -moz-border-radius: 5px;';
        $style.= ' border-radius: 5px;';
        $style.= ' -webkit-box-shadow: 2px 2px 6px rgba(0,0,0,0.6);';
        $style.= ' -moz-box-shadow: 2px 2px 6px rgba(0,0,0,0.6);';
        $style.= ' box-shadow: 2px 2px 6px rgba(0,0,0,0.6);';
        $style.= ' border: 5px solid #FFFFFF; } </style>';        
        //echo $style;
        echo '<div name="xx" style="width:' . $area . 'px">';

        //---Situar los thumbnails
        for ($i = 0; $i < $total; $i++) {

           echo '<div id="divfoto"><a href="' . $this->path . '/' . $this->files[$i] . '" rel="lightbox"><img src="show_thumb.php?src=' . $this->path . '/' . $this->files[$i] . '&width=' . $width . '" width="' . $width . '" height="' . $width . '" border="0"></img></a></div>';
        }
        echo '</div>';
        echo '<div style="clear: both;">&nbsp;</div>';
    }

}
?>