<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class v_Recorrido_resumen extends SQLConection {

    public function __construct() {
        parent::__construct("v_recorrido");
        $this->fields = array(
            array('public', 'id'),
            array('public', 'nombre_recorrido'),
            array('public', 'municipio'),
            array('public', 'nombre_empresa'),
            array('public', 'nombre_proyecto'),
            array('public', 'estado'),
            array('public', 'fecha_inicio'),
            array('public', 'fecha_fin'),
        );
    }
}
?>

