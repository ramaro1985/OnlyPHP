<?php 
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../'));
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../../'));     
include_once("configuracion/configuracion.php");  
include_once("acceso_datos/".DRIVER_BD."_acceso_datos.class.php");
include_once("utiles/paginator.class.php");

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nombre                        : Paginator_html extiende pe la clase Paginator
//autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
//fecha creacion                : 19 Junio 2012
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//RESUMEN
/*
   Clase que extiende de Pagintor para manejar la paginaci?n de la clase listado y mostrar los controles de manejo
*/
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Las constantes que se utilizan en la clase se obtienen del fichero de configuracion "configuracion.php"
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      
class Paginator_html extends Paginator {
			  
	var $casouso;
	var $db_name;
	var $table;
	var $result;
	var $db;
	var $port;
	var $sql_num_rows_query;
	var $request;

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : __construct(Constructor por defecto)
    //parametros de entrada           : $page => Pagina catual
	//								  : $conexion => El objeto que representa el controlador del caso de uso	
    //parametros de salida            : n/e
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 08 Junio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function __construct($casouso, $page, $request= '')
    {
		parent::__construct ( $page, $casouso->objConexion->cantidadElementos());
        
        $this->casouso      = $casouso;
        $this->request      = $request;
        $this->total_items  = $this->num_rows;
        $this->limit        = FILAS_POR_PAGINA;
        $offset             = $this->getRange1();
        $q = $query . " LIMIT " . $limit . " offset " . $offset;        
	}
			  
	function setQuery($query)
	{
  
		$limit = $this->get_Limit();  

		/*echo "page = ".$this->page. "<br>";
		echo "record = ".$this->num_rows. "<br>";
		echo $q. "<br>";
		echo "*".$this->request. "<br>";*/
		$this->result = pg_query($this->connection, $q) or die("Query failed : " . pg_last_error($this->connection));
					
		//echo mysql_errno().": ".mysql_error()."<BR>";
	}
         
	function getResults()
	{
		return $this->result;
	}
				
	//outputs a link set like this 1 of 4 of 25 First | Prev | Next | Last |              
	function firstLast()
	{				
		if($this->getCurrent()==1)
		{
			$first = "<font color='#A2A2A2'>Inicio</font> | ";
		} 
		else { 
			$first="<a href=\"" .  $this->getPageName() . "?".$this->request."page=" . $this->getFirst() . "\">Inicio</a> |"; 
		}  
		       
		if($this->getPrevious())
		{
			$prev = "<a href=\"" .  $this->getPageName() . "?".$this->request."page=" . $this->getPrevious() . "\">Anterior</a> | ";
		} 
		else { 
			$prev="<font color='#A2A2A2'>Anterior</font> | "; 
		}
		
		if($this->getNext())
		{
			$next = "<a href=\"" . $this->getPageName() . "?".$this->request."page=" . $this->getNext() . "\">Siguiente</a> | ";
		} 
		else { 
			$next="<font color='#A2A2A2'>Siguiente</font> | "; 
		}
		
		
		if($this->getLast())
		{
			$last = "<a href=\"" . $this->getPageName() . "?".$this->request."page=" . $this->getLast() . "\">Final</a> | ";
		} 
		else { 
			$last="<font color='#A2A2A2'>Final</font> | "; 
		}
		if ($this->getSecondOf() > 0)
			echo "<font color='#A2A2A2'>Mostrando del " . $this->getFirstOf() . " al " .$this->getSecondOf() . ". (" . $this->getTotalItems() . " elementos) - </font>";
		echo $first . " " . $prev . " " . $next . " " . $last;
	} 
	
	function imgfirstLast()
	{				
		echo '<table width="100" height="20" border="0" cellpadding="0" cellspacing="0"><tr>';
		echo '<td><img src="../icons/SurfMenuBG1.jpg" width="49" height="20"></td>';
    	echo '<td background="../icons/SurfMenuBG2.jpg"></td>';
		if($this->getCurrent()==1)
		{
			echo '<td><img src="../icons/SurfMenuFirstUN.jpg" width="16" height="20"></td>';
		} 
		else { 
			echo "<td><a href=\"" .  $this->getPageName() . "?".$this->request."page=" . $this->getFirst() . "\"><img src='../icons/SurfMenuFirstNR.jpg' width='16' height='20' style='border:0' title='Inicio'></a></td>"; 
		}  
		
		
		if($this->getPrevious())
		{
			echo "<td><a href=\"" .  $this->getPageName() . "?".$this->request."page=" . $this->getPrevious() . "\"><img src='../icons/SurfMenuPrevNR.jpg' width='16' height='20'  style='border:0' title='Anterior'></a></td>";
		} 
		else { 
			echo '<td><img src="../icons/SurfMenuPrevUN.jpg" width="16" height="20"></td>';
		}
		
		if ($this->getSecondOf() > 0)
			echo '<td width="110" align="center" background="../icons/SurfMenuBG2.jpg" nowrap style="cursor:help" title="Total de elementos: '.$this->getTotalItems().'">'.$this->getFirstOf() . ' - ' .$this->getSecondOf().'</td>';
		else
			echo '<td width="30" align="center" background="../icons/SurfMenuBG2.jpg" nowrap style="cursor:help" title="Total de elementos: '.$this->getTotalItems().'"> - </td>';
		
		if($this->getNext())
		{
			echo "<td><a href=\"" . $this->getPageName() . "?".$this->request."page=" . $this->getNext() . "\"><img src='../icons/SurfMenuNextNR.jpg' width='16' height='20'  style='border:0' title='Siguiente'></a></td>";
		} 
		else { 
			echo '<td><img src="../icons/SurfMenuNextUN.jpg" width="16" height="20"></td>';
		}
		
		
		if($this->getLast())
		{
			echo "<td><a href=\"" . $this->getPageName() . "?".$this->request."page=" . $this->getLast() . "\"><img src='../icons/SurfMenuLastNR.jpg' width='16' height='20'  style='border:0' title='Final'></a></td>";
		} 
		else { 
			echo '<td><img src="../icons/SurfMenuLastUN.jpg" width="16" height="20"></td>';
		}
		
		echo '<td background="../icons/SurfMenuBG2.jpg"></td><td><img src="../icons/SurfMenuBG3.jpg" width="8" height="20"></td></tr></table>';
	} 
					
	//outputs a link set like this Previous 1 2 3 4 5 6 Next   
	function previousNext()
	{
		if($this->getPrevious())
		{
			echo "<a href=\"" . $this->getPageName() . "?".$this->request."page=" . $this->getPrevious() . "\">Previous</a> ";
		}
		
		$links = $this->getLinkArr();
		foreach($links as $link)
		{
			if($link == $this->getCurrent()) {
				echo " $link ";
			} 
			else { 
				echo "<a href=\"" . $this->getPageName() . "?".$this->request."page=$link\">" . $link . "</a> ";
			}
		} 
		
		if($this->getNext())
	  	{
	  		echo "<a href=\"" . $this->getPageName() . "?".$this->request."page=" . $this->getNext() . "\">Next</a> ";
	  	}
	}  
}//ends class
?>				 