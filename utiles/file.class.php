<?php
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //nombre                        : File
    //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
    //fecha    creacion           : 30 Julio 2012
    //historico de modificaciones :
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //RESUMEN
    /*
        Clase para manejar la session de usuario.
    */ 
    set_include_path(get_include_path().PATH_SEPARATOR.realpath('../../'));
    set_include_path(get_include_path().PATH_SEPARATOR.realpath('../../../'));     
    include_once("configuracion/configuracion.php");  
    
    class Files
    {
        var $sourcePath;                    //Camino donde provienen el fichero
        var $destinationPath;               //Camino donde se almacenaran el fichero
        var $arrSourceFiles = array();      //arreglo con los datos de los ficheros que vienen por el POST o GET
        var $fileNameHDD;                   //Nombre del fichero en el HDD
        var $fileNameBD;                    //Nombre del fichero en la BD
        var $defauldPath;                   //Camino de la carpeta raiz donde se almacenan los ficheros
        
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //nombre                        : __construct(Constructor por defecto)
        //parametros de entrada         : $arrSourceFiles -->  arreglo con los datos de los ficheros que vienen por el POST o GET
        //parametros de salida          : n/e
        //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
         //fecha    creacion            : 30 Julio 2012
         //historico de modificaciones  :
         ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
        function __construct() 
        {
           //inicializar variables de sesion 
           $this->defauldPath  = '../'. CAMINO_DOC_ADJUNTOS;
          
           $this->createFolder( $this->defauldPath );

	    }
        
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //nombre                        : createFolder
        //parametros de entrada         : folderName --> Nombre de la carpeta a crear
        //parametros de salida          : true o flase
        //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
        //fecha    creacion            : 30 Julio 2012
        //historico de modificaciones  :
        //RESUMEN                       : Se actualizan las variable de session con los datos de los atributos de la clase
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
         
        function createFolder( $folderName ) 
        { 
              if (!file_exists( $folderName )) {
                return mkdir( $folderName ); 
              } else { 
                  return true; 
              }
        }
        
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //nombre                        : uploadFile
        //parametros de entrada         : arrFile --> Arreglo con los datos del fichero a temporal
        //                              : $fileName --> Nombre para el fichero
        //parametros de salida          : true o flase
        //autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
        //fecha    creacion            : 30 Julio 2012
        //historico de modificaciones  :
        //RESUMEN                       : Se actualizan las variable de session con los datos de los atributos de la clase
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
         
        function uploadFile( $arrFile, $fileName='') 
        { 
              if ( $fileName == '' ) { $fileName = basename($arrFile['userfile']['name']); }
              if (is_array( $arrFile )) {
                move_uploaded_file($arrFile['userfile']['tmp_name'], $fileName);
                return true;
              } else { 
                  return false; 
              }
        }

       
    }
?>