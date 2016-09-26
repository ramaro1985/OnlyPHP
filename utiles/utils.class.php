<?php
abstract class Utils 
{
    /**
    * @desc convertBoolean
    *   Convierte los valores de true, false que vienen como cadena del XML en valores boolean para 
    *   el tratamiento posterior en las clases
    */
    static function convertBoolean( $stringValue )
    {
        $stringValue = ( $stringValue == "true" );
        return ( $stringValue && true );
    }
    
    /**
    * @desc showArray
    *   Funcionalidad para imprimir el contenido de un arreglo en pantalla
    */
    static  function showArray( $fullXML )
    {
        echo ("<pre>");
        print_r( $fullXML );
        echo ("<pre>");
    }
    
    static function obtenerIpUsuario()
    {     
        if( @$_SERVER['HTTP_X_FORWARDED_FOR'] != '' )
        {
            $client_ip =
                ( !empty($_SERVER['REMOTE_ADDR']) ) ?   @$_SERVER['REMOTE_ADDR']  :
                        ( ( !empty($_ENV['REMOTE_ADDR']) ) ?    @$_ENV['REMOTE_ADDR']   :   "Ip desconocida" );

            // los proxys van hadiendo al final de esta cabecera
            // las direcciones ip que van "ocultando". Para localizar la ip real
            // del usuario se comienza a mirar por el principio hasta encontrar
            // una direcci?n ip que no sea del rango privado. En caso de no
            // encontrarse ninguna se toma como valor el REMOTE_ADDR

            $entries = split('[, ]', @$_SERVER['HTTP_X_FORWARDED_FOR']);

            reset($entries);
              while (list(, $entry) = each($entries))
              {
                 $entry = trim($entry);
                 if ( preg_match("/^([0-9]+\\.[0-9]+\\.[0-9]+\\.[0-9]+)/", $entry, $ip_list) )
                 {
                    // http://www.faqs.org/rfcs/rfc1918.html
                    $private_ip = array(
                          '/^0\\./',
                          '/^127\\.0\\.0\\.1/',
                          '/^192\\.168\\..*/',
                          '/^172\\.((1[6-9])|(2[0-9])|(3[0-1]))\\..*/',
                          '/^10\\..*/');

                    $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);

                    if ($client_ip != $found_ip)
                    {
                       $client_ip = $found_ip;
                       break;
                    }
                 }
              }
           }
           else
           {
              $client_ip =
                 ( !empty($_SERVER['REMOTE_ADDR']) ) ?  @$_SERVER['REMOTE_ADDR'] :
                        ( ( !empty($_ENV['REMOTE_ADDR']) ) ?    @$_ENV['REMOTE_ADDR'] : "Ip desconocida" );
           }

