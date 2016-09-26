<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class v_Evento_opsc_buscar extends SQLConection {

    public function __construct() {
        parent::__construct("v_evento_opsc_buscar");
        $this->fields = array(
            array('private', 'id'),
            array('public', 'id_usuario'),
            array('public', 'id_provincia'),
            array('public', 'id_municipio'),
            array('public', 'id_comuna'),
            array('public', 'id_tipo_organizacion_enevento'),
            array('public', 'id_ubicacion_evento'),
            array('public', 'presidente_acto'),
            array('public', 'cantidad_participantes'),
            array('public', 'principales_ocurrencias'),
            array('public', 'fecha_planificada'),
            array('public', 'hora_planificada'),
            array('public', 'fecha_realizada'),
            array('public', 'hora_realizada'),
            array('public', 'prelectores'),
            array('public', 'id_dirigente'),
            array('public', 'local'),
            array('public', 'cordinador'),
            array('public', 'enfoque'),
            array('public', 'medidas_organizativas'),
            array('public', 'impacto'),
            array('public', 'dificultades'),
            array('public', 'medidas_seguridad'),
            array('public', 'id_organizacion'),
        );
    }

}
?>













