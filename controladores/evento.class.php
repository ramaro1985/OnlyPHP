<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class Evento extends SQLConection {

    public function __construct() {
        parent::__construct("evento");
        $this->fields = array(
            array('private', 'id'),
            array('public', 'id_usuario'),
            array('public', 'id_municipio'),
            array('public', 'id_comuna'),
            array('public', 'id_tipo_evento'),
            array('public', 'fecha'),
            array('public', 'descripcion'),
            array('public', 'nro_participante'),
            array('public', 'quien_dirige'),
            array('public', 'otros_miembros'),
            array('public', 'id_organizacion'),
        );
    }

}
?>