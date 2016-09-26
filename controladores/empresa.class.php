<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class Empresa extends SQLConection {

    public function __construct() {
        parent::__construct("nmempresa");
        $this->fields = array(
            array('private', 'id'),
            array('public', 'id_tipo_servicio'),
            array('public', 'nombre_empresa'),
            array('public', 'direccion')
        );
    }

}

?>