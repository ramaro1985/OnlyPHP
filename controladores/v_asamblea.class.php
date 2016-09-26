<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class v_Asamblea extends SQLConection {

    public function __construct() {
        parent::__construct("v_asamblea");
        $this->fields = array(
            array('private', 'id'),
            array('public', 'provincia'),
            array('public', 'municipio'),
            array('public', 'comuna'),
            array('public', 'cap'),
            array('public', 'localidad'),
            array('public', 'poblado'),
            array('public', 'presidente_asamblea'),
            array('public', 'codigo_asamblea'),
            array('public', 'cabo_electoral'),
            array('public', 'electores_registrados'),
        );
    }

}
?>

