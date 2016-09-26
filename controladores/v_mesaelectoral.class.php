<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class v_Mesaelectoral extends SQLConection {

    public function __construct() {
        parent::__construct("v_mesaelectoral");
        $this->fields = array(
            array('private', 'id'),
            array('public', 'desc_mesa'),
            array('public', 'activo'),
            array('public', 'cerrada'),
        );
    }

}

?>