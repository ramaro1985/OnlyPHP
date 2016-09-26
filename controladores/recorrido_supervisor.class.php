<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class Recorrido_supervisor extends SQLConection {

    public function __construct() {
        parent::__construct("recorrido_supervisor");
        $this->fields = array(
            array('private', 'id'),
            array('public', 'id_tipo_supervisor'),
            array('public', 'id_usuario'),
            array('public', 'id_recorrido'),
        );
    }

}

?>
