<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
include_once("configuracion/configuracion.php");
include_once("acceso_datos/" . DRIVER_BD . "_acceso_datos.class.php");
include_once("utiles/session.class.php");
include_once("utiles/filter.class.php");
include_once("utiles/botones.class.php");
include_once("utiles/utils.class.php");
include_once("utiles/paginator.class.php");
include_once("controladores/grupo.class.php");
include_once("controladores/usuario.class.php");
include_once("controladores/v_usuario.class.php");
include_once("controladores/organizacion.class.php");
include_once("controladores/profesion.class.php");
include_once("controladores/provincia.class.php");
include_once("controladores/estadocivil.class.php");
include_once("controladores/nivelescolar.class.php");
include_once("controladores/funciontrabajo.class.php");
include_once("controladores/tipoevento.class.php");
include_once("controladores/funcionmesa.class.php");
include_once("controladores/comuna.class.php");
include_once("controladores/v_comuna.class.php");
include_once("controladores/v_municipio.class.php");
include_once("controladores/v_cap.class.php");
include_once("controladores/v_activista.class.php");
include_once("controladores/v_nmgrupo_gestion.class.php");
include_once("controladores/empresa.class.php");
include_once("controladores/v_empresa.class.php");
include_once("controladores/v_proyecto.class.php");
include_once("controladores/v_proyectoempresa.class.php");
include_once("controladores/proyecto.class.php");
include_once("controladores/producto.class.php");
include_once("controladores/tiposervicio.class.php");
include_once("controladores/cargotrabajo.class.php");
include_once("controladores/v_recorrido.class.php");
include_once("controladores/v_recorridoparte.class.php");
include_once("controladores/v_evento.class.php");
include_once("controladores/empresa.class.php");
include_once("controladores/v_empresa.class.php");
include_once("controladores/v_proyecto.class.php");
include_once("controladores/v_proyectoempresa.class.php");
include_once("controladores/proyecto.class.php");
include_once("controladores/producto.class.php");
include_once("controladores/tiposervicio.class.php");
include_once("controladores/cargotrabajo.class.php");
include_once("controladores/v_recorrido.class.php");
include_once("controladores/v_recorridoparte.class.php");
include_once("controladores/tipoevaluacion.class.php");
include_once("controladores/v_dialecto.class.php");
include_once("controladores/dialecto.class.php");
include_once("controladores/organizacion_enevento.class.php");
include_once("controladores/v_evento_mpla.class.php");
//include_once("controladores/v_asamblea.class.php");
include_once("controladores/v_asamblea.class.php");
include_once("controladores/v_mesaelectoral.class.php");



include_once("idioma/pt.php");

class lst {

    private $conexion;
    private $arrFields;
    private $arrGet;
    private $arrFullLabels;
    private $hrefEdit;
    private $urlAction;
    private $casoUso;
    private $paginator;
    private $mySession;
    private $arrPermisoCasoUso;
    private $accesoInsertar;
    private $accesoEliminar;
    private $accesoModificar;
    private $accesoFiltrar;
    private $accesoBuscar;

