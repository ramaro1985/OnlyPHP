<?php
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../'));
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class Organizacion_enevento extends SQLConection
{
    public function __construct ()
    {
        parent::__construct ("nmorganizacion_enevento");
        $this->fields = array (
                                array ('private', 'id'),
                                array ('public', 'nombre_organizacion'),
                                array ('public', 'abreviatura')
                                );
    }
}
?>