<?php
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../'));
set_include_path(get_include_path().PATH_SEPARATOR.realpath('../../'));     
include_once("configuracion/configuracion.php");
include_once("utiles/file.class.php");
include_once("utiles/gallery.class.php");

$myFile = new Files();

$pathFile = $myFile->defauldPath. '/'. $_GET['cu'];
if (!$myFile->createFolder($pathFile)) {
    echo 'error';
}
if ($_GET['cu'] != '' ) { 
    $pathFile .= '/'. $_GET['id']; 
    if (!$myFile->createFolder($pathFile)) {
        echo 'error';
    }
}

$fileName = basename($_FILES['userfile']['name']);

if (!$myFile->uploadFile($_FILES, $pathFile.'/'.$fileName)) {
    echo 'error';
} else {
    //Aquí va el codigo para insertar la imagen en la BD
    
    $mygallery = new gallery();
    $mygallery->loadFolder($pathFile);
    $mygallery->show(550, 100, 10);    
}

?>