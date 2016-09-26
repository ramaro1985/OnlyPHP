<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class Trabajador extends SQLConection {

    public function __construct() {
        parent::__construct("nmtrabajador");
        $this->fields = array(
            array('private', 'id'),
            array('public', 'id_cargo'),
            array('public', 'id_empresa'),
            array('public', 'nombre_apellido'),
            array('public', 'nro_identidad'),
            array('public', 'correo'),
            array('public', 'telefono'),
            array('public', 'sexo'),
        );
    }

}
?>