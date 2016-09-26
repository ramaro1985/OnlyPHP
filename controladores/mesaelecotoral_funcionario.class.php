<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class Mesaelecotoral_funcionario extends SQLConection {

    public function __construct() {
        parent::__construct("mesaelecotoral_funcionario");
        $this->fields = array(
            array('private', 'id'),
            array('public', 'id_mesa'),
            array('public', 'id_funcion_mesa'),
            array('public', 'nombre_apellido'),
            array('public', 'nro_carton_electoral'),
            array('public', 'fecha'),
        );
    }

}

?>