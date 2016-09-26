<?php
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../'));
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../../'));
require_once ("acceso_datos/SQLConection.class.php");

class V_recorridoparte_buscar extends SQLConection
{
    public function __construct ()
    {
        parent::__construct ("v_recorridoparte_buscar");
        $this->fields = array (
                                array ('public', 'id'),
                                array ('public', 'id_recorrido'),
                                array ('public', 'nombre_recorrido'),
                                array ('public', 'id_usuario'),
                                array ('public', 'fecha_parte'),
                                array ('public', 'descripcion'),
                                array ('public', 'fecha_inicio_trabajo'),
                                array ('public', 'fecha_fin_trabajo')
                                                                );
    }
}
?>