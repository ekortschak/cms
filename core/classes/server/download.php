<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for downloading files

// ***********************************************************
// HOW TO USE
// ***********************************************************
incCls("server/download.php");

$srv = new download();
$srv->get($file);

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class download {

function __construct() {}

// ***********************************************************
public function get($file) {
	if (! is_file($file)) return "No file: $file";

	$fil = basename($file);
	$dat = file_get_contents($file);
	$typ = mime_content_type($file);

	$this->send($dat, $fil, $typ);
}

public function csv($file, $text) {
	$fil = basename($file);
	$this->send($text, $fil, "text/csv");
}

// ***********************************************************
// send file content
// ***********************************************************
private function send($content, $file, $type) {
	header("Pragma: no-cache");
	header("Content-Description: File Transfer");
	header("Content-Disposition: attachment; filename=$file");
	header("Content-Type: $type");
	header("Content-Length: ".strlen($content));
	header("Content-Transfer-Encoding: binary\n");
	die($content);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
