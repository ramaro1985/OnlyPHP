<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class Recorridoparte extends SQLConection {

    public function __construct() {
        parent::__construct("recorrido_parte");
        $this->fields = array(
            array('private', 'id'),
            array('public', 'id_recorrido'),
            array('public', 'id_usuario'), 
            array('public', 'fecha_parte'),
            array('public', 'descripcion'),
            array('public', 'fecha_inicio_trabajo'),
            array('public', 'fecha_fin_trabajo')
        );
    }

}
?>