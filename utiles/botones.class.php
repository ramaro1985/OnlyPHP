<?php
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../'));
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../../'));     
include_once("configuracion/configuracion.php");  
include_once("utiles/session.class.php");
include_once("utiles/utils.class.php");

    class Botones
    {
        private $frmBotones;
        private $arrFullLabels;
        private $mySession;
        private $mostrarInsertar;
        private $mostrarEliminar;
        private $mostrarFiltrar;
        private $mostrarPaginado;
        private $mostrarBuscar;
        private $casoUso;
        private $cantidad;
        private $por;
        private $orden;
        private $txtSearch;
        private $footerPages;        
        
        public function __construct($arrFullLabels = array(), $casoUso="", $cantidad, $por, $orden, $txtSearch, $footerPages='')
        {
            $this->mySession        = new Session();
            $this->frmBotones       = "";
            $this->arrFullLabels    = $arrFullLabels;       
            $this->mostrarInsertar  = TRUE;
            $this->mostrarEliminar  = TRUE;
            $this->mostrarFiltrar   = TRUE;
            $this->mostrarPaginado  = TRUE;
            $this->mostrarBuscar    = TRUE;            
            $this->casoUso          = $casoUso;
            $this->cantidad         = $cantidad;
            $this->por              = $por;
            $this->orden            = $orden;
            $this->txtSearch        = $txtSearch;
            $this->footerPages      = $footerPages; 
                               
            
        }
        
        public function setMostrarInsertar( $value = TRUE) {
            $this->mostrarInsertar = $value;
        }        

        public function setMostrarEliminar( $value = TRUE) {
            $this->mostrarEliminar = $value;
        }        
        
        public function setMostrarFiltrar( $value = TRUE) {
            $this->mostrarFiltrar = $value;
        }                

        public function setMostrarPaginado( $value = TRUE) {
            $this->mostrarPaginado = $value;
        }                

        public function setMostrarBuscar( $value = TRUE) {
            $this->mostrarBuscar = $value;
        }                
        
        
        public function obtenerBotones()
        {
            try
            {
                $frmBotones = '<input type="hidden" name="por" value="'.$this->por.'">';            
                $frmBotones.= '<input type="hidden" name="orden" value="'.$this->orden.'">';            
				$frmBotones.= '<table border="0" width="100%" cellpadding="3" cellspacing="2">';
				$frmBotones.= '<tr>';
				$frmBotones.= '<td><table border="0" width="100%" align="center" id="tbl_list">';
				$frmBotones.= '<tr>';
                $frmBotones.= '<td align="left">';
                if ($this->mostrarInsertar) { $frmBotones.= '<input name="btn_insertar" type="button" id="btn_insertar" title="'.$this->arrFullLabels["nuevo_elemento"].'" value="'.$this->arrFullLabels["nuevo"].'" align="left" onClick="insertar_articulo('."'frm_listado', 'insertar', '../negocio/crud_".$this->casoUso.".php');". '">'; }
				if ( $this->cantidad > 0) {
					$frmBotones.= '<input name="btn_todos" type="button" id="btn_todos" title="'.$this->arrFullLabels["seleccionar_todos"].'" onClick="return CheckAll(\'frm_listado\',\'0\');" value="'.$this->arrFullLabels["todos"].'" align="left">';
					$frmBotones.= '<input name="btn_ninguno" type="button" id="btn_ninguno" title="'.$this->arrFullLabels["limpiar_seleccion"].'" onClick="return CheckAll(\'frm_listado\',\'1\');" value="'.$this->arrFullLabels["limpiar"].'" align="left">';            
					$frmBotones.= '<input name="btn_invertir" type="button" id="btn_invertir" title="'.$this->arrFullLabels["invertir_seleccion"].'" onClick="return CheckAll(\'frm_listado\',\'2\');" value="'.$this->arrFullLabels["invertir"].'" align="left">';            
				}				
                if ( ($this->cantidad > 0) && ($this->mostrarEliminar) ) { $frmBotones.= '<input name="btn_eliminar" type="submit" id="btn_eliminar" title="'.$this->arrFullLabels["eliminar_seleccionados"].'" value="'.$this->arrFullLabels["eliminar"].'" align="left">'; }                

                //Mostrar el pafinador
                if ( ($this->footerPages != '') && ($this->mostrarPaginado) ) { $frmBotones.= "<div style=\"text-align:right; float:right; margin-top:8px\">".$this->footerPages."</div>"; }                

                $frmBotones.= '</td>';               
                if ( $this->mostrarFiltrar ) {                
                    $frmBotones.= '<td align="right">';
                    $frmBotones.= '<input name="txtSearch" id="txtSearch" value="'.$this->txtSearch.'" >';
                    $frmBotones.= '<input type="button" title="'.$this->arrFullLabels["filtro_porcriterio"].'" name="btn_filtrar" id="btn_filtrar" value="'.$this->arrFullLabels["buscar"].'" onClick="buscar_filtro('."'frm_listado', 'buscar', '../negocio/crud_".$this->casoUso.".php');". '">';
                    $frmBotones.= '<input type="button" title="'.$this->arrFullLabels["filtro_limpiar"].'" name="btn_limpiarfiltro" id="btn_limpiarfiltro" value="'.$this->arrFullLabels["limpiar_filtro"].'" onClick="limpiar_filtro(\'txtSearch\');" >';
                    if ( $this->mostrarBuscar ) { $frmBotones.= '<input type="button" title="'.$this->arrFullLabels["buscar_avanzado"].'" name="btn_buscar" id="btn_buscar" value="'.$this->arrFullLabels["avanzada"].'" onClick="buscar_avanzada('."'frm_listado', 'buscar_avanzado', '../negocio/crud_".$this->casoUso.".php');". '">'; }
                    $frmBotones.= '</td>';
                }

				$frmBotones.= '</tr>';            
				$frmBotones.= '</table>';            
				$frmBotones.= '</td>';
				$frmBotones.= '</tr>';            
				$frmBotones.= '</table>';
                return $frmBotones;
            }
            catch(Exception $e)
            {                                
                throw new Exception($e->getMessage(), $e->getCode());   
            }
        }
        
        public function getBotonImpPdf($frm)
        {
            return '<input name="btn_imprimir" type="button" id="btn_imprimir" title="Imprimir pdf" value="Exportar a pdf" align="absmiddle" onClick="imprimirPdf(\''.$frm.'\');">';
        }
        
      
    }  

?>