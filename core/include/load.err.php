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
	$fil = relPath($file); if (! $type) return;
	$msg = relPath($message);

	echo "<hr>Error #$type<hr>in $fil on <b>$line</b><br />";
	echo "<pre>$msg</pre>";
}

function errHandler($num, $msg, $file, $line) {
	if (! error_get_last()) return;

	$fil = relPath($file);
	$msg = relPath($msg);

	echo "<pre>";
	echo "$line: $fil\n";
	echo $msg;
	echo "</pre>";
}

function relPath($fso) {
	$fso = STR::replace($fso, APP_FBK, "FBK");
	$fso = STR::replace($fso, APP_DIR, ".");
	$fso = STR::replace($fso, SRV_ROOT, "");
	return $fso;
}


// ***********************************************************
// define error options
// ***********************************************************
register_shutdown_function("shutDown"); // defined above
set_error_handler("errHandler");        // defined above

?>
