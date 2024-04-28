<?php

error_reporting(E_ALL);

ini_set("ignore_repeated_errors", true);
ini_set("display_startup_errors", false);
ini_set("display_errors", false);

// ***********************************************************
// error handling
// ***********************************************************
function shutDown() {
	$inf = error_get_last(); extract($inf); if (! $inf) return;
	$fil = constPath($file); if (! $type) return;
	$msg = constPath($message);

	echo "<hr>Error #$type<hr>in $fil on <b>$line</b><br />";
	echo "<pre>$msg</pre>";
}

function errHandler($num, $msg, $file, $line) {
	if (! error_get_last()) return;

	$fil = constPath($file);
	$msg = constPath($msg);

	echo "<pre>";
	echo "$line: $fil\n";
	echo $msg;
	echo "</pre>";
}

function constPath($fso) {
	$fso = STR::replace($fso, FBK_DIR, "FBK_DIR");
	$fso = STR::replace($fso, APP_DIR, "APP_DIR");
	$fso = STR::replace($fso, PRJ_DIR, "PRJ_DIR");
	$fso = STR::replace($fso, DOM_DIR, "DOM_DIR");
	return $fso;
}


// ***********************************************************
// define error options
// ***********************************************************
register_shutdown_function("shutDown"); // defined above
set_error_handler("errHandler");        // defined above

?>
