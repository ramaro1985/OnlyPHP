<?php
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../'));
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class v_Municipios_Buscar extends SQLConection
{
    public function __construct ()
    {
        parent::__construct ("v_nmmunicipio_buscar");
        $this->fields = array (
                                array ('private', 'id'),
                                array ('public', 'id_provincia'),
                                array ('public', 'municipio'),
                                array ('public', 'provincia'),                                
                                );
    }
}
?>