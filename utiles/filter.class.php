<?php
    class Filtro
    {
        private $frmFiltro;
        private $arrFullLabels;
        
        public function __construct($arrFullLabels = array())
        {
            $this->frmFiltro = "";
            $this->arrFullLabels = $arrFullLabels;       
        }
        		        
        public function getFiltro($href, $por, $orden, $txtSearch, $Mostrartitulo)
        {
            try
            {
				$frmFiltro= '<form name="frmSearch" onsubmit="return validateTxtFilter(this);" action="'.$href.'" method="get">';
				$frmFiltro.= '<input type="hidden" name="por" value="'.$por.'">';            
				$frmFiltro.= '<input type="hidden" name="orden" value="'.$orden.'">';            
				$frmFiltro.= '<table border="0" cellpadding="3" cellspacing="2">';
				$frmFiltro.= '<tr>'; 
				$Busq = $this->arrFullLabels["filtro_busqueda"]; 
				if ( $txtSearch !="" ) $Busq.= "<b style='color:red'>".$this->arrFullLabels["filtro_activo"]."</b>";
				if ( $Mostrartitulo ) $Busq = "";
				$frmFiltro.= '<td colspan="3" width="100%"><strong><small>'.$Busq.'</small></strong></td>'; 
				$frmFiltro.= '</tr>'; 
				$frmFiltro.= '<tr>';
				$frmFiltro.= '<td nowrap="nowrap">'.$this->arrFullLabels["filtro_todo"].':&nbsp;<input name="txtSearch" id="txtSearch" value="'.$txtSearch.'" ></td>';
				$frmFiltro.= '<td align="right">';
				$frmFiltro.= '<input type="submit" title="'.$this->arrFullLabels["filtro_porcriterio"].'" name="btn_filtrar" id="btn_filtrar" value="'.$this->arrFullLabels["buscar"].'" >';
				$frmFiltro.= '</td>';       
				$frmFiltro.= '<td align="right">';            
				$frmFiltro.= '<input type="button" title="'.$this->arrFullLabels["filtro_limpiar"].'" name="btn_limpiarfiltro" id="btn_limpiarfiltro" value="'.$this->arrFullLabels["limpiar_filtro"].'" onClick="limpiar_filtro(\'txtSearch\');" >';
				$frmFiltro.= '</td>';
				$frmFiltro.= '</tr>';
				$frmFiltro.= '</table>';
				$frmFiltro.= '</form>';
                return $frmFiltro;
            }
            catch(Exception $e)
            {                                
                throw new Exception($e->getMessage(), $e->getCode());   
            }
        }
      
    }  
?>