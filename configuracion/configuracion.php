<?php
  //Ejemplo http://<servidor>:<puerto>/PREFIJO_SITIO
  @define('PROTOCOLO','http:');
  @define('SERVIDOR','localhost');
  @define('PREFIJO','Elecciones');  
  
  //Para el acceso a BD
  //@define('DRIVER_BD','postgres');    /*postgres, mysql, mssql, oracle*/
  //@define('NOMBRE_BD','mpla'); 
  //@define('PUERTO_BD','5433'); 
  //@define('USUARIO_BD','mpla'); 
  //@define('CLAVE_BD','#mpl4-'); 
  
    //Para el acceso a BD
  @define('DRIVER_BD','postgres');    /*postgres, mysql, mssql, oracle*/
  @define('NOMBRE_BD','mpla_internet'); 
  @define('PUERTO_BD','5432'); 
  @define('USUARIO_BD','postgres'); 
  @define('CLAVE_BD','p*stgr3s'); 

  @define('APPLICATION_NAME','Elecciones MPLA...');
  @define('HTML_CHARSET','UTF-8'); //UTF-8, iso-8859-1  
  @define('LENGUAJE','pt');
  @define('TIEMPO_SESION','1600'); 
  @define('ERROR_LOG_SYSTEM', FALSE );
 
  //variables de presentacion para elementos en los listados y formularios
  @define('TIEMPO_SPLASH','3000'); 
  @define('CAMINO_IMAGENES', 'imagenes');
  @define('CAMINO_DOC_ADJUNTOS', 'ficheros');
  @define('FILAS_POR_PAGINA', 25);
  @define('FILA_TIPO_ORDEN', 'ASC');
  @define('ETIQUETA_INDEFINIDA', 'INDEFINIDA');  
  
  //Correo SMTP
  @define('SEGURO_SMTP', '' );//(puede tomar 3 valores "", "ssl", "tls")
  @define('SERVIDOR_SMTP', '10.14.0.25' );
  @define('USUARIO_SMTP', 'badillo' );
  @define('CLAVE_SMTP', '' );
  @define('CORREO_POR_DEFECTO_SMTP', 'badillo@imbondex.net' );    
 
  //definiendo las variables de acceso al directorio activo
  @define('SERVIDOR_LDAP','192.168.20.12');
  @define('PUERTO_LDAP','389'); //por defecto 389
  @define('DOMINIO','@antex.co.ao');
?>