<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class Recorrido_producto extends SQLConection {

    public function __construct() {
        parent::__construct("recorrido_producto");
        $this->fields = array(
            array('private', 'id'),
            array('public', 'id_recorrido'),
            array('public', 'id_producto'),
            array('public', 'cantidad_producto'),
        );
    }

}

?>
