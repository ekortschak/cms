<?php

error_reporting(E_ALL);

$dir = strtr(dirname(__DIR__), DIRECTORY_SEPARATOR, "/");
$fbk = $par = $dir;

// ***********************************************************
// find fallback directory
// ***********************************************************
while ($par = dirname($par)) {
	$chk = "$par/cms"; if (! is_dir($chk)) continue;
	$fbk = $chk; break;
}

define("APP_DIR", $dir);
define("APP_FBK", $fbk);

define("APP_NAME", basename($dir));

// ***********************************************************
// set include path
// ***********************************************************
set_include_path($dir.PATH_SEPARATOR.$fbk);

?>
