<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class Mesaelectoral extends SQLConection {

    public function __construct() {
        parent::__construct("nmmesaelectoral");
        $this->fields = array(
            array('private', 'id'),
            array('public', 'desc_mesa'),
            array('public', 'activo'),
            array('public', 'fecha'),
            array('public', 'id_asamblea_resultado'),
            array('public', 'votos_blanco'),
            array('public', 'votos_nulos'),
            array('public', 'votos_reclamados'),
            array('public', 'votos_validos'),
        );
    }

}
?>