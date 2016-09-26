<?php
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../'));
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class Grupos extends SQLConection
{
    public function __construct ()
    {
        parent::__construct ("nmgrupo_gestion");
        $this->fields = array (
                                array ('private', 'id'),
                                array ('public', 'grupo'),
                                array ('public', 'descripcion'),
                                array ('public', 'activo')
                                );
    }
}
?>