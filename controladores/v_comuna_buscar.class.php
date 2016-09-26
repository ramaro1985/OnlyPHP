<?php
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../'));
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class v_Comunas_Buscar extends SQLConection
{
    public function __construct ()
    {
        parent::__construct ("v_nmcomuna_buscar");
        $this->fields = array (
                                array ('public', 'id'),
                                array ('private', 'id_municipio'),
                                array ('private', 'id_provincia'),
                                array ('public', 'comuna'),
                                array ('public', 'municipio'),
                                array ('public', 'provincia'),
                                );
    }
}
?>