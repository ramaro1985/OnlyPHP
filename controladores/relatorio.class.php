<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class Relatorio extends SQLConection {

    public function __construct() {
        parent::__construct("v_resultados_por_partido");
        $this->fields = array(
            array('private', 'orden'),
            array('public', 'abreviatura'),
            array('public', 'totalxpartido'),
            array('public', 'porciento'),
            array('public', 'total'),
        );
    }

}

?>