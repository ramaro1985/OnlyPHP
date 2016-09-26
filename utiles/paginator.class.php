<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nombre                        : Paginator
//autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
//fecha creacion                : 19 Junio 2012
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//RESUMEN
/*
   Clase para manejar la paginaci?n de la clase listado
*/
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Las constantes que se utilizan en la clase se obtienen del fichero de configuracion "configuracion.php"
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
class Paginator {
	//todas las variables pivadas.
	var $previous;	
	var $current;
	var $next;
	var $page;
	var $total_pages;
	var $link_arr;
	var $range1;
	var $range2;
	var $num_rows;
	var $first;
	var $last;
	var $first_of;
	var $second_of;
	var $limit;
	var $prev_next;
	var $base_page_num;
	var $extra_page_num;
	var $total_items;
	var $pagename;
    var $offset;
    private $arrFullLabels;
	

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : __construct(Constructor por defecto)
    //parametros de entrada           : $page => Pagina catual
	//								  : $num_rows => Cantidad de registros
    //parametros de salida            : n/e
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 08 Junio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function __construct($page, $limit, $num_rows=0, $arrFullLabels)
    {
		if (!$page) {
			$this->page = 1; //Iniciamos en la primara pagina
		} else {
			$this->page = $page; //Recibimos el valor de la pagina actual, de ser un valor (<1) Iniciamos en 1 
			if ($this->page < 1)
				$this->page = 1;
		}
	
		if($num_rows)
		{
			$this->num_rows = $num_rows; //Recibimos el total de registros
			$this->total_items = $this->num_rows;
		}
        
        $this->set_Limit( $limit );
        $this->offset   = $this->getRange1();
        $this->arrFullLabels = $arrFullLabels; 
	}
	
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : getOffset
    //parametros de entrada           : n/e
    //parametros de salida            : retorna el numero de registro a partir del cual comenzar a cargarse la consulta.
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 08 Junio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function getOffset() { return $this->offset; }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : getPage
    //parametros de entrada           : n/e
    //parametros de salida            : Retorna la pagina activa 
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 08 Junio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getPage() { return $this->page; }
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : set_Limit
    //parametros de entrada           : $limit => Cantidad de registros por cada pagina
    //parametros de salida            : n/e
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 08 Junio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function set_Limit($limit=5)
	{
		$this->limit = $limit;
		$this->setBasePage();
		$this->setExtraPage();
	}

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : get_Limit
    //parametros de entrada           : n/e
    //parametros de salida            : Cantidad de registros por cada pagina
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 08 Junio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function get_Limit()
	{
		return $this->limit;
	}
			
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : setBasePage
    //parametros de entrada           : n/e
    //parametros de salida            : Cantidad de paginas que necesitaran en funcion del $limit (cantidad de registros por paginas)
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 08 Junio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function setBasePage()
	{
		$div=$this->num_rows/$this->limit;	
		$this->base_page_num=floor($div);
	}

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : setExtraPage
    //parametros de entrada           : n/e
    //parametros de salida            : Cantidad de paginas extras que necesitaran en funcion del $limit (cantidad de registros por paginas)
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 08 Junio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function setExtraPage()
	{
		$this->extra_page_num=$this->num_rows - ($this->base_page_num*$this->limit);
	}
	
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : set_Links
    //parametros de entrada           : prev_next => Cantidad de registros para calcular la proxima pagina
    //parametros de salida            : n/e
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 08 Junio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function set_Links($prev_next=5)
	{
		$this->prev_next = $prev_next;
	}
	
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : getTotalItems
    //parametros de entrada           : n/e
    //parametros de salida            : Cantidad toral de registros
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 08 Junio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function getTotalItems()
	{
		$this->total_items = $this->num_rows;
		return $this->total_items;
	}
	
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : getRange1
    //parametros de entrada           : n/e
    //parametros de salida            : Rango para usar en las consultas
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 08 Junio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function getRange1()
	{
		return $this->range1=($this->limit*$this->page)-$this->limit;	
	}
	
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : getRange2
    //parametros de entrada           : n/e
    //parametros de salida            : Rango para usar en salida 
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 08 Junio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function getRange2()
	{
		if($this->page==$this->base_page_num + 1)
		{
			$this->range2=$this->extra_page_num;
		} else { 
			$this->range2=$this->limit;
		}
		return $this->range2;
	}
	
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : getFirstOf
    //parametros de entrada           : n/e
    //parametros de salida            : Retorna el primer elemento de la lista 
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 08 Junio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function getFirstOf()
	{
		$this->first_of=$this->range1 + 1;
		return $this->first_of;
	}
	
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : getSecondOf
    //parametros de entrada           : n/e
    //parametros de salida            : Retorna el segundo elemento de la lista 
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 08 Junio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//method to get the second number in a series as in 5 of 8.
	function getSecondOf()
	{
		if($this->page==$this->base_page_num + 1)
		{
			$this->second_of=$this->range1 + $this->extra_page_num;
		} else { 
			$this->second_of=$this->range1 + $this->limit;
		}
		return $this->second_of;
	}
	
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : getTotalPages
    //parametros de entrada           : n/e
    //parametros de salida            : Retorna la cantidad total de paginas 
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 08 Junio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function getTotalPages()
	{
		if($this->extra_page_num)
		{
			$this->total_pages = $this->base_page_num + 1;
		} else {
			$this->total_pages = $this->base_page_num;
		}
		return $this->total_pages;
	}
	
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : getFirst
    //parametros de entrada           : n/e
    //parametros de salida            : Retorna el primer link de la lista 
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 08 Junio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function getFirst()
	{
		$this->first=1;
		return $this->first;
	}
	
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : getFirst
    //parametros de entrada           : n/e
    //parametros de salida            : Retorna el ultimo link de la lista 
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 08 Junio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function getLast()
	{
		if($this->page == $this->total_pages)
		{
			$this->last=0;
		}else { 
			$this->last = $this->total_pages;
		}
		return $this->last;  
	}

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : getPrevious
    //parametros de entrada           : n/e
    //parametros de salida            : Retorna el anterior link de la lista 
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 08 Junio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function getPrevious()
	{
		if ( $this->page > 1 ) { $this->previous = $this->page - 1; }
		return $this->previous;
	}
	
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : getCurrent
    //parametros de entrada           : n/e
    //parametros de salida            : Retorna el link activo de la lista 
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 08 Junio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function getCurrent()
	{
		$this->current = $this->page;
		return $this->current;
	}
	
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : getPageName
    //parametros de entrada           : n/e
    //parametros de salida            : Retorna el nombre de la pagina o link activo 
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 08 Junio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function getPageName()
	{
		$this->pagename = $_SERVER['PHP_SELF'];;
		return $this->pagename;
	}
	
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : getNext
    //parametros de entrada           : n/e
    //parametros de salida            : Retorna el nombre del siguiente link de la lista 
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 08 Junio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function getNext()
	{   
		$this->getTotalPages();
		if($this->total_pages != $this->page && $this->total_pages> 0)
		{
			$this->next = $this->page + 1;
		}
		return $this->next;
	}
	
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : getLinkArr
    //parametros de entrada           : n/e
    //parametros de salida            : Retorna el arreglo de link
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 08 Junio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function getLinkArr()
	{
		//gets the top range   
		$top = $this->getTotalPages()- $this->getCurrent();
		if($top <= $this->prev_next)
		{
			$top = $top;
			$top_range = $this->getCurrent() + $top;
		} else { $top = $this->prev_next; $top_range = $this->getCurrent() + $top; }
	
		//gets the bottom range
		$bottom = $this->getCurrent() -1;
		if($bottom <= $this->prev_next)
		{
			$bottom = $bottom;
			$bottom_range = $this->getCurrent() - $bottom;
		} else { $bottom = $this->prev_next; $bottom_range = $this->getCurrent() - $bottom; } 
	
		$j=0;
		foreach(range($bottom_range, $top_range) as $i)
		{
			$this->link_arr[$j] = $i;
			$j++;
		}
		return $this->link_arr;
	}

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : getPagerFooter
    //parametros de entrada           : n/e
    //parametros de salida            : Retorna el link de pie de pagina de la siguiente forma
    //                                : Mostrando del 1 al 22. (22 elementos) - Inicio | Anterior | Siguiente | Final |
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 08 Junio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    
    public function getPagerFooter( $request )
    {                
        if($this->getCurrent()==1)
        {
            $first = "<font color='#A2A2A2'>". $this->arrFullLabels["inicio"] ."</font> | ";
        } 
        else { 
            $first="<a href=\"" .  $request ."&amp;page=" . $this->getFirst() . "\">". $this->arrFullLabels["inicio"] ."</a> |"; 
        }  
               
        if($this->getPrevious())
        {
            $prev = "<a href=\"" . $request ."&amp;page=" . $this->getPrevious() . "\">". $this->arrFullLabels["anterior"] ."</a> | ";
        } 
        else { 
            $prev="<font color='#A2A2A2'>". $this->arrFullLabels["anterior"] ."</font> | "; 
        }
        
        if($this->getNext())
        {
            $next = "<a href=\"" . $request."&amp;page=" . $this->getNext() . "\">". $this->arrFullLabels["siguiente"] ."</a> | ";
        } 
        else { 
            $next="<font color='#A2A2A2'>". $this->arrFullLabels["siguiente"] ."</font> | "; 
        }
        
        
        if($this->getLast())
        {
            $last = "<a href=\"" . $request."&amp;page=" . $this->getLast() . "\">". $this->arrFullLabels["final"] ."</a> | ";
        } 
        else { 
            $last="<font color='#A2A2A2'>". $this->arrFullLabels["final"] ."</font> | "; 
        }
        if ($this->getSecondOf() > 0)
            $html = "<font color='#A2A2A2'>". $this->arrFullLabels["mostrando_del"]. " " . $this->getFirstOf() . " ". $this->arrFullLabels["al"]. " ". $this->getSecondOf() . ". (" . $this->getTotalItems() . " ". $this->arrFullLabels["elementos"]. ") - </font>";

        $html .=  $first . " " . $prev . " " . $next . " " . $last;

        return $html; //Control de salida

    } 


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : getPagerHeader
    //parametros de entrada           : n/e
    //parametros de salida            : Retorna el link de pie de pagina de la siguiente forma
    //                                : <<  <  1 al 22 >  >>
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 08 Junio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    
    public function getPagerHeader()
    {                
        echo '<table width="100" height="20" border="0" cellpadding="0" cellspacing="0"><tr>';
        echo '<td><img src="public/imagenes/SurfMenuBG1.jpg" width="49" height="20"></td>';
        echo '<td background="public/imagenes/SurfMenuBG2.jpg"></td>';
        if($this->getCurrent()==1)
        {
            echo '<td><img src="public/imagenes/FirstUN.jpg" width="16" height="20"></td>';
        } 
        else { 
            echo "<td><a href=\"" .  $this->getPageName() . "?".$this->request."page=" . $this->getFirst() . "\"><img src='public/imagenes/FirstNR.jpg' width='16' height='20' style='border:0' title='Inicio'></a></td>"; 
        }  
        
        
        if($this->getPrevious())
        {
            echo "<td><a href=\"" .  $this->getPageName() . "?".$this->request."page=" . $this->getPrevious() . "\"><img src='public/imagenes/PrevNR.jpg' width='16' height='20'  style='border:0' title='Anterior'></a></td>";
        } 
        else { 
            echo '<td><img src="public/imagenes/PrevUN.jpg" width="16" height="20"></td>';
        }
        
        if ($this->getSecondOf() > 0)
            echo '<td width="110" align="center" background="public/imagenes/SurfMenuBG2.jpg" nowrap style="cursor:help" title="Total de elementos: '.$this->getTotalItems().'">'.$this->getFirstOf() . ' - ' .$this->getSecondOf().'</td>';
        else
            echo '<td width="30" align="center" background="public/imagenes/SurfMenuBG2.jpg" nowrap style="cursor:help" title="Total de elementos: '.$this->getTotalItems().'"> - </td>';
        
        if($this->getNext())
        {
            echo "<td><a href=\"" . $this->getPageName() . "?".$this->request."page=" . $this->getNext() . "\"><img src='public/imagenes/NextNR.jpg' width='16' height='20'  style='border:0' title='Siguiente'></a></td>";
        } 
        else { 
            echo '<td><img src="public/imagenes/NextUN.jpg" width="16" height="20"></td>';
        }
        
        
        if($this->getLast())
        {
            echo "<td><a href=\"" . $this->getPageName() . "?".$this->request."page=" . $this->getLast() . "\"><img src='public/imagenes/LastNR.jpg' width='16' height='20'  style='border:0' title='Final'></a></td>";
        } 
        else { 
            echo '<td><img src="public/imagenes/SurfMenuLastUN.jpg" width="16" height="20"></td>';
        }
        
        echo '<td background="public/imagenes/SurfMenuBG2.jpg"></td><td><img src="public/imagenes/SurfMenuBG3.jpg" width="8" height="20"></td></tr></table>';
    }     
	
}//ends Paginator class
?>	