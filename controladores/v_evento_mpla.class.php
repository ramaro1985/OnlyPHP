<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class v_Evento_mpla extends SQLConection {
    public function __construct() {
        parent::__construct("v_evento_mpla");
        $this->fields = array(
            array('private', 'id'),
            array('public', 'provincia'),
            array('public', 'municipio'),
            array('public', 'comuna'),
            array('public', 'presidente_acto'),
            array('public', 'fecha_realizada'),
            array('public', 'cantidad_participantes')
        );
    }

}
?>

   
   
   
   
   
   
   
   
   
   
   