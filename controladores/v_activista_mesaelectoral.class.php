<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class v_Activista_mesaelectoral extends SQLConection {

    public function __construct() {
        parent::__construct("v_activista_mesaelectoral");
        $this->fields = array(
            array('private', 'id'),
            array('public', 'id_activista'),
            array('public', 'id_mesaelectoral'),
            array('public', 'id_funcion_mesa'),
            array('public', 'nombre_apellido')
            
        );
    }

}

?>