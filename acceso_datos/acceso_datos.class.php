<?php
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : Acceso_datos
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creaci?n             : 08 Junio 2012
    //hist?rico de modificaciones   :                                           
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //RESUMEN
    /*
        Clase abstracta para manejar el acceso a los datos en la base de datos. A partir de esta clase heredar?n las clases
        espec?ficas para cada uno de los gestores de base de datos soportados. Con esta clase se obliga a que todas 
        las clases que hereden de la misma, tengan que implementar o por lo menos definir cada uno de los m?todos que 
        en ella se declaran
    */

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  abstract class Acceso_datos
  {                  
      
    protected $servidor;
    protected $puerto;
    protected $usuario;
    protected $contrasena;
    protected $base_datos;
    protected $id_conexion;
    protected $resultado;
    
    protected $limit;
    protected $offset;
    protected $totalItems;
    protected $sqlQuery;    
    
    //Definiendo los m?todos set y get de los atributos de la clase. Se definen los gets para cada atributo y solamente el
    //set para el atributo id_conexion con el objetivo de verificar si se asigna realmente una conexi?n realizada 
        
    public function setIdConexion($aid_conexion)
    { 
        if($aid_conexion != FALSE)
            $this->id_conexion = $aid_conexion; 
    }                                                                           
    
    public function getServidor(){ return $this->servidor; }
    public function getPuerto(){ return $this->puerto; }
    public function getUsuario(){ return $this->usuario; }
    public function getContrasena(){ return $this->contrasena; }    
    public function getBaseDatos(){ return $this->base_datos; }
    public function getIdConexion(){ return $this->id_conexion; }
    public function getResultado(){ return $this->resultado; }
    //**** Nuevos elementos para la utilización del paginado
    public function getLimit(){ return $this->limit; }
    public function getOffset(){ return $this->offset; }
    public function getTotalItems(){ return $this->totalItems; }            
    public function getSqlQuery(){ return $this->sqlQuery; }    
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : abrirConexion
    //par?metros de entrada         : No se hace uso de par?metros de entrada
    //par?metros de salida          : Se retorna el identificador de la conexi?n realizada
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creaci?n             : 08 Junio 2012
    //hist?rico de modificaciones   :
    //RESUMEN                       : M?todo abstracto para establecer la conexi?n con el servidor de base de datos
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
    abstract public function abrirConexion();
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : cerrarConexion
    //par?metros de entrada         : No se hace uso de par?metros de entrada
    //par?metros de salida          : Se retorna true o false, en dependencia de si se cierra la conexi?n o no
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creaci?n             : 08 Junio 2012
    //hist?rico de modificaciones   :
    //RESUMEN                       : M?todo abstracto para cerrar la conexi?n con el servidor de base de datos
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
    abstract public function cerrarConexion();
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : realizarConsulta
    //par?metros de entrada         : $query => Cadena sql a ejecutar en el gestor de base de datos
    //par?metros de salida          : Para las sentencias SELECT se devuelve un recurso en caso exitoso y FALSE en error
    //                                Para otro tipo de sentencia SQL, UPDATE, DELETE, DROP, etc, 
    //                                regresa TRUE en caso exitoso y FALSE en error.
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creaci?n             : 08 Junio 2012
    //hist?rico de modificaciones   :
    //RESUMEN                       : M?todo abstracto para enviar una consulta sql al servidor de base de datos para que la ejecute
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    abstract public function realizarConsulta($query);
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : cantidadElementos
    //par?metros de entrada         : No se hace uso de par?metros de entrada
    //par?metros de salida          : Se retorna el n?mero de filas que devuelve una consulta de selecci?n ejecutada
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creaci?n             : 08 Junio 2012
    //hist?rico de modificaciones   :
    //RESUMEN                       : M?todo abstracto para devolver la cantidad de tuplas obtenidas en una consulta
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    abstract public function cantidadElementos();
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : crearArregloObjetos
    //par?metros de entrada         : No se hace uso de par?metros de entrada
    //par?metros de salida          : Se retorna un arreglo de objetos a partir del resultado obtenido en una consulta de
    //                                selecci?n
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creaci?n             : 08 Junio 2012
    //hist?rico de modificaciones   :
    //RESUMEN                       : M?todo abstracto para crear y retornar un arreglo de objetos por cada tupla obtenida en una consulta
    //                                de selecci?n realizada
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    abstract public function crearArregloObjetos();
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : crearArreglo
    //par?metros de entrada         : No se hace uso de par?metros de entrada
    //par?metros de salida          : Se retorna un arreglo por cada fila a partir del resultado obtenido en una consulta de
    //                                selecci?n
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creaci?n             : 08 Junio 2012
    //hist?rico de modificaciones   :
    //RESUMEN                       : M?todo abstracto para devolver un arreglo para la fila obtenida
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    abstract public function crearArreglo();
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : obtenerCantFilasAfectadas
    //par?metros de entrada         : No se hace uso de par?metros de entrada
    //par?metros de salida          : Se retorna la cantidad de filas afectadas en una consulta
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creaci?n             : 08 Junio 2012
    //hist?rico de modificaciones   :
    //RESUMEN                       : M?todo abstracto para devolver la cantidad de filas afectadas en una consulta ejecutada, select, insert,
    //                                delete, update
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    abstract public function obtenerCantFilasAfectadas();
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : obtenerMaximoId
    //par?metros de entrada         : $tabla => Nombre de la tabla que se va a buscar el m?ximo identificador
    //par?metros de salida          : Se retorna el m?ximo identificador de la tabla
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creaci?n             : 08 Junio 2012
    //hist?rico de modificaciones   :
    //RESUMEN                       : M?todo abstracto para devolver el m?ximo identificador de la tabla especificada
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    abstract public function obtenerMaximoId($tabla);
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : iniciarTransaccion
    //par?metros de entrada         : No se hace uso de par?metros de entrada
    //par?metros de salida          : Se retorna el resultado de la consulta ejecutada
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creaci?n             : 08 Junio 2012
    //RESUMEN                       : M?todo abstracto para iniciar una transacci?n
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    abstract public function iniciarTransaccion($anivel_aislamiento);
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : terminarTransaccion
    //par?metros de entrada         : No se hace uso de par?metros de entrada
    //par?metros de salida          : Se retorna el resultado de la consulta ejecutada
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creaci?n             : 08 Junio 2012
    //hist?rico de modificaciones   :
    //RESUMEN                       : M?todo abstracto para terminar una transacci?n
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    abstract public function terminarTransaccion();
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : deshacerTransaccion
    //par?metros de entrada         : No se hace uso de par?metros de entrada
    //par?metros de salida          : Se retorna el resultado de la consulta ejecutada
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creaci?n             : 08 Junio 2012
    //hist?rico de modificaciones   :
    //RESUMEN                       : M?todo abstracto para deshacer una transacci?n
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    abstract public function deshacerTransaccion();
  }
?>
