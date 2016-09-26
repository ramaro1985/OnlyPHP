<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class v_Recorrido_producto_buscar extends SQLConection {

    public function __construct() {
        parent::__construct("v_recorrido_producto_buscar");
        $this->fields = array(
            array('private', 'id'),
            array('public', 'nombre'),
            array('public', 'cantidad_producto'),
            array('public', 'id_producto'),
            array('public', 'id_recorrido'),
        );
    }

}

?>
