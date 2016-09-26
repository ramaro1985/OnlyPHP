<?php
    set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
    set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
    include_once('utiles/thumb.class.php');

	$src = $_GET['src'];
	$width = $_GET['width'];

	$image = new thumb();
	$image->loadImage($src);
	$image->crop($width, $width);
	$image->show();

?>