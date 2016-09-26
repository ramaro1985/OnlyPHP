<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class Ubicacion_evento extends SQLConection {

    public function __construct() {
        parent::__construct("nmubicacion_evento");
        $this->fields = array(
            array('private', 'id'),
            array('public', 'ubicacion_evento'),
            array('public', 'fecha_inicio'),
            array('public', 'fecha_fin'),
        );
    }

}

?>