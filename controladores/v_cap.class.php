<?php
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../'));
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class v_Cap extends SQLConection
{
    public function __construct ()
    {
        parent::__construct ("v_nmcap");
        $this->fields = array (
                                array ('private', 'id'),
                                array ('public', 'cap'),
                                array ('public', 'comuna'),
                                array ('public', 'municipio'),
                                array ('public', 'provincia'),                                
                                );
    }
}
?>