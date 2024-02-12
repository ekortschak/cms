<?php

$fbk = CMS_DIR; if (is_link($fbk))
$fbk = realpath($fbk);

define("PRJ_DIR", dirname(APP_DIR));
define("TOP_DIR", dirname(PRJ_DIR));
define("APP_FBK", $fbk);

define("APP_NAME", basename(APP_DIR));

if (! is_dir(APP_FBK)) die("APP_FBK not set correctly: ".APP_FBK);
if (! is_dir(APP_DIR)) die("APP_DIR not set correctly: ".APP_DIR);

// ***********************************************************
// adapt include path
// ***********************************************************
$pfd = APP_DIR;

if (APP_DIR !== APP_FBK) $pfd.= PATH_SEPARATOR.APP_FBK;
if (CMS_DIR !== APP_FBK) $pfd.= PATH_SEPARATOR.CMS_DIR;

$pfd.= PATH_SEPARATOR.PRJ_DIR;
$pfd.= PATH_SEPARATOR.TOP_DIR;

set_include_path($pfd);

?>
