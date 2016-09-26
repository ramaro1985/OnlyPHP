<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class Proyecto extends SQLConection {

    public function __construct() {
        parent::__construct("nmproyecto");
        $this->fields = array(
            array('private', 'id'),
            array('public', 'nombre_proyecto'),
            array('public', 'lider'),
            array('public', 'descripcion'),
            array('public', 'id_estado')
        );
    }

}

?>