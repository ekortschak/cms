<?php

errMode(true);

// ***********************************************************
// error handling
// ***********************************************************
function shutDown() {
	$inf = error_get_last();  if (! $inf) return; extract($inf); 
	$fil = checkConst($file); if (! $type) return;
	$msg = checkConst($message);
	$msg = checkErr($msg);

	echo "<hr>Error #$type<hr>in $fil on <b>$line</b><br />";
	echo "<pre>$msg</pre>";
}

function errHandler($num, $msg, $file, $line) {
	if (! error_get_last()) return;

	$fil = checkConst($file);
	$msg = checkConst($msg);
	$msg = checkErr($msg);

	echo "<pre>$line: $fil\n$msg</pre>";
}

function checkConst($fso) {
	$fso = str_replace(FBK_DIR, "FBK_DIR", $fso);
	$fso = str_replace(APP_DIR, "APP_DIR", $fso);
	$fso = str_replace(PRJ_DIR, "PRJ_DIR", $fso);
	$fso = str_replace(DOM_DIR, "DOM_DIR", $fso);
	return $fso;
}

function checkErr($msg) {
	if (strpos($msg, "Access denied")) return "Database not accessible";
	return $msg;
}

// ***********************************************************
// define error options
// ***********************************************************
register_shutdown_function("shutDown"); // defined above
set_error_handler("errHandler");        // defined above

?>
