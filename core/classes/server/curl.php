<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for synchronizing fs via curl

// ***********************************************************
// HOW TO USE
// ***********************************************************
$crl = new curl();
$crl->upload("https://your_domain",$file);

*/

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class curl {
	private $dot = "¬";

function __construct() {}

// ***********************************************************
// acting to transfer requests
// ***********************************************************
public function act() {
	$cnt = 0;

	foreach ($_FILES as $dir => $inf) {
		$dir = $this->restore($dir); if (! $dir) continue;
		extract($inf);
		
		switch ($name) { # commented cases are not tested
			case "curl.mkd": # $cnt+= self::bulk_job($tmp_name, "force"); break;
			case "curl.rmd": # $cnt+= self::bulk_job($tmp_name, "rmDir"); break;
			case "curl.dpf": # $cnt+= self::bulk_job($tmp_name, "kill");  break;
			case "curl.cpf": # $cnt+= self::bulk_job($tmp_name, "copy");  break;

			case "curl.ren": # $cnt+= self::bulk_ren($tmp_name); break;

			default: $cnt+= self::copy($tmp_name, $dir, $name);
		}
	}
	echo "curl: $cnt files";
}

// ***********************************************************
// executing bulk commands
// ***********************************************************
private function bulk_job($lst, $fnc) { // mkdir, rmdir, kill
	$arr = file($lst); FSO::kill($lst); $cnt = 0;

	foreach ($arr as $fso) {
		$cnt+= FSO::$fnc($fso); 
	}
	return $cnt;
}

// ***********************************************************
private function bulk_ren($lst) { // rename dirs and files
	$arr = file($lst); FSO::kill($lst); $cnt = 0;

	foreach ($arr as $lin) {
		$src = STR::before($lin, "=>"); if (! $src) continue;
		$dst = STR::after( $lin, "=>"); if (! $dst) continue;
		$cnt+= FSO::rename($src, $dst);
	}
	return $cnt;
}

// ***********************************************************
// copy uploaded file to destination
// ***********************************************************
private function copy($source, $dir, $target) { // $source = temp_file
	$dst = FSO::join($dir, $target);
	$dst = STR::replace($dst, ".ini", ".test");
	return FSO::copy($source, $dst);
}

// ***********************************************************
// uploading files
// ***********************************************************
public function upload($url, $file) { // copy non text file to destination
	$dir = APP::relPath(dirname($file));
	$dir = $this->secure($dir);
	$ful = realpath($file);

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

	curl_setopt($con, CURLOPT_URL, "$url/x.sync.php");
	curl_setopt($con, CURLOPT_HTTPHEADER, $opt);
	curl_setopt($con, CURLOPT_POSTFIELDS, $inf);

	$erg = curl_exec($con);
	$erg = STR::between($erg, "curl:", "files");
	$erg = intval($erg);

	return ($erg > 0);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function secure($fso) {
	return STR::replace($fso, ".", $this->dot);
}

private function restore($fso) {
	$dot = $this->dot;
	$out = STR::replace($fso, "$dot/", "");
	return STR::replace($out,  $dot,  ".");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

