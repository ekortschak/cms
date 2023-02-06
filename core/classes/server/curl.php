<?php
/* ***********************************************************
// INFO
// ***********************************************************
used for synchronizing fs via curl

// ***********************************************************
// HOW TO USE
// ***********************************************************
$crl = new curl("https://your_domain/prj_dir");
$crl->upload($file);

*/

incCls("user/USR.php");

// ***********************************************************
// BEGIN OF CLASS
// ***********************************************************
class curl {
	private $url = NV;
	private $dot = "¬";

function __construct($server = NV) {
	$this->url = "https://$url/x.sync.php";
}

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
	return FSO::copy($source, $dst);
}

// ***********************************************************
// uploading files
// ***********************************************************
public function upload($file) { // copy non text file to destination
	if ($this->url == NV) return;	
	
	$dir = APP::relPath(dirname($file));
	$dir = $this->secure($dir); if (! $dir) return;
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

	curl_setopt($con, CURLOPT_URL, $this->url);
	curl_setopt($con, CURLOPT_HTTPHEADER, $opt);
	curl_setopt($con, CURLOPT_POSTFIELDS, $inf);

	$erg = curl_exec($con);  DBG::text($erg, "erg");
	$erg = STR::between($erg, "curl:", "files");
	$erg = intval($erg);

	return ($erg > 0);
}

// ***********************************************************
// auxilliary methods
// ***********************************************************
private function secure($fso) {
	$pfx = USR::md5("admin", "powerman"); if (! $pfx) return false;
	$fso = STR::replace($fso, ".", $this->dot);
	return SSL::encrypt("$pfx:$fso");
}

private function restore($dat) {
	$dat = SSL::decrypt($dat);
	$pfx = USR::md5("admin", "powerman"); if (! $pfx) return false;
	$chk = STR::before($dat, ":");  if ($chk != $pfx) return false;
	$fso = STR::after($dat,  ":");
	
	$out = STR::replace($fso, "$this->dot/", "");
	return STR::replace($out,  $this->dot,  ".");
}

// ***********************************************************
} // END OF CLASS
// ***********************************************************
?>

