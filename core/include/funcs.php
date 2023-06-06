<?php

define("LOC_CLS", "core/classes");
define("LOC_MOD", "core/modules");
define("LOC_INC", "core/include");
define("LOC_ICO", "core/icons");
define("LOC_SCR", "core/scripts");

define("LOC_DIC", "design/dictionary");
define("LOC_LAY", "design/layout");
define("LOC_CSS", "design/styles");
define("LOC_CFG", "design/config");
define("LOC_CLR", "design/css.colors");
define("LOC_DIM", "design/css.dims");
define("LOC_TPL", "design/templates");
define("LOC_BTN", "design/buttons");

define("LOC_IMG", "img");

// ***********************************************************
// find files or default to fallback dir
// ***********************************************************
function incCls($file) { incAny(LOC_CLS."/$file"); }
function incMod($file) { incAny(LOC_MOD."/$file"); }
function incFnc($file) { incAny(LOC_INC."/$file"); }

function incAny($file) {
#	if (! is_file($file)) die("File not found: $file");
	require_once $file;
}

// ***********************************************************
// goodies
// ***********************************************************
function checkStop() { // force execution to stop
	$fil = FSO::join(APP_DIR, "x.stop");
	if (is_file($fil)) die("Execution halted!");
}

function requireAdmin() { // force login of admin
	if (! FS_ADMIN) $_GET["dmode"] = "login";
}
function requireLogin() { // force login of any user
	if (CUR_USER == "www") $_GET["dmode"] = "login";
}

?>
