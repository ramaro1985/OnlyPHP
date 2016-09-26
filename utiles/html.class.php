<?php
class Html
{
    private $fontSize;
    private $title;
    private $doctype;     
    private $charset;     
    private $script;
    private $styles;
    private $head;
    private $body;
    private $html;
    private $bodyStyle;
    private $camino_imagenes;
    
    public function __construct($charset, $title, $camino_imagenes)
    {
        try 
        {
            $this->doctype      = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
            $this->head         = '';                        
            $this->body         = '';                        
            $this->html         = '';
            $this->script       = '';
            $this->styles       = '';
            $this->charset      = $charset;
            $this->title        = $title;
            $this->fontSize     = 10;
            $this->bodyStyle    = 'font-family:Verdana, Arial, Helvetica, sans-serif; font-size:'.$this->fontSize.'px;';
            $this->camino_imagenes = $camino_imagenes; 
        }   
        catch(Exception $e)            
        {
            throw new Exception($e->getMessage(),$e->getCode());
        }
    }

    function setTitle( $title="" ) {
        $this->title = $title;
    }
    
    function setCharset( $charset='UTF-8' ) {
        $this->charset = $charset;
    }
    
    function setDoctype( $doctype='' ) {
        $this->doctype = $doctype;
    }
    
    function setArrScript( $script ) {
        for ($i=0; $i<sizeof($script); $i++){ 
            $this->script.= ' <script language="javascript" src="'.$script[$i].'"></script>'; 
        }
    }

    function setScript( $script='' ) {
        $this->script.= '<script type="text/javascript">';
        $this->script.= $script;
        $this->script.= '</script>';         
    }    
    
    function setArrStyles( $styles ) {
        for ($i=0; $i<sizeof($styles); $i++){ 
            $this->styles.= ' <link rel="stylesheet" type="text/css" href="'.$styles[$i].'"/>'; 
        }
    }
    
    function setStyles( $styles='' ) {
        $this->styles.= '<style type="text/css">';
        $this->styles.= $styles; 
        $this->styles.= '</style>';
    }

    function setIcon( $icon='' ) {
        $this->styles.= ($icon !='') ? '<link rel="shortcut icon" href="'.$this->camino_imagenes.'/'.$icon.'" />' : '<link rel="shortcut icon" href="'.$this->camino_imagenes.'/loginIcon.ico" />'; 
    }
    
    private function setHead() {
        $this->head = '<head>';
        $this->head.= ' <meta http-equiv="Content-Type" content="text/html; charset='.$this->charset.'"/>';
        $this->head.= ' <title>'.$this->title.'</title>';
        $this->head.= $this->styles;
        $this->head.= $this->script;        
        $this->head.= "</head>";                            
    }
    
    function setBody( $style='', $onLoad='', $body='' ) {
        if ($style !='') { $this->bodyStyle = $style; } 
        $this->body = '<body ';
        if ($onLoad!='') { $this->body.= ' onLoad="'.$onLoad.'"'; }
        if ($this->bodyStyle !='') { $this->body.= ' style="'.$this->bodyStyle.'"'; }        
        $this->body.= ' >';
        if ($body !='' ) { $this->body .= $body; }
        $this->body.='</body>';
    }
    
    function getHtml() {
        $this->html = $this->doctype;
        $this->html.= '<html xmlns="http://www.w3.org/1999/xhtml">';
        $this->setHead();
        $this->html.= $this->head;
        $this->html.= $this->body;
        $this->html.= '</html>';
        return $this->html;
    }
        
  }
?>