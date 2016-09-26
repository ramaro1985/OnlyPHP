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
    
}    
?>
