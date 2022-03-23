<?php

error_reporting(E_ALL);

$dir = strtr(dirname(__DIR__), DIRECTORY_SEPARATOR, "/");
$fbk = $top = $dir;

define("APP_DIR", $dir."/");

// ***********************************************************
// find fallback directory
// ***********************************************************
while ($top = dirname($top)) {
	$chk = "$top/cms"; if (! is_dir($chk)) continue;
	$fbk = $chk; break;
}
define("APP_FBK", "$fbk/");
define("SRV_ROOT", "$top/");

// ***********************************************************
// set include path
// ***********************************************************
#$pfd = get_include_path();
#set_include_path($dir.PATH_SEPARATOR.$fbk.PATH_SEPARATOR.$pfd);
set_include_path($dir.PATH_SEPARATOR.$fbk);

?>
