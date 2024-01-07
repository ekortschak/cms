<?php

$fbk = CMS_DIR; if (is_link($fbk))
$fbk = realpath($fbk);

define("APP_NAME", basename(APP_DIR));
define("APP_FBK", $fbk);

if (! is_dir(APP_FBK)) die("APP_FBK not set correctly: ".APP_FBK);
if (! is_dir(APP_DIR)) die("APP_DIR not set correctly: ".APP_DIR);

// ***********************************************************
// adapt include path
// ***********************************************************
set_include_path(APP_DIR.PATH_SEPARATOR.APP_FBK.PATH_SEPARATOR.CMS_DIR);

?>
