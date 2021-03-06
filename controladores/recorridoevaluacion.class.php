<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class Recorridoevaluacion extends SQLConection {

    public function __construct() {
        parent::__construct("recorridoevaluacion");
        $this->fields = array(
            array('private', 'id'),
            array('public', 'id_recorrido'),
            array('public', 'id_tipo_evaluacion'), 
            array('public', 'descripcion'),
            array('public', 'fecha_evaluacion')
        );
    }

}
?>