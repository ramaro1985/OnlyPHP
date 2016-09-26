// Compara las dos listas de valores por Id y text

function compareOptionValues(a, b) 
{ 

    // Radix 10: Para valores Numericos

    // Radix 36: Para Valores alfanumericos

    var sA = parseInt( a.value, 36 );  

    var sB = parseInt( b.value, 36 );  

    return sA - sB;

}


// Compara las dos listas de valores por Id y text

function compareOptionText(a, b) 
{ 

    // Radix 10: Para valores Numericos

    // Radix 36: Para Valores alfanumericos
    var sA = parseInt( a.text, 36 );  

    var sB = parseInt( b.text, 36 );  

    return sA - sB;

}



// Dual list move function

function moveDualList( srcList, destList, moveAll ) 
{

    // Do nothing if nothing is selected

    if (  ( srcList.selectedIndex == -1 ) && ( moveAll == false )   )

    {

        return;

    }



    newDestList = new Array( destList.options.length );



    var len = 0;



    for( len = 0; len < destList.options.length; len++ ) 

    {

            if ( destList.options[ len ] != null )

            {

                newDestList[ len ] = new Option( destList.options[ len ].text, destList.options[ len ].value, destList.options[ len ].defaultSelected, destList.options[ len ].selected );

            }

        }

    //alert(srcList.value);

    for( var i = 0; i < srcList.options.length; i++ ) 
        
    { 

            if ( srcList.options[i] != null && ( srcList.options[i].selected == true || moveAll ) )

            {

                // Statements to perform if option is selected


                // Incorporate into new list

                newDestList[ len ] = new Option( srcList.options[i].text, srcList.options[i].value, srcList.options[i].defaultSelected, srcList.options[i].selected );
                newDestList[ len ].selected = true;

                len++;

            }

        }



    // Sort out the new destination list

    newDestList.sort( compareOptionValues );   // BY VALUES

    //newDestList.sort( compareOptionText );   // BY TEXT



    // Populate the destination with the items from the new array

    for ( var j = 0; j < newDestList.length; j++ ) 

    {

            if ( newDestList[ j ] != null )

            {

                destList.options[ j ] = newDestList[ j ];

            }

        }



    // Erase source list selected elements

    for( var i = srcList.options.length - 1; i >= 0; i-- ) 

    { 

            if ( srcList.options[i] != null && ( srcList.options[i].selected == true || moveAll ) )

            {

                //Verificar  este segmento cuando tengo que actualizar la lista destino
                // Erase Source

                //srcList.options[i].value = "";

                //srcList.options[i].text  = "";

                srcList.options[i]       = null;

            }

        }



} // End of moveDualList()

function add_element( srcList, destList, moveAll ) 
{
    if( srcList.value != '' ){
        if (  ( srcList.selectedIndex == -1 ) && ( moveAll == false )   )
        {
            return;
        }

        newDestList = new Array( destList.options.length );

        var len = 0;

        for( len = 0; len < destList.options.length; len++ ) 
        {
            if ( destList.options[ len ] != null )
            {
                //newDestList[ len ] = new Option(destList.options[ len ].text, destList.options[ len ].value, destList.options[ len ].defaultSelected, destList.options[ len ].selected );
                newDestList[ len ] = new Option(destList.options[ len ].text);
                 

            }
        }
        // alert(srcList.defaultSelected);
        newDestList[len] = new Option(srcList.value);
        //newDestList[len] = new Option(len,srcList.value,srcList.defaultSelected,srcList.selected);
        //newDestList[len].selected = true;
        
        for ( var j = 0; j < newDestList.length; j++ ) 
        {
            if ( newDestList[ j ] != '' )
            {
                destList.options[ j] = newDestList[ j ];
            }
        }
    }
       

   
//document.getElementById('add_prelectores').setValue();
} 

function remove_element( srcList, destList, moveAll ) 
{

    for( var i = srcList.options.length - 1; i >= 0; i-- ) 

    { 
            if ( srcList.options[i] != null && ( srcList.options[i].selected == true || moveAll ) )
            {
                srcList.options[i]       = null;
            }
        }
} 
function selectedIncluidos(destList) 

{     
    for ( var i = 0; i < destList.length; i++ )
            
        destList.options[i].selected = true;
        
    return true;

} // End of selectedIncluidos()

function addUsuario() 
{     
    var usuario_par = document.getElementById('usuario').value;
    var destList = document.getElementById('incluido');
    var clave = document.getElementById('clave').value;
    var clave_confirm = document.getElementById('clave_confirm').value;
   
    var zona_usuario = document.getElementById('zona_usuario');
    
    if(usuario_par != ''){
        selectedIncluidos(destList); 
        var toLoad= 'public/usuario.php?usuario='+ usuario_par + '&clave=' + clave + '&clave_confirm=' + clave_confirm ;
        $.post(toLoad,function (responseText){
            
            if(responseText=='true'){
                document.getElementById( 'form' ).submit();
            }else{
                $(zona_usuario).html(responseText);
            }
            
           
        });
        //var ok = document.getElementById('ok').value;
        
        return false;
       
    }else{
        selectedIncluidos(destList);
        return true;
        
    }
}

function EscribirValorListaDisponible( ctrl )

{

    var lugar = document.getElementById('RowExplicita');

    lugar.innerHTML = "<strong>" +  ctrl.options[ctrl.selectedIndex].text + "</strong>";

}
function relatoriomun(zon_mun){
    var id_provincia = document.getElementById('id_provincia').value;
    var id_municipio = document.getElementById('id_municipio').value;
    
    var toLoad= 'public/relatoriomun.php?id_provincia='+ id_provincia + '&id_municipio=' + id_municipio;
    $.post(toLoad,function (responseText){
        $('#' + 'zon_mun').html(responseText);
    });
    return false;
    
}

