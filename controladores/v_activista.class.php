<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class v_Activista extends SQLConection {

    public function __construct() {
        parent::__construct("v_nmactivista");
        $this->fields = array(
            array('public', 'id'),
            array('public', 'municipio'),
            array('public', 'provincia'),
            array('public', 'nombre_apellido'),
            array('public', 'direccion'),
        );
    }

}
?>


