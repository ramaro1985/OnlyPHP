<?php
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../'));
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class Cargotrabajo extends SQLConection
{
    public function __construct ()
    {
        parent::__construct ("nmcargo_trabajo");
        $this->fields = array (
                                array ('private', 'id'),
                                array ('public', 'cargo_trabajo'),
                                );
    }
}
?>