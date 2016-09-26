<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class Asamblea extends SQLConection {

    public function __construct() {
        parent::__construct("nmasamblea");
        $this->fields = array(
            array('private', 'id'),
            array('public', 'id_cap'),
            array('public', 'id_comuna'),
            array('public', 'id_municipio'),
            array('public', 'localidad'),
            array('public', 'poblado'),
            array('public', 'presidente_asamblea'),
            array('public', 'codigo_asamblea'),
        );
    }

}

?>