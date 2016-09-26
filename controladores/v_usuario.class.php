<?php
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../'));
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class v_Usuarios extends SQLConection
{
    public function __construct ()
    {
        parent::__construct ("v_nmusuario");
        $this->fields = array (
                                array ('public', 'id'),
                                array ('public', 'usuario'),
                                array ('public', 'nombre_apellido'),
                                array ('public', 'habilitado'),
                               // array ('public', 'grupo'),
                                array ('public', 'activista'),
                                );
    }
}
?>