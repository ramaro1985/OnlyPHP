<?php
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../'));
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class v_Caso_uso_funcionalidad extends SQLConection
{
    public function __construct ()
    {
        parent::__construct ("v_caso_uso_funcionalidad");
        $this->fields = array (
                                array ('private', 'id'),
                                array ('public', 'id_caso_uso'),
                                array ('public', 'id_funcionalidad'),
                                array ('public', 'funcionalidad'),
                                array ('public', 'nombre_logico'),
                                array ('public', 'nombre_fisico'),
                                array ('public', 'nombre_logico'),
                                array ('public', 'nombre_completo')
                                );
    }
}
?>