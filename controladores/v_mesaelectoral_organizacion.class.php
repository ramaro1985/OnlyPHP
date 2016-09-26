<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class v_Mesaelectoral_organizacion extends SQLConection {

    public function __construct() {
        parent::__construct("v_mesaelectoral_organizacion");
        $this->fields = array(
            array('private', 'id'),
            array('public', 'id_mesa'),
            array('public', 'id_organizacion'),
            array('public', 'voto_efectuado'),
            array('public', 'org_partidista'),
            array('public', 'abreviatura')
        );
    }

}
?>