<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class v_Asamblea_buscar extends SQLConection {

    public function __construct() {
        parent::__construct("v_asamblea_buscar");
        $this->fields = array(
            array('private', 'id'),
            array('public', 'id_cap'),
            array('public', 'id_comuna'),
            array('public', 'id_municipio'),
            array('public', 'id_provincia'),
            array('public', 'localidad'),
            array('public', 'poblado'),
            array('public', 'presidente_asamblea'),
            array('public', 'codigo_asamblea'),
            array('public', 'id_usuario'),
            array('public', 'fecha_cierre'),
            array('public', 'votos_blanco'),
            array('public', 'votos_reclamados'),
            array('public', 'votos_nulos'),
            array('public', 'votos_validos'),
            array('public', 'id_asamblea_resultado'),
            array('public', 'cerrada'),
            array('public', 'confirmada'),
            array('public', 'electores_registrados'),
        );
    }

}
?>
    