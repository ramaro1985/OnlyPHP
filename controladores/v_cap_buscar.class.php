<?php
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../'));
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class v_Cap_Buscar extends SQLConection
{
    public function __construct ()
    {
        parent::__construct ("v_nmcap_buscar");
        $this->fields = array (
                                array ('public', 'id'),
                                array ('public', 'id_comuna'),                                
                                array ('public', 'id_municipio'),
                                array ('public', 'id_provincia'),
                                array ('public', 'cap'),
                                array ('public', 'comuna'),
                                array ('public', 'municipio'),
                                array ('public', 'provincia')
                                );
    }
}
?>