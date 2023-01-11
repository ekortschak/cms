<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for synchronizing fs via curl

// ***********************************************************
// HOW TO USE
// ***********************************************************
$srv = new curl();

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class curl {
	private $url = "http://localhost/cms/x.curl.php";
	private $con;

function __construct() {
	$this->con = curl_init();

	curl_setopt($this->con, CURLOPT_POST, 1);
	curl_setopt($this->con, CURLOPT_HEADER, 0);
	curl_setopt($this->con, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($this->con, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
	curl_setopt($this->con, CURLOPT_FRESH_CONNECT, 1);
	curl_setopt($this->con, CURLOPT_FORBID_REUSE, 1);
	curl_setopt($this->con, CURLOPT_TIMEOUT, 10);
}

// ***********************************************************
public function copy($file) {
	$trg = FSO::join($this->url, $file);
	$fil = realpath($file);

	$fil = new CURLFile($fil);
	$fls = array ("file" => $fil);
	$opt = array("Content-Type: multipart/form-data");

	curl_setopt($this->con, CURLOPT_URL, $trg);
	curl_setopt($this->con, CURLOPT_HTTPHEADER, $opt);
	curl_setopt($this->con, CURLOPT_POSTFIELDS, $fls);

	$erg = curl_exec ($this->con);
	return ($erg === false);
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

