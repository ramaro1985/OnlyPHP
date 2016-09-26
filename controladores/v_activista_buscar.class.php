<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class v_Actvista_buscar extends SQLConection {

    public function __construct() {
        parent::__construct("v_nmactivista_buscar");
        $this->fields = array(
            array('public', 'id'),
            array('public', 'id_estado_civil'),
            array('public', 'id_organizacion'),
            array('public', 'id_profesion'),
            array('public', 'id_funcion_trabajo'),
            array('public', 'id_nivel_escolar'),
            array('public', 'id_cap'),
            array('public', 'id_comuna'),
            array('public', 'id_municipio'),
            array('public', 'id_provincia'),
            array('public', 'nro_carton_militante'),
            array('public', 'nro_identidad'),
            array('public', 'nro_carton_electoral'),
            array('public', 'nombre_apellido'),
            array('public', 'direccion'),
            array('public', 'correo'),
            array('public', 'telefono'),
            array('public', 'sexo'),
            array('public', 'padre'),
            array('public', 'madre'),
            array('public', 'fecha_nacimiento'),
            array('public', 'cap'),
            array('public', 'comuna'),
            array('public', 'municipio'),
            array('public', 'provincia'),
            array('public', 'estado_civil'),
            array('public', 'org_partidista'),
            array('public', 'profesion'),
            array('public', 'funcion_trabajo'),
            array('public', 'nivel_escolar')
        );
    }

}
?>