    public function __construct($casoUso = "", $tabla, $arrFullLabels = array(), $arrGet = array(), $hrefEdit = '', $filter = "", $showFilter = "", $urlAction = "", $mySession) {
        try {
            $this->casoUso = strtolower($casoUso);
            $this->mySession = $mySession;

            $this->arrPermisoCasoUso = Utils::getArrayPermisoCasoUso($this->mySession->arrAcceso, $this->casoUso);
            //print_r( $this->arrPermisoCasoUso);
            $this->accesoInsertar = Utils::getPermisoCasoUsoFuncionalidad($this->arrPermisoCasoUso, $this->casoUso, 'insertar', $this->mySession->idusuario);
            $this->accesoEliminar = Utils::getPermisoCasoUsoFuncionalidad($this->arrPermisoCasoUso, $this->casoUso, 'eliminar', $this->mySession->idusuario);
            $this->accesoModificar = Utils::getPermisoCasoUsoFuncionalidad($this->arrPermisoCasoUso, $this->casoUso, 'modificar', $this->mySession->idusuario);
            $this->accesoFiltrar = Utils::getPermisoCasoUsoFuncionalidad($this->arrPermisoCasoUso, $this->casoUso, 'filtrar', $this->mySession->idusuario);
            $this->accesoBuscar = Utils::getPermisoCasoUsoFuncionalidad($this->arrPermisoCasoUso, $this->casoUso, 'buscar', $this->mySession->idusuario);

            $this->arrFullLabels = $arrFullLabels;
            $clase = ucwords($tabla);
            $this->conexion = new $clase;
            $this->arrFields = explode(",", $this->conexion->getTableFieldsAll());
            //$this->arrFields = explode(",", $this->conexion->getTableFields());
            $this->arrGet = $arrGet;
            $this->hrefEdit = $hrefEdit;
            $this->urlAction = $urlAction;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function getLst($return = false) {
        //Campo por el que se ordenara
        if ($this->arrGet["por"] != '') {
            $por = $this->arrGet["por"];
        } else {
            $por = 'id';
        }
        //Tipo de ordenamiento
        if (strtolower($this->arrGet["orden"]) == 'asc') {
            $orden = 'asc';
            $ordenhref = 'desc';
        } else {
            $orden = 'desc';
            $ordenhref = 'asc';
        }
        //Texto de busqueda
        if (isset($this->arrGet["txtSearch"])) {
            $txtSearch = $this->arrGet["txtSearch"];
        } else {
            $txtSearch = "";
        }

        $table1 = '<form id="frm_listado" name="frm_listado" method="post" action="' . $this->urlAction . '" onSubmit="return ValidateSomeChecked( this,' . "'" . $this->arrFullLabels["seleccionar_uno"] . "', '" . $this->arrFullLabels["eliminar_seleccionado"] . "'" . ' );">';

        $table5 = '<table width="100%" border="0" cellpadding="0" cellspacing="0" id="redandblack">';
        $table5.= '<tr>';

        /* bgcolor="'. $bgcolor .'" align="'. $align. '" */
        $table5.= '<th width="24" >';
        $table5.= '</th>';

        $filtro = '';
        /* bgcolor="'. $bgcolor .'" align="'. $align. '" */
        for ($i = 0; $i < count($this->arrFields); $i++) {
            if ($this->arrFields[$i] != 'id') {
                $table5.= '<th >';
                $Fields = $this->arrFields[$i];
                $labelTitle = $this->arrFullLabels[$Fields];
                if ($txtSearch != '') {
                    $table5.= '<a href="?frm=' . $this->casoUso . '&amp;template=lst&amp;por=' . $this->arrFields[$i] . '&amp;orden=' . $ordenhref . '&amp;txtSearch=' . $txtSearch . '">' . $labelTitle . '</a>';
                } else {
                    $table5.= '<a href="?frm=' . $this->casoUso . '&amp;template=lst&amp;por=' . $this->arrFields[$i] . '&amp;orden=' . $ordenhref . '">' . $labelTitle . '</a>';
                }
                $table5.= '</th>';
            }
            if ($txtSearch != '') {
                if ($i != 0) {
                    $filtro .= " or ( cast(" . $this->arrFields[$i] . " as text) ilike '%" . $txtSearch . "%') ";
                } else {
                    $filtro .= " ( cast(" . $this->arrFields[$i] . " as text) ilike '%" . $txtSearch . "%') ";
                }
            }
        }
        $table5.= '</tr>';

        $index = $this->casoUso;
        if (isset($this->mySession->where[$index]['where']) && ($this->mySession->where[$index]['where'] != '')) {
            if ($filtro != '') {
                $filtro.= ' AND ' . $this->mySession->where[$index]['where'];
            } else {
                $filtro.= $this->mySession->where[$index]['where'];
            }
        }
        if ($filtro != '') {
            $where_str = " 0=0 AND " . $filtro;
        } else {
            $where_str = " 0=0 ";
        }
        $order_str = $por . ' ' . $orden;

        //Pagina activa
        if (isset($this->arrGet["page"])) {
            $page = $this->arrGet["page"];
        }

        $this->conexion->getRecords($where_str, $order_str);

        //Se crea una instancia del paginador        
        $this->paginator = new Paginator($page, $this->conexion->objConexion->getLimit(), $this->conexion->objConexion->getTotalItems(), $this->arrFullLabels);

        $this->conexion->objConexion->realizarConsultaPaginada($this->paginator->page, $this->paginator->getOffset());

        $aDatos = $this->conexion->objConexion->crearArregloObjetos();

        $noExisten = "";
        if (is_array($aDatos) && count($aDatos) > 0) {
            $i = 0;
            foreach ($aDatos as $key => $value) {
                if ($i % 2 == 0) {
                    $idcebra = 'par';
                    $_bgcolor = "#F5F5F5";
                } else {
                    $idcebra = 'impar';
                    $_bgcolor = "#FFFFFF";
                }
                $j = 0;
                $hrefEdit = '';
                $table5.= '<tr class="' . $idcebra . '">';
                foreach ($value as $key => $value1) {
                    if ($j == 0) {
                        /* bgcolor="'.$_bgcolor.'" */
                        $table5.= '<td width="24"><input type="checkbox" id="chkDEL' . $i . '" name="chkDEL[]" value="' . $value1 . '"></td>';
                        if ($this->accesoModificar) {
                            $hrefEdit = '<a href="?frm=' . $this->casoUso . '&amp;template=add&amp;id=' . $value1 . '">';
                        }
                    } else {
                        /* bgcolor="'.$_bgcolor.'"  */
                        $table5.= '<td>' . $hrefEdit . $value1;
                        if ($this->accesoModificar) {
                            $table5.= '</a>';
                        }
                        $table5.= '</td>';
                    }
                    $j++;
                }
                $table5.= '</tr>';
                $i++;
            }
        } else {
            $noExisten = '<br><br><div id="div_no_existe">' . $this->arrFullLabels["no_existen"] . '</div><br><br>';
        }

        //$request = '?frm='.$this->arrGet["frm"].'&amp;template='.$this->arrGet["template"];
        if ($txtSearch != '') {
            $this->arrGet['txtSearch'] = $txtSearch;
        } else {
            unset($this->arrGet['txtSearch']);
        }
        if ($por != '') {
            $this->arrGet['por'] = $por;
        } else {
            unset($this->arrGet['por']);
        }
        if ($orden != '') {
            $this->arrGet['orden'] = $orden;
        } else {
            unset($this->arrGet['orden']);
        }

        $table5.= '</table>' . $noExisten;

        $table6 = '<input type="hidden" name="MM_from" id="MM_from" value="eliminar">';
        $table6.= '<input type="hidden" name="arrGet" id="arrGet" value="' . Utils::arrayEnviaPOST($this->arrGet) . '">';
        $table6.= '</form>';

        $this->mySession->arrFiltro = $this->arrGet;
        $this->mySession->actualizar();
        $request = Utils::construirURL($this->arrGet);

        $pagerFooter = $this->paginator->getPagerFooter($request);
        $hrefButton = '?frm=' . $this->arrGet["frm"] . '&amp;template=' . $this->arrGet["template"];

        $botones = new Botones($this->arrFullLabels, $this->casoUso, $this->conexion->objConexion->cantidadElementos(), $por, $orden, $txtSearch, $pagerFooter);

        $botones->setMostrarInsertar($this->accesoInsertar);
        $botones->setMostrarEliminar($this->accesoEliminar);
        $botones->setMostrarFiltrar($this->accesoFiltrar);
        $botones->setMostrarBuscar($this->accesoBuscar);

        $botones->setMostrarPaginado(FALSE);
        $table .= $table1 . $botones->obtenerBotones();

        $botones->setMostrarPaginado(TRUE);
        $botones->setMostrarFiltrar(FALSE);
        $table .= '<hr noshade size="1" width="100%" color="#FFFFFF">' . $table5 . '<hr noshade size="1" width="100%" color="#FFFFFF">';
        if ($noExisten == '') {
            $table .= $botones->obtenerBotones();
        }
        $table .= $table6;

        // if $return argument was TRUE, return the result
        if ($return)
            return $table;

        // if $return argument was FALSE, output the content
        else
            echo $table;
    }

    function getFooterPages($casoUso, $template, $txtSearch, $por, $orden) {
        $hrefPage = '?frm=' . $casoUso . '&amp;template=' . $template;
        if ($txtSearch != '') {
            $hrefPage .= '&amp;txtSearch=' . $txtSearch;
        }
        if ($por != '') {
            $hrefPage .= '&amp;por=' . $por;
        }
        if ($orden != '') {
            $hrefPage .= '&amp;orden=' . $orden;
        }
        if ($this->conexion->objConexion->getCurrentPages() == 1) {
            $first = "<font color='#A2A2A2'>Inicio</font> | ";
        } else {
            $first = "<a href=\"" . $hrefPage . "&amp;page=" . $this->conexion->objConexion->getFirstPages() . "\">Inicio</a> |";
        }

        if ($this->conexion->objConexion->getPreviousPages() > 0) {
            $prev = "<a href=\"" . $hrefPage . "&amp;page=" . $this->conexion->objConexion->getPreviousPages() . "\">Anterior</a> | ";
        } else {
            $prev = "<font color='#A2A2A2'>Anterior</font> | ";
        }

        if ($this->conexion->objConexion->getNextPages() > 0) {
            $next = "<a href=\"" . $hrefPage . "&amp;page=" . $this->conexion->objConexion->getNextPages() . "\">Siguiente</a> | ";
        } else {
            $next = "<font color='#A2A2A2'>Siguiente</font> | ";
        }

        if ($this->conexion->objConexion->getLastPages()) {
            $last = "<a href=\"" . $hrefPage . "&amp;page=" . $this->conexion->objConexion->getLastPages() . "\">Final</a> | ";
        } else {
            $last = "<font color='#A2A2A2'>Final</font> | ";
        }

        $html = "<font color='#A2A2A2'>Mostrando del " . $this->conexion->objConexion->getStartOfRange() . " al " . $this->conexion->objConexion->getEndOfRange() . ". (" . $this->conexion->objConexion->getTotalItems() . " elementos) - </font>";
        $html .= $first . " " . $prev . " " . $next . " " . $last;
        return $html;
    }

}

?>