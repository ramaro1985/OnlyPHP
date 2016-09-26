<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class v_Evento_Buscar extends SQLConection {

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
            array('public', 'id_provincia'),
            array('public', 'id_municipio'),
            array('public', 'id_comuna'),
            array('public', 'id_usuario'),            
            array('public', 'nombre_apellido'),
            array('public', 'id_tipo_evento'),             
            array('public', 'descripcion'),                         
            array('public', 'otros_miembros'),
            array('public', 'id_organizacion'),
            array('public', 'org_partidista'),
        );
    }

}
?>