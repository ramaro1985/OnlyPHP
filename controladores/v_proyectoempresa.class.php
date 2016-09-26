<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class V_proyectoempresa extends SQLConection {

    public function __construct() {
        parent::__construct("v_proyecto_empresa");
        $this->fields = array(
            array('public', 'id'),
            array('public', 'id_empresa'),
            array('public', 'id_proyecto'),
            array('public', 'nombre_empresa'),
            array('public', 'nombre_proyecto'),
        );
    }

}

?>
