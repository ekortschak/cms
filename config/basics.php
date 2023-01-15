<?php

error_reporting(E_ALL);

$dir = strtr(dirname(__DIR__), DIRECTORY_SEPARATOR, "/");

define("SRV_ROOT", $_SERVER["DOCUMENT_ROOT"]);
define("APP_DIR",  "$dir/");
define("APP_NAME", basename($dir));

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
