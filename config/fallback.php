<?php

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
define("CMS_DIR", $fbk);

// ***********************************************************
// adapt include path
// ***********************************************************
set_include_path(APP_DIR.PATH_SEPARATOR.CMS_DIR);

?>
