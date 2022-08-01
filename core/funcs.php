<?php

/* this file contains minimum requirements
 * as needed for x.css.php and others
 */

// ***********************************************************
// find files or default to fallback dir
// ***********************************************************
function incCls($file) { doInc("core/classes/$file"); }
function incMod($file) { doInc("core/modules/$file"); }
function incFnc($file) { doInc("core/include/$file"); }

function doInc($file) {
	$fil = APP_DIR."$file"; if (! is_file($fil))
	$fil = APP_FBK."$file"; if (! is_file($fil)) {
		die("File not found: $file");
	}
	require_once $fil;
	LOG::module($fil);
}

// ***********************************************************
// error handling
// ***********************************************************
function shutDown() {
	$inf = error_get_last(); if (! $inf) return;
	extract($inf);

	echo "<hr>Error #$type<hr>";
	echo "in $file on <b>$line</b><br>";
	echo "<pre>$message</pre>";

	if (! IS_LOCAL) return;

	echo "<h1>What can I do?</h1>";
	echo "<li>Enter <a href='?vmode=pedit'>edit mode</a>!</li>";
}

function errHandler($num, $msg, $file, $line) {
	if (class_exists("ERR")) {
		ERR::handler($num, $msg, $file, $line);
		return;
	}

	shutdown();
}

?>
