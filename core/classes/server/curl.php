<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for synchronizing fs via curl

// ***********************************************************
// HOW TO USE
// ***********************************************************
$crl = new curl();

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class curl {
	private $url = "http://localhost/kor/".APP_NAME."/x.curl.php";
	private $dot = "¬";

function __construct() {
}

// ***********************************************************
// executing bulk commands
// ***********************************************************
public function bulk_job($fil, $fnc) { // mkdir, rmdir, kill
	$arr = file($fil); FSO::kill($fil); $cnt = 0;

	foreach ($arr as $fso) {
		 $cnt+= FSO::$fnc($fso); 
	}
	return $cnt;
}

public function bulk_ren($fil) { // rename dirs and files
	$arr = file($fil); FSO::kill($fil); $cnt = 0;

	foreach ($arr as $lin) {
		$src = STR::before($lin, "=>"); if (! $src) continue;
		$dst = STR::after($lin, "=>");  if (! $dst) continue;
		$cnt+= FSO::rename($src, $dst);
	}
	return $cnt;
}

public function bulk_cpy($fil) { // copy text files to destination
	$cmd = APP::read($fil); FSO::kill($fil); $cnt = 0;
	$arr = STR::split($cmd, "¬¬¬");

	foreach ($arr as $itm) {
		$fil = STR::before($itm, "\n"); if (! $fil) continue;
		$txt = STR::after($itm, "\n");
		$cnt+= APP::write($fil, $txt);
	}
	return $cnt;
}

// ***********************************************************
// executing file commands
// ***********************************************************
public function copy($source, $dir, $target) { // copy non text file to destination
	$dir = $this->restore($dir);
	$dst = FSO::join($dir, $target);
	return FSO::copy($source, $dst);
}

// ***********************************************************
// uploading files
// ***********************************************************
public function upload($file) {
	$ful = realpath($file);
	$dir = $this->secure(dirname($file));

	$inf = new CURLFile($ful);
	$inf = array ($dir => $inf);
	$opt = array("Content-Type: multipart/form-data");
       
	$con = curl_init();
	curl_setopt($con, CURLOPT_POST, 1);
	curl_setopt($con, CURLOPT_HEADER, 0);
	curl_setopt($con, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($con, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
	curl_setopt($con, CURLOPT_FRESH_CONNECT, 1);
	curl_setopt($con, CURLOPT_FORBID_REUSE, 1);
	curl_setopt($con, CURLOPT_TIMEOUT, 10);

	curl_setopt($con, CURLOPT_URL, $this->url);
	curl_setopt($con, CURLOPT_HTTPHEADER, $opt);
	curl_setopt($con, CURLOPT_POSTFIELDS, $inf);

	$erg = curl_exec($con);
dbg($erg, "erg_upload");
	return ($erg === false);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function secure($fso) {
	return STR::replace($fso, ".", $this->dot);
}

public function restore($fso) {
	$dot = $this->dot;
	$out = STR::replace($fso, "$dot/", "");
	return STR::replace($out,  $dot,  ".");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

