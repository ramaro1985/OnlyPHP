<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class v_Activista_asamblea extends SQLConection {

    public function __construct() {
        parent::__construct("v_activista_asamblea");
        $this->fields = array(
            array('private', 'id'),
            array('public', 'id_asamblea'),
            array('public', 'nombre_apellido'),
            array('public', 'id_asamblea_resultado'),
        );
    }

}
?>