<?php

error_reporting(E_ALL);

ini_set("ignore_repeated_errors", 1);

// ***********************************************************
// error handling
// ***********************************************************
function shutDown() {
	$inf = error_get_last(); if (! $inf) return;
	extract($inf);

	echo "<hr>Error #$type<hr>in $file on <b>$line</b><br />";
	echo "<pre>$message</pre>";
}

function errHandler($num, $msg, $file, $line) {
	if (! error_get_last()) return;

	echo "<pre>";
	echo "$line: $file\n";
	echo $msg;
	echo "</pre>";
#	die();
}

// ***********************************************************
// define error options
// ***********************************************************
register_shutdown_function("shutDown"); // defined above
set_error_handler("errHandler");        // defined above

?>
