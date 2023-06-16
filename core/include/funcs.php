<?php

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
