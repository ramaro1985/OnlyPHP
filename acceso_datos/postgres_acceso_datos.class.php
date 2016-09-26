<?php
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : Postgres_Acceso_datos
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha creacion                : 08 Junio 2012
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //RESUMEN
    /*
        Clase para manejar el acceso a los datos en la base de datos. En esta clase se interact�a con el gestor de base 
        de datos postgres SQL. Se manejan las conexiones al servidor de base de datos, se devuelven los resultados de las 
        consultas.
    */

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Las constantes que se utilizan en la clase se obtienen del fichero de configuracion "configuracion.php"
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  set_include_path(get_include_path().PATH_SEPARATOR.realpath('../'));
  set_include_path(get_include_path().PATH_SEPARATOR.realpath('../../'));     
  include_once("configuracion/configuracion.php");  
  require_once("acceso_datos/acceso_datos.class.php");
      
  class Postgres_Acceso_Datos extends Acceso_datos                         
  {
        
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : __construct(Constructor por defecto)
    //parametros de entrada           : No se hace uso de parametros de entrada
    //parametros de salida            : n/e
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 08 Junio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function __construct()
    {
        //Se asignan los valores a los atributos de la clase a partir de las variables definidas en el fichero de 
        //configuracion        
        $this->servidor     = SERVIDOR;
        $this->puerto       = PUERTO_BD;
        $this->usuario      = USUARIO_BD;
        $this->contrasena   = CLAVE_BD;
        $this->base_datos   = NOMBRE_BD;
        $this->id_conexion  = null;
        $this->resultado    = null;

        $this->limit        = FILAS_POR_PAGINA;        
        
    }   
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : abrirConexion
    //parametros de entrada           : No se hace uso de parametros de entrada
    //parametros de salida            : Se retorna el identificador de la conexion realizada
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion               : 08 Junio 2012
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////               
    public function abrirConexion()
    {
        try
        {
            $cadena = '';                 
            //creando la cadena de conexion al servidor
            $cadena = "host=".$this->servidor." port=".$this->puerto." dbname=".$this->base_datos." user=".$this->usuario.
                      " password=".$this->contrasena;
                                                        
            if(function_exists( 'pg_connect' )) 
            {
                if(!$conexion = @pg_connect($cadena))
                    throw new Exception('',101);
                    else
                    {
                        $this->setIdConexion($conexion); 
                        return $this->id_conexion;
                    }
            }
            else
             throw new Exception('',106);
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage(),$e->getCode());
        }
    }
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : cerrarConexion
    //parametros de entrada         : No se hace uso de parametros de entrada
    //parametros de salida          : Se retorna true o false, en dependencia de si se cierra la conexion o no
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion             : 08 Junio 2012
    //RESUMEN                       : Se cierra una conexion activa al servidor de base de datos
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function cerrarConexion()   
    {
        if($this->id_conexion != null)
        {
            if(@pg_close($this->id_conexion))
            {
                $this->setIdConexion(null);
                return true;
            }
            else
                return false;
        }
         else
            return -1; //Si no habia una conexion activa retorna -1
    }
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : realizarConsulta
    //parametros de entrada         : $query => Cadena sql a ejecutar en el gestor de base de datos
    //parametros de salida          : Para las sentencias SELECT se devuelve un recurso en caso exitoso y FALSE en error
    //                                Para otro tipo de sentencia SQL, UPDATE, DELETE, DROP, etc, 
    //                                regresa TRUE en caso exitoso y FALSE en error.
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion             : 08 Junio 2012
    //RESUMEN                       : Se envia una consulta sql al servidor de base de datos para que la ejecute
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function realizarConsulta($query)    
    {
        try
        {
            //Basta con poner en falso la variable ERROR_LOG_SYSTEM en el fichero 
            //configuracion.php para que no se muestren los querys en el fichero especificado
            if ( ERROR_LOG_SYSTEM ){
                error_log($query . "\r\n", 3, "/my-errors.log");
            }
            if(!$this->resultado = @pg_query($this->id_conexion, $query))
            {
                $consulta = str_replace( "\r", "", str_replace( "\n", "", $query));
                throw new Exception( utf8_encode(@pg_last_error( $this->id_conexion ) . '. Consulta = ' .  trim( $consulta )) );
            }
            else {
                $i=0; $i++;
                $this->sqlQuery = $query;
                $this->totalItems = $this->cantidadElementos();
                return $this->resultado;
            }
        }
        catch(Exception $e)
        {
            //throw new Exception($e->getMessage());
            return 1;
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : realizarConsultaPaginada
    //parametros de entrada         : $currentPage => pagina activa
    //                              : $offset => Id del que se comienza a cargar las tuplas en el paginado
    //                              : $query => Cadena sql a ejecutar en el gestor de base de datos
    //parametros de salida          : Para las sentencias SELECT se devuelve un recurso en caso exitoso y FALSE en error
    //                                Para otro tipo de sentencia SQL, UPDATE, DELETE, DROP, etc, 
    //                                regresa TRUE en caso exitoso y FALSE en error.
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion             : 21 Junio 2012
    //RESUMEN                       : Se envia una consulta sql al servidor de base de datos para que la ejecute
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function realizarConsultaPaginada($currentPage, $offset=0, $query="")    
    {
        try
        {
            $this->offset = $offset;
            
            if ( $query == "" ) { $query = $this->getSqlQuery(); }

            $query .= "LIMIT ". $this->limit ." OFFSET ". $this->getOffset();
            
            //Basta con poner en falso la variable ERROR_LOG_SYSTEM en el fichero 
            //configuracion.php para que no se muestren los querys en el fichero especificado
            if ( ERROR_LOG_SYSTEM ){ error_log($query . "\r\n", 3, "/my-errors.log"); }
            if(!$this->resultado = @pg_query($this->id_conexion, $query))
            {
                $consulta = str_replace( "\r", "", str_replace( "\n", "", $query));
                throw new Exception( utf8_encode(@pg_last_error( $this->id_conexion ) . '. Consulta = ' .  trim( $consulta )) );
            }
            else {
                $i=0; $i++;
                return $this->resultado;
            }
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : realizarInsertar
    //parametros de entrada         : $query => Cadena sql a ejecutar en el gestor de base de datos
    //parametros de salida          : Retorna un arreglo con la tupla insertada en caso exitoso y FALSE en caso de error
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion             : 26 Junio 2012
    //RESUMEN                       : Se envia una consulta sql al servidor de base de datos para que la ejecute
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function realizarInsertar($query)    
    {

        $query .= "  RETURNING *";
        
        $this->realizarConsulta( $query );

        return $this->crearArreglo();
        
    }
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : cantidadElementos
    //parametros de entrada         : No se hace uso de parametros de entrada 
    //parametros de salida          : Se retorna el numero de filas que devuelve una consulta de selecci�n ejecutada
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion             : 08 Junio 2012
    //historico de modificaciones   :
    //RESUMEN                       : Se devuelve la cantidad de tuplas obtenidas en una consulta
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function cantidadElementos()         
    {
        if($this->resultado != null)
        {
            try
            {
                return $this->totalItems = @pg_num_rows( $this->resultado );
            }
            catch(Exception $e)
            {
                $error = $e->getMessage();
                throw new Exception($error);
            }
        }
        return -1;                  //Si no se habia ejecutado ninguna consulta se devuelve -1          
    }
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                          : crearArregloreporte
    //parametros de entrada         : No se hace uso de parametros de entrada 
    //parametros de salida          : Se retorna un arreglo de objetos a partir del resultado obtenido en una consulta de
    //                                selecci�n
    //autor                           : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion             : 08 Junio 2012
    //RESUMEN                         : Se crea y se retorna un arreglo de objetos por cada tupla obtenida en una consulta
    //                                de selecci�n realizada
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function crearArregloReporte()  
    {
        if($this->resultado != null)
        {
            if($this->cantidadElementos() > 0)
            {
                $arreglo = array(); 
                $cantidad = $this->cantidadElementos();
                if($cantidad > 0)
                {
                    $numfield = @pg_num_fields( $this->resultado );
                    $arreglo[0] = array();
                    for($i=0; $i<$numfield;$i++)
                    {
                        $arreglo[0][$i] = @pg_field_name($this->resultado,$i);
                        
                    }
                    for($i=0; $i<$cantidad;$i++)
                    {
                        $arreglo[$i+1] = @pg_fetch_array($this->resultado,$i,PGSQL_NUM);
                        
                    }
                    //Aqui se le aplica utf8_decode  a todos los elementos del arreglo , para que salgan las t�ldes 
                    foreach($arreglo as $item_arreglo){
                    
                    
                    foreach($item_arreglo as $item_item_arreglo){
                        
                       $arreglo_utf8_decode[$n][$m] = utf8_decode($item_item_arreglo);                    
                       $m++;
                    }
                      $m = 0;
                      $n++;
                    
                    }  
                    return $arreglo_utf8_decode;   
                }                                                         
            }
             else
             return 0;
        }
        else
            return -1;                 //Si no se habia ejecutado ninguna consulta se devuelve -1
    }       
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : crearArregloObjetos
    //parametros de entrada         : No se hace uso de parametros de entrada 
    //parametros de salida          : Se retorna un arreglo de objetos a partir del resultado obtenido en una consulta de
    //                                selecci�n
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion             : 08 Junio 2012
    //historico de modificaciones   :
    //RESUMEN                       : Se crea y se retorna un arreglo de objetos por cada tupla obtenida en una consulta
    //                                de selecci�n realizada
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function crearArregloObjetos()  
    {
        if($this->resultado != null)
        {
            if($this->cantidadElementos() > 0)
            {
                $arreglo = array(); 
                $cantidad = $this->cantidadElementos();
                if($cantidad > 0)
                {
                    for($i=0; $i<$cantidad;$i++)
                    {
                        $arreglo[$i] = @pg_fetch_object($this->resultado);
                    } 
                    return $arreglo;  
                }                                                         
            }
             else
             return 0;
        }
        else
            return -1;                 //Si no se habia ejecutado ninguna consulta se devuelve -1
    }                                  
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : crearArreglo
    //parametros de entrada         : No se hace uso de parametros de entrada 
    //parametros de salida          : Se retorna un arreglo por cada fila a partir del resultado obtenido en una consulta de
    //                                seleccion
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion             : 08 Junio 2012
    //historico de modificaciones   :
    //RESUMEN                       : Se devuelve un arreglo para la fila obtenida
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function crearArreglo()      
    {
        if($this->resultado != null)
            return @pg_fetch_array($this->resultado);
        return -1;                  //Si no se habia ejecutado ninguna consulta se devuelve -1
    }
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : crearArregloDeFilas
    //parametros de entrada         : No se hace uso de parametros de entrada 
    //parametros de salida          : Se retorna un arreglo por indices y nombres de las filas a partir del resultado obtenido en una consulta de
    //                                seleccion
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion             : 08 Junio 2012
    //historico de modificaciones   :
    //RESUMEN                       : Se devuelve un arreglo para la fila obtenida
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function crearArregloDeFilas()      
    {
        if($this->resultado != null) {
            for ($i = 0; $i < $this->cantidadElementos(); $i++) {
               $array = @pg_fetch_array($this->resultado, $i);
            }
        }
        return $array;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : crearArregloPorNombreDeFilas
    //parametros de entrada         : No se hace uso de parametros de entrada 
    //parametros de salida          : Se retorna un arreglo por nombre de filas a partir del resultado obtenido en una consulta de
    //                                seleccion
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion             : 08 Junio 2012
    //historico de modificaciones   :
    //RESUMEN                       : Se devuelve un arreglo para la fila obtenida
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function crearArregloPorNombreDeFilas()      
    {
        if($this->resultado != null) {
            for ($i = 0; $i < $this->totalItems; $i++) {
               $array[$i] = @pg_fetch_assoc($this->resultado, $i);
            }
        }
        return $array;
    }

    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : obtenerCantFilasAfectadas
    //parametros de entrada         : No se hace uso de parametros de entrada 
    //parametros de salida          : Se retorna la cantidad de filas afectadas en una consulta
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion             : 08 Junio 2012
    //historico de modificaciones   :
    //RESUMEN                       : Se devuelve la cantidad de filas afectadas en una consulta ejecutada, select, insert,
    //                                delete, update
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function obtenerCantFilasAfectadas()      
    {
        if($this->resultado != null)
            return @pg_affected_rows($this->resultado);
        return -1;                  //Si no se habia ejecutado ninguna consulta se devuelve -1
    }
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //nombre                        : obtenerMaximoId
        //parametros de entrada         : $tabla => Nombre de la tabla que se va a buscar el m�ximo identificador                                                     
        //parametros de salida          : Se retorna el m�ximo identificador de la tabla
        //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
        //fecha    creacion             : 11 Agosto 2009
        //historico de modificaciones   : 
        //RESUMEN                       : Se retorna el m�ximo identificador de la tabla especificada
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function obtenerMaximoId($tabla)
    {
        try
        {
            
            $consulta = 'SELECT id FROM '.$tabla.' ORDER BY id DESC LIMIT 1';
            //Basta con poner en falso la variable ERROR_LOG_SYSTEM en el fichero 
            //configuracion.php para que no se muestren los querys en el fichero especificado
            if ( ERROR_LOG_SYSTEM )
                error_log($consulta . "\r\n", 3, "/my-errors.log");
            
            if(!$this->resultado = @pg_query($this->id_conexion, $consulta))
                throw new Exception('',107);
                else
                {
                    //si no habia elemento , debemos comenzar en 0
                    //porque siempre el proximo elemento seria 1
                    if($this->cantidadElementos() == -1)
                        return 0;
                        
                    $id = $this->crearArreglo();
                    return $id['id'];
                }                                
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }         
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //nombre                        : obtenerCantidadFilas
        //parametros de entrada         : $tabla => Nombre de la tabla a consultar
        //                              : $where => Condici�n                                                     
        //parametros de salida          : Se retorna la cantidad de elementos que hay en la tabla
        //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
        //fecha    creacion             : 26 Agosto 2009
        //historico de modificaciones   : 
        //RESUMEN                       : Se obtiene la cantidad de tuplas que existen en la tabla especificada
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function obtenerCantidadFilas($tabla, $where ,$esquema_historico = false)
    {
        try
        {
            $esquema = ($esquema_historico ==true) ? 'historico.' : '';
            if(isset($_POST['filter'])&& $_POST['filter'][0]['field'] == id_periodo)$tabla = 'registro';
            $consulta = 'SELECT COUNT(id) AS cantidad FROM '.$esquema.$tabla .' WHERE ' . $where;
            //Basta con poner en falso la variable ERROR_LOG_SYSTEM en el fichero 
            //configuracion.php para que no se muestren los querys en el fichero especificado
            if ( ERROR_LOG_SYSTEM )
                error_log($consulta . "\r\n", 3, "/my-errors.log");
            if(!$this->resultado = @pg_query($this->id_conexion, $consulta))
                throw new Exception('',107);
                else
                {
                    $cantidad = $this->crearArreglo();
                    return $cantidad[0];
                }                                
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }  
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //nombre                        : obtenerCantidadFilasVistas
        //parametros de entrada         : $caso_uso => Nombre del caso de uso
        //                              : $where => Condici�n
        //parametros de salida          : Se retorna la cantidad de elementos que hay en la vista
        //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
        //fecha    creacion             : 10 Septiembre 2009
        //historico de modificaciones   : 
        //RESUMEN                       : Se obtiene la cantidad de tuplas que existen en la vista del caso de uso
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function obtenerCantidadFilasVista($caso_uso, $where)
    {
        try
        {
            $vista = "vw_".$caso_uso;
            $consulta = 'SELECT COUNT(*) AS cantidad FROM '.$vista .' WHERE ' . $where;
            if(!$this->resultado = @pg_query($this->id_conexion, $consulta))
                throw new Exception('',108);
                else
                {
                    $cantidad = $this->crearArreglo();
                    return $cantidad[0];
                }                                
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }                     
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : iniciarTransaccion
    //parametros de entrada         : No se hace uso de parametros de entrada 
    //parametros de salida          : Se retorna el resultado de la consulta ejecutada
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion             : 08 Junio 2012
    //historico de modificaciones   : 
    //RESUMEN                       : Se inicia una transaccion en el servidor de base de datos para la conexion abierta
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function iniciarTransaccion($anivel_aislamiento)
    {
        return $this->realizarConsulta("begin".' '.$anivel_aislamiento);
    }
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : terminarTransaccion
    //parametros de entrada         : No se hace uso de parametros de entrada 
    //parametros de salida          : Se retorna el resultado de la consulta ejecutada
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion             : 08 Junio 2012
    //historico de modificaciones   :
    //RESUMEN                       : Se termina una transaccion en el servidor de base de datos para la conexion abierta
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function terminarTransaccion()
    {
        return $this->realizarConsulta("commit");
    }
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : deshacerTransaccion
    //parametros de entrada         : No se hace uso de parametros de entrada 
    //parametros de salida          : Se retorna el resultado de la consulta ejecutada
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion             : 08 Junio 2012
    //historico de modificaciones   :
    //RESUMEN                       : Se deshace una transaccion en el servidor de base de datos para la conexion abierta
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function deshacerTransaccion()
    {
        return $this->realizarConsulta("rollback");
    }
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : tipoColumnadeTabla
    //parametros de entrada         : $tableName -> El nombre de la tabla 
    //parametros de salida          : Se retorna el resultado de la consulta ejecutada en un arreglo de nombres.
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion             : 18 Junio 2012
    //historico de modificaciones   :
    //RESUMEN                       : retorna un listado con todas las columnas y tipo de dato de la tabla.
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function tipoColumnadeTabla($tableName)
    {
        $this->realizarConsulta("SELECT column_name, udt_name FROM information_schema.columns WHERE table_name = '$tableName'");
        if($this->resultado != null) {
            for ($i = 0; $i < $this->totalItems; $i++) {
               $array[$i] = @pg_fetch_assoc($this->resultado, $i);
               $arrType[$array[$i]['column_name']]= $array[$i]['udt_name'];
            }
        }
        return $arrType;
    }    
    
  } 
  
?>