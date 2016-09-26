<?php
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../'));
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../../'));     
// include the Zebra_Form class
$casoUso = 'provincia';
require 'Zebra_Form.php';
include_once("utiles/utils.class.php");       
include_once("idioma/pt.php");
include_once("controladores/provincia.class.php");   
include_once("controladores/municipio.class.php"); 
 /*
$objProvincia = new Provincias();
$arrProvincia = explode(',', 'Bengo,Benguela,Bié,Cabinda,Cuando Cubango,Kwanza-Norte,Kwanza-Sul,Cunene,Huambo,Huíla,Luanda,Lunda-Norte,Lunda-Sul,Malanje,Moxico,Namibe,Uíge,Zaire');
for($i=0; $i<count($arrProvincia);$i++) {
    $str = array($arrProvincia[$i]);  
    $objProvincia->insertRecord($str);    
} */

$objMunicipio = new Municipios();
/*     
//Bengo
$arrMunicipio = explode(',', 'Caxito,Ambriz,Bula Atumba,Dande,Dembos,Nambuangongo,Pango Aluquém');
for($i=0; $i<count($arrMunicipio);$i++) {
    $str = array(1, $arrMunicipio[$i]);  
    $objMunicipio->insertRecord($str);    
}
//Benguela
$arrMunicipio = explode(',', 'Balombo,Baía Farta,Benguela,Bocoio,Caimbambo,Chongoroi,Cubal,Ganda,Lobito');
for($i=0; $i<count($arrMunicipio);$i++) {
    $str = array(2, $arrMunicipio[$i]);  
    $objMunicipio->insertRecord($str);    
}
//Bié
$arrMunicipio = explode(',', 'Andulo,Camacupa,Catabola,Chinguar,Chitembo,Cuemba,Cunhinga,Kuito,Nharea');
for($i=0; $i<count($arrMunicipio);$i++) {
    $str = array(3, $arrMunicipio[$i]);  
    $objMunicipio->insertRecord($str);    
}
//Cabinda
$arrMunicipio = explode(',', 'Belize,Buco-Zau,Cabinda,Cacongo');
for($i=0; $i<count($arrMunicipio);$i++) {
    $str = array(4, $arrMunicipio[$i]);  
    $objMunicipio->insertRecord($str);    
}
//Cuando Cubango
$arrMunicipio = explode(',', 'Calai,Cuangar,Cuchi,Cuito Cuanavale,Dirico,Mavinga,Menongue,Nancova,Rivungo');
for($i=0; $i<count($arrMunicipio);$i++) {
    $str = array(5, $arrMunicipio[$i]);  
    $objMunicipio->insertRecord($str);    
}
//Kwanza-Norte
$arrMunicipio = explode(',', 'Ndalatando,Ambaca,Banga,Bolongongo,Cambambe,Cazengo,Golungo Alto,Gonguembo,Lucala,Quiculungo,Samba Caju');
for($i=0; $i<count($arrMunicipio);$i++) {
    $str = array(6, $arrMunicipio[$i]);  
    $objMunicipio->insertRecord($str);    
}
//Kwanza-Sul
$arrMunicipio = explode(',', 'Amboim,Cassongue,Conda,Ebo,Libolo,Mussende,Porto Amboim,Quibala,Quilenda,Seles,Sumbe,Waku Kungo');
for($i=0; $i<count($arrMunicipio);$i++) {
    $str = array(7, $arrMunicipio[$i]);  
    $objMunicipio->insertRecord($str);    
}
//Cunene
$arrMunicipio = explode(',', 'Ondjiva,Cahama,Cuanhama,Curoca,Cuvelai,Namacunde,Ombadja');
for($i=0; $i<count($arrMunicipio);$i++) {
    $str = array(8, $arrMunicipio[$i]);  
    $objMunicipio->insertRecord($str);    
}
//Huambo
$arrMunicipio = explode(',', 'Bailundo,Catchiungo,Caála,Ekunha,Huambo,Londuimbale,Longonjo,Mungo,Tchicala-Tcholoanga,Tchindjenje,Ucuma');
for($i=0; $i<count($arrMunicipio);$i++) {
    $str = array(9, $arrMunicipio[$i]);  
    $objMunicipio->insertRecord($str);    
}
//Huíla
$arrMunicipio = explode(',', 'Caconda,Caluquembe,Chiange,Chibia,Chicomba,Chipindo,Cuvango,Humpata,Jamba,Lubango,Matala,Quilengues,Quipungo');
for($i=0; $i<count($arrMunicipio);$i++) {
    $str = array(10, $arrMunicipio[$i]);  
    $objMunicipio->insertRecord($str);    
}
//Luanda
$arrMunicipio = explode(',', 'Belas,Cacuaco,Cazenga,Ícolo e Bengo,Luanda,Quiçama,Viana');
for($i=0; $i<count($arrMunicipio);$i++) {
    $str = array(11, $arrMunicipio[$i]);  
    $objMunicipio->insertRecord($str);    
}
//Lunda-Norte
$arrMunicipio = explode(',', 'Cambulo,Capenda-Camulemba,Caungula,Chitato,Cuango,Cuílo,Lubalo,Lucapa,Xá-Muteba');
for($i=0; $i<count($arrMunicipio);$i++) {
    $str = array(12, $arrMunicipio[$i]);  
    $objMunicipio->insertRecord($str);    
}
//Lunda-Sul
$arrMunicipio = explode(',', 'Cacolo, Dala, Muconda, Saurimo');
for($i=0; $i<count($arrMunicipio);$i++) {
    $str = array(13, $arrMunicipio[$i]);  
    $objMunicipio->insertRecord($str);    
}
//Malanje
$arrMunicipio = explode(',', 'Cacuso,Calandula,Cambundi-Catembo,Cangandala,Caombo,Cuaba Nzogo,Cunda-Dia-Baze,Luquembo,Malanje,Marimba,Massango,Mucari,Quela,Quirima');
for($i=0; $i<count($arrMunicipio);$i++) {
    $str = array(14, $arrMunicipio[$i]);  
    $objMunicipio->insertRecord($str);    
}
//Moxico
$arrMunicipio = explode(',', 'Luena,Alto Zambeze,Bundas,Camanongue,Léua,Luau,Luacano,Luchazes,Lumeje,Moxico');
for($i=0; $i<count($arrMunicipio);$i++) {
    $str = array(15, $arrMunicipio[$i]);  
    $objMunicipio->insertRecord($str);    
}
//Namibe
$arrMunicipio = explode(',', 'Bibala,Camucuio,Namibe,Tômbua,Virei');
for($i=0; $i<count($arrMunicipio);$i++) {
    $str = array(16, $arrMunicipio[$i]);  
    $objMunicipio->insertRecord($str);    
}
//Uíge
$arrMunicipio = explode(',', 'Alto Cauale,Ambuíla,Bembe,Buengas,Damba,Macocola,Mucaba,Negage,Puri,Quimbele,Quitexe,Sanza Pombo,Songo,Uíge,Zombo');
for($i=0; $i<count($arrMunicipio);$i++) {
    $str = array(17, $arrMunicipio[$i]);  
    $objMunicipio->insertRecord($str);    
} 
//Zaire
$arrMunicipio = explode(',', 'Cuimba,M\'Banza Kongo,Noqui,N\'Zeto,Soyo,Tomboco');
for($i=1; $i<count($arrMunicipio);$i++) {
    $str = array(18, addslashes($arrMunicipio[$i]));  
    $objMunicipio->insertRecord($str);    
}
*/
?>
