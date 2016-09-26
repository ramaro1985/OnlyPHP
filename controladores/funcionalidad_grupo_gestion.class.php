<?php
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../'));
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class Funcionalidad_grupo_gestion extends SQLConection
{
    public function __construct ()
    {
        parent::__construct ("funcionalidad_grupo_gestion");
        $this->fields = array (
                                array ('private', 'id'),
                                array ('public', 'id_grupo_gestion'),
                                array ('public', 'id_caso_uso_funcionalidad')                                
                                );
    }
}
?>