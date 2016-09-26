<?php
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../'));
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class v_Permisos_por_usuario extends SQLConection
{
    public function __construct ()
    {
        parent::__construct ("v_permisos_por_usuario");
        $this->fields = array (
                                array ('private', 'id_caso_uso'),
                                array ('public', 'id_funcionalidad'),
                                array ('public', 'funcionalidad'),
                                array ('public', 'nombre_caso_uso'),
                                array ('private', 'id_grupo_gestion'),
                                array ('public', 'id_usuario'),
                                array ('public', 'id_caso_uso_funcionalidad'),
                                array ('public', 'id_grupo'),
                                array ('public', 'grupo'),
                                array ('public', 'activo')                                                                
                                );
    }
}
?>