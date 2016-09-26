<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class v_Recorrido_buscar extends SQLConection {

    public function __construct() {
        parent::__construct("v_recorrido_buscar");
        $this->fields = array(
            array('public', 'id'),
            array('public', 'id_comuna'),
            array('public', 'id_municipio'),
            array('public', 'id_provincia'),
            array('public', 'id_estado'),
            array('public', 'id_proyecto_empresa'),
            array('public', 'nombre_recorrido'),
            array('public', 'provincia'),
            array('public', 'municipio'),
            array('public', 'provincia'),
            array('public', 'comuna'),
            array('public', 'estado'),
            array('public', 'id_proyecto'),
            array('public', 'id_empresa'),
            array('public', 'fecha_propuesta_inicio'),
            array('public', 'fecha_inicio'),
            array('public', 'fecha_propuesta_fin'),
            array('public', 'fecha_fin'),
            array('public', 'id_tipo_supervisor'),
            array('public', 'id_usuario'),
            array('public', 'tipo_supervisor'),
            array('public', 'nombre_apellido'),
            array('public', 'habilitado'),
            array('public', 'id_recorrido_supervisor'),
        );
    }

}
?>


