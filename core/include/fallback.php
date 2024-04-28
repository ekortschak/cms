<?php

$fbk = CMS_DIR; if (is_link($fbk))
$fbk = realpath($fbk);

define("TOP_DIR", $_SERVER["DOCUMENT_ROOT"]);
define("PRJ_DIR", dirname(APP_DIR));
define("DOM_DIR", dirname(PRJ_DIR));
define("FBK_DIR", $fbk);

define("X_TOOLS", DOM_DIR."/xtools");

define("APP_NAME", basename(APP_DIR));

if (! is_dir(FBK_DIR)) die("FBK_DIR not set correctly: ".FBK_DIR);
if (! is_dir(APP_DIR)) die("APP_DIR not set correctly: ".APP_DIR);

// ***********************************************************
// adapt include path
// ***********************************************************
$pfd = APP_DIR;

if (APP_DIR !== FBK_DIR) $pfd.= PATH_SEPARATOR.FBK_DIR;
if (CMS_DIR !== FBK_DIR) $pfd.= PATH_SEPARATOR.CMS_DIR;

$pfd.= PATH_SEPARATOR.PRJ_DIR;
$pfd.= PATH_SEPARATOR.DOM_DIR;

set_include_path($pfd);

?>
