<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class V_recorridoparte extends SQLConection {

    public function __construct() {
        parent::__construct("v_recorridoparte");
        $this->fields = array(
            array('public', 'id'),
            array('public', 'fecha_parte'),
            array('public', 'fecha_inicio_trabajo'),
            array('public', 'fecha_fin_trabajo'),
            array('public', 'emitido_por'),
        );
    }

}
?>

