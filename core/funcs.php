<?php

/* this file contains minimum requirements
 * as needed for x.css.php and others
 */

// ***********************************************************
// find files or default to fallback dir
// ***********************************************************
function incCls($file) { require_once "core/classes/$file"; }
function incMod($file) { require_once "core/modules/$file"; }
function incFnc($file) { require_once "core/include/$file"; }

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

// ***********************************************************
// error handling
// ***********************************************************
function shutDown() {
	$inf = error_get_last(); if (! $inf) return;
	extract($inf);

	echo "<hr>Error #$type<hr>";
	echo "in $file on <b>$line</b><br />";
	HTW::tag($message, "pre");

	if (! IS_LOCAL) return;

	$lnk = HTM::href("?vmode=pedit", "edit mode");
	$rst = HTM::href("?reset=1", "session");

	HTW::tag("What can I do?", "h1");
	HTW::tag("Enter $lnk", "li");
	HTW::tag("Reset $rst", "li");
}

function errHandler($num, $msg, $file, $line) {
	if (class_exists("ERR")) {
		ERR::handler($num, $msg, $file, $line);
		return;
	}
	shutdown();
}

?>
