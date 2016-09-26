<script>
    $.fx.speeds._default = 1000;
    $(function() {
        $( "#dialog" ).dialog({
            autoOpen: false,
            show: "resizable",
            hide:"explode",
            autoHeight:true,
            width:1024,
            modal:true,
            position:  ['center','top']
            // position:"center"
            
        });
        $( "#1" ).click(function(response) {
            var id = document.getElementById('1').name;
            var toLoad= 'public/datos_provincia.php?id='+ id ;
            $.post(toLoad,function (responseText){
               
                $( "#dialog" ).dialog({title:'Resumo da Provincia do Bengo'});
                $( "#dialog" ).dialog( "open" ).html(responseText);
                return false;
            
            });
            
        });
        $( "#2" ).click(function(response) {
            var id = document.getElementById('2').name;
           
            var toLoad= 'public/datos_provincia.php?id='+ id ;
            $.post(toLoad,function (responseText){
                
                $( "#dialog" ).dialog({title:'Resumo da Província de Benguela'});
                $( "#dialog" ).dialog( "open" ).html(responseText);
                return false;
            
            });
            
        });
        $( "#3" ).click(function(response) {
            var id = document.getElementById('3').name;
           
            var toLoad= 'public/datos_provincia.php?id='+ id ;
            $.post(toLoad,function (responseText){
                
                $( "#dialog" ).dialog({title:'Resumo da Província do Bíe'});
                $( "#dialog" ).dialog( "open" ).html(responseText);
                return false;
            
            });
            
        });
        
        $( "#4" ).click(function(response) {
            var id = document.getElementById('4').name;
           
            var toLoad= 'public/datos_provincia.php?id='+ id ;
            $.post(toLoad,function (responseText){
                
                $( "#dialog" ).dialog({title:'Resumo da Província de Cabinda'});
                $( "#dialog" ).dialog( "open" ).html(responseText);
                return false;
            
            });
            
        });
        $( "#5" ).click(function(response) {
            var id = document.getElementById('5').name;
           
            var toLoad= 'public/datos_provincia.php?id='+ id ;
            $.post(toLoad,function (responseText){
                
                $( "#dialog" ).dialog({title:'Resumo da Província do Cuando Cubango'});
                $( "#dialog" ).dialog( "open" ).html(responseText);
                return false;
            
            });
            
        });
        $( "#6" ).click(function(response) {
            var id = document.getElementById('6').name;
           
            var toLoad= 'public/datos_provincia.php?id='+ id ;
            $.post(toLoad,function (responseText){
                
                $( "#dialog" ).dialog({title:'Resumo da Província do Kwanza Norte'});
                $( "#dialog" ).dialog( "open" ).html(responseText);
                return false;
            
            });
            
        });
        $( "#7" ).click(function(response) {
            var id = document.getElementById('7').name;
           
            var toLoad= 'public/datos_provincia.php?id='+ id ;
            $.post(toLoad,function (responseText){
                
                $( "#dialog" ).dialog({title:'Resumo da Província do Kwanza Sul'});
                $( "#dialog" ).dialog( "open" ).html(responseText);
                return false;
            
            });
            
        });
        $( "#8" ).click(function(response) {
            var id = document.getElementById('8').name;
           
            var toLoad= 'public/datos_provincia.php?id='+ id ;
            $.post(toLoad,function (responseText){
                
                $( "#dialog" ).dialog({title:'Resumo da Província do Cunene'});
                $( "#dialog" ).dialog( "open" ).html(responseText);
                return false;
            
            });
            
            
        });
        $( "#9" ).click(function(response) {
            var id = document.getElementById('9').name;
           
            var toLoad= 'public/datos_provincia.php?id='+ id ;
            $.post(toLoad,function (responseText){
                
                $( "#dialog" ).dialog({title:'Resumo da Província do Huambo'});
                $( "#dialog" ).dialog( "open" ).html(responseText);
                return false;
            
            });
            
        });
        $( "#10" ).click(function(response) {
            var id = document.getElementById('10').name;
           
            var toLoad= 'public/datos_provincia.php?id='+ id ;
            $.post(toLoad,function (responseText){
                
                $( "#dialog" ).dialog({title:'Resumo da Província da Huíla'});
                $( "#dialog" ).dialog( "open" ).html(responseText);
                return false;
            
            });
            
        });
        $( "#11" ).click(function(response) {
            var id = document.getElementById('11').name;
           
            var toLoad= 'public/datos_provincia.php?id='+ id ;
            $.post(toLoad,function (responseText){
                
                $( "#dialog" ).dialog({title:'Resumo da Província de Luanda'});
                $( "#dialog" ).dialog( "open" ).html(responseText);
                return false;
            
            });
            
        });
        $( "#12" ).click(function(response) {
            var id = document.getElementById('12').name;
           
            var toLoad= 'public/datos_provincia.php?id='+ id ;
            $.post(toLoad,function (responseText){
                
                $( "#dialog" ).dialog({title:'Resumo da Província da Lunda Norte'});
                $( "#dialog" ).dialog( "open" ).html(responseText);
                return false;
            
            });
            
        });
        $( "#13" ).click(function(response) {
            var id = document.getElementById('13').name;
           
            var toLoad= 'public/datos_provincia.php?id='+ id ;
            $.post(toLoad,function (responseText){
                
                $( "#dialog" ).dialog({title:'Resumo da Província da Lunda Sul'});
                $( "#dialog" ).dialog( "open" ).html(responseText);
                return false;
            
            });
            
        });
        $( "#14" ).click(function(response) {
            var id = document.getElementById('14').name;
           
            var toLoad= 'public/datos_provincia.php?id='+ id ;
            $.post(toLoad,function (responseText){
                
                $( "#dialog" ).dialog({title:'Resumo da Província de Malanje'});
                $( "#dialog" ).dialog( "open" ).html(responseText);
                return false;
            
            });
            
        });
        $( "#15" ).click(function(response) {
            var id = document.getElementById('15').name;
           
            var toLoad= 'public/datos_provincia.php?id='+ id ;
            $.post(toLoad,function (responseText){
                
                $( "#dialog" ).dialog({title:'Resumo da Província do Moxico'});
                $( "#dialog" ).dialog( "open" ).html(responseText);
                return false;
            
            });
            
        });
        $( "#16" ).click(function(response) {
            var id = document.getElementById('16').name;
           
            var toLoad= 'public/datos_provincia.php?id='+ id ;
            $.post(toLoad,function (responseText){
                
                $( "#dialog" ).dialog({title:'Resumo da Província do Namibe'});
                $( "#dialog" ).dialog( "open" ).html(responseText);
                return false;
            
            });
            
        });
        $( "#17" ).click(function(response) {
            var id = document.getElementById('17').name;
           
            var toLoad= 'public/datos_provincia.php?id='+ id ;
            $.post(toLoad,function (responseText){
                
                $( "#dialog" ).dialog({title:'Resumo da Província do Uíge'});
                $( "#dialog" ).dialog( "open" ).html(responseText);
                return false;
            
            });
            
        });
        $( "#18" ).click(function(response) {
            var id = document.getElementById('18').name;
           
            var toLoad= 'public/datos_provincia.php?id='+ id ;
            $.post(toLoad,function (responseText){
                
                $( "#dialog" ).dialog({title:'Resumo da Província do Zaire'});
                $( "#dialog" ).dialog( "open" ).html(responseText);
                return false;
            
            });
            
        });
    }); 
