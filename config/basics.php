<?php

error_reporting(E_ALL);

$top = $_SERVER["DOCUMENT_ROOT"];
$dir = strtr(dirname(__DIR__), DIRECTORY_SEPARATOR, "/");

define("SRV_ROOT", "$top/");
define("APP_DIR",  "$dir/");

$fbk = $par = $dir;

// ***********************************************************
// find fallback directory
// ***********************************************************
while ($par = dirname($par)) {
	$chk = "$par/cms"; if (! is_dir($chk)) continue;
	$fbk = $chk; break;
}
define("APP_FBK", "$fbk/");

// ***********************************************************
// set include path
// ***********************************************************
set_include_path($dir.PATH_SEPARATOR.$fbk);

?>
