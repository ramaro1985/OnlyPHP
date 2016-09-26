<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class Trabajador_proyecto extends SQLConection {

    public function __construct() {
        parent::__construct("trabajador_proyecto");
        $this->fields = array(
            array('private', 'id'),
            array('public', 'id_proyecto'),
            array('public', 'id_trabajador')
        );
    }

}

?>