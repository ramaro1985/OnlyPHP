<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class Producto extends SQLConection {

    public function __construct() {
        parent::__construct("nmproducto");
        $this->fields = array(
            array('private', 'id'),
            array('public', 'nombre'),
            array('public', 'cantidad_producto'),
            array('public', 'precio_costo'),
            array('public', 'descripcion')
        );
    }

}

?>