<?php
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../'));
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class Usuario_extendido extends SQLConection
{
    public function __construct ()
    {
        parent::__construct ("nmusuario");
        $this->fields = array (
                                array ('private', 'id'),
                                array ('public', 'usuario'),
                                array ('public', 'nombre_apellido'),
                                array ('public', 'clave'),
                                array ('public', 'habilitado'),
                                array ('public', 'id_activista'),
                              //  array ('public', 'id_grupo')                                
                                );
    }
}
?>