           return $client_ip;
    }

    /**
    * @desc getMenu
    *   Funcionalidad armar el muenu principal
    */
    static function getMenu( $arr, $current_example, $current_template )
    {
        $html = "";
        foreach ($arr as $title => $values) {
            $html .= "<li>".$title;
            $html .= "  <ul>";
            foreach ($values[1] as $option => $value1) { 
                $casoUso = explode (',', $value1);
                $html .= "<li>";
                $html .= '<a href="?frm='.$casoUso[0].'&amp;template='.$casoUso[1].'"';
                if ($current_example == $casoUso[0] && $current_template == $casoUso[1]) { $html .= ' class="selected"'; }
                $html .= '>'.$option.'</a>';
                $html .= '</li>';
            }
            @end;
            $html .= "  </ul>";
            $html .= "</li>";
        }
        @end;
        return $html;
    }

    static function arrayEnviaPOST( $arr ) {
        $arr = urlencode(serialize($arr));
        return $arr;
    } 
    
    static function arrayRecibePOST( $arr ) {
        $tmp = stripslashes($arr);
        $tmp = urldecode($tmp);
        $tmp = unserialize($tmp);

        return $tmp;
    } 

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : construirURLdeARRAY (Construcir los parametros de una URL desde un ARRAY)
    //parametros de entrada           : $arrPOST -> Arreglo que entra por el POST.
    //                                : $arr -> Arreglo que entra por el POST en la variable $arrGet (Trae los valores del caso uso y plantilla)
    //                                : $indice_buscar -> Indice del arreglo que entra por el POST en la variable $arrGet (Trae los valores del caso uso y plantilla)
    //                                : $indice_eliminar -> Indice del arreglo que quiero eliminar    
    //parametros de salida            : n/e
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 08 Junio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    static function construirURLdeARRAY($arrPOST, $arr, $indice_buscar, $indice_eliminar) {
         unset($arrPOST[$indice_eliminar]);
       
        foreach ($arrPOST as $indice=>$valor) {
            if ($indice != $indice_buscar) {
                if (array_key_exists($indice, $arr)) {
                    $arr[$indice] = $valor;   
                } else {
                    $arr[$indice] = $valor;   
                }
            }
        }

        $url = '?';
        foreach ($arr as $indice => $valor) {
            $url .= $indice.'='.$valor.'&'; 
        }
        $url = substr($url, 0, strlen($url)-1);

        return $url;        
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : construirURL (Construcir los parametros de una URL desde un ARRAY)
    //parametros de entrada           : $arrPOST -> Arreglo que entra por el POST.
    //parametros de salida            : la URL
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 05 Julio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    static function construirURL( $arr ) {
        $url = '?';
        foreach ($arr as $indice => $valor) {
            $url .= $indice.'='.$valor.'&'; 
        }
        $url = substr($url, 0, strlen($url)-1);

        return $url;        
    }

    
    static function getArrayForSelect($objDatos, $fieldIndex='id', $fieldDescription='', $firstElement='') {
        if(is_array($objDatos) && count($objDatos) > 0)
        {
            $myArray = array();
            foreach($objDatos as $key=>$value)
            {
                if ($firstElement != '') { $myArray['']= $firstElement; }
                foreach($value as $field=>$value1) {                 
                    if ($field == $fieldIndex) { $index = $value1; }
                    if ($field == $fieldDescription) { $description = $value1; }                
                }
                $myArray[$index]= $description;          
            }
        }
        return @$myArray;
    }     

    static function getArrayPermisoCasoUso( $arrayPermisos, $casoUso ) {
        $arrPermisoCasoUso = array();
        if ($arrayPermisos != null) {
            $cantElementos = count($arrayPermisos);
            for ($i = 0; $i < $cantElementos; $i++) {
                if ( $arrayPermisos[$i]['nombre_caso_uso'] == $casoUso )
                    $arrPermisoCasoUso[$i] = $arrayPermisos[$i];
            }
        }
        return $arrPermisoCasoUso;                
    }

    static function getPermisoCasoUsoFuncionalidad( $arrPermisoCasoUso, $casoUso, $funcionalidad, $idUsuario ) {
        if ($idUsuario != 1) {
            $acceso = FALSE;
            if ($arrPermisoCasoUso != null) {
                foreach($arrPermisoCasoUso as $index=>$value) {
                    if ( strtolower($value['funcionalidad']) == strtolower($funcionalidad) ) {
                        $acceso = TRUE;
                        BREAK;
                    }
                }                
            }
        } else { //es usuario SuperAdmin
            $acceso = TRUE;             
        }
        return $acceso;                
    }
    
    static function getArrMenu( $arrFullLabels, $arrayPermisos, $Menu, $idUsuario ) {
        $arryMenu = array();
        if ($arrFullLabels != null) {
            switch (strtolower($Menu)) {
                case "adminusuario": {
                    $opciones = array();
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'grupo' )) || ($idUsuario == 1) ) { $opciones[$arrFullLabels["grupos"]] = 'grupo,lst'; }
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'usuario' )) || ($idUsuario == 1)  ) { $opciones[$arrFullLabels["usuarios"]] = 'usuario,lst'; }

                    if ( $opciones != NULL ) { 
                        $arryMenu = array( $arrFullLabels["usuarios_del_sistema"]  =>  array('usuario', $opciones) ); 
                    } else {
                        $arryMenu = NULL;         
                    } 
                    
                break;
                }
                case "menuactivista": {
                    $opciones = array();
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'activista' )) || ($idUsuario == 1) ) { $opciones[$arrFullLabels["activistas"]] = 'activista,lst'; }

                    if ( $opciones != NULL ) { 
                        $arryMenu = array( $arrFullLabels["gestion_activistas"]  =>  array('usuario', $opciones) ); 
                    } else {
                        $arryMenu = NULL;         
                    } 
                    
                break;
                }                
                case "menuproyecto": {
                    $opciones = array();
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'empresa' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["listado_empresa"]] = 'empresa,lst'; }
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'proyecto' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["listado_proyecto"]] = 'proyecto,lst'; }                    
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'recorrido' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["listado_recorrido"]] = 'recorrido,lst'; }   
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'producto' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["listado_producto"]] = 'producto,lst'; }                                
                    
                    if ( $opciones != NULL ) { 
                        $arryMenu = array( $arrFullLabels["gestion_proyectos"]  =>  array('usuario', $opciones) ); 
                    } else {
                        $arryMenu = NULL;         
                    } 
                    
                break;
                }                                
                case "adminnomenclador": {
                    $opciones = array();
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'provincia' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["provincias"]] = 'provincia,lst'; }
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'municipio' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["municipios"]] = 'municipio,lst'; }
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'comuna' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["comunas"]] = 'comuna,lst'; }
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'cap' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["cap"]] = 'cap,lst'; }
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'estadocivil' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["estado_civil"]] = 'estadocivil,lst'; }
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'organizacion' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["listado_organizacion"]] = 'organizacion,lst'; }
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'profesion' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["profesiones"]] = 'profesion,lst'; }
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'nivelescolar' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["nivel_escolar"]] = 'nivelescolar,lst'; }
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'funciontrabajo' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["funciones_de_trabajo"]] = 'funciontrabajo,lst'; }
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'tipoevento' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["tipo_evento"]] = 'tipoevento,lst'; }                    
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'funcionmesa' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["funciones_en_mesa"]] = 'funcionmesa,lst'; }  

                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'tipoevaluacion' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["tipoevaluacion"]] = 'tipoevaluacion,lst'; }  
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'dialecto' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["dialecto"]] = 'dialecto,lst'; }  
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'cargotrabajo' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["listado_cargo_trabajo"]] = 'cargotrabajo,lst'; }
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'tiposervicio' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["tipos_servicio"]] = 'tiposervicio,lst'; }  

                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'organizacion_enevento' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["organizacion_enevento"]] = 'organizacion_enevento,lst'; }  

                    if ( $opciones != NULL ) { 
                        $arryMenu = array( $arrFullLabels["nomencladores_del_sistema"]  =>  array('nomencladores', $opciones) ); 
                    } else {
                        $arryMenu = NULL;         
                    } 
                    
                break;
                }
                case "menuasamblea": {
                    $opciones = array();
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'asamblea' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["asambleas"]] = 'asamblea,lst'; }
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'asamblea' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["asambleaporconf"]] = 'asambleaporconf,lst'; }
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'asamblea' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["asambleaconf"]] = 'asambleaconf,lst'; }                    
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'relatorio' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["relatorio"]] = 'relatorio,horizontal'; }
                    //if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'partemesa' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["partes_informativos"]] = 'partemesa,lst'; }
                    
                    if ( $opciones != NULL ) { 
                        $arryMenu = array( $arrFullLabels["gestion_asamblea"]  =>  array('campanna', $opciones) ); 
                    } else {
                        $arryMenu = NULL;         
                    } 
                    
                break;
                }                
                case "menuactividades": {
                    $opciones = array();
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'evento' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["listado_evento"]] = 'evento,lst'; }
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'evento_mpla' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["precampanna"]] = 'precampanna,lst';}
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'evento_mpla' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["encampanna"]] = 'encampanna,lst';}
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'evento_mpla' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["postcampanna"]] = 'postcampanna,lst';}
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'evento_mpla' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["evento_oposc"]] = 'evento_oposc,lst'; }
                    if ( (Utils::getArrayPermisoCasoUso( $arrayPermisos, 'modificar_fecha_electoral' ))  || ($idUsuario == 1) ) { $opciones[$arrFullLabels["modificar_fecha_electoral"]] = 'modificarfecha,horizontal'; }
                 
                    if ( $opciones != NULL ) { 
                        $arryMenu = array( $arrFullLabels["gestion_actividades"]  =>  array('campanna', $opciones) ); 
                    } else {
                        $arryMenu = NULL;         
                    } 
                    
                break;
                }                                
            }  
            
        }
        return $arryMenu;                
        
    }    
    
	 static function getDivError( $text ) {
        return '<div id="div_error" style="display:none;">'.$text.'</div><br>';                
    }
    
     static function getDivOpen() {
        return '<div id="div_horizontal"; >';                
    }
     static function getDivClose() {
        return '</div>';                
    }
    
    static function getDivErrorLogin( $text ) {
        return '<div id="div_error">'.$text.'</div><br>';                
    }    
    
    static function getDivTitulo( $text ) {
        return '<div id="div_title_list"><h2><span>'.$text.'</span></h2><br></div>';
    }

    static function getDivTituloLogin( $text, $error ) {
        $titulo = '<h2>'.$text.'</h2><br>';
        if ( !isset($error) ) { $titulo .= '<br>'; }
        return $titulo;
    }    
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : construirFiltro
    //parametros de entrada         : $filtro => Arreglo de elementos a filtrar
    //parametros de entrada         : $operador => Operador para conformar la cadena del WHERE
    //parametros de salida          : Se retorna la cadena de filtro
    //autor                         : Msc. Juan Carlos Badillo Goy
    //fecha    creacion             : 06 Julio 2012
    //RESUMEN                       : Se crea la lista para filtrar
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function construirFiltro($arrPOST, $arrString, $arrNumeric, $arrBoolean, $arrDate, $arrList, $operador= ' OR ')
    {
        $arrResult = array();
        $datos = array();
        if ($arrPOST != null) {
            $filtro = array();
            foreach($arrPOST as $index=>$value) {
                $index = strtolower($index);
                if ( (is_array($arrString)) && (count($arrString)>0) ) {
                    if ( in_array (strtolower($index), $arrString )) {
                        $filtro[] = array ('field' => $index, 'type' => 'string', 'value' => $value, 'comparacion' => NULL);
                        $datos[$index] = $value; 
                    }
                }
                if ( (is_array($arrNumeric)) && (count($arrNumeric)>0) ) {                
                    if ( in_array (strtolower($index), $arrNumeric )) {
                        $filtro[] = array ('field' => $index, 'type' => 'numeric', 'value' => $value, 'comparacion' => '='); 
                        $datos[$index] = $value;
                    }
                }
                if ( (is_array($arrDate)) && (count($arrDate)>0) ) {                                
                    if ( in_array (strtolower($index), $arrDate )) {
                        $filtro[] = array ('field' => $index, 'type' => 'date', 'value' => $value, 'comparacion' => '=');
                        $datos[$index] = $value; 
                    }
                }
                if ( (is_array($arrBoolean)) && (count($arrBoolean)>0) ) {                                
                    if ( in_array (strtolower($index), $arrBoolean )) {
                        $filtro[] = array ('field' => $index, 'type' => 'date', 'value' => $value, 'comparacion' => '='); 
                        $datos[$index] = $value;
                    }
                } 
                if ( (is_array($arrList)) && (count($arrList)>0) ) {                                
                    if ( in_array (strtolower($index), $arrList )) {
                        $filtro[] = array ('field' => $index, 'type' => 'date', 'value' => $value, 'comparacion' => '='); 
                        $datos[$index] = $value;
                    }
                }                                   
            }                
        }

        $arrResult['datos'] = $datos;  
        $qs ="";
        $where = "";
        if (is_array($filtro)) {
            for ($i=0;$i<count($filtro);$i++){
                switch($filtro[$i]['type']){
                    case 'string' : if ($filtro[$i]['value'] != '') { $qs .= $operador . ' (' . $filtro[$i]['field']." ILIKE '%".$filtro[$i]['value']."%'" . ')'; } Break;
                    case 'list' : 
                        if (strstr($filtro[$i]['value'],',')){
                            $fi = explode(',',$filtro[$i]['value']);
                            for ($q=0;$q<count($fi);$q++){
                                $fi[$q] = "'".$fi[$q]."'";
                            }
                            $filtro[$i]['value'] = implode(',',$fi);
                            $qs .= $operador . ' (' . $filtro[$i]['field']." IN (".$filtro[$i]['value'].")" . ')'; 
                        }else{
                            $qs .= $operador . ' (' . $filtro[$i]['field']." = '".$filtro[$i]['value']."'" . ')'; 
                        }
                    Break;
                    case 'boolean' : $qs .= $operador . ' (' .$filtro[$i]['field']." = ".($filtro[$i]['value']) . ')'; Break;
                    case 'numeric' : 
                        if ( isset($filtro[$i]['value']) && $filtro[$i]['value'] != '' && $filtro[$i]['value'] != ' ') {
                            switch ($filtro[$i]['comparacion']) {
                                case 'eq' : $qs .= $operador . ' (' . $filtro[$i]['field']." = ".$filtro[$i]['value'] . ')'; Break;
                                case 'lt' : $qs .= $operador . ' (' . $filtro[$i]['field']." < ".$filtro[$i]['value'] . ')'; Break;
                                case 'gt' : $qs .= $operador . ' (' . $filtro[$i]['field']." > ".$filtro[$i]['value'] . ')'; Break;
                            }
                        }
                    Break;
                    case 'date' : 
                        if ( isset($filtro[$i]['value']) && ($filtro[$i]['value'] != '')) {
                            date_default_timezone_set('America/Havana');
                            switch ($filtro[$i]['comparacion']) {
                                case '=' : $qs .= $operador . ' (' . $filtro[$i]['field']." BETWEEN '".date('Y-m-d H:i:s',strtotime($filtro[$i]['value'])." 00:00:00")."' AND '".date('Y-m-d H:i:s',strtotime($filtro[$i]['value']."23:59:59"))."'" . ')'; Break;
                                case '<' : $qs .= $operador . ' (' . $filtro[$i]['field']." < '".date('Y-m-d',strtotime($filtro[$i]['value']))."'" . ')'; Break;
                                case '>' : $qs .= $operador . ' (' . $filtro[$i]['field']." > '".date('Y-m-d',strtotime($filtro[$i]['value']))."'" . ')'; Break;
                            }
                        }
                    Break;
                }
            }    
            $qs = substr($qs, 3, strlen($qs));
            if ($qs != "") {$where .= $qs;} else {$where = "";}
            
        }
         $arrResult['where'] = $where;  
         return $arrResult;
    }    

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : generarCadenaAleatoria
    //parametros de entrada         : $longitud     => Canatidad de caracteres de la cadena de resultado, por defecto 10
    //                              : $mayusculas   => Si queremos incluir caracteres en mayusculas, por defecto SI
    //                              : $numeros      => Si queremos incluir caracteres numericos, por defecto SI
    //                              : $especiales   => Si queremos incluir caracteres especiales, por defecto NO    
    //parametros de salida          : Retorna la cadena de caracteres generada  
    //autor                         : Msc. Juan Carlos Badillo Goy
    //fecha    creacion             : 16 Julio 2012
    //RESUMEN                       : Genera una cadena con caracteres aletorios
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function generarCadenaAleatoria($longitud=10, $mayusculas=TRUE, $numeros=TRUE, $especiales=FALSE) {
        $cadFuente = 'abcdefghijklmnopqrstuvwxyz';
        if($mayusculas == 1) $cadFuente .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if($numeros == 1) $cadFuente .= '1234567890';
        if($especiales == 1) $cadFuente .= '|@#~$%()=^*+[]{}-_';
        if($longitud > 0) {
            $cadResultado = "";
            $longitudFuente  = strlen($cadFuente) - 1;
            for($i=1; $i<=$longitud; $i++) {
                mt_srand((double)microtime() * 1000000);
                $cadResultado .= $cadFuente[mt_rand(1, $longitudFuente)-1];
            }
        }
        return $cadResultado;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : codificarClave
    //parametros de entrada         : $clave        => Clave a codificar
    //                              : $longitud     => Canatidad de caracteres a generar, por defecto 5
    //                              : $posicion     => posicion en la que queremos insertar los caracteres generados, por defecto 15
    //                              : $inicio       => Si queremos incluir un caracter al inicio, por defecto SI    
    //                              : $fin          => Si queremos incluir un caracter al final, por defecto SI    
    //                              : $mayusculas   => Si queremos incluir caracteres en mayusculas, por defecto SI
    //                              : $numeros      => Si queremos incluir caracteres numericos, por defecto SI
    //                              : $especiales   => Si queremos incluir caracteres especiales, por defecto NO    
    //parametros de salida          : Retorna la clave codificada
    //autor                         : Msc. Juan Carlos Badillo Goy
    //fecha    creacion             : 16 Julio 2012
    //RESUMEN                       : Genera una cadena con caracteres aletorios
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function codificarClave($clave='', $longitud=5, $posicion=15, $inicio=TRUE, $fin=TRUE, $mayusculas=TRUE, $numeros=TRUE, $especiales=FALSE) {
        if ($clave != '') {
            if($posicion != 0) {
                $cadInicio = $cadFin = '';
                $centro = Utils::generarCadenaAleatoria($longitud, $mayusculas, $numeros, $especiales);
                if ($inicio == 1) $cadInicio = Utils::generarCadenaAleatoria(1, $mayusculas, $numeros, $especiales);
                if ($fin == 1) $cadFin = Utils::generarCadenaAleatoria(1, $mayusculas, $numeros, $especiales);            
                $clave = $cadInicio. substr($clave, 0, $posicion). $centro. substr($clave, $posicion, strlen($clave)). $cadFin;
            }
        }
        return $clave;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : codificarClave
    //parametros de entrada         : $clave        => Clave a codificar
    //                              : $longitud     => Canatidad de caracteres a eliminar, por defecto 5
    //                              : $posicion     => posicion a partir que eliminaremos los caracteres, por defecto 15
    //                              : $inicio       => Si queremos eliminar un caracter al inicio, por defecto SI    
    //                              : $fin          => Si queremos eliminar un caracter al final, por defecto SI    
    //parametros de salida          : Retorna la clave decodificada
    //autor                         : Msc. Juan Carlos Badillo Goy
    //fecha    creacion             : 16 Julio 2012
    //RESUMEN                       : Genera una cadena con caracteres aletorios
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function decodificarClave($clave='', $longitud=5, $posicion=15, $inicio=TRUE, $fin=TRUE) {
        if ($clave != '') {
            if($posicion != 0) {
                if ($inicio == 1) $clave = substr($clave, 1);
                if ($fin == 1) $clave = substr($clave, 0, strlen($clave)-1);                                                          
                $clave = substr($clave, 0, $posicion). substr($clave, $posicion + $longitud, strlen($clave));
            }
        }
        return $clave;
    }
     
}
?>