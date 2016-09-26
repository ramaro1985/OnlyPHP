<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class v_Recorridoevaluacion_buscar extends SQLConection {

    public function __construct() {
        parent::__construct("v_recorridoevaluacion_buscar");
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