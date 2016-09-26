<?php
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../'));
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class Municipios extends SQLConection
{
    public function __construct ()
    {
        parent::__construct ("nmmunicipio");
        $this->fields = array (
                                array ('private', 'id'),
                                array ('public', 'id_provincia'),
                                array ('public', 'municipio'),
                                );
    }
}
?>