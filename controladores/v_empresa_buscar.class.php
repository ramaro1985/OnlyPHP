<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class v_Empresa_buscar extends SQLConection {

    public function __construct() {
        parent::__construct("v_empresa");
        $this->fields = array(
            array('public', 'id'),
            array('public', 'nombre_empresa'),
            array('public', 'direccion'),
            array('public', 'tipo_servicio'),
            array('public', 'id_tipo_servicio')
            
        );
    }

}

?>