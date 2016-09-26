<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class Recorrido extends SQLConection {

    public function __construct() {
        parent::__construct("recorrido");
        $this->fields = array(
            array('private', 'id'),
            array('public', 'id_comuna'),
            array('public', 'id_municipio'),
            array('public', 'id_provincia'),
            array('public', 'id_estado'),
            array('public', 'id_proyecto_empresa'),
            array('public', 'fecha_propuesta_inicio'),
            array('public', 'fecha_inicio'),
            array('public', 'fecha_propuesta_fin'),
            array('public', 'fecha_fin'),
            array('public', 'nombre_recorrido'),
            
        );
    }

}

?>
