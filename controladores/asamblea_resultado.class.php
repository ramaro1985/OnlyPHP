<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class Asamblea_resultado extends SQLConection {

    public function __construct() {
        parent::__construct("asamblea_resultado");
        $this->fields = array(
            array('private', 'id'),
            array('public', 'id_asamblea'),
            array('public', 'id_usuario'),
            array('public', 'fecha_cierre'),
            array('public', 'votos_blanco'),
            array('public', 'votos_nulos'),
            array('public', 'votos_reclamados'),
            array('public', 'votos_validos'),
            array('public', 'cerrada'),
            array('public', 'confirmada'),
            array('public', 'electores_registrados'),
            
        );
    }

}

?>