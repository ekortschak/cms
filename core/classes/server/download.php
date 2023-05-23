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

	$dat = file_get_contents($file);

	$this->send($dat, $file);
}

public function csv($file, $text) {
	$this->send($text, $fil, "text/csv");
}

// ***********************************************************
// send any text
// ***********************************************************
public function provide($text) {
	$this->send($text, "by.cms", "text/html");
}

// ***********************************************************
// send file content
// ***********************************************************
private function send($content, $file, $type = NV) {
	$fil = basename($file);

	$txt = $content; if (is_array($txt))
	$txt = implode("\n", $txt);
	$txt = utf8_encode($txt);
	$lng = strlen($txt);

	$typ = $type; if ($typ === NV)
	$typ = mime_content_type($file);

	header("Pragma: no-cache");
	header("Content-Type: $typ; charset=UTF-8");
	header("Content-Description: File Transfer");
	header("Content-Disposition: attachment; filename=$fil");
   	header("Content-Length: $lng");
	header("Content-Transfer-Encoding: binary\n");
	die($txt);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>
