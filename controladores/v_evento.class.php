<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class v_Evento extends SQLConection {

    public function __construct() {
        parent::__construct("v_evento");
        $this->fields = array(
            array('private', 'id'),
            array('public', 'fecha'),
            array('public', 'provincia'),
            array('public', 'municipio'),
            array('public', 'comuna'),
            array('public', 'tipo_evento'),
            array('public', 'nro_participante'),
            array('public', 'quien_dirige'),
        );
    }

}
?>