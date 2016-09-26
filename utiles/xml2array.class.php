<?php
/**
* XMLToArray Generator Class
* @author  :  MA Razzaque Rupom <rupom_315@yahoo.com>, <rupom.bd@gmail.com>
*             Moderator, phpResource (LINK1http://groups.yahoo.com/group/phpresource/LINK1)
*             URL: LINK2http://www.rupom.infoLINK2
* @version :  1.0
* @date       06/05/2006
* Purpose  : Creating Hierarchical Array from XML Data
* Released : Under GPL
*/

class XmlToArray
{
   
    var $xml='';
   
    /**
    * Default Constructor
    * @param $xml = xml data
    * @return none
    */
   
    function XmlToArray($xml)
    {
       $this->xml = $xml;   
    }
   
    /**
    * _struct_to_array($values, &$i)
    *
    * This is adds the contents of the return xml into the array for easier processing.
    * Recursive, Static
    *
    * @access    private
    * @param    array  $values this is the xml data in an array
    * @param    int    $i  this is the current location in the array
    * @return    Array
    */
   
    function _struct_to_array($values, &$i)
    {
        $child = array();
        if (isset($values[$i]['value'])) array_push($child, $values[$i]['value']);
       
        while ($i++ < count($values)) {
            switch ($values[$i]['type']) {
                case 'cdata':
                array_push($child, $values[$i]['value']);
                break;
               
                case 'complete':
                    $name = $values[$i]['tag'];
                    if(!empty($name)){
                    $child[$name]= ($values[$i]['value'])?($values[$i]['value']):'';
                    if(isset($values[$i]['attributes'])) {                   
                        $child[$name] = $values[$i]['attributes'];
                    }
                }   
              break;
               
                case 'open':
                    $name = $values[$i]['tag'];
                    $size = isset($child[$name]) ? sizeof($child[$name]) : 0;
                    $child[$name][$size] = $this->_struct_to_array($values, $i);
                break;
               
                case 'close':
                return $child;
                break;
            }
        }
        return $child;
    }//_struct_to_array
   
    /**
    * createArray($data)
    *
    * This is adds the contents of the return xml into the array for easier processing.
    *
    * @access    public
    * @param    string    $data this is the string of the xml data
    * @return    Array
    */
    function createArray()
    {
        $xml    = $this->xml;
        $values = array();
        $index  = array();
        $array  = array();
        $parser = xml_parser_create();
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        if (!xml_parse_into_struct($parser, $xml, $values, $index) )
			die ("XML : " . xml_error_string ( xml_get_error_code($parser) ) . "F: " . $xml );
			
        xml_parser_free($parser);
        $i = 0;
        $name = $values[$i]['tag'];
        $array[$name] = isset($values[$i]['attributes']) ? $values[$i]['attributes'] : '';
        $array[$name] = $this->_struct_to_array($values, $i);
        return $array;
    }//createArray
   
   
	/*
		Working with XML. Usage: 
		$xml=xml2ary(file_get_contents('1.xml'));
		$link=&$xml['ddd']['_c'];
		$link['twomore']=$link['onemore'];
		// ins2ary(); // dot not insert a link, and arrays with links inside!
		echo ary2xml($xml);
	*/
	
	// XML to Array
	// _Internal: Remove recursion in result array
	function _del_p(&$ary) {
		foreach ($ary as $k=>$v) {
			if ($k==='_p') unset($ary[$k]);
			elseif (is_array($ary[$k])) $this->_del_p($ary[$k]);
		}
	}
		
	function xml2ary(&$string) {
		$parser = xml_parser_create();
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		xml_parse_into_struct($parser, $string, $vals, $index);
		xml_parser_free($parser);
	
		$mnary=array();
		$ary=&$mnary;
		foreach ($vals as $r) {
			$t=$r['tag'];
			if ($r['type']=='open') {
				if (isset($ary[$t])) {
					if (isset($ary[$t][0])) $ary[$t][]=array(); else $ary[$t]=array($ary[$t], array());
					$cv=&$ary[$t][count($ary[$t])-1];
				} else $cv=&$ary[$t];
				if (isset($r['attributes'])) {foreach ($r['attributes'] as $k=>$v) $cv['_a'][$k]=$v;}
				$cv['_c']=array();
				$cv['_c']['_p']=&$ary;
				$ary=&$cv['_c'];
	
			} elseif ($r['type']=='complete') {
				if (isset($ary[$t])) { // same as open
					if (isset($ary[$t][0])) $ary[$t][]=array(); else $ary[$t]=array($ary[$t], array());
					$cv=&$ary[$t][count($ary[$t])-1];
				} else $cv=&$ary[$t];
				if (isset($r['attributes'])) {foreach ($r['attributes'] as $k=>$v) $cv['_a'][$k]=$v;}
				$cv['_v']=(isset($r['value']) ? $r['value'] : '');
	
			} elseif ($r['type']=='close') {
				$ary=&$ary['_p'];
			}
		}    
		
		$this->_del_p($mnary);
		return $mnary;
	}
	

	
	// Array to XML
	function ary2xml($cary, $d=0, $forcetag='') {
		$res=array();
		foreach ($cary as $tag=>$r) {
			if (isset($r[0])) {
				$res[]=ary2xml($r, $d, $tag);
			} else {
				if ($forcetag) $tag=$forcetag;
				$sp=str_repeat("\t", $d);
				$res[]="$sp<$tag";
				if (isset($r['_a'])) {foreach ($r['_a'] as $at=>$av) $res[]=" $at=\"$av\"";}
				$res[]=">".((isset($r['_c'])) ? "\n" : '');
				if (isset($r['_c'])) $res[]=ary2xml($r['_c'], $d+1);
				elseif (isset($r['_v'])) $res[]=$r['_v'];
				$res[]=(isset($r['_c']) ? $sp : '')."</$tag>\n";
			}
			
		}
		return implode('', $res);
	}
	
	// Insert element into array
	function ins2ary(&$ary, $element, $pos) {
		$ar1=array_slice($ary, 0, $pos); $ar1[]=$element;
		$ary=array_merge($ar1, array_slice($ary, $pos));
	}
   
}//XmlToArray
?>