</script>
<div id="dialog">
    <style type="text/css" ></style>
</div>
<div style="background-image:url('public/imagenes/angola-map_1.jpg'); height: 105%;  width:100%;float:left; background-repeat: no-repeat">
    <div style="top: 5px;left: 15px;"><image src="../vistas/public/imagenes/flag_roja_1.png" title="Cabinda" id="4" name="4">Cabinda</div> 
    <div style="top: 35px;margin-left:65px;"><image src="../vistas/public/imagenes/flag_roja_1.png" title="Zaire" id="18" name="18">Zaire</div>
    <div style="top: 40px;margin-left:145px;"><image src="../vistas/public/imagenes/flag_roja_1.png" title="Uige" id="17" name="17">Uige</div>
    <div style="top: 35px;margin-left:60px;">Bengo<image src="../vistas/public/imagenes/flag_roja_1.png" title="Bengo" id="1" name="1"></div>
    <div style="top: 40px;margin-left: 30px;">Luanda<image src="../vistas/public/imagenes/flag_roja_1.png" title="Luanda" id="11" name="11"></div>
    <div style="top: -10px;margin-left:150px;"><image src="../vistas/public/imagenes/flag_roja_1.png" title="Cuanza Norte" id="6" name="6">Kuanza Norte</div>
    <div style="top:40px; margin-left:100px;">Kuanza Sul<image src="../vistas/public/imagenes/flag_roja_1.png" title="Cuanza Sul" id="7" name="7"></div>
    <div style="top:-45px; margin-left:250px">Malanje<image src="../vistas/public/imagenes/flag_roja_1.png" title="Malanje" id="14" name="14"></div>
    <div style="margin-top: -125px; margin-left:375px"><image src="../vistas/public/imagenes/flag_roja_1.png" title="Lunda Norte" id="12" name="12" >Lunda Norte</div>
    <div style="margin-top:20px; margin-left:450px"><image src="../vistas/public/imagenes/flag_roja_1.png" title="Lunda Sul" id="13" name="13">Lunda Sul</div>
    <div style="top:140px; margin-left:450px">Moxico<image src="../vistas/public/imagenes/flag_roja_1.png" title="Moxico" id="15" name="15"></div>
    <div style="margin-top:-15px; margin-left:140px">Huambo<image src="../vistas/public/imagenes/flag_roja_1.png" title="Huambo" id="9" name="9"></div>
    <div style="margin-top:-15px;margin-left:55px;">Benguela<image src="../vistas/public/imagenes/flag_roja_1.png" title="Benguela" id="2" name="2"></div>
    <div style="margin-top:-50px; margin-left:270px">Bié<image src="../vistas/public/imagenes/flag_roja_1.png" title="Bié" id="3" name="3"></div>
    <div style="margin-top:75px; margin-left:320px;"><image src="../vistas/public/imagenes/flag_roja_1.png" title="Kuando Kubango" id="5" name="5">Kuando Kubango</div>
    <div style="margin-top:60px; margin-left:185px;">Cunene<image src="../vistas/public/imagenes/flag_roja_1.png" title="Cunene" id="8" name="8"></div>
    <div style="margin-top:-120px ; margin-left:100px;">Huila<image src="../vistas/public/imagenes/flag_roja_1.png" title="Huila" id="10" name="10"></div>
    <div style="margin-top:-5px; margin-left:-5px;">Namibe<image src="../vistas/public/imagenes/flag_roja_1.png" title="Namibe" id="16" name="16"></div>
</div>
<br>
