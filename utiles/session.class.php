<?php
    
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : Session
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion           : 10 Junio 2012
    //historico de modificaciones :
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //RESUMEN
    /*
        Clase para manejar la session de usuario.
    */ 
    set_include_path(get_include_path().PATH_SEPARATOR.realpath('../../'));
    set_include_path(get_include_path().PATH_SEPARATOR.realpath('../../../'));     
    include_once("configuracion/configuracion.php");  
    
    class Session 
    {
        var $idusuario;             //Identificador del usuario
        var $nombreCompletoUsuario; //Nombre completo del usuario logueado
        var $usuario;               //Login o identificador de nombre en el sistema
        var $logeado;               //Si esta logueado en el sistema
        var $t_expirar;             //Tiempo en que expira la session
        var $hora_inicio;           //Tiempo en el que inicio la session
        var $idioma;                //Idioma activo
        var $ididioma;              //Identificador del idioma activo
        var $idgrupo;               //Identificador del grupo al que pertenece
        var $arrFiltro;             //Arreglo de con los accesos por el usuario.
        var $where;                 //Cadena equivalente a un filtro realizado por una busqueda.
        var $arrAcceso;             //Arreglo de con los accesos por el usuario.

        
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //nombre                        : __construct(Constructor por defecto)
        //parametros de entrada         : n/e
        //parametros de salida          : n/e
        //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
         //fecha    creacion            : 10 Junio 2012
         //historico de modificaciones  :
         ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
        function __construct() 
        {
           global $Config; //se incluye la clase que maneja la configuracion...
           //se crea la sesion            
           session_name('suite_mpla');
           @session_start();  
           //inicializar variables de sesion 
           (isset($_SESSION['idusuario']))              ? $this->idusuario              = $_SESSION['idusuario']                : $_SESSION['idusuario'] = NULL ;
           (isset($_SESSION['nombreCompletoUsuario']))  ? $this->nombreCompletoUsuario  = $_SESSION['nombreCompletoUsuario']    : $_SESSION['nombreCompletoUsuario'] = NULL ;
           (isset($_SESSION['usuario']))                ? $this->usuario                = $_SESSION['usuario']                  : $_SESSION['usuario'] = NULL ;
           (isset($_SESSION['logeado']))                ? $this->logeado                = $_SESSION['logeado']                  : $_SESSION['logeado'] = false;
           $this->t_expirar                                                             = $_SESSION['t_expirar'] = TIEMPO_SESION;
           (isset($_SESSION['hora_inicio']))            ? $this->hora_inicio            = $_SESSION['hora_inicio']                 : $_SESSION['s_tiempo'] = time();
           (isset($_SESSION['lenguaje']))               ? $this->idioma                 = $_SESSION['idioma']                   : $_SESSION['idioma'] = "es" ;
           (isset($_SESSION['ididioma']))               ? $this->ididioma               = $_SESSION['ididioma']                 : $_SESSION['idlenguaje'] = NULL ;
           (isset($_SESSION['idgrupo']))                ? $this->idgrupo                = $_SESSION['idgrupo']                  : $_SESSION['idgrupo'] = array() ;
           (isset($_SESSION['arrAcceso']))              ? $this->arrAcceso              = $_SESSION['arrAcceso']                : $_SESSION['arrAcceso'] = array() ;           
           (isset($_SESSION['arrFiltro']))              ? $this->arrFiltro              = $_SESSION['arrFiltro']                : $_SESSION['arrFiltro'] = NULL ;                      
           (isset($_SESSION['where']))                  ? $this->where                  = $_SESSION['where']                    : $_SESSION['where'] = array();
	}
        
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //nombre                        : actualizar
        //parametros de entrada         : n/e
        //parametros de salida          : n/e
        //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
         //fecha    creacion            : 10 Junio 2012
         //historico de modificaciones  :
         //RESUMEN                       : Se actualizan las variable de session con los datos de los atributos de la clase
         ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
         
        function actualizar() 
        { 
           $_SESSION['idusuario']               = $this->idusuario;
           $_SESSION['nombreCompletoUsuario']   = $this->nombreCompletoUsuario;
           $_SESSION['usuario']                 = $this->usuario; 
           $_SESSION['logeado']                 = $this->logeado;
           $_SESSION['t_expirar']               = TIEMPO_SESION; 
           $_SESSION['hora_inicio']             = $this->hora_inicio;
           $_SESSION['idioma']                  = $this->idioma; 
           $_SESSION['ididioma']                = $this->ididioma;
           $_SESSION['idgrupo']                 = $this->idgrupo;
           $_SESSION['arrAcceso']               = $this->arrAcceso;
           $_SESSION['arrFiltro']               = $this->arrFiltro;
           $_SESSION['where']                   = $this->where;
        }
        
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //nombre                        : reiniciar
        //parametros de entrada         : n/e
        //parametros de salida          : n/e
        //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
        //fecha    creacion            : 10 Junio 2012
        //historico de modificaciones  :
        //RESUMEN                       : Se reinicia las variable de session con los datos de session nula
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
         
        function reiniciar()
        {
           $_SESSION['idusuario']               = NULL;
           $_SESSION['nombreCompletoUsuario']   = NULL;
           $_SESSION['usuario']                 = NULL; 
           $_SESSION['logeado']                 = false;
           $_SESSION['t_expirar']               = $this->t_expirar; 
           $_SESSION['hora_inicio']             = $this->hora_inicio = time();
           $_SESSION['idioma']                  = $this->idioma; 
           $_SESSION['ididioma']                = $this->ididioma;
           $_SESSION['idgrupo']                 = NULL;
           $_SESSION['arrAcceso']               = array();
           $_SESSION['arrFiltro']               = array();
           $_SESSION['where']                   = array();             
        }
        
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //nombre                        : estadoUsuarioLogeado
        //parametros de entrada         : n/e
        //parametros de salida          : Devuelve el estado en que se encuentra en usuario ( logeado o no )
        //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
        //fecha    creacion             : 10 Junio 2012
        //historico de modificaciones   :
        //RESUMEN                       : //
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
        function estadoUsuarioLogeado() 
        {
            return $this->logeado;   
        }
            
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //nombre                        : expirada
        //parametros de entrada         : n/e
        //parametros de salida          : Devuelve si la session ha expirado ( valor boolean ).
        //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
        //fecha    creacion             : 10 Junio 2012
        //historico de modificaciones   :
        //RESUMEN                       : //
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
         function expirada() 
        {
           $retval = false;
           $diff_time = time() - $this->hora_inicio;
           if($diff_time > $this->t_expirar)
            $retval = true;
           return $retval;  
        }
        
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //nombre                        : actualizarTiempoSesion
        //parametros de entrada         : n/e
        //parametros de salida          : n/e
        //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
        //fecha    creacion            : 10 Junio 2012
        //historico de modificaciones  :
        //RESUMEN                       : Actualiza el tiempo de session para el usuario logeado.
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////    
         function actualizarTiempoSesion() 
        {
            $_SESSION['hora_inicio'] = $this->hora_inicio = time(); 
        }
        
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //nombre                        : cerrar
        //parametros de entrada         : n/e
        //parametros de salida          : n/e
        //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
        //fecha    creacion            : 10 Junio 2012
        //historico de modificaciones  :
        //RESUMEN                       : Destruye la session .
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
            
        function cerrar() 
        {
           session_destroy();  
        }
        
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //nombre                        : registrarVariable
        //parametros de entrada         : 
        // $pVarName : nombre de la variable
        // $pValue   : valor  de la variable
        //parametros de salida          : n/e
        //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
        //fecha    creacion            : 10 Junio 2012
        //historico de modificaciones  :
        //RESUMEN                       : Ingresa una nueva variable la session .
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
            
        function registrarVariable($pVarName, $pValue) 
        {
           $_SESSION[$pVarName] = $pValue;   
        }
        
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //nombre                        : eliminarVariable
        //parametros de entrada         : 
        // $pVarName : nombre de la variable
        //parametros de salida          : n/e
        //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
        //fecha    creacion            : 10 Junio 2012
        //historico de modificaciones  :
        //RESUMEN                       : Elimina una variable de session .
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////     
        function eliminarVariable($pVarName) 
        {
           unset($_SESSION[$pVarName]);   
        }
        
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //nombre                        : variableDefinida
        //parametros de entrada         : 
        // $pVarName : nombre de la variable
        //parametros de salida          : n/e
        //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
        //fecha    creacion             : 10 Junio 2012
        //historico de modificaciones   :
        //RESUMEN                       : Comprueba si existe una variable en session .
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////     
        function variableDefinida($pVarName) 
        {
            $retval = false;
            if(isset($_SESSION[$pVarName]))
                $retval = true;
            return $retval;  
        }
        
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //nombre                        : obtenerVariable
        //parametros de entrada         : 
        // $pVarName : nombre de la variable
        //parametros de salida          : valor de variable en session
        //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
        //fecha    creacion             : 10 Junio 2012
        //historico de modificaciones   :
        //RESUMEN                       : Obtiene si existe el valor de una variable en session .
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////     
        function obtenerVariable($pVarName) 
        {
            $retval = NULL;
            ($this->variableDefinida($pVarName)) ? $retval = $_SESSION[$pVarName] : $retval = NULL;
            return $retval;                
        }
       
    }
?>