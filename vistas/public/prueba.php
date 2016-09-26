<head>
    <style>
     
    /* Z-index of #mask must lower than #boxes .window */
    #mask {
      position:absolute;
      z-index:9000;
      background-color:#000;
      display:none;
    }
     
    #boxes .window {
      position:absolute;
      width:440px;
      height:200px;
      display:none;
      z-index:9999;
      padding:20px;
    }
     
     
    /* Customize your modal window here, you can add background image too */
    #boxes #dialog {
      width:375px;
      height:203px;
    }
    </style>

<link href="vistas/libraries/jquery-ui-1.8.21/css/ui-lightness/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" media="screen">
<script type="text/javascript" language="javascript" src="../vistas/libraries/jquery-ui-1.8.21/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" language="javascript" src="../vistas/libraries/jquery-ui-1.8.21/js/jquery-ui-1.8.21.custom.min.js"></script>


    <script> 
     
    $(document).ready(function() {   
     
        //select all the a tag with name equal to modal 
        $('a[name=modal]').click(function(e) { 
            //Cancel the link behavior 
            e.preventDefault(); 
            //Get the A tag 
            var id = $(this).attr('href'); 
         
            //Get the screen height and width 
            var maskHeight = $(document).height(); 
            var maskWidth = $(window).width(); 
         
            //Set height and width to mask to fill up the whole screen 
            $('#mask').css({'width':maskWidth,'height':maskHeight}); 
             
            //transition effect       
            $('#mask').fadeIn(1000);     
            $('#mask').fadeTo("slow",0.8);   
         
            //Get the window height and width 
            var winH = $(window).height(); 
            var winW = $(window).width(); 
                   
            //Set the popup window to center 
            $(id).css('top',  winH/2-$(id).height()/2); 
            $(id).css('left', winW/2-$(id).width()/2); 
         
            //transition effect 
            $(id).fadeIn(2000);   
         
        }); 
         
        //if close button is clicked 
        $('.window .close').click(function (e) { 
            //Cancel the link behavior 
            e.preventDefault(); 
            $('#mask, .window').hide(); 
        });       
         
        //if mask is clicked 
        $('#mask').click(function () { 
            $(this).hide(); 
            $('.window').hide(); 
        });           
         
    }); 
     
    </script>


</head>


    <!-- #dialog es el id de un DIV definido en el código que está a continuación -->
        <a href="#dialog" name="modal">Simple Modal Window</a>
     
        <div id="boxes">
     
        <!-- #Aqui personalizas tu ventana modal -->
     
        <div id="dialog" class="window">
        <b>Testeo de la Modal Window</b> |
     
        <!-- el botón close está definido como clase close<a href="#" class="close">Close it</a>
     
        </div>
     
        <!-- No elimines el div#mask, porque lo necesitarás para rellenar la pantalla -->
        <div id="mask"></div>
        </div